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
<div class="wishlist">	
		<a class="wish wb-wishlist-button btn-product btn{if $added_wishlist} added{/if}" href="javascript:void(0)" data-id-wishlist="{$id_wishlist}" data-id-product="{$wb_wishlist_id_product}" data-id-product-attribute="{$wb_wishlist_id_product_attribute}" title="{if $added_wishlist}{l s='Remove from Wishlist' mod='wbfeature'}{else}{l s='Add to Wishlist' mod='wbfeature'}{/if}">
			{* <span class="wb-wishlist-bt-loading cssload-speeding-wheel"></span> *}
			{* <span class="wb-wishlist-bt-content">
				<i class="material-icons">&#xE87D;</i>
				<span>{l s='Add to Wishlist' mod='wbfeature'}</span>
			</span> *}
			<span class="pwish">
                    <svg width="18px" height="18px"><use xlink:href="#heart" /></svg>
            </span>
		</a>	
</div>