/**
 * Sponsorship Management System
 * Handles chapter-based sponsorship grouping with tabs, tiers, and CRUD operations
 * 
 * Notification System:
 * - Uses global window.showNotification() from admin_panel_soswk.php
 * - Supports types: 'success', 'error', 'warning', 'info'
 * - Auto-dismisses after 3 seconds with smooth animations
 * - Styled with green gradient for success, red for errors
 * 
 * @version 2.0
 */

// Prevent multiple initialization
if (window.sponsorshipManagementInitialized) {
    console.warn('Sponsorship management already loaded, skipping re-initialization');
} else {
    window.sponsorshipManagementInitialized = true;

(function() {
    'use strict';

    console.log('Sponsorship Management System loading...');

    // State management
    const state = {
        sponsors: [],
        currentFilter: 'all',
        isLoading: false,
        initialized: false
    };

    // DOM element cache
    const elements = {};

    /**
     * Initialize the sponsorship management system
     */
    function init() {
        if (state.initialized) {
            console.warn('Sponsorship management already initialized');
            return;
        }
        
        console.log('Initializing sponsorship management...');
        state.initialized = true;
        cacheElements();
        
        // Check if essential elements exist
        if (!elements.container) {
            console.error('Sponsorship container not found! Cannot initialize.');
            return;
        }
        
        console.log('Elements cached successfully');
        attachEventListeners();
        console.log('Event listeners attached');
        loadSponsors();
        console.log('Loading sponsors...');
    }

    /**
     * Cache DOM elements for better performance
     */
    function cacheElements() {
        elements.form = document.getElementById('sponsorshipForm');
        elements.imageInput = document.getElementById('sponsorshipImage');
        elements.imagePreview = document.getElementById('sponsorshipImagePreview');
        elements.imageStatus = document.getElementById('sponsorshipImageStatus');
        elements.deleteImageBtn = document.getElementById('deleteSponsorshipImageBtn');
        elements.container = document.getElementById('currentSponsorship');
        elements.modal = document.getElementById('sponsorshipModal');
    }

    /**
     * Attach all event listeners
     */
    function attachEventListeners() {
        // Form submission
        if (elements.form) {
            elements.form.addEventListener('submit', handleFormSubmit, false);
        }

        // Image input
        if (elements.imageInput) {
            elements.imageInput.addEventListener('change', handleImageChange, false);
        }

        // Delete image button
        if (elements.deleteImageBtn) {
            elements.deleteImageBtn.addEventListener('click', handleImageDelete, false);
        }

        // Cancel edit button
        const cancelEditBtn = document.getElementById('cancelEditBtn');
        if (cancelEditBtn) {
            cancelEditBtn.addEventListener('click', closeModal, false);
        }

        // NUCLEAR OPTION: Event delegation at DOCUMENT level
        console.log('📌 Attaching delegation at DOCUMENT level (not container)');
        
        // Remove any existing document-level sponsorship listeners
        document.removeEventListener('click', handleSponsorAction, true);
        document.removeEventListener('click', handleSponsorAction, false);
        
        // Attach at document level with capture phase - catches EVERYTHING
        document.addEventListener('click', handleSponsorAction, true);
        console.log('✅ Document-level delegation attached (CAPTURE PHASE)');
    }

    /**
     * Handle sponsor action clicks (edit/delete)
     * NOW ATTACHED AT DOCUMENT LEVEL - must filter for sponsorship section only
     */
    function handleSponsorAction(e) {
        // ONLY handle clicks within sponsorship grid
        if (!e.target.closest('.sponsorship-grid')) {
            return; // Not a sponsorship button, ignore
        }
        
        console.log('🎯 DELEGATION HANDLER FIRED (Document Level)');
        console.log('Event target:', e.target);
        console.log('Event currentTarget:', e.currentTarget);
        
        // Check if clicked element is a button or inside a button
        const editBtn = e.target.closest('.edit-btn');
        const deleteBtn = e.target.closest('.delete-btn');

        console.log('✓ editBtn found:', editBtn);
        console.log('✓ deleteBtn found:', deleteBtn);

        if (editBtn) {
            console.log('🎉 EDIT BUTTON MATCHED!');
            e.preventDefault();
            e.stopPropagation();
            const sponsorId = editBtn.getAttribute('data-id');
            console.log('📝 Sponsor ID from data-id:', sponsorId);
            
            if (sponsorId) {
                console.log('✅ Calling editSponsor with ID:', sponsorId);
                try {
                    editSponsor(parseInt(sponsorId));
                } catch (error) {
                    console.error('❌ Error in editSponsor:', error);
                    showNotification('Error opening edit modal', 'error');
                }
            } else {
                console.error('❌ No sponsor ID found on button');
            }
            return false;
        }

        if (deleteBtn) {
            console.log('🎉 DELETE BUTTON MATCHED!');
            e.preventDefault();
            e.stopPropagation();
            const sponsorId = deleteBtn.getAttribute('data-id');
            console.log('🗑️ Sponsor ID from data-id:', sponsorId);
            
            if (sponsorId) {
                console.log('✅ Calling deleteSponsor with ID:', sponsorId);
                try {
                    deleteSponsor(parseInt(sponsorId));
                } catch (error) {
                    console.error('❌ Error in deleteSponsor:', error);
                    showNotification('Error deleting sponsor', 'error');
                }
            } else {
                console.error('❌ No sponsor ID found on button');
            }
            return false;
        }
        
        console.log('⚠️ Click in sponsorship grid but not on edit/delete button');
    }

    function loadSponsors() {
        if (!elements.container || state.isLoading) return;

        state.isLoading = true;
        elements.container.innerHTML = '<p style="text-align: center; color: #64748b; padding: 40px;">Loading sponsors...</p>';

        fetch('./handler/admin_sponsorship_handler.php?action=fetch&_=' + Date.now())
            .then(response => {
                if (!response.ok) throw new Error('Network error');
                return response.json();
            })
            .then(data => {
                if (data.success) {
                    state.sponsors = data.sponsorships || [];
                    updateStats(data.stats);
                    renderSponsors();
                } else {
                    showError('Failed to load sponsors');
                }
            })
            .catch(error => {
                console.error('Load error:', error);
                showError('Failed to load sponsors. Please refresh.');
            })
            .finally(() => {
                state.isLoading = false;
            });
    }

    function updateStats(stats) {
        if (!stats) {
            stats = {
                total: state.sponsors.length,
                state_level: state.sponsors.filter(s => !s.chapter_id || s.chapter_id == 0).length,
                chapter_level: state.sponsors.filter(s => s.chapter_id && s.chapter_id != 0).length
            };
        }

        const ids = ['totalSponsorsCount', 'stateSponsorsCount', 'chapterSponsorsCount'];
        const values = [stats.total || 0, stats.state_level || 0, stats.chapter_level || 0];
        
        ids.forEach((id, index) => {
            const el = document.getElementById(id);
            if (el) el.textContent = values[index];
        });
    }

    function renderSponsors() {
        if (!elements.container) return;

        const filteredSponsors = filterSponsors();
        updateFilterHeader(filteredSponsors.length);
        elements.container.innerHTML = '';

        if (filteredSponsors.length === 0) {
            elements.container.innerHTML = `
                <div style="grid-column: 1 / -1; text-align: center; padding: 40px; color: #64748b;">
                    <i class="fas fa-handshake" style="font-size: 48px; margin-bottom: 16px; opacity: 0.5;"></i>
                    <p>No sponsors found for this category.</p>
                    <button onclick="openSponsorshipModal()" style="margin-top: 16px; padding: 10px 20px; background: #e53935; color: white; border: none; border-radius: 8px; cursor: pointer;">
                        <i class="fas fa-plus"></i> Add First Sponsor
                    </button>
                </div>
            `;
            return;
        }

        const fragment = document.createDocumentFragment();
        filteredSponsors.forEach(sponsor => {
            fragment.appendChild(createSponsorCard(sponsor));
        });
        elements.container.appendChild(fragment);
        
        // Event delegation at container level handles all button clicks
        // No need to attach individual listeners
    }

    function filterSponsors() {
        const filter = state.currentFilter;
        if (filter === 'all') return state.sponsors;
        if (filter === '0') {
            return state.sponsors.filter(s => !s.chapter_id || s.chapter_id == 0 || s.chapter_id === '0');
        }
        return state.sponsors.filter(s => String(s.chapter_id) === String(filter));
    }

    function updateFilterHeader(count) {
        const chapterNames = {
            '0': 'Special Olympics Sarawak', '1': 'Kuching Chapter', '2': 'Samarahan Chapter',
            '3': 'Sibu Chapter', '4': 'Bintulu Chapter', '5': 'Miri Chapter'
        };

        const titleEl = document.getElementById('sponsorshipListTitle');
        const countEl = document.getElementById('currentFilterCount');

        if (titleEl) {
            titleEl.textContent = state.currentFilter === 'all' ? 'All Sponsors' : (chapterNames[state.currentFilter] || 'Sponsors');
        }
        if (countEl) {
            countEl.textContent = `${count} sponsor${count !== 1 ? 's' : ''}`;
        }
    }

    function createSponsorCard(sponsor) {
        const chapterCities = {'0': 'State Level', '1': 'Kuching', '2': 'Samarahan', '3': 'Sibu', '4': 'Bintulu', '5': 'Miri'};
        
        const card = document.createElement('div');
        card.className = 'sponsorship-item-admin';
        card.setAttribute('data-sponsorship-id', sponsor.id);
        card.setAttribute('data-chapter-id', sponsor.chapter_id || '0');

        let chapterDisplay = (!sponsor.chapter_id || sponsor.chapter_id == 0) ? 'State Level' : 
                           (sponsor.city || chapterCities[sponsor.chapter_id] || 'State Level');

        const tierClass = sponsor.sponsor_tier || 'supporter';
        const tierDisplay = tierClass.charAt(0).toUpperCase() + tierClass.slice(1);
        
        let imageSrc = sponsor.image_path || 'https://via.placeholder.com/150?text=No+Logo';
        if (imageSrc && !imageSrc.startsWith('http') && !imageSrc.startsWith('data:')) {
            imageSrc = imageSrc.startsWith('/') ? '..' + imageSrc : 
                      (imageSrc.startsWith('../') ? imageSrc : '../' + imageSrc);
        }

        const escapeHtml = (text) => String(text).replace(/[&<>"']/g, m => ({'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;',"'":'&#039;'}[m]));

        card.innerHTML = `
            <div class="sponsor-logo-container">
                <img src="${imageSrc}" alt="${escapeHtml(sponsor.sponsor_name || 'Sponsor')}" onerror="this.src='https://via.placeholder.com/150?text=No+Logo'">
            </div>
            <div class="sponsor-info">
                <div class="sponsor-name">${escapeHtml(sponsor.sponsor_name || sponsor.type || 'Sponsor')}</div>
                <div class="sponsor-chapter"><i class="fas fa-map-marker-alt"></i> ${escapeHtml(chapterDisplay)}</div>
                <span class="sponsor-tier ${tierClass}">${tierDisplay}</span>
            </div>
            <div class="sponsor-actions">
                <button class="edit-btn" type="button" title="Edit Sponsor" data-id="${sponsor.id}">
                    <i class="fas fa-pencil"></i> Edit
                </button>
                <button class="delete-btn" type="button" title="Delete Sponsor" data-id="${sponsor.id}">
                    <i class="fas fa-trash"></i> Delete
                </button>
            </div>
        `;

        // Event delegation handles all clicks at container level


        return card;
    }

    function editSponsor(sponsorId) {
        console.log('editSponsor called with ID:', sponsorId);
        console.log('Current sponsors in state:', state.sponsors.length);
        
        const sponsor = state.sponsors.find(s => String(s.id) === String(sponsorId));
        if (!sponsor) {
            console.error('Sponsor not found in state for ID:', sponsorId);
            showNotification('Sponsor not found', 'error');
            return;
        }

        console.log('Sponsor found:', sponsor);
        
        try {
            setModalMode('edit');
            populateForm(sponsor);
            openModal();
            console.log('Modal opened successfully');
        } catch (error) {
            console.error('Error in editSponsor:', error);
            showNotification('Error opening edit form', 'error');
        }
    }

    function setModalMode(mode) {
        const modalTitle = document.querySelector('#sponsorshipModal .modal-title');
        const submitBtn = document.getElementById('submitSponsorshipBtn');
        const cancelEditBtn = document.getElementById('cancelEditBtn');

        if (mode === 'edit') {
            if (modalTitle) modalTitle.textContent = 'Edit Sponsor';
            if (submitBtn) submitBtn.textContent = 'Update Sponsor';
            if (cancelEditBtn) cancelEditBtn.style.display = 'inline-block';
        } else {
            if (modalTitle) modalTitle.textContent = 'Add New Sponsor';
            if (submitBtn) submitBtn.textContent = 'Add Sponsor';
            if (cancelEditBtn) cancelEditBtn.style.display = 'none';
        }
    }

    function populateForm(sponsor) {
        const fields = {
            sponsorshipId: sponsor.id,
            sponsorshipName: sponsor.sponsor_name || '',
            sponsorshipChapter: sponsor.chapter_id === null ? '0' : String(sponsor.chapter_id),
            sponsorshipTier: sponsor.sponsor_tier || 'supporter',
            sponsorshipOrder: sponsor.display_order || 0
        };

        for (const [id, value] of Object.entries(fields)) {
            const field = document.getElementById(id);
            if (field) field.value = value;
        }

        if (sponsor.image_path) {
            let imgSrc = sponsor.image_path;
            if (!imgSrc.startsWith('http') && !imgSrc.startsWith('/')) {
                imgSrc = imgSrc.startsWith('../') ? imgSrc : '../' + imgSrc;
            }

            const currentImage = document.getElementById('currentSponsorshipImage');
            if (currentImage) currentImage.value = sponsor.image_path;
            
            if (elements.imagePreview) {
                const previewImg = elements.imagePreview.querySelector('img');
                if (previewImg) previewImg.src = imgSrc;
                elements.imagePreview.style.display = 'block';
            }
            if (elements.imageStatus) elements.imageStatus.textContent = 'Current logo loaded';
            if (elements.deleteImageBtn) elements.deleteImageBtn.style.display = 'inline-flex';
        }
    }

    function deleteSponsor(sponsorId) {
        if (!confirm('Are you sure you want to delete this sponsor?')) return;

        fetch('./handler/admin_sponsorship_handler.php', {
            method: 'POST',
            headers: {'Content-Type': 'application/x-www-form-urlencoded'},
            body: `action=delete&id=${sponsorId}`
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showNotification('Sponsor deleted successfully!', 'success');
                loadSponsors();
            } else {
                showNotification('Error: ' + (data.message || 'Failed to delete'), 'error');
            }
        })
        .catch(() => showNotification('An error occurred', 'error'));
    }

    function handleFormSubmit(e) {
        e.preventDefault();

        const formData = new FormData(e.target);
        const sponsorshipId = document.getElementById('sponsorshipId').value;
        const action = sponsorshipId ? 'edit' : 'add';
        formData.append('action', action);

        const submitBtn = document.getElementById('submitSponsorshipBtn');
        const originalText = submitBtn ? submitBtn.textContent : '';
        
        if (submitBtn) {
            submitBtn.textContent = action === 'edit' ? 'Updating...' : 'Adding...';
            submitBtn.disabled = true;
        }

        fetch('./handler/admin_sponsorship_handler.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showNotification(`Sponsor ${action === 'edit' ? 'updated' : 'added'} successfully!`, 'success');
                closeModal();
                loadSponsors();
            } else {
                showNotification('Error: ' + (data.message || 'Operation failed'), 'error');
            }
        })
        .catch(() => showNotification('An error occurred', 'error'))
        .finally(() => {
            if (submitBtn) {
                submitBtn.textContent = originalText;
                submitBtn.disabled = false;
            }
        });
    }

    function handleImageChange(e) {
        const file = e.target.files[0];
        if (!file) return;

        if (!file.type.startsWith('image/')) {
            showNotification('Please select an image file.', 'error');
            e.target.value = '';
            return;
        }

        if (file.size > 5 * 1024 * 1024) {
            showNotification('Image size must be less than 5MB.', 'error');
            e.target.value = '';
            return;
        }

        if (elements.imageStatus) elements.imageStatus.textContent = file.name;

        const reader = new FileReader();
        reader.onload = function(e) {
            if (elements.imagePreview) {
                const previewImg = elements.imagePreview.querySelector('img');
                if (previewImg) {
                    previewImg.src = e.target.result;
                    elements.imagePreview.style.display = 'block';
                }
            }
        };
        reader.readAsDataURL(file);

        if (elements.deleteImageBtn) elements.deleteImageBtn.style.display = 'inline-flex';
    }

    function handleImageDelete() {
        if (elements.imageInput) elements.imageInput.value = '';
        if (elements.imagePreview) {
            elements.imagePreview.style.display = 'none';
            const previewImg = elements.imagePreview.querySelector('img');
            if (previewImg) previewImg.src = '';
        }
        if (elements.imageStatus) elements.imageStatus.textContent = 'No file selected';
        if (elements.deleteImageBtn) elements.deleteImageBtn.style.display = 'none';

        const currentImage = document.getElementById('currentSponsorshipImage');
        if (currentImage) currentImage.value = '';
    }

    window.filterSponsorshipsByChapter = function(chapterId) {
        state.currentFilter = String(chapterId);
        document.querySelectorAll('.sponsorship-tab').forEach(tab => {
            tab.classList.remove('active');
            if (tab.getAttribute('data-chapter') === chapterId) tab.classList.add('active');
        });
        renderSponsors();
    };

    window.openSponsorshipModal = function() {
        console.log('openSponsorshipModal called');
        try {
            resetForm();
            setModalMode('add');
            openModal();
            console.log('Add modal opened successfully');
        } catch (error) {
            console.error('Error opening add modal:', error);
            alert('Error opening modal: ' + error.message);
        }
    };

    window.closeSponsorshipModal = function() {
        console.log('closeSponsorshipModal called');
        try {
            closeModal();
        } catch (error) {
            console.error('Error closing modal:', error);
        }
    };

    // Expose edit and delete functions globally for onclick handlers
    window.editSponsor = function(sponsorId) {
        editSponsor(sponsorId);
    };

    window.deleteSponsor = function(sponsorId) {
        deleteSponsor(sponsorId);
    };

    function openModal() {
        console.log('openModal called, modal element:', elements.modal);
        if (elements.modal) {
            elements.modal.classList.add('show');
            document.body.style.overflow = 'hidden';
            console.log('Modal show class added');
        } else {
            console.error('Modal element not found!');
            alert('Modal element not found! Please refresh the page.');
        }
    }

    function closeModal() {
        if (elements.modal) {
            elements.modal.classList.remove('show');
            document.body.style.overflow = '';
            resetForm();
        }
    }

    function resetForm() {
        if (elements.form) elements.form.reset();

        ['sponsorshipId', 'currentSponsorshipImage'].forEach(id => {
            const field = document.getElementById(id);
            if (field) field.value = '';
        });

        if (elements.imagePreview) {
            elements.imagePreview.style.display = 'none';
            const previewImg = elements.imagePreview.querySelector('img');
            if (previewImg) previewImg.src = '';
        }
        if (elements.imageStatus) elements.imageStatus.textContent = 'No file selected';
        if (elements.deleteImageBtn) elements.deleteImageBtn.style.display = 'none';

        const chapterSelect = document.getElementById('sponsorshipChapter');
        const tierSelect = document.getElementById('sponsorshipTier');
        if (chapterSelect) chapterSelect.value = '';
        if (tierSelect) tierSelect.value = 'supporter';
    }

    /**
     * Standardized notification system - uses global function if available
     */
    function showNotification(message, type = 'success') {
        // Use global notification system from admin panel
        if (typeof window.showNotification === 'function') {
            window.showNotification(message, type);
            return;
        }

        // Fallback notification (should rarely be used)
        console.warn('Global showNotification not found, using fallback');
        const notification = document.createElement('div');
        notification.className = `notification-toast ${type}`;
        notification.style.cssText = `
            position: fixed; top: 20px; right: 20px; padding: 16px 24px;
            background: ${type === 'success' ? 'linear-gradient(135deg, #10b981 0%, #059669 100%)' : 'linear-gradient(135deg, #ef4444 0%, #dc2626 100%)'};
            color: white; border-radius: 12px; font-weight: 500; z-index: 999999;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
            font-family: 'Inter', sans-serif; font-size: 14px;
            animation: slideInRight 0.4s cubic-bezier(0.68, -0.55, 0.265, 1.55);
        `;
        notification.textContent = message;
        document.body.appendChild(notification);
        setTimeout(() => {
            notification.style.animation = 'fadeOut 0.3s ease forwards';
            setTimeout(() => notification.remove(), 300);
        }, 3000);
    }

    function showError(message) {
        if (elements.container) {
            elements.container.innerHTML = `
                <p style="text-align: center; color: #ef4444; padding: 40px;">
                    <i class="fas fa-exclamation-triangle" style="font-size: 48px; margin-bottom: 16px;"></i><br>
                    ${message}
                </p>
            `;
        }
    }

    // Initialize
    if (document.readyState === 'loading') {
        console.log('DOM still loading, waiting for DOMContentLoaded...');
        document.addEventListener('DOMContentLoaded', init);
    } else {
        console.log('DOM already loaded, initializing immediately...');
        init();
    }

})(); // End of IIFE

} // End of initialization guard
