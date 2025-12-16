<?php
session_start();
header('Content-Type: application/json');

// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Check if user is logged in
if (!isset($_SESSION['user']) || !isset($_SESSION['admin_id'])) {
    // For debugging, allow access without proper session
    if (!isset($_GET['debug'])) {
        echo json_encode(['success' => false, 'message' => 'Unauthorized access']);
        exit();
    }
}

// Database configuration
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "so_sarawak_db";

try {
    $pdo = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    echo json_encode(['success' => false, 'message' => 'Database connection failed: ' . $e->getMessage()]);
    exit();
}

// Handle different actions
$action = $_POST['action'] ?? $_GET['action'] ?? 'fetch';

switch($action) {
    case 'add':
        addStateGamesEvent($pdo);
        break;
    case 'edit':
        editStateGamesEvent($pdo);
        break;
    case 'delete':
        deleteStateGamesEvent($pdo);
        break;
    case 'fetch':
        fetchStateGamesEvents($pdo);
        break;
    case 'reorder':
        reorderStateGamesEvents($pdo);
        break;
    case 'test':
        echo json_encode(['success' => true, 'message' => 'State Games handler is working!', 'timestamp' => date('Y-m-d H:i:s')]);
        break;
    default:
        echo json_encode(['success' => false, 'message' => 'Invalid action']);
}

function addStateGamesEvent($pdo) {
    try {
        $eventTitle = $_POST['eventTitle'] ?? '';
        $eventDate = $_POST['eventDate'] ?? '';
        $eventDescription = $_POST['eventDescription'] ?? '';
        $learnMoreLink = $_POST['learnMoreLink'] ?? '';
        $displayOrder = $_POST['displayOrder'] ?? null;
        
        // Validate required fields
        if (empty($eventTitle) || empty($eventDate) || empty($eventDescription)) {
            throw new Exception('Event title, date, and description are required');
        }
        
        // Handle image upload
        $imagePath = '';
        if (isset($_FILES['stateGamesImage']) && $_FILES['stateGamesImage']['error'] === UPLOAD_ERR_OK) {
            $imagePath = handleImageUpload($_FILES['stateGamesImage']);
        }
        
        // If no display order provided, get the next available order
        if ($displayOrder === null || $displayOrder === '') {
            $stmt = $pdo->prepare("SELECT COALESCE(MAX(display_order), 0) + 1 as next_order FROM state_games");
            $stmt->execute();
            $displayOrder = $stmt->fetch(PDO::FETCH_ASSOC)['next_order'];
        }
        
        // Insert into database
        $stmt = $pdo->prepare("INSERT INTO state_games (event_title, event_date, event_description, learn_more_link, image_path, display_order, created_at) VALUES (?, ?, ?, ?, ?, ?, NOW())");
        $stmt->execute([$eventTitle, $eventDate, $eventDescription, $learnMoreLink, $imagePath, $displayOrder]);
        
        echo json_encode([
            'success' => true,
            'message' => 'State Games event added successfully!',
            'id' => $pdo->lastInsertId()
        ]);
        
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'message' => $e->getMessage()]);
    }
}

function editStateGamesEvent($pdo) {
    try {
        $id = $_POST['id'] ?? '';
        $eventTitle = $_POST['eventTitle'] ?? '';
        $eventDate = $_POST['eventDate'] ?? '';
        $eventDescription = $_POST['eventDescription'] ?? '';
        $learnMoreLink = $_POST['learnMoreLink'] ?? '';
        $displayOrder = $_POST['displayOrder'] ?? null;
        $currentImage = $_POST['currentImage'] ?? '';
        
        if (empty($id) || empty($eventTitle) || empty($eventDate) || empty($eventDescription)) {
            throw new Exception('ID, event title, date, and description are required');
        }
        
        // Handle image upload or keep existing
        $imagePath = $currentImage;
        if (isset($_FILES['stateGamesImage']) && $_FILES['stateGamesImage']['error'] === UPLOAD_ERR_OK) {
            // Delete old image if exists
            if (!empty($currentImage) && file_exists($currentImage)) {
                unlink($currentImage);
            }
            $imagePath = handleImageUpload($_FILES['stateGamesImage']);
        }
        
        // Update database
        $stmt = $pdo->prepare("UPDATE state_games SET event_title = ?, event_date = ?, event_description = ?, learn_more_link = ?, image_path = ?, display_order = ?, updated_at = NOW() WHERE id = ?");
        $stmt->execute([$eventTitle, $eventDate, $eventDescription, $learnMoreLink, $imagePath, $displayOrder, $id]);
        
        echo json_encode(['success' => true, 'message' => 'State Games event updated successfully!']);
        
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'message' => $e->getMessage()]);
    }
}

