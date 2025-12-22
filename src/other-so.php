<?php
/**
 * ============================================================================
 * Other Special Olympics Page
 * ============================================================================
 * 
 * Purpose: Display Special Olympics organizations (International, Malaysia, States)
 * Data Source: other_special_olympics table
 * 
 * Author: SO Sarawak Web Team
 * Updated: December 17, 2025
 * ============================================================================
 */

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "so_sarawak_db";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Database connection failed. Please try again later.");
}

$conn->set_charset("utf8mb4");

// Fetch organizations grouped by category
$international = [];
$malaysia = [];
$states = [];

$sql = "SELECT * FROM other_special_olympics WHERE is_active = 1 ORDER BY category, display_order ASC";
$result = $conn->query($sql);

if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        if ($row['category'] === 'international') {
            $international[] = $row;
        } elseif ($row['category'] === 'malaysia') {
            $malaysia[] = $row;
        } elseif ($row['category'] === 'state') {
            $states[] = $row;
        }
    }
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Other Special Olympics | Special Olympics Sarawak</title>
    <link rel="shortcut icon" href="../assets/images/master_logo_front.png">
    <!--Local and Global CSS---->
    <link rel="stylesheet" href="../css/global-style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <style>
        .other-so-hero {
            background: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)), url('../assets/images/pexels-pixabay-41949.jpg') center/cover no-repeat;
            height: 60vh;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
            color: white;
            position: relative;
        }

        .other-so-hero h1 {
            font-size: 3.5rem;
            margin-bottom: 20px;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);
        }
        .other-so-hero p {
            font-size: 1.2rem;
            max-width: 800px;
            margin: 0 auto 30px;
            padding: 0 20px;
        }

        /* Container for all cards */
        .other-so-container {
            max-width: 1280px;
            margin: 50px auto;
            padding: 0 20px;
        }

        .other-so-container h2 {
            text-align: center;
            margin-bottom: 40px;
            color: #cc0000;
            font-size: 2rem;
            position: relative;
        }

        /* Duo grid for International and Malaysia cards */
        .other-so-grid-duo {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 30px;
            margin-bottom: 40px;
            align-items: center;
            justify-items: center;
        }

        .other-so-card-duo {
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 4px 16px rgba(0,0,0,0.08);
            display: flex;
            align-items: center;
            justify-content: center;
            height: 260px;
            width: 530px;
            padding: 40px;
            transition: transform 0.3s;
        }
        .other-so-card-duo:hover {
            transform: translateY(-6px) scale(1.03);
        }
        .other-so-card-duo img {
            max-width: 100%;
            max-height: 160px;
            object-fit: contain;
        }
        .other-so-card-link {
            display: block;
            text-decoration: none;
        }
        .other-so-card-link .other-so-card-duo, .other-so-card-link .other-so-card {
            cursor: pointer;
        }

        /* Grid for state cards */
        .other-so-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 30px;
            align-items: stretch;
            justify-items: center;
            padding: 20px 0;
        }

        /* Card style for states */
        .other-so-card-desktop {
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.08);
            display: flex;
            align-items: center;
            justify-content: center;
            height: 150px;
            width: 250px;
            padding: 20px;
            transition: transform 0.3s;
        }
        .other-so-card-desktop:hover {
            transform: translateY(-4px) scale(1.03);
        }
        .other-so-card-desktop img {
            max-width: 100%;
            max-height: 170px;
            object-fit: contain;
        }

        .other-so-card-mobile {
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.08);
            display: none;
            align-items: center;
            justify-content: center;
            height: 150px;
            width: 250px;
            padding: 20px;
            transition: transform 0.3s;
        }
        .other-so-card-mobile:hover {
            transform: translateY(-4px) scale(1.03);
        }
        .other-so-card-mobile img {
            max-width: 100%;
            max-height: 90px;
            object-fit: contain;
        }

        /* Responsive adjustments */
        @media (max-width: 1320px) {
            .other-so-grid {
                grid-template-columns: repeat(3, 1fr);
            }
        }
        @media (max-width: 1024px) {
            .other-so-grid-duo {
                grid-template-columns: 1fr;
                gap: 30px;
            }
            .other-so-card-duo {
                width: 90%;
                margin: 0 auto;
            }
            .other-so-grid {
                grid-template-columns: repeat(2, 1fr);
            }
            .other-so-card {
                width: 90%;
                margin: 0 auto;
            }
        }
        @media (max-width: 768px) {
            .other-so-hero h1 {
                font-size: 2.5rem;
            }
            .other-so-hero p {
                font-size: 1rem;
            }
        }
        @media (max-width: 600px) {
            .other-so-grid {
                grid-template-columns: 1fr;
                gap: 20px;
            }
            .other-so-card {
                height: 120px;
                padding: 12px;
            }
            .other-so-card-duo {
                height: 140px;
                padding: 20px;
            }
            .other-so-card-mobile {
                display: flex;
            }
            .other-so-card-desktop {
                display: none;
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

    <section class="other-so-hero">
        <h1>Special Olympics Organization</h1>
        <p>Explore the wider Special Olympics network, including Special Olympics International, Special Olympics Malaysia, and programs across other states and federal territories in Malaysia.</p>
    </section>

    <section class="other-so-section">
        <div class="other-so-container">
            <?php if (!empty($malaysia)): ?>
            <div style="text-align:center;">
                <h2>Special Olympics Malaysia</h2>
                <div class="so-afterline-60w-mb40" style="margin-left:auto; margin-right:auto;"></div>
                <div class="other-so-grid-duo" style="display:inline-grid;">
                    <?php
                    // Display Malaysia organizations only
                    foreach ($malaysia as $org):
                        $url = $org['website_url'] ?: '#';
                        $logo = $org['logo_desktop'] ?: '../assets/images/placeholder.png';
                        $name = htmlspecialchars($org['name']);
                    ?>
                    <a href="<?php echo htmlspecialchars($url); ?>" class="other-so-card-link" 
                       <?php if ($url !== '#'): ?>target="_blank" rel="noopener noreferrer"<?php endif; ?>>
                        <div class="other-so-card-duo">
                            <img src="<?php echo htmlspecialchars($logo); ?>" 
                                 alt="<?php echo $name; ?>"
                                 onerror="this.src='../assets/images/placeholder.png'">
                        </div>
                    </a>
                    <?php endforeach; ?>
                </div>
            </div>
            <?php endif; ?>

            <?php if (!empty($states)): ?>
            <h2>Special Olympics in other States and Federal Territories</h2>
            <div class="so-afterline-60w-mb40"></div>
            <div class="other-so-grid">
                <?php foreach ($states as $org):
                    $url = $org['website_url'] ?: '#';
                    $logoDesktop = $org['logo_desktop'] ?: '../assets/images/placeholder.png';
                    $logoMobile = $org['logo_mobile'] ?: $logoDesktop;
                    $name = htmlspecialchars($org['name']);
                ?>
                <a href="<?php echo htmlspecialchars($url); ?>" class="other-so-card-link"
                   <?php if ($url !== '#'): ?>target="_blank" rel="noopener noreferrer"<?php endif; ?>>
                    <div class="other-so-card-desktop">
                        <img src="<?php echo htmlspecialchars($logoDesktop); ?>" 
                             alt="<?php echo $name; ?>"
                             onerror="this.src='../assets/images/placeholder.png'">
                    </div>
                    <div class="other-so-card-mobile">
                        <img src="<?php echo htmlspecialchars($logoMobile); ?>" 
                             alt="<?php echo $name; ?>"
                             onerror="this.src='../assets/images/placeholder.png'">
                    </div>
                </a>
                <?php endforeach; ?>
            </div>
            <?php endif; ?>

            <?php if (empty($international) && empty($malaysia) && empty($states)): ?>
            <div style="text-align: center; padding: 80px 20px; color: #666;">
                <i class="fas fa-globe" style="font-size: 64px; opacity: 0.3; margin-bottom: 20px;"></i>
                <p style="font-size: 18px;">No organizations available at the moment.</p>
            </div>
            <?php endif; ?>
        </div>
    </section>

    <!-- Bottom Navigation -->
    <script src="../scripts/components/bottom-nav.js"></script>

    <!-- Site footer -->
    <script src="../scripts/components/site-footer.js"></script>

    <script src="../scripts/script.js"></script>
    <script src="../scripts/song-bubble.js"></script>
</body>
</html>
