<?php
// Prevent any HTML output
ob_start();
error_reporting(E_ALL);
ini_set('display_errors', 0); // Don't display errors to output

session_start();

// Catch any PHP errors/warnings and convert to JSON
set_error_handler(function($errno, $errstr, $errfile, $errline) {
    ob_clean();
    echo json_encode(['success' => false, 'message' => "PHP Error: $errstr in $errfile on line $errline"]);
    exit();
});

header('Content-Type: application/json');

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

// Ensure only authenticated users can access
if (!isset($_SESSION['admin_id']) && !isset($_SESSION['user'])) {
    echo json_encode(['success' => false, 'message' => 'Unauthorized access']);
    exit();
}

$action = $_GET['action'] ?? $_POST['action'] ?? '';

try {
    switch ($action) {
        case 'fetch':
            fetchCoaches($conn);
            break;
        
        case 'fetchStats':
            fetchCoachesStats($conn);
            break;
        
        case 'upload':
            uploadExcel($conn);
            break;
        
        case 'add':
            addCoach($conn);
            break;
        
        case 'updateStatus':
            updateCoachStatus($conn);
            break;
        
        case 'delete':
            deleteCoach($conn);
            break;
        
        case 'update':
            updateCoach($conn);
            break;
        
        case 'export':
            exportCoaches($conn);
            break;
        
        default:
            echo json_encode(['success' => false, 'message' => 'Invalid action']);
    }
} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}

function fetchCoaches($conn) {
    $search = $_GET['search'] ?? '';
    $status = $_GET['status'] ?? '';
    $chapter = $_GET['chapter'] ?? '';
    $limit = intval($_GET['limit'] ?? 50);
    $offset = intval($_GET['offset'] ?? 0);
    
    $query = "SELECT * FROM coaches WHERE 1=1";
    $params = [];
    $types = "";
    
    if (!empty($search)) {
        $query .= " AND (full_name LIKE ? OR email LIKE ? OR phone LIKE ?)";
        $searchParam = "%$search%";
        $params[] = $searchParam;
        $params[] = $searchParam;
        $params[] = $searchParam;
        $types .= "sss";
    }
    
    if (!empty($status)) {
        $query .= " AND status = ?";
        $params[] = $status;
        $types .= "s";
    }
    
    if (!empty($chapter)) {
        $query .= " AND chapter = ?";
        $params[] = $chapter;
        $types .= "s";
    }
    
    $query .= " ORDER BY created_at DESC LIMIT ? OFFSET ?";
    $params[] = $limit;
    $params[] = $offset;
    $types .= "ii";
    
    $stmt = $conn->prepare($query);
    if (!empty($params)) {
        $stmt->bind_param($types, ...$params);
    }
    $stmt->execute();
    $result = $stmt->get_result();
    
    $coaches = [];
    while ($row = $result->fetch_assoc()) {
        $coaches[] = $row;
    }
    
    $countQuery = "SELECT COUNT(*) as total FROM coaches WHERE 1=1";
    if (!empty($search)) {
        $countQuery .= " AND (full_name LIKE '%$search%' OR email LIKE '%$search%' OR phone LIKE '%$search%')";
    }
    if (!empty($status)) {
        $countQuery .= " AND status = '$status'";
    }
    if (!empty($chapter)) {
        $countQuery .= " AND chapter = '$chapter'";
    }
    
    $countResult = $conn->query($countQuery);
    $totalCount = $countResult->fetch_assoc()['total'];
    
    echo json_encode([
        'success' => true,
        'data' => $coaches,
        'total' => $totalCount,
        'limit' => $limit,
        'offset' => $offset
    ]);
}

