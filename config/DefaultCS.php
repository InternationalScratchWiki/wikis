<?php
$wgCacheEpoch = max( $wgCacheEpoch, gmdate( 'YmdHis', @filemtime( __FILE__ ) ) );

// Common default LocalSettings options

# Enable subpages in all namespaces
$wgNamespacesWithSubpages = array_fill(0, 1000, true);
# Making this mandatory would break enwiki image links
$wgHashedUploadDirectory = true;
# Wikis occasionally need local debugging
$wgShowExceptionDetails = false;
# Users are allowed to suppress auto-redirect creation
$wgGroupPermissions['user']['suppressredirect'] = true;
// give	sysops suppressor and interface admin permissions
// some suppressor permissions given partially by Kenny2scratch 2020-08-24
// some interface admin permissions given partially by jvvg 2021-03-09
// all of both given by Kenny2scratch 2025-12-30
// given to sysops instead of bureaucrats, and globally, by Kenny2scratch 2026-01-15
foreach ( ['interface-admin', 'suppress'] as $group ) {
	foreach ( $wgGroupPermissions[$group] as $perm => $given ) {
		$wgGroupPermissions['bureaucrat'][$perm] = ($given || $wgGroupPermissions['bureaucrat'][$perm]);
	}
}
# Allow Scratch and Wikipedia images to be hotlinked
$wgAllowExternalImagesFrom = [
	'https://scratch.mit.edu/',
	'https://cdn2.scratch.mit.edu/',
	'https://cdn.scratch.mit.edu/',
	'https://uploads.scratch.mit.edu/',
	'https://cdn.assets.scratch.mit.edu/',
	'https://upload.wikimedia.org/',
];
# Disable bot passwords
$wgEnableBotPasswords = false;
# Sysops are normally allowed to create accounts
$wgGroupPermissions['sysop']['createaccount'] = true;
# Sysops and bots are normally allowed to apply change tags
$wgGroupPermissions['bot']['applychangetags'] = true;
$wgGroupPermissions['sysop']['applychangetags'] = true;
# Sysops are normally allowed to create change tags
$wgGroupPermissions['sysop']['changetags'] = true;
# Sysops are normally allowed to change page content models
$wgGroupPermissions['sysop']['editcontentmodel'] = true;

// Default CommonSettings options

$swgEmailOptions = true;

$swgEnableUploads = true;

$swgRightsOptions = true;

$swgRealNameOptions = true;

$swgBetaToolbar = true;

$swgUseExtensions = [
	'CategoryTree',
	'CharInsert',
	'Cite',
	'InputBox',
	'ParserFunctions',
	'ScratchSig',
	'ScratchBlocks',
	'ConfirmAccount3',
	'Editcount',
	'CodeMirror',
	'LsCache',
];

$swgAFsysop = 'sysop';
$swgGoogleAnalyticsAccount = NULL; // this MUST be set in LS

$swgAllowUserCSSJS = true;

$swgUseWELabs = false;

$swgUseLinkPreviews = true;

$swgUseForeignFiles = true;

$swgDebugLogs = false;
