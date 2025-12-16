// Sarawak Chapters Management JavaScript for Admin Panel
// Force global availability
window.loadChapters = function() {
    const existingChaptersContainer = document.getElementById('existingChapters');
    
    if (!existingChaptersContainer) {
        return;
    }
    
    fetch('handler/admin_chapters_handler.php?action=fetch_chapters')
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(data => {
            if (data.success) {
                existingChaptersContainer.innerHTML = '';
                
                // Update statistics
                updateChapterStatistics(data.chapters || []);
                
                if (data.chapters && data.chapters.length > 0) {
                    data.chapters.forEach(chapter => {
                        const chapterItem = document.createElement('div');
                        chapterItem.classList.add('chapter-item-admin');
                        chapterItem.setAttribute('data-id', chapter.id);
                        chapterItem.id = 'chapter-' + chapter.id;
                        
                        const statusBadge = getStatusBadge(chapter.status);
                        
                        // Refurbished card structure - cleaner HTML
                        chapterItem.innerHTML = `
                            <div class="chapter-card-header">
                                <div class="chapter-logo-admin">
                                    <img src="${chapter.logo_path}" 
                                         alt="${chapter.chapter_name} Logo" 
                                         class="chapter-logo-img" 
                                         onerror="this.style.display='none'; this.parentNode.innerHTML='<i class=\\'fas fa-building\\' style=\\'color:#cbd5e1;font-size:36px;\\'></i>';">
                                </div>
                                <div class="chapter-header-content">
                                    <div class="chapter-item-admin-header">
                                        <h4 class="chapter-item-admin-title">${chapter.chapter_name}</h4>
                                        <span class="chapter-status-badge ${chapter.status}">${statusBadge}</span>
                                    </div>
                                    <div class="chapter-location-badge">
                                        <i class="fas fa-map-marker-alt"></i>
                                        ${chapter.city}
                                    </div>
                                </div>
                            </div>
                            
                            <div class="chapter-leadership-info">
                                <div class="leadership-header">
                                    <i class="fas fa-users-cog"></i>
                                    Board of Directors
                                </div>
                                <div class="leadership-grid">
                                    <div class="leadership-row">
                                        <strong>Chairman:</strong> 
                                        <span class="chairman-text">${chapter.chairman || 'TBD'}</span>
                                    </div>
                                    <div class="leadership-row">
                                        <strong>Vice Chairman:</strong> 
                                        <span class="vice-chairman-text">${chapter.vice_chairman || 'TBD'}</span>
                                    </div>
                                    <div class="leadership-row">
                                        <strong>Secretary:</strong> 
                                        <span class="secretary-text">${chapter.secretary || 'TBD'}</span>
                                    </div>
                                    <div class="leadership-row">
                                        <strong>Treasurer:</strong> 
                                        <span class="treasurer-text">${chapter.treasurer || 'TBD'}</span>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="chapter-item-admin-actions">
                                <button type="button" class="edit-btn" data-chapter-id="${chapter.id}" onclick="window.editChapter(${chapter.id}); return false;">
                                    <i class="fas fa-edit"></i>
                                    <span>Edit Chapter</span>
                                </button>
                            </div>
                        `;
                        
                        existingChaptersContainer.appendChild(chapterItem);
                    });
                } else {
                    existingChaptersContainer.innerHTML = `
                        <div class="chapters-loading">
                            <i class="fas fa-building"></i>
                            <p>No chapters found</p>
                        </div>
                    `;
                }
            } else {
                console.error('Error loading chapters:', data.message);
                existingChaptersContainer.innerHTML = '<p style="text-align: center; color: #e63946;">Error loading chapters. Please try again.</p>';
            }
        })
        .catch(error => {
            console.error('Error loading chapters:', error);
            console.error('Error details:', error.message);
            existingChaptersContainer.innerHTML = '<p style="text-align: center; color: #e63946;">Error loading chapters: ' + error.message + '</p>';
        });
};

function countLeaders(chapter) {
    let count = 0;
    if (chapter.chairman) count++;
    if (chapter.vice_chairman) count++;
    if (chapter.secretary) count++;
    if (chapter.treasurer) count++;
    return count;
}

function updateChapterStatistics(chapters) {
    const totalCount = chapters.length;
    const activeCount = chapters.filter(c => c.status === 'active').length;
    const leadersCount = chapters.reduce((sum, c) => sum + countLeaders(c), 0);
    
    const totalEl = document.getElementById('chapterTotalCount');
    const activeEl = document.getElementById('chapterActiveCount');
    const leadersEl = document.getElementById('chapterLeadersCount');
    
    if (totalEl) totalEl.textContent = totalCount;
    if (activeEl) activeEl.textContent = activeCount;
    if (leadersEl) leadersEl.textContent = leadersCount;
}

