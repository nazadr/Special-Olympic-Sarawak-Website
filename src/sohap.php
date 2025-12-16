<?php
// Fetch HAP articles from database
$host = 'localhost';
$dbname = 'so_sarawak_db';
$username = 'root';
$password = '';

$hapArticles = [];

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    $stmt = $pdo->prepare("SELECT * FROM hap ORDER BY display_order ASC, created_at DESC LIMIT 6");
    $stmt->execute();
    $hapArticles = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch(PDOException $e) {
    // If there's an error, we'll use default content
    error_log("Database error in SOHAP: " . $e->getMessage());
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Healthy Athletes Program (SOHAP) | Special Olympics Sarawak</title>
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

        /* Newly added */
        .sohap-hero {
            background: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)), url('../assets/images/sohap-hero-2.jpg') center/cover no-repeat;
            height: 60vh;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
            color: white;
            position: relative;
        }

        .sohap-hero h1 {
            font-size: 3.5rem;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);
        }

        .sohap-desc-section {
            background-color: white;
            padding: 60px 20px 0 20px;
            text-align: left;
        }

        .sohap-desc-section p {
            font-size: 1.1rem;
            line-height: 1.6;
            color: #333;
            max-width: 1200px;
            margin: 0 auto 40px;
        }

        .sohap-desc-section ul {
            max-width: 1160px;
            margin: 0 auto 40px;
            font-size: 1.1rem;
            color: #333;
        }

        .sohap-desc-section li {
            margin-bottom: 12px;
        }

        /* Articles about SOHAP */
        .sohap-more-articles {
            padding: 60px 20px;
            background-color: #f9f9f9;
            margin-top: 80px;
        }

        .sohap-more-articles h2 {
            text-align: center;
            color: #e63946;
            font-size: 2.2rem;
            margin-bottom: 10px;
        }

        .sohap-more-afterline {
            width: 60px;
            height: 3px;
            background-color: #e30613;
            margin: 0 auto 60px auto;
            display: block;
        }

        .sohap-more-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(380px, 1fr));
            gap: 30px;
            max-width: 1200px;
            margin: 0 auto;
            align-items: stretch;
        }

        .sohap-more-card {
            display: flex;
            flex-direction: column;
            background-color: white;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
            cursor: pointer;
            height: 100%;
        }

        .sohap-more-card:hover{
            transform: translateY(-10px);
            box-shadow: 0 8px 16px rgba(230, 57, 70, 0.2);
        }

        .sohap-card-image {
            height: 180px;
            overflow: hidden;
        }

        .sohap-card-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.3s ease;
        }

        .sohap-more-card:hover .sohap-card-image img {
            transform: scale(1.05);
        }

        .sohap-card-content {
            padding: 20px;
            text-align: center;
            flex-grow: 1;
            display: flex;
            flex-direction: column;
        }

        .sohap-card-content h3 {
            color: #e63946;
            margin-bottom: 10px;
            font-size: 1.4rem;
        }

        .sohap-card-content p {
            color: #6b7280;
            font-size: 1rem;
        }

        .sohap-card-button {
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            width: 140px;
            height: 40px;
            background-color: #c41926;
            border: none;
            margin: 0 auto 40px auto;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .sohap-card-button a {
            text-decoration: none;
            color: white;
            font-size: 1rem;
            font-weight: 600;
        }

        .sohap-card-button:hover {
            background-color: #e94e1b;
        }

        .sohap-more-button {
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            width: 300px;
            height: 60px;
            background-color: #c41926;
            border: none;
            margin: 80px auto 40px auto;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .sohap-more-button a {
            text-decoration: none;
            color: white;
            font-size: 1.2rem;
            font-weight: 700;
        }

        .sohap-more-button:hover {
            background-color: #e94e1b;
        }

        .sohap-more-section {
            display: flex;
            background: linear-gradient(to right, rgba(0, 0, 0, 0.85), rgba(0, 0, 0, 0) 60%), url('../assets/images/sohap-more.JPG') center/cover no-repeat;
            height: 40vh;
            max-height: 100%;
            display: flex;
            flex-direction: column;
            justify-content: left;
            align-items: left;
            text-align: left;
            color: white;
            position: relative;
            margin-bottom: 80px;
        }

        .sohap-more-section h1 {
            font-size: 2.8rem;
            margin: auto auto 10px 80px;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);
        }

        .sohap-more-section p {
            font-size: 1.1rem;
            max-width: 400px;
            margin: 10px auto 20px 80px;
        }

        .sohap-ms-button {
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            width: 200px;
            height: 60px;
            background-color: #c41926;
            border: none;
            margin: 20px auto auto 80px;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
            text-decoration: none;
            color: white;
            font-size: 1.1rem;
            font-weight: 700;
        }

        .sohap-ms-button:hover {
            background-color: #e94e1b;
        }

        @media (max-width: 1299px) {
            .sohap-more-section {
                margin-bottom: 0px;
            }

            .site-footer {
                margin-top: 0px;
            }
        }

        @media (max-width: 768px) {
            .sohap-section h2 {
                font-size: 1.6rem;
                margin: 40px 0 20px 0;
            }

            .sohap-section-afterline {
                margin-bottom: 40px;
            }

            .sohap-section-alt {
                font-size: 0.7rem;
                margin-bottom: 20px;
            }

            .sohap-section p {
                font-size: 1rem;
            }

            .sohap-more-section {
                background: linear-gradient(to right, rgba(0, 0, 0, 0.5) 100%, rgba(0, 0, 0, 0)), url('../assets/images/sohap-more-sample.jpeg') center/cover no-repeat;
                justify-content: center;
                align-items: center;
                text-align: center;
            }

            .sohap-more-section h1 {
                font-size: 2rem;
                margin: auto auto 40px auto;
            }

            .sohap-more-section p {
                display: none;
            }

            .sohap-ms-button {
                margin: 0 auto auto auto;
            }

            .sohap-more-grid {
                grid-template-columns: 1fr;
                gap: 20px;
            }
        }
    </style>
</head>
<body>
    <!-- Navigation Bar (Loaded via JS) -->
    <script src="../scripts/components/header.js"></script>

    <!-- Social Media Bar (Loaded via JS) -->
    <script src="../scripts/components/socmed-bar.js"></script>

    <!-- Space for existing header -->
    <div class="header-space"></div>

    <section class="sohap-hero">
        <h1>Healthy Athletes Program (SOHAP)</h1>
    </section>

    <section class="sohap-desc-section">
        <p>The Healthy Athletes Program (SOHAP) at Special Olympics Sarawak is dedicated to improving the health and well-being of athletes by providing access to essential health services, education, and screenings. The program aims to promote overall physical health, prevent potential health issues, and educate athletes on maintaining healthy lifestyles both on and off the field. By offering free health screenings and partnering with healthcare professionals, Healthy Athletes Program ensures that athletes have the tools and resources to perform at their best while living a healthy and active life. The key features of this program are:</p>
        <ul>
            <li><strong>Free Health Screenings:</strong> Athletes have access to a wide range of free health screenings, including vision, hearing, dental, and fitness assessments, ensuring they receive early detection and appropriate care.</li>
            <li><strong>Comprehensive Health Education:</strong> We provides educational resources on topics like nutrition, fitness, hydration, and healthy habits, empowering athletes to make informed choices about their health.</li>
            <li><strong>Access to Healthcare Professionals:</strong> Special Olympics Sarawak collaborates with medical professionals, including doctors, dentists, optometrists, and physical therapists, to offer specialized care and guidance tailored to athletes' needs.</li>
            <li><strong>Focused on Preventive Care:</strong> The program emphasizes the importance of preventive health measures to help athletes maintain long-term well-being, addressing issues before they become serious.</li>
            <li><strong>Improved Physical Fitness:</strong> Through regular health screenings and fitness assessments, athletes receive personalized advice and support to enhance their physical performance and overall fitness levels.</li>
            <li><strong>Inclusive Health Resources:</strong> HAP ensures that all athletes, regardless of their background or ability, have equal access to the healthcare services and education they need to thrive.</li>
            <li><strong>Holistic Wellness:</strong> The program not only focuses on physical health but also promotes mental and emotional wellness by encouraging athletes to maintain a balanced lifestyle, reducing stress, and building self-esteem.</li>
        </ul>
        <p>The Healthy Athletes Program operates at local Special Olympics events and competitions, where athletes can participate in free screenings and educational activities. Through partnerships with healthcare organizations and professionals, HAP is able to bring medical care directly to athletes, ensuring they have the support they need. Additionally, athletes are encouraged to apply the knowledge gained through the program in their daily lives to maintain a healthy and active lifestyle.</p>
        <p>By participating in the Healthy Athletes Program, athletes can identify potential health issues early, receive the care they need, and enhance their overall physical and mental well-being, allowing them to perform their best in all areas of life. The program plays a crucial role in fostering a healthier and more inclusive community where every athlete can reach their full potential.</p>
    </section>

    <section class="sohap-more-articles">
        <h2>Articles about Healthy Athletes Program</h2>
        <div class="sohap-more-afterline"></div>
        <div class="sohap-more-grid">
            <?php 
            if (!empty($hapArticles)) {
                foreach ($hapArticles as $article) {
                    // Use placeholder image if no image is provided
                    $imagePath = !empty($article['image_path']) ? htmlspecialchars($article['image_path']) : '../assets/images/special-olympics-1-1024x768.webp';
                    $learnMoreLink = !empty($article['learn_more_link']) ? htmlspecialchars($article['learn_more_link']) : '#';
                    
                    echo '<div class="sohap-more-card">';
                    echo '<div class="sohap-card-image">';
                    echo '<img src="' . $imagePath . '" alt="' . htmlspecialchars($article['title']) . '">';
                    echo '</div>';
                    echo '<div class="sohap-card-content">';
                    echo '<p style="color: black; font-size: 0.9rem; font-weight: 600; margin: 0 0 4px 0;">' . htmlspecialchars(strtoupper($article['category'])) . '</p>';
                    echo '<h3>' . htmlspecialchars($article['title']) . '</h3>';
                    echo '<p>' . htmlspecialchars(substr($article['description'], 0, 120)) . (strlen($article['description']) > 120 ? '...' : '') . '</p>';
                    echo '</div>';
                    echo '<div class="sohap-card-button">';
                    echo '<a href="' . $learnMoreLink . '">Learn More</a>';
                    echo '</div>';
                    echo '</div>';
                }
            } else {
                // Default/fallback content when no articles are available
                ?>
                <div class="sohap-more-card">
                    <div class="sohap-card-image">
                        <img src="../assets/images/special-olympics-1-1024x768.webp">
                    </div>
                    <div class="sohap-card-content">
                        <p style="color: black; font-size: 0.9rem; font-weight: 600; margin: 0 0 4px 0;">COMMUNITY IMPACT</p>
                        <h3>Community Health Screening</h3>
                        <p>Free health screenings provided to athletes including vision, hearing, dental, and fitness assessments.</p>
                    </div>
                    <div class="sohap-card-button">
                        <a href="#">Learn More</a>
                    </div>
                </div>
                <div class="sohap-more-card">
                    <div class="sohap-card-image">
                        <img src="../assets/images/young_athelte_1.jpg">
                    </div>
                    <div class="sohap-card-content">
                        <p style="color: black; font-size: 0.9rem; font-weight: 600; margin: 0 0 4px 0;">ATHLETES</p>
                        <h3>Athletic Wellness Initiative</h3>
                        <p>Comprehensive health education and fitness programs designed to empower athletes with knowledge about nutrition and fitness.</p>
                    </div>
                    <div class="sohap-card-button">
                        <a href="#">Learn More</a>
                    </div>
                </div>
                <div class="sohap-more-card">
                    <div class="sohap-card-image">
                        <img src="../assets/images/another_news.jpg">
                    </div>
                    <div class="sohap-card-content">
                        <p style="color: black; font-size: 0.9rem; font-weight: 600; margin: 0 0 4px 0;">IN THE NEWS</p>
                        <h3>Healthcare Partnership Success</h3>
                        <p>Collaboration with medical professionals brings specialized care directly to Special Olympics events.</p>
                    </div>
                    <div class="sohap-card-button">
                        <a href="#">Learn More</a>
                    </div>
                </div>
                <?php
            }
            ?>
        </div>
        <div class="sohap-more-button">
            <a href="../src/latest-news.php">EXPAND MORE ARTICLES</a>
        </div>
    </section>

    <section class="sohap-more-section">
        <h1>Healthy Athletes Program</h1>
        <p>Join with the health care providers and students statewide who have volunteered with the Healthy Athletes Program.</p>
        <a href="../src/join_us.html" class="sohap-ms-button">LEARN MORE</a>
    </section>

    <!-- Bottom Navigation -->
    <script src="../scripts/components/bottom-nav.js"></script>

    <!-- Site footer -->
    <script src="../scripts/components/site-footer.js"></script>

    <script src="../scripts/script.js"></script>
</body>
</html>