<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Latest News | Special Olympics Sarawak</title>
    <link rel="shortcut icon" href="../assets/images/master_logo_front.png">
    <link rel="stylesheet" href="../css/global-style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        :root {
            --so-red: #e53935;
            --so-white: #ffffff;
            --so-dark: #1a1a1a;
            --so-gray: #666;
            --shadow-sm: 0 2px 10px rgba(229, 57, 53, 0.08);
            --shadow-md: 0 4px 20px rgba(229, 57, 53, 0.12);
            --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        /* Hero Section - Inspired by SONG 26 */
        .news-hero {
            background: linear-gradient(135deg, var(--so-red) 0%, #c62828 100%);
            min-height: 50vh;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
            color: white;
            position: relative;
            overflow: hidden;
            padding: 80px 20px 60px 20px;
        }

        .news-hero::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: 
                radial-gradient(circle at 20% 50%, rgba(255,255,255,0.08) 0%, transparent 50%),
                radial-gradient(circle at 80% 80%, rgba(255,255,255,0.06) 0%, transparent 50%);
            pointer-events: none;
        }

        .news-hero-content {
            position: relative;
            z-index: 2;
            max-width: 900px;
            animation: fadeInUp 1s ease;
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .news-hero-icon {
            font-size: 64px;
            margin-bottom: 20px;
            filter: drop-shadow(0 4px 12px rgba(0,0,0,0.2));
            animation: floatIcon 3s ease-in-out infinite;
        }

        @keyframes floatIcon {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-10px); }
        }

        .news-hero-title {
            font-size: 3.5rem;
            font-weight: 800;
            margin: 0 0 16px 0;
            text-shadow: 0 2px 20px rgba(0,0,0,0.15);
            letter-spacing: -0.5px;
        }

        .news-hero-subtitle {
            font-size: 1.25rem;
            font-weight: 300;
            margin: 0;
            opacity: 0.95;
            letter-spacing: 0.5px;
        }

        .news-hero-divider {
            width: 80px;
            height: 4px;
            background: white;
            margin: 24px auto;
            border-radius: 2px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.2);
        }

        /* Main Content */
        .news-main {
            max-width: 1200px;
            margin: 0 auto;
            padding: 60px 20px;
            min-height: 50vh;
        }

        .news-container {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(340px, 1fr));
            gap: 32px;
            margin-top: 20px;
        }

        .loading-state,
        .empty-state {
            grid-column: 1 / -1;
            text-align: center;
            padding: 60px 20px;
            color: #64748b;
            font-size: 1.1rem;
        }

        .loading-state i {
            font-size: 3rem;
            margin-bottom: 20px;
            color: var(--so-red);
            animation: spin 2s linear infinite;
        }

        @keyframes spin {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .news-hero {
                min-height: 40vh;
                padding: 60px 20px 40px 20px;
            }

            .news-hero-icon {
                font-size: 48px;
            }

            .news-hero-title {
                font-size: 2.5rem;
            }

            .news-hero-subtitle {
                font-size: 1.1rem;
            }

            .news-container {
                grid-template-columns: 1fr;
                gap: 24px;
            }

            .news-main {
                padding: 40px 20px;
            }
        }

        @media (max-width: 480px) {
            .news-hero-title {
                font-size: 2rem;
            }

            .news-hero-subtitle {
                font-size: 1rem;
            }
        }
    </style>
</head>
<body>
    <!-- Navigation Bar (Loaded via JS) -->
    <script src="../scripts/components/header.js"></script>

    <!-- Social Media Bar (Loaded via JS) -->
    <script src="../scripts/components/socmed-bar.js"></script>

    <!-- Hero Section -->
    <section class="news-hero">
        <div class="news-hero-content">
            <div class="news-hero-icon">
                <i class="fas fa-newspaper"></i>
            </div>
            <h1 class="news-hero-title">Latest News</h1>
            <div class="news-hero-divider"></div>
            <p class="news-hero-subtitle">Stay updated with the latest happenings and achievements from Special Olympics Sarawak</p>
        </div>
    </section>

    <!-- Latest News Section -->
    <main class="news-main">
      <div class="news-container" id="news-articles-container">
        <!-- News articles will be dynamically loaded here -->
        <div class="loading-state">
            <i class="fas fa-spinner"></i>
            <p>Loading latest news...</p>
        </div>
      </div>
    </main>

    <!-- Bottom Navigation -->
    <script src="../scripts/components/bottom-nav.js"></script>

    <!-- Site footer -->
    <script src="../scripts/components/site-footer.js"></script>

    <script src="../scripts/script.js"></script>
    
    <script>
        // Function to load news articles from the database
        function loadLatestNews() {
            fetch('../admin/handler/admin_news_handler.php?action=fetch')
                .then(response => response.json())
                .then(news => {
                    const newsContainer = document.getElementById('news-articles-container');
                    newsContainer.innerHTML = ''; // Clear existing content

                    if (news && news.length > 0) {
                        news.forEach(article => {
                            // Format date to dd/mm/yyyy
                            const dateObj = new Date(article.news_date);
                            const day = String(dateObj.getDate()).padStart(2, '0');
                            const month = String(dateObj.getMonth() + 1).padStart(2, '0');
                            const year = dateObj.getFullYear();
                            const formattedDate = `${day}/${month}/${year}`;
                            
                            // Fix image path - database stores paths relative to admin folder
                            let imagePath = article.image_path || '';
                            console.log('Original path from DB:', imagePath); // Debug
                            
                            // Database stores: ../assets/images/news_uploads/file.jpg (from admin folder)
                            // We're in src/ folder, same level as admin/, so path should work as-is
                            
                            const newsCard = document.createElement('article');
                            newsCard.classList.add('news-card');
                            newsCard.innerHTML = `
                                <div class="news-image" style="background: url('${imagePath}') center center / cover no-repeat, linear-gradient(135deg, #f5f5f5 0%, #e0e0e0 100%);"></div>
                                <div class="news-content">
                                    <h2 class="news-headline">${article.headline}</h2>
                                    <p class="news-date"><i class="far fa-calendar-alt"></i> ${formattedDate}</p>
                                    <p class="news-desc">${article.description}</p>
                                </div>
                            `;
                            newsContainer.appendChild(newsCard);
                        });
                    } else {
                        newsContainer.innerHTML = `
                            <div class="empty-state">
                                <i class="far fa-newspaper" style="font-size: 3rem; margin-bottom: 20px; color: #cbd5e1; display: block;"></i>
                                <p>No news articles available at the moment.</p>
                                <p style="font-size: 0.95rem; color: #94a3b8; margin-top: 8px;">Check back soon for updates!</p>
                            </div>
                        `;
                    }
                })
                .catch(error => {
                    console.error('Error loading news:', error);
                    document.getElementById('news-articles-container').innerHTML = `
                        <div class="empty-state">
                            <i class="fas fa-exclamation-triangle" style="font-size: 3rem; margin-bottom: 20px; color: #ef4444; display: block;"></i>
                            <p style="color: #ef4444;">Failed to load news articles.</p>
                            <p style="font-size: 0.95rem; color: #94a3b8; margin-top: 8px;">Please try refreshing the page.</p>
                        </div>
                    `;
                });
        }

        // Load news articles when the page loads
        document.addEventListener('DOMContentLoaded', loadLatestNews);
    </script>
</body>
</html>
