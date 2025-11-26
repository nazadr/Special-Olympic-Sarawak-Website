document.addEventListener('DOMContentLoaded', function() {
    const existingNewsArticlesContainer = document.getElementById('existingNewsArticles');
    const addNewsForm = document.getElementById('addNewsForm');
    const newsImageInput = document.getElementById('newsImage');
    const newsImagePreview = document.getElementById('newsImagePreview');
    const newsImageStatus = document.getElementById('newsImageStatus');
    const deleteNewsImageBtn = document.getElementById('deleteNewsImageBtn');

    // Load News Articles
    function loadNewsArticles() {
        fetch('handler/admin_news_handler.php?action=fetch')
            .then(response => response.json())
            .then(news => {
                existingNewsArticlesContainer.innerHTML = '';
                if (news.length > 0) {
                    news.forEach(article => {
                        const newsItem = document.createElement('div');
                        newsItem.classList.add('news-item-admin');
                        newsItem.innerHTML = `
                            <img src="${article.image_path}" alt="${article.headline}" class="news-item-admin-image">
                            <div class="news-item-admin-content">
                                <h4 class="news-item-admin-headline">${article.headline}</h4>
                                <p class="news-item-admin-date">${article.news_date}</p>
                                <p class="news-item-admin-desc">${article.description}</p>
                            </div>
                            <div class="news-item-admin-actions">
                                <button class="edit-btn" data-id="${article.id}"><i class="fa-solid fa-pencil"></i></button>
                                <button class="delete-btn" data-id="${article.id}"><i class="fa-solid fa-trash"></i></button>
                            </div>
                        `;
                        existingNewsArticlesContainer.appendChild(newsItem);
                    });

                    // Edit button
                    document.querySelectorAll('#existingNewsArticles .edit-btn').forEach(button => {
                        button.addEventListener('click', function() {
                            const newsId = this.getAttribute('data-id');
                            alert('Edit news item with ID: ' + newsId);
                            // Implement edit logic here
                        });
                    });

                    // Delete button
                    document.querySelectorAll('#existingNewsArticles .delete-btn').forEach(button => {
                        button.addEventListener('click', function() {
                            const newsId = this.getAttribute('data-id');
                            if (confirm('Are you sure you want to delete this news article?')) {
                                fetch('handler/admin_news_handler.php', {
                                    method: 'POST',
                                    headers: {
                                        'Content-Type': 'application/x-www-form-urlencoded',
                                    },
                                    body: `action=delete&id=${newsId}`
                                })
                                .then(response => response.json())
                                .then(data => {
                                    if (data.success) {
                                        alert('News article deleted successfully!');
                                        loadNewsArticles();
                                    } else {
                                        alert('Error deleting news article: ' + data.message);
                                    }
                                })
                                .catch(error => console.error('Error:', error));
                            }
                        });
                    });

                } else {
                    existingNewsArticlesContainer.innerHTML = '<p style="text-align: center; color: #64748b;">No news articles found.</p>';
                }
            })
            .catch(error => {
                console.error('Error loading news articles:', error);
                existingNewsArticlesContainer.innerHTML = '<p style="text-align: center; color: #ef4444;">Failed to load news articles.</p>';
            });
    }

    // Add News Form Submission
    if (addNewsForm) {
        addNewsForm.addEventListener('submit', function(e) {
            e.preventDefault();
            const formData = new FormData(this);
            formData.append('action', 'add');
            fetch('handler/admin_news_handler.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('News article added successfully!');
                    addNewsForm.reset();
                    newsImagePreview.style.display = 'none';
                    newsImageStatus.textContent = 'No file selected.';
                    if (deleteNewsImageBtn) deleteNewsImageBtn.style.display = 'none';
                    loadNewsArticles();
                } else {
                    alert('Error adding news article: ' + data.message);
                }
            })
            .catch(error => console.error('Error:', error));
        });
    }

    // News image preview and delete functionality
    if (newsImageInput) {
        newsImageInput.addEventListener('change', function() {
            if (this.files && this.files[0]) {
                newsImageStatus.textContent = this.files[0].name;
                newsImageStatus.style.display = '';
                const reader = new FileReader();
                reader.onload = function(e) {
                    newsImagePreview.src = e.target.result;
                    newsImagePreview.style.display = 'block';
                };
                reader.readAsDataURL(this.files[0]);
                if (deleteNewsImageBtn) deleteNewsImageBtn.style.display = 'inline-block';
            } else {
                newsImageStatus.textContent = 'No file selected.';
                newsImagePreview.src = '';
                newsImagePreview.style.display = 'none';
                if (deleteNewsImageBtn) deleteNewsImageBtn.style.display = 'none';
            }
        });
    }

    if (deleteNewsImageBtn) {
        deleteNewsImageBtn.style.display = 'none';
        deleteNewsImageBtn.addEventListener('click', function() {
            newsImageInput.value = '';
            newsImagePreview.src = '';
            newsImagePreview.style.display = 'none';
            newsImageStatus.textContent = 'No file selected.';
            newsImageStatus.style.display = '';
            deleteNewsImageBtn.style.display = 'none';
        });
    }

    // Initial load
    loadNewsArticles();
});