<?php
//$wgReadOnly = ( PHP_SAPI === 'cli' ) ? false : 'This wiki is currently being upgraded to a newer software version. Please check back later.';

ini_set('display_errors', 'On');
ini_set('log_errors', 'On');
error_reporting(E_ALL);
$wgShowExceptionDetails = true;

# When you make changes to this configuration file, this will make
# sure that cached pages are cleared.
$wgCacheEpoch = max( $wgCacheEpoch, gmdate( 'YmdHis', @filemtime( __FILE__ ) ) );

## Settings that are always site-specific

$wgSitename = "Scratch Wiki";
$wgLanguageCode = "en";
$wgLogo	= "/w/images/Wiki.png";

## Other site-specific non-extension settings

$wgDefaultUserOptions['forceeditsummary'] = 1;

$swgDebugLogs = true;

# Staging header color
$wgDefaultUserOptions['scratchwikiskin-header-color'] = '#FF0000';

## Site-specific permissions

$wgGroupPermissions['Experienced_Wikians']['confirmaccount'] = true;
$wgGroupPermissions['Experienced_Wikians']['createaccount'] = true;
$wgGroupPermissions['Experienced_Wikians']['movefile'] = true;
$wgGroupPermissions['Experienced_Wikians']['delete'] = true;
$wgGroupPermissions['Experienced_Wikians']['rollback'] = true;
$wgGroupPermissions['Experienced_Wikians']['patrol'] = true;
$wgGroupPermissions['Experienced_Wikians']['lookupcredentials'] = true;
$wgGroupPermissions['Experienced_Wikians']['autopatrol'] = true;

$wgGroupPermissions['sysop']['block']            = false;
$wgGroupPermissions['sysop']['blockemail']       = false;

// Protection level that includes bots
$wgRestrictionLevels[] = 'botplus';
$wgGroupPermissions['Experienced_Wikians']['botplus'] = true;
$wgGroupPermissions['sysop']['botplus'] = true;
$wgGroupPermissions['bot']['botplus'] = true;

// add a Experienced_Wikian protection level
$wgRestrictionLevels[] = 'EWplus';
// give it to experienced wikians
$wgGroupPermissions['Experienced_Wikians']['EWplus'] = true;
$wgGroupPermissions['sysop']['EWplus'] = true;

// testing built-in rate limits
// Kenny2scratch replaced RateLimiter extension test on 2025-12-30
$wgRateLimits['edit']['bureaucrat'] = [2, 60];
$wgRateLimits['move']['bureaucrat'] = [1, 60];
// most permissive limit applies
$wgRateLimits['edit']['user'] = [2, 60];
$wgRateLimits['move']['user'] = [1, 60];
// bureaucrats have noratelimit
$wgRateLimits['edit']['&can-bypass'] = false;
$wgRateLimits['move']['&can-bypass'] = false;

## Common extensions and their settings

$swgUseExtensions = array_merge( $swgUseExtensions, [
	'EmbedVideo',
	'EmbedPhosphorus',
	'Report',
	'mediawiki-scratch-login',
	'EventStreamConfig',
	'EventLogging',
	'Loops',
	'WikiSEO',
	'HitCounters',
	'DSN',
	'RIC',
	'RandomSelection',
	'AbuseFilter',
	'CheckUser',
	'SyntaxHighlight',
	'NSH',
	'VisualEditor',
	'ScratchSig',
	'EmbedScratch',
	'HitCounters',
	'Math',
	'Echo',
] );

$swgUseLinkPreviews = true;
$wgExtractsRemoveClasses = ['.noextract'];

# Allow EWs to handle reports
$wgGroupPermissions['Experienced_Wikians']['handle-reports'] = true;

$wgWikiSeoDefaultImage = 'x.png';
$wgTwitterCardType = 'summary';

## Site-specific extensions and their settings

# RecentChangesWebhooks extension - added June 4th, 2018 by Kenny2scratch
wfLoadExtension( 'RecentChangesWebhooks' );
# URL configured in config/private

# GuidedTour extension - added June 25 2020 by Kenny2scratch
$wgEventLoggingBaseUri = 'http://localhost:8100/event.gif';
$wgEventLoggingFile = '/home/scratchwiki/logs/eventlogging-en.log';
wfLoadExtension('GuidedTour');

wfLoadExtension('HiddenBlockAppealEmail');
$wgBlockAppealEmail = 'appeals@example.com';

wfLoadExtension('scratch-confirmaccount-v3-webhooks');
# URL configured in config/private

wfLoadExtension('mediawiki-elections');
$wgElectionActive = false;
$wgElectionId = '12345';
$wgElectionCandidates = ['jvvg', 'kenny2scratch'];
$wgElectionMinRegistrationDate = 0;
$wgElectionCountMethod = 'confidence';
$wgGroupPermissions['user']['vote'] = true;
$wgGroupPermissions['sysop']['viewelectionresults'] = true;

wfLoadExtension('ResourceLogger');
