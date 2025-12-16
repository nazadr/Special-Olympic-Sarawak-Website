<!-- Open via localhost -->

<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $conn = new mysqli("localhost", "root", "", "so_sarawak_db");
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $email = trim($_POST['email']);
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $res = $stmt->get_result();

    if ($row = $res->fetch_assoc()) {
        if (password_verify($password, $row['password'])) {
            // Regenerate session ID for security
            session_regenerate_id(true);
            
            // Store user information in session
            $_SESSION['user'] = $row['fullname'];
            $_SESSION['admin_id'] = $row['id'];
            $_SESSION['admin_email'] = $row['email'];
            $_SESSION['last_activity'] = time();
            $_SESSION['login_time'] = time();
            $_SESSION['session_timeout'] = 1800; // 30 minutes default
            
            // Log successful login (optional - only if table exists)
            try {
                $login_ip = $_SERVER['REMOTE_ADDR'] ?? 'unknown';
                $user_agent = $_SERVER['HTTP_USER_AGENT'] ?? 'unknown';
                
                // Check if the activity logs table exists first
                $table_check = $conn->query("SHOW TABLES LIKE 'admin_activity_logs'");
                if ($table_check && $table_check->num_rows > 0) {
                    // Try to log to activity table if it exists
                    $log_stmt = $conn->prepare("INSERT INTO admin_activity_logs (user_id, action, description, ip_address, user_agent, created_at) VALUES (?, 'login', ?, ?, ?, NOW())");
                    $login_description = 'Successful login from ' . $login_ip;
                    if ($log_stmt) {
                        $log_stmt->bind_param("isss", $row['id'], $login_description, $login_ip, $user_agent);
                        $log_stmt->execute();
                        $log_stmt->close();
                    }
                }
            } catch (mysqli_sql_exception $e) {
                // Silently handle any database errors during login logging
                // Don't prevent login if logging fails
            }
            
            header("Location: admin_panel_soswk.php");
            exit();
        } else {
            $error = "Invalid password.";
        }
    } else {
        $error = "No account found with that email.";
    }

    $stmt->close();
    $conn->close();
}

// Handle messages from URL parameters
$message = '';
if (isset($_GET['message'])) {
    switch($_GET['message']) {
        case 'logged_out':
            $message = "You have been successfully logged out.";
            break;
    }
}

// Handle error messages from URL parameters
if (isset($_GET['error'])) {
    switch($_GET['error']) {
        case 'not_logged_in':
            $error = "Please log in to access the admin panel.";
            break;
        case 'session_expired':
            $error = "Your session has expired. Please log in again.";
            break;
        case 'access_denied':
            $error = "Access denied. Please log in with valid credentials.";
            break;
        default:
            $error = "An error occurred. Please try logging in again.";
    }
}

