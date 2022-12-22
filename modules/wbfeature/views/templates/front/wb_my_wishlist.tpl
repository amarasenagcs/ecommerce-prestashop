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
		<div id="mywishlist">
			 <div class="pro-tab other">
			 	<div class="home-heading"><span>{l s='New wishlist' mod='wbfeature'}</span></div>  
			 </div>
               
			
			<div class="new-wishlist">
				<div class="form-group has-success">
					<div class="form-control-feedback"></div>			 
				</div>
				<div class="form-group has-danger">		 
				  <div class="form-control-feedback"></div>		 
				</div>
				<div class="form-group">
					<label for="wishlist_name" class="float-xs-left">{l s='Name' mod='wbfeature'}</label>
					<input type="text" class="form-control float-xs-left" id="wishlist_name" placeholder="{l s='Enter name of new wishlist' mod='wbfeature'}">
				</div>
				
				<button type="submit" class="btn btn-primary wb-save-wishlist-bt float-xs-left">
					{* <span class="wb-save-wishlist-loading cssload-speeding-wheel"></span> *}
					<span class="">
						{l s='Save' mod='wbfeature'}
					</span>
				</button>
				<div class="clwi"></div>
			</div>
			{if $wishlists}
				<div class="list-wishlist table-responsive clearfix">
					<table class="table table-bordered">
					  <thead class="wishlist-table-head">
						<tr>
						  <th>{l s='Name' mod='wbfeature'}</th>
						  <th>{l s='Quantity' mod='wbfeature'}</th>
						  <th>{l s='Viewed' mod='wbfeature'}</th>
						  <th class="wishlist-datecreate-head">{l s='Created' mod='wbfeature'}</th>
						  <th>{l s='Direct Link' mod='wbfeature'}</th>
						  <th>{l s='Default' mod='wbfeature'}</th>
						  <th>{l s='Delete' mod='wbfeature'}</th>
						</tr>
					  </thead>
					  <tbody>
					
							{foreach from=$wishlists item=wishlists_item name=for_wishlists}
								<tr>					 
									<td><a href="javascript:void(0)" class="view-wishlist-product" data-name-wishlist="{$wishlists_item.name}" data-id-wishlist="{$wishlists_item.id_wishlist}">{* <i class="material-icons">&#xE8EF;</i> *}{$wishlists_item.name}</a><div class="wb-view-wishlist-product-loading wb-view-wishlist-product-loading-{$wishlists_item.id_wishlist} cssload-speeding-wheel"></div></td>
									<td class="wishlist-numberproduct wishlist-numberproduct-{$wishlists_item.id_wishlist}">{$wishlists_item.number_product|intval}</td>
									<td>{$wishlists_item.counter|intval}</td>
									<td class="wishlist-datecreate">{$wishlists_item.date_add}</td>							
									<td><a class="view-wishlist" data-token="{$wishlists_item.token}" href="{$view_wishlist_url}{if $wb_is_rewrite_active}?{else}&{/if}token={$wishlists_item.token}" title="{l s='View' mod='wbfeature'}">{l s='View' mod='wbfeature'}</a></td>
									<td>
										
											<label class="form-check-label">
												<input class="default-wishlist form-check-input" data-id-wishlist="{$wishlists_item.id_wishlist}" type="checkbox" {if $wishlists_item.default == 1}checked="checked"{/if}>
											</label>
									
									</td>
									<td><a class="delete-wishlist" data-id-wishlist="{$wishlists_item.id_wishlist}" href="javascript:void(0)" title="{l s='Delete' mod='wbfeature'}"><i class="fa fa-close"></i></a></td>
								</tr>
							{/foreach}
					
					  </tbody>
					</table>
				</div>
			{/if}
			<div class="send-wishlist text-xs-left">
				<a class="wb-send-wishlist-button btn btn-info" href="javascript:void(0)" title="{l s='Send this wishlist' mod='wbfeature'}">
					{* <i class="material-icons">&#xE163;</i> *}
					{l s='Send this wishlist' mod='wbfeature'}
				</a>
			</div>
			<section id="products">
				<div class="wb-wishlist-product products row">
				
				</div>
			</section>
			<ul class="footer_links page-footer">
				<li class="pull-xs-left d-inline-block"><a class="account-link" href="{$link->getPageLink('my-account', true)|escape:'html'}"><i class="material-icons">&#xE314;</i> <span>{l s='Back to Your Account' mod='wbfeature'}</span> </a></li>
				<li class="pull-xs-right d-inline-block"><a class="account-link" href="{$urls.base_url}"><i class="material-icons">&#xE88A;</i> <span>{l s='Home' mod='wbfeature'}</span> </a></li>
			</ul>
		</div>
	</section>
{/block}

