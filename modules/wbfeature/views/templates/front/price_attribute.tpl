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
{if $product_price_attribute.show_price}
	
		{if $product_price_attribute.has_discount}
		  {hook h='displayProductPriceBlock' product=$product_price_attribute type="old_price"}

		  <span class="regular-price">{$product_price_attribute.regular_price}</span>
		  {if $product_price_attribute.discount_type === 'percentage'}
			<span class="discount-percentage">{$product_price_attribute.discount_percentage}</span>
		  {/if}
		{/if}

		{hook h='displayProductPriceBlock' product=$product_price_attribute type="before_price"}

		<span itemprop="price" class="price">{$product_price_attribute.price}</span>

		{hook h='displayProductPriceBlock' product=$product_price_attribute type='unit_price'}

		{hook h='displayProductPriceBlock' product=$product_price_attribute type='weight'}
	
  
{/if}