function getStatusBadge(status) {
    switch (status) {
        case 'active': return 'Active';
        case 'upcoming': return 'Upcoming';
        case 'inactive': return 'Inactive';
        default: return 'Active';
    }
}

document.addEventListener('DOMContentLoaded', function() {
    console.log('Chapters management script loaded');
    
    // Global click handler for edit buttons
    document.addEventListener('click', function(e) {
        const editBtn = e.target.closest('.edit-btn');
        if (editBtn && editBtn.classList.contains('edit-btn')) {
            e.preventDefault();
            e.stopPropagation();
            
            const chapterId = editBtn.getAttribute('data-chapter-id') || editBtn.dataset.chapterId;
            
            if (chapterId && chapterId !== 'null') {
                window.editChapter(chapterId);
            } else {
                // Fallback: extract from parent card ID
                const chapterCard = editBtn.closest('.chapter-item-admin');
                if (chapterCard && chapterCard.id && chapterCard.id.startsWith('chapter-')) {
                    const extractedId = chapterCard.id.replace('chapter-', '');
                    window.editChapter(extractedId);
                }
            }
        }
    }, true);
    
    // Ensure modal exists - check and create if needed
    setTimeout(() => {
        let modal = document.getElementById('chapterModal');
        if (!modal) {
            createChapterModalDynamic();
        }
    }, 100);
    
    // Also listen for when the Sarawak Chapters section becomes active
    const sarawakChaptersNavItem = document.querySelector('[data-section="sarawak-chapters"]');
    if (sarawakChaptersNavItem) {
        sarawakChaptersNavItem.addEventListener('click', function() {
            setTimeout(() => {
                window.loadChapters();
            }, 100);
        });
    }

    // Load chapters on page load if element exists
    setTimeout(() => {
        const existingChaptersContainer = document.getElementById('existingChapters');
        if (existingChaptersContainer) {
            window.loadChapters();
        }
    }, 500);
    
    const participantsOverviewContainer = document.getElementById('participantsOverview');
    if (participantsOverviewContainer) {
        loadParticipantsData();
    }



    function loadParticipantsData() {
        if (!participantsOverviewContainer) return;
        
        fetch('handler/admin_chapters_handler.php?action=fetch_participants')
            .then(response => response.json())
            .then(data => {
                if (data.success && data.participants) {
                    displayParticipantsOverview(data.participants);
                }
            })
            .catch(error => {
                console.error('Error loading participants:', error);
            });
    }

    function displayParticipantsOverview(participants) {
        if (!participantsOverviewContainer) return;
        
        let html = '<h4>Participants by Chapter</h4>';
        participants.forEach(participant => {
            html += `
                <div class="participant-overview-item">
                    <h5>${participant.chapter_name}</h5>
                    <p>Total: ${participant.total_participants || 0}</p>
                </div>
            `;
        });
        participantsOverviewContainer.innerHTML = html;
    }

    // Debug function
    window.debugChapters = function() {
        console.log('=== CHAPTER DEBUG INFO ===');
        console.log('Container:', document.getElementById('existingChapters'));
        console.log('Chapters found:', document.querySelectorAll('.chapter-item-admin').length);
        
        // Check if modal exists in HTML
        console.log('Checking modal...');
        const modal = document.getElementById('chapterModal');
        console.log('Modal exists:', !!modal);
        if (modal) {
            console.log('Modal display:', modal.style.display);
            console.log('Modal classes:', modal.className);
        } else {
            console.log('Modal NOT FOUND - will be created on first edit click');
        }
        
        // Test edit button
        const firstEditBtn = document.querySelector('.edit-btn');
        console.log('First edit button found:', !!firstEditBtn);
        if (firstEditBtn) {
            console.log('Button onclick:', firstEditBtn.getAttribute('onclick'));
        }
    };
    
    // Global test function
    window.testChapterModal = function() {
        console.log('Testing modal creation...');
        createChapterModalDynamic();
        const modal = document.getElementById('chapterModal');
        if (modal) {
            console.log('✅ Modal created successfully!');
            modal.classList.add('show');
            modal.style.display = 'block';
            console.log('Modal should be visible now');
        } else {
            console.error('❌ Failed to create modal');
        }
    };
    
    // Test edit button clicks
    window.testEditButtons = function() {
        console.log('=== TESTING EDIT BUTTONS ===');
        const editButtons = document.querySelectorAll('.chapter-item-admin .edit-btn');
        console.log('Edit buttons found:', editButtons.length);
        
        editButtons.forEach((btn, index) => {
            console.log(`Button ${index + 1}:`, {
                'data-chapter-id': btn.getAttribute('data-chapter-id'),
                'onclick': btn.getAttribute('onclick'),
                'has event listeners': btn.onclick !== null,
                'cursor style': window.getComputedStyle(btn).cursor,
                'pointer-events': window.getComputedStyle(btn).pointerEvents,
                'z-index': window.getComputedStyle(btn).zIndex
            });
        });
        
        if (editButtons.length > 0) {
            console.log('Attempting to click first button programmatically...');
            editButtons[0].click();
        }
    };
});

