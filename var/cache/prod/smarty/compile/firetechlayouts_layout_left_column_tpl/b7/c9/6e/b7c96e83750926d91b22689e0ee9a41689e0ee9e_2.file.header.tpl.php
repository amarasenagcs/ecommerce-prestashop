<?php
/* Smarty version 3.1.43, created on 2023-01-02 05:05:43
  from 'C:\wamp64\www\prestadefault\themes\firetech\templates\_partials\header.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.43',
  'unifunc' => 'content_63b2ac77ae0495_84909193',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'b7c96e83750926d91b22689e0ee9a41689e0ee9e' => 
    array (
      0 => 'C:\\wamp64\\www\\prestadefault\\themes\\firetech\\templates\\_partials\\header.tpl',
      1 => 1671695918,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_63b2ac77ae0495_84909193 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_loadInheritance();
$_smarty_tpl->inheritance->init($_smarty_tpl, false);
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_165642742963b2ac77ac5bc7_37785122', 'header_banner');
?>


<?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_20380539863b2ac77aca266_15898534', 'header_nav');
?>

<?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_54545323463b2ac77ad4d48_59357146', 'header_top');
?>

<?php }
/* {block 'header_banner'} */
class Block_165642742963b2ac77ac5bc7_37785122 extends Smarty_Internal_Block
{
public $subBlocks = array (
  'header_banner' => 
  array (
    0 => 'Block_165642742963b2ac77ac5bc7_37785122',
  ),
);
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>

  <div class="header-banner">
    <?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['hook'][0], array( array('h'=>'displayBanner'),$_smarty_tpl ) );?>

  </div>
<?php
}
}
/* {/block 'header_banner'} */
/* {block 'header_nav'} */
class Block_20380539863b2ac77aca266_15898534 extends Smarty_Internal_Block
{
public $subBlocks = array (
  'header_nav' => 
  array (
    0 => 'Block_20380539863b2ac77aca266_15898534',
  ),
);
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>

  <nav class="header-nav">
    <div class="container">
        <div class="row">
          <div class="hidden-sm-down">
            <div class="col-lg-6 col-md-7 col-sm-6 col-xs-12 displaynav1 hidden-sm-down">
              <?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['hook'][0], array( array('h'=>'displayNav1'),$_smarty_tpl ) );?>

            </div>
            <div class="col-lg-6 col-md-5 col-sm-6 right-nav text-xs-right">
                <?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['hook'][0], array( array('h'=>'displayWbNav2'),$_smarty_tpl ) );?>

                <?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['hook'][0], array( array('h'=>'displayNav2'),$_smarty_tpl ) );?>

            </div>
          </div>
          <div class="hidden-md-up  mobile col-xs-12">
                                     <div id="mobile_top_menu_wrapper" class="d-inline-block float-xs-left" style="display:none;">
              <div class="js-top-menu-bottom">
                                  <div id="menu-icon" class=" xstop">              
                    <div class="navbar-header">              
                        <button type="button" class="btn-navbar navbar-toggle" data-toggle="collapse" onclick="openNav()" >
                        <i class="fa fa-bars"></i></button>
                    </div>
                    <div id="mySidenav" class="sidenav">
                    <div class="close-nav">
                        <span class="categories"><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Category','d'=>'Shop.Theme.Catalog'),$_smarty_tpl ) );?>
</span>
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
                       </div>
          
        </div>
    </div>
  </nav>
<?php
}
}
/* {/block 'header_nav'} */
/* {block 'header_top'} */
class Block_54545323463b2ac77ad4d48_59357146 extends Smarty_Internal_Block
{
public $subBlocks = array (
  'header_top' => 
  array (
    0 => 'Block_54545323463b2ac77ad4d48_59357146',
  ),
);
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>

  <div class="header-top  hidden-sm-down">
    <div class="container">
       <div class="row">
        <div class="col-lg-3 col-md-3 hidden-sm-down" id="_desktop_logo">
          <a href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['urls']->value['base_url'], ENT_QUOTES, 'UTF-8');?>
">
            <img class="logo img-responsive" src="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['shop']->value['logo'], ENT_QUOTES, 'UTF-8');?>
" alt="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['shop']->value['name'], ENT_QUOTES, 'UTF-8');?>
">
          </a>
        </div>
        <div class="col-lg-9 col-md-9 col-sm-12 position-static text-xs-right right-top">
            <?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['hook'][0], array( array('h'=>'displayTop'),$_smarty_tpl ) );?>

            <div class="clearfix"></div>        
        </div>
      </div>
       <?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['hook'][0], array( array('h'=>'displayNavFullWidth'),$_smarty_tpl ) );?>

    </div>
  </div>

<?php
}
}
/* {/block 'header_top'} */
}
