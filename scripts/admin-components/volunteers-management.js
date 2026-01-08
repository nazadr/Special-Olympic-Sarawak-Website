// ========================================
// VOLUNTEERS MANAGEMENT JAVASCRIPT
// Special Olympics Sarawak Admin Panel
// ========================================

let volunteersCurrentFilter = 'all';
let volunteersCurrentPage = 1;
let volunteersPerPage = 50;
let volunteersSearchTerm = '';

document.addEventListener('DOMContentLoaded', function() {
    const volunteersNavItem = document.querySelector('[data-section="volunteers"]');
    if (volunteersNavItem) {
        volunteersNavItem.addEventListener('click', () => loadVolunteersData());
    }

    const searchInput = document.getElementById('volunteersSearchInput');
    if (searchInput) {
        let searchTimeout;
        searchInput.addEventListener('input', function() {
            clearTimeout(searchTimeout);
            searchTimeout = setTimeout(() => {
                volunteersSearchTerm = this.value;
                volunteersCurrentPage = 1;
                loadVolunteersData();
            }, 500);
        });
    }
});

function loadVolunteersStats() {
    fetch('handler/admin_volunteers_handler.php?action=fetchStats')
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                document.getElementById('volunteersTotalCount').textContent = data.stats.total || 0;
                document.getElementById('volunteersApprovedCount').textContent = data.stats.approved || 0;
                document.getElementById('volunteersPendingCount').textContent = data.stats.pending || 0;
                document.getElementById('volunteersRecentCount').textContent = data.recent_count || 0;

                if (data.last_upload) {
                    const uploadText = `${data.last_upload.original_filename} • ${formatDate(data.last_upload.created_at)} • ${data.last_upload.rows_imported} imported`;
                    document.getElementById('volunteersLastUpload').textContent = uploadText;
                } else {
                    document.getElementById('volunteersLastUpload').textContent = 'No uploads yet';
                }
            }
        })
        .catch(error => console.error('Error loading volunteers stats:', error));
}

function loadVolunteersData() {
    loadVolunteersStats();
    
    const tbody = document.getElementById('volunteersTableBody');
    tbody.innerHTML = '<tr><td colspan="10" style="text-align: center; padding: 40px;"><i class="fas fa-spinner fa-spin" style="font-size: 24px;"></i><p>Loading...</p></td></tr>';

    let url = `handler/admin_volunteers_handler.php?action=fetch&limit=${volunteersPerPage}&offset=${(volunteersCurrentPage - 1) * volunteersPerPage}`;
    if (volunteersCurrentFilter !== 'all') url += `&status=${volunteersCurrentFilter}`;
    if (volunteersSearchTerm) url += `&search=${encodeURIComponent(volunteersSearchTerm)}`;

    fetch(url)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                displayVolunteersTable(data.data);
                updateVolunteersPagination(data.total);
            } else {
                tbody.innerHTML = '<tr><td colspan="10" style="text-align: center; color: #ef4444;">Error loading volunteers</td></tr>';
            }
        })
        .catch(() => tbody.innerHTML = '<tr><td colspan="10" style="text-align: center; color: #ef4444;">Failed to load</td></tr>');
}

function displayVolunteersTable(volunteers) {
    const tbody = document.getElementById('volunteersTableBody');
    
    if (volunteers.length === 0) {
        tbody.innerHTML = '<tr><td colspan="10" style="text-align: center; padding: 40px;"><i class="fas fa-inbox" style="font-size: 48px; color: #cbd5e1;"></i><p>No volunteers found</p></td></tr>';
        return;
    }

    tbody.innerHTML = volunteers.map(v => `
        <tr>
            <td>${v.id}</td>
            <td style="font-weight: 500;">${escapeHtml(v.full_name)}</td>
            <td>${v.email || '<span style="color: #94a3b8;">-</span>'}</td>
            <td>${v.phone || '-'}</td>
            <td>${v.chapter || '-'}</td>
            <td>${v.gender || '-'}</td>
            <td style="max-width: 180px; overflow: hidden; text-overflow: ellipsis;" title="${escapeHtml(v.volunteer_role || '')}">${v.volunteer_role || '-'}</td>
            <td><span class="participant-status ${v.status}">${getStatusIcon(v.status)} ${v.status}</span></td>
            <td>${formatDate(v.created_at)}</td>
            <td>
                <div class="participant-actions">
                    <button class="participant-action-btn view" onclick="viewVolunteerDetails(${v.id})"><i class="fas fa-eye"></i></button>
                    ${v.status === 'pending' ? `
                        <button class="participant-action-btn approve" onclick="updateVolunteerStatus(${v.id}, 'approved')"><i class="fas fa-check"></i></button>
                        <button class="participant-action-btn reject" onclick="updateVolunteerStatus(${v.id}, 'rejected')"><i class="fas fa-times"></i></button>
                    ` : ''}
                    <button class="participant-action-btn delete" onclick="deleteVolunteer(${v.id})"><i class="fas fa-trash"></i></button>
                </div>
            </td>
        </tr>
    `).join('');
}

function filterVolunteers(status) {
    volunteersCurrentFilter = status;
    volunteersCurrentPage = 1;
    document.querySelectorAll('#volunteers .filter-btn').forEach(btn => {
        btn.classList.toggle('active', btn.dataset.filter === status);
    });
    loadVolunteersData();
}

