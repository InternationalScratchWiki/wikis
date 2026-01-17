<?php
//$wgReadOnly = ( PHP_SAPI === 'cli' ) ? false : 'This wiki is currently being upgraded to a newer software version. Please check back later.';

// ini_set('display_errors', 'On');
// ini_set('log_errors', 'On');
// error_reporting(E_ALL);

# When you make changes to this configuration file, this will make
# sure that cached pages are cleared.
$wgCacheEpoch = max( $wgCacheEpoch, gmdate( 'YmdHis', @filemtime( __FILE__ ) ) );

## Settings that are always site-specific

$wgSitename = "Das deutschsprachige Scratch-Wiki";
$wgLanguageCode = "de";
$wgLogo = "/w/images/0/01/German_Scratch_Wiki_logo.png";

## Other site-specific non-extension settings

$wgMetaNamespace = "Scratch-Wiki";
$wgNamespaceAliases["Das_deutschsprachige_Scratch-Wiki"] = NS_PROJECT;
$wgNamespaceAliases["Das_deutschsprachige_Scratch-Wiki_Diskussion"] = NS_PROJECT_TALK;

## Site-specific permissions

// To grant sysops permissions to edit interwiki data
$wgGroupPermissions['sysop']['interwiki'] = true;

//additional protection levels - added 1 October 2015 by jvvg
$wgRestrictionLevels[] = 'EWplus';

//additional user groups - added 1 October 2015 by jvvg
$wgGroupPermissions['ew']['confirmaccount'] = true;
$wgGroupPermissions['ew']['rollback'] = true;
$wgGroupPermissions['ew']['EWplus'] = true;
$wgGroupPermissions['ew']['patrol'] = true;
$wgGroupPermissions['ew']['lookupcredentials'] = true;

$wgGroupPermission['sysop']['EWplus'] = true;

## Common extensions and their settings

$swgUseExtensions = array_merge( $swgUseExtensions, [
	'EmbedVideo',
	'LST',
	'EmbedScratch',
	'EmbedPhosphorus',
	'DynamicPageList',
	'VisualEditor',
] );

$swgUseLinkPreviews = true;

## Site-specific extensions and their settings

# Add nonpublic-namespace
# Arne - 10.01.2016
wfLoadExtension('Lockdown');

define("NS_NONPUBLIC", 250);
$wgExtraNamespaces[NS_NONPUBLIC] = "Nonpublic";
$wgNamespacePermissionLockdown[NS_NONPUBLIC]['read'] = array('user')
$wgNamespacePermissionLockdown[NS_NONPUBLIC]['edit'] = array('user')
