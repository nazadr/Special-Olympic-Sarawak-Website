<?php
// Database connection
$host = 'localhost';
$dbname = 'so_sarawak_db';
$username = 'root'; 
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Fetch sports from database, ordered by display_order, limit to 7 for getting started page
    $stmt = $pdo->prepare("SELECT * FROM sports ORDER BY display_order ASC, id ASC LIMIT 7");
    $stmt->execute();
    $sports = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
} catch(PDOException $e) {
    // Fallback data if database connection fails
    $sports = [
        ['id' => 1, 'title' => 'Athletics', 'description' => 'Track and field events', 'image_path' => '../assets/images/athletics.jpg'],
        ['id' => 2, 'title' => 'Aquatics', 'description' => 'Swimming competitions', 'image_path' => '../assets/images/aquatics.jpg'],
        ['id' => 3, 'title' => 'Ten-Pin Bowling', 'description' => 'Bowling competitions', 'image_path' => '../assets/images/bowling.jpg'],
        ['id' => 4, 'title' => 'Bocce', 'description' => 'Precision ball sport', 'image_path' => '../assets/images/bocce.jpg'],
        ['id' => 5, 'title' => 'Floor Hockey', 'description' => 'Indoor hockey sport', 'image_path' => '../assets/images/hockey.jpg'],
        ['id' => 6, 'title' => 'Football', 'description' => 'Team ball sport', 'image_path' => '../assets/images/football.jpg'],
        ['id' => 7, 'title' => 'Badminton', 'description' => 'Racquet sport', 'image_path' => '../assets/images/badminton.jpg']
    ];
}