function fetchCoachesStats($conn) {
    $statsQuery = "SELECT 
        COUNT(*) as total,
        SUM(CASE WHEN status = 'approved' THEN 1 ELSE 0 END) as approved,
        SUM(CASE WHEN status = 'pending' THEN 1 ELSE 0 END) as pending,
        SUM(CASE WHEN status = 'rejected' THEN 1 ELSE 0 END) as rejected,
        SUM(CASE WHEN status = 'archived' THEN 1 ELSE 0 END) as archived,
        SUM(CASE WHEN gender = 'Male' THEN 1 ELSE 0 END) as male,
        SUM(CASE WHEN gender = 'Female' THEN 1 ELSE 0 END) as female,
        AVG(experience_years) as avg_experience
    FROM coaches";
    
    $statsResult = $conn->query($statsQuery);
    $stats = $statsResult->fetch_assoc();
    
    $chapterQuery = "SELECT chapter, COUNT(*) as count 
                     FROM coaches 
                     WHERE status = 'approved' AND chapter IS NOT NULL
                     GROUP BY chapter 
                     ORDER BY count DESC";
    $chapterResult = $conn->query($chapterQuery);
    $chapters = [];
    while ($row = $chapterResult->fetch_assoc()) {
        $chapters[] = $row;
    }
    
    $recentQuery = "SELECT COUNT(*) as recent_count 
                    FROM coaches 
                    WHERE created_at >= DATE_SUB(NOW(), INTERVAL 7 DAY)";
    $recentResult = $conn->query($recentQuery);
    $recentCount = $recentResult->fetch_assoc()['recent_count'];
    
    $uploadQuery = "SELECT * FROM participant_excel_uploads 
                    WHERE participant_type = 'coach' 
                    ORDER BY created_at DESC LIMIT 1";
    $uploadResult = $conn->query($uploadQuery);
    $lastUpload = $uploadResult->fetch_assoc();
    
    echo json_encode([
        'success' => true,
        'stats' => $stats,
        'chapters' => $chapters,
        'recent_count' => $recentCount,
        'last_upload' => $lastUpload
    ]);
}

// Add a single coach
function addCoach($conn) {
    // Get form data
    $full_name = $_POST['full_name'] ?? '';
    $email = $_POST['email'] ?? '';
    $phone = $_POST['phone'] ?? '';
    $date_of_birth = $_POST['date_of_birth'] ?? null;
    $gender = $_POST['gender'] ?? '';
    $chapter = $_POST['chapter'] ?? '';
    $sports_expertise = $_POST['sports_expertise'] ?? '';
    $experience_years = $_POST['experience_years'] ?? null;
    $certifications = $_POST['certifications'] ?? '';
    $availability = $_POST['availability'] ?? '';
    $emergency_contact_name = $_POST['emergency_contact_name'] ?? '';
    $emergency_contact_phone = $_POST['emergency_contact_phone'] ?? '';
    
    // Validation
    if (empty($full_name)) {
        echo json_encode(['success' => false, 'message' => 'Full name is required']);
        return;
    }
    
    // Check for duplicate email
    if (!empty($email)) {
        $checkQuery = "SELECT id FROM coaches WHERE email = ?";
        $checkStmt = $conn->prepare($checkQuery);
        $checkStmt->bind_param('s', $email);
        $checkStmt->execute();
        $checkResult = $checkStmt->get_result();
        
        if ($checkResult->num_rows > 0) {
            echo json_encode(['success' => false, 'message' => 'A coach with this email already exists']);
            return;
        }
    }
    
    // Insert into database
    $query = "INSERT INTO coaches (
        full_name, email, phone, date_of_birth, gender, chapter,
        sports_expertise, experience_years, certifications, availability, emergency_contact_name, emergency_contact_phone,
        status, created_at
    ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 'active', NOW())";
    
    $stmt = $conn->prepare($query);
    $stmt->bind_param(
        'sssssssissss',
        $full_name, $email, $phone, $date_of_birth, $gender, $chapter,
        $sports_expertise, $experience_years, $certifications, $availability, $emergency_contact_name, $emergency_contact_phone
    );
    
    if ($stmt->execute()) {
        echo json_encode([
            'success' => true,
            'message' => 'Coach added successfully',
            'coach_id' => $conn->insert_id
        ]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to add coach: ' . $stmt->error]);
    }
}

