<?php
/**
* 2007-2018 PrestaShop
*
* NOTICE OF LICENSE
*
* This source file is subject to the Academic Free License (AFL 3.0)
* that is bundled with this package in the file LICENSE.txt.
* It is also available through the world-wide-web at this URL:
* http://opensource.org/licenses/afl-3.0.php
* If you did not receive a copy of the license and are unable to
* obtain it through the world-wide-web, please send an email
* to license@prestashop.com so we can send you a copy immediately.
*
* DISCLAIMER
*
* Do not edit or add to this file if you wish to upgrade PrestaShop to newer
* versions in the future. If you wish to customize PrestaShop for your
* needs please refer to http://www.prestashop.com for more information.
*
*  @author PrestaShop SA <contact@prestashop.com>
*  @copyright  2007-2018 PrestaShop SA
*  @license    http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
*  International Registered Trademark & Property of PrestaShop SA
*/

if (!defined('_PS_VERSION_')) {
    exit;
}

class WishList extends ObjectModel
{
    /** @var integer Wishlist ID */
    public $id;

    /** @var integer Customer ID */
    public $id_customer;

    /** @var integer Token */
    public $token;

    /** @var integer Name */
    public $name;

    /** @var string Object creation date */
    public $date_add;

    /** @var string Object last modification date */
    public $date_upd;

    /** @var string Object last modification date */
    public $id_shop;

    /** @var string Object last modification date */
    public $id_shop_group;

    /** @var integer default */
    public $default;

    /**
     * @see ObjectModel::$definition
     */
    public static $definition = array(
        'table' => 'wbfeature_wishlist',
        'primary' => 'id_wishlist',
        'fields' => array(
            'id_customer' =>    array('type' => self::TYPE_INT, 'validate' => 'isUnsignedId', 'required' => true),
            'token' =>          array('type' => self::TYPE_STRING, 'validate' => 'isMessage', 'required' => true),
            'name' =>           array('type' => self::TYPE_STRING, 'validate' => 'isMessage', 'required' => true),
            'date_add' =>       array('type' => self::TYPE_DATE, 'validate' => 'isDate'),
            'date_upd' =>       array('type' => self::TYPE_DATE, 'validate' => 'isDate'),
            'id_shop' =>        array('type' => self::TYPE_INT, 'validate' => 'isUnsignedId'),
            'id_shop_group' =>  array('type' => self::TYPE_INT, 'validate' => 'isUnsignedId'),
            'default' => array('type' => self::TYPE_BOOL, 'validate' => 'isUnsignedId'),
        )
    );

    public function delete()
    {
        Db::getInstance()->execute(
            'DELETE FROM `'._DB_PREFIX_.'wbfeature_wishlist_product` WHERE `id_wishlist` = '.(int)($this->id)
        );
        if ($this->default) {
            $result = Db::getInstance()->executeS(
                'SELECT * FROM `'._DB_PREFIX_.'wbfeature_wishlist` WHERE `id_customer` = '.(int)$this->id_customer.' AND
                `id_wishlist` != '.(int)$this->id.' LIMIT 1'
            );
            foreach ($result as $res) {
                Db::getInstance()->update('wishlist', array('default' => '1'), 'id_wishlist = '.(int)$res['id_wishlist']);
            }
        }
        if (isset($this->context->cookie->id_wishlist)) {
            unset($this->context->cookie->id_wishlist);
        }

        return (parent::delete());
    }

    /**
     * Increment counter
     *
     * @return boolean succeed
     */
    public static function incCounter($id_wishlist)
    {
        if (!Validate::isUnsignedId($id_wishlist)) {
            die(Tools::displayError());
        }
        $result = Db::getInstance()->getRow(
            'SELECT `counter` FROM `'._DB_PREFIX_.'wbfeature_wishlist` WHERE `id_wishlist` = '.(int)$id_wishlist
        );
        if ($result == false || !count($result) || empty($result) === true) {
            return (false);
        }

        return Db::getInstance()->execute(
            'UPDATE `'._DB_PREFIX_.'wbfeature_wishlist` SET `counter` = '.(int)($result['counter'] + 1).' WHERE
            `id_wishlist` = '.(int)$id_wishlist
        );
    }

    public static function isExistsByNameForUser($name)
    {
        if (Shop::getContextShopID()) {
            $shop_restriction = 'AND id_shop = '.(int)Shop::getContextShopID();
        } elseif (Shop::getContextShopGroupID()) {
            $shop_restriction = 'AND id_shop_group = '.(int)Shop::getContextShopGroupID();
        } else {
            $shop_restriction = '';
        }

        $context = Context::getContext();
        return Db::getInstance()->getValue(
            'SELECT COUNT(*) AS total FROM `'._DB_PREFIX_.'wbfeature_wishlist` WHERE `name` = \''.pSQL($name).'\' AND
            `id_customer` = '.(int)$context->customer->id.' '.$shop_restriction
        );
    }

