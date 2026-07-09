<?php
$baseUrl = getenv('BASE_URL') ?: '/';
define('BASE_URL', rtrim($baseUrl, '/') . '/');
?>
