<?php
/**
 * Admin Sponsorship Handler - Enhanced Version
 * Supports chapter-based sponsorship grouping with tiers
 * 
 * Actions:
 * - add: Add new sponsor with chapter assignment
 * - fetch: Fetch all sponsors (optionally grouped by chapter)
 * - fetch_grouped: Fetch sponsors grouped by chapter
 * - fetch_by_chapter: Fetch sponsors for specific chapter
 * - fetch_single: Fetch single sponsor details
 * - edit: Update sponsor information
 * - delete: Remove sponsor
 * - get_chapters: Get list of chapters for dropdown
 * - update_order: Update display order of sponsors
 */

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

// Initialize response
$action = $_POST['action'] ?? $_GET['action'] ?? '';
$response = ['success' => false, 'message' => 'Invalid action.'];

// Helper function to get chapter name by ID
function getChapterName($conn, $chapter_id) {
    if ($chapter_id === null || $chapter_id === '' || $chapter_id === '0') {
        return 'Special Olympics Sarawak';
    }
    $stmt = $conn->prepare("SELECT chapter_name, city FROM sarawak_chapters WHERE id = ?");
    $stmt->bind_param("i", $chapter_id);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($row = $result->fetch_assoc()) {
        return $row['chapter_name'];
    }
    return 'Unknown Chapter';
}

// Helper function to map old type to chapter_id
function mapTypeToChapterId($type) {
    $mapping = [
        'Special Olympics Sarawak' => null,
        'Kuching Chapter' => 1,
        'Samarahan Chapter' => 2,
        'Sibu Chapter' => 3,
        'Bintulu Chapter' => 4,
        'Miri Chapter' => 5
    ];
    return $mapping[$type] ?? null;
}

// Helper function to check if new columns exist
function hasNewColumns($conn) {
    $columns_check = $conn->query("SHOW COLUMNS FROM sponsorships LIKE 'sponsor_name'");
    return $columns_check->num_rows > 0;
}

