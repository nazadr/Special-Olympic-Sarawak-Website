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
        :root {
            --primary-color: #cc0000;
            --secondary-color: #333;
            --accent-color: #ff6b35;
            --light-bg: #f9f9f9;
            --white: #ffffff;
            --shadow: 0 4px 20px rgba(0,0,0,0.1);
            --transition: all 0.3s ease;
            --border-radius: 15px;
        }

        .header-space {
            height: 70px;
            background: transparent;
        }

        .body {
            background-color: var(--white);
            overflow-y: auto;
            min-height: 100vh;
            font-family: 'Arial', sans-serif;
            background-image:
                linear-gradient(rgba(204, 0, 0, 0.03) 1px, transparent 1px),
                linear-gradient(90deg, rgba(204, 0, 0, 0.03) 1px, transparent 1px);
            background-size: 50px 50px;
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
            font-weight: bold;
        }

        .song26-hero-logo {
            width: 80px;
            height: 80px;
            filter: drop-shadow(0 2px 4px rgba(0, 0, 0, 0.3));
        }

        /* Main Content Container */
        .song26-main-content {
            max-width: 1200px;
            margin: 0 auto;
            padding: 60px 20px;
            background: var(--white);
            border-radius: 20px 20px 0 0;
            margin-top: -20px;
            position: relative;
            z-index: 1;
            box-shadow: 0 -10px 30px rgba(0,0,0,0.1);
        }

        /* Section Styles */
        .song26-section {
            margin-bottom: 80px;
            padding: 50px;
            background: var(--white);
            border-radius: var(--border-radius);
            box-shadow: var(--shadow);
            transition: var(--transition);
            border: 2px solid rgba(204, 0, 0, 0.1);
            position: relative;
            overflow: hidden;
        }

        .song26-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 5px;
            background: linear-gradient(90deg, var(--primary-color), var(--accent-color));
        }

        .song26-section:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 40px rgba(0,0,0,0.15);
        }

        .song26-section h2 {
            color: var(--primary-color);
            text-align: center;
            margin-bottom: 30px;
            font-weight: 700;
            font-size: 2.5rem;
            text-transform: uppercase;
            letter-spacing: 2px;
        }

        .song26-section h3 {
            color: var(--primary-color);
            text-align: center;
            margin-bottom: 25px;
            font-weight: 600;
            font-size: 1.8rem;
        }

        .song26-section p {
            line-height: 1.8;
            color: var(--secondary-color);
            text-align: center;
            max-width: 900px;
            margin: 0 auto;
            font-size: 1.1rem;
        }

        /* Info Cards */
        .song26-info-cards {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 40px;
            margin-bottom: 80px;
        }

        .song26-info-card {
            background: var(--white);
            border-radius: var(--border-radius);
            box-shadow: var(--shadow);
            padding: 40px 30px;
            text-align: center;
            transition: var(--transition);
            border: 2px solid rgba(204, 0, 0, 0.1);
            position: relative;
        }

        .song26-info-card::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 80%;
            height: 3px;
            background: linear-gradient(90deg, var(--primary-color), var(--accent-color));
            border-radius: 2px;
        }

        .song26-info-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 12px 40px rgba(0,0,0,0.2);
        }

        .song26-info-card i {
            font-size: 3.5rem;
            color: var(--primary-color);
            margin-bottom: 25px;
        }

        .song26-info-card h3 {
            font-size: 1.6rem;
            color: var(--primary-color);
            margin-bottom: 20px;
            font-weight: 600;
        }

        .song26-info-card p {
            font-size: 1.1rem;
            color: var(--secondary-color);
            line-height: 1.6;
        }

        /* Motto Section */
        .song26-motto p {
            font-style: italic;
            font-size: 1.5rem;
            color: var(--primary-color);
            font-weight: 500;
            text-align: center;
            max-width: 700px;
            margin: 0 auto;
            padding: 20px;
            border-left: 5px solid var(--primary-color);
            border-right: 5px solid var(--primary-color);
            background: rgba(204, 0, 0, 0.05);
            border-radius: 10px;
        }

        /* Get Involved */
        .song26-involvement ul {
            list-style: none;
            padding: 0;
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 30px;
            max-width: 1000px;
            margin: 30px auto 0;
        }

        .song26-involvement li {
            background: var(--light-bg);
            padding: 25px;
            border-radius: 10px;
            border-left: 6px solid var(--primary-color);
            font-size: 1.1rem;
            color: var(--secondary-color);
            transition: var(--transition);
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        }

        .song26-involvement li:hover {
            background: var(--white);
            transform: translateX(10px);
            box-shadow: 0 4px 20px rgba(0,0,0,0.1);
        }

        /* Organizing Committee */
        .song26-committee-section {
            text-align: center;
            margin-bottom: 80px;
        }

        .song26-committee-title {
            font-size: 2.2rem;
            color: var(--primary-color);
            margin-bottom: 50px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .song26-committee-hierarchy {
            display: grid;
            grid-template-columns: 1fr;
            gap: 40px;
            max-width: 1000px;
            margin: 0 auto;
        }

        .song26-committee-level {
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 30px;
            background: var(--white);
            border-radius: var(--border-radius);
            box-shadow: var(--shadow);
            border: 2px solid rgba(204, 0, 0, 0.1);
            transition: var(--transition);
            position: relative;
        }

        .song26-committee-level::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, var(--primary-color), var(--accent-color));
        }

        .song26-committee-level:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 30px rgba(0,0,0,0.15);
        }

        .song26-committee-role {
            font-size: 1.4rem;
            color: var(--primary-color);
            font-weight: 600;
            margin-bottom: 20px;
            text-transform: uppercase;
        }

        .song26-committee-member {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 15px;
        }

        .song26-committee-photo {
            width: 120px;
            height: 120px;
            background: linear-gradient(135deg, var(--light-bg) 0%, #e0e0e0 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            border: 3px solid rgba(204, 0, 0, 0.2);
            font-size: 2rem;
            color: var(--primary-color);
            transition: var(--transition);
        }

        .song26-committee-photo:hover {
            border-color: var(--primary-color);
            transform: scale(1.1);
        }

        .song26-committee-name {
            font-size: 1.2rem;
            color: var(--secondary-color);
            font-weight: 500;
            text-align: center;
        }

        .song26-committee-position {
            font-size: 1rem;
            color: #666;
            text-align: center;
            font-style: italic;
        }

        .song26-logo-placeholder {
            width: 180px;
            height: 180px;
            background: linear-gradient(135deg, var(--light-bg) 0%, #e0e0e0 100%);
            border-radius: var(--border-radius);
            display: flex;
            align-items: center;
            justify-content: center;
            border: 3px dashed rgba(204, 0, 0, 0.3);
            color: #999;
            font-size: 16px;
            margin: 0 auto;
            transition: var(--transition);
        }

        .song26-logo-placeholder:hover {
            border-color: var(--primary-color);
            transform: scale(1.05);
        }

        .song26-logo-placeholder img {
            max-width: 100%;
            max-height: 100%;
            border-radius: 10px;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .body {
                background-size: 25px 25px;
            }

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

            .song26-main-content {
                padding: 40px 15px;
                margin-top: -10px;
            }

            .song26-section {
                padding: 30px 20px;
                margin-bottom: 40px;
            }

            .song26-section h2 {
                font-size: 2rem;
            }

            .song26-section h3 {
                font-size: 1.5rem;
            }

            .song26-info-cards {
                grid-template-columns: 1fr;
                gap: 30px;
            }

            .song26-info-card {
                padding: 30px 20px;
            }

            .song26-involvement ul {
                grid-template-columns: 1fr;
            }

            .song26-committee-card, .song26-logo-card {
                padding: 30px 20px;
            }

            .song26-committee-title {
                font-size: 1.8rem;
            }

            .song26-committee-hierarchy {
                gap: 20px;
            }

            .song26-committee-level {
                padding: 20px;
            }

            .song26-committee-role {
                font-size: 1.2rem;
            }

            .song26-committee-photo {
                width: 100px;
                height: 100px;
                font-size: 1.5rem;
            }

            .song26-logo-placeholder {
                width: 150px;
                height: 150px;
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
        <h1>Special Olympics Sarawak — 6th State Games</h1>
    </section>

    <!-- Main Content -->
    <div class="song26-main-content">
        <section class="song26-section song26-about-overview">
            <h2>About the 6th State Games</h2>
            <p>The Special Olympics Sarawak 6th State Games is a celebration of athletic achievement, inclusion and community for athletes with intellectual disabilities across Sarawak. The Games provide competition, skill development and social opportunities, bringing together athletes, families, coaches and volunteers.</p>
        </section>

        <div class="song26-info-cards">
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

        <section class="song26-section song26-design">
            <h3>Purpose & Impact</h3>
            <p>The Games focus on inclusion, skill development and community empowerment. They create opportunities for athletes to compete in a safe, supportive environment while fostering volunteerism, local engagement and lasting improvements to sports access across the state.</p>
        </section>

        <section class="song26-section song26-motto">
            <h3>Motto</h3>
            <p>"Let me win. But if I cannot win, let me be brave in the attempt."</p>
        </section>

        <section class="song26-section song26-values">
            <h3>Values & Legacy</h3>
            <p>The event champions respect, courage and teamwork. Its legacy includes improved community programmes, trained volunteers, upgraded local facilities and greater public awareness about the abilities of people with intellectual disabilities.</p>
        </section>

        <section class="song26-section song26-participation">
            <h3>Participation</h3>
            <p>Competitions include athletics, aquatics, bocce, badminton, bowling, table tennis, basketball and unified sports. Events are organised to provide classification-appropriate competition and promote athlete development.</p>
        </section>

        <section class="song26-section song26-involvement">
            <h3>Get Involved</h3>
            <ul>
                <li>Volunteer: support athletes, logistics and community programmes.</li>
                <li>Coach or Unified Partner: participate alongside athletes to promote inclusion.</li>
                <li>Sponsor or Donate: support athlete services, equipment and legacy projects.</li>
            </ul>
        </section>

        <div class="song26-committee-section">
            <h2 class="song26-committee-title">Organising Committee</h2>
            <div class="song26-committee-hierarchy">
                <div class="song26-committee-level">
                    <div class="song26-committee-role">Chairman</div>
                    <div class="song26-committee-member">
                        <div class="song26-committee-photo">
                            <i class="fas fa-user-tie"></i>
                        </div>
                        <div class="song26-committee-name">Dato Haji Ruslan Bin Abdul Ghani</div>
                        <div class="song26-committee-position">Chairman</div>
                    </div>
                </div>
                <div class="song26-committee-level">
                    <div class="song26-committee-role">Vice Chairman</div>
                    <div class="song26-committee-member">
                        <div class="song26-committee-photo">
                            <i class="fas fa-user-tie"></i>
                        </div>
                        <div class="song26-committee-name">TBD</div>
                        <div class="song26-committee-position">Vice Chairman</div>
                    </div>
                </div>
                <div class="song26-committee-level">
                    <div class="song26-committee-role">Secretary</div>
                    <div class="song26-committee-member">
                        <div class="song26-committee-photo">
                            <i class="fas fa-user-tie"></i>
                        </div>
                        <div class="song26-committee-name">Sabrina Cheong Oi Lin binti Abdullah</div>
                        <div class="song26-committee-position">Secretary</div>
                    </div>
                </div>
                <div class="song26-committee-level">
                    <div class="song26-committee-role">Treasurer</div>
                    <div class="song26-committee-member">
                        <div class="song26-committee-photo">
                            <i class="fas fa-user-tie"></i>
                        </div>
                        <div class="song26-committee-name">TBD</div>
                        <div class="song26-committee-position">Treasurer</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="song26-logo-section">
            <div class="song26-logo-card">
                <h3>Visual Identity</h3>
                <div class="song26-logo-placeholder">
                    <img src="../assets/icons/bintulu-stork.png" alt="Special Olympics Sarawak logo">
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