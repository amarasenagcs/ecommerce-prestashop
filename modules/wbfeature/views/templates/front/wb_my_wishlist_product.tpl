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
{if $products && count($products) >0}
	{foreach from=$products item=product_item name=for_products}
		{assign var='product' value=$product_item.product_info}
		{assign var='wishlist' value=$product_item.wishlist_info}
		<div class="col-xs-12 col-sm-6 col-md-6 col-lg-4 col-xl-4 float-xs-left product-miniature js-product-miniature wb-wishlistproduct-item wb-wishlistproduct-item-{$wishlist.id_wishlist_product} product-{$product.id_product}" data-id-product="{$product.id_product}" data-id-product-attribute="{$product.id_product_attribute}" itemscope itemtype="http://schema.org/Product">
			<div class="delete-wishlist-product clearfix">
				<a class="wb-wishlist-button-delete" href="javascript:void(0)" title="{l s='Remove from this wishlist' mod='wbfeature'}" data-id-wishlist="{$wishlist.id_wishlist}" data-id-wishlist-product="{$wishlist.id_wishlist_product}" data-id-product="{$product.id_product}"><i class="fa fa-close"></i>
				</a>
			</div>
			<div class="wish-image-block clearfix">

				{block name='product_thumbnail'}
				  <a href="{$product.url}" class="thumbnail product-thumbnail">
					<img class="img-fluid center-block"
					  src = "{$product.cover.bySize.home_default.url}"
					  alt = "{$product.cover.legend}"
					  data-full-size-image-url = "{$product.cover.large.url}"
					>
				  </a>
				{/block}
						
			</div>
			<div class="product-description">							
				  {block name='product_name'}
					<h1 class="h3 product-title" itemprop="name"><a href="{$product.url}">{$product.name|truncate:30:'...'}</a></h1>
				  {/block}
				  
			
			<div class="wishlist-product-info">
				<div class="form-group">
					<label>{l s='Quantity' mod='wbfeature'}</label>
					<input class="form-control wishlist-product-quantity wishlist-product-quantity-{$wishlist.id_wishlist_product}" type="number" min=1 value="{$wishlist.quantity}">					
				</div>
				<div class="form-group">
					<label>{l s='Priority' mod='wbfeature'}</label>
					<select class="form-control wishlist-product-priority wishlist-product-priority-{$wishlist.id_wishlist_product}">					  
						{for $i=0 to 2}
							<option value="{$i}"{if $i == $wishlist.priority} selected="selected"{/if}>								
								{if $i == 0}{l s='High' mod='wbfeature'}{/if}
								{if $i == 1}{l s='Medium' mod='wbfeature'}{/if}
								{if $i == 2}{l s='Low' mod='wbfeature'}{/if}								
							</option>
						{/for}
					</select>
				  </div>
			</div>		
			<div class="wishlist-product-action text-xs-left">
				<a class="wb-wishlist-product-save-button btn btn-primary" href="javascript:void(0)" title="{l s='Save' mod='wbfeature'}" data-id-wishlist="{$wishlist.id_wishlist}" data-id-wishlist-product="{$wishlist.id_wishlist_product}" data-id-product="{$product.id_product}">{l s='Save' mod='wbfeature'}
				</a>
				{if isset($wishlists) && count($wishlists) > 0}					
					<div class="dropdown wb-wishlist-button-dropdown">					 
					  <button class="wb-wishlist-button dropdown-toggle btn btn-primary show-list" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">{l s='Move' mod='wbfeature'}</button>
					  <div class="dropdown-menu wb-list-wishlist wb-list-wishlist-{$product.id_product}">				
						{foreach from=$wishlists item=wishlists_item}							
							<a href="#" class="dropdown-item list-group-item list-group-item-action move-wishlist-item" data-id-wishlist="{$wishlists_item.id_wishlist}" data-id-wishlist-product="{$wishlist.id_wishlist_product}" data-id-product="{$product.id_product}" data-id-product-attribute="{$product.id_product_attribute}" title="{$wishlists_item.name}">{$wishlists_item.name}</a>			
						{/foreach}
					  </div>
					</div>
				{/if}
			</div>
	    </div>	
		</div>
	{/foreach}
{else}
 <div class="col-xs-12">
	<div class="alert alert-warning">{l s='No products' mod='wbfeature'}</div>
</div>
{/if}

