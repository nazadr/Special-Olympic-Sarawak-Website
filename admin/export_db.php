<?php
// export_db.php: Export the current MySQL database as a SQL file for download
// NOTE: This script assumes you have access to mysqldump and proper DB credentials

$host = 'localhost';
$user = 'root';
$pass = '';
$db = 'so_sarawak_db'; // Change to your actual DB name

// XAMPP: mysqldump location (adjust path based on your XAMPP installation)
$mysqldump = 'C:\\xampp\\mysql\\bin\\mysqldump.exe';

$filename = 'soswk_db_export_' . date('Ymd_His') . '.sql';

header('Content-Type: application/octet-stream');
header('Content-Disposition: attachment; filename=' . $filename);
header('Pragma: no-cache');
header('Expires: 0');

$cmd = sprintf(
    '%s --user=%s --password=%s --host=%s %s 2>&1',
    escapeshellarg($mysqldump),
    escapeshellarg($user),
    escapeshellarg($pass),
    escapeshellarg($host),
    escapeshellarg($db)
);

// Debug: Check if command works
$output = [];
$return_var = 0;
exec($cmd, $output, $return_var);

if ($return_var !== 0) {
    header('Content-Type: text/plain');
    echo "Error executing mysqldump:\n";
    echo "Return code: $return_var\n";
    echo "Command: $cmd\n";
    echo "Output: " . implode("\n", $output);
    echo "\n\nMysqldump path: $mysqldump\n";
    echo "File exists: " . (file_exists($mysqldump) ? "Yes" : "No");
    exit;
}

passthru($cmd);
exit;
