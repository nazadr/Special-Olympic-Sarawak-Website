<?php
// filepath: d:\0 - Miscellaneous\VS Code\Web\SOS (Testing Ground)\admin\admin_gallery_photo_handler.php
// Contains Photos gallery handler

// Disable error display to prevent HTML in JSON response
ini_set('display_errors', 0);
error_reporting(0);

// Increase memory limit for image processing
ini_set('memory_limit', '512M');

header('Content-Type: application/json');

// Error handler that ensures JSON output
function handleError($message) {
    echo json_encode(['success' => false, 'message' => $message]);
    exit;
}

// Database connection details
$servername = "localhost"; // Your database host
$username   = "root"; // Your database username
$password   = ""; // Your database password
$dbname     = "so_sarawak_db"; // The database name you will create

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die(json_encode(['success' => false, 'message' => 'Connection failed: ' . $conn->connect_error]));
}

// Physical upload directory (relative to this handler file)
$uploadDirPhysical = '../../assets/images/gallery_photos_upload/';
if (!is_dir($uploadDirPhysical)) mkdir($uploadDirPhysical, 0777, true);

// Web path (what gets stored in DB and used in HTML)
$uploadDirWeb = '../assets/images/gallery_photos_upload/';

$action = $_REQUEST['action'] ?? '';

// Early exit for empty or invalid actions to prevent unwanted error messages
if (empty($action) || strlen($action) < 3) {
    http_response_code(400);
    exit;
}

function safeName($name){ return preg_replace('/[^A-Za-z0-9._-]/','_', $name); }

// Image compression function
function compressImage($source, $destination, $quality = 75, $maxWidth = 1920, $maxHeight = 1080) {
    // Check if destination directory exists
    $destDir = dirname($destination);
    if (!is_dir($destDir)) {
        if (!mkdir($destDir, 0777, true)) {
            return false;
        }
    }
    
    $info = getimagesize($source);
    if (!$info) {
        return false;
    }
    
    $mime = $info['mime'];
    $width = $info[0];
    $height = $info[1];
    
    // Calculate new dimensions while maintaining aspect ratio
    if ($width > $maxWidth || $height > $maxHeight) {
        $ratio = min($maxWidth / $width, $maxHeight / $height);
        $newWidth = floor($width * $ratio);
        $newHeight = floor($height * $ratio);
    } else {
        $newWidth = $width;
        $newHeight = $height;
    }
    
    // Create image resource from source
    switch ($mime) {
        case 'image/jpeg':
            $image = imagecreatefromjpeg($source);
            break;
        case 'image/png':
            $image = imagecreatefrompng($source);
            break;
        case 'image/gif':
            $image = imagecreatefromgif($source);
            break;
        case 'image/webp':
            $image = imagecreatefromwebp($source);
            break;
        default:
            return false;
    }
    
    if (!$image) {
        return false;
    }
    
    // Create new image with calculated dimensions
    $newImage = imagecreatetruecolor($newWidth, $newHeight);
    
    // Preserve transparency for PNG and GIF
    if ($mime == 'image/png' || $mime == 'image/gif') {
        imagealphablending($newImage, false);
        imagesavealpha($newImage, true);
        $transparent = imagecolorallocatealpha($newImage, 255, 255, 255, 127);
        imagefill($newImage, 0, 0, $transparent);
    }
    
    // Resize image
    imagecopyresampled($newImage, $image, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);
    
    // Save compressed image
    $success = false;
    switch ($mime) {
        case 'image/jpeg':
            $success = imagejpeg($newImage, $destination, $quality);
            break;
        case 'image/png':
            // Convert quality (0-100) to PNG compression (0-9)
            $pngQuality = floor((100 - $quality) / 10);
            $success = imagepng($newImage, $destination, $pngQuality);
            break;
        case 'image/gif':
            $success = imagegif($newImage, $destination);
            break;
        case 'image/webp':
            $success = imagewebp($newImage, $destination, $quality);
            break;
    }
    
    // Clean up memory
    imagedestroy($image);
    imagedestroy($newImage);
    
    return $success;
}

// ==================== FETCH COLLECTIONS ====================
if ($action === 'fetch_collections') {
    // Check if sort_order column exists and add it if not
    $checkColumn = $conn->query("SHOW COLUMNS FROM gallery_photos_collection LIKE 'sort_order'");
    if ($checkColumn->num_rows == 0) {
        $conn->query("ALTER TABLE gallery_photos_collection ADD COLUMN sort_order INT DEFAULT 0");
    }
    
    $res = $conn->query("SELECT id, name, description, sort_order FROM gallery_photos_collection ORDER BY sort_order ASC, name ASC");
    if (!$res) {
        echo json_encode(['success' => false, 'message' => 'Query error: ' . $conn->error]);
        exit;
    }
    echo json_encode(['success'=>true,'collections'=>$res->fetch_all(MYSQLI_ASSOC)]);
    exit;
}

