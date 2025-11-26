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
      .news-main {
        height: 75vh;
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

    <!-- Latest News Section -->
    <main class="news-main">
      <h1 class="news-title">Latest News</h1>
      <div class="news-list" id="news-articles-container">
        <!-- News articles will be dynamically loaded here -->
        <p style="text-align: center; color: #64748b;">Loading latest news...</p>
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
            fetch('../admin/handler/admin_news_handler.php?action=fetch') // Use the same handler to fetch news
                .then(response => response.json())
                .then(news => {
                    const newsContainer = document.getElementById('news-articles-container');
                    newsContainer.innerHTML = ''; // Clear existing content

                    if (news.length > 0) {
                        news.forEach(article => {
                            // Format date to dd/mm/yyyy
                            const dateObj = new Date(article.news_date);
                            const day = String(dateObj.getDate()).padStart(2, '0');
                            const month = String(dateObj.getMonth() + 1).padStart(2, '0');
                            const year = dateObj.getFullYear();
                            const formattedDate = `${day}/${month}/${year}`;
                            
                            const newsCard = document.createElement('article');
                            newsCard.classList.add('news-card');
                            newsCard.innerHTML = `
                                <div class="news-image" style="background:#eee url('${article.image_path}') center/cover no-repeat;"></div>
                                <div class="news-content">
                                    <h2 class="news-headline">${article.headline}</h2>
                                    <p class="news-date">${formattedDate}</p>
                                    <p class="news-desc">${article.description}</p>
                                </div>
                            `;
                            newsContainer.appendChild(newsCard);
                        });
                    } else {
                        newsContainer.innerHTML = '<p style="text-align: center; color: #64748b;">No news articles available at the moment.</p>';
                    }
                })
                .catch(error => {
                    console.error('Error loading latest news:', error);
                    document.getElementById('news-articles-container').innerHTML = '<p style="text-align: center; color: #ef4444;">Failed to load news articles.</p>';
                });
        }

        // Load news articles when the page loads
        document.addEventListener('DOMContentLoaded', loadLatestNews);
    </script>
</body>
</html>
