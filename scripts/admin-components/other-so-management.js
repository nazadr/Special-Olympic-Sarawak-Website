/**
 * ============================================================================
 * Other Special Olympics Management System
 * ============================================================================
 * 
 * Purpose: Admin interface for managing Other Special Olympics organizations
 * Features: CRUD operations, drag-drop sorting, category filtering, status toggle
 * 
 * Author: SO Sarawak Admin Webmaster
 * Created: December 17, 2025
 * ============================================================================
 */

// Global variables
let currentEditingId = null;
let otherSOData = [];

/**
 * ============================================================================
 * INITIALIZATION
 * ============================================================================
 */
document.addEventListener('DOMContentLoaded', function() {
    // Only initialize if we're on the other special olympics section
    if (document.getElementById('otherSOList')) {
        loadOtherSpecialOlympics();
    }
});

/**
 * ============================================================================
 * MODAL FUNCTIONS
 * ============================================================================
 */

/**
 * Open Add/Edit Organization Modal
 */
function openOtherSOModal(mode = 'add', id = null) {
    const modal = document.getElementById('otherSOModal');
    const modalTitle = modal.querySelector('.other-so-modal-header h3');
    const form = document.getElementById('otherSOForm');
    
    // Reset form
    form.reset();
    currentEditingId = null;
    
    // Clear image previews and status
    document.getElementById('otherSODesktopPreview').innerHTML = '';
    document.getElementById('otherSODesktopPreview').style.display = 'none';
    document.getElementById('otherSOMobilePreview').innerHTML = '';
    document.getElementById('otherSOMobilePreview').style.display = 'none';
    document.getElementById('otherSODesktopStatus').textContent = 'No file selected';
    document.getElementById('otherSOMobileStatus').textContent = 'No file selected';
    document.getElementById('deleteOtherSODesktopBtn').style.display = 'none';
    document.getElementById('deleteOtherSOMobileBtn').style.display = 'none';
    
    if (mode === 'edit' && id) {
        modalTitle.textContent = 'Edit Organization';
        currentEditingId = id;
        
        // Load organization data
        fetch(`handler/admin_other_so_handler.php?action=fetch_single&id=${id}`)
            .then(response => response.json())
            .then(result => {
                if (result.success) {
                    const org = result.data;
                    document.getElementById('otherSOName').value = org.name;
                    document.getElementById('otherSOCategory').value = org.category;
                    document.getElementById('otherSOWebsite').value = org.website_url || '';
                    document.getElementById('otherSOOrder').value = org.display_order;
                    document.getElementById('otherSOStatus').checked = org.is_active == 1;
                    
                    // Show current images
                    if (org.logo_desktop) {
                        document.getElementById('otherSODesktopPreview').innerHTML = 
                            `<div class="image-preview-item">
                                <img src="${org.logo_desktop}" alt="Desktop Logo">
                                <small>Current Desktop Logo</small>
                            </div>`;
                    }
                    if (org.logo_mobile) {
                        document.getElementById('otherSOMobilePreview').innerHTML = 
                            `<div class="image-preview-item">
                                <img src="${org.logo_mobile}" alt="Mobile Logo">
                                <small>Current Mobile Logo</small>
                            </div>`;
                    }
                } else {
                    showNotification('Error loading organization data', 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showNotification('Failed to load organization data', 'error');
            });
    } else {
        modalTitle.textContent = 'Add New Organization';
    }
    
    // Show modal
    modal.style.display = 'flex';
    document.body.style.overflow = 'hidden';
    setTimeout(() => modal.classList.add('show'), 10);
}

/**
 * Close Organization Modal
 */
function closeOtherSOModal() {
    const modal = document.getElementById('otherSOModal');
    modal.classList.remove('show');
    document.body.style.overflow = '';
    setTimeout(() => {
        modal.style.display = 'none';
        document.getElementById('otherSOForm').reset();
        currentEditingId = null;
    }, 300);
}

/**
 * ============================================================================
 * DATA OPERATIONS
 * ============================================================================
 */

/**
 * Load All Organizations
 */
function loadOtherSpecialOlympics() {
    const listContainer = document.getElementById('otherSOList');
    listContainer.innerHTML = '<div class="loading-spinner">Loading organizations...</div>';
    
    fetch('handler/admin_other_so_handler.php?action=fetch')
        .then(response => response.json())
        .then(result => {
            if (result.success) {
                otherSOData = result.data;
                displayOtherSpecialOlympics(result.data);
                updateOtherSOStats(result.data);
            } else {
                listContainer.innerHTML = `<div class="error-message">${result.message}</div>`;
            }
        })
        .catch(error => {
            console.error('Error:', error);
            listContainer.innerHTML = '<div class="error-message">Failed to load organizations</div>';
        });
}

/**
 * Display Organizations in UI
 */
function displayOtherSpecialOlympics(data) {
    const listContainer = document.getElementById('otherSOList');
    
    if (data.length === 0) {
        listContainer.innerHTML = `
            <div class="empty-state">
                <i class="fas fa-globe"></i>
                <p>No organizations found</p>
                <button class="add-other-so-btn" onclick="openOtherSOModal('add')">
                    <i class="fas fa-plus"></i> Add First Organization
                </button>
            </div>`;
        return;
    }
    
    // Group by category
    const international = data.filter(org => org.category === 'international');
    const malaysia = data.filter(org => org.category === 'malaysia');
    const states = data.filter(org => org.category === 'state');
    
    let html = '';
    
    // International & Malaysia Section
    if (international.length > 0 || malaysia.length > 0) {
        html += `
            <div class="other-so-category-section">
                <h3 class="category-title">
                    <i class="fas fa-globe"></i> International & Malaysia
                </h3>
                <div class="other-so-grid international-grid" data-category="international-malaysia">
                    ${[...international, ...malaysia].map(org => createOrgCard(org)).join('')}
                </div>
            </div>`;
    }
    
    // States Section
    if (states.length > 0) {
        html += `
            <div class="other-so-category-section">
                <h3 class="category-title">
                    <i class="fas fa-map-marked-alt"></i> States & Federal Territories
                </h3>
                <div class="other-so-grid states-grid" data-category="state">
                    ${states.map(org => createOrgCard(org)).join('')}
                </div>
            </div>`;
    }
    
    listContainer.innerHTML = html;
    
    // Initialize drag-drop sorting
    initializeOtherSOSorting();
}

/**
 * Create Organization Card HTML
 */
function createOrgCard(org) {
    const statusClass = org.is_active == 1 ? 'active' : 'inactive';
    const statusIcon = org.is_active == 1 ? 'check-circle' : 'times-circle';
    const statusText = org.is_active == 1 ? 'Active' : 'Inactive';
    
    return `
        <div class="other-so-card" data-id="${org.id}" data-order="${org.display_order}">
            <div class="card-drag-handle">
                <i class="fas fa-grip-vertical"></i>
            </div>
            
            <div class="card-image">
                <img src="${org.logo_desktop || '../assets/images/placeholder.png'}" 
                     alt="${org.name}"
                     onerror="this.src='../assets/images/placeholder.png'">
            </div>
            
            <div class="card-content">
                <h4 class="card-title">${org.name}</h4>
                <div class="card-meta">
                    <span class="meta-badge category-${org.category}">
                        ${org.category.toUpperCase()}
                    </span>
                    <span class="meta-badge status-${statusClass}">
                        <i class="fas fa-${statusIcon}"></i> ${statusText}
                    </span>
                </div>
                
                ${org.website_url && org.website_url !== '#' ? 
                    `<div class="card-link">
                        <i class="fas fa-link"></i>
                        <a href="${org.website_url}" target="_blank" class="website-link">
                            ${org.website_url.substring(0, 40)}${org.website_url.length > 40 ? '...' : ''}
                        </a>
                    </div>` : 
                    '<div class="card-link-empty">No website URL</div>'
                }
            </div>
            
            <div class="card-actions">
                <button class="action-btn btn-edit" onclick="openOtherSOModal('edit', ${org.id})" 
                        title="Edit">
                    <i class="fas fa-edit"></i>
                </button>
                <button class="action-btn btn-toggle" onclick="toggleOtherSOStatus(${org.id})" 
                        title="Toggle Status">
                    <i class="fas fa-power-off"></i>
                </button>
                <button class="action-btn btn-delete" onclick="deleteOtherSO(${org.id})" 
                        title="Delete">
                    <i class="fas fa-trash"></i>
                </button>
            </div>
        </div>`;
}

/**
 * Update Statistics
 */
function updateOtherSOStats(data) {
    const totalOrgs = data.length;
    const activeOrgs = data.filter(org => org.is_active == 1).length;
    const inactiveOrgs = totalOrgs - activeOrgs;
    
    const international = data.filter(org => org.category === 'international').length;
    const malaysia = data.filter(org => org.category === 'malaysia').length;
    const states = data.filter(org => org.category === 'state').length;
    
    // Update stat cards if they exist
    const statElements = {
        'totalOtherSO': totalOrgs,
        'activeOtherSO': activeOrgs,
        'inactiveOtherSO': inactiveOrgs,
        'internationalCount': international,
        'malaysiaCount': malaysia,
        'statesCount': states
    };
    
    Object.keys(statElements).forEach(id => {
        const element = document.getElementById(id);
        if (element) {
            element.textContent = statElements[id];
        }
    });
}

/**
 * ============================================================================
 * FORM SUBMISSION
 * ============================================================================
 */

/**
 * Handle Form Submission
 */
function submitOtherSOForm(event) {
    event.preventDefault();
    
    const form = document.getElementById('otherSOForm');
    const formData = new FormData(form);
    
    // Set action based on mode
    if (currentEditingId) {
        formData.append('action', 'edit');
        formData.append('id', currentEditingId);
    } else {
        formData.append('action', 'add');
    }
    
    // Get checkbox value
    const isActive = document.getElementById('otherSOStatus').checked ? 1 : 0;
    formData.set('is_active', isActive);
    
    // Show loading
    const submitBtn = form.querySelector('button[type="submit"]');
    const originalText = submitBtn.innerHTML;
    submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Saving...';
    submitBtn.disabled = true;
    
    fetch('handler/admin_other_so_handler.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(result => {
        if (result.success) {
            showNotification(result.message, 'success');
            closeOtherSOModal();
            loadOtherSpecialOlympics();
        } else {
            showNotification(result.message, 'error');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showNotification('Failed to save organization', 'error');
    })
    .finally(() => {
        submitBtn.innerHTML = originalText;
        submitBtn.disabled = false;
    });
}

/**
 * ============================================================================
 * DELETE OPERATION
 * ============================================================================
 */

/**
 * Delete Organization
 */
function deleteOtherSO(id) {
    const org = otherSOData.find(o => o.id == id);
    if (!org) return;
    
    if (confirm(`Are you sure you want to delete "${org.name}"?\n\nThis action cannot be undone.`)) {
        const formData = new FormData();
        formData.append('action', 'delete');
        formData.append('id', id);
        
        fetch('handler/admin_other_so_handler.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(result => {
            if (result.success) {
                showNotification(result.message, 'success');
                loadOtherSpecialOlympics();
            } else {
                showNotification(result.message, 'error');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showNotification('Failed to delete organization', 'error');
        });
    }
}

/**
 * ============================================================================
 * TOGGLE STATUS
 * ============================================================================
 */

/**
 * Toggle Organization Active Status
 */
function toggleOtherSOStatus(id) {
    const formData = new FormData();
    formData.append('action', 'toggle_status');
    formData.append('id', id);
    
    fetch('handler/admin_other_so_handler.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(result => {
        if (result.success) {
            showNotification(result.message, 'success');
            loadOtherSpecialOlympics();
        } else {
            showNotification(result.message, 'error');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showNotification('Failed to toggle status', 'error');
    });
}

/**
 * ============================================================================
 * DRAG & DROP SORTING
 * ============================================================================
 */

/**
 * Initialize Drag-Drop Sorting
 */
function initializeOtherSOSorting() {
    const grids = document.querySelectorAll('.other-so-grid');
    
    grids.forEach(grid => {
        new Sortable(grid, {
            animation: 150,
            handle: '.card-drag-handle',
            ghostClass: 'sortable-ghost',
            chosenClass: 'sortable-chosen',
            dragClass: 'sortable-drag',
            onEnd: function(evt) {
                updateOtherSOOrder(grid);
            }
        });
    });
}

/**
 * Update Display Order After Drag
 */
function updateOtherSOOrder(grid) {
    const cards = grid.querySelectorAll('.other-so-card');
    const order = Array.from(cards).map(card => parseInt(card.dataset.id));
    
    fetch('handler/admin_other_so_handler.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({
            action: 'update_order',
            order: order
        })
    })
    .then(response => response.json())
    .then(result => {
        if (result.success) {
            showNotification('Display order updated', 'success');
        } else {
            showNotification('Failed to update order', 'error');
            loadOtherSpecialOlympics(); // Reload to restore original order
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showNotification('Failed to update order', 'error');
        loadOtherSpecialOlympics();
    });
}

