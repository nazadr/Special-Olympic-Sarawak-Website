<?php
// Placeholder for future database integration
$song26Data = [];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Special Olympics Sarawak — 6th State Games | SONG 26</title>
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

            .song26-info-card {
                width: 90%;
                margin: 0 auto 20px;
            }

            .song26-games-grid {
                gap: 20px;
            }

            .song26-game-item {
                width: 100px;
            }
        }

        /* New styles for improved interface */
        .song26-intro {
            text-align: center;
            margin-bottom: 50px;
            font-size: 1.1rem;
            line-height: 1.6;
            color: #333;
        }

        .song26-info-cards {
            display: flex;
            justify-content: center;
            gap: 30px;
            margin-bottom: 50px;
        }

        .song26-info-card {
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 4px 16px rgba(0,0,0,0.08);
            padding: 30px;
            width: 300px;
            text-align: center;
            transition: transform 0.3s;
        }

        .song26-info-card:hover {
            transform: translateY(-4px);
        }

        .song26-info-card i {
            font-size: 2rem;
            color: #cc0000;
            margin-bottom: 15px;
        }

        .song26-info-card h3 {
            font-size: 1.4rem;
            color: #cc0000;
            margin-bottom: 10px;
        }

        .song26-info-card p {
            font-size: 1.2rem;
            color: #333;
        }

        .song26-games-section {
            margin-bottom: 50px;
        }

        .song26-games-title {
            text-align: center;
            font-size: 1.8rem;
            color: #cc0000;
            margin-bottom: 30px;
            position: relative;
        }

        .song26-games-grid {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 30px;
        }

        .song26-game-item {
            display: flex;
            flex-direction: column;
            align-items: center;
            width: 110px;
            padding: 15px;
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.05);
            transition: transform 0.3s, box-shadow 0.3s;
        }

        .song26-game-item:hover {
            transform: translateY(-4px);
            box-shadow: 0 4px 16px rgba(0,0,0,0.1);
        }

        .song26-game-item img {
            width: 60px;
            height: 60px;
            margin-bottom: 8px;
        }

        .song26-game-item span {
            font-size: 1rem;
            color: #333;
            text-align: center;
        }

        .song26-committee-section,
        .song26-logo-section {
            text-align: center;
            margin-bottom: 50px;
        }

        .song26-committee-card,
        .song26-logo-card {
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 4px 16px rgba(0,0,0,0.08);
            padding: 30px;
            display: inline-block;
            transition: transform 0.3s;
        }

        .song26-committee-card:hover,
        .song26-logo-card:hover {
            transform: translateY(-4px);
        }

        .song26-committee-card h3,
        .song26-logo-card h3 {
            font-size: 1.4rem;
            color: #cc0000;
            margin-bottom: 15px;
        }

        .song26-committee-card p {
            font-size: 1.1rem;
            color: #666;
        }

        .song26-logo-placeholder {
            width: 120px;
            height: 120px;
            background: linear-gradient(135deg, #f0f0f0 0%, #e0e0e0 100%);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            border: 2px dashed #ccc;
            color: #999;
            font-size: 16px;
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
        <h1>Special Olympics Sarawak — 6th State Games</h1>
    </section>

    <!-- Main Content -->
    <div class="song26-desc-section" style="max-width:1200px; margin:0 auto;">
        <section class="song26-about-overview">
            <h2 style="text-align:center; color:#cc0000; margin-bottom:12px;">About the 6th State Games</h2>
            <p class="song26-intro" style="max-width:1000px; margin:0 auto 24px;">
                The Special Olympics Sarawak 6th State Games is a celebration of athletic achievement, inclusion and community for athletes with intellectual disabilities across Sarawak. The Games provide competition, skill development and social opportunities, bringing together athletes, families, coaches and volunteers.
            </p>
        </section>

        <div class="song26-info-cards" style="flex-wrap:wrap; gap:18px; justify-content:center;">
            <div class="song26-info-card">
                <i class="fas fa-map-marker-alt"></i>
                <h3>Venue</h3>
                <p>Bintulu, Sarawak</p>
            </div>
            <div class="song26-info-card">
                <i class="fas fa-calendar-alt"></i>
                <h3>Date</h3>
                <p>24 - 26 April 2026</p>
            </div>
            <div class="song26-info-card">
                <i class="fas fa-users"></i>
                <h3>Participants</h3>
                <p>Athletes, unified partners, coaches and delegations from all across Malaysia.</p>
            </div>
        </div>

        <section class="song26-design" style="margin-top:40px;">
            <h3 style="text-align:center; color:#cc0000;">Purpose & Impact</h3>
            <p style="max-width:980px; margin:16px auto 0; color:#444; line-height:1.6;">
                The Games focus on inclusion, skill development and community empowerment. They create opportunities for athletes to compete in a safe, supportive environment while fostering volunteerism, local engagement and lasting improvements to sports access across the state.
            </p>
        </section>

        <section class="song26-motto" style="margin-top:32px;">
            <h3 style="text-align:center; color:#cc0000;">Motto</h3>
            <p style="max-width:700px; margin:12px auto 0; color:#444;">"Inclusion Through Sport" — promoting dignity, ability and opportunity for all athletes.</p>
        </section>

        <section class="song26-values" style="margin-top:40px;">
            <h3 style="text-align:center; color:#cc0000;">Values & Legacy</h3>
            <p style="max-width:980px; margin:16px auto 0; color:#444; line-height:1.6;">
                The event champions respect, courage and teamwork. Its legacy includes improved community programmes, trained volunteers, upgraded local facilities and greater public awareness about the abilities of people with intellectual disabilities.
            </p>
        </section>

        <section class="song26-participation" style="margin-top:40px;">
            <h3 style="text-align:center; color:#cc0000;">Participation</h3>
            <p style="max-width:980px; margin:16px auto 0; color:#444; line-height:1.6;">Competitions include athletics, aquatics, bocce, badminton, bowling, table tennis, basketball and unified sports. Events are organised to provide classification-appropriate competition and promote athlete development.</p>
        </section>

        <section class="song26-involvement" style="margin-top:40px; margin-bottom:20px;">
            <h3 style="text-align:center; color:#cc0000;">Get Involved</h3>
            <ul style="max-width:860px; margin:12px auto 0; color:#444; line-height:1.6;">
                <li>Volunteer: support athletes, logistics and community programmes.</li>
                <li>Coach or Unified Partner: participate alongside athletes to promote inclusion.</li>
                <li>Sponsor or Donate: support athlete services, equipment and legacy projects.</li>
            </ul>
        </section>

        <div class="song26-committee-section">
            <div class="song26-committee-card">
                <h3>Organising Committee</h3>
                <p>Special Olympics Sarawak, in partnership with local authorities and community stakeholders, coordinates venues, athlete services and volunteer programmes. Official committee details will be published as they are finalised.</p>
            </div>
        </div>

        <div class="song26-logo-section">
            <div class="song26-logo-card">
                <h3>Visual Identity</h3>
                <div class="song26-logo-placeholder" style="display:inline-flex; padding:10px;">
                    <img src="../assets/icons/bintulu-stork.png" alt="Special Olympics Sarawak logo" style="max-width:160px; max-height:120px;">
                </div>
            </div>
        </div>
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