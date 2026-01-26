<?php
// Fetch ALP page settings from database
$host = 'localhost';
$dbname = 'so_sarawak_db';
$username = 'root';
$password = '';

// Initialize with default values
$heroImagePath = '../assets/images/alp-hero-temp.jpg';
$heroTitle = 'Athlete Leadership Program (ALP)';
$descriptionContent = '<p>The Athlete Leadership Program (ALP) at Special Olympics Sarawak is designed to empower athletes to become leaders both on and off the field. This comprehensive program provides athletes with the skills, confidence, and opportunities to take on leadership roles within their communities and the broader Special Olympics movement.</p><p>The program is open to all athletes involved in Special Olympics Sarawak. Whether you are an experienced athlete or just starting your journey, ALP offers a pathway to develop your leadership potential and make a meaningful impact.</p><ul><li><strong>Leadership Development:</strong> Athletes will learn core leadership skills including communication, decision-making, and teamwork through interactive workshops and practical exercises.</li><li><strong>Empowerment Through Roles:</strong> The program offers various leadership roles such as Athlete Representatives, Global Messengers, and Program Assistants, enabling athletes to contribute actively to program planning and advocacy.</li><li><strong>Mentorship Opportunities:</strong> Athletes are paired with experienced leaders and mentors who provide guidance, support, and inspiration throughout their leadership journey.</li><li><strong>Advocacy and Awareness:</strong> Participants have the chance to speak out on important issues, share their stories, and raise awareness about the abilities and potential of people with intellectual disabilities.</li><li><strong>Community Engagement:</strong> The program encourages athletes to engage with their local communities, organize events, and become ambassadors for inclusion and diversity.</li><li><strong>Training and Workshops:</strong> A series of workshops and training sessions cover topics such as public speaking, event planning, fundraising, and sports officiating.</li><li><strong>Personal Growth:</strong> The Athlete Leadership Program fosters personal development, building self-esteem, independence, and life skills that extend beyond the sports arena.</li></ul><p>Through active participation in the Athlete Leadership Program, athletes become change-makers and role models, demonstrating that leadership has no boundaries and that everyone has the power to inspire others.</p>';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Fetch page settings
    $stmt = $pdo->prepare("SELECT * FROM alp_page_settings WHERE id = 1");
    $stmt->execute();
    $pageSettings = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if ($pageSettings) {
        // Update variables with database values
        $heroImagePath = $pageSettings['hero_image_path'] ?? $heroImagePath;
        $heroTitle = $pageSettings['hero_title'] ?? $heroTitle;
        $descriptionContent = $pageSettings['description_content'] ?? $descriptionContent;
    }
} catch(PDOException $e) {
    // If there's an error, we'll use default content
    error_log("Database error in ALP: " . $e->getMessage());
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Athlete Leadership Program (ALP) | Special Olympics Sarawak</title>
    <link rel="shortcut icon" href="../assets/images/master_logo_front.png">
    <link rel="stylesheet" href="../css/global-style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <style>
        .header-space {
            height: 70px;
            background: transparent;
        }

        .body {
            background-color: #f9f9f9;
            overflow-y: auto;
            min-height: 100vh;
        }

        .alp-afterline {
            width: 60px;
            height: 3px;
            background-color: #FF0000;
            margin: 0 auto 80px auto;
            display: block;
        }

        .alp-hero {
            background: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)), url('<?php echo htmlspecialchars($heroImagePath); ?>') center/cover no-repeat;
            height: 60vh;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
            color: white;
            position: relative;
        }

        .alp-hero h1 {
            font-size: 3.5rem;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);
        }

        .alp-desc-section {
            background-color: white;
            padding: 60px 20px;
            text-align: left;
        }

        .alp-desc-section p {
            font-size: 1.1rem;
            line-height: 1.6;
            color: #333;
            max-width: 1200px;
            margin: 0 auto 40px;
        }

        .alp-desc-section ul {
            max-width: 1160px;
            margin: 0 auto 40px;
            font-size: 1.1rem;
            color: #333;
        }

        .alp-desc-section li {
            margin-bottom: 12px;
            line-height: 1.6;
        }

        /* Three Guiding Principle */
        .alp-gp-section {
            background-color: #f1f1f1;
            padding: 60px 20px;
            text-align: left;
        }

        .alp-gp-section h2 {
            color: #e63946;
            font-size: 2.5rem;
            text-align: center;
            margin-bottom: 10px;
        }

        .alp-gp-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(380px, 1fr));
            gap: 30px;
            max-width: 1200px;
            margin: 0 auto;
        }

        .alp-border-bottom {
            border-bottom: 5px solid #e63946;
        }

        .alp-gp-card {
            background: white;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
            cursor: pointer;
        }

        .alp-gp-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 8px 16px rgba(230, 57, 70, 0.2);
        }

        .alp-gp-content {
            padding: 20px 28px;
            text-align: left;
        }

        .alp-gp-content h3 {
            color: black;
            font-size: 1.4rem;
            font-weight: 600;
        }

        .alp-gp-content p {
            color: black;
            font-size: 1rem;
            line-height: 1.6;
        }

        .alp-gp-content a {
            text-decoration: none;
            color: #e63946;
            font-size: 1rem;
        }

        /* Meet our Athlete Leaders */
        .alp-meet-section {
            display: flex;
            background: linear-gradient(to right, rgba(0, 0, 0, 0.85), rgba(0, 0, 0, 0) 60%), url('../assets/images/pexels-franco-monsalvo-252430633-32101179.jpg') center/cover no-repeat;
            height: 50vh;
            max-height: 100%;
            flex-direction: column;
            justify-content: left;
            align-items: left;
            text-align: left;
            color: white;
            position: relative;
            margin-bottom: 80px;
        }

        .alp-meet-section h1 {
            font-size: 2.8rem;
            margin: auto auto 10px 80px;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);
        }

        .alp-meet-section p {
            font-size: 1.1rem;
            max-width: 400px;
            margin: 10px auto 20px 80px;
        }

        .alp-meet-button {
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

        .alp-meet-button:hover {
            background-color: #e94e1b;
        }

        @media (max-width: 1299px) {
            .alp-meet-section {
                margin-bottom: 0px;
            }

            .site-footer {
                margin-top: 0px;
            }
        }

        @media (max-width: 768px) {
            .alp-hero {
                height: 40vh;
            }
            
            .alp-hero h1 {
                font-size: 1.6rem;
                margin-left: 20px;
                margin-right: 20px;
            }
            
            .alp-desc-section p, .alp-desc-section ul {
                font-size: 1rem;
            }

            .alp-desc-section li {
                margin-bottom: 16px;
            }
            
            .articles-grid {
                grid-template-columns: 1fr;
            }
            
            .alp-meet-section {
                background: linear-gradient(to right, rgba(0, 0, 0, 0.5) 100%, rgba(0, 0, 0, 0)), url('../assets/images/pexels-franco-monsalvo-252430633-32101179.jpg') center/cover no-repeat;
                justify-content: center;
                align-items: center;
                text-align: center;
            }

            .alp-meet-section h1 {
                font-size: 2rem;
                margin: auto auto 40px auto;
            }

            .alp-meet-section p {
                display: none;
            }

            .alp-meet-button {
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

    <section class="alp-hero">
        <h1><?php echo htmlspecialchars($heroTitle); ?></h1>
    </section>

    <section class="alp-desc-section">
        <?php echo $descriptionContent; // Output HTML content directly - CSS will handle styling ?>
    </section>

    <section class="alp-gp-section">
        <h2>Three Guiding Principles</h2>
        <div class="alp-afterline"></div>
        <div class="alp-gp-grid">
            <div class="alp-gp-card alp-border-bottom">
                <div class="alp-gp-content">
                    <h3>Principle 1: Education and Awareness Building</h3>
                    <p>The first principle is Education and Awareness Building utilizing the Unified Leadership approach to developing leaders. Building from sport, Unified Leadership teaches leaders (both those with AND without ID) that we all have a responsibility to develop diverse leaders.</p>
                    <a href="#">Learn more about Unified Leadership</a>
                </div>
            </div>
            <div class="alp-gp-card alp-border-bottom">
                <div class="alp-gp-content">
                    <h3>Principle 2: Choice and Training</h3>
                    <p>It is important that all non-Special Olympics athletes acknowledge that athletes have a choice in how and where they lead in Special Olympics. This is their program, and staff and volunteers are here to support them. But for them to succeed, they need to be trained in the areas that they choose to pursue.</p>
                    <a href="#">Learn more about Leadership & Skills Curriculum</a>
                </div>
            </div>
            <div class="alp-gp-card alp-border-bottom">
                <div class="alp-gp-content">
                    <h3>Principle 3: Empowerment and Change</h3>
                    <p>Special Olympics athletes hold the power to change the world through sport; that is the organization's founding principle. Athlete Leadership teaches our athletes to gain the knowledge and confidence to lead programmatic work. This is their organization — we are here to support them.</p>
                    <a href="#">Learn more about Athlete Empowerment</a>
                </div>
            </div>
        </div>
    </section>


    <!-- "Meet Our Athlete Leader" -->
    <section class="alp-meet-section">
        <h1>Meet our Athlete Leaders</h1>
        <p>We empower athletes to share their abilities and experiences, ensuring they play a leading role in shaping our movement and strengthening our programs.</p>
        <a href="#" class="alp-meet-button">LEARN MORE</a>
    </section>

    <!-- Bottom Navigation -->
    <script src="../scripts/components/bottom-nav.js"></script>

    <!-- Site footer -->
    <script src="../scripts/components/site-footer.js"></script>

    <script src="../scripts/script.js"></script>
    <script src="../scripts/song-bubble.js"></script>
</body>
</html>