    /**
     * Return true if wishlist exists else false
     *
     *  @return boolean exists
     */
    public static function exists($id_wishlist, $id_customer, $return = false)
    {
        if (!Validate::isUnsignedId($id_wishlist) or
            !Validate::isUnsignedId($id_customer)) {
            die(Tools::displayError());
        }
        $result = Db::getInstance()->getRow(
            'SELECT `id_wishlist`, `name`, `token` FROM `'._DB_PREFIX_.'wbfeature_wishlist` WHERE `id_wishlist` = '.(int)($id_wishlist).' AND
            `id_customer` = '.(int)($id_customer).' AND `id_shop` = '.(int)Context::getContext()->shop->id
        );
        if (empty($result) === false and $result != false and sizeof($result)) {
            if ($return === false) {
                return (true);
            } else {
                return ($result);
            }
        }
        return (false);
    }

    /**
    * Get Customers having a wishlist
        *
        * @return array Results
        */
    public static function getCustomers()
    {
        $cache_id = 'WhishList::getCustomers';
        if (!Cache::isStored($cache_id)) {
            $result = Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS(
                'SELECT c.`id_customer`, c.`firstname`, c.`lastname` FROM `'._DB_PREFIX_.'wbfeature_wishlist` w INNER JOIN
                `'._DB_PREFIX_.'customer` c ON c.`id_customer` = w.`id_customer`
                ORDER BY c.`firstname` ASC'
            );
            Cache::store($cache_id, $result);
        }
        return Cache::retrieve($cache_id);
    }

    /**
     * Get ID wishlist by Token
     *
     * @return array Results
     */
    public static function getByToken($token)
    {
        if (!Validate::isMessage($token)) {
            die(Tools::displayError());
        }
        return (Db::getInstance(_PS_USE_SQL_SLAVE_)->getRow(
            'SELECT w.`id_wishlist`, w.`name`, w.`id_customer`, c.`firstname`, c.`lastname` FROM `'._DB_PREFIX_.'wbfeature_wishlist` w INNER JOIN
            `'._DB_PREFIX_.'customer` c ON c.`id_customer` = w.`id_customer` WHERE `token` = \''.pSQL($token).'\''
        ));
    }

