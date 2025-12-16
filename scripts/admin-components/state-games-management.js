// State Games Management JavaScript for Admin Panel
document.addEventListener('DOMContentLoaded', function() {
    const existingStateGamesContainer = document.getElementById('existingStateGames');
    const stateGamesForm = document.getElementById('stateGamesForm');
    
    let sortable;
    let allEvents = [];
    let currentView = 'grid';

    // Load state games events on page load
    loadStateGamesEvents();

    // View Toggle
    document.querySelectorAll('.state-games-view-toggle .view-toggle-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            document.querySelectorAll('.state-games-view-toggle .view-toggle-btn').forEach(b => b.classList.remove('active'));
            this.classList.add('active');
            currentView = this.getAttribute('data-view');
            renderEvents(allEvents);
        });
    });

    // Search and Sort Listeners
    document.getElementById('searchStateGames')?.addEventListener('input', filterAndSortEvents);
    document.getElementById('sortStateGames')?.addEventListener('change', filterAndSortEvents);

    // Initialize sortable functionality
    function initSortable() {
        if (sortable) sortable.destroy();
        
        if (existingStateGamesContainer) {
            sortable = Sortable.create(existingStateGamesContainer, {
                animation: 150,
                ghostClass: 'sortable-ghost',
                handle: currentView === 'grid' ? '.state-game-card-drag-handle' : '.state-game-item-drag-handle',
                onEnd: function(evt) {
                    updateStateGamesOrder();
                }
            });
        }
    }

    function loadStateGamesEvents() {
        fetch('handler/admin_state_games_handler.php?action=fetch')
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    allEvents = data.events || [];
                    renderEvents(allEvents);
                } else {
                    allEvents = [];
                    showEmptyState();
                }
            })
            .catch(error => {
                console.error('Error:', error);
                existingStateGamesContainer.innerHTML = `
                    <div class="state-games-empty-state">
                        <i class="fas fa-exclamation-triangle"></i>
                        <h4>Failed to Load Events</h4>
                        <p>${error.message}</p>
                    </div>
                `;
            });
    }

    function renderEvents(events) {
        existingStateGamesContainer.innerHTML = '';
        document.getElementById('displayedStateGamesCount').textContent = events.length;
        
        if (events.length === 0) {
            showEmptyState();
            return;
        }

        existingStateGamesContainer.className = currentView === 'grid' ? 'state-games-grid sortable-state-games' : 'state-games-list sortable-state-games';

        events.forEach(event => {
            const eventCard = createEventCard(event);
            existingStateGamesContainer.appendChild(eventCard);
        });

        initSortable();
    }

    function createEventCard(event) {
        const card = document.createElement('div');
        card.setAttribute('data-id', event.id);
        
        let imagePath = event.image_path || 'https://via.placeholder.com/400x220?text=No+Image';

        if (currentView === 'grid') {
            card.classList.add('state-game-card');
            card.innerHTML = `
                <div class="state-game-card-drag-handle">
                    <i class="fas fa-grip-vertical"></i>
                </div>
                <img src="${imagePath}" alt="${event.event_title}" class="state-game-card-image" onerror="this.src='https://via.placeholder.com/400x220?text=No+Image';">
                <div class="state-game-card-content">
                    <div class="state-game-card-header">
                        <h4 class="state-game-card-title">${event.event_title}</h4>
                        <span class="state-game-order-badge">#${event.display_order}</span>
                    </div>
                    <div class="state-game-card-date">
                        <i class="fas fa-calendar"></i>
                        <span>${event.event_date}</span>
                    </div>
                    <p class="state-game-card-description">${event.event_description}</p>
                    <div class="state-game-card-actions">
                        <button class="state-game-action-btn edit" onclick="editStateGamesEvent(${event.id})">
                            <i class="fas fa-edit"></i> Edit
                        </button>
                        <button class="state-game-action-btn delete" onclick="deleteStateGamesEvent(${event.id})">
                            <i class="fas fa-trash"></i> Delete
                        </button>
                    </div>
                </div>
            `;
        } else {
            card.classList.add('state-game-item');
            card.innerHTML = `
                <div class="state-game-item-drag-handle">
                    <i class="fas fa-grip-vertical"></i>
                </div>
                <img src="${imagePath}" alt="${event.event_title}" class="state-game-item-image" onerror="this.src='https://via.placeholder.com/160x160?text=No+Image';">
                <div class="state-game-item-content">
                    <div class="state-game-item-header">
                        <h4 class="state-game-item-title">${event.event_title}</h4>
                        <span class="state-game-order-badge">#${event.display_order}</span>
                    </div>
                    <div class="state-game-card-date">
                        <i class="fas fa-calendar"></i>
                        <span>${event.event_date}</span>
                    </div>
                    <p class="state-game-item-description">${event.event_description}</p>
                    <div class="state-game-item-actions">
                        <button class="state-game-action-btn edit" onclick="editStateGamesEvent(${event.id})">
                            <i class="fas fa-edit"></i> Edit
                        </button>
                        <button class="state-game-action-btn delete" onclick="deleteStateGamesEvent(${event.id})">
                            <i class="fas fa-trash"></i> Delete
                        </button>
                    </div>
                </div>
            `;
        }

        return card;
    }

    function showEmptyState() {
        existingStateGamesContainer.className = 'state-games-grid sortable-state-games';
        existingStateGamesContainer.innerHTML = `
            <div class="state-games-empty-state">
                <i class="fas fa-trophy"></i>
                <h4>No Events Found</h4>
                <p>Start by adding your first State Games event</p>
            </div>
        `;
    }

    function filterAndSortEvents() {
        const searchTerm = document.getElementById('searchStateGames').value.toLowerCase();
        const sortOrder = document.getElementById('sortStateGames').value;

        let filtered = [...allEvents];

        if (searchTerm) {
            filtered = filtered.filter(e => 
                e.event_title.toLowerCase().includes(searchTerm) ||
                e.event_description.toLowerCase().includes(searchTerm) ||
                e.event_date.toLowerCase().includes(searchTerm)
            );
        }

        filtered.sort((a, b) => {
            switch(sortOrder) {
                case 'order':
                    return parseInt(a.display_order) - parseInt(b.display_order);
                case 'title_asc':
                    return a.event_title.localeCompare(b.event_title);
                case 'title_desc':
                    return b.event_title.localeCompare(a.event_title);
                case 'newest':
                    return b.id - a.id;
                case 'oldest':
                    return a.id - b.id;
                default:
                    return 0;
            }
        });

        renderEvents(filtered);
    }

    function updateStateGamesOrder() {
        const eventItems = document.querySelectorAll('#existingStateGames > div[data-id]');
        const orders = [];

        eventItems.forEach((item, index) => {
            const eventId = parseInt(item.getAttribute('data-id'));
            if (eventId) {
                orders.push({
                    id: eventId,
                    order: index + 1
                });
            }
        });

        if (orders.length === 0) return;

        fetch('handler/admin_state_games_handler.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: 'action=reorder&' + eventIds.map((id, index) => `event_ids[]=${id}`).join('&')
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showNotification('Event order updated successfully!', 'success');
            } else {
                console.error('Error updating order:', data.message);
                showNotification('Error updating order: ' + data.message, 'error');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showNotification('Network error while updating order', 'error');
        });
    }

    // Form submission
    if (stateGamesForm) {
        stateGamesForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const formData = new FormData(stateGamesForm);
            const isEdit = formData.get('id') && formData.get('id') !== '';
            formData.append('action', isEdit ? 'edit' : 'add');

            const submitBtn = document.getElementById('submitStateGamesBtn');
            const originalText = submitBtn.textContent;
            submitBtn.textContent = isEdit ? 'Updating...' : 'Adding...';
            submitBtn.disabled = true;

            fetch('handler/admin_state_games_handler.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showNotification(data.message, 'success');
                    closeStateGamesModal();
                    loadStateGamesEvents();
                } else {
                    showNotification('Error: ' + data.message, 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showNotification('Network error occurred', 'error');
            })
            .finally(() => {
                submitBtn.textContent = originalText;
                submitBtn.disabled = false;
            });
        });
    }

    // Image preview functionality
    if (stateGamesImageInput) {
        stateGamesImageInput.addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                // Validate file size (5MB max)
                if (file.size > 5 * 1024 * 1024) {
                    showNotification('Image file too large. Maximum size is 5MB.', 'error');
                    this.value = '';
                    return;
                }

                // Validate file type
                const allowedTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif', 'image/webp'];
                const fileType = file.type.toLowerCase();
                if (!allowedTypes.includes(fileType)) {
                    showNotification('Invalid file type. Only JPEG, PNG, GIF, and WebP are allowed.', 'error');
                    this.value = '';
                    return;
                }

                // Show preview
                const reader = new FileReader();
                reader.onload = function(e) {
                    if (stateGamesImagePreview) {
                        stateGamesImagePreview.src = e.target.result;
                        stateGamesImagePreview.style.display = 'block';
                    }
                };
                reader.readAsDataURL(file);

                if (stateGamesImageStatus) {
                    stateGamesImageStatus.textContent = file.name;
                    stateGamesImageStatus.style.color = '#28a745';
                }
                if (deleteStateGamesImageBtn) {
                    deleteStateGamesImageBtn.style.display = 'inline-block';
                }
            }
        });
    }

    // Delete image button
    if (deleteStateGamesImageBtn) {
        deleteStateGamesImageBtn.addEventListener('click', function() {
            if (stateGamesImageInput) stateGamesImageInput.value = '';
            if (stateGamesImagePreview) stateGamesImagePreview.style.display = 'none';
            if (stateGamesImageStatus) stateGamesImageStatus.textContent = 'No file selected.';
            this.style.display = 'none';
            
            // Clear current image field if editing
            const currentImageField = document.getElementById('currentStateGamesImage');
            if (currentImageField) currentImageField.value = '';
        });
    }
});