switch ($action) {
    case 'add':
        $sponsor_name = $_POST['sponsorshipName'] ?? 'Sponsor';
        $chapter_input = $_POST['sponsorshipChapter'] ?? '';
        $sponsor_tier = $_POST['sponsorshipTier'] ?? 'supporter';
        $display_order = intval($_POST['sponsorshipOrder'] ?? 0);
        $image_path = null;
        
        // Handle chapter_id - '0' means state level (NULL in DB), others are FK
        $chapter_id = ($chapter_input === '0' || $chapter_input === '') ? null : intval($chapter_input);
        
        // For backward compatibility with old type field
        $type = $_POST['type'] ?? '';
        if (empty($type)) {
            if ($chapter_id === null) {
                $type = 'Special Olympics Sarawak';
            } else {
                $stmt = $conn->prepare("SELECT city FROM sarawak_chapters WHERE id = ?");
                $stmt->bind_param("i", $chapter_id);
                $stmt->execute();
                $result = $stmt->get_result();
                if ($row = $result->fetch_assoc()) {
                    $type = $row['city'] . ' Chapter';
                } else {
                    $type = 'Unknown Chapter';
                }
                $stmt->close();
            }
        } else {
            // Legacy: map type to chapter_id
            $chapter_id = mapTypeToChapterId($type);
        }

        // Handle image upload
        if (isset($_FILES['sponsorshipImage']) && $_FILES['sponsorshipImage']['error'] == UPLOAD_ERR_OK) {
            $target_dir = "../../assets/images/sponsorships/";
            if (!is_dir($target_dir)) {
                mkdir($target_dir, 0777, true);
            }
            $image_name = basename($_FILES["sponsorshipImage"]["name"]);
            $unique_name = uniqid() . '_' . preg_replace('/[^a-zA-Z0-9._-]/', '', $image_name);
            $physical_path = $target_dir . $unique_name;
            
            if (!move_uploaded_file($_FILES["sponsorshipImage"]["tmp_name"], $physical_path)) {
                $response = ['success' => false, 'message' => 'Failed to upload image.'];
                echo json_encode($response);
                $conn->close();
                exit();
            }
            $image_path = '../assets/images/sponsorships/' . $unique_name;
        }

        // Validate required fields
        if (empty($image_path)) {
            $response = ['success' => false, 'message' => 'Sponsor logo is required.'];
            echo json_encode($response);
            $conn->close();
            exit();
        }

        // Check if new columns exist
        $has_new_columns = hasNewColumns($conn);

        if ($has_new_columns) {
            $stmt = $conn->prepare("INSERT INTO sponsorships (sponsor_name, type, chapter_id, sponsor_tier, image_path, display_order, is_active) VALUES (?, ?, ?, ?, ?, ?, 1)");
            $stmt->bind_param("ssissi", $sponsor_name, $type, $chapter_id, $sponsor_tier, $image_path, $display_order);
        } else {
            // Legacy insert
            $stmt = $conn->prepare("INSERT INTO sponsorships (type, image_path) VALUES (?, ?)");
            $stmt->bind_param("ss", $type, $image_path);
        }
        
        if ($stmt->execute()) {
            $response = ['success' => true, 'message' => 'Sponsor added successfully!', 'id' => $conn->insert_id];
        } else {
            $response = ['success' => false, 'message' => 'Error adding sponsor: ' . $stmt->error];
        }
        $stmt->close();
        break;

    case 'fetch':
        $has_new_columns = hasNewColumns($conn);

        if ($has_new_columns) {
            $sql = "SELECT s.*, 
                    COALESCE(c.chapter_name, 'Special Olympics Sarawak') as chapter_name,
                    COALESCE(c.city, 'State Level') as city
                    FROM sponsorships s 
                    LEFT JOIN sarawak_chapters c ON s.chapter_id = c.id 
                    WHERE s.is_active = 1 
                    ORDER BY s.chapter_id IS NULL DESC, s.chapter_id ASC, s.display_order ASC, s.id ASC";
        } else {
            $sql = "SELECT id, type, image_path, type as chapter_name FROM sponsorships ORDER BY id ASC";
        }
        
        $result = $conn->query($sql);
        $sponsorships = [];
        
        if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                // Add computed fields for backward compatibility
                if (!$has_new_columns) {
                    $row['sponsor_name'] = 'Sponsor';
                    $row['chapter_id'] = mapTypeToChapterId($row['type']);
                    $row['sponsor_tier'] = 'supporter';
                    $row['display_order'] = 0;
                    $row['city'] = str_replace(' Chapter', '', $row['type']);
                    if ($row['type'] === 'Special Olympics Sarawak') {
                        $row['city'] = 'State Level';
                    }
                }
                $sponsorships[] = $row;
            }
        }
        
        // Calculate statistics
        $total = count($sponsorships);
        $state_level = count(array_filter($sponsorships, fn($s) => $s['chapter_id'] === null || $s['chapter_id'] == 0));
        $chapter_level = $total - $state_level;
        
        $response = [
            'success' => true, 
            'sponsorships' => $sponsorships,
            'stats' => [
                'total' => $total,
                'state_level' => $state_level,
                'chapter_level' => $chapter_level
            ]
        ];
        break;

    case 'fetch_grouped':
        $has_new_columns = hasNewColumns($conn);

        // Get chapters first
        $chapters_result = $conn->query("SELECT id, chapter_name, city, logo_path FROM sarawak_chapters WHERE status = 'active' ORDER BY id");
        $chapters = [];
        while ($row = $chapters_result->fetch_assoc()) {
            $chapters[$row['id']] = [
                'id' => $row['id'],
                'name' => $row['chapter_name'],
                'city' => $row['city'],
                'logo' => $row['logo_path'],
                'sponsors' => []
            ];
        }
        
        // Add state-level group
        $grouped = [
            'state' => [
                'id' => 0,
                'name' => 'Special Olympics Sarawak',
                'city' => 'State Level',
                'logo' => 'assets/images/master_logo_front.png',
                'sponsors' => []
            ]
        ];
        $grouped = array_merge($grouped, $chapters);

        // Fetch all sponsors
        if ($has_new_columns) {
            $sql = "SELECT * FROM sponsorships WHERE is_active = 1 ORDER BY display_order ASC, id ASC";
        } else {
            $sql = "SELECT * FROM sponsorships ORDER BY id ASC";
        }
        
        $result = $conn->query($sql);
        while ($row = $result->fetch_assoc()) {
            if (!$has_new_columns) {
                $row['chapter_id'] = mapTypeToChapterId($row['type']);
                $row['sponsor_name'] = 'Sponsor';
                $row['sponsor_tier'] = 'supporter';
            }
            
            $chapter_id = $row['chapter_id'];
            if ($chapter_id === null || $chapter_id == 0) {
                $grouped['state']['sponsors'][] = $row;
            } elseif (isset($grouped[$chapter_id])) {
                $grouped[$chapter_id]['sponsors'][] = $row;
            }
        }
        
        $response = ['success' => true, 'grouped' => array_values($grouped)];
        break;

    case 'fetch_by_chapter':
        $chapter_id = $_GET['chapter_id'] ?? null;
        $has_new_columns = hasNewColumns($conn);

        if ($chapter_id === '0' || $chapter_id === 'state') {
            // State level sponsors
            if ($has_new_columns) {
                $sql = "SELECT * FROM sponsorships WHERE (chapter_id IS NULL OR chapter_id = 0) AND is_active = 1 ORDER BY display_order ASC";
            } else {
                $sql = "SELECT * FROM sponsorships WHERE type = 'Special Olympics Sarawak' ORDER BY id ASC";
            }
            $result = $conn->query($sql);
        } else {
            if ($has_new_columns) {
                $stmt = $conn->prepare("SELECT * FROM sponsorships WHERE chapter_id = ? AND is_active = 1 ORDER BY display_order ASC");
                $stmt->bind_param("i", $chapter_id);
                $stmt->execute();
                $result = $stmt->get_result();
            } else {
                $type_map = [1 => 'Kuching Chapter', 2 => 'Samarahan Chapter', 3 => 'Sibu Chapter', 4 => 'Bintulu Chapter', 5 => 'Miri Chapter'];
                $type = $type_map[$chapter_id] ?? '';
                $stmt = $conn->prepare("SELECT * FROM sponsorships WHERE type = ? ORDER BY id ASC");
                $stmt->bind_param("s", $type);
                $stmt->execute();
                $result = $stmt->get_result();
            }
        }
        
        $sponsorships = [];
        while ($row = $result->fetch_assoc()) {
            $sponsorships[] = $row;
        }
        
        $response = ['success' => true, 'sponsorships' => $sponsorships];
        break;

    case 'fetch_single':
        $id = $_GET['id'] ?? '';
        if ($id) {
            $has_new_columns = hasNewColumns($conn);
            
            if ($has_new_columns) {
                $stmt = $conn->prepare("SELECT s.*, c.chapter_name, c.city 
                                        FROM sponsorships s 
                                        LEFT JOIN sarawak_chapters c ON s.chapter_id = c.id 
                                        WHERE s.id = ?");
            } else {
                $stmt = $conn->prepare("SELECT * FROM sponsorships WHERE id = ?");
            }
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $result = $stmt->get_result();
            if ($result->num_rows > 0) {
                $sponsorship = $result->fetch_assoc();
                if (!$has_new_columns) {
                    $sponsorship['chapter_id'] = mapTypeToChapterId($sponsorship['type']);
                    $sponsorship['sponsor_name'] = 'Sponsor';
                    $sponsorship['sponsor_tier'] = 'supporter';
                }
                $response = ['success' => true, 'sponsorship' => $sponsorship];
            } else {
                $response = ['success' => false, 'message' => 'Sponsorship not found.'];
            }
            $stmt->close();
        } else {
            $response = ['success' => false, 'message' => 'Sponsorship ID is required.'];
        }
        break;

    case 'edit':
        $id = $_POST['id'] ?? '';
        $sponsor_name = $_POST['sponsorshipName'] ?? 'Sponsor';
        $chapter_input = $_POST['sponsorshipChapter'] ?? '';
        $sponsor_tier = $_POST['sponsorshipTier'] ?? 'supporter';
        $display_order = intval($_POST['sponsorshipOrder'] ?? 0);
        $image_path = $_POST['currentSponsorshipImage'] ?? null;
        
        // Handle chapter_id
        $chapter_id = ($chapter_input === '0' || $chapter_input === '') ? null : intval($chapter_input);
        
        // Determine type string for backward compatibility
        if ($chapter_id === null) {
            $type = 'Special Olympics Sarawak';
        } else {
            $stmt = $conn->prepare("SELECT city FROM sarawak_chapters WHERE id = ?");
            $stmt->bind_param("i", $chapter_id);
            $stmt->execute();
            $result = $stmt->get_result();
            if ($row = $result->fetch_assoc()) {
                $type = $row['city'] . ' Chapter';
            } else {
                $type = 'Unknown Chapter';
            }
            $stmt->close();
        }

        // Handle new image upload
        if (isset($_FILES['sponsorshipImage']) && $_FILES['sponsorshipImage']['error'] == UPLOAD_ERR_OK) {
            $target_dir = "../../assets/images/sponsorships/";
            if (!is_dir($target_dir)) {
                mkdir($target_dir, 0777, true);
            }
            $image_name = basename($_FILES["sponsorshipImage"]["name"]);
            $unique_name = uniqid() . '_' . preg_replace('/[^a-zA-Z0-9._-]/', '', $image_name);
            $physical_path = $target_dir . $unique_name;
            
            if (move_uploaded_file($_FILES["sponsorshipImage"]["tmp_name"], $physical_path)) {
                // Delete old image
                if ($image_path && !empty($image_path)) {
                    $old_physical_path = str_replace('../assets/images/sponsorships/', '../../assets/images/sponsorships/', $image_path);
                    if (file_exists($old_physical_path)) {
                        unlink($old_physical_path);
                    }
                }
                $image_path = '../assets/images/sponsorships/' . $unique_name;
            } else {
                $response = ['success' => false, 'message' => 'Failed to upload new image.'];
                echo json_encode($response);
                $conn->close();
                exit();
            }
        }

        if ($id) {
            $has_new_columns = hasNewColumns($conn);

            if ($has_new_columns) {
                $stmt = $conn->prepare("UPDATE sponsorships SET sponsor_name = ?, type = ?, chapter_id = ?, sponsor_tier = ?, image_path = ?, display_order = ? WHERE id = ?");
                $stmt->bind_param("ssissii", $sponsor_name, $type, $chapter_id, $sponsor_tier, $image_path, $display_order, $id);
            } else {
                $stmt = $conn->prepare("UPDATE sponsorships SET type = ?, image_path = ? WHERE id = ?");
                $stmt->bind_param("ssi", $type, $image_path, $id);
            }
            
            if ($stmt->execute()) {
                $response = ['success' => true, 'message' => 'Sponsor updated successfully!'];
            } else {
                $response = ['success' => false, 'message' => 'Error updating sponsor: ' . $stmt->error];
            }
            $stmt->close();
        } else {
            $response = ['success' => false, 'message' => 'Sponsor ID is required.'];
        }
        break;

    case 'delete':
        $id = $_POST['id'] ?? '';
        if ($id) {
            // Get image path first
            $stmt = $conn->prepare("SELECT image_path FROM sponsorships WHERE id = ?");
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $stmt->bind_result($image_path_to_delete);
            $stmt->fetch();
            $stmt->close();

            // Delete record
            $stmt = $conn->prepare("DELETE FROM sponsorships WHERE id = ?");
            $stmt->bind_param("i", $id);
            if ($stmt->execute()) {
                // Delete image file
                if ($image_path_to_delete) {
                    $physical_path = str_replace('../assets/images/sponsorships/', '../../assets/images/sponsorships/', $image_path_to_delete);
                    if (file_exists($physical_path)) {
                        unlink($physical_path);
                    }
                }
                $response = ['success' => true, 'message' => 'Sponsor deleted successfully!'];
            } else {
                $response = ['success' => false, 'message' => 'Error deleting sponsor: ' . $stmt->error];
            }
            $stmt->close();
        } else {
            $response = ['success' => false, 'message' => 'Sponsor ID is required.'];
        }
        break;

    case 'get_chapters':
        $sql = "SELECT id, chapter_name, city, logo_path, status FROM sarawak_chapters ORDER BY id";
        $result = $conn->query($sql);
        $chapters = [
            ['id' => 0, 'chapter_name' => 'Special Olympics Sarawak', 'city' => 'State Level', 'status' => 'active']
        ];
        while ($row = $result->fetch_assoc()) {
            $chapters[] = $row;
        }
        $response = ['success' => true, 'chapters' => $chapters];
        break;

    case 'update_order':
        $orders = $_POST['orders'] ?? [];
        if (!empty($orders)) {
            $success = true;
            foreach ($orders as $order) {
                $stmt = $conn->prepare("UPDATE sponsorships SET display_order = ? WHERE id = ?");
                $stmt->bind_param("ii", $order['order'], $order['id']);
                if (!$stmt->execute()) {
                    $success = false;
                }
                $stmt->close();
            }
            $response = ['success' => $success, 'message' => $success ? 'Order updated successfully!' : 'Error updating order.'];
        } else {
            $response = ['success' => false, 'message' => 'No order data provided.'];
        }
        break;

    default:
        $response = ['success' => false, 'message' => 'Unknown action: ' . $action];
}

echo json_encode($response);
$conn->close();
?>