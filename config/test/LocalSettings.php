<?php
//$wgReadOnly = ( PHP_SAPI === 'cli' ) ? false : 'This wiki is currently being upgraded to a newer software version. Please check back later.';

ini_set('display_errors', 'On');
ini_set('log_errors', 'On');
error_reporting(E_ALL);
$wgShowSQLErrors = true;
$wgDebugDumpSql  = true;
$wgShowDBErrorBacktrace = true;
$wgShowExceptionDetails = true;

# When you make changes to this configuration file, this will make
# sure that cached pages are cleared.
$wgCacheEpoch = max( $wgCacheEpoch, gmdate( 'YmdHis', @filemtime( __FILE__ ) ) );

## Settings that are always site-specific

$wgSitename = "Test-Scratch-Wiki";
$wgLanguageCode = "en";
$wgLogo	= "/w/images/wikilogo2.png";

## Other site-specific non-extension settings

$namespaceToLanguage = [];
$threeLetterCodeToLanguage = [];
// an extension setting, but set at the same time as namespaces are defined
$wgScratchBlocks4Langs = [];

function defineTestWiki($namespaceName, $langCode3, $langCode2, $number, $namespaceTalkSuffix = 'T', $isLanguage = true) {
	global $wgExtraNamespaces, $namespaceToLanguage, $threeLetterCodeToLanguage, $wgScratchBlocks4Langs;
	define('NS_' . $namespaceName, $number);
	define('NS_' . $namespaceName . '_' . $namespaceTalkSuffix, $number + 1);

	$wgExtraNamespaces[$number] = $langCode3;
	$wgExtraNamespaces[$number + 1] = $langCode3 . '_talk';

	$namespaceToLanguage[$number] = $langCode2;
	$namespaceToLanguage[$number + 1] = $langCode2;

	$threeLetterCodeToLanguage[$langCode3] = $langCode2;

	$wgScratchBlocks4Langs[] = $langCode2;
}

# Special namespaces
# see https://en.wikipedia.org/wiki/List_of_ISO_639-2_codes
define("NS_SCRATCH_WIKI", 3000); // This MUST be even.
define("NS_SCRATCH_WIKI_TALK", 3001); // This MUST be the following odd integer.
defineTestWiki('FRA', 'Fra', 'fr', 3002);
defineTestWiki('ITA', 'Ita', 'it', 3004);
defineTestWiki('SPA', 'Spa', 'es', 3006);
defineTestWiki('POR', 'Por', 'pt', 3008);
defineTestWiki('TUR', 'Tur', 'tr', 3010);
defineTestWiki('ENG', 'Eng', 'en', 3012);
defineTestWiki('HIN', 'Hin', 'hi', 3014);
defineTestWiki('POL', 'Pol', 'pl', 3016);
defineTestWiki('ZHO', 'Zho', 'zh', 3018);
defineTestWiki('TAM', 'Tam', 'ta', 3020);
defineTestWiki('HEB', 'Heb', 'he', 3022);
defineTestWiki('SLV', 'Slv', 'sl', 3024);
defineTestWiki('KOR', 'Kor', 'ko', 3026);
defineTestWiki('ARA', 'Ara', 'ar', 3028);
defineTestWiki('LAT', 'Lat', 'la', 3030);
defineTestWiki('UKR', 'Ukr', 'uk', 3032);
defineTestWiki('SQI', 'Sqi', 'sq', 3034);
defineTestWiki('BEN', 'Ben', 'bn', 3036);
defineTestWiki('GUJ', 'Guj', 'gu', 3038);
defineTestWiki('RON', 'Ron', 'ro', 3040);
defineTestWiki('CES', 'Ces', 'cs', 3042);
defineTestWiki('SLK', 'Slk', 'sk', 3044);
defineTestWiki('MLT', 'Mlt', 'mt', 3046);
defineTestWiki('FIN', 'Fin', 'fi', 3048);
defineTestWiki('LIT', 'Lit', 'lt', 3050);
# N.B. The namespace ID that Nor: now uses was the original
# definition of the Vie: namespace. The latter was accidentally
# overwritten by the later 3060 definition and has since been
# replaced. The only two pages in the old namespace have been moved
# or merged into the new one.
# - Kenny2scratch, 2024-09-02
defineTestWiki('NOR', 'Nor', 'no', 3052);
defineTestWiki('ELL', 'Ell', 'el', 3054);
defineTestWiki('MAR', 'Mar', 'mr', 3056);
defineTestWiki('TEL', 'Tel', 'te', 3058);
defineTestWiki('VIE', 'Vie', 'vi', 3060);
defineTestWiki('URD', 'Urd', 'ur', 3062);
defineTestWiki('TGL', 'Tgl', 'tl', 3064);
defineTestWiki('BUL', 'Bul', 'bg', 3066);
$wgExtraNamespaces[NS_SCRATCH_WIKI] = "Scratch_Wiki";
$wgExtraNamespaces[NS_SCRATCH_WIKI_TALK] = "Scratch_Wiki_talk"; // Note underscores in the namespace name.

