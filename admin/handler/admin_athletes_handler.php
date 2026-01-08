<?php
session_start();
header('Content-Type: application/json');

// Database connection
require_once '../../db_connection.php';

// Ensure only authenticated users can access
if (!isset($_SESSION['admin_id']) && !isset($_SESSION['user'])) {
    echo json_encode(['success' => false, 'message' => 'Unauthorized access']);
    exit();
}

$action = $_GET['action'] ?? $_POST['action'] ?? '';

try {
    switch ($action) {
        case 'fetch':
            fetchAthletes($conn);
            break;
        
        case 'fetchStats':
            fetchAthletesStats($conn);
            break;
        
        case 'upload':
            uploadExcel($conn);
            break;
        
        case 'updateStatus':
            updateAthleteStatus($conn);
            break;
        
        case 'delete':
            deleteAthlete($conn);
            break;
        
        case 'update':
            updateAthlete($conn);
            break;
        
        case 'export':
            exportAthletes($conn);
            break;
        
        default:
            echo json_encode(['success' => false, 'message' => 'Invalid action']);
    }
} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}

// Fetch all athletes with filters
function fetchAthletes($conn) {
    $search = $_GET['search'] ?? '';
    $status = $_GET['status'] ?? '';
    $chapter = $_GET['chapter'] ?? '';
    $limit = intval($_GET['limit'] ?? 50);
    $offset = intval($_GET['offset'] ?? 0);
    
    $query = "SELECT * FROM athletes WHERE 1=1";
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
    
    $athletes = [];
    while ($row = $result->fetch_assoc()) {
        $athletes[] = $row;
    }
    
    // Get total count
    $countQuery = "SELECT COUNT(*) as total FROM athletes WHERE 1=1";
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
        'data' => $athletes,
        'total' => $totalCount,
        'limit' => $limit,
        'offset' => $offset
    ]);
}

// Fetch statistics
function fetchAthletesStats($conn) {
    // Total counts by status
    $statsQuery = "SELECT 
        COUNT(*) as total,
        SUM(CASE WHEN status = 'approved' THEN 1 ELSE 0 END) as approved,
        SUM(CASE WHEN status = 'pending' THEN 1 ELSE 0 END) as pending,
        SUM(CASE WHEN status = 'rejected' THEN 1 ELSE 0 END) as rejected,
        SUM(CASE WHEN status = 'archived' THEN 1 ELSE 0 END) as archived,
        SUM(CASE WHEN gender = 'Male' THEN 1 ELSE 0 END) as male,
        SUM(CASE WHEN gender = 'Female' THEN 1 ELSE 0 END) as female
    FROM athletes";
    
    $statsResult = $conn->query($statsQuery);
    $stats = $statsResult->fetch_assoc();
    
    // Chapter breakdown
    $chapterQuery = "SELECT chapter, COUNT(*) as count 
                     FROM athletes 
                     WHERE status = 'approved' AND chapter IS NOT NULL
                     GROUP BY chapter 
                     ORDER BY count DESC";
    $chapterResult = $conn->query($chapterQuery);
    $chapters = [];
    while ($row = $chapterResult->fetch_assoc()) {
        $chapters[] = $row;
    }
    
    // Recent registrations (last 7 days)
    $recentQuery = "SELECT COUNT(*) as recent_count 
                    FROM athletes 
                    WHERE created_at >= DATE_SUB(NOW(), INTERVAL 7 DAY)";
    $recentResult = $conn->query($recentQuery);
    $recentCount = $recentResult->fetch_assoc()['recent_count'];
    
    // Last upload info
    $uploadQuery = "SELECT * FROM participant_excel_uploads 
                    WHERE participant_type = 'athlete' 
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

// Upload and process Excel file
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
    
    // Create upload directory if not exists
    $uploadDir = '../../uploads/participants/athletes/';
    if (!file_exists($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }
    
    // Generate unique filename
    $filename = 'athletes_' . date('Ymd_His') . '.' . $fileExtension;
    $filepath = $uploadDir . $filename;
    
    if (!move_uploaded_file($file['tmp_name'], $filepath)) {
        echo json_encode(['success' => false, 'message' => 'Failed to upload file']);
        return;
    }
    
    // Process Excel file
    require_once '../../vendor/autoload.php'; // PhpSpreadsheet library
    
    try {
        $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($filepath);
        $worksheet = $spreadsheet->getActiveSheet();
        $rows = $worksheet->toArray();
        
        // Assume first row is header
        $headers = array_shift($rows);
        
        $imported = 0;
        $updated = 0;
        $failed = 0;
        $errors = [];
        
        foreach ($rows as $index => $row) {
            if (empty($row[0])) continue; // Skip empty rows
            
            // Map Excel columns to database fields (adjust based on your Excel structure)
            $data = [
                'excel_row_id' => $index + 2, // +2 because header is row 1, array is 0-indexed
                'full_name' => $row[0] ?? '',
                'email' => $row[1] ?? null,
                'phone' => $row[2] ?? null,
                'date_of_birth' => !empty($row[3]) ? date('Y-m-d', strtotime($row[3])) : null,
                'gender' => $row[4] ?? null,
                'chapter' => $row[5] ?? null,
                'sports_interested' => $row[6] ?? null,
                'medical_conditions' => $row[7] ?? null,
                'emergency_contact_name' => $row[8] ?? null,
                'emergency_contact_phone' => $row[9] ?? null,
                'registration_date' => !empty($row[10]) ? date('Y-m-d H:i:s', strtotime($row[10])) : date('Y-m-d H:i:s'),
                'excel_filename' => $filename
            ];
            
            // Check if athlete already exists (by email or name+phone)
            $checkQuery = "SELECT id FROM athletes WHERE email = ? OR (full_name = ? AND phone = ?)";
            $checkStmt = $conn->prepare($checkQuery);
            $checkStmt->bind_param("sss", $data['email'], $data['full_name'], $data['phone']);
            $checkStmt->execute();
            $existingResult = $checkStmt->get_result();
            
            if ($existingResult->num_rows > 0) {
                // Update existing record
                $existingId = $existingResult->fetch_assoc()['id'];
                $updateQuery = "UPDATE athletes SET 
                                full_name = ?, email = ?, phone = ?, date_of_birth = ?,
                                gender = ?, chapter = ?, sports_interested = ?,
                                medical_conditions = ?, emergency_contact_name = ?,
                                emergency_contact_phone = ?, registration_date = ?,
                                excel_filename = ?, updated_at = NOW()
                                WHERE id = ?";
                $updateStmt = $conn->prepare($updateQuery);
                $updateStmt->bind_param("ssssssssssssi",
                    $data['full_name'], $data['email'], $data['phone'], $data['date_of_birth'],
                    $data['gender'], $data['chapter'], $data['sports_interested'],
                    $data['medical_conditions'], $data['emergency_contact_name'],
                    $data['emergency_contact_phone'], $data['registration_date'],
                    $data['excel_filename'], $existingId
                );
                
                if ($updateStmt->execute()) {
                    $updated++;
                } else {
                    $failed++;
                    $errors[] = "Row " . ($index + 2) . ": " . $updateStmt->error;
                }
            } else {
                // Insert new record
                $insertQuery = "INSERT INTO athletes 
                                (excel_row_id, full_name, email, phone, date_of_birth, gender,
                                 chapter, sports_interested, medical_conditions,
                                 emergency_contact_name, emergency_contact_phone,
                                 registration_date, excel_filename)
                                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
                $insertStmt = $conn->prepare($insertQuery);
                $insertStmt->bind_param("issssssssssss",
                    $data['excel_row_id'], $data['full_name'], $data['email'], $data['phone'],
                    $data['date_of_birth'], $data['gender'], $data['chapter'],
                    $data['sports_interested'], $data['medical_conditions'],
                    $data['emergency_contact_name'], $data['emergency_contact_phone'],
                    $data['registration_date'], $data['excel_filename']
                );
                
                if ($insertStmt->execute()) {
                    $imported++;
                } else {
                    $failed++;
                    $errors[] = "Row " . ($index + 2) . ": " . $insertStmt->error;
                }
            }
        }
        
        // Log upload history
        $uploadStatus = $failed > 0 ? 'partial' : 'success';
        $errorLog = !empty($errors) ? implode("\n", $errors) : null;
        
        $logQuery = "INSERT INTO participant_excel_uploads 
                     (participant_type, filename, original_filename, file_path,
                      rows_imported, rows_updated, rows_failed, uploaded_by,
                      upload_status, error_log)
                     VALUES ('athlete', ?, ?, ?, ?, ?, ?, ?, ?, ?)";
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

// Update athlete status
function updateAthleteStatus($conn) {
    $id = intval($_POST['id'] ?? 0);
    $status = $_POST['status'] ?? '';
    
    if ($id <= 0 || empty($status)) {
        echo json_encode(['success' => false, 'message' => 'Invalid parameters']);
        return;
    }
    
    $query = "UPDATE athletes SET status = ?, updated_at = NOW() WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("si", $status, $id);
    
    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'message' => 'Status updated successfully']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to update status']);
    }
}

// Delete athlete
function deleteAthlete($conn) {
    $id = intval($_POST['id'] ?? 0);
    
    if ($id <= 0) {
        echo json_encode(['success' => false, 'message' => 'Invalid ID']);
        return;
    }
    
    $query = "DELETE FROM athletes WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $id);
    
    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'message' => 'Athlete deleted successfully']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to delete athlete']);
    }
}

