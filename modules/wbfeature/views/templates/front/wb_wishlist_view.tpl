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
{extends file=$layout}

{block name='content'}
	<section id="main">
		<div id="view_wishlist">
			{if isset($current_wishlist)}
			 <div class="pro-tab other">
			 	<div class="home-heading"><span>{l s='Wishlist' mod='wbfeature'} "{$current_wishlist.name}"</span></div>  
			 </div>
                       
              
			
				{* <h2>{l s='Wishlist' mod='wbfeature'} "{$current_wishlist.name}"</h2> *}
				{if $wishlists}
				<p class="text-xs-left">
					{l s='Other wishlists of ' mod='wbfeature'}{$current_wishlist.firstname} {$current_wishlist.lastname} :
					{foreach from=$wishlists item=wishlist_item name=i}				
						<a href="{$view_wishlist_url}{if $wb_is_rewrite_active}?{else}&{/if}token={$wishlist_item.token}" title="{$wishlist_item.name}" rel="nofollow">{$wishlist_item.name}</a>
						{if !$smarty.foreach.i.last}
							/
						{/if}				
					{/foreach}
				</p>
				{/if}
				<section id="products">
					<div class="wb-wishlist-product products row">
						{if $products && count($products) >0}
							{foreach from=$products item=product_item name=for_products}
								{assign var='product' value=$product_item.product_info}
								{assign var='wishlist' value=$product_item.wishlist_info}
								<div class="col-xs-12 col-sm-6 col-md-6 col-lg-4 col-xl-4 float-xs-left product-miniature js-product-miniature wb-wishlistproduct-item wb-wishlistproduct-item-{$wishlist.id_wishlist_product} product-{$product.id_product}" data-id-product="{$product.id_product}" data-id-product-attribute="{$product.id_product_attribute}" itemscope itemtype="http://schema.org/Product">
									<div class="clearfix">
										<div class="product-image">
											{block name='product_thumbnail'}
											  <a href="{$product.url}" target="_blank" class="thumbnail product-thumbnail">
												<img class="img-fluid center-block"
												  src = "{$product.cover.bySize.home_default.url}"
												  alt = "{$product.cover.legend}"
												  data-full-size-image-url = "{$product.cover.large.url}"
												>
											  </a>
											{/block}
{* 
											{block name='product_flags'}
												<ul class="product-flags">
													{foreach from=$product.flags item=flag}
														<li class="product-flag {$flag.type}">{$flag.label}</li>
													{/foreach}
												</ul>
											{/block} *}
										</div>
										<div class="product-description">
											{hook h='displayWbCartAttribute' product=$product}
											{hook h='displayWbCartQuantity' product=$product}
											{hook h='displayWbCartButton' product=$product}
											{block name='product_name'}
												<h1 class="h3 product-title" itemprop="name"><a href="{$product.url}" target="_blank">{$product.name|truncate:30:'...'}</a></h1>
											{/block}
											{block name='product_price_and_shipping'}
												{if $product.show_price}
													<div class="product-price-and-shipping">
														{if $product.has_discount}
															{hook h='displayProductPriceBlock' product=$product type="old_price"}
															<span class="regular-price">{$product.regular_price}</span>
															{if $product.discount_type === 'percentage'}
																<span class="discount-percentage">{$product.discount_percentage}</span>
															{/if}
														{/if}
														{hook h='displayProductPriceBlock' product=$product type="before_price"}
														<span itemprop="price" class="price">{$product.price}</span>												
														{hook h='displayProductPriceBlock' product=$product type='unit_price'}
														{hook h='displayProductPriceBlock' product=$product type='weight'}
													</div>	  
												{/if}
											{/block}
											<div class="wishlist-product-info">										
												<input class="form-control wishlist-product-quantity wishlist-product-quantity-{$wishlist.id_wishlist_product}" type="{if $show_button_cart}hidden{else}number{/if}" data-min=1 value="{$wishlist.quantity}">					
												<div class="form-group">
													<label>
														<strong>{l s='Priority' mod='wbfeature'}: </strong>
														{if $wishlist.priority == 0}{l s='High' mod='wbfeature'}{/if}
														{if $wishlist.priority == 1}{l s='Medium' mod='wbfeature'}{/if}
														{if $wishlist.priority == 2}{l s='Low' mod='wbfeature'}{/if}
													</label>									
												</div>
											</div>
										</div>										
									</div>											
								</div>
							{/foreach}
						{else}
						   <div class="col-xs-12">
							<div class="alert alert-warning">{l s='No products' mod='wbfeature'}</div>
						   </div>
						{/if}
					</div>
				</section>
			{else}
			<div class="col-xs-12">
				<div class="alert alert-warning">{l s='Wishlist does not exist' mod='wbfeature'}</div>
			</div>
			{/if}
		</div>
	</section>
{/block}

