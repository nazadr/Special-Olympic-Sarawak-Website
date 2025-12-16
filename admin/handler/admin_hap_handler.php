<?php
// HAP (Healthy Athletes Program) Articles Handler
// Handles CRUD operations for HAP articles

session_start();
header('Content-Type: application/json');

// Check if user is logged in
if (!isset($_SESSION['user']) || !isset($_SESSION['admin_id'])) {
    echo json_encode(['success' => false, 'message' => 'Unauthorized access']);
    exit();
}

// Database connection
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

$action = $_GET['action'] ?? $_POST['action'] ?? '';

try {
    switch($action) {
        case 'fetch':
            $stmt = $pdo->prepare("SELECT * FROM hap ORDER BY display_order ASC, created_at DESC");
            $stmt->execute();
            $articles = $stmt->fetchAll(PDO::FETCH_ASSOC);
            echo json_encode(['success' => true, 'articles' => $articles]);
            break;

        case 'add':
            $title = $_POST['title'] ?? '';
            $category = $_POST['category'] ?? '';
            $description = $_POST['description'] ?? '';
            $learnMoreLink = $_POST['learnMoreLink'] ?? '';
            $displayOrder = $_POST['displayOrder'] ?? 0;
            
            if (empty($title) || empty($category) || empty($description)) {
                echo json_encode(['success' => false, 'message' => 'Title, category, and description are required']);
                break;
            }
            
            $imagePath = null;
            if (isset($_FILES['hapImage']) && $_FILES['hapImage']['error'] === UPLOAD_ERR_OK) {
                $uploadDir = '../assets/images/hap/';
                if (!file_exists($uploadDir)) {
                    mkdir($uploadDir, 0777, true);
                }
                
                $fileExtension = pathinfo($_FILES['hapImage']['name'], PATHINFO_EXTENSION);
                $fileName = 'hap_' . time() . '_' . uniqid() . '.' . $fileExtension;
                $uploadPath = $uploadDir . $fileName;
                
                if (move_uploaded_file($_FILES['hapImage']['tmp_name'], $uploadPath)) {
                    $imagePath = '../assets/images/hap/' . $fileName;
                }
            }
            
            $stmt = $pdo->prepare("INSERT INTO hap (title, category, description, image_path, learn_more_link, display_order) VALUES (?, ?, ?, ?, ?, ?)");
            $stmt->execute([$title, $category, $description, $imagePath, $learnMoreLink, $displayOrder]);
            
            echo json_encode(['success' => true, 'message' => 'HAP article added successfully']);
            break;

        case 'update':
            $id = $_POST['id'] ?? '';
            $title = $_POST['title'] ?? '';
            $category = $_POST['category'] ?? '';
            $description = $_POST['description'] ?? '';
            $learnMoreLink = $_POST['learnMoreLink'] ?? '';
            $displayOrder = $_POST['displayOrder'] ?? 0;
            $currentImage = $_POST['currentImage'] ?? '';
            
            if (empty($id) || empty($title) || empty($category) || empty($description)) {
                echo json_encode(['success' => false, 'message' => 'ID, title, category, and description are required']);
                break;
            }
            
            $imagePath = $currentImage;
            if (isset($_FILES['hapImage']) && $_FILES['hapImage']['error'] === UPLOAD_ERR_OK) {
                $uploadDir = '../assets/images/hap/';
                if (!file_exists($uploadDir)) {
                    mkdir($uploadDir, 0777, true);
                }
                
                $fileExtension = pathinfo($_FILES['hapImage']['name'], PATHINFO_EXTENSION);
                $fileName = 'hap_' . time() . '_' . uniqid() . '.' . $fileExtension;
                $uploadPath = $uploadDir . $fileName;
                
                if (move_uploaded_file($_FILES['hapImage']['tmp_name'], $uploadPath)) {
                    // Delete old image if it exists
                    if ($currentImage && file_exists($currentImage)) {
                        unlink($currentImage);
                    }
                    $imagePath = '../assets/images/hap/' . $fileName;
                }
            }
            
            $stmt = $pdo->prepare("UPDATE hap SET title = ?, category = ?, description = ?, image_path = ?, learn_more_link = ?, display_order = ? WHERE id = ?");
            $stmt->execute([$title, $category, $description, $imagePath, $learnMoreLink, $displayOrder, $id]);
            
            echo json_encode(['success' => true, 'message' => 'HAP article updated successfully']);
            break;

        case 'delete':
            $id = $_POST['id'] ?? $_GET['id'] ?? '';
            
            if (empty($id)) {
                echo json_encode(['success' => false, 'message' => 'Article ID is required']);
                break;
            }
            
            // Get image path before deleting
            $stmt = $pdo->prepare("SELECT image_path FROM hap WHERE id = ?");
            $stmt->execute([$id]);
            $article = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if ($article && $article['image_path'] && file_exists($article['image_path'])) {
                unlink($article['image_path']);
            }
            
            $stmt = $pdo->prepare("DELETE FROM hap WHERE id = ?");
            $stmt->execute([$id]);
            
            echo json_encode(['success' => true, 'message' => 'HAP article deleted successfully']);
            break;

        case 'update_order':
            $orders = $_POST['orders'] ?? [];
            
            if (empty($orders)) {
                echo json_encode(['success' => false, 'message' => 'No order data provided']);
                break;
            }
            
            $pdo->beginTransaction();
            
            foreach ($orders as $order) {
                $stmt = $pdo->prepare("UPDATE hap SET display_order = ? WHERE id = ?");
                $stmt->execute([$order['order'], $order['id']]);
            }
            
            $pdo->commit();
            echo json_encode(['success' => true, 'message' => 'Display order updated successfully']);
            break;

        default:
            echo json_encode(['success' => false, 'message' => 'Invalid action']);
    }
} catch(Exception $e) {
    if (isset($pdo) && $pdo->inTransaction()) {
        $pdo->rollback();
    }
    echo json_encode(['success' => false, 'message' => 'Error: ' . $e->getMessage()]);
}
?>