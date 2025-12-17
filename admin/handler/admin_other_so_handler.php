<?php
/**
 * ============================================================================
 * Admin Other Special Olympics Handler
 * ============================================================================
 * 
 * Purpose: Manages CRUD operations for Other Special Olympics organizations
 * 
 * Actions:
 * - add: Add new organization
 * - fetch: Fetch all organizations
 * - fetch_by_category: Fetch organizations by category
 * - fetch_single: Fetch single organization details
 * - edit: Update organization information
 * - delete: Remove organization
 * - update_order: Update display order (drag-drop sorting)
 * - toggle_status: Toggle active/inactive status
 * 
 * Database Table: other_special_olympics
 * 
 * Author: SO Sarawak Admin Webmaster
 * Created: December 17, 2025
 * ============================================================================
 */

// Database connection configuration
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "so_sarawak_db";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    header('Content-Type: application/json');
    die(json_encode([
        'success' => false, 
        'message' => 'Database connection failed: ' . $conn->connect_error
    ]));
}

// Set charset to UTF-8
$conn->set_charset("utf8mb4");

// Initialize response
$action = $_POST['action'] ?? $_GET['action'] ?? '';
$response = ['success' => false, 'message' => 'Invalid action.'];

/**
 * ============================================================================
 * ACTION: ADD NEW ORGANIZATION
 * ============================================================================
 */
