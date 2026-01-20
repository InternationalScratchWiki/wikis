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

$swgMergePermissionsInto = 'sysop';
