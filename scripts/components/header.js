// Reusable HTML Element written in JavaScript.
// Created on 8 Sep 2025

document.writeln(`
    <nav class="top-nav">
        <div class="logo">
            <img src="../assets/images/Special_olympic_sarawak_Logo_new.png" alt="Logo" class="logo-img">
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
                        <li><a href="../src/organization_overview.html">Organization Overview</a></li>
                        <li><a href="../src/brochure.html">SO Brochure</a></li>
                        <li><a href="../src/how_can_you_help.html">How can you help?</a></li>
                    </ul>
                </li>
                <li class="dropdown mobile-dropdown-parent">
                    <a href="#news">News <i class="fa-solid fa-angle-down"></i></a>
                    <ul class="dropdown-menu mobile-dropdown-submenu">
                        <li><a href="../src/latest-news.php">Latest News</a></li>
                        <li><a href="#">Archived News</a></li>
                    </ul>
                </li>
                <li class="dropdown mobile-dropdown-parent">
                    <a href="#contact">Contact Us <i class="fa-solid fa-angle-down"></i></a>
                    <ul class="dropdown-menu mobile-dropdown-submenu">
                        <li><a href="../src/visit_us_with_map.html">Visit Us</a></li>
                        <li><a href="#">Email Us</a></li>
                    </ul>
                </li>
                <!-- Searchbar moved to the very top of the sidebar for mobile -->
                <li class="search-item">
                    <div class="search-container">
                        <form class="search-form">
                            <input type="text" placeholder="Search..." class="search-input">
                            <button type="submit" class="search-button">
                                <i class="fas fa-search"></i>
                            </button>
                        </form>
                    </div>
                </li>
                <!-- Donation button moved to the very bottom of the sidebar for mobile -->
                <li class="donation-item">
                    <div class="donation-button-container">
                        <a href="../src/donation_pages_test1.html" class="donate-btn">Donate</a>
                    </div>
                </li>
                <!-- Bottom Navigation items integrated here for mobile -->
                <li class="dropdown mobile-only mobile-dropdown-parent">
                    <a href="#">What We Do? <i class="fa-solid fa-angle-down"></i></a>
                    <ul class="dropdown-menu mobile-dropdown-submenu">
                        <li><a href="../src/getting_started.html">Getting Started</a></li>
                        <li><a href="../src/sport.html">Our Sports</a></li>
                    </ul>
                </li>
                <li class="dropdown mobile-only mobile-dropdown-parent">
                    <a href="#">Affiliate <i class="fa-solid fa-angle-down"></i></a>
                    <ul class="dropdown-menu mobile-dropdown-submenu">
                        <li><a href="../src/loaffiliate_v1.html">Sarawak Chapters</a></li>
                        <li><a href="../src/sponsorships.html">Sponsorships</a></li>
                    </ul>
                </li>
                <li class="dropdown mobile-only mobile-dropdown-parent">
                    <a href="#">Events <i class="fa-solid fa-angle-down"></i></a>
                    <ul class="dropdown-menu mobile-dropdown-submenu">
                        <li><a href="#photos">Healthy Athletes Program (SOHAP)</a></li>
                        <li><a href="#photos">Athletes Leadership Program (ALPs)</a></li>
                        <li><a href="#photos">Young Athletes Program (YAP)</a></li>
                        <li><a href="../src/state-games.html">State Games</a></li>
                        <li><a href="../src/event_calendar.php">Event Calendar</a></li>
                    </ul>
                </li>
                <li class="dropdown mobile-only mobile-dropdown-parent">
                    <a href="#">Gallery <i class="fa-solid fa-angle-down"></i></a>
                    <ul class="dropdown-menu mobile-dropdown-submenu">
                        <li><a href="#photos">Photos</a></li>
                        <li><a href="#videos">Videos</a></li>
                    </ul>
                </li>
                <li class="dropdown mobile-only mobile-dropdown-parent">
                    <a href="#">Join Us <i class="fa-solid fa-angle-down"></i></a>
                    <ul class="dropdown-menu mobile-dropdown-submenu">
                        <li><a href="../src/join_us.html">Join Us</a></li>
                    </ul>
                </li>
                <li class="dropdown mobile-only mobile-dropdown-parent">
                    <a href="#">Community <i class="fa-solid fa-angle-down"></i></a>
                    <ul class="dropdown-menu mobile-dropdown-submenu">
                        <li><a href="#join">Program Partners</a></li>
                        <li><a href="#details">Other Special Olympics</a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </nav>
    `
)