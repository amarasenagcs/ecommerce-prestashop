<?php
/* Smarty version 3.1.43, created on 2022-12-22 00:18:10
  from 'C:\wamp64\www\prestadefault\themes\firetech\templates\page.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.43',
  'unifunc' => 'content_63a3e89218e105_66711709',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'e145959b94c5b3d1e88c0fd5a2b5ac29655d41aa' => 
    array (
      0 => 'C:\\wamp64\\www\\prestadefault\\themes\\firetech\\templates\\page.tpl',
      1 => 1671685652,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_63a3e89218e105_66711709 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_loadInheritance();
$_smarty_tpl->inheritance->init($_smarty_tpl, true);
?>


<?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_118019289363a3e8921754b2_40052553', 'content');
?>

<?php $_smarty_tpl->inheritance->endChild($_smarty_tpl, $_smarty_tpl->tpl_vars['layout']->value);
}
/* {block 'page_title'} */
class Block_14446197363a3e892178f79_88055100 extends Smarty_Internal_Block
{
public $callsChild = 'true';
public $hide = 'true';
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>

        <header class="page-header">
          <h1 class="bh text-xs-center"><?php 
$_smarty_tpl->inheritance->callChild($_smarty_tpl, $this);
?>
</h1>
        </header>
      <?php
}
}
/* {/block 'page_title'} */
/* {block 'page_header_container'} */
class Block_6339068463a3e892176ee1_36129230 extends Smarty_Internal_Block
{
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>

      <?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_14446197363a3e892178f79_88055100', 'page_title', $this->tplIndex);
?>

    <?php
}
}
/* {/block 'page_header_container'} */
/* {block 'page_content_top'} */
class Block_9093118463a3e892182480_13362184 extends Smarty_Internal_Block
{
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
}
}
/* {/block 'page_content_top'} */
/* {block 'page_content'} */
class Block_115989527563a3e8921849f2_84670044 extends Smarty_Internal_Block
{
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>

          <!-- Page content -->
        <?php
}
}
/* {/block 'page_content'} */
/* {block 'page_content_container'} */
class Block_22686723463a3e892180ac0_53421307 extends Smarty_Internal_Block
{
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>

      <section id="content" class="page-content card card-block">
        <?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_9093118463a3e892182480_13362184', 'page_content_top', $this->tplIndex);
?>

        <?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_115989527563a3e8921849f2_84670044', 'page_content', $this->tplIndex);
?>

      </section>
    <?php
}
}
/* {/block 'page_content_container'} */
/* {block 'page_footer'} */
class Block_141847693463a3e892189da1_39189711 extends Smarty_Internal_Block
{
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>

          <!-- Footer content -->
        <?php
}
}
/* {/block 'page_footer'} */
/* {block 'page_footer_container'} */
class Block_168732655863a3e892188472_30002633 extends Smarty_Internal_Block
{
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>

      <footer class="page-footer">
        <?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_141847693463a3e892189da1_39189711', 'page_footer', $this->tplIndex);
?>

      </footer>
    <?php
}
}
/* {/block 'page_footer_container'} */
/* {block 'content'} */
class Block_118019289363a3e8921754b2_40052553 extends Smarty_Internal_Block
{
public $subBlocks = array (
  'content' => 
  array (
    0 => 'Block_118019289363a3e8921754b2_40052553',
  ),
  'page_header_container' => 
  array (
    0 => 'Block_6339068463a3e892176ee1_36129230',
  ),
  'page_title' => 
  array (
    0 => 'Block_14446197363a3e892178f79_88055100',
  ),
  'page_content_container' => 
  array (
    0 => 'Block_22686723463a3e892180ac0_53421307',
  ),
  'page_content_top' => 
  array (
    0 => 'Block_9093118463a3e892182480_13362184',
  ),
  'page_content' => 
  array (
    0 => 'Block_115989527563a3e8921849f2_84670044',
  ),
  'page_footer_container' => 
  array (
    0 => 'Block_168732655863a3e892188472_30002633',
  ),
  'page_footer' => 
  array (
    0 => 'Block_141847693463a3e892189da1_39189711',
  ),
);
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>


  <section id="main">

    <?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_6339068463a3e892176ee1_36129230', 'page_header_container', $this->tplIndex);
?>


    <?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_22686723463a3e892180ac0_53421307', 'page_content_container', $this->tplIndex);
?>


    <?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_168732655863a3e892188472_30002633', 'page_footer_container', $this->tplIndex);
?>


  </section>

<?php
}
}
/* {/block 'content'} */
}