/**
 * ============================================================================
 * IMAGE PREVIEW
 * ============================================================================
 */

/**
 * Preview Desktop Logo
 */
function previewOtherSODesktopLogo(input) {
    const preview = document.getElementById('otherSODesktopPreview');
    const status = document.getElementById('otherSODesktopStatus');
    const deleteBtn = document.getElementById('deleteOtherSODesktopBtn');
    preview.innerHTML = '';
    
    if (input.files && input.files[0]) {
        const file = input.files[0];
        status.textContent = file.name;
        deleteBtn.style.display = 'inline-block';
        preview.style.display = 'block';
        
        const reader = new FileReader();
        reader.onload = function(e) {
            preview.innerHTML = `<img src="${e.target.result}" alt="Desktop Logo Preview" />`;
        };
        reader.readAsDataURL(file);
    } else {
        status.textContent = 'No file selected';
        deleteBtn.style.display = 'none';
        preview.style.display = 'none';
    }
}

/**
 * Preview Mobile Logo
 */
function previewOtherSOMobileLogo(input) {
    const preview = document.getElementById('otherSOMobilePreview');
    const status = document.getElementById('otherSOMobileStatus');
    const deleteBtn = document.getElementById('deleteOtherSOMobileBtn');
    preview.innerHTML = '';
    
    if (input.files && input.files[0]) {
        const file = input.files[0];
        status.textContent = file.name;
        deleteBtn.style.display = 'inline-block';
        preview.style.display = 'block';
        
        const reader = new FileReader();
        reader.onload = function(e) {
            preview.innerHTML = `<img src="${e.target.result}" alt="Mobile Logo Preview" />`;
        };
        reader.readAsDataURL(file);
    } else {
        status.textContent = 'No file selected';
        deleteBtn.style.display = 'none';
        preview.style.display = 'none';
    }
}

