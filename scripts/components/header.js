// Reusable HTML Element written in JavaScript.
// Created on 8 Sep 2025
// Updated on 19 Jan 2026

document.writeln(`
    <nav class="top-nav">
        <div class="logo">
            <a href="../index.php"><img src="../assets/images/Remake/SO Sarawak horizontal logo BG.png" alt="Logo" class="logo-img" style="margin-top: 4px;"></a>
            <img src="../assets/images/Malaysia_Flag_New.png" alt="Malaysia Flag" class="sarawak-flag-header" style="object-fit: contain;">
            <img src="../assets/images/Sarawak_Flag.png" alt="Sarawak Flag" class="sarawak-flag-header">
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
                        <li><a href="../src/introduction.html">Introduction</a></li>
                        <li><a href="../src/brochure.html">SO Brochure</a></li>
                        <li><a href="../src/how_can_you_help.html">How can you help?</a></li>
                    </ul>
                </li>
                <li class="dropdown mobile-dropdown-parent">
                    <a href="#whatwedo">What We Do? <i class="fa-solid fa-angle-down"></i></a>
                    <ul class="dropdown-menu mobile-dropdown-submenu">
                        <li><a href="../src/getting_started.php">Getting Started</a></li>
                    </ul>
                </li>
                <li class="dropdown mobile-dropdown-parent">
                    <a href="#affiliate">Affiliate <i class="fa-solid fa-angle-down"></i></a>
                    <ul class="dropdown-menu mobile-dropdown-submenu">
                        <li><a href="../src/sarawak-chapters.php">Sarawak Chapters</a></li>
                        <li><a href="../src/sponsorships.php">Sponsorships</a></li>
                        <li><a href="../src/other-so.php">Special Olympics Organization</a></li>
                    </ul>
                </li>
                <li class="dropdown mobile-dropdown-parent">
                    <a href="#sports">Sports <i class="fa-solid fa-angle-down"></i></a>
                    <ul class="dropdown-menu mobile-dropdown-submenu">
                        <li><a href="../src/sport.php">Our Sports</a></li>
                    </ul>
                </li>
                <li class="dropdown mobile-dropdown-parent">
                    <a href="#contact">Contact Us <i class="fa-solid fa-angle-down"></i></a>
                    <ul class="dropdown-menu mobile-dropdown-submenu">
                        <li><a href="../src/visit_us_with_map.html">Visit Us</a></li>
                        <li><a href="../src/email-us.html">Email Us</a></li>
                    </ul>
                </li>
                <!-- Donation and Join Us buttons -->
                <li class="donation-item">
                    <div class="donation-button-container">
                            <a href="../src/join_us.html" class="donate-btn">Join Us</a>
                            <a href="../src/donation_page.php" class="donate-btn">Donate</a>
                    </div>
                </li>
                <!-- Bottom Navigation items integrated here for mobile -->
                <li class="dropdown mobile-only mobile-dropdown-parent">
                    <a href="#">News <i class="fa-solid fa-angle-down"></i></a>
                    <ul class="dropdown-menu mobile-dropdown-submenu">
                        <li><a href="../src/latest-news.php">In the News</a></li>
                    </ul>
                </li>
                <li class="dropdown mobile-only mobile-dropdown-parent">
                    <a href="#">Events <i class="fa-solid fa-angle-down"></i></a>
                    <ul class="dropdown-menu mobile-dropdown-submenu">
                        <li><a href="../src/state-games.php">State Games</a></li>
                        <li><a href="../src/event_calendar.php">Event Calendar</a></li>
                    </ul>
                </li>
                <li class="dropdown mobile-only mobile-dropdown-parent">
                    <a href="#">National Games 26' <i class="fa-solid fa-angle-down"></i></a>
                    <ul class="dropdown-menu mobile-dropdown-submenu">
                        <li><a href="../src/SONG 26.php?standalone=1" target="_blank">National Games 2026</a></li>
                    </ul>
                </li>
                <li class="dropdown mobile-only mobile-dropdown-parent">
                    <a href="#">Gallery <i class="fa-solid fa-angle-down"></i></a>
                    <ul class="dropdown-menu mobile-dropdown-submenu">
                        <li><a href="../src/gallery-photos.php">Photos</a></li>
                        <li><a href="../src/gallery-videos.php">Videos</a></li>
                    </ul>
                </li>
                <li class="dropdown mobile-only mobile-dropdown-parent">
                    <a href="#">Core Program <i class="fa-solid fa-angle-down"></i></a>
                    <ul class="dropdown-menu mobile-dropdown-submenu">
                        <li><a href="../src/sohap.php">Healthy Athletes Program</a></li>
                        <li><a href="../src/yap.php">Young Athletes Program</a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </nav>
    `
)