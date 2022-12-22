<?php
/* Smarty version 3.1.43, created on 2022-12-22 00:18:07
  from 'module:psfeaturedproductsviewste' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.43',
  'unifunc' => 'content_63a3e88fc819c4_82541995',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'fa6cc378d2942c8857b89d6bca728048c0caeedd' => 
    array (
      0 => 'module:psfeaturedproductsviewste',
      1 => 1671685652,
      2 => 'module',
    ),
  ),
  'includes' => 
  array (
    'file:catalog/_partials/miniatures/product.tpl' => 2,
  ),
),false)) {
function content_63a3e88fc819c4_82541995 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->compiled->nocache_hash = '128655660663a3e88fc48521_63497295';
?>
<div class="fea-best-tabs fea-tab-1">    
    <div class="pro-tab tabs">
            <div class="home-heading float-xs-left"><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'treding product','d'=>'Shop.Theme.Catalog'),$_smarty_tpl ) );?>
</div>
           
            <ul class="list-inline nav nav-tabs text-xs-right">
                <li class="nav-item">
                    <a class="nav-link active" href="#tab-featured-0" data-toggle="tab" ><span><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Featured','d'=>'Shop.Theme.Catalog'),$_smarty_tpl ) );?>
</span></a>
                </li>
                <span class="tab-indicator">|</span>
                <li class="nav-item">
                    <a class="nav-link " href="#tab-new-0" data-toggle="tab"><span><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'new','d'=>'Shop.Theme.Catalog'),$_smarty_tpl ) );?>
</span></a>
                </li> 
                <span class="tab-indicator">|</span> 
                 <li class="nav-item">
                    <a class="nav-link " href="#tab-best-0" data-toggle="tab"><span><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'bestsellers','d'=>'Shop.Theme.Catalog'),$_smarty_tpl ) );?>
</span></a>
                </li>  

            </ul>
        </div>
<div id="tab-content" class="tab-content ">
<section class="featured-products tab-pane clearfix active" id="tab-featured-0">
  <div id="owl-fea" class="owl-carousel owl-theme">
 <?php $_smarty_tpl->_assignInScope('num_row', 2);?> <!-- Number of Row Ex 2,3,4,5....etc-->
    <?php $_smarty_tpl->_assignInScope('i', 0);?>
    <?php if (count($_smarty_tpl->tpl_vars['products']->value) <= 6) {?>
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
    <?php } else { ?>
      <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['products']->value, 'product');
$_smarty_tpl->tpl_vars['product']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['product']->value) {
$_smarty_tpl->tpl_vars['product']->do_else = false;
?>
        <?php if ($_smarty_tpl->tpl_vars['i']->value == 0) {?>
          <ul>
            <li>
        <?php }?>
              <?php $_smarty_tpl->_subTemplateRender("file:catalog/_partials/miniatures/product.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 9999, $_smarty_tpl->cache_lifetime, array('product'=>$_smarty_tpl->tpl_vars['product']->value), 0, true);
?>
              <?php $_smarty_tpl->_assignInScope('i', $_smarty_tpl->tpl_vars['i']->value+1);?>
        <?php if ($_smarty_tpl->tpl_vars['i']->value == $_smarty_tpl->tpl_vars['num_row']->value) {?>
            </li>
          </ul>
          <?php $_smarty_tpl->_assignInScope('i', 0);?>
        <?php }?>
      <?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
    <?php }?>
    </div>
</section>
<?php }
}
