// ========================================
// ATHLETES MANAGEMENT JAVASCRIPT
// Special Olympics Sarawak Admin Panel
// ========================================

let athletesCurrentFilter = 'all';
let athletesCurrentPage = 1;
let athletesPerPage = 50;
let athletesSearchTerm = '';

// Initialize when section is loaded
document.addEventListener('DOMContentLoaded', function() {
    // Load athletes data when section becomes active
    const athletesNavItem = document.querySelector('[data-section="athletes"]');
    if (athletesNavItem) {
        athletesNavItem.addEventListener('click', function() {
            loadAthletesData();
        });
    }

    // Search functionality with debounce
    const searchInput = document.getElementById('athletesSearchInput');
    if (searchInput) {
        let searchTimeout;
        searchInput.addEventListener('input', function() {
            clearTimeout(searchTimeout);
            searchTimeout = setTimeout(() => {
                athletesSearchTerm = this.value;
                athletesCurrentPage = 1;
                loadAthletesData();
            }, 500);
        });
    }
});

// Load Athletes Statistics
function loadAthletesStats() {
    fetch('handler/admin_athletes_handler.php?action=fetchStats')
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Update statistics cards
                document.getElementById('athletesTotalCount').textContent = data.stats.total || 0;
                document.getElementById('athletesApprovedCount').textContent = data.stats.approved || 0;
                document.getElementById('athletesPendingCount').textContent = data.stats.pending || 0;
                document.getElementById('athletesRecentCount').textContent = data.recent_count || 0;

                // Update last upload info
                if (data.last_upload) {
                    const uploadDate = new Date(data.last_upload.created_at);
                    const uploadText = `${data.last_upload.original_filename} • ${formatDate(uploadDate)} • ${data.last_upload.rows_imported} imported, ${data.last_upload.rows_updated} updated`;
                    document.getElementById('athletesLastUpload').textContent = uploadText;
                } else {
                    document.getElementById('athletesLastUpload').textContent = 'No uploads yet';
                }
            }
        })
        .catch(error => {
            console.error('Error loading athletes stats:', error);
        });
}

// Load Athletes Data with filters
function loadAthletesData() {
    loadAthletesStats();
    
    const tbody = document.getElementById('athletesTableBody');
    tbody.innerHTML = '<tr><td colspan="10" style="text-align: center; padding: 40px;"><i class="fas fa-spinner fa-spin" style="font-size: 24px; color: #667eea;"></i><p style="margin-top: 10px; color: #64748b;">Loading athletes data...</p></td></tr>';

    let url = `handler/admin_athletes_handler.php?action=fetch&limit=${athletesPerPage}&offset=${(athletesCurrentPage - 1) * athletesPerPage}`;
    
    if (athletesCurrentFilter !== 'all') {
        url += `&status=${athletesCurrentFilter}`;
    }
    
    if (athletesSearchTerm) {
        url += `&search=${encodeURIComponent(athletesSearchTerm)}`;
    }

    fetch(url)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                displayAthletesTable(data.data);
                updateAthletesPagination(data.total);
            } else {
                tbody.innerHTML = `<tr><td colspan="10" style="text-align: center; padding: 40px; color: #ef4444;">
                    <i class="fas fa-exclamation-triangle" style="font-size: 24px; margin-bottom: 10px;"></i>
                    <p>Error loading athletes: ${data.message}</p>
                </td></tr>`;
            }
        })
        .catch(error => {
            console.error('Error:', error);
            tbody.innerHTML = `<tr><td colspan="10" style="text-align: center; padding: 40px; color: #ef4444;">
                <i class="fas fa-exclamation-triangle" style="font-size: 24px; margin-bottom: 10px;"></i>
                <p>Failed to load athletes data</p>
            </td></tr>`;
        });
}

