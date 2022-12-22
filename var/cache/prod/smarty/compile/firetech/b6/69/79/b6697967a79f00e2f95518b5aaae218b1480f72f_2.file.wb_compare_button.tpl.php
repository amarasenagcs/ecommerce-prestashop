<?php
/* Smarty version 3.1.43, created on 2022-12-22 00:18:08
  from 'C:\wamp64\www\prestadefault\modules\wbfeature\views\templates\hook\wb_compare_button.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.43',
  'unifunc' => 'content_63a3e8906c6898_54427455',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'b6697967a79f00e2f95518b5aaae218b1480f72f' => 
    array (
      0 => 'C:\\wamp64\\www\\prestadefault\\modules\\wbfeature\\views\\templates\\hook\\wb_compare_button.tpl',
      1 => 1671685647,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_63a3e8906c6898_54427455 (Smarty_Internal_Template $_smarty_tpl) {
?><div class="compare">
	<a class="wb-compare-button btn-product btn<?php if ($_smarty_tpl->tpl_vars['added']->value) {?> added<?php }?>" href="javascript:void(0)" data-id-product="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['wb_compare_id_product']->value, ENT_QUOTES, 'UTF-8');?>
" title="<?php if ($_smarty_tpl->tpl_vars['added']->value) {
echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Remove from Compare','mod'=>'wbfeature'),$_smarty_tpl ) );
} else {
echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Add to Compare','mod'=>'wbfeature'),$_smarty_tpl ) );
}?>">
				<span class="wb-compare-content">
			<svg width="17px" height="17px"><use xlink:href="#compare" /></svg>
			<span><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Add to Compare','mod'=>'wbfeature'),$_smarty_tpl ) );?>
</span>
		</span>
	</a>
</div><?php }
}
