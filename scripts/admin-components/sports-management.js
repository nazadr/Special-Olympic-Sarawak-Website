// Sports Management JavaScript for Admin Panel
// Global allSports array for visibility toggle access
window.allSports = [];

document.addEventListener('DOMContentLoaded', function() {
    const existingSportsContainer = document.getElementById('existingSports');
    const sportForm = document.getElementById('sportForm');
    const sportImageInput = document.getElementById('sportImage');
    const sportImagePreview = document.getElementById('sportImagePreview');
    const sportImageStatus = document.getElementById('sportImageStatus');
    const deleteSportImageBtn = document.getElementById('deleteSportImageBtn');
    
    let sortable;
    let allSports = [];
    let currentView = 'grid';

    // Load sports on page load
    loadSports();

    // View Toggle
    document.querySelectorAll('.sport-view-toggle .view-toggle-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            document.querySelectorAll('.sport-view-toggle .view-toggle-btn').forEach(b => b.classList.remove('active'));
            this.classList.add('active');
            currentView = this.getAttribute('data-view');
            renderSports(allSports);
        });
    });

    // Search and Sort Listeners
    document.getElementById('searchSports')?.addEventListener('input', filterAndSortSports);
    document.getElementById('sortSports')?.addEventListener('change', filterAndSortSports);

    // Initialize sortable functionality
    function initSortable() {
        if (sortable) {
            sortable.destroy();
        }
        
        if (existingSportsContainer) {
            sortable = Sortable.create(existingSportsContainer, {
                animation: 150,
                ghostClass: 'sortable-ghost',
                chosenClass: 'sortable-chosen',
                dragClass: 'sortable-drag',
                handle: currentView === 'grid' ? '.sport-card-drag-handle' : '.sport-item-drag-handle',
                onEnd: function(evt) {
                    updateSportOrder();
                }
            });
        }
    }

    function loadSports() {
        fetch('handler/admin_sports_handler.php?action=fetch')
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    allSports = data.sports || [];
                    window.allSports = allSports; // Update global reference
                    renderSports(allSports);
                } else {
                    allSports = [];
                    window.allSports = []; // Update global reference
                    showEmptyState();
                }
            })
            .catch(error => {
                console.error('Error:', error);
                existingSportsContainer.innerHTML = `
                    <div class="sports-empty-state">
                        <i class="fas fa-exclamation-triangle"></i>
                        <h4>Failed to Load Sports</h4>
                        <p>${error.message}</p>
                    </div>
                `;
            });
    }

    function renderSports(sports) {
        existingSportsContainer.innerHTML = '';
        document.getElementById('displayedSportsCount').textContent = sports.length;
        
        if (sports.length === 0) {
            showEmptyState();
            return;
        }

        // Apply view class
        existingSportsContainer.className = currentView === 'grid' ? 'sports-grid sortable-sports' : 'sports-list sortable-sports';

        sports.forEach(sport => {
            const sportCard = createSportCard(sport);
            existingSportsContainer.appendChild(sportCard);
        });

        // Attach event listeners and init sortable
        attachButtonListeners();
        initSortable();
    }

    function createSportCard(sport) {
        const card = document.createElement('div');
        card.setAttribute('data-id', sport.id);
        
        let imagePath = sport.image_path;
        if (!imagePath || imagePath === 'null') {
            imagePath = 'https://via.placeholder.com/400x200?text=No+Image';
        }

        if (currentView === 'grid') {
            card.classList.add('sport-card');
            card.innerHTML = `
                <div class="sport-card-drag-handle">
                    <i class="fas fa-grip-vertical"></i>
                </div>
                <img src="${imagePath}" alt="${sport.title}" class="sport-card-image"
                     onerror="this.src='https://via.placeholder.com/400x200?text=No+Image';">
                <div class="sport-card-content">
                    <div class="sport-card-header">
                        <h4 class="sport-card-title">${sport.title}</h4>
                        <span class="sport-order-badge">#${sport.display_order}</span>
                    </div>
                    <p class="sport-card-description">${sport.description}</p>
                    <div class="sport-visibility-control">
                        <label class="visibility-toggle">
                            <input type="checkbox" class="visibility-checkbox" data-id="${sport.id}" ${sport.is_visible == 1 ? 'checked' : ''}>
                            <span class="visibility-slider"></span>
                        </label>
                        <span class="visibility-label">${sport.is_visible == 1 ? 'Visible' : 'Hidden'}</span>
                    </div>
                    <div class="sport-card-actions">
                        <button class="sport-action-btn edit" data-id="${sport.id}">
                            <i class="fas fa-edit"></i> Edit
                        </button>
                        <button class="sport-action-btn delete" data-id="${sport.id}">
                            <i class="fas fa-trash"></i> Delete
                        </button>
                    </div>
                </div>
            `;
        } else {
            card.classList.add('sport-item');
            card.innerHTML = `
                <div class="sport-item-drag-handle">
                    <i class="fas fa-grip-vertical"></i>
                </div>
                <img src="${imagePath}" alt="${sport.title}" class="sport-item-image"
                     onerror="this.src='https://via.placeholder.com/140x140?text=No+Image';">
                <div class="sport-item-content">
                    <div class="sport-item-header">
                        <h4 class="sport-item-title">${sport.title}</h4>
                        <span class="sport-order-badge">#${sport.display_order}</span>
                    </div>
                    <p class="sport-item-description">${sport.description}</p>
                    <div class="sport-visibility-control">
                        <label class="visibility-toggle">
                            <input type="checkbox" class="visibility-checkbox" data-id="${sport.id}" ${sport.is_visible == 1 ? 'checked' : ''}>
                            <span class="visibility-slider"></span>
                        </label>
                        <span class="visibility-label">${sport.is_visible == 1 ? 'Visible' : 'Hidden'}</span>
                    </div>
                    <div class="sport-item-actions">
                        <button class="sport-action-btn edit" data-id="${sport.id}">
                            <i class="fas fa-edit"></i> Edit
                        </button>
                        <button class="sport-action-btn delete" data-id="${sport.id}">
                            <i class="fas fa-trash"></i> Delete
                        </button>
                    </div>
                </div>
            `;
        }

        return card;
    }

    function showEmptyState() {
        existingSportsContainer.className = 'sports-grid sortable-sports';
        existingSportsContainer.innerHTML = `
            <div class="sports-empty-state">
                <i class="fas fa-futbol"></i>
                <h4>No Sports Found</h4>
                <p>Start by adding your first sport using the button above</p>
            </div>
        `;
    }

    function filterAndSortSports() {
        const searchTerm = document.getElementById('searchSports').value.toLowerCase();
        const sortOrder = document.getElementById('sortSports').value;

        let filtered = [...allSports];

        // Apply search
        if (searchTerm) {
            filtered = filtered.filter(s => 
                s.title.toLowerCase().includes(searchTerm) ||
                s.description.toLowerCase().includes(searchTerm)
            );
        }

        // Apply sorting
        filtered.sort((a, b) => {
            switch(sortOrder) {
                case 'order':
                    return parseInt(a.display_order) - parseInt(b.display_order);
                case 'title_asc':
                    return a.title.localeCompare(b.title);
                case 'title_desc':
                    return b.title.localeCompare(a.title);
                case 'newest':
                    return b.id - a.id;
                case 'oldest':
                    return a.id - b.id;
                default:
                    return 0;
            }
        });

        renderSports(filtered);
    }

    function attachButtonListeners() {
        // Visibility toggle checkboxes
        document.querySelectorAll('.visibility-checkbox').forEach(checkbox => {
            checkbox.addEventListener('change', function() {
                const sportId = this.getAttribute('data-id');
                const isVisible = this.checked ? 1 : 0;
                toggleSportVisibility(sportId, isVisible, this);
            });
        });

        // Edit buttons
        document.querySelectorAll('.sport-action-btn.edit').forEach(button => {
            button.addEventListener('click', function() {
                const sportId = this.getAttribute('data-id');
                const sport = allSports.find(s => s.id == sportId);
                
                if (sport) {
                    // Open modal in edit mode
                    openSportModal();
                    
                    // Set form to edit mode
                    const modalTitle = document.querySelector('#sportModal .modal-title');
                    const submitBtn = document.getElementById('submitSportBtn');
                    const cancelBtn = document.getElementById('cancelEditSportBtn');
                    
                    modalTitle.textContent = 'Edit Sport';
                    submitBtn.textContent = 'Update Sport';
                    cancelBtn.style.display = 'inline-block';
                    
                    // Fill form with current data
                    document.getElementById('sportId').value = sport.id;
                    document.getElementById('sportTitle').value = sport.title;
                    document.getElementById('sportDescription').value = sport.description;
                    
                    // Handle image
                    if (sport.image_path && sport.image_path !== 'null') {
                        document.getElementById('currentSportImage').value = sport.image_path;
                        sportImagePreview.src = sport.image_path;
                        sportImagePreview.style.display = 'block';
                        sportImageStatus.textContent = 'Current image loaded. Select new image to change.';
                        deleteSportImageBtn.style.display = 'inline-block';
                    } else {
                        document.getElementById('currentSportImage').value = '';
                        sportImagePreview.style.display = 'none';
                        sportImageStatus.textContent = 'No image uploaded. Select image to add.';
                        deleteSportImageBtn.style.display = 'none';
                    }
                }
            });
        });

        // Delete buttons
        document.querySelectorAll('.sport-action-btn.delete').forEach(button => {
            button.addEventListener('click', function() {
                const sportId = this.getAttribute('data-id');
                const sport = allSports.find(s => s.id == sportId);
                
                if (sport && confirm(`Are you sure you want to delete "${sport.title}"? This action cannot be undone.`)) {
                    deleteSport(sportId);
                }
            });
        });
    }

    function deleteSport(sportId) {
        const formData = new FormData();
        formData.append('action', 'delete');
        formData.append('id', sportId);

        fetch('handler/admin_sports_handler.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showMessage(data.message, 'success');
                loadSports();
            } else {
                showMessage(data.message || 'Error deleting sport', 'error');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showMessage('Error deleting sport. Please try again.', 'error');
        });
    }

    function updateSportOrder() {
        const sportItems = document.querySelectorAll('#existingSports > div[data-id]');
        const orders = [];
        
        sportItems.forEach((item, index) => {
            const sportId = parseInt(item.getAttribute('data-id'));
            if (sportId) {
                orders.push({
                    id: sportId,
                    order: index + 1
                });
            }
        });

        if (orders.length === 0) {
            console.error('No valid sport items found for reordering');
            return;
        }

        const formData = new FormData();
        formData.append('action', 'update_order');
        formData.append('orders', JSON.stringify(orders));

        fetch('handler/admin_sports_handler.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                console.log('Order updated successfully');
                // Update the allSports array with new order
                orders.forEach(orderItem => {
                    const sport = allSports.find(s => s.id == orderItem.id);
                    if (sport) {
                        sport.display_order = orderItem.order;
                    }
                });
                // Re-render to show updated order badges
                renderSports(allSports);
            } else {
                console.error('Error updating order:', data.message);
                showMessage('Error updating order. Please try again.', 'error');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showMessage('Error updating order. Please try again.', 'error');
        });
    }

    // Form submission
    if (sportForm) {
        sportForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const formData = new FormData(this);
            const isEdit = document.getElementById('sportId').value !== '';
            formData.append('action', isEdit ? 'edit' : 'add');

            fetch('handler/admin_sports_handler.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showMessage(data.message, 'success');
                    closeSportModal();
                    sportForm.reset();
                    loadSports();
                } else {
                    showMessage(data.message || 'Error processing sport', 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showMessage('Error processing sport. Please try again.', 'error');
            });
        });
    }

    // Image handling
    if (sportImageInput) {
        sportImageInput.addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    sportImagePreview.src = e.target.result;
                    sportImagePreview.style.display = 'block';
                    sportImageStatus.textContent = file.name;
                    deleteSportImageBtn.style.display = 'inline-block';
                };
                reader.readAsDataURL(file);
            }
        });
    }

    if (deleteSportImageBtn) {
        deleteSportImageBtn.addEventListener('click', function() {
            sportImageInput.value = '';
            sportImagePreview.style.display = 'none';
            sportImageStatus.textContent = 'No file selected.';
            deleteSportImageBtn.style.display = 'none';
            document.getElementById('currentSportImage').value = '';
        });
    }

    // Cancel edit button
    const cancelEditBtn = document.getElementById('cancelEditSportBtn');
    if (cancelEditBtn) {
        cancelEditBtn.addEventListener('click', function() {
            closeSportModal();
        });
    }

    function showMessage(message, type) {
        // Create or update message element
        let messageEl = document.querySelector('.admin-message');
        if (!messageEl) {
            messageEl = document.createElement('div');
            messageEl.className = 'admin-message';
            document.querySelector('.sport-management-container').insertBefore(messageEl, document.querySelector('.sport-list-admin'));
        }
        
        messageEl.textContent = message;
        messageEl.className = `admin-message ${type}`;
        messageEl.style.display = 'block';
        
        setTimeout(() => {
            messageEl.style.display = 'none';
        }, 5000);
    }
});

