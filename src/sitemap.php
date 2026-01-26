<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sitemap | Special Olympics Sarawak</title>
    <link rel="shortcut icon" href="../assets/images/master_logo_front.png">
    <link rel="stylesheet" href="../css/global-style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <style>
        /* Header space for fixed navigation */
        .header-space {
            height: 100px;
        }

        /* Hero Banner */
        .sitemap-hero {
            background: linear-gradient(135deg, #e21b23 0%, #b71c1c 100%);
            color: white;
            padding: 60px 20px;
            text-align: center;
        }

        .sitemap-hero h1 {
            font-size: 3rem;
            font-weight: 700;
            margin: 0;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.2);
        }

        .sitemap-hero p {
            font-size: 1.1rem;
            margin-top: 15px;
            opacity: 0.95;
        }

        /* Main Container */
        .sitemap-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 40px 20px 80px;
            background-color: #f8f9fa;
        }

        /* Sitemap Tree Styles */
        .sitemap-tree {
            background: white;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
            padding: 40px;
        }

        .sitemap-section {
            margin-bottom: 30px;
        }

        .sitemap-section:last-child {
            margin-bottom: 0;
        }

        /* Main Category (Level 1) */
        .sitemap-category {
            position: relative;
            padding-left: 25px;
            margin-bottom: 20px;
        }

        .sitemap-category::before {
            content: '';
            position: absolute;
            left: 0;
            top: 12px;
            width: 15px;
            height: 3px;
            background: #e21b23;
        }

        .sitemap-category > a {
            font-size: 1.3rem;
            font-weight: 700;
            color: #1a1a1a;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 10px;
            transition: color 0.3s ease;
        }

        .sitemap-category > a:hover {
            color: #e21b23;
        }

        .sitemap-category > a i {
            color: #e21b23;
            font-size: 1rem;
        }

        /* Subcategory List (Level 2) */
        .sitemap-subcategory {
            list-style: none;
            padding: 0;
            margin: 15px 0 0 40px;
            border-left: 2px solid #e5e5e5;
        }

        .sitemap-subcategory li {
            position: relative;
            padding: 8px 0 8px 25px;
        }

        .sitemap-subcategory li::before {
            content: '';
            position: absolute;
            left: 0;
            top: 18px;
            width: 15px;
            height: 2px;
            background: #ddd;
        }

        .sitemap-subcategory li a {
            font-size: 1rem;
            color: #444;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: all 0.3s ease;
        }

        .sitemap-subcategory li a:hover {
            color: #e21b23;
            transform: translateX(5px);
        }

        .sitemap-subcategory li a i {
            color: #999;
            font-size: 0.85rem;
            transition: color 0.3s ease;
        }

        .sitemap-subcategory li a:hover i {
            color: #e21b23;
        }

        /* Deep Nested (Level 3) */
        .sitemap-nested {
            list-style: none;
            padding: 0;
            margin: 10px 0 0 30px;
            border-left: 2px solid #f0f0f0;
        }

        .sitemap-nested li {
            position: relative;
            padding: 6px 0 6px 20px;
        }

        .sitemap-nested li::before {
            content: '';
            position: absolute;
            left: 0;
            top: 14px;
            width: 12px;
            height: 2px;
            background: #eee;
        }

        .sitemap-nested li a {
            font-size: 0.95rem;
            color: #666;
        }

        /* Section Divider */
        .sitemap-divider {
            height: 1px;
            background: linear-gradient(90deg, transparent, #ddd 20%, #ddd 80%, transparent);
            margin: 30px 0;
        }

        /* Legend */
        .sitemap-legend {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            padding: 20px;
            background: #f8f9fa;
            border-radius: 8px;
            margin-bottom: 30px;
        }

        .legend-item {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 0.9rem;
            color: #666;
        }

        .legend-item i {
            width: 20px;
            text-align: center;
        }

        .legend-item.page i { color: #4CAF50; }
        .legend-item.section i { color: #2196F3; }
        .legend-item.external i { color: #FF9800; }
        .legend-item.form i { color: #9C27B0; }

        /* Quick Links */
        .quick-links {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 15px;
            margin-bottom: 40px;
        }

        .quick-link {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 15px 20px;
            background: white;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.06);
            text-decoration: none;
            color: #333;
            transition: all 0.3s ease;
            border-left: 4px solid transparent;
        }

        .quick-link:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
            border-left-color: #e21b23;
        }

        .quick-link i {
            font-size: 1.5rem;
            color: #e21b23;
        }

        .quick-link span {
            font-weight: 600;
        }

        /* Stats Bar */
        .stats-bar {
            display: flex;
            justify-content: center;
            gap: 40px;
            padding: 25px;
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            border-radius: 10px;
            margin-bottom: 30px;
        }

        .stat-item {
            text-align: center;
        }

        .stat-value {
            font-size: 2rem;
            font-weight: 700;
            color: #e21b23;
        }

        .stat-label {
            font-size: 0.9rem;
            color: #666;
            margin-top: 5px;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .sitemap-hero h1 {
                font-size: 2rem;
            }

            .sitemap-tree {
                padding: 25px 20px;
            }

            .sitemap-category > a {
                font-size: 1.1rem;
            }

            .sitemap-subcategory {
                margin-left: 25px;
            }

            .stats-bar {
                flex-direction: column;
                gap: 20px;
            }

            .quick-links {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <script src="../scripts/components/header.js"></script>
    <script src="../scripts/components/socmed-bar.js"></script>
    <div class="header-space"></div>

    <!-- Hero Banner -->
    <div class="sitemap-hero">
        <h1><i class="fas fa-sitemap"></i> Sitemap</h1>
        <p>Navigate through all pages of Special Olympics Sarawak website</p>
    </div>

    <div class="sitemap-container">
        <!-- Quick Stats -->
        <div class="stats-bar">
            <div class="stat-item">
                <div class="stat-value">40+</div>
                <div class="stat-label">Total Pages</div>
            </div>
            <div class="stat-item">
                <div class="stat-value">8</div>
                <div class="stat-label">Main Sections</div>
            </div>
            <div class="stat-item">
                <div class="stat-value">5</div>
                <div class="stat-label">Chapters</div>
            </div>
        </div>

        <!-- Quick Links -->
        <div class="quick-links">
            <a href="../index.php" class="quick-link">
                <i class="fas fa-home"></i>
                <span>Home</span>
            </a>
            <a href="join_us.html" class="quick-link">
                <i class="fas fa-user-plus"></i>
                <span>Join Us</span>
            </a>
            <a href="donation_page.php" class="quick-link">
                <i class="fas fa-heart"></i>
                <span>Donate</span>
            </a>
            <a href="event_calendar.php" class="quick-link">
                <i class="fas fa-calendar-alt"></i>
                <span>Events</span>
            </a>
        </div>

        <!-- Sitemap Tree -->
        <div class="sitemap-tree">
            
            <!-- Home -->
            <div class="sitemap-section">
                <div class="sitemap-category">
                    <a href="../index.php"><i class="fas fa-home"></i> Home</a>
                </div>
            </div>

            <div class="sitemap-divider"></div>

            <!-- About Us -->
            <div class="sitemap-section">
                <div class="sitemap-category">
                    <a href="#"><i class="fas fa-info-circle"></i> About Us</a>
                    <ul class="sitemap-subcategory">
                        <li><a href="introduction.html"><i class="fas fa-file"></i> Introduction</a></li>
                        <li><a href="brochure.html"><i class="fas fa-file-pdf"></i> SO Brochure</a></li>
                        <li><a href="how_can_you_help.html"><i class="fas fa-hands-helping"></i> How Can You Help?</a></li>
                    </ul>
                </div>
            </div>

            <div class="sitemap-divider"></div>

            <!-- What We Do -->
            <div class="sitemap-section">
                <div class="sitemap-category">
                    <a href="#"><i class="fas fa-bullseye"></i> What We Do?</a>
                    <ul class="sitemap-subcategory">
                        <li>
                            <a href="getting_started.php"><i class="fas fa-play-circle"></i> Getting Started</a>
                            <ul class="sitemap-nested">
                                <li><a href="sohap.php"><i class="fas fa-stethoscope"></i> Healthy Athletes Program</a></li>
                                <li><a href="alp.php"><i class="fas fa-medal"></i> Athlete Leadership Program </a></li>
                                <li><a href="yap.php"><i class="fas fa-child"></i> Young Athletes Program</a></li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="sitemap-divider"></div>

            <!-- Core Programs -->
            <div class="sitemap-section">
                <div class="sitemap-category">
                    <a href="#"><i class="fas fa-heartbeat"></i> Core Programs</a>
                    <ul class="sitemap-subcategory">
                        <li><a href="sohap.php"><i class="fas fa-stethoscope"></i> Healthy Athletes Program</a></li>
                        <li>
                            <a href="yap.php"><i class="fas fa-child"></i> Young Athletes Program</a>
                            <ul class="sitemap-nested">
                                <li><a href="yap-lm.html"><i class="fas fa-book-open"></i> Young Athletes Program Learn More</a></li>
                                <li><a href="yap-lm-brochure.html"><i class="fas fa-file-alt"></i> Young Athletes Program Brochure</a></li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="sitemap-divider"></div>

            <!-- Sports -->
            <div class="sitemap-section">
                <div class="sitemap-category">
                    <a href="sport.php"><i class="fas fa-running"></i> Sports</a>
                    <ul class="sitemap-subcategory">
                        <li><a href="sport.php"><i class="fas fa-trophy"></i> Our Sports</a></li>
                    </ul>
                </div>
            </div>

            <div class="sitemap-divider"></div>

            <!-- SONG 2026 -->
            <div class="sitemap-section">
                <div class="sitemap-category">
                    <a href="SONG 26.php"><i class="fas fa-star"></i> SONG 2026</a>
                    <ul class="sitemap-subcategory">
                        <li><a href="SONG 26.php"><i class="fas fa-flag-checkered"></i> Special Olympics National Games 2026</a></li>
                        <li><a href="so-national-games-2026.html"><i class="fas fa-info"></i> SONG 2026 Information</a></li>
                    </ul>
                </div>
            </div>

            <div class="sitemap-divider"></div>

            <!-- Events -->
            <div class="sitemap-section">
                <div class="sitemap-category">
                    <a href="#"><i class="fas fa-calendar-alt"></i> Events</a>
                    <ul class="sitemap-subcategory">
                        <li>
                            <a href="state-games.php"><i class="fas fa-medal"></i> State Games</a>
                            <ul class="sitemap-nested">
                                <li><a href="learn-more/7th-state-games-kuching-2025.html"><i class="fas fa-trophy"></i> 7th State Games Kuching 2025</a></li>
                            </ul>
                        </li>
                        <li><a href="event_calendar.php"><i class="fas fa-calendar"></i> Events Calendar</a></li>
                    </ul>
                </div>
            </div>

            <div class="sitemap-divider"></div>

            <!-- Sarawak Chapters -->
            <div class="sitemap-section">
                <div class="sitemap-category">
                    <a href="sarawak-chapters.php"><i class="fas fa-map-marker-alt"></i> Sarawak Chapters</a>
                    <ul class="sitemap-subcategory">
                        <li><a href="sarawak-chapters.php"><i class="fas fa-map"></i> All Chapters</a></li>
                        <li><a href="ch_kuching.html"><i class="fas fa-location-dot"></i> Kuching Chapter</a></li>
                        <li><a href="ch_samarahan.html"><i class="fas fa-location-dot"></i> Samarahan Chapter</a></li>
                        <li><a href="ch_sibu.html"><i class="fas fa-location-dot"></i> Sibu Chapter</a></li>
                        <li><a href="ch_bintulu.html"><i class="fas fa-location-dot"></i> Bintulu Chapter</a></li>
                        <li><a href="ch_miri.html"><i class="fas fa-location-dot"></i> Miri Chapter</a></li>
                    </ul>
                </div>
            </div>

            <div class="sitemap-divider"></div>

            <!-- Affiliate -->
            <div class="sitemap-section">
                <div class="sitemap-category">
                    <a href="#"><i class="fas fa-handshake"></i> Affiliate</a>
                    <ul class="sitemap-subcategory">
                        <li><a href="sponsorships.php"><i class="fas fa-building"></i> Sponsorships</a></li>
                        <li><a href="other-so.php"><i class="fas fa-globe"></i> Special Olympics Organizations</a></li>
                    </ul>
                </div>
            </div>

            <div class="sitemap-divider"></div>

            <!-- Gallery -->
            <div class="sitemap-section">
                <div class="sitemap-category">
                    <a href="#"><i class="fas fa-images"></i> Gallery</a>
                    <ul class="sitemap-subcategory">
                        <li><a href="gallery-photos.php"><i class="fas fa-camera"></i> Photos</a></li>
                        <li><a href="gallery-videos.php"><i class="fas fa-video"></i> Videos</a></li>
                        <li><a href="video-player.php"><i class="fas fa-play"></i> Video Player</a></li>
                    </ul>
                </div>
            </div>

            <div class="sitemap-divider"></div>

            <!-- News -->
            <div class="sitemap-section">
                <div class="sitemap-category">
                    <a href="latest-news.php"><i class="fas fa-newspaper"></i> News</a>
                    <ul class="sitemap-subcategory">
                        <li><a href="latest-news.php"><i class="fas fa-rss"></i> In the News</a></li>
                    </ul>
                </div>
            </div>

            <div class="sitemap-divider"></div>

            <!-- Join Us -->
            <div class="sitemap-section">
                <div class="sitemap-category">
                    <a href="join_us.html"><i class="fas fa-user-plus"></i> Join Us</a>
                    <ul class="sitemap-subcategory">
                        <li><a href="join_us.html"><i class="fas fa-door-open"></i> Join Us Overview</a></li>
                        <li><a href="ja-athlete.php"><i class="fas fa-edit"></i> Become an Athlete</a></li>
                        <li><a href="ja-coach.php"><i class="fas fa-edit"></i> Become a Coach</a></li>
                        <li><a href="ja-volunteer.php"><i class="fas fa-edit"></i> Become a Volunteer</a></li>
                        <li><a href="ja-unified.php"><i class="fas fa-edit"></i> Unified Partner Registration</a></li>
                        <li><a href="ja-nationalgames.php"><i class="fas fa-edit"></i> National Games Registration</a></li>
                    </ul>
                </div>
            </div>

            <div class="sitemap-divider"></div>

            <!-- Contact Us -->
            <div class="sitemap-section">
                <div class="sitemap-category">
                    <a href="#"><i class="fas fa-envelope"></i> Contact Us</a>
                    <ul class="sitemap-subcategory">
                        <li><a href="visit_us_with_map.html"><i class="fas fa-map-marked-alt"></i> Visit Us</a></li>
                        <li><a href="email-us.html"><i class="fas fa-paper-plane"></i> Email Us</a></li>
                    </ul>
                </div>
            </div>

            <div class="sitemap-divider"></div>

            <!-- Support -->
            <div class="sitemap-section">
                <div class="sitemap-category">
                    <a href="donation_page.php"><i class="fas fa-heart"></i> Support Us</a>
                    <ul class="sitemap-subcategory">
                        <li><a href="donation_page.php"><i class="fas fa-donate"></i> Make a Donation</a></li>
                    </ul>
                </div>
            </div>

            <div class="sitemap-divider"></div>

            <!-- Legal -->
            <div class="sitemap-section">
                <div class="sitemap-category">
                    <a href="#"><i class="fas fa-gavel"></i> Legal</a>
                    <ul class="sitemap-subcategory">
                        <li><a href="terms-and-conditions.php"><i class="fas fa-file-contract"></i> Terms & Conditions</a></li>
                        <li><a href="privacy-policy.html"><i class="fas fa-user-shield"></i> Privacy Policy</a></li>
                    </ul>
                </div>
            </div>

            <div class="sitemap-divider"></div>

            <!-- Admin -->
            <div class="sitemap-section">
                <div class="sitemap-category">
                    <a href="../admin/login_page_v1.php"><i class="fas fa-lock"></i> Admin</a>
                    <ul class="sitemap-subcategory">
                        <li><a href="../admin/login_page_v1.php"><i class="fas fa-sign-in-alt"></i> Admin Login</a></li>
                    </ul>
                </div>
            </div>

        </div>
    </div>

    <div class="section-divider"></div>
    <script src="../scripts/components/bottom-nav.js"></script>
    <script src="../scripts/components/site-footer.js"></script>
    <script src="../scripts/script.js"></script>
</body>
</html>
