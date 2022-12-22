<?php
/* Smarty version 3.1.43, created on 2022-12-22 00:18:07
  from 'C:\wamp64\www\prestadefault\modules\wbproductcountdown\views\templates\hook\header.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.43',
  'unifunc' => 'content_63a3e88f53b695_10390003',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '94c5f39a83c68b052ada43548ac70e7260abf3ba' => 
    array (
      0 => 'C:\\wamp64\\www\\prestadefault\\modules\\wbproductcountdown\\views\\templates\\hook\\header.tpl',
      1 => 1671685648,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_63a3e88f53b695_10390003 (Smarty_Internal_Template $_smarty_tpl) {
?><!-- module wbproductcountdown start -->
<?php echo '<script'; ?>
 type="text/javascript">
    <?php if ($_smarty_tpl->tpl_vars['show_weeks']->value) {?>
        var wbpc_labels = ['weeks', 'days', 'hours', 'minutes', 'seconds'];
        var wbpc_labels_lang = {
            'weeks': '<?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'weeks','mod'=>'wbproductcountdown'),$_smarty_tpl ) );?>
',
            'days': '<?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'days','mod'=>'wbproductcountdown'),$_smarty_tpl ) );?>
',
            'hours': '<?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'hours','mod'=>'wbproductcountdown'),$_smarty_tpl ) );?>
',
            'minutes': '<?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'minutes','mod'=>'wbproductcountdown'),$_smarty_tpl ) );?>
',
            'seconds': '<?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'seconds','mod'=>'wbproductcountdown'),$_smarty_tpl ) );?>
'
        };
    <?php } else { ?>
    var wbpc_labels = ['days', 'hours', 'minutes', 'seconds'];
    var wbpc_labels_lang = {
        'days': '<?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'days','mod'=>'wbproductcountdown'),$_smarty_tpl ) );?>
',
        'hours': '<?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'hours','mod'=>'wbproductcountdown'),$_smarty_tpl ) );?>
',
        'minutes': '<?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'minutes','mod'=>'wbproductcountdown'),$_smarty_tpl ) );?>
',
        'seconds': '<?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'seconds','mod'=>'wbproductcountdown'),$_smarty_tpl ) );?>
'
    };
    <?php }?>
    var wbpc_show_weeks = <?php echo htmlspecialchars(intval($_smarty_tpl->tpl_vars['show_weeks']->value), ENT_QUOTES, 'UTF-8');?>
;
    var wbpc_wbv = <?php echo htmlspecialchars(floatval($_smarty_tpl->tpl_vars['wbv']->value), ENT_QUOTES, 'UTF-8');?>
;
<?php echo '</script'; ?>
>
<?php if ($_smarty_tpl->tpl_vars['custom_css']->value) {?>
    <style type="text/css">
        <?php echo htmlspecialchars(call_user_func_array($_smarty_tpl->registered_plugins[ 'modifier' ][ 'escape' ][ 0 ], array( $_smarty_tpl->tpl_vars['custom_css']->value,'quotes','UTF-8' )), ENT_QUOTES, 'UTF-8');?>

    </style>
<?php }?>
<!-- module wbproductcountdown end --><?php }
}
