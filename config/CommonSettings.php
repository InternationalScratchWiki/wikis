<?php
## This file contains settings common to all wikis.
## It is included by wiki/w/LocalSettings.php which is expected to have set the $wiki variable.

if (!defined('MEDIAWIKI')) die('This script must be included!\n');

## Set nonpublishable settings like DB info, etc.
require_once __DIR__ . '/private/CommonSettings.php';

$wgCacheEpoch = max( $wgCacheEpoch, gmdate( 'YmdHis', @filemtime( __FILE__ ) ) );

## The following settings are not locally customizable

# Wikis cannot control their domain.
$wgServer = "https://$wiki.scratch-wiki.info";
# These must be universal.
$wgScriptPath       = "/w";
$wgArticlePath      = "/wiki/$1";
$wgUsePathInfo      = true;
$wgStylePath = "$wgScriptPath/skins";

# Wikis cannot control their database.
$wgDBtype = 'mysql';
$wgDBserver = 'localhost';
$wgDBname = $swgDB[$wiki]['name'];
$wgDBuser = $swgDB[$wiki]['user'];
$wgDBpassword = $swgDB[$wiki]['password'];
$wgDBprefix = $swgDB[$wiki]['prefix'];
$wgDBTableOptions = 'ENGINE=InnoDB, DEFAULT CHARSET=' . $swgDB[$wiki]['charset'];

# Wikis cannot have differing performance.
$wgMainCacheType = CACHE_ACCEL;
$wgSessionCacheType = CACHE_DB;
$wgMemCachedServers = [];
$wgCacheDirectory = "/home/scratchwiki/web/cache/$wiki";
// file cache originally enabled Janaury 13, 2019
$wgUseFileCache = true;
$wgFileCacheDirectory = "/home/scratchwiki/web/cache/$wiki";

# Wikis must have account request emails.
$wgEmergencyContact = "contact@scratch-wiki.info";
$wgPasswordSender   = "no-reply@scratch-wiki.info";
$NoReplyAddress     = "no-reply@scratch-wiki.info";
$wgEnableEmail      = true;
# CG compliance: user email is private communication.
$wgEnableUserEmail  = false; # UPO

# Wikis cannot have different default skins.
$wgDefaultSkin = "scratchwikiskin2";

# These are the only skins installed.
wfLoadSkin( 'MinervaNeue' );
wfLoadSkin( 'MonoBook' );
wfLoadSkin( 'ScratchWikiSkin2' );
wfLoadSkin( 'Timeless' );
wfLoadSkin( 'Vector' );

# Wikis cannot control where uploads go.
$wgUploadDirectory = "$IP/images/$wiki";
$wgUploadPath = '/w/images';
$wgHashedUploadDirectory = $swgDB[$wiki]['uploadHashing'];

// do not run jobs since we have a cron job for that
$wgJobRunRate = 0.0;// 0.25;
$wgRunJobsAsync = true;

// manually set search type because it defaults to dummy for some reason
// added Oct 25, 2020 by Kenny2scratch
$wgSearchType = 'SearchMySQL';

// set the autoblock expiry to be 180 days instead of the default 24 hours
$wgAutoblockExpiry = 15552000;

// use faster diff tools
$wgDiff = '/bin/diff';
$wgDiff3 = '/bin/diff3';

# Permissions. These must be global.

// Anons must not be allowed to edit
$wgGroupPermissions['*']['edit'] = false;
$wgGroupPermissions['*']['createpage'] = false;
$wgGroupPermissions['*']['createtalk'] = false;
$wgGroupPermissions['*']['writeapi'] = false;
// Registered users must be allowed to edit
$wgGroupPermissions['user']['edit'] = true;
$wgGroupPermissions['user']['createpage'] = true;
$wgGroupPermissions['user']['createtalk'] = true;
$wgGroupPermissions['user']['writeapi'] = true;
// Anons and regular users must not be allowed to create accounts
$wgGroupPermissions['*']['createaccount'] = false;
$wgGroupPermissions['user']['createaccount'] = false;
// Bureaucrats must be allowed to create accounts
$wgGroupPermissions['bureaucrat']['createaccount'] = true;
// Regular users must not be allowed to create or apply change tags
$wgGroupPermissions['user']['changetags'] = false;
$wgGroupPermissions['user']['applychangetags'] = false;
// Regular users must not be allowed to change page content models
$wgGroupPermissions['user']['editcontentmodel'] = false;
// Bureaucrats must be allowed to block
$wgGroupPermissions['bureaucrat']['block'] = true;
$wgGroupPermissions['bureaucrat']['blockemail'] = true;
// Bureaucrats must be allowed to rename users
$wgGroupPermissions['bureaucrat']['renameuser'] = true;

