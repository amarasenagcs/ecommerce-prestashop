<?php
/* Smarty version 3.1.43, created on 2023-01-02 04:27:30
  from 'C:\wamp64\www\prestadefault\modules\wbfeature\views\templates\hook\wb_compare_headlink.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.43',
  'unifunc' => 'content_63b2a382b86e45_19018686',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '9e2cc75d66be914787f5871e329210571d17bcec' => 
    array (
      0 => 'C:\\wamp64\\www\\prestadefault\\modules\\wbfeature\\views\\templates\\hook\\wb_compare_headlink.tpl',
      1 => 1671695907,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_63b2a382b86e45_19018686 (Smarty_Internal_Template $_smarty_tpl) {
?><div class="hcom">
<a id="compare-link" href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['productcompare_url']->value, ENT_QUOTES, 'UTF-8');?>
">
<span class="wcom"><svg width="16px" height="16px"> <use xlink:href="#hcom"></use></svg> <?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'compare','mod'=>'wbfeature'),$_smarty_tpl ) );?>
</span>
</a>
</div><?php }
}
