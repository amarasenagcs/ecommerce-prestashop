<?php
/* Smarty version 3.1.43, created on 2022-12-22 00:18:13
  from 'module:wblogosliderviewstemplate' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.43',
  'unifunc' => 'content_63a3e8954ae5c1_81062519',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '37705ede3a2dfe1821713da65b2891d368a6b9b6' => 
    array (
      0 => 'module:wblogosliderviewstemplate',
      1 => 1671685647,
      2 => 'module',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_63a3e8954ae5c1_81062519 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->compiled->nocache_hash = '201245156863a3e895495fc7_99501757';
?>
<div class="container logos">
  <div class="home-heading"><span><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'our brands','mod'=>'wblogoslider'),$_smarty_tpl ) );?>
</span></div>  

<?php if ($_smarty_tpl->tpl_vars['logoslider']->value['slides']) {?>
  <div class="logo-slider" data-interval="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['logoslider']->value['speed'], ENT_QUOTES, 'UTF-8');?>
" data-wrap="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['logoslider']->value['wrap'], ENT_QUOTES, 'UTF-8');?>
" data-pause="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['logoslider']->value['pause'], ENT_QUOTES, 'UTF-8');?>
">
    <ul id="owl-logo" class="rslide owl-carousel owl-theme">
      <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['logoslider']->value['slides'], 'slide');
$_smarty_tpl->tpl_vars['slide']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['slide']->value) {
$_smarty_tpl->tpl_vars['slide']->do_else = false;
?>
        <li class="lslide">
          <a href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['slide']->value['url'], ENT_QUOTES, 'UTF-8');?>
">
            <img src="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['slide']->value['image_url'], ENT_QUOTES, 'UTF-8');?>
" alt="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['slide']->value['legend'], ENT_QUOTES, 'UTF-8');?>
"  class="img-responsive center-block"/>
          </a>
        </li>
      <?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
    </ul>
    </div>
<?php }?>

</div><?php }
}
