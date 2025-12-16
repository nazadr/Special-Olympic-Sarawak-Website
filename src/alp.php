<?php
// Fetch ALP articles from database
$host = 'localhost';
$dbname = 'so_sarawak_db';
$username = 'root';
$password = '';

$alpArticles = [];

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    $stmt = $pdo->prepare("SELECT * FROM alp WHERE is_active = 1 ORDER BY display_order ASC, created_at DESC");
    $stmt->execute();
    $alpArticles = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch(PDOException $e) {
    // If there's an error, we'll use default content
    error_log("Database error in ALP: " . $e->getMessage());
}

// Organize articles by categories for the three principles
$principleArticles = [
    'LEADERSHIP DEVELOPMENT' => [],
    'TRAINING PROGRAMS' => [],
    'ATHLETE SPOTLIGHT' => [],
    'SUCCESS STORIES' => [],
    'COMMUNITY ENGAGEMENT' => [],
    'MENTORSHIP' => []
];

foreach ($alpArticles as $article) {
    // Normalize image path for frontend display
    if (!empty($article['image_path'])) {
        $imagePath = $article['image_path'];
        
        // Handle different path formats
        if (strpos($imagePath, '../') === 0) {
            // Remove '../' prefix for frontend
            $article['image_path'] = substr($imagePath, 3);
        } elseif (strpos($imagePath, 'assets/') !== 0) {
            // If it doesn't start with 'assets/', prepend it
            $article['image_path'] = 'assets/images/alp/' . basename($imagePath);
        }
        // If it already starts with 'assets/', keep it as is
    }
    
    if (isset($principleArticles[$article['category']])) {
        $principleArticles[$article['category']][] = $article;
    }
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
            background-color: #e30613;
            margin: 0 auto 80px auto;
            display: block;
        }

        .alp-hero {
            background: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)), url('../assets/images/alp-hero-temp.jpg') center/cover no-repeat;
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

        /* Dynamic Articles Section */
        .alp-articles-section {
            background-color: white;
            padding: 60px 20px;
        }

        .alp-articles-section h2 {
            color: #e63946;
            font-size: 2.5rem;
            text-align: center;
            margin-bottom: 10px;
        }

        .principle-group {
            margin-bottom: 60px;
        }

        .principle-group h3 {
            color: #10b981;
            font-size: 2rem;
            text-align: center;
            margin-bottom: 30px;
            font-weight: 600;
        }

        .articles-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
            gap: 30px;
            max-width: 1200px;
            margin: 0 auto;
        }

        .article-card {
            background: white;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
            border: 1px solid #e5e7eb;
        }

        .article-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 12px 24px rgba(16, 185, 129, 0.15);
            border-color: #10b981;
        }

        .article-image {
            width: 100%;
            height: 200px;
            object-fit: cover;
            background: #f3f4f6;
        }

        .article-content {
            padding: 24px;
        }

        .article-category {
            display: inline-block;
            background: rgba(16, 185, 129, 0.1);
            color: #10b981;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 0.85rem;
            font-weight: 600;
            text-transform: uppercase;
            margin-bottom: 12px;
        }

        .article-title {
            color: #1f2937;
            font-size: 1.25rem;
            font-weight: 700;
            margin-bottom: 12px;
            line-height: 1.4;
        }

        .article-description {
            color: #6b7280;
            font-size: 0.95rem;
            line-height: 1.6;
            margin-bottom: 16px;
        }

        .article-link {
            color: #10b981;
            text-decoration: none;
            font-weight: 600;
            font-size: 0.9rem;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            transition: color 0.2s ease;
        }

        .article-link:hover {
            color: #059669;
        }

        .no-articles {
            text-align: center;
            color: #6b7280;
            font-style: italic;
            padding: 40px;
            background: #f9fafb;
            border-radius: 12px;
            margin: 20px 0;
        }

        /* Downloadable PDF Resource */
        .alp-res-bord-btm1 {
            border-bottom: 5px solid #2379b4;
        }

        .alp-res-bord-btm2 {
            border-bottom: 5px solid #10b981;
        }
        
        .card {
            transition: all 0.3s ease;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            border-radius: 12px;
            overflow: hidden;
            background-color: white;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.15);
        }

        /* Button Styles */
        .btn-primary {
            background-color: #c41926;
            transition: all 0.3s ease;
            color: white;
            padding: 0.5rem 1.5rem;
            border-radius: 0.5rem;
            display: inline-block;
            font-weight: 600;
            text-decoration: none;
            border: none;
            cursor: pointer;
        }

        .btn-primary:hover {
            background-color: #e94e1b;
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
        <h1>Athlete Leadership Program (ALP)</h1>
    </section>

    <section class="alp-desc-section">
        <p>The Athlete Leadership Program (ALP) at Special Olympics Sarawak is designed to empower athletes to become leaders both on and off the field. This program aims to cultivate leadership skills, foster self-confidence, and create opportunities for athletes to take on roles of responsibility within the organization. Through a combination of training, mentorship, and hands-on experience, athletes are given the tools to advocate for themselves and their peers, contribute to the growth of the Special Olympics movement, and become influential role models in their communities. The key features of this program are:</p>
        <ul>
            <li><strong>Leadership Development:</strong> Athletes will learn core leadership skills, including effective communication, team-building, public speaking, and decision-making.</li>
            <li><strong>Empowerment Through Roles:</strong> The program offers various leadership roles within the Special Olympics Sarawak community, allowing athletes to represent their peers, organize events, and advocate for inclusion.</li>
            <li><strong>Mentorship Opportunities:</strong> Athletes are paired with experienced leaders and mentors who provide guidance, support, and advice throughout their leadership journey.</li>
            <li><strong>Advocacy and Awareness:</strong> Participants have the chance to speak out on issues that matter to them, raising awareness and promoting inclusion for people with intellectual disabilities.</li>
            <li><strong>Community Engagement:</strong> The program encourages athletes to engage with local communities, spreading the message of empowerment, acceptance, and unity in both sporting and non-sporting environments.</li>
            <li><strong>Training and Workshops:</strong> A series of workshops and training sessions are offered to equip athletes with the skills they need to succeed in leadership positions, including conflict resolution, organizational skills, and goal setting.</li>
            <li><strong>Personal Growth:</strong> The Athlete Leadership Program fosters personal development by helping athletes build confidence, resilience, and self-awareness.</li>
        </ul>
        <p>The program is open to all athletes involved in Special Olympics Sarawak, with different levels of participation based on experience and interests. Whether athletes want to take on a leadership role within their sport or in the broader community, the program offers structured opportunities to develop and practice these skills.</p>
        <p>Through active participation in the Athlete Leadership Program, athletes not only enhance their personal development but also contribute to creating a more inclusive, diverse, and empowered community.</p>
    </section>

    <section class="alp-gp-section">
        <h2>Three Guiding Principles</h2>
        <div class="alp-afterline"></div>
        <div class="alp-gp-grid">
            <div class="alp-gp-card alp-border-bottom">
                <div class="alp-gp-content">
                    <h3>Principle 1: Education and Awareness Building</h3>
                    <p>The first principle is Education and Awareness Building utilizing the Unified Leadership approach to developing leaders. Building from sport, Unified Leadership teaches leaders (both those with AND without ID) that we all have a responsibility to develop diverse leaders.</p>
                    <?php if (count($principleArticles['LEADERSHIP DEVELOPMENT']) > 0): ?>
                        <a href="#principle-1">View <?php echo count($principleArticles['LEADERSHIP DEVELOPMENT']); ?> Leadership Development Articles</a>
                    <?php else: ?>
                        <a href="#">Learn more about Unified Leadership</a>
                    <?php endif; ?>
                </div>
            </div>
            <div class="alp-gp-card alp-border-bottom">
                <div class="alp-gp-content">
                    <h3>Principle 2: Choice and Training</h3>
                    <p>It is important that all non-Special Olympics athletes acknowledge that athletes have a choice in how and where they lead in Special Olympics. This is their program, and staff and volunteers are here to support them. But for them to succeed, they need to be trained in the areas that they choose to pursue.</p>
                    <?php if (count($principleArticles['TRAINING PROGRAMS']) > 0): ?>
                        <a href="#principle-2">View <?php echo count($principleArticles['TRAINING PROGRAMS']); ?> Training Program Articles</a>
                    <?php else: ?>
                        <a href="#">Learn more about Leadership & Skills Curriculum</a>
                    <?php endif; ?>
                </div>
            </div>
            <div class="alp-gp-card alp-border-bottom">
                <div class="alp-gp-content">
                    <h3>Principle 3: Empowerment and Change</h3>
                    <p>Special Olympics athletes hold the power to change the world through sport; that is the organization's founding principle. Athlete Leadership teaches our athletes to gain the knowledge and confidence to lead programmatic work. This is their organization — we are here to support them.</p>
                    <?php 
                    $spotlightCount = count($principleArticles['ATHLETE SPOTLIGHT']) + count($principleArticles['SUCCESS STORIES']);
                    if ($spotlightCount > 0): ?>
                        <a href="#principle-3">View <?php echo $spotlightCount; ?> Athlete Spotlight Articles</a>
                    <?php else: ?>
                        <a href="#">Meet our Athlete Leaders</a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </section>

    <?php if (count($alpArticles) > 0): ?>
    <section class="alp-articles-section">
        <h2>Our Athlete Leadership Stories</h2>
        <div class="alp-afterline"></div>

        <!-- Principle 1: Leadership Development -->
        <?php if (count($principleArticles['LEADERSHIP DEVELOPMENT']) > 0): ?>
        <div class="principle-group" id="principle-1">
            <h3><i class="fas fa-lightbulb"></i> Education & Leadership Development</h3>
            <div class="articles-grid">
                <?php foreach ($principleArticles['LEADERSHIP DEVELOPMENT'] as $article): ?>
                <div class="article-card">
                    <?php if (!empty($article['image_path'])): ?>
                        <img src="<?php echo htmlspecialchars($article['image_path']); ?>" alt="<?php echo htmlspecialchars($article['title']); ?>" class="article-image" onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                        <div class="article-image" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); display: none; align-items: center; justify-content: center; color: white; font-size: 3rem;">
                            <i class="fas fa-user-graduate"></i>
                        </div>
                    <?php else: ?>
                        <div class="article-image" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); display: flex; align-items: center; justify-content: center; color: white; font-size: 3rem;">
                            <i class="fas fa-user-graduate"></i>
                        </div>
                    <?php endif; ?>
                    <div class="article-content">
                        <span class="article-category"><?php echo htmlspecialchars($article['category']); ?></span>
                        <h4 class="article-title"><?php echo htmlspecialchars($article['title']); ?></h4>
                        <p class="article-description"><?php echo htmlspecialchars(substr($article['description'], 0, 150)) . (strlen($article['description']) > 150 ? '...' : ''); ?></p>
                        <?php if (!empty($article['learn_more_link'])): ?>
                            <a href="<?php echo htmlspecialchars($article['learn_more_link']); ?>" class="article-link" target="_blank">
                                Learn More <i class="fas fa-external-link-alt"></i>
                            </a>
                        <?php endif; ?>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
        <?php endif; ?>

        <!-- Principle 2: Training Programs -->
        <?php if (count($principleArticles['TRAINING PROGRAMS']) > 0): ?>
        <div class="principle-group" id="principle-2">
            <h3><i class="fas fa-chalkboard-teacher"></i> Training & Skills Development</h3>
            <div class="articles-grid">
                <?php foreach ($principleArticles['TRAINING PROGRAMS'] as $article): ?>
                <div class="article-card">
                    <?php if (!empty($article['image_path'])): ?>
                        <img src="<?php echo htmlspecialchars($article['image_path']); ?>" alt="<?php echo htmlspecialchars($article['title']); ?>" class="article-image" onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                        <div class="article-image" style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%); display: none; align-items: center; justify-content: center; color: white; font-size: 3rem;">
                            <i class="fas fa-dumbbell"></i>
                        </div>
                    <?php else: ?>
                        <div class="article-image" style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%); display: flex; align-items: center; justify-content: center; color: white; font-size: 3rem;">
                            <i class="fas fa-dumbbell"></i>
                        </div>
                    <?php endif; ?>
                    <div class="article-content">
                        <span class="article-category"><?php echo htmlspecialchars($article['category']); ?></span>
                        <h4 class="article-title"><?php echo htmlspecialchars($article['title']); ?></h4>
                        <p class="article-description"><?php echo htmlspecialchars(substr($article['description'], 0, 150)) . (strlen($article['description']) > 150 ? '...' : ''); ?></p>
                        <?php if (!empty($article['learn_more_link'])): ?>
                            <a href="<?php echo htmlspecialchars($article['learn_more_link']); ?>" class="article-link" target="_blank">
                                Learn More <i class="fas fa-external-link-alt"></i>
                            </a>
                        <?php endif; ?>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
        <?php endif; ?>

        <!-- Principle 3: Athlete Spotlights and Success Stories -->
        <?php if (count($principleArticles['ATHLETE SPOTLIGHT']) > 0 || count($principleArticles['SUCCESS STORIES']) > 0): ?>
        <div class="principle-group" id="principle-3">
            <h3><i class="fas fa-trophy"></i> Athlete Spotlights & Success Stories</h3>
            <div class="articles-grid">
                <?php 
                $principle3Articles = array_merge($principleArticles['ATHLETE SPOTLIGHT'], $principleArticles['SUCCESS STORIES']);
                foreach ($principle3Articles as $article): ?>
                <div class="article-card">
                    <?php if (!empty($article['image_path'])): ?>
                        <img src="<?php echo htmlspecialchars($article['image_path']); ?>" alt="<?php echo htmlspecialchars($article['title']); ?>" class="article-image" onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                        <div class="article-image" style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%); display: none; align-items: center; justify-content: center; color: white; font-size: 3rem;">
                            <i class="fas fa-star"></i>
                        </div>
                    <?php else: ?>
                        <div class="article-image" style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%); display: flex; align-items: center; justify-content: center; color: white; font-size: 3rem;">
                            <i class="fas fa-star"></i>
                        </div>
                    <?php endif; ?>
                    <div class="article-content">
                        <span class="article-category"><?php echo htmlspecialchars($article['category']); ?></span>
                        <h4 class="article-title"><?php echo htmlspecialchars($article['title']); ?></h4>
                        <p class="article-description"><?php echo htmlspecialchars(substr($article['description'], 0, 150)) . (strlen($article['description']) > 150 ? '...' : ''); ?></p>
                        <?php if (!empty($article['learn_more_link'])): ?>
                            <a href="<?php echo htmlspecialchars($article['learn_more_link']); ?>" class="article-link" target="_blank">
                                Learn More <i class="fas fa-external-link-alt"></i>
                            </a>
                        <?php endif; ?>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
        <?php endif; ?>

        <!-- Community Engagement & Mentorship -->
        <?php if (count($principleArticles['COMMUNITY ENGAGEMENT']) > 0 || count($principleArticles['MENTORSHIP']) > 0): ?>
        <div class="principle-group">
            <h3><i class="fas fa-hands-helping"></i> Community Engagement & Mentorship</h3>
            <div class="articles-grid">
                <?php 
                $communityArticles = array_merge($principleArticles['COMMUNITY ENGAGEMENT'], $principleArticles['MENTORSHIP']);
                foreach ($communityArticles as $article): ?>
                <div class="article-card">
                    <?php if (!empty($article['image_path'])): ?>
                        <img src="<?php echo htmlspecialchars($article['image_path']); ?>" alt="<?php echo htmlspecialchars($article['title']); ?>" class="article-image" onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                        <div class="article-image" style="background: linear-gradient(135deg, #fa709a 0%, #fee140 100%); display: none; align-items: center; justify-content: center; color: white; font-size: 3rem;">
                            <i class="fas fa-users"></i>
                        </div>
                    <?php else: ?>
                        <div class="article-image" style="background: linear-gradient(135deg, #fa709a 0%, #fee140 100%); display: flex; align-items: center; justify-content: center; color: white; font-size: 3rem;">
                            <i class="fas fa-users"></i>
                        </div>
                    <?php endif; ?>
                    <div class="article-content">
                        <span class="article-category"><?php echo htmlspecialchars($article['category']); ?></span>
                        <h4 class="article-title"><?php echo htmlspecialchars($article['title']); ?></h4>
                        <p class="article-description"><?php echo htmlspecialchars(substr($article['description'], 0, 150)) . (strlen($article['description']) > 150 ? '...' : ''); ?></p>
                        <?php if (!empty($article['learn_more_link'])): ?>
                            <a href="<?php echo htmlspecialchars($article['learn_more_link']); ?>" class="article-link" target="_blank">
                                Learn More <i class="fas fa-external-link-alt"></i>
                            </a>
                        <?php endif; ?>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
        <?php endif; ?>
    </section>
    <?php else: ?>
    <section class="alp-articles-section">
        <h2>Our Athlete Leadership Stories</h2>
        <div class="alp-afterline"></div>
        <div class="no-articles">
            <i class="fas fa-newspaper" style="font-size: 3rem; color: #e5e7eb; margin-bottom: 16px; display: block;"></i>
            <p>No ALP articles available yet. Check back soon for inspiring stories from our athlete leaders!</p>
        </div>
    </section>
    <?php endif; ?>

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
</body>
</html>