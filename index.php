<!-- Last updated: 23 Sep 2025 -->
<!-- Discontinued on 17 Nov 2025, kept as archived -->

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Special Olympics Sarawak</title>
    <link rel="shortcut icon" href="assets/images/master_logo_front.png"> <!-- 28/8/2025: This web icon previously was not added -->
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>

<body>
    
    <!-- Floating SONG 26 Nav Bubble -->
    <a href="src/SONG 26.php" class="song26-nav-bubble" aria-label="Go to SONG 26">
        <img src="assets/icons/bintulu-stork.png" alt="SONG 26" class="song26-bubble-icon">
        <span class="song26-bubble-tooltip">SONG 2026 page</span>
    </a>
    <div class="video-background" style="position:relative;width:100vw;height:100vh;overflow:hidden;">
        <video autoplay loop muted playsinline
            style="width:100vw;height:100vh;object-fit:cover;position:fixed;top:0;left:0;z-index:1;">
            <!-- Replace with your video source -->
            <source src="assets/videos/soswk-index-datasaver.mp4" type="video/mp4">
            Your browser does not support the video tag.
        </video>
        <!-- Clickable overlay for SONG 26 -->
        <a href="src/SONG 26.php" style="position:fixed;top:0;left:0;width:100vw;height:100vh;z-index:2;display:block;text-decoration:none;cursor:pointer;" aria-label="Go to SONG 26"></a>
        <!-- Welcome Section with Logo (now in front of video) -->
        <section class="welcome-section" style="position:relative;z-index:3;">
            <img src="assets/images/master_logo_front.png" alt="Special Olympics Sarawak Main Title">
            <h1>
                Welcome to Special Olympics Sarawak
            </h1>
            <p>
                Empowering athletes, building community, and celebrating abilities. Join us in making a difference through
                sports and inclusion.
            </p>
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
        /* SONG 26 Nav Bubble Styles */
        .song26-nav-bubble {
            position: fixed;
            top: 50%;
            left: 32px;
            transform: translateY(-50%);
            z-index: 100;
            width: 64px;
            height: 64px;
            background: #d90429;
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
            background: #fff;
            box-shadow: 0 8px 24px rgba(217,4,41,0.18);
        }
        
        .song26-bubble-icon {
            width: 32px;
            height: 32px;
            filter: invert(1);
            transition: filter 0.3s;
        }
        
        .song26-nav-bubble:hover .song26-bubble-icon {
            filter: invert(16%) sepia(99%) saturate(7490%) hue-rotate(-5deg) brightness(97%) contrast(119%);
        }
        
        .song26-bubble-tooltip {
            position: absolute;
            left: 80px;
            top: 50%;
            transform: translateY(-50%) scale(0.95);
            background: #d90429;
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
            color: #d90429;
        }
        
        @keyframes bubble-pop-in {
            0% { transform: scale(0.5) translateY(-50%); opacity: 0; }
            60% { transform: scale(1.1) translateY(-50%); opacity: 1; }
            100% { transform: scale(1) translateY(-50%); opacity: 1; }
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
                <button class="nav-btn"><span>What We Do?</span></button>
                <div class="dropup-menu">
                    <a href="src/getting_started.php">Getting Started</a>
                    <a href="src/alp.php">Athlete Leadership Program (ALP)</a>
                    <a href="src/yap.php">Young Athletes Program (YAP)</a>
                </div>
            </li>
            <li class="nav-item">
                <button class="nav-btn"><span>Core Program</span></button>
                <div class="dropup-menu">
                    <a href="src/sohap.php">Healthy Athletes Program (HAP)</a>
                </div>
            </li>
            <li class="nav-item">
                <button class="nav-btn"><span>Sports</span></button>
                <div class="dropup-menu">
                    <a href="src/sport.php">Our Sports</a>
                </div>
            </li>
            <li class="nav-item">
                <button class="nav-btn"><span>SONG 2026</span></button>
                <div class="dropup-menu">
                    <a href="src/SONG 26.php">SONG 26</a>
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
                <button class="nav-btn"><span>Affiliate</span></button>
                <div class="dropup-menu">
                    <a href="src/sarawak-chapters.php">Sarawak Chapters</a>
                    <a href="src/sponsorships.php">Sponsorships</a>
                    <a href="src/other-so.php">Special Olympics Organization</a>
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
                <span class="copyright-text">© 2025 Special Olympics Sarawak. All rights reserved</span>
                <div class="footer-links">
                    <a href="#" class="footer-link">Privacy Policy</a>
                    <a href="src/disclaimer.html" class="footer-link">Disclaimer</a>
                    <a href="#" class="footer-link">Terms & Condition</a>
                </div>
            </div>
        </div>
    </footer>

    <script src="scripts/script.js"></script>
</body>
</html>