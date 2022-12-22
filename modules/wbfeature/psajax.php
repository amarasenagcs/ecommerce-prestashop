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

require_once(dirname(__FILE__).'/../../config/config.inc.php');
require_once(dirname(__FILE__).'/../../init.php');

include_once(dirname(__FILE__).'/wbfeature.php');
include_once(dirname(__FILE__).'/classes/WbfeatureProduct.php');

$module = new Wbfeature();

//DONGND:: render modal popup and dropdown cart
if (Tools::getValue('action') == 'render-modal') {
    $context = Context::getContext();
    $modal = '';
    $notification = '';
    $dropdown = '';
    if (Tools::getValue('only_dropdown') == 0) {
        $modal = $module->renderModal();
        $notification = $module->renderNotification();
    }
    if (Configuration::get('WBFEATURE_ENABLE_DROPDOWN_DEFAULTCART') ||
        Configuration::get('WBFEATURE_ENABLE_DROPDOWN_FLYCART')) {
        $only_total = Tools::getValue('only_total');
        $dropdown = $module->renderDropDown($only_total);
    }
    ob_end_clean();
    header('Content-Type: application/json');
    die(Tools::jsonEncode(
        array(
            'dropdown' => $dropdown,
            'modal'   => $modal,
            'notification' => $notification,
        )
    ));
};

if (Tools::getValue('action') == 'get-attribute-data') {
    $result = array();
    $context = Context::getContext();
    $id_product = Tools::getValue('id_product');
    $id_product_attribute = Tools::getValue('id_product_attribute');
    
    $attribute_data = new WbfeatureProduct();
    $result = $attribute_data->getTemplateVarProduct2(
        $id_product,
        $id_product_attribute
    );
    die(Tools::jsonEncode(array(
        'product_cover' => $result['cover'],
        'price_attribute'   => $module->renderPriceAttribute($result),
        'product_url' => $context->link->getProductLink(
            $id_product,
            null,
            null,
            null,
            $context->language->id,
            null,
            $id_product_attribute,
            false,
            false,
            true
        ),
    )));
};

if (Tools::getValue('action') == 'get-new-review') {
    // $result = array();
    if (Configuration::get('WBFEATURE_PRODUCT_REVIEWS_MODERATE')) {
        $reviews = ProductReview::getByValidate(0, false);
    } else {
        $reviews = array();
    }
    die(Tools::jsonEncode(array(
        'number_review' => count($reviews)
    )));
}

if (Tools::getValue('action') == 'check-product-outstock') {
    $id_product = Tools::getValue('id_product');
    $id_product_attribute = Tools::getValue('id_product_attribute');
    $id_customization = Tools::getValue('id_customization');
    $check_product_in_cart = Tools::getValue('check_product_in_cart');
    $quantity = Tools::getValue('quantity');
    $context = Context::getContext();
    $qty_to_check = $quantity;
    // print_r('test111');
    if ($check_product_in_cart == 'true') {
        // print_r('test');die();
        $cart_products = $context->cart->getProducts();

        if (is_array($cart_products)) {
            foreach ($cart_products as $cart_product) {
                if ((
                    !isset($id_product_attribute) ||
                    (
                        $cart_product['id_product_attribute'] == $id_product_attribute &&
                        $cart_product['id_customization'] == $id_customization
                    )
                ) && isset($id_product) && $cart_product['id_product'] == $id_product) {
                    $qty_to_check = $cart_product['cart_quantity'];
                    $qty_to_check += $quantity;
                    break;
                }
            }
        }
    }
    // die();
    
    $product = new Product($id_product, true, $context->language->id);
    $return = true;
    // Check product quantity availability
    if ($id_product_attribute) {
        if (!Product::isAvailableWhenOutOfStock($product->out_of_stock) &&
            !Attribute::checkAttributeQty($id_product_attribute, $qty_to_check)) {
            $return = false;
        }
    } elseif (!$product->checkQty($qty_to_check)) {
        $return = false;
    }
    
    die(Tools::jsonEncode(array(
        'success' => $return,
    )));
}
