// ========================================
// SHARED PARTICIPANTS MANAGEMENT
// Upload, Export, and Common Functions
// For Athletes, Coaches, and Volunteers
// ========================================

let currentParticipantType = '';

// Open Upload Modal
function openUploadModal(type) {
    currentParticipantType = type;
    document.getElementById('participantType').value = type;
    
    // Update modal title
    const titles = {
        'athletes': 'Upload Athletes Excel File',
        'coaches': 'Upload Coaches Excel File',
        'volunteers': 'Upload Volunteers Excel File'
    };
    document.getElementById('uploadModalTitle').textContent = titles[type];
    
    // Update column mapping guide
    updateColumnMappingGuide(type);
    
    // Show modal
    document.getElementById('uploadExcelModal').style.display = 'flex';
    
    // Reset form
    document.getElementById('uploadExcelForm').reset();
    document.getElementById('selectedFileName').style.display = 'none';
    document.getElementById('uploadProgress').style.display = 'none';
    document.getElementById('uploadResults').style.display = 'none';
}

// Close Upload Modal
function closeUploadModal() {
    document.getElementById('uploadExcelModal').style.display = 'none';
    document.getElementById('uploadExcelForm').reset();
    currentParticipantType = '';
}

// Update Column Mapping Guide
function updateColumnMappingGuide(type) {
    const guides = {
        'athletes': `
            <p style="margin: 0 0 8px 0; font-weight: 600;">Expected columns in order:</p>
            <ol class="column-list">
                <li>Full Name (required)</li>
                <li>Email</li>
                <li>Phone</li>
                <li>Date of Birth (YYYY-MM-DD)</li>
                <li>Gender (Male/Female/Other)</li>
                <li>Chapter (Kuching/Miri/Sibu/Bintulu/Samarahan)</li>
                <li>Sports Interested</li>
                <li>Medical Conditions</li>
                <li>Emergency Contact Name</li>
                <li>Emergency Contact Phone</li>
                <li>Registration Date (optional, defaults to now)</li>
            </ol>
        `,
        'coaches': `
            <p style="margin: 0 0 8px 0; font-weight: 600;">Expected columns in order:</p>
            <ol class="column-list">
                <li>Full Name (required)</li>
                <li>Email</li>
                <li>Phone</li>
                <li>Date of Birth (YYYY-MM-DD)</li>
                <li>Gender (Male/Female/Other)</li>
                <li>Chapter (Kuching/Miri/Sibu/Bintulu/Samarahan)</li>
                <li>Sports Expertise</li>
                <li>Experience Years (number)</li>
                <li>Certifications</li>
                <li>Availability</li>
                <li>Emergency Contact Name</li>
                <li>Emergency Contact Phone</li>
                <li>Registration Date (optional)</li>
            </ol>
        `,
        'volunteers': `
            <p style="margin: 0 0 8px 0; font-weight: 600;">Expected columns in order:</p>
            <ol class="column-list">
                <li>Full Name (required)</li>
                <li>Email</li>
                <li>Phone</li>
                <li>Date of Birth (YYYY-MM-DD)</li>
                <li>Gender (Male/Female/Other)</li>
                <li>Chapter (Kuching/Miri/Sibu/Bintulu/Samarahan)</li>
                <li>Volunteer Role</li>
                <li>Skills</li>
                <li>Availability</li>
                <li>Previous Volunteer Experience</li>
                <li>Emergency Contact Name</li>
                <li>Emergency Contact Phone</li>
                <li>Registration Date (optional)</li>
            </ol>
        `
    };
    
    document.getElementById('columnMappingGuide').innerHTML = guides[type];
}

// Handle Excel File Select
function handleExcelFileSelect(input) {
    const file = input.files[0];
    if (file) {
        const allowedExtensions = ['xlsx', 'xls', 'csv'];
        const fileExtension = file.name.split('.').pop().toLowerCase();
        
        if (!allowedExtensions.includes(fileExtension)) {
            showNotification('Invalid file type. Please upload Excel or CSV file.', 'error');
            input.value = '';
            return;
        }

        // Show selected file
        document.getElementById('selectedFileName').style.display = 'flex';
        document.getElementById('fileNameText').textContent = file.name;
    }
}

// Remove Excel File
function removeExcelFile() {
    document.getElementById('excelFile').value = '';
    document.getElementById('selectedFileName').style.display = 'none';
}

// Submit Upload Form
document.addEventListener('DOMContentLoaded', function() {
    const uploadForm = document.getElementById('uploadExcelForm');
    if (uploadForm) {
        uploadForm.addEventListener('submit', function(e) {
            e.preventDefault();
            submitExcelUpload();
        });
    }
});

