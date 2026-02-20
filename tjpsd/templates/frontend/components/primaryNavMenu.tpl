{**
 * templates/frontend/components/primaryNavMenu.tpl
 *
 * Copyright (c) 2014-2021 Simon Fraser University
 * Copyright (c) 2003-2021 John Willinsky
 * Distributed under the GNU GPL v3. For full terms see the file docs/COPYING.
 *
 * Primary navigation menu list for OJS
 *}
<ul id="navigationPrimary" class="pkp_navigation_primary pkp_nav_list">

	{if $enableAnnouncements}
		<li>
			<a href="{url router=$smarty.const.ROUTE_PAGE page="announcement"}">
				{translate key="announcement.announcements"}
			</a>
		</li>
	{/if}

	{if $currentJournal}

		{if $currentJournal->getData('publishingMode') != $smarty.const.PUBLISHING_MODE_NONE}
			<li>
				<a href="{url router=$smarty.const.ROUTE_PAGE page="issue" op="current"}">
					{translate key="navigation.current"}
				</a>
			</li>
			<li>
				<a href="{url router=$smarty.const.ROUTE_PAGE page="issue" op="archive"}">
					{translate key="navigation.archives"}
				</a>
			</li>

		{* Analytics Tab with Dropdown *}
		<li class="has_submenu analytics-nav-dropdown">
			<a href="http://localhost:3000/">
				Analytics
			</a>
			<ul>
				<li><a href="http://localhost:3000/#top-cited">All-Time Top Cited</a></li>
				<li><a href="http://localhost:3000/#monthly-top">Monthly Top 10</a></li>
				<li><a href="http://localhost:3000/#visual">Visual Analytics</a></li>
				<li><a href="http://localhost:3000/#growth">Citation Growth</a></li>
				<li><a href="http://localhost:3000/#countries">Readers by Country</a></li>
				<li><a href="http://localhost:3000/#trending">Trending Articles</a></li>
			</ul>
		</li>
		{/if}

		<li>
			<a href="{url router=$smarty.const.ROUTE_PAGE page="about"}">
				{translate key="navigation.about"}
			</a>
			<ul>
				<li>
					<a href="{url router=$smarty.const.ROUTE_PAGE page="about"}">
						{translate key="about.aboutContext"}
					</a>
				</li>
				{if $currentJournal->getLocalizedData('editorialTeam')}
					<li>
						<a href="{url router=$smarty.const.ROUTE_PAGE page="about" op="editorialTeam"}">
							{translate key="about.editorialTeam"}
						</a>
					</li>
				{/if}
				<li>
					<a href="{url router=$smarty.const.ROUTE_PAGE page="about" op="submissions"}">
						{translate key="about.submissions"}
					</a>
				</li>
				{if $currentJournal->getData('mailingAddress') || $currentJournal->getData('contactName')}
					<li>
						<a href="{url router=$smarty.const.ROUTE_PAGE page="about" op="contact"}">
							{translate key="about.contact"}
						</a>
					</li>
				{/if}
			</ul>
		</li>
	{/if}
</ul>
