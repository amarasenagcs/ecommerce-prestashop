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
<div class="modal wb-modal wb-modal-review fade" tabindex="-1" role="dialog" aria-hidden="true">
	<!--
	<div class="vertical-alignment-helper">
	-->
	  <div class="modal-dialog" role="document">
		<div class="modal-content">
		  <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close">
			  <span aria-hidden="true">&times;</span>
			</button>
			<h4 class="modal-title h2 text-xs-center">
							
				{l s='Write a review' mod='wbfeature'}		
			</h4>
				
		  </div>
		  
		  <div class="modal-body">
			<div class="row">
				{if isset($product_modal_review) && $product_modal_review}
					<div class="product-info clearfix  col-xs-12 col-sm-6">
						<img class="img-fluid" src="{$productcomment_cover_image}" alt="{$product_modal_review->name|escape:'html':'UTF-8'}" />
						<div class="product_desc">
							<p class="product_name">
								<strong>{$product_modal_review->name}</strong>
							</p>
							{$product_modal_review->description_short nofilter}
						</div>
					</div>
				{/if}
				<div class="new_review_form_content col-xs-12 col-sm-6">					
					{if $criterions|@count > 0}
						<ul id="criterions_list">
						{foreach from=$criterions item='criterion'}
							<li>
								<label>{$criterion.name|escape:'html':'UTF-8'}:</label>
								<div class="star_content">
									<input class="star not_uniform" type="radio" name="criterion[{$criterion.id_product_review_criterion|round}]" value="1" />
									<input class="star not_uniform" type="radio" name="criterion[{$criterion.id_product_review_criterion|round}]" value="2" />
									<input class="star not_uniform" type="radio" name="criterion[{$criterion.id_product_review_criterion|round}]" value="3" />
									<input class="star not_uniform" type="radio" name="criterion[{$criterion.id_product_review_criterion|round}]" value="4" />
									<input class="star not_uniform" type="radio" name="criterion[{$criterion.id_product_review_criterion|round}]" value="5" checked="checked" />
								</div>
								<div class="clearfix"></div>
							</li>
						{/foreach}
						</ul>
					{/if}				
					<form class="form-new-review" action="#" method="post">
						<div class="form-group">
						  <label class="form-control-label" for="new_review_title">{l s='Title' mod='wbfeature'} <sup class="required">*</sup></label>
						  <input type="text" class="form-control" id="new_review_title" required="" name="new_review_title">					  
						</div>
						<div class="form-group">
						  <label class="form-control-label" for="new_review_content">{l s='Comment' mod='wbfeature'} <sup class="required">*</sup></label>
						  <textarea type="text" class="form-control" id="new_review_content" required="" name="new_review_content"></textarea>				  
						</div>
						{if !$is_logged}
							<div class="form-group">
							  <label class="form-control-label" for="new_review_customer_name">{l s='Your name' mod='wbfeature'} <sup class="required">*</sup></label>
							  <input type="text" class="form-control" id="new_review_customer_name" required="" name="new_review_customer_name">					  
							</div>
						{else}

						{/if}

						<div class="form-group">
							<label class="form-control-label"><sup>*</sup> {l s='Required fields' mod='wbfeature'}</label>
						<input id="id_product_review" name="id_product_review" type="hidden" value='{$product_modal_review->id}' />
						</div>
						<button class="btn btn-primary form-control-submit wb-fake-button pull-xs-right" type="submit">
						  
						</button>
					</form>
				</div>
			</div>
		  </div>
		  <div class="modal-footer">
			
			<button type="button" class="btn btn-secondary" data-dismiss="modal">{l s='Close' mod='wbfeature'}</button>
			<button type="button" class="wb-modal-review-bt btn btn-primary">
				
				<span class="wb-modal-review-loading cssload-speeding-wheel"></span>
				<span class="wb-modal-review-bt-text">
					{l s='Submit' mod='wbfeature'}
				</span>
			</button>
			
		  </div>
		  
		</div>
	  </div>
	<!--
	</div>
	-->
</div>