<?php
// Contains Photos gallery handler

// Database connection details
$servername = "localhost"; // Your database host
$username = "root"; // Your database username
$password = ""; // Your database password
$dbname = "so_sarawak_db"; // The database name you will create

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die(json_encode(['success' => false, 'message' => 'Connection failed: ' . $conn->connect_error]));
}

$videoDir = '../../assets/videos/gallery_videos_upload/';
$coverDir = '../../assets/videos/gallery_videos_upload/covers/';
if (!is_dir($videoDir)) mkdir($videoDir,0777,true);
if (!is_dir($coverDir)) mkdir($coverDir,0777,true);

// Physical upload directory (relative to this handler file)
$uploadDirPhysical = '../../assets/images/gallery_photos_upload/';
if (!is_dir($uploadDirPhysical)) mkdir($uploadDirPhysical, 0777, true);

// Web path (what gets stored in DB and used in HTML)
$uploadDirWeb = '../assets/images/gallery_photos_upload/';

$action = $_REQUEST['action'] ?? '';

function safeName($n){ return preg_replace('/[^A-Za-z0-9._-]/','_', $n); }

if ($action==='fetch_collections'){
    $res = $conn->query("SELECT id,name,description FROM gallery_videos_collection ORDER BY display_order ASC, name ASC");
    echo json_encode(['success'=>true,'collections'=>$res->fetch_all(MYSQLI_ASSOC)]); exit;
}

if ($action==='add_collection'){
    $name = trim($_POST['name'] ?? '');
    $desc = trim($_POST['description'] ?? '');
    if ($name===''){ echo json_encode(['success'=>false,'message'=>'Name required']); exit; }
    $stmt=$conn->prepare("INSERT INTO gallery_videos_collection (name,description) VALUES (?,?)");
    $stmt->bind_param('ss',$name,$desc);
    if ($stmt->execute()) echo json_encode(['success'=>true,'id'=>$stmt->insert_id]); else echo json_encode(['success'=>false,'message'=>'Insert fail']);
    exit;
}

if ($action==='fetch_items'){
    $cid = (int)($_GET['collection_id'] ?? 0);
    $stmt=$conn->prepare("SELECT id,video_path,cover_path,title,description FROM gallery_videos WHERE collection_id=? ORDER BY display_order ASC, id ASC");
    $stmt->bind_param('i',$cid); $stmt->execute();
    $res=$stmt->get_result();
    echo json_encode(['success'=>true,'videos'=>$res->fetch_all(MYSQLI_ASSOC)]); exit;
}