function uploadExcel($conn) {
    if (!isset($_FILES['excelFile'])) {
        echo json_encode(['success' => false, 'message' => 'No file uploaded']);
        return;
    }
    
    $file = $_FILES['excelFile'];
    $allowedExtensions = ['xls', 'xlsx', 'csv'];
    $fileExtension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
    
    if (!in_array($fileExtension, $allowedExtensions)) {
        echo json_encode(['success' => false, 'message' => 'Invalid file type. Only Excel files allowed.']);
        return;
    }
    
    $uploadDir = '../../uploads/participants/coaches/';
    if (!file_exists($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }
    
    $filename = 'coaches_' . date('Ymd_His') . '.' . $fileExtension;
    $filepath = $uploadDir . $filename;
    
    if (!move_uploaded_file($file['tmp_name'], $filepath)) {
        echo json_encode(['success' => false, 'message' => 'Failed to upload file']);
        return;
    }
    
    require_once '../../vendor/autoload.php';
    
    try {
        $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($filepath);
        $worksheet = $spreadsheet->getActiveSheet();
        $rows = $worksheet->toArray();
        
        $headers = array_shift($rows);
        
        $imported = 0;
        $updated = 0;
        $failed = 0;
        $errors = [];
        
        foreach ($rows as $index => $row) {
            if (empty($row[0])) continue;
            
            $data = [
                'excel_row_id' => $index + 2,
                'full_name' => $row[0] ?? '',
                'email' => $row[1] ?? null,
                'phone' => $row[2] ?? null,
                'date_of_birth' => !empty($row[3]) ? date('Y-m-d', strtotime($row[3])) : null,
                'gender' => $row[4] ?? null,
                'chapter' => $row[5] ?? null,
                'sports_expertise' => $row[6] ?? null,
                'experience_years' => !empty($row[7]) ? intval($row[7]) : null,
                'certifications' => $row[8] ?? null,
                'availability' => $row[9] ?? null,
                'emergency_contact_name' => $row[10] ?? null,
                'emergency_contact_phone' => $row[11] ?? null,
                'registration_date' => !empty($row[12]) ? date('Y-m-d H:i:s', strtotime($row[12])) : date('Y-m-d H:i:s'),
                'excel_filename' => $filename
            ];
            
            $checkQuery = "SELECT id FROM coaches WHERE email = ? OR (full_name = ? AND phone = ?)";
            $checkStmt = $conn->prepare($checkQuery);
            $checkStmt->bind_param("sss", $data['email'], $data['full_name'], $data['phone']);
            $checkStmt->execute();
            $existingResult = $checkStmt->get_result();
            
            if ($existingResult->num_rows > 0) {
                $existingId = $existingResult->fetch_assoc()['id'];
                $updateQuery = "UPDATE coaches SET 
                                full_name = ?, email = ?, phone = ?, date_of_birth = ?,
                                gender = ?, chapter = ?, sports_expertise = ?,
                                experience_years = ?, certifications = ?, availability = ?,
                                emergency_contact_name = ?, emergency_contact_phone = ?,
                                registration_date = ?, excel_filename = ?, updated_at = NOW()
                                WHERE id = ?";
                $updateStmt = $conn->prepare($updateQuery);
                $updateStmt->bind_param("ssssssisssssssi",
                    $data['full_name'], $data['email'], $data['phone'], $data['date_of_birth'],
                    $data['gender'], $data['chapter'], $data['sports_expertise'],
                    $data['experience_years'], $data['certifications'], $data['availability'],
                    $data['emergency_contact_name'], $data['emergency_contact_phone'],
                    $data['registration_date'], $data['excel_filename'], $existingId
                );
                
                if ($updateStmt->execute()) {
                    $updated++;
                } else {
                    $failed++;
                    $errors[] = "Row " . ($index + 2) . ": " . $updateStmt->error;
                }
            } else {
                $insertQuery = "INSERT INTO coaches 
                                (excel_row_id, full_name, email, phone, date_of_birth, gender,
                                 chapter, sports_expertise, experience_years, certifications,
                                 availability, emergency_contact_name, emergency_contact_phone,
                                 registration_date, excel_filename)
                                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
                $insertStmt = $conn->prepare($insertQuery);
                $insertStmt->bind_param("issssssisssssss",
                    $data['excel_row_id'], $data['full_name'], $data['email'], $data['phone'],
                    $data['date_of_birth'], $data['gender'], $data['chapter'],
                    $data['sports_expertise'], $data['experience_years'], $data['certifications'],
                    $data['availability'], $data['emergency_contact_name'],
                    $data['emergency_contact_phone'], $data['registration_date'], $data['excel_filename']
                );
                
                if ($insertStmt->execute()) {
                    $imported++;
                } else {
                    $failed++;
                    $errors[] = "Row " . ($index + 2) . ": " . $insertStmt->error;
                }
            }
        }
        
        $uploadStatus = $failed > 0 ? 'partial' : 'success';
        $errorLog = !empty($errors) ? implode("\n", $errors) : null;
        
        $logQuery = "INSERT INTO participant_excel_uploads 
                     (participant_type, filename, original_filename, file_path,
                      rows_imported, rows_updated, rows_failed, uploaded_by,
                      upload_status, error_log)
                     VALUES ('coach', ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $logStmt = $conn->prepare($logQuery);
        $adminId = $_SESSION['admin_id'] ?? null;
        $logStmt->bind_param("sssiiisss",
            $filename, $file['name'], $filepath, $imported, $updated, $failed,
            $adminId, $uploadStatus, $errorLog
        );
        $logStmt->execute();
        
        echo json_encode([
            'success' => true,
            'message' => "Upload completed successfully",
            'imported' => $imported,
            'updated' => $updated,
            'failed' => $failed,
            'errors' => $errors
        ]);
        
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'message' => 'Error processing Excel: ' . $e->getMessage()]);
    }
}

