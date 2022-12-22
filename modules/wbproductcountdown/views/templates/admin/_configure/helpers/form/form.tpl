{**
* NOTICE OF LICENSE
*
* This file is licenced under the Software License Agreement.
* With the purchase or the installation of the software in your application
* you accept the licence agreement.
*
* @author    Presta.Site
* @copyright 2015 Presta.Site
* @license   LICENSE.txt
*}

{extends file="helpers/form/form.tpl"}
{block name="field"}
	{if $input.type == 'theme'}
		<div class="col-lg-{if isset($input.col)}{$input.col|intval}{else}9{/if}{if !isset($input.label)} col-lg-offset-3{/if} themes-wrp-{$wbvd|escape:'html':'UTF-8'}">
			{foreach $input.values as $value}
				<div class="col-lg-4 col-md-4 col-xs-6 theme-item {if isset($input.class)}{$input.class|escape:'html':'UTF-8'}{/if}">
					{strip}
						<label>
							<input type="radio"	name="{$input.name|escape:'html':'UTF-8'}" id="theme-{$value.label|escape:'html':'UTF-8'}" value="{$value.value|escape:'html':'UTF-8'}"{if $fields_value[$input.name] == $value.value} checked="checked"{/if}{if isset($input.disabled) && $input.disabled} disabled="disabled"{/if}/>
							<img class="theme-img" src="{$value.img|escape:'html':'UTF-8'}" alt="{$value.label|escape:'html':'UTF-8'}">
						</label>
					{/strip}
				</div>
				{if isset($value.p) && $value.p}<p class="help-block">{$value.p|escape:'html':'UTF-8'}</p>{/if}
			{/foreach}
		</div>
	{else}
		{$smarty.block.parent}
	{/if}
{/block}