    /**
     * Get Wishlists by Customer ID
     *
     * @return array Results
     */
    public static function getByIdCustomer($id_customer)
    {
        if (!Validate::isUnsignedId($id_customer)) {
            die(Tools::displayError());
        }
        if (Shop::getContextShopID()) {
            $shop_restriction = 'AND id_shop = '.(int)Shop::getContextShopID();
        } elseif (Shop::getContextShopGroupID()) {
            $shop_restriction = 'AND id_shop_group = '.(int)Shop::getContextShopGroupID();
        } else {
            $shop_restriction = '';
        }

        $cache_id = 'WhishList::getByIdCustomer_'.(int)$id_customer.'-'.(int)Shop::getContextShopID().'-'.(int)Shop::getContextShopGroupID();
        if (!Cache::isStored($cache_id)) {
            $result = Db::getInstance()->executeS(
                'SELECT w.`id_wishlist`, w.`name`, w.`token`, w.`date_add`, w.`date_upd`, w.`counter`, w.`default`
                FROM `'._DB_PREFIX_.'wbfeature_wishlist` w
                WHERE `id_customer` = '.(int)($id_customer).' '.$shop_restriction.'
                ORDER BY w.`name` ASC'
            );
            Cache::store($cache_id, $result);
        }
        return Cache::retrieve($cache_id);
    }
    /**
     * Get Wishlist products by Customer ID
     *
     * @return array Results
     */
    public static function getProductByIdCustomer($id_wishlist, $id_customer, $id_lang, $id_product = null, $quantity = false)
    {
        if (!Validate::isUnsignedId($id_customer) or
            !Validate::isUnsignedId($id_lang) or
            !Validate::isUnsignedId($id_wishlist)) {
            die(Tools::displayError());
        }
        $products = Db::getInstance()->executeS(
            'SELECT wp.`id_product`, wp.`quantity`, p.`quantity` AS product_quantity, pl.`name`, wp.`id_product_attribute`, wp.`priority`, pl.link_rewrite, cl.link_rewrite AS category_rewrite
            FROM `'._DB_PREFIX_.'wbfeature_wishlist_product` wp
            LEFT JOIN `'._DB_PREFIX_.'product` p ON p.`id_product` = wp.`id_product`
            '.Shop::addSqlAssociation('product', 'p').'
            LEFT JOIN `'._DB_PREFIX_.'product_lang` pl
            ON pl.`id_product` = wp.`id_product`'.Shop::addSqlRestrictionOnLang('pl').'
            LEFT JOIN `'._DB_PREFIX_.'wbfeature_wishlist` w
            ON w.`id_wishlist` = wp.`id_wishlist`
            LEFT JOIN `'._DB_PREFIX_.'category_lang` cl
            ON cl.`id_category` = product_shop.`id_category_default`
            AND cl.id_lang='.(int)$id_lang.Shop::addSqlRestrictionOnLang('cl').'
            WHERE w.`id_customer` = '.(int)($id_customer).'
            AND pl.`id_lang` = '.(int)($id_lang).'
            AND wp.`id_wishlist` = '.(int)($id_wishlist).
            (empty($id_product) === false ? ' AND wp.`id_product` = '.(int)($id_product) : '').
            ($quantity == true ? ' AND wp.`quantity` != 0': '').'
            GROUP BY p.id_product, wp.id_product_attribute'
        );
        if (empty($products) === true or !sizeof($products)) {
            return array();
        }
        for ($i = 0; $i < sizeof($products); ++$i) {
            if (isset($products[$i]['id_product_attribute']) and
                Validate::isUnsignedInt($products[$i]['id_product_attribute'])) {
                $result = Db::getInstance()->executeS(
                    'SELECT al.`name` AS attribute_name, pa.`quantity` AS "attribute_quantity"
                    FROM `'._DB_PREFIX_.'product_attribute_combination` pac
                    LEFT JOIN `'._DB_PREFIX_.'attribute` a
                    ON (a.`id_attribute` = pac.`id_attribute`)
                    LEFT JOIN `'._DB_PREFIX_.'attribute_group` ag
                    ON (ag.`id_attribute_group` = a.`id_attribute_group`)
                    LEFT JOIN `'._DB_PREFIX_.'attribute_lang` al
                    ON (a.`id_attribute` = al.`id_attribute` AND al.`id_lang` = '.(int)($id_lang).')
                    LEFT JOIN `'._DB_PREFIX_.'attribute_group_lang` agl
                    ON (ag.`id_attribute_group` = agl.`id_attribute_group` AND agl.`id_lang` = '.(int)($id_lang).')
                    LEFT JOIN `'._DB_PREFIX_.'product_attribute` pa
                    ON (pac.`id_product_attribute` = pa.`id_product_attribute`)
                    '.Shop::addSqlAssociation('product_attribute', 'pa').'
                    WHERE pac.`id_product_attribute` = '.(int)($products[$i]['id_product_attribute'])
                );
                $products[$i]['attributes_small'] = '';
                if ($result) {
                    foreach ($result as $row) {
                        $products[$i]['attributes_small'] .= $row['attribute_name'].', ';
                    }
                }
                $products[$i]['attributes_small'] = rtrim($products[$i]['attributes_small'], ', ');
                if (isset($result[0])) {
                    $products[$i]['attribute_quantity'] = $result[0]['attribute_quantity'];
                }
            } else {
                $products[$i]['attribute_quantity'] = $products[$i]['product_quantity'];
            }
        }
        return ($products);
    }
    
    //DONGND:: get simple list product by wishlist
    public static function getSimpleProductByIdCustomer($id_customer, $id_shop)
    {
        if (!Validate::isUnsignedId($id_customer) or
            !Validate::isUnsignedId($id_shop)) {
            die(Tools::displayError());
        }
        $wishlists = Db::getInstance()->executeS(
            'SELECT w.`id_wishlist`
            FROM `'._DB_PREFIX_.'wbfeature_wishlist` w     
            WHERE w.`id_customer` = '.(int)($id_customer).'
            AND w.`id_shop` = '.(int) $id_shop.' '
        );

        if (empty($wishlists) === true or !sizeof($wishlists)) {
            return array();
        }
        
        $wishlist_product = array();
        foreach ($wishlists as $wishlists_val) {
            $product = Db::getInstance()->executeS(
                'SELECT wp.`id_product`, wp.`id_product_attribute`
                FROM `'._DB_PREFIX_.'wbfeature_wishlist_product` wp    
                WHERE wp.`id_wishlist` = '.(int)$wishlists_val['id_wishlist'].' '
            );
            $wishlist_product[$wishlists_val['id_wishlist']] = $product;
        }

        return ($wishlist_product);
    }

