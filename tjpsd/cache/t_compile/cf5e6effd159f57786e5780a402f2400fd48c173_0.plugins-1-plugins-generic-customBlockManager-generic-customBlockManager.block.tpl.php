<?php
/* Smarty version 4.3.1, created on 2026-02-14 14:02:12
  from 'plugins-1-plugins-generic-customBlockManager-generic-customBlockManager:block.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '4.3.1',
  'unifunc' => 'content_69907254364fa6_07159267',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'cf5e6effd159f57786e5780a402f2400fd48c173' => 
    array (
      0 => 'plugins-1-plugins-generic-customBlockManager-generic-customBlockManager:block.tpl',
      1 => 1771066923,
      2 => 'plugins-1-plugins-generic-customBlockManager-generic-customBlockManager',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_69907254364fa6_07159267 (Smarty_Internal_Template $_smarty_tpl) {
?><div class="pkp_block block_custom" id="<?php echo call_user_func_array($_smarty_tpl->registered_plugins[ 'modifier' ][ 'escape' ][ 0 ], array( $_smarty_tpl->tpl_vars['customBlockId']->value ));?>
">
	<h2 class="title<?php if (!$_smarty_tpl->tpl_vars['showName']->value) {?> pkp_screen_reader<?php }?>"><?php echo $_smarty_tpl->tpl_vars['customBlockTitle']->value;?>
</h2>
	<div class="content">
		<?php echo $_smarty_tpl->tpl_vars['customBlockContent']->value;?>

	</div>
</div>
<?php }
}
