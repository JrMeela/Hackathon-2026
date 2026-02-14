<?php
/* Smarty version 4.3.1, created on 2026-02-13 13:24:04
  from 'app:controllersmodalsdocumentLibrarydocumentLibrary.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '4.3.1',
  'unifunc' => 'content_698f17e47b2215_80848911',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '7eaf718214fac20be2b38dda789ce42d55bb8f1d' => 
    array (
      0 => 'app:controllersmodalsdocumentLibrarydocumentLibrary.tpl',
      1 => 1770978292,
      2 => 'app',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_698f17e47b2215_80848911 (Smarty_Internal_Template $_smarty_tpl) {
echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['help'][0], array( array('file'=>"editorial-workflow",'section'=>"submission-library",'class'=>"pkp_help_modal"),$_smarty_tpl ) );?>


<?php $_smarty_tpl->smarty->ext->_capture->open($_smarty_tpl, 'default', 'submissionLibraryGridUrl', null);
echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['url'][0], array( array('submissionId'=>$_smarty_tpl->tpl_vars['submission']->value->getId(),'router'=>(defined('ROUTE_COMPONENT') ? constant('ROUTE_COMPONENT') : null),'component'=>"grid.files.submissionDocuments.SubmissionDocumentsFilesGridHandler",'op'=>"fetchGrid",'escape'=>false),$_smarty_tpl ) );
$_smarty_tpl->smarty->ext->_capture->close($_smarty_tpl);
echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['load_url_in_div'][0], array( array('id'=>"submissionLibraryGridContainer",'url'=>$_smarty_tpl->tpl_vars['submissionLibraryGridUrl']->value),$_smarty_tpl ) );?>

<?php }
}
