<?php
// Placeholder for future database integration
$song26Data = [];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Special Olympics Sarawak — 6th National Games | SONG 26</title>
    <link rel="shortcut icon" href="../assets/images/master_logo_front.png">
    <link rel="stylesheet" href="../css/global-style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <style>
        /* Local style within this HTML */
        :root {
            --so-red: #D90429;
            --so-white: #ffffff;
            --so-dark: #1a1a1a;
            --so-gray: #666;
            --so-light-gray: #f5f5f5;
            --shadow-sm: 0 2px 10px rgba(217, 4, 41, 0.08);
            --shadow-md: 0 4px 20px rgba(217, 4, 41, 0.12);
            --shadow-lg: 0 8px 30px rgba(217, 4, 41, 0.15);
            --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .header-space {
            height: 70px;
            background: transparent;
        }

        .body {
            background-color: var(--so-white);
            overflow-y: auto;
            min-height: 100vh;
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', 'Roboto', 'Helvetica Neue', Arial, sans-serif;
        }

        /* Hero Section - SEA Games Inspired */
        .song26-hero {
            background: linear-gradient(135deg, var(--so-red) 0%, #8b0000 100%);
            min-height: 75vh;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
            color: white;
            position: relative;
            overflow: hidden;
            padding: 80px 20px;
        }

        .song26-hero::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: 
                radial-gradient(circle at 20% 50%, rgba(255,255,255,0.08) 0%, transparent 50%),
                radial-gradient(circle at 80% 80%, rgba(255,255,255,0.06) 0%, transparent 50%);
            pointer-events: none;
        }

        .song26-hero-content {
            position: relative;
            z-index: 2;
            max-width: 1200px;
            animation: fadeInUp 1s ease;
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .song26-hero-logo {
            width: 140px;
            height: 140px;
            margin-bottom: 30px;
            filter: brightness(0) invert(1) drop-shadow(0 4px 20px rgba(0,0,0,0.2));
            animation: floatLogo 3s ease-in-out infinite;
        }

        @keyframes floatLogo {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-10px); }
        }

        .song26-hero-location {
            font-size: 1.3rem;
            font-weight: 600;
            margin-bottom: 10px;
            opacity: 0.9;
            letter-spacing: 1px;
            color: rgba(255,255,255,0.95);
        }

        .song26-hero h1 {
            font-size: 3.8rem;
            font-weight: 800;
            margin-bottom: 20px;
            line-height: 1.2;
            letter-spacing: -1px;
        }

        .song26-hero-subtitle {
            font-size: 1.5rem;
            font-weight: 300;
            margin-bottom: 15px;
            opacity: 0.95;
            letter-spacing: 2px;
            text-transform: uppercase;
        }

        .song26-hero-date {
            font-size: 2rem;
            font-weight: 600;
            margin-top: 10px;
            padding: 15px 40px;
            background: rgba(255,255,255,0.15);
            backdrop-filter: blur(10px);
            border-radius: 50px;
            display: inline-block;
            border: 2px solid rgba(255,255,255,0.3);
        }

        .song26-hero-logo-inline {
            display: none;
        }

        /* Main Content Container - Full Width Sections */
        .song26-main-content {
            background: var(--so-white);
        }

        /* Full Width Section Wrapper */
        .song26-full-section {
            width: 100%;
            padding: 80px 0;
        }

        .song26-full-section.gray-bg {
            background: var(--so-light-gray);
        }

        .song26-full-section.white-bg {
            background: var(--so-white);
        }

        .song26-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 40px;
        }

        /* Section Title - SEA Games Style */
        .song26-section-title {
            text-align: center;
            margin-bottom: 60px;
        }

        .song26-section-title h2 {
            font-size: 2.8rem;
            font-weight: 800;
            color: var(--so-dark);
            margin-bottom: 15px;
            text-transform: uppercase;
            letter-spacing: 1px;
            position: relative;
            display: inline-block;
        }

        .song26-section-title h2::after {
            content: '';
            position: absolute;
            bottom: -10px;
            left: 50%;
            transform: translateX(-50%);
            width: 80px;
            height: 4px;
            background: var(--so-red);
            border-radius: 2px;
        }

        .song26-section-title p {
            font-size: 1.2rem;
            color: var(--so-gray);
            max-width: 700px;
            margin: 25px auto 0;
            line-height: 1.8;
        }

        /* Info Cards - Enhanced Grid */
        .song26-info-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
            gap: 30px;
            margin-top: 50px;
        }

        .song26-info-card {
            background: var(--so-white);
            border-radius: 20px;
            padding: 50px 35px;
            text-align: center;
            transition: var(--transition);
            border: 2px solid transparent;
            box-shadow: var(--shadow-sm);
            position: relative;
            overflow: hidden;
        }

        .song26-info-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 5px;
            background: linear-gradient(90deg, var(--so-red) 0%, #ff4d6d 100%);
            transform: scaleX(0);
            transition: var(--transition);
        }

        .song26-info-card:hover::before {
            transform: scaleX(1);
        }

        .song26-info-card:hover {
            transform: translateY(-10px);
            box-shadow: var(--shadow-lg);
            border-color: var(--so-red);
        }

        .song26-icon-wrapper {
            width: 90px;
            height: 90px;
            margin: 0 auto 25px;
            background: linear-gradient(135deg, var(--so-red) 0%, #8b0000 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 10px 30px rgba(217, 4, 41, 0.3);
            transition: var(--transition);
        }

        .song26-info-card:hover .song26-icon-wrapper {
            transform: scale(1.1) rotate(5deg);
        }

        .song26-info-card i {
            font-size: 2.5rem;
            color: var(--so-white);
        }

        .song26-info-card h3 {
            font-size: 1.5rem;
            color: var(--so-dark);
            margin-bottom: 15px;
            font-weight: 700;
        }

        .song26-info-card p {
            font-size: 1.05rem;
            color: var(--so-gray);
            line-height: 1.7;
        }

        /* Content Sections - Full Width Alternating */
        .song26-content-section {
            padding: 70px 0;
            text-align: center;
        }

        .song26-content-box {
            max-width: 900px;
            margin: 0 auto;
            padding: 50px;
            background: var(--so-white);
            border-radius: 25px;
            box-shadow: var(--shadow-md);
            border-left: 5px solid var(--so-red);
        }

        .song26-content-box h3 {
            font-size: 2rem;
            color: var(--so-red);
            margin-bottom: 25px;
            font-weight: 700;
        }

        .song26-content-box p {
            font-size: 1.15rem;
            color: var(--so-dark);
            line-height: 1.9;
        }

        /* Motto Section - Special Highlight */
        .song26-motto-section {
            padding: 100px 40px;
            background: linear-gradient(135deg, var(--so-red) 0%, #8b0000 100%);
            text-align: center;
            position: relative;
            overflow: hidden;
        }

        .song26-motto-section::before {
            content: '"';
            position: absolute;
            top: 20px;
            left: 50%;
            transform: translateX(-50%);
            font-size: 15rem;
            color: rgba(255,255,255,0.1);
            font-family: Georgia, serif;
            line-height: 1;
        }

        .song26-motto-content {
            position: relative;
            z-index: 2;
            max-width: 900px;
            margin: 0 auto;
        }

        .song26-motto-content h3 {
            font-size: 1.5rem;
            color: rgba(255,255,255,0.9);
            margin-bottom: 20px;
            text-transform: uppercase;
            letter-spacing: 3px;
            font-weight: 300;
        }

        .song26-motto-content p {
            font-size: 2.2rem;
            color: var(--so-white);
            font-weight: 300;
            line-height: 1.6;
            font-style: italic;
            text-shadow: 0 2px 10px rgba(0,0,0,0.2);
        }

        /* Participation Grid */
        .song26-participation-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 25px;
            margin-top: 40px;
        }

        .song26-sport-card {
            background: var(--so-white);
            padding: 30px 25px;
            border-radius: 15px;
            border-left: 4px solid var(--so-red);
            box-shadow: var(--shadow-sm);
            transition: var(--transition);
            text-align: left;
        }

        .song26-sport-card:hover {
            transform: translateX(5px);
            box-shadow: var(--shadow-md);
        }

        .song26-sport-card::before {
            content: '◆';
            color: var(--so-red);
            margin-right: 10px;
            font-size: 1.2rem;
        }

        /* Get Involved Section */
        .song26-involvement-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
            gap: 30px;
            margin-top: 50px;
        }

        .song26-involvement-card {
            background: var(--so-white);
            padding: 40px 35px;
            border-radius: 20px;
            box-shadow: var(--shadow-sm);
            transition: var(--transition);
            border-top: 5px solid var(--so-red);
            text-align: left;
        }

        .song26-involvement-card:hover {
            transform: translateY(-8px);
            box-shadow: var(--shadow-lg);
        }

        .song26-involvement-card h4 {
            font-size: 1.4rem;
            color: var(--so-red);
            margin-bottom: 15px;
            font-weight: 700;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .song26-involvement-card h4::before {
            content: '►';
            font-size: 1rem;
        }

        .song26-involvement-card p {
            font-size: 1.05rem;
            color: var(--so-dark);
            line-height: 1.7;
        }

        /* Organizing Committee - Enhanced Layout */
        .song26-committee-section {
            padding: 80px 0;
            background: var(--so-light-gray);
        }

        .song26-committee-title {
            font-size: 2.8rem;
            font-weight: 800;
            color: var(--so-dark);
            text-align: center;
            margin-bottom: 60px;
            text-transform: uppercase;
            letter-spacing: 1px;
            position: relative;
            display: inline-block;
            width: 100%;
        }

        .song26-committee-title::after {
            content: '';
            position: absolute;
            bottom: -15px;
            left: 50%;
            transform: translateX(-50%);
            width: 100px;
            height: 4px;
            background: var(--so-red);
            border-radius: 2px;
        }

        .song26-committee-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 35px;
            max-width: 1100px;
            margin: 0 auto;
            padding: 0 40px;
        }

        .song26-committee-card {
            background: var(--so-white);
            border-radius: 20px;
            padding: 45px 30px;
            text-align: center;
            box-shadow: var(--shadow-sm);
            transition: var(--transition);
            border-top: 4px solid var(--so-red);
            position: relative;
        }

        .song26-committee-card:hover {
            transform: translateY(-8px);
            box-shadow: var(--shadow-lg);
        }

        .song26-committee-photo {
            width: 110px;
            height: 110px;
            margin: 0 auto 25px;
            background: linear-gradient(135deg, var(--so-red) 0%, #8b0000 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            border: 4px solid rgba(217, 4, 41, 0.1);
            transition: var(--transition);
            box-shadow: 0 8px 25px rgba(217, 4, 41, 0.2);
        }

        .song26-committee-card:hover .song26-committee-photo {
            transform: scale(1.08);
            box-shadow: 0 12px 35px rgba(217, 4, 41, 0.3);
        }

        .song26-committee-photo i {
            font-size: 2.8rem;
            color: var(--so-white);
        }

        .song26-committee-role {
            font-size: 0.95rem;
            color: var(--so-red);
            text-transform: uppercase;
            letter-spacing: 2px;
            font-weight: 700;
            margin-bottom: 12px;
        }

        .song26-committee-name {
            font-size: 1.25rem;
            color: var(--so-dark);
            font-weight: 600;
            margin-bottom: 8px;
            line-height: 1.4;
        }

        .song26-committee-position {
            font-size: 0.95rem;
            color: var(--so-gray);
            font-style: italic;
        }

        .song26-committee-hierarchy,
        .song26-committee-level,
        .song26-committee-member {
            display: none;
        }

        /* Sponsors Section */
        .song26-sponsors-section {
            padding: 80px 0;
            background: var(--so-white);
        }

        .song26-sponsors-title {
            font-size: 2.8rem;
            font-weight: 800;
            color: var(--so-dark);
            text-align: center;
            margin-bottom: 20px;
            text-transform: uppercase;
            letter-spacing: 1px;
            position: relative;
            display: inline-block;
            width: 100%;
        }

        .song26-sponsors-title::after {
            content: '';
            position: absolute;
            bottom: -15px;
            left: 50%;
            transform: translateX(-50%);
            width: 100px;
            height: 4px;
            background: var(--so-red);
            border-radius: 2px;
        }

        .song26-sponsors-subtitle {
            text-align: center;
            font-size: 1.2rem;
            color: var(--so-gray);
            margin-bottom: 60px;
            max-width: 700px;
            margin-left: auto;
            margin-right: auto;
        }

        .song26-sponsor-tier {
            margin-bottom: 60px;
        }

        .song26-sponsor-tier-title {
            text-align: center;
            font-size: 1.5rem;
            color: var(--so-red);
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 2px;
            margin-bottom: 30px;
        }

        .song26-sponsors-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 30px;
            max-width: 1100px;
            margin: 0 auto;
            padding: 0 40px;
        }

        .song26-sponsor-card {
            background: var(--so-white);
            border-radius: 20px;
            padding: 40px;
            text-align: center;
            box-shadow: var(--shadow-sm);
            transition: var(--transition);
            border: 2px solid #f0f0f0;
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 180px;
        }

        .song26-sponsor-card:hover {
            transform: translateY(-8px);
            box-shadow: var(--shadow-lg);
            border-color: var(--so-red);
        }

        .song26-sponsor-logo {
            max-width: 100%;
            max-height: 100px;
            object-fit: contain;
            filter: grayscale(100%);
            transition: var(--transition);
        }

        .song26-sponsor-card:hover .song26-sponsor-logo {
            filter: grayscale(0%);
        }

        .song26-sponsor-placeholder {
            width: 100%;
            height: 100px;
            background: var(--so-light-gray);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--so-gray);
            font-size: 1.1rem;
            font-weight: 600;
        }

        /* Logo Section */
        .song26-logo-section {
            text-align: center;
            margin: 60px 0;
        }

        .song26-logo-card {
            display: flex;
            justify-content: center;
            align-items: center;
            margin: 36px 0 48px;
        }

        .song26-logo-placeholder {
            display: none;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .song26-hero {
                min-height: 60vh;
                padding: 60px 20px;
            }

            .song26-hero h1 {
                font-size: 2.2rem;
            }

            .song26-hero-location {
                font-size: 1.1rem;
            }

            .song26-hero-subtitle {
                font-size: 1.1rem;
            }

            .song26-hero-date {
                font-size: 1.5rem;
                padding: 12px 30px;
            }

            .song26-hero-logo {
                width: 100px;
                height: 100px;
                margin-bottom: 20px;
            }

            .song26-container {
                padding: 0 20px;
            }

            .song26-full-section {
                padding: 50px 0;
            }

            .song26-section-title h2 {
                font-size: 2rem;
            }

            .song26-section-title p {
                font-size: 1.05rem;
            }

            .song26-info-grid {
                grid-template-columns: 1fr;
                gap: 25px;
            }

            .song26-info-card {
                padding: 35px 25px;
            }

            .song26-content-box {
                padding: 35px 25px;
            }

            .song26-content-box h3 {
                font-size: 1.6rem;
            }

            .song26-motto-section {
                padding: 70px 20px;
            }

            .song26-motto-content p {
                font-size: 1.6rem;
            }

            .song26-participation-grid,
            .song26-involvement-grid {
                grid-template-columns: 1fr;
            }

            .song26-committee-section {
                padding: 50px 0;
            }

            .song26-committee-title {
                font-size: 2rem;
                margin-bottom: 40px;
            }

            .song26-committee-grid {
                grid-template-columns: 1fr;
                gap: 25px;
                padding: 0 20px;
            }

            .song26-sponsors-section {
                padding: 50px 0;
            }

            .song26-sponsors-title {
                font-size: 2rem;
            }

            .song26-sponsors-grid {
                grid-template-columns: 1fr;
                gap: 20px;
                padding: 0 20px;
            }
        }
    </style>
