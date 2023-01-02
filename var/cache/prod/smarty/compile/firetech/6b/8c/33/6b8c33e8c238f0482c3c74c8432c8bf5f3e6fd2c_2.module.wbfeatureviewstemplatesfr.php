<?php
/* Smarty version 3.1.43, created on 2023-01-02 05:05:45
  from 'module:wbfeatureviewstemplatesfr' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.43',
  'unifunc' => 'content_63b2ac79f364f5_25909013',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '6b8c33e8c238f0482c3c74c8432c8bf5f3e6fd2c' => 
    array (
      0 => 'module:wbfeatureviewstemplatesfr',
      1 => 1671695907,
      2 => 'module',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_63b2ac79f364f5_25909013 (Smarty_Internal_Template $_smarty_tpl) {
?><div class="wb-notification" style="width: <?php echo htmlspecialchars($_smarty_tpl->tpl_vars['width_notification']->value, ENT_QUOTES, 'UTF-8');?>
px; <?php echo htmlspecialchars($_smarty_tpl->tpl_vars['vertical_position']->value, ENT_QUOTES, 'UTF-8');?>
; <?php echo htmlspecialchars($_smarty_tpl->tpl_vars['horizontal_position']->value, ENT_QUOTES, 'UTF-8');?>
">
</div>
<div class="wb-temp wb-temp-success">
	<div class="notification-wrapper">
		<div class="notification notification-success">
						<strong class="noti product-name"></strong>
			<span class="noti noti-update"><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'The product has been updated in your shopping cart','mod'=>'wbfeature'),$_smarty_tpl ) );?>
</span>
			<span class="noti noti-delete"><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'The product has been removed from your shopping cart','mod'=>'wbfeature'),$_smarty_tpl ) );?>
</span>
			<span class="noti noti-add"><strong class="noti-special"></strong> <?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Product successfully added to your shopping cart','mod'=>'wbfeature'),$_smarty_tpl ) );?>
</span>
			<span class="notification-close float-xs-right">X</span>
			
		</div>
	</div>
</div>
<div class="wb-temp wb-temp-error">
	<div class="notification-wrapper">
		<div class="notification notification-error">
						
			<span class="noti noti-update"><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Error updating','mod'=>'wbfeature'),$_smarty_tpl ) );?>
</span>
			<span class="noti noti-delete"><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Error deleting','mod'=>'wbfeature'),$_smarty_tpl ) );?>
</span>
			<span class="noti noti-add"><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Error adding. Please go to product detail page and try again','mod'=>'wbfeature'),$_smarty_tpl ) );?>
</span>
			
			<span class="notification-close">X</span>
			
		</div>
	</div>
</div>
<div class="wb-temp wb-temp-warning">
	<div class="notification-wrapper">
		<div class="notification notification-warning">
						<span class="noti noti-min"><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'The minimum purchase order quantity for the product is','mod'=>'wbfeature'),$_smarty_tpl ) );?>
 <strong class="noti-special"></strong></span>
			<span class="noti noti-max"><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'There are not enough products in stock','mod'=>'wbfeature'),$_smarty_tpl ) );?>
</span>
			
			<span class="notification-close">X</span>
			
		</div>
	</div>
</div>
<div class="wb-temp wb-temp-normal">
	<div class="notification-wrapper">
		<div class="notification notification-normal">
						<span class="noti noti-check"><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'You must enter a quantity','mod'=>'wbfeature'),$_smarty_tpl ) );?>
</span>
			
			<span class="notification-close">X</span>
			
		</div>
	</div>
</div>
<?php }
}
