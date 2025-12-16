<?php
session_start();

// Set up debug session
$_SESSION['user'] = 'Debug Admin';
$_SESSION['admin_id'] = 2;

echo "<html><head><title>Profile API Debug Test</title>";
echo "<style>
    body { font-family: 'Courier New', monospace; padding: 20px; background: #1e293b; color: #e2e8f0; }
    .test { background: #334155; padding: 20px; margin: 15px 0; border-radius: 8px; border-left: 4px solid #3b82f6; }
    .success { border-left-color: #10b981; }
    .error { border-left-color: #ef4444; }
    h1, h2 { color: #60a5fa; }
    pre { background: #0f172a; padding: 15px; border-radius: 4px; overflow-x: auto; }
    .label { color: #94a3b8; font-weight: bold; }
</style></head><body>";

echo "<h1>🔍 Profile API Comprehensive Debug Test</h1>";
echo "<p>Testing admin_profile_handler.php endpoint with current session</p>";

// Test 1: Session Check
echo "<div class='test'>";
echo "<h2>Test 1: Session Variables</h2>";
echo "<pre>";
echo "Session Status: " . (session_status() === PHP_SESSION_ACTIVE ? "✓ ACTIVE" : "✗ INACTIVE") . "\n";
echo "Session ID: " . session_id() . "\n";
echo "User: " . ($_SESSION['user'] ?? 'NOT SET') . "\n";
echo "Admin ID: " . ($_SESSION['admin_id'] ?? 'NOT SET') . "\n";
echo "Admin Email: " . ($_SESSION['admin_email'] ?? 'NOT SET') . "\n";
echo "</pre>";
echo "</div>";

// Test 2: Database Connection
echo "<div class='test'>";
echo "<h2>Test 2: Database Connection</h2>";
echo "<pre>";
try {
    $pdo = new PDO("mysql:host=localhost;dbname=so_sarawak_db", "root", "");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "✓ Database connection: SUCCESS\n";
    echo "Database: so_sarawak_db\n";
} catch(PDOException $e) {
    echo "✗ Database connection: FAILED\n";
    echo "Error: " . $e->getMessage() . "\n";
}
echo "</pre>";
echo "</div>";

// Test 3: Direct Query
if (isset($pdo)) {
    echo "<div class='test'>";
    echo "<h2>Test 3: Direct Database Query</h2>";
    echo "<pre>";
    try {
        $stmt = $pdo->prepare("SELECT id, fullname, email, phone, position, bio, profile_photo FROM users WHERE id = ?");
        $stmt->execute([2]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($user) {
            echo "✓ User found in database:\n\n";
            echo "ID: " . $user['id'] . "\n";
            echo "Full Name: " . $user['fullname'] . "\n";
            echo "Email: " . $user['email'] . "\n";
            echo "Phone: " . $user['phone'] . "\n";
            echo "Position: " . $user['position'] . "\n";
            echo "Bio: " . (empty($user['bio']) ? '(empty)' : substr($user['bio'], 0, 100) . '...') . "\n";
            echo "Profile Photo: " . ($user['profile_photo'] ?? '(null)') . "\n";
        } else {
            echo "✗ User ID 2 not found in database\n";
        }
    } catch(Exception $e) {
        echo "✗ Query failed: " . $e->getMessage() . "\n";
    }
    echo "</pre>";
    echo "</div>";
}

// Test 4: API Call via PHP
echo "<div class='test'>";
echo "<h2>Test 4: Simulated API Call (POST)</h2>";
echo "<pre>";
$_POST['action'] = 'get_profile_data';
$_SERVER['REQUEST_METHOD'] = 'POST';

ob_start();
include 'handler/admin_profile_handler.php';
$response = ob_get_clean();

echo "Raw Response:\n";
echo $response . "\n\n";

$decoded = json_decode($response, true);
if ($decoded) {
    echo "Parsed Response:\n";
    echo "Success: " . ($decoded['success'] ? 'true' : 'false') . "\n";
    if ($decoded['success'] && isset($decoded['data'])) {
        echo "Data received:\n";
        foreach ($decoded['data'] as $key => $value) {
            if ($key === 'bio') {
                $value = empty($value) ? '(empty)' : substr($value, 0, 50) . '...';
            }
            echo "  - $key: $value\n";
        }
    } else {
        echo "Message: " . ($decoded['message'] ?? 'No message') . "\n";
    }
} else {
    echo "✗ Failed to parse JSON response\n";
}
echo "</pre>";
echo "</div>";

// Test 5: JavaScript Fetch Test
echo "<div class='test'>";
echo "<h2>Test 5: JavaScript Fetch API Test</h2>";
echo "<div id='fetchTest'>Testing...</div>";
echo "<pre id='fetchResult'></pre>";
echo "</div>";

echo "<script>
console.log('Starting JavaScript fetch test...');

fetch('handler/admin_profile_handler.php', {
    method: 'POST',
    headers: {
        'Content-Type': 'application/x-www-form-urlencoded',
    },
    body: 'action=get_profile_data'
})
.then(response => {
    console.log('Response status:', response.status);
    console.log('Response headers:', response.headers);
    return response.text();
})
.then(text => {
    console.log('Raw response text:', text);
    
    let result = 'Response Status: ' + '200 OK\\n\\n';
    result += 'Raw Response:\\n' + text + '\\n\\n';
    
    try {
        const data = JSON.parse(text);
        result += 'Parsed JSON:\\n';
        result += 'Success: ' + data.success + '\\n';
        
        if (data.success && data.data) {
            result += '\\nProfile Data:\\n';
            for (let key in data.data) {
                let value = data.data[key];
                if (key === 'bio' && value) {
                    value = value.substring(0, 50) + '...';
                }
                result += '  ' + key + ': ' + value + '\\n';
            }
            document.getElementById('fetchTest').innerHTML = '✓ <strong>Fetch API Test: SUCCESS</strong>';
            document.getElementById('fetchTest').parentElement.classList.add('success');
        } else {
            result += 'Message: ' + data.message + '\\n';
            document.getElementById('fetchTest').innerHTML = '✗ <strong>Fetch API Test: FAILED</strong>';
            document.getElementById('fetchTest').parentElement.classList.add('error');
        }
    } catch(e) {
        result += '✗ JSON Parse Error: ' + e.message + '\\n';
        document.getElementById('fetchTest').innerHTML = '✗ <strong>Fetch API Test: JSON ERROR</strong>';
        document.getElementById('fetchTest').parentElement.classList.add('error');
    }
    
    document.getElementById('fetchResult').textContent = result;
})
.catch(error => {
    console.error('Fetch error:', error);
    document.getElementById('fetchTest').innerHTML = '✗ <strong>Fetch API Test: NETWORK ERROR</strong>';
    document.getElementById('fetchTest').parentElement.classList.add('error');
    document.getElementById('fetchResult').textContent = 'Error: ' + error.message;
});
</script>";

// Test 6: Form Element Check
echo "<div class='test'>";
echo "<h2>Test 6: Test Form Population</h2>";
echo "<p>Simulating the profile form with actual data load:</p>";
echo "<form style='background: #0f172a; padding: 20px; border-radius: 8px;'>";
echo "<div style='margin: 10px 0;'>";
echo "<label style='display: block; color: #94a3b8;'>Full Name:</label>";
echo "<input type='text' id='testFullName' style='width: 100%; padding: 8px; margin-top: 5px; background: #1e293b; border: 1px solid #475569; color: #e2e8f0; border-radius: 4px;' readonly>";
echo "</div>";
echo "<div style='margin: 10px 0;'>";
echo "<label style='display: block; color: #94a3b8;'>Email:</label>";
echo "<input type='email' id='testEmail' style='width: 100%; padding: 8px; margin-top: 5px; background: #1e293b; border: 1px solid #475569; color: #e2e8f0; border-radius: 4px;' readonly>";
echo "</div>";
echo "<div style='margin: 10px 0;'>";
echo "<label style='display: block; color: #94a3b8;'>Phone:</label>";
echo "<input type='text' id='testPhone' style='width: 100%; padding: 8px; margin-top: 5px; background: #1e293b; border: 1px solid #475569; color: #e2e8f0; border-radius: 4px;' readonly>";
echo "</div>";
echo "<div style='margin: 10px 0;'>";
echo "<label style='display: block; color: #94a3b8;'>Position:</label>";
echo "<input type='text' id='testPosition' style='width: 100%; padding: 8px; margin-top: 5px; background: #1e293b; border: 1px solid #475569; color: #e2e8f0; border-radius: 4px;' readonly>";
echo "</div>";
echo "</form>";
echo "<div id='formPopulationStatus' style='margin-top: 15px; padding: 10px; background: #0f172a; border-radius: 4px;'>Waiting for data...</div>";
echo "</div>";

echo "<script>
// Wait for fetch to complete then populate test form
setTimeout(() => {
    fetch('handler/admin_profile_handler.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: 'action=get_profile_data'
    })
    .then(response => response.json())
    .then(data => {
        if (data.success && data.data) {
            const profile = data.data;
            document.getElementById('testFullName').value = profile.fullname || '';
            document.getElementById('testEmail').value = profile.email || '';
            document.getElementById('testPhone').value = profile.phone || '';
            document.getElementById('testPosition').value = profile.position || '';
            
            document.getElementById('formPopulationStatus').innerHTML = '<strong style=\"color: #10b981;\">✓ Form fields populated successfully!</strong>';
            document.getElementById('formPopulationStatus').style.borderLeft = '4px solid #10b981';
        } else {
            document.getElementById('formPopulationStatus').innerHTML = '<strong style=\"color: #ef4444;\">✗ Failed to populate form: ' + (data.message || 'Unknown error') + '</strong>';
            document.getElementById('formPopulationStatus').style.borderLeft = '4px solid #ef4444';
        }
    })
    .catch(error => {
        document.getElementById('formPopulationStatus').innerHTML = '<strong style=\"color: #ef4444;\">✗ Error: ' + error.message + '</strong>';
        document.getElementById('formPopulationStatus').style.borderLeft = '4px solid #ef4444';
    });
}, 500);
</script>";

// Summary
echo "<div class='test' style='border-left-color: #f59e0b;'>";
echo "<h2>🎯 Next Steps</h2>";
echo "<ul style='line-height: 2;'>";
echo "<li>If all tests pass: Issue is in the main admin panel JavaScript</li>";
echo "<li>If API test fails: Issue is in admin_profile_handler.php</li>";
echo "<li>If database query fails: Issue is with database connection or data</li>";
echo "<li>If fetch fails: Issue is with CORS or request headers</li>";
echo "</ul>";
echo "<p style='margin-top: 20px;'><strong>Open Browser Console (F12) to see detailed logs</strong></p>";
echo "</div>";

echo "</body></html>";
?>
