<?php
// export_db.php: Export the current MySQL database as a SQL file for download
// NOTE: This script assumes you have access to mysqldump and proper DB credentials

// Set your DB credentials here
$host = 'localhost';
$user = 'root';
$pass = '';
$db = 'special_olympic_sarawak'; // Change to your actual DB name

$filename = 'soswk_db_export_' . date('Ymd_His') . '.sql';

header('Content-Type: application/octet-stream');
header('Content-Disposition: attachment; filename=' . $filename);
header('Pragma: no-cache');
header('Expires: 0');

$cmd = sprintf(
    'mysqldump --user=%s --password=%s --host=%s %s 2>&1',
    escapeshellarg($user),
    escapeshellarg($pass),
    escapeshellarg($host),
    escapeshellarg($db)
);

passthru($cmd);
exit;
