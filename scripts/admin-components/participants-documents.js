// Participants Documents Management
// Google Drive-inspired document explorer for Excel upload tracking

let currentDocView = 'list'; // 'list' or 'grid'
let currentDocFilter = 'all';
let currentDocSort = 'date-desc';
let documentsData = [];

// Initialize when section is opened
document.addEventListener('DOMContentLoaded', function() {
    // Load documents when navigating to the section
    const docNavItem = document.querySelector('[data-section="documents"]');
    if (docNavItem) {
        docNavItem.addEventListener('click', function() {
            loadDocuments();
            loadDocumentStats();
        });
    }
    
    // Search functionality
    const searchInput = document.getElementById('docsSearchInput');
    if (searchInput) {
        let searchTimeout;
        searchInput.addEventListener('input', function() {
            clearTimeout(searchTimeout);
            searchTimeout = setTimeout(() => {
                loadDocuments();
            }, 500);
        });
    }
    
    // Type filter
    const typeFilter = document.getElementById('docsTypeFilter');
    if (typeFilter) {
        typeFilter.addEventListener('change', function() {
            currentDocFilter = this.value;
            loadDocuments();
        });
    }
    
    // Sort select
    const sortSelect = document.getElementById('docsSortBy');
    if (sortSelect) {
        sortSelect.addEventListener('change', function() {
            currentDocSort = this.value;
            loadDocuments();
        });
    }
});

// Load document statistics
function loadDocumentStats() {
    fetch('handler/admin_documents_handler.php?action=fetchStats')
        .then(response => {
            if (!response.ok) {
                throw new Error('Database not set up');
            }
            return response.json();
        })
        .then(data => {
            if (data.success && data.stats) {
                const stats = data.stats;
                const totalEl = document.getElementById('docsTotalCount');
                const athletesEl = document.getElementById('docsAthletesCount');
                const coachesEl = document.getElementById('docsCoachesCount');
                const volunteersEl = document.getElementById('docsVolunteersCount');
                
                if (totalEl) totalEl.textContent = stats.total || 0;
                if (athletesEl) athletesEl.textContent = stats.athletes || 0;
                if (coachesEl) coachesEl.textContent = stats.coaches || 0;
                if (volunteersEl) volunteersEl.textContent = stats.volunteers || 0;
            }
        })
        .catch(error => {
            console.error('Error loading document stats:', error);
            // Silently fail for stats - the main table will show the setup message
        });
}

// Load documents with filters
function loadDocuments() {
    const search = document.getElementById('docsSearchInput').value;
    const type = currentDocFilter;
    const sortBy = currentDocSort;
    
    const params = new URLSearchParams({
        action: 'fetch',
        search: search,
        type: type,
        sortBy: sortBy,
        limit: 100,
        offset: 0
    });
    
    fetch(`handler/admin_documents_handler.php?${params}`)
        .then(response => {
            if (!response.ok) {
                throw new Error(`HTTP ${response.status}: Database table not set up. Please run admin/SETUP_DOCUMENTS_TABLE.sql in phpMyAdmin.`);
            }
            return response.json();
        })
        .then(data => {
            if (data.success) {
                documentsData = data.data || [];
                if (currentDocView === 'list') {
                    displayDocumentsList(documentsData);
                } else {
                    displayDocumentsGrid(documentsData);
                }
            } else {
                const tbody = document.getElementById('docsTableBody');
                if (tbody) {
                    tbody.innerHTML = `
                        <tr>
                            <td colspan="7" style="text-align: center; padding: 60px 20px;">
                                <i class="fas fa-exclamation-triangle" style="font-size: 48px; color: #f59e0b; margin-bottom: 16px;"></i>
                                <p style="color: #64748b; font-size: 16px; margin: 0; font-weight: 600;">Database Setup Required</p>
                                <p style="color: #94a3b8; font-size: 14px; margin-top: 12px;">Please run <strong>admin/SETUP_DOCUMENTS_TABLE.sql</strong> in phpMyAdmin</p>
                                <p style="color: #94a3b8; font-size: 13px; margin-top: 8px;">This will create the table needed to track Excel uploads.</p>
                            </td>
                        </tr>
                    `;
                }
            }
        })
        .catch(error => {
            console.error('Error loading documents:', error);
            const tbody = document.getElementById('docsTableBody');
            if (tbody) {
                tbody.innerHTML = `
                    <tr>
                        <td colspan="7" style="text-align: center; padding: 60px 20px;">
                            <i class="fas fa-database" style="font-size: 48px; color: #ef4444; margin-bottom: 16px;"></i>
                            <p style="color: #64748b; font-size: 16px; margin: 0; font-weight: 600;">Database Setup Required</p>
                            <p style="color: #94a3b8; font-size: 14px; margin-top: 12px;">Run <strong>admin/SETUP_DOCUMENTS_TABLE.sql</strong> in phpMyAdmin</p>
                            <p style="color: #94a3b8; font-size: 12px; margin-top: 8px; font-family: monospace;">Go to: http://localhost/phpmyadmin → so_sarawak_db → Import → Choose file</p>
                        </td>
                    </tr>
                `;
            }
        });
}

