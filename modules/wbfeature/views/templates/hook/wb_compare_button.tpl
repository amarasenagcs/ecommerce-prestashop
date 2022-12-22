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
<div class="compare">
	<a class="wb-compare-button btn-product btn{if $added} added{/if}" href="javascript:void(0)" data-id-product="{$wb_compare_id_product}" title="{if $added}{l s='Remove from Compare' mod='wbfeature'}{else}{l s='Add to Compare' mod='wbfeature'}{/if}">
		{* <span class="wb-compare-bt-loading cssload-speeding-wheel"></span> *}
		<span class="wb-compare-content">
			<svg width="17px" height="17px"><use xlink:href="#compare" /></svg>
			<span>{l s='Add to Compare' mod='wbfeature'}</span>
		</span>
	</a>
</div>