function deleteStateGamesEvent($pdo) {
    try {
        $id = $_POST['id'] ?? $_GET['id'] ?? '';
        
        if (empty($id)) {
            throw new Exception('Event ID is required');
        }
        
        // Get image path before deletion
        $stmt = $pdo->prepare("SELECT image_path FROM state_games WHERE id = ?");
        $stmt->execute([$id]);
        $event = $stmt->fetch(PDO::FETCH_ASSOC);
        
        // Delete from database
        $stmt = $pdo->prepare("DELETE FROM state_games WHERE id = ?");
        $stmt->execute([$id]);
        
        // Delete image file if exists
        if ($event && !empty($event['image_path']) && file_exists($event['image_path'])) {
            unlink($event['image_path']);
        }
        
        echo json_encode(['success' => true, 'message' => 'State Games event deleted successfully!']);
        
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'message' => $e->getMessage()]);
    }
}

function fetchStateGamesEvents($pdo) {
    try {
        $stmt = $pdo->prepare("SELECT * FROM state_games ORDER BY display_order ASC, created_at DESC");
        $stmt->execute();
        $events = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        // Convert image paths to URLs and format data
        foreach ($events as &$event) {
            if (!empty($event['image_path'])) {
                // Convert file path to web URL
                $event['image_url'] = str_replace('\\', '/', $event['image_path']);
                $event['image_url'] = str_replace('../', '', $event['image_url']);
                if (!str_starts_with($event['image_url'], 'http')) {
                    $event['image_url'] = '../' . $event['image_url'];
                }
            } else {
                $event['image_url'] = '';
            }
            
            // Format dates for display
            if ($event['created_at']) {
                $event['created_at_formatted'] = date('M j, Y', strtotime($event['created_at']));
            }
            if ($event['updated_at']) {
                $event['updated_at_formatted'] = date('M j, Y', strtotime($event['updated_at']));
            }
        }
        
        echo json_encode(['success' => true, 'events' => $events]);
        
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'message' => $e->getMessage()]);
    }
}

function reorderStateGamesEvents($pdo) {
    try {
        $eventIds = $_POST['event_ids'] ?? [];
        
        if (empty($eventIds) || !is_array($eventIds)) {
            throw new Exception('Invalid event order data');
        }
        
        // Update display order for each event
        foreach ($eventIds as $index => $eventId) {
            $stmt = $pdo->prepare("UPDATE state_games SET display_order = ? WHERE id = ?");
            $stmt->execute([$index + 1, $eventId]);
        }
        
        echo json_encode(['success' => true, 'message' => 'Event order updated successfully!']);
        
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'message' => $e->getMessage()]);
    }
}

function handleImageUpload($file) {
    $uploadDir = '../assets/images/events/';
    
    // Create directory if it doesn't exist
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }
    
    // Validate file type
    $allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
    if (!in_array($file['type'], $allowedTypes)) {
        throw new Exception('Invalid image type. Only JPEG, PNG, GIF, and WebP are allowed.');
    }
    
    // Validate file size (max 5MB)
    if ($file['size'] > 5 * 1024 * 1024) {
        throw new Exception('Image file too large. Maximum size is 5MB.');
    }
    
    // Generate unique filename
    $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
    $filename = 'state_game_' . time() . '_' . uniqid() . '.' . $extension;
    $uploadPath = $uploadDir . $filename;
    
    // Move uploaded file
    if (!move_uploaded_file($file['tmp_name'], $uploadPath)) {
        throw new Exception('Failed to upload image file');
    }
    
    return $uploadPath;
}
?>