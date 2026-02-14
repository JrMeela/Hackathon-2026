<?php
/* Smarty version 4.3.1, created on 2026-02-13 12:06:05
  from 'app:submissionformindex.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '4.3.1',
  'unifunc' => 'content_698f059ded0634_51449814',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '10d18cabd09acc581a020d1f09ef304f29a1da44' => 
    array (
      0 => 'app:submissionformindex.tpl',
      1 => 1770978294,
      2 => 'app',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_698f059ded0634_51449814 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_loadInheritance();
$_smarty_tpl->inheritance->init($_smarty_tpl, true);
?>


<?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_1194316514698f059deb3ec1_04912541', "page");
?>

<?php $_smarty_tpl->inheritance->endChild($_smarty_tpl, "layouts/backend.tpl");
}
/* {block "page"} */
class Block_1194316514698f059deb3ec1_04912541 extends Smarty_Internal_Block
{
public $subBlocks = array (
  'page' => 
  array (
    0 => 'Block_1194316514698f059deb3ec1_04912541',
  ),
);
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>

	<h1 class="app__pageHeading">
		<?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['translate'][0], array( array('key'=>"submission.submit.title"),$_smarty_tpl ) );?>

	</h1>

	<?php echo '<script'; ?>
 type="text/javascript">
		// Attach the JS file tab handler.
		$(function() {
			$('#submitTabs').pkpHandler(
				'$.pkp.pages.submission.SubmissionTabHandler',
				{
					submissionProgress: <?php echo $_smarty_tpl->tpl_vars['submissionProgress']->value;?>
,
					selected: <?php echo $_smarty_tpl->tpl_vars['submissionProgress']->value-1;?>
,
					cancelUrl: <?php echo call_user_func_array($_smarty_tpl->registered_plugins[ 'modifier' ][ 'json_encode' ][ 0 ], array( call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['url'][0], array( array('page'=>"submissions",'escape'=>false),$_smarty_tpl ) ) ));?>
,
					cancelConfirmText: <?php echo call_user_func_array($_smarty_tpl->registered_plugins[ 'modifier' ][ 'json_encode' ][ 0 ], array( call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['translate'][0], array( array('key'=>"submission.submit.cancelSubmission"),$_smarty_tpl ) ) ));?>

				}
			);
		});
	<?php echo '</script'; ?>
>
	<?php if ($_smarty_tpl->tpl_vars['currentContext']->value->getData('disableSubmissions')) {?>
		<notification>
			<?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['translate'][0], array( array('key'=>"manager.setup.disableSubmissions.notAccepting"),$_smarty_tpl ) );?>

		</notification>
	<?php } else { ?>
		<div id="submitTabs" class="pkp_controllers_tab">
			<ul>
				<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['steps']->value, 'stepLocaleKey', false, 'step');
$_smarty_tpl->tpl_vars['stepLocaleKey']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['step']->value => $_smarty_tpl->tpl_vars['stepLocaleKey']->value) {
$_smarty_tpl->tpl_vars['stepLocaleKey']->do_else = false;
?>
					<li><a name="step-<?php echo call_user_func_array($_smarty_tpl->registered_plugins[ 'modifier' ][ 'escape' ][ 0 ], array( $_smarty_tpl->tpl_vars['step']->value ));?>
" href="<?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['url'][0], array( array('op'=>"step",'path'=>$_smarty_tpl->tpl_vars['step']->value,'submissionId'=>$_smarty_tpl->tpl_vars['submissionId']->value,'sectionId'=>$_smarty_tpl->tpl_vars['sectionId']->value),$_smarty_tpl ) );?>
"><?php echo $_smarty_tpl->tpl_vars['step']->value;?>
. <?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['translate'][0], array( array('key'=>$_smarty_tpl->tpl_vars['stepLocaleKey']->value),$_smarty_tpl ) );?>
</a></li>
				<?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
			</ul>
		</div>
	<?php }
}
}
/* {/block "page"} */
}
