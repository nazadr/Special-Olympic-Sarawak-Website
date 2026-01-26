<?php
// Start output buffering and error handling
ob_start();
set_error_handler(function($errno, $errstr, $errfile, $errline) {
    ob_clean();
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'message' => 'PHP Error: ' . $errstr . ' in ' . $errfile . ' on line ' . $errline
    ]);
    exit();
});

session_start();

// Debug mode - match admin panel behavior
$debug_mode = true; // Set to false in production
if ($debug_mode && (!isset($_SESSION['admin_id']) || !isset($_SESSION['user']))) {
    $_SESSION['user'] = 'SO Sarawak Admin';
    $_SESSION['admin_id'] = 1;
}

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "so_sarawak_db";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die(json_encode(['success' => false, 'message' => 'Connection failed: ' . $conn->connect_error]));
}

// Ensure only authenticated users can access (after debug session creation)
if (!isset($_SESSION['admin_id']) && !isset($_SESSION['user'])) {
    echo json_encode(['success' => false, 'message' => 'Unauthorized access']);
    exit();
}

$action = $_GET['action'] ?? $_POST['action'] ?? '';

try {
    switch ($action) {
        case 'fetch':
            fetchDocuments($conn);
            break;
        
        case 'fetchStats':
            fetchDocumentStats($conn);
            break;
        
        case 'download':
            downloadDocument($conn);
            break;
        
        case 'delete':
            deleteDocument($conn);
            break;
        
        default:
            echo json_encode(['success' => false, 'message' => 'Invalid action']);
    }
} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}

// Fetch all document uploads with filters
function fetchDocuments($conn) {    // Check if table exists first
    $checkTable = $conn->query("SHOW TABLES LIKE 'participant_excel_uploads'");
    if ($checkTable->num_rows === 0) {
        echo json_encode([
            'success' => false,
            'message' => 'Database table not found. Please run the SQL setup from admin/db/participants-management-sql.txt',
            'data' => [],
            'total' => 0
        ]);
        return;
    }
        $search = $_GET['search'] ?? '';
    $type = $_GET['type'] ?? '';
    $sortBy = $_GET['sortBy'] ?? 'date-desc';
    $limit = intval($_GET['limit'] ?? 100);
    $offset = intval($_GET['offset'] ?? 0);
    
    $query = "SELECT 
        id,
        participant_type,
        filename,
        original_filename,
        file_path,
        rows_imported,
        rows_updated,
        rows_failed,
        uploaded_by,
        upload_status,
        error_log,
        created_at,
        ROUND(LENGTH(error_log) / 1024, 2) as file_size_kb
    FROM participant_excel_uploads WHERE 1=1";
    
    $params = [];
    $types = "";
    
    // Filter by type
    if (!empty($type) && $type !== 'all') {
        $query .= " AND participant_type = ?";
        $params[] = $type;
        $types .= "s";
    }
    
    // Search filter
    if (!empty($search)) {
        $query .= " AND (original_filename LIKE ? OR filename LIKE ?)";
        $searchTerm = "%$search%";
        $params[] = $searchTerm;
        $params[] = $searchTerm;
        $types .= "ss";
    }
    
    // Sorting
    switch ($sortBy) {
        case 'date-asc':
            $query .= " ORDER BY created_at ASC";
            break;
        case 'name-asc':
            $query .= " ORDER BY original_filename ASC";
            break;
        case 'name-desc':
            $query .= " ORDER BY original_filename DESC";
            break;
        case 'size-desc':
            $query .= " ORDER BY LENGTH(error_log) DESC";
            break;
        case 'size-asc':
            $query .= " ORDER BY LENGTH(error_log) ASC";
            break;
        default: // date-desc
            $query .= " ORDER BY created_at DESC";
    }
    
    // Count total
    $countQuery = str_replace("SELECT id, participant_type, filename, original_filename, file_path, rows_imported, rows_updated, rows_failed, uploaded_by, upload_status, error_log, created_at, ROUND(LENGTH(error_log) / 1024, 2) as file_size_kb", "SELECT COUNT(*) as total", $query);
    $countQuery = preg_replace('/ ORDER BY .*/', '', $countQuery);
    
    if (!empty($params)) {
        $countStmt = $conn->prepare($countQuery);
        $countStmt->bind_param($types, ...$params);
        $countStmt->execute();
        $countResult = $countStmt->get_result()->fetch_assoc();
        $total = ($countResult && isset($countResult['total'])) ? intval($countResult['total']) : 0;
    } else {
        $countResult = $conn->query($countQuery);
        if ($countResult) {
            $countRow = $countResult->fetch_assoc();
            $total = ($countRow && isset($countRow['total'])) ? intval($countRow['total']) : 0;
        } else {
            $total = 0;
        }
    }
    
    // Pagination
    $query .= " LIMIT ? OFFSET ?";
    $params[] = $limit;
    $params[] = $offset;
    $types .= "ii";
    
    // Execute main query
    if (!empty($params)) {
        $stmt = $conn->prepare($query);
        $stmt->bind_param($types, ...$params);
        $stmt->execute();
        $result = $stmt->get_result();
    } else {
        $result = $conn->query($query);
    }
    
    $documents = [];
    while ($row = $result->fetch_assoc()) {
        $documents[] = $row;
    }
    
    echo json_encode([
        'success' => true,
        'data' => $documents,
        'total' => $total,
        'limit' => $limit,
        'offset' => $offset
    ]);
}