// Display documents in list view
function displayDocumentsList(documents) {
    const tbody = document.getElementById('docsTableBody');
    
    if (documents.length === 0) {
        tbody.innerHTML = `
            <tr>
                <td colspan="7" style="text-align: center; padding: 60px 20px;">
                    <i class="fas fa-folder-open" style="font-size: 48px; color: #cbd5e1; margin-bottom: 16px;"></i>
                    <p style="color: #64748b; font-size: 16px; margin: 0;">No documents found</p>
                    <p style="color: #94a3b8; font-size: 14px; margin-top: 8px;">Upload Excel files to see them here</p>
                </td>
            </tr>
        `;
        return;
    }
    
    tbody.innerHTML = documents.map(doc => {
        const typeColors = {
            'athlete': '#f093fb',
            'coach': '#3b82f6',
            'volunteer': '#f59e0b'
        };
        
        const typeLabels = {
            'athlete': 'Athletes',
            'coach': 'Coaches',
            'volunteer': 'Volunteers'
        };
        
        const statusColors = {
            'success': '#10b981',
            'partial': '#f59e0b',
            'failed': '#ef4444'
        };
        
        const statusLabels = {
            'success': 'Success',
            'partial': 'Partial',
            'failed': 'Failed'
        };
        
        const uploadDate = new Date(doc.created_at);
        const formattedDate = uploadDate.toLocaleDateString('en-GB', {
            day: '2-digit',
            month: 'short',
            year: 'numeric',
            hour: '2-digit',
            minute: '2-digit'
        });
        
        const totalRecords = parseInt(doc.rows_imported) + parseInt(doc.rows_updated) + parseInt(doc.rows_failed);
        
        return `
            <tr style="border-bottom: 1px solid #e2e8f0; transition: background 0.2s;" onmouseover="this.style.background='#f8fafc'" onmouseout="this.style.background='white'">
                <td style="padding: 16px 12px;">
                    <div style="display: flex; align-items: center; gap: 12px;">
                        <div style="width: 40px; height: 40px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 8px; display: flex; align-items: center; justify-content: center; color: white; font-size: 18px;">
                            <i class="fas fa-file-excel"></i>
                        </div>
                        <div>
                            <div style="font-weight: 500; color: #1e293b; font-size: 14px;">${escapeHtml(doc.original_filename)}</div>
                            <div style="font-size: 12px; color: #64748b; margin-top: 2px;">
                                <i class="fas fa-database"></i> v${doc.id}
                            </div>
                        </div>
                    </div>
                </td>
                <td style="padding: 16px 12px;">
                    <span style="display: inline-block; padding: 4px 12px; background: ${typeColors[doc.participant_type]}20; color: ${typeColors[doc.participant_type]}; border-radius: 12px; font-size: 12px; font-weight: 500;">
                        ${typeLabels[doc.participant_type]}
                    </span>
                </td>
                <td style="padding: 16px 12px; color: #64748b; font-size: 13px;">
                    <i class="fas fa-calendar"></i> ${formattedDate}
                </td>
                <td style="padding: 16px 12px; color: #64748b; font-size: 13px;">
                    <i class="fas fa-user"></i> Admin
                </td>
                <td style="padding: 16px 12px; text-align: center;">
                    <div style="font-weight: 600; color: #1e293b; font-size: 14px;">${totalRecords}</div>
                    <div style="font-size: 11px; color: #64748b; margin-top: 2px;">
                        <span style="color: #10b981;">↑${doc.rows_imported}</span> 
                        <span style="color: #3b82f6;">⟳${doc.rows_updated}</span>
                        ${doc.rows_failed > 0 ? `<span style="color: #ef4444;">✕${doc.rows_failed}</span>` : ''}
                    </div>
                </td>
                <td style="padding: 16px 12px; text-align: center;">
                    <span style="display: inline-flex; align-items: center; gap: 6px; padding: 6px 12px; background: ${statusColors[doc.upload_status]}20; color: ${statusColors[doc.upload_status]}; border-radius: 12px; font-size: 12px; font-weight: 500;">
                        <i class="fas fa-${doc.upload_status === 'success' ? 'check-circle' : doc.upload_status === 'partial' ? 'exclamation-circle' : 'times-circle'}"></i>
                        ${statusLabels[doc.upload_status]}
                    </span>
                </td>
                <td style="padding: 16px 12px; text-align: right;">
                    <div style="display: flex; gap: 8px; justify-content: flex-end;">
                        <button onclick="viewDocumentDetails(${doc.id})" style="padding: 8px 12px; background: white; border: 1px solid #cbd5e1; border-radius: 6px; color: #64748b; cursor: pointer; transition: all 0.2s;" onmouseover="this.style.background='#f1f5f9'" onmouseout="this.style.background='white'" title="View Details">
                            <i class="fas fa-eye"></i>
                        </button>
                        <button onclick="downloadDocument(${doc.id})" style="padding: 8px 12px; background: white; border: 1px solid #cbd5e1; border-radius: 6px; color: #3b82f6; cursor: pointer; transition: all 0.2s;" onmouseover="this.style.background='#eff6ff'" onmouseout="this.style.background='white'" title="Download">
                            <i class="fas fa-download"></i>
                        </button>
                        <button onclick="deleteDocument(${doc.id})" style="padding: 8px 12px; background: white; border: 1px solid #cbd5e1; border-radius: 6px; color: #ef4444; cursor: pointer; transition: all 0.2s;" onmouseover="this.style.background='#fef2f2'" onmouseout="this.style.background='white'" title="Delete">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                </td>
            </tr>
        `;
    }).join('');
}

