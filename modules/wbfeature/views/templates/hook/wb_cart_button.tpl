{**
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
*  @author    Codespot SA <support@presthemes.com>
*  @copyright 2017-2018 PrestaShop SA
*  @license   http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
*  International Registered Trademark & Property of PrestaShop SA
*}

<div class="button-container cart add-cart">
	<form action="{$link_cart}" method="post">
		<input type="hidden" name="token" value="{$static_token}">
		<input type="hidden" value="{$wb_cart_product.quantity}" class="quantity_product quantity_product_{$wb_cart_product.id_product}" name="quantity_product">
		<input type="hidden" value="{if isset($wb_cart_product.product_attribute_minimal_quantity) && $wb_cart_product.product_attribute_minimal_quantity>$wb_cart_product.minimal_quantity}{$wb_cart_product.product_attribute_minimal_quantity}{else}{$wb_cart_product.minimal_quantity}{/if}" class="minimal_quantity minimal_quantity_{$wb_cart_product.id_product}" name="minimal_quantity">
		<input type="hidden" value="{$wb_cart_product.id_product_attribute}" class="id_product_attribute id_product_attribute_{$wb_cart_product.id_product}" name="id_product_attribute">
		<input type="hidden" value="{$wb_cart_product.id_product}" class="id_product" name="id_product">
		<input type="hidden" name="id_customization" value="{if $wb_cart_product.id_customization}{$wb_cart_product.id_customization}{/if}" class="product_customization_id">
			
		<input type="hidden" class="input-group form-control qty qty_product qty_product_{$wb_cart_product.id_product}" name="qty" value="{if isset($wb_cart_product.wishlist_quantity)}{$wb_cart_product.wishlist_quantity}{else}{if $wb_cart_product.product_attribute_minimal_quantity && $wb_cart_product.product_attribute_minimal_quantity>$wb_cart_product.minimal_quantity}{$wb_cart_product.product_attribute_minimal_quantity}{else}{$wb_cart_product.minimal_quantity}{/if}{/if}" data-min="{if $wb_cart_product.product_attribute_minimal_quantity && $wb_cart_product.product_attribute_minimal_quantity>$wb_cart_product.minimal_quantity}{$wb_cart_product.product_attribute_minimal_quantity}{else}{$wb_cart_product.minimal_quantity}{/if}">
		  <button class="cartb  btn-product add-to-cart wb-bt-cart wb-bt-cart_{$wb_cart_product.id_product}{if !$wb_cart_product.add_to_cart_url} disabled{/if}" data-button-action="add-to-cart" type="submit">
			{* <span class="wb-loading cssload-speeding-wheel"></span> *}
			{* <span class="wb-bt-cart-content">
				<i class="material-icons shopping-cart">&#xE547;</i>
				<span>{l s='Add to cart' mod='wbfeature'}</span>
			</span> *}
			 <svg width="18px" height="18px"><use xlink:href="#bcart" /></svg><span class="pcart">{l s='add to cart' mod='wbfeature'}</span>
		  </button>
	</form>
</div>

