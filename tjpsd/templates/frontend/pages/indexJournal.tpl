{**
 * templates/frontend/pages/indexJournal.tpl
 *
 * Copyright (c) 2014-2021 Simon Fraser University
 * Copyright (c) 2003-2021 John Willinsky
 * Distributed under the GNU GPL v3. For full terms see the file docs/COPYING.
 *
 * @brief Display the index page for a journal
 *
 * @uses $currentJournal Journal This journal
 * @uses $journalDescription string Journal description from HTML text editor
 * @uses $homepageImage object Image to be displayed on the homepage
 * @uses $additionalHomeContent string Arbitrary input from HTML text editor
 * @uses $announcements array List of announcements
 * @uses $numAnnouncementsHomepage int Number of announcements to display on the
 *       homepage
 * @uses $issue Issue Current issue
 *}
{include file="frontend/components/header.tpl" pageTitleTranslated=$currentJournal->getLocalizedName()}

<div class="page_index_journal">

	{* UDSM Journal Analytics Dashboard — Hidden by default, shown only when #analytics is active *}
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
	<script>
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
	</script>

	{call_hook name="Templates::Index::journal"}

	{if !$activeTheme->getOption('useHomepageImageAsHeader') && $homepageImage}
		<div class="homepage_image">
			<img src="{$publicFilesDir}/{$homepageImage.uploadName|escape:"url"}"{if $homepageImage.altText} alt="{$homepageImage.altText|escape}"{/if}>
		</div>
	{/if}

	{* Journal Description *}
	{if $activeTheme->getOption('showDescriptionInJournalIndex')}
		<section class="homepage_about">
			<a id="homepageAbout"></a>
			<h2>{translate key="about.aboutContext"}</h2>
			{$currentContext->getLocalizedData('description')}
		</section>
	{/if}

	{* Announcements *}
	{if $numAnnouncementsHomepage && $announcements|@count}
		<section class="cmp_announcements highlight_first">
			<a id="homepageAnnouncements"></a>
			<h2>
				{translate key="announcement.announcements"}
			</h2>
			{foreach name=announcements from=$announcements item=announcement}
				{if $smarty.foreach.announcements.iteration > $numAnnouncementsHomepage}
					{break}
				{/if}
				{if $smarty.foreach.announcements.iteration == 1}
					{include file="frontend/objects/announcement_summary.tpl" heading="h3"}
					<div class="more">
				{else}
					<article class="obj_announcement_summary">
						<h4>
							<a href="{url router=$smarty.const.ROUTE_PAGE page="announcement" op="view" path=$announcement->getId()}">
								{$announcement->getLocalizedTitle()|escape}
							</a>
						</h4>
						<div class="date">
							{$announcement->getDatePosted()|date_format:$dateFormatShort}
						</div>
					</article>
				{/if}
			{/foreach}
			</div><!-- .more -->
		</section>
	{/if}

	{* Latest issue *}
	{if $issue}
		<section class="current_issue">
			<a id="homepageIssue"></a>
			<h2>
				{translate key="journal.currentIssue"}
			</h2>
			<div class="current_issue_title">
				{$issue->getIssueIdentification()|strip_unsafe_html}
			</div>
			{include file="frontend/objects/issue_toc.tpl" heading="h3"}
			<a href="{url router=$smarty.const.ROUTE_PAGE page="issue" op="archive"}" class="read_more">
				{translate key="journal.viewAllIssues"}
			</a>
		</section>
	{/if}

	{* Additional Homepage Content *}
	{if $additionalHomeContent}
		<div class="additional_content">
			{$additionalHomeContent}
		</div>
	{/if}
</div><!-- .page -->

{include file="frontend/components/footer.tpl"}
