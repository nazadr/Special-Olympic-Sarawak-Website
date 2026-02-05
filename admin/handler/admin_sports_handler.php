<?php
// Set proper headers for JSON response
header('Content-Type: application/json');

// Enable error reporting for debugging (remove in production)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "so_sarawak_db";

try {
    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);
    
    // Check connection
    if ($conn->connect_error) {
        throw new Exception('Connection failed: ' . $conn->connect_error);
    }
    
    // Initialize variables
    $action = $_POST['action'] ?? $_GET['action'] ?? '';
    $response = ['success' => false, 'message' => 'Invalid action.'];
} catch (Exception $e) {
    $response = ['success' => false, 'message' => $e->getMessage()];
    echo json_encode($response);
    exit();
}

try {
    // Debug information
    error_log("Sports handler called with action: " . $action);
    error_log("POST data: " . print_r($_POST, true));
    error_log("FILES data: " . print_r($_FILES, true));
    
    switch ($action) {
    case 'add':
        $title = $_POST['sportTitle'] ?? '';
        $description = $_POST['sportDescription'] ?? '';
        $display_order = $_POST['displayOrder'] ?? 0;
        $image_path = null;

        // Handle image upload
        if (isset($_FILES['sportImage']) && $_FILES['sportImage']['error'] == UPLOAD_ERR_OK) {
            $target_dir = "../../assets/images/sports/";
            $web_dir = "../assets/images/sports/";
            
            if (!is_dir($target_dir)) {
                if (!mkdir($target_dir, 0777, true)) {
                    $response = ['success' => false, 'message' => 'Failed to create upload directory.'];
                    echo json_encode($response);
                    exit();
                }
            }
            
            $image_name = basename($_FILES["sportImage"]["name"]);
            $unique_name = uniqid() . '_' . $image_name;
            $file_path = $target_dir . $unique_name;
            $image_path = $web_dir . $unique_name;
            
            if (!move_uploaded_file($_FILES["sportImage"]["tmp_name"], $file_path)) {
                $response = ['success' => false, 'message' => 'Failed to upload image.'];
                echo json_encode($response);
                exit();
            }
        }

        if ($title && $description) {
            // If no display_order provided, get the next available order
            if (empty($display_order)) {
                $orderStmt = $conn->prepare("SELECT MAX(display_order) as max_order FROM sports");
                $orderStmt->execute();
                $orderResult = $orderStmt->get_result();
                $orderRow = $orderResult->fetch_assoc();
                $display_order = ($orderRow['max_order'] ?? 0) + 1;
                $orderStmt->close();
            }

            $stmt = $conn->prepare("INSERT INTO sports (title, description, image_path, display_order) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("sssi", $title, $description, $image_path, $display_order);

            if ($stmt->execute()) {
                $response = ['success' => true, 'message' => 'Sport added successfully!'];
            } else {
                $response = ['success' => false, 'message' => 'Error adding sport: ' . $stmt->error];
            }
            $stmt->close();
        } else {
            $response = ['success' => false, 'message' => 'Title and description are required for adding a sport.'];
        }
        break;

    case 'fetch':
        $sql = "SELECT id, title, description, image_path, display_order, is_visible, created_at FROM sports ORDER BY display_order ASC, id ASC";
        $result = $conn->query($sql);

        $sports = [];
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $sports[] = $row;
            }
            $response = ['success' => true, 'sports' => $sports];
        } else {
            $response = ['success' => true, 'sports' => [], 'message' => 'No sports found.'];
        }
        break;

    case 'delete':
        $id = $_POST['id'] ?? '';

        if ($id) {
            // First, get the image path to delete the file
            $stmt = $conn->prepare("SELECT image_path FROM sports WHERE id = ?");
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $stmt->bind_result($image_path_to_delete);
            $stmt->fetch();
            $stmt->close();

            $stmt = $conn->prepare("DELETE FROM sports WHERE id = ?");
            $stmt->bind_param("i", $id);

            if ($stmt->execute()) {
                // Delete the image file if it exists and is a local file
                if ($image_path_to_delete && strpos($image_path_to_delete, '../assets') === 0 && file_exists("../../" . str_replace('../', '', $image_path_to_delete))) {
                    unlink("../../" . str_replace('../', '', $image_path_to_delete));
                }
                $response = ['success' => true, 'message' => 'Sport deleted successfully!'];
            } else {
                $response = ['success' => false, 'message' => 'Error deleting sport: ' . $stmt->error];
            }
            $stmt->close();
        } else {
            $response = ['success' => false, 'message' => 'Sport ID is required for deletion.'];
        }
        break;

    case 'edit':
        $id = $_POST['id'] ?? '';
        $title = $_POST['sportTitle'] ?? '';
        $description = $_POST['sportDescription'] ?? '';
        $display_order = $_POST['displayOrder'] ?? 0;
        $image_path = $_POST['currentImage'] ?? null;

        // Handle new image upload
        if (isset($_FILES['sportImage']) && $_FILES['sportImage']['error'] == UPLOAD_ERR_OK) {
            $target_dir = "../../assets/images/sports/";
            $web_dir = "../assets/images/sports/";
            
            if (!is_dir($target_dir)) {
                if (!mkdir($target_dir, 0777, true)) {
                    $response = ['success' => false, 'message' => 'Failed to create upload directory.'];
                    echo json_encode($response);
                    exit();
                }
            }
            
            $image_name = basename($_FILES["sportImage"]["name"]);
            $unique_name = uniqid() . '_' . $image_name;
            $new_file_path = $target_dir . $unique_name;
            $new_image_path = $web_dir . $unique_name;

            if (move_uploaded_file($_FILES["sportImage"]["tmp_name"], $new_file_path)) {
                // Delete old image file if a new one is uploaded and it's a local file
                if ($image_path && strpos($image_path, '../assets') === 0 && file_exists("../../" . str_replace('../', '', $image_path))) {
                    unlink("../../" . str_replace('../', '', $image_path));
                }
                $image_path = $new_image_path;
            } else {
                $response = ['success' => false, 'message' => 'Failed to upload new image.'];
                echo json_encode($response);
                exit();
            }
        }
        
        // Check if image was intentionally removed
        if (empty($_POST['currentImage']) && (!isset($_FILES['sportImage']) || $_FILES['sportImage']['error'] !== UPLOAD_ERR_OK)) {
            // Get the old image path to delete it
            $stmt = $conn->prepare("SELECT image_path FROM sports WHERE id = ?");
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $stmt->bind_result($old_image_path);
            $stmt->fetch();
            $stmt->close();
            
            // Delete the old image file if it's a local file
            if ($old_image_path && strpos($old_image_path, '../assets') === 0 && file_exists("../../" . str_replace('../', '', $old_image_path))) {
                unlink("../../" . str_replace('../', '', $old_image_path));
            }
            $image_path = null;
        }

        if ($id && $title && $description) {
            $stmt = $conn->prepare("UPDATE sports SET title = ?, description = ?, image_path = ?, display_order = ? WHERE id = ?");
            $stmt->bind_param("sssii", $title, $description, $image_path, $display_order, $id);

            if ($stmt->execute()) {
                $response = ['success' => true, 'message' => 'Sport updated successfully!'];
            } else {
                $response = ['success' => false, 'message' => 'Error updating sport: ' . $stmt->error];
            }
            $stmt->close();
        } else {
            $response = ['success' => false, 'message' => 'All fields and ID are required for editing a sport.'];
        }
        break;

    case 'fetch_single':
        $id = $_GET['id'] ?? '';
        if ($id) {
            $stmt = $conn->prepare("SELECT id, title, description, image_path, display_order FROM sports WHERE id = ?");
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $result = $stmt->get_result();
            if ($result->num_rows > 0) {
                $sport = $result->fetch_assoc();
                $response = ['success' => true, 'sport' => $sport];
            } else {
                $response = ['success' => false, 'message' => 'Sport not found.'];
            }
            $stmt->close();
        } else {
            $response = ['success' => false, 'message' => 'Sport ID is required.'];
        }
        break;

    case 'update_order':
        $orders = $_POST['orders'] ?? '';
        if ($orders) {
            $orders = json_decode($orders, true);
            if ($orders) {
                $conn->begin_transaction();
                try {
                    $stmt = $conn->prepare("UPDATE sports SET display_order = ? WHERE id = ?");
                    foreach ($orders as $item) {
                        $stmt->bind_param("ii", $item['order'], $item['id']);
                        $stmt->execute();
                    }
                    $conn->commit();
                    $response = ['success' => true, 'message' => 'Order updated successfully!'];
                } catch (Exception $e) {
                    $conn->rollback();
                    $response = ['success' => false, 'message' => 'Error updating order: ' . $e->getMessage()];
                }
                $stmt->close();
            } else {
                $response = ['success' => false, 'message' => 'Invalid order data.'];
            }
        } else {
            $response = ['success' => false, 'message' => 'Order data is required.'];
        }
        break;

    default:
        $response = ['success' => false, 'message' => 'Unknown action.'];
        break;
}

} catch (Exception $e) {
    $response = ['success' => false, 'message' => 'Server error: ' . $e->getMessage()];
}

echo json_encode($response);
if (isset($conn)) {
    $conn->close();
}
?>