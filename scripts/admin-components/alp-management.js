// ALP (Athlete Leadership Program) Management JavaScript for Admin Panel
document.addEventListener('DOMContentLoaded', function() {
    const existingAlpContainer = document.getElementById('existingAlp');
    const alpForm = document.getElementById('alpForm');
    const alpEditForm = document.getElementById('alpEditForm');
    const alpImageInput = document.getElementById('alpImage');
    const alpImagePreview = document.getElementById('alpImagePreview');
    const alpImageStatus = document.getElementById('alpImageStatus');
    const deleteAlpImageBtn = document.getElementById('deleteAlpImageBtn');
    
    let sortable;

    // Load ALP articles on page load
    loadAlpArticles();

    // Initialize sortable functionality
    function initSortable() {
        if (sortable) {
            sortable.destroy();
        }
        
        if (existingAlpContainer) {
            sortable = Sortable.create(existingAlpContainer, {
                animation: 150,
                ghostClass: 'sortable-ghost',
                chosenClass: 'sortable-chosen',
                dragClass: 'sortable-drag',
                onEnd: function(evt) {
                    updateAlpOrder();
                }
            });
        }
    }

    function loadAlpArticles() {
        fetch('handler/admin_alp_handler.php?action=fetch')
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    existingAlpContainer.innerHTML = '';
                    if (data.articles && data.articles.length > 0) {
                        data.articles.forEach(article => {
                            const articleItem = document.createElement('div');
                            articleItem.classList.add('alp-item-admin');
                            articleItem.setAttribute('data-id', article.id);
                            
                            // Handle image path with better error handling
                            let imagePath = article.image_path;
                            if (!imagePath || imagePath === 'null' || imagePath === '') {
                                imagePath = 'data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMTAwIiBoZWlnaHQ9IjEwMCIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj48cmVjdCB3aWR0aD0iMTAwIiBoZWlnaHQ9IjEwMCIgZmlsbD0iI2Y1ZjVmNSIvPjx0ZXh0IHg9IjUwIiB5PSI1NSIgZm9udC1mYW1pbHk9IkFyaWFsIiBmb250LXNpemU9IjE0IiBmaWxsPSIjOTk5IiB0ZXh0LWFuY2hvcj0ibWlkZGxlIj5ObyBJbWFnZTwvdGV4dD48L3N2Zz4=';
                            } else {
                                // Normalize path for admin panel display
                                if (imagePath.startsWith('assets/')) {
                                    imagePath = '../' + imagePath;
                                } else if (imagePath.startsWith('../assets/')) {
                                    // Already has ../ prefix
                                    imagePath = imagePath;
                                } else if (imagePath.startsWith('../')) {
                                    // Remove ../ and add it back properly
                                    imagePath = '../' + imagePath.substring(3);
                                } else {
                                    // Fallback: assume it needs ../ prefix
                                    imagePath = '../' + imagePath;
                                }
                            }
                            
                            // Format date
                            const createdDate = new Date(article.created_at).toLocaleDateString();
                            
                            // Truncate description
                            const description = article.description.length > 150 
                                ? article.description.substring(0, 150) + '...' 
                                : article.description;
                            
                            articleItem.innerHTML = `
                                <div class="alp-item-image">
                                    <img src="${imagePath}" alt="${article.title}">
                                </div>
                                <div class="alp-item-content">
                                    <div class="alp-item-category">${article.category}</div>
                                    <div class="alp-item-title">${article.title}</div>
                                    <div class="alp-item-description">${description}</div>
                                    <div class="alp-item-meta">
                                        <span>Created: ${createdDate}</span>
                                        <span>Order: ${article.display_order || 'Auto'}</span>
                                    </div>
                                </div>
                                <div class="alp-item-actions">
                                    <button class="alp-edit-btn" onclick="editAlpArticle(${article.id})">
                                        <i class="fas fa-edit"></i> Edit
                                    </button>
                                    <button class="alp-delete-btn" onclick="deleteAlpArticle(${article.id})">
                                        <i class="fas fa-trash"></i> Delete
                                    </button>
                                </div>
                            `;
                            
                            existingAlpContainer.appendChild(articleItem);
                        });
                        
                        initSortable();
                    } else {
                        existingAlpContainer.innerHTML = `
                            <div style="text-align: center; padding: 40px; color: #6b7280;">
                                <i class="fas fa-user-tie" style="font-size: 3rem; margin-bottom: 16px; color: #e5e7eb;"></i>
                                <p>No ALP articles found. Create your first article!</p>
                            </div>
                        `;
                    }
                } else {
                    showNotification('Error loading ALP articles: ' + data.message, 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showNotification('Network error loading ALP articles', 'error');
            });
    }

    // Update display order after drag and drop
    function updateAlpOrder() {
        const items = existingAlpContainer.querySelectorAll('.alp-item-admin');
        const orders = [];
        
        items.forEach((item, index) => {
            orders.push({
                id: item.getAttribute('data-id'),
                order: index + 1
            });
        });
        
        fetch('handler/admin_alp_handler.php', {
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
                loadAlpArticles(); // Reload to reset order
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showNotification('Network error updating order', 'error');
            loadAlpArticles(); // Reload to reset order
        });
    }

    // Edit ALP article
    window.editAlpArticle = function(id) {
        fetch(`handler/admin_alp_handler.php?action=fetch`)
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    const article = data.articles.find(a => a.id == id);
                    if (article) {
                        // Fill edit form with article data
                        document.getElementById('editAlpId').value = article.id;
                        document.getElementById('editAlpTitle').value = article.title;
                        document.getElementById('editAlpCategory').value = article.category;
                        document.getElementById('editAlpDescription').value = article.description;
                        document.getElementById('editAlpLearnMoreLink').value = article.learn_more_link || '';
                        document.getElementById('editAlpDisplayOrder').value = article.display_order || '';
                        document.getElementById('currentEditAlpImage').value = article.image_path || '';
                        
                        // Show current image if exists
                        if (article.image_path && article.image_path !== 'null' && article.image_path !== '') {
                            const preview = document.getElementById('editAlpImagePreview');
                            const previewImg = document.querySelector('#editAlpImagePreview img');
                            const imageStatus = document.getElementById('editAlpImageStatus');
                            const deleteBtn = document.getElementById('deleteEditAlpImageBtn');
                            
                            // Normalize path for admin panel display
                            let imagePath = article.image_path;
                            if (imagePath.startsWith('assets/')) {
                                imagePath = '../' + imagePath;
                            } else if (imagePath.startsWith('../assets/')) {
                                // Already properly formatted
                                imagePath = imagePath;
                            } else if (imagePath.startsWith('../')) {
                                // Remove ../ and add it back properly
                                imagePath = '../' + imagePath.substring(3);
                            } else {
                                // Fallback: assume it needs ../ prefix
                                imagePath = '../' + imagePath;
                            }
                            
                            if (previewImg) {
                                previewImg.src = imagePath;
                                previewImg.onerror = function() {
                                    console.warn('Failed to load image:', imagePath);
                                    this.style.display = 'none';
                                    if (preview) preview.style.display = 'none';
                                    if (imageStatus) imageStatus.textContent = 'Image not found';
                                };
                            }
                            if (preview) preview.style.display = 'block';
                            if (imageStatus) imageStatus.textContent = 'Current image loaded';
                            if (deleteBtn) deleteBtn.style.display = 'inline-block';
                        }
                        
                        // Open edit modal
                        openAlpEditModal();
                    }
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showNotification('Error loading article for editing', 'error');
            });
    };

    // Delete ALP article
    window.deleteAlpArticle = function(id) {
        if (confirm('Are you sure you want to delete this ALP article? This action cannot be undone.')) {
            fetch('handler/admin_alp_handler.php', {
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
                    showNotification('ALP article deleted successfully!', 'success');
                    loadAlpArticles();
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

    // Handle add form submission
    if (alpForm) {
        alpForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const formData = new FormData(this);
            
            // Show loading state
            const submitBtn = document.getElementById('submitAlpBtn');
            const originalText = submitBtn.textContent;
            submitBtn.textContent = 'Adding...';
            submitBtn.disabled = true;
            
            fetch('handler/admin_alp_handler.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showNotification(data.message, 'success');
                    closeAlpModal();
                    loadAlpArticles();
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
    if (alpEditForm) {
        alpEditForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const formData = new FormData(this);
            
            // Show loading state
            const submitBtn = document.getElementById('submitEditAlpBtn');
            const originalText = submitBtn.textContent;
            submitBtn.textContent = 'Updating...';
            submitBtn.disabled = true;
            
            fetch('handler/admin_alp_handler.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showNotification(data.message, 'success');
                    closeAlpEditModal();
                    loadAlpArticles();
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

// ALP Modal Functions - for global access
window.openAlpModal = function() {
    const modal = document.getElementById('alpModal');
    if (modal) {
        modal.style.display = 'block';
        modal.classList.add('show');
        document.body.style.overflow = 'hidden';
        resetAlpModal();
    }
}

window.closeAlpModal = function() {
    const modal = document.getElementById('alpModal');
    if (modal) {
        modal.style.display = 'none';
        modal.classList.remove('show');
        document.body.style.overflow = '';
        resetAlpModal();
    }
}

function resetAlpModal() {
    // Reset form
    const form = document.getElementById('alpForm');
    if (form) form.reset();
    
    // Reset image preview and status
    const preview = document.getElementById('alpImagePreview');
    const imageStatus = document.getElementById('alpImageStatus');
    const imageDeleteBtn = document.getElementById('deleteAlpImageBtn');
    const previewImg = document.querySelector('#alpImagePreview img');
    
    if (preview) preview.style.display = 'none';
    if (imageStatus) imageStatus.textContent = 'No file selected';
    if (imageDeleteBtn) imageDeleteBtn.style.display = 'none';
    if (previewImg) previewImg.src = '';
}

window.openAlpEditModal = function() {
    const modal = document.getElementById('alpEditModal');
    if (modal) {
        modal.style.display = 'block';
        modal.classList.add('show');
        document.body.style.overflow = 'hidden';
    }
}

window.closeAlpEditModal = function() {
    const modal = document.getElementById('alpEditModal');
    if (modal) {
        modal.style.display = 'none';
        modal.classList.remove('show');
        document.body.style.overflow = '';
        resetAlpEditModal();
    }
}

function resetAlpEditModal() {
    // Reset edit form
    const form = document.getElementById('alpEditForm');
    if (form) form.reset();
    
    // Reset hidden fields
    const alpId = document.getElementById('editAlpId');
    const currentImage = document.getElementById('currentEditAlpImage');
    if (alpId) alpId.value = '';
    if (currentImage) currentImage.value = '';
    
    // Reset image preview and status
    const preview = document.getElementById('editAlpImagePreview');
    const imageStatus = document.getElementById('editAlpImageStatus');
    const imageDeleteBtn = document.getElementById('deleteEditAlpImageBtn');
    const previewImg = document.querySelector('#editAlpImagePreview img');
    
    if (preview) preview.style.display = 'none';
    if (imageStatus) imageStatus.textContent = 'Current image loaded';
    if (imageDeleteBtn) imageDeleteBtn.style.display = 'none';
    if (previewImg) previewImg.src = '';
}

// ALP File Handling Functions with validation
window.handleAlpFileSelect = function(input) {
    const fileStatus = document.getElementById('alpImageStatus');
    const deleteBtn = document.getElementById('deleteAlpImageBtn');
    const preview = document.getElementById('alpImagePreview');
    const previewImg = document.querySelector('#alpImagePreview img');
    
    if (input.files && input.files[0]) {
        const file = input.files[0];
        
        // Validate file type
        const allowedTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif', 'image/webp'];
        if (!allowedTypes.includes(file.type)) {
            if (fileStatus) fileStatus.textContent = 'Please select a valid image file (JPG, PNG, GIF, WebP)';
            fileStatus.style.color = '#ef4444';
            input.value = '';
            return;
        }
        
        // Validate file size (5MB limit)
        const maxSize = 5 * 1024 * 1024; // 5MB
        if (file.size > maxSize) {
            if (fileStatus) fileStatus.textContent = 'File too large. Please select an image under 5MB.';
            fileStatus.style.color = '#ef4444';
            input.value = '';
            return;
        }
        
        // Update status
        if (fileStatus) {
            fileStatus.textContent = file.name + ' (' + (file.size / 1024 / 1024).toFixed(2) + ' MB)';
            fileStatus.style.color = '#10b981';
        }
        if (deleteBtn) deleteBtn.style.display = 'inline-block';
        
        // Show preview
        const reader = new FileReader();
        reader.onload = function(e) {
            if (previewImg) {
                previewImg.src = e.target.result;
                if (preview) preview.style.display = 'block';
            }
        };
        reader.onerror = function() {
            if (fileStatus) {
                fileStatus.textContent = 'Error reading file';
                fileStatus.style.color = '#ef4444';
            }
        };
        reader.readAsDataURL(file);
    }
}

window.removeAlpSelectedFile = function() {
    const fileInput = document.getElementById('alpImage');
    const fileStatus = document.getElementById('alpImageStatus');
    const deleteBtn = document.getElementById('deleteAlpImageBtn');
    const preview = document.getElementById('alpImagePreview');
    const previewImg = document.querySelector('#alpImagePreview img');
    
    if (fileInput) fileInput.value = '';
    if (fileStatus) fileStatus.textContent = 'No file selected';
    if (deleteBtn) deleteBtn.style.display = 'none';
    if (previewImg) previewImg.src = '';
    if (preview) preview.style.display = 'none';
}

window.handleEditAlpFileSelect = function(input) {
    const fileStatus = document.getElementById('editAlpImageStatus');
    const deleteBtn = document.getElementById('deleteEditAlpImageBtn');
    const preview = document.getElementById('editAlpImagePreview');
    const previewImg = document.querySelector('#editAlpImagePreview img');
    
    if (input.files && input.files[0]) {
        const file = input.files[0];
        
        // Validate file type
        const allowedTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif', 'image/webp'];
        if (!allowedTypes.includes(file.type)) {
            if (fileStatus) {
                fileStatus.textContent = 'Invalid file type. Please select JPEG, PNG, GIF, or WebP images only.';
                fileStatus.style.color = '#e74c3c';
            }
            input.value = ''; // Clear the input
            return;
        }
        
        // Validate file size (5MB limit)
        const maxSize = 5 * 1024 * 1024; // 5MB in bytes
        if (file.size > maxSize) {
            if (fileStatus) {
                fileStatus.textContent = 'File too large. Please select an image smaller than 5MB.';
                fileStatus.style.color = '#e74c3c';
            }
            input.value = ''; // Clear the input
            return;
        }
        
        // Update status with success
        if (fileStatus) {
            fileStatus.textContent = file.name + ' ✓';
            fileStatus.style.color = '#27ae60';
        }
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

window.removeEditAlpSelectedFile = function() {
    const fileInput = document.getElementById('editAlpImage');
    const fileStatus = document.getElementById('editAlpImageStatus');
    const deleteBtn = document.getElementById('deleteEditAlpImageBtn');
    const preview = document.getElementById('editAlpImagePreview');
    const previewImg = document.querySelector('#editAlpImagePreview img');
    
    if (fileInput) fileInput.value = '';
    if (fileStatus) fileStatus.textContent = 'Current image loaded';
    if (deleteBtn) deleteBtn.style.display = 'none';
    if (previewImg) previewImg.src = '';
    if (preview) preview.style.display = 'none';
}

// Global function to show notifications (if not already defined)
if (typeof showNotification === 'undefined') {
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
                if (document.body.contains(notification)) {
                    document.body.removeChild(notification);
                }
            }, 300);
        }, 4000);
    }
}