// ==================== ADD COLLECTION (optional helper) ====================
if ($action === 'add_collection') {
    $name = trim($_POST['name'] ?? '');
    $desc = trim($_POST['description'] ?? '');
    if ($name === '') {
        echo json_encode(['success'=>false,'message'=>'Name required']);
        exit;
    }
    $stmt = $conn->prepare("INSERT INTO gallery_photos_collection (name,description) VALUES (?,?)");
    $stmt->bind_param('ss', $name, $desc);
    if ($stmt->execute()) {
        echo json_encode(['success'=>true,'id'=>$stmt->insert_id]);
    } else {
        echo json_encode(['success'=>false,'message'=>'Insert failed: ' . $conn->error]);
    }
    exit;
}

// ==================== FETCH PHOTOS IN A COLLECTION ====================
if ($action === 'fetch_items') {
    $cid = (int)($_GET['collection_id'] ?? 0);
    
    // Check if sort_order column exists in gallery_photos table and add it if not
    $checkColumn = $conn->query("SHOW COLUMNS FROM gallery_photos LIKE 'sort_order'");
    if ($checkColumn->num_rows == 0) {
        $conn->query("ALTER TABLE gallery_photos ADD COLUMN sort_order INT DEFAULT 0");
    }
    
    $stmt = $conn->prepare("SELECT id, image_path, sort_order FROM gallery_photos WHERE collection_id=? ORDER BY sort_order ASC, id ASC");
    $stmt->bind_param('i', $cid);
    $stmt->execute();
    $res = $stmt->get_result();
    echo json_encode(['success'=>true,'photos'=>$res->fetch_all(MYSQLI_ASSOC)]);
    exit;
}

// ==================== ADD PHOTO (PUBLISH) ====================
if ($action === 'add_photo') {
    $existing = trim($_POST['galleryPhotoAlbum'] ?? '');
    $newName  = trim($_POST['galleryPhotoNewAlbum'] ?? '');
    $newDesc  = trim($_POST['galleryPhotoNewAlbumDesc'] ?? '');
    $cid = 0;
    
    // Debug: Log all POST data
    error_log("Gallery upload DEBUG - POST data: " . json_encode($_POST));
    error_log("Gallery upload DEBUG - existing='$existing', newName='$newName', newDesc='$newDesc'");

    // allow: new collection without selecting dropdown
    if ($newName !== '') {
        // create or reuse collection by name
        $stmt = $conn->prepare(
            "INSERT INTO gallery_photos_collection (name,description)
             VALUES (?,?)
             ON DUPLICATE KEY UPDATE id = LAST_INSERT_ID(id)"
        );
        $stmt->bind_param('ss', $newName, $newDesc);
        if (!$stmt->execute()) {
            echo json_encode(['success'=>false,'message'=>'Collection insert failed: ' . $conn->error]);
            exit;
        }
        $cid = $conn->insert_id;

        // fallback: if still 0, explicitly fetch
        if ($cid === 0) {
            $q = $conn->prepare("SELECT id FROM gallery_photos_collection WHERE name=?");
            $q->bind_param('s', $newName);
            $q->execute();
            $row = $q->get_result()->fetch_assoc();
            $cid = $row['id'] ?? 0;
        }
    } elseif ($existing !== '') {
        // use existing collection
        $q = $conn->prepare("SELECT id FROM gallery_photos_collection WHERE name=?");
        $q->bind_param('s', $existing);
        $q->execute();
        $row = $q->get_result()->fetch_assoc();
        $cid = $row['id'] ?? 0;
    }

    if ($cid === 0) {
        echo json_encode(['success'=>false,'message'=>'Please select or create a collection. Debug: existing="' . $existing . '", newName="' . $newName . '"']);
        exit;
    }
    
    // Handle both single and multiple file uploads
    if (!isset($_FILES['galleryPhotoImage'])) {
        handleError('No images selected');
    }
    
    // Normalize to array format for consistent handling
    $fileNames = $_FILES['galleryPhotoImage']['name'];
    $fileTmpNames = $_FILES['galleryPhotoImage']['tmp_name'];
    $fileErrors = $_FILES['galleryPhotoImage']['error'];
    $fileSizes = $_FILES['galleryPhotoImage']['size'];
    
    // If single file, convert to array format
    if (!is_array($fileNames)) {
        $fileNames = [$fileNames];
        $fileTmpNames = [$fileTmpNames];
        $fileErrors = [$fileErrors];
        $fileSizes = [$fileSizes];
    }

    $uploadedCount = 0;
    $errors = [];
    $totalCompressionSaved = 0;
    $fileCount = count($fileNames);
    
    // Prepare statement once for efficiency
    $stmt = $conn->prepare("INSERT INTO gallery_photos (collection_id, image_path) VALUES (?, ?)");
    
    for ($i = 0; $i < $fileCount; $i++) {
        // Check if this file has an error
        if ($fileErrors[$i] !== UPLOAD_ERR_OK) {
            $errors[] = "File " . ($i + 1) . ": Upload error code " . $fileErrors[$i];
            continue;
        }
        
        $orig = safeName($fileNames[$i]);
        $timestamp = time() . '_' . $i; // Add index to avoid conflicts
        $physicalPath = $uploadDirPhysical . $timestamp . '_' . $orig;
        $webPath = $uploadDirWeb . $timestamp . '_' . $orig;
        
        // Validate image
        $fileInfo = getimagesize($fileTmpNames[$i]);
        if (!$fileInfo) {
            $errors[] = "File '$orig': Invalid image file";
            continue;
        }
        
        $originalSize = $fileSizes[$i];
        
        // Upload file directly (compression temporarily disabled for stability)
        if (!move_uploaded_file($fileTmpNames[$i], $physicalPath)) {
            $errors[] = "File '$orig': Upload failed";
            continue;
        }
        
        // Calculate compression savings
        $compressedSize = file_exists($physicalPath) ? filesize($physicalPath) : $originalSize;
        $totalCompressionSaved += ($originalSize - $compressedSize);
        
        // Insert into database
        $stmt->bind_param('is', $cid, $webPath);
        if ($stmt->execute()) {
            $uploadedCount++;
        } else {
            $dbError = $conn->error;
            $errors[] = "File '$orig': Database error - " . $dbError;
            // Clean up the uploaded file if DB insert fails
            if (file_exists($physicalPath)) {
                unlink($physicalPath);
            }
        }
    }
    
    $stmt->close();
    
    // Prepare response message
    $message = "";
    if ($uploadedCount > 0) {
        $message = "Successfully uploaded $uploadedCount photo(s)";
        if ($totalCompressionSaved > 0) {
            $savedMB = round($totalCompressionSaved / (1024 * 1024), 1);
            $message .= " (saved {$savedMB}MB through compression)";
        }
    }
    
    if (!empty($errors)) {
        if ($uploadedCount > 0) {
            $message .= ". Errors: " . implode('; ', $errors);
        } else {
            $message = "Upload failed: " . implode('; ', $errors);
        }
    }
    
    echo json_encode([
        'success' => $uploadedCount > 0, 
        'message' => $message,
        'uploaded_count' => $uploadedCount,
        'total_files' => $fileCount
    ]);
    exit;
}

