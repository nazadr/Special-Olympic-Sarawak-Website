<?php
// Test login credentials
$test_password = 'Abcd!234';

// Connect to database
$conn = new mysqli("localhost", "root", "", "so_sarawak_db");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get user from database
$stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
$email = 'sosarawak@gmail.com';
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

echo "<h1>Login Test Results</h1>";
echo "<style>body{font-family:monospace;padding:20px;background:#0f172a;color:#e2e8f0;} h1{color:#60a5fa;} .success{color:#10b981;} .error{color:#ef4444;} pre{background:#1e293b;padding:15px;border-radius:4px;}</style>";

if ($row = $result->fetch_assoc()) {
    echo "<h2>✅ User Found</h2>";
    echo "<pre>";
    echo "ID: " . $row['id'] . "\n";
    echo "Full Name: " . $row['fullname'] . "\n";
    echo "Email: " . $row['email'] . "\n";
    echo "Phone: " . $row['phone'] . "\n";
    echo "Position: " . $row['position'] . "\n";
    echo "\nPassword Hash (from DB): " . $row['password'] . "\n";
    echo "</pre>";
    
    echo "<h2>🔐 Password Verification Test</h2>";
    echo "<pre>";
    echo "Test Password: <strong>$test_password</strong>\n\n";
    
    // Test password verification
    if (password_verify($test_password, $row['password'])) {
        echo "<span class='success'>✅✅✅ PASSWORD VERIFICATION: SUCCESS ✅✅✅</span>\n";
        echo "Login should work with this password!\n";
    } else {
        echo "<span class='error'>❌ PASSWORD VERIFICATION: FAILED</span>\n";
        echo "Login will NOT work with this password.\n";
    }
    echo "</pre>";
    
    // Generate new hash for comparison
    echo "<h2>🔄 Fresh Password Hash</h2>";
    echo "<pre>";
    $new_hash = password_hash($test_password, PASSWORD_DEFAULT);
    echo "New hash generated: $new_hash\n";
    echo "Verify with new hash: " . (password_verify($test_password, $new_hash) ? '<span class="success">✅ Works</span>' : '<span class="error">❌ Failed</span>');
    echo "</pre>";
    
} else {
    echo "<h2 class='error'>❌ No User Found</h2>";
    echo "<p>No user with email: $email</p>";
}

$stmt->close();
$conn->close();

echo "<hr style='margin:30px 0;border-color:#334155;'>";
echo "<h2>📋 Login Instructions</h2>";
echo "<pre>";
echo "Email: sosarawak@gmail.com\n";
echo "Password: Abcd!234\n\n";
echo "Login URL: http://localhost/Special-Olympic-Sarawak-Website-Staging-environment/admin/login_page_v1.php";
echo "</pre>";
?>
