<?php
/* Smarty version 3.1.43, created on 2022-12-22 00:18:08
  from 'C:\wamp64\www\prestadefault\modules\wbfeature\views\templates\hook\wb_wishlist_button.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.43',
  'unifunc' => 'content_63a3e8905f1d05_64049592',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '114448aeb639294185c5c94a166a944b3f92ad88' => 
    array (
      0 => 'C:\\wamp64\\www\\prestadefault\\modules\\wbfeature\\views\\templates\\hook\\wb_wishlist_button.tpl',
      1 => 1671685647,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_63a3e8905f1d05_64049592 (Smarty_Internal_Template $_smarty_tpl) {
?><div class="wishlist">	
		<a class="wish wb-wishlist-button btn-product btn<?php if ($_smarty_tpl->tpl_vars['added_wishlist']->value) {?> added<?php }?>" href="javascript:void(0)" data-id-wishlist="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['id_wishlist']->value, ENT_QUOTES, 'UTF-8');?>
" data-id-product="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['wb_wishlist_id_product']->value, ENT_QUOTES, 'UTF-8');?>
" data-id-product-attribute="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['wb_wishlist_id_product_attribute']->value, ENT_QUOTES, 'UTF-8');?>
" title="<?php if ($_smarty_tpl->tpl_vars['added_wishlist']->value) {
echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Remove from Wishlist','mod'=>'wbfeature'),$_smarty_tpl ) );
} else {
echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Add to Wishlist','mod'=>'wbfeature'),$_smarty_tpl ) );
}?>">
									<span class="pwish">
                    <svg width="18px" height="18px"><use xlink:href="#heart" /></svg>
            </span>
		</a>	
</div><?php }
}
