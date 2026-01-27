<!-- Last updated: 23 Sep 2025 -->
<!-- Discontinued on 17 Nov 2025, kept as archived -->

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Special Olympics Sarawak</title>
    <link rel="shortcut icon" href="assets/images/master_logo_front.png"> <!-- 28/8/2025: This web icon previously was not added -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,700;1,400;1,700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>

<body>
    
    <!-- Floating SONG 26 Nav Bubble -->
    <a href="src/SONG 26.php?standalone=1" target="_blank" class="song26-nav-bubble" aria-label="Go to SONG 26">
        <img src="assets/images/SONG26_Logo.png" alt="SONG 26" class="song26-bubble-icon">
        <span class="song26-bubble-tooltip">SONG 2026 page</span>
    </a>
    <div class="video-background" style="position:relative;width:100vw;height:100vh;overflow:hidden;">
        <video autoplay loop muted playsinline
            style="width:100vw;height:100vh;object-fit:cover;position:fixed;top:0;left:0;z-index:1;">
            <!-- Replace with your video source -->
            <source src="assets/videos/SO website bg.mp4" type="video/mp4">
            Your browser does not support the video tag
        </video>
        <!-- Animated gradient backgrounds -->
        <div class="bg"></div>
        <div class="bg bg2"></div>
        <div class="bg bg3"></div>
        <!-- Clickable overlay for SONG 26 -->
        <a href="src/SONG 26.php?standalone=1" target="_blank" style="position:fixed;top:0;left:0;width:100vw;height:100vh;z-index:3;display:block;text-decoration:none;cursor:pointer;" aria-label="Go to SONG 26"></a>
        <!-- Welcome Section with Logo (now in front of video) -->
        <section class="welcome-section" style="position:relative;z-index:4;">
            <h1>
                Special Olympics Sarawak
            </h1>
            <img src="assets/images/master_logo_front.png" alt="Special Olympics Sarawak Main Title">
            <div class="oath-pyramid">
                <p class="oath-line oath-line-small">"Let me win,</p>
                <p class="oath-line oath-line-medium">But if I cannot win,</p>
                <p class="oath-line oath-line-large">Let me be brave in the attempt."</p>
            </div>
          
            <!-- Display horizontally below <p> -->
            <div class="socmed-bar mobile-only-flex">
                <a href="https://www.facebook.com/SpecialOlympicsSarawak/" class="socmed-icon soc-facebook" title="Facebook"><i
                        class="fab fa-facebook-f"></i></a>
                <a href="#" class="socmed-icon soc-x" title="X"><i
                        class="fab fa-x-twitter"></i></a>
                <a href="#" class="socmed-icon soc-tiktok" title="TikTok"><i
                        class="fab fa-tiktok"></i></a>
                <a href="#" class="socmed-icon soc-instagram" title="Instagram"><i
                        class="fab fa-instagram"></i></a>
            </div>
        </section>
    </div>

    <!-- Navigation component injected from script to avoid duplicate markup -->
    <script src="scripts/components/index/header-index.js"></script>

    <style>
        /* Animated Gradient Background */
        html {
            height: 100%;
        }
        
        .bg {
            animation: slide 3s ease-in-out infinite alternate;
            background-image: linear-gradient(-60deg, rgba(0, 0, 0, 0.36) 50%, rgba(36, 1, 1, 0.2) 50%);
            bottom: 0;
            left: -50%;
            opacity: 1;
            position: fixed;
            right: -50%;
            top: 0;
            z-index: 2;
            pointer-events: none;
        }
        
        .bg2 {
            animation-direction: alternate-reverse;
            animation-duration: 4s;
        }
        
        .bg3 {
            animation-duration: 5s;
        }
        
        @keyframes slide {
            0% {
                transform: translateX(-25%);
            }
            100% {
                transform: translateX(25%);
            }
        }
        
        /* Special Olympics Oath Pyramid Styling */
        .oath-pyramid {
            display: flex;
            flex-direction: column;
            align-items: center;
            margin: 0.5rem 0 0.5rem 0;
            gap: 0.3rem;
        }
        
        .oath-line {
            font-style: italic;
            color: #ffd400 !important;
            text-shadow: 
                -3px -3px 0 #000,
                3px -3px 0 #000,
                -3px 3px 0 #000,
                3px 3px 0 #000,
                -2px 0 0 #000,
                2px 0 0 #000,
                0 -2px 0 #000,
                0 2px 0 #000;
            font-weight: 700;
            font-family: 'Playfair Display', 'Georgia', 'Garamond', serif;
            margin: 0;
            text-align: center;
            line-height: 1.4;
        }
        
        .oath-line-small {
            font-size: 1.881rem !important;
        }
        
        .oath-line-medium {
            font-size: 1.881rem !important;
        }
        
        .oath-line-large {
            font-size: 1.881rem !important;
            font-weight: 700;
        }
        
        .oath-attribution {
            font-size: 1rem;
            color: ##e5A812;
            text-shadow: 2px 2px 8px rgba(0,0,0,0.7);
            margin-top: 0.5rem;
            font-style: italic;
        }
        
        @media (max-width: 768px) {
            .oath-line-small {
                font-size: 1.1rem;
            }
            .oath-line-medium {
                font-size: 1.4rem;
            }
            .oath-line-large {
                font-size: 1.8rem;
            }
        }
        
        /* SONG 26 Nav Bubble Styles */
        .song26-nav-bubble {
            position: fixed;
            top: 50%;
            left: 32px;
            transform: translateY(-50%);
            z-index: 100;
            width: 100px;
            height: 100px;
            background: #fff;
            border-radius: 50%;
            box-shadow: 0 4px 16px rgba(0,0,0,0.12);
            display: flex;
            align-items: center;
            justify-content: center;
            transition: background 0.3s, box-shadow 0.3s;
            cursor: pointer;
            border: none;
            outline: none;
            animation: bubble-pop-in 0.6s cubic-bezier(.68,-0.55,.27,1.55);
        }
        
        .song26-nav-bubble:hover {
            background: #FF0000;
            box-shadow: 0 8px 24px rgba(255, 0, 0,0.18);
        }
        
        .song26-bubble-icon {
            width: 70px;
            height: 70px;
            transition: all 0.3s;
        }
        
        .song26-nav-bubble:hover .song26-bubble-icon {
            transform: scale(1.05);
        }
        
        .song26-bubble-tooltip {
            position: absolute;
            left: 80px;
            top: 50%;
            transform: translateY(-50%) scale(0.95);
            background: #FF0000;
            color: #fff;
            padding: 8px 18px;
            border-radius: 24px;
            font-size: 1rem;
            font-family: 'Inter', sans-serif;
            white-space: nowrap;
            opacity: 0;
            pointer-events: none;
            transition: opacity 0.25s, transform 0.25s, background 0.3s, color 0.3s;
            box-shadow: 0 2px 8px rgba(0,0,0,0.10);
        }
        
        .song26-nav-bubble:hover .song26-bubble-tooltip {
            opacity: 1;
            transform: translateY(-50%) scale(1);
            background: #fff;
            color: #FF0000;
        }
        
        @keyframes bubble-pop-in {
            0% { transform: scale(0.5) translateY(-50%); opacity: 0; }
            60% { transform: scale(1.1) translateY(-50%); opacity: 1; }
            100% { transform: scale(1) translateY(-50%); opacity: 1; }
        }
        
        /* Bottom Nav Height Adjustment */
        .bottom-nav {
            height: 75px;
        }
        
        .bottom-nav ul {
            height: 100%;
        }
        
        .bottom-nav .nav-btn {
            height: 75px;
            padding: 15px 30px;
        }
        
        .bottom-nav .nav-btn span {
            line-height: 1.3;
        }
    </style>


    <!-- Social Media Bar -->
    <!-- This will be hidden on desktop via CSS -->
    <div class="socmed-bar desktop-only">
        <a href="https://www.facebook.com/SpecialOlympicsSarawak/" class="socmed-icon soc-facebook" title="Facebook"><i
                class="fab fa-facebook-f"></i></a>
        <a href="#" class="socmed-icon soc-x" title="X"><i
                class="fab fa-x-twitter"></i></a>
        <a href="#" class="socmed-icon soc-tiktok" title="TikTok"><i
                class="fab fa-tiktok"></i></a>
        <a href="#" class="socmed-icon soc-instagram"
            title="Instagram"><i class="fab fa-instagram"></i></a>
    </div>

    <!-- Chatbot Section (optional remove if not needed and remove the javascript event listener)-->
    <div class="chatbot-container">
        <button class="chatbot-toggle">💬</button>
        <div class="chatbot-window" id="chatbot-window">
            <div class="chatbot-header">Chat Assistant</div>
            <div class="chatbot-messages" id="chat-messages">
                <p class="bot-msg">Hi there! How can I help you?</p>
            </div>
            <input type="text" id="chat-input" class="chatbot-input" placeholder="Type your message...">
        </div>
    </div>

    <!-- The original bottom navigation will be hidden on mobile -->
    <footer class="bottom-nav desktop-only">
        <ul>
            <li class="nav-item">
                <button class="nav-btn"><span>News</span></button>
                <div class="dropup-menu">
                    <a href="src/latest-news.php">In the News</a>
                </div>
            </li>
            <li class="nav-item">
                <button class="nav-btn"><span>Core Program</span></button>
                <div class="dropup-menu">
                    <a href="src/sohap.php">Healthy Athletes Program</a>
                    <a href="src/yap.php">Young Athletes Program</a>
                </div>
            </li>
            <li class="nav-item">
                <button class="nav-btn"><span>National<br>Games 2026</span></button>
                <div class="dropup-menu">
                    <a href="src/SONG 26.php?standalone=1" target="_blank">National Games 2026</a>
                </div>
            </li>
            <li class="nav-item">
                <button class="nav-btn"><span>Events</span></button>
                <div class="dropup-menu">
                    <a href="src/state-games.php">State Games</a>
                    <a href="src/event_calendar.php">Events Calendar</a>
                </div>
            </li>
             <li class="nav-item">
                <button class="nav-btn"><span>Gallery</span></button>
                <div class="dropup-menu">
                    <a href="src/gallery-photos.php">Photos</a>
                    <a href="src/gallery-videos.php">Videos</a>
                </div>
            </li>
        </ul>
    </footer>

    <!-- New Site Footer Section -->
    <footer class="site-footer">
        <div class="site-footer-content">
            <div class="footer-top">
                <span class="copyright-text">© 2026 Special Olympics Sarawak. All rights reserved</span>
                <div class="footer-links">
                    <a href="#" class="footer-link">Privacy Policy</a>
                    <a href="src/terms-and-conditions.php" class="footer-link">Terms & Condition</a>
                    <a href="src/sitemap.php" class="footer-link">Sitemap</a>
                </div>
            </div>
        </div>
    </footer>

    <script src="scripts/script.js"></script>
</body>
</html>