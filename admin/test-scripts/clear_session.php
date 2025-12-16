<?php
// Clear all sessions
session_start();
session_unset();
session_destroy();

// Clear session cookie
if (isset($_COOKIE[session_name()])) {
    setcookie(session_name(), '', time()-3600, '/');
}

echo "<html><head><title>Session Cleared</title>";
echo "<style>body{font-family:monospace;padding:40px;background:#0f172a;color:#e2e8f0;text-align:center;} h1{color:#10b981;margin-bottom:20px;} .btn{display:inline-block;margin:10px;padding:12px 24px;background:#3b82f6;color:white;text-decoration:none;border-radius:6px;} .btn:hover{background:#2563eb;}</style>";
echo "</head><body>";
echo "<h1>✅ All Sessions Cleared</h1>";
echo "<p>All PHP sessions have been destroyed.</p>";
echo "<p>Session cookies have been cleared.</p>";
echo "<br><br>";
echo "<a href='login_page_v1.php' class='btn'>Go to Login Page</a>";
echo "<a href='test_login.php' class='btn'>Test Login Credentials</a>";
echo "</body></html>";
?>
