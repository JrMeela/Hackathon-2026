<?php
/* Smarty version 4.3.1, created on 2026-02-14 17:04:31
  from 'app:frontendpagesindexJournal.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '4.3.1',
  'unifunc' => 'content_69909d0f0ead80_53735751',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'e64e579388e5615e11e939b12134d6ae8679eba6' => 
    array (
      0 => 'app:frontendpagesindexJournal.tpl',
      1 => 1771084904,
      2 => 'app',
    ),
  ),
  'includes' => 
  array (
    'app:frontend/components/header.tpl' => 1,
    'app:frontend/objects/announcement_summary.tpl' => 1,
    'app:frontend/objects/issue_toc.tpl' => 1,
    'app:frontend/components/footer.tpl' => 1,
  ),
),false)) {
function content_69909d0f0ead80_53735751 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_checkPlugins(array(0=>array('file'=>'C:\\Users\\junio\\Hackathon-2026\\tjpsd\\lib\\pkp\\lib\\vendor\\smarty\\smarty\\libs\\plugins\\modifier.count.php','function'=>'smarty_modifier_count',),1=>array('file'=>'C:\\Users\\junio\\Hackathon-2026\\tjpsd\\lib\\pkp\\lib\\vendor\\smarty\\smarty\\libs\\plugins\\modifier.date_format.php','function'=>'smarty_modifier_date_format',),));
$_smarty_tpl->_subTemplateRender("app:frontend/components/header.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array('pageTitleTranslated'=>$_smarty_tpl->tpl_vars['currentJournal']->value->getLocalizedName()), 0, false);
?>

<div class="page_index_journal">

		<section id="analytics" class="analytics_dashboard_section" style="display: none;">
		<iframe
			id="analyticsIframe"
			style="width: 100%; border: none; overflow: hidden;"
			title="UDSM Journal Analytics Dashboard"
			allow="accelerometer; autoplay"
		></iframe>
	</section>
	<style>
		.analytics_dashboard_section.active {
			position: fixed;
			left: 0;
			width: 100vw;
			background: #0f172a;
			z-index: 100;
			margin: 0;
			padding: 0;
		}
		.analytics_dashboard_section.active iframe {
			width: 100%;
			height: 100%;
		}
		.pkp_structure_head {
			position: relative;
			z-index: 200;
		}
	</style>
	<?php echo '<script'; ?>
>
	(function() {
		var analyticsSection = document.getElementById('analytics');
		var analyticsIframe = document.getElementById('analyticsIframe');
		var mainContent = document.querySelector('.page_index_journal');
		var contentWrapper = document.querySelector('.pkp_structure_content');
		var sidebar = document.querySelector('.pkp_structure_sidebar');
		var header = document.querySelector('.pkp_structure_head');

		function toggleAnalytics() {
			if (window.location.hash === '#analytics') {
				analyticsSection.style.display = 'block';
				analyticsSection.classList.add('active');
				// Lazy-load iframe only when Analytics tab is clicked
				if (!analyticsIframe.src || analyticsIframe.src === window.location.href) {
					analyticsIframe.src = 'http://localhost:3000';
				}
				// Hide sidebar
				if (sidebar) sidebar.style.display = 'none';
				// Make content full-width
				if (contentWrapper) {
					contentWrapper.classList.remove('has_sidebar');
					contentWrapper.style.cssText = 'max-width:100%;width:100%;padding:0;margin:0;';
				}
				if (mainContent) {
					mainContent.style.cssText = 'max-width:100%;width:100%;padding:0;margin:0;';
				}
				// Position below header, fill remaining viewport
				if (header) {
					var headerHeight = header.offsetHeight;
					analyticsSection.style.top = headerHeight + 'px';
					analyticsSection.style.height = 'calc(100vh - ' + headerHeight + 'px)';
				}
				// Hide other homepage sections
				var siblings = mainContent.children;
				for (var i = 0; i < siblings.length; i++) {
					if (siblings[i].id !== 'analytics' && siblings[i].tagName !== 'STYLE' && siblings[i].tagName !== 'SCRIPT') {
						siblings[i].style.display = 'none';
					}
				}
				document.body.style.overflow = 'hidden';
			} else {
				analyticsSection.style.display = 'none';
				analyticsSection.classList.remove('active');
				// Restore sidebar and layout
				if (sidebar) sidebar.style.display = '';
				if (contentWrapper) {
					contentWrapper.classList.add('has_sidebar');
					contentWrapper.style.cssText = '';
				}
				if (mainContent) mainContent.style.cssText = '';
				// Show other homepage sections
				var siblings = mainContent.children;
				for (var i = 0; i < siblings.length; i++) {
					if (siblings[i].id !== 'analytics' && siblings[i].tagName !== 'STYLE' && siblings[i].tagName !== 'SCRIPT') {
						siblings[i].style.display = '';
					}
				}
				document.body.style.overflow = '';
			}
		}

		window.addEventListener('hashchange', toggleAnalytics);
		toggleAnalytics();
	})();
	<?php echo '</script'; ?>
>

	<?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['call_hook'][0], array( array('name'=>"Templates::Index::journal"),$_smarty_tpl ) );?>


	<?php if (!$_smarty_tpl->tpl_vars['activeTheme']->value->getOption('useHomepageImageAsHeader') && $_smarty_tpl->tpl_vars['homepageImage']->value) {?>
		<div class="homepage_image">
			<img src="<?php echo $_smarty_tpl->tpl_vars['publicFilesDir']->value;?>
/<?php echo call_user_func_array($_smarty_tpl->registered_plugins[ 'modifier' ][ 'escape' ][ 0 ], array( $_smarty_tpl->tpl_vars['homepageImage']->value['uploadName'],"url" ));?>
"<?php if ($_smarty_tpl->tpl_vars['homepageImage']->value['altText']) {?> alt="<?php echo call_user_func_array($_smarty_tpl->registered_plugins[ 'modifier' ][ 'escape' ][ 0 ], array( $_smarty_tpl->tpl_vars['homepageImage']->value['altText'] ));?>
"<?php }?>>
		</div>
	<?php }?>

		<?php if ($_smarty_tpl->tpl_vars['activeTheme']->value->getOption('showDescriptionInJournalIndex')) {?>
		<section class="homepage_about">
			<a id="homepageAbout"></a>
			<h2><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['translate'][0], array( array('key'=>"about.aboutContext"),$_smarty_tpl ) );?>
</h2>
			<?php echo $_smarty_tpl->tpl_vars['currentContext']->value->getLocalizedData('description');?>

		</section>
	<?php }?>

		<?php if ($_smarty_tpl->tpl_vars['numAnnouncementsHomepage']->value && smarty_modifier_count($_smarty_tpl->tpl_vars['announcements']->value)) {?>
		<section class="cmp_announcements highlight_first">
			<a id="homepageAnnouncements"></a>
			<h2>
				<?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['translate'][0], array( array('key'=>"announcement.announcements"),$_smarty_tpl ) );?>

			</h2>
			<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['announcements']->value, 'announcement', false, NULL, 'announcements', array (
  'iteration' => true,
));
$_smarty_tpl->tpl_vars['announcement']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['announcement']->value) {
$_smarty_tpl->tpl_vars['announcement']->do_else = false;
$_smarty_tpl->tpl_vars['__smarty_foreach_announcements']->value['iteration']++;
?>
				<?php if ((isset($_smarty_tpl->tpl_vars['__smarty_foreach_announcements']->value['iteration']) ? $_smarty_tpl->tpl_vars['__smarty_foreach_announcements']->value['iteration'] : null) > $_smarty_tpl->tpl_vars['numAnnouncementsHomepage']->value) {?>
					<?php break 1;?>
				<?php }?>
				<?php if ((isset($_smarty_tpl->tpl_vars['__smarty_foreach_announcements']->value['iteration']) ? $_smarty_tpl->tpl_vars['__smarty_foreach_announcements']->value['iteration'] : null) == 1) {?>
					<?php $_smarty_tpl->_subTemplateRender("app:frontend/objects/announcement_summary.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array('heading'=>"h3"), 0, true);
?>
					<div class="more">
				<?php } else { ?>
					<article class="obj_announcement_summary">
						<h4>
							<a href="<?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['url'][0], array( array('router'=>(defined('ROUTE_PAGE') ? constant('ROUTE_PAGE') : null),'page'=>"announcement",'op'=>"view",'path'=>$_smarty_tpl->tpl_vars['announcement']->value->getId()),$_smarty_tpl ) );?>
">
								<?php echo call_user_func_array($_smarty_tpl->registered_plugins[ 'modifier' ][ 'escape' ][ 0 ], array( $_smarty_tpl->tpl_vars['announcement']->value->getLocalizedTitle() ));?>

							</a>
						</h4>
						<div class="date">
							<?php echo smarty_modifier_date_format($_smarty_tpl->tpl_vars['announcement']->value->getDatePosted(),$_smarty_tpl->tpl_vars['dateFormatShort']->value);?>

						</div>
					</article>
				<?php }?>
			<?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
			</div><!-- .more -->
		</section>
	<?php }?>

		<?php if ($_smarty_tpl->tpl_vars['issue']->value) {?>
		<section class="current_issue">
			<a id="homepageIssue"></a>
			<h2>
				<?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['translate'][0], array( array('key'=>"journal.currentIssue"),$_smarty_tpl ) );?>

			</h2>
			<div class="current_issue_title">
				<?php echo call_user_func_array($_smarty_tpl->registered_plugins[ 'modifier' ][ 'strip_unsafe_html' ][ 0 ], array( $_smarty_tpl->tpl_vars['issue']->value->getIssueIdentification() ));?>

			</div>
			<?php $_smarty_tpl->_subTemplateRender("app:frontend/objects/issue_toc.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array('heading'=>"h3"), 0, false);
?>
			<a href="<?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['url'][0], array( array('router'=>(defined('ROUTE_PAGE') ? constant('ROUTE_PAGE') : null),'page'=>"issue",'op'=>"archive"),$_smarty_tpl ) );?>
" class="read_more">
				<?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['translate'][0], array( array('key'=>"journal.viewAllIssues"),$_smarty_tpl ) );?>

			</a>
		</section>
	<?php }?>

		<?php if ($_smarty_tpl->tpl_vars['additionalHomeContent']->value) {?>
		<div class="additional_content">
			<?php echo $_smarty_tpl->tpl_vars['additionalHomeContent']->value;?>

		</div>
	<?php }?>
</div><!-- .page -->

<?php $_smarty_tpl->_subTemplateRender("app:frontend/components/footer.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
}
}
