<?php
/* Smarty version 4.3.1, created on 2026-02-13 12:05:50
  from 'app:usernotificationSettingsForm.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '4.3.1',
  'unifunc' => 'content_698f058ed2bc64_64213093',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'a30f866b29d80531bfc63eba879304b1f665a133' => 
    array (
      0 => 'app:usernotificationSettingsForm.tpl',
      1 => 1770978295,
      2 => 'app',
    ),
  ),
  'includes' => 
  array (
    'app:controllers/notification/inPlaceNotification.tpl' => 1,
  ),
),false)) {
function content_698f058ed2bc64_64213093 (Smarty_Internal_Template $_smarty_tpl) {
echo '<script'; ?>
>
	$(function() {
		// Attach the form handler.
		$('#notificationSettingsForm').pkpHandler('$.pkp.controllers.form.AjaxFormHandler', {
			'enableDisablePairs': {
					<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['notificationSettingCategories']->value, 'notificationSettingCategory');
$_smarty_tpl->tpl_vars['notificationSettingCategory']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['notificationSettingCategory']->value) {
$_smarty_tpl->tpl_vars['notificationSettingCategory']->do_else = false;
?>
						<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['notificationSettingCategory']->value['settings'], 'settingId', false, NULL, 'notifications', array (
));
$_smarty_tpl->tpl_vars['settingId']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['settingId']->value) {
$_smarty_tpl->tpl_vars['settingId']->do_else = false;
?>
						<?php echo call_user_func_array($_smarty_tpl->registered_plugins[ 'modifier' ][ 'json_encode' ][ 0 ], array( $_smarty_tpl->tpl_vars['notificationSettings']->value[$_smarty_tpl->tpl_vars['settingId']->value]['settingName'] ));?>
: <?php echo call_user_func_array($_smarty_tpl->registered_plugins[ 'modifier' ][ 'json_encode' ][ 0 ], array( $_smarty_tpl->tpl_vars['notificationSettings']->value[$_smarty_tpl->tpl_vars['settingId']->value]['emailSettingName'] ));?>
,
						<?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
					<?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
				}
		});
	});
<?php echo '</script'; ?>
>

<form class="pkp_form" id="notificationSettingsForm" method="post" action="<?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['url'][0], array( array('op'=>"saveNotificationSettings"),$_smarty_tpl ) );?>
" enctype="multipart/form-data">
	<p><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['translate'][0], array( array('key'=>"notification.settingsDescription"),$_smarty_tpl ) );?>
</p>

		<?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['help'][0], array( array('file'=>"user-profile",'class'=>"pkp_help_tab"),$_smarty_tpl ) );?>


	<?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['csrf'][0], array( array(),$_smarty_tpl ) );?>


	<?php $_smarty_tpl->_subTemplateRender("app:controllers/notification/inPlaceNotification.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array('notificationId'=>"notificationSettingsFormNotification"), 0, false);
?>

	<?php $_block_plugin1 = isset($_smarty_tpl->smarty->registered_plugins['block']['fbvFormArea'][0][0]) ? $_smarty_tpl->smarty->registered_plugins['block']['fbvFormArea'][0][0] : null;
if (!is_callable(array($_block_plugin1, 'smartyFBVFormArea'))) {
throw new SmartyException('block tag \'fbvFormArea\' not callable or registered');
}
$_smarty_tpl->smarty->_cache['_tag_stack'][] = array('fbvFormArea', array('id'=>"notificationSettings"));
$_block_repeat=true;
echo $_block_plugin1->smartyFBVFormArea(array('id'=>"notificationSettings"), null, $_smarty_tpl, $_block_repeat);
while ($_block_repeat) {
ob_start();?>
		<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['notificationSettingCategories']->value, 'notificationSettingCategory');
$_smarty_tpl->tpl_vars['notificationSettingCategory']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['notificationSettingCategory']->value) {
$_smarty_tpl->tpl_vars['notificationSettingCategory']->do_else = false;
?>
			<h4><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['translate'][0], array( array('key'=>$_smarty_tpl->tpl_vars['notificationSettingCategory']->value['categoryKey']),$_smarty_tpl ) );?>
</h4>
			<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['notificationSettingCategory']->value['settings'], 'settingId');
$_smarty_tpl->tpl_vars['settingId']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['settingId']->value) {
$_smarty_tpl->tpl_vars['settingId']->do_else = false;
?>
				<?php $_smarty_tpl->_assignInScope('settingName', $_smarty_tpl->tpl_vars['notificationSettings']->value[$_smarty_tpl->tpl_vars['settingId']->value]['settingName']);?>
				<?php $_smarty_tpl->_assignInScope('emailSettingName', $_smarty_tpl->tpl_vars['notificationSettings']->value[$_smarty_tpl->tpl_vars['settingId']->value]['emailSettingName']);?>
				<?php $_smarty_tpl->smarty->ext->_capture->open($_smarty_tpl, 'default', "settingKey", null);
echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['translate'][0], array( array('key'=>$_smarty_tpl->tpl_vars['notificationSettings']->value[$_smarty_tpl->tpl_vars['settingId']->value]['settingKey'],'title'=>call_user_func_array($_smarty_tpl->registered_plugins[ 'modifier' ][ 'translate' ][ 0 ], array( "common.title" ))),$_smarty_tpl ) );
$_smarty_tpl->smarty->ext->_capture->close($_smarty_tpl);?>

				<?php $_block_plugin2 = isset($_smarty_tpl->smarty->registered_plugins['block']['fbvFormSection'][0][0]) ? $_smarty_tpl->smarty->registered_plugins['block']['fbvFormSection'][0][0] : null;
if (!is_callable(array($_block_plugin2, 'smartyFBVFormSection'))) {
throw new SmartyException('block tag \'fbvFormSection\' not callable or registered');
}
$_smarty_tpl->smarty->_cache['_tag_stack'][] = array('fbvFormSection', array('title'=>$_smarty_tpl->tpl_vars['settingKey']->value,'list'=>true,'translate'=>false));
$_block_repeat=true;
echo $_block_plugin2->smartyFBVFormSection(array('title'=>$_smarty_tpl->tpl_vars['settingKey']->value,'list'=>true,'translate'=>false), null, $_smarty_tpl, $_block_repeat);
while ($_block_repeat) {
ob_start();?>
					<?php if (in_array($_smarty_tpl->tpl_vars['settingId']->value,$_smarty_tpl->tpl_vars['blockedNotifications']->value)) {?>
						<?php $_smarty_tpl->_assignInScope('checked', "0");?>
					<?php } else { ?>
						<?php $_smarty_tpl->_assignInScope('checked', "1");?>
					<?php }?>
					<?php if (in_array($_smarty_tpl->tpl_vars['settingId']->value,$_smarty_tpl->tpl_vars['emailSettings']->value)) {?>
						<?php $_smarty_tpl->_assignInScope('emailChecked', "1");?>
					<?php } else { ?>
						<?php $_smarty_tpl->_assignInScope('emailChecked', "0");?>
					<?php }?>
					<?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['fbvElement'][0], array( array('type'=>"checkbox",'id'=>$_smarty_tpl->tpl_vars['settingName']->value,'checked'=>$_smarty_tpl->tpl_vars['checked']->value,'label'=>"notification.allow"),$_smarty_tpl ) );?>

					<?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['fbvElement'][0], array( array('type'=>"checkbox",'id'=>$_smarty_tpl->tpl_vars['emailSettingName']->value,'checked'=>$_smarty_tpl->tpl_vars['emailChecked']->value,'label'=>"notification.email"),$_smarty_tpl ) );?>

				<?php $_block_repeat=false;
echo $_block_plugin2->smartyFBVFormSection(array('title'=>$_smarty_tpl->tpl_vars['settingKey']->value,'list'=>true,'translate'=>false), ob_get_clean(), $_smarty_tpl, $_block_repeat);
}
array_pop($_smarty_tpl->smarty->_cache['_tag_stack']);?>
			<?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
		<?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>

		<p>
			<?php $_smarty_tpl->smarty->ext->_capture->open($_smarty_tpl, 'default', "privacyUrl", null);
echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['url'][0], array( array('router'=>(defined('ROUTE_PAGE') ? constant('ROUTE_PAGE') : null),'page'=>"about",'op'=>"privacy"),$_smarty_tpl ) );
$_smarty_tpl->smarty->ext->_capture->close($_smarty_tpl);?>
			<?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['translate'][0], array( array('key'=>"user.privacyLink",'privacyUrl'=>$_smarty_tpl->tpl_vars['privacyUrl']->value),$_smarty_tpl ) );?>

		</p>

		<p><span class="formRequired"><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['translate'][0], array( array('key'=>"common.requiredField"),$_smarty_tpl ) );?>
</span></p>
		<?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['fbvFormButtons'][0], array( array('hideCancel'=>true,'submitText'=>"common.save"),$_smarty_tpl ) );?>

	<?php $_block_repeat=false;
echo $_block_plugin1->smartyFBVFormArea(array('id'=>"notificationSettings"), ob_get_clean(), $_smarty_tpl, $_block_repeat);
}
array_pop($_smarty_tpl->smarty->_cache['_tag_stack']);?>
</form>
<?php }
}