    /**
     * Get Wishlists number products by Customer ID
     *
     * @return array Results
     */
    public static function getInfosByIdCustomer($id_customer, $id_wishlist)
    {
        if (Shop::getContextShopID()) {
            $shop_restriction = 'AND id_shop = '.(int)Shop::getContextShopID();
        } elseif (Shop::getContextShopGroupID()) {
            $shop_restriction = 'AND id_shop_group = '.(int)Shop::getContextShopGroupID();
        } else {
            $shop_restriction = '';
        }

        if (!Validate::isUnsignedId($id_customer)) {
            die(Tools::displayError());
        }
        return (Db::getInstance(_PS_USE_SQL_SLAVE_)->getRow(
            'SELECT SUM(wp.`quantity`) AS nbProducts, wp.`id_wishlist` FROM `'._DB_PREFIX_.'wbfeature_wishlist_product` wp
            INNER JOIN `'._DB_PREFIX_.'wbfeature_wishlist` w
            ON (w.`id_wishlist` = wp.`id_wishlist`)
            WHERE w.`id_customer` = '.(int)($id_customer).'
            AND wp.`id_wishlist` = '.(int)($id_wishlist).'
            '.$shop_restriction.'
            GROUP BY w.`id_wishlist`
            ORDER BY w.`name` ASC'
        ));
    }