// Display documents in grid view
function displayDocumentsGrid(documents) {
    const container = document.getElementById('docsGridView');
    
    if (documents.length === 0) {
        container.innerHTML = `
            <div style="text-align: center; padding: 60px 20px;">
                <i class="fas fa-folder-open" style="font-size: 64px; color: #cbd5e1; margin-bottom: 24px;"></i>
                <p style="color: #64748b; font-size: 18px; margin: 0;">No documents found</p>
                <p style="color: #94a3b8; font-size: 14px; margin-top: 12px;">Upload Excel files to see them here</p>
            </div>
        `;
        return;
    }
    
    container.innerHTML = `
        <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 20px; padding: 20px;">
            ${documents.map(doc => {
                const typeColors = {
                    'athlete': '#f093fb',
                    'coach': '#3b82f6',
                    'volunteer': '#f59e0b'
                };
                
                const uploadDate = new Date(doc.created_at);
                const formattedDate = uploadDate.toLocaleDateString('en-GB', {
                    day: '2-digit',
                    month: 'short',
                    year: 'numeric'
                });
                
                const totalRecords = parseInt(doc.rows_imported) + parseInt(doc.rows_updated) + parseInt(doc.rows_failed);
                
                return `
                    <div style="background: white; border-radius: 12px; padding: 20px; box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1); transition: all 0.3s; cursor: pointer;" onmouseover="this.style.transform='translateY(-4px)'; this.style.boxShadow='0 4px 12px rgba(0,0,0,0.15)'" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 1px 3px rgba(0,0,0,0.1)'" onclick="viewDocumentDetails(${doc.id})">
                        <div style="width: 100%; height: 120px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 8px; display: flex; align-items: center; justify-content: center; margin-bottom: 16px;">
                            <i class="fas fa-file-excel" style="font-size: 48px; color: white;"></i>
                        </div>
                        <div style="font-weight: 600; color: #1e293b; font-size: 14px; margin-bottom: 8px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;" title="${escapeHtml(doc.original_filename)}">
                            ${escapeHtml(doc.original_filename)}
                        </div>
                        <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 12px;">
                            <span style="font-size: 12px; color: #64748b;">
                                <i class="fas fa-calendar"></i> ${formattedDate}
                            </span>
                            <span style="font-size: 12px; font-weight: 600; color: ${typeColors[doc.participant_type]};">
                                v${doc.id}
                            </span>
                        </div>
                        <div style="padding: 12px; background: #f8fafc; border-radius: 6px; margin-bottom: 12px;">
                            <div style="font-size: 11px; color: #64748b; margin-bottom: 4px;">Records Processed</div>
                            <div style="font-size: 18px; font-weight: 700; color: #1e293b;">${totalRecords}</div>
                            <div style="font-size: 11px; color: #64748b; margin-top: 4px;">
                                <span style="color: #10b981;">↑${doc.rows_imported}</span> · 
                                <span style="color: #3b82f6;">⟳${doc.rows_updated}</span>
                                ${doc.rows_failed > 0 ? ` · <span style="color: #ef4444;">✕${doc.rows_failed}</span>` : ''}
                            </div>
                        </div>
                        <div style="display: flex; gap: 8px;">
                            <button onclick="event.stopPropagation(); downloadDocument(${doc.id})" style="flex: 1; padding: 8px; background: #3b82f6; color: white; border: none; border-radius: 6px; font-size: 12px; cursor: pointer; transition: all 0.2s;" onmouseover="this.style.background='#2563eb'" onmouseout="this.style.background='#3b82f6'">
                                <i class="fas fa-download"></i> Download
                            </button>
                            <button onclick="event.stopPropagation(); deleteDocument(${doc.id})" style="padding: 8px 12px; background: white; border: 1px solid #fecaca; color: #ef4444; border-radius: 6px; font-size: 12px; cursor: pointer; transition: all 0.2s;" onmouseover="this.style.background='#fef2f2'" onmouseout="this.style.background='white'">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </div>
                `;
            }).join('')}
        </div>
    `;
}

