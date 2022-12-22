{**
* NOTICE OF LICENSE
*
* This file is licenced under the Software License Agreement.
* With the purchase or the installation of the software in your application
* you accept the licence agreement.
*
* @author    Presta.Site
* @copyright 2016 Presta.Site
* @license   LICENSE.txt
*}
<div id="wbpc-countdowns-list">
    {if $wbv == 1.5}
        <br/><fieldset><legend>{l s='Countdown list' mod='wbproductcountdown'}</legend>
    {else}
    <div class="panel">
        <div class="panel-heading">
            <i class="icon-cogs"></i> {l s='Countdown list' mod='wbproductcountdown'}
        </div>
    {/if}
        <p><i>{l s='List of manually added countdown timers (not from specific prices)' mod='wbproductcountdown'}</i>. {l s='"Inactive" status means that countdown is expired or not started yet.' mod='wbproductcountdown'}</p>
        <div class="form-wrapper">
            <div class="form-group">
                <div class="table-responsive-row">
                    <table class="table">
                        <thead>
                        <tr>
                            <th>{l s='Product' mod='wbproductcountdown'}</th>
                            <th>{l s='Name' mod='wbproductcountdown'}</th>
                            <th>{l s='From' mod='wbproductcountdown'}</th>
                            <th>{l s='To' mod='wbproductcountdown'}</th>
                            <th>{l s='State' mod='wbproductcountdown'}</th>
                            <th>{l s='Actions' mod='wbproductcountdown'}</th>
                        </tr>
                        </thead>
                        <tbody>
                        {foreach from=$countdowns item=countdown}
                            <tr>
                                <td>#{$countdown.id_product|intval} {$countdown.product_name|escape:'html':'UTF-8'}</td>
                                <td>{$countdown.name|escape:'html':'UTF-8'}</td>
                                <td>{$countdown.from|escape:'html':'UTF-8'}</td>
                                <td>{$countdown.to|escape:'html':'UTF-8'}</td>
                                <td>
                                    {if !$countdown.expired}
                                        {if $countdown.active}
                                            <span class="label label-success">{l s='Enabled' mod='wbproductcountdown'}</span>
                                        {else}
                                            <span class="label label-danger">{l s='Disabled' mod='wbproductcountdown'}</span>
                                        {/if}
                                    {else}
                                        <span class="label label-default">{l s='Inactive' mod='wbproductcountdown'}</span>
                                    {/if}
                                </td>
                                <td>
                                    {* Edit btn *}
                                    {if $wbv < 1.7}
                                        <a href="{$link->getAdminLink('AdminProducts')|escape:'html':'UTF-8'}&id_product={$countdown.id_product|intval}&updateproduct&key_tab={$key_tab|escape:'html':'UTF-8'}"
                                           title="{l s='Edit' mod='wbproductcountdown'}" class="edit btn btn-default" target="_blank">
                                            <i class="icon-pencil"></i>\
                                        </a>
                                    {else}
                                        <a href="{$link->getAdminLink('AdminProducts', true, ['id_product' => $countdown.id_product])|escape:'html':'UTF-8'}#tab-hooks"
                                           title="{l s='Edit' mod='wbproductcountdown'}" class="edit btn btn-default" target="_blank">
                                            <i class="icon-pencil"></i>\
                                        </a>
                                    {/if}
                                    &nbsp;&nbsp;&nbsp;&nbsp;
                                    {* Remove btn *}
                                    <a href="#" title="{l s='Remove' mod='wbproductcountdown'}" class="edit btn btn-default remove-countdown" data-id-countdown="{$countdown.id_countdown|intval}">
                                        <i class="icon-remove"></i>
                                    </a>
                                </td>
                            </tr>
                        {/foreach}
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    {if $wbv == 1.5}
        </fieldset><br/>
    {else}
        </div>
    {/if}

    <script type="text/javascript">
        var wbpc_ajax_url = "{$ajax_url|escape:'quotes':'UTF-8'}";
        var wbpc_remove_confirm_txt = "{l s='Are you sure you want to delete this countdown?' mod='wbproductcountdown'}";
    </script>
</div>
