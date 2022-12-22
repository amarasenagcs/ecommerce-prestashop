<?php
/* Smarty version 3.1.43, created on 2022-12-22 00:18:13
  from 'module:pscontactinfopscontactinf' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.43',
  'unifunc' => 'content_63a3e8957c8626_05701375',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '9992f3fe04dd41bcec1a2029cf07bead637caf4d' => 
    array (
      0 => 'module:pscontactinfopscontactinf',
      1 => 1671685651,
      2 => 'module',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_63a3e8957c8626_05701375 (Smarty_Internal_Template $_smarty_tpl) {
?>
<div class="block-contact col-sm-12 col-md-3  col-lg-3 links wrapper">
<h4 class="hidden-sm-down c-info"><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'contact us','d'=>'Shop.Theme.Catalog'),$_smarty_tpl ) );?>
</h4>
<div class="title clearfix hidden-md-up" data-toggle="collapse" data-target="#footer_contact">
    <span class="h3"><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'contact us','d'=>'Shop.Theme.Catalog'),$_smarty_tpl ) );?>
</span>
   <span class="float-xs-right">
          <span class="navbar-toggler collapse-icons text-xs-right">
            <i class="fa fa-plus add"></i>
            <i class="fa fa-minus remove"></i>
          </span>
  </span>
  </div>
  <ul id="footer_contact" class="fthr collapse c-map">
  <li class="block">
    <div class="icon"><i class="fa fa-map-marker"></i></div>
    <div class="data ad"><?php echo $_smarty_tpl->tpl_vars['contact_infos']->value['address']['formatted'];?>
</div>
  </li>

  <?php if ($_smarty_tpl->tpl_vars['contact_infos']->value['phone']) {?>
    <li class="block">
      <div class="icon"><i class="fa fa-phone"></i></div>
      <div class="data">
        <a href="tel:<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['contact_infos']->value['phone'], ENT_QUOTES, 'UTF-8');?>
"><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['contact_infos']->value['phone'], ENT_QUOTES, 'UTF-8');?>
</a>
       </div>
    </li>
  <?php }?>

  <?php if ($_smarty_tpl->tpl_vars['contact_infos']->value['fax']) {?>
    <li class="block">
      <div class="icon"><i class="fa fa-fax"></i></div>
      <div class="data">
             <?php echo htmlspecialchars($_smarty_tpl->tpl_vars['contact_infos']->value['fax'], ENT_QUOTES, 'UTF-8');?>

      </div>
    </li>
  <?php }?>
  <?php if ($_smarty_tpl->tpl_vars['contact_infos']->value['email']) {?>
    <li class="block">
      <div class="icon"><i class="fa fa-envelope"></i></div>
      <div class="data email">
      <a href="mailto:<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['contact_infos']->value['email'], ENT_QUOTES, 'UTF-8');?>
"><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['contact_infos']->value['email'], ENT_QUOTES, 'UTF-8');?>
</a>
       </div>
    </li>
  <?php }?>
</ul>
</div><?php }
}
