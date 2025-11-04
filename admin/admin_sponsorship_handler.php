<?php
// Database connection (replace with your actual credentials)
$servername = "localhost";
$username = "root"; // Your MySQL username
$password = "";     // Your MySQL password
$dbname = "so_sarawak_db"; // Database name on local phpMyAdmin

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
        $type = $_POST['sponsorshipType'] ?? '';
        $image_path = null;

        // Handle image upload
        if (isset($_FILES['sponsorshipImage']) && $_FILES['sponsorshipImage']['error'] == UPLOAD_ERR_OK) {
            $target_dir = "../assets/images/sponsorships/";
            if (!is_dir($target_dir)) {
                mkdir($target_dir, 0777, true);
            }
            $image_name = basename($_FILES["sponsorshipImage"]["name"]);
            $image_path = $target_dir . uniqid() . '_' . $image_name;
            if (!move_uploaded_file($_FILES["sponsorshipImage"]["tmp_name"], $image_path)) {
                $response = ['success' => false, 'message' => 'Failed to upload image.'];
                echo json_encode($response);
                $conn->close();
                exit();
            }
        }

        if ($type && $image_path) {
            $stmt = $conn->prepare("INSERT INTO sponsorships (type, image_path) VALUES (?, ?)");
            $stmt->bind_param("ss", $type, $image_path);
            if ($stmt->execute()) {
                $response = ['success' => true, 'message' => 'Sponsorship added successfully!'];
            } else {
                $response = ['success' => false, 'message' => 'Error adding sponsorship: ' . $stmt->error];
            }
            $stmt->close();
        } else {
            $response = ['success' => false, 'message' => 'Sponsorship type and image are required.'];
        }
        break;

    case 'fetch':
        $sql = "SELECT id, type, image_path FROM sponsorships ORDER BY id ASC";
        $result = $conn->query($sql);
        $sponsorships = [];
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $sponsorships[] = $row;
            }
            $response = ['success' => true, 'sponsorships' => $sponsorships];
        } else {
            $response = ['success' => true, 'sponsorships' => [], 'message' => 'No sponsorships found.'];
        }
        break;

    case 'delete':
        $id = $_POST['id'] ?? '';
        if ($id) {
            $stmt = $conn->prepare("SELECT image_path FROM sponsorships WHERE id = ?");
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $stmt->bind_result($image_path_to_delete);
            $stmt->fetch();
            $stmt->close();

            $stmt = $conn->prepare("DELETE FROM sponsorships WHERE id = ?");
            $stmt->bind_param("i", $id);
            if ($stmt->execute()) {
                if ($image_path_to_delete && file_exists($image_path_to_delete)) {
                    unlink($image_path_to_delete);
                }
                $response = ['success' => true, 'message' => 'Sponsorship deleted successfully!'];
            } else {
                $response = ['success' => false, 'message' => 'Error deleting sponsorship: ' . $stmt->error];
            }
            $stmt->close();
        } else {
            $response = ['success' => false, 'message' => 'Sponsorship ID is required for deletion.'];
        }
        break;

    case 'edit':
        $id = $_POST['id'] ?? '';
        $type = $_POST['sponsorshipType'] ?? '';
        $image_path = $_POST['currentImage'] ?? null;

        // Handle new image upload
        if (isset($_FILES['sponsorshipImage']) && $_FILES['sponsorshipImage']['error'] == UPLOAD_ERR_OK) {
            $target_dir = "../assets/images/sponsorships/";
            if (!is_dir($target_dir)) {
                mkdir($target_dir, 0777, true);
            }
            $image_name = basename($_FILES["sponsorshipImage"]["name"]);
            $new_image_path = $target_dir . uniqid() . '_' . $image_name;
            if (move_uploaded_file($_FILES["sponsorshipImage"]["tmp_name"], $new_image_path)) {
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

        if ($id && $type) {
            $stmt = $conn->prepare("UPDATE sponsorships SET type = ?, image_path = ? WHERE id = ?");
            $stmt->bind_param("ssi", $type, $image_path, $id);
            if ($stmt->execute()) {
                $response = ['success' => true, 'message' => 'Sponsorship updated successfully!'];
            } else {
                $response = ['success' => false, 'message' => 'Error updating sponsorship: ' . $stmt->error];
            }
            $stmt->close();
        } else {
            $response = ['success' => false, 'message' => 'All fields and ID are required for editing a sponsorship.'];
        }
        break;

    case 'fetch_single':
        $id = $_GET['id'] ?? '';
        if ($id) {
            $stmt = $conn->prepare("SELECT id, type, image_path FROM sponsorships WHERE id = ?");
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $result = $stmt->get_result();
            if ($result->num_rows > 0) {
                $sponsorship = $result->fetch_assoc();
                $response = ['success' => true, 'sponsorship' => $sponsorship];
            } else {
                $response = ['success' => false, 'message' => 'Sponsorship not found.'];
            }
            $stmt->close();
        } else {
            $response = ['success' => false, 'message' => 'Sponsorship ID is required.'];
        }
        break;
}

echo json_encode($response);
$conn->close();
?>