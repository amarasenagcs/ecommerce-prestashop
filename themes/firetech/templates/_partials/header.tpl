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
{block name='header_banner'}
  <div class="header-banner">
    {hook h='displayBanner'}
  </div>
{/block}

{block name='header_nav'}
  <nav class="header-nav">
    <div class="container">
        <div class="row">
          <div class="hidden-sm-down">
            <div class="col-lg-6 col-md-7 col-sm-6 col-xs-12 displaynav1 hidden-sm-down">
              {hook h='displayNav1'}
            </div>
            <div class="col-lg-6 col-md-5 col-sm-6 right-nav text-xs-right">
                {hook h='displayWbNav2'}
                {hook h='displayNav2'}
            </div>
          </div>
          <div class="hidden-md-up  mobile col-xs-12">
            {* <div class="float-xs-left" id="menu-icon">
              <i class="material-icons d-inline">&#xE5D2;</i>
            </div> *}
            {* mobile *}
             <div id="mobile_top_menu_wrapper" class="d-inline-block float-xs-left" style="display:none;">
              <div class="js-top-menu-bottom">
                {* menu *}
                  <div id="menu-icon" class=" xstop">              
                    <div class="navbar-header">              
                        <button type="button" class="btn-navbar navbar-toggle" data-toggle="collapse" onclick="openNav()" >
                        <i class="fa fa-bars"></i></button>
                    </div>
                    <div id="mySidenav" class="sidenav">
                    <div class="close-nav">
                        <span class="categories">{l s='Category' d='Shop.Theme.Catalog'}</span>
                        <a href="javascript:void(0)" class="closebtn float-xs-right" onclick="closeNav()"><i class="fa fa-close"></i></a>
                    </div>
                    <div id="mobile_top_menu_wrapper" class="row">
                        <div id="_mobile_currency_selector" class="d-inline-block f1"></div>
                        <div id="_mobile_language_selector" class="d-inline-block f1"></div>
                        <div class="js-top-menu mobile" id="_mobile_top_menu"></div>                        
                        <div id="_mobile_contact_link"></div>
                    </div>
                 </div>
              </div>
              </div>
          </div>    
            <div class="top-logo d-inline-block float-xs-left" id="_mobile_logo"></div>
            <div class="float-xs-right mobile-right">
              <div class="d-inline-block" id="_mobile_user_info"></div> 
              <div  class="d-inline-block " id="mbl-cart"></div> 
            </div>                      
            <div class="clearfix"></div>
            <div class="row">
               <div class="" id="_mobile_search"></div>  
            </div>      
             {* mobile end *}
          </div>
          
        </div>
    </div>
  </nav>
{/block}
{block name='header_top'}
  <div class="header-top  hidden-sm-down">
    <div class="container">
       <div class="row">
        <div class="col-lg-3 col-md-3 hidden-sm-down" id="_desktop_logo">
          <a href="{$urls.base_url}">
            <img class="logo img-responsive" src="{$shop.logo}" alt="{$shop.name}">
          </a>
        </div>
        <div class="col-lg-9 col-md-9 col-sm-12 position-static text-xs-right right-top">
            {hook h='displayTop'}
            <div class="clearfix"></div>        
        </div>
      </div>
       {hook h='displayNavFullWidth'}
    </div>
  </div>

{/block}
