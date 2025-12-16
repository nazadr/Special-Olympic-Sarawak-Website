<?php
// Update password hash in database
$password = 'Abcd!234';
$hash = password_hash($password, PASSWORD_DEFAULT);

echo "Generating new hash for password: $password<br>";
echo "New hash: $hash<br><br>";

// Connect to database
$conn = new mysqli("localhost", "root", "", "so_sarawak_db");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Update the password using prepared statement to avoid escaping issues
$stmt = $conn->prepare("UPDATE users SET password = ? WHERE email = 'sosarawak@gmail.com'");
$stmt->bind_param("s", $hash);

if ($stmt->execute()) {
    echo "<strong style='color:#10b981;'>✅ Password updated successfully!</strong><br><br>";
    
    // Verify it was stored correctly
    $verify_stmt = $conn->prepare("SELECT email, password FROM users WHERE email = 'sosarawak@gmail.com'");
    $verify_stmt->execute();
    $result = $verify_stmt->get_result();
    
    if ($row = $result->fetch_assoc()) {
        echo "Stored hash: " . $row['password'] . "<br><br>";
        
        // Test verification
        if (password_verify($password, $row['password'])) {
            echo "<strong style='color:#10b981;font-size:18px;'>✅✅✅ PASSWORD VERIFICATION: SUCCESS ✅✅✅</strong><br>";
            echo "Login will now work!<br><br>";
        } else {
            echo "<strong style='color:#ef4444;'>❌ Verification still failed!</strong><br>";
        }
    }
    
    $verify_stmt->close();
} else {
    echo "<strong style='color:#ef4444;'>❌ Failed to update password: " . $stmt->error . "</strong>";
}

$stmt->close();
$conn->close();

echo "<hr>";
echo "<h3>Login Credentials:</h3>";
echo "Email: sosarawak@gmail.com<br>";
echo "Password: Abcd!234<br><br>";
echo "<a href='test_login.php' style='padding:10px 20px;background:#3b82f6;color:white;text-decoration:none;border-radius:4px;'>Test Again</a> ";
echo "<a href='login_page_v1.php' style='padding:10px 20px;background:#10b981;color:white;text-decoration:none;border-radius:4px;margin-left:10px;'>Go to Login</a>";
?>
