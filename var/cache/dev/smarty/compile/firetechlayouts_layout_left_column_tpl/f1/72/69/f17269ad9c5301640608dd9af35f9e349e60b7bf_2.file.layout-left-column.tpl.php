<?php
/* Smarty version 3.1.43, created on 2023-01-02 04:27:28
  from 'C:\wamp64\www\prestadefault\themes\firetech\templates\layouts\layout-left-column.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.43',
  'unifunc' => 'content_63b2a380e6cf62_31318110',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'f17269ad9c5301640608dd9af35f9e349e60b7bf' => 
    array (
      0 => 'C:\\wamp64\\www\\prestadefault\\themes\\firetech\\templates\\layouts\\layout-left-column.tpl',
      1 => 1671695918,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:_partials/breadcrumb.tpl' => 1,
  ),
),false)) {
function content_63b2a380e6cf62_31318110 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_loadInheritance();
$_smarty_tpl->inheritance->init($_smarty_tpl, true);
?>


<?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_29206435563b2a380e36324_40391549', 'right_column');
?>


<?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_146633596963b2a380e38e78_14393873', 'content_wrapper');
?>

<?php $_smarty_tpl->inheritance->endChild($_smarty_tpl, 'layouts/layout-both-columns.tpl');
}
/* {block 'right_column'} */
class Block_29206435563b2a380e36324_40391549 extends Smarty_Internal_Block
{
public $subBlocks = array (
  'right_column' => 
  array (
    0 => 'Block_29206435563b2a380e36324_40391549',
  ),
);
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
}
}
/* {/block 'right_column'} */
/* {block 'breadcrumb'} */
class Block_111720467063b2a380e3ad47_69900933 extends Smarty_Internal_Block
{
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>

            <?php $_smarty_tpl->_subTemplateRender('file:_partials/breadcrumb.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>
          <?php
}
}
/* {/block 'breadcrumb'} */
/* {block 'content'} */
class Block_135490620063b2a380e5e385_93918568 extends Smarty_Internal_Block
{
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>

      <p>Hello world! This is HTML5 Boilerplate.</p>
    <?php
}
}
/* {/block 'content'} */
/* {block 'content_wrapper'} */
class Block_146633596963b2a380e38e78_14393873 extends Smarty_Internal_Block
{
public $subBlocks = array (
  'content_wrapper' => 
  array (
    0 => 'Block_146633596963b2a380e38e78_14393873',
  ),
  'breadcrumb' => 
  array (
    0 => 'Block_111720467063b2a380e3ad47_69900933',
  ),
  'content' => 
  array (
    0 => 'Block_135490620063b2a380e5e385_93918568',
  ),
);
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>

  <div id="content-wrapper" class="left-column col-xs-12 col-sm-12 col-md-8 col-lg-9">
  	 <?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_111720467063b2a380e3ad47_69900933', 'breadcrumb', $this->tplIndex);
?>

    <?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['hook'][0], array( array('h'=>"displayContentWrapperTop"),$_smarty_tpl ) );?>

    <?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_135490620063b2a380e5e385_93918568', 'content', $this->tplIndex);
?>

    <?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['hook'][0], array( array('h'=>"displayContentWrapperBottom"),$_smarty_tpl ) );?>

  </div>
<?php
}
}
/* {/block 'content_wrapper'} */
}
