<?php
/**
 * BinaLib - Database Configuration
 *
 * Mendukung:
 * - XAMPP/LAMPP lokal
 * - Docker Compose
 *
 * Docker Compose:
 *   BLS_DB_HOST=db
 *   BLS_DB_PORT=3306
 *   BLS_DB_NAME=bls
 *   BLS_DB_USER=binalib
 *   BLS_DB_PASS=binalib_dev_password
 */

// Ambil dari environment variable.
// Jika tidak ada, gunakan default untuk XAMPP/LAMPP.
$dbHost = getenv('BLS_DB_HOST') ?: '127.0.0.1';
$dbPort = getenv('BLS_DB_PORT') ?: '3306';
$dbName = getenv('BLS_DB_NAME') ?: 'bls';
$dbUser = getenv('BLS_DB_USER') ?: 'root';
$dbPass = getenv('BLS_DB_PASS') ?: '';

$dsn = sprintf(
    'mysql:host=%s;port=%s;dbname=%s;charset=utf8mb4',
    $dbHost,
    $dbPort,
    $dbName
);

$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

try {
    $pdo = new PDO($dsn, $dbUser, $dbPass, $options);
} catch (PDOException $e) {
    // Jangan tampilkan password/credential database ke user.
    error_log('BinaLib database connection failed: ' . $e->getMessage());

    http_response_code(500);
    exit('Koneksi database gagal. Periksa konfigurasi database BinaLib.');
}