// Display Athletes Table
function displayAthletesTable(athletes) {
    const tbody = document.getElementById('athletesTableBody');
    
    if (athletes.length === 0) {
        tbody.innerHTML = `<tr><td colspan="10" style="text-align: center; padding: 40px;">
            <i class="fas fa-inbox" style="font-size: 48px; color: #cbd5e1; margin-bottom: 16px;"></i>
            <p style="color: #64748b; font-size: 16px; margin: 0;">No athletes found</p>
            <p style="color: #94a3b8; font-size: 14px; margin-top: 8px;">Upload an Excel file to get started</p>
        </td></tr>`;
        return;
    }

    tbody.innerHTML = athletes.map(athlete => `
        <tr>
            <td>${athlete.id}</td>
            <td style="font-weight: 500;">${escapeHtml(athlete.full_name)}</td>
            <td>${athlete.email || '<span style="color: #94a3b8;">-</span>'}</td>
            <td>${athlete.phone || '<span style="color: #94a3b8;">-</span>'}</td>
            <td>${athlete.chapter || '<span style="color: #94a3b8;">-</span>'}</td>
            <td>${athlete.gender || '<span style="color: #94a3b8;">-</span>'}</td>
            <td style="max-width: 200px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;" title="${escapeHtml(athlete.sports_interested || '')}">
                ${athlete.sports_interested || '<span style="color: #94a3b8;">-</span>'}
            </td>
            <td>
                <span class="participant-status ${athlete.status}">
                    ${getStatusIcon(athlete.status)} ${athlete.status}
                </span>
            </td>
            <td>${formatDate(athlete.created_at)}</td>
            <td>
                <div class="participant-actions">
                    <button class="participant-action-btn view" onclick="viewAthleteDetails(${athlete.id})" title="View Details">
                        <i class="fas fa-eye"></i>
                    </button>
                    ${athlete.status === 'pending' ? `
                        <button class="participant-action-btn approve" onclick="updateAthleteStatus(${athlete.id}, 'approved')" title="Approve">
                            <i class="fas fa-check"></i>
                        </button>
                        <button class="participant-action-btn reject" onclick="updateAthleteStatus(${athlete.id}, 'rejected')" title="Reject">
                            <i class="fas fa-times"></i>
                        </button>
                    ` : ''}
                    <button class="participant-action-btn delete" onclick="deleteAthlete(${athlete.id})" title="Delete">
                        <i class="fas fa-trash"></i>
                    </button>
                </div>
            </td>
        </tr>
    `).join('');
}

// Update Pagination
function updateAthletesPagination(total) {
    const totalPages = Math.ceil(total / athletesPerPage);
    const paginationContainer = document.getElementById('athletesPagination');
    
    if (totalPages <= 1) {
        paginationContainer.innerHTML = '';
        return;
    }

    let paginationHTML = `
        <button class="pagination-btn" onclick="changePage(${athletesCurrentPage - 1})" ${athletesCurrentPage === 1 ? 'disabled' : ''}>
            <i class="fas fa-chevron-left"></i> Previous
        </button>
    `;

    // Show page numbers
    for (let i = 1; i <= totalPages; i++) {
        if (i === 1 || i === totalPages || (i >= athletesCurrentPage - 2 && i <= athletesCurrentPage + 2)) {
            paginationHTML += `
                <button class="pagination-btn ${i === athletesCurrentPage ? 'active' : ''}" onclick="changePage(${i})">
                    ${i}
                </button>
            `;
        } else if (i === athletesCurrentPage - 3 || i === athletesCurrentPage + 3) {
            paginationHTML += `<span class="pagination-info">...</span>`;
        }
    }

    paginationHTML += `
        <button class="pagination-btn" onclick="changePage(${athletesCurrentPage + 1})" ${athletesCurrentPage === totalPages ? 'disabled' : ''}>
            Next <i class="fas fa-chevron-right"></i>
        </button>
    `;

    paginationHTML += `<span class="pagination-info">Showing ${(athletesCurrentPage - 1) * athletesPerPage + 1} - ${Math.min(athletesCurrentPage * athletesPerPage, total)} of ${total}</span>`;

    paginationContainer.innerHTML = paginationHTML;
}

// Change Page
function changePage(page) {
    athletesCurrentPage = page;
    loadAthletesData();
}

