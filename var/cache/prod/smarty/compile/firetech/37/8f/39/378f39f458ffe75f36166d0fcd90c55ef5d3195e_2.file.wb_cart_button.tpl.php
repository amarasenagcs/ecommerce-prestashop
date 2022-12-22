<?php
/* Smarty version 3.1.43, created on 2022-12-22 00:18:08
  from 'C:\wamp64\www\prestadefault\modules\wbfeature\views\templates\hook\wb_cart_button.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.43',
  'unifunc' => 'content_63a3e8904610f5_79783314',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '378f39f458ffe75f36166d0fcd90c55ef5d3195e' => 
    array (
      0 => 'C:\\wamp64\\www\\prestadefault\\modules\\wbfeature\\views\\templates\\hook\\wb_cart_button.tpl',
      1 => 1671685647,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_63a3e8904610f5_79783314 (Smarty_Internal_Template $_smarty_tpl) {
?>
<div class="button-container cart add-cart">
	<form action="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['link_cart']->value, ENT_QUOTES, 'UTF-8');?>
" method="post">
		<input type="hidden" name="token" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['static_token']->value, ENT_QUOTES, 'UTF-8');?>
">
		<input type="hidden" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['wb_cart_product']->value['quantity'], ENT_QUOTES, 'UTF-8');?>
" class="quantity_product quantity_product_<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['wb_cart_product']->value['id_product'], ENT_QUOTES, 'UTF-8');?>
" name="quantity_product">
		<input type="hidden" value="<?php if ((isset($_smarty_tpl->tpl_vars['wb_cart_product']->value['product_attribute_minimal_quantity'])) && $_smarty_tpl->tpl_vars['wb_cart_product']->value['product_attribute_minimal_quantity'] > $_smarty_tpl->tpl_vars['wb_cart_product']->value['minimal_quantity']) {
echo htmlspecialchars($_smarty_tpl->tpl_vars['wb_cart_product']->value['product_attribute_minimal_quantity'], ENT_QUOTES, 'UTF-8');
} else {
echo htmlspecialchars($_smarty_tpl->tpl_vars['wb_cart_product']->value['minimal_quantity'], ENT_QUOTES, 'UTF-8');
}?>" class="minimal_quantity minimal_quantity_<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['wb_cart_product']->value['id_product'], ENT_QUOTES, 'UTF-8');?>
" name="minimal_quantity">
		<input type="hidden" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['wb_cart_product']->value['id_product_attribute'], ENT_QUOTES, 'UTF-8');?>
" class="id_product_attribute id_product_attribute_<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['wb_cart_product']->value['id_product'], ENT_QUOTES, 'UTF-8');?>
" name="id_product_attribute">
		<input type="hidden" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['wb_cart_product']->value['id_product'], ENT_QUOTES, 'UTF-8');?>
" class="id_product" name="id_product">
		<input type="hidden" name="id_customization" value="<?php if ($_smarty_tpl->tpl_vars['wb_cart_product']->value['id_customization']) {
echo htmlspecialchars($_smarty_tpl->tpl_vars['wb_cart_product']->value['id_customization'], ENT_QUOTES, 'UTF-8');
}?>" class="product_customization_id">
			
		<input type="hidden" class="input-group form-control qty qty_product qty_product_<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['wb_cart_product']->value['id_product'], ENT_QUOTES, 'UTF-8');?>
" name="qty" value="<?php if ((isset($_smarty_tpl->tpl_vars['wb_cart_product']->value['wishlist_quantity']))) {
echo htmlspecialchars($_smarty_tpl->tpl_vars['wb_cart_product']->value['wishlist_quantity'], ENT_QUOTES, 'UTF-8');
} else {
if ($_smarty_tpl->tpl_vars['wb_cart_product']->value['product_attribute_minimal_quantity'] && $_smarty_tpl->tpl_vars['wb_cart_product']->value['product_attribute_minimal_quantity'] > $_smarty_tpl->tpl_vars['wb_cart_product']->value['minimal_quantity']) {
echo htmlspecialchars($_smarty_tpl->tpl_vars['wb_cart_product']->value['product_attribute_minimal_quantity'], ENT_QUOTES, 'UTF-8');
} else {
echo htmlspecialchars($_smarty_tpl->tpl_vars['wb_cart_product']->value['minimal_quantity'], ENT_QUOTES, 'UTF-8');
}
}?>" data-min="<?php if ($_smarty_tpl->tpl_vars['wb_cart_product']->value['product_attribute_minimal_quantity'] && $_smarty_tpl->tpl_vars['wb_cart_product']->value['product_attribute_minimal_quantity'] > $_smarty_tpl->tpl_vars['wb_cart_product']->value['minimal_quantity']) {
echo htmlspecialchars($_smarty_tpl->tpl_vars['wb_cart_product']->value['product_attribute_minimal_quantity'], ENT_QUOTES, 'UTF-8');
} else {
echo htmlspecialchars($_smarty_tpl->tpl_vars['wb_cart_product']->value['minimal_quantity'], ENT_QUOTES, 'UTF-8');
}?>">
		  <button class="cartb  btn-product add-to-cart wb-bt-cart wb-bt-cart_<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['wb_cart_product']->value['id_product'], ENT_QUOTES, 'UTF-8');
if (!$_smarty_tpl->tpl_vars['wb_cart_product']->value['add_to_cart_url']) {?> disabled<?php }?>" data-button-action="add-to-cart" type="submit">
									 <svg width="18px" height="18px"><use xlink:href="#bcart" /></svg><span class="pcart"><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'add to cart','mod'=>'wbfeature'),$_smarty_tpl ) );?>
</span>
		  </button>
	</form>
</div>

<?php }
}
