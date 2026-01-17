<?php
//$wgReadOnly = ( PHP_SAPI === 'cli' ) ? false : 'This wiki is currently being upgraded to a newer software version. Please check back later.';

// ini_set('display_errors', 'On');
// ini_set('log_errors', 'On');
// error_reporting(E_ALL);

# Protect against web entry
if ( !defined( 'MEDIAWIKI' ) ) {
	exit;
}

# When you make changes to this configuration file, this will make
# sure that cached pages are cleared.
$wgCacheEpoch = max( $wgCacheEpoch, gmdate( 'YmdHis', @filemtime( __FILE__ ) ) );

## Settings that are always site-specific

$wgSitename = "Hungarian Scratch-Wiki";
$wgLanguageCode = "hu";
$wgLogo = "/w/images/Hungarian_Scratch_Wiki_logo.png";

## Other site-specific non-extension settings

$wgEnotifUserTalk      = false; # UPO
$wgEnotifWatchlist     = false; # UPO
$wgEmailAuthentication = true;

## Site-specific permissions

# Grant interwiki permission to sysops, not just bureaucrats
$wgGroupPermissions['sysop']['interwiki'] = true;

# Create uploader group, restrict uploading to it, and allow sysops to manage it
# - Kenny2scratch on 2024-08-05 at request of Simiagain
$wgGroupPermissions['uploader']['upload'] = true;
$wgGroupPermissions['user']['upload'] = false;
$wgGroupPermissions['sysop']['upload'] = false;
$wgGroupPermissions['bureaucrat']['upload'] = false;
$wgAddGroups['sysop'][] = 'uploader';
$wgGroupsAddToSelf['sysop'][] = 'uploader';
$wgRemoveGroups['sysop'][] = 'uploader';
$wgGroupsRemoveFromSelf['sysop'][] = 'uploader';

## Common extensions and their settings

$swgUseExtensions = array_merge( $swgUseExtensions, [
	'VisualEditor',
	'NSH',
] );

$swgUseLinkPreviews = true;

## Site-specific extensions and their settings
