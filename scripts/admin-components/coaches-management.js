// ========================================
// COACHES MANAGEMENT JAVASCRIPT
// Special Olympics Sarawak Admin Panel
// ========================================

let coachesCurrentFilter = 'all';
let coachesCurrentPage = 1;
let coachesPerPage = 50;
let coachesSearchTerm = '';

// Initialize when section is loaded
document.addEventListener('DOMContentLoaded', function() {
    const coachesNavItem = document.querySelector('[data-section="coaches"]');
    if (coachesNavItem) {
        coachesNavItem.addEventListener('click', function() {
            loadCoachesData();
        });
    }

    const searchInput = document.getElementById('coachesSearchInput');
    if (searchInput) {
        let searchTimeout;
        searchInput.addEventListener('input', function() {
            clearTimeout(searchTimeout);
            searchTimeout = setTimeout(() => {
                coachesSearchTerm = this.value;
                coachesCurrentPage = 1;
                loadCoachesData();
            }, 500);
        });
    }
});

// Load Coaches Statistics
function loadCoachesStats() {
    fetch('handler/admin_coaches_handler.php?action=fetchStats')
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                document.getElementById('coachesTotalCount').textContent = data.stats.total || 0;
                document.getElementById('coachesApprovedCount').textContent = data.stats.approved || 0;
                document.getElementById('coachesPendingCount').textContent = data.stats.pending || 0;
                document.getElementById('coachesAvgExperience').textContent = Math.round(data.stats.avg_experience || 0);

                if (data.last_upload) {
                    const uploadDate = new Date(data.last_upload.created_at);
                    const uploadText = `${data.last_upload.original_filename} • ${formatDate(uploadDate)} • ${data.last_upload.rows_imported} imported, ${data.last_upload.rows_updated} updated`;
                    document.getElementById('coachesLastUpload').textContent = uploadText;
                } else {
                    document.getElementById('coachesLastUpload').textContent = 'No uploads yet';
                }
            }
        })
        .catch(error => console.error('Error loading coaches stats:', error));
}

// Load Coaches Data
function loadCoachesData() {
    loadCoachesStats();
    
    const tbody = document.getElementById('coachesTableBody');
    tbody.innerHTML = '<tr><td colspan="10" style="text-align: center; padding: 40px;"><i class="fas fa-spinner fa-spin" style="font-size: 24px; color: #667eea;"></i><p style="margin-top: 10px; color: #64748b;">Loading coaches data...</p></td></tr>';

    let url = `handler/admin_coaches_handler.php?action=fetch&limit=${coachesPerPage}&offset=${(coachesCurrentPage - 1) * coachesPerPage}`;
    
    if (coachesCurrentFilter !== 'all') {
        url += `&status=${coachesCurrentFilter}`;
    }
    
    if (coachesSearchTerm) {
        url += `&search=${encodeURIComponent(coachesSearchTerm)}`;
    }

    fetch(url)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                displayCoachesTable(data.data);
                updateCoachesPagination(data.total);
            } else {
                tbody.innerHTML = `<tr><td colspan="10" style="text-align: center; padding: 40px; color: #ef4444;"><i class="fas fa-exclamation-triangle"></i><p>Error loading coaches</p></td></tr>`;
            }
        })
        .catch(error => {
            console.error('Error:', error);
            tbody.innerHTML = `<tr><td colspan="10" style="text-align: center; padding: 40px; color: #ef4444;"><i class="fas fa-exclamation-triangle"></i><p>Failed to load coaches</p></td></tr>`;
        });
}

