<?php
// Database configuration
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "so_sarawak_db";

try {
    $pdo = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Fetch state games events
    $stmt = $pdo->prepare("SELECT * FROM state_games ORDER BY display_order ASC, created_at DESC");
    $stmt->execute();
    $stateGamesEvents = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
} catch(PDOException $e) {
    // Fallback data in case database is not available
    $stateGamesEvents = [
        [
            'id' => 1,
            'event_title' => '8th State Games Kuching 2025',
            'event_date' => 'TBA 2025',
            'event_description' => 'The 8th edition of the State Games will be held in Kuching, Sarawak in 2025. This event will feature a variety of sports and activities, bringing together athletes from across the state to compete and celebrate their achievements.',
            'learn_more_link' => '#',
            'image_path' => 'https://www.theborneopost.com/newsimages/2025/05/kch-030525-dd-fatimah-702x336.jpg',
        ],
        [
            'id' => 2,
            'event_title' => 'National Games 2027',
            'event_date' => 'TBA 2027',
            'event_description' => 'An event that brings together athletes from across Malaysia to compete in a variety of sports.',
            'learn_more_link' => '#',
            'image_path' => 'https://www.theborneopost.com/newsimages/2025/09/kch-260925-mtu-bg_ath_roundup-p1-B.jpg',
        ],
        [
            'id' => 3,
            'event_title' => 'SEA Games 2027',
            'event_date' => 'TBA 2027',
            'event_description' => 'This event card is just a placeholder for mockup.',
            'learn_more_link' => '#',
            'image_path' => 'https://media.freemalaysiatoday.com/wp-content/uploads/2022/05/Sea-Gaes-2017-Malaysia-Bernama.jpg',
        ]
    ];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>State Games | Special Olympics Sarawak</title>
    <link rel="shortcut icon" href="../assets/images/master_logo_front.png">
    <link rel="stylesheet" href="../css/global-style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <style>
        /* Local HTML Styles */
        .header-space {
            height: 70px;
            background: transparent;
        }
        
        .footer-space {
            height: 100px;
            background: transparent;
        }

        .body {
            background-color: #f9f9f9;
            overflow-y: auto;
            min-height: 100vh;
        }

        /* Assume this sport-hero */
        .sg-hero {
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

        .sg-hero h1 {
            font-size: 3.5rem;
            margin-bottom: 20px;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);
        }
        .sg-hero p {
            font-size: 1.2rem;
            max-width: 800px;
            margin: 0 auto 30px;
        }

        /* Assume this About Section */
        .sg-desc-section {
            background-color: #f1f1f1;
            padding: 60px 20px;
            text-align: center;
        }
        .sg-desc-section p {
            font-size: 1.2rem;
            line-height: 1.6;
            color: #333;
            max-width: 800px;
            margin: 0 auto 40px;
        }

        /* Assume this Sports Container */
        .sg-events-container {
            padding: 60px 20px;
            background-color: white;
        }
        .sg-events-container h2 {
            text-align: center;
            color: #e63946;
            font-size: 2.5rem;
            margin-bottom: 40px;
        }
        .sg-events-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(380px, 1fr)); /* 250px for 4 rows, 380 for 3 rows*/
            gap: 30px;
            max-width: 1200px;
            margin: 0 auto;
            align-items: stretch; /* Ensure all cards have the same height */
        }
        .sg-events-card {
            display: flex;
            flex-direction: column;
            background: white;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
            cursor: pointer;
            height: 100%; /* ensure full height for flex to work */
        }
        .sg-events-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 8px 16px rgba(230, 57, 70, 0.2);
        }
        .sg-card-image {
            height: 180px;
            overflow: hidden;
        }
        .sg-card-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.3s ease;
        }
        .sg-events-card:hover .sg-card-image img {
            transform: scale(1.05);
        }
        .sg-card-content {
            padding: 20px;
            text-align: center;
            flex-grow: 1; /* take all available vertical space */
            display: flex;
            flex-direction: column;
        }
        .sg-card-content h3 {
            color: #e63946;
            margin-bottom: 10px;
            font-size: 1.4rem;
        }
        .sg-card-content p {
            color: #6b7280;
            font-size: 1rem;
        }
        .sg-card-button {
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            width: 140px;
            height: 40px;
            background-color: #c41926;
            border: none;
            margin: 0 auto 40px auto; /* center horizontally, 20px bottom margin */
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        .sg-card-button a {
            text-decoration: none;
            color: white;
            font-size: 1rem;
            font-weight: 600;
        }
        .sg-card-button:hover {
            background-color: #e94e1b;
        }

        /* Eligibility and Guidelines */
        .sg-eligibility-section {
            background-color: #f1f1f1;
            padding: 60px 20px;
            margin-bottom: 80px;
            text-align: left;
        }
        .sg-eligibility-section h2 {
            color: #e63946;
            font-size: 2.5rem;
            text-align: center;
            margin-bottom: 40px;
        }
        .sg-eligibility-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(380px, 1fr));
            gap: 30px;
            max-width: 1200px;
            margin: 0 auto;
        }
        .border-bottom {
            border-bottom: 5px solid #e63946;
        }
        .sg-eligibility-card {
            background: white;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
            cursor: pointer;
        }
        .sg-eligibility-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 8px 16px rgba(230, 57, 70, 0.2);
        }
        .sg-eligibility-content {
            padding: 20px 28px;
            text-align: left;
        }
        .sg-eligibility-content h3 {
            color: black;
            font-size: 1.4rem;
            font-weight: 600;
        }
        .sg-eligibility-content p {
            color: black;
            font-size: 1rem;
            line-height: 1.6;
        }

        @media (max-width: 1250px) {
            .sg-events-grid {
                grid-template-columns: repeat(auto-fill, minmax(250px, 3fr));
                max-width: 900px;
            }
        }

        @media (max-width: 950px) {
            .sg-events-grid {
                grid-template-columns: repeat(auto-fill, minmax(250px, 2fr));
                max-width: 600px;
            }
        }

        @media (max-width: 768px) {
            .sg-hero h1 {
                font-size: 2.5rem;
            }
            
            .sg-hero p {
                font-size: 1rem;
            }
        }

        @media (max-width: 650px) {
            .sg-hero h1 {
                font-size: 2rem;
            }
            
            .sg-events-grid {
                grid-template-columns: 1fr;
            }
            .sg-card-image {
                height: 220px;
            }
        }
    </style>
