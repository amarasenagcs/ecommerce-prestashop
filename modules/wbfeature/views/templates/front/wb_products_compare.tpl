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
		{capture name=path}{l s='Products Comparison' mod='wbfeature'}{/capture}
	           <div class="pro-tab other">
			 	  <div class="home-heading"><span>{l s='Products Comparison' mod='wbfeature'}</span></div>  
			   </div>
              
		
		{if $hasProduct}
			<div class="products_block table-responsive">
				<table id="product_comparison" class="table table-bordered">
					<tr>
						<td class="td_empty compare_extra_information">
							<span>{l s='Features:' mod='wbfeature'}</span>
						</td>
						
						{foreach from=$products item=product name=for_products}
							{assign var='replace_id' value=$product.id|cat:'|'}
							<td class="product-miniature js-product-miniature wb-productscompare-item product-{$product.id_product}" data-id-product="{$product.id_product}" data-id-product-attribute="{$product.id_product_attribute}" itemscope itemtype="http://schema.org/Product">
								<div class="delete-productcompare clearfix">
									<a class="wb-compare-button btn delete float-xs-right" href="#" title="{l s='Remove from Compare' mod='wbfeature'}" data-id-product="{$product.id_product}"><i class="fa fa-close"></i>
									</a>
								</div>
							  <div class="clearfix">
								<div class="product-image">
									{block name='product_thumbnail'}
									  <a href="{$product.url}" class="thumbnail product-thumbnail">
										<img class="center-block"
										  src = "{$product.cover.bySize.home_default.url}"
										  alt = "{$product.cover.legend}"
										  data-full-size-image-url = "{$product.cover.large.url}"
										>
									  </a>
									{/block}
									
									{* {block name='product_flags'}
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
										<h1 class="h3 product-title" itemprop="name"><a href="{$product.url}">{$product.name|truncate:30:'...'}</a></h1>
									{/block}
									<div class="product_desc">
										{$product.description_short|strip_tags|truncate:60:'...'}
									</div>
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
								</div>
							  </div>
							</td>
						{/foreach}
					</tr>
					{if $ordered_features}
						{foreach from=$ordered_features item=feature}
							<tr>
								{cycle values='comparison_feature_odd,comparison_feature_even' assign='classname'}
								<td class="{$classname} feature-name" >
									<strong>{$feature.name|escape:'html':'UTF-8'}</strong>
								</td>
								{foreach from=$products item=product name=for_products}
									{assign var='product_id' value=$product.id}
									{assign var='feature_id' value=$feature.id_feature}
									{if isset($product_features[$product_id])}
										{assign var='tab' value=$product_features[$product_id]}
										<td class="{$classname} comparison_infos product-{$product.id}">{if (isset($tab[$feature_id]))}{$tab[$feature_id]|escape:'html':'UTF-8'}{/if}</td>
									{else}
										<td class="{$classname} comparison_infos product-{$product.id}"></td>
									{/if}
								{/foreach}
							</tr>
						{/foreach}
					{else}
						<tr>
							<td></td>
							<td colspan="{$products|@count}" class="text-center">{l s='No features to compare' mod='wbfeature'}</td>
						</tr>
					{/if}
					
					{hook h='displayWbProducReviewCompare' list_product=$list_product}
				</table>
			</div> <!-- end products_block -->
		{else}
			<p class="alert alert-warning">{l s='There are no products selected for comparison.' mod='wbfeature'}</p>
		{/if}
		<ul class="footer_link text-xs-left">
			<li>
				<a class="button lnk_view btn btn-outline btn-sm" href="{$urls.base_url}">
					<i class="material-icons">&#xE317;</i>
					<span>{l s='Continue Shopping' mod='wbfeature'}</span>
				</a>
			</li>
		</ul>
	</section>
{/block}

