<?php
$dbHost = getenv('DB_HOST') ?: 'localhost';
$dbPort = getenv('DB_PORT') ?: '3306';
$dbName = getenv('DB_DATABASE') ?: 'unmute_music';
$dbUser = getenv('DB_USERNAME') ?: 'root';
$dbPass = getenv('DB_PASSWORD') ?: '';

$databaseUrl = getenv('DATABASE_URL');
if ($databaseUrl) {
    $parts = parse_url($databaseUrl);
    $scheme = $parts['scheme'] ?? '';

    if (in_array($scheme, ['mysql', 'mariadb'], true)) {
        $dbHost = $parts['host'] ?? $dbHost;
        $dbPort = isset($parts['port']) ? (string) $parts['port'] : $dbPort;
        $dbUser = isset($parts['user']) ? urldecode($parts['user']) : $dbUser;
        $dbPass = isset($parts['pass']) ? urldecode($parts['pass']) : $dbPass;
        $dbName = isset($parts['path']) ? ltrim($parts['path'], '/') : $dbName;
    } elseif ($scheme === 'postgres' || $scheme === 'postgresql') {
        die('This Core PHP application uses mysqli and requires a MySQL or MariaDB database.');
    }
}

$conn = mysqli_connect($dbHost, $dbUser, $dbPass, $dbName, (int) $dbPort);

if (!$conn) {
    error_log('Database connection failed: ' . mysqli_connect_error());
    die('Database connection failed');
}

mysqli_set_charset($conn, 'utf8mb4');
?>
