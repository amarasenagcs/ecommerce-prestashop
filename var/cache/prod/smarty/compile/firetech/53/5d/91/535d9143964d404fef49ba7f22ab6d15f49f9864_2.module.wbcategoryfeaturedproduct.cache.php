<?php
/* Smarty version 3.1.43, created on 2022-12-22 00:18:09
  from 'module:wbcategoryfeaturedproduct' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.43',
  'unifunc' => 'content_63a3e891cc3596_47275078',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '535d9143964d404fef49ba7f22ab6d15f49f9864' => 
    array (
      0 => 'module:wbcategoryfeaturedproduct',
      1 => 1671685646,
      2 => 'module',
    ),
  ),
  'includes' => 
  array (
    'file:catalog/_partials/miniatures/product.tpl' => 1,
  ),
),false)) {
function content_63a3e891cc3596_47275078 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->compiled->nocache_hash = '30090765663a3e891cb6e66_66662829';
?>
<div class="categoryfeaturedproducts fea-best-tabs">
	     
            <div class="home-heading"><span><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'special products','mod'=>'wbcategoryfeature'),$_smarty_tpl ) );?>
</span></div>          
      
  <div id="spe_product" class="owl-carousel owl-theme">
  	
      <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['products']->value, 'product');
$_smarty_tpl->tpl_vars['product']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['product']->value) {
$_smarty_tpl->tpl_vars['product']->do_else = false;
?>
        <?php $_smarty_tpl->_subTemplateRender("file:catalog/_partials/miniatures/product.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 9999, $_smarty_tpl->cache_lifetime, array('product'=>$_smarty_tpl->tpl_vars['product']->value), 0, true);
?>
      <?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
    
    </div>
</div><?php }
}
