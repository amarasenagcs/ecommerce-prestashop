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
<div class="wbproductcountdown buttons_bottom_block wbpc-inactive" data-to="{$countdown.to_time|escape:'html':'UTF-8'}">
	
    <div class="wbpc-main days-diff-{$days_diff|intval} weeks-diff-{$weeks_diff|intval} {if $weeks_diff == 0 && $hide_zero_weeks}hide_zero_weeks{/if}">
        {if $countdown.name}<h4>{$countdown.name|escape:'html':'UTF-8'}</h4>{/if}
    </div>
    <input type="hidden" class="wbpc-checker">
</div>