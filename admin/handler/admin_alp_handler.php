<?php
// ALP (Athlete Leadership Program) Handler
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
    case 'add':
        addAlpArticle();
        break;
    case 'update':
        updateAlpArticle();
        break;
    case 'delete':
        deleteAlpArticle();
        break;
    case 'fetch':
        fetchAlpArticles();
        break;
    case 'update_order':
        updateAlpOrder();
        break;
    default:
        echo json_encode(['success' => false, 'message' => 'Invalid action']);
}

function addAlpArticle() {
    global $pdo;
    
    try {
        $title = $_POST['title'] ?? '';
        $category = $_POST['category'] ?? '';
        $description = $_POST['description'] ?? '';
        $learnMoreLink = $_POST['learnMoreLink'] ?? null;
        $displayOrder = $_POST['displayOrder'] ?? null;
        
        if (empty($title) || empty($category) || empty($description)) {
            echo json_encode(['success' => false, 'message' => 'Title, category, and description are required']);
            return;
        }
        
        // Handle image upload
        $imagePath = null;
        if (isset($_FILES['alpImage']) && $_FILES['alpImage']['error'] === UPLOAD_ERR_OK) {
            $imagePath = handleImageUpload($_FILES['alpImage'], 'alp');
            if (!$imagePath) {
                echo json_encode(['success' => false, 'message' => 'Failed to upload image']);
                return;
            }
        }
        
        // If no display order specified, get the next order
        if (empty($displayOrder)) {
            $stmt = $pdo->query("SELECT MAX(display_order) FROM alp");
            $maxOrder = $stmt->fetchColumn();
            $displayOrder = ($maxOrder ? $maxOrder : 0) + 1;
        }
        
        $stmt = $pdo->prepare("INSERT INTO alp (title, category, description, image_path, learn_more_link, display_order) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->execute([$title, $category, $description, $imagePath, $learnMoreLink, $displayOrder]);
        
        echo json_encode(['success' => true, 'message' => 'ALP article added successfully', 'id' => $pdo->lastInsertId()]);
    } catch(Exception $e) {
        echo json_encode(['success' => false, 'message' => 'Error adding article: ' . $e->getMessage()]);
    }
}

function updateAlpArticle() {
    global $pdo;
    
    try {
        $id = $_POST['id'] ?? '';
        $title = $_POST['title'] ?? '';
        $category = $_POST['category'] ?? '';
        $description = $_POST['description'] ?? '';
        $learnMoreLink = $_POST['learnMoreLink'] ?? null;
        $displayOrder = $_POST['displayOrder'] ?? null;
        $currentImage = $_POST['currentImage'] ?? '';
        
        if (empty($id) || empty($title) || empty($category) || empty($description)) {
            echo json_encode(['success' => false, 'message' => 'ID, title, category, and description are required']);
            return;
        }
        
        // Handle image upload
        $imagePath = $currentImage;
        if (isset($_FILES['alpImage']) && $_FILES['alpImage']['error'] === UPLOAD_ERR_OK) {
            $newImagePath = handleImageUpload($_FILES['alpImage'], 'alp');
            if ($newImagePath) {
                // Delete old image if it exists
                if ($currentImage && file_exists($currentImage)) {
                    unlink($currentImage);
                }
                $imagePath = $newImagePath;
            }
        }
        
        $stmt = $pdo->prepare("UPDATE alp SET title = ?, category = ?, description = ?, image_path = ?, learn_more_link = ?, display_order = ?, updated_at = CURRENT_TIMESTAMP WHERE id = ?");
        $stmt->execute([$title, $category, $description, $imagePath, $learnMoreLink, $displayOrder, $id]);
        
        echo json_encode(['success' => true, 'message' => 'ALP article updated successfully']);
    } catch(Exception $e) {
        echo json_encode(['success' => false, 'message' => 'Error updating article: ' . $e->getMessage()]);
    }
}

function deleteAlpArticle() {
    global $pdo;
    
    try {
        $id = $_POST['id'] ?? '';
        
        if (empty($id)) {
            echo json_encode(['success' => false, 'message' => 'Article ID is required']);
            return;
        }
        
        // Get the image path before deleting
        $stmt = $pdo->prepare("SELECT image_path FROM alp WHERE id = ?");
        $stmt->execute([$id]);
        $article = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($article) {
            // Delete the article
            $stmt = $pdo->prepare("DELETE FROM alp WHERE id = ?");
            $stmt->execute([$id]);
            
            // Delete the image file if it exists
            if ($article['image_path'] && file_exists($article['image_path'])) {
                unlink($article['image_path']);
            }
            
            echo json_encode(['success' => true, 'message' => 'ALP article deleted successfully']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Article not found']);
        }
    } catch(Exception $e) {
        echo json_encode(['success' => false, 'message' => 'Error deleting article: ' . $e->getMessage()]);
    }
}

function fetchAlpArticles() {
    global $pdo;
    
    try {
        $stmt = $pdo->prepare("SELECT * FROM alp WHERE is_active = 1 ORDER BY display_order ASC, created_at DESC");
        $stmt->execute();
        $articles = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        echo json_encode(['success' => true, 'articles' => $articles]);
    } catch(Exception $e) {
        echo json_encode(['success' => false, 'message' => 'Error fetching articles: ' . $e->getMessage()]);
    }
}

function updateAlpOrder() {
    global $pdo;
    
    try {
        $orders = json_decode($_POST['orders'], true);
        
        if (!$orders) {
            echo json_encode(['success' => false, 'message' => 'Invalid order data']);
            return;
        }
        
        $pdo->beginTransaction();
        
        foreach ($orders as $order) {
            $stmt = $pdo->prepare("UPDATE alp SET display_order = ? WHERE id = ?");
            $stmt->execute([$order['order'], $order['id']]);
        }
        
        $pdo->commit();
        echo json_encode(['success' => true, 'message' => 'Display order updated successfully']);
    } catch(Exception $e) {
        $pdo->rollBack();
        echo json_encode(['success' => false, 'message' => 'Error updating order: ' . $e->getMessage()]);
    }
}

function handleImageUpload($file, $folder) {
    // Use absolute path for upload directory
    $rootDir = dirname(dirname(dirname(__FILE__))); // Go up to project root
    $uploadDir = $rootDir . "/assets/images/$folder/";
    
    // Create directory if it doesn't exist
    if (!is_dir($uploadDir)) {
        if (!mkdir($uploadDir, 0755, true)) {
            error_log("Failed to create directory: " . $uploadDir);
            return false;
        }
    }
    
    // Validate file
    if (!isset($file['tmp_name']) || !is_uploaded_file($file['tmp_name'])) {
        error_log("Invalid file upload");
        return false;
    }
    
    $fileExtension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
    $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
    
    if (!in_array($fileExtension, $allowedExtensions)) {
        error_log("Invalid file extension: " . $fileExtension);
        return false;
    }
    
    // Check file size (limit to 5MB)
    if ($file['size'] > 5 * 1024 * 1024) {
        error_log("File too large: " . $file['size']);
        return false;
    }
    
    $fileName = uniqid() . '_' . time() . '.' . $fileExtension;
    $uploadPath = $uploadDir . $fileName;
    
    if (move_uploaded_file($file['tmp_name'], $uploadPath)) {
        // Return path relative to the document root
        return "assets/images/$folder/" . $fileName;
    } else {
        error_log("Failed to move uploaded file to: " . $uploadPath);
        return false;
    }
}
?>