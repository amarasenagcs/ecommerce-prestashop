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
<tr class="new">
	<td>
		<a href="javascript:void(0)" class="view-wishlist-product" data-name-wishlist="{$wishlist->name}" data-id-wishlist="{$wishlist->id}">
			{* <i class="material-icons">&#xE8EF;</i> *}
			{$wishlist->name}
		</a>
		<div class="wb-view-wishlist-product-loading wb-view-wishlist-product-loading-{$wishlist->id} cssload-speeding-wheel"></div>
	</td>
	<td class="wishlist-numberproduct wishlist-numberproduct-{$wishlist->id}">0</td>
	<td>0</td>
	<td class="wishlist-datecreate">{$wishlist->date_add}</td>					
	<td><a class="view-wishlist" data-token="{$wishlist->token}" target="_blank" href="{$url_view_wishlist}" title="{l s='View' mod='wbfeature'}">{l s='View' mod='wbfeature'}</a></td>
	<td>
		<label class="form-check-label">
			<input class="default-wishlist form-check-input" data-id-wishlist="{$wishlist->id}" type="checkbox" {$checked}>
		</label>
	</td>
	<td><a class="delete-wishlist" data-id-wishlist="{$wishlist->id}" href="javascript:void(0)" title="{l s='Delete' mod='wbfeature'}"><i class="fa fa-close"></i></a></td>
</tr>

