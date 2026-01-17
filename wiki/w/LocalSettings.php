<?php
# Protect against web entry
if ( !defined( 'MEDIAWIKI' ) ) {
	exit;
}

#ini_set('display_errors', 'On');
#error_reporting(E_ERROR | E_PARSE | E_USER_ERROR);

$servers = [
	'en.scratch-wiki.info' => 'en',
	'de.scratch-wiki.info' => 'de',
	'fr.scratch-wiki.info' => 'fr',
	'hu.scratch-wiki.info' => 'hu',
	'id.scratch-wiki.info' => 'id',
	'ja.scratch-wiki.info' => 'ja',
	'nl.scratch-wiki.info' => 'nl',
	'ru.scratch-wiki.info' => 'ru',
	'test.scratch-wiki.info' => 'test',
	'oauth2.scratch-wiki.info' => 'oauth2',
	'staging.scratch-wiki.info' => 'staging',
];
$databases = [
	'scratchwiki_enwiki' => 'en',
	'scratchwiki_dachwiki' => 'de',
	'scratchwiki_frwiki' => 'fr',
	'scratchwiki_huwiki2' => 'hu',
	'scratchwiki_idwiki' => 'id',
	'scratchwiki_jawiki' => 'ja',
	'scratchwiki_nlwiki' => 'nl',
	'scratchwiki_ruwiki' => 'ru',
	'scratchwiki_testwiki' => 'test',
	'scratchwiki_oauth2wiki' => 'oauth2',
	'scratchwiki_staging' => 'staging',
];

if (defined('MW_DB')) {
	$wiki = $databases[MW_DB] ?? null;
} else {
	$wiki = $databases[$_SERVER['MW_DB'] ?? ''] ?? $servers[$_SERVER['SERVER_NAME'] ?? ''] ?? null;
}

if (!$wiki) {
	die('Unknown wiki.');
}

$wgCacheEpoch = max( $wgCacheEpoch, gmdate( 'YmdHis', @filemtime( __FILE__ ) ) );

$confRoot = '/home/scratchwiki/web/config';
require_once "$confRoot/DefaultCS.php";
require_once "$confRoot/$wiki/LocalSettings.php";
require_once "$confRoot/CommonSettings.php";
