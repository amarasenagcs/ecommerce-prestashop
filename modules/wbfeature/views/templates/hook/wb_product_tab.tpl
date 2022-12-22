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
	<h4 class="title-info-product wb-product-show-review-title">{l s='Reviews' mod='wbfeature'}</h4>
{else if isset($USE_PTABS) && $USE_PTABS == 'accordion'}
	<div class="card-header" role="tab" id="headingwbfeatureproductreview">
	  <h5 class="h5">
		<a class="collapsed wb-product-show-review-title wbfeature-accordion" data-toggle="collapse" data-parent="#accordion" href="#collapsewbfeatureproductreview" aria-expanded="false" aria-controls="collapsewbfeatureproductreview">
		  {l s='Reviews' mod='wbfeature'}
		</a>
	 </h5>
  </div>
{else}
	<li class="nav-item">
	  <a class="nav-link wb-product-show-review-title" data-toggle="tab" href="#wb-product-show-review-content">{l s='Reviews' mod='wbfeature'}</a>
	</li>
{/if}