# All wikis are viewed by an multinational audience.
# Set default timezone to UTC for universality
$wgLocaltimezone = "UTC";

# Blocks must not be public.
# modified to use extension on Sept 19, 2020 by Kenny2scratch
wfLoadExtension( 'OSBlocks' );

# Wikis must be able to connect to each other.
wfLoadExtension( 'Interwiki' );
# Bureaucrats must be able to configure that connection.
$wgGroupPermissions['bureaucrat']['interwiki'] = true;
# WikiEditor extension is mandatory.
wfLoadExtension( 'WikiEditor' );

# Cookie warning is required for GDPR compliance.
// added by jvvg 15 April 2021
wfLoadExtension('CookieWarning');
$wgCookieWarningEnabled = true;
$wgCookieWarningMoreUrl = 'https://de.scratch-wiki.info/wiki/Scratch-Wiki:Datenschutz';

## The following settings come in packages
## Wikis can customize them by not enabling the $swg option and configuring them separately

if ($swgEmailOptions) {
	## UPO means: this is also a user preference option

	$wgEnotifUserTalk      = true; # UPO
	$wgEnotifWatchlist     = true; # UPO
	$wgEmailAuthentication = true;
}

if ($swgEnableUploads) {
	$wgEnableUploads  = true;
	$wgUseImageMagick = true;
	$wgImageMagickConvertCommand = "/usr/bin/convert";
	$wgFileExtensions = array_unique( array_merge(
		$wgFileExtensions ?? [],
		[ 'png', 'gif', 'jpg', 'jpeg', 'pdf', 'sb', 'sb2', 'sb3', 'sprite', 'sprite2', 'sprite3', 'svg']
	) );
	## If you use ImageMagick (or any other shell command) on a
	## Linux server, this will need to be set to the name of an
	## available UTF-8 locale
	$wgShellLocale = "en_US.utf8";
}

if ($swgRightsOptions) {
	## For attaching licensing metadata to pages, and displaying an
	## appropriate copyright notice / icon. GNU Free Documentation
	## License and Creative Commons licenses are supported so far.
	$wgRightsPage = ""; # Set to the title of a wiki page that describes your license/copyright
	$wgRightsUrl  = "https://creativecommons.org/licenses/by-sa/4.0/";
	$wgRightsText = "CC BY-SA 4.0";
	$wgRightsIcon = "{$wgScriptPath}/resources/assets/licenses/cc-by-sa.png";
}

if ($swgRealNameOptions) {
	$wgAllowRealName = false;
	$wgHiddenPrefs[] = 'realname';
}

if ($swgBetaToolbar) {
	$wgDefaultUserOptions['usebetatoolbar'] = 1;
	$wgDefaultUserOptions['usebetatoolbar-cgd'] = 1;
}