// Update athlete details
function updateAthlete($conn) {
    $id = intval($_POST['id'] ?? 0);
    
    if ($id <= 0) {
        echo json_encode(['success' => false, 'message' => 'Invalid ID']);
        return;
    }
    
    $query = "UPDATE athletes SET 
              full_name = ?, email = ?, phone = ?, date_of_birth = ?,
              gender = ?, chapter = ?, sports_interested = ?,
              medical_conditions = ?, emergency_contact_name = ?,
              emergency_contact_phone = ?, notes = ?, updated_at = NOW()
              WHERE id = ?";
    
    $stmt = $conn->prepare($query);
    $stmt->bind_param("sssssssssssi",
        $_POST['full_name'], $_POST['email'], $_POST['phone'], $_POST['date_of_birth'],
        $_POST['gender'], $_POST['chapter'], $_POST['sports_interested'],
        $_POST['medical_conditions'], $_POST['emergency_contact_name'],
        $_POST['emergency_contact_phone'], $_POST['notes'], $id
    );
    
    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'message' => 'Athlete updated successfully']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to update athlete']);
    }
}

// Export athletes to CSV
function exportAthletes($conn) {
    $query = "SELECT * FROM athletes ORDER BY created_at DESC";
    $result = $conn->query($query);
    
    header('Content-Type: text/csv');
    header('Content-Disposition: attachment; filename="athletes_export_' . date('Ymd_His') . '.csv"');
    
    $output = fopen('php://output', 'w');
    
    // Headers
    fputcsv($output, [
        'ID', 'Full Name', 'Email', 'Phone', 'Date of Birth', 'Gender',
        'Chapter', 'Sports Interested', 'Medical Conditions',
        'Emergency Contact Name', 'Emergency Contact Phone',
        'Registration Date', 'Status', 'Notes', 'Created At', 'Updated At'
    ]);
    
    while ($row = $result->fetch_assoc()) {
        fputcsv($output, $row);
    }
    
    fclose($output);
    exit();
}
?>
