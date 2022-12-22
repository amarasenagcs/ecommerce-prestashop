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
<div class="wb-notification" style="width: {$width_notification}px; {$vertical_position}; {$horizontal_position}">
</div>
<div class="wb-temp wb-temp-success">
	<div class="notification-wrapper">
		<div class="notification notification-success">
			{*
			<span class="notification-title"><i class="material-icons">&#xE876;</i></span> 
			*}
			<strong class="noti product-name"></strong>
			<span class="noti noti-update">{l s='The product has been updated in your shopping cart' mod='wbfeature'}</span>
			<span class="noti noti-delete">{l s='The product has been removed from your shopping cart' mod='wbfeature'}</span>
			<span class="noti noti-add"><strong class="noti-special"></strong> {l s='Product successfully added to your shopping cart' mod='wbfeature'}</span>
			<span class="notification-close float-xs-right">X</span>
			
		</div>
	</div>
</div>
<div class="wb-temp wb-temp-error">
	<div class="notification-wrapper">
		<div class="notification notification-error">
			{*
			<span class="notification-title"><i class="material-icons">&#xE611;</i></span>
			*}
			
			<span class="noti noti-update">{l s='Error updating' mod='wbfeature'}</span>
			<span class="noti noti-delete">{l s='Error deleting' mod='wbfeature'}</span>
			<span class="noti noti-add">{l s='Error adding. Please go to product detail page and try again' mod='wbfeature'}</span>
			
			<span class="notification-close">X</span>
			
		</div>
	</div>
</div>
<div class="wb-temp wb-temp-warning">
	<div class="notification-wrapper">
		<div class="notification notification-warning">
			{*
			<span class="notification-title"><i class="material-icons">&#xE645;</i></span> 
			*}
			<span class="noti noti-min">{l s='The minimum purchase order quantity for the product is' mod='wbfeature'} <strong class="noti-special"></strong></span>
			<span class="noti noti-max">{l s='There are not enough products in stock' mod='wbfeature'}</span>
			
			<span class="notification-close">X</span>
			
		</div>
	</div>
</div>
<div class="wb-temp wb-temp-normal">
	<div class="notification-wrapper">
		<div class="notification notification-normal">
			{*
			<span class="notification-title"><i class="material-icons">&#xE88F;</i></span>
			*}
			<span class="noti noti-check">{l s='You must enter a quantity' mod='wbfeature'}</span>
			
			<span class="notification-close">X</span>
			
		</div>
	</div>
</div>