// Filter Athletes
function filterAthletes(status) {
    athletesCurrentFilter = status;
    athletesCurrentPage = 1;
    
    // Update active filter button
    document.querySelectorAll('#athletes .filter-btn').forEach(btn => {
        btn.classList.remove('active');
        if (btn.dataset.filter === status) {
            btn.classList.add('active');
        }
    });
    
    loadAthletesData();
}

// Update Athlete Status
function updateAthleteStatus(id, status) {
    const statusText = status.charAt(0).toUpperCase() + status.slice(1);
    
    if (!confirm(`Are you sure you want to ${statusText.toLowerCase()} this athlete?`)) {
        return;
    }

    const formData = new FormData();
    formData.append('action', 'updateStatus');
    formData.append('id', id);
    formData.append('status', status);

    fetch('handler/admin_athletes_handler.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showNotification(`Athlete ${statusText.toLowerCase()} successfully!`, 'success');
            loadAthletesData();
        } else {
            showNotification(data.message || 'Failed to update status', 'error');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showNotification('Failed to update status', 'error');
    });
}

// Delete Athlete
function deleteAthlete(id) {
    if (!confirm('Are you sure you want to delete this athlete? This action cannot be undone.')) {
        return;
    }

    const formData = new FormData();
    formData.append('action', 'delete');
    formData.append('id', id);

    fetch('handler/admin_athletes_handler.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showNotification('Athlete deleted successfully!', 'success');
            loadAthletesData();
        } else {
            showNotification(data.message || 'Failed to delete athlete', 'error');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showNotification('Failed to delete athlete', 'error');
    });
}

// View Athlete Details (opens modal with full information)
function viewAthleteDetails(id) {
    // Fetch athlete details
    fetch(`handler/admin_athletes_handler.php?action=fetch&search=&limit=1000`)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const athlete = data.data.find(a => a.id === id);
                if (athlete) {
                    showAthleteDetailsModal(athlete);
                }
            }
        })
        .catch(error => console.error('Error:', error));
}