// Global functions that can be called from HTML
window.editStateGamesEvent = function(id) {
    // TEACHING: This function is called when you click the "Edit" button
    // Step 1: Fetch all state games events from the server
    fetch(`handler/admin_state_games_handler.php?action=fetch`)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Step 2: Find the specific event by ID
                const event = data.events.find(e => e.id == id);
                
                if (event) {
                    console.log('✓ Loading event for editing:', event);
                    
                    // Step 3: Populate form fields with existing data
                    // These are the input fields in your modal
                    document.getElementById('stateGamesId').value = event.id;
                    document.getElementById('stateGameEventTitle').value = event.event_title;
                    document.getElementById('stateGameEventDate').value = event.event_date;
                    document.getElementById('stateGameEventDescription').value = event.event_description;
                    document.getElementById('learnMoreLink').value = event.learn_more_link || '';
                    document.getElementById('stateGameDisplayOrder').value = event.display_order || '';
                    document.getElementById('currentStateGamesImage').value = event.image_path || '';

                    // Step 4: Show existing image if available
                    const preview = document.getElementById('stateGamesImagePreview');
                    const status = document.getElementById('stateGamesImageStatus');
                    const deleteBtn = document.getElementById('deleteStateGamesImageBtn');

                    if (event.image_path && event.image_path !== 'null') {
                        if (preview) {
                            preview.src = event.image_path;
                            preview.style.display = 'block';
                        }
                        if (status) {
                            status.textContent = 'Current image: ' + event.image_path.split('/').pop();
                            status.style.color = '#28a745';
                        }
                        if (deleteBtn) deleteBtn.style.display = 'inline-block';
                    }

                    // Update modal title and button
                    const title = document.querySelector('#stateGamesModal h3');
                    const submitBtn = document.getElementById('submitStateGamesBtn');
                    const cancelBtn = document.getElementById('cancelEditStateGamesBtn');

                    // Open modal first in edit mode (this will NOT reset the form)
                    openStateGamesModal('edit');

                    // Then update the UI elements for edit mode
                    if (title) title.textContent = 'Edit State Games Event';
                    if (submitBtn) {
                        submitBtn.textContent = 'Update Event';
                        submitBtn.className = 'state-games-submit-btn';
                    }
                    if (cancelBtn) cancelBtn.style.display = 'inline-block';
                }
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showNotification('Error loading event data', 'error');
        });
};

