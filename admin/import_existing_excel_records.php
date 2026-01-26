<?php
/**
 * Import Existing Excel Files into Documents Tracking
 * Run this once to add already uploaded Excel files to the participant_excel_uploads table
 */

session_start();

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "so_sarawak_db";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

echo "<h2>Importing Existing Excel Files into Documents Tracking</h2>";
echo "<pre>";

// Get base path
$basePath = dirname(__DIR__) . '/uploads/participants/';

// Define file records to import
$files = [
    [
        'type' => 'athlete',
        'filename' => 'athletes_20260123_013923.xlsx',
        'path' => 'athletes/athletes_20260123_013923.xlsx',
        'created' => '2026-01-23 08:39:23'
    ],
    [
        'type' => 'athlete',
        'filename' => 'athletes_20260123_014131.xlsx',
        'path' => 'athletes/athletes_20260123_014131.xlsx',
        'created' => '2026-01-23 08:41:31'
    ],
    [
        'type' => 'athlete',
        'filename' => 'athletes_20260123_014317.xlsx',
        'path' => 'athletes/athletes_20260123_014317.xlsx',
        'created' => '2026-01-23 08:43:17'
    ],
    [
        'type' => 'athlete',
        'filename' => 'athletes_20260123_014716.xlsx',
        'path' => 'athletes/athletes_20260123_014716.xlsx',
        'created' => '2026-01-23 08:47:16'
    ],
    [
        'type' => 'volunteer',
        'filename' => 'volunteers_20260123_014627.xlsx',
        'path' => 'volunteers/volunteers_20260123_014627.xlsx',
        'created' => '2026-01-23 08:46:27'
    ],
    [
        'type' => 'volunteer',
        'filename' => 'volunteers_20260123_032829.xlsx',
        'path' => 'volunteers/volunteers_20260123_032829.xlsx',
        'created' => '2026-01-23 10:28:29'
    ]
];

$imported = 0;
$skipped = 0;
$errors = 0;

foreach ($files as $file) {
    $fullPath = $basePath . $file['path'];
    
    // Check if file exists
    if (!file_exists($fullPath)) {
        echo "❌ File not found: {$file['filename']}\n";
        $errors++;
        continue;
    }
    
    // Check if already imported
    $checkStmt = $conn->prepare("SELECT id FROM participant_excel_uploads WHERE filename = ? AND participant_type = ?");
    $checkStmt->bind_param("ss", $file['filename'], $file['type']);
    $checkStmt->execute();
    $result = $checkStmt->get_result();
    
    if ($result->num_rows > 0) {
        echo "⏭️  Already imported: {$file['filename']}\n";
        $skipped++;
        $checkStmt->close();
        continue;
    }
    $checkStmt->close();
    
    // Get record counts from respective tables
    $recordsImported = 0;
    $recordsUpdated = 0;
    $recordsFailed = 0;
    
    if ($file['type'] === 'athlete') {
        $countStmt = $conn->prepare("SELECT COUNT(*) as total FROM athletes WHERE excel_filename = ?");
        $countStmt->bind_param("s", $file['filename']);
        $countStmt->execute();
        $countResult = $countStmt->get_result()->fetch_assoc();
        $recordsImported = $countResult['total'];
        $countStmt->close();
    } elseif ($file['type'] === 'coach') {
        $countStmt = $conn->prepare("SELECT COUNT(*) as total FROM coaches WHERE excel_filename = ?");
        $countStmt->bind_param("s", $file['filename']);
        $countStmt->execute();
        $countResult = $countStmt->get_result()->fetch_assoc();
        $recordsImported = $countResult['total'];
        $countStmt->close();
    } elseif ($file['type'] === 'volunteer') {
        $countStmt = $conn->prepare("SELECT COUNT(*) as total FROM volunteers WHERE excel_filename = ?");
        $countStmt->bind_param("s", $file['filename']);
        $countStmt->execute();
        $countResult = $countStmt->get_result()->fetch_assoc();
        $recordsImported = $countResult['total'];
        $countStmt->close();
    }
    
    // If no records found, assume they were uploaded but not imported (failed upload)
    $status = $recordsImported > 0 ? 'success' : 'failed';
    $errorLog = $recordsImported == 0 ? 'No records found in database. File may have been uploaded but import failed.' : '';
    
    // Original filename (without timestamp prefix)
    $originalFilename = preg_replace('/^(athletes|coaches|volunteers)_\d{8}_\d{6}_/', '', $file['filename']);
    if ($originalFilename == $file['filename']) {
        $originalFilename = $file['filename']; // Keep as is if pattern doesn't match
    }
    
    // Insert into participant_excel_uploads
    $relativeFilePath = 'uploads/participants/' . $file['path'];
    
    $insertStmt = $conn->prepare("
        INSERT INTO participant_excel_uploads 
        (participant_type, filename, original_filename, file_path, rows_imported, rows_updated, rows_failed, uploaded_by, upload_status, error_log, created_at)
        VALUES (?, ?, ?, ?, ?, ?, ?, 1, ?, ?, ?)
    ");
    
    $insertStmt->bind_param(
        "ssssiiiiss",
        $file['type'],
        $file['filename'],
        $originalFilename,
        $relativeFilePath,
        $recordsImported,
        $recordsUpdated,
        $recordsFailed,
        $status,
        $errorLog,
        $file['created']
    );
    
    if ($insertStmt->execute()) {
        echo "✅ Imported: {$file['filename']} ({$recordsImported} records, status: {$status})\n";
        $imported++;
    } else {
        echo "❌ Error importing {$file['filename']}: " . $insertStmt->error . "\n";
        $errors++;
    }
    
    $insertStmt->close();
}

echo "\n";
echo "═══════════════════════════════════════\n";
echo "Summary:\n";
echo "  ✅ Imported: $imported\n";
echo "  ⏭️  Skipped (already exists): $skipped\n";
echo "  ❌ Errors: $errors\n";
echo "═══════════════════════════════════════\n";

if ($imported > 0) {
    echo "\n✨ Success! Refresh your Documents section to see the imported files.\n";
}

echo "</pre>";

$conn->close();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Import Complete</title>
    <style>
        body { font-family: Arial, sans-serif; max-width: 800px; margin: 50px auto; padding: 20px; }
        h2 { color: #333; }
        pre { background: #f5f5f5; padding: 20px; border-radius: 8px; border-left: 4px solid #667eea; }
        .btn { display: inline-block; padding: 10px 20px; background: #667eea; color: white; text-decoration: none; border-radius: 6px; margin-top: 20px; }
        .btn:hover { background: #5568d3; }
    </style>
</head>
<body>
    <a href="admin_panel_soswk.php" class="btn">← Back to Admin Panel</a>
    <a href="?rerun=1" class="btn">🔄 Run Again</a>
</body>
</html>