/**
 * ============================================================================
 * FILTER & SEARCH
 * ============================================================================
 */

/**
 * Filter by Category
 */
function filterOtherSOByCategory(category) {
    if (category === 'all') {
        displayOtherSpecialOlympics(otherSOData);
    } else {
        const filtered = otherSOData.filter(org => org.category === category);
        displayOtherSpecialOlympics(filtered);
    }
    
    // Update active filter button
    document.querySelectorAll('.filter-btn').forEach(btn => {
        btn.classList.remove('active');
    });
    event.target.classList.add('active');
}

/**
 * Search Organizations
 */
function searchOtherSO(searchTerm) {
    const term = searchTerm.toLowerCase();
    const filtered = otherSOData.filter(org => 
        org.name.toLowerCase().includes(term) ||
        org.category.toLowerCase().includes(term) ||
        (org.website_url && org.website_url.toLowerCase().includes(term))
    );
    displayOtherSpecialOlympics(filtered);
}

/**
 * Remove Selected Desktop Logo
 */
function removeOtherSODesktopLogo() {
    const input = document.getElementById('otherSODesktopLogo');
    const preview = document.getElementById('otherSODesktopPreview');
    const status = document.getElementById('otherSODesktopStatus');
    const deleteBtn = document.getElementById('deleteOtherSODesktopBtn');
    
    input.value = '';
    preview.innerHTML = '';
    preview.style.display = 'none';
    status.textContent = 'No file selected';
    deleteBtn.style.display = 'none';
}

