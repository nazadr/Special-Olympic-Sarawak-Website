<?php
// ALP Page Settings Handler
// Manages hero section image and description content for the Athlete Leadership Program page

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, GET, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

// Database configuration
$host = 'localhost';
$dbname = 'so_sarawak_db';
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    echo json_encode(['success' => false, 'message' => 'Database connection failed: ' . $e->getMessage()]);
    exit();
}

// Get the action from POST or GET
$action = $_POST['action'] ?? $_GET['action'] ?? '';

switch($action) {
    case 'fetch':
        fetchPageSettings();
        break;
    case 'update':
        updatePageSettings();
        break;
    case 'update_hero_image':
        updateHeroImage();
        break;
    default:
        echo json_encode(['success' => false, 'message' => 'Invalid action']);
}

function fetchPageSettings() {
    global $pdo;
    
    try {
        $stmt = $pdo->prepare("SELECT * FROM alp_page_settings WHERE id = 1");
        $stmt->execute();
        $settings = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($settings) {
            echo json_encode(['success' => true, 'data' => $settings]);
        } else {
            echo json_encode(['success' => false, 'message' => 'No settings found']);
        }
    } catch(Exception $e) {
        echo json_encode(['success' => false, 'message' => 'Error fetching settings: ' . $e->getMessage()]);
    }
}

function updatePageSettings() {
    global $pdo;
    
    try {
        $heroTitle = $_POST['hero_title'] ?? 'Athlete Leadership Program (ALP)';
        $descriptionContent = $_POST['description_content'] ?? '';
        $updatedBy = $_POST['updated_by'] ?? 'Admin';
        
        // Check if we need to update the hero image
        $currentImagePath = null;
        if (isset($_FILES['hero_image']) && $_FILES['hero_image']['error'] === UPLOAD_ERR_OK) {
            // Get current image to delete old one
            $stmt = $pdo->prepare("SELECT hero_image_path FROM alp_page_settings WHERE id = 1");
            $stmt->execute();
            $currentSettings = $stmt->fetch(PDO::FETCH_ASSOC);
            
            $newImagePath = handleImageUpload($_FILES['hero_image'], 'alp-hero');
            if ($newImagePath) {
                // Delete old image if exists
                if ($currentSettings && !empty($currentSettings['hero_image_path'])) {
                    $oldImageFullPath = '../../' . $currentSettings['hero_image_path'];
                    if (file_exists($oldImageFullPath)) {
                        unlink($oldImageFullPath);
                    }
                }
                $currentImagePath = $newImagePath;
            }
        }
        
        // Build update query
        $sql = "UPDATE alp_page_settings SET 
                hero_title = ?,
                description_content = ?,
                updated_by = ?";
        
        $params = [
            $heroTitle,
            $descriptionContent,
            $updatedBy
        ];
        
        // Add hero image path if updated
        if ($currentImagePath !== null) {
            $sql .= ", hero_image_path = ?";
            $params[] = $currentImagePath;
        }
        
        $sql .= " WHERE id = 1";
        
        $stmt = $pdo->prepare($sql);
        $stmt->execute($params);
        
        echo json_encode([
            'success' => true, 
            'message' => 'ALP page settings updated successfully',
            'hero_image_path' => $currentImagePath
        ]);
    } catch(Exception $e) {
        echo json_encode(['success' => false, 'message' => 'Error updating settings: ' . $e->getMessage()]);
    }
}

function updateHeroImage() {
    global $pdo;
    
    try {
        if (!isset($_FILES['hero_image']) || $_FILES['hero_image']['error'] !== UPLOAD_ERR_OK) {
            echo json_encode(['success' => false, 'message' => 'No image file provided']);
            return;
        }
        
        // Get current image to delete
        $stmt = $pdo->prepare("SELECT hero_image_path FROM alp_page_settings WHERE id = 1");
        $stmt->execute();
        $currentSettings = $stmt->fetch(PDO::FETCH_ASSOC);
        
        // Upload new image
        $newImagePath = handleImageUpload($_FILES['hero_image'], 'alp-hero');
        if (!$newImagePath) {
            echo json_encode(['success' => false, 'message' => 'Failed to upload image']);
            return;
        }
        
        // Delete old image
        if ($currentSettings && !empty($currentSettings['hero_image_path'])) {
            $oldImageFullPath = '../../' . $currentSettings['hero_image_path'];
            if (file_exists($oldImageFullPath)) {
                unlink($oldImageFullPath);
            }
        }
        
        // Update database
        $stmt = $pdo->prepare("UPDATE alp_page_settings SET hero_image_path = ? WHERE id = 1");
        $stmt->execute([$newImagePath]);
        
        echo json_encode([
            'success' => true, 
            'message' => 'Hero image updated successfully',
            'image_path' => $newImagePath
        ]);
    } catch(Exception $e) {
        echo json_encode(['success' => false, 'message' => 'Error updating hero image: ' . $e->getMessage()]);
    }
}

function handleImageUpload($file, $subfolder = '') {
    $uploadDir = '../../assets/images/' . ($subfolder ? $subfolder . '/' : '');
    
    // Create directory if it doesn't exist
    if (!file_exists($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }
    
    // Generate unique filename
    $extension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
    $filename = 'alp_' . time() . '_' . uniqid() . '.' . $extension;
    $uploadPath = $uploadDir . $filename;
    
    // Validate file type
    $allowedTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif', 'image/webp'];
    if (!in_array($file['type'], $allowedTypes)) {
        return false;
    }
    
    // Validate file size (max 5MB)
    if ($file['size'] > 5 * 1024 * 1024) {
        return false;
    }
    
    // Move uploaded file
    if (move_uploaded_file($file['tmp_name'], $uploadPath)) {
        // Return relative path for database storage
        return '../assets/images/' . ($subfolder ? $subfolder . '/' : '') . $filename;
    }
    
    return false;
}
?>
