<?php
use MediaWiki\SpecialPage\Hook\SpecialPageAfterExecuteHook;
use MediaWiki\Api\Hook\APIAfterExecuteHook;
use MediaWiki\Hook\ParserAfterTidyHook;

class ResourceLoggerHooks implements SpecialPageAfterExecuteHook, APIAfterExecuteHook {
	function onSpecialPageAfterExecute($special, $subpage): void {
		self::logResourceUsage();
	}
	
	function onAPIAfterExecute($module): void {
		self::logResourceUsage();
	}
	
	function onParserAfterTidy($parser, &$text): void {
		self::logResourceUsage();
	}
	
	private static function peakMemoryUsageInMB(): int {
		return (int)(memory_get_peak_usage() / 1000000);
	}
	
	private static function logResourceUsage() {
		$memUsage = self::peakMemoryUsageInMB();
		$uptime = time() - $_SERVER['REQUEST_TIME'];
				
		if ($memUsage >= 50 || $uptime > 5) {
			file_put_contents('/tmp/resource-log-en.txt', date('Y-m-d H:i:s', $_SERVER['REQUEST_TIME']) . "\t" . $_SERVER['HTTP_HOST'] . "\t" . $_SERVER['REQUEST_URI'] . "\t" . 'Memory: ' . $memUsage . 'MB' . "\t" . 'Uptime: ' . $uptime . ' sec' . "\n", FILE_APPEND | LOCK_EX);
		}
	}
}