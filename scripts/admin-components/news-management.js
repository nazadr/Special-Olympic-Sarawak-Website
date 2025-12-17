/**
 * News Management Script
 * 
 * Notification System:
 * - Uses global window.showNotification() from admin_panel_soswk.php
 * - Supports types: 'success', 'error', 'warning', 'info'
 * - Auto-dismisses after 3 seconds with smooth animations
 * - Styled with green gradient for success, red for errors
 */

function showNotification(message, type = 'success') {
    if (typeof window.showNotification === 'function') {
        window.showNotification(message, type);
    } else {
        console.warn('⚠️ Global showNotification not found, using fallback');
        const notification = document.createElement('div');
        notification.style.cssText = `
            position: fixed;
            top: 20px;
            right: 20px;
            min-width: 300px;
            padding: 16px 20px;
            border-radius: 12px;
            background: ${type === 'success' ? 'linear-gradient(135deg, #10b981 0%, #059669 100%)' : 'linear-gradient(135deg, #ef4444 0%, #dc2626 100%)'};
            color: white;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
            z-index: 10000;
            font-family: 'Inter', sans-serif;
            font-size: 14px;
            animation: slideIn 0.3s ease-out;
        `;
        notification.textContent = message;
        document.body.appendChild(notification);
        setTimeout(() => {
            notification.style.animation = 'slideOut 0.3s ease-in';
            setTimeout(() => notification.remove(), 300);
        }, 3000);
    }
}

