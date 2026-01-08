// YAP Page Management JavaScript Functions (Matching ALP Structure)

// Global variable to store the current hero image path
let currentYapHeroImagePath = '';
let currentYapResourcesImagePath = '';

// Format text in the YAP description editor
function formatYapText(command, value = null) {
    const editor = document.getElementById('yapDescriptionContent');
    if (!editor) return;
    
    editor.focus();
    document.execCommand(command, false, value);
}

// Clear formatting in YAP editor
function clearYapFormatting() {
    const editor = document.getElementById('yapDescriptionContent');
    if (!editor) return;
    
    const selection = window.getSelection();
    if (!selection.rangeCount) return;
    
    const range = selection.getRangeAt(0);
    const selectedText = range.toString();
    
    if (selectedText) {
        range.deleteContents();
        range.insertNode(document.createTextNode(selectedText));
    }
}

// Handle hero image selection
function handleYapHeroImageSelect(input) {
    const file = input.files[0];
    const preview = document.getElementById('yapHeroImagePreview');
    const status = document.getElementById('yapHeroImageStatus');
    
    if (file) {
        // Validate file size (max 5MB)
        if (file.size > 5 * 1024 * 1024) {
            showNotification('Image size must be less than 5MB', 'error');
            input.value = '';
            return;
        }
        
        // Validate file type
        if (!file.type.match('image.*')) {
            showNotification('Please select a valid image file', 'error');
            input.value = '';
            return;
        }
        
        const reader = new FileReader();
        reader.onload = function(e) {
            preview.querySelector('img').src = e.target.result;
            preview.style.display = 'block';
            
            // Update current hero preview
            const currentHeroImage = document.getElementById('currentYapHeroImage');
            const currentHeroPreview = document.getElementById('currentYapHeroPreview');
            if (currentHeroImage) {
                currentHeroImage.src = e.target.result;
            }
            if (currentHeroPreview) {
                currentHeroPreview.style.display = 'block';
            }
        };
        reader.readAsDataURL(file);
        
        status.textContent = file.name;
        status.style.color = '#10b981';
    }
}

// Handle resources image selection
function handleYapResourcesImageSelect(input) {
    const file = input.files[0];
    const preview = document.getElementById('yapResourcesImagePreview');
    const status = document.getElementById('yapResourcesImageStatus');
    
    if (file) {
        // Validate file size (max 5MB)
        if (file.size > 5 * 1024 * 1024) {
            showNotification('Image size must be less than 5MB', 'error');
            input.value = '';
            return;
        }
        
        // Validate file type
        if (!file.type.match('image.*')) {
            showNotification('Please select a valid image file', 'error');
            input.value = '';
            return;
        }
        
        const reader = new FileReader();
        reader.onload = function(e) {
            preview.querySelector('img').src = e.target.result;
            preview.style.display = 'block';
        };
        reader.readAsDataURL(file);
        
        status.textContent = file.name;
        status.style.color = '#10b981';
    }
}

// Load YAP page settings
function loadYapPageSettings() {
    fetch('handler/admin_yap_handler.php?action=get_yap_content')
        .then(response => response.json())
        .then(data => {
            if (data.success && data.data) {
                const yapData = data.data;
                
                // Populate hero section
                document.getElementById('yapHeroTitle').value = yapData.hero_title || 'Young Athletes Program (YAP)';
                
                // Set hero image
                if (yapData.hero_image) {
                    currentYapHeroImagePath = yapData.hero_image;
                    const currentHeroImage = document.getElementById('currentYapHeroImage');
                    if (currentHeroImage) {
                        currentHeroImage.src = yapData.hero_image;
                    }
                }
                
                // Update hero title in preview
                const currentHeroTitle = document.getElementById('currentYapHeroTitle');
                if (currentHeroTitle) {
                    currentHeroTitle.textContent = yapData.hero_title || 'Young Athletes Program (YAP)';
                }
                
                // Populate description content (RTE)
                const descriptionEditor = document.getElementById('yapDescriptionContent');
                if (descriptionEditor) {
                    descriptionEditor.innerHTML = yapData.description_text || '';
                }
                
                // Populate testimonial section
                document.getElementById('yapTestimonialText').value = yapData.testimonial_text || '';
                document.getElementById('yapTestimonialAuthor').value = yapData.testimonial_author || '';
                document.getElementById('yapTestimonialLocation').value = yapData.testimonial_location || '';
                
                // Populate resources section
                document.getElementById('yapResourcesTitle').value = yapData.resources_title || '';
                document.getElementById('yapResourcesDescription').value = yapData.resources_description || '';
                document.getElementById('yapResourcesButtonText').value = yapData.resources_button_text || '';
                document.getElementById('yapResourcesButtonLink').value = yapData.resources_button_link || '';
                
                // Set resources image
                if (yapData.resources_background_image) {
                    currentYapResourcesImagePath = yapData.resources_background_image;
                }
                
                // Show last updated info
                if (yapData.updated_at && yapData.updated_by) {
                    const lastUpdated = document.getElementById('yapLastUpdated');
                    const updateTime = document.getElementById('yapUpdateTime');
                    const updateBy = document.getElementById('yapUpdateBy');
                    
                    if (lastUpdated && updateTime && updateBy) {
                        updateTime.textContent = formatDateTime(yapData.updated_at);
                        updateBy.textContent = yapData.updated_by;
                        lastUpdated.style.display = 'flex';
                    }
                }
            }
        })
        .catch(error => {
            console.error('Error loading YAP page settings:', error);
            showNotification('Error loading YAP page settings', 'error');
        });
}