// Display Coaches Table
function displayCoachesTable(coaches) {
    const tbody = document.getElementById('coachesTableBody');
    
    if (coaches.length === 0) {
        tbody.innerHTML = `<tr><td colspan="10" style="text-align: center; padding: 40px;">
            <i class="fas fa-inbox" style="font-size: 48px; color: #cbd5e1;"></i>
            <p style="color: #64748b;">No coaches found</p>
        </td></tr>`;
        return;
    }

    tbody.innerHTML = coaches.map(coach => `
        <tr>
            <td>${coach.id}</td>
            <td style="font-weight: 500;">${escapeHtml(coach.full_name)}</td>
            <td>${coach.email || '<span style="color: #94a3b8;">-</span>'}</td>
            <td>${coach.phone || '<span style="color: #94a3b8;">-</span>'}</td>
            <td>${coach.chapter || '<span style="color: #94a3b8;">-</span>'}</td>
            <td>${coach.gender || '<span style="color: #94a3b8;">-</span>'}</td>
            <td style="max-width: 180px; overflow: hidden; text-overflow: ellipsis;" title="${escapeHtml(coach.sports_expertise || '')}">
                ${coach.sports_expertise || '<span style="color: #94a3b8;">-</span>'}
            </td>
            <td>${coach.experience_years ? coach.experience_years + ' yrs' : '<span style="color: #94a3b8;">-</span>'}</td>
            <td><span class="participant-status ${coach.status}">${getStatusIcon(coach.status)} ${coach.status}</span></td>
            <td>
                <div class="participant-actions">
                    <button class="participant-action-btn view" onclick="viewCoachDetails(${coach.id})" title="View">
                        <i class="fas fa-eye"></i>
                    </button>
                    ${coach.status === 'pending' ? `
                        <button class="participant-action-btn approve" onclick="updateCoachStatus(${coach.id}, 'approved')" title="Approve">
                            <i class="fas fa-check"></i>
                        </button>
                        <button class="participant-action-btn reject" onclick="updateCoachStatus(${coach.id}, 'rejected')" title="Reject">
                            <i class="fas fa-times"></i>
                        </button>
                    ` : ''}
                    <button class="participant-action-btn delete" onclick="deleteCoach(${coach.id})" title="Delete">
                        <i class="fas fa-trash"></i>
                    </button>
                </div>
            </td>
        </tr>
    `).join('');
}

// Filter, Status Update, Delete functions (similar to athletes)
function filterCoaches(status) {
    coachesCurrentFilter = status;
    coachesCurrentPage = 1;
    document.querySelectorAll('#coaches .filter-btn').forEach(btn => {
        btn.classList.toggle('active', btn.dataset.filter === status);
    });
    loadCoachesData();
}

function updateCoachStatus(id, status) {
    if (!confirm(`${status.charAt(0).toUpperCase() + status.slice(1)} this coach?`)) return;
    
    const formData = new FormData();
    formData.append('action', 'updateStatus');
    formData.append('id', id);
    formData.append('status', status);

    fetch('handler/admin_coaches_handler.php', { method: 'POST', body: formData })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showNotification(`Coach ${status} successfully!`, 'success');
                loadCoachesData();
            } else {
                showNotification(data.message || 'Failed to update status', 'error');
            }
        })
        .catch(() => showNotification('Failed to update status', 'error'));
}

function deleteCoach(id) {
    if (!confirm('Delete this coach? This cannot be undone.')) return;
    
    const formData = new FormData();
    formData.append('action', 'delete');
    formData.append('id', id);

    fetch('handler/admin_coaches_handler.php', { method: 'POST', body: formData })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showNotification('Coach deleted successfully!', 'success');
                loadCoachesData();
            } else {
                showNotification(data.message || 'Failed to delete', 'error');
            }
        })
        .catch(() => showNotification('Failed to delete', 'error'));
}

function viewCoachDetails(id) {
    fetch(`handler/admin_coaches_handler.php?action=fetch`)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const coach = data.data.find(c => c.id === id);
                if (coach) showCoachDetailsModal(coach);
            }
        });
}

