<?php
//$wgReadOnly = ( PHP_SAPI === 'cli' ) ? false : 'This wiki is currently being upgraded to a newer software version. Please check back later.';

// ini_set('display_errors', 'On');
// ini_set('log_errors', 'On');
// error_reporting(E_ALL);
$wgShowExceptionDetails = true;
$wgShowDBErrorBacktrace = true;

# When you make changes to this configuration file, this will make
# sure that cached pages are cleared.
$wgCacheEpoch = max( $wgCacheEpoch, gmdate( 'YmdHis', @filemtime( __FILE__ ) ) );

## Settings that are always site-specific

$wgSitename = "Japanese Scratch-Wiki";
$wgLanguageCode = "ja";
$wgLogo = "/w/images/b/bc/Wiki.png";

## Other site-specific non-extension settings

$swgEmailOptions = false;
$wgEnotifUserTalk      = false; # UPO
$wgEnotifWatchlist     = false; # UPO
$wgEmailAuthentication = true;

# NEW NAMESPACE! ADDING HERE, apple502j 2018/12/26
define('NS_MEME', 3420);
define('NS_MEME_TALK', 3421);
$wgExtraNamespaces[NS_MEME] = "文化";
$wgExtraNamespaces[NS_MEME_TALK] = "文化・トーク";

# Hiragana Articles Apple502j, 2018/08/14
$wgNamespacesWithSubpages[NS_MAIN] = true;
$wgNamespacesWithSubpages[NS_MEME] = true;
$wgRestrictDisplayTitle = false;

$wgHiddenPrefs[] = 'usebetatoolbar';

$wgExtraSignatureNamespaces = array( NS_PROJECT );

// clean up jvvg's mess
// added by apple, oct 17th, 2020
$wgEnableBotPasswords = true;
$wgForceHTTPS = true;
$wgPageCreationLog = true;
$wgCookieSameSite = "Lax";

## Site-specific permissions

// To grant sysops permissions to edit interwiki data
$wgGroupPermissions['sysop']['interwiki'] = true;

# Bots should have no rate limits! Apple502j 2018/07/20
$wgGroupPermissions['bot']['noratelimit'] = true;

$wgGroupPermissions['sysop']['upload_by_url'] = true;
$wgAllowCopyUploads = true;
$wgCopyUploadsFromSpecialUpload = true;

# Add extendedconfirmed group by Apple502j 2018-10-28
$wgGroupPermissions['extendedconfirmed']['upload_by_url'] = true;
$wgGroupPermissions['extendedconfirmed']['massmessage'] = true;
$wgGroupPermissions['extendedconfirmed']['autopatrol'] = true;

$wgAddGroups['sysop'] = array('extendedconfirmed');
$wgRemoveGroups['sysop'] = array('extendedconfirmed');

# Disable writeapi  by Apple502j 2018-10-28
$wgGroupPermissions['user']['writeapi'] = false;
$wgGroupPermissions['sysop']['writeapi'] = true;
$wgGroupPermissions['bot']['writeapi'] = true;

# ExtendedConfirmed permissions +1 apple502j 2018-10-29
$wgGroupPermissions['extendedconfirmed']['editcontentmodel'] = true;

# ExtendedConfirmed Protection 2018/12/03 apple502j
$wgRestrictionLevels[] = 'extendedconfirmed';
$wgGroupPermissions['user']['extendedconfirmed'] = false;
$wgGroupPermissions['extendedconfirmed']['extendedconfirmed'] = true;
$wgGroupPermissions['sysop']['extendedconfirmed'] = true;
$wgGroupPermissions['bot']['extendedconfirmed'] = true;

// Remove interface admin
unset( $wgGroupPermissions['interface-admin'] );
unset( $wgRevokePermissions['interface-admin'] );
unset( $wgAddGroups['interface-admin'] );
unset( $wgRemoveGroups['interface-admin'] );
unset( $wgGroupsAddToSelf['interface-admin'] );
unset( $wgGroupsRemoveFromSelf['interface-admin'] );

