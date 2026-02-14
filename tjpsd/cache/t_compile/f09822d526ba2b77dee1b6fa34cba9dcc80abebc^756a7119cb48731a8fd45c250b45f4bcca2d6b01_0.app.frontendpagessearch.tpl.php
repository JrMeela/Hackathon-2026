<?php
/* Smarty version 4.3.1, created on 2026-02-14 14:22:38
  from 'app:frontendpagessearch.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '4.3.1',
  'unifunc' => 'content_6990771e793a48_21042660',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '756a7119cb48731a8fd45c250b45f4bcca2d6b01' => 
    array (
      0 => 'app:frontendpagessearch.tpl',
      1 => 1771066928,
      2 => 'app',
    ),
  ),
  'includes' => 
  array (
    'app:frontend/components/header.tpl' => 1,
    'app:frontend/components/breadcrumbs.tpl' => 1,
    'app:frontend/objects/article_summary.tpl' => 1,
    'app:frontend/components/notification.tpl' => 2,
    'app:frontend/components/footer.tpl' => 1,
  ),
),false)) {
function content_6990771e793a48_21042660 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_loadInheritance();
$_smarty_tpl->inheritance->init($_smarty_tpl, false);
$_smarty_tpl->_subTemplateRender("app:frontend/components/header.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array('pageTitle'=>"common.search"), 0, false);
?>

<?php if (!$_smarty_tpl->tpl_vars['heading']->value) {?>
	<?php $_smarty_tpl->_assignInScope('heading', "h2");
}?>

<div class="page page_search">

	<?php $_smarty_tpl->_subTemplateRender("app:frontend/components/breadcrumbs.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array('currentTitleKey'=>"common.search"), 0, false);
?>
	<h1>
		<?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['translate'][0], array( array('key'=>"common.search"),$_smarty_tpl ) );?>

	</h1>

	<?php $_smarty_tpl->smarty->ext->_capture->open($_smarty_tpl, "searchFormUrl", null, null);
echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['url'][0], array( array('escape'=>false),$_smarty_tpl ) );
$_smarty_tpl->smarty->ext->_capture->close($_smarty_tpl);?>
	<?php $_smarty_tpl->_assignInScope('formUrlParameters', array());?>	<?php echo call_user_func_array($_smarty_tpl->registered_plugins[ 'modifier' ][ 'parse_str' ][ 0 ], array( (($tmp = call_user_func_array($_smarty_tpl->registered_plugins[ 'modifier' ][ 'parse_url' ][ 0 ], array( $_smarty_tpl->smarty->ext->_capture->getBuffer($_smarty_tpl, 'searchFormUrl'),(defined('PHP_URL_QUERY') ? constant('PHP_URL_QUERY') : null) )) ?? null)===null||$tmp==='' ? '' ?? null : $tmp),$_smarty_tpl->tpl_vars['formUrlParameters']->value ));?>

	<form class="cmp_form" method="get" action="<?php echo call_user_func_array($_smarty_tpl->registered_plugins[ 'modifier' ][ 'escape' ][ 0 ], array( call_user_func_array($_smarty_tpl->registered_plugins[ 'modifier' ][ 'strtok' ][ 0 ], array( $_smarty_tpl->smarty->ext->_capture->getBuffer($_smarty_tpl, 'searchFormUrl'),"?" )) ));?>
">
		<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['formUrlParameters']->value, 'paramValue', false, 'paramKey');
$_smarty_tpl->tpl_vars['paramValue']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['paramKey']->value => $_smarty_tpl->tpl_vars['paramValue']->value) {
$_smarty_tpl->tpl_vars['paramValue']->do_else = false;
?>
			<input type="hidden" name="<?php echo call_user_func_array($_smarty_tpl->registered_plugins[ 'modifier' ][ 'escape' ][ 0 ], array( $_smarty_tpl->tpl_vars['paramKey']->value ));?>
" value="<?php echo call_user_func_array($_smarty_tpl->registered_plugins[ 'modifier' ][ 'escape' ][ 0 ], array( $_smarty_tpl->tpl_vars['paramValue']->value ));?>
"/>
		<?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>

				<div class="search_input">
			<label class="pkp_screen_reader" for="query">
				<?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['translate'][0], array( array('key'=>"search.searchFor"),$_smarty_tpl ) );?>

			</label>
			<?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_18506777596990771e5b9687_38508539', 'searchQuery');
?>

		</div>

		<fieldset class="search_advanced">
			<legend>
				<?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['translate'][0], array( array('key'=>"search.advancedFilters"),$_smarty_tpl ) );?>

			</legend>
			<div class="date_range">
				<div class="from">
					<?php $_smarty_tpl->smarty->ext->_capture->open($_smarty_tpl, 'default', "dateFromLegend", null);
echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['translate'][0], array( array('key'=>"search.dateFrom"),$_smarty_tpl ) );
$_smarty_tpl->smarty->ext->_capture->close($_smarty_tpl);?>
					<?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['html_select_date_a11y'][0], array( array('legend'=>$_smarty_tpl->tpl_vars['dateFromLegend']->value,'prefix'=>"dateFrom",'time'=>$_smarty_tpl->tpl_vars['dateFrom']->value,'start_year'=>$_smarty_tpl->tpl_vars['yearStart']->value,'end_year'=>$_smarty_tpl->tpl_vars['yearEnd']->value),$_smarty_tpl ) );?>

				</div>
				<div class="to">
					<?php $_smarty_tpl->smarty->ext->_capture->open($_smarty_tpl, 'default', "dateFromTo", null);
echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['translate'][0], array( array('key'=>"search.dateTo"),$_smarty_tpl ) );
$_smarty_tpl->smarty->ext->_capture->close($_smarty_tpl);?>
					<?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['html_select_date_a11y'][0], array( array('legend'=>$_smarty_tpl->tpl_vars['dateFromTo']->value,'prefix'=>"dateTo",'time'=>$_smarty_tpl->tpl_vars['dateTo']->value,'start_year'=>$_smarty_tpl->tpl_vars['yearStart']->value,'end_year'=>$_smarty_tpl->tpl_vars['yearEnd']->value),$_smarty_tpl ) );?>

				</div>
			</div>
			<div class="author">
				<label class="label" for="authors">
					<?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['translate'][0], array( array('key'=>"search.author"),$_smarty_tpl ) );?>

				</label>
				<?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_1014164836990771e5c3f59_98882310', 'searchAuthors');
?>

			</div>
			<?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['call_hook'][0], array( array('name'=>"Templates::Search::SearchResults::AdditionalFilters"),$_smarty_tpl ) );?>

		</fieldset>

		<div class="submit">
			<button class="submit" type="submit"><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['translate'][0], array( array('key'=>"common.search"),$_smarty_tpl ) );?>
</button>
		</div>
	</form>

	<?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['call_hook'][0], array( array('name'=>"Templates::Search::SearchResults::PreResults"),$_smarty_tpl ) );?>


	<h2 class="pkp_screen_reader"><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['translate'][0], array( array('key'=>"search.searchResults"),$_smarty_tpl ) );?>
</h2>

		<?php if (!$_smarty_tpl->tpl_vars['results']->value->wasEmpty()) {?>
		<?php $_smarty_tpl->_assignInScope('count', $_smarty_tpl->tpl_vars['results']->value->count);?>
		<div class="pkp_screen_reader" role="status">
			<?php if ($_smarty_tpl->tpl_vars['results']->value->count > 1) {?>
				<?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['translate'][0], array( array('key'=>"search.searchResults.foundPlural",'count'=>$_smarty_tpl->tpl_vars['results']->value->count),$_smarty_tpl ) );?>

			<?php } else { ?>
				<?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['translate'][0], array( array('key'=>"search.searchResults.foundSingle"),$_smarty_tpl ) );?>

			<?php }?>
		</div>
	<?php }?>

		<ul class="search_results">
		<?php $_block_plugin1 = isset($_smarty_tpl->smarty->registered_plugins['block']['iterate'][0][0]) ? $_smarty_tpl->smarty->registered_plugins['block']['iterate'][0][0] : null;
if (!is_callable(array($_block_plugin1, 'smartyIterate'))) {
throw new SmartyException('block tag \'iterate\' not callable or registered');
}
$_smarty_tpl->smarty->_cache['_tag_stack'][] = array('iterate', array('from'=>'results','item'=>'result'));
$_block_repeat=true;
echo $_block_plugin1->smartyIterate(array('from'=>'results','item'=>'result'), null, $_smarty_tpl, $_block_repeat);
while ($_block_repeat) {
ob_start();?>
			<li>
				<?php $_smarty_tpl->_subTemplateRender("app:frontend/objects/article_summary.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array('article'=>$_smarty_tpl->tpl_vars['result']->value['publishedSubmission'],'journal'=>$_smarty_tpl->tpl_vars['result']->value['journal'],'showDatePublished'=>true,'hideGalleys'=>true,'heading'=>"h3"), 0, false);
?>
			</li>
		<?php $_block_repeat=false;
echo $_block_plugin1->smartyIterate(array('from'=>'results','item'=>'result'), ob_get_clean(), $_smarty_tpl, $_block_repeat);
}
array_pop($_smarty_tpl->smarty->_cache['_tag_stack']);?>
	</ul>

		<?php if ($_smarty_tpl->tpl_vars['results']->value->wasEmpty()) {?>
		<span role="status">
			<?php if ($_smarty_tpl->tpl_vars['error']->value) {?>
				<?php $_smarty_tpl->_subTemplateRender("app:frontend/components/notification.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array('type'=>"error",'message'=>call_user_func_array($_smarty_tpl->registered_plugins[ 'modifier' ][ 'escape' ][ 0 ], array( $_smarty_tpl->tpl_vars['error']->value ))), 0, false);
?>
			<?php } else { ?>
				<?php $_smarty_tpl->_subTemplateRender("app:frontend/components/notification.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array('type'=>"notice",'messageKey'=>"search.noResults"), 0, true);
?>
			<?php }?>
		</span>

		<?php } else { ?>
		<div class="cmp_pagination">
			<?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['page_info'][0], array( array('iterator'=>$_smarty_tpl->tpl_vars['results']->value),$_smarty_tpl ) );?>

			<?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['page_links'][0], array( array('anchor'=>"results",'iterator'=>$_smarty_tpl->tpl_vars['results']->value,'name'=>"search",'query'=>$_smarty_tpl->tpl_vars['query']->value,'searchJournal'=>$_smarty_tpl->tpl_vars['searchJournal']->value,'authors'=>$_smarty_tpl->tpl_vars['authors']->value,'dateFromMonth'=>$_smarty_tpl->tpl_vars['dateFromMonth']->value,'dateFromDay'=>$_smarty_tpl->tpl_vars['dateFromDay']->value,'dateFromYear'=>$_smarty_tpl->tpl_vars['dateFromYear']->value,'dateToMonth'=>$_smarty_tpl->tpl_vars['dateToMonth']->value,'dateToDay'=>$_smarty_tpl->tpl_vars['dateToDay']->value,'dateToYear'=>$_smarty_tpl->tpl_vars['dateToYear']->value),$_smarty_tpl ) );?>

		</div>
	<?php }?>

		<?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_10348443696990771e791b51_50056430', 'searchSyntaxInstructions');
?>

</div><!-- .page -->

<?php $_smarty_tpl->_subTemplateRender("app:frontend/components/footer.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
}
/* {block 'searchQuery'} */
class Block_18506777596990771e5b9687_38508539 extends Smarty_Internal_Block
{
public $subBlocks = array (
  'searchQuery' => 
  array (
    0 => 'Block_18506777596990771e5b9687_38508539',
  ),
);
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>