// Check if already logged in
if (isset($_SESSION['user']) && isset($_SESSION['admin_id'])) {
    header("Location: admin_panel_soswk.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Special Olympics Sarawak Admin Webmaster - Login</title>
    <!-- White color logo of SO represents an admin -->
    <link rel="shortcut icon" href="../assets/images/master-logo-front-white.png">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        body {
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            background-size: 400% 400%;
            animation: gradientBG 15s ease infinite;
            overflow: hidden;
        }

        @keyframes gradientBG {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }

        .particles {
            position: absolute;
            width: 100%;
            height: 100%;
            z-index: 0;
        }

        .particle {
            position: absolute;
            background: rgba(211, 47, 47, 0.2);
            border-radius: 50%;
            animation: float 15s infinite linear;
        }

        @keyframes float {
            0% {
                transform: translateY(0) rotate(0deg);
                opacity: 1;
            }
            100% {
                transform: translateY(-1000px) rotate(720deg);
                opacity: 0;
            }
        }

        .login-container {
            position: relative;
            width: 400px;
            background: rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            padding: 40px;
            box-shadow: 0 25px 45px rgba(0, 0, 0, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.5);
            border-right: 1px solid rgba(255, 255, 255, 0.2);
            border-bottom: 1px solid rgba(255, 255, 255, 0.2);
            z-index: 1;
        }

        .logo {
            text-align: center;
            margin-bottom: 30px;
        }

        .logo img {
            width: 150px;
            margin-bottom: 10px;
        }

        .logo h2 {
            color: #d32f2f;
            margin-top: 10px;
            font-weight: 600;
            letter-spacing: 1px;
        }

        .input-group {
            position: relative;
            margin-bottom: 30px;
        }

        .input-group input {
            width: 100%;
            padding: 15px 20px;
            background: rgba(255, 255, 255, 0.25);
            border: none;
            outline: none;
            border-radius: 35px;
            font-size: 16px;
            color: #333;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            transition: all 0.3s ease;
        }

        .input-group input:focus {
            background: rgba(255, 255, 255, 0.5);
        }

        .input-group label {
            position: absolute;
            top: 15px;
            left: 20px;
            font-size: 16px;
            color: #d32f2f;
            pointer-events: none;
            transition: all 0.3s ease;
        }

        .input-group input:focus ~ label,
        .input-group input:valid ~ label {
            top: -18px;
            left: 15px;
            font-size: 12px;
            background: rgba(255, 255, 255, 0.8);
            padding: 0 5px;
            border-radius: 5px;
        }

        .forgot-pass {
            text-align: right;
            margin-bottom: 20px;
        }

        .forgot-pass a {
            color: #d32f2f;
            font-size: 14px;
            text-decoration: none;
            transition: all 0.3s ease;
        }

        .forgot-pass a:hover {
            text-decoration: underline;
        }

        button {
            width: 100%;
            padding: 15px;
            background: #d32f2f;
            color: white;
            border: none;
            border-radius: 35px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }

        button:hover {
            background: #b71c1c;
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
        }

        .signup-link {
            text-align: center;
            margin-top: 25px;
            color: #666;
        }

        .signup-link a {
            color: #d32f2f;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .signup-link a:hover {
            text-decoration: underline;
        }

        @media (max-width: 480px) {
            .login-container {
                width: 90%;
                padding: 30px;
            }
        }
    </style>
</head>
<body>
     <div class="particles" id="particles"></div>
    <div class="login-container">
        <div class="logo">
            <img src="../assets/images/master_logo_front.png" alt="Special Olympics Sarawak logo" />
            <h2>Special Olympics Sarawak Admin Webmaster</h2>
            <?php if (!empty($error)) echo "<p style='color:red;'>$error</p>"; ?>
            <?php if (!empty($message)) echo "<p style='color:green;'>$message</p>"; ?>
            <?php if (isset($_GET['signup']) && $_GET['signup'] == 'success') echo "<p style='color:green;'>Signup successful! Please log in.</p>"; ?>
        </div>
        <form method="POST" action="">
            <div class="input-group">
                <input type="text" name="email" required>
                <label>Email</label>
            </div>
            <div class="input-group">
                <input type="password" name="password" required>
                <label>Password</label>
            </div>
            <div class="forgot-pass">
                <a href="#">Forgot Password?</a>
            </div>
            <button type="submit">Login</button>
        </form>
    </div>


    
    <script>
        // Create floating particles
        document.addEventListener('DOMContentLoaded', function() {
            const particlesContainer = document.getElementById('particles');
            const particleCount = 30;
            
            for (let i = 0; i < particleCount; i++) {
                const particle = document.createElement('div');
                particle.classList.add('particle');
                
                // Random size between 5px and 15px
                const size = Math.random() * 10 + 5;
                particle.style.width = `${size}px`;
                particle.style.height = `${size}px`;
                
                // Random position
                particle.style.left = `${Math.random() * 100}%`;
                particle.style.top = `${Math.random() * 100}%`;
                
                // Random animation duration between 10s and 20s
                particle.style.animationDuration = `${Math.random() * 10 + 10}s`;
                
                // Random delay
                particle.style.animationDelay = `${Math.random() * 5}s`;
                
                particlesContainer.appendChild(particle);
            }
            
            // Form validation
            const form = document.querySelector('form');
            form.addEventListener('submit', function(e) {
                const inputs = document.querySelectorAll('.input-group input');
                let isValid = true;
                
                inputs.forEach(input => {
                    if (!input.value.trim()) {
                        isValid = false;
                        input.style.border = '1px solid #d32f2f';
                    } else {
                        input.style.border = 'none';
                    }
                });
                
                if (!isValid) {
                    // Only prevent submission if invalid
                    e.preventDefault();
                }

                // If valid, let the form submit to PHP
            });
        });
</script>

</body>
</html>