# Extensions that require no additional configuration
$trivialExtensions = [
	'CategoryTree',
	'CharInsert',
	'Cite',
	'DismissableSiteNotice',
	'InputBox',
	'RandomInCategory',
	'RandomSelection',
	'mw-scratchsig3',
	'scratch-confirmaccount-v3',
	'Editcount',
	'SyntaxHighlight_PrismJS',
	'NativeSvgHandler',
	// EmbedVideo is a fork since 1.39 upgrade
	'EmbedVideo',
	'LabeledSectionTransclusion',
	'mw-embedScratch',
	'mw-embedPhosphorus',
	'DynamicPageList4',
	'TitleKey',
	'HitCounters',
	'Math',
	// use Litespeed cache, added March 14, 2025 by jvvg
	//'LiteSpeedCache',
	'Report',
	'mediawiki-scratch-login',
	'EventStreamConfig',
	'EventLogging',
	'Loops',
];
# Other names for some extensions
$extensionAliases = [
	'ScratchSig' => 'mw-scratchsig3',
	'ScratchBlocks' => 'mw-ScratchBlocks4',
	'DSN' => 'DismissableSiteNotice',
	'RIC' => 'RandomInCategory',
	'ConfirmAccount3' => 'scratch-confirmaccount-v3',
	'ConfirmAccounts' => 'scratch-confirmaccount-v3',
	'ConfirmAccount' => 'scratch-confirmaccount-v3',
	'GoogleAnalytics' => 'GTag',
	'SyntaxHighlight' => 'SyntaxHighlight_PrismJS',
	'SyntaxHighlight_GeSHi' => 'SyntaxHighlight_PrismJS',
	'NSH' => 'NativeSvgHandler',
	'LST' => 'LabeledSectionTransclusion',
	'EmbedScratch' => 'mw-embedScratch',
	'EmbedPhosphorus' => 'mw-embedPhosphorus',
	'DynamicPageList' => 'DynamicPageList4',
	'DynamicPageList3' => 'DynamicPageList4',
	'MathExt' => 'Math',
	'LsCache' => 'LiteSpeedCache',
	'Notifications' => 'Echo',
	'ScratchLogin' => 'mediawiki-scratch-login',
	'ScratchPasswordReset' => 'mediawiki-scratch-login',
];
foreach ( array_unique( $swgUseExtensions ) as $ext ) {
	if ( isset( $extensionAliases[$ext] ) ) $ext = $extensionAliases[$ext];
	# Extensions that require no additional configuration
	if ( in_array( $ext, $trivialExtensions ) ) wfLoadExtension( $ext );
	# Extensions packaged with additional configuration
	if ( $ext == 'ParserFunctions' ) {
		wfLoadExtension( $ext );
		$wgPFEnableStringFunctions = true;
	}
	if ( $ext == 'VisualEditor' ) {
		wfLoadExtension( $ext );
		$wgDefaultUserOptions['visualeditor-enable'] = 0;
		// Anons require access to the write API for VisualEditor to work
		$wgGroupPermissions['*']['writeapi'] = true;
		// Provide API for VisualEditor to understand templates
		// Added by Kenny2scratch 2026-01-17
		wfLoadExtension( 'TemplateData' );
	}
	if ( $ext == 'AbuseFilter' ) {
		wfLoadExtension( $ext );
		$wgGroupPermissions[$swgAFsysop]['abusefilter-modify'] = true;
		$wgGroupPermissions[$swgAFsysop]['abusefilter-log'] = true;
		$wgGroupPermissions['*']['abusefilter-log'] = false;
		$wgGroupPermissions['*']['abusefilter-log-detail'] = false;
		$wgGroupPermissions[$swgAFsysop]['abusefilter-log-detail'] = true;
		$wgGroupPermissions['*']['abusefilter-view'] = true;
		$wgGroupPermissions['*']['abusefilter-private'] = false;
		$wgGroupPermissions['*']['abusefilter-modify-restricted'] = false;
		$wgGroupPermissions[$swgAFsysop]['abusefilter-private'] = true;
		$wgGroupPermissions[$swgAFsysop]['abusefilter-modify-restricted'] = true;
		$wgGroupPermissions[$swgAFsysop]['abusefilter-revert'] = true;
		$wgGroupPermissions[$swgAFsysop]['abusefilter-log-private'] = true;
		$wgGroupPermissions['*']['abusefilter-view-private'] = false;
		$wgGroupPermissions[$swgAFsysop]['abusefilter-view-private'] = true;
		$wgGroupPermissions[$swgAFsysop]['abusefilter-hide-log'] = true;
		$wgGroupPermissions[$swgAFsysop]['abusefilter-hidden-log'] = true;
		$wgGroupPermissions[$swgAFsysop]['abusefilter-modify-global'] = true;
	}
	if ( $ext == 'GTag' && isset( $swgGoogleAnalyticsAccount ) ) {
		wfLoadExtension( $ext );
		$wgGTagAnalyticsId = $swgGoogleAnalyticsAccount;
		$wgGTagAnonymizeIP = true;
		$wgGTagEnableTCF = true;
		$wgGTagHonorDNT = true;
		$wgGTagTrackSensitivePages = false;
		$wgGroupPermissions['bot']['gtag-exempt'] = true;
	}
	if ( $ext == 'CodeMirror' ) {
		wfLoadExtension( $ext );
		$wgDefaultUserOptions['usecodemirror'] = true;
	}
	if ( $ext == 'CheckUser' ) {
		wfLoadExtension( $ext );
		$wgGroupPermissions['bureaucrat']['checkuser'] = true;
		$wgGroupPermissions['bureaucrat']['checkuser-log'] = true;
	}
	// use Echo - added December 18, 2023 by jvvg
	if ( $ext == 'Echo' ) {
		wfLoadExtension( $ext );
		//$wgEchoUseJobQueue = true; // disabled while job queue is difficult to use
	}
	// Custom ScratchBlocks extension by apple502j
	// Find here: https://github.com/apple502j/mw-ScratchBlocks4
	if ( $ext == 'mw-ScratchBlocks4' ) {
		wfLoadExtension( $ext );
		// to correct for MW vs ScratchBlocks language code differences
		$mwToSbLangMap = [
			'nl-informal' => 'nl',
		];
		$wgScratchBlocks4Langs = array_unique( array_merge(
			$wgScratchBlocks4Langs ?? [], // allow adding other languages
			// but wiki language and en are mandatory
			[ $mwToSbLangMap[$wgLanguageCode] ?? $wgLanguageCode, 'en' ]
		) );
	}
}