if ($action==='add_video'){
    $existing = trim($_POST['galleryVideoAlbum'] ?? '');
    $newName = trim($_POST['galleryVideoAddAlbum'] ?? '');
    $newDesc = trim($_POST['galleryVideoAlbumDesc'] ?? '');
    $title = trim($_POST['galleryVideoTitle'] ?? '');
    $description = trim($_POST['galleryVideoDesc'] ?? '');
    if ($title===''){ echo json_encode(['success'=>false,'message'=>'Title required']); exit; }

    $cid=0;
    if ($newName!==''){
        $stmt=$conn->prepare("INSERT INTO gallery_videos_collection (name,description) VALUES (?,?) ON DUPLICATE KEY UPDATE name=name");
        $stmt->bind_param('ss',$newName,$newDesc); $stmt->execute();
        if ($stmt->insert_id) $cid=$stmt->insert_id;
        else {
            $q=$conn->prepare("SELECT id FROM gallery_videos_collection WHERE name=?");
            $q->bind_param('s',$newName); $q->execute(); $cid=$q->get_result()->fetch_assoc()['id'] ?? 0;
        }
    } elseif ($existing!==''){
        $q=$conn->prepare("SELECT id FROM gallery_videos_collection WHERE name=?");
        $q->bind_param('s',$existing); $q->execute(); $cid=$q->get_result()->fetch_assoc()['id'] ?? 0;
    }
    if ($cid===0){ echo json_encode(['success'=>false,'message'=>'Collection missing']); exit; }

    if (!isset($_FILES['galleryVideo']) || $_FILES['galleryVideo']['error']!==UPLOAD_ERR_OK){
        echo json_encode(['success'=>false,'message'=>'Video required']); exit;
    }
    if (!isset($_FILES['galleryVideoImage']) || $_FILES['galleryVideoImage']['error']!==UPLOAD_ERR_OK){
        echo json_encode(['success'=>false,'message'=>'Cover required']); exit;
    }

    $vOrig = safeName($_FILES['galleryVideo']['name']);
    $vFilename = time().'_'.$vOrig;
    $vPathPhysical = $videoDir . $vFilename;
    $vPathWeb = '../assets/videos/gallery_videos_upload/' . $vFilename;
    if (!move_uploaded_file($_FILES['galleryVideo']['tmp_name'],$vPathPhysical)){
        echo json_encode(['success'=>false,'message'=>'Video upload fail']); exit;
    }

    $cOrig = safeName($_FILES['galleryVideoImage']['name']);
    $cFilename = time().'_'.$cOrig;
    $cPathPhysical = $coverDir . $cFilename;
    $cPathWeb = '../assets/videos/gallery_videos_upload/covers/' . $cFilename;
    if (!move_uploaded_file($_FILES['galleryVideoImage']['tmp_name'],$cPathPhysical)){
        @unlink($vPathPhysical);
        echo json_encode(['success'=>false,'message'=>'Cover upload fail']); exit;
    }

    $stmt=$conn->prepare("INSERT INTO gallery_videos (collection_id,video_path,cover_path,title,description) VALUES (?,?,?,?,?)");
    $stmt->bind_param('issss',$cid,$vPathWeb,$cPathWeb,$title,$description);
    if ($stmt->execute()) echo json_encode(['success'=>true,'message'=>'Video added']); else echo json_encode(['success'=>false,'message'=>'DB fail']);
    exit;
}

if ($action==='delete_video'){
    $id=(int)($_POST['id'] ?? 0);
    $stmt=$conn->prepare("SELECT video_path,cover_path FROM gallery_videos WHERE id=?");
    $stmt->bind_param('i',$id); $stmt->execute(); $r=$stmt->get_result()->fetch_assoc();
    if (!$r){ echo json_encode(['success'=>false,'message'=>'Not found']); exit; }
    // Convert web paths back to physical paths for deletion
    $vPhysical = str_replace('../assets/videos/gallery_videos_upload/', $videoDir, $r['video_path']);
    $cPhysical = str_replace('../assets/videos/gallery_videos_upload/covers/', $coverDir, $r['cover_path']);
    @unlink($vPhysical); @unlink($cPhysical);
    $d=$conn->prepare("DELETE FROM gallery_videos WHERE id=?");
    $d->bind_param('i',$id); $d->execute();
    echo json_encode(['success'=>true]); exit;
}

if ($action==='delete_collection'){
    $cid=(int)($_POST['id'] ?? 0);
    $stmt=$conn->prepare("SELECT video_path,cover_path FROM gallery_videos WHERE collection_id=?");
    $stmt->bind_param('i',$cid); $stmt->execute(); $res=$stmt->get_result();
    while($row=$res->fetch_assoc()){ 
        // Convert web paths back to physical paths for deletion
        $vPhysical = str_replace('../assets/videos/gallery_videos_upload/', $videoDir, $row['video_path']);
        $cPhysical = str_replace('../assets/videos/gallery_videos_upload/covers/', $coverDir, $row['cover_path']);
        @unlink($vPhysical); @unlink($cPhysical); 
    }
    $del=$conn->prepare("DELETE FROM gallery_videos_collection WHERE id=?");
    $del->bind_param('i',$cid); $del->execute();
    echo json_encode(['success'=>true]); exit;
}

