<?php
// Database connection
$host = 'localhost';
$dbname = 'so_sarawak_db';
$username = 'root'; 
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Fetch sports from database, ordered by display_order
    $stmt = $pdo->prepare("SELECT * FROM sports ORDER BY display_order ASC, id ASC");
    $stmt->execute();
    $sports = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
} catch(PDOException $e) {
    // Fallback data if database connection fails
    $sports = [
        ['id' => 1, 'title' => 'Athletics', 'description' => 'Track and field events including sprints, relays, jumps and throws', 'image_path' => 'https://akm-img-a-in.tosshub.com/sites/media2/indiatoday/images/stories/2015July/special-olympic-5_072515021147.jpg'],
        ['id' => 2, 'title' => 'Aquatics', 'description' => 'Individual and team aquatic sport with various strokes and distances', 'image_path' => '../assets/images/Aquatics_sport.jpg'],
        ['id' => 3, 'title' => 'Badminton', 'description' => 'Fast-paced racquet sport played individually or in doubles', 'image_path' => 'https://www.businesstoday.com.my/wp-content/uploads/2025/05/badminton.png'],
        ['id' => 4, 'title' => 'Basketball', 'description' => 'Team sport with dribbling, passing and shooting skills', 'image_path' => 'https://dotorg.brightspotcdn.com/dims4/default/ee9e8a5/2147483647/strip/true/crop/800x450+0+42/resize/800x450!/quality/90/?url=http%3A%2F%2Fsoi-brightspot.s3.amazonaws.com%2Fdotorg%2F79%2F2c%2Fdff376344b05bacc6cc4a6108434%2Fandrew-marquise.JPG']
    ];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sports | Special Olympics Sarawak</title>
    <link rel="shortcut icon" href="../assets/images/master_logo_front.png">
    <link rel="stylesheet" href="../css/global-style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <style>
        /* Space for existing header */
        .header-space {
            height: 70px;
            background: transparent;
        }

        /* Space for existing footer */
        .footer-space {
            height: 100px;
            background: transparent;
        }

        body {
            background-color: #f9f9f9;
            overflow-y: auto;
            min-height: 100vh;
            /* Ensure scrolling is possible */
        }

        .sport-hero {
            background: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)), url('../assets/images/sport_1.jpg') center/cover no-repeat;
            height: 60vh;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
            color: white;
            position: relative;
        }

        .sport-hero img {
            width: 150px;
            margin-bottom: 20px;
        }

        .sport-hero h1 {
            font-size: 3.5rem;
            margin-bottom: 20px;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);
        }

        .sport-hero p {
            font-size: 1.2rem;
            max-width: 800px;
            margin: 0 auto 30px;
        }

        .about-section {
            background-color: white;
            padding: 60px 20px;
            text-align: center;
        }

        .about-section h2 {
            color: #e63946;
            font-size: 2.2rem;
            margin-bottom: 30px;
        }

        .about-section p {
            font-size: 1.1rem;
            line-height: 1.6;
            color: #333;
            max-width: 800px;
            margin: 0 auto 40px;
        }

        .sports-container {
            padding: 60px 20px;
            background-color: #f1f1f1;
            margin: 0 0 80px 0;
        }

        .sports-container h2 {
            width: 1200px;
            text-align: center;
            color: #e63946;
            font-size: 2.5rem;
            margin-bottom: 40px;
        }

        .sports-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            gap: 30px;
            max-width: 1200px;
            margin: 0 auto;
        }

        .sport-card {
            background: white;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
            cursor: pointer;
        }

        .sport-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 8px 16px rgba(230, 57, 70, 0.2);
        }

        .card-image {
            height: 180px;
            overflow: hidden;
        }

        .card-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.3s ease;
        }

        .sport-card:hover .card-image img {
            transform: scale(1.05);
        }

        .card-content {
            padding: 20px;
            text-align: center;
        }

        .card-content h3 {
            color: #e63946;
            margin-bottom: 10px;
            font-size: 1.4rem;
        }

        .card-content p {
            color: #666;
            font-size: 0.9rem;
        }

        /* Responsive adjustments */
        @media (max-width: 1250px) {
            .sports-grid {
                grid-template-columns: repeat(auto-fill, minmax(250px, 3fr));
                max-width: 900px;
            }
        }

        @media (max-width: 950px) {
            .sports-grid {
                grid-template-columns: repeat(auto-fill, minmax(250px, 2fr));
                max-width: 600px;
            }
        }

        @media (max-width: 768px) {
            .sport-hero h1 {
                font-size: 2.5rem;
            }
            
            .sport-hero p {
                font-size: 1rem;
            }
        }

        @media (max-width: 650px) {
            .sport-hero h1 {
                font-size: 2rem;
            }
            
            .sports-grid {
                grid-template-columns: 1fr;
            }
        }

        .no-sports-message {
            text-align: center;
            padding: 40px 20px;
            color: #666;
            font-style: italic;
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

    <section class="sport-hero">
        <img src="../assets/images/master_logo_front.png" alt="Special Olympics Logo - torch with flame inside circular logo with red and white colors" />
        <h1>Special Olympics Sarawak Sports</h1>
        <p>The most inclusive sports organization in the world, transforming lives through the power of sports</p>
    </section>

    <section class="about-section">
        <h2>About Sport</h2>
        <p>Special Olympics is a global movement that unleashes the human spirit through the transformative power and joy of sports every day around the world. Through programming in sports, health, education, and community building, Special Olympics is changing the lives of people with intellectual disabilities.</p>
        <p>Athletes train year-round in Olympic-type sports to compete in local and international events, building confidence, improving physical fitness, and creating lifelong friendships.</p>
    </section>

    <section class="sports-container">
        <h2>Our Sports</h2>
        <div class="sports-grid">
            <?php if (empty($sports)): ?>
                <div class="no-sports-message">
                    <p>No sports are currently available. Please check back later.</p>
                </div>
            <?php else: ?>
                <?php foreach ($sports as $sport): ?>
                    <div class="sport-card">
                        <div class="card-image">
                            <img src="<?php echo htmlspecialchars($sport['image_path']); ?>" 
                                 alt="<?php echo htmlspecialchars($sport['title']); ?> - Special Olympics sport" />
                        </div>
                        <div class="card-content">
                            <h3><?php echo htmlspecialchars($sport['title']); ?></h3>
                            <p><?php echo htmlspecialchars($sport['description']); ?></p>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </section>

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