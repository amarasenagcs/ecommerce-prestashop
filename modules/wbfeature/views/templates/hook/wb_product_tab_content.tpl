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
{if isset($USE_PTABS) && $USE_PTABS == 'default'}
	
{else if isset($USE_PTABS) && $USE_PTABS == 'accordion'}
	<div id="collapsewbfeatureproductreview" class="collapse" role="tabpanel">
          <div class="card-block">
{else}
	<div class="tab-pane fade in" id="wb-product-show-review-content">	
{/if}

		<div id="product_reviews_block_tab">
			{if $reviews}
				<div class="reviewbtn">
					<a class="open-review-form btn btn-primary" href="javascript:void(0)" data-id-product="{$id_product_tab_content}" data-is-logged="{$customer.is_logged}" data-product-link="{$link_product_tab_content}">
						{* <i class="material-icons">&#xE150;</i> *}
						{l s='Write a review' mod='wbfeature'}
					</a>
				</div>			
				{else}
				<div class="reviewbtn">
					<a class="open-review-form btn btn-primary" href="javascript:void(0)" data-id-product="{$id_product_tab_content}" data-is-logged="{$customer.is_logged}" data-product-link="{$link_product_tab_content}">
						{* <i class="material-icons">&#xE150;</i> *}
						{l s='Write a review' mod='wbfeature'}
					</a>
				</div>
					<p class="align_center">{l s='No customer reviews for the moment.' mod='wbfeature'}</p>
			{/if}
				{foreach from=$reviews item=review}
					{if $review.content}
					<div class="review" itemprop="review" itemscope itemtype="https://schema.org/Review">
						<div class="review-info">
							<div class="review_author">
								{* <span>{l s='Grade' mod='wbfeature'}&nbsp;</span> *}
								<div class="star_content clearfix"  itemprop="reviewRating" itemscope itemtype="https://schema.org/Rating">
									{section name="i" start=0 loop=5 step=1}
										{if $review.grade le $smarty.section.i.index}
											<div class="star"></div>
										{else}
											<div class="star star_on"></div>
										{/if}
									{/section}
									<meta itemprop="worstRating" content = "0" />
									<meta itemprop="ratingValue" content = "{$review.grade|escape:'html':'UTF-8'}" />
									<meta itemprop="bestRating" content = "5" />
								</div>
								<div class="review_author_infos">
									<p itemprop="name" class="title_block">
										<strong>{$review.title}</strong>
									</p>
								</div>
							</div>
							<div class="rname">
								<span itemprop="author">{$review.customer_name|escape:'html':'UTF-8'}</span>
								<span class="arr">|</span>
								<meta itemprop="datePublished" content="{$review.date_add|escape:'html':'UTF-8'|substr:0:10}" />
								<span>{dateFormat date=$review.date_add|escape:'html':'UTF-8' full=0}</span>
							</div>

							<div class="review_details">
								
								<p itemprop="reviewBody">{$review.content|escape:'html':'UTF-8'|nl2br}</p>
								
							</div>
							<!-- .review_details -->
						</div>
						
						<div class="review_button">
							<ul>
								{if $review.total_advice > 0}
									<li>
										{l s='%1$d out of %2$d people found this review useful.' sprintf=[$review.total_useful,$review.total_advice] mod='wbfeature'}
									</li>
								{/if}
								{if $customer.is_logged}
									{if !$review.customer_advice && $allow_usefull_button}
									<li>
										{l s='Was this review useful to you?' mod='wbfeature'}
										<button class="usefulness_btn button button-small" data-is-usefull="1" data-id-product-review="{$review.id_product_review}">
											<span>{l s='Yes' mod='wbfeature'}</span>
										</button>
										<button class="usefulness_btn button button-small" data-is-usefull="0" data-id-product-review="{$review.id_product_review}">
											<span>{l s='No' mod='wbfeature'}</span>
										</button>
									</li>
									{/if}
									{if !$review.customer_report && $allow_report_button}
									<li>
										<a href="javascript:void(0)" class="btn report_btn" data-id-product-review="{$review.id_product_review}">
											{l s='Report abuse' mod='wbfeature'}
										</a>
									</li>
									{/if}
								{/if}
							</ul>
						</div>
					</div> <!-- .review -->
					{/if}
				{/foreach}
		</div> 
{if isset($USE_PTABS) && $USE_PTABS == 'default'}
		
{else if isset($USE_PTABS) && $USE_PTABS == 'accordion'}
		</div>
	</div>
{else}
	</div>	
{/if}