// Map sport titles to emoji icons for fallback display
$sportIcons = [
    'Athletics' => '🏃',
    'Aquatics' => '🏊',
    'Ten-Pin Bowling' => '🎳',
    'Bowling' => '🎳',
    'Bocce' => '🥏',
    'Floor Hockey' => '🏒',
    'Hockey' => '🏒',
    'Football' => '⚽',
    'Soccer' => '⚽',
    'Badminton' => '🏸',
    'Basketball' => '🏀',
    'Tennis' => '🎾',
    'Table Tennis' => '🏓',
    'Volleyball' => '🏐'
];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Getting Started | Special Olympics Sarawak</title>
    <link rel="shortcut icon" href="../assets/images/master_logo_front.png">
    <link rel="stylesheet" href="../css/global-style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <!-- Local HTML Style -->
    <style>
        /* Reset and base styles */     
        body {
            background-color: #f9f9f9;
            color: #333;
            line-height: 1.6;
            overflow-x: hidden;
            overflow-y: auto;
        }

        /* Program card hover effects */
        a.program-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 12px 30px rgba(0, 0, 0, 0.15) !important;
            cursor: pointer;
        }

        a.program-card {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        a.program-card:active {
            transform: translateY(-4px);
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
    
    <!-- Hero section with animated background -->
    <section class="hero">
        <img src="../assets/images/sarawak_group_photo.jpeg" alt="Group of Special Olympics athletes celebrating together with raised arms in a stadium" class="hero-background">
        <div class="hero-content">
            <h1 class="hero-title">Special Olympics Sarawak</h1>
            <p class="hero-subtitle">Empowering athletes with intellectual disabilities through sports</p>
        </div>
    </section>
    
    <!-- About section -->
    <section class="section" id="about">
        <div class="container">
            <h2 class="section-title">About Our Program</h2>
            <div class="about-content">
                <div class="about-text">
                    <p>In Sarawak, the Special Olympics program started in 1998. It is currently led by YB Dato Sri Hajah Fatimah Abdullah and available in Kuching, Miri, Sibu and Bintulu with plans to expand to all regions of Sarawak.</p>
                    <p>Our mission is to provide year-round sports training and athletic competition in a variety of Olympic-type sports for children and adults with intellectual disabilities, giving them continuing opportunities to develop physical fitness, demonstrate courage, experience joy and participate in a sharing of gifts, skills and friendship.</p>
                </div>
                <div class="about-image">
                    <img src="../assets/images/yb_hfatimah_along.gif" alt="Group of Special Olympics athletes participating in various sports activities with coaches and volunteers">
                </div>
            </div>
        </div>
    </section>
    
    <!-- Programs section -->
    <section class="section" style="background-color: #f0f0f0;">
        <div class="container">
            <h2 class="section-title">Programs</h2>
            <div class="programs-grid">
                <a href="sohap.php" class="program-card" style="text-decoration: none; color: inherit; display: block; transition: transform 0.3s ease, box-shadow 0.3s ease;">
                    <div class="program-image">
                        <img src="../assets/images/healthy_program_1.jpg" alt="Medical professionals conducting health screenings for Special Olympics athletes">
                    </div>
                    <div class="program-content">
                        <h3 class="program-title"><span class="program-number">1</span>Special Olympics Healthy Athletes Program</h3>
                        <p>The Special Olympics Healthy Athletes program offers health services and education to Special Olympics athletes and focuses on removing the barriers to care that people with intellectual disabilities face.</p>
                    </div>
                </a>
                <a href="alp.php" class="program-card" style="text-decoration: none; color: inherit; display: block; transition: transform 0.3s ease, box-shadow 0.3s ease;">
                    <div class="program-image">
                        <img src="../assets/images/leadership_1.jpg" alt="Special Olympics athletes participating in leadership training sessions">
                    </div>
                    <div class="program-content">
                        <h3 class="program-title"><span class="program-number">2</span>Special Olympics Athlete Leadership Program </h3>
                        <p>This program provides athletes with opportunities to take on leadership roles in the Special Olympics movement beyond the playing field. Athletes serve as coaches, officials, spokespeople, and board members.</p>
                    </div>
                </a>
                <a href="yap.php" class="program-card" style="text-decoration: none; color: inherit; display: block; transition: transform 0.3s ease, box-shadow 0.3s ease;">
                    <div class="program-image">
                        <img src="../assets/images/young_athelte_1.jpg" alt="Young children with intellectual disabilities playing sports games with coaches">
                    </div>
                    <div class="program-content">
                        <h3 class="program-title"><span class="program-number">3</span> Young Athletes Program</h3>
                        <p>An innovative sports play program for children with intellectual disabilities ages 2-7 years old. The program introduces basic sports skills through fun activities that support developmental milestones.</p>
                    </div>
                </a>
            </div>
        </div>
    </section>

    <!-- Sports section -->
    <section class="section">
        <div class="container">
            <h2 class="section-title">Our Sports</h2>
            <div class="sports-container">
                <?php if (empty($sports)): ?>
                    <div style="text-align: center; padding: 40px; color: #666; font-style: italic;">
                        <p>No sports are currently available. Please check back later.</p>
                    </div>
                <?php else: ?>
                    <?php foreach ($sports as $sport): ?>
                        <div class="sport-item">
                            <div class="sport-icon">
                                <?php 
                                // Display icon based on sport title, fallback to default
                                echo isset($sportIcons[$sport['title']]) ? $sportIcons[$sport['title']] : '🏆';
                                ?>
                            </div>
                            <h3><?php echo htmlspecialchars($sport['title']); ?></h3>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
            <?php if (!empty($sports)): ?>
                <div style="text-align: center; margin-top: 30px;">
                    <a href="sport.php" class="cta-button" style="display: inline-block; padding: 12px 24px; background-color: #e63946; color: white; text-decoration: none; border-radius: 5px; font-weight: bold; transition: background-color 0.3s ease;">
                        View All Sports
                    </a>
                </div>
            <?php endif; ?>
        </div>
    </section>
    
    <!-- Regions section -->
    <section class="section" style="background-color: #f0f0f0;">
        <div class="container">
            <h2 class="section-title">Available In</h2>
            <div class="regions-container">
                <div class="region-card">Kuching</div>
                <div class="region-card">Miri</div>
                <div class="region-card">Sibu</div>
                <div class="region-card">Bintulu</div>
                <div class="region-card">Samarahan</div>
            </div>
            <p style="text-align: center; margin-top: 30px; font-weight: bold;">With plans to expand to all regions of Sarawak</p>
        </div>
    </section>

    <div class="section-divider"></div>

    <!-- Bottom Navigation -->
    <script src="../scripts/components/bottom-nav.js"></script>

    <!-- Site footer -->
    <script src="../scripts/components/site-footer.js"></script>

    <script src="../scripts/script.js"></script>
    <script src="../scripts/song-bubble.js"></script>
</body>
</html>
