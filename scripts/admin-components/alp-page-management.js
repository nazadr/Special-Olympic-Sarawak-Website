// ALP Page Settings Management
// Handles hero section and rich text description content for the Athlete Leadership Program page

document.addEventListener('DOMContentLoaded', function() {
    // Load ALP page settings when the ALP section is active
    const alpSection = document.getElementById('alp');
    if (alpSection) {
        loadAlpPageSettings();
    }
});

// Load current ALP page settings
function loadAlpPageSettings() {
    fetch('handler/admin_alp_page_handler.php?action=fetch')
        .then(response => response.json())
        .then(data => {
            if (data.success && data.data) {
                populateAlpForm(data.data);
            } else {
                console.error('Failed to load ALP page settings:', data.message);
            }
        })
        .catch(error => {
            console.error('Error loading ALP page settings:', error);
        });
}

// Populate form with existing data
function populateAlpForm(settings) {
    // Hero section
    document.getElementById('heroTitle').value = settings.hero_title || 'Athlete Leadership Program (ALP)';
    document.getElementById('currentHeroTitle').textContent = settings.hero_title || 'Athlete Leadership Program (ALP)';
    
    if (settings.hero_image_path) {
        const heroImg = document.getElementById('currentHeroImage');
        heroImg.src = settings.hero_image_path;
        heroImg.onerror = function() {
            // Fallback to default image if path is invalid
            this.src = '../assets/images/alp-hero-temp.jpg';
        };
    }
    
    // Description content - set HTML in the editor
    const editor = document.getElementById('descriptionContent');
    if (editor && settings.description_content) {
        editor.innerHTML = settings.description_content;
    }
    
    // Last updated info
    if (settings.updated_at) {
        const lastUpdatedDiv = document.getElementById('alpLastUpdated');
        const updateTime = document.getElementById('alpUpdateTime');
        const updateBy = document.getElementById('alpUpdateBy');
        
        const date = new Date(settings.updated_at);
        updateTime.textContent = date.toLocaleString();
        updateBy.textContent = settings.updated_by || 'Admin';
        lastUpdatedDiv.style.display = 'block';
    }
}

// Handle hero image selection
function handleHeroImageSelect(input) {
    const file = input.files[0];
    if (file) {
        // Validate file size (5MB max)
        if (file.size > 5 * 1024 * 1024) {
            alert('File size must be less than 5MB');
            input.value = '';
            return;
        }
        
        // Validate file type
        if (!file.type.startsWith('image/')) {
            alert('Please select a valid image file');
            input.value = '';
            return;
        }
        
        // Update status
        document.getElementById('heroImageStatus').textContent = file.name;
        
        // Show preview
        const reader = new FileReader();
        reader.onload = function(e) {
            const preview = document.getElementById('heroImagePreview');
            const img = preview.querySelector('img');
            img.src = e.target.result;
            preview.style.display = 'block';
            
            // Update the hero preview as well
            document.getElementById('currentHeroImage').src = e.target.result;
        };
        reader.readAsDataURL(file);
    }
}

// Update hero title preview in real-time
document.addEventListener('DOMContentLoaded', function() {
    const heroTitleInput = document.getElementById('heroTitle');
    if (heroTitleInput) {
        heroTitleInput.addEventListener('input', function() {
            document.getElementById('currentHeroTitle').textContent = this.value || 'Athlete Leadership Program (ALP)';
        });
    }
});

// Rich Text Editor Functions
function formatText(command, value = null) {
    document.execCommand(command, false, value);
    document.getElementById('descriptionContent').focus();
}

function clearFormatting() {
    document.execCommand('removeFormat', false, null);
    document.getElementById('descriptionContent').focus();
}

// Save all ALP page settings
function saveAlpPageSettings() {
    const saveBtn = document.querySelector('.btn-save-alp');
    const originalText = saveBtn.innerHTML;
    
    // Disable button and show loading state
    saveBtn.disabled = true;
    saveBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Saving...';
    
    // Get HTML content from the editor
    const descriptionContent = document.getElementById('descriptionContent').innerHTML;
    
    // Prepare form data
    const formData = new FormData();
    formData.append('action', 'update');
    formData.append('hero_title', document.getElementById('heroTitle').value);
    formData.append('description_content', descriptionContent);
    
    // Get admin info from session
    formData.append('updated_by', 'SO Sarawak Admin'); // This should come from PHP session
    
    // Add hero image if selected
    const heroImageInput = document.getElementById('heroImage');
    if (heroImageInput.files.length > 0) {
        formData.append('hero_image', heroImageInput.files[0]);
    }
    
    // Send update request
    fetch('handler/admin_alp_page_handler.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        saveBtn.disabled = false;
        saveBtn.innerHTML = originalText;
        
        if (data.success) {
            // Show success message
            showNotification('success', 'ALP page settings updated successfully!');
            
            // Reload settings to show updated info
            loadAlpPageSettings();
            
            // Clear file input
            heroImageInput.value = '';
            document.getElementById('heroImageStatus').textContent = 'No file selected';
            document.getElementById('heroImagePreview').style.display = 'none';
            
            // Clear draft
            localStorage.removeItem('alp_page_draft');
        } else {
            showNotification('error', 'Failed to update settings: ' + data.message);
        }
    })
    .catch(error => {
        saveBtn.disabled = false;
        saveBtn.innerHTML = originalText;
        console.error('Error saving ALP page settings:', error);
        showNotification('error', 'An error occurred while saving. Please try again.');
    });
}

// Preview ALP page
function previewAlpPage() {
    window.open('../src/alp.php', '_blank');
}

// Show notification (reuse existing notification system or create new one)
function showNotification(type, message) {
    // Check if there's an existing notification system
    if (typeof window.showAlert === 'function') {
        window.showAlert(message, type);
    } else {
        // Fallback to simple alert
        if (type === 'success') {
            alert('✓ ' + message);
        } else {
            alert('✗ ' + message);
        }
    }
}

// Auto-save draft feature DISABLED to prevent annoying popups
// If you want to enable draft auto-save, uncomment the code below

// function autoSaveDraft() {
//     const draftData = {
//         hero_title: document.getElementById('heroTitle').value,
//         description_content: document.getElementById('descriptionContent').innerHTML,
//         timestamp: new Date().toISOString()
//     };
//     
//     localStorage.setItem('alp_page_draft', JSON.stringify(draftData));
// }

// function checkForDraft() {
//     const draft = localStorage.getItem('alp_page_draft');
//     if (draft) {
//         const draftData = JSON.parse(draft);
//         const draftAge = Date.now() - new Date(draftData.timestamp).getTime();
//         
//         // If draft is less than 24 hours old
//         if (draftAge < 24 * 60 * 60 * 1000) {
//             if (confirm('A draft was found. Would you like to restore it?')) {
//                 document.getElementById('heroTitle').value = draftData.hero_title || '';
//                 document.getElementById('descriptionContent').innerHTML = draftData.description_content || '';
//             }
//         }
//     }
// }

// document.addEventListener('DOMContentLoaded', function() {
//     checkForDraft();
//     setInterval(autoSaveDraft, 30000);
// });
