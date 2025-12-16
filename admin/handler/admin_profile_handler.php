<?php
header('Content-Type: application/json');

// Start session only if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Check if user is logged in - but be more lenient for debugging
if (!isset($_SESSION['user']) || !isset($_SESSION['admin_id'])) {
    // For debugging, create a test session
    $_SESSION['user'] = 'SO Sarawak Admin';
    $_SESSION['admin_id'] = 1;
    $_SESSION['admin_email'] = 'sosarawak@gmail.com';
}

// Database connection (adjust these settings as needed)
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "so_sarawak_db";

try {
    $pdo = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Database connection failed']);
    exit();
}

$response = ['success' => false, 'message' => 'Invalid request'];

// Handle both POST and GET requests for debugging
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';
} elseif ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $action = $_GET['action'] ?? '';
} else {
    $action = '';
}

if (!empty($action)) {
    switch($action) {
        case 'update_personal_info':
            $response = updatePersonalInfo($pdo);
            break;
            
        case 'update_profile_info':
            $response = updateProfileInfo($pdo);
            break;
            
        case 'change_password':
            $response = changePassword($pdo);
            break;
            
        case 'update_preferences':
            $response = updatePreferences($pdo);
            break;
            
        case 'upload_avatar':
            $response = uploadAvatar($pdo);
            break;
            
        case 'get_profile_data':
            $response = getProfileData($pdo);
            break;
            
        case 'update_profile':
            $response = updateProfile($pdo);
            break;
            
        default:
            $response = ['success' => false, 'message' => 'Invalid action'];
    }
} else {
    $response = ['success' => false, 'message' => 'No action specified'];
}

echo json_encode($response);

function updatePersonalInfo($pdo) {
    try {
        $firstName = $_POST['firstName'] ?? '';
        $lastName = $_POST['lastName'] ?? '';
        $email = $_POST['email'] ?? '';
        $phone = $_POST['phone'] ?? '';
        $position = $_POST['position'] ?? '';
        $department = $_POST['department'] ?? '';
        $bio = $_POST['bio'] ?? '';
        
        // Validate required fields
        if (empty($firstName) || empty($lastName) || empty($email)) {
            return ['success' => false, 'message' => 'First name, last name, and email are required'];
        }
        
        // Validate email format
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return ['success' => false, 'message' => 'Invalid email format'];
        }
        
        $adminId = $_SESSION['admin_id'] ?? 1; // Default to 1 for demo
        
        // Check if profile record exists
        $checkStmt = $pdo->prepare("SELECT id FROM admin_profiles WHERE admin_id = ?");
        $checkStmt->execute([$adminId]);
        
        if ($checkStmt->rowCount() > 0) {
            // Update existing record
            $stmt = $pdo->prepare("
                UPDATE admin_profiles 
                SET first_name = ?, last_name = ?, email = ?, phone = ?, position = ?, department = ?, bio = ?, updated_at = NOW()
                WHERE admin_id = ?
            ");
            $stmt->execute([$firstName, $lastName, $email, $phone, $position, $department, $bio, $adminId]);
        } else {
            // Insert new record
            $stmt = $pdo->prepare("
                INSERT INTO admin_profiles (admin_id, first_name, last_name, email, phone, position, department, bio, created_at, updated_at)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, NOW(), NOW())
            ");
            $stmt->execute([$adminId, $firstName, $lastName, $email, $phone, $position, $department, $bio]);
        }
        
        return ['success' => true, 'message' => 'Profile updated successfully'];
        
    } catch(Exception $e) {
        return ['success' => false, 'message' => 'Error updating profile: ' . $e->getMessage()];
    }
}

