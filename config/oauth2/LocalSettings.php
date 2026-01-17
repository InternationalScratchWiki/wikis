<?php
//$wgReadOnly = ( PHP_SAPI === 'cli' ) ? false : 'This wiki is currently being upgraded to a newer software version. Please check back later.';

// ini_set('display_errors', 'On');
// ini_set('log_errors', 'On');
// error_reporting(E_ALL);

# When you make changes to this configuration file, this will make
# sure that cached pages are cleared.
$wgCacheEpoch = max( $wgCacheEpoch, gmdate( 'YmdHis', @filemtime( __FILE__ ) ) );

## Settings that are always site-specific

$wgSitename = "ScratchOAuth2";
$wgMetaNamespace = "SOA2";
$wgLanguageCode = "en";
$wgLogo	= "/w/images/thumb/1/1c/Auth-lock.png/100px-Auth-lock.png";

## Other site-specific non-extension settings

$swgEmailOptions = false;
$wgEnotifUserTalk      = false; # UPO
$wgEnotifWatchlist     = false; # UPO
$wgEmailAuthentication = true;

$wgHooks['PersonalUrls'][] = function ( array &$personal_urls, $title, $skin ) {
	$personal_urls[] = ['text' => 'SOA2 Admin', 'href' => Title::newFromText('Special:SOA2Admin')->getLinkURL()];
};

## Site-specific permissions

## Common extensions and their settings

$swgUseExtensions = array_merge( $swgUseExtensions, [
	'CodeEditor',
] );

$swgUseLinkPreviews = true;

$wgSWS2JoinBox = false;
$wgSWS2ForceDarkTheme = true;

## Site-specific extensions and their settings

wfLoadExtension( 'OGMetaPF' );

wfLoadExtension( 'ScratchOAuth2' );
$wgSOA2AdminUsers = [10114764, 35751470, 62962013];
