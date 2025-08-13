<?php
// Process form if submitted
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $conn = new mysqli("localhost", "root", "", "special_olympics_site");
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $fullname = trim($_POST['fullname']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    if ($password !== $confirm_password) {
        $error = "Passwords do not match!";
    } else {
        $hashed = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $conn->prepare("INSERT INTO users (fullname, email, password) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $fullname, $email, $hashed);
        if ($stmt->execute()) {
            header("Location: login_page_v1.php?signup=success");
            exit();
        } else {
            $error = "Email already exists or error occurred.";
        }
        $stmt->close();
    }
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
    
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Special Olympics Sarawak - Sign Up</title>


    
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
            <h2>Create Your Account</h2>
            <?php if (!empty($error)) echo "<p style='color:red;'>$error</p>"; ?>
        </div>
        <form method="POST" action="">
            <div class="input-group">
                <input type="text" name="fullname" required>
                <label>Full Name</label>
            </div>
            <div class="input-group">
                <input type="email" name="email" required>
                <label>Email</label>
            </div>
            <div class="input-group">
                <input type="password" name="password" required>
                <label>Create Password</label>
            </div>
            <div class="input-group">
                <input type="password" name="confirm_password" required>
                <label>Confirm Password</label>
            </div>
            <button type="submit">Sign Up</button>
            <div class="signup-link">
                Already have an account? <a href="../admin/login_page_v1.php">Log in</a>
            </div>
        </form>
    </div>

    <!----
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
                e.preventDefault();
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
                
                if (isValid) {
                    // Login logic would go here
                    alert('Login successful!');
                    form.reset();
                }
            });
        });
    </script>
-->
</body>
</html>

