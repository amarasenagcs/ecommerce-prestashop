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

require_once(_PS_MODULE_DIR_.'wbfeature/classes/WishList.php');
require_once(_PS_MODULE_DIR_.'wbfeature/classes/WbfeatureProduct.php');

class WbFeatureViewWishlistModuleFrontController extends ModuleFrontController
{
    public $php_self;
    
    public function __construct()
    {
        parent::__construct();
        $this->context = Context::getContext();
    }

    public function initContent()
    {
        $this->php_self = 'viewwishlist';
        
        parent::initContent();
        // print_r('testaa');die();
        if (!Configuration::get('WBFEATURE_ENABLE_PRODUCTWISHLIST')) {
            return Tools::redirect('index.php?controller=404');
        }
        $token = Tools::getValue('token');

        if ($token) {
            $wishlist = WishList::getByToken($token);
            
            $wishlists = WishList::getByIdCustomer((int)$wishlist['id_customer']);
            // print_r();die();
            if (count($wishlists) > 1) {
                foreach ($wishlists as $key => $wishlists_item) {
                    if ($wishlists_item['id_wishlist'] == $wishlist['id_wishlist']) {
                        unset($wishlists[$key]);
                    }
                }
            } else {
                $wishlists = array();
            }
            
            $products = array();
            $wishlist_product = WishList::getSimpleProductByIdWishlist((int)$wishlist['id_wishlist']);
            $product_object = new WbfeatureProduct();
            if (count($wishlist_product) > 0) {
                foreach ($wishlist_product as $wishlist_product_item) {
                    $list_product_tmp = array();
                    $list_product_tmp['wishlist_info'] = $wishlist_product_item;
                    $list_product_tmp['product_info'] = $product_object->getTemplateVarProduct2(
                        $wishlist_product_item['id_product'],
                        $wishlist_product_item['id_product_attribute']
                    );
                    $list_product_tmp['product_info']['wishlist_quantity'] = $wishlist_product_item['quantity'];
                    $products[] = $list_product_tmp;
                }
            }
            // echo '<pre>';
            // print_r($products);die();
            WishList::incCounter((int)$wishlist['id_wishlist']);

            $this->context->smarty->assign(
                array(
                    'current_wishlist' => $wishlist,
                    'wishlists' => $wishlists,
                    'products' => $products,
                    'view_wishlist_url' => $this->context->link->getModuleLink('wbfeature', 'viewwishlist'),
                    'show_button_cart' => Configuration::get('WBFEATURE_ENABLE_AJAXCART'),
                    'wb_is_rewrite_active' => (bool)Configuration::get('PS_REWRITING_SETTINGS'),
                )
            );
        }
        $this->setTemplate('module:wbfeature/views/templates/front/wb_wishlist_view.tpl');
    }
    
    //DONGND:: add meta title, meta description, meta keywords
    public function getTemplateVarPage()
    {
        $page = parent::getTemplateVarPage();
        $page['meta']['title'] = Configuration::get('PS_SHOP_NAME').' - '.$this->l('View Wishlist', 'viewwishlist');
        $page['meta']['keywords'] = $this->l('view-wishlist', 'viewwishlist');
        $page['meta']['description'] = $this->l('view Wishlist', 'viewwishlist');
        // echo '<pre>';
        // print_r($page);die();
        return $page;
    }
    
    //DONGND:: add breadcrumb
    public function getBreadcrumbLinks()
    {
        $breadcrumb = parent::getBreadcrumbLinks();
        // $link = WbBlogHelper::getInstance()->getFontBlogLink();
        // $config = WbBlogConfig::getInstance();
        $breadcrumb['links'][] = array(
            'title' => $this->l('My Account', 'viewwishlist'),
            'url' => $this->context->link->getPageLink('my-account', true),
        );
        
        $breadcrumb['links'][] = array(
            'title' => $this->l('My Wishlist', 'viewwishlist'),
            'url' => $this->context->link->getModuleLink('wbfeature', 'mywishlist'),
        );

        return $breadcrumb;
    }
    //DONGND:: get layout
    public function getLayout()
    {
        $entity = 'module-wbfeature-'.$this->php_self;
        
        $layout = $this->context->shop->theme->getLayoutRelativePathForPage($entity);
        
        if ($overridden_layout = Hook::exec(
            'overrideLayoutTemplate',
            array(
                'default_layout' => $layout,
                'entity' => $entity,
                'locale' => $this->context->language->locale,
                'controller' => $this,
            )
        )) {
            return $overridden_layout;
        }

        if ((int) Tools::getValue('content_only')) {
            $layout = 'layouts/layout-content-only.tpl';
        }

        return $layout;
    }
}
