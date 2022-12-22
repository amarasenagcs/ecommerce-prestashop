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
<div id="_desktop_user_info" class="dropdown js-dropdown hidden-sm-down d-inline-block">
    <div class="user-info" data-toggle="dropdown">
        <svg width="35px" height="33px"> <use xlink:href="#huser"></use></svg>
        <div class="shop-c text-xs-center hidden-xs-down">{l s='My account' d='Shop.Theme.Catalog'}</div>
    </div>
    <ul class="dropdown-menu user-down dropdown-menu-right">
       {if $logged}
       <li>
      <a class="account" href="{$my_account_url}" title="{l s='View my customer account' d='Shop.Theme.Customeraccount'}" rel="nofollow">
        <i class="fa fa-user logged"></i>
        {$customerName}
      </a>
      </li>
       <li>
      <a class="logout" href="{$logout_url}" rel="nofollow">
        <i class="fa fa-sign-out"></i>
        {l s='Sign out' d='Shop.Theme.Actions'}
      </a>
      </li>
    {else}
     <li> <a href="{$my_account_url}" title="{l s='Log in to your customer account' d='Shop.Theme.Customeraccount'}" rel="nofollow">
        <i class="fa fa-user"></i>
        <span>{l s='Sign in' d='Shop.Theme.Actions'}</span>
      </a></li>
    {/if}
    <li> <span>{hook h='displayWbTop'}</span></li>
  </ul>
</div>

