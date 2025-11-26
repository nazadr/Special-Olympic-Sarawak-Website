<?php
// filepath: d:\0 - Miscellaneous\VS Code\Web\SOS (Testing Ground)\admin\admin_gallery_photo_handler.php
// Contains Photos gallery handler

header('Content-Type: application/json');

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

function safeName($name){ return preg_replace('/[^A-Za-z0-9._-]/','_', $name); }

// ==================== FETCH COLLECTIONS ====================
if ($action === 'fetch_collections') {
    $res = $conn->query("SELECT id, name, description FROM gallery_photos_collection ORDER BY name ASC");
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
    $stmt = $conn->prepare("SELECT id, image_path FROM gallery_photos WHERE collection_id=? ORDER BY id ASC");
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
        echo json_encode(['success'=>false,'message'=>'Please select or create a collection']);
        exit;
    }

    if (!isset($_FILES['galleryPhotoImage']) || $_FILES['galleryPhotoImage']['error'] !== UPLOAD_ERR_OK) {
        echo json_encode(['success'=>false,'message'=>'Image required']);
        exit;
    }

    $orig = safeName($_FILES['galleryPhotoImage']['name']);
    $physicalPath = $uploadDirPhysical . time() . '_' . $orig;
    $webPath = $uploadDirWeb . time() . '_' . $orig;

    if (!move_uploaded_file($_FILES['galleryPhotoImage']['tmp_name'], $physicalPath)) {
        echo json_encode(['success'=>false,'message'=>'Upload failed']);
        exit;
    }

    // Store the web path in database
    $stmt = $conn->prepare("INSERT INTO gallery_photos (collection_id, image_path) VALUES (?, ?)");
    $stmt->bind_param('is', $cid, $webPath);

    if ($stmt->execute()) {
        echo json_encode(['success'=>true,'message'=>'Photo added successfully']);
    } else {
        echo json_encode(['success'=>false,'message'=>'Database error: ' . $conn->error]);
    }
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

// default
echo json_encode(['success'=>false,'message'=>'Invalid action']);
?>