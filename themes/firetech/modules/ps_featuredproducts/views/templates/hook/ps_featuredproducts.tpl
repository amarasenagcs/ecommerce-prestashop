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
<div class="fea-best-tabs fea-tab-1">    
    <div class="pro-tab tabs">
            <div class="home-heading float-xs-left">{l s='treding product' d='Shop.Theme.Catalog'}</div>
           
            <ul class="list-inline nav nav-tabs text-xs-right">
                <li class="nav-item">
                    <a class="nav-link active" href="#tab-featured-0" data-toggle="tab" ><span>{l s='Featured' d='Shop.Theme.Catalog'}</span></a>
                </li>
                <span class="tab-indicator">|</span>
                <li class="nav-item">
                    <a class="nav-link " href="#tab-new-0" data-toggle="tab"><span>{l s='new' d='Shop.Theme.Catalog'}</span></a>
                </li> 
                <span class="tab-indicator">|</span> 
                 <li class="nav-item">
                    <a class="nav-link " href="#tab-best-0" data-toggle="tab"><span>{l s='bestsellers' d='Shop.Theme.Catalog'}</span></a>
                </li>  

            </ul>
        </div>
<div id="tab-content" class="tab-content ">
<section class="featured-products tab-pane clearfix active" id="tab-featured-0">
  <div id="owl-fea" class="owl-carousel owl-theme">
 {$num_row=2} <!-- Number of Row Ex 2,3,4,5....etc-->
    {$i=0}
    {if count($products) <= 6}
      {foreach from=$products item="product"}
        {include file="catalog/_partials/miniatures/product.tpl" product=$product}
      {/foreach}
    {else}
      {foreach from=$products item="product"}
        {if $i == 0}
          <ul>
            <li>
        {/if}
              {include file="catalog/_partials/miniatures/product.tpl" product=$product}
              {$i=$i+1}
        {if $i == $num_row}
            </li>
          </ul>
          {$i=0}
        {/if}
      {/foreach}
    {/if}
    </div>
</section>