document.addEventListener('DOMContentLoaded', function() {
    const existingNewsArticlesContainer = document.getElementById('existingNewsArticles');
    
    let allNews = [];
    let currentView = 'grid';

    // Load news articles on page load
    loadNewsArticles();

    // View Toggle
    document.querySelectorAll('.news-view-toggle .view-toggle-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            document.querySelectorAll('.news-view-toggle .view-toggle-btn').forEach(b => b.classList.remove('active'));
            this.classList.add('active');
            currentView = this.getAttribute('data-view');
            renderNews(allNews);
        });
    });

    // Filter and Search Listeners
    document.getElementById('filterNewsDate')?.addEventListener('change', filterAndSortNews);
    document.getElementById('sortNews')?.addEventListener('change', filterAndSortNews);
    document.getElementById('searchNews')?.addEventListener('input', filterAndSortNews);

    function loadNewsArticles() {
        fetch('handler/admin_news_handler.php?action=fetch')
            .then(response => response.json())
            .then(news => {
                allNews = Array.isArray(news) ? news : [];
                updateStatistics();
                renderNews(allNews);
            })
            .catch(error => {
                console.error('Error:', error);
                existingNewsArticlesContainer.innerHTML = `
                    <div class="news-empty-state">
                        <i class="fas fa-exclamation-triangle"></i>
                        <h4>Failed to Load News</h4>
                        <p>${error.message}</p>
                    </div>
                `;
            });
    }

    function updateStatistics() {
        const total = allNews.length;
        document.getElementById('totalNewsCount').textContent = total;

        const now = new Date();
        const thisMonth = allNews.filter(n => {
            const newsDate = new Date(n.news_date);
            return newsDate.getMonth() === now.getMonth() && newsDate.getFullYear() === now.getFullYear();
        }).length;
        document.getElementById('thisMonthNewsCount').textContent = thisMonth;

        const last7Days = allNews.filter(n => {
            const newsDate = new Date(n.news_date);
            const diffTime = Math.abs(now - newsDate);
            const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));
            return diffDays <= 7;
        }).length;
        document.getElementById('recentNewsCount').textContent = last7Days;

        if (allNews.length > 0) {
            const latest = allNews.sort((a, b) => new Date(b.news_date) - new Date(a.news_date))[0];
            const latestDate = new Date(latest.news_date);
            const diffDays = Math.floor((now - latestDate) / (1000 * 60 * 60 * 24));
            if (diffDays === 0) document.getElementById('latestNewsDate').textContent = 'Today';
            else if (diffDays === 1) document.getElementById('latestNewsDate').textContent = 'Yesterday';
            else document.getElementById('latestNewsDate').textContent = `${diffDays} days ago`;
        }
    }

    function renderNews(news) {
        existingNewsArticlesContainer.innerHTML = '';
        document.getElementById('displayedNewsCount').textContent = news.length;
        
        if (news.length === 0) {
            showEmptyState();
            return;
        }

        existingNewsArticlesContainer.className = currentView === 'grid' ? 'news-grid' : 'news-list';

        news.forEach(article => {
            const newsCard = createNewsCard(article);
            existingNewsArticlesContainer.appendChild(newsCard);
        });

        attachEventListeners();
    }

    function createNewsCard(article) {
        const card = document.createElement('div');
        let imagePath = article.image_path;
        if (imagePath && imagePath.includes('/')) {
            let filename = imagePath.split('/').pop();
            imagePath = '../assets/images/news_uploads/' + filename;
        } else {
            imagePath = 'https://via.placeholder.com/400x200?text=No+Image';
        }

        const newsDate = new Date(article.news_date);
        const formattedDate = newsDate.toLocaleDateString('en-US', { year: 'numeric', month: 'short', day: 'numeric' });

        if (currentView === 'grid') {
            card.classList.add('news-card');
            card.innerHTML = `
                <img src="${imagePath}" alt="${article.headline}" class="news-card-image" onerror="this.src='https://via.placeholder.com/400x200?text=No+Image';">
                <div class="news-card-content">
                    <h4 class="news-card-title">${article.headline}</h4>
                    <div class="news-card-meta">
                        <div><i class="fas fa-calendar"></i> ${formattedDate}</div>
                    </div>
                    <p class="news-card-excerpt">${article.description}</p>
                    <div class="news-card-actions">
                        <button class="news-action-btn edit" data-id="${article.id}">
                            <i class="fas fa-edit"></i> Edit
                        </button>
                        <button class="news-action-btn delete" data-id="${article.id}">
                            <i class="fas fa-trash"></i> Delete
                        </button>
                    </div>
                </div>
            `;
        } else {
            card.classList.add('news-item');
            card.innerHTML = `
                <img src="${imagePath}" alt="${article.headline}" class="news-item-image" onerror="this.src='https://via.placeholder.com/140x140?text=No+Image';">
                <div class="news-item-content">
                    <div class="news-item-header">
                        <h4 class="news-item-title">${article.headline}</h4>
                    </div>
                    <div class="news-item-meta">
                        <div><i class="fas fa-calendar"></i> ${formattedDate}</div>
                    </div>
                    <p class="news-item-excerpt">${article.description}</p>
                    <div class="news-item-actions">
                        <button class="news-action-btn edit" data-id="${article.id}">
                            <i class="fas fa-edit"></i> Edit
                        </button>
                        <button class="news-action-btn delete" data-id="${article.id}">
                            <i class="fas fa-trash"></i> Delete
                        </button>
                    </div>
                </div>
            `;
        }

        return card;
    }

    function showEmptyState() {
        existingNewsArticlesContainer.className = 'news-grid';
        existingNewsArticlesContainer.innerHTML = `
            <div class="news-empty-state">
                <i class="fas fa-newspaper"></i>
                <h4>No News Articles Found</h4>
                <p>Start by adding your first news article</p>
            </div>
        `;
    }

    function filterAndSortNews() {
        const dateFilter = document.getElementById('filterNewsDate').value;
        const sortOrder = document.getElementById('sortNews').value;
        const searchTerm = document.getElementById('searchNews').value.toLowerCase();

        let filtered = [...allNews];
        const now = new Date();

        // Apply date filter
        if (dateFilter !== 'all') {
            filtered = filtered.filter(n => {
                const newsDate = new Date(n.news_date);
                switch(dateFilter) {
                    case 'today':
                        return newsDate.toDateString() === now.toDateString();
                    case 'week':
                        const weekAgo = new Date(now.getTime() - 7 * 24 * 60 * 60 * 1000);
                        return newsDate >= weekAgo;
                    case 'month':
                        return newsDate.getMonth() === now.getMonth() && newsDate.getFullYear() === now.getFullYear();
                    case 'year':
                        return newsDate.getFullYear() === now.getFullYear();
                    default:
                        return true;
                }
            });
        }

        // Apply search
        if (searchTerm) {
            filtered = filtered.filter(n => 
                n.headline.toLowerCase().includes(searchTerm) ||
                n.description.toLowerCase().includes(searchTerm)
            );
        }

        // Apply sorting
        filtered.sort((a, b) => {
            switch(sortOrder) {
                case 'date_desc':
                    return new Date(b.news_date) - new Date(a.news_date);
                case 'date_asc':
                    return new Date(a.news_date) - new Date(b.news_date);
                case 'title_asc':
                    return a.headline.localeCompare(b.headline);
                case 'title_desc':
                    return b.headline.localeCompare(a.headline);
                default:
                    return 0;
            }
        });

        renderNews(filtered);
    }

    function attachEventListeners() {
        document.querySelectorAll('.news-action-btn.edit').forEach(button => {
            button.addEventListener('click', function() {
                const newsId = this.getAttribute('data-id');
                fetch(`handler/admin_news_handler.php?action=fetch_single&id=${newsId}`)
                    .then(response => response.json())
                    .then(newsData => {
                        if (newsData.success && typeof openNewsModalForEdit === 'function') {
                            openNewsModalForEdit(newsData.data);
                        } else {
                            showNotification('Error loading news data', 'error');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        showNotification('Failed to load news article data', 'error');
                    });
            });
        });

        document.querySelectorAll('.news-action-btn.delete').forEach(button => {
            button.addEventListener('click', function() {
                const newsId = this.getAttribute('data-id');
                const newsTitle = this.closest(currentView === 'grid' ? '.news-card' : '.news-item')
                    .querySelector(currentView === 'grid' ? '.news-card-title' : '.news-item-title').textContent;
                
                if (confirm(`Are you sure you want to delete "${newsTitle}"?`)) {
                    fetch('handler/admin_news_handler.php', {
                        method: 'POST',
                        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                        body: `action=delete&id=${newsId}`
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            showNotification('News article deleted successfully!', 'success');
                            loadNewsArticles();
                        } else {
                            showNotification('Error deleting news article: ' + data.message, 'error');
                        }
                    })
                    .catch(error => console.error('Error:', error));
                }
            });
        });
    }

    // Make loadNewsArticles globally accessible
    window.loadNewsArticles = loadNewsArticles;
});

