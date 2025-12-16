<?php
session_start();

// Log logout activity before destroying session (optional - only if table exists)
if (isset($_SESSION['admin_id'])) {
    try {
        $conn = new mysqli("localhost", "root", "", "so_sarawak_db");
        if (!$conn->connect_error) {
            // Check if the activity logs table exists first
            $table_check = $conn->query("SHOW TABLES LIKE 'admin_activity_logs'");
            if ($table_check && $table_check->num_rows > 0) {
                $admin_id = $_SESSION['admin_id'];
                $logout_ip = $_SERVER['REMOTE_ADDR'] ?? 'unknown';
                $user_agent = $_SERVER['HTTP_USER_AGENT'] ?? 'unknown';
                
                // Log to activity table
                $log_stmt = $conn->prepare("INSERT INTO admin_activity_logs (user_id, action, description, ip_address, user_agent, created_at) VALUES (?, 'logout', ?, ?, ?, NOW())");
                $logout_description = 'User logged out from ' . $logout_ip;
                if ($log_stmt) {
                    $log_stmt->bind_param("isss", $admin_id, $logout_description, $logout_ip, $user_agent);
                    $log_stmt->execute();
                    $log_stmt->close();
                }
            }
            $conn->close();
        }
    } catch (mysqli_sql_exception $e) {
        // Silently handle any database errors during logout
        // Don't prevent logout if logging fails
    }
}

// Clear all session data
session_unset();
session_destroy();

// Delete session cookie
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

// Prevent caching
header("Cache-Control: no-cache, no-store, must-revalidate");
header("Pragma: no-cache");
header("Expires: 0");

// Start a new session to show logout message
session_start();
header("Location: login_page_v1.php?message=logged_out");
exit();
?>
