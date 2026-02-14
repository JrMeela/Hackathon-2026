<?php
/* Smarty version 4.3.1, created on 2026-02-13 11:59:59
  from 'app:frontendcomponentsregistrationFormContexts.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '4.3.1',
  'unifunc' => 'content_698f042f7f5466_10607561',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '2337a06e9cc4d931cf6ffcdfe9c920f5d6b5541a' => 
    array (
      0 => 'app:frontendcomponentsregistrationFormContexts.tpl',
      1 => 1770978293,
      2 => 'app',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_698f042f7f5466_10607561 (Smarty_Internal_Template $_smarty_tpl) {
if (!$_smarty_tpl->tpl_vars['currentContext']->value) {?>

		<fieldset name="contexts">
		<legend>
			<?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['translate'][0], array( array('key'=>"user.register.contextsPrompt"),$_smarty_tpl ) );?>

		</legend>
		<div class="fields">
			<div id="contextOptinGroup" class="context_optin">
				<ul class="contexts">
					<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['contexts']->value, 'context');
$_smarty_tpl->tpl_vars['context']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['context']->value) {
$_smarty_tpl->tpl_vars['context']->do_else = false;
?>
						<?php $_smarty_tpl->_assignInScope('contextId', $_smarty_tpl->tpl_vars['context']->value->getId());?>
						<?php $_smarty_tpl->_assignInScope('isSelected', false);?>
						<li class="context">
							<div class="name">
								<?php echo $_smarty_tpl->tpl_vars['context']->value->getLocalizedName();?>

							</div class="name">
							<fieldset class="roles">
								<legend>
									<?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['translate'][0], array( array('key'=>"user.register.otherContextRoles"),$_smarty_tpl ) );?>

								</legend>
								<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['readerUserGroups']->value[$_smarty_tpl->tpl_vars['contextId']->value], 'userGroup');
$_smarty_tpl->tpl_vars['userGroup']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['userGroup']->value) {
$_smarty_tpl->tpl_vars['userGroup']->do_else = false;
?>
									<?php if ($_smarty_tpl->tpl_vars['userGroup']->value->getPermitSelfRegistration()) {?>
										<?php $_smarty_tpl->_assignInScope('userGroupId', $_smarty_tpl->tpl_vars['userGroup']->value->getId());?>
										<label>
											<input type="checkbox" name="readerGroup[<?php echo $_smarty_tpl->tpl_vars['userGroupId']->value;?>
]"<?php if (in_array($_smarty_tpl->tpl_vars['userGroupId']->value,$_smarty_tpl->tpl_vars['userGroupIds']->value)) {?> checked="checked"<?php }?>>
											<?php echo $_smarty_tpl->tpl_vars['userGroup']->value->getLocalizedName();?>

										</label>
										<?php if (in_array($_smarty_tpl->tpl_vars['userGroupId']->value,$_smarty_tpl->tpl_vars['userGroupIds']->value)) {?>
											<?php $_smarty_tpl->_assignInScope('isSelected', true);?>
										<?php }?>
									<?php }?>
								<?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
								<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['reviewerUserGroups']->value[$_smarty_tpl->tpl_vars['contextId']->value], 'userGroup');
$_smarty_tpl->tpl_vars['userGroup']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['userGroup']->value) {
$_smarty_tpl->tpl_vars['userGroup']->do_else = false;
?>
									<?php if ($_smarty_tpl->tpl_vars['userGroup']->value->getPermitSelfRegistration()) {?>
										<?php $_smarty_tpl->_assignInScope('userGroupId', $_smarty_tpl->tpl_vars['userGroup']->value->getId());?>
										<label>
											<input type="checkbox" name="reviewerGroup[<?php echo $_smarty_tpl->tpl_vars['userGroupId']->value;?>
]"<?php if (in_array($_smarty_tpl->tpl_vars['userGroupId']->value,$_smarty_tpl->tpl_vars['userGroupIds']->value)) {?> checked="checked"<?php }?>>
											<?php echo $_smarty_tpl->tpl_vars['userGroup']->value->getLocalizedName();?>

										</label>
										<?php if (in_array($_smarty_tpl->tpl_vars['userGroupId']->value,$_smarty_tpl->tpl_vars['userGroupIds']->value)) {?>
											<?php $_smarty_tpl->_assignInScope('isSelected', true);?>
										<?php }?>
									<?php }?>
								<?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
							</fieldset>
														<?php if (!$_smarty_tpl->tpl_vars['enableSiteWidePrivacyStatement']->value && $_smarty_tpl->tpl_vars['context']->value->getData('privacyStatement')) {?>
								<div class="context_privacy <?php if ($_smarty_tpl->tpl_vars['isSelected']->value) {?>context_privacy_visible<?php }?>">
									<label>
										<input type="checkbox" name="privacyConsent[<?php echo $_smarty_tpl->tpl_vars['contextId']->value;?>
]" id="privacyConsent[<?php echo $_smarty_tpl->tpl_vars['contextId']->value;?>
]" value="1"<?php if ($_smarty_tpl->tpl_vars['privacyConsent']->value[$_smarty_tpl->tpl_vars['contextId']->value]) {?> checked="checked"<?php }?>>
										<?php $_smarty_tpl->smarty->ext->_capture->open($_smarty_tpl, 'default', "privacyUrl", null);
echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['url'][0], array( array('router'=>(defined('ROUTE_PAGE') ? constant('ROUTE_PAGE') : null),'context'=>$_smarty_tpl->tpl_vars['context']->value->getPath(),'page'=>"about",'op'=>"privacy"),$_smarty_tpl ) );
$_smarty_tpl->smarty->ext->_capture->close($_smarty_tpl);?>
										<?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['translate'][0], array( array('key'=>"user.register.form.privacyConsentThisContext",'privacyUrl'=>$_smarty_tpl->tpl_vars['privacyUrl']->value),$_smarty_tpl ) );?>

									</label>
								</div>
							<?php }?>
						</li>
					<?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
				</ul>
			</div>
		</div>
	</fieldset>
<?php }
}
}