// Modal functionality
function openModal() {
    const addNewsModal = document.getElementById('addNewsModal');
    if (addNewsModal) {
        addNewsModal.classList.add('show');
        addNewsModal.style.display = 'block';
        document.body.style.overflow = 'hidden';
    }
}

function closeModal() {
    const addNewsModal = document.getElementById('addNewsModal');
    const addNewsForm = document.getElementById('addNewsForm');
    const newsImagePreview = document.getElementById('newsImagePreview');
    const newsImageStatus = document.getElementById('newsImageStatus');
    const deleteNewsImageBtn = document.getElementById('deleteNewsImageBtn');
    
    if (addNewsModal) {
        addNewsModal.classList.remove('show');
        addNewsModal.style.display = 'none';
        document.body.style.overflow = '';
        // Reset form
        if (addNewsForm) {
            addNewsForm.reset();
            if (newsImagePreview) newsImagePreview.style.display = 'none';
            if (newsImageStatus) newsImageStatus.textContent = 'No file selected';
            if (deleteNewsImageBtn) deleteNewsImageBtn.style.display = 'none';
        }
    }
}

// Initialize modal event listeners
document.addEventListener('DOMContentLoaded', function() {
    const addNewsBtn = document.getElementById('addNewsBtn');
    const modalClose = document.querySelector('#addNewsModal .close-modal');
    const cancelBtn = document.getElementById('cancelNewsBtn');
    const addNewsModal = document.getElementById('addNewsModal');
    const newsImageBtn = document.getElementById('newsImageBtn');
    const newsImageInput = document.getElementById('newsImageInput');
    const addNewsForm = document.getElementById('addNewsForm');

    if (addNewsBtn) {
        addNewsBtn.addEventListener('click', function(e) {
            e.preventDefault();
            openModal();
        });
    }

    if (modalClose) {
        modalClose.addEventListener('click', closeModal);
    }

    if (cancelBtn) {
        cancelBtn.addEventListener('click', closeModal);
    }

    // Close modal when clicking backdrop
    if (addNewsModal) {
        addNewsModal.addEventListener('click', function(e) {
            if (e.target === addNewsModal || e.target.classList.contains('news-modal-backdrop')) {
                closeModal();
            }
        });
    }

    // File upload button
    if (newsImageBtn && newsImageInput) {
        newsImageBtn.addEventListener('click', function() {
            newsImageInput.click();
        });
    }

    // Add/Edit News Form Submission
    if (addNewsForm) {
        addNewsForm.addEventListener('submit', function(e) {
            e.preventDefault();
            const formData = new FormData(this);
            
            // Determine if we're adding or editing based on newsId field
            const newsId = document.getElementById('newsId').value;
            const action = newsId ? 'edit' : 'add';
            formData.append('action', action);
            
            // For edit mode, ensure we send the current image path correctly
            if (action === 'edit') {
                const currentImage = document.getElementById('currentNewsImage').value;
                if (currentImage) {
                    formData.append('currentImagePath', currentImage);
                }
            }
            
            fetch('handler/admin_news_handler.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    const message = action === 'edit' ? 'News article updated successfully!' : 'News article added successfully!';
                    showNotification(message, 'success');
                    resetNewsModal();
                    closeModal();
                    loadNewsArticles();
                } else {
                    showNotification('Error saving news article: ' + data.message, 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showNotification('An error occurred while saving the news article.', 'error');
            });
        });
    }

    // News image preview and delete functionality
    if (newsImageInput) {
        newsImageInput.addEventListener('change', function() {
            const previewContainer = document.getElementById('newsImagePreview');
            const previewImg = document.querySelector('#newsImagePreview img');
            
            if (this.files && this.files[0]) {
                if (newsImageStatus) newsImageStatus.textContent = this.files[0].name;
                const reader = new FileReader();
                reader.onload = function(e) {
                    if (previewImg) {
                        previewImg.src = e.target.result;
                        previewContainer.style.display = 'block';
                    }
                };
                reader.readAsDataURL(this.files[0]);
                if (deleteNewsImageBtn) deleteNewsImageBtn.style.display = 'inline-block';
            } else {
                if (newsImageStatus) newsImageStatus.textContent = 'No file selected';
                if (previewImg) previewImg.src = '';
                if (previewContainer) previewContainer.style.display = 'none';
                if (deleteNewsImageBtn) deleteNewsImageBtn.style.display = 'none';
            }
        });
    }

    if (deleteNewsImageBtn) {
        deleteNewsImageBtn.style.display = 'none';
        deleteNewsImageBtn.addEventListener('click', function() {
            if (newsImageInput) newsImageInput.value = '';
            const previewContainer = document.getElementById('newsImagePreview');
            const previewImg = document.querySelector('#newsImagePreview img');
            if (previewImg) previewImg.src = '';
            if (previewContainer) previewContainer.style.display = 'none';
            if (newsImageStatus) newsImageStatus.textContent = 'No file selected';
            deleteNewsImageBtn.style.display = 'none';
        });
    }

    // Function to open modal in edit mode
    window.openNewsModalForEdit = function(newsData) {
        const modal = document.getElementById('addNewsModal');
        if (!modal) {
            console.error('News modal not found!');
            return;
        }
        
        // Set edit mode flag
        modal.setAttribute('data-mode', 'edit');
        
        // Update modal title and button text
        const modalTitle = modal.querySelector('.news-modal-header h3');
        const submitBtn = modal.querySelector('.btn-submit');
        
        if (modalTitle) modalTitle.textContent = 'Edit News Article';
        if (submitBtn) submitBtn.textContent = 'Update Article';
        
        // Fill form with current data
        document.getElementById('newsId').value = newsData.id || '';
        document.getElementById('newsHeadline').value = newsData.headline || '';
        document.getElementById('newsDate').value = newsData.news_date || '';
        document.getElementById('newsDescription').value = newsData.description || '';
        
        // Handle image preview
        const preview = document.getElementById('newsImagePreview');
        const previewImg = preview?.querySelector('img');
        const status = document.getElementById('newsImageStatus');
        const deleteBtn = document.getElementById('deleteNewsImageBtn');
        
        if (newsData.image_path) {
            document.getElementById('currentNewsImage').value = newsData.image_path;
            
            if (previewImg) {
                previewImg.src = newsData.image_path;
                preview.style.display = 'block';
            }
            if (status) status.textContent = 'Current image loaded. Choose new file to replace.';
            if (deleteBtn) deleteBtn.style.display = 'inline-block';
        } else {
            if (status) status.textContent = 'No image. Choose file to add.';
            if (deleteBtn) deleteBtn.style.display = 'none';
            if (preview) preview.style.display = 'none';
        }
        
        // Open the modal
        openModal();
        
        console.log('News modal opened for editing:', newsData);
    };
    
    // Function to reset modal to add mode
    window.resetNewsModal = function() {
        const modal = document.getElementById('addNewsModal');
        if (!modal) return;
        
        // Remove edit mode flag
        modal.removeAttribute('data-mode');
        
        // Reset modal title and button text
        const modalTitle = modal.querySelector('.news-modal-header h3');
        const submitBtn = modal.querySelector('.btn-submit');
        
        if (modalTitle) modalTitle.textContent = 'Add New News Article';
        if (submitBtn) submitBtn.textContent = 'Add News Article';
        
        // Reset form
        if (addNewsForm) addNewsForm.reset();
        
        // Clear hidden fields
        document.getElementById('newsId').value = '';
        document.getElementById('currentNewsImage').value = '';
        
        // Reset file upload display
        if (newsImagePreview) newsImagePreview.style.display = 'none';
        if (newsImageStatus) newsImageStatus.textContent = 'No file selected';
        if (deleteNewsImageBtn) deleteNewsImageBtn.style.display = 'none';
    };
    
    // Ensure modal resets when opening for add
    if (addNewsBtn) {
        const originalClick = addNewsBtn.onclick;
        addNewsBtn.onclick = function(e) {
            resetNewsModal();
            if (originalClick) originalClick.call(this, e);
        };
    }

    // Initial load
    loadNewsArticles();
});