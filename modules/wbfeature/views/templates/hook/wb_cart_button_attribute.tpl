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

{if isset($wb_cart_product_attribute.combinations) && count($wb_cart_product_attribute.combinations) > 0}		
	<div class="dropdown wb-pro-attr-section">
	  <button class="btn btn-secondary dropdown-toggle wb-bt-select-attr dropdownListAttrButton_{$wb_cart_product_attribute.id_product}" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
		{$wb_cart_product_attribute.attribute_designation}
	  </button>
	  <div class="dropdown-menu wb-dropdown-attr">
		{foreach from=$wb_cart_product_attribute.combinations item=attribute}
			<a class="dropdown-item wb-select-attr{if $attribute.id_product_attribute == $wb_cart_product_attribute.id_product_attribute} selected{/if}{if $attribute.add_to_cart_url == ''} disable{/if}" href="#" data-id-product="{$attribute.id_product}" data-id-attr="{$attribute.id_product_attribute}" data-qty-attr="{$attribute.quantity}" data-min-qty-attr="{$attribute.minimal_quantity}">{$attribute.attribute_designation}</a>
		{/foreach}
		
	  </div>
	</div>
{/if}

