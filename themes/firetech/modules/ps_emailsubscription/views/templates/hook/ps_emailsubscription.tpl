{**
 * 2007-2018 PrestaShop
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
 * @copyright 2007-2018 PrestaShop SA
 * @license   https://opensource.org/licenses/AFL-3.0 Academic Free License 3.0 (AFL-3.0)
 * International Registered Trademark & Property of PrestaShop SA
 *}

<div class="col-md-3 col-sm-12 col-xs-12 block_newsletter">
  <div class="bestlc">
      <h2 class="text-uppercase">{l s='newsletter' d='Shop.Theme.Catalog'}</h2> 
      <h5>{l s='Send Us a Message The Industrys Stan Dard My.' d='Shop.Theme.Catalog'}</h5>
  </div>
  <div class=" bestrc">
      <form action="{$urls.pages.index}#footer" method="post">
             <div class="input-wrapper">
              <input
                name="email"
                type="text"
                value="{$value}"
                placeholder="{l s='Enter Your Email......' d='Shop.Forms.Labels'}"
                aria-labelledby="block-newsletter-label"
              >
            </div>
            <input
              class="btn ebtn  hidden-xs-down text-uppercase f1"
              name="submitNewsletter"
              type="submit"
              value="{l s='subscribe' d='Shop.Theme.Actions'}"
            >
            <input
              class="btn ebtn  hidden-sm-up text-uppercase f1"
              name="submitNewsletter"
              type="submit"
              value="{l s='send' d='Shop.Theme.Actions'}"
            >           
            <input type="hidden" name="action" value="0">
            <div class="clearfix"></div>
              {if $msg}
                <p class="alert {if $nw_error}alert-danger{else}alert-success{/if}">
                  {$msg}
                </p>
              {/if}
      </form>
    </div>
</div>