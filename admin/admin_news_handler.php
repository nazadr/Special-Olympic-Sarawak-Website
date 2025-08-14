<?php
// Database connection details
$servername = "localhost"; // Your database host
$username = "root"; // Your database username
$password = ""; // Your database password
$dbname = "special_olympics_site"; // The database name you will create

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die(json_encode(['success' => false, 'message' => 'Connection failed: ' . $conn->connect_error]));
}

// Ensure the 'uploads' directory exists
$uploadDir = '../assets/images/news_uploads/'; // Relative path from admin_news_handler.php
if (!is_dir($uploadDir)) {
    mkdir($uploadDir, 0777, true); // Create directory with write permissions
}

header('Content-Type: application/json');

$action = $_REQUEST['action'] ?? '';

switch ($action) {
    case 'add':
        $headline = $_POST['newsHeadline'] ?? '';
        $newsDate = $_POST['newsDate'] ?? '';
        $description = $_POST['newsDescription'] ?? '';
        $imagePath = '';

        // Handle image upload
        if (isset($_FILES['newsImage']) && $_FILES['newsImage']['error'] == UPLOAD_ERR_OK) {
            $fileTmpPath = $_FILES['newsImage']['tmp_name'];
            $fileName = $_FILES['newsImage']['name'];
            $fileSize = $_FILES['newsImage']['size'];
            $fileType = $_FILES['newsImage']['type'];
            $fileNameCmps = explode(".", $fileName);
            $fileExtension = strtolower(end($fileNameCmps));

            $newFileName = md5(time() . $fileName) . '.' . $fileExtension;
            $destPath = $uploadDir . $newFileName;

            $allowedfileExtensions = array('jpg', 'gif', 'png', 'jpeg');
            if (in_array($fileExtension, $allowedfileExtensions)) {
                if (move_uploaded_file($fileTmpPath, $destPath)) {
                    $imagePath = $destPath;
                } else {
                    echo json_encode(['success' => false, 'message' => 'Failed to move uploaded file.']);
                    exit();
                }
            } else {
                echo json_encode(['success' => false, 'message' => 'Invalid file type. Only JPG, GIF, PNG, JPEG are allowed.']);
                exit();
            }
        } else {
            echo json_encode(['success' => false, 'message' => 'No image uploaded or upload error.']);
            exit();
        }

        if (empty($headline) || empty($newsDate) || empty($description) || empty($imagePath)) {
            echo json_encode(['success' => false, 'message' => 'All fields are required.']);
            exit();
        }

        $stmt = $conn->prepare("INSERT INTO news (image_path, headline, news_date, description) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $imagePath, $headline, $newsDate, $description);

        if ($stmt->execute()) {
            echo json_encode(['success' => true, 'message' => 'News article added successfully.']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Database error: ' . $stmt->error]);
        }
        $stmt->close();
        break;

    case 'fetch':
        $result = $conn->query("SELECT id, image_path, headline, news_date, description FROM news ORDER BY news_date DESC, id DESC");
        $news = [];
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $news[] = $row;
            }
        }
        echo json_encode($news);
        break;

    case 'delete':
        $id = $_POST['id'] ?? '';
        if (empty($id)) {
            echo json_encode(['success' => false, 'message' => 'News ID is required.']);
            exit();
        }

        // First, get the image path to delete the file
        $stmt = $conn->prepare("SELECT image_path FROM news WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $stmt->bind_result($imageToDelete);
        $stmt->fetch();
        $stmt->close();

        $stmt = $conn->prepare("DELETE FROM news WHERE id = ?");
        $stmt->bind_param("i", $id);

        if ($stmt->execute()) {
            // Delete the image file from the server
            if (!empty($imageToDelete) && file_exists($imageToDelete)) {
                unlink($imageToDelete);
            }
            echo json_encode(['success' => true, 'message' => 'News article deleted successfully.']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Database error: ' . $stmt->error]);
        }
        $stmt->close();
        break;

    // You would add 'edit' case here for updating news articles
    case 'edit':
        $id = $_POST['id'] ?? '';
        $headline = $_POST['newsHeadline'] ?? '';
        $newsDate = $_POST['newsDate'] ?? '';
        $description = $_POST['newsDescription'] ?? '';
        $imagePath = $_POST['currentImagePath'] ?? ''; // Hidden field for current image path

        // Handle image upload if a new one is provided
        if (isset($_FILES['newsImage']) && $_FILES['newsImage']['error'] == UPLOAD_ERR_OK) {
            $fileTmpPath = $_FILES['newsImage']['tmp_name'];
            $fileName = $_FILES['newsImage']['name'];
            $fileSize = $_FILES['newsImage']['size'];
            $fileType = $_FILES['newsImage']['type'];
            $fileNameCmps = explode(".", $fileName);
            $fileExtension = strtolower(end($fileNameCmps));

            $newFileName = md5(time() . $fileName) . '.' . $fileExtension;
            $destPath = $uploadDir . $newFileName;

            $allowedfileExtensions = array('jpg', 'gif', 'png', 'jpeg');
            if (in_array($fileExtension, $allowedfileExtensions)) {
                if (move_uploaded_file($fileTmpPath, $destPath)) {
                    // Delete old image if it exists and is not the default placeholder
                    if (!empty($imagePath) && file_exists($imagePath) && strpos($imagePath, 'news_uploads') !== false) {
                        unlink($imagePath);
                    }
                    $imagePath = $destPath; // Update image path to new one
                } else {
                    echo json_encode(['success' => false, 'message' => 'Failed to move uploaded file for edit.']);
                    exit();
                }
            } else {
                echo json_encode(['success' => false, 'message' => 'Invalid file type for edit. Only JPG, GIF, PNG, JPEG are allowed.']);
                exit();
            }
        }

        if (empty($id) || empty($headline) || empty($newsDate) || empty($description)) {
            echo json_encode(['success' => false, 'message' => 'All fields are required for edit.']);
            exit();
        }

        $stmt = $conn->prepare("UPDATE news SET image_path = ?, headline = ?, news_date = ?, description = ? WHERE id = ?");
        $stmt->bind_param("ssssi", $imagePath, $headline, $newsDate, $description, $id);

        if ($stmt->execute()) {
            echo json_encode(['success' => true, 'message' => 'News article updated successfully.']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Database error during update: ' . $stmt->error]);
        }
        $stmt->close();
        break;

    default:
        echo json_encode(['success' => false, 'message' => 'Invalid action.']);
        break;
}

$conn->close();
?>