function updateCoachStatus($conn) {
    $id = intval($_POST['id'] ?? 0);
    $status = $_POST['status'] ?? '';
    
    if ($id <= 0 || empty($status)) {
        echo json_encode(['success' => false, 'message' => 'Invalid parameters']);
        return;
    }
    
    $query = "UPDATE coaches SET status = ?, updated_at = NOW() WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("si", $status, $id);
    
    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'message' => 'Status updated successfully']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to update status']);
    }
}

function deleteCoach($conn) {
    $id = intval($_POST['id'] ?? 0);
    
    if ($id <= 0) {
        echo json_encode(['success' => false, 'message' => 'Invalid ID']);
        return;
    }
    
    $query = "DELETE FROM coaches WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $id);
    
    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'message' => 'Coach deleted successfully']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to delete coach']);
    }
}

function updateCoach($conn) {
    $id = intval($_POST['id'] ?? 0);
    
    if ($id <= 0) {
        echo json_encode(['success' => false, 'message' => 'Invalid ID']);
        return;
    }
    
    $query = "UPDATE coaches SET 
              full_name = ?, email = ?, phone = ?, date_of_birth = ?,
              gender = ?, chapter = ?, sports_expertise = ?,
              experience_years = ?, certifications = ?, availability = ?,
              emergency_contact_name = ?, emergency_contact_phone = ?,
              notes = ?, updated_at = NOW()
              WHERE id = ?";
    
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ssssssissssssi",
        $_POST['full_name'], $_POST['email'], $_POST['phone'], $_POST['date_of_birth'],
        $_POST['gender'], $_POST['chapter'], $_POST['sports_expertise'],
        $_POST['experience_years'], $_POST['certifications'], $_POST['availability'],
        $_POST['emergency_contact_name'], $_POST['emergency_contact_phone'],
        $_POST['notes'], $id
    );
    
    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'message' => 'Coach updated successfully']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to update coach']);
    }
}

function exportCoaches($conn) {
    $query = "SELECT * FROM coaches ORDER BY created_at DESC";
    $result = $conn->query($query);
    
    header('Content-Type: text/csv');
    header('Content-Disposition: attachment; filename="coaches_export_' . date('Ymd_His') . '.csv"');
    
    $output = fopen('php://output', 'w');
    
    fputcsv($output, [
        'ID', 'Full Name', 'Email', 'Phone', 'Date of Birth', 'Gender',
        'Chapter', 'Sports Expertise', 'Experience Years', 'Certifications',
        'Availability', 'Emergency Contact Name', 'Emergency Contact Phone',
        'Registration Date', 'Status', 'Notes', 'Created At', 'Updated At'
    ]);
    
    while ($row = $result->fetch_assoc()) {
        fputcsv($output, $row);
    }
    
    fclose($output);
    exit();
}
?>
