<?php
// Placeholder for future database integration
$song26Data = [];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SONG 26 | Special Olympics Malaysia National Games 2026 | Special Olympics Sarawak</title>
    <link rel="shortcut icon" href="../assets/images/master_logo_front.png">
    <link rel="stylesheet" href="../css/global-style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <style>
        /* Local style within this HTML */
        .header-space {
            height: 70px;
            background: transparent;
        }

        .body {
            background-color: white;
            overflow-y: auto;
            min-height: 100vh;
        }

        /* Hero Section */
        .song26-hero {
            background: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)), url('../assets/images/state-games-hero.jpg') center/cover no-repeat;
            height: 60vh;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
            color: white;
            position: relative;
        }

        .song26-hero h1 {
            font-size: 3.5rem;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 30px;
        }

        .song26-hero-logo {
            width: 80px;
            height: 80px;
            filter: drop-shadow(0 2px 4px rgba(0, 0, 0, 0.3));
        }

        .song26-desc-section {
            background-color: white;
            padding: 60px 20px 0 20px;
            text-align: left;
        }

        .song26-desc-section p {
            font-size: 1.1rem;
            line-height: 1.6;
            color: #333;
            max-width: 1200px;
            margin: 0 auto 40px;
        }

        .song26-desc-section ul {
            max-width: 1160px;
            margin: 0 auto 40px;
            font-size: 1.1rem;
            color: #333;
        }

        .song26-desc-section li {
            margin-bottom: 12px;
        }

        /* Placeholder Image Section */
        .song26-image-placeholder {
            max-width: 1200px;
            margin: 0 auto 60px;
            padding: 0 20px;
        }

        .placeholder-img {
            width: 100%;
            height: 400px;
            background: linear-gradient(135deg, #f0f0f0 0%, #e0e0e0 100%);
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #999;
            font-size: 16px;
            border: 2px dashed #ccc;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .song26-hero {
                height: 40vh;
            }

            .song26-hero h1 {
                font-size: 1.8rem;
                flex-direction: column;
                gap: 15px;
            }

            .song26-hero-logo {
                width: 60px;
                height: 60px;
            }

            .song26-desc-section {
                padding: 40px 15px 0 15px;
            }

            .song26-desc-section p,
            .song26-desc-section ul {
                font-size: 1rem;
            }
        }
    </style>
</head>
<body class="body">
    <!-- Navigation Bar (Loaded via JS) -->
    <script src="../scripts/components/header.js"></script>

    <!-- Social Media Bar (Loaded via JS) -->
    <script src="../scripts/components/socmed-bar.js"></script>

    <!-- Chatbot (Loaded via JS) -->
    <!-- <div id="chatbot-container"></div> -->

    <!-- Header Space for Navigation Bar -->
    <div class="header-space"></div>

    <!-- Hero Section -->
    <section class="song26-hero">
        <img src="../assets/icons/bintulu-stork.png" alt="SONG 26 Logo" class="song26-hero-logo">
        <h1>Special Olympics Malaysia National Games 2026</h1>
    </section>

    <!-- Main Content -->
    <div class="song26-desc-section">
        <p>
            The Special Olympics Malaysia National Games 2026 (SONG 26) is a premier international sporting event that celebrates the achievements of athletes with intellectual disabilities from across Malaysia and the Southeast Asian region. This prestigious games showcase the determination, spirit, and athletic excellence of our Special Olympics community.
        </p>

        <p>
            SONG 26 brings together athletes, coaches, volunteers, and families for an unforgettable celebration of sport, inclusion, and community. The games feature multiple sport disciplines and demonstrate the transformative power of athletics for individuals with intellectual disabilities.
        </p>

        <p>
            Key aspects of SONG 26 include:
        </p>

        <ul>
            <li><strong>Athletic Competition:</strong> Athletes compete in various sport disciplines at the national level, showcasing their skills and training.</li>
            <li><strong>Inclusion & Community:</strong> The games bring together diverse communities to celebrate athletes and promote inclusion.</li>
            <li><strong>Personal Growth:</strong> Participants experience personal development, confidence building, and lasting friendships.</li>
            <li><strong>Volunteer Engagement:</strong> Thousands of volunteers contribute to the success of the games.</li>
            <li><strong>Leadership Opportunities:</strong> Athletes develop leadership skills and represent their organizations with pride.</li>
            <li><strong>Regional Participation:</strong> The games attract participants from across Malaysia and Southeast Asia.</li>
        </ul>

        <!-- Placeholder Image -->
        <div class="song26-image-placeholder">
            <div class="placeholder-img">
                <i class="fas fa-image" style="margin-right: 10px;"></i> Event Image Placeholder
            </div>
        </div>

        <p>
            Special Olympics Sarawak is committed to providing exceptional opportunities for athletes to compete, grow, and achieve their dreams. We invite you to be part of this historic celebration of athletic excellence and inclusion.
        </p>

        <p>
            For more information about SONG 26, registration details, and event updates, please check back soon as we prepare for this momentous occasion.
        </p>
    </div>

    <!-- Section Divider -->
    <div class="section-divider"></div>
    
    <!-- Bottom Navigation -->
    <script src="../scripts/components/bottom-nav.js"></script>

    <!-- Site footer -->
    <script src="../scripts/components/site-footer.js"></script>

    <script src="../scripts/script.js"></script>
    <script src="../scripts/song-bubble.js"></script>
</body>
</html>