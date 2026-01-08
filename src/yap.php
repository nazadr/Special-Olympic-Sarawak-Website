<?php
// Database connection
$host = 'localhost';
$dbname = 'so_sarawak_db';
$username = 'root'; 
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Fetch YAP content from database
    $stmt = $pdo->prepare("SELECT * FROM yap_content WHERE is_active = 1 LIMIT 1");
    $stmt->execute();
    $yapContent = $stmt->fetch(PDO::FETCH_ASSOC);
    
} catch(PDOException $e) {
    // Fallback data if database connection fails
    $yapContent = [
        'hero_image' => '../assets/images/yap-hero.jpg',
        'hero_title' => 'Young Athletes Program (YAP)',
        'description_text' => 'Special Olympics Young Athletes is an early childhood play program for children with and without intellectual disabilities, ages 2 to 7 years old. Young Athletes introduces basic sport skills, like running, kicking and throwing.',
        'testimonial_text' => '"When my baby was born and I learned he had an intellectual disability, I felt lost, unsure of what the future would hold. But at Young Athletes Program, I see him so full of joy — running, laughing, and connecting with others. It\'s such a beautiful sight to witness, and it fills me with hope, reminding me that one day, he might just be able to stand on his own, stronger than I could have ever imagined."',
        'testimonial_author' => 'SARAH, MOTHER OF A YOUNG ATHLETES IN KUCHING',
        'testimonial_location' => 'KUCHING',
        'resources_title' => 'Resources for YAP',
        'resources_description' => 'We provides an introductory information of this program and resources to run Young Athletes Program in schools, communities and homes.',
        'resources_button_text' => 'LEARN MORE',
        'resources_button_link' => '../src/yap-lm.html',
        'resources_background_image' => '../assets/images/yap-lm-hero-hf.jpg'
    ];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Young Athletes Program (YAP) | Special Olympics Sarawak</title>
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

        .yap-hero {
            background: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)), url('<?php echo htmlspecialchars($yapContent['hero_image']); ?>') center/cover no-repeat;
            height: 60vh;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
            color: white;
            position: relative;
        }

        .yap-hero h1 {
            font-size: 3.5rem;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);
        }

        .yap-desc-section {
            background-color: white;
            padding: 60px 20px 0 20px;
            text-align: left;
        }

        .yap-desc-section p {
            font-size: 1.1rem;
            line-height: 1.6;
            color: #333;
            margin-bottom: 40px;
        }

        .yap-desc-section ul, .yap-desc-section ol {
            margin: 0 0 40px 0;
            padding-left: 40px;
            font-size: 1.1rem;
            color: #333;
        }

        .yap-desc-section li {
            margin-bottom: 12px;
            line-height: 1.6;
        }
        
        .yap-desc-section strong, .yap-desc-section b {
            font-weight: 600;
            color: #1a1a1a;
        }
        
        .yap-desc-section em, .yap-desc-section i {
            font-style: italic;
        }
        
        .yap-desc-section a {
            color: #e63946;
            text-decoration: none;
            border-bottom: 1px solid transparent;
            transition: border-bottom-color 0.2s ease;
        }
        
        .yap-desc-section a:hover {
            border-bottom-color: #e63946;
        }
        
        .yap-desc-section u {
            text-decoration: underline;
        }

        /* Message in squared red card */
        .yap-section {
            max-width: 1200px;
            margin: 0 auto 0 auto;
            padding: 0 20px 0 20px;
        }

        .yap-message {
            display: flex;
            flex-direction: column; /* Stack children vertically (h3 above p) */
            align-items: center; /* Center children horizontally */
            justify-content: center; /* Center the entire stack vertically in the container */
            text-align: center; /* Ensure text inside h3 and p is centered */
            width: 100%;
            max-width: 1200px;
            min-height: 300px;
            background-color: #c4161c;
            margin: 80px auto 80px auto;
            padding: 0 80px;
            box-sizing: border-box;
        }

        .yap-message-contents{
            padding: 0 40px;
        }

        .yap-message h3 {
            color: white;
            font-size: 1.4rem;
            margin: 40px;
            font-weight: normal;
            max-width: 100%; /* Prevent overflow on smaller screens */
            width: 100%;
        }
        
        .yap-message h3 strong, .yap-message h3 b {
            font-weight: 600;
        }
        
        .yap-message h3 em, .yap-message h3 i {
            font-style: italic;
        }
        
        .yap-message h3 u {
            text-decoration: underline;
        }
        .yap-message p {
            color: white;
            font-size: 0.8rem;
            font-weight: 600;
            max-width: 100%; /* Prevent overflow on smaller screens */
            width: 100%;
        }

        .yap-more-section {
            display: flex;
            background: linear-gradient(to right, rgba(0, 0, 0, 0.85), rgba(0, 0, 0, 0) 60%), url('<?php echo htmlspecialchars($yapContent['resources_background_image']); ?>') center/cover no-repeat;
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

        .yap-more-section h1 {
            font-size: 2.8rem;
            margin: auto auto 10px 80px;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);
        }

        .yap-more-section p {
            font-size: 1.1rem;
            max-width: 400px;
            margin: 10px auto 20px 80px;
        }

        .yap-more-button {
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

        .yap-more-button:hover {
            background-color: #e94e1b;
        }

        @media (max-width: 1299px) {
            .yap-more-section {
                margin-bottom: 0px;
            }

            .site-footer {
                margin-top: 0px;
            }
        }

        @media (max-width: 768px) {
            .yap-section h2 {
                font-size: 1.6rem;
                margin: 40px 0 20px 0;
            }

            .yap-section-afterline {
                margin-bottom: 40px;
            }

            .yap-section p {
                font-size: 1rem;
            }

            .yap-message {
                height: auto; /* Reduce height on mobile if needed */
                margin: 20px auto 40px auto;
                padding: 0 40px;
            }
            
            .yap-message h3 {
                font-size: 1.2rem;
                margin: 20px
            }
            .yap-message p {
                font-size: 0.7rem;
                margin: 20px;
            }

            .yap-more-section {
                background: linear-gradient(to right, rgba(0, 0, 0, 0.5) 100%, rgba(0, 0, 0, 0)), url('<?php echo htmlspecialchars($yapContent['resources_background_image']); ?>') center/cover no-repeat;
                justify-content: center;
                align-items: center;
                text-align: center;
            }

            .yap-more-section h1 {
                font-size: 2rem;
                margin: auto auto 40px auto;
            }

            .yap-more-section p {
                display: none;
            }

            .yap-more-button {
                margin: 0 auto auto auto;
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

    <!-- New -->
    <section class="yap-hero">
        <h1><?php echo htmlspecialchars($yapContent['hero_title']); ?></h1>
    </section>

    <section class="yap-desc-section">
        <div style="max-width: 1200px; margin: 0 auto;">
        <?php 
        // Display HTML content from rich text editor
        echo $yapContent['description_text'] ?? '<p>No content available.</p>';
        ?>
        </div>
    </section>

    <?php if (!empty($yapContent['testimonial_text'])): ?>
    <div class="yap-section">
        <div class="yap-message">
            <h3><?php echo $yapContent['testimonial_text']; ?></h3>
            <?php if (!empty($yapContent['testimonial_author'])): ?>
            <p>— <?php echo strtoupper(htmlspecialchars($yapContent['testimonial_author'])); ?></p>
            <?php endif; ?>
        </div>
    </div>
    <?php endif; ?>

    <section class="yap-more-section">
        <h1><?php echo htmlspecialchars($yapContent['resources_title']); ?></h1>
        <?php if (!empty($yapContent['resources_description'])): ?>
        <p><?php echo htmlspecialchars($yapContent['resources_description']); ?></p>
        <?php endif; ?>
        <a href="<?php echo htmlspecialchars($yapContent['resources_button_link']); ?>" class="yap-more-button">
            <?php echo htmlspecialchars($yapContent['resources_button_text']); ?>
        </a>
    </section>

    <!-- Bottom Navigation -->
    <script src="../scripts/components/bottom-nav.js"></script>

    <!-- Site footer -->
    <script src="../scripts/components/site-footer.js"></script>

    <script src="../scripts/script.js"></script>
    <script src="../scripts/song-bubble.js"></script>
</body>
</html>