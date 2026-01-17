<?php
//$wgReadOnly = ( PHP_SAPI === 'cli' ) ? false : 'This wiki is currently being upgraded to a newer software version. Please check back later.';

// ini_set('display_errors', 'On');
// ini_set('log_errors', 'On');
// error_reporting(E_ALL);

# When you make changes to this configuration file, this will make
# sure that cached pages are cleared.
$wgCacheEpoch = max( $wgCacheEpoch, gmdate( 'YmdHis', @filemtime( __FILE__ ) ) );

## Settings that are always site-specific

$wgSitename = "Scratch Wiki en français";
$wgMetaNamespace = 'SWFR';
$wgNamespaceAliases = [
	'Scratch_Wiki_en_français' => NS_PROJECT,
	'Discussion_Scratch_Wiki_en_français' => NS_PROJECT_TALK,
];
$wgLanguageCode = "fr";
$wgLogo = "/w/wikilogo.svg";

## Other site-specific non-extension settings

# In addition to CommonSettings list
$wgFileExtensions = ['avi', 'bmp', 'flv', 'mkv', 'mp2', 'mp3', 'mp4', 'mpeg', 'mpg', 'ogg', 'tif', 'wav', 'webm', 'webp', 'wmv'];

$wgEnableBotPasswords = true;

$wgAllowSiteCSSOnRestrictedPages = true;

$wgRCMaxAge = 26 * 7 * 24 * 60 * 60; # keep Recent Changes for 26 weeks

# April Fools
define('NAMESPACE_APRIL_FOOLS', 3000);
define('NAMESPACE_APRIL_FOOLS_TALK', NAMESPACE_APRIL_FOOLS + 1);
$wgExtraNamespaces = [
        NAMESPACE_APRIL_FOOLS => "Poisson_d'avril",
        NAMESPACE_APRIL_FOOLS_TALK => "Discussion_poisson_d'avril",
];
$wgNamespacesWithSubpages[NAMESPACE_APRIL_FOOLS] = true;
$wgNamespacesWithSubpages[NAMESPACE_APRIL_FOOLS_TALK] = true;

# Enable Interwiki transclusion
# Added by Smrman on January 10, 2021
$wgEnableScaryTranscluding = true;
$wgInterwikiMagic = true;
$wgHideInterlanguageLinks = false;

## Site-specific permissions

$wgGroupPermissions['sysop']['block'] = true;
$wgGroupPermissions['sysop']['blockemail'] = true;
$wgGroupPermissions['sysop']['checkuser-log'] = true;
$wgGroupPermissions['sysop']['checkuser'] = true;
$wgGroupPermissions['sysop']['createaccount'] = true;
$wgGroupPermissions['sysop']['editsitecss'] = true;
$wgGroupPermissions['sysop']['editsitejs'] = true;
$wgGroupPermissions['sysop']['editsitejson'] = true;
$wgGroupPermissions['sysop']['interwiki'] = true;
$wgGroupPermissions['sysop']['userrights'] = true;


$wgNamespaceProtection[NAMESPACE_APRIL_FOOLS] = ['editaprilfools'];
$wgNamespaceProtection[NAMESPACE_APRIL_FOOLS_TALK] = ['editaprilfoolstalk'];
$wgGroupPermissions['*']['editaprilfools'] = true;
$wgGroupPermissions['*']['editaprilfoolstalk'] = true;

## Common extensions and their settings

$swgUseExtensions = array_merge( $swgUseExtensions, [
	'CategoryTree',
	'CheckUser',
	'DSN',
	'DynamicPageList',
	'EmbedPhosphorus',
	'EmbedScratch',
	'EmbedVideo',
	'LST',
	'NSH',
	'RandomSelection',
	'SyntaxHighlight',
	'VisualEditor',
	# Since GuidedTour requires it
	# https://www.mediawiki.org/wiki/Extension:EventLogging
	# Added by jvvg on March 6, 2023
	'EventLogging',
	# Allows users to login with Scratch account
	# https://github.com/InternationalScratchWiki/mediawiki-scratch-login
	# Added by Smrman on April 13, 2021
	'mediawiki-scratch-login',
] );

$swgUseLinkPreviews = true;

$wgEmbedVideoEnableVideoHandler = true;
$wgEmbedVideoEnableAudioHandler = true;

## Site-specific extensions and their settings

# AutoSiteMap
# Adds a sitemap for search engines
# https://www.mediawiki.org/wiki/Extension:AutoSitemap
# Added by Smrman on October 9, 2018
wfLoadExtension( 'AutoSitemap' );
$wgAutoSitemap['filename'] = 'fr-sitemap.xml';
$wgAutoSitemap['server'] = 'https://fr.scratch-wiki.info/seo/';
$wgAutoSitemap['freq'] = 'daily';

