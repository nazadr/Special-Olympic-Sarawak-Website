// Sarawak Chapters Management JavaScript for Admin Panel
// Force global availability
window.loadChapters = function() {
    console.log('Loading chapters...');
    const existingChaptersContainer = document.getElementById('existingChapters');
    
    if (!existingChaptersContainer) {
        console.log('existingChapters element not found');
        return;
    }
    
    fetch('handler/admin_chapters_handler.php?action=fetch_chapters')
        .then(response => {
            console.log('Response status:', response.status);
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(data => {
            console.log('Chapters data received:', data);
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
                        const leaderCount = countLeaders(chapter);
                        
                        chapterItem.innerHTML = `
                            <div class="chapter-card-header">
                                <div class="chapter-logo-admin">
                                    <img src="${chapter.logo_path}" alt="${chapter.chapter_name} Logo" class="chapter-logo-img" onerror="this.style.display='none'; this.parentNode.innerHTML='<i class=\\'fas fa-building\\' style=\\'color:#cbd5e1;font-size:36px;\\'></i>';">
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
                                <button class="edit-btn" onclick="editChapter(${chapter.id})">
                                    <i class="fas fa-edit"></i> Edit Chapter
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
    
    // Create modal early
    createChapterModal();
    
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
            console.log('Found existingChapters element, loading chapters...');
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
        
        // Test modal creation
        console.log('Testing modal creation...');
        createChapterModal();
        const modal = document.getElementById('chapterModal');
        console.log('Modal created:', !!modal);
        if (modal) {
            console.log('Modal HTML:', modal.outerHTML.substring(0, 200) + '...');
        }
    };
});

// Global functions for modal management
window.editChapter = function editChapter(chapterId) {
    console.log('Editing chapter:', chapterId);
    
    const chapterElement = document.getElementById('chapter-' + chapterId);
    if (!chapterElement) {
        alert('Chapter not found!');
        return;
    }
    
    // Get current values from the new card structure
    const chapterName = chapterElement.querySelector('.chapter-item-admin-title').textContent;
    const logoImg = chapterElement.querySelector('.chapter-logo-img');
    const logoSrc = logoImg ? logoImg.src : '';
    const chairmanText = chapterElement.querySelector('.chairman-text').textContent.trim();
    const viceChairmanText = chapterElement.querySelector('.vice-chairman-text').textContent.trim();
    const secretaryText = chapterElement.querySelector('.secretary-text').textContent.trim();
    const treasurerText = chapterElement.querySelector('.treasurer-text').textContent.trim();
    const statusElement = chapterElement.querySelector('.chapter-status-badge');
    const currentStatus = statusElement.classList.contains('upcoming') ? 'upcoming' : 
                         statusElement.classList.contains('inactive') ? 'inactive' : 'active';
    
    openChapterModal(chapterId, {
        name: chapterName,
        logo: logoSrc,
        chairman: chairmanText === 'TBD' ? '' : chairmanText,
        vice_chairman: viceChairmanText === 'TBD' ? '' : viceChairmanText,
        secretary: secretaryText === 'TBD' ? '' : secretaryText,
        treasurer: treasurerText === 'TBD' ? '' : treasurerText,
        status: currentStatus
    });
};

window.openChapterModal = function openChapterModal(chapterId, chapterData) {
    console.log('Opening modal for chapter:', chapterId, chapterData);
    const modal = document.getElementById('chapterModal');
    if (!modal) {
        console.log('Modal not found, creating new modal');
        createChapterModal();
        return openChapterModal(chapterId, chapterData);
    }
    console.log('Modal found:', modal);
    
    // Populate modal with current data
    document.getElementById('modalChapterLogo').src = chapterData.logo;
    document.getElementById('modalChapterLogo').alt = chapterData.name + ' Logo';
    document.getElementById('editChairman').value = chapterData.chairman;
    document.getElementById('editViceChairman').value = chapterData.vice_chairman;
    document.getElementById('editSecretary').value = chapterData.secretary;
    document.getElementById('editTreasurer').value = chapterData.treasurer;
    document.getElementById('editStatus').value = chapterData.status;
    
    // Store chapter ID for saving
    modal.setAttribute('data-chapter-id', chapterId);
    
    // Show modal
    console.log('Showing modal...');
    modal.classList.add('show');
    modal.style.display = 'block';
    console.log('Modal classes:', modal.className);
    console.log('Modal display style:', modal.style.display);
};

window.createChapterModal = function createChapterModal() {
    const modalHTML = `
        <div class="chapter-modal" id="chapterModal" style="display: none;">
            <div class="chapter-modal-backdrop" onclick="closeChapterModal()"></div>
            <div class="chapter-modal-content">
                <div class="chapter-modal-header">
                    <h3>Edit Chapter Information</h3>
                    <span class="chapter-modal-close" onclick="closeChapterModal()">×</span>
                </div>
                <div class="chapter-modal-body">
                    <form id="chapterForm">
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
};

window.closeChapterModal = function closeChapterModal() {
    const modal = document.getElementById('chapterModal');
    if (modal) {
        modal.classList.remove('show');
        modal.style.display = 'none';
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