// ==================== DELETE PHOTO ====================
if ($action === 'delete_photo') {
    $id = (int)($_POST['id'] ?? 0);
    if ($id <= 0) {
        echo json_encode(['success' => false, 'message' => 'Invalid photo id']);
        exit;
    }

    // Get image path before deleting
    $stmt = $conn->prepare("SELECT image_path FROM gallery_photos WHERE id = ?");
    $stmt->bind_param('i', $id);
    $stmt->execute();
    $res = $stmt->get_result();
    $photo = $res->fetch_assoc();
    $stmt->close();

    if (!$photo) {
        echo json_encode(['success' => false, 'message' => 'Photo not found']);
        exit;
    }

    // Delete from database
    $stmt = $conn->prepare("DELETE FROM gallery_photos WHERE id = ?");
    $stmt->bind_param('i', $id);
    $ok = $stmt->execute();
    $stmt->close();

    if ($ok) {
        // Convert web path to physical path for deletion
        $webPath = $photo['image_path'];
        $physicalPath = str_replace('../assets/', '../../assets/', $webPath);
        if (file_exists($physicalPath)) {
            @unlink($physicalPath);
        }
        echo json_encode(['success' => true, 'message' => 'Photo deleted successfully']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Delete failed: ' . $conn->error]);
    }
    exit;
}

// ==================== DELETE COLLECTION ====================
if ($action === 'delete_collection') {
    $cid = (int)($_POST['id'] ?? 0);

    // remove files
    $stmt = $conn->prepare("SELECT image_path FROM gallery_photos WHERE collection_id=?");
    $stmt->bind_param('i', $cid);
    $stmt->execute();
    $res = $stmt->get_result();
    while ($row = $res->fetch_assoc()) {
        $physicalPath = str_replace('../assets/', '../../assets/', $row['image_path']);
        @unlink($physicalPath);
    }

    // delete collection (photos table has FK with ON DELETE CASCADE ideally)
    $del = $conn->prepare("DELETE FROM gallery_photos_collection WHERE id=?");
    $del->bind_param('i', $cid);
    $del->execute();

    echo json_encode(['success'=>true]);
    exit;
}

// ==================== UPDATE COLLECTION ====================
if ($action === 'update_collection') {
    $id   = (int)($_POST['id'] ?? 0);
    $name = trim($_POST['name'] ?? '');
    $desc = trim($_POST['description'] ?? '');
    
    if ($id <= 0 || $name === '') {
        echo json_encode(['success' => false, 'message' => 'Invalid input']);
        exit;
    }
    
    $stmt = $conn->prepare("UPDATE gallery_photos_collection SET name=?, description=? WHERE id=?");
    $stmt->bind_param('ssi', $name, $desc, $id);
    
    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'message' => 'Collection updated successfully']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Update failed: ' . $conn->error]);
    }
    exit;
}