// Global functions for modal management
window.editChapter = function editChapter(chapterId) {
    const chapterElement = document.getElementById('chapter-' + chapterId);
    if (!chapterElement) {
        // Try finding by data-id attribute instead
        const altElement = document.querySelector(`.chapter-item-admin[data-id="${chapterId}"]`);
        if (altElement) {
            return editChapterByElement(altElement, chapterId);
        }
        
        alert('Chapter not found! Please refresh the page.');
        return;
    }
    
    editChapterByElement(chapterElement, chapterId);
};

// Helper function to edit chapter by element
function editChapterByElement(chapterElement, chapterId) {
    // Extract data from card
    const titleElement = chapterElement.querySelector('.chapter-item-admin-title');
    const logoImg = chapterElement.querySelector('.chapter-logo-img');
    const chairmanElement = chapterElement.querySelector('.chairman-text');
    const viceChairmanElement = chapterElement.querySelector('.vice-chairman-text');
    const secretaryElement = chapterElement.querySelector('.secretary-text');
    const treasurerElement = chapterElement.querySelector('.treasurer-text');
    const statusElement = chapterElement.querySelector('.chapter-status-badge');
    
    const chapterData = {
        id: chapterId,
        name: titleElement ? titleElement.textContent : '',
        logo: logoImg ? logoImg.src : '',
        chairman: chairmanElement ? chairmanElement.textContent.trim() : '',
        vice_chairman: viceChairmanElement ? viceChairmanElement.textContent.trim() : '',
        secretary: secretaryElement ? secretaryElement.textContent.trim() : '',
        treasurer: treasurerElement ? treasurerElement.textContent.trim() : '',
        status: statusElement && statusElement.classList.contains('upcoming') ? 'upcoming' : 
                statusElement && statusElement.classList.contains('inactive') ? 'inactive' : 'active'
    };
    
    // Ensure modal exists
    let modal = document.getElementById('chapterModal');
    if (!modal) {
        createChapterModalDynamic();
        modal = document.getElementById('chapterModal');
        if (!modal) {
            alert('Error: Unable to open edit form. Please refresh the page.');
            return;
        }
    }
    
    // Populate modal fields
    const modalLogo = document.getElementById('modalChapterLogo');
    const editChairman = document.getElementById('editChairman');
    const editViceChairman = document.getElementById('editViceChairman');
    const editSecretary = document.getElementById('editSecretary');
    const editTreasurer = document.getElementById('editTreasurer');
    const editStatus = document.getElementById('editStatus');
    
    if (modalLogo && chapterData.logo) {
        modalLogo.src = chapterData.logo;
        modalLogo.alt = chapterData.name + ' Logo';
    }
    if (editChairman) editChairman.value = chapterData.chairman === 'TBD' ? '' : chapterData.chairman;
    if (editViceChairman) editViceChairman.value = chapterData.vice_chairman === 'TBD' ? '' : chapterData.vice_chairman;
    if (editSecretary) editSecretary.value = chapterData.secretary === 'TBD' ? '' : chapterData.secretary;
    if (editTreasurer) editTreasurer.value = chapterData.treasurer === 'TBD' ? '' : chapterData.treasurer;
    if (editStatus) editStatus.value = chapterData.status;
    
    // Store chapter ID
    modal.setAttribute('data-chapter-id', chapterId);
    
    // Show the modal
    modal.style.display = 'block';
    modal.classList.add('show');
    document.body.style.overflow = 'hidden';
    
    // Force repaint
    modal.offsetHeight;
}

