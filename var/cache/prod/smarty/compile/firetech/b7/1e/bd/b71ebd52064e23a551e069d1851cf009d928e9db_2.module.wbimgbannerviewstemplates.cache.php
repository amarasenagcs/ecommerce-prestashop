<?php
/* Smarty version 3.1.43, created on 2022-12-22 00:18:09
  from 'module:wbimgbannerviewstemplates' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.43',
  'unifunc' => 'content_63a3e891acd7c5_33297659',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'b71ebd52064e23a551e069d1851cf009d928e9db' => 
    array (
      0 => 'module:wbimgbannerviewstemplates',
      1 => 1671685647,
      2 => 'module',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_63a3e891acd7c5_33297659 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->compiled->nocache_hash = '109393962463a3e891ab9a97_19264497';
?>

    <?php if ($_smarty_tpl->tpl_vars['imgbanner']->value['slides']) {?>
      <div class="iamge-banner" data-wrap="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['imgbanner']->value['wrap'], ENT_QUOTES, 'UTF-8');?>
">
          <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['imgbanner']->value['slides'], 'slide');
$_smarty_tpl->tpl_vars['slide']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['slide']->value) {
$_smarty_tpl->tpl_vars['slide']->do_else = false;
?>
            <div class="ser-banner">
            	<div class="sub-img-banner">
    		          <a href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['slide']->value['url'], ENT_QUOTES, 'UTF-8');?>
">
    		              <img src="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['slide']->value['image_url'], ENT_QUOTES, 'UTF-8');?>
" alt="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['slide']->value['legend'], ENT_QUOTES, 'UTF-8');?>
"  class="img-responsive center-block b-radius"/>
                      <div class="hover-border">
                        <div class="leftTop"></div>
                        <div class="rightTop"></div>
                        <div class="leftBot"></div>
                        <div class="rightBot"></div>
                      </div>
    		          </a>
    		     </div>
            </div>
          <?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>

      </div>
    <?php }
}
}
