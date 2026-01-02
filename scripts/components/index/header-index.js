// Reusable HTML Element written in JavaScript.
// Header for index page. Mirrors scripts/components/header.js but paths are site-root relative.

document.writeln(`
    <nav class="top-nav">
        <div class="logo">
            <a href="index.php"><img src="assets/images/Remake/SO Sarawak horizontal logo BG.png" alt="Logo" class="logo-img" style="margin-top: 4px;"></a>
            <img src="assets/images/Sarawak_Flag.png" alt="Sarawak Flag" class="sarawak-flag-header">
        </div>

        <!-- Hamburger Icon for Mobile -->
        <div class="hamburger" id="hamburger-icon">
            <div class="bar"></div>
            <div class="bar"></div>
            <div class="bar"></div>
        </div>

        <div class="nav-right" id="nav-right-menu">
            <ul class="nav-menu">
                <li class="dropdown mobile-dropdown-parent">
                    <a href="#about">About Us <i class="fa-solid fa-angle-down"></i></a>
                    <ul class="dropdown-menu mobile-dropdown-submenu">
                        <li><a href="src/introduction.html">Introduction</a></li>
                        <li><a href="src/brochure.html">SO Brochure</a></li>
                        <li><a href="src/how_can_you_help.html">How can you help?</a></li>
                    </ul>
                </li>
                <li class="dropdown mobile-dropdown-parent">
                    <a href="#news">News <i class="fa-solid fa-angle-down"></i></a>
                    <ul class="dropdown-menu mobile-dropdown-submenu">
                        <li><a href="src/latest-news.php">In the News</a></li>
                    </ul>
                </li>
                <li class="dropdown mobile-dropdown-parent">
                    <a href="#contact">Contact Us <i class="fa-solid fa-angle-down"></i></a>
                    <ul class="dropdown-menu mobile-dropdown-submenu">
                        <li><a href="src/visit_us_with_map.html">Visit Us</a></li>
                        <li><a href="src/email-us.html">Email Us</a></li>
                    </ul>
                </li>
                <!-- Donation buttons moved to the very bottom of the sidebar for mobile -->
                <li class="donation-item">
                    <div class="donation-button-container">
                            <a href="src/join_us.html" class="donate-btn">Join Us</a>
                            <a href="src/donation_page.php" class="donate-btn">Donate</a>
                    </div>
                </li>
                <!-- Bottom Navigation items integrated here for mobile -->
                <li class="dropdown mobile-only mobile-dropdown-parent">
                    <a href="#">What We Do? <i class="fa-solid fa-angle-down"></i></a>
                    <ul class="dropdown-menu mobile-dropdown-submenu">
                        <li><a href="src/getting_started.php">Getting Started</a></li>
                        <li><a href="src/alp.php">Athlete Leadership Program (ALP)</a></li>
                        <li><a href="src/yap.php">Young Athletes Program (YAP)</a></li>
                    </ul>
                </li>
                <li class="dropdown mobile-only mobile-dropdown-parent">
                    <a href="#">Core Program <i class="fa-solid fa-angle-down"></i></a>
                    <ul class="dropdown-menu mobile-dropdown-submenu">
                        <li><a href="src/sohap.php">Healthy Athletes Program (HAP)</a></li>
                    </ul>
                </li>
                <li class="dropdown mobile-only mobile-dropdown-parent">
                    <a href="#">Sports <i class="fa-solid fa-angle-down"></i></a>
                    <ul class="dropdown-menu mobile-dropdown-submenu">
                        <li><a href="src/sport.php">Our Sports</a></li>
                    </ul>
                </li>
                <li class="dropdown mobile-only mobile-dropdown-parent">
                    <a href="#">SONG 2026 <i class="fa-solid fa-angle-down"></i></a>
                    <ul class="dropdown-menu mobile-dropdown-submenu">
                        <li><a href="src/SONG 26.php">SONG 26</a></li>
                    </ul>
                </li>
                <li class="dropdown mobile-only mobile-dropdown-parent">
                    <a href="#">Events <i class="fa-solid fa-angle-down"></i></a>
                    <ul class="dropdown-menu mobile-dropdown-submenu">
                        <li><a href="src/state-games.php">State Games</a></li>
                        <li><a href="src/event_calendar.php">Event Calendar</a></li>
                    </ul>
                </li>
                <li class="dropdown mobile-only mobile-dropdown-parent">
                    <a href="#">Gallery <i class="fa-solid fa-angle-down"></i></a>
                    <ul class="dropdown-menu mobile-dropdown-submenu">
                        <li><a href="src/gallery-photos.php">Photos</a></li>
                        <li><a href="src/gallery-videos.php">Videos</a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </nav>
    `)