function updateVolunteerStatus(id, status) {
    if (!confirm(`${status.charAt(0).toUpperCase() + status.slice(1)} this volunteer?`)) return;
    
    const formData = new FormData();
    formData.append('action', 'updateStatus');
    formData.append('id', id);
    formData.append('status', status);

    fetch('handler/admin_volunteers_handler.php', { method: 'POST', body: formData })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showNotification(`Volunteer ${status}!`, 'success');
                loadVolunteersData();
            } else {
                showNotification('Failed to update status', 'error');
            }
        })
        .catch(() => showNotification('Failed to update', 'error'));
}

function deleteVolunteer(id) {
    if (!confirm('Delete this volunteer?')) return;
    
    const formData = new FormData();
    formData.append('action', 'delete');
    formData.append('id', id);

    fetch('handler/admin_volunteers_handler.php', { method: 'POST', body: formData })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showNotification('Volunteer deleted!', 'success');
                loadVolunteersData();
            } else {
                showNotification('Failed to delete', 'error');
            }
        })
        .catch(() => showNotification('Failed to delete', 'error'));
}

function viewVolunteerDetails(id) {
    fetch(`handler/admin_volunteers_handler.php?action=fetch`)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const volunteer = data.data.find(v => v.id === id);
                if (volunteer) showVolunteerDetailsModal(volunteer);
            }
        });
}

function showVolunteerDetailsModal(v) {
    const modalHTML = `
        <div class="news-modal" id="volunteerDetailsModal" style="display: flex;">
            <div class="news-modal-backdrop" onclick="closeVolunteerDetailsModal()"></div>
            <div class="news-modal-content" style="max-width: 700px;">
                <div class="modal-header">
                    <h3 class="modal-title">Volunteer Details</h3>
                    <button class="modal-close" onclick="closeVolunteerDetailsModal()">&times;</button>
                </div>
                <div class="modal-body" style="padding: 32px;">
                    <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 20px;">
                        <div><label style="font-size: 12px; color: #64748b;">Name</label><p style="font-weight: 600;">${escapeHtml(v.full_name)}</p></div>
                        <div><label style="font-size: 12px; color: #64748b;">Status</label><span class="participant-status ${v.status}">${v.status}</span></div>
                        <div><label style="font-size: 12px; color: #64748b;">Email</label><p>${v.email || '-'}</p></div>
                        <div><label style="font-size: 12px; color: #64748b;">Phone</label><p>${v.phone || '-'}</p></div>
                        <div><label style="font-size: 12px; color: #64748b;">Chapter</label><p>${v.chapter || '-'}</p></div>
                        <div><label style="font-size: 12px; color: #64748b;">Gender</label><p>${v.gender || '-'}</p></div>
                        <div style="grid-column: 1 / -1;"><label style="font-size: 12px; color: #64748b;">Volunteer Role</label><p>${v.volunteer_role || '-'}</p></div>
                        <div style="grid-column: 1 / -1;"><label style="font-size: 12px; color: #64748b;">Skills</label><p>${v.skills || '-'}</p></div>
                        <div><label style="font-size: 12px; color: #64748b;">Availability</label><p>${v.availability || '-'}</p></div>
                        <div style="grid-column: 1 / -1;"><label style="font-size: 12px; color: #64748b;">Experience</label><p>${v.previous_volunteer_experience || 'None'}</p></div>
                        <div><label style="font-size: 12px; color: #64748b;">Emergency Contact</label><p>${v.emergency_contact_name || '-'}</p></div>
                        <div><label style="font-size: 12px; color: #64748b;">Emergency Phone</label><p>${v.emergency_contact_phone || '-'}</p></div>
                    </div>
                    <div class="modal-footer" style="margin-top: 24px;">
                        <button class="btn-cancel" onclick="closeVolunteerDetailsModal()">Close</button>
                    </div>
                </div>
            </div>
        </div>
    `;
    document.body.insertAdjacentHTML('beforeend', modalHTML);
}

function closeVolunteerDetailsModal() {
    document.getElementById('volunteerDetailsModal')?.remove();
}

function updateVolunteersPagination(total) {
    const totalPages = Math.ceil(total / volunteersPerPage);
    const container = document.getElementById('volunteersPagination');
    if (totalPages <= 1) { container.innerHTML = ''; return; }
    
    let html = `<button class="pagination-btn" onclick="changeVolunteersPage(${volunteersCurrentPage - 1})" ${volunteersCurrentPage === 1 ? 'disabled' : ''}><i class="fas fa-chevron-left"></i> Previous</button>`;
    for (let i = 1; i <= totalPages; i++) {
        if (i === 1 || i === totalPages || (i >= volunteersCurrentPage - 2 && i <= volunteersCurrentPage + 2)) {
            html += `<button class="pagination-btn ${i === volunteersCurrentPage ? 'active' : ''}" onclick="changeVolunteersPage(${i})">${i}</button>`;
        } else if (i === volunteersCurrentPage - 3 || i === volunteersCurrentPage + 3) {
            html += `<span class="pagination-info">...</span>`;
        }
    }
    html += `<button class="pagination-btn" onclick="changeVolunteersPage(${volunteersCurrentPage + 1})" ${volunteersCurrentPage === totalPages ? 'disabled' : ''}>Next <i class="fas fa-chevron-right"></i></button>`;
    container.innerHTML = html;
}

function changeVolunteersPage(page) {
    volunteersCurrentPage = page;
    loadVolunteersData();
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
