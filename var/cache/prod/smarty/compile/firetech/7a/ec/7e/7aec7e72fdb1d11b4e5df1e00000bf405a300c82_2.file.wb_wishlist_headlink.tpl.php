<?php
/* Smarty version 3.1.43, created on 2022-12-22 00:18:11
  from 'C:\wamp64\www\prestadefault\modules\wbfeature\views\templates\hook\wb_wishlist_headlink.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.43',
  'unifunc' => 'content_63a3e8936ede32_16972786',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '7aec7e72fdb1d11b4e5df1e00000bf405a300c82' => 
    array (
      0 => 'C:\\wamp64\\www\\prestadefault\\modules\\wbfeature\\views\\templates\\hook\\wb_wishlist_headlink.tpl',
      1 => 1671685647,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_63a3e8936ede32_16972786 (Smarty_Internal_Template $_smarty_tpl) {
?><div class="wishl d-inline-block">
    <a id="headlink" href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['wishlist_link']->value, ENT_QUOTES, 'UTF-8');?>
">
		<span class="wimg f1"><svg width="13px" height="14px" class="hidden-md-up"> <use xlink:href="#hwish"></use> </svg>
		<?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Wishlist','mod'=>'wbfeature'),$_smarty_tpl ) );?>

		</span>
    </a>
</div><?php }
}