/**
 * Remove Selected Mobile Logo
 */
function removeOtherSOMobileLogo() {
    const input = document.getElementById('otherSOMobileLogo');
    const preview = document.getElementById('otherSOMobilePreview');
    const status = document.getElementById('otherSOMobileStatus');
    const deleteBtn = document.getElementById('deleteOtherSOMobileBtn');
    
    input.value = '';
    preview.innerHTML = '';
    preview.style.display = 'none';
    status.textContent = 'No file selected';
    deleteBtn.style.display = 'none';
}

/**
 * ============================================================================
 * UTILITY FUNCTIONS
 * ============================================================================
 */

/**
 * Standardized Notification System
 */
function showNotification(message, type = 'info') {
    // Use global notification system from admin panel
    if (typeof window.showNotification === 'function') {
        window.showNotification(message, type);
    } else {
        console.warn('Global showNotification not found, using fallback');
        const notification = document.createElement('div');
        notification.className = `notification-toast ${type}`;
        notification.style.cssText = `
            position: fixed; top: 20px; right: 20px; padding: 16px 24px;
            background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
            color: white; border-radius: 12px; font-weight: 500; z-index: 999999;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
            font-family: 'Inter', sans-serif; font-size: 14px;
        `;
        notification.textContent = message;
        document.body.appendChild(notification);
        setTimeout(() => notification.remove(), 3000);
    }
}