    /**
     * Add product to ID wishlist
     *
     * @return boolean succeed
     */
    public static function addProduct($id_wishlist, $id_customer, $id_product, $id_product_attribute, $quantity)
    {
        if (!Validate::isUnsignedId($id_wishlist) or
            !Validate::isUnsignedId($id_customer) or
            !Validate::isUnsignedId($id_product) or
            !Validate::isUnsignedId($quantity)) {
            die(Tools::displayError());
        }
        $result = Db::getInstance()->getRow(
            'SELECT wp.`quantity`
            FROM `'._DB_PREFIX_.'wbfeature_wishlist_product` wp
            JOIN `'._DB_PREFIX_.'wbfeature_wishlist` w
            ON (w.`id_wishlist` = wp.`id_wishlist`)
            WHERE wp.`id_wishlist` = '.(int)($id_wishlist).'
            AND w.`id_customer` = '.(int)($id_customer).'
            AND wp.`id_product` = '.(int)($id_product).'
            AND wp.`id_product_attribute` = '.(int)($id_product_attribute)
        );
        if (empty($result) === false and sizeof($result)) {
            if (($result['quantity'] + $quantity) <= 0) {
                return (
                    WishList::removeProduct(
                        $id_wishlist,
                        $id_customer,
                        $id_product,
                        $id_product_attribute
                    )
                );
            } else {
                return (Db::getInstance()->execute(
                    'UPDATE `'._DB_PREFIX_.'wbfeature_wishlist_product` SET
                    `quantity` = '.(int)($quantity + $result['quantity']).'
                    WHERE `id_wishlist` = '.(int)($id_wishlist).'
                    AND `id_product` = '.(int)($id_product).'
                    AND `id_product_attribute` = '.(int)($id_product_attribute)
                ));
            }
        } else {
            return (Db::getInstance()->execute(
                'INSERT INTO `'._DB_PREFIX_.'wbfeature_wishlist_product` (`id_wishlist`, `id_product`, `id_product_attribute`, `quantity`, `priority`) VALUES(
                '.(int)($id_wishlist).',
                '.(int)($id_product).',
                '.(int)($id_product_attribute).',
                '.(int)($quantity).', 1)'
            ));
        }
    }

    /**
     * Update product to wishlist
     *
     * @return boolean succeed
     */
    public static function updateProduct($id_wishlist, $id_product, $id_product_attribute, $priority, $quantity)
    {
        if (!Validate::isUnsignedId($id_wishlist) or
            !Validate::isUnsignedId($id_product) or
            !Validate::isUnsignedId($quantity) or
            $priority < 0 or $priority > 2) {
            die(Tools::displayError());
        }
        return (Db::getInstance()->execute(
            'UPDATE `'._DB_PREFIX_.'wbfeature_wishlist_product` SET
            `priority` = '.(int)($priority).',
            `quantity` = '.(int)($quantity).'
            WHERE `id_wishlist` = '.(int)($id_wishlist).'
            AND `id_product` = '.(int)($id_product).'
            AND `id_product_attribute` = '.(int)($id_product_attribute)
        ));
    }

    /**
     * Remove product from wishlist
     *
     * @return boolean succeed
     */
    public static function removeProduct($id_wishlist, $id_customer, $id_product, $id_product_attribute)
    {
        if (!Validate::isUnsignedId($id_wishlist) or
            !Validate::isUnsignedId($id_customer) or
            !Validate::isUnsignedId($id_product)) {
            die(Tools::displayError());
        }
        $result = Db::getInstance()->getRow(
            'SELECT w.`id_wishlist`, wp.`id_wishlist_product`
            FROM `'._DB_PREFIX_.'wbfeature_wishlist` w
            LEFT JOIN `'._DB_PREFIX_.'wbfeature_wishlist_product` wp
            ON (wp.`id_wishlist` = w.`id_wishlist`)
            WHERE `id_customer` = '.(int)($id_customer).'
            AND w.`id_wishlist` = '.(int)($id_wishlist)
        );
        if (empty($result) === true or
            $result === false or
            !sizeof($result) or
            $result['id_wishlist'] != $id_wishlist) {
            return (false);
        }
        // Delete product in wishlist_product_cart
        // Db::getInstance()->execute('
        // DELETE FROM `'._DB_PREFIX_.'wishlist_product_cart`
        // WHERE `id_wishlist_product` = '.(int)($result['id_wishlist_product'])
        // );
        return Db::getInstance()->execute(
            'DELETE FROM `'._DB_PREFIX_.'wbfeature_wishlist_product` WHERE
            `id_wishlist` = '.(int)($id_wishlist).' AND `id_product` = '.(int)($id_product).' AND
            `id_product_attribute` = '.(int)($id_product_attribute)
        );
    }

    
    /**
    * Return if there is a default already set
    *
    * @return boolean
    */
    public static function isDefault($id_customer)
    {
        return (Bool)Db::getInstance()->getValue(
            'SELECT * FROM `'._DB_PREFIX_.'wbfeature_wishlist` WHERE `id_customer` = '.(int)$id_customer.' AND `default` = 1'
        );
    }

    public static function getDefault($id_customer)
    {
        return Db::getInstance()->executeS(
            'SELECT * FROM `'._DB_PREFIX_.'wbfeature_wishlist` WHERE `id_customer` = '.(int)$id_customer.' AND `default` = 1'
        );
    }

    /**
    * Set current WishList as default
    *
    * @return boolean
    */
    public function setDefault()
    {
        if ($default = $this->getDefault($this->id_customer)) {
            Db::getInstance()->update(
                'wbfeature_wishlist',
                array('default' => '0'),
                'id_wishlist = '.(int)$default[0]['id_wishlist']
            );
        }

        return Db::getInstance()->update(
            'wbfeature_wishlist',
            array('default' => '1'),
            'id_wishlist = '.(int)$this->id
        );
    }
    
    //DONGND:: delete product of wishlist
    public static function removeProductWishlist($id_wishlist, $id_wishlist_product)
    {
        if (!Validate::isUnsignedId($id_wishlist_product) ||
            !Validate::isUnsignedId($id_wishlist)) {
            die(Tools::displayError());
        }
        
        return Db::getInstance()->execute(
            'DELETE FROM `'._DB_PREFIX_.'wbfeature_wishlist_product` WHERE
            `id_wishlist_product` = '.(int)($id_wishlist_product).' AND `id_wishlist` = '.(int)($id_wishlist)
        );
    }
    
    //DONGND:: delete product of wishlist
    public static function updateProductWishlist($id_wishlist, $id_wishlist_product, $priority, $quantity)
    {
        if (!Validate::isUnsignedId($id_wishlist_product) ||
            !Validate::isUnsignedId($id_wishlist) ||
            !Validate::isUnsignedInt($quantity) ||
            !Validate::isUnsignedInt($priority) ||
            $priority < 0 ||
            $priority > 2) {
            die(Tools::displayError());
        }
            
        return Db::getInstance()->execute(
            'UPDATE `'._DB_PREFIX_.'wbfeature_wishlist_product` SET `priority` = '.(int)($priority).', `quantity` = '.(int)($quantity).' WHERE `id_wishlist` = '.(int)($id_wishlist).' AND `id_wishlist_product` = '.(int)($id_wishlist_product)
        );
    }
    
    //DONGND::
    public static function getSimpleProductByIdWishlist($id_wishlist)
    {
        if (!Validate::isUnsignedId($id_wishlist)) {
            die(Tools::displayError());
        }
        
        return Db::getInstance()->executeS(
            'SELECT wp.* FROM `'._DB_PREFIX_.'wbfeature_wishlist_product` wp WHERE wp.`id_wishlist` = '.(int)$id_wishlist.' '
        );
    }
}