<?php
/* Smarty version 4.3.1, created on 2026-02-15 10:43:23
  from 'app:frontendobjectsarticle_details.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '4.3.1',
  'unifunc' => 'content_6991953b6f9190_48565980',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'addd65021fadf964339ab08cd1aa93ba59b14e9c' => 
    array (
      0 => 'app:frontendobjectsarticle_details.tpl',
      1 => 1771148496,
      2 => 'app',
    ),
  ),
  'includes' => 
  array (
    'app:frontend/objects/galley_link.tpl' => 2,
  ),
),false)) {
function content_6991953b6f9190_48565980 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_checkPlugins(array(0=>array('file'=>'C:\\Users\\junio\\Hackathon-2026\\tjpsd\\lib\\pkp\\lib\\vendor\\smarty\\smarty\\libs\\plugins\\modifier.date_format.php','function'=>'smarty_modifier_date_format',),));
?>
 <?php if (!$_smarty_tpl->tpl_vars['heading']->value) {?>
 	<?php $_smarty_tpl->_assignInScope('heading', "h3");?>
 <?php }?>
<article class="obj_article_details">

		<?php if ($_smarty_tpl->tpl_vars['publication']->value->getData('status') !== (defined('STATUS_PUBLISHED') ? constant('STATUS_PUBLISHED') : null)) {?>
	<div class="cmp_notification notice">
		<?php $_smarty_tpl->smarty->ext->_capture->open($_smarty_tpl, 'default', "submissionUrl", null);
echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['url'][0], array( array('page'=>"workflow",'op'=>"access",'path'=>$_smarty_tpl->tpl_vars['article']->value->getId()),$_smarty_tpl ) );
$_smarty_tpl->smarty->ext->_capture->close($_smarty_tpl);?>
		<?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['translate'][0], array( array('key'=>"submission.viewingPreview",'url'=>$_smarty_tpl->tpl_vars['submissionUrl']->value),$_smarty_tpl ) );?>

	</div>
		<?php } elseif ($_smarty_tpl->tpl_vars['currentPublication']->value->getId() !== $_smarty_tpl->tpl_vars['publication']->value->getId()) {?>
		<div class="cmp_notification notice">
			<?php $_smarty_tpl->smarty->ext->_capture->open($_smarty_tpl, 'default', "latestVersionUrl", null);
echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['url'][0], array( array('page'=>"article",'op'=>"view",'path'=>$_smarty_tpl->tpl_vars['article']->value->getBestId()),$_smarty_tpl ) );
$_smarty_tpl->smarty->ext->_capture->close($_smarty_tpl);?>
			<?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['translate'][0], array( array('key'=>"submission.outdatedVersion",'datePublished'=>smarty_modifier_date_format($_smarty_tpl->tpl_vars['publication']->value->getData('datePublished'),$_smarty_tpl->tpl_vars['dateFormatShort']->value),'urlRecentVersion'=>call_user_func_array($_smarty_tpl->registered_plugins[ 'modifier' ][ 'escape' ][ 0 ], array( $_smarty_tpl->tpl_vars['latestVersionUrl']->value ))),$_smarty_tpl ) );?>

		</div>
	<?php }?>

	<h1 class="page_title">
		<?php echo call_user_func_array($_smarty_tpl->registered_plugins[ 'modifier' ][ 'escape' ][ 0 ], array( $_smarty_tpl->tpl_vars['publication']->value->getLocalizedTitle() ));?>

	</h1>

	<?php if ($_smarty_tpl->tpl_vars['publication']->value->getLocalizedData('subtitle')) {?>
		<h2 class="subtitle">
			<?php echo call_user_func_array($_smarty_tpl->registered_plugins[ 'modifier' ][ 'escape' ][ 0 ], array( $_smarty_tpl->tpl_vars['publication']->value->getLocalizedData('subtitle') ));?>

		</h2>
	<?php }?>

	<div class="row">
		<div class="main_entry">

			<?php if ($_smarty_tpl->tpl_vars['publication']->value->getData('authors')) {?>
				<section class="item authors">
					<h2 class="pkp_screen_reader"><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['translate'][0], array( array('key'=>"article.authors"),$_smarty_tpl ) );?>
</h2>
					<ul class="authors">
					<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['publication']->value->getData('authors'), 'author');
$_smarty_tpl->tpl_vars['author']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['author']->value) {
$_smarty_tpl->tpl_vars['author']->do_else = false;
?>
						<li>
							<span class="name">
								<?php echo call_user_func_array($_smarty_tpl->registered_plugins[ 'modifier' ][ 'escape' ][ 0 ], array( $_smarty_tpl->tpl_vars['author']->value->getFullName() ));?>

							</span>
							<?php if ($_smarty_tpl->tpl_vars['author']->value->getLocalizedData('affiliation')) {?>
								<span class="affiliation">
									<?php echo call_user_func_array($_smarty_tpl->registered_plugins[ 'modifier' ][ 'escape' ][ 0 ], array( $_smarty_tpl->tpl_vars['author']->value->getLocalizedData('affiliation') ));?>

									<?php if ($_smarty_tpl->tpl_vars['author']->value->getData('rorId')) {?>
										<a href="<?php echo call_user_func_array($_smarty_tpl->registered_plugins[ 'modifier' ][ 'escape' ][ 0 ], array( $_smarty_tpl->tpl_vars['author']->value->getData('rorId') ));?>
"><?php echo $_smarty_tpl->tpl_vars['rorIdIcon']->value;?>
</a>
									<?php }?>
								</span>
							<?php }?>
							<?php if ($_smarty_tpl->tpl_vars['author']->value->getData('orcid')) {?>
								<span class="orcid">
									<?php if ($_smarty_tpl->tpl_vars['author']->value->getData('orcidAccessToken')) {?>
										<?php echo $_smarty_tpl->tpl_vars['orcidIcon']->value;?>

									<?php }?>
									<a href="<?php echo call_user_func_array($_smarty_tpl->registered_plugins[ 'modifier' ][ 'escape' ][ 0 ], array( $_smarty_tpl->tpl_vars['author']->value->getData('orcid') ));?>
" target="_blank">
										<?php echo call_user_func_array($_smarty_tpl->registered_plugins[ 'modifier' ][ 'escape' ][ 0 ], array( $_smarty_tpl->tpl_vars['author']->value->getData('orcid') ));?>

									</a>
								</span>
							<?php }?>
						</li>
					<?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
					</ul>
				</section>
			<?php }?>

						<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['pubIdPlugins']->value, 'pubIdPlugin');
$_smarty_tpl->tpl_vars['pubIdPlugin']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['pubIdPlugin']->value) {
$_smarty_tpl->tpl_vars['pubIdPlugin']->do_else = false;
?>
				<?php if ($_smarty_tpl->tpl_vars['pubIdPlugin']->value->getPubIdType() != 'doi') {?>
					<?php continue 1;?>
				<?php }?>
				<?php $_smarty_tpl->_assignInScope('pubId', $_smarty_tpl->tpl_vars['article']->value->getStoredPubId($_smarty_tpl->tpl_vars['pubIdPlugin']->value->getPubIdType()));?>
				<?php if ($_smarty_tpl->tpl_vars['pubId']->value) {?>
					<?php $_smarty_tpl->_assignInScope('doiUrl', call_user_func_array($_smarty_tpl->registered_plugins[ 'modifier' ][ 'escape' ][ 0 ], array( $_smarty_tpl->tpl_vars['pubIdPlugin']->value->getResolvingURL($_smarty_tpl->tpl_vars['currentJournal']->value->getId(),$_smarty_tpl->tpl_vars['pubId']->value) )));?>
					<section class="item doi">
						<h2 class="label">
							<?php $_smarty_tpl->smarty->ext->_capture->open($_smarty_tpl, 'default', 'translatedDOI', null);
echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['translate'][0], array( array('key'=>"plugins.pubIds.doi.readerDisplayName"),$_smarty_tpl ) );
$_smarty_tpl->smarty->ext->_capture->close($_smarty_tpl);?>
							<?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['translate'][0], array( array('key'=>"semicolon",'label'=>$_smarty_tpl->tpl_vars['translatedDOI']->value),$_smarty_tpl ) );?>

						</h2>
						<span class="value">
							<a href="<?php echo $_smarty_tpl->tpl_vars['doiUrl']->value;?>
">
								<?php echo $_smarty_tpl->tpl_vars['doiUrl']->value;?>

							</a>
						</span>
					</section>
				<?php }?>
			<?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>

						<?php if (!empty($_smarty_tpl->tpl_vars['publication']->value->getLocalizedData('keywords'))) {?>
			<section class="item keywords">
				<h2 class="label">
					<?php $_smarty_tpl->smarty->ext->_capture->open($_smarty_tpl, 'default', 'translatedKeywords', null);
echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['translate'][0], array( array('key'=>"article.subject"),$_smarty_tpl ) );
$_smarty_tpl->smarty->ext->_capture->close($_smarty_tpl);?>
					<?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['translate'][0], array( array('key'=>"semicolon",'label'=>$_smarty_tpl->tpl_vars['translatedKeywords']->value),$_smarty_tpl ) );?>

				</h2>
				<span class="value">
					<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['publication']->value->getLocalizedData('keywords'), 'keyword', false, NULL, 'keywords', array (
  'last' => true,
  'iteration' => true,
  'total' => true,
));
$_smarty_tpl->tpl_vars['keyword']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['keyword']->value) {
$_smarty_tpl->tpl_vars['keyword']->do_else = false;
$_smarty_tpl->tpl_vars['__smarty_foreach_keywords']->value['iteration']++;
$_smarty_tpl->tpl_vars['__smarty_foreach_keywords']->value['last'] = $_smarty_tpl->tpl_vars['__smarty_foreach_keywords']->value['iteration'] === $_smarty_tpl->tpl_vars['__smarty_foreach_keywords']->value['total'];
?>
						<?php echo call_user_func_array($_smarty_tpl->registered_plugins[ 'modifier' ][ 'escape' ][ 0 ], array( $_smarty_tpl->tpl_vars['keyword']->value ));
if (!(isset($_smarty_tpl->tpl_vars['__smarty_foreach_keywords']->value['last']) ? $_smarty_tpl->tpl_vars['__smarty_foreach_keywords']->value['last'] : null)) {
echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['translate'][0], array( array('key'=>"common.commaListSeparator"),$_smarty_tpl ) );
}?>
					<?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
				</span>
			</section>
			<?php }?>

						<?php if ($_smarty_tpl->tpl_vars['publication']->value->getLocalizedData('abstract')) {?>
				<section class="item abstract">
					<h2 class="label"><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['translate'][0], array( array('key'=>"article.abstract"),$_smarty_tpl ) );?>
</h2>
					<?php echo call_user_func_array($_smarty_tpl->registered_plugins[ 'modifier' ][ 'strip_unsafe_html' ][ 0 ], array( $_smarty_tpl->tpl_vars['publication']->value->getLocalizedData('abstract') ));?>

				</section>
			<?php }?>

			<?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['call_hook'][0], array( array('name'=>"Templates::Article::Main"),$_smarty_tpl ) );?>


						<?php $_smarty_tpl->_assignInScope('hasBiographies', 0);?>
			<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['publication']->value->getData('authors'), 'author');
$_smarty_tpl->tpl_vars['author']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['author']->value) {
$_smarty_tpl->tpl_vars['author']->do_else = false;
?>
				<?php if ($_smarty_tpl->tpl_vars['author']->value->getLocalizedData('biography')) {?>
					<?php $_smarty_tpl->_assignInScope('hasBiographies', $_smarty_tpl->tpl_vars['hasBiographies']->value+1);?>
				<?php }?>
			<?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
			<?php if ($_smarty_tpl->tpl_vars['hasBiographies']->value) {?>
				<section class="item author_bios">
					<h2 class="label">
						<?php if ($_smarty_tpl->tpl_vars['hasBiographies']->value > 1) {?>
							<?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['translate'][0], array( array('key'=>"submission.authorBiographies"),$_smarty_tpl ) );?>

						<?php } else { ?>
							<?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['translate'][0], array( array('key'=>"submission.authorBiography"),$_smarty_tpl ) );?>

						<?php }?>
					</h2>
					<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['publication']->value->getData('authors'), 'author');
$_smarty_tpl->tpl_vars['author']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['author']->value) {
$_smarty_tpl->tpl_vars['author']->do_else = false;
?>
						<?php if ($_smarty_tpl->tpl_vars['author']->value->getLocalizedData('biography')) {?>
							<section class="sub_item">
								<h3 class="label">
									<?php if ($_smarty_tpl->tpl_vars['author']->value->getLocalizedData('affiliation')) {?>
										<?php $_smarty_tpl->smarty->ext->_capture->open($_smarty_tpl, 'default', "authorName", null);
echo call_user_func_array($_smarty_tpl->registered_plugins[ 'modifier' ][ 'escape' ][ 0 ], array( $_smarty_tpl->tpl_vars['author']->value->getFullName() ));
$_smarty_tpl->smarty->ext->_capture->close($_smarty_tpl);?>
										<?php $_smarty_tpl->smarty->ext->_capture->open($_smarty_tpl, 'default', "authorAffiliation", null);?><span class="affiliation"><?php echo call_user_func_array($_smarty_tpl->registered_plugins[ 'modifier' ][ 'escape' ][ 0 ], array( $_smarty_tpl->tpl_vars['author']->value->getLocalizedData('affiliation') ));?>
</span><?php $_smarty_tpl->smarty->ext->_capture->close($_smarty_tpl);?>
										<?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['translate'][0], array( array('key'=>"submission.authorWithAffiliation",'name'=>$_smarty_tpl->tpl_vars['authorName']->value,'affiliation'=>$_smarty_tpl->tpl_vars['authorAffiliation']->value),$_smarty_tpl ) );?>

									<?php } else { ?>
										<?php echo call_user_func_array($_smarty_tpl->registered_plugins[ 'modifier' ][ 'escape' ][ 0 ], array( $_smarty_tpl->tpl_vars['author']->value->getFullName() ));?>

									<?php }?>
								</h3>
								<div class="value">
									<?php echo call_user_func_array($_smarty_tpl->registered_plugins[ 'modifier' ][ 'strip_unsafe_html' ][ 0 ], array( $_smarty_tpl->tpl_vars['author']->value->getLocalizedData('biography') ));?>

								</div>
							</section>
						<?php }?>
					<?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
				</section>
			<?php }?>

						<?php if ($_smarty_tpl->tpl_vars['parsedCitations']->value || $_smarty_tpl->tpl_vars['publication']->value->getData('citationsRaw')) {?>
				<section class="item references">
					<h2 class="label">
						<?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['translate'][0], array( array('key'=>"submission.citations"),$_smarty_tpl ) );?>

					</h2>
					<div class="value">
						<?php if ($_smarty_tpl->tpl_vars['parsedCitations']->value) {?>
							<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['parsedCitations']->value, 'parsedCitation');
$_smarty_tpl->tpl_vars['parsedCitation']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['parsedCitation']->value) {
$_smarty_tpl->tpl_vars['parsedCitation']->do_else = false;
?>
								<p><?php echo call_user_func_array($_smarty_tpl->registered_plugins[ 'modifier' ][ 'strip_unsafe_html' ][ 0 ], array( $_smarty_tpl->tpl_vars['parsedCitation']->value->getCitationWithLinks() ));?>
 <?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['call_hook'][0], array( array('name'=>"Templates::Article::Details::Reference",'citation'=>$_smarty_tpl->tpl_vars['parsedCitation']->value),$_smarty_tpl ) );?>
</p>
							<?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
						<?php } else { ?>
							<?php echo nl2br((string) call_user_func_array($_smarty_tpl->registered_plugins[ 'modifier' ][ 'escape' ][ 0 ], array( $_smarty_tpl->tpl_vars['publication']->value->getData('citationsRaw') )), (bool) 1);?>

						<?php }?>
					</div>
				</section>
			<?php }?>

		</div><!-- .main_entry -->

		<div class="entry_details">

						<?php if ($_smarty_tpl->tpl_vars['publication']->value->getLocalizedData('coverImage') || ($_smarty_tpl->tpl_vars['issue']->value && $_smarty_tpl->tpl_vars['issue']->value->getLocalizedCoverImage())) {?>
				<div class="item cover_image">
					<div class="sub_item">
						<?php if ($_smarty_tpl->tpl_vars['publication']->value->getLocalizedData('coverImage')) {?>
							<?php $_smarty_tpl->_assignInScope('coverImage', $_smarty_tpl->tpl_vars['publication']->value->getLocalizedData('coverImage'));?>
							<img
								src="<?php echo call_user_func_array($_smarty_tpl->registered_plugins[ 'modifier' ][ 'escape' ][ 0 ], array( $_smarty_tpl->tpl_vars['publication']->value->getLocalizedCoverImageUrl($_smarty_tpl->tpl_vars['article']->value->getData('contextId')) ));?>
"
								alt="<?php echo (($tmp = call_user_func_array($_smarty_tpl->registered_plugins[ 'modifier' ][ 'escape' ][ 0 ], array( $_smarty_tpl->tpl_vars['coverImage']->value['altText'] )) ?? null)===null||$tmp==='' ? '' ?? null : $tmp);?>
"
							>
						<?php } else { ?>
							<a href="<?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['url'][0], array( array('page'=>"issue",'op'=>"view",'path'=>$_smarty_tpl->tpl_vars['issue']->value->getBestIssueId()),$_smarty_tpl ) );?>
">
								<img src="<?php echo call_user_func_array($_smarty_tpl->registered_plugins[ 'modifier' ][ 'escape' ][ 0 ], array( $_smarty_tpl->tpl_vars['issue']->value->getLocalizedCoverImageUrl() ));?>
" alt="<?php echo (($tmp = call_user_func_array($_smarty_tpl->registered_plugins[ 'modifier' ][ 'escape' ][ 0 ], array( $_smarty_tpl->tpl_vars['issue']->value->getLocalizedCoverImageAltText() )) ?? null)===null||$tmp==='' ? '' ?? null : $tmp);?>
">
							</a>
						<?php }?>
					</div>
				</div>
			<?php }?>

						<?php if ($_smarty_tpl->tpl_vars['primaryGalleys']->value) {?>
				<div class="item galleys">
					<h2 class="pkp_screen_reader">
						<?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['translate'][0], array( array('key'=>"submission.downloads"),$_smarty_tpl ) );?>

					</h2>
					<ul class="value galleys_links">
						<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['primaryGalleys']->value, 'galley');
$_smarty_tpl->tpl_vars['galley']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['galley']->value) {
$_smarty_tpl->tpl_vars['galley']->do_else = false;
?>
							<li>
								<?php $_smarty_tpl->_subTemplateRender("app:frontend/objects/galley_link.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array('parent'=>$_smarty_tpl->tpl_vars['article']->value,'publication'=>$_smarty_tpl->tpl_vars['publication']->value,'galley'=>$_smarty_tpl->tpl_vars['galley']->value,'purchaseFee'=>$_smarty_tpl->tpl_vars['currentJournal']->value->getData('purchaseArticleFee'),'purchaseCurrency'=>$_smarty_tpl->tpl_vars['currentJournal']->value->getData('currency')), 0, true);
?>
							</li>
						<?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
					</ul>
				</div>
			<?php }?>
			<?php if ($_smarty_tpl->tpl_vars['supplementaryGalleys']->value) {?>
				<div class="item galleys">
					<h3 class="pkp_screen_reader">
						<?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['translate'][0], array( array('key'=>"submission.additionalFiles"),$_smarty_tpl ) );?>

					</h3>
					<ul class="value supplementary_galleys_links">
						<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['supplementaryGalleys']->value, 'galley');
$_smarty_tpl->tpl_vars['galley']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['galley']->value) {
$_smarty_tpl->tpl_vars['galley']->do_else = false;
?>
							<li>
								<?php $_smarty_tpl->_subTemplateRender("app:frontend/objects/galley_link.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array('parent'=>$_smarty_tpl->tpl_vars['article']->value,'publication'=>$_smarty_tpl->tpl_vars['publication']->value,'galley'=>$_smarty_tpl->tpl_vars['galley']->value,'isSupplementary'=>"1"), 0, true);
?>
							</li>
						<?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
					</ul>
				</div>
			<?php }?>

			<?php if ($_smarty_tpl->tpl_vars['publication']->value->getData('datePublished')) {?>
			<div class="item published">
				<section class="sub_item">
					<h2 class="label">
						<?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['translate'][0], array( array('key'=>"submissions.published"),$_smarty_tpl ) );?>

					</h2>
					<div class="value">
												<?php if ($_smarty_tpl->tpl_vars['firstPublication']->value->getID() === $_smarty_tpl->tpl_vars['publication']->value->getId()) {?>
							<span><?php echo smarty_modifier_date_format($_smarty_tpl->tpl_vars['firstPublication']->value->getData('datePublished'),$_smarty_tpl->tpl_vars['dateFormatShort']->value);?>
</span>
												<?php } else { ?>
							<span><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['translate'][0], array( array('key'=>"submission.updatedOn",'datePublished'=>smarty_modifier_date_format($_smarty_tpl->tpl_vars['firstPublication']->value->getData('datePublished'),$_smarty_tpl->tpl_vars['dateFormatShort']->value),'dateUpdated'=>smarty_modifier_date_format($_smarty_tpl->tpl_vars['publication']->value->getData('datePublished'),$_smarty_tpl->tpl_vars['dateFormatShort']->value)),$_smarty_tpl ) );?>
</span>
						<?php }?>
					</div>
				</section>
				<?php if (count($_smarty_tpl->tpl_vars['article']->value->getPublishedPublications()) > 1) {?>
					<section class="sub_item versions">
						<h2 class="label">
							<?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['translate'][0], array( array('key'=>"submission.versions"),$_smarty_tpl ) );?>

						</h2>
						<ul class="value">
							<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, array_reverse($_smarty_tpl->tpl_vars['article']->value->getPublishedPublications()), 'iPublication');
$_smarty_tpl->tpl_vars['iPublication']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['iPublication']->value) {
$_smarty_tpl->tpl_vars['iPublication']->do_else = false;
?>
								<?php $_smarty_tpl->smarty->ext->_capture->open($_smarty_tpl, 'default', "name", null);
echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['translate'][0], array( array('key'=>"submission.versionIdentity",'datePublished'=>smarty_modifier_date_format($_smarty_tpl->tpl_vars['iPublication']->value->getData('datePublished'),$_smarty_tpl->tpl_vars['dateFormatShort']->value),'version'=>$_smarty_tpl->tpl_vars['iPublication']->value->getData('version')),$_smarty_tpl ) );
$_smarty_tpl->smarty->ext->_capture->close($_smarty_tpl);?>
								<li>
									<?php if ($_smarty_tpl->tpl_vars['iPublication']->value->getId() === $_smarty_tpl->tpl_vars['publication']->value->getId()) {?>
										<?php echo $_smarty_tpl->tpl_vars['name']->value;?>

									<?php } elseif ($_smarty_tpl->tpl_vars['iPublication']->value->getId() === $_smarty_tpl->tpl_vars['currentPublication']->value->getId()) {?>
										<a href="<?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['url'][0], array( array('page'=>"article",'op'=>"view",'path'=>$_smarty_tpl->tpl_vars['article']->value->getBestId()),$_smarty_tpl ) );?>
"><?php echo $_smarty_tpl->tpl_vars['name']->value;?>
</a>
									<?php } else { ?>
										<a href="<?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['url'][0], array( array('page'=>"article",'op'=>"view",'path'=>call_user_func_array($_smarty_tpl->registered_plugins[ 'modifier' ][ 'to_array' ][ 0 ], array( $_smarty_tpl->tpl_vars['article']->value->getBestId(),"version",$_smarty_tpl->tpl_vars['iPublication']->value->getId() ))),$_smarty_tpl ) );?>
"><?php echo $_smarty_tpl->tpl_vars['name']->value;?>
</a>
									<?php }?>
								</li>
							<?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
						</ul>
					</section>
				<?php }?>
			</div>
			<?php }?>

						<?php if ($_smarty_tpl->tpl_vars['citation']->value) {?>
				<div class="item citation">
					<section class="sub_item citation_display">
						<h2 class="label">
							<?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['translate'][0], array( array('key'=>"submission.howToCite"),$_smarty_tpl ) );?>

						</h2>
						<div class="value">
							<div id="citationOutput" role="region" aria-live="polite">
								<?php echo $_smarty_tpl->tpl_vars['citation']->value;?>

							</div>
							<div class="citation_formats">
								<button class="cmp_button citation_formats_button" aria-controls="cslCitationFormats" aria-expanded="false" data-csl-dropdown="true">
									<?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['translate'][0], array( array('key'=>"submission.howToCite.citationFormats"),$_smarty_tpl ) );?>

								</button>
								<div id="cslCitationFormats" class="citation_formats_list" aria-hidden="true">
									<ul class="citation_formats_styles">
										<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['citationStyles']->value, 'citationStyle');
$_smarty_tpl->tpl_vars['citationStyle']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['citationStyle']->value) {
$_smarty_tpl->tpl_vars['citationStyle']->do_else = false;
?>
											<li>
												<a
													rel="nofollow"
													aria-controls="citationOutput"
													href="<?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['url'][0], array( array('page'=>"citationstylelanguage",'op'=>"get",'path'=>$_smarty_tpl->tpl_vars['citationStyle']->value['id'],'params'=>$_smarty_tpl->tpl_vars['citationArgs']->value),$_smarty_tpl ) );?>
"
													data-load-citation
													data-json-href="<?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['url'][0], array( array('page'=>"citationstylelanguage",'op'=>"get",'path'=>$_smarty_tpl->tpl_vars['citationStyle']->value['id'],'params'=>$_smarty_tpl->tpl_vars['citationArgsJson']->value),$_smarty_tpl ) );?>
"
												>
													<?php echo call_user_func_array($_smarty_tpl->registered_plugins[ 'modifier' ][ 'escape' ][ 0 ], array( $_smarty_tpl->tpl_vars['citationStyle']->value['title'] ));?>

												</a>
											</li>
										<?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
									</ul>
									<?php if (count($_smarty_tpl->tpl_vars['citationDownloads']->value)) {?>
										<div class="label">
											<?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['translate'][0], array( array('key'=>"submission.howToCite.downloadCitation"),$_smarty_tpl ) );?>

										</div>
										<ul class="citation_formats_styles">
											<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['citationDownloads']->value, 'citationDownload');
$_smarty_tpl->tpl_vars['citationDownload']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['citationDownload']->value) {
$_smarty_tpl->tpl_vars['citationDownload']->do_else = false;
?>
												<li>
													<a href="<?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['url'][0], array( array('page'=>"citationstylelanguage",'op'=>"download",'path'=>$_smarty_tpl->tpl_vars['citationDownload']->value['id'],'params'=>$_smarty_tpl->tpl_vars['citationArgs']->value),$_smarty_tpl ) );?>
">
														<span class="fa fa-download"></span>
														<?php echo call_user_func_array($_smarty_tpl->registered_plugins[ 'modifier' ][ 'escape' ][ 0 ], array( $_smarty_tpl->tpl_vars['citationDownload']->value['title'] ));?>

													</a>
												</li>
											<?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
										</ul>
									<?php }?>
								</div>
							</div>
						</div>
					</section>
				</div>
			<?php }?>

						<?php if ($_smarty_tpl->tpl_vars['issue']->value || $_smarty_tpl->tpl_vars['section']->value || $_smarty_tpl->tpl_vars['categories']->value) {?>
				<div class="item issue">

					<?php if ($_smarty_tpl->tpl_vars['issue']->value) {?>
						<section class="sub_item">
							<h2 class="label">
								<?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['translate'][0], array( array('key'=>"issue.issue"),$_smarty_tpl ) );?>

							</h2>
							<div class="value">
								<a class="title" href="<?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['url'][0], array( array('page'=>"issue",'op'=>"view",'path'=>$_smarty_tpl->tpl_vars['issue']->value->getBestIssueId()),$_smarty_tpl ) );?>
">
									<?php echo $_smarty_tpl->tpl_vars['issue']->value->getIssueIdentification();?>

								</a>
							</div>
						</section>
					<?php }?>

					<?php if ($_smarty_tpl->tpl_vars['section']->value) {?>
						<section class="sub_item">
							<h2 class="label">
								<?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['translate'][0], array( array('key'=>"section.section"),$_smarty_tpl ) );?>

							</h2>
							<div class="value">
								<?php echo call_user_func_array($_smarty_tpl->registered_plugins[ 'modifier' ][ 'escape' ][ 0 ], array( $_smarty_tpl->tpl_vars['section']->value->getLocalizedTitle() ));?>

							</div>
						</section>
					<?php }?>

					<?php if ($_smarty_tpl->tpl_vars['categories']->value) {?>
						<section class="sub_item">
							<h2 class="label">
								<?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['translate'][0], array( array('key'=>"category.category"),$_smarty_tpl ) );?>

							</h2>
							<div class="value">
								<ul class="categories">
									<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['categories']->value, 'category');
$_smarty_tpl->tpl_vars['category']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['category']->value) {
$_smarty_tpl->tpl_vars['category']->do_else = false;
?>
										<li><a href="<?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['url'][0], array( array('router'=>(defined('ROUTE_PAGE') ? constant('ROUTE_PAGE') : null),'page'=>"catalog",'op'=>"category",'path'=>call_user_func_array($_smarty_tpl->registered_plugins[ 'modifier' ][ 'escape' ][ 0 ], array( $_smarty_tpl->tpl_vars['category']->value->getPath() ))),$_smarty_tpl ) );?>
"><?php echo call_user_func_array($_smarty_tpl->registered_plugins[ 'modifier' ][ 'escape' ][ 0 ], array( $_smarty_tpl->tpl_vars['category']->value->getLocalizedTitle() ));?>
</a></li>
									<?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
								</ul>
							</div>
						</section>
					<?php }?>
				</div>
			<?php }?>

						<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['pubIdPlugins']->value, 'pubIdPlugin');
$_smarty_tpl->tpl_vars['pubIdPlugin']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['pubIdPlugin']->value) {
$_smarty_tpl->tpl_vars['pubIdPlugin']->do_else = false;
?>
				<?php if ($_smarty_tpl->tpl_vars['pubIdPlugin']->value->getPubIdType() == 'doi') {?>
					<?php continue 1;?>
				<?php }?>
				<?php $_smarty_tpl->_assignInScope('pubId', $_smarty_tpl->tpl_vars['article']->value->getStoredPubId($_smarty_tpl->tpl_vars['pubIdPlugin']->value->getPubIdType()));?>
				<?php if ($_smarty_tpl->tpl_vars['pubId']->value) {?>
					<section class="item pubid">
						<h2 class="label">
							<?php echo call_user_func_array($_smarty_tpl->registered_plugins[ 'modifier' ][ 'escape' ][ 0 ], array( $_smarty_tpl->tpl_vars['pubIdPlugin']->value->getPubIdDisplayType() ));?>

						</h2>
						<div class="value">
							<?php if (call_user_func_array($_smarty_tpl->registered_plugins[ 'modifier' ][ 'escape' ][ 0 ], array( $_smarty_tpl->tpl_vars['pubIdPlugin']->value->getResolvingURL($_smarty_tpl->tpl_vars['currentJournal']->value->getId(),$_smarty_tpl->tpl_vars['pubId']->value) ))) {?>
								<a id="pub-id::<?php echo call_user_func_array($_smarty_tpl->registered_plugins[ 'modifier' ][ 'escape' ][ 0 ], array( $_smarty_tpl->tpl_vars['pubIdPlugin']->value->getPubIdType() ));?>
" href="<?php echo call_user_func_array($_smarty_tpl->registered_plugins[ 'modifier' ][ 'escape' ][ 0 ], array( $_smarty_tpl->tpl_vars['pubIdPlugin']->value->getResolvingURL($_smarty_tpl->tpl_vars['currentJournal']->value->getId(),$_smarty_tpl->tpl_vars['pubId']->value) ));?>
">
									<?php echo call_user_func_array($_smarty_tpl->registered_plugins[ 'modifier' ][ 'escape' ][ 0 ], array( $_smarty_tpl->tpl_vars['pubIdPlugin']->value->getResolvingURL($_smarty_tpl->tpl_vars['currentJournal']->value->getId(),$_smarty_tpl->tpl_vars['pubId']->value) ));?>

								</a>
							<?php } else { ?>
								<?php echo call_user_func_array($_smarty_tpl->registered_plugins[ 'modifier' ][ 'escape' ][ 0 ], array( $_smarty_tpl->tpl_vars['pubId']->value ));?>

							<?php }?>
						</div>
					</section>
				<?php }?>
			<?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>

						<?php if ($_smarty_tpl->tpl_vars['currentContext']->value->getLocalizedData('licenseTerms') || $_smarty_tpl->tpl_vars['publication']->value->getData('licenseUrl')) {?>
				<div class="item copyright">
					<h2 class="label">
						<?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['translate'][0], array( array('key'=>"submission.license"),$_smarty_tpl ) );?>

					</h2>
					<?php if ($_smarty_tpl->tpl_vars['publication']->value->getData('licenseUrl')) {?>
						<?php if ($_smarty_tpl->tpl_vars['ccLicenseBadge']->value) {?>
							<?php if ($_smarty_tpl->tpl_vars['publication']->value->getLocalizedData('copyrightHolder')) {?>
								<p><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['translate'][0], array( array('key'=>"submission.copyrightStatement",'copyrightHolder'=>$_smarty_tpl->tpl_vars['publication']->value->getLocalizedData('copyrightHolder'),'copyrightYear'=>$_smarty_tpl->tpl_vars['publication']->value->getData('copyrightYear')),$_smarty_tpl ) );?>
</p>
							<?php }?>
							<?php echo $_smarty_tpl->tpl_vars['ccLicenseBadge']->value;?>

						<?php } else { ?>
							<a href="<?php echo call_user_func_array($_smarty_tpl->registered_plugins[ 'modifier' ][ 'escape' ][ 0 ], array( $_smarty_tpl->tpl_vars['publication']->value->getData('licenseUrl') ));?>
" class="copyright">
								<?php if ($_smarty_tpl->tpl_vars['publication']->value->getLocalizedData('copyrightHolder')) {?>
									<?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['translate'][0], array( array('key'=>"submission.copyrightStatement",'copyrightHolder'=>$_smarty_tpl->tpl_vars['publication']->value->getLocalizedData('copyrightHolder'),'copyrightYear'=>$_smarty_tpl->tpl_vars['publication']->value->getData('copyrightYear')),$_smarty_tpl ) );?>

								<?php } else { ?>
									<?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['translate'][0], array( array('key'=>"submission.license"),$_smarty_tpl ) );?>

								<?php }?>
							</a>
						<?php }?>
					<?php }?>
					<?php echo $_smarty_tpl->tpl_vars['currentContext']->value->getLocalizedData('licenseTerms');?>

				</div>
			<?php }?>

			<?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['call_hook'][0], array( array('name'=>"Templates::Article::Details"),$_smarty_tpl ) );?>


		</div><!-- .entry_details -->
	</div><!-- .row -->

		<div class="article-metrics-map article-metrics-map--fullwidth" id="articleMetricsMap" data-article-id="<?php echo $_smarty_tpl->tpl_vars['article']->value->getId();?>
">
		<div class="metrics-header">
			<div class="metrics-title">Global Readership</div>
			<div class="metrics-stats">
				<span class="metric-badge"><span class="metric-icon">👁</span> <span id="mapViews">—</span> views</span>
				<span class="metric-badge"><span class="metric-icon">⬇</span> <span id="mapDownloads">—</span> downloads</span>
			</div>
			<div class="metrics-legend" style="display:flex;gap:12px;margin-top:8px;font-size:11px;">
				<span style="display:flex;align-items:center;gap:4px;"><span style="width:12px;height:12px;border-radius:50%;background:#00ffff;box-shadow:0 0 8px #00ffff;"></span> Views</span>
				<span style="display:flex;align-items:center;gap:4px;"><span style="width:12px;height:12px;border-radius:50%;background:#ffff00;box-shadow:0 0 8px #ffff00;"></span> Downloads</span>
				<span style="display:flex;align-items:center;gap:4px;"><span style="width:12px;height:12px;border-radius:50%;background:#ff00ff;box-shadow:0 0 8px #ff00ff;"></span> Citations</span>
			</div>
		</div>
		<div class="globe-container" id="globeContainer"></div>
		<div class="metrics-countries" id="mapCountries">
			<div class="globe-loading">Loading metrics...</div>
		</div>
	</div>

	<?php echo '<script'; ?>
 src="https://unpkg.com/three@0.158.0/build/three.min.js"><?php echo '</script'; ?>
>
	<?php echo '<script'; ?>
 src="https://unpkg.com/globe.gl@2.27.2/dist/globe.gl.min.js"><?php echo '</script'; ?>
>
	<?php echo '<script'; ?>
>
	(function() {
		var API_BASE = 'http://localhost:3001';
		var articleId = parseInt(document.getElementById('articleMetricsMap').getAttribute('data-article-id')) || 1;

		var COUNTRY_GEO = {
			'TZ': { lat: -6.37, lng: 34.89, name: 'Tanzania' },
			'KE': { lat: -0.02, lng: 37.91, name: 'Kenya' },
			'UG': { lat: 1.37, lng: 32.29, name: 'Uganda' },
			'ZA': { lat: -30.56, lng: 22.94, name: 'South Africa' },
			'NG': { lat: 9.08, lng: 8.68, name: 'Nigeria' },
			'US': { lat: 37.09, lng: -95.71, name: 'United States' },
			'GB': { lat: 55.38, lng: -3.44, name: 'United Kingdom' },
			'IN': { lat: 20.59, lng: 78.96, name: 'India' },
			'ET': { lat: 9.15, lng: 40.49, name: 'Ethiopia' },
			'RW': { lat: -1.94, lng: 29.87, name: 'Rwanda' },
			'DE': { lat: 51.17, lng: 10.45, name: 'Germany' },
			'AU': { lat: -25.27, lng: 133.78, name: 'Australia' },
			'CN': { lat: 35.86, lng: 104.20, name: 'China' },
			'MZ': { lat: -18.67, lng: 35.53, name: 'Mozambique' },
			'GH': { lat: 7.95, lng: -1.02, name: 'Ghana' },
			'MW': { lat: -13.25, lng: 34.30, name: 'Malawi' },
			'ZM': { lat: -13.13, lng: 28.64, name: 'Zambia' },
			'BW': { lat: -22.33, lng: 24.68, name: 'Botswana' },
			'CD': { lat: -4.04, lng: 21.76, name: 'DR Congo' },
			'SD': { lat: 12.86, lng: 30.22, name: 'Sudan' },
			'EG': { lat: 26.82, lng: 30.80, name: 'Egypt' },
			'MA': { lat: 31.79, lng: -7.09, name: 'Morocco' },
			'FR': { lat: 46.23, lng: 2.21, name: 'France' },
			'IT': { lat: 41.87, lng: 12.57, name: 'Italy' },
			'ES': { lat: 40.46, lng: -3.75, name: 'Spain' },
			'NL': { lat: 52.13, lng: 5.29, name: 'Netherlands' },
			'SE': { lat: 60.13, lng: 18.64, name: 'Sweden' },
			'NO': { lat: 60.47, lng: 8.47, name: 'Norway' },
			'CA': { lat: 56.13, lng: -106.35, name: 'Canada' },
			'BR': { lat: -14.24, lng: -51.93, name: 'Brazil' },
			'JP': { lat: 36.20, lng: 138.25, name: 'Japan' },
			'KR': { lat: 35.91, lng: 127.77, name: 'South Korea' },
			'PH': { lat: 12.88, lng: 121.77, name: 'Philippines' },
			'MY': { lat: 4.21, lng: 101.98, name: 'Malaysia' },
			'SG': { lat: 1.35, lng: 103.82, name: 'Singapore' },
			'PK': { lat: 30.38, lng: 69.35, name: 'Pakistan' },
			'BD': { lat: 23.68, lng: 90.36, name: 'Bangladesh' },
			'AE': { lat: 23.42, lng: 53.85, name: 'UAE' },
			'SA': { lat: 23.89, lng: 45.08, name: 'Saudi Arabia' },
			'RU': { lat: 61.52, lng: 105.32, name: 'Russia' },
		};

		fetch(API_BASE + '/api/article/' + articleId + '/metrics')
			.then(function(r) { return r.json(); })
			.then(function(data) { renderGlobe(data); })
			.catch(function(err) {
				console.warn('Metrics API unavailable:', err);
				renderGlobe(null);
			});

		// Metric type colors - BRIGHT and visible from afar
		var METRIC_COLORS = {
			views: '#00ffff',      // Cyan - very bright
			downloads: '#ffff00',  // Yellow - very bright
			citations: '#ff00ff'   // Magenta - very bright
		};

		function renderGlobe(data) {
			var views = 0, downloads = 0, pointsData = [], countryData = [];

			if (data && data.views !== undefined) {
				views = data.views;
				downloads = data.downloads;
				
				// Process views by country (real or distributed)
				var viewsByCountry = data.viewsByCountry || [];
				var maxViews = 1;
				viewsByCountry.forEach(function(c) { if (c.total > maxViews) maxViews = c.total; });
				
				viewsByCountry.forEach(function(c) {
					var code = (c.country_id || '').toUpperCase();
					var geo = COUNTRY_GEO[code];
					if (!geo || !c.total) return;
					
					pointsData.push({
						lat: geo.lat,
						lng: geo.lng,
						name: geo.name,
						code: code.toLowerCase(),
						total: c.total,
						type: 'views',
						color: METRIC_COLORS.views,
						size: 0.5 + (c.total / maxViews) * 1.2
					});
					
					// Build country tags from views data
					countryData.push({ name: geo.name, code: code.toLowerCase(), total: c.total });
				});
				
				// Process downloads by country (real or distributed)
				var downloadsByCountry = data.downloadsByCountry || [];
				var maxDownloads = 1;
				downloadsByCountry.forEach(function(c) { if (c.total > maxDownloads) maxDownloads = c.total; });
				
				downloadsByCountry.forEach(function(c) {
					var code = (c.country_id || '').toUpperCase();
					var geo = COUNTRY_GEO[code];
					if (!geo || !c.total) return;
					
					pointsData.push({
						lat: geo.lat + 1.5,
						lng: geo.lng + 1.5,
						name: geo.name,
						code: code.toLowerCase(),
						total: c.total,
						type: 'downloads',
						color: METRIC_COLORS.downloads,
						size: 0.5 + (c.total / maxDownloads) * 1.2
					});
				});
			}

			console.log('Article globe: views=' + views + ', downloads=' + downloads + ', points=' + pointsData.length);

			document.getElementById('mapViews').textContent = views.toLocaleString();
			document.getElementById('mapDownloads').textContent = downloads.toLocaleString();

			var container = document.getElementById('globeContainer');
			var width = container.offsetWidth;
			var height = Math.max(420, width * 0.55);
			container.style.height = height + 'px';

			var globe = Globe()
				.globeImageUrl('https://unpkg.com/three-globe/example/img/earth-blue-marble.jpg')
				.bumpImageUrl('https://unpkg.com/three-globe/example/img/earth-topology.png')
				.backgroundImageUrl('')
				.backgroundColor('rgba(0,0,0,0)')
				.width(width)
				.height(height)
				.atmosphereColor('#1E6292')
				.atmosphereAltitude(0.2)
				.pointsData(pointsData)
				.pointLat('lat')
				.pointLng('lng')
				.pointAltitude(0.01)
				.pointRadius(function(d) { return d.size; })
				.pointColor('color')
				.pointsMerge(false)
				.pointLabel(function(d) {
					var icon = d.type === 'views' ? '👁' : (d.type === 'downloads' ? '📥' : '📝');
					var label = d.type === 'views' ? 'Views' : (d.type === 'downloads' ? 'Downloads' : 'Citations');
					return '<div style="background:rgba(15,23,42,0.9);padding:8px 12px;border-radius:10px;border:1px solid rgba(255,255,255,0.1);font-size:11px;color:#e2e8f0;">'
						+ '<div style="font-weight:600;color:' + d.color + ';">' + d.name + '</div>'
						+ '<div style="margin-top:3px;">' + icon + ' ' + label + ': <strong>' + d.total.toLocaleString() + '</strong></div>'
						+ '</div>';
				})
				(container);

			globe.controls().autoRotate = true;
			globe.controls().autoRotateSpeed = 0.8;
			globe.controls().enableZoom = true;
			globe.controls().minDistance = 150;
			globe.controls().maxDistance = 500;

			// Start camera pointing at Tanzania
			globe.pointOfView({ lat: -6.37, lng: 34.89, altitude: 2.0 }, 1500);

			// Country tags below globe
			var tagsEl = document.getElementById('mapCountries');
			if (countryData.length === 0) {
				tagsEl.innerHTML = '<span class="globe-no-data">No geographic data available for this article</span>';
				return;
			}
			var tagsHtml = '';
			countryData.forEach(function(c) {
				tagsHtml += '<span class="country-tag">'
					+ '<img src="https://flagcdn.com/24x18/' + c.code + '.png" alt="' + c.name + '">'
					+ c.name + ' <strong>' + c.total.toLocaleString() + '</strong>'
					+ '</span>';
			});
			tagsEl.innerHTML = tagsHtml;

			// Responsive resize
			window.addEventListener('resize', function() {
				var w = container.parentElement.offsetWidth;
				var h = Math.max(420, w * 0.55);
				container.style.height = h + 'px';
				globe.width(w).height(h);
			});
		}
	})();
	<?php echo '</script'; ?>
>

</article>
<?php }
}
