<?php
// Database migration to add is_visible column to sports table
$host = 'localhost';
$dbname = 'so_sarawak_db';
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Check if column exists
    $stmt = $pdo->query("SHOW COLUMNS FROM sports LIKE 'is_visible'");
    $columnExists = $stmt->fetch();
    
    if (!$columnExists) {
        // Add is_visible column (default to 1 = visible)
        $pdo->exec("ALTER TABLE sports ADD COLUMN is_visible TINYINT(1) DEFAULT 1 AFTER display_order");
        
        // Also set all existing sports to visible
        $pdo->exec("UPDATE sports SET is_visible = 1 WHERE is_visible IS NULL");
        
        echo json_encode(['success' => true, 'message' => 'is_visible column added successfully and all sports set to visible']);
    } else {
        echo json_encode(['success' => true, 'message' => 'is_visible column already exists']);
    }
    
} catch(PDOException $e) {
    echo json_encode(['success' => false, 'message' => 'Error: ' . $e->getMessage()]);
}
?>