if ($action==='get_video'){
    $id = (int)($_GET['id'] ?? 0);
    if ($id === 0) {
        echo json_encode(['success'=>false,'message'=>'Invalid video ID']); 
        exit;
    }
    
    $stmt = $conn->prepare("
        SELECT v.id, v.title, v.description, v.video_path, v.cover_path, 
               c.name as collection_name, c.description as collection_description
        FROM gallery_videos v 
        LEFT JOIN gallery_videos_collection c ON v.collection_id = c.id 
        WHERE v.id = ?
    ");
    $stmt->bind_param('i', $id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($row = $result->fetch_assoc()) {
        echo json_encode(['success'=>true,'video'=>$row]); 
    } else {
        echo json_encode(['success'=>false,'message'=>'Video not found']); 
    }
    exit;
}

if ($action==='update_video'){
    $id = (int)($_POST['id'] ?? 0);
    $title = trim($_POST['title'] ?? '');
    $description = trim($_POST['description'] ?? '');
    
    if ($id === 0) {
        echo json_encode(['success'=>false,'message'=>'Invalid video ID']); 
        exit;
    }
    
    if ($title === '') {
        echo json_encode(['success'=>false,'message'=>'Title required']); 
        exit;
    }
    
    $stmt = $conn->prepare("UPDATE gallery_videos SET title=?, description=? WHERE id=?");
    $stmt->bind_param('ssi', $title, $description, $id);
    
    if ($stmt->execute()) {
        echo json_encode(['success'=>true,'message'=>'Video updated successfully']); 
    } else {
        echo json_encode(['success'=>false,'message'=>'Update failed']); 
    }
    exit;
}

if ($action==='update_collection'){
    $id = (int)($_POST['id'] ?? 0);
    $name = trim($_POST['name'] ?? '');
    $description = trim($_POST['description'] ?? '');
    
    // Debug info
    $debug = [
        'received_id' => $id,
        'received_name' => $name,
        'received_description' => $description,
        'videos_received' => isset($_FILES['videos']) ? 'yes' : 'no'
    ];
    
    if ($id === 0) {
        echo json_encode(['success'=>false,'message'=>'Invalid collection ID', 'debug' => $debug]); 
        exit;
    }
    
    if ($name === '') {
        echo json_encode(['success'=>false,'message'=>'Name required', 'debug' => $debug]); 
        exit;
    }
    
    // Handle multiple video uploads
    $uploadedVideos = [];
    $uploadErrors = [];
    
    if (isset($_FILES['videos']) && !empty($_FILES['videos']['name'][0])) {
        // Use the existing video directory
        $uploadDir = $videoDir; // ../../assets/videos/gallery_videos_upload/
        
        // Create directory if it doesn't exist
        if (!is_dir($uploadDir)) {
            if (!mkdir($uploadDir, 0777, true)) {
                $uploadErrors[] = 'Failed to create upload directory';
            }
        }
        
        // Check if directory is writable
        if (!is_writable($uploadDir)) {
            $uploadErrors[] = 'Upload directory is not writable: ' . $uploadDir;
        }
        
        $fileCount = count($_FILES['videos']['name']);
        $debug['file_count'] = $fileCount;
        
        for ($i = 0; $i < $fileCount; $i++) {
            $debug['file_' . $i . '_error'] = $_FILES['videos']['error'][$i];
            $debug['file_' . $i . '_name'] = $_FILES['videos']['name'][$i];
            $debug['file_' . $i . '_size'] = $_FILES['videos']['size'][$i];
            
            if ($_FILES['videos']['error'][$i] === UPLOAD_ERR_OK) {
                $tmpName = $_FILES['videos']['tmp_name'][$i];
                $originalName = $_FILES['videos']['name'][$i];
                $extension = strtolower(pathinfo($originalName, PATHINFO_EXTENSION));
                
                // Validate video type
                $allowedTypes = ['mp4', 'webm', 'mov', 'avi', 'mkv', 'wmv'];
                if (!in_array($extension, $allowedTypes)) {
                    $uploadErrors[] = "File $originalName has invalid type: $extension";
                    continue;
                }
                
                // Generate unique filename
                $newFilename = 'video_' . $id . '_' . time() . '_' . $i . '.' . $extension;
                $targetPath = $uploadDir . $newFilename;
                
                if (move_uploaded_file($tmpName, $targetPath)) {
                    // Web path for storing in DB
                    $webPath = '../assets/videos/gallery_videos_upload/' . $newFilename;
                    $uploadedVideos[] = $webPath;
                    
                    // Also insert into gallery_videos table
                    $videoTitle = pathinfo($originalName, PATHINFO_FILENAME);
                    $stmt2 = $conn->prepare("INSERT INTO gallery_videos (collection_id, video_path, title) VALUES (?, ?, ?)");
                    $stmt2->bind_param('iss', $id, $webPath, $videoTitle);
                    $stmt2->execute();
                    
                } else {
                    $uploadErrors[] = "Failed to move file: $originalName";
                }
            } else {
                $errorMessages = [
                    UPLOAD_ERR_INI_SIZE => 'File exceeds upload_max_filesize',
                    UPLOAD_ERR_FORM_SIZE => 'File exceeds MAX_FILE_SIZE',
                    UPLOAD_ERR_PARTIAL => 'File was only partially uploaded',
                    UPLOAD_ERR_NO_FILE => 'No file was uploaded',
                    UPLOAD_ERR_NO_TMP_DIR => 'Missing temporary folder',
                    UPLOAD_ERR_CANT_WRITE => 'Failed to write file to disk',
                    UPLOAD_ERR_EXTENSION => 'Upload stopped by PHP extension'
                ];
                $errorCode = $_FILES['videos']['error'][$i];
                $errorMsg = $errorMessages[$errorCode] ?? "Unknown error ($errorCode)";
                $uploadErrors[] = "Upload error for {$_FILES['videos']['name'][$i]}: $errorMsg";
            }
        }
    }
    
    // Update collection info
    $stmt = $conn->prepare("UPDATE gallery_videos_collection SET name=?, description=? WHERE id=?");
    $stmt->bind_param('ssi', $name, $description, $id);
    
    if ($stmt->execute()) {
        $response = [
            'success' => true,
            'message' => 'Collection updated successfully'
        ];
        
        if (!empty($uploadedVideos)) {
            $response['uploaded_videos'] = $uploadedVideos;
            $response['message'] .= '. ' . count($uploadedVideos) . ' video(s) uploaded.';
        }
        
        if (!empty($uploadErrors)) {
            $response['upload_errors'] = $uploadErrors;
        }
        
        // Include debug info in development
        $response['debug'] = $debug;
        
        echo json_encode($response); 
    } else {
        echo json_encode(['success'=>false,'message'=>'Database update failed: ' . $conn->error, 'debug' => $debug]); 
    }
    exit;
}

// Upload video thumbnail/cover
if ($action==='upload_video_thumbnail'){
    $videoId = (int)($_POST['video_id'] ?? 0);
    
    if ($videoId === 0) {
        echo json_encode(['success'=>false,'message'=>'Invalid video ID']); 
        exit;
    }
    
    if (!isset($_FILES['thumbnail']) || $_FILES['thumbnail']['error'] !== UPLOAD_ERR_OK) {
        echo json_encode(['success'=>false,'message'=>'No thumbnail file uploaded']); 
        exit;
    }
    
    $file = $_FILES['thumbnail'];
    $allowedTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif', 'image/webp'];
    
    if (!in_array($file['type'], $allowedTypes)) {
        echo json_encode(['success'=>false,'message'=>'Invalid file type. Only JPEG, PNG, GIF, and WebP are allowed']); 
        exit;
    }
    
    // Generate safe filename
    $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
    $newName = 'video_' . $videoId . '_thumb_' . time() . '.' . $ext;
    $targetPath = $coverDir . $newName;
    
    if (!move_uploaded_file($file['tmp_name'], $targetPath)) {
        echo json_encode(['success'=>false,'message'=>'Failed to save thumbnail file']); 
        exit;
    }
    
    // Web path for database (relative to web root)
    $webPath = 'assets/videos/gallery_videos_upload/covers/' . $newName;
    
    // Delete old thumbnail if exists
    $oldCover = $conn->query("SELECT cover_path FROM gallery_videos WHERE id=$videoId")->fetch_assoc()['cover_path'] ?? '';
    if ($oldCover && file_exists('../../' . $oldCover)) {
        @unlink('../../' . $oldCover);
    }
    
    // Update database
    $stmt = $conn->prepare("UPDATE gallery_videos SET cover_path=? WHERE id=?");
    $stmt->bind_param('si', $webPath, $videoId);
    
    if ($stmt->execute()) {
        echo json_encode(['success'=>true,'message'=>'Thumbnail saved successfully','cover_path'=>$webPath]); 
    } else {
        // If DB update fails, delete uploaded file
        @unlink($targetPath);
        echo json_encode(['success'=>false,'message'=>'Failed to update database']); 
    }
    exit;
}

// Remove video thumbnail/cover
if ($action==='remove_video_thumbnail'){
    $videoId = (int)($_POST['video_id'] ?? 0);
    
    if ($videoId === 0) {
        echo json_encode(['success'=>false,'message'=>'Invalid video ID']); 
        exit;
    }
    
    // Get current cover path
    $result = $conn->query("SELECT cover_path FROM gallery_videos WHERE id=$videoId");
    if ($result && $row = $result->fetch_assoc()) {
        $coverPath = $row['cover_path'];
        
        // Delete physical file if exists
        if ($coverPath && file_exists('../../' . $coverPath)) {
            @unlink('../../' . $coverPath);
        }
        
        // Clear from database
        $stmt = $conn->prepare("UPDATE gallery_videos SET cover_path='' WHERE id=?");
        $stmt->bind_param('i', $videoId);
        
        if ($stmt->execute()) {
            echo json_encode(['success'=>true,'message'=>'Thumbnail removed successfully']); 
        } else {
            echo json_encode(['success'=>false,'message'=>'Failed to update database']); 
        }
    } else {
        echo json_encode(['success'=>false,'message'=>'Video not found']); 
    }
    exit;
}

// Update video order within a collection (drag-and-drop)
if ($action === 'update_video_order') {
    $json = file_get_contents('php://input');
    $data = json_decode($json, true);
    
    if (!isset($data['collection_id']) || !isset($data['order'])) {
        echo json_encode(['success' => false, 'message' => 'Missing parameters']);
        exit;
    }
    
    $collectionId = (int)$data['collection_id'];
    $order = $data['order'];
    
    $conn->begin_transaction();
    try {
        $stmt = $conn->prepare("UPDATE gallery_videos SET display_order = ? WHERE id = ? AND collection_id = ?");
        foreach ($order as $item) {
            $videoId = (int)$item['id'];
            $displayOrder = (int)$item['order'];
            $stmt->bind_param('iii', $displayOrder, $videoId, $collectionId);
            $stmt->execute();
        }
        $conn->commit();
        echo json_encode(['success' => true, 'message' => 'Video order updated']);
    } catch (Exception $e) {
        $conn->rollback();
        echo json_encode(['success' => false, 'message' => 'Failed to update order: ' . $e->getMessage()]);
    }
    exit;
}

// Update collection order (drag-and-drop)
if ($action === 'update_collection_order') {
    $json = file_get_contents('php://input');
    $data = json_decode($json, true);
    
    if (!isset($data['order'])) {
        echo json_encode(['success' => false, 'message' => 'Missing order data']);
        exit;
    }
    
    $order = $data['order'];
    
    $conn->begin_transaction();
    try {
        $stmt = $conn->prepare("UPDATE gallery_videos_collection SET display_order = ? WHERE id = ?");
        foreach ($order as $item) {
            $collectionId = (int)$item['id'];
            $displayOrder = (int)$item['order'];
            $stmt->bind_param('ii', $displayOrder, $collectionId);
            $stmt->execute();
        }
        $conn->commit();
        echo json_encode(['success' => true, 'message' => 'Collection order updated']);
    } catch (Exception $e) {
        $conn->rollback();
        echo json_encode(['success' => false, 'message' => 'Failed to update order: ' . $e->getMessage()]);
    }
    exit;
}

echo json_encode(['success'=>false,'message'=>'Invalid action']);
?>