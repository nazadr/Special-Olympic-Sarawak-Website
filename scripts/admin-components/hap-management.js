// HAP (Healthy Athletes Program) Management JavaScript for Admin Panel
document.addEventListener('DOMContentLoaded', function() {
    const existingHapContainer = document.getElementById('existingHap');
    const hapForm = document.getElementById('hapForm');
    const hapImageInput = document.getElementById('hapImage');
    const hapImagePreview = document.getElementById('hapImagePreview');
    const hapImageStatus = document.getElementById('hapImageStatus');
    const deleteHapImageBtn = document.getElementById('deleteHapImageBtn');
    
    let sortable;

    // Load HAP articles on page load
    loadHapArticles();

    // Initialize sortable functionality
    function initSortable() {
        if (sortable) {
            sortable.destroy();
        }
        
        if (existingHapContainer) {
            sortable = Sortable.create(existingHapContainer, {
                animation: 150,
                ghostClass: 'sortable-ghost',
                chosenClass: 'sortable-chosen',
                dragClass: 'sortable-drag',
                onEnd: function(evt) {
                    updateHapOrder();
                }
            });
        }
    }

    function loadHapArticles() {
        fetch('handler/admin_hap_handler.php?action=fetch')
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    existingHapContainer.innerHTML = '';
                    
                    // Update statistics
                    updateHapStatistics(data.articles || []);
                    
                    if (data.articles && data.articles.length > 0) {
                        // Remove empty state
                        const emptyState = existingHapContainer.querySelector('.hap-empty-state');
                        if (emptyState) emptyState.remove();
                        
                        data.articles.forEach(article => {
                            const articleItem = document.createElement('div');
                            articleItem.classList.add('hap-item-admin');
                            articleItem.setAttribute('data-id', article.id);
                            
                            // Handle image path
                            let imagePath = article.image_path;
                            if (!imagePath || imagePath === 'null') {
                                imagePath = 'data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iNDAwIiBoZWlnaHQ9IjMwMCIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj48cmVjdCB3aWR0aD0iNDAwIiBoZWlnaHQ9IjMwMCIgZmlsbD0iI2ZlZjNjNyIvPjx0ZXh0IHg9IjIwMCIgeT0iMTUwIiBmb250LWZhbWlseT0iQXJpYWwiIGZvbnQtc2l6ZT0iMTgiIGZpbGw9IiNmNTllMGIiIHRleHQtYW5jaG9yPSJtaWRkbGUiPk5vIEltYWdlPC90ZXh0Pjwvc3ZnPg==';
                            }
                            
                            // Format date
                            const createdDate = new Date(article.created_at).toLocaleDateString('en-US', {
                                year: 'numeric',
                                month: 'short',
                                day: 'numeric'
                            });
                            
                            // Truncate description
                            const description = article.description.length > 120 
                                ? article.description.substring(0, 120) + '...' 
                                : article.description;
                            
                            // Category badge class
                            const categoryClass = article.category.toLowerCase().replace(/\s+/g, '-');
                            
                            articleItem.innerHTML = `
                                <div class="hap-item-image-container">
                                    <img src="${imagePath}" alt="${article.title}">
                                    <span class="hap-category-badge ${categoryClass}">${article.category}</span>
                                </div>
                                <div class="hap-item-content">
                                    <h4 class="hap-item-title">${article.title}</h4>
                                    <p class="hap-item-description">${description}</p>
                                </div>
                                <div class="hap-item-footer">
                                    <div class="hap-item-meta">
                                        <span><i class="fas fa-calendar"></i> ${createdDate}</span>
                                        ${article.display_order ? `<span><i class="fas fa-sort"></i> #${article.display_order}</span>` : ''}
                                    </div>
                                    <div class="hap-item-actions">
                                        <button class="hap-edit-btn" onclick="editHapArticle(${article.id})">
                                            <i class="fas fa-edit"></i> Edit
                                        </button>
                                        <button class="hap-delete-btn" onclick="deleteHapArticle(${article.id})">
                                            <i class="fas fa-trash"></i> Delete
                                        </button>
                                    </div>
                                </div>
                            `;
                            
                            existingHapContainer.appendChild(articleItem);
                        });
                        
                        initSortable();
                    } else {
                        // Show empty state if no articles
                        if (!existingHapContainer.querySelector('.hap-empty-state')) {
                            existingHapContainer.innerHTML = `
                                <div class="hap-empty-state">
                                    <div class="empty-state-icon">
                                        <i class="fas fa-heartbeat"></i>
                                    </div>
                                    <h3>No Articles Yet</h3>
                                    <p>Start building your Healthy Athletes Program content by adding your first article</p>
                                    <button class="btn-primary" onclick="openHapModal()">
                                        <i class="fas fa-plus"></i>
                                        Add First Article
                                    </button>
                                </div>
                            `;
                        }
                    }
                } else {
                    showNotification('Error loading HAP articles: ' + data.message, 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showNotification('Network error loading HAP articles', 'error');
            });
    }

    // Update display order after drag and drop
    function updateHapOrder() {
        const items = existingHapContainer.querySelectorAll('.hap-item-admin');
        const orders = [];
        
        items.forEach((item, index) => {
            orders.push({
                id: item.getAttribute('data-id'),
                order: index + 1
            });
        });
        
        fetch('handler/admin_hap_handler.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: new URLSearchParams({
                action: 'update_order',
                orders: JSON.stringify(orders)
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showNotification('Display order updated successfully!', 'success');
            } else {
                showNotification('Error updating order: ' + data.message, 'error');
                loadHapArticles(); // Reload to reset order
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showNotification('Network error updating order', 'error');
            loadHapArticles(); // Reload to reset order
        });
    }

    // Edit HAP article
    window.editHapArticle = function(id) {
        fetch(`handler/admin_hap_handler.php?action=fetch`)
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    const article = data.articles.find(a => a.id == id);
                    if (article) {
                        // Fill edit form with article data
                        document.getElementById('editHapId').value = article.id;
                        document.getElementById('editHapTitle').value = article.title;
                        document.getElementById('editHapCategory').value = article.category;
                        document.getElementById('editHapDescription').value = article.description;
                        document.getElementById('editHapLearnMoreLink').value = article.learn_more_link || '';
                        document.getElementById('currentEditHapImage').value = article.image_path || '';
                        
                        // Show current image if exists
                        if (article.image_path) {
                            const preview = document.getElementById('editHapImagePreview');
                            const previewImg = document.querySelector('#editHapImagePreview img');
                            const imageStatus = document.getElementById('editHapImageStatus');
                            const deleteBtn = document.getElementById('deleteEditHapImageBtn');
                            
                            if (previewImg) previewImg.src = article.image_path;
                            if (preview) preview.style.display = 'block';
                            if (imageStatus) imageStatus.textContent = 'Current image loaded';
                            if (deleteBtn) deleteBtn.style.display = 'inline-block';
                        }
                        
                        // Open edit modal
                        openHapEditModal();
                    }
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showNotification('Error loading article for editing', 'error');
            });
    };

    // Delete HAP article
    window.deleteHapArticle = function(id) {
        if (confirm('Are you sure you want to delete this HAP article? This action cannot be undone.')) {
            fetch('handler/admin_hap_handler.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: new URLSearchParams({
                    action: 'delete',
                    id: id
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showNotification('HAP article deleted successfully!', 'success');
                    loadHapArticles();
                } else {
                    showNotification('Error deleting article: ' + data.message, 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showNotification('Network error deleting article', 'error');
            });
        }
    };

    // Handle form submission
    if (hapForm) {
        hapForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const formData = new FormData(this);
            const isEdit = document.getElementById('hapId').value !== '';
            
            if (!isEdit) {
                formData.append('action', 'add');
            }
            
            // Show loading state
            const submitBtn = document.getElementById('submitHapBtn');
            const originalText = submitBtn.textContent;
            submitBtn.textContent = isEdit ? 'Updating...' : 'Adding...';
            submitBtn.disabled = true;
            
            fetch('handler/admin_hap_handler.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showNotification(data.message, 'success');
                    closeHapModal();
                    loadHapArticles();
                } else {
                    showNotification('Error: ' + data.message, 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showNotification('Network error. Please try again.', 'error');
            })
            .finally(() => {
                submitBtn.textContent = originalText;
                submitBtn.disabled = false;
            });
        });
    }



    // Handle edit form submission
    const hapEditForm = document.getElementById('hapEditForm');
    if (hapEditForm) {
        hapEditForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const formData = new FormData(this);
            
            // Show loading state
            const submitBtn = document.getElementById('submitEditHapBtn');
            const originalText = submitBtn.textContent;
            submitBtn.textContent = 'Updating...';
            submitBtn.disabled = true;
            
            fetch('handler/admin_hap_handler.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showNotification(data.message, 'success');
                    closeHapEditModal();
                    loadHapArticles();
                } else {
                    showNotification('Error: ' + data.message, 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showNotification('Network error. Please try again.', 'error');
            })
            .finally(() => {
                submitBtn.textContent = originalText;
                submitBtn.disabled = false;
            });
        });
    }
});

// HAP Edit Modal Functions
window.openHapEditModal = function() {
    const modal = document.getElementById('hapEditModal');
    if (modal) {
        modal.style.display = 'block';
        modal.classList.add('show');
        document.body.style.overflow = 'hidden';
    }
}

window.closeHapEditModal = function() {
    const modal = document.getElementById('hapEditModal');
    if (modal) {
        modal.style.display = 'none';
        modal.classList.remove('show');
        document.body.style.overflow = '';
        resetHapEditModal();
    }
}

function resetHapEditModal() {
    // Reset edit form
    const form = document.getElementById('hapEditForm');
    if (form) form.reset();
    
    // Reset hidden fields
    const hapId = document.getElementById('editHapId');
    const currentImage = document.getElementById('currentEditHapImage');
    if (hapId) hapId.value = '';
    if (currentImage) currentImage.value = '';
    
    // Reset image preview and status
    const preview = document.getElementById('editHapImagePreview');
    const imageStatus = document.getElementById('editHapImageStatus');
    const imageDeleteBtn = document.getElementById('deleteEditHapImageBtn');
    const previewImg = document.querySelector('#editHapImagePreview img');
    
    if (preview) preview.style.display = 'none';
    if (imageStatus) imageStatus.textContent = 'Current image loaded';
    if (imageDeleteBtn) imageDeleteBtn.style.display = 'none';
    if (previewImg) previewImg.src = '';
}

// Edit HAP File Handling Functions
window.handleEditHapFileSelect = function(input) {
    const fileStatus = document.getElementById('editHapImageStatus');
    const deleteBtn = document.getElementById('deleteEditHapImageBtn');
    const preview = document.getElementById('editHapImagePreview');
    const previewImg = document.querySelector('#editHapImagePreview img');
    
    if (input.files && input.files[0]) {
        const file = input.files[0];
        
        // Update status
        if (fileStatus) fileStatus.textContent = file.name;
        if (deleteBtn) deleteBtn.style.display = 'inline-block';
        
        // Show preview
        const reader = new FileReader();
        reader.onload = function(e) {
            if (previewImg) {
                previewImg.src = e.target.result;
                if (preview) preview.style.display = 'block';
            }
        };
        reader.readAsDataURL(file);
    }
}

window.removeEditHapSelectedFile = function() {
    const fileInput = document.getElementById('editHapImage');
    const fileStatus = document.getElementById('editHapImageStatus');
    const deleteBtn = document.getElementById('deleteEditHapImageBtn');
    const preview = document.getElementById('editHapImagePreview');
    const previewImg = document.querySelector('#editHapImagePreview img');
    
    if (fileInput) fileInput.value = '';
    if (fileStatus) fileStatus.textContent = 'Current image loaded';
    if (deleteBtn) deleteBtn.style.display = 'none';
    if (previewImg) previewImg.src = '';
    if (preview) preview.style.display = 'none';
}

// Update HAP statistics
function updateHapStatistics(articles) {
    const totalCount = articles.length;
    const communityCount = articles.filter(a => 
        a.category === 'COMMUNITY IMPACT' || a.category === 'PARTNERSHIP'
    ).length;
    const healthCount = articles.filter(a => 
        a.category === 'HEALTH SCREENING' || a.category === 'WELLNESS PROGRAM'
    ).length;
    
    const totalCountEl = document.getElementById('hapTotalCount');
    const communityCountEl = document.getElementById('hapCommunityCount');
    const healthCountEl = document.getElementById('hapHealthCount');
    
    if (totalCountEl) totalCountEl.textContent = totalCount;
    if (communityCountEl) communityCountEl.textContent = communityCount;
    if (healthCountEl) healthCountEl.textContent = healthCount;
}

// Toggle between grid and list view
window.toggleHapView = function(view) {
    const container = document.getElementById('existingHap');
    const buttons = document.querySelectorAll('.view-toggle-btn');
    
    // Update active state
    buttons.forEach(btn => {
        if (btn.dataset.view === view) {
            btn.classList.add('active');
        } else {
            btn.classList.remove('active');
        }
    });
    
    // Update container class
    if (view === 'grid') {
        container.classList.remove('hap-list-view');
        container.classList.add('hap-grid-view');
    } else {
        container.classList.remove('hap-grid-view');
        container.classList.add('hap-list-view');
    }
    
    // Save preference to localStorage
    localStorage.setItem('hapViewPreference', view);
};

// Load saved view preference on page load
document.addEventListener('DOMContentLoaded', function() {
    const savedView = localStorage.getItem('hapViewPreference') || 'grid';
    const container = document.getElementById('existingHap');
    
    if (container && savedView === 'list') {
        toggleHapView('list');
    }
});

// Global function to show notifications
function showNotification(message, type = 'info') {
    // Create notification element
    const notification = document.createElement('div');
    notification.className = `notification notification-${type}`;
    notification.style.cssText = `
        position: fixed;
        top: 20px;
        right: 20px;
        padding: 12px 24px;
        border-radius: 8px;
        color: white;
        font-weight: 500;
        z-index: 10000;
        min-width: 300px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        transform: translateX(100%);
        transition: transform 0.3s ease;
    `;
    
    // Set background color based on type
    switch(type) {
        case 'success':
            notification.style.backgroundColor = '#10b981';
            break;
        case 'error':
            notification.style.backgroundColor = '#ef4444';
            break;
        case 'warning':
            notification.style.backgroundColor = '#f59e0b';
            break;
        default:
            notification.style.backgroundColor = '#3b82f6';
    }
    
    notification.textContent = message;
    
    document.body.appendChild(notification);
    
    // Animate in
    setTimeout(() => {
        notification.style.transform = 'translateX(0)';
    }, 100);
    
    // Remove after 4 seconds
    setTimeout(() => {
        notification.style.transform = 'translateX(100%)';
        setTimeout(() => {
            document.body.removeChild(notification);
        }, 300);
    }, 4000);
}