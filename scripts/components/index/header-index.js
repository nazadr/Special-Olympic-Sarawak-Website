// Reusable HTML Element written in JavaScript.
// Created on 8 Sep 2025

document.writeln(`
    <nav class="top-nav">
        <div class="logo">
            <a href="../index.php"><img src="../assets/images/Remake/SO Sarawak horizontal logo BG.png" alt="Logo" class="logo-img" style="margin-top: 4px;"></a>
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
                <!-- Searchbar moved to the very top for mobile -->
                <li class="dropdown mobile-dropdown-parent">
                    <a href="#about">About Us <i class="fa-solid fa-angle-down"></i></a>
                    <ul class="dropdown-menu mobile-dropdown-submenu">
                        <li><a href="../src/introduction.html">Introduction</a></li>
                        <!-- <li><a href="../src/dev.html">Organization Overview</a></li> -->
                        <li><a href="../src/brochure.html">SO Brochure</a></li>
                        <li><a href="../src/how_can_you_help.html">How can you help?</a></li>
                    </ul>
                </li>
                <li class="dropdown mobile-dropdown-parent">
                    <a href="#news">News <i class="fa-solid fa-angle-down"></i></a>
                    <ul class="dropdown-menu mobile-dropdown-submenu">
                        <li><a href="../src/latest-news.php">In the News</a></li>
                    </ul>
                </li>
                <li class="dropdown mobile-dropdown-parent">
                    <a href="#contact">Contact Us <i class="fa-solid fa-angle-down"></i></a>
                    <ul class="dropdown-menu mobile-dropdown-submenu">
                        <li><a href="../src/visit_us_with_map.html">Visit Us</a></li>
                        <li><a href="../src/email-us.html">Email Us</a></li>
                    </ul>
                </li>
                <!-- Searchbar moved to the very top of the sidebar for mobile -->
                <!-- <li class="search-item">
                    <div class="search-container">
                        <form class="search-form">
                            <input type="text" placeholder="Search..." class="search-input">
                            <button type="submit" class="search-button">
                                <i class="fas fa-search"></i>
                            </button>
                        </form>
                    </div>
                </li> -->
                <!-- Donation and Join Us buttons moved to the very bottom of the sidebar for mobile -->
                <li class="donation-item">
                    <div class="donation-button-container">
                        <a href="../src/donation_page.html" class="donate-btn">Donate</a>
                        <a href="../src/join_us.html" class="donate-btn">Join Us</a>
                    </div>
                </li>
                <!-- Bottom Navigation items integrated here for mobile -->
                <li class="dropdown mobile-only mobile-dropdown-parent">
                    <a href="#">What We Do? <i class="fa-solid fa-angle-down"></i></a>
                    <ul class="dropdown-menu mobile-dropdown-submenu">
                        <li><a href="../src/getting_started.html">Getting Started</a></li>
                        <li><a href="../src/alp.php">Athlete Leadership Program (ALP)</a></li>
                        <li><a href="../src/yap.php">Young Athletes Program (YAP)</a></li>
                    </ul>
                </li>
                <li class="dropdown mobile-only mobile-dropdown-parent">
                    <a href="#">Core Program <i class="fa-solid fa-angle-down"></i></a>
                    <ul class="dropdown-menu mobile-dropdown-submenu">
                        <li><a href="../src/sohap.php">Healthy Athletes Program (HAP)</a></li>
                    </ul>
                </li>
                <li class="dropdown mobile-only mobile-dropdown-parent">
                    <a href="#">Sports <i class="fa-solid fa-angle-down"></i></a>
                    <ul class="dropdown-menu mobile-dropdown-submenu">
                        <li><a href="../src/sport.php">Our Sports</a></li>
                    </ul>
                </li>
                <li class="dropdown mobile-only mobile-dropdown-parent">
                    <a href="#">Affiliate <i class="fa-solid fa-angle-down"></i></a>
                    <ul class="dropdown-menu mobile-dropdown-submenu">
                        <li><a href="../src/sarawak-chapters.php">Sarawak Chapters</a></li>
                        <li><a href="../src/sponsorships.php">Sponsorships</a></li>
                        <li><a href="../src/other-so.php">Other Special Olympics</a></li>
                    </ul>
                </li>
                <li class="dropdown mobile-only mobile-dropdown-parent">
                    <a href="#">Events <i class="fa-solid fa-angle-down"></i></a>
                    <ul class="dropdown-menu mobile-dropdown-submenu">
                        <li><a href="../src/SONG 26.php">SONG 26</a></li>
                        <li><a href="../src/state-games.php">State Games</a></li>
                        <li><a href="../src/event_calendar.php">Event Calendar</a></li>
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
                    <a href="#">Join Us <i class="fa-solid fa-angle-down"></i></a>
                    <ul class="dropdown-menu mobile-dropdown-submenu">
                        <li><a href="../src/join_us.html">Join Us</a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </nav>
    `
)