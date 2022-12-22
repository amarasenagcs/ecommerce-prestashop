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
<!doctype html>
<html lang="{$language.iso_code}">

  <head>
    {block name='head'}
      {include file='_partials/head.tpl'}
    {/block}
  </head>

 <body id="{$page.page_name}" class="{$page.body_classes|classnames} {if isset($WB_mainLayout)}{$WB_mainLayout}{/if}">
  {if isset($WB_showPanelTool) && $WB_showPanelTool}
    {include file="modules/wbthemecustomizer/views/templates/front/colortool.tpl"}
  {/if}

    {block name='hook_after_body_opening_tag'}
      {hook h='displayAfterBodyOpeningTag'}
    {/block}
  <main>
    <header id="header">
      {block name='header'}
        {include file='checkout/_partials/header.tpl'}
      {/block}
    </header>

    {block name='notifications'}
      {include file='_partials/notifications.tpl'}
    {/block}
    <div id="cat-left-column" class="hidden-md-up col-xs-12"></div>
     <section id="wrapper">
     {*  {hook h="displayWrapperTop"} *}
      <div class="container">

      {block name='content'}
        <section id="content">
          <div class="row">
              {block name="left_column"}
                <div id="left-column" class="col-xs-12 col-sm-12 col-md-4 col-lg-3">
                      {if $page.page_name == 'product'}
                        {hook h='displayLeftColumnProduct'}
                      {else}
                        {hook h="displayLeftColumn"}
                      {/if}
                 </div>
              {/block}
              <div id="content-wrapper" class="left-column col-xs-12 col-sm-12 col-md-8 col-lg-9 col-xl-9">
                    {block name='breadcrumb'}
                    {include file='_partials/breadcrumb.tpl'}
                  {/block}
                  <div class="row">
                      <div class="col-xl-8">
                        {block name='cart_summary'}
                          {render file='checkout/checkout-process.tpl' ui=$checkout_process}
                        {/block}
                      </div>
                      <div class="col-xl-4">

                        {block name='cart_summary'}
                          {include file='checkout/_partials/cart-summary.tpl' cart = $cart}
                        {/block}
                        {block name='hook_reassurance'}
                          {hook h='displayReassurance'}
                        {/block}
                      </div>
                  </div>
              </div>
          </div>
        </section>
      {/block}
      </div>
    </section>

    <footer id="footer">
      {block name='footer'}
        {include file='checkout/_partials/footer.tpl'}
      {/block}
    </footer>
</main>
    {block name='javascript_bottom'}
      {include file="_partials/javascript.tpl" javascript=$javascript.bottom}
    {/block}

    {block name='hook_before_body_closing_tag'}
      {hook h='displayBeforeBodyClosingTag'}
    {/block}

  </body>

</html>
