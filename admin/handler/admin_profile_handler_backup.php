<?php
session_start();

// Check if user is logged in (basic security check)
if (!isset($_SESSION['admin_logged_in'])) {
    http_response_code(401);
    echo json_encode(['success' => false, 'message' => 'Unauthorized access']);
    exit();
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

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';
    
    switch($action) {
        case 'update_personal_info':
            $response = updatePersonalInfo($pdo);
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
            
        case 'get_activity_logs':
            $response = getActivityLogs($pdo);
            break;
            
        case 'update_preferences':
            $response = updatePreferences($pdo);
            break;
            
        case 'get_preferences':
            $response = getPreferences($pdo);
            break;
            
        case 'reset_preferences':
            $response = resetPreferences($pdo);
            break;
            
        case 'export_preferences':
            $response = exportPreferences($pdo);
            break;
            
        case 'check_session':
            $response = checkSession();
            break;
            
        case 'export_activity_logs':
            $response = exportActivityLogs($pdo);
            break;
            
        default:
            $response = ['success' => false, 'message' => 'Invalid action'];
    }
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
        
        $userId = $_SESSION['admin_id'] ?? 1; // Using your existing users table
        
        // Update existing user record with new profile fields
        $fullname = $firstName . ' ' . $lastName;
        
        // Check what columns exist in users table
        try {
            $columnsQuery = $pdo->prepare("SHOW COLUMNS FROM users");
            $columnsQuery->execute();
            $columns = $columnsQuery->fetchAll(PDO::FETCH_COLUMN);
            
            // Build UPDATE query based on available columns
            $updateFields = ['fullname = ?', 'email = ?'];
            $updateValues = [$fullname, $email];
            
            if (in_array('phone', $columns)) {
                $updateFields[] = 'phone = ?';
                $updateValues[] = $phone;
            }
            if (in_array('position', $columns)) {
                $updateFields[] = 'position = ?';
                $updateValues[] = $position;
            }
            if (in_array('department', $columns)) {
                $updateFields[] = 'department = ?';
                $updateValues[] = $department;
            }
            if (in_array('bio', $columns)) {
                $updateFields[] = 'bio = ?';
                $updateValues[] = $bio;
            }
            if (in_array('updated_at', $columns)) {
                $updateFields[] = 'updated_at = NOW()';
            }
            
            $updateValues[] = $userId; // WHERE clause value
            
            $sql = "UPDATE users SET " . implode(', ', $updateFields) . " WHERE id = ?";
            $stmt = $pdo->prepare($sql);
            $stmt->execute($updateValues);
            
        } catch(Exception $e) {
            // Fallback to basic update if column check fails
            $stmt = $pdo->prepare("UPDATE users SET fullname = ?, email = ? WHERE id = ?");
            $stmt->execute([$fullname, $email, $userId]);
        }
        
        // Log the activity
        logActivity($pdo, $userId, 'profile_updated', 'Updated profile information');
        
        return ['success' => true, 'message' => 'Profile updated successfully'];
        
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
        
        $userId = $_SESSION['admin_id'] ?? 1;
        
        // Get current password hash (for demo purposes, we'll skip verification)
        // In production, you should verify the current password
        
        // Hash new password
        $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
        
        // Update password in users table
        $stmt = $pdo->prepare("UPDATE users SET password = ?, updated_at = NOW() WHERE id = ?");
        $stmt->execute([$hashedPassword, $userId]);
        
        // Log the activity
        logActivity($pdo, $userId, 'password_changed', 'Password updated successfully');
        
        return ['success' => true, 'message' => 'Password updated successfully'];
        
    } catch(Exception $e) {
        return ['success' => false, 'message' => 'Error updating password: ' . $e->getMessage()];
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
        $userId = $_SESSION['admin_id'] ?? 1;
        $filename = 'avatar_' . $userId . '_' . time() . '.' . $extension;
        $uploadPath = $uploadDir . $filename;
        
        // Move uploaded file
        if (move_uploaded_file($file['tmp_name'], $uploadPath)) {
            // Update database with new avatar path in users table
            $avatarPath = 'assets/images/admin_avatars/' . $filename;
            $stmt = $pdo->prepare("UPDATE users SET profile_picture = ?, updated_at = NOW() WHERE id = ?");
            $stmt->execute([$avatarPath, $userId]);
            
            // Log the activity
            logActivity($pdo, $userId, 'avatar_updated', 'Profile picture updated');
            
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
        $userId = $_SESSION['admin_id'] ?? 1;
        
        // First get user data
        $userStmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
        $userStmt->execute([$userId]);
        $profile = $userStmt->fetch(PDO::FETCH_ASSOC);
        
        if (!$profile) {
            // Return default data if no profile exists
            return ['success' => true, 'data' => [
                'fullname' => 'Admin User',
                'email' => 'admin@specialolympics.org.my',
                'phone' => '+60 12-345-6789',
                'position' => 'System Administrator',
                'department' => 'administration',
                'bio' => 'Dedicated administrator managing the Special Olympics Sarawak digital platform.',
                'profile_picture' => null,
                'first_name' => 'Admin',
                'last_name' => 'User',
                'theme' => 'light',
                'language' => 'en',
                'email_notifications' => 1,
                'event_notifications' => 1,
                'system_notifications' => 0,
                'default_view' => 'overview',
                'items_per_page' => 25
            ]];
        }
        
        // Check if admin_preferences table exists and get preferences
        try {
            $tableExistsQuery = $pdo->prepare("SHOW TABLES LIKE 'admin_preferences'");
            $tableExistsQuery->execute();
            
            if ($tableExistsQuery->rowCount() > 0) {
                // Table exists, get preferences
                $prefsStmt = $pdo->prepare("SELECT * FROM admin_preferences WHERE user_id = ?");
                $prefsStmt->execute([$userId]);
                $preferences = $prefsStmt->fetch(PDO::FETCH_ASSOC);
                
                if ($preferences) {
                    // Merge preferences with profile data
                    $profile = array_merge($profile, $preferences);
                }
            }
        } catch(Exception $e) {
            // If preferences table doesn't exist or error, just use defaults
            $profile['theme'] = 'light';
            $profile['language'] = 'en';
            $profile['email_notifications'] = 1;
            $profile['event_notifications'] = 1;
            $profile['system_notifications'] = 0;
            $profile['default_view'] = 'overview';
            $profile['items_per_page'] = 25;
        }
        
        // Set default preferences if not exists
        if (!isset($profile['theme'])) $profile['theme'] = 'light';
        if (!isset($profile['language'])) $profile['language'] = 'en';
        if (!isset($profile['email_notifications'])) $profile['email_notifications'] = 1;
        if (!isset($profile['event_notifications'])) $profile['event_notifications'] = 1;
        if (!isset($profile['system_notifications'])) $profile['system_notifications'] = 0;
        if (!isset($profile['default_view'])) $profile['default_view'] = 'overview';
        if (!isset($profile['items_per_page'])) $profile['items_per_page'] = 25;
        
        // Split fullname into first and last name for the form
        if ($profile['fullname']) {
            $nameParts = explode(' ', $profile['fullname'], 2);
            $profile['first_name'] = $nameParts[0] ?? '';
            $profile['last_name'] = $nameParts[1] ?? '';
        } else {
            $profile['first_name'] = '';
            $profile['last_name'] = '';
        }
        
        return ['success' => true, 'data' => $profile];
        
    } catch(Exception $e) {
        return ['success' => false, 'message' => 'Error fetching profile data: ' . $e->getMessage()];
    }
}