// Fetch document statistics
function fetchDocumentStats($conn) {
    // Check if table exists first
    $checkTable = $conn->query("SHOW TABLES LIKE 'participant_excel_uploads'");
    if ($checkTable->num_rows === 0) {
        echo json_encode([
            'success' => true,
            'stats' => [
                'total' => 0,
                'athletes' => 0,
                'coaches' => 0,
                'volunteers' => 0,
                'recent' => 0,
                'success_rate' => 0
            ]
        ]);
        return;
    }
    
    // Total uploads
    $totalQuery = "SELECT COUNT(*) as total FROM participant_excel_uploads";
    $total = $conn->query($totalQuery)->fetch_assoc()['total'];
    
    // By type
    $typeQuery = "SELECT 
        participant_type,
        COUNT(*) as count,
        SUM(rows_imported) as total_imported,
        SUM(rows_updated) as total_updated,
        SUM(rows_failed) as total_failed
    FROM participant_excel_uploads 
    GROUP BY participant_type";
    
    $typeResult = $conn->query($typeQuery);
    $byType = [
        'athlete' => 0,
        'coach' => 0,
        'volunteer' => 0
    ];
    
    while ($row = $typeResult->fetch_assoc()) {
        $byType[$row['participant_type']] = $row['count'];
    }
    
    // Recent uploads (last 7 days)
    $recentQuery = "SELECT COUNT(*) as recent 
                    FROM participant_excel_uploads 
                    WHERE created_at >= DATE_SUB(NOW(), INTERVAL 7 DAY)";
    $recent = $conn->query($recentQuery)->fetch_assoc()['recent'];
    
    // Success rate
    $successQuery = "SELECT 
        SUM(CASE WHEN upload_status = 'success' THEN 1 ELSE 0 END) as successful,
        COUNT(*) as total
    FROM participant_excel_uploads";
    
    $successData = $conn->query($successQuery)->fetch_assoc();
    $successRate = $successData['total'] > 0 ? round(($successData['successful'] / $successData['total']) * 100) : 0;
    
    echo json_encode([
        'success' => true,
        'stats' => [
            'total' => $total,
            'athletes' => $byType['athlete'],
            'coaches' => $byType['coach'],
            'volunteers' => $byType['volunteer'],
            'recent' => $recent,
            'success_rate' => $successRate
        ]
    ]);
}

// Download document
function downloadDocument($conn) {
    $id = $_GET['id'] ?? 0;
    
    $query = "SELECT file_path, original_filename FROM participant_excel_uploads WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('i', $id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows === 0) {
        echo json_encode(['success' => false, 'message' => 'Document not found']);
        return;
    }
    
    $doc = $result->fetch_assoc();
    $filePath = '../../' . $doc['file_path'];
    
    if (!file_exists($filePath)) {
        echo json_encode(['success' => false, 'message' => 'File not found on server']);
        return;
    }
    
    // Set headers for download
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment; filename="' . $doc['original_filename'] . '"');
    header('Content-Length: ' . filesize($filePath));
    
    readfile($filePath);
    exit();
}

// Delete document
function deleteDocument($conn) {
    $id = $_POST['id'] ?? 0;
    
    if (empty($id)) {
        echo json_encode(['success' => false, 'message' => 'Document ID required']);
        return;
    }
    
    // Get file path first
    $query = "SELECT file_path FROM participant_excel_uploads WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('i', $id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows === 0) {
        echo json_encode(['success' => false, 'message' => 'Document not found']);
        return;
    }
    
    $doc = $result->fetch_assoc();
    $filePath = '../../' . $doc['file_path'];
    
    // Delete from database
    $deleteQuery = "DELETE FROM participant_excel_uploads WHERE id = ?";
    $deleteStmt = $conn->prepare($deleteQuery);
    $deleteStmt->bind_param('i', $id);
    
    if ($deleteStmt->execute()) {
        // Try to delete file from filesystem
        if (file_exists($filePath)) {
            @unlink($filePath);
        }
        
        echo json_encode([
            'success' => true,
            'message' => 'Document deleted successfully'
        ]);
    } else {
        echo json_encode([
            'success' => false,
            'message' => 'Failed to delete document: ' . $deleteStmt->error
        ]);
    }
}

$conn->close();
?>