# GuidedTour
# Tours new users in the wiki
# https://www.mediawiki.org/wiki/Extension:GuidedTour
# Added by Smrman on April 13, 2021
wfLoadExtension( 'GuidedTour' );

# RecentChangesWebhooks
# Spies on the Fr Wiki
# Added by Kenny2scratch on August 22, 2018
wfLoadExtension( 'RecentChangesWebhooks' );
# URL configured in config/private
$wgRCWHookType = 'job';

# ReplaceText
# Allows to replace text in pages
# https://www.mediawiki.org/wiki/Extension:ReplaceText
# Added by Smrman on December 26, 2022
wfLoadExtension( 'ReplaceText' );
$wgGroupPermissions['bureaucrat']['replacetext'] = true;
$wgGroupPermissions['admin']['replacetext'] = true;
$wgGroupPermissions['bureaucrat']['suppressredirect'] = true;
$wgGroupPermissions['admin']['suppressredirect'] = true;

# Tabs
# Allows to add tabs to the wiki
# https://www.mediawiki.org/wiki/Extension:Tabs
# Added by Smrman on February 19, 2022
wfLoadExtension( 'Tabs' );

# TemplateStyles
# Allows to add styles to templates
# https://www.mediawiki.org/wiki/Extension:TemplateStyles
# Added by Smrman on September 5, 2022
wfLoadExtension( 'TemplateStyles' );

# WikiSEO
# Allows better search engine discoverability
# https://www.mediawiki.org/wiki/Extension:WikiSEO
# Added by Smrman on June 25, 2018
wfLoadExtension( 'WikiSEO' );

###################################
# Adding the ability to add HTML code in the HTML head of generated pages
# Ultimate goal is to add links to the PWA manifest
# https://www.mediawiki.org/wiki/Extension:HeadScript
# Added by Smrman on April 16, 2020
###################################
wfLoadExtension('HeadScript');
$wgHeadScriptDescription = "Le $wgSitename est un wiki sur le Scratch, le langage de programmation et le site qui s'en rapporte. Vous y trouverez des l'aide et des articles sur les différents sujets.";
$wgHeadScriptKeywords = join(', ', [
	$wgSitename,
	'Aide',
	'Effacer Tout',
	'Extension Scratch',
	'Fr Wiki',
	'Fr',
	'Français',
	'Imagine Programme Partage',
	'Info',
	'Mblock',
	'Modulo Scratch',
	'Scratch 3.0',
	'Scratch 3',
	'Scratch Arduino',
	'Scratch Desktop',
	'Scratch Fr',
	'Scratch Fr Wiki',
	'Scratch Français',
	'Scratch Link',
	'Scratch Programmation',
	'Scratch Stylo',
	'Scratch Wiki Fr',
	'Scratch Wiki Français',
	'Scratch Wiki',
	'Scratch',
	"Stylo En Position d'écriture",
	'Variable Scratch',
	'Wiki Fr',
	'Wiki Scratch Fr',
	'Wiki Scratch Français',
	'Wiki Scratch',
	'Wiki',
	'Wikipedia',
]);
$wgHeadScriptLogo = "https://fr.scratch-wiki.info$wgLogo";
$wgHeadScriptCode = <<<START_END_MARKER
<link rel="manifest" href="/seo/fr.webmanifest">
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-title" content="$wgSitename">
<meta name="application-name" content="$wgSitename">
<meta name="msapplication-starturl" content="/">
<meta name="theme-color" content="#7953C4">
<link rel="apple-touch-icon" href="/favicon.ico">
<!-- service worker for PWA -->
<script>
window.addEventListener("beforeinstallprompt", e => e.prompt());
window.addEventListener("load", async () =>
	navigator.__proto__.hasOwnProperty("serviceWorker")
	? await navigator.serviceWorker.register("/seo/fr-sw.js")
	: undefined);
</script>
<meta name="description" content="$wgHeadScriptDescription">
<meta name="keywords" content="$wgHeadScriptKeywords">

<meta property="og:description" content="$wgHeadScriptDescription">
<meta property="og:image:alt" content="$wgSitename">
<meta property="og:image:type" content="image/svg">
<meta property="og:image" content="$wgHeadScriptLogo">
<meta property="og:locale" content="fr_FR">
<meta property="og:site_name" content="$wgSitename">
<meta property="og:title" content="$wgSitename">
<meta property="og:type" content="website">
START_END_MARKER;