// Toggle between grid and list view
function toggleDocView(view) {
    currentDocView = view;
    
    const gridView = document.getElementById('docsGridView');
    const listView = document.getElementById('docsListView');
    const gridBtn = document.getElementById('gridViewBtn');
    const listBtn = document.getElementById('listViewBtn');
    
    if (view === 'grid') {
        gridView.style.display = 'block';
        listView.style.display = 'none';
        gridBtn.classList.add('active');
        listBtn.classList.remove('active');
        displayDocumentsGrid(documentsData);
    } else {
        gridView.style.display = 'none';
        listView.style.display = 'block';
        listBtn.classList.add('active');
        gridBtn.classList.remove('active');
        displayDocumentsList(documentsData);
    }
}

// View document details
function viewDocumentDetails(id) {
    const doc = documentsData.find(d => d.id === id);
    if (!doc) return;
    
    const uploadDate = new Date(doc.created_at).toLocaleString('en-GB');
    const totalRecords = parseInt(doc.rows_imported) + parseInt(doc.rows_updated) + parseInt(doc.rows_failed);
    
    const detailsHTML = `
        <div style="max-width: 600px;">
            <h3 style="margin: 0 0 20px 0; color: #1e293b;">
                <i class="fas fa-file-excel"></i> Document Details
            </h3>
            <div style="background: #f8fafc; padding: 20px; border-radius: 8px; margin-bottom: 20px;">
                <div style="font-size: 16px; font-weight: 600; color: #1e293b; margin-bottom: 8px;">
                    ${escapeHtml(doc.original_filename)}
                </div>
                <div style="font-size: 12px; color: #64748b;">
                    Version ${doc.id} · Uploaded ${uploadDate}
                </div>
            </div>
            
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px; margin-bottom: 20px;">
                <div style="padding: 16px; background: white; border: 1px solid #e2e8f0; border-radius: 8px;">
                    <div style="font-size: 11px; color: #64748b; margin-bottom: 4px;">Type</div>
                    <div style="font-weight: 600; color: #1e293b; text-transform: capitalize;">${doc.participant_type}s</div>
                </div>
                <div style="padding: 16px; background: white; border: 1px solid #e2e8f0; border-radius: 8px;">
                    <div style="font-size: 11px; color: #64748b; margin-bottom: 4px;">Status</div>
                    <div style="font-weight: 600; color: ${doc.upload_status === 'success' ? '#10b981' : '#f59e0b'}; text-transform: capitalize;">${doc.upload_status}</div>
                </div>
            </div>
            
            <div style="padding: 20px; background: white; border: 1px solid #e2e8f0; border-radius: 8px; margin-bottom: 20px;">
                <h4 style="margin: 0 0 16px 0; font-size: 14px; color: #1e293b;">Import Statistics</h4>
                <div style="display: grid; gap: 12px;">
                    <div style="display: flex; justify-content: space-between; align-items: center;">
                        <span style="color: #64748b; font-size: 13px;">Total Records</span>
                        <span style="font-weight: 600; color: #1e293b; font-size: 16px;">${totalRecords}</span>
                    </div>
                    <div style="display: flex; justify-content: space-between; align-items: center;">
                        <span style="color: #10b981; font-size: 13px;"><i class="fas fa-arrow-up"></i> New Records</span>
                        <span style="font-weight: 600; color: #10b981;">${doc.rows_imported}</span>
                    </div>
                    <div style="display: flex; justify-content: space-between; align-items: center;">
                        <span style="color: #3b82f6; font-size: 13px;"><i class="fas fa-sync"></i> Updated Records</span>
                        <span style="font-weight: 600; color: #3b82f6;">${doc.rows_updated}</span>
                    </div>
                    ${doc.rows_failed > 0 ? `
                    <div style="display: flex; justify-content: space-between; align-items: center;">
                        <span style="color: #ef4444; font-size: 13px;"><i class="fas fa-times"></i> Failed Records</span>
                        <span style="font-weight: 600; color: #ef4444;">${doc.rows_failed}</span>
                    </div>
                    ` : ''}
                </div>
            </div>
            
            ${doc.error_log ? `
            <div style="padding: 16px; background: #fef2f2; border: 1px solid #fecaca; border-radius: 8px;">
                <h4 style="margin: 0 0 8px 0; font-size: 13px; color: #ef4444;">
                    <i class="fas fa-exclamation-triangle"></i> Error Log
                </h4>
                <pre style="font-size: 11px; color: #991b1b; white-space: pre-wrap; margin: 0; max-height: 200px; overflow-y: auto;">${escapeHtml(doc.error_log)}</pre>
            </div>
            ` : ''}
        </div>
    `;
    
    // Use existing modal or create new one
    showModal('Document Details', detailsHTML);
}

