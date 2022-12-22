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
<!-- module wbproductcountdown start -->
<script type="text/javascript">
    {if $show_weeks}
        var wbpc_labels = ['weeks', 'days', 'hours', 'minutes', 'seconds'];
        var wbpc_labels_lang = {
            'weeks': '{l s='weeks' mod='wbproductcountdown'}',
            'days': '{l s='days' mod='wbproductcountdown'}',
            'hours': '{l s='hours' mod='wbproductcountdown'}',
            'minutes': '{l s='minutes' mod='wbproductcountdown'}',
            'seconds': '{l s='seconds' mod='wbproductcountdown'}'
        };
    {else}
    var wbpc_labels = ['days', 'hours', 'minutes', 'seconds'];
    var wbpc_labels_lang = {
        'days': '{l s='days' mod='wbproductcountdown'}',
        'hours': '{l s='hours' mod='wbproductcountdown'}',
        'minutes': '{l s='minutes' mod='wbproductcountdown'}',
        'seconds': '{l s='seconds' mod='wbproductcountdown'}'
    };
    {/if}
    var wbpc_show_weeks = {$show_weeks|intval};
    var wbpc_wbv = {$wbv|floatval};
</script>
{if $custom_css}
    <style type="text/css">
        {$custom_css|escape:'quotes':'UTF-8'}
    </style>
{/if}
<!-- module wbproductcountdown end -->