window.deleteStateGamesEvent = function(id) {
    if (confirm('Are you sure you want to delete this state games event? This action cannot be undone.')) {
        fetch('handler/admin_state_games_handler.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: `action=delete&id=${id}`
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showNotification(data.message, 'success');
                loadStateGamesEvents();
            } else {
                showNotification('Error: ' + data.message, 'error');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showNotification('Network error occurred', 'error');
        });
    }
};

// Utility function to truncate text
function truncateText(text, maxLength) {
    if (!text) return '';
    if (text.length <= maxLength) return text;
    return text.substring(0, maxLength) + '...';
}

// Utility function to show notifications
function showNotification(message, type = 'success') {
    // Check if the global showNotification function exists, otherwise create a simple alert
    if (typeof window.showNotification === 'function') {
        window.showNotification(message, type);
    } else {
        // Simple fallback notification
        const notification = document.createElement('div');
        notification.style.cssText = `
            position: fixed;
            top: 20px;
            right: 20px;
            padding: 12px 20px;
            border-radius: 4px;
            color: white;
            font-weight: 500;
            z-index: 9999;
            background-color: ${type === 'success' ? '#28a745' : '#dc3545'};
            animation: slideIn 0.3s ease;
        `;
        notification.textContent = message;
        document.body.appendChild(notification);
        setTimeout(() => notification.remove(), 3000);
    }
}

// Load state games events when the section becomes active
document.addEventListener('DOMContentLoaded', function() {
    const stateGamesSection = document.getElementById('state-games');
    if (stateGamesSection) {
        // Set up observer to reload data when section becomes visible
        const observer = new MutationObserver(function(mutations) {
            mutations.forEach(function(mutation) {
                if (mutation.type === 'attributes' && mutation.attributeName === 'class') {
                    if (stateGamesSection.classList.contains('active')) {
                        setTimeout(loadStateGamesEvents, 100);
                    }
                }
            });
        });

        observer.observe(stateGamesSection, {
            attributes: true,
            attributeFilter: ['class']
        });
    }
});