// Download document
function downloadDocument(id) {
    window.location.href = `handler/admin_documents_handler.php?action=download&id=${id}`;
    showNotification('Download started...', 'success');
}

// Delete document
function deleteDocument(id) {
    const doc = documentsData.find(d => d.id === id);
    if (!doc) return;
    
    if (!confirm(`Are you sure you want to delete "${doc.original_filename}"?\n\nThis will remove the upload record but NOT delete the participant data already imported.`)) {
        return;
    }
    
    fetch('handler/admin_documents_handler.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: `action=delete&id=${id}`
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showNotification('Document deleted successfully', 'success');
            loadDocuments();
            loadDocumentStats();
        } else {
            showNotification(data.message || 'Failed to delete document', 'error');
        }
    })
    .catch(error => {
        console.error('Error deleting document:', error);
        showNotification('Failed to delete document', 'error');
    });
}

// Helper function for modal display (reuse existing modal system or create basic one)
function showModal(title, content) {
    // This would integrate with your existing modal system
    // For now, using a simple alert
    alert(title + '\n\n' + content.replace(/<[^>]*>/g, ''));
}

// Helper function to escape HTML
function escapeHtml(text) {
    if (!text) return '';
    const div = document.createElement('div');
    div.textContent = text;
    return div.innerHTML;
}