if ($action === 'add') {
    $name = trim($_POST['name'] ?? '');
    $category = $_POST['category'] ?? '';
    $website_url = trim($_POST['website_url'] ?? '#');
    $display_order = intval($_POST['display_order'] ?? 0);
    $is_active = intval($_POST['is_active'] ?? 1);
    
    // Validate required fields
    if (empty($name) || empty($category)) {
        $response = ['success' => false, 'message' => 'Name and category are required.'];
    } 
    // Validate category
    elseif (!in_array($category, ['international', 'malaysia', 'state'])) {
        $response = ['success' => false, 'message' => 'Invalid category.'];
    } 
    else {
        // Handle file uploads
        $logo_desktop = null;
        $logo_mobile = null;
        $upload_dir = '../../assets/images/other-so/';
        
        // Create directory if it doesn't exist
        if (!file_exists($upload_dir)) {
            mkdir($upload_dir, 0755, true);
        }
        
        // Handle desktop logo upload
        if (isset($_FILES['logo_desktop']) && $_FILES['logo_desktop']['error'] === UPLOAD_ERR_OK) {
            $file_extension = pathinfo($_FILES['logo_desktop']['name'], PATHINFO_EXTENSION);
            $safe_name = preg_replace('/[^a-zA-Z0-9_-]/', '_', $name);
            $desktop_filename = $safe_name . '_desktop_' . time() . '.' . $file_extension;
            $desktop_path = $upload_dir . $desktop_filename;
            
            if (move_uploaded_file($_FILES['logo_desktop']['tmp_name'], $desktop_path)) {
                $logo_desktop = '../assets/images/other-so/' . $desktop_filename;
            }
        }
        
        // Handle mobile logo upload
        if (isset($_FILES['logo_mobile']) && $_FILES['logo_mobile']['error'] === UPLOAD_ERR_OK) {
            $file_extension = pathinfo($_FILES['logo_mobile']['name'], PATHINFO_EXTENSION);
            $safe_name = preg_replace('/[^a-zA-Z0-9_-]/', '_', $name);
            $mobile_filename = $safe_name . '_mobile_' . time() . '.' . $file_extension;
            $mobile_path = $upload_dir . $mobile_filename;
            
            if (move_uploaded_file($_FILES['logo_mobile']['tmp_name'], $mobile_path)) {
                $logo_mobile = '../assets/images/other-so/' . $mobile_filename;
            }
        }
        
        // Insert into database
        $stmt = $conn->prepare("INSERT INTO other_special_olympics 
            (name, category, logo_desktop, logo_mobile, website_url, display_order, is_active) 
            VALUES (?, ?, ?, ?, ?, ?, ?)");
        
        $stmt->bind_param("sssssii", 
            $name, $category, $logo_desktop, $logo_mobile, $website_url, $display_order, $is_active
        );
        
        if ($stmt->execute()) {
            $response = [
                'success' => true, 
                'message' => 'Organization added successfully.',
                'id' => $conn->insert_id
            ];
        } else {
            $response = [
                'success' => false, 
                'message' => 'Database error: ' . $stmt->error
            ];
        }
        
        $stmt->close();
    }
}

/**
 * ============================================================================
 * ACTION: FETCH ALL ORGANIZATIONS
 * ============================================================================
 */
elseif ($action === 'fetch') {
    $sql = "SELECT * FROM other_special_olympics ORDER BY category, display_order ASC";
    $result = $conn->query($sql);
    
    if ($result) {
        $organizations = [];
        while ($row = $result->fetch_assoc()) {
            $organizations[] = $row;
        }
        
        $response = [
            'success' => true,
            'data' => $organizations,
            'count' => count($organizations)
        ];
    } else {
        $response = [
            'success' => false, 
            'message' => 'Failed to fetch organizations: ' . $conn->error
        ];
    }
}

/**
 * ============================================================================
 * ACTION: FETCH ORGANIZATIONS BY CATEGORY
 * ============================================================================
 */
elseif ($action === 'fetch_by_category') {
    $category = $_GET['category'] ?? '';
    
    if (empty($category)) {
        $response = ['success' => false, 'message' => 'Category parameter is required.'];
    } else {
        $stmt = $conn->prepare("SELECT * FROM other_special_olympics 
            WHERE category = ? AND is_active = 1 
            ORDER BY display_order ASC");
        $stmt->bind_param("s", $category);
        $stmt->execute();
        $result = $stmt->get_result();
        
        $organizations = [];
        while ($row = $result->fetch_assoc()) {
            $organizations[] = $row;
        }
        
        $response = [
            'success' => true,
            'data' => $organizations,
            'count' => count($organizations)
        ];
        
        $stmt->close();
    }
}

/**
 * ============================================================================
 * ACTION: FETCH SINGLE ORGANIZATION
 * ============================================================================
 */
elseif ($action === 'fetch_single') {
    $id = intval($_GET['id'] ?? 0);
    
    if ($id <= 0) {
        $response = ['success' => false, 'message' => 'Invalid organization ID.'];
    } else {
        $stmt = $conn->prepare("SELECT * FROM other_special_olympics WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($row = $result->fetch_assoc()) {
            $response = [
                'success' => true,
                'data' => $row
            ];
        } else {
            $response = ['success' => false, 'message' => 'Organization not found.'];
        }
        
        $stmt->close();
    }
}

/**
 * ============================================================================
 * ACTION: EDIT ORGANIZATION
 * ============================================================================
 */
elseif ($action === 'edit') {
    $id = intval($_POST['id'] ?? 0);
    $name = trim($_POST['name'] ?? '');
    $category = $_POST['category'] ?? '';
    $website_url = trim($_POST['website_url'] ?? '#');
    $display_order = intval($_POST['display_order'] ?? 0);
    $is_active = intval($_POST['is_active'] ?? 1);
    
    // Validate
    if ($id <= 0) {
        $response = ['success' => false, 'message' => 'Invalid organization ID.'];
    } 
    elseif (empty($name) || empty($category)) {
        $response = ['success' => false, 'message' => 'Name and category are required.'];
    }
    else {
        // Get current logos
        $stmt = $conn->prepare("SELECT logo_desktop, logo_mobile FROM other_special_olympics WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $current = $result->fetch_assoc();
        $stmt->close();
        
        $logo_desktop = $current['logo_desktop'];
        $logo_mobile = $current['logo_mobile'];
        $upload_dir = '../../assets/images/other-so/';
        
        // Create directory if it doesn't exist
        if (!file_exists($upload_dir)) {
            mkdir($upload_dir, 0755, true);
        }
        
        // Handle desktop logo upload
        if (isset($_FILES['logo_desktop']) && $_FILES['logo_desktop']['error'] === UPLOAD_ERR_OK) {
            // Delete old file
            if ($logo_desktop && file_exists('../../' . $logo_desktop)) {
                unlink('../../' . $logo_desktop);
            }
            
            $file_extension = pathinfo($_FILES['logo_desktop']['name'], PATHINFO_EXTENSION);
            $safe_name = preg_replace('/[^a-zA-Z0-9_-]/', '_', $name);
            $desktop_filename = $safe_name . '_desktop_' . time() . '.' . $file_extension;
            $desktop_path = $upload_dir . $desktop_filename;
            
            if (move_uploaded_file($_FILES['logo_desktop']['tmp_name'], $desktop_path)) {
                $logo_desktop = '../assets/images/other-so/' . $desktop_filename;
            }
        }
        
        // Handle mobile logo upload
        if (isset($_FILES['logo_mobile']) && $_FILES['logo_mobile']['error'] === UPLOAD_ERR_OK) {
            // Delete old file
            if ($logo_mobile && file_exists('../../' . $logo_mobile)) {
                unlink('../../' . $logo_mobile);
            }
            
            $file_extension = pathinfo($_FILES['logo_mobile']['name'], PATHINFO_EXTENSION);
            $safe_name = preg_replace('/[^a-zA-Z0-9_-]/', '_', $name);
            $mobile_filename = $safe_name . '_mobile_' . time() . '.' . $file_extension;
            $mobile_path = $upload_dir . $mobile_filename;
            
            if (move_uploaded_file($_FILES['logo_mobile']['tmp_name'], $mobile_path)) {
                $logo_mobile = '../assets/images/other-so/' . $mobile_filename;
            }
        }
        
        // Update database
        $stmt = $conn->prepare("UPDATE other_special_olympics 
            SET name = ?, category = ?, logo_desktop = ?, logo_mobile = ?, 
                website_url = ?, display_order = ?, is_active = ?, updated_at = CURRENT_TIMESTAMP
            WHERE id = ?");
        
        $stmt->bind_param("ssssssii", 
            $name, $category, $logo_desktop, $logo_mobile, $website_url, $display_order, $is_active, $id
        );
        
        if ($stmt->execute()) {
            $response = [
                'success' => true, 
                'message' => 'Organization updated successfully.'
            ];
        } else {
            $response = [
                'success' => false, 
                'message' => 'Database error: ' . $stmt->error
            ];
        }
        
        $stmt->close();
    }
}

/**
 * ============================================================================
 * ACTION: DELETE ORGANIZATION
 * ============================================================================
 */
elseif ($action === 'delete') {
    $id = intval($_POST['id'] ?? 0);
    
    if ($id <= 0) {
        $response = ['success' => false, 'message' => 'Invalid organization ID.'];
    } else {
        // Get file paths before deleting
        $stmt = $conn->prepare("SELECT logo_desktop, logo_mobile FROM other_special_olympics WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $files = $result->fetch_assoc();
        $stmt->close();
        
        // Delete from database
        $stmt = $conn->prepare("DELETE FROM other_special_olympics WHERE id = ?");
        $stmt->bind_param("i", $id);
        
        if ($stmt->execute()) {
            // Delete image files
            if ($files['logo_desktop'] && file_exists('../../' . $files['logo_desktop'])) {
                unlink('../../' . $files['logo_desktop']);
            }
            if ($files['logo_mobile'] && file_exists('../../' . $files['logo_mobile'])) {
                unlink('../../' . $files['logo_mobile']);
            }
            
            $response = [
                'success' => true, 
                'message' => 'Organization deleted successfully.'
            ];
        } else {
            $response = [
                'success' => false, 
                'message' => 'Failed to delete organization: ' . $stmt->error
            ];
        }
        
        $stmt->close();
    }
}

/**
 * ============================================================================
 * ACTION: UPDATE DISPLAY ORDER (Drag & Drop)
 * ============================================================================
 */
elseif ($action === 'update_order') {
    $order_data = json_decode(file_get_contents('php://input'), true);
    
    if (!$order_data || !isset($order_data['order'])) {
        $response = ['success' => false, 'message' => 'Invalid order data.'];
    } else {
        $conn->begin_transaction();
        
        try {
            $stmt = $conn->prepare("UPDATE other_special_olympics SET display_order = ? WHERE id = ?");
            
            foreach ($order_data['order'] as $order => $id) {
                $display_order = ($order + 1) * 10; // 10, 20, 30, etc.
                $stmt->bind_param("ii", $display_order, $id);
                $stmt->execute();
            }
            
            $conn->commit();
            $response = [
                'success' => true, 
                'message' => 'Display order updated successfully.'
            ];
            
            $stmt->close();
        } catch (Exception $e) {
            $conn->rollback();
            $response = [
                'success' => false, 
                'message' => 'Failed to update order: ' . $e->getMessage()
            ];
        }
    }
}

/**
 * ============================================================================
 * ACTION: TOGGLE ACTIVE STATUS
 * ============================================================================
 */
elseif ($action === 'toggle_status') {
    $id = intval($_POST['id'] ?? 0);
    
    if ($id <= 0) {
        $response = ['success' => false, 'message' => 'Invalid organization ID.'];
    } else {
        $stmt = $conn->prepare("UPDATE other_special_olympics 
            SET is_active = NOT is_active, updated_at = CURRENT_TIMESTAMP 
            WHERE id = ?");
        $stmt->bind_param("i", $id);
        
        if ($stmt->execute()) {
            // Get new status
            $stmt2 = $conn->prepare("SELECT is_active FROM other_special_olympics WHERE id = ?");
            $stmt2->bind_param("i", $id);
            $stmt2->execute();
            $result = $stmt2->get_result();
            $row = $result->fetch_assoc();
            
            $response = [
                'success' => true, 
                'message' => 'Status updated successfully.',
                'is_active' => $row['is_active']
            ];
            
            $stmt2->close();
        } else {
            $response = [
                'success' => false, 
                'message' => 'Failed to update status: ' . $stmt->error
            ];
        }
        
        $stmt->close();
    }
}

/**
 * ============================================================================
 * INVALID ACTION HANDLER
 * ============================================================================
 */
else {
    $response = [
        'success' => false, 
        'message' => 'Invalid or missing action parameter.'
    ];
}

// Close database connection
$conn->close();

// Return JSON response
header('Content-Type: application/json');
echo json_encode($response);
exit();
?>