// Save YAP page settings
function saveYapPageSettings() {
    // Get all form values
    const heroTitle = document.getElementById('yapHeroTitle').value.trim();
    const descriptionContent = document.getElementById('yapDescriptionContent').innerHTML;
    const testimonialText = document.getElementById('yapTestimonialText').value.trim();
    const testimonialAuthor = document.getElementById('yapTestimonialAuthor').value.trim();
    const testimonialLocation = document.getElementById('yapTestimonialLocation').value.trim();
    const resourcesTitle = document.getElementById('yapResourcesTitle').value.trim();
    const resourcesDescription = document.getElementById('yapResourcesDescription').value.trim();
    const resourcesButtonText = document.getElementById('yapResourcesButtonText').value.trim();
    const resourcesButtonLink = document.getElementById('yapResourcesButtonLink').value.trim();
    
    // Validate required fields
    if (!heroTitle) {
        showNotification('Please enter a hero title', 'error');
        return;
    }
    
    if (!descriptionContent || descriptionContent === '<br>' || descriptionContent.trim() === '') {
        showNotification('Please enter description content', 'error');
        return;
    }
    
    // Create FormData object
    const formData = new FormData();
    formData.append('action', 'update_yap_content');
    formData.append('hero_title', heroTitle);
    formData.append('description_text', descriptionContent);
    formData.append('testimonial_text', testimonialText);
    formData.append('testimonial_author', testimonialAuthor);
    formData.append('testimonial_location', testimonialLocation);
    formData.append('resources_title', resourcesTitle);
    formData.append('resources_description', resourcesDescription);
    formData.append('resources_button_text', resourcesButtonText);
    formData.append('resources_button_link', resourcesButtonLink);
    
    // Append hero image if selected
    const heroImageInput = document.getElementById('yapHeroImage');
    if (heroImageInput.files && heroImageInput.files[0]) {
        formData.append('hero_image', heroImageInput.files[0]);
    } else {
        formData.append('current_hero_image', currentYapHeroImagePath);
    }
    
    // Append resources image if selected
    const resourcesImageInput = document.getElementById('yapResourcesBackgroundImage');
    if (resourcesImageInput.files && resourcesImageInput.files[0]) {
        formData.append('resources_background_image', resourcesImageInput.files[0]);
    } else {
        formData.append('current_resources_image', currentYapResourcesImagePath);
    }
    
    // Show loading state
    const saveBtn = document.querySelector('.btn-save-yap');
    const originalText = saveBtn.innerHTML;
    saveBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Saving...';
    saveBtn.disabled = true;
    
    // Send to server
    fetch('handler/admin_yap_handler.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showNotification('YAP page settings saved successfully!', 'success');
            
            // Reload the page settings to show updated data
            setTimeout(() => {
                loadYapPageSettings();
            }, 1000);
        } else {
            showNotification(data.message || 'Error saving YAP page settings', 'error');
        }
    })
    .catch(error => {
        console.error('Error saving YAP page settings:', error);
        showNotification('Error saving YAP page settings', 'error');
    })
    .finally(() => {
        saveBtn.innerHTML = originalText;
        saveBtn.disabled = false;
    });
}

// Preview YAP page
function previewYapPage() {
    window.open('../src/yap.php', '_blank');
}

// Format date/time for display
function formatDateTime(dateTimeString) {
    const date = new Date(dateTimeString);
    const options = {
        year: 'numeric',
        month: 'short',
        day: 'numeric',
        hour: '2-digit',
        minute: '2-digit'
    };
    return date.toLocaleDateString('en-US', options);
}

// Show notification (using existing notification system)
function showNotification(message, type = 'info') {
    // Create notification toast
    const toast = document.createElement('div');
    toast.className = `notification-toast ${type}`;
    
    const icon = type === 'success' ? 'check-circle' : 
                 type === 'error' ? 'exclamation-circle' : 
                 type === 'warning' ? 'exclamation-triangle' : 'info-circle';
    
    toast.innerHTML = `
        <span class="notification-icon"><i class="fas fa-${icon}"></i></span>
        <span class="notification-message">${message}</span>
        <button class="notification-close" onclick="this.parentElement.remove()">
            <i class="fas fa-times"></i>
        </button>
    `;
    
    document.body.appendChild(toast);
    
    // Auto-remove after 5 seconds
    setTimeout(() => {
        toast.classList.add('fade-out');
        setTimeout(() => toast.remove(), 300);
    }, 5000);
}

// Initialize when page loads
document.addEventListener('DOMContentLoaded', function() {
    // Load YAP page settings if on YAP section
    if (document.getElementById('yapDescriptionContent')) {
        loadYapPageSettings();
    }
});
