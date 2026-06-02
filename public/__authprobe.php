<?php
// TEMPORARY diagnostic — DELETE after use.
header('Content-Type: text/plain');

echo "SAPI:            " . PHP_SAPI . "\n";
echo "SERVER_SOFTWARE: " . ($_SERVER['SERVER_SOFTWARE'] ?? '(unset)') . "\n";
echo "--- what PHP received for auth ---\n";
echo "PHP_AUTH_USER:               " . ($_SERVER['PHP_AUTH_USER'] ?? '(unset)') . "\n";
echo "PHP_AUTH_PW:                 " . ($_SERVER['PHP_AUTH_PW'] ?? '(unset)') . "\n";
echo "HTTP_AUTHORIZATION:          " . ($_SERVER['HTTP_AUTHORIZATION'] ?? '(unset)') . "\n";
echo "REDIRECT_HTTP_AUTHORIZATION: " . ($_SERVER['REDIRECT_HTTP_AUTHORIZATION'] ?? '(unset)') . "\n";

$apache = function_exists('apache_request_headers') ? apache_request_headers() : [];
echo "apache Authorization header:  " . ($apache['Authorization'] ?? $apache['authorization'] ?? '(unset)') . "\n";

echo "getenv HTTP_AUTHORIZATION:    " . (getenv('HTTP_AUTHORIZATION') ?: '(unset)') . "\n";
echo "getenv REDIRECT_HTTP_AUTHORIZATION: " . (getenv('REDIRECT_HTTP_AUTHORIZATION') ?: '(unset)') . "\n";
