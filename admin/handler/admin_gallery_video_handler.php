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
    $res = $conn->query("SELECT id,name,description FROM gallery_videos_collection ORDER BY name ASC");
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
    $stmt=$conn->prepare("SELECT id,video_path,cover_path,title,description FROM gallery_videos WHERE collection_id=? ORDER BY id ASC");
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
    $vPath = $videoDir . time().'_'.$vOrig;
    if (!move_uploaded_file($_FILES['galleryVideo']['tmp_name'],$vPath)){
        echo json_encode(['success'=>false,'message'=>'Video upload fail']); exit;
    }

    $cOrig = safeName($_FILES['galleryVideoImage']['name']);
    $cPath = $coverDir . time().'_'.$cOrig;
    if (!move_uploaded_file($_FILES['galleryVideoImage']['tmp_name'],$cPath)){
        @unlink($vPath);
        echo json_encode(['success'=>false,'message'=>'Cover upload fail']); exit;
    }

    $stmt=$conn->prepare("INSERT INTO gallery_videos (collection_id,video_path,cover_path,title,description) VALUES (?,?,?,?,?)");
    $stmt->bind_param('issss',$cid,$vPath,$cPath,$title,$description);
    if ($stmt->execute()) echo json_encode(['success'=>true,'message'=>'Video added']); else echo json_encode(['success'=>false,'message'=>'DB fail']);
    exit;
}

if ($action==='delete_video'){
    $id=(int)($_POST['id'] ?? 0);
    $stmt=$conn->prepare("SELECT video_path,cover_path FROM gallery_videos WHERE id=?");
    $stmt->bind_param('i',$id); $stmt->execute(); $r=$stmt->get_result()->fetch_assoc();
    if (!$r){ echo json_encode(['success'=>false,'message'=>'Not found']); exit; }
    @unlink($r['video_path']); @unlink($r['cover_path']);
    $d=$conn->prepare("DELETE FROM gallery_videos WHERE id=?");
    $d->bind_param('i',$id); $d->execute();
    echo json_encode(['success'=>true]); exit;
}

if ($action==='delete_collection'){
    $cid=(int)($_POST['id'] ?? 0);
    $stmt=$conn->prepare("SELECT video_path,cover_path FROM gallery_videos WHERE collection_id=?");
    $stmt->bind_param('i',$cid); $stmt->execute(); $res=$stmt->get_result();
    while($row=$res->fetch_assoc()){ @unlink($row['video_path']); @unlink($row['cover_path']); }
    $del=$conn->prepare("DELETE FROM gallery_videos_collection WHERE id=?");
    $del->bind_param('i',$cid); $del->execute();
    echo json_encode(['success'=>true]); exit;
}

echo json_encode(['success'=>false,'message'=>'Invalid action']);
?>