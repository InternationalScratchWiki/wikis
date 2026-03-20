<?php
$expiry_secs = 7200;
$load_threshold = 750;

$ip = isset($_SERVER['CF-Connecting-IP']) ? $_SERVER['CF-Connecting-IP'] : (isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : '(no remote addr)');

$cache_key = 'load_for[' . $ip . ']';
$load = apcu_inc($cache_key, 1, $x, $expiry_secs);

if ($load > $load_threshold) {
    header('HTTP/1.1 429 Rate Limit Exceeded');
    
    $key_info = apcu_key_info($cache_key);
    $retry_interval = $expiry_secs - (time() - $key_info['creation_time']);
    header('Retry-After: ' . $retry_interval);
    
    file_put_contents('/home/scratchwiki/logs/loadcheck.log', time() . "\t" . $_SERVER['HTTP_HOST'] . "\t" . $ip . "\n", FILE_APPEND | LOCK_EX);
    
    echo 'You have exceeded the amount of requests you are allowed to make. This will expire in ' . $retry_interval . ' second(s). Contact us on <a href="https://scratch.mit.edu/discuss/topic/294197/">the Wiki forum topic</a> if you are seeing this message and think you haven\'t been making a particularly high volume of requests.'; die;
} else {
    header('X-Server-Load: ' . $load);
}
