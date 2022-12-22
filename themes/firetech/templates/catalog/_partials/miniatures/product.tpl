{**
 * 2007-2017 PrestaShop
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Academic Free License 3.0 (AFL-3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * https://opensource.org/licenses/AFL-3.0
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
 * @author    PrestaShop SA <contact@prestashop.com>
 * @copyright 2007-2017 PrestaShop SA
 * @license   https://opensource.org/licenses/AFL-3.0 Academic Free License 3.0 (AFL-3.0)
 * International Registered Trademark & Property of PrestaShop SA
 *}
{block name='product_miniature_item'}
  <article class="product-miniature js-product-miniature" data-id-product="{$product.id_product}" data-id-product-attribute="{$product.id_product_attribute}" itemscope itemtype="http://schema.org/Product">
    <div class="thumbnail-container">
    <div class="wb-image-block">
      {block name='product_thumbnail'}
              <a href="{$product.url}" class="thumbnail product-thumbnail">
                <img class="center-block img-responsive" src = "{$product.cover.bySize.home_default.url}"
                  alt = "{$product.cover.legend}"
                  data-full-size-image-url = "{$product.cover.large.url}">
                {$count=0}
                 {foreach from=$product.images item=image}
                {if $count==0}
                    <img class="second-img img-responsive"  
                      src="{$image.bySize.home_default.url}"
                      alt="{$image.legend}"
                      title="{$image.legend}"
                      itemprop="image"
                    >
                    {/if} {$count=$count+1}
                {/foreach}
              </a>
          {/block}
          {* {block name='product_flags'}
            <ul class="product-flags">
              {foreach from=$product.flags item=flag}
                <li class="product-flag {$flag.type}">{$flag.label}</li>
              {/foreach}
            </ul>
          {/block} *}
          {if $product.discount_type === 'percentage'}
            <div class="discount-percentage sale"><span>{$product.discount_percentage}</span></div>
          {elseif $product.discount_type === 'amount'}
            <div class="discount-amount sale"><span>{$product.discount_amount_to_display}</span></div>
          {/if}
    </div>

      <div class="wb-product-desc text-xs-left">
         <div class="title-price">
            {block name='product_name'}
              <h1 class="h3 product-title float-xs-left" itemprop="name"><a href="{$product.url}">{$product.name|truncate:40:'...'}</a></h1>
            {/block} 

            {* {block name='product_reviews'}
              {hook h='displayWbProductListReview' product=$product}
            {/block} *}

            {block name='product_price_and_shipping'}
              {if $product.show_price}
                <div class="product-price-and-shipping float-xs-right text-xs-right">
                  <span itemprop="price" class="price">{$product.price}</span>
                  {if $product.has_discount}
                    {hook h='displayProductPriceBlock' product=$product type="old_price"}

                    <span class="sr-only">{l s='Regular price' d='Shop.Theme.Catalog'}</span><br/>
                    <span class="regular-price">{$product.regular_price}</span>
                  {/if}

                  {hook h='displayProductPriceBlock' product=$product type="before_price"}

                  <span class="sr-only">{l s='Price' d='Shop.Theme.Catalog'}</span>

                  {hook h='displayProductPriceBlock' product=$product type='unit_price'}              
                </div>
              {/if}
            {/block}
        </div>
        <div class="clearfix"></div>
         {block name='product_description_short'}
              <div id="product-description-short-{$product.id}" itemprop="description" class="listds">{$product.description_short|truncate:150:'...' nofilter}</div>
            {/block}
      <div class="countdown">
          {hook h='displayProductPriceBlock' product=$product type='weight'}
      </div>

          <div class="highlighted-informations{if !$product.main_variants} no-variants{/if} button-group">
                <div class="functional-buttons clearfix abs-btn">          
                   
                      {hook h='displayWbCartButton' product=$product}
                      {hook h='displayWbWishlistButton' product=$product }
                      {hook h='displayWbCompareButton' product=$product } 
                       {block name='quick_view'}
                          <a class="quick-view quick" href="#" data-link-action="quickview">
                           <svg width="18px" height="18px"><use xlink:href="#bquick" /></svg>
                          </a>
                        {/block}                      
                       
                </div>        
         </div>
      </div>

    </div>
  </article>
{/block}
