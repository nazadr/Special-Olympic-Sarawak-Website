<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Latest News | Special Olympics Sarawak</title>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body>

    <!-- Navigation Bar (Loaded via JS) -->
    <div id="top-nav-container"></div>

    <!-- Social Media Bar (Loaded via JS) -->
    <div id="socmed-bar-container"></div>

    <!-- Chatbot (Loaded via JS) -->
    <div id="chatbot-container"></div>

    <!-- Latest News Section -->
    <main class="news-main">
      <h1 class="news-title">Latest News</h1>
      <div class="news-list" id="news-articles-container">
        <!-- News articles will be dynamically loaded here -->
        <p style="text-align: center; color: #64748b;">Loading latest news...</p>
      </div>
<style>
  /* Fixed header, footer, and social bar for consistent layout */
  .top-nav, .bottom-nav, .site-footer, .socmed-bar {
    position: fixed;
  }
  .top-nav { top: 0; left: 0; right: 0; z-index: 1000; }
  .bottom-nav { bottom: 60px; left: 50%; transform: translateX(-50%); z-index: 999; }
  .site-footer { left: 0; right: 0; bottom: 0; z-index: 1001; }
  .socmed-bar { top: 50%; right: 0; transform: translateY(-50%); z-index: 10; }
  .news-main { margin-top: 110px; margin-bottom: 120px; }
  html, body { height: auto !important; min-height: 100%; overflow-y: auto !important; overflow-x: hidden; }
</style>
    </main>

    <!-- Bottom Nav (Loaded via JS) -->
    <div id="bottom-nav-container"></div>
    <!-- Site Footer (Loaded via JS) -->
    <div id="site-footer-container"></div>
    <script src="../scripts/script.js"></script>
    <script>
      // Function to load HTML into a container
      function loadHTML(containerId, filePath) {
        fetch(filePath)
          .then(response => response.text())
          .then(data => {
            document.getElementById(containerId).innerHTML = data;
          });
      }
      // Load shared components
      loadHTML('top-nav-container', '../src/components/top-nav.html');
      loadHTML('socmed-bar-container', '../src/components/socmed-bar.html');
      loadHTML('bottom-nav-container', '../src/components/bottom-nav.html');
      loadHTML('site-footer-container', '../src/components/site-footer.html');
      loadHTML('chatbot-container', '../src/components/chatbot.html');

      // Re-attach dropup menu listeners after bottom nav loads
      fetch('../src/components/bottom-nav.html')
        .then(response => response.text())
        .then(data => {
          document.getElementById('bottom-nav-container').innerHTML = data;
          if (typeof attachDropupMenuListeners === 'function') {
            attachDropupMenuListeners();
          }
        });

        // Function to load news articles from the database
        function loadLatestNews() {
            fetch('../admin/admin_news_handler.php?action=fetch') // Use the same handler to fetch news
                .then(response => response.json())
                .then(news => {
                    const newsContainer = document.getElementById('news-articles-container');
                    newsContainer.innerHTML = ''; // Clear existing content

                    if (news.length > 0) {
                        news.forEach(article => {
                            const newsCard = document.createElement('article');
                            newsCard.classList.add('news-card');
                            newsCard.innerHTML = `
                                <div class="news-image" style="background:#eee url('${article.image_path}') center/cover no-repeat;"></div>
                                <div class="news-content">
                                    <h2 class="news-headline">${article.headline}</h2>
                                    <p class="news-date">${article.news_date}</p>
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