</head>
<body>
    <!-- Navigation Bar (Loaded via JS) -->
    <script src="../scripts/components/header.js"></script>

    <!-- Social Media Bar (Loaded via JS) -->
    <script src="../scripts/components/socmed-bar.js"></script>

    <!-- Chatbot (Loaded via JS) -->
    <!-- <div id="chatbot-container"></div> -->

    <!-- Space for existing header -->
    <div class="header-space"></div>

    <section class="sg-hero">
        <h1>State Games</h1>
        <!-- <p>Advancing to a Special Olympics state-level event is an accomplishment to be celebrated.</p> -->
    </section>

    <section class="sg-desc-section">
        <p>State Games are a significant milestone in the journey of Special Olympics athletes. These events bring together athletes from various local programs to compete at a higher level, showcasing their skills, determination, and sportsmanship. State Games serve as a platform for athletes to demonstrate their progress, build confidence, and foster camaraderie among peers.</p>
        <p>Participation in State Games is not only about competition but also about celebrating the achievements of individuals with intellectual disabilities. These events provide an opportunity for athletes to experience the thrill of competition, set new personal goals, and inspire others through their dedication and perseverance.</p>
    </section>

    <section class="sg-events-container">
        <h2>Special Olympics Major Events</h2> <!-- Previously: State Level Events -->
        <div class="sg-events-grid">
            <?php if (empty($stateGamesEvents)): ?>
                <div style="grid-column: 1 / -1; text-align: center; padding: 40px; color: #666;">
                    <p>No events are currently scheduled. Please check back later for updates.</p>
                </div>
            <?php else: ?>
                <?php foreach ($stateGamesEvents as $event): ?>
                    <div class="sg-events-card">
                        <div class="sg-card-image">
                            <?php 
                            $imageSrc = !empty($event['image_path']) ? htmlspecialchars($event['image_path']) : '../assets/images/placeholder-event.jpg';
                            $altText = htmlspecialchars($event['event_title']);
                            ?>
                            <img src="<?php echo $imageSrc; ?>" alt="<?php echo $altText; ?>" onerror="this.src='../assets/images/placeholder-event.jpg'">
                        </div>
                        <div class="sg-card-content">
                            <h3><?php echo htmlspecialchars($event['event_title']); ?></h3>
                            <p style="font-size: 1.2rem;"><strong><?php echo htmlspecialchars($event['event_date']); ?></strong></p>
                            <p><?php echo htmlspecialchars($event['event_description']); ?></p>
                        </div>
                        <?php if (!empty($event['learn_more_link']) && $event['learn_more_link'] !== '#'): ?>
                            <div class="sg-card-button">
                                <a href="<?php echo htmlspecialchars($event['learn_more_link']); ?>" target="_blank" rel="noopener noreferrer">Learn More</a>
                            </div>
                        <?php else: ?>
                            <div class="sg-card-button">
                                <a href="#">Learn More</a>
                            </div>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </section>

    <section class="sg-eligibility-section">
        <h2>Eligibility and Guidelines</h2>
        <div class="sg-eligibility-grid">
            <div class="sg-eligibility-card border-bottom">
                <div class="sg-eligibility-content">
                    <h3>Athlete Eligibility</h3>
                    <p>To be eligible to compete in State Games, athletes must be registered with Special Olympics and meet the age and skill requirements for their chosen sport. Athletes typically qualify for State Games through their performance in local competitions and must demonstrate a commitment to training and sportsmanship.</p>
                </div>
            </div>
            <div class="sg-eligibility-card border-bottom">
                <div class="sg-eligibility-content">
                    <h3>Competition Guidelines</h3>
                    <p>State Games competitions are conducted according to the rules and regulations set forth by Special Olympics. Athletes are expected to adhere to the principles of fair play, respect for opponents, and sportsmanship. Coaches and volunteers play a crucial role in ensuring a positive experience for all participants.</p>
                </div>
            </div>
            <div class="sg-eligibility-card border-bottom">
                <div class="sg-eligibility-content">
                    <p style="color: #FF0000; font-size: 0.9rem; font-weight: 600; margin: 0 0 4px 0;">GET INVOLVED</p>
                    <h3 style="margin-top: 0;">Volunteer Opportunities</h3>
                    <p>State Games rely on the support of dedicated volunteers to help with various aspects of the event, including athlete support, event logistics, and hospitality. Volunteers play a vital role in creating a positive and inclusive environment for athletes and are encouraged to participate in this rewarding experience. Training and orientation sessions will be provided for all volunteers prior to the event.</p>
                </div>
            </div>
        </div>
        <!-- <p style="text-align: center; margin-top: 40px;">*This area of content is a placeholder and is subject to change.</p> -->
    </section>

    <!-- Bottom Navigation -->
    <script src="../scripts/components/bottom-nav.js"></script>

    <!-- Site footer -->
    <script src="../scripts/components/site-footer.js"></script>

    <script src="../scripts/script.js"></script>
    <script src="../scripts/song-bubble.js"></script>
</body>
</html>