// Modal functions (global scope for onclick handlers)
function openSportModal() {
    const modal = document.getElementById('sportModal');
    const modalTitle = document.querySelector('#sportModal .modal-title');
    const submitBtn = document.getElementById('submitSportBtn');
    const cancelBtn = document.getElementById('cancelEditSportBtn');
    
    // Reset form to add mode
    document.getElementById('sportForm').reset();
    document.getElementById('sportId').value = '';
    document.getElementById('currentSportImage').value = '';
    
    modalTitle.textContent = 'Add New Sport';
    submitBtn.textContent = 'Add Sport';
    cancelBtn.style.display = 'none';
    
    // Reset image preview
    const preview = document.getElementById('sportImagePreview');
    const status = document.getElementById('sportImageStatus');
    const deleteBtn = document.getElementById('deleteSportImageBtn');
    
    preview.style.display = 'none';
    status.textContent = 'No file selected.';
    deleteBtn.style.display = 'none';
    
    modal.classList.add('show');
    modal.style.display = 'flex';
}

function closeSportModal() {
    const modal = document.getElementById('sportModal');
    modal.classList.remove('show');
    modal.style.display = 'none';
}

// Toggle sport visibility function
function toggleSportVisibility(sportId, isVisible, checkbox) {
    const visibilityLabel = checkbox.closest('.sport-visibility-control').querySelector('.visibility-label');
    const originalState = checkbox.checked;
    const originalText = visibilityLabel.textContent;
    
    // Update UI immediately for better UX
    visibilityLabel.textContent = isVisible ? 'Visible' : 'Hidden';
    
    console.log('Toggling visibility:', { sportId, isVisible });
    
    fetch('handler/toggle_sport_visibility.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({
            sport_id: sportId,
            is_visible: isVisible
        })
    })
    .then(response => {
        console.log('Response status:', response.status);
        return response.json();
    })
    .then(data => {
        console.log('Response data:', data);
        if (data.success) {
            // Update the sport in allSports array
            const sportIndex = window.allSports?.findIndex(s => s.id == sportId);
            if (sportIndex !== -1 && window.allSports) {
                window.allSports[sportIndex].is_visible = isVisible;
            }
            
            // Show success message
            showVisibilityMessage(data.message, 'success');
        } else {
            // Revert checkbox and label on error
            checkbox.checked = !originalState;
            visibilityLabel.textContent = originalText;
            showVisibilityMessage(data.message || 'Failed to update visibility', 'error');
            console.error('Toggle failed:', data.message);
        }
    })
    .catch(error => {
        // Revert checkbox and label on error
        checkbox.checked = !originalState;
        visibilityLabel.textContent = originalText;
        showVisibilityMessage('Network error: ' + error.message, 'error');
        console.error('Network error:', error);
    });
}

function showVisibilityMessage(message, type) {
    // Create or update message element
    let messageEl = document.querySelector('.visibility-message');
    if (!messageEl) {
        messageEl = document.createElement('div');
        messageEl.className = 'visibility-message';
        const container = document.querySelector('.sport-management-container');
        if (container) {
            container.insertBefore(messageEl, container.firstChild);
        }
    }
    
    messageEl.textContent = message;
    messageEl.className = `visibility-message ${type}`;
    messageEl.style.display = 'block';
    
    setTimeout(() => {
        messageEl.style.display = 'none';
    }, 3000);
}

// Close modal when clicking outside
window.onclick = function(event) {
    const modal = document.getElementById('sportModal');
    if (event.target == modal) {
        closeSportModal();
    }
}