<?php
/* Smarty version 3.1.43, created on 2023-01-02 04:27:34
  from 'module:wbfeatureviewstemplatesfr' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.43',
  'unifunc' => 'content_63b2a38607f984_24328381',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '9298a49ad71ac901a3ecc0f1992622f79cc87373' => 
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
function content_63b2a38607f984_24328381 (Smarty_Internal_Template $_smarty_tpl) {
?><!-- begin C:\wamp64\www\prestadefault/modules/wbfeature/views/templates/front/modal.tpl --><div class="modal wb-modal wb-modal-cart fade" tabindex="-1" role="dialog" aria-hidden="true">
	<!--
	<div class="vertical-alignment-helper">
	-->
	  <div class="modal-dialog" role="document">
		<div class="modal-content">
		  <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close">
			  <span aria-hidden="true">&times;</span>
			</button>
			<h4 class="modal-title h6 text-xs-center wb-warning wb-alert">
				<i class="material-icons">info_outline</i>				
				<?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'You must enter a quantity','mod'=>'wbfeature'),$_smarty_tpl ) );?>
		
			</h4>
			
			<h4 class="modal-title h6 text-xs-center wb-info wb-alert">
				<i class="material-icons">info_outline</i>				
				<?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'The minimum purchase order quantity for the product is ','mod'=>'wbfeature'),$_smarty_tpl ) );?>
<strong class="alert-min-qty"></strong>		
			</h4>	
			
			<h4 class="modal-title h6 text-xs-center wb-block wb-alert">				
				<i class="material-icons">block</i>				
				<?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'There are not enough products in stock','mod'=>'wbfeature'),$_smarty_tpl ) );?>

			</h4>
		  </div>
		  <!--
		  <div class="modal-body">
			...
		  </div>
		  <div class="modal-footer">
			
			<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
			<button type="button" class="btn btn-primary">Save changes</button>
			
		  </div>
		  -->
		</div>
	  </div>
	<!--
	</div>
	-->
</div><!-- end C:\wamp64\www\prestadefault/modules/wbfeature/views/templates/front/modal.tpl --><?php }
}