if ($swgAllowUserCSSJS) {
	$wgAllowUserCss = true;
	$wgAllowUserJs = true;
}

if (!$swgUseWELabs) {
	$wgDefaultUserOptions['wikieditor-publish'] = 0;
	$wgDefaultUserOptions['wikieditor-preview'] = 0;
	$wgHiddenPrefs[] = 'wikieditor-publish';
	$wgHiddenPrefs[] = 'wikieditor-preview';
}

//show link previews if enabled
if ($swgUseLinkPreviews) {
	$wgExtractsRemoveClasses = array_merge( $wgExtractsRemoveClasses ?? [], [ '.extract-ignore' ] );
	// wfLoadExtension('TextExtracts');
	// Disabled due to CG-violating license by Kenny2scratch 2026-01-20
	// wfLoadExtension('PageImages');
	// wfLoadExtension('Popups');
}

if ($swgUseForeignFiles) {
	foreach ( $swgDB as $code => $data ) {
		if ( $code == $wiki ) continue;
		$wgForeignFileRepos[] = [
			'class' => 'ForeignDBRepo',
			'name' => $code . 'wiki',
			'url' => "https://$code.scratch-wiki.info/w/images",
			'directory' => "/home/scratchwiki/web/wiki/w/images/$code",
			'hashLevels' => $data['uploadHashing'] ? 2 : 0,
			'dbType' => 'mysql',
			'dbServer' => 'localhost',
			'dbUser' => $data['user'],
			'dbPassword' => $data['password'],
			'dbName' => $data['name'],
			'dbFlags' => DBO_DEFAULT,
			'hasSharedCache' => false,
			'tablePrefix' => $data['prefix'],
			'descBaseUrl' => "https://$code.scratch-wiki.info/wiki/File:",
			'fetchDescription' => false
		];
	}
}

if ($swgDebugLogs) {
	$date = gmdate( 'Y-m-d' );
	$wgDebugLogFile = "/home/scratchwiki/web/logs/$wiki/$date-requests.log";
	$wgDebugLogGroups['ratelimit'] = "/home/scratchwiki/web/logs/$wiki/$date-ratelimit.log";
}

if ($swgMergePermissionsInto) {
	// give	a group suppressor and interface admin permissions
	// some suppressor permissions given partially by Kenny2scratch 2020-08-24
	// some interface admin permissions given partially by jvvg 2021-03-09
	// all of both given by Kenny2scratch 2025-12-30
	// given to sysops instead of bureaucrats, and globally, by Kenny2scratch 2026-01-15
	// given to configurable group and source groups unset globally by Kenny2scratch 2026-01-19
	foreach ( ['interface-admin', 'suppress'] as $group ) {
		foreach ( $wgGroupPermissions[$group] as $perm => $given ) {
			$wgGroupPermissions[$swgMergePermissionsInto][$perm] = ($given || $wgGroupPermissions[$swgMergePermissionsInto][$perm]);
		}
		// Remove the group
		unset( $wgGroupPermissions[$group] );
		unset( $wgRevokePermissions[$group] );
		unset( $wgAddGroups[$group] );
		unset( $wgRemoveGroups[$group] );
		unset( $wgGroupsAddToSelf[$group] );
		unset( $wgGroupsRemoveFromSelf[$group] );
	}
}

// load checker to avoid overloading the server with excessive requests
require dirname(__FILE__) . '/loadchecker.php';
