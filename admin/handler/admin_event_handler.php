<?php
// Set proper headers for JSON response
header('Content-Type: application/json');

// Enable error reporting for debugging (remove in production)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Database connection (replace with your actual credentials)
$servername = "localhost";
$username = "root"; // Your MySQL username
$password = "";     // Your MySQL password
$dbname = "so_sarawak_db"; // Database name on local phpMyAdmin

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
    error_log("Event handler called with action: " . $action);
    error_log("POST data: " . print_r($_POST, true));
    error_log("FILES data: " . print_r($_FILES, true));
    
    // Test case - return debug info if action is 'test'
    if ($action === 'test') {
        $response = [
            'success' => true,
            'message' => 'Test successful',
            'post_data' => $_POST,
            'files_data' => $_FILES,
            'working_directory' => getcwd()
        ];
        echo json_encode($response);
        exit();
    }
    
    switch ($action) {
    case 'add':
        $title = $_POST['eventTitle'] ?? '';
        $description = $_POST['eventDescription'] ?? '';
        $location = $_POST['eventLocation'] ?? '';
        $city = $_POST['eventCity'] ?? ''; // Recently added for city icon
        $event_date = $_POST['eventDate'] ?? '';
        $event_time = $_POST['eventTime'] ?? '';
        $type = $_POST['eventType'] ?? '';
        $image_path = null;

        // Handle image upload
        if (isset($_FILES['eventImage']) && $_FILES['eventImage']['error'] == UPLOAD_ERR_OK) {
            $target_dir = "../../assets/images/events/"; // File system path
            $web_dir = "assets/images/events/"; // Web path for database storage
            
            if (!is_dir($target_dir)) {
                if (!mkdir($target_dir, 0777, true)) {
                    $response = ['success' => false, 'message' => 'Failed to create upload directory.'];
                    echo json_encode($response);
                    exit();
                }
            }
            
            $image_name = basename($_FILES["eventImage"]["name"]);
            $unique_name = uniqid() . '_' . $image_name;
            $file_path = $target_dir . $unique_name; // For file operations
            $image_path = $web_dir . $unique_name; // For database storage
            
            if (!move_uploaded_file($_FILES["eventImage"]["tmp_name"], $file_path)) {
                $response = ['success' => false, 'message' => 'Failed to upload image.'];
                echo json_encode($response);
                exit();
            }
        }

        if ($title && $description && $location && $city && $event_date && $event_time && $type) {
            $stmt = $conn->prepare("INSERT INTO events (title, description, location, city, event_date, event_time, type, image_path) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("ssssssss", $title, $description, $location, $city, $event_date, $event_time, $type, $image_path);

            if ($stmt->execute()) {
                $response = ['success' => true, 'message' => 'Event added successfully!'];
            } else {
                $response = ['success' => false, 'message' => 'Error adding event: ' . $stmt->error];
            }
            $stmt->close();
        } else {
            $response = ['success' => false, 'message' => 'All fields are required for adding an event.'];
        }
        break;

    case 'fetch':
        $sql = "SELECT id, title, description, location, city, event_date, event_time, type, image_path FROM events ORDER BY event_date ASC, event_time ASC";
        $result = $conn->query($sql);

        $events = [];
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $events[] = $row;
            }
            $response = ['success' => true, 'events' => $events];
        } else {
            $response = ['success' => true, 'events' => [], 'message' => 'No events found.'];
        }
        break;

    case 'delete':
        $id = $_POST['id'] ?? '';

        if ($id) {
            // First, get the image path to delete the file
            $stmt = $conn->prepare("SELECT image_path FROM events WHERE id = ?");
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $stmt->bind_result($image_path_to_delete);
            $stmt->fetch();
            $stmt->close();

            $stmt = $conn->prepare("DELETE FROM events WHERE id = ?");
            $stmt->bind_param("i", $id);

            if ($stmt->execute()) {
                // Delete the image file if it exists
                if ($image_path_to_delete && file_exists("../../" . $image_path_to_delete)) {
                    unlink("../../" . $image_path_to_delete);
                }
                $response = ['success' => true, 'message' => 'Event deleted successfully!'];
            } else {
                $response = ['success' => false, 'message' => 'Error deleting event: ' . $stmt->error];
            }
            $stmt->close();
        } else {
            $response = ['success' => false, 'message' => 'Event ID is required for deletion.'];
        }
        break;

    case 'edit':
        $id = $_POST['id'] ?? '';
        $title = $_POST['eventTitle'] ?? '';
        $description = $_POST['eventDescription'] ?? '';
        $location = $_POST['eventLocation'] ?? '';
        $city = $_POST['eventCity'] ?? '';
        $event_date = $_POST['eventDate'] ?? '';
        $event_time = $_POST['eventTime'] ?? '';
        $type = $_POST['eventType'] ?? '';
        $image_path = $_POST['currentImage'] ?? null; // Keep current image if not updated

        // Handle new image upload
        if (isset($_FILES['eventImage']) && $_FILES['eventImage']['error'] == UPLOAD_ERR_OK) {
            $target_dir = "../../assets/images/events/"; // File system path
            $web_dir = "assets/images/events/"; // Web path
            
            if (!is_dir($target_dir)) {
                if (!mkdir($target_dir, 0777, true)) {
                    $response = ['success' => false, 'message' => 'Failed to create upload directory.'];
                    echo json_encode($response);
                    exit();
                }
            }
            
            $image_name = basename($_FILES["eventImage"]["name"]);
            $unique_name = uniqid() . '_' . $image_name;
            $new_file_path = $target_dir . $unique_name; // For file operations
            $new_image_path = $web_dir . $unique_name; // For database storage

            if (move_uploaded_file($_FILES["eventImage"]["tmp_name"], $new_file_path)) {
                // Delete old image file if a new one is uploaded
                if ($image_path && file_exists("../../" . $image_path)) {
                    unlink("../../" . $image_path);
                }
                $image_path = $new_image_path;
            } else {
                $response = ['success' => false, 'message' => 'Failed to upload new image.'];
                echo json_encode($response);
                exit();
            }
        }
        
        // Check if image was intentionally removed (currentImage is empty but no new file uploaded)
        if (empty($_POST['currentImage']) && (!isset($_FILES['eventImage']) || $_FILES['eventImage']['error'] !== UPLOAD_ERR_OK)) {
            // Get the old image path to delete it
            $stmt = $conn->prepare("SELECT image_path FROM events WHERE id = ?");
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $stmt->bind_result($old_image_path);
            $stmt->fetch();
            $stmt->close();
            
            // Delete the old image file
            if ($old_image_path && file_exists("../../" . $old_image_path)) {
                unlink("../../" . $old_image_path);
            }
            $image_path = null; // Set to null to remove from database
        }

        if ($id && $title && $description && $location && $city && $event_date && $event_time && $type) {
            $stmt = $conn->prepare("UPDATE events SET title = ?, description = ?, location = ?, city = ?, event_date = ?, event_time = ?, type = ?, image_path = ? WHERE id = ?");
            $stmt->bind_param("ssssssssi", $title, $description, $location, $city, $event_date, $event_time, $type, $image_path, $id);

            if ($stmt->execute()) {
                $response = ['success' => true, 'message' => 'Event updated successfully!'];
            } else {
                $response = ['success' => false, 'message' => 'Error updating event: ' . $stmt->error];
            }
            $stmt->close();
        } else {
            $response = ['success' => false, 'message' => 'All fields and ID are required for editing an event.'];
        }
        break;

    case 'fetch_single':
        $id = $_GET['id'] ?? '';
        if ($id) {
            $stmt = $conn->prepare("SELECT id, title, description, location, city, event_date, event_time, type, image_path FROM events WHERE id = ?");
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $result = $stmt->get_result();
            if ($result->num_rows > 0) {
                $event = $result->fetch_assoc();
                $response = ['success' => true, 'event' => $event];
            } else {
                $response = ['success' => false, 'message' => 'Event not found.'];
            }
            $stmt->close();
        } else {
            $response = ['success' => false, 'message' => 'Event ID is required.'];
        }
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