// Submit Excel Upload
function submitExcelUpload() {
    const fileInput = document.getElementById('excelFile');
    const file = fileInput.files[0];
    
    if (!file) {
        showNotification('Please select a file to upload', 'error');
        return;
    }

    // Show progress
    document.getElementById('uploadProgress').style.display = 'block';
    document.getElementById('uploadResults').style.display = 'none';
    document.getElementById('uploadStatus').textContent = 'Uploading file...';
    document.getElementById('uploadProgressBar').style.width = '30%';

    // Prepare form data
    const formData = new FormData();
    formData.append('action', 'upload');
    formData.append('excelFile', file);

    // Determine handler based on participant type
    const handlers = {
        'athletes': 'handler/admin_athletes_handler.php',
        'coaches': 'handler/admin_coaches_handler.php',
        'volunteers': 'handler/admin_volunteers_handler.php'
    };

    const handlerUrl = handlers[currentParticipantType];

    // Update status
    document.getElementById('uploadStatus').textContent = 'Processing Excel file...';
    document.getElementById('uploadProgressBar').style.width = '60%';

    // Upload file
    fetch(handlerUrl, {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        document.getElementById('uploadProgressBar').style.width = '100%';
        document.getElementById('uploadStatus').textContent = 'Processing complete!';
        
        setTimeout(() => {
            document.getElementById('uploadProgress').style.display = 'none';
            displayUploadResults(data);
        }, 500);
    })
    .catch(error => {
        console.error('Error:', error);
        document.getElementById('uploadProgress').style.display = 'none';
        showNotification('Upload failed. Please try again.', 'error');
    });
}

// Display Upload Results
function displayUploadResults(data) {
    const resultsDiv = document.getElementById('uploadResults');
    resultsDiv.style.display = 'block';

    if (data.success) {
        let resultsHTML = `
            <div style="background: #d1fae5; border-left: 4px solid #10b981; padding: 20px; border-radius: 8px;">
                <h4 style="margin: 0 0 12px 0; color: #065f46; font-size: 16px; display: flex; align-items: center; gap: 8px;">
                    <i class="fas fa-check-circle"></i> Upload Successful!
                </h4>
                <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 16px; margin-bottom: 16px;">
                    <div style="background: white; padding: 12px; border-radius: 6px; text-align: center;">
                        <div style="font-size: 24px; font-weight: 700; color: #10b981;">${data.imported || 0}</div>
                        <div style="font-size: 12px; color: #64748b; margin-top: 4px;">New Records</div>
                    </div>
                    <div style="background: white; padding: 12px; border-radius: 6px; text-align: center;">
                        <div style="font-size: 24px; font-weight: 700; color: #3b82f6;">${data.updated || 0}</div>
                        <div style="font-size: 12px; color: #64748b; margin-top: 4px;">Updated Records</div>
                    </div>
                    <div style="background: white; padding: 12px; border-radius: 6px; text-align: center;">
                        <div style="font-size: 24px; font-weight: 700; color: ${data.failed > 0 ? '#ef4444' : '#10b981'}">${data.failed || 0}</div>
                        <div style="font-size: 12px; color: #64748b; margin-top: 4px;">Failed Records</div>
                    </div>
                </div>
        `;

        if (data.errors && data.errors.length > 0) {
            resultsHTML += `
                <div style="margin-top: 12px; padding: 12px; background: #fef3c7; border-radius: 6px;">
                    <h5 style="margin: 0 0 8px 0; color: #92400e; font-size: 13px; font-weight: 600;">
                        <i class="fas fa-exclamation-triangle"></i> Errors encountered:
                    </h5>
                    <ul style="margin: 0; padding-left: 20px; font-size: 12px; color: #78350f; max-height: 150px; overflow-y: auto;">
                        ${data.errors.map(error => `<li>${escapeHtml(error)}</li>`).join('')}
                    </ul>
                </div>
            `;
        }

        resultsHTML += `
                <div style="margin-top: 16px; text-align: right;">
                    <button class="btn-submit" onclick="finishUpload()">
                        <i class="fas fa-check"></i> Done
                    </button>
                </div>
            </div>
        `;

        resultsDiv.innerHTML = resultsHTML;
        showNotification(`Successfully imported ${data.imported} and updated ${data.updated} records!`, 'success');
    } else {
        resultsDiv.innerHTML = `
            <div style="background: #fee2e2; border-left: 4px solid #ef4444; padding: 20px; border-radius: 8px;">
                <h4 style="margin: 0 0 12px 0; color: #991b1b; font-size: 16px; display: flex; align-items: center; gap: 8px;">
                    <i class="fas fa-exclamation-circle"></i> Upload Failed
                </h4>
                <p style="margin: 0; color: #7f1d1d; font-size: 14px;">${escapeHtml(data.message)}</p>
                <div style="margin-top: 16px; text-align: right;">
                    <button class="btn-cancel" onclick="closeUploadModal()">Close</button>
                </div>
            </div>
        `;
        showNotification(data.message || 'Upload failed', 'error');
    }
}

