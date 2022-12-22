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
<div id="module_wbproductcountdown" class="">
    <input type="hidden" name="submitted_tabs[]" value="{$module_name|escape:'html':'UTF-8'}" />
    <input type="hidden" name="{$module_name|escape:'html':'UTF-8'}-submit" value="1" />

    <div class="row">
        <div class="col-lg-12 col-xl-4">
            <fieldset class="form-group">
                <label class="form-control-label">{l s='Enabled:' mod='wbproductcountdown'}</label>
                <div id="wbpc_active">
                    <div class="radio">
                        <label class="">
                            <input type="radio" id="wbpc_active_1" name="wbpc_active" value="1" {if isset($countdown_data.active) && $countdown_data.active}checked{/if}>
                            {l s='Yes' mod='wbproductcountdown'}
                        </label>
                        &nbsp;&nbsp;&nbsp;&nbsp;
                        <label class="">
                            <input type="radio" id="wbpc_active_0" name="wbpc_active" value="0" {if !isset($countdown_data.active) || (isset($countdown_data.active) && !$countdown_data.active)}checked{/if}>
                            {l s='No' mod='wbproductcountdown'}
                        </label>
                    </div>
                </div>
            </fieldset>
        </div>
        <div class="col-lg-12 col-xl-4">
            <fieldset class="form-group">
                <label class="form-control-label">{l s='Name:' mod='wbproductcountdown'}</label>
                <div class="translations tabbable" id="wbpc_name_wrp">
                    <div class="translationsFields tab-content ">
                        {foreach from=$languages item=language name=wbpc_lang_foreach}
                            <div class="translationsFields-wbpc_name tab-pane translation-label-{$language.iso_code|escape:'html':'UTF-8'} {if $smarty.foreach.wbpc_lang_foreach.first}active{/if}">
                                <input type="text"
                                       id="wbpc_name_{$language.id_lang|intval}"
                                       name="wbpc_name_{$language.id_lang|intval}"
                                       class="form-control"
                                       value="{if isset($countdown_data['name'][$language.id_lang])}{$countdown_data['name'][$language.id_lang]|escape:'html':'UTF-8'}{/if}"
                                />
                            </div>
                        {/foreach}
                    </div>
                </div>
            </fieldset>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12 col-xl-4">
            <fieldset class="form-group">
                <label class="form-control-label">{l s='Display:' mod='wbproductcountdown'}</label>

                <div class="row">
                    <div class="col-lg-6">
                        <div class="input-group">
                            <span class="input-group-addon">{l s='from' mod='wbproductcountdown'}</span>
                            <input type="text" name="wbpc_from" class="wbpc-datepicker form-control" value="{if isset($countdown_data.from)}{$countdown_data.from|escape:'html':'UTF-8'}{/if}" style="text-align: center;" id="wbpc_from">
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="input-group">
                            <span class="input-group-addon">{l s='to' mod='wbproductcountdown'}</span>
                            <input type="text" name="wbpc_to" class="wbpc-datepicker form-control" value="{if isset($countdown_data.to)}{$countdown_data.to|escape:'html':'UTF-8'}{/if}" style="text-align: center;" id="wbpc_to">
                        </div>
                    </div>
                </div>
                <script type="text/javascript">
                    $(function () {
                        $(".wbpc-datepicker").datetimepicker({
                            sideBySide: true,
                            format: 'YYYY-MM-DD HH:mm:ss',
                            useCurrent: false
                        });
                    });
                </script>
            </fieldset>
        </div>
        <div class="col-lg-12 col-xl-4">
            <fieldset class="form-group">
                <label class="form-control-label">{l s='Use dates from specific prices:' mod='wbproductcountdown'}</label>
                <div id="wbpc_specific_price_wrp">
                    <select name="wbpc_specific_price" id="wbpc_specific_price" class="form-control">
                        <option value="">--</option>
                        {foreach from=$specific_prices item=specific_price}
                            <option value="{$specific_price.id_specific_price|intval}"
                                    data-from="{$specific_price.from|escape:'html':'UTF-8'}"
                                    data-to="{$specific_price.to|escape:'html':'UTF-8'}">
                                {l s='from' mod='wbproductcountdown'}: {$specific_price.from|escape:'html':'UTF-8'}&nbsp;&nbsp;&nbsp;
                                {l s='to' mod='wbproductcountdown'}: {$specific_price.to|escape:'html':'UTF-8'}
                            </option>
                        {/foreach}
                    </select>
                </div>
            </fieldset>
        </div>
    </div>

    {if isset($countdown_data.id_countdown)}
        <div class="form-group">
            <div class="row">
                <div class="col-lg-12 col-xl-4">
                    <fieldset class="form-group">
                        <div>
                            <button type="button" id="wbpc-reset-countdown" class="btn btn-default" data-id-countdown="{$countdown_data.id_countdown|intval}">{l s='Reset & remove' mod='wbproductcountdown'}</button>
                        </div>
                    </fieldset>
                </div>
            </div>
        </div>
    {/if}

    <script type="text/javascript">
        var wbpc_ajax_url = "{$ajax_url|escape:'quotes':'UTF-8'}";
    </script>
</div>
