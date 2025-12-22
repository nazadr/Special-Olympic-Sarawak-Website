<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Our Sponsors | Special Olympics Sarawak</title>
    <link rel="shortcut icon" href="../assets/images/master_logo_front.png">
    <link rel="stylesheet" href="../css/global-style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <style>
        /* Space for existing header */
        .header-space {
            height: 72px;
            background: transparent;
        }

        /* Space for existing footer */
        .footer-space {
            height: 100px;
            background: transparent;
        }

        /* Main content styles */
        body {
            margin: 0;
            padding: 0;
            background-color: #ffffff;
            color: #333;
            overflow-y: auto;
        }

        /* Hero section with animated background */
        .hero {
            position: relative;
            height: 300px;
            overflow: hidden;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #cc0000; /* Special Olympics red */
        }

        .hero-bg {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-image: url('https://storage.googleapis.com/workspace-0f70711f-8b4e-4d94-86f1-2a93ccde5887/image/f3bbac00-7a8a-4674-bf8c-7f162e9d6f28.png');
            background-size: cover;
            background-position: center;
            animation: zoomAnimation 15s infinite alternate;
            opacity: 0.3;
        }

        @keyframes zoomAnimation {
            0% {
                transform: scale(1);
            }
            100% {
                transform: scale(1.9);
            }
        }

        .hero-content {
            position: relative;
            z-index: 1;
            text-align: center;
            color: white;
            padding: 0 20px;
        }

        .hero h1 {
            font-size: 3rem;
            margin: 0;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);
        }

        /* Sponsors section */
        .sponsors-container {
            max-width: 1200px;
            margin: 50px auto;
            padding: 0 20px;
        }

        .sponsors-title {
            text-align: center;
            margin-bottom: 40px;
            color: #cc0000;
            font-size: 2rem;
            position: relative;
        }

        .sponsors-title:after {
            content: '';
            display: block;
            width: 80px;
            height: 4px;
            background: #cc0000;
            margin: 15px auto;
        }

        .sponsors-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            gap: 30px;
            align-items: center;
            justify-items: center;
            padding: 20px 0;
        }

        .sponsor-item {
            background: white;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 150px;
            width: 250px;
            padding: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease;
        }

        .sponsor-item:hover {
            transform: translateY(-5px);
        }

        .sponsor-item img {
            max-width: 100%;
            max-height: 100%;
            object-fit: contain;
        }

        /* Empty state when no logos are added yet */
        .empty-state {
            text-align: center;
            padding: 50px;
            color: #777;
            font-style: italic;
            grid-column: 1 / -1;
        }

        /* NEW: Chapters Column */
        .chapter-container {
            max-width: 1200px;
            margin: 60px auto;
            padding: 0 20px;
        }

        /* Chapter grid - 5 rows */
        .chapter-grid {
            display: grid;
            grid-template-columns: repeat(5, 1fr);
            gap: 20px;
            margin-top: 40px;
        }

        /* Chapter logo container */
        .chapter-logo-container {
            max-width: 224px;
            height: auto;
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        /* Chapter logo card */
        .chapter-logo {
            background: #fff;
            padding: 10px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 214px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease;
        }

        .chapter-logo:hover {
            transform: translateY(-5px);
        }

        .chapter-logo img {
            max-width: 100%;
            max-height: 214px;
            object-fit: contain;
        }

        /* Sponsor item column card */
        .sponsor-item-col {
            background: #fff;
            padding: 15px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease;
        }

        .sponsor-item-col:hover {
            transform: translateY(-5px);
        }

        .sponsor-item-col img {
            max-width: 100%;
            max-height: 80px;
            object-fit: contain;
        }

        /* Responsive */
        @media (max-width: 1024px) {
            .chapter-grid {
                grid-template-columns: repeat(3, 1fr);
            }
            .chapter-logo-container {
                max-width: 100%;
            }
        }

        @media (max-width: 768px) {
            .chapter-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 480px) {
            .chapter-grid {
                grid-template-columns: 1fr;
            }
            .chapter-logo-container {
                margin-bottom: 80px;
            }
        }

        /* Responsive adjustments */
        @media (max-width: 768px) {
            .hero h1 {
                font-size: 2rem;
            }
            
            .sponsors-grid {
                grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            }
            
            .sponsor-item {
                width: 200px;
                height: 120px;
            }

            
        }

        @media (max-width: 480px) {
            .hero {
                height: 200px;
            }
            
            .hero h1 {
                font-size: 1.5rem;
            }
            
            .sponsors-grid {
                grid-template-columns: 1fr;
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

    <!-- Hero section with animated background -->
    <section class="hero">
        <div class="hero-bg" alt="Panoramic view of athletes competing in Special Olympics events with vibrant colors representing the spirit of competition and inclusion"></div>
        <div class="hero-content">
            <h1>Our Valued Sponsors</h1>
            <p>Our partners play a major role in providing funding in support of our movement and allowing us to reach out to more families and people with intellectual disabilities.</p>
        </div>
    </section>

    <!-- Sponsors showcase -->
    <div class="sponsors-container">
        <h2 class="sponsors-title">Supporting Special Olympics Sarawak</h2>
        
        <div class="sponsors-grid">
            <!-- Logo for the sponsorships will be added here via JS -->
        </div>
    </div>

    <!-- Add this after your sponsors section -->

    <!-- Chapters Section -->
    <div class="chapter-container">
        <h2 class="sponsors-title">Special Olympics Sarawak Chapters</h2>
        <div class="chapter-grid">
            <!-- Bintulu Chapter -->
            <div class="chapter-logo-container">
                <div class="chapter-logo">
                    <img src="../assets/images/Remake/SO Sarawak Bintulu Chapter BG - Official logo.png" alt="Bintulu Chapter">
                </div>
                <!-- Logo for the sponsorships will be added here via JS -->
            </div>

            <!-- Kuching Chapter -->
            <div class="chapter-logo-container">
                <div class="chapter-logo">
                    <img src="../assets/images/Remake/SO Sarawak Kuching Chapter BG - Official logo.png" alt="Kuching Chapter">
                </div>
                <!-- Logo for the sponsorships will be added here via JS -->
            </div>

            <!-- Miri Chapter -->
            <div class="chapter-logo-container">
                <div class="chapter-logo">
                    <img src="../assets/images/Remake/SO Sarawak Miri Chapter BG - Official logo.png" alt="Miri Chapter">
                </div>
                <!-- Logo for the sponsorships will be added here via JS -->
            </div>

            <!-- Samarahan Chapter -->
            <div class="chapter-logo-container">
                <div class="chapter-logo">
                    <img src="../assets/images/Remake/SO Sarawak Samarahan Chapter BG - Official logo.png" alt="Samarahan Chapter">
                </div>
                <!-- Logo for the sponsorships will be added here via JS -->
            </div>

            <!-- Sibu Chapter -->
            <div class="chapter-logo-container">
                <div class="chapter-logo">
                    <img src="../assets/images/Remake/SO Sarawak Sibu Chapter BG - Official logo.png" alt="Sibu Chapter">
                </div>
                <!-- Logo for the sponsorships will be added here via JS -->
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            fetch('../admin/handler/admin_sponsorship_handler.php?action=fetch')
                .then(response => response.json())
                .then(data => {
                    // Fill main sponsors grid (only type 'Special Olympics Sarawak')
                    const sponsorsGrid = document.querySelector('.sponsors-grid');
                    sponsorsGrid.innerHTML = '';

                    if (data.success && data.sponsorships.length > 0) {
                        data.sponsorships
                            .filter(sponsor => sponsor.type === 'Special Olympics Sarawak')
                            .forEach(sponsor => {
                                const sponsorItem = document.createElement('div');
                                sponsorItem.className = 'sponsor-item';
                                sponsorItem.innerHTML = `<img src="${sponsor.image_path}" alt="${sponsor.type}">`;
                                sponsorsGrid.appendChild(sponsorItem);
                            });

                        // Fill chapter sponsor logos
                        const chapters = ["Bintulu", "Kuching", "Miri", "Samarahan", "Sibu"];
                        chapters.forEach(chapter => {
                            const chapterContainers = document.querySelectorAll('.chapter-logo-container');
                            chapterContainers.forEach(container => {
                                const img = container.querySelector('.chapter-logo img');
                                if (img && img.alt.toLowerCase().includes(chapter.toLowerCase())) {
                                    container.querySelectorAll('.sponsor-item-col').forEach(e => e.remove());
                                    data.sponsorships
                                        .filter(sponsor => sponsor.type.toLowerCase() === (chapter + " Chapter").toLowerCase())
                                        .forEach(sponsor => {
                                            const sponsorCol = document.createElement('div');
                                            sponsorCol.className = 'sponsor-item-col';
                                            sponsorCol.innerHTML = `<img src="${sponsor.image_path}" alt="${sponsor.type}">`;
                                            container.appendChild(sponsorCol);
                                        });
                                }
                            });
                        });
                    } else {
                        sponsorsGrid.innerHTML = '<div class="empty-state">No sponsorships found.</div>';
                    }
                })
                .catch(error => {
                    // Error fetching sponsorships
                    document.querySelector('.sponsors-grid').innerHTML = '<div class="empty-state">Failed to load sponsorships.</div>';
                });
        });
    </script>

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