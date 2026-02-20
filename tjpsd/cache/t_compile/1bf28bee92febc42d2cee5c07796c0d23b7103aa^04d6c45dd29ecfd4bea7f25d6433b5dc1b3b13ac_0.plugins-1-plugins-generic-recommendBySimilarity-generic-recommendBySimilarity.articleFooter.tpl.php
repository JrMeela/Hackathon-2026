<?php
/* Smarty version 4.3.1, created on 2026-02-14 22:06:45
  from 'plugins-1-plugins-generic-recommendBySimilarity-generic-recommendBySimilarity:articleFooter.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '4.3.1',
  'unifunc' => 'content_6990e3e5762df4_39476105',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '04d6c45dd29ecfd4bea7f25d6433b5dc1b3b13ac' => 
    array (
      0 => 'plugins-1-plugins-generic-recommendBySimilarity-generic-recommendBySimilarity:articleFooter.tpl',
      1 => 1771066924,
      2 => 'plugins-1-plugins-generic-recommendBySimilarity-generic-recommendBySimilarity',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_6990e3e5762df4_39476105 (Smarty_Internal_Template $_smarty_tpl) {
?><div id="articlesBySimilarityList">
	<?php $_smarty_tpl->_assignInScope('recommendations', $_smarty_tpl->tpl_vars['articlesBySimilarity']->value->submissions);?>
	<?php if (!$_smarty_tpl->tpl_vars['recommendations']->value->wasEmpty()) {?>
		<h3>
			<a name="articlesBySimilarity"><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['translate'][0], array( array('key'=>"plugins.generic.recommendBySimilarity.heading"),$_smarty_tpl ) );?>
</a>
		</h3>
		<ul>

			<?php $_block_plugin1 = isset($_smarty_tpl->smarty->registered_plugins['block']['iterate'][0][0]) ? $_smarty_tpl->smarty->registered_plugins['block']['iterate'][0][0] : null;
if (!is_callable(array($_block_plugin1, 'smartyIterate'))) {
throw new SmartyException('block tag \'iterate\' not callable or registered');
}
$_smarty_tpl->smarty->_cache['_tag_stack'][] = array('iterate', array('from'=>"recommendations",'item'=>'submission'));
$_block_repeat=true;
echo $_block_plugin1->smartyIterate(array('from'=>"recommendations",'item'=>'submission'), null, $_smarty_tpl, $_block_repeat);
while ($_block_repeat) {
ob_start();?>
				<?php $_smarty_tpl->_assignInScope('publication', $_smarty_tpl->tpl_vars['submission']->value->getCurrentPublication());?>
				<?php $_smarty_tpl->_assignInScope('issue', $_smarty_tpl->tpl_vars['articlesBySimilarity']->value->plugin->getIssue((int) $_smarty_tpl->tpl_vars['publication']->value->getData('issueId')));?>

				<li>
					<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['publication']->value->getData('authors'), 'author');
$_smarty_tpl->tpl_vars['author']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['author']->value) {
$_smarty_tpl->tpl_vars['author']->do_else = false;
?>
						<?php echo call_user_func_array($_smarty_tpl->registered_plugins[ 'modifier' ][ 'escape' ][ 0 ], array( $_smarty_tpl->tpl_vars['author']->value->getFullName() ));?>
,
					<?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
					<a href="<?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['url'][0], array( array('journal'=>$_smarty_tpl->tpl_vars['currentContext']->value->getPath(),'page'=>"article",'op'=>"view",'path'=>$_smarty_tpl->tpl_vars['submission']->value->getBestId()),$_smarty_tpl ) );?>
">
						<?php echo call_user_func_array($_smarty_tpl->registered_plugins[ 'modifier' ][ 'strip_unsafe_html' ][ 0 ], array( $_smarty_tpl->tpl_vars['submission']->value->getLocalizedTitle() ));?>

					</a>
					<?php if ($_smarty_tpl->tpl_vars['issue']->value) {?>,
					<a href="<?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['url'][0], array( array('journal'=>$_smarty_tpl->tpl_vars['currentContext']->value->getPath(),'page'=>"issue",'op'=>"view",'path'=>$_smarty_tpl->tpl_vars['issue']->value->getBestIssueId()),$_smarty_tpl ) );?>
">
						<?php echo call_user_func_array($_smarty_tpl->registered_plugins[ 'modifier' ][ 'escape' ][ 0 ], array( $_smarty_tpl->tpl_vars['currentContext']->value->getLocalizedName() ));?>
: <?php echo call_user_func_array($_smarty_tpl->registered_plugins[ 'modifier' ][ 'escape' ][ 0 ], array( $_smarty_tpl->tpl_vars['issue']->value->getIssueIdentification() ));?>

					</a>
					<?php }?>
				</li>
			<?php $_block_repeat=false;
echo $_block_plugin1->smartyIterate(array('from'=>"recommendations",'item'=>'submission'), ob_get_clean(), $_smarty_tpl, $_block_repeat);
}
array_pop($_smarty_tpl->smarty->_cache['_tag_stack']);?>
		</ul>
		<p id="articlesBySimilarityPages">
			<?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['page_links'][0], array( array('anchor'=>"articlesBySimilarity",'iterator'=>$_smarty_tpl->tpl_vars['recommendations']->value,'name'=>"articlesBySimilarity"),$_smarty_tpl ) );?>

		</p>
		<p id="articlesBySimilaritySearch">
			<?php $_smarty_tpl->smarty->ext->_capture->open($_smarty_tpl, 'default', "advancedSearchLink", null);?><a href="<?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['url'][0], array( array('page'=>"search",'op'=>"search",'query'=>$_smarty_tpl->tpl_vars['articlesBySimilarity']->value->query),$_smarty_tpl ) );?>
"><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['translate'][0], array( array('key'=>"plugins.generic.recommendBySimilarity.advancedSearch"),$_smarty_tpl ) );?>
</a><?php $_smarty_tpl->smarty->ext->_capture->close($_smarty_tpl);?>
			<?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['translate'][0], array( array('key'=>"plugins.generic.recommendBySimilarity.advancedSearchIntro",'advancedSearchLink'=>$_smarty_tpl->tpl_vars['advancedSearchLink']->value),$_smarty_tpl ) );?>

		</p>
	<?php }?>
</div>
<?php }
}
