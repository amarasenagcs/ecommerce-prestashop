<?php
/* Smarty version 3.1.43, created on 2022-12-22 00:18:12
  from 'module:wbblogviewstemplatesfront' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.43',
  'unifunc' => 'content_63a3e894e1bfd5_73142829',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '782fb14174261522df9e7583ef1273bf096534ef' => 
    array (
      0 => 'module:wbblogviewstemplatesfront',
      1 => 1671685646,
      2 => 'module',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_63a3e894e1bfd5_73142829 (Smarty_Internal_Template $_smarty_tpl) {
?><div class="post_format_items <?php if ((isset($_smarty_tpl->tpl_vars['class']->value)) && $_smarty_tpl->tpl_vars['class']->value) {
echo htmlspecialchars($_smarty_tpl->tpl_vars['class']->value, ENT_QUOTES, 'UTF-8');
}?>">
	<?php if (((isset($_smarty_tpl->tpl_vars['videos']->value)) && !empty($_smarty_tpl->tpl_vars['videos']->value))) {?>
		<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['videos']->value, 'videourl');
$_smarty_tpl->tpl_vars['videourl']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['videourl']->value) {
$_smarty_tpl->tpl_vars['videourl']->do_else = false;
?>
			<div class="item post_video">
				<div class="embed-responsive embed-responsive-16by9">
					<iframe class="embed-responsive-item" src="<?php if ((isset($_smarty_tpl->tpl_vars['videourl']->value)) && $_smarty_tpl->tpl_vars['videourl']->value) {
echo htmlspecialchars($_smarty_tpl->tpl_vars['videourl']->value, ENT_QUOTES, 'UTF-8');
}?>" width="<?php if ((isset($_smarty_tpl->tpl_vars['width']->value)) && $_smarty_tpl->tpl_vars['width']->value) {
echo htmlspecialchars($_smarty_tpl->tpl_vars['width']->value, ENT_QUOTES, 'UTF-8');
}?>" height="<?php if ((isset($_smarty_tpl->tpl_vars['height']->value)) && $_smarty_tpl->tpl_vars['height']->value) {
echo htmlspecialchars($_smarty_tpl->tpl_vars['height']->value, ENT_QUOTES, 'UTF-8');
}?>"></iframe>
				</div>
			</div>
		<?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
	<?php }?>
</div><?php }
}