function updateProfileInfo($pdo) {
    try {
        // Check if admin_id exists in session
        if (!isset($_SESSION['admin_id'])) {
            return ['success' => false, 'message' => 'Session expired. Please log in again.'];
        }
        
        $fullname = trim($_POST['fullname'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $phone = trim($_POST['phone'] ?? '');
        $position = trim($_POST['position'] ?? '');
        $bio = trim($_POST['bio'] ?? '');
        
        // Validate required fields
        if (empty($fullname) || empty($email)) {
            return ['success' => false, 'message' => 'Full name and email are required'];
        }
        
        // Validate email format
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return ['success' => false, 'message' => 'Invalid email format'];
        }
        
        $adminId = $_SESSION['admin_id'];
        
        // Update user record in the users table
        $stmt = $pdo->prepare("
            UPDATE users 
            SET fullname = ?, email = ?, phone = ?, position = ?, bio = ?, updated_at = NOW()
            WHERE id = ?
        ");
        $stmt->execute([$fullname, $email, $phone, $position, $bio, $adminId]);
        
        if ($stmt->rowCount() > 0) {
            return ['success' => true, 'message' => 'Profile updated successfully'];
        } else {
            return ['success' => false, 'message' => 'No changes were made or user not found'];
        }
        
    } catch(Exception $e) {
        return ['success' => false, 'message' => 'Error updating profile: ' . $e->getMessage()];
    }
}

function changePassword($pdo) {
    try {
        $currentPassword = $_POST['currentPassword'] ?? '';
        $newPassword = $_POST['newPassword'] ?? '';
        $confirmPassword = $_POST['confirmPassword'] ?? '';
        
        // Validate passwords
        if (empty($currentPassword) || empty($newPassword) || empty($confirmPassword)) {
            return ['success' => false, 'message' => 'All password fields are required'];
        }
        
        if ($newPassword !== $confirmPassword) {
            return ['success' => false, 'message' => 'New passwords do not match'];
        }
        
        if (strlen($newPassword) < 8) {
            return ['success' => false, 'message' => 'Password must be at least 8 characters long'];
        }
        
        $adminId = $_SESSION['admin_id'];
        
        // Verify current password
        $verify_stmt = $pdo->prepare("SELECT password FROM users WHERE id = ?");
        $verify_stmt->execute([$adminId]);
        $result = $verify_stmt->fetch();
        
        if (!$result || !password_verify($currentPassword, $result['password'])) {
            return ['success' => false, 'message' => 'Current password is incorrect'];
        }
        
        // Hash new password
        $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
        
        // Update password in database
        $stmt = $pdo->prepare("UPDATE users SET password = ? WHERE id = ?");
        $stmt->execute([$hashedPassword, $adminId]);
        
        return ['success' => true, 'message' => 'Password updated successfully'];
        
    } catch(Exception $e) {
        return ['success' => false, 'message' => 'Error updating password: ' . $e->getMessage()];
    }
}

function updatePreferences($pdo) {
    try {
        $theme = $_POST['theme'] ?? 'light';
        $language = $_POST['language'] ?? 'en';
        $emailNotifications = isset($_POST['emailNotifications']) ? 1 : 0;
        $eventNotifications = isset($_POST['eventNotifications']) ? 1 : 0;
        $systemNotifications = isset($_POST['systemNotifications']) ? 1 : 0;
        $defaultView = $_POST['defaultView'] ?? 'overview';
        $itemsPerPage = $_POST['itemsPerPage'] ?? 25;
        
        $adminId = $_SESSION['admin_id'] ?? 1;
        
        // Check if preferences record exists
        $checkStmt = $pdo->prepare("SELECT id FROM admin_preferences WHERE admin_id = ?");
        $checkStmt->execute([$adminId]);
        
        if ($checkStmt->rowCount() > 0) {
            // Update existing record
            $stmt = $pdo->prepare("
                UPDATE admin_preferences 
                SET theme = ?, language = ?, email_notifications = ?, event_notifications = ?, 
                    system_notifications = ?, default_view = ?, items_per_page = ?, updated_at = NOW()
                WHERE admin_id = ?
            ");
            $stmt->execute([$theme, $language, $emailNotifications, $eventNotifications, 
                          $systemNotifications, $defaultView, $itemsPerPage, $adminId]);
        } else {
            // Insert new record
            $stmt = $pdo->prepare("
                INSERT INTO admin_preferences (admin_id, theme, language, email_notifications, event_notifications, 
                                             system_notifications, default_view, items_per_page, created_at, updated_at)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, NOW(), NOW())
            ");
            $stmt->execute([$adminId, $theme, $language, $emailNotifications, $eventNotifications, 
                          $systemNotifications, $defaultView, $itemsPerPage]);
        }
        
        return ['success' => true, 'message' => 'Preferences updated successfully'];
        
    } catch(Exception $e) {
        return ['success' => false, 'message' => 'Error updating preferences: ' . $e->getMessage()];
    }
}

function uploadAvatar($pdo) {
    try {
        if (!isset($_FILES['avatar']) || $_FILES['avatar']['error'] !== UPLOAD_ERR_OK) {
            return ['success' => false, 'message' => 'No file uploaded or upload error'];
        }
        
        $file = $_FILES['avatar'];
        
        // Validate file size (2MB max)
        if ($file['size'] > 2 * 1024 * 1024) {
            return ['success' => false, 'message' => 'File size must be less than 2MB'];
        }
        
        // Validate file type
        $allowedTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif'];
        if (!in_array($file['type'], $allowedTypes)) {
            return ['success' => false, 'message' => 'Invalid file type. Only JPG, PNG, and GIF are allowed'];
        }
        
        // Create upload directory if it doesn't exist
        $uploadDir = '../assets/images/admin_avatars/';
        if (!file_exists($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }
        
        // Generate unique filename
        $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
        $adminId = $_SESSION['admin_id'] ?? 1;
        $filename = 'avatar_' . $adminId . '_' . time() . '.' . $extension;
        $uploadPath = $uploadDir . $filename;
        
        // Move uploaded file
        if (move_uploaded_file($file['tmp_name'], $uploadPath)) {
            // Update database with new avatar path
            $avatarPath = 'assets/images/admin_avatars/' . $filename;
            $stmt = $pdo->prepare("UPDATE admin_profiles SET avatar = ?, updated_at = NOW() WHERE admin_id = ?");
            $stmt->execute([$avatarPath, $adminId]);
            
            return ['success' => true, 'message' => 'Avatar uploaded successfully', 'avatar_url' => '../' . $avatarPath];
        } else {
            return ['success' => false, 'message' => 'Failed to upload file'];
        }
        
    } catch(Exception $e) {
        return ['success' => false, 'message' => 'Error uploading avatar: ' . $e->getMessage()];
    }
}

function getProfileData($pdo) {
    try {
        // Check if admin_id exists in session
        if (!isset($_SESSION['admin_id'])) {
            return ['success' => false, 'message' => 'Session expired. Please log in again.'];
        }
        
        $adminId = $_SESSION['admin_id'];
        
        // Get profile data from users table
        $stmt = $pdo->prepare("
            SELECT id, fullname, email, phone, position, bio, profile_photo, created_at, updated_at
            FROM users
            WHERE id = ?
        ");
        $stmt->execute([$adminId]);
        $profile = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if (!$profile) {
            return ['success' => false, 'message' => 'User profile not found.'];
        }
        
        return ['success' => true, 'data' => $profile];
        
    } catch(Exception $e) {
        return ['success' => false, 'message' => 'Error fetching profile data: ' . $e->getMessage()];
    }
}

function updateProfile($pdo) {
    try {
        error_log("updateProfile called with POST data: " . print_r($_POST, true));
        error_log("FILES data: " . print_r($_FILES, true));
        
        $admin_id = $_POST['admin_id'] ?? '';
        $fullname = trim($_POST['fullname'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $phone = trim($_POST['phone'] ?? '');
        $position = trim($_POST['position'] ?? '');
        $bio = trim($_POST['bio'] ?? '');
        
        // Validation
        if (empty($admin_id) || empty($fullname) || empty($email)) {
            return ['success' => false, 'message' => 'Required fields are missing'];
        }
        
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return ['success' => false, 'message' => 'Invalid email format'];
        }
        
        // Check if email is already taken by another user
        $email_check = $pdo->prepare("SELECT id FROM users WHERE email = ? AND id != ?");
        $email_check->execute([$email, $admin_id]);
        if ($email_check->rowCount() > 0) {
            return ['success' => false, 'message' => 'Email is already in use'];
        }
        
        // Handle profile photo upload
        $profile_photo = $_POST['currentProfilePhoto'] ?? '';
        if (isset($_FILES['profilePhoto']) && $_FILES['profilePhoto']['error'] === UPLOAD_ERR_OK) {
            $photo_result = handlePhotoUploadPDO($_FILES['profilePhoto'], $profile_photo);
            if (!$photo_result['success']) {
                return $photo_result;
            }
            $profile_photo = $photo_result['filename'];
        }
        
        // Check if users table has all required columns, if not add them
        $columns_to_add = [
            'phone' => 'VARCHAR(20)',
            'position' => 'VARCHAR(100)',
            'bio' => 'TEXT',
            'profile_photo' => 'VARCHAR(255)'
        ];
        
        foreach ($columns_to_add as $column => $type) {
            $column_check = $pdo->query("SHOW COLUMNS FROM users LIKE '$column'");
            if ($column_check->rowCount() === 0) {
                $pdo->exec("ALTER TABLE users ADD COLUMN $column $type");
            }
        }
        
        // Remove the redundant profile_picture column if it exists
        $redundant_check = $pdo->query("SHOW COLUMNS FROM users LIKE 'profile_picture'");
        if ($redundant_check->rowCount() > 0) {
            $pdo->exec("ALTER TABLE users DROP COLUMN profile_picture");
        }
        
        // Update user profile
        $update_stmt = $pdo->prepare("UPDATE users SET fullname = ?, email = ?, phone = ?, position = ?, bio = ?, profile_photo = ? WHERE id = ?");
        
        error_log("Updating user profile for ID: $admin_id with photo: $profile_photo");
        
        if ($update_stmt->execute([$fullname, $email, $phone, $position, $bio, $profile_photo, $admin_id])) {
            // Update session variables
            $_SESSION['user'] = $fullname;
            $_SESSION['admin_email'] = $email;
            
            error_log("Profile updated successfully for user ID: $admin_id");
            return ['success' => true, 'message' => 'Profile updated successfully', 'profile_photo' => $profile_photo];
        } else {
            $error_info = $update_stmt->errorInfo();
            error_log("Database error: " . print_r($error_info, true));
            return ['success' => false, 'message' => 'Failed to update profile: ' . $error_info[2]];
        }
        
    } catch(Exception $e) {
        return ['success' => false, 'message' => 'Error updating profile: ' . $e->getMessage()];
    }
}

function handlePhotoUploadPDO($file, $current_photo = '') {
    // Use absolute path from document root
    $upload_dir = $_SERVER['DOCUMENT_ROOT'] . '/Special-Olympic-Sarawak-Website-Staging-environment/assets/images/avatars/';
    
    // Create directory if it doesn't exist
    if (!file_exists($upload_dir)) {
        mkdir($upload_dir, 0777, true);
    }
    
    $allowed_types = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif'];
    $max_file_size = 5 * 1024 * 1024; // 5MB
    
    // Add debugging info
    error_log("File upload attempt: " . $file['name'] . " Size: " . $file['size'] . " Type: " . $file['type']);
    
    // Check for upload errors
    if ($file['error'] !== UPLOAD_ERR_OK) {
        return ['success' => false, 'message' => 'File upload error: ' . $file['error']];
    }
    
    // Get real mime type
    $finfo = finfo_open(FILEINFO_MIME_TYPE);
    $mime_type = finfo_file($finfo, $file['tmp_name']);
    finfo_close($finfo);
    
    // Validate file type using real mime type
    if (!in_array($mime_type, $allowed_types)) {
        return ['success' => false, 'message' => 'Invalid file type. Only JPG, PNG, and GIF are allowed. Detected: ' . $mime_type];
    }
    
    if ($file['size'] > $max_file_size) {
        return ['success' => false, 'message' => 'File size too large. Maximum 5MB allowed.'];
    }
    
    // Generate unique filename
    $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
    $filename = 'profile_' . $_SESSION['admin_id'] . '_' . time() . '.' . $extension;
    $upload_path = $upload_dir . $filename;
    
    // Move uploaded file
    if (move_uploaded_file($file['tmp_name'], $upload_path)) {
        // Verify file was uploaded successfully
        if (!file_exists($upload_path)) {
            return ['success' => false, 'message' => 'File upload failed - file not found after move'];
        }
        
        // Delete old photo if exists
        if (!empty($current_photo) && file_exists($upload_dir . $current_photo)) {
            unlink($upload_dir . $current_photo);
        }
        
        error_log("Photo uploaded successfully: " . $upload_path);
        return ['success' => true, 'filename' => $filename];
    } else {
        $error_msg = 'Failed to upload photo. Check directory permissions: ' . $upload_dir;
        error_log($error_msg);
        return ['success' => false, 'message' => $error_msg];
    }
}
?>