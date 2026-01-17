<?php
//$wgReadOnly = ( PHP_SAPI === 'cli' ) ? false : 'This wiki is currently being upgraded to a newer software version. Please check back later.';

// ini_set('display_errors', 'On');
// ini_set('log_errors', 'On');
// error_reporting(E_ALL);

# When you make changes to this configuration file, this will make
# sure that cached pages are cleared.
$wgCacheEpoch = max( $wgCacheEpoch, gmdate( 'YmdHis', @filemtime( __FILE__ ) ) );

## Settings that are always site-specific

$wgSitename = "Dutch Scratch-Wiki";
$wgLanguageCode = "nl-informal";
$wgLogo = "/w/images/Dutch_Scratch_Wiki_logo.png";

## Other site-specific non-extension settings

$swgEmailOptions = false;
$wgEnotifUserTalk      = false; # UPO
$wgEnotifWatchlist     = false; # UPO
$wgEmailAuthentication = true;

$swgRightsOptions = false;
$wgRightsPage = "";
$wgRightsUrl  = "";
$wgRightsText = "";
$wgRightsIcon = "";

## Site-specific permissions

# Setting of permissions for bureaucrats, added: 20120412 by DL6DBN
# Bureaucrats may create accounts and delete pages.
$wgGroupPermissions['bureaucrat']['createaccount']  = true;
$wgGroupPermissions['bureaucrat']['delete']  = true;
$wgGroupPermissions['bureaucrat']['bigdelete']  = true;
$wgGroupPermissions['bureaucrat']['undelete']  = true;
$wgGroupPermissions['bureaucrat']['deletedhistory']  = true;
$wgGroupPermissions['bureaucrat']['deletedtext']  = true;

$wgGroupPermissions['sysop']['interwiki'] = true;

## Common extensions and their settings

$swgUseExtensions = array_merge( $swgUseExtensions, [
	'VisualEditor',
	'mediawiki-scratch-login',
] );

$swgUseLinkPreviews = true;

## Site-specific extensions and their settings
