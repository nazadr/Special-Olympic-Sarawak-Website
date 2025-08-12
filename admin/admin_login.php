<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel Login</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @keyframes floatBubbles {
            0% {
                transform: translateY(0) rotate(0deg);
                opacity: 1;
            }
            100% {
                transform: translateY(-100vh) rotate(720deg);
                opacity: 0;
            }
        }

        .bubble {
            position: absolute;
            background-color: rgba(255,255,255,0.2);
            box-shadow: 0 0 15px rgba(255,255,255,0.8);
            border-radius: 50%;
            pointer-events: none;
            animation: floatBubbles 10s linear infinite;
        }

        @keyframes float {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-10px); }
        }

        .floating-logo {
            animation: float 4s ease-in-out infinite;
        }

        .input-field {
            transition: all 0.3s ease;
        }

        .input-field:focus {
            transform: scale(1.02);
            box-shadow: 0 0 0 3px rgba(237, 28, 36, 0.2);
        }

        .login-btn {
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .login-btn:hover {
            transform: translateY(-2px);
        }

        .login-btn::after {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
            transition: 0.5s;
        }

        .login-btn:hover::after {
            left: 100%;
        }

        .pulse {
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0% {
                transform: scale(1);
                opacity: 1;
            }
            50% {
                transform: scale(1.05);
                opacity: 0.9;
            }
            100% {
                transform: scale(1);
                opacity: 1;
            }
        }
    </style>
</head>
<body class="min-h-screen flex items-center justify-center p-4 relative overflow-hidden" style="background: linear-gradient(to bottom, #000000, #ffffff);">
    <div id="bubbles-container"></div>
    <div class="max-w-md w-full bg-white rounded-xl shadow-2xl overflow-hidden">
        <div class="bg-red-600 p-8 text-center">
            <div class="floating-logo inline-block pulse">
                <div class="w-24 h-24 bg-white rounded-full flex items-center justify-center mx-auto">
                    <img src="../assets/images/master_logo_front.png" alt="Special Olympics logo - red and white torch icon surrounded by five arched shapes representing the world" class="w-16 h-16">
                </div>
            </div>
            <h1 class="text-3xl font-bold text-white mt-4">Admin Panel</h1>
            <p class="text-white opacity-90 mt-2">Special Olympics Management System</p>
        </div>

        <div class="p-8">
            <form id="loginForm" class="space-y-6">
                <div class="space-y-1">
                    <label for="username" class="block text-sm font-medium text-gray-700">Username</label>
                    <input type="text" id="username" required placeholder="Enter your username" 
                           class="input-field w-full px-4 py-3 border rounded-lg focus:outline-none focus:ring-1 focus:ring-red-500">
                </div>

                <div class="space-y-1">
                    <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                    <input type="password" id="password" required placeholder="Enter your password"
                           class="input-field w-full px-4 py-3 border rounded-lg focus:outline-none focus:ring-1 focus:ring-red-500">
                </div>

                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <input id="remember-me" type="checkbox" class="h-4 w-4 text-red-600 focus:ring-red-500 border-gray-300 rounded mr-2">
                        <label for="remember-me" class="block text-sm text-gray-700">Remember me</label>
                    </div>
                    <a href="#" class="text-sm text-red-600 hover:text-red-800">Forgot password?</a>
                </div>

                <button type="submit" class="login-btn w-full bg-red-600 text-white py-3 px-4 rounded-lg font-semibold text-lg focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2">
                    Sign In
                </button>
            </form>

            <div id="loadingIndicator" class="hidden flex items-center justify-center py-4">
                <div class="animate-spin rounded-full h-8 w-8 border-b-2 border-red-600"></div>
            </div>
        </div>

        <div class="bg-gray-50 px-8 py-4 text-center">
            <p class="text-sm text-gray-600">© 2023 Special Olympics Admin Panel. All rights reserved.</p>
        </div>
    </div>

    <script>
        // Create floating bubbles
        function createBubbles() {
            const container = document.getElementById('bubbles-container');
            const bubbleCount = 30;
            
            for (let i = 0; i < bubbleCount; i++) {
                const bubble = document.createElement('div');
                const size = Math.random() * 50 + 20;
                const posX = Math.random() * 100;
                const delay = Math.random() * 5;
                const duration = Math.random() * 10 + 10;
                
                bubble.className = 'bubble';
                bubble.style.left = `${posX}vw`;
                bubble.style.bottom = '-100px';
                bubble.style.filter = 'brightness(1.2)';
                bubble.style.width = `${size}px`;
                bubble.style.height = `${size}px`;
                bubble.style.animationDuration = `${duration}s`;
                bubble.style.animationDelay = `${delay}s`;
                
                container.appendChild(bubble);
            }
        }

        window.addEventListener('load', createBubbles);

        document.getElementById('loginForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            // Show loading indicator
            document.getElementById('loadingIndicator').classList.remove('hidden');
            
            // Simulate login process (you would replace this with actual login logic)
            setTimeout(() => {
                // Here you would handle the actual login process
                // For demo purposes, we'll just show an alert
                alert('Login functionality would be implemented here');
                document.getElementById('loadingIndicator').classList.add('hidden');
            }, 1500);
        });
    </script>
</body>
</html>
