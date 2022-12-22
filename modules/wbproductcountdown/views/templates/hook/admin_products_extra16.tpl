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
<div id="wbproductcountdown" class="panel product-tab">
    <input type="hidden" name="submitted_tabs[]" value="{$module_name|escape:'html':'UTF-8'}" />
    <input type="hidden" name="{$module_name|escape:'html':'UTF-8'}-submit" value="1" />
    <h3>{l s='Countdown' mod='wbproductcountdown'}</h3>

    <div class="form-group">
        <div class="col-lg-1"><span class="pull-right"></span></div>
        <label class="control-label col-lg-2">
            <span class="label-tooltip" data-toggle="tooltip" title="" data-original-title="{l s='Set to NO if you want to completely disable countdown for this product.'  mod='wbproductcountdown'}">
				 {l s='Enabled:' mod='wbproductcountdown'}
			</span>
        </label>
        <div class="col-lg-5">
            <span class="switch prestashop-switch fixed-width-lg">
				<input onclick="toggleDraftWarning(false);showOptions(true);showRedirectProductOptions(false);" type="radio" name="wbpc_active" id="wbpc_active_on" value="1" {if isset($countdown_data.active) && $countdown_data.active}checked{/if}>
				<label for="wbpc_active_on" class="radioCheck">
                    {l s='Yes' mod='wbproductcountdown'}
                </label>
				<input onclick="toggleDraftWarning(true);showOptions(false);showRedirectProductOptions(true);" type="radio" name="wbpc_active" id="wbpc_active_off" value="0"{if !isset($countdown_data.active) || (isset($countdown_data.active) && !$countdown_data.active)}checked{/if}>
				<label for="wbpc_active_off" class="radioCheck">
                    {l s='No' mod='wbproductcountdown'}
                </label>
				<a class="slide-button btn"></a>
			</span>
        </div>
    </div>

    <div class="form-group">
        <div class="col-lg-1"><span class="pull-right"></span></div>
        <label class="control-label col-lg-2">
            {l s='Name:' mod='wbproductcountdown'}
        </label>
        <div class="col-lg-5">
            {foreach from=$languages item=language name=wbpc_lang_foreach}
                {if $languages|count > 1}
                    <div class="translatable-field row lang-{$language.id_lang|intval}" {if !$smarty.foreach.wbpc_lang_foreach.first}style="display: none;" {/if}>
                    <div class="col-lg-9">
                {/if}
                <input type="text"
                       id="wbpc_name_{$language.id_lang|intval}"
                       class="form-control"
                       name="wbpc_name_{$language.id_lang|intval}"
                       value="{if isset($countdown_data['name'][$language.id_lang])}{$countdown_data['name'][$language.id_lang]|escape:'html':'UTF-8'}{/if}"
                       />
                {if $languages|count > 1}
                    </div>
                    <div class="col-lg-2">
                        <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" tabindex="-1">
                            {$language.iso_code|escape:'html':'UTF-8'}
                            <span class="caret"></span>
                        </button>
                        <ul class="dropdown-menu">
                            {foreach from=$languages item=lang}
                                <li>
                                    <a href="javascript:tabs_manager.allow_hide_other_languages = false;hideOtherLanguage({$lang.id_lang|intval});">{$lang.name|escape:'html':'UTF-8'}</a>
                                </li>
                            {/foreach}
                        </ul>
                    </div>
                    </div>
                {/if}
            {/foreach}
        </div>
    </div>

    <div class="form-group">
        <div class="col-lg-1"><span class="pull-right"></span></div>

        <label class="control-label col-lg-2">
             {l s='Display:' mod='wbproductcountdown'}
        </label>
        <div class="col-lg-5">
            <div class="row">
                <div class="col-lg-6">
                    <div class="input-group">
                        <span class="input-group-addon">{l s='from' mod='wbproductcountdown'}</span>
                        <input type="text" name="wbpc_from" class="wbpc-datepicker test" value="{if isset($countdown_data.from)}{$countdown_data.from|escape:'html':'UTF-8'}{/if}" style="text-align: center;" id="wbpc_from">
                        <span class="input-group-addon"><i class="icon-calendar-empty"></i></span>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="input-group">
                        <span class="input-group-addon">{l s='to' mod='wbproductcountdown'}</span>
                        <input type="text" name="wbpc_to" class="wbpc-datepicker" value="{if isset($countdown_data.to)}{$countdown_data.to|escape:'html':'UTF-8'}{/if}" style="text-align: center;" id="wbpc_to">
                        <span class="input-group-addon"><i class="icon-calendar-empty"></i></span>
                    </div>
                </div>
                <script type="text/javascript">
                    $(function () {
                        $(".wbpc-datepicker").datetimepicker({
                            prevText: '',
                            nextText: '',
                            dateFormat: 'yy-mm-dd',
                            // Define a custom regional settings in order to use PrestaShop translation tools
                            currentText: '{l s='Now' js=1 mod='wbproductcountdown'}',
                            closeText: '{l s='Done' js=1 mod='wbproductcountdown'}',
                            ampm: false,
                            amNames: ['AM', 'A'],
                            pmNames: ['PM', 'P'],
                            timeFormat: 'hh:mm:ss tt',
                            timeSuffix: '',
                            timeOnlyTitle: '{l s='Choose Time' js=1 mod='wbproductcountdown'}',
                            timeText: '{l s='Time' js=1 mod='wbproductcountdown'}',
                            hourText: '{l s='Hour' js=1 mod='wbproductcountdown'}',
                            minuteText: '{l s='Minute' js=1 mod='wbproductcountdown'}'
                        });
                    });
                </script>
            </div>
        </div>
    </div>

    <div class="form-group">
        <div class="col-lg-1"><span class="pull-right"></span></div>
        <label class="control-label col-lg-2">
            {l s='Use dates from specific prices:' mod='wbproductcountdown'}
        </label>
        <div class="col-lg-5">
            <select name="wbpc_specific_price" id="wbpc_specific_price">
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
    </div>

    {if isset($countdown_data.id_countdown)}
        <div class="form-group">
            <div class="col-lg-1"><span class="pull-right"></span></div>
            <div class="control-label col-lg-2"></div>
            <div class="col-lg-5">
                <button type="button" id="wbpc-reset-countdown" class="btn btn-default" data-id-countdown="{$countdown_data.id_countdown|intval}">{l s='Reset & remove' mod='wbproductcountdown'}</button>
            </div>
        </div>
    {/if}

    {if $wbv > 1.5}
        <div class="panel-footer">
            <a href="{$link->getAdminLink('AdminProducts')|escape:'html':'UTF-8'}" class="btn btn-default"><i class="process-icon-cancel"></i> {l s='Cancel' mod='wbproductcountdown'}</a>
            <button type="submit" name="submitAddproduct" class="btn btn-default pull-right"><i class="process-icon-save"></i> {l s='Save' mod='wbproductcountdown'}</button>
            <button type="submit" name="submitAddproductAndStay" class="btn btn-default pull-right"><i class="process-icon-save"></i> {l s='Save and stay' mod='wbproductcountdown'}</button>
        </div>
    {/if}
    <script type="text/javascript">
        var wbpc_ajax_url = "{$ajax_url|escape:'quotes':'UTF-8'}";
    </script>
</div>