// ==================== UPDATE GALLERY ORDER ====================
if ($action === 'update_gallery_order') {
    $orderData = json_decode($_POST['order_data'] ?? '[]', true);
    
    if (empty($orderData) || !is_array($orderData)) {
        echo json_encode(['success' => false, 'message' => 'Invalid order data']);
        exit;
    }
    
    $conn->begin_transaction();
    
    try {
        // First, check if sort_order column exists, if not add it
        $checkColumn = $conn->query("SHOW COLUMNS FROM gallery_photos_collection LIKE 'sort_order'");
        if ($checkColumn->num_rows == 0) {
            $conn->query("ALTER TABLE gallery_photos_collection ADD COLUMN sort_order INT DEFAULT 0");
        }
        
        // Update each collection's sort order
        $stmt = $conn->prepare("UPDATE gallery_photos_collection SET sort_order = ? WHERE id = ?");
        if (!$stmt) {
            throw new Exception('Prepare failed: ' . $conn->error);
        }
        
        foreach ($orderData as $item) {
            $collection_id = intval($item['collection_id']);
            $sort_order = intval($item['sort_order']);
            
            if ($collection_id <= 0) {
                throw new Exception('Invalid collection ID');
            }
            
            $stmt->bind_param('ii', $sort_order, $collection_id);
            if (!$stmt->execute()) {
                throw new Exception('Execute failed: ' . $stmt->error);
            }
        }
        
        $conn->commit();
        echo json_encode(['success' => true, 'message' => 'Gallery order updated successfully']);
        
    } catch (Exception $e) {
        $conn->rollback();
        echo json_encode(['success' => false, 'message' => 'Failed to update gallery order: ' . $e->getMessage()]);
    }
    
    exit;
}

// ==================== UPDATE PHOTO ORDER ====================
if ($action === 'update_photo_order') {
    $collectionId = intval($_POST['collection_id'] ?? 0);
    $orderData = json_decode($_POST['order_data'] ?? '[]', true);
    
    if ($collectionId <= 0) {
        echo json_encode(['success' => false, 'message' => 'Invalid collection ID']);
        exit;
    }
    
    if (empty($orderData) || !is_array($orderData)) {
        echo json_encode(['success' => false, 'message' => 'Invalid order data']);
        exit;
    }
    
    $conn->begin_transaction();
    
    try {
        // First, check if sort_order column exists in gallery_photos table, if not add it
        $checkColumn = $conn->query("SHOW COLUMNS FROM gallery_photos LIKE 'sort_order'");
        if ($checkColumn->num_rows == 0) {
            $conn->query("ALTER TABLE gallery_photos ADD COLUMN sort_order INT DEFAULT 0");
        }
        
        // Update each photo's sort order within the collection
        $stmt = $conn->prepare("UPDATE gallery_photos SET sort_order = ? WHERE id = ? AND collection_id = ?");
        if (!$stmt) {
            throw new Exception('Prepare failed: ' . $conn->error);
        }
        
        foreach ($orderData as $item) {
            $photo_id = intval($item['photo_id']);
            $sort_order = intval($item['sort_order']);
            
            if ($photo_id <= 0) {
                throw new Exception('Invalid photo ID');
            }
            
            $stmt->bind_param('iii', $sort_order, $photo_id, $collectionId);
            if (!$stmt->execute()) {
                throw new Exception('Execute failed: ' . $stmt->error);
            }
        }
        
        $conn->commit();
        echo json_encode(['success' => true, 'message' => 'Photo order updated successfully']);
        
    } catch (Exception $e) {
        $conn->rollback();
        echo json_encode(['success' => false, 'message' => 'Failed to update photo order: ' . $e->getMessage()]);
    }
    
    exit;
}

// default - silently handle invalid actions
http_response_code(400);
exit;
?>