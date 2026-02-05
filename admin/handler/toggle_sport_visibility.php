<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['user']) || !isset($_SESSION['admin_id'])) {
    echo json_encode(['success' => false, 'message' => 'Unauthorized access']);
    exit;
}

// Database connection
$host = 'localhost';
$dbname = 'so_sarawak_db';
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Get POST data
    $input = json_decode(file_get_contents('php://input'), true);
    $sportId = isset($input['sport_id']) ? intval($input['sport_id']) : 0;
    $isVisible = isset($input['is_visible']) ? intval($input['is_visible']) : 0;
    
    if ($sportId <= 0) {
        echo json_encode(['success' => false, 'message' => 'Invalid sport ID']);
        exit;
    }
    
    // Update visibility status
    $stmt = $pdo->prepare("UPDATE sports SET is_visible = :is_visible WHERE id = :id");
    $stmt->bindParam(':is_visible', $isVisible, PDO::PARAM_INT);
    $stmt->bindParam(':id', $sportId, PDO::PARAM_INT);
    
    if ($stmt->execute()) {
        $status = $isVisible ? 'visible' : 'hidden';
        echo json_encode([
            'success' => true, 
            'message' => "Sport successfully set to $status",
            'is_visible' => $isVisible
        ]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to update visibility']);
    }
    
} catch(PDOException $e) {
    echo json_encode(['success' => false, 'message' => 'Database error: ' . $e->getMessage()]);
}
?>
