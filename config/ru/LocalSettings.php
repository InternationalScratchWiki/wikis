<?php
//$wgReadOnly = ( PHP_SAPI === 'cli' ) ? false : 'This wiki is currently being upgraded to a newer software version. Please check back later.';

// ini_set('display_errors', 'On');
// ini_set('log_errors', 'On');
// error_reporting(E_ALL);

# When you make changes to this configuration file, this will make
# sure that cached pages are cleared.
$wgCacheEpoch = max( $wgCacheEpoch, gmdate( 'YmdHis', @filemtime( __FILE__ ) ) );

## Settings that are always site-specific

$wgSitename = "Скретч Вики";
$wgLanguageCode = "ru";
$wgLogo = "/w/images/Russian_Scratch_Wiki_logo.png";

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

$wgCapitalLinks = false;

## Site-specific permissions

// Give sysops the permission to edit the interwiki table
$wgGroupPermissions['sysop']['interwiki'] = true;

// Require 10 edits to be autoconfirmed. Added by Kenny2scratch
// on 2023-07-19 by request of Gohoski.
$wgAutoConfirmCount = 10;

// Protection level that includes bots, added October 1, 2018 by ErnieParke
$wgRestrictionLevels[] = 'botplus';
$wgGroupPermissions['sysop']['botplus'] = true;
$wgGroupPermissions['bot']['botplus'] = true;

## Common extensions and their settings

$swgUseExtensions = array_merge( array_diff( $swgUseExtensions, [
	'Editcount', // this is specifically disabled
] ), [
	# HitCounter extension - added 2023-05-25 by Kenny2scratch at request of Gohoski
	'HitCounters',
	'VisualEditor',
	// Scratch password reset (and login) - added 2022-11-06 by Kenny2scratch
	'mediawiki-scratch-login',
] );

$swgUseLinkPreviews = true;

## Site-specific extensions and their settings

# RecentChangesWebhooks extension - added 10/07/2018 by Kenny2scratch
wfLoadExtension( 'RecentChangesWebhooks' );
# URL configured in config/private
$wgRCWHookType = 'job';

// Kenny2scratch enabled ConfirmAccount webhook on 2024-10-28 by request of admin Gohoski
wfLoadExtension( 'scratch-confirmaccount-v3-webhooks' );
# URL configured in config/private

# MobileDetect extension - added 2023-04-09 by Kenny2scratch at request of Gohoski
wfLoadExtension('MobileDetect');

wfLoadExtension('mediawiki-elections');
$wgElectionActive = false;
$wgElectionId = '25409c21-00d2-498e-8569-5bfa48b1705c';
$wgElectionCandidates = ['Scratch_craft_2', 'Idey_programm', 'Veniamin6'];
$wgElectionMinRegistrationDate = time() + 100000000; //POSIX timestamp for minimum registration date to vote
$wgElectionCountMethod = 'borda'; // borda or confidence
$wgGroupPermissions['*']['vote'] = true;
$wgGroupPermissions['bureaucrat']['viewelectionresults'] = true;
$wgGroupPermissions['sysop']['viewelectionresults'] = true;
