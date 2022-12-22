<?php
/* Smarty version 3.1.43, created on 2022-12-22 00:18:07
  from 'module:wbimagesliderviewstemplat' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.43',
  'unifunc' => 'content_63a3e88f762ad1_52415232',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'c3553de397ee6bb692576ba5d522289df29260ab' => 
    array (
      0 => 'module:wbimagesliderviewstemplat',
      1 => 1671685647,
      2 => 'module',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_63a3e88f762ad1_52415232 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->compiled->nocache_hash = '3946104663a3e88f738474_88057891';
if ($_smarty_tpl->tpl_vars['wbslider']->value['slides']) {?>
  <div class="homeslider-container slideshow-panel slider-wrapper theme-default" data-interval="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['wbslider']->value['speed'], ENT_QUOTES, 'UTF-8');?>
" data-wrap="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['wbslider']->value['wrap'], ENT_QUOTES, 'UTF-8');?>
" data-pause="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['wbslider']->value['pause'], ENT_QUOTES, 'UTF-8');?>
">
    <div id="slider" class="nivoSlider">
      <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['wbslider']->value['slides'], 'slide');
$_smarty_tpl->tpl_vars['slide']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['slide']->value) {
$_smarty_tpl->tpl_vars['slide']->do_else = false;
?>
          <a href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['slide']->value['url'], ENT_QUOTES, 'UTF-8');?>
">
            <img src="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['slide']->value['image_url'], ENT_QUOTES, 'UTF-8');?>
" data-thumb="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['slide']->value['image_url'], ENT_QUOTES, 'UTF-8');?>
" alt="" />
          </a>
      <?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
    </div>
   </div>
<?php }
}
}
