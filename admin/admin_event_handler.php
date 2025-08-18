<?php
// Database connection (replace with your actual credentials)
$servername = "localhost";
$username = "root"; // Your MySQL username
$password = "";     // Your MySQL password
$dbname = "special_olympics_data"; // Your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die(json_encode(['success' => false, 'message' => 'Connection failed: ' . $conn->connect_error]));
}

// Initialize variables
$action = $_POST['action'] ?? $_GET['action'] ?? '';
$response = ['success' => false, 'message' => 'Invalid action.'];

switch ($action) {
    case 'add':
        $title = $_POST['eventTitle'] ?? '';
        $description = $_POST['eventDescription'] ?? '';
        $location = $_POST['eventLocation'] ?? '';
        $event_date = $_POST['eventDate'] ?? '';
        $event_time = $_POST['eventTime'] ?? '';
        $type = $_POST['eventType'] ?? '';
        $image_path = null;

        // Handle image upload
        if (isset($_FILES['eventImage']) && $_FILES['eventImage']['error'] == UPLOAD_ERR_OK) {
            $target_dir = "../assets/images/events/"; // Directory to save event images
            if (!is_dir($target_dir)) {
                mkdir($target_dir, 0777, true);
            }
            $image_name = basename($_FILES["eventImage"]["name"]);
            $image_path = $target_dir . uniqid() . '_' . $image_name; // Unique filename to prevent overwrites
            
            if (!move_uploaded_file($_FILES["eventImage"]["tmp_name"], $image_path)) {
                $response = ['success' => false, 'message' => 'Failed to upload image.'];
                echo json_encode($response);
                $conn->close();
                exit();
            }
        }

        if ($title && $description && $location && $event_date && $event_time && $type) {
            $stmt = $conn->prepare("INSERT INTO events (title, description, location, event_date, event_time, type, image_path) VALUES (?, ?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("sssssss", $title, $description, $location, $event_date, $event_time, $type, $image_path);

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
        $sql = "SELECT id, title, description, location, event_date, event_time, type, image_path FROM events ORDER BY event_date ASC, event_time ASC";
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
                if ($image_path_to_delete && file_exists($image_path_to_delete)) {
                    unlink($image_path_to_delete);
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
        $event_date = $_POST['eventDate'] ?? '';
        $event_time = $_POST['eventTime'] ?? '';
        $type = $_POST['eventType'] ?? '';
        $image_path = $_POST['currentImage'] ?? null; // Keep current image if not updated

        // Handle new image upload
        if (isset($_FILES['eventImage']) && $_FILES['eventImage']['error'] == UPLOAD_ERR_OK) {
            $target_dir = "../assets/images/events/";
            if (!is_dir($target_dir)) {
                mkdir($target_dir, 0777, true);
            }
            $image_name = basename($_FILES["eventImage"]["name"]);
            $new_image_path = $target_dir . uniqid() . '_' . $image_name;

            if (move_uploaded_file($_FILES["eventImage"]["tmp_name"], $new_image_path)) {
                // Delete old image if a new one is uploaded
                if ($image_path && file_exists($image_path)) {
                    unlink($image_path);
                }
                $image_path = $new_image_path;
            } else {
                $response = ['success' => false, 'message' => 'Failed to upload new image.'];
                echo json_encode($response);
                $conn->close();
                exit();
            }
        }

        if ($id && $title && $description && $location && $event_date && $event_time && $type) {
            $stmt = $conn->prepare("UPDATE events SET title = ?, description = ?, location = ?, event_date = ?, event_time = ?, type = ?, image_path = ? WHERE id = ?");
            $stmt->bind_param("sssssssi", $title, $description, $location, $event_date, $event_time, $type, $image_path, $id);

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
            $stmt = $conn->prepare("SELECT id, title, description, location, event_date, event_time, type, image_path FROM events WHERE id = ?");
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

echo json_encode($response);
$conn->close();
?>