// Create modal dynamically if it doesn't exist
window.createChapterModalDynamic = function createChapterModalDynamic() {
    console.log('Creating chapter modal dynamically...');
    
    // Remove existing modal if any
    const existingModal = document.getElementById('chapterModal');
    if (existingModal) {
        existingModal.remove();
    }
    
    const modalHTML = `
        <div class="chapter-modal" id="chapterModal" style="display: none;">
            <div class="chapter-modal-backdrop" onclick="closeChapterModal()"></div>
            <div class="chapter-modal-content">
                <div class="chapter-modal-header">
                    <h3>Edit Chapter Information</h3>
                    <span class="chapter-modal-close" onclick="closeChapterModal()">×</span>
                </div>
                <div class="chapter-modal-body">
                    <form id="chapterForm" onsubmit="return false;">
                        <div style="text-align: center; margin-bottom: 30px;">
                            <img id="modalChapterLogo" src="" alt="Chapter Logo" style="width: 80px; height: 80px; object-fit: contain; border-radius: 8px; border: 2px solid #e9ecef;">
                        </div>
                        
                        <div class="form-group">
                            <label for="editChairman">Chairman <span class="required">*</span></label>
                            <input type="text" id="editChairman" name="chairman" placeholder="Enter chairman name">
                        </div>
                        
                        <div class="form-group">
                            <label for="editViceChairman">Vice Chairman <span class="required">*</span></label>
                            <input type="text" id="editViceChairman" name="vice_chairman" placeholder="Enter vice chairman name">
                        </div>
                        
                        <div class="form-group">
                            <label for="editSecretary">Secretary <span class="required">*</span></label>
                            <input type="text" id="editSecretary" name="secretary" placeholder="Enter secretary name">
                        </div>
                        
                        <div class="form-group">
                            <label for="editTreasurer">Treasurer <span class="required">*</span></label>
                            <input type="text" id="editTreasurer" name="treasurer" placeholder="Enter treasurer name">
                        </div>
                        
                        <div class="form-group">
                            <label for="editStatus">Status <span class="required">*</span></label>
                            <select id="editStatus" name="status">
                                <option value="active">Active</option>
                                <option value="upcoming">Upcoming</option>
                                <option value="inactive">Inactive</option>
                            </select>
                        </div>
                        
                        <div class="chapter-modal-actions">
                            <button type="button" class="btn btn-secondary" onclick="closeChapterModal()">Cancel</button>
                            <button type="button" class="btn btn-primary" onclick="saveChapterChanges()">Update Chapter</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    `;
    
    document.body.insertAdjacentHTML('beforeend', modalHTML);
    console.log('Modal created successfully');
};

window.closeChapterModal = function closeChapterModal() {
    const modal = document.getElementById('chapterModal');
    if (modal) {
        modal.classList.remove('show');
        modal.style.display = 'none';
        document.body.style.overflow = ''; // Restore body scrolling
    }
};

window.saveChapterChanges = function saveChapterChanges() {
    const modal = document.getElementById('chapterModal');
    const chapterId = modal.getAttribute('data-chapter-id');
    
    const formData = new FormData();
    formData.append('action', 'update_chapter');
    formData.append('id', chapterId);
    formData.append('chairman', document.getElementById('editChairman').value);
    formData.append('vice_chairman', document.getElementById('editViceChairman').value);
    formData.append('secretary', document.getElementById('editSecretary').value);
    formData.append('treasurer', document.getElementById('editTreasurer').value);
    formData.append('status', document.getElementById('editStatus').value);

    fetch('handler/admin_chapters_handler.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            closeChapterModal();
            showMessage('Chapter updated successfully!', 'success');
            setTimeout(() => location.reload(), 1000); // Reload after showing success message
        } else {
            showMessage('Error: ' + (data.message || 'Failed to update chapter'), 'error');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showMessage('Error updating chapter. Please try again.', 'error');
    });
};

window.showMessage = function showMessage(message, type) {
    // Create or update message element
    let messageEl = document.getElementById('message-display');
    if (!messageEl) {
        messageEl = document.createElement('div');
        messageEl.id = 'message-display';
        messageEl.style.cssText = `
            position: fixed;
            top: 20px;
            right: 20px;
            padding: 12px 20px;
            border-radius: 4px;
            color: white;
            font-weight: 500;
            z-index: 1001;
            box-shadow: 0 2px 8px rgba(0,0,0,0.2);
        `;
        document.body.appendChild(messageEl);
    }
    
    messageEl.textContent = message;
    messageEl.style.backgroundColor = type === 'success' ? '#10b981' : '#e63946';
    messageEl.style.display = 'block';
    
    setTimeout(() => {
        messageEl.style.display = 'none';
    }, 5000);
};