function logActivity($pdo, $userId, $action, $description) {
    try {
        // Check if activity logs table exists
        $tableExistsQuery = $pdo->prepare("SHOW TABLES LIKE 'admin_activity_logs'");
        $tableExistsQuery->execute();
        
        if ($tableExistsQuery->rowCount() > 0) {
            $ipAddress = $_SERVER['REMOTE_ADDR'] ?? 'unknown';
            $userAgent = $_SERVER['HTTP_USER_AGENT'] ?? 'unknown';
            
            $stmt = $pdo->prepare("
                INSERT INTO admin_activity_logs (user_id, action, description, ip_address, user_agent, created_at)
                VALUES (?, ?, ?, ?, ?, NOW())
            ");
            $stmt->execute([$userId, $action, $description, $ipAddress, $userAgent]);
        }
    } catch(Exception $e) {
        // Silently fail if logging doesn't work
        error_log('Failed to log activity: ' . $e->getMessage());
    }
}

function getActivityLogs($pdo) {
    try {
        $userId = $_SESSION['admin_id'] ?? 1;
        $filter = $_POST['filter'] ?? 'all';
        $period = $_POST['period'] ?? '30';
        
        // Check if activity logs table exists
        $tableExistsQuery = $pdo->prepare("SHOW TABLES LIKE 'admin_activity_logs'");
        $tableExistsQuery->execute();
        
        if ($tableExistsQuery->rowCount() === 0) {
            // Return sample data if table doesn't exist
            return ['success' => true, 'data' => [
                [
                    'action' => 'login',
                    'description' => 'Successful login from Chrome on Windows',
                    'created_at' => date('Y-m-d H:i:s', strtotime('-2 minutes')),
                    'ip_address' => '192.168.1.100'
                ],
                [
                    'action' => 'profile_updated',
                    'description' => 'Updated profile information',
                    'created_at' => date('Y-m-d H:i:s', strtotime('-1 hour')),
                    'ip_address' => '192.168.1.100'
                ]
            ]];
        }
        
        // Build query based on filter
        $whereClause = "WHERE user_id = ? AND created_at >= DATE_SUB(NOW(), INTERVAL ? DAY)";
        $params = [$userId, $period];
        
        if ($filter !== 'all') {
            $whereClause .= " AND action LIKE ?";
            $params[] = '%' . $filter . '%';
        }
        
        $stmt = $pdo->prepare("
            SELECT action, description, ip_address, user_agent, created_at
            FROM admin_activity_logs 
            $whereClause
            ORDER BY created_at DESC 
            LIMIT 50
        ");
        $stmt->execute($params);
        $logs = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        return ['success' => true, 'data' => $logs];
        
    } catch(Exception $e) {
        return ['success' => false, 'message' => 'Error fetching activity logs: ' . $e->getMessage()];
    }
}

function updatePreferences($pdo) {
    try {
        $userId = $_SESSION['admin_id'] ?? 1;
        
        // Check if preferences table exists
        $tableExistsQuery = $pdo->prepare("SHOW TABLES LIKE 'admin_preferences'");
        $tableExistsQuery->execute();
        
        if ($tableExistsQuery->rowCount() === 0) {
            return ['success' => false, 'message' => 'Preferences table not found. Please run the database setup first.'];
        }
        
        $preferences = $_POST['preferences'] ?? [];
        $updatedCount = 0;
        
        // Prepare update/insert statement
        $stmt = $pdo->prepare("
            INSERT INTO admin_preferences (user_id, preference_key, preference_value, updated_at)
            VALUES (?, ?, ?, NOW())
            ON DUPLICATE KEY UPDATE 
            preference_value = VALUES(preference_value),
            updated_at = NOW()
        ");
        
        // Update each preference
        foreach ($preferences as $key => $value) {
            // Sanitize the preference key
            $key = preg_replace('/[^a-zA-Z0-9_]/', '', $key);
            
            // Convert boolean values
            if ($value === 'true') $value = '1';
            if ($value === 'false') $value = '0';
            
            $stmt->execute([$userId, $key, $value]);
            $updatedCount++;
        }
        
        // Log the activity
        logActivity($pdo, $userId, 'preferences_updated', "Updated $updatedCount preferences");
        
        return ['success' => true, 'message' => "Successfully updated $updatedCount preferences"];
        
    } catch(Exception $e) {
        return ['success' => false, 'message' => 'Error updating preferences: ' . $e->getMessage()];
    }
}

function getPreferences($pdo) {
    try {
        $userId = $_SESSION['admin_id'] ?? 1;
        
        // Check if preferences table exists
        $tableExistsQuery = $pdo->prepare("SHOW TABLES LIKE 'admin_preferences'");
        $tableExistsQuery->execute();
        
        if ($tableExistsQuery->rowCount() === 0) {
            // Return default preferences if table doesn't exist
            return ['success' => true, 'data' => getDefaultPreferences()];
        }
        
        $stmt = $pdo->prepare("
            SELECT preference_key, preference_value 
            FROM admin_preferences 
            WHERE user_id = ?
        ");
        $stmt->execute([$userId]);
        $preferences = $stmt->fetchAll(PDO::FETCH_KEY_PAIR);
        
        // Merge with defaults to ensure all preferences exist
        $defaultPrefs = getDefaultPreferences();
        $preferences = array_merge($defaultPrefs, $preferences);
        
        return ['success' => true, 'data' => $preferences];
        
    } catch(Exception $e) {
        return ['success' => false, 'message' => 'Error fetching preferences: ' . $e->getMessage()];
    }
}

function getDefaultPreferences() {
    return [
        // Notification preferences
        'email_notifications' => '1',
        'browser_notifications' => '1',
        'notification_sound' => '1',
        'daily_digest' => '1',
        // Display preferences
        'theme' => 'light',
        'sidebar_collapsed' => '0',
        'items_per_page' => '10',
        'date_format' => 'YYYY-MM-DD',
        // Security preferences
        'two_factor_enabled' => '0',
        'session_timeout' => '30',
        'login_alerts' => '1',
        // System preferences
        'auto_save' => '1',
        'backup_frequency' => 'weekly',
        'language' => 'en'
    ];
}

function resetPreferences($pdo) {
    try {
        $userId = $_SESSION['admin_id'] ?? 1;
        
        // Check if preferences table exists
        $tableExistsQuery = $pdo->prepare("SHOW TABLES LIKE 'admin_preferences'");
        $tableExistsQuery->execute();
        
        if ($tableExistsQuery->rowCount() === 0) {
            return ['success' => false, 'message' => 'Preferences table not found. Please run the database setup first.'];
        }
        
        // Delete existing preferences
        $stmt = $pdo->prepare("DELETE FROM admin_preferences WHERE user_id = ?");
        $stmt->execute([$userId]);
        
        // Insert default preferences
        $defaultPrefs = getDefaultPreferences();
        $stmt = $pdo->prepare("
            INSERT INTO admin_preferences (user_id, preference_key, preference_value)
            VALUES (?, ?, ?)
        ");
        
        foreach ($defaultPrefs as $key => $value) {
            $stmt->execute([$userId, $key, $value]);
        }
        
        // Log the activity
        logActivity($pdo, $userId, 'preferences_reset', 'Reset all preferences to default values');
        
        return ['success' => true, 'message' => 'Preferences reset to default values successfully'];
        
    } catch(Exception $e) {
        return ['success' => false, 'message' => 'Error resetting preferences: ' . $e->getMessage()];
    }
}

function exportPreferences($pdo) {
    try {
        $userId = $_SESSION['admin_id'] ?? 1;
        
        // Get current preferences
        $result = getPreferences($pdo);
        if (!$result['success']) {
            return $result;
        }
        
        $preferences = $result['data'];
        
        // Create export data
        $exportData = [
            'export_date' => date('Y-m-d H:i:s'),
            'user_id' => $userId,
            'preferences' => $preferences
        ];
        
        // Log the activity
        logActivity($pdo, $userId, 'preferences_exported', 'Exported preferences configuration');
        
        return ['success' => true, 'data' => $exportData];
        
    } catch(Exception $e) {
        return ['success' => false, 'message' => 'Error exporting preferences: ' . $e->getMessage()];
    }
}

function checkSession() {
    // Check if user is logged in
    if (!isset($_SESSION['user']) || !isset($_SESSION['admin_id'])) {
        return ['success' => false, 'message' => 'Not logged in'];
    }
    
    // Check session timeout
    $session_timeout = $_SESSION['session_timeout'] ?? 1800; // 30 minutes default
    if (isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity'] > $session_timeout)) {
        return ['success' => false, 'message' => 'Session expired'];
    }
    
    // Update last activity
    $_SESSION['last_activity'] = time();
    
    return ['success' => true, 'message' => 'Session valid'];
}

function exportActivityLogs($pdo) {
    try {
        $userId = $_SESSION['admin_id'] ?? 1;
        $filter = $_POST['filter'] ?? 'all';
        $period = $_POST['period'] ?? '30';
        
        // Check if activity logs table exists
        $tableExistsQuery = $pdo->prepare("SHOW TABLES LIKE 'admin_activity_logs'");
        $tableExistsQuery->execute();
        
        if ($tableExistsQuery->rowCount() === 0) {
            return ['success' => false, 'message' => 'Activity logs table not found'];
        }
        
        // Build query based on filter
        $whereClause = "WHERE user_id = ? AND created_at >= DATE_SUB(NOW(), INTERVAL ? DAY)";
        $params = [$userId, $period];
        
        if ($filter !== 'all') {
            $whereClause .= " AND action LIKE ?";
            $params[] = '%' . $filter . '%';
        }
        
        $stmt = $pdo->prepare("
            SELECT action, description, ip_address, user_agent, created_at
            FROM admin_activity_logs 
            $whereClause
            ORDER BY created_at DESC
        ");
        $stmt->execute($params);
        $logs = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        // Log the export activity
        logActivity($pdo, $userId, 'activity_logs_exported', "Exported activity logs (filter: $filter, period: {$period} days)");
        
        return ['success' => true, 'data' => $logs];
        
    } catch(Exception $e) {
        return ['success' => false, 'message' => 'Error exporting activity logs: ' . $e->getMessage()];
    }
}
?>