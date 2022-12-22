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
{* {if (isset($nbReviews) && $nbReviews > 0)} *}

	<div class="wb-list-product-reviews" {if (isset($nbReviews) && $nbReviews > 0)}itemprop="aggregateRating" itemscope itemtype="https://schema.org/AggregateRating"{/if}>
		<div class="wb-list-product-reviews-wraper">
			<div class="star_content clearfix">
				{section name="i" start=0 loop=5 step=1}
					{if $averageTotal le $smarty.section.i.index}
						<div class="star"></div>
					{else}
						<div class="star star_on"></div>
					{/if}
				{/section}
				{if (isset($nbReviews) && $nbReviews > 0)}
					<meta itemprop="worstRating" content = "0" />
					<meta itemprop="ratingValue" content = "{if isset($ratings.avg)}{$ratings.avg|round:1|escape:'html':'UTF-8'}{else}{$averageTotal|round:1|escape:'html':'UTF-8'}{/if}" />
					<meta itemprop="bestRating" content = "5" />
				{/if}
			</div>
			{* {if isset($nbReviews) && $nbReviews > 0}
				{if $show_number_product_review}
					<span class="nb-revews"><span itemprop="reviewCount">{$nbReviews}</span> {l s='Review(s)' mod='wbfeature'}</span>
				{else}
					<meta itemprop="reviewCount" content = "{$nbReviews}" />
				{/if}
			{/if} *}
		</div>
	</div>

{* {/if} *}
