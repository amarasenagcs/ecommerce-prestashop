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
<div data-type="{$type_fly_cart}" style="position: {$type_position}; {$vertical_position}; {$horizontal_position}" class="wb-fly-cart solo type-{$type_position}{if $type_fly_cart == 'dropup' || $type_fly_cart == 'dropdown'} enable-dropdown{/if}{if $type_fly_cart == 'slidebar_top' || $type_fly_cart == 'slidebar_bottom' || $type_fly_cart == 'slidebar_right' || $type_fly_cart == 'slidebar_left'} enable-slidebar{/if}">
	<div class="wb-fly-cart-icon-wrapper">
		<a href="javascript:void(0)" class="wb-fly-cart-icon" data-type="{$type_fly_cart}"><i class="material-icons">&#xE8CC;</i></a>
		<span class="wb-fly-cart-total"></span>
	</div>
	{*
	<div class="wb-fly-cssload-speeding-wheel"></div>
	*}
	<div class="wb-fly-cart-cssload-loader"></div>
</div>