</head>
<body class="body">
    <!-- Navigation Bar (Loaded via JS) -->
    <script src="../scripts/components/header.js"></script>

    <!-- Social Media Bar (Loaded via JS) -->
    <script src="../scripts/components/socmed-bar.js"></script>

    <!-- Header Space for Navigation Bar -->
    <div class="header-space"></div>

    <!-- Hero Section -->
    <section class="song26-hero">
        <div class="song26-hero-content">
            <img src="../assets/icons/bintulu-stork.png" alt="SONG 26 Logo" class="song26-hero-logo">
            <div class="song26-hero-location">Bintulu, Sarawak</div>
            <div class="song26-hero-subtitle">6th National Games</div>
            <h1>Special Olympics Sarawak</h1>
            <div class="song26-hero-date">24 - 26 April 2026</div>
        </div>
    </section>

    <!-- Main Content -->
    <div class="song26-main-content">
        <!-- About Section -->
        <section class="song26-full-section white-bg">
            <div class="song26-container">
                <div class="song26-section-title">
                    <h2>SONG 2026</h2>
                    <p>A celebration of athletic achievement, inclusion, and community for athletes with intellectual disabilities across Sarawak.</p>
                </div>
                
                <!-- Logo Display -->
                <div class="song26-logo-section">
                    <div class="song26-logo-card">
                        <div aria-hidden="false" role="img" aria-label="Special Olympics Sarawak logo" style="width:74px;height:74px;background:#d90429;border-radius:50%;box-shadow:0 4px 16px rgba(217,4,41,0.12);display:flex;align-items:center;justify-content:center;">
                            <img src="../assets/icons/bintulu-stork.png" alt="Special Olympics Sarawak logo" style="width:36px;height:36px;display:block;object-fit:contain;filter:brightness(0) invert(1);" aria-hidden="false">
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Info Cards -->
        <section class="song26-full-section gray-bg">
            <div class="song26-container"> 
                <div class="song26-info-grid">
                    <div class="song26-info-card">
                        <div class="song26-icon-wrapper">
                            <i class="fas fa-map-marker-alt"></i>
                        </div>
                        <h3>Venue</h3> 
                        <p>Bintulu, Sarawak<br>Energy Town of Sarawak</p>
                    </div>
                    <div class="song26-info-card">
                        <div class="song26-icon-wrapper">
                            <i class="fas fa-calendar-alt"></i>
                        </div>
                        <h3>Date</h3>
                        <p>24 - 26 April 2026<br>Three Days of Competition & Unity</p>
                    </div>
                    <div class="song26-info-card">
                        <div class="song26-icon-wrapper">
                            <i class="fas fa-users"></i>
                        </div>
                        <h3>Participants</h3>
                        <p>Athletes, unified partners, coaches and delegations from all across Malaysia</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Purpose Section -->
        <section class="song26-full-section white-bg">
            <div class="song26-container">
                <div class="song26-content-section">
                    <div class="song26-content-box">
                        <h3>Purpose & Impact</h3>
                        <p>The Games focus on inclusion, skill development and community empowerment. They create opportunities for athletes to compete in a safe, supportive environment while fostering volunteerism, local engagement and lasting improvements to sports access across the state.</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Motto Section -->
        <section class="song26-motto-section">
            <div class="song26-motto-content">
                <h3>Our Motto</h3>
                <p>Let me win. But if I cannot win, let me be brave in the attempt.</p>
            </div>
        </section>

        <!-- Values Section -->
        <section class="song26-full-section white-bg">
            <div class="song26-container">
                <div class="song26-content-section">
                    <div class="song26-content-box">
                        <h3>Values & Legacy</h3>
                        <p>The event champions respect, courage and teamwork. Its legacy includes improved community programmes, trained volunteers, upgraded local facilities and greater public awareness about the abilities of people with intellectual disabilities.</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Participation Section -->
        <section class="song26-full-section gray-bg">
            <div class="song26-container">
                <div class="song26-section-title">
                    <h2>Sports Competitions</h2>
                    <p>Multiple sporting events organized to provide classification-appropriate competition and promote athlete development</p>
                </div>
                <div class="song26-participation-grid">
                    <div class="song26-sport-card">Athletics</div>
                    <div class="song26-sport-card">Aquatics</div>
                    <div class="song26-sport-card">Bocce</div>
                    <div class="song26-sport-card">Badminton</div>
                    <div class="song26-sport-card">Football 5-a-Side</div>
                    <div class="song26-sport-card">Table Tennis</div>
                    <div class="song26-sport-card">Basketball</div>
                    <div class="song26-sport-card">Unified Sports</div>
                </div>
            </div>
        </section>

        <!-- Get Involved Section --> 
         <!-- Part tok mun possible engkah link untuk forms mun sik just for informatics --> 
        <section class="song26-full-section white-bg">
            <div class="song26-container">
                <div class="song26-section-title">
                    <h2>Get Involved</h2>
                    <p>Be part of something bigger – join us in celebrating inclusion and athletic excellence</p>
                </div>
                <div class="song26-involvement-grid">
                    <div class="song26-involvement-card">
                        <h4>Volunteer</h4>
                        <p>Support athletes, assist with logistics, and help create an unforgettable experience. Your time and energy make a real difference in our community programmes.</p>
                    </div>
                    <div class="song26-involvement-card">
                        <h4>Coach or Unified Partner</h4>
                        <p>Participate alongside athletes to promote inclusion. Share your skills and passion for sports while building meaningful connections.</p>
                    </div>
                    <div class="song26-involvement-card">
                        <h4>Sponsor or Donation</h4>
                        <p>Support the Games financially and be recognized as an official sponsor. Your contribution helps provide equipment, facilities, and opportunities for our athletes.</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Organizing Committee Section (To be branched and put in trees + To be added the photos of commitee-->
        <section class="song26-committee-section">
            <div class="song26-container">
                <h2 class="song26-committee-title">Organising Committee</h2>
                <div class="song26-committee-grid">
                    <div class="song26-committee-card">
                        <div class="song26-committee-photo">
                            <i class="fas fa-user-tie"></i>
                        </div>
                        <div class="song26-committee-role">Chairman</div>
                        <div class="song26-committee-name">Dato Haji Ruslan Bin Abdul Ghani</div>
                        <div class="song26-committee-position">Chairman</div>
                    </div>
                    <div class="song26-committee-card">
                        <div class="song26-committee-photo">
                            <i class="fas fa-user-tie"></i>
                        </div>
                        <div class="song26-committee-role">Vice Chairman</div>
                        <div class="song26-committee-name">TBD</div>
                        <div class="song26-committee-position">Vice Chairman</div>
                    </div>
                    <div class="song26-committee-card">
                        <div class="song26-committee-photo">
                            <i class="fas fa-user-tie"></i>
                        </div>
                        <div class="song26-committee-role">Secretary</div>
                        <div class="song26-committee-name">Sabrina Cheong Oi Lin binti Abdullah</div>
                        <div class="song26-committee-position">Secretary</div>
                    </div>
                    <div class="song26-committee-card">
                        <div class="song26-committee-photo">
                            <i class="fas fa-user-tie"></i>
                        </div>
                        <div class="song26-committee-role">Treasurer</div>
                        <div class="song26-committee-name">TBD</div>
                        <div class="song26-committee-position">Treasurer</div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Sponsors Section -->
        <section class="song26-sponsors-section">
            <div class="song26-container">
                <h2 class="song26-sponsors-title">Our Sponsors</h2>
                <p class="song26-sponsors-subtitle">We extend our gratitude to our valued sponsors who make SONG 2026 possible</p>
                
                <!-- Platinum Sponsors -->
                <div class="song26-sponsor-tier">
                    <h3 class="song26-sponsor-tier-title">Platinum Sponsors</h3>
                    <div class="song26-sponsors-grid">
                        <div class="song26-sponsor-card">
                            <div class="song26-sponsor-placeholder">Sponsor Logo</div>
                        </div>
                        <div class="song26-sponsor-card">
                            <div class="song26-sponsor-placeholder">Sponsor Logo</div>
                        </div>
                        <div class="song26-sponsor-card">
                            <div class="song26-sponsor-placeholder">Sponsor Logo</div>
                        </div>
                    </div>
                </div>

                <!-- Gold Sponsors -->
                <div class="song26-sponsor-tier">
                    <h3 class="song26-sponsor-tier-title">Gold Sponsors</h3>
                    <div class="song26-sponsors-grid">
                        <div class="song26-sponsor-card">
                            <div class="song26-sponsor-placeholder">Sponsor Logo</div>
                        </div>
                        <div class="song26-sponsor-card">
                            <div class="song26-sponsor-placeholder">Sponsor Logo</div>
                        </div>
                        <div class="song26-sponsor-card">
                            <div class="song26-sponsor-placeholder">Sponsor Logo</div>
                        </div>
                        <div class="song26-sponsor-card">
                            <div class="song26-sponsor-placeholder">Sponsor Logo</div>
                        </div>
                    </div>
                </div>

                <!-- Silver Sponsors -->
                <div class="song26-sponsor-tier">
                    <h3 class="song26-sponsor-tier-title">Silver Sponsors</h3>
                    <div class="song26-sponsors-grid">
                        <div class="song26-sponsor-card">
                            <div class="song26-sponsor-placeholder">Sponsor Logo</div>
                        </div>
                        <div class="song26-sponsor-card">
                            <div class="song26-sponsor-placeholder">Sponsor Logo</div>
                        </div>
                        <div class="song26-sponsor-card">
                            <div class="song26-sponsor-placeholder">Sponsor Logo</div>
                        </div>
                        <div class="song26-sponsor-card">
                            <div class="song26-sponsor-placeholder">Sponsor Logo</div>
                        </div>
                        <div class="song26-sponsor-card">
                            <div class="song26-sponsor-placeholder">Sponsor Logo</div>
                        </div>
                        <div class="song26-sponsor-card">
                            <div class="song26-sponsor-placeholder">Sponsor Logo</div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <!-- Section Divider -->
    <div class="section-divider"></div>
    
    <!-- Bottom Navigation -->
    <script src="../scripts/components/bottom-nav.js"></script>

    <!-- Site footer -->
    <script src="../scripts/components/site-footer.js"></script>

    <script src="../scripts/script.js"></script>
</body>
</html>