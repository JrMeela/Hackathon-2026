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
	<section id="analytics" class="analytics_dashboard_section" style="display: none; margin-bottom: 2rem;">
		<div style="background: #1e293b; border-radius: 12px; overflow: hidden; box-shadow: 0 4px 24px rgba(0,0,0,0.2);">
			<div style="padding: 12px 20px; background: linear-gradient(135deg, #1e3a5f, #0f172a); border-bottom: 1px solid #334155; display: flex; align-items: center; gap: 10px;">
				<span style="display: inline-block; width: 10px; height: 10px; border-radius: 50%; background: #3b82f6; animation: pulse 2s infinite;"></span>
				<h2 style="margin: 0; font-size: 16px; font-weight: 600; color: #e2e8f0; letter-spacing: 0.5px;">📊 Analytics Dashboard</h2>
			</div>
			<iframe
				id="analyticsIframe"
				style="width: 100%; height: 900px; border: none; overflow: hidden;"
				title="UDSM Journal Analytics Dashboard"
				allow="accelerometer; autoplay"
			></iframe>
		</div>
	</section>
	<style>
		@keyframes pulse { 0%, 100% { opacity: 1; } 50% { opacity: 0.4; } }
	</style>
	<script>
	(function() {
		var analyticsSection = document.getElementById('analytics');
		var analyticsIframe = document.getElementById('analyticsIframe');
		var mainContent = document.querySelector('.page_index_journal');
		var contentWrapper = document.querySelector('.pkp_structure_content');
		var sidebar = document.querySelector('.pkp_structure_sidebar');

		function toggleAnalytics() {
			if (window.location.hash === '#analytics') {
				analyticsSection.style.display = 'block';
				// Lazy-load iframe only when Analytics tab is clicked
				if (!analyticsIframe.src || analyticsIframe.src === window.location.href) {
					analyticsIframe.src = 'http://localhost:3000';
				}
				// Hide sidebar and go full-width
				if (sidebar) sidebar.style.display = 'none';
				if (contentWrapper) {
					contentWrapper.classList.remove('has_sidebar');
					contentWrapper.style.maxWidth = '100%';
				}
				if (mainContent) mainContent.style.maxWidth = '100%';
				// Hide other homepage sections
				var siblings = mainContent.children;
				for (var i = 0; i < siblings.length; i++) {
					if (siblings[i].id !== 'analytics' && siblings[i].tagName !== 'STYLE' && siblings[i].tagName !== 'SCRIPT') {
						siblings[i].style.display = 'none';
					}
				}
			} else {
				analyticsSection.style.display = 'none';
				// Restore sidebar and layout
				if (sidebar) sidebar.style.display = '';
				if (contentWrapper) {
					contentWrapper.classList.add('has_sidebar');
					contentWrapper.style.maxWidth = '';
				}
				if (mainContent) mainContent.style.maxWidth = '';
				// Show other homepage sections
				var siblings = mainContent.children;
				for (var i = 0; i < siblings.length; i++) {
					if (siblings[i].id !== 'analytics' && siblings[i].tagName !== 'STYLE' && siblings[i].tagName !== 'SCRIPT') {
						siblings[i].style.display = '';
					}
				}
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