				<input type="text" id="query" name="query" value="<?php echo call_user_func_array($_smarty_tpl->registered_plugins[ 'modifier' ][ 'escape' ][ 0 ], array( $_smarty_tpl->tpl_vars['query']->value ));?>
" class="query" placeholder="<?php echo call_user_func_array($_smarty_tpl->registered_plugins[ 'modifier' ][ 'escape' ][ 0 ], array( call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['translate'][0], array( array('key'=>"common.search"),$_smarty_tpl ) ) ));?>
">
			<?php
}
}
/* {/block 'searchQuery'} */
/* {block 'searchAuthors'} */
class Block_1014164836990771e5c3f59_98882310 extends Smarty_Internal_Block
{
public $subBlocks = array (
  'searchAuthors' => 
  array (
    0 => 'Block_1014164836990771e5c3f59_98882310',
  ),
);
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>

					<input type="text" id="authors" name="authors" value="<?php echo call_user_func_array($_smarty_tpl->registered_plugins[ 'modifier' ][ 'escape' ][ 0 ], array( $_smarty_tpl->tpl_vars['authors']->value ));?>
">
				<?php
}
}
/* {/block 'searchAuthors'} */
/* {block 'searchSyntaxInstructions'} */
class Block_10348443696990771e791b51_50056430 extends Smarty_Internal_Block
{
public $subBlocks = array (
  'searchSyntaxInstructions' => 
  array (
    0 => 'Block_10348443696990771e791b51_50056430',
  ),
);
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
}
}
/* {/block 'searchSyntaxInstructions'} */
}