$wgNamespacesWithSubpages = array_fill( 0, 3100, true ); //allow subpages on every namespace

// Unset telephone URL protocol to avoid conflict with Telugu namespace
// Added 2023-04-07 by Kenny2scratch
// Modified 2026-01-17 by Kenny2scratch to fix
// "array value found, but an array is required" update.php warning
$wgUrlProtocols = array_values( array_diff( $wgUrlProtocols, ['tel:'] ) );

function languagesForNamespaces( $title, &$pagelang ) {
	global $namespaceToLanguage, $threeLetterCodeToLanguage;

	if ($title->getNamespace() == NS_TEMPLATE && isset($threeLetterCodeToLanguage[$title->getBaseText()])) {
		$pagelang = $threeLetterCodeToLanguage[$title->getBaseText()];
		return true;
	}
	if (isset($namespaceToLanguage[$title->getNamespace()])) {
		$pagelang = $namespaceToLanguage[$title->getNamespace()];
		return true;
	}
	return true;
}
$wgHooks['PageContentLanguage'][] = 'languagesForNamespaces';

$swgRealNameOptions = false;

$wgForceUIMsgAsContentMsg[] = 'sidebar';

## Site-specific permissions

$wgGroupPermissions['sysop']['interwiki'] = true;

#//mtwoll 07.11.2015 se Mail from ErnieParke: I tried connecting via FTP to the Test Wiki, but I cannot login. Can you add the line of code to LocalSettings.PHP?
# This line allows bots to upload files to the wiki
$wgAllowCopyUploads = true;
$wgGroupPermissions['bot']['upload_by_url'] = true;
$wgGroupPermissions['bot']['delete'] = true;
$wgGroupPermissions['bot']['suppressredirect'] = true;

## Common extensions and their settings

$swgUseExtensions = array_merge( array_diff( $swgUseExtensions, [
	'Editcount',
	'ScratchSig',
] ), [
	'HitCounters',
	'CheckUser',
	'mediawiki-scratch-login',
	'VisualEditor',
] );

$swgUseLinkPreviews = true;

$wgScratchAccountCheckDisallowNewScratcher = true;
$wgScratchAccountJoinedRequirement = 2 * 30 * 24 * 60 * 60;

# SB has zh variants but no zh
$wgScratchBlocks4Langs = array_merge(
	array_diff( $wgScratchBlocks4Langs, [ 'zh' ] ),
	[ 'zh_tw', 'zh_cn' ]
);

## Site-specific extensions and their settings

# RecentChangesWebhooks extension - added August 14 2018
wfLoadExtension( 'RecentChangesWebhooks' );
# URL configured in config/private
$wgRCWHookType = 'job';

wfLoadExtension( 'scratch-confirmaccount-v3-webhooks' );
# URL configured in config/private
