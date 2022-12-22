<?php
/* Smarty version 3.1.43, created on 2022-12-22 00:18:13
  from 'C:\wamp64\www\prestadefault\themes\firetech\templates\_partials\footer.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.43',
  'unifunc' => 'content_63a3e895649475_42038257',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'c8361cef35e313a15acb32bb5e31f9cc46e6b155' => 
    array (
      0 => 'C:\\wamp64\\www\\prestadefault\\themes\\firetech\\templates\\_partials\\footer.tpl',
      1 => 1671685652,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_63a3e895649475_42038257 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_loadInheritance();
$_smarty_tpl->inheritance->init($_smarty_tpl, false);
?>
<div class="footer-container">
  <div class="container">
      <div class="row foot-top" >
        <?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_25607414463a3e895633404_62635285', 'hook_footer');
?>

      </div>
    </div>
     <div class="container">
         <div class="foot-last">                
             
                <div class="foot-link text-xs-center">
                  <?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_168791059963a3e8956382f7_95186239', 'copyright_link');
?>

                </div>
                <?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_199038263763a3e895645355_04859650', 'hook_footer_down');
?>

        </div>
    </div>
</div>

<a href="" id="scroll" title="Scroll to Top" style="display: block;"><svg width="40px" height="40px"><use xlink:href="#gototop"></use></svg></a><?php }
/* {block 'hook_footer'} */
class Block_25607414463a3e895633404_62635285 extends Smarty_Internal_Block
{
public $subBlocks = array (
  'hook_footer' => 
  array (
    0 => 'Block_25607414463a3e895633404_62635285',
  ),
);
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>

          <?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['hook'][0], array( array('h'=>'displayFooter'),$_smarty_tpl ) );?>

        <?php
}
}
/* {/block 'hook_footer'} */
/* {block 'copyright_link'} */
class Block_168791059963a3e8956382f7_95186239 extends Smarty_Internal_Block
{
public $subBlocks = array (
  'copyright_link' => 
  array (
    0 => 'Block_168791059963a3e8956382f7_95186239',
  ),
);
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>

                    <a class="_blank" href="http://www.prestashop.com" target="_blank">
                      <?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'%copyright% %year% - Ecommerce software by %prestashop%','sprintf'=>array('%prestashop%'=>'PrestaShop™','%year%'=>date('Y'),'%copyright%'=>'©'),'d'=>'Shop.Theme.Global'),$_smarty_tpl ) );?>

                    </a>
                  <?php
}
}
/* {/block 'copyright_link'} */
/* {block 'hook_footer_down'} */
class Block_199038263763a3e895645355_04859650 extends Smarty_Internal_Block
{
public $subBlocks = array (
  'hook_footer_down' => 
  array (
    0 => 'Block_199038263763a3e895645355_04859650',
  ),
);
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>

                  <?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['hook'][0], array( array('h'=>'displayFooterDown'),$_smarty_tpl ) );?>

                <?php
}
}
/* {/block 'hook_footer_down'} */
}
