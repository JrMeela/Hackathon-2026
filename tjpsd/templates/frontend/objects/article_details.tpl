{**
 * templates/frontend/objects/article_details.tpl
 *
 * Copyright (c) 2014-2021 Simon Fraser University
 * Copyright (c) 2003-2021 John Willinsky
 * Distributed under the GNU GPL v3. For full terms see the file docs/COPYING.
 *
 * @brief View of an Article which displays all details about the article.
 *  Expected to be primary object on the page.
 *
 * Many journals will want to add custom data to this object, either through
 * plugins which attach to hooks on the page or by editing the template
 * themselves. In order to facilitate this, a flexible layout markup pattern has
 * been implemented. If followed, plugins and other content can provide markup
 * in a way that will render consistently with other items on the page. This
 * pattern is used in the .main_entry column and the .entry_details column. It
 * consists of the following:
 *
 * <!-- Wrapper class which provides proper spacing between components -->
 * <div class="item">
 *     <!-- Title/value combination -->
 *     <div class="label">Abstract</div>
 *     <div class="value">Value</div>
 * </div>
 *
 * All styling should be applied by class name, so that titles may use heading
 * elements (eg, <h3>) or any element required.
 *
 * <!-- Example: component with multiple title/value combinations -->
 * <div class="item">
 *     <div class="sub_item">
 *         <div class="label">DOI</div>
 *         <div class="value">12345678</div>
 *     </div>
 *     <div class="sub_item">
 *         <div class="label">Published Date</div>
 *         <div class="value">2015-01-01</div>
 *     </div>
 * </div>
 *
 * <!-- Example: component with no title -->
 * <div class="item">
 *     <div class="value">Whatever you'd like</div>
 * </div>
 *
 * Core components are produced manually below, but can also be added via
 * plugins using the hooks provided:
 *
 * Templates::Article::Main
 * Templates::Article::Details
 *
 * @uses $article Submission This article
 * @uses $publication Publication The publication being displayed
 * @uses $firstPublication Publication The first published version of this article
 * @uses $currentPublication Publication The most recently published version of this article
 * @uses $issue Issue The issue this article is assigned to
 * @uses $section Section The journal section this article is assigned to
 * @uses $categories Category The category this article is assigned to
 * @uses $primaryGalleys array List of article galleys that are not supplementary or dependent
 * @uses $supplementaryGalleys array List of article galleys that are supplementary
 * @uses $keywords array List of keywords assigned to this article
 * @uses $pubIdPlugins Array of pubId plugins which this article may be assigned
 * @uses $licenseTerms string License terms.
 * @uses $licenseUrl string URL to license. Only assigned if license should be
 *   included with published submissions.
 * @uses $ccLicenseBadge string An image and text with details about the license
 *}
 {if !$heading}
 	{assign var="heading" value="h3"}
 {/if}