// Show Athlete Details Modal
function showAthleteDetailsModal(athlete) {
    const modalHTML = `
        <div class="news-modal" id="athleteDetailsModal" style="display: flex;">
            <div class="news-modal-backdrop" onclick="closeAthleteDetailsModal()"></div>
            <div class="news-modal-content" style="max-width: 700px;">
                <div class="modal-header">
                    <h3 class="modal-title">Athlete Details</h3>
                    <button class="modal-close" onclick="closeAthleteDetailsModal()">&times;</button>
                </div>
                <div class="modal-body" style="padding: 32px;">
                    <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 20px;">
                        <div>
                            <label style="display: block; font-size: 12px; color: #64748b; margin-bottom: 4px; font-weight: 500;">Full Name</label>
                            <p style="margin: 0; color: #1e293b; font-weight: 600;">${escapeHtml(athlete.full_name)}</p>
                        </div>
                        <div>
                            <label style="display: block; font-size: 12px; color: #64748b; margin-bottom: 4px; font-weight: 500;">Status</label>
                            <span class="participant-status ${athlete.status}">${getStatusIcon(athlete.status)} ${athlete.status}</span>
                        </div>
                        <div>
                            <label style="display: block; font-size: 12px; color: #64748b; margin-bottom: 4px; font-weight: 500;">Email</label>
                            <p style="margin: 0; color: #1e293b;">${athlete.email || '-'}</p>
                        </div>
                        <div>
                            <label style="display: block; font-size: 12px; color: #64748b; margin-bottom: 4px; font-weight: 500;">Phone</label>
                            <p style="margin: 0; color: #1e293b;">${athlete.phone || '-'}</p>
                        </div>
                        <div>
                            <label style="display: block; font-size: 12px; color: #64748b; margin-bottom: 4px; font-weight: 500;">Date of Birth</label>
                            <p style="margin: 0; color: #1e293b;">${athlete.date_of_birth ? formatDate(athlete.date_of_birth) : '-'}</p>
                        </div>
                        <div>
                            <label style="display: block; font-size: 12px; color: #64748b; margin-bottom: 4px; font-weight: 500;">Gender</label>
                            <p style="margin: 0; color: #1e293b;">${athlete.gender || '-'}</p>
                        </div>
                        <div>
                            <label style="display: block; font-size: 12px; color: #64748b; margin-bottom: 4px; font-weight: 500;">Chapter</label>
                            <p style="margin: 0; color: #1e293b;">${athlete.chapter || '-'}</p>
                        </div>
                        <div>
                            <label style="display: block; font-size: 12px; color: #64748b; margin-bottom: 4px; font-weight: 500;">Registration Date</label>
                            <p style="margin: 0; color: #1e293b;">${formatDate(athlete.registration_date || athlete.created_at)}</p>
                        </div>
                        <div style="grid-column: 1 / -1;">
                            <label style="display: block; font-size: 12px; color: #64748b; margin-bottom: 4px; font-weight: 500;">Sports Interested</label>
                            <p style="margin: 0; color: #1e293b;">${athlete.sports_interested || '-'}</p>
                        </div>
                        <div style="grid-column: 1 / -1;">
                            <label style="display: block; font-size: 12px; color: #64748b; margin-bottom: 4px; font-weight: 500;">Medical Conditions</label>
                            <p style="margin: 0; color: #1e293b;">${athlete.medical_conditions || 'None reported'}</p>
                        </div>
                        <div>
                            <label style="display: block; font-size: 12px; color: #64748b; margin-bottom: 4px; font-weight: 500;">Emergency Contact Name</label>
                            <p style="margin: 0; color: #1e293b;">${athlete.emergency_contact_name || '-'}</p>
                        </div>
                        <div>
                            <label style="display: block; font-size: 12px; color: #64748b; margin-bottom: 4px; font-weight: 500;">Emergency Contact Phone</label>
                            <p style="margin: 0; color: #1e293b;">${athlete.emergency_contact_phone || '-'}</p>
                        </div>
                        ${athlete.notes ? `
                        <div style="grid-column: 1 / -1;">
                            <label style="display: block; font-size: 12px; color: #64748b; margin-bottom: 4px; font-weight: 500;">Notes</label>
                            <p style="margin: 0; color: #1e293b;">${escapeHtml(athlete.notes)}</p>
                        </div>
                        ` : ''}
                    </div>
                    <div class="modal-footer" style="margin-top: 24px;">
                        <button class="btn-cancel" onclick="closeAthleteDetailsModal()">Close</button>
                        ${athlete.status === 'pending' ? `
                            <button class="btn-submit" style="background: #10b981;" onclick="updateAthleteStatus(${athlete.id}, 'approved'); closeAthleteDetailsModal();">
                                <i class="fas fa-check"></i> Approve
                            </button>
                        ` : ''}
                    </div>
                </div>
            </div>
        </div>
    `;

    // Remove existing modal if any
    const existingModal = document.getElementById('athleteDetailsModal');
    if (existingModal) {
        existingModal.remove();
    }

    // Add modal to body
    document.body.insertAdjacentHTML('beforeend', modalHTML);
}

// Close Athlete Details Modal
function closeAthleteDetailsModal() {
    const modal = document.getElementById('athleteDetailsModal');
    if (modal) {
        modal.remove();
    }
}

// Utility Functions
function getStatusIcon(status) {
    const icons = {
        'approved': '<i class="fas fa-check-circle"></i>',
        'pending': '<i class="fas fa-clock"></i>',
        'rejected': '<i class="fas fa-times-circle"></i>',
        'archived': '<i class="fas fa-archive"></i>'
    };
    return icons[status] || '';
}

function formatDate(dateString) {
    if (!dateString) return '-';
    const date = new Date(dateString);
    return date.toLocaleDateString('en-MY', { year: 'numeric', month: 'short', day: 'numeric' });
}

function escapeHtml(text) {
    if (!text) return '';
    const map = {
        '&': '&amp;',
        '<': '&lt;',
        '>': '&gt;',
        '"': '&quot;',
        "'": '&#039;'
    };
    return text.replace(/[&<>"']/g, m => map[m]);
}
