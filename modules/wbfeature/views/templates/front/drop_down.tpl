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
	{if $only_total != 1}
		<div class="wb-dropdown-cart-content clearfix text-xs-left">
			<div class="wb-dropdown-list-item-warpper">
				<ul class="wb-dropdown-list-item">{foreach from=$cart.products item=product name="cart_product"}<li style="width: {$width_cart_item}px; height: {$height_cart_item}px" class="wb-dropdown-cart-item clearfix{if ($product.attributes|count && $show_combination) || ($product.customizations|count && $show_customization)} has-view-additional{/if}{if $smarty.foreach.cart_product.first} first{/if}{if $smarty.foreach.cart_product.last} last{/if}">						
							<div class="wb-cart-item-img float-xs-left">
								{if $product.images}
									<a class="label" href="{$product.url}" title="{$product.name}"><img class="img-fluid" src="{$product.images.0.bySize.small_default.url}" alt="{$product.name}" title="{$product.name}"/></a>
								{/if}	
							</div>						
							<div class="wb-cart-item-info float-xs-left">					
								<div class="product-name"><a class="label" href="{$product.url}" title="{$product.name}">{$product.name|truncate:18:'...'}</a></div>
								<div class="product-price">
									{if $product.has_discount}
										<div class="product-discount">
										  <span class="regular-price">{$product.regular_price}</span>
										  
										  {if $product.discount_type === 'percentage'}
											<span class="discount discount-percentage">
												-{$product.discount_percentage_absolute}
											  </span>
										  {else}
											<span class="discount discount-amount">
												-{$product.discount_to_display}
											  </span>
										  {/if}
										  
										</div>
									  {/if}
									  <div class="current-price">
										<span class="price">{$product.price}</span>
									  </div>
										{if $product.unit_price_full}
										  <div class="unit-price-cart">{$product.unit_price_full}</div>
										{/if}
								</div>
								<div class="cart-drop">
										{if $enable_update_quantity}
											<div class="product-quantity d-inline-block float-xs-left">												
												{if $enable_button_quantity}
													<a href="javascript:void(0)" class="wb-bt-product-quantity wb-bt-product-quantity-down"><i class="fa fa-minus"></i></a>
												{/if}
												<input
													class="wb-input-product-quantity input-group"
													data-down-url="{$product.down_quantity_url}"
													data-up-url="{$product.up_quantity_url}"
													data-update-url="{$product.update_quantity_url}"
													data-id-product = "{$product.id_product|escape:'javascript'}"
													data-id-product-attribute = "{$product.id_product_attribute|escape:'javascript'}"
													data-id-customization = "{$product.id_customization|escape:'javascript'}"
													data-min-quantity="{$product.minimal_quantity}"
													data-product-quantity="{$product.quantity}"
													data-quantity-available="{$product.quantity_available}"									
													type="text"
													value="{$product.quantity}"								
													min="{$product.minimal_quantity}"
												  />
												{if $enable_button_quantity}	
													<a href="javascript:void(0)" class="wb-bt-product-quantity wb-bt-product-quantity-up"><i class="fa fa-plus"></i></a>
												{/if}
											</div>
										{else}
											<div class="product-quantity"><span class="lablel">{l s='Quantity' mod='wbfeature'}</span>: {$product.quantity}</div>
										{/if}
										{if ($product.attributes|count && $show_combination) || ($product.customizations|count && $show_customization)}
											<div class="view-additional float-xs-right">								
												<div class="view-wb-dropdown-additional"></div>
											</div>
										{/if}
						        </div>
						        <a class="wb-remove-from-cart text-xs-right"					
										href="javascript:void(0)"					
										title="{l s='Remove from cart' mod='wbfeature'}" 
										data-link-url="{$product.remove_from_cart_url}"
										data-id-product = "{$product.id_product|escape:'javascript'}"
										data-id-product-attribute = "{$product.id_product_attribute|escape:'javascript'}"
										data-id-customization = "{$product.id_customization|escape:'javascript'}"
									>
										<i class="fa fa-close"></i>
									</a>
							</div>
							
							
							<div class="wb-dropdown-overlay">
								<div class="wb-dropdown-cssload-speeding-wheel"></div>
							</div>
							<div class="wb-dropdown-additional">
								{if $product.attributes|count && $show_combination}							
									<div class="view-combination label">
										
									</div>
									<div class="combinations">
										{foreach from=$product.attributes key="attribute" item="value"}
											  <div class="product-line-info">
												<span class="label">{$attribute}:</span>
												<span class="value">{$value}</span>
											  </div>
										{/foreach}
									</div>
								{/if}
								{if $product.customizations|count && $show_customization}
									<div class="view-customization label">
										
									</div>
									<div class="customizations">								
										{foreach from=$product.customizations item='customization'}			
											
											<ul>
												{foreach from=$customization.fields item='field'}
													<li>
														<span class="label">{$field.label}</span>
														{if $field.type == 'text'}
															: <span class="value">{$field.text nofilter}</span>
														{else if $field.type == 'image'}
															<img src="{$field.image.small.url}">
														{/if}
													</li>
												{/foreach}
											</ul>								
										{/foreach}								
									</div>
								{/if}
							</div>
						</li>{/foreach}</ul>
			</div>
			<div class="wb-dropdown-bottom">
			{/if}
				<div class="wb-dropdown-total" data-cart-total="{$cart.products_count}">
					<div class="wb-dropdown-cart-subtotals">
						{foreach from=$cart.subtotals item="subtotal"}
							{if $subtotal|count}
								<div class="{$subtotal.type} clearfix">
									<div class="row">
										<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 col-xl-6 text-xs-left">
											<span class="label">{$subtotal.label}</span>
										</div>
										<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 col-xl-6 text-xs-right">
											<span class="value">{$subtotal.value}</span>
										</div>
									</div>
								</div>
							{/if}
						{/foreach}
					</div>
					<div class="wb-dropdown-cart-total clearfix">
						<div class="row">
							<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 col-xl-6 text-xs-left">
								<span class="label">{$cart.totals.total.label}</span>
							</div>
							<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 col-xl-6 text-xs-right">
								<span class="value">{$cart.totals.total.value}</span>
							</div>
						</div>
					</div>
				</div>
			{if $only_total != 1}
				<div class="wb-cart-dropdown-action clearfix">
					<a class="cart-dropdow-button cart-dropdow-viewcart btn btn-primary btn-outline" href="{$cart_url}">{l s='View Cart' mod='wbfeature'}</a>
					<a class="cart-dropdow-button cart-dropdow-checkout btn btn-primary btn-outline" href="{$order_url}">{l s='Check Out' mod='wbfeature'}</a>
				</div>
			</div>
		</div>
	{/if}
