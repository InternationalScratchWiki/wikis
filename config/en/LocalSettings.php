<?php
//$wgReadOnly = ( PHP_SAPI === 'cli' ) ? false : 'This wiki is currently being upgraded to a newer software version. Please check back later.';

ini_set('display_errors', 'On');
// ini_set('log_errors', 'On');
error_reporting(E_ERROR | E_PARSE | E_USER_ERROR);
$wgShowExceptionDetails = true;

# When you make changes to this configuration file, this will make
# sure that cached pages are cleared.
$wgCacheEpoch = max( $wgCacheEpoch, gmdate( 'YmdHis', @filemtime( __FILE__ ) ) );

## Settings that are always site-specific

$wgSitename = "Scratch Wiki";
$wgLanguageCode = "en";
$wgLogo	= "/w/images/Wiki.png";

// This was the setting that broke everything, goddamnit.
//$wgArticlePath = "$wgScriptPath/$1";
// from Kenny2scratch: I kept this ^ here because it's so hilarious

## Other site-specific non-extension settings

$wgAllowCopyUploads = true;

$wgDefaultUserOptions['forceeditsummary'] = 1;

$swgDebugLogs = true;

$wgMemoryLimit = '256M';
$wgMaxShellMemory = 512000;
$wgMaxImageArea = 64000000;

# RC limits
$wgRCLinkLimits = [ 50, 100, 200 ];
$wgRCLinkDays = [ 1, 3, 7 ];
$wgRCMaxAge = 86400 * 30;
$wgRCLinkLimits = [ 50, 100 ];
$wgRCFilterByAge = true;

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

# Add the "wikian" protection level
$wgRestrictionLevels[] = 'wikian';
# Give Wikians all autoconfirmed permissions - Kenny2scratch 2025-12-30
$wgGroupPermissions['wikian'] = $wgGroupPermissions['autoconfirmed'];
# Add the "wikian" usergroup and allow it to edit "wikian"-protected pages
$wgGroupPermissions['wikian']['wikian'] = true;
# Give the "wikian" permission to sysops so that they can apply the protection level
$wgGroupPermissions['sysop']['wikian'] = true;
# Bots are controlled by "wikian"s
$wgGroupPermissions['bot']['wikian'] = true;
# Automatically promote users over a month old and over 50 edits
$wgAutopromote['wikian'] = [
	'&',
	[APCOND_EDITCOUNT, 50],
	[APCOND_AGE, 2592000],
];
# Make Wikian an implicit-only group - Kenny2scratch 2025-12-30
$wgImplicitGroups[] = 'wikian';
# Remove autoconfirmed ("New Wikian") if Wikian is granted - Kenny2scratch 2025-12-30
define('APCOND_MAXEDITCOUNT', 50);
define('APCOND_MAXAGE', 51);
$wgHooks['AutopromoteCondition'][] = function ( $type, array $args, User $user, ?bool &$result ) {
	$services = MediaWiki\MediaWikiServices::getInstance();
	$options = $services->getMainConfig();
	switch ($type) {
		case APCOND_MAXEDITCOUNT:
			$reqEditCount = $args[0] ?? $options->get(MediaWiki\MainConfigNames::AutoConfirmCount);
			if ($reqEditCount < 0) {
				$result = false;
				return;
			}
			$result = $user->isRegistered() && $services->getUserEditTracker()->getUserEditCount($user) <= $reqEditCount;
			return;
		case APCOND_MAXAGE:
			$reqAge = $args[0] ?? $options->get(MediaWiki\MainConfigNames::AutoConfirmAge);
			$age = time() - (int)wfTimestampOrNull(TS_UNIX, $user->getRegistration());
			$result = $age <= $reqAge;
			return;
	}
};
// invert Wikian conditions
$wgAutopromote['autoconfirmed'] = [
        '|',
        [APCOND_MAXEDITCOUNT, 50-1],
        [APCOND_MAXAGE, 2592000-1],
];

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

$wgGroupPermissions['autoconfirmed']['autoconfirmed'] = false;
$wgGroupPermissions['wikian']['autoconfirmed'] = true;
$wgRateLimits['edit']['newbie'] = [1, 180];
$wgRateLimits['move']['newbie'] = [1, 180];

## Common extensions and their settings

$swgUseExtensions = array_merge( $swgUseExtensions, [
	'Report',
	'mediawiki-scratch-login',
	'EventStreamConfig',
	'EventLogging',
	'DSN',
	'RIC',
	'RandomSelection',
	'AbuseFilter',
	'CheckUser',
	'SyntaxHighlight',
	'NSH',
	'Math',
	'Echo',
] );

$swgUseLinkPreviews = true;

# Allow EWs to handle reports
$wgGroupPermissions['Experienced_Wikians']['handle-reports'] = true;

$wgScratchLoginAuthenticator = 'project';

//ConfirmAccount settings
$wgScratchAccountCheckDisallowNewScratcher = true; // New Scratchers cannot submit requests
$wgScratchAccountJoinedRequirement = 2 * 30 * 24 * 60 * 60; // Accounts must have been registered for 60 days (2 months)
$wgRateLimits["requestaccountaction"]["ip"] = [1, 120];

//VisualEditor settings
$wgVisualEditorAvailableNamespaces = [
	'Project' => true
];

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
$wgBlockAppealEmail = 'appeals-en@scratch-wiki.info';

wfLoadExtension('scratch-confirmaccount-v3-webhooks');
# URL configured in config/private

wfLoadExtension('DiffBlocker');

//election code
wfLoadExtension('mediawiki-elections');
$wgElectionActive = time() <= 1767312000; // January 2, 2026, midnight UTC
$wgElectionId = '520ce3a55ded';
$wgElectionCandidates = ['A-MARIO-PLAYER', 'Mrsrec', 'minikiwigeek2'];
$wgElectionMinRegistrationDate = 1764806400; //December 4, 2025, midnight UTC
$wgElectionCountMethod = 'borda';
$wgGroupPermissions['user']['vote'] = true;
$wgGroupPermissions['Experienced_Wikians']['vote'] = false;
$wgGroupPermissions['Experienced_Wikians']['viewelectionresults'] = true;

wfLoadExtension('ResourceLogger');