<article class="obj_article_details">

	{* Indicate if this is only a preview *}
	{if $publication->getData('status') !== $smarty.const.STATUS_PUBLISHED}
	<div class="cmp_notification notice">
		{capture assign="submissionUrl"}{url page="workflow" op="access" path=$article->getId()}{/capture}
		{translate key="submission.viewingPreview" url=$submissionUrl}
	</div>
	{* Notification that this is an old version *}
	{elseif $currentPublication->getId() !== $publication->getId()}
		<div class="cmp_notification notice">
			{capture assign="latestVersionUrl"}{url page="article" op="view" path=$article->getBestId()}{/capture}
			{translate key="submission.outdatedVersion"
				datePublished=$publication->getData('datePublished')|date_format:$dateFormatShort
				urlRecentVersion=$latestVersionUrl|escape
			}
		</div>
	{/if}

	<h1 class="page_title">
		{$publication->getLocalizedTitle()|escape}
	</h1>

	{if $publication->getLocalizedData('subtitle')}
		<h2 class="subtitle">
			{$publication->getLocalizedData('subtitle')|escape}
		</h2>
	{/if}

	<div class="row">
		<div class="main_entry">

			{if $publication->getData('authors')}
				<section class="item authors">
					<h2 class="pkp_screen_reader">{translate key="article.authors"}</h2>
					<ul class="authors">
					{foreach from=$publication->getData('authors') item=author}
						<li>
							<span class="name">
								{$author->getFullName()|escape}
							</span>
							{if $author->getLocalizedData('affiliation')}
								<span class="affiliation">
									{$author->getLocalizedData('affiliation')|escape}
									{if $author->getData('rorId')}
										<a href="{$author->getData('rorId')|escape}">{$rorIdIcon}</a>
									{/if}
								</span>
							{/if}
							{if $author->getData('orcid')}
								<span class="orcid">
									{if $author->getData('orcidAccessToken')}
										{$orcidIcon}
									{/if}
									<a href="{$author->getData('orcid')|escape}" target="_blank">
										{$author->getData('orcid')|escape}
									</a>
								</span>
							{/if}
						</li>
					{/foreach}
					</ul>
				</section>
			{/if}

			{* DOI (requires plugin) *}
			{foreach from=$pubIdPlugins item=pubIdPlugin}
				{if $pubIdPlugin->getPubIdType() != 'doi'}
					{continue}
				{/if}
				{assign var=pubId value=$article->getStoredPubId($pubIdPlugin->getPubIdType())}
				{if $pubId}
					{assign var="doiUrl" value=$pubIdPlugin->getResolvingURL($currentJournal->getId(), $pubId)|escape}
					<section class="item doi">
						<h2 class="label">
							{capture assign=translatedDOI}{translate key="plugins.pubIds.doi.readerDisplayName"}{/capture}
							{translate key="semicolon" label=$translatedDOI}
						</h2>
						<span class="value">
							<a href="{$doiUrl}">
								{$doiUrl}
							</a>
						</span>
					</section>
				{/if}
			{/foreach}

			{* Keywords *}
			{if !empty($publication->getLocalizedData('keywords'))}
			<section class="item keywords">
				<h2 class="label">
					{capture assign=translatedKeywords}{translate key="article.subject"}{/capture}
					{translate key="semicolon" label=$translatedKeywords}
				</h2>
				<span class="value">
					{foreach name="keywords" from=$publication->getLocalizedData('keywords') item="keyword"}
						{$keyword|escape}{if !$smarty.foreach.keywords.last}{translate key="common.commaListSeparator"}{/if}
					{/foreach}
				</span>
			</section>
			{/if}

			{* Abstract *}
			{if $publication->getLocalizedData('abstract')}
				<section class="item abstract">
					<h2 class="label">{translate key="article.abstract"}</h2>
					{$publication->getLocalizedData('abstract')|strip_unsafe_html}
				</section>
			{/if}

			{call_hook name="Templates::Article::Main"}

			{* Author biographies *}
			{assign var="hasBiographies" value=0}
			{foreach from=$publication->getData('authors') item=author}
				{if $author->getLocalizedData('biography')}
					{assign var="hasBiographies" value=$hasBiographies+1}
				{/if}
			{/foreach}
			{if $hasBiographies}
				<section class="item author_bios">
					<h2 class="label">
						{if $hasBiographies > 1}
							{translate key="submission.authorBiographies"}
						{else}
							{translate key="submission.authorBiography"}
						{/if}
					</h2>
					{foreach from=$publication->getData('authors') item=author}
						{if $author->getLocalizedData('biography')}
							<section class="sub_item">
								<h3 class="label">
									{if $author->getLocalizedData('affiliation')}
										{capture assign="authorName"}{$author->getFullName()|escape}{/capture}
										{capture assign="authorAffiliation"}<span class="affiliation">{$author->getLocalizedData('affiliation')|escape}</span>{/capture}
										{translate key="submission.authorWithAffiliation" name=$authorName affiliation=$authorAffiliation}
									{else}
										{$author->getFullName()|escape}
									{/if}
								</h3>
								<div class="value">
									{$author->getLocalizedData('biography')|strip_unsafe_html}
								</div>
							</section>
						{/if}
					{/foreach}
				</section>
			{/if}

			{* References *}
			{if $parsedCitations || $publication->getData('citationsRaw')}
				<section class="item references">
					<h2 class="label">
						{translate key="submission.citations"}
					</h2>
					<div class="value">
						{if $parsedCitations}
							{foreach from=$parsedCitations item="parsedCitation"}
								<p>{$parsedCitation->getCitationWithLinks()|strip_unsafe_html} {call_hook name="Templates::Article::Details::Reference" citation=$parsedCitation}</p>
							{/foreach}
						{else}
							{$publication->getData('citationsRaw')|escape|nl2br}
						{/if}
					</div>
				</section>
			{/if}

		</div><!-- .main_entry -->

		<div class="entry_details">

			{* Article/Issue cover image *}
			{if $publication->getLocalizedData('coverImage') || ($issue && $issue->getLocalizedCoverImage())}
				<div class="item cover_image">
					<div class="sub_item">
						{if $publication->getLocalizedData('coverImage')}
							{assign var="coverImage" value=$publication->getLocalizedData('coverImage')}
							<img
								src="{$publication->getLocalizedCoverImageUrl($article->getData('contextId'))|escape}"
								alt="{$coverImage.altText|escape|default:''}"
							>
						{else}
							<a href="{url page="issue" op="view" path=$issue->getBestIssueId()}">
								<img src="{$issue->getLocalizedCoverImageUrl()|escape}" alt="{$issue->getLocalizedCoverImageAltText()|escape|default:''}">
							</a>
						{/if}
					</div>
				</div>
			{/if}

			{* Article Galleys *}
			{if $primaryGalleys}
				<div class="item galleys">
					<h2 class="pkp_screen_reader">
						{translate key="submission.downloads"}
					</h2>
					<ul class="value galleys_links">
						{foreach from=$primaryGalleys item=galley}
							<li>
								{include file="frontend/objects/galley_link.tpl" parent=$article publication=$publication galley=$galley purchaseFee=$currentJournal->getData('purchaseArticleFee') purchaseCurrency=$currentJournal->getData('currency')}
							</li>
						{/foreach}
					</ul>
				</div>
			{/if}
			{if $supplementaryGalleys}
				<div class="item galleys">
					<h3 class="pkp_screen_reader">
						{translate key="submission.additionalFiles"}
					</h3>
					<ul class="value supplementary_galleys_links">
						{foreach from=$supplementaryGalleys item=galley}
							<li>
								{include file="frontend/objects/galley_link.tpl" parent=$article publication=$publication galley=$galley isSupplementary="1"}
							</li>
						{/foreach}
					</ul>
				</div>
			{/if}

			{if $publication->getData('datePublished')}
			<div class="item published">
				<section class="sub_item">
					<h2 class="label">
						{translate key="submissions.published"}
					</h2>
					<div class="value">
						{* If this is the original version *}
						{if $firstPublication->getID() === $publication->getId()}
							<span>{$firstPublication->getData('datePublished')|date_format:$dateFormatShort}</span>
						{* If this is an updated version *}
						{else}
							<span>{translate key="submission.updatedOn" datePublished=$firstPublication->getData('datePublished')|date_format:$dateFormatShort dateUpdated=$publication->getData('datePublished')|date_format:$dateFormatShort}</span>
						{/if}
					</div>
				</section>
				{if count($article->getPublishedPublications()) > 1}
					<section class="sub_item versions">
						<h2 class="label">
							{translate key="submission.versions"}
						</h2>
						<ul class="value">
							{foreach from=array_reverse($article->getPublishedPublications()) item=iPublication}
								{capture assign="name"}{translate key="submission.versionIdentity" datePublished=$iPublication->getData('datePublished')|date_format:$dateFormatShort version=$iPublication->getData('version')}{/capture}
								<li>
									{if $iPublication->getId() === $publication->getId()}
										{$name}
									{elseif $iPublication->getId() === $currentPublication->getId()}
										<a href="{url page="article" op="view" path=$article->getBestId()}">{$name}</a>
									{else}
										<a href="{url page="article" op="view" path=$article->getBestId()|to_array:"version":$iPublication->getId()}">{$name}</a>
									{/if}
								</li>
							{/foreach}
						</ul>
					</section>
				{/if}
			</div>
			{/if}

			{* How to cite *}
			{if $citation}
				<div class="item citation">
					<section class="sub_item citation_display">
						<h2 class="label">
							{translate key="submission.howToCite"}
						</h2>
						<div class="value">
							<div id="citationOutput" role="region" aria-live="polite">
								{$citation}
							</div>
							<div class="citation_formats">
								<button class="cmp_button citation_formats_button" aria-controls="cslCitationFormats" aria-expanded="false" data-csl-dropdown="true">
									{translate key="submission.howToCite.citationFormats"}
								</button>
								<div id="cslCitationFormats" class="citation_formats_list" aria-hidden="true">
									<ul class="citation_formats_styles">
										{foreach from=$citationStyles item="citationStyle"}
											<li>
												<a
													rel="nofollow"
													aria-controls="citationOutput"
													href="{url page="citationstylelanguage" op="get" path=$citationStyle.id params=$citationArgs}"
													data-load-citation
													data-json-href="{url page="citationstylelanguage" op="get" path=$citationStyle.id params=$citationArgsJson}"
												>
													{$citationStyle.title|escape}
												</a>
											</li>
										{/foreach}
									</ul>
									{if count($citationDownloads)}
										<div class="label">
											{translate key="submission.howToCite.downloadCitation"}
										</div>
										<ul class="citation_formats_styles">
											{foreach from=$citationDownloads item="citationDownload"}
												<li>
													<a href="{url page="citationstylelanguage" op="download" path=$citationDownload.id params=$citationArgs}">
														<span class="fa fa-download"></span>
														{$citationDownload.title|escape}
													</a>
												</li>
											{/foreach}
										</ul>
									{/if}
								</div>
							</div>
						</div>
					</section>
				</div>
			{/if}

			{* Issue article appears in *}
			{if $issue || $section || $categories}
				<div class="item issue">

					{if $issue}
						<section class="sub_item">
							<h2 class="label">
								{translate key="issue.issue"}
							</h2>
							<div class="value">
								<a class="title" href="{url page="issue" op="view" path=$issue->getBestIssueId()}">
									{$issue->getIssueIdentification()}
								</a>
							</div>
						</section>
					{/if}

					{if $section}
						<section class="sub_item">
							<h2 class="label">
								{translate key="section.section"}
							</h2>
							<div class="value">
								{$section->getLocalizedTitle()|escape}
							</div>
						</section>
					{/if}

					{if $categories}
						<section class="sub_item">
							<h2 class="label">
								{translate key="category.category"}
							</h2>
							<div class="value">
								<ul class="categories">
									{foreach from=$categories item=category}
										<li><a href="{url router=$smarty.const.ROUTE_PAGE page="catalog" op="category" path=$category->getPath()|escape}">{$category->getLocalizedTitle()|escape}</a></li>
									{/foreach}
								</ul>
							</div>
						</section>
					{/if}
				</div>
			{/if}

			{* PubIds (requires plugins) *}
			{foreach from=$pubIdPlugins item=pubIdPlugin}
				{if $pubIdPlugin->getPubIdType() == 'doi'}
					{continue}
				{/if}
				{assign var=pubId value=$article->getStoredPubId($pubIdPlugin->getPubIdType())}
				{if $pubId}
					<section class="item pubid">
						<h2 class="label">
							{$pubIdPlugin->getPubIdDisplayType()|escape}
						</h2>
						<div class="value">
							{if $pubIdPlugin->getResolvingURL($currentJournal->getId(), $pubId)|escape}
								<a id="pub-id::{$pubIdPlugin->getPubIdType()|escape}" href="{$pubIdPlugin->getResolvingURL($currentJournal->getId(), $pubId)|escape}">
									{$pubIdPlugin->getResolvingURL($currentJournal->getId(), $pubId)|escape}
								</a>
							{else}
								{$pubId|escape}
							{/if}
						</div>
					</section>
				{/if}
			{/foreach}

			{* Licensing info *}
			{if $currentContext->getLocalizedData('licenseTerms') || $publication->getData('licenseUrl')}
				<div class="item copyright">
					<h2 class="label">
						{translate key="submission.license"}
					</h2>
					{if $publication->getData('licenseUrl')}
						{if $ccLicenseBadge}
							{if $publication->getLocalizedData('copyrightHolder')}
								<p>{translate key="submission.copyrightStatement" copyrightHolder=$publication->getLocalizedData('copyrightHolder') copyrightYear=$publication->getData('copyrightYear')}</p>
							{/if}
							{$ccLicenseBadge}
						{else}
							<a href="{$publication->getData('licenseUrl')|escape}" class="copyright">
								{if $publication->getLocalizedData('copyrightHolder')}
									{translate key="submission.copyrightStatement" copyrightHolder=$publication->getLocalizedData('copyrightHolder') copyrightYear=$publication->getData('copyrightYear')}
								{else}
									{translate key="submission.license"}
								{/if}
							</a>
						{/if}
					{/if}
					{$currentContext->getLocalizedData('licenseTerms')}
				</div>
			{/if}

			{call_hook name="Templates::Article::Details"}

		</div><!-- .entry_details -->
	</div><!-- .row -->

	{* Article Metrics — Interactive 3D Globe (full width) *}
	<div class="article-metrics-map article-metrics-map--fullwidth" id="articleMetricsMap" data-article-id="{$article->getId()}">
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

	<script src="https://unpkg.com/three@0.158.0/build/three.min.js"></script>
	<script src="https://unpkg.com/globe.gl@2.27.2/dist/globe.gl.min.js"></script>
	<script>
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
	</script>

</article>