function showCoachDetailsModal(coach) {
    const modalHTML = `
        <div class="news-modal" id="coachDetailsModal" style="display: flex;">
            <div class="news-modal-backdrop" onclick="closeCoachDetailsModal()"></div>
            <div class="news-modal-content" style="max-width: 700px;">
                <div class="modal-header">
                    <h3 class="modal-title">Coach Details</h3>
                    <button class="modal-close" onclick="closeCoachDetailsModal()">&times;</button>
                </div>
                <div class="modal-body" style="padding: 32px;">
                    <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 20px;">
                        <div><label style="font-size: 12px; color: #64748b;">Name</label><p style="font-weight: 600;">${escapeHtml(coach.full_name)}</p></div>
                        <div><label style="font-size: 12px; color: #64748b;">Status</label><span class="participant-status ${coach.status}">${coach.status}</span></div>
                        <div><label style="font-size: 12px; color: #64748b;">Email</label><p>${coach.email || '-'}</p></div>
                        <div><label style="font-size: 12px; color: #64748b;">Phone</label><p>${coach.phone || '-'}</p></div>
                        <div><label style="font-size: 12px; color: #64748b;">Chapter</label><p>${coach.chapter || '-'}</p></div>
                        <div><label style="font-size: 12px; color: #64748b;">Gender</label><p>${coach.gender || '-'}</p></div>
                        <div><label style="font-size: 12px; color: #64748b;">Experience</label><p>${coach.experience_years ? coach.experience_years + ' years' : '-'}</p></div>
                        <div><label style="font-size: 12px; color: #64748b;">Availability</label><p>${coach.availability || '-'}</p></div>
                        <div style="grid-column: 1 / -1;"><label style="font-size: 12px; color: #64748b;">Sports Expertise</label><p>${coach.sports_expertise || '-'}</p></div>
                        <div style="grid-column: 1 / -1;"><label style="font-size: 12px; color: #64748b;">Certifications</label><p>${coach.certifications || '-'}</p></div>
                        <div><label style="font-size: 12px; color: #64748b;">Emergency Contact</label><p>${coach.emergency_contact_name || '-'}</p></div>
                        <div><label style="font-size: 12px; color: #64748b;">Emergency Phone</label><p>${coach.emergency_contact_phone || '-'}</p></div>
                    </div>
                    <div class="modal-footer" style="margin-top: 24px;">
                        <button class="btn-cancel" onclick="closeCoachDetailsModal()">Close</button>
                    </div>
                </div>
            </div>
        </div>
    `;
    document.body.insertAdjacentHTML('beforeend', modalHTML);
}

function closeCoachDetailsModal() {
    document.getElementById('coachDetailsModal')?.remove();
}

function updateCoachesPagination(total) {
    const totalPages = Math.ceil(total / coachesPerPage);
    const container = document.getElementById('coachesPagination');
    if (totalPages <= 1) { container.innerHTML = ''; return; }
    
    let html = `<button class="pagination-btn" onclick="changeCoachesPage(${coachesCurrentPage - 1})" ${coachesCurrentPage === 1 ? 'disabled' : ''}><i class="fas fa-chevron-left"></i> Previous</button>`;
    for (let i = 1; i <= totalPages; i++) {
        if (i === 1 || i === totalPages || (i >= coachesCurrentPage - 2 && i <= coachesCurrentPage + 2)) {
            html += `<button class="pagination-btn ${i === coachesCurrentPage ? 'active' : ''}" onclick="changeCoachesPage(${i})">${i}</button>`;
        } else if (i === coachesCurrentPage - 3 || i === coachesCurrentPage + 3) {
            html += `<span class="pagination-info">...</span>`;
        }
    }
    html += `<button class="pagination-btn" onclick="changeCoachesPage(${coachesCurrentPage + 1})" ${coachesCurrentPage === totalPages ? 'disabled' : ''}>Next <i class="fas fa-chevron-right"></i></button>`;
    container.innerHTML = html;
}

function changeCoachesPage(page) {
    coachesCurrentPage = page;
    loadCoachesData();
}

function getStatusIcon(status) {
    return {'approved': '<i class="fas fa-check-circle"></i>', 'pending': '<i class="fas fa-clock"></i>', 'rejected': '<i class="fas fa-times-circle"></i>'}[status] || '';
}

function formatDate(dateString) {
    return dateString ? new Date(dateString).toLocaleDateString('en-MY', {year: 'numeric', month: 'short', day: 'numeric'}) : '-';
}

function escapeHtml(text) {
    if (!text) return '';
    return text.replace(/[&<>"']/g, m => ({'&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#039;'}[m]));
}
