<?php
/* Smarty version 3.1.43, created on 2022-12-22 00:18:10
  from 'C:\wamp64\www\prestadefault\themes\firetech\templates\index.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.43',
  'unifunc' => 'content_63a3e8920506e6_17515141',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '38c7f57f73e0d01f17d9f589f71b526f58d12f52' => 
    array (
      0 => 'C:\\wamp64\\www\\prestadefault\\themes\\firetech\\templates\\index.tpl',
      1 => 1671685652,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_63a3e8920506e6_17515141 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_loadInheritance();
$_smarty_tpl->inheritance->init($_smarty_tpl, true);
?>


    <?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_97087061563a3e8920410d0_15028079', 'page_content_container');
?>

<?php $_smarty_tpl->inheritance->endChild($_smarty_tpl, 'page.tpl');
}
/* {block 'page_content_top'} */
class Block_206831345063a3e892042e19_45600894 extends Smarty_Internal_Block
{
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
}
}
/* {/block 'page_content_top'} */
/* {block 'hook_home'} */
class Block_94907117663a3e8920474c8_48236512 extends Smarty_Internal_Block
{
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>

            <?php echo $_smarty_tpl->tpl_vars['HOOK_HOME']->value;?>

          <?php
}
}
/* {/block 'hook_home'} */
/* {block 'page_content'} */
class Block_183113517063a3e8920458f8_78934345 extends Smarty_Internal_Block
{
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>

          <?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_94907117663a3e8920474c8_48236512', 'hook_home', $this->tplIndex);
?>

        <?php
}
}
/* {/block 'page_content'} */
/* {block 'page_content_container'} */
class Block_97087061563a3e8920410d0_15028079 extends Smarty_Internal_Block
{
public $subBlocks = array (
  'page_content_container' => 
  array (
    0 => 'Block_97087061563a3e8920410d0_15028079',
  ),
  'page_content_top' => 
  array (
    0 => 'Block_206831345063a3e892042e19_45600894',
  ),
  'page_content' => 
  array (
    0 => 'Block_183113517063a3e8920458f8_78934345',
  ),
  'hook_home' => 
  array (
    0 => 'Block_94907117663a3e8920474c8_48236512',
  ),
);
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>

      <section id="content" class="page-home">
        <?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_206831345063a3e892042e19_45600894', 'page_content_top', $this->tplIndex);
?>


        <?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_183113517063a3e8920458f8_78934345', 'page_content', $this->tplIndex);
?>

      </section>
    <?php
}
}
/* {/block 'page_content_container'} */
}
