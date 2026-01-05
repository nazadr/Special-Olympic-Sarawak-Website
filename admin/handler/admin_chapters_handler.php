<?php
// Set proper headers for JSON response
header('Content-Type: application/json');

// Enable error reporting for debugging (remove in production)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "so_sarawak_db";

try {
    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);
    
    // Check connection
    if ($conn->connect_error) {
        throw new Exception('Connection failed: ' . $conn->connect_error);
    }
    
    // Initialize variables
    $action = $_POST['action'] ?? $_GET['action'] ?? '';
    $response = ['success' => false, 'message' => 'Invalid action.'];
} catch (Exception $e) {
    $response = ['success' => false, 'message' => $e->getMessage()];
    echo json_encode($response);
    exit();
}

try {
    // Debug information
    error_log("Chapters handler called with action: " . $action);
    error_log("POST data: " . print_r($_POST, true));
    
    switch ($action) {
    
    // CHAPTER MANAGEMENT ACTIONS
    case 'fetch_chapters':
        $sql = "SELECT id, chapter_name, city, chairman, vice_chairman, secretary, treasurer, logo_path, status FROM sarawak_chapters ORDER BY id ASC";
        $result = $conn->query($sql);

        $chapters = [];
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                // Fix logo path for admin directory context
                if ($row['logo_path']) {
                    // If path doesn't start with ../ or http, prepend ../ for admin context
                    if (strpos($row['logo_path'], '../') !== 0 && strpos($row['logo_path'], 'http') !== 0) {
                        $row['logo_path'] = '../' . $row['logo_path'];
                    }
                }
                $chapters[] = $row;
            }
            $response = ['success' => true, 'chapters' => $chapters];
        } else {
            $response = ['success' => true, 'chapters' => [], 'message' => 'No chapters found.'];
        }
        break;

    case 'update_chapter':
        $id = $_POST['id'] ?? '';
        $chairman = $_POST['chairman'] ?? '';
        $vice_chairman = $_POST['vice_chairman'] ?? '';
        $secretary = $_POST['secretary'] ?? '';
        $treasurer = $_POST['treasurer'] ?? '';
        $status = $_POST['status'] ?? 'active';

        if ($id && $chairman) {
            $stmt = $conn->prepare("UPDATE sarawak_chapters SET chairman = ?, vice_chairman = ?, secretary = ?, treasurer = ?, status = ? WHERE id = ?");
            $stmt->bind_param("sssssi", $chairman, $vice_chairman, $secretary, $treasurer, $status, $id);

            if ($stmt->execute()) {
                $response = ['success' => true, 'message' => 'Chapter updated successfully!'];
            } else {
                $response = ['success' => false, 'message' => 'Error updating chapter: ' . $stmt->error];
            }
            $stmt->close();
        } else {
            $response = ['success' => false, 'message' => 'Chapter ID and Chairman are required.'];
        }
        break;

    case 'fetch_single_chapter':
        $id = $_GET['id'] ?? '';
        if ($id) {
            $stmt = $conn->prepare("SELECT id, chapter_name, city, chairman, vice_chairman, secretary, treasurer, status FROM sarawak_chapters WHERE id = ?");
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $result = $stmt->get_result();
            if ($result->num_rows > 0) {
                $chapter = $result->fetch_assoc();
                $response = ['success' => true, 'chapter' => $chapter];
            } else {
                $response = ['success' => false, 'message' => 'Chapter not found.'];
            }
            $stmt->close();
        } else {
            $response = ['success' => false, 'message' => 'Chapter ID is required.'];
        }
        break;

    case 'update_chapter_order':
        $orders = $_POST['orders'] ?? '';
        if ($orders) {
            $orders = json_decode($orders, true);
            if ($orders) {
                $conn->begin_transaction();
                try {
                    $stmt = $conn->prepare("UPDATE sarawak_chapters SET display_order = ? WHERE id = ?");
                    foreach ($orders as $item) {
                        $stmt->bind_param("ii", $item['order'], $item['id']);
                        $stmt->execute();
                    }
                    $conn->commit();
                    $response = ['success' => true, 'message' => 'Chapter order updated successfully!'];
                } catch (Exception $e) {
                    $conn->rollback();
                    $response = ['success' => false, 'message' => 'Error updating order: ' . $e->getMessage()];
                }
                $stmt->close();
            } else {
                $response = ['success' => false, 'message' => 'Invalid order data.'];
            }
        } else {
            $response = ['success' => false, 'message' => 'Order data is required.'];
        }
        break;

    // PARTICIPANTS MANAGEMENT ACTIONS
    case 'fetch_participants':
        $sql = "SELECT cp.*, sc.chapter_name, sc.city 
                FROM chapter_participants cp 
                LEFT JOIN sarawak_chapters sc ON cp.chapter_id = sc.id 
                ORDER BY sc.display_order ASC, cp.year DESC";
        $result = $conn->query($sql);

        $participants = [];
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $participants[] = $row;
            }
            $response = ['success' => true, 'participants' => $participants];
        } else {
            $response = ['success' => true, 'participants' => [], 'message' => 'No participant data found.'];
        }
        break;

    case 'update_participants':
        $chapter_id = $_POST['chapter_id'] ?? '';
        $athletes_male = $_POST['athletes_male'] ?? 0;
        $athletes_female = $_POST['athletes_female'] ?? 0;
        $coaches_male = $_POST['coaches_male'] ?? 0;
        $coaches_female = $_POST['coaches_female'] ?? 0;
        $volunteers_male = $_POST['volunteers_male'] ?? 0;
        $volunteers_female = $_POST['volunteers_female'] ?? 0;
        $year = $_POST['year'] ?? date('Y');

        if ($chapter_id) {
            // Check if record exists for this chapter and year
            $stmt = $conn->prepare("SELECT id FROM chapter_participants WHERE chapter_id = ? AND year = ?");
            $stmt->bind_param("ii", $chapter_id, $year);
            $stmt->execute();
            $result = $stmt->get_result();
            
            if ($result->num_rows > 0) {
                // Update existing record
                $stmt = $conn->prepare("UPDATE chapter_participants SET athletes_male = ?, athletes_female = ?, coaches_male = ?, coaches_female = ?, volunteers_male = ?, volunteers_female = ? WHERE chapter_id = ? AND year = ?");
                $stmt->bind_param("iiiiiiii", $athletes_male, $athletes_female, $coaches_male, $coaches_female, $volunteers_male, $volunteers_female, $chapter_id, $year);
            } else {
                // Insert new record
                $stmt = $conn->prepare("INSERT INTO chapter_participants (chapter_id, athletes_male, athletes_female, coaches_male, coaches_female, volunteers_male, volunteers_female, year) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
                $stmt->bind_param("iiiiiiii", $chapter_id, $athletes_male, $athletes_female, $coaches_male, $coaches_female, $volunteers_male, $volunteers_female, $year);
            }

            if ($stmt->execute()) {
                $response = ['success' => true, 'message' => 'Participant data updated successfully!'];
            } else {
                $response = ['success' => false, 'message' => 'Error updating participant data: ' . $stmt->error];
            }
            $stmt->close();
        } else {
            $response = ['success' => false, 'message' => 'Chapter ID is required.'];
        }
        break;

    case 'fetch_single_participants':
        $chapter_id = $_GET['chapter_id'] ?? '';
        $year = $_GET['year'] ?? date('Y');
        if ($chapter_id) {
            $stmt = $conn->prepare("SELECT cp.*, sc.chapter_name FROM chapter_participants cp LEFT JOIN sarawak_chapters sc ON cp.chapter_id = sc.id WHERE cp.chapter_id = ? AND cp.year = ?");
            $stmt->bind_param("ii", $chapter_id, $year);
            $stmt->execute();
            $result = $stmt->get_result();
            if ($result->num_rows > 0) {
                $participant_data = $result->fetch_assoc();
                $response = ['success' => true, 'participant_data' => $participant_data];
            } else {
                $response = ['success' => false, 'message' => 'No participant data found for this chapter and year.'];
            }
            $stmt->close();
        } else {
            $response = ['success' => false, 'message' => 'Chapter ID is required.'];
        }
        break;

    case 'fetch_chapters_with_participants':
        // Get the latest year with data or default to current year
        $year_query = "SELECT MAX(year) as latest_year FROM chapter_participants";
        $year_result = $conn->query($year_query);
        $year_row = $year_result->fetch_assoc();
        $year = $year_row['latest_year'] ?? date('Y');
        
        $sql = "SELECT sc.*, 
                       COALESCE(cp.athletes_male, 0) as athletes_male,
                       COALESCE(cp.athletes_female, 0) as athletes_female,
                       COALESCE(cp.coaches_male, 0) as coaches_male,
                       COALESCE(cp.coaches_female, 0) as coaches_female,
                       COALESCE(cp.volunteers_male, 0) as volunteers_male,
                       COALESCE(cp.volunteers_female, 0) as volunteers_female,
                       COALESCE(cp.total_participants, 0) as total_participants,
                       COALESCE(cp.athletes_total, 0) as athletes_total,
                       COALESCE(cp.coaches_total, 0) as coaches_total,
                       COALESCE(cp.volunteers_total, 0) as volunteers_total,
                       cp.year
                FROM sarawak_chapters sc 
                LEFT JOIN chapter_participants cp ON sc.id = cp.chapter_id AND cp.year = ?
                ORDER BY sc.display_order ASC";
        
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $year);
        $stmt->execute();
        $result = $stmt->get_result();

        $chapters_data = [];
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $chapters_data[] = $row;
            }
            $response = ['success' => true, 'chapters_data' => $chapters_data];
        } else {
            $response = ['success' => true, 'chapters_data' => [], 'message' => 'No data found.'];
        }
        $stmt->close();
        break;

    case 'fetch_pinpoint_data':
        // Get the latest year with data or default to current year
        $year_query = "SELECT MAX(year) as latest_year FROM chapter_participants";
        $year_result = $conn->query($year_query);
        $year_row = $year_result->fetch_assoc();
        $year = $year_row['latest_year'] ?? date('Y');
        
        $sql = "SELECT sc.id, sc.chapter_name, sc.city, sc.chairman, sc.vice_chairman, sc.secretary, sc.treasurer, sc.logo_path, sc.status,
                       COALESCE(cp.athletes_male, 0) as athletes_male,
                       COALESCE(cp.athletes_female, 0) as athletes_female,
                       COALESCE(cp.coaches_male, 0) as coaches_male,
                       COALESCE(cp.coaches_female, 0) as coaches_female,
                       COALESCE(cp.volunteers_male, 0) as volunteers_male,
                       COALESCE(cp.volunteers_female, 0) as volunteers_female,
                       COALESCE(cp.total_participants, 0) as total_participants,
                       COALESCE(cp.athletes_total, 0) as total_athletes,
                       COALESCE(cp.coaches_total, 0) as total_coaches,
                       COALESCE(cp.volunteers_total, 0) as total_volunteers
                FROM sarawak_chapters sc 
                LEFT JOIN chapter_participants cp ON sc.id = cp.chapter_id AND cp.year = ?
                ORDER BY sc.id ASC";
        
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $year);
        $stmt->execute();
        $result = $stmt->get_result();

        $pinpoint_data = [];
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $logo_path = $row['logo_path'];
                // Fix logo path for frontend context
                if ($logo_path && strpos($logo_path, '../') !== 0 && strpos($logo_path, 'http') !== 0) {
                    $logo_path = '../' . $logo_path;
                }
                
                $pinpoint_data[] = [
                    'id' => $row['id'],
                    'chapter_name' => $row['chapter_name'],
                    'city' => $row['city'],
                    'chairman' => $row['chairman'],
                    'vice_chairman' => $row['vice_chairman'],
                    'secretary' => $row['secretary'],
                    'treasurer' => $row['treasurer'],
                    'logo_path' => $logo_path,
                    'status' => $row['status'],
                    'athletes_male' => (int)$row['athletes_male'],
                    'athletes_female' => (int)$row['athletes_female'],
                    'coaches_male' => (int)$row['coaches_male'],
                    'coaches_female' => (int)$row['coaches_female'],
                    'volunteers_male' => (int)$row['volunteers_male'],
                    'volunteers_female' => (int)$row['volunteers_female'],
                    'total_participants' => (int)$row['total_participants'],
                    'total_athletes' => (int)$row['total_athletes'],
                    'total_coaches' => (int)$row['total_coaches'],
                    'total_volunteers' => (int)$row['total_volunteers']
                ];
            }
            $response = ['success' => true, 'pinpoint_data' => $pinpoint_data];
        } else {
            $response = ['success' => true, 'pinpoint_data' => [], 'message' => 'No pinpoint data found.'];
        }
        $stmt->close();
        break;

    default:
        $response = ['success' => false, 'message' => 'Unknown action.'];
        break;
}

} catch (Exception $e) {
    $response = ['success' => false, 'message' => 'Server error: ' . $e->getMessage()];
}

echo json_encode($response);
if (isset($conn)) {
    $conn->close();
}
?>