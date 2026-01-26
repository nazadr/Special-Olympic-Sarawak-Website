<?php
header('Content-Type: application/json');

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

switch($action) {
    case 'get_yap_content':
        try {
            $stmt = $pdo->prepare("SELECT * FROM yap_content WHERE is_active = 1 LIMIT 1");
            $stmt->execute();
            $content = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if (!$content) {
                // Create default content if none exists
                $stmt = $pdo->prepare("INSERT INTO yap_content (description_text) VALUES (?)");
                $defaultText = "Special Olympics Young Athletes is an early childhood play program for children with and without intellectual disabilities, ages 2 to 7 years old.";
                $stmt->execute([$defaultText]);
                
                $stmt = $pdo->prepare("SELECT * FROM yap_content WHERE id = ?");
                $stmt->execute([$pdo->lastInsertId()]);
                $content = $stmt->fetch(PDO::FETCH_ASSOC);
            }
            
            echo json_encode(['success' => true, 'data' => $content]);
        } catch(PDOException $e) {
            echo json_encode(['success' => false, 'message' => 'Error fetching YAP content: ' . $e->getMessage()]);
        }
        break;

    case 'update_yap_content':
        try {
            $id = $_POST['yap_id'] ?? '';
            $hero_title = $_POST['hero_title'] ?? 'Young Athletes Program';
            $description_text = $_POST['description_text'] ?? '';
            $testimonial_text = $_POST['testimonial_text'] ?? '';
            $testimonial_author = $_POST['testimonial_author'] ?? '';
            $testimonial_location = $_POST['testimonial_location'] ?? '';
            $resources_title = $_POST['resources_title'] ?? 'Resources for Young Athletes Program';
            $resources_description = $_POST['resources_description'] ?? '';
            $resources_button_text = $_POST['resources_button_text'] ?? 'LEARN MORE';
            $resources_button_link = $_POST['resources_button_link'] ?? '../src/yap-lm.html';

            // Handle hero image upload
            $hero_image_path = null;
            if (isset($_FILES['hero_image']) && $_FILES['hero_image']['error'] === UPLOAD_ERR_OK) {
                $uploadDir = '../assets/images/yap/';
                if (!is_dir($uploadDir)) {
                    mkdir($uploadDir, 0777, true);
                }
                
                $fileExtension = pathinfo($_FILES['hero_image']['name'], PATHINFO_EXTENSION);
                $newFileName = 'yap_hero_' . time() . '.' . $fileExtension;
                $hero_image_path = $uploadDir . $newFileName;
                
                if (!move_uploaded_file($_FILES['hero_image']['tmp_name'], $hero_image_path)) {
                    echo json_encode(['success' => false, 'message' => 'Failed to upload hero image']);
                    exit();
                }
                $hero_image_path = '../assets/images/yap/' . $newFileName;
            }

            // Handle resources background image upload
            $resources_bg_path = null;
            if (isset($_FILES['resources_background_image']) && $_FILES['resources_background_image']['error'] === UPLOAD_ERR_OK) {
                $uploadDir = '../assets/images/yap/';
                if (!is_dir($uploadDir)) {
                    mkdir($uploadDir, 0777, true);
                }
                
                $fileExtension = pathinfo($_FILES['resources_background_image']['name'], PATHINFO_EXTENSION);
                $newFileName = 'yap_resources_bg_' . time() . '.' . $fileExtension;
                $resources_bg_path = $uploadDir . $newFileName;
                
                if (!move_uploaded_file($_FILES['resources_background_image']['tmp_name'], $resources_bg_path)) {
                    echo json_encode(['success' => false, 'message' => 'Failed to upload resources background image']);
                    exit();
                }
                $resources_bg_path = '../assets/images/yap/' . $newFileName;
            }

            if ($id) {
                // Update existing content
                $sql = "UPDATE yap_content SET 
                        hero_title = ?, 
                        description_text = ?, 
                        testimonial_text = ?, 
                        testimonial_author = ?, 
                        testimonial_location = ?,
                        resources_title = ?,
                        resources_description = ?,
                        resources_button_text = ?,
                        resources_button_link = ?";
                
                $params = [$hero_title, $description_text, $testimonial_text, $testimonial_author, 
                          $testimonial_location, $resources_title, $resources_description, 
                          $resources_button_text, $resources_button_link];
                
                if ($hero_image_path) {
                    $sql .= ", hero_image = ?";
                    $params[] = $hero_image_path;
                }
                
                if ($resources_bg_path) {
                    $sql .= ", resources_background_image = ?";
                    $params[] = $resources_bg_path;
                }
                
                $sql .= " WHERE id = ?";
                $params[] = $id;
                
                $stmt = $pdo->prepare($sql);
                $stmt->execute($params);
                
                echo json_encode(['success' => true, 'message' => 'YAP content updated successfully']);
            } else {
                // Create new content
                $sql = "INSERT INTO yap_content (hero_title, description_text, testimonial_text, testimonial_author, testimonial_location, resources_title, resources_description, resources_button_text, resources_button_link";
                $params = [$hero_title, $description_text, $testimonial_text, $testimonial_author, $testimonial_location, $resources_title, $resources_description, $resources_button_text, $resources_button_link];
                
                if ($hero_image_path) {
                    $sql .= ", hero_image";
                    $params[] = $hero_image_path;
                }
                
                if ($resources_bg_path) {
                    $sql .= ", resources_background_image";
                    $params[] = $resources_bg_path;
                }
                
                $sql .= ") VALUES (" . str_repeat('?,', count($params) - 1) . "?)";
                
                $stmt = $pdo->prepare($sql);
                $stmt->execute($params);
                
                echo json_encode(['success' => true, 'message' => 'YAP content created successfully']);
            }
        } catch(PDOException $e) {
            echo json_encode(['success' => false, 'message' => 'Error updating YAP content: ' . $e->getMessage()]);
        }
        break;

    case 'delete_hero_image':
        try {
            $id = $_POST['id'] ?? '';
            if (!$id) {
                echo json_encode(['success' => false, 'message' => 'YAP ID is required']);
                exit();
            }

            // Get current image path
            $stmt = $pdo->prepare("SELECT hero_image FROM yap_content WHERE id = ?");
            $stmt->execute([$id]);
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if ($result && $result['hero_image'] && file_exists($result['hero_image'])) {
                unlink($result['hero_image']);
            }

            // Reset to default image
            $stmt = $pdo->prepare("UPDATE yap_content SET hero_image = '../assets/images/yap-hero.jpg' WHERE id = ?");
            $stmt->execute([$id]);

            echo json_encode(['success' => true, 'message' => 'Hero image deleted successfully']);
        } catch(PDOException $e) {
            echo json_encode(['success' => false, 'message' => 'Error deleting hero image: ' . $e->getMessage()]);
        }
        break;

    case 'delete_resources_bg_image':
        try {
            $id = $_POST['id'] ?? '';
            if (!$id) {
                echo json_encode(['success' => false, 'message' => 'YAP ID is required']);
                exit();
            }

            // Get current image path
            $stmt = $pdo->prepare("SELECT resources_background_image FROM yap_content WHERE id = ?");
            $stmt->execute([$id]);
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if ($result && $result['resources_background_image'] && file_exists($result['resources_background_image'])) {
                unlink($result['resources_background_image']);
            }

            // Reset to default image
            $stmt = $pdo->prepare("UPDATE yap_content SET resources_background_image = '../assets/images/yap-lm-hero-hf.jpg' WHERE id = ?");
            $stmt->execute([$id]);

            echo json_encode(['success' => true, 'message' => 'Resources background image deleted successfully']);
        } catch(PDOException $e) {
            echo json_encode(['success' => false, 'message' => 'Error deleting resources background image: ' . $e->getMessage()]);
        }
        break;

    default:
        echo json_encode(['success' => false, 'message' => 'Invalid action']);
        break;
}
?>