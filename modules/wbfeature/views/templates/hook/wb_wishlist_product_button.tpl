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
	{if isset($wishlists) && count($wishlists) > 1}
		<div class="dropdown wb-wishlist-button-dropdown">
		  <button class="wish wb-wishlist-button dropdown-toggle show-list btn-product btn{if $added_wishlist} added{/if}" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" data-id-wishlist="{$id_wishlist}" data-id-product="{$wb_wishlist_id_product}" data-id-product-attribute="{$wb_wishlist_id_product_attribute}">
			{* <span class="wb-wishlist-bt-loading cssload-speeding-wheel"></span> *}
			{* <span class="wb-wishlist-bt-content">
				<i class="material-icons">&#xE87D;</i>
				<span>{l s='Add to Wishlist' mod='wbfeature'}</span>
			</span> *}
			<svg width="18px" height="18px"><use xlink:href="#heart" /></svg>
			<span>{l s='Add to Wishlist' mod='wbfeature'}</span>
			
		  </button>
		  <div class="dropdown-menu wb-list-wishlist wb-list-wishlist-{$wb_wishlist_id_product}">
			{foreach from=$wishlists item=wishlists_item}
				<a href="javascript:void(0)" class="dropdown-item list-group-item list-group-item-action wishlist-item{if in_array($wishlists_item.id_wishlist, $wishlists_added)} added {/if}" data-id-wishlist="{$wishlists_item.id_wishlist}" data-id-product="{$wb_wishlist_id_product}" data-id-product-attribute="{$wb_wishlist_id_product_attribute}" title="{if in_array($wishlists_item.id_wishlist, $wishlists_added)}{l s='Remove from Wishlist' mod='wbfeature'}{else}{l s='Add to Wishlist' mod='wbfeature'}{/if}">{$wishlists_item.name}</a>			
			{/foreach}
		  </div>
		</div>
	{else}
		<a class="wish wb-wishlist-button btn-product btn{if $added_wishlist} added{/if}" href="javascript:void(0)" data-id-wishlist="{$id_wishlist}" data-id-product="{$wb_wishlist_id_product}" data-id-product-attribute="{$wb_wishlist_id_product_attribute}" title="{if $added_wishlist}{l s='Remove from Wishlist' mod='wbfeature'}{else}{l s='Add to Wishlist' mod='wbfeature'}{/if}">
			{* <span class="wb-wishlist-bt-loading cssload-speeding-wheel"></span> *}
			{* <span class="wb-wishlist-bt-content">
				<i class="material-icons">&#xE87D;</i>
				<span>{l s='Add to Wishlist' mod='wbfeature'}</span>
			</span> *}
			<svg width="18px" height="18px"><use xlink:href="#heart" /></svg>
			<span>{l s='Add to Wishlist' mod='wbfeature'}</span>
		</a>
	{/if}
</div>