// Finish Upload and Refresh Data
function finishUpload() {
    closeUploadModal();
    
    // Reload data based on current participant type
    if (currentParticipantType === 'athletes') {
        loadAthletesData();
    } else if (currentParticipantType === 'coaches') {
        loadCoachesData();
    } else if (currentParticipantType === 'volunteers') {
        loadVolunteersData();
    }
}

// Export Data to CSV
function exportData(type) {
    const typeText = type.charAt(0).toUpperCase() + type.slice(1);
    
    if (!confirm(`Export all ${typeText} data to CSV?`)) {
        return;
    }

    const handlers = {
        'athletes': 'handler/admin_athletes_handler.php',
        'coaches': 'handler/admin_coaches_handler.php',
        'volunteers': 'handler/admin_volunteers_handler.php'
    };

    // Create a temporary link to trigger download
    window.location.href = `${handlers[type]}?action=export`;
    
    showNotification(`Exporting ${typeText} data...`, 'success');
}

// Utility function for escaping HTML (if not already defined)
function escapeHtml(text) {
    if (!text) return '';
    const map = {
        '&': '&amp;',
        '<': '&lt;',
        '>': '&gt;',
        '"': '&quot;',
        "'": '&#039;'
    };
    return text.toString().replace(/[&<>"']/g, m => map[m]);
}

// Open Add Participant Modal
function openAddParticipantModal(type) {
    currentParticipantType = type;
    document.getElementById('addParticipantType').value = type;
    
    // Update modal title
    const titles = {
        'athletes': 'Add New Athlete',
        'coaches': 'Add New Coach',
        'volunteers': 'Add New Volunteer'
    };
    document.getElementById('addParticipantModalTitle').textContent = titles[type];
    
    // Show/hide type-specific fields
    document.getElementById('athleteSpecificFields').style.display = type === 'athletes' ? 'block' : 'none';
    document.getElementById('coachSpecificFields').style.display = type === 'coaches' ? 'block' : 'none';
    document.getElementById('volunteerSpecificFields').style.display = type === 'volunteers' ? 'block' : 'none';
    
    // Show modal
    document.getElementById('addParticipantModal').style.display = 'flex';
    
    // Reset form
    document.getElementById('addParticipantForm').reset();
}

// Close Add Participant Modal
function closeAddParticipantModal() {
    document.getElementById('addParticipantModal').style.display = 'none';
    document.getElementById('addParticipantForm').reset();
    currentParticipantType = '';
}

// Submit Add Participant Form
document.addEventListener('DOMContentLoaded', function() {
    const addForm = document.getElementById('addParticipantForm');
    if (addForm) {
        addForm.addEventListener('submit', function(e) {
            e.preventDefault();
            submitAddParticipant();
        });
    }
});

function submitAddParticipant() {
    const formData = new FormData(document.getElementById('addParticipantForm'));
    formData.append('action', 'add');
    
    // Determine handler based on participant type
    const handlers = {
        'athletes': 'handler/admin_athletes_handler.php',
        'coaches': 'handler/admin_coaches_handler.php',
        'volunteers': 'handler/admin_volunteers_handler.php'
    };
    
    const handlerUrl = handlers[currentParticipantType];
    
    // Disable submit button
    const submitBtn = document.querySelector('#addParticipantForm button[type="submit"]');
    const originalText = submitBtn.innerHTML;
    submitBtn.disabled = true;
    submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Adding...';
    
    fetch(handlerUrl, {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showNotification(data.message || 'Participant added successfully!', 'success');
            closeAddParticipantModal();
            
            // Auto-refresh data
            if (currentParticipantType === 'athletes') {
                loadAthletesData();
            } else if (currentParticipantType === 'coaches') {
                loadCoachesData();
            } else if (currentParticipantType === 'volunteers') {
                loadVolunteersData();
            }
        } else {
            showNotification(data.message || 'Failed to add participant', 'error');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showNotification('An error occurred. Please try again.', 'error');
    })
    .finally(() => {
        submitBtn.disabled = false;
        submitBtn.innerHTML = originalText;
    });
}