## Common extensions and their settings

$swgUseExtensions = array_merge( $swgUseExtensions, [
	'AbuseFilter',
	# Add SyntaxHighlight Apple502j, 2018/09/09
	'SyntaxHighlight',
	# Add DismissableSiteNotice Apple502j, 2018/09/15
	'DSN',
	# Add Labeled Section Transclusion Apple502j, 2018/09/16
	'LST',
	'NSH',
	# Add Report by Apple502j 2018-10-28
	'Report',
	# Installing an extension 2019/01/01 by apple502j
	'EmbedScratch',
	'Echo',
	// Enable ScratchPasswordReset - Kenny2scratch 2022-08-14
	'mediawiki-scratch-login',
] );

$swgUseLinkPreviews = true;

// Changed from previous project (of which the current one is a remix)
// on 2024-10-29 by Kenny2scratch
$wgScratchVerificationProjectAuthor = "kokastar";
$wgScratchVerificationProjectID = "1088061584";
$wgScratchAccountRequestRejectCooldownDays = 7;
$wgScratchAccountCheckDisallowNewScratcher = true;
$wgScratchAccountJoinedRequirement = 6 * 30 * 24 * 60 * 60;
$wgAutoWelcomeNewUsers = true;

# ParserFunctions Settings by Apple502j 2018/08/14
$wgPFStringLengthLimit = 1024;

## Site-specific extensions and their settings

# RecentChangesWebhooks extension - added June 12th, 2018 by Kenny2scratch
wfLoadExtension( 'RecentChangesWebhooks' );
# URL configured in config/private

$wgRCWHookType = 'job';

# Disambiguator extension - added by Kenny2scratch on 2018/08/08
wfLoadExtension( 'Disambiguator' );

# Add MassMessage extension - added 28 October 2018 with approval from 227kei and apple502j
wfLoadExtension( 'MassMessage' );

wfLoadExtension('YouTube');
wfLoadExtension('ImageMap');

// Description2 and OpenGraphMeta
wfLoadExtension("Description2");
wfLoadExtension("OpenGraphMeta");
$wgEnableMetaDescriptionFunctions = true;

// RelatedArticles
wfLoadExtension("RelatedArticles");
$wgRelatedArticlesFooterWhitelistedSkins = array("scratchwikiskin2", "vector");
$wgRelatedArticlesDescriptionSource = "pagedescription";

// AutoSitemap

wfLoadExtension( 'AutoSitemap' );

$wgAutoSitemap["notify"] = [
    'https://www.google.com/webmasters/sitemaps/ping?sitemap=',
    'https://www.bing.com/webmaster/ping.aspx?sitemap='
];

$wgAutoSitemap["exclude_namespaces"] = [
    NS_TALK,
    NS_USER,
    NS_USER_TALK,
    NS_PROJECT_TALK,
    NS_FILE_TALK,
    NS_MEDIAWIKI,
    NS_MEDIAWIKI_TALK,
    NS_TEMPLATE,
    NS_TEMPLATE_TALK,
    NS_HELP,
    NS_HELP_TALK,
    NS_CATEGORY_TALK,
    NS_MEME_TALK
];

// GuguruSearch
wfLoadExtension("GuguruSearch");
$wgGoogleSearchOptions = array(
    "googlebot" => "index,nofollow,noarchive",
    "sitesearch" => true,
    "translate" => false
);

// NewestPages
wfLoadExtension("NewestPages");

// BetaFeatures
wfLoadExtension("BetaFeatures");

// RevisionSlider
wfLoadExtension( 'RevisionSlider' );
$wgDefaultUserOptions['revisionslider-disable'] = 1;

wfLoadExtension("TwoColConflict");

wfLoadExtension('scratch-confirmaccount-v3-webhooks');
# URL configured in config/private
