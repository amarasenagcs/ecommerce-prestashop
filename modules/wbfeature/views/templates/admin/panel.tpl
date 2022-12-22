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
{* <div class="panel form-horizontal">
	<div class="form-group">					
		<div class="col-lg-1">
			<a class="megamenu-correct-module btn btn-success" href="{$url_admin}&success=correct&correctmodule=1">
				<i class="icon-AdminParentPreferences"></i>{l s='Correct module' mod='wbfeature'}
			</a>
		</div>
		<label class="control-label col-lg-3">* {l s='Please backup the database before run correct module to safe' mod='wbfeature'}</label>							
	</div>
</div> *}

<div id="wbfeature-group">

	<div class="panel panel-default">
		<div class="panel-heading"><i class="icon-cogs"></i> {l s='Wb Feature Global Config' mod='wbfeature'}</div>
		
		<div class="panel-content" id="wbfeature-setting">
			<ul class="nav nav-tabs wbfeature-tablist" role="tablist">
				<li class="nav-item{if $default_tab == '#fieldset_0'} active{/if}">
					<a class="nav-link" href="#fieldset_0" role="tab" data-toggle="tab">{l s='Ajax Cart' mod='wbfeature'}</a>
				</li>
				<li class="nav-item{if $default_tab == '#fieldset_1_1'} active{/if}">
					<a class="nav-link" href="#fieldset_1_1" role="tab" data-toggle="tab">{l s='Product Review' mod='wbfeature'}</a>
				</li>
				<li class="nav-item{if $default_tab == '#fieldset_2_2'} active{/if}">
					<a class="nav-link" href="#fieldset_2_2" role="tab" data-toggle="tab">{l s='Product Compare' mod='wbfeature'}</a>
				</li>
				<li class="nav-item{if $default_tab == '#fieldset_3_3'} active{/if}">
					<a class="nav-link" href="#fieldset_3_3" role="tab" data-toggle="tab">{l s='Product Wishlist' mod='wbfeature'}</a>
				</li>
				
			</ul>
			<div class="tab-content">
				{$globalform}{* HTML form , no escape necessary *}
			</div>
		</div>	

	</div>
		
</div>