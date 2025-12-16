// YAP Management JavaScript Functions

// Load and display YAP content preview
function loadYapContent() {
    fetch('handler/admin_yap_handler.php?action=get_yap_content')
        .then(response => response.json())
        .then(data => {
            if (data.success && data.data) {
                populateYapForm(data.data);
                updateYapPreview(data.data);
            } else {
                console.log('No YAP content found, creating default');
            }
        })
        .catch(error => {
            console.error('Error loading YAP content:', error);
            showNotification('Error loading YAP content', 'error');
        });
}

// Populate the YAP form with existing data
function populateYapForm(yapData) {
    document.getElementById('yapId').value = yapData.id || '';
    document.getElementById('yapHeroTitle').value = yapData.hero_title || '';
    document.getElementById('yapTestimonialAuthor').value = yapData.testimonial_author || '';
    document.getElementById('yapTestimonialLocation').value = yapData.testimonial_location || '';
    document.getElementById('yapResourcesTitle').value = yapData.resources_title || '';
    document.getElementById('yapResourcesDescription').value = yapData.resources_description || '';
    document.getElementById('yapResourcesButtonText').value = yapData.resources_button_text || '';
    document.getElementById('yapResourcesButtonLink').value = yapData.resources_button_link || '';
    
    // Populate rich text editors
    const descriptionEditor = document.getElementById('yapDescriptionEditor');
    const testimonialEditor = document.getElementById('yapTestimonialEditor');
    if (descriptionEditor) {
        descriptionEditor.innerHTML = yapData.description_text || '';
    }
    if (testimonialEditor) {
        testimonialEditor.innerHTML = yapData.testimonial_text || '';
    }
    
    // Update hidden textareas
    document.getElementById('yapDescriptionText').value = yapData.description_text || '';
    document.getElementById('yapTestimonialText').value = yapData.testimonial_text || '';
}

// Update YAP content preview in the main admin panel - REDESIGNED FOR NEW DASHBOARD
function updateYapPreview(yapData) {
    // Hero Title
    const heroTitleDisplay = document.getElementById('yapHeroTitleDisplay');
    if (heroTitleDisplay) {
        heroTitleDisplay.textContent = yapData.hero_title || 'Not Set';
        updateStatusBadge('heroStatus', yapData.hero_title);
    }

    // Hero Image
    const heroImagePreview = document.getElementById('yapHeroImagePreview');
    if (heroImagePreview && yapData.hero_image) {
        heroImagePreview.src = yapData.hero_image;
        heroImagePreview.style.display = 'block';
    }

    // Description
    const descriptionDisplay = document.getElementById('yapDescriptionDisplay');
    if (descriptionDisplay) {
        const desc = yapData.description_text || 'Not Set';
        descriptionDisplay.innerHTML = desc !== 'Not Set' 
            ? `<p>${desc}</p>` 
            : '<span style="color: #94a3b8; font-style: italic;">Not Set</span>';
        
        // Character count
        const charCount = document.getElementById('yapDescriptionCharCount');
        if (charCount) {
            const count = yapData.description_text ? yapData.description_text.length : 0;
            charCount.textContent = `${count} characters`;
        }
        
        updateStatusBadge('descriptionStatus', yapData.description_text);
    }

    // Testimonial
    const testimonialDisplay = document.getElementById('yapTestimonialDisplay');
    if (testimonialDisplay) {
        const testimonial = yapData.testimonial_text || 'Not Set';
        testimonialDisplay.innerHTML = testimonial !== 'Not Set' 
            ? `<p>"${testimonial}"</p>` 
            : '<span style="color: #94a3b8; font-style: italic;">Not Set</span>';
        
        updateStatusBadge('testimonialStatus', yapData.testimonial_text);
    }

    // Testimonial Author
    const authorDisplay = document.getElementById('yapTestimonialAuthorDisplay');
    if (authorDisplay) {
        authorDisplay.textContent = yapData.testimonial_author || 'Not Set';
    }

    // Testimonial Location
    const locationDisplay = document.getElementById('yapTestimonialLocationDisplay');
    if (locationDisplay) {
        locationDisplay.textContent = yapData.testimonial_location || 'Not Set';
    }

    // Resources Title
    const resourcesTitleDisplay = document.getElementById('yapResourcesTitleDisplay');
    if (resourcesTitleDisplay) {
        resourcesTitleDisplay.textContent = yapData.resources_title || 'Not Set';
        updateStatusBadge('resourcesStatus', yapData.resources_title);
    }

    // Resources Description
    const resourcesDescDisplay = document.getElementById('yapResourcesDescriptionDisplay');
    if (resourcesDescDisplay) {
        const resDesc = yapData.resources_description || 'Not Set';
        resourcesDescDisplay.innerHTML = resDesc !== 'Not Set' 
            ? `<p>${resDesc}</p>` 
            : '<span style="color: #94a3b8; font-style: italic;">Not Set</span>';
    }

    // Resources Button Text
    const buttonTextDisplay = document.getElementById('yapResourcesButtonTextDisplay');
    if (buttonTextDisplay) {
        buttonTextDisplay.textContent = yapData.resources_button_text || 'Not Set';
    }

    // Resources Button Link
    const buttonLinkDisplay = document.getElementById('yapResourcesButtonLinkDisplay');
    if (buttonLinkDisplay) {
        if (yapData.resources_button_link) {
            buttonLinkDisplay.href = yapData.resources_button_link;
            buttonLinkDisplay.textContent = yapData.resources_button_link;
        } else {
            buttonLinkDisplay.href = '#';
            buttonLinkDisplay.textContent = 'Not Set';
            buttonLinkDisplay.style.cursor = 'not-allowed';
        }
    }

    // Resources Image
    const resourcesImagePreview = document.getElementById('yapResourcesImagePreview');
    if (resourcesImagePreview && yapData.resources_bg_image) {
        resourcesImagePreview.src = yapData.resources_bg_image;
        resourcesImagePreview.style.display = 'block';
        updateStatusBadge('resourcesImageStatus', yapData.resources_bg_image);
    }

    // Last Updated
    const lastUpdate = document.getElementById('yapLastUpdate');
    if (lastUpdate && yapData.updated_at) {
        const date = new Date(yapData.updated_at);
        lastUpdate.textContent = date.toLocaleString();
    }
}

// Helper function to update status badges
function updateStatusBadge(elementId, value) {
    const badge = document.getElementById(elementId);
    if (badge) {
        if (value && value.trim() !== '') {
            badge.textContent = 'Set';
            badge.style.background = '#d1fae5';
            badge.style.color = '#059669';
        } else {
            badge.textContent = 'Not Set';
            badge.style.background = '#fee2e2';
            badge.style.color = '#dc2626';
        }
    }
}

// Sync rich text editor content to hidden textareas
function syncEditorContent() {
    const descriptionEditor = document.getElementById('yapDescriptionEditor');
    const descriptionTextarea = document.getElementById('yapDescriptionText');
    const testimonialEditor = document.getElementById('yapTestimonialEditor');
    const testimonialTextarea = document.getElementById('yapTestimonialText');
    
    if (descriptionEditor && descriptionTextarea) {
        descriptionTextarea.value = descriptionEditor.innerHTML;
    }
    
    if (testimonialEditor && testimonialTextarea) {
        testimonialTextarea.value = testimonialEditor.innerHTML;
    }
}

// Submit YAP content form
function submitYapContent() {
    // Sync editor content to hidden textareas before submission
    syncEditorContent();
    
    const form = document.getElementById('yapForm');
    if (!form.checkValidity()) {
        form.reportValidity();
        return;
    }
    
    const formData = new FormData(form);
    formData.append('action', 'update_yap_content');
    
    // Show loading state
    const submitBtn = document.getElementById('submitYapBtn');
    const originalText = submitBtn.textContent;
    submitBtn.textContent = 'Saving...';
    submitBtn.disabled = true;
    
    fetch('handler/admin_yap_handler.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showNotification(data.message, 'success');
            closeYapModal();
            loadYapPreview(); // Reload the preview
        } else {
            showNotification(data.message || 'Error saving YAP content', 'error');
        }
    })
    .catch(error => {
        console.error('Error saving YAP content:', error);
        showNotification('Error saving YAP content', 'error');
    })
    .finally(() => {
        // Reset button state
        submitBtn.textContent = originalText;
        submitBtn.disabled = false;
    });
}

// Load YAP preview (called from main admin panel)
function loadYapPreview() {
    fetch('handler/admin_yap_handler.php?action=get_yap_content')
        .then(response => response.json())
        .then(data => {
            if (data.success && data.data) {
                updateYapPreview(data.data);
            } else {
                resetYapDashboard();
            }
        })
        .catch(error => {
            console.error('Error loading YAP preview:', error);
            resetYapDashboard(true);
        });
}

// Reset YAP dashboard to empty state
function resetYapDashboard(isError = false) {
    // Reset all display elements
    document.getElementById('yapHeroTitleDisplay').textContent = 'Not Set';
    document.getElementById('yapHeroImagePreview').src = 'data:image/svg+xml,%3Csvg xmlns="http://www.w3.org/2000/svg" width="200" height="150"%3E%3Crect fill="%23e2e8f0" width="200" height="150"/%3E%3Ctext x="50%25" y="50%25" font-size="14" fill="%2364748b" text-anchor="middle" dominant-baseline="middle"%3ENo Image%3C/text%3E%3C/svg%3E';
    document.getElementById('yapDescriptionDisplay').innerHTML = '<span style="color: #94a3b8; font-style: italic;">Not Set</span>';
    document.getElementById('yapDescriptionCharCount').textContent = '0 characters';
    document.getElementById('yapTestimonialDisplay').innerHTML = '<span style="color: #94a3b8; font-style: italic;">Not Set</span>';
    document.getElementById('yapTestimonialAuthorDisplay').textContent = 'Not Set';
    document.getElementById('yapTestimonialLocationDisplay').textContent = 'Not Set';
    document.getElementById('yapResourcesTitleDisplay').textContent = 'Not Set';
    document.getElementById('yapResourcesDescriptionDisplay').innerHTML = '<span style="color: #94a3b8; font-style: italic;">Not Set</span>';
    document.getElementById('yapResourcesButtonTextDisplay').textContent = 'Not Set';
    document.getElementById('yapResourcesButtonLinkDisplay').textContent = 'Not Set';
    document.getElementById('yapResourcesButtonLinkDisplay').href = '#';
    document.getElementById('yapResourcesImagePreview').src = 'data:image/svg+xml,%3Csvg xmlns="http://www.w3.org/2000/svg" width="200" height="150"%3E%3Crect fill="%23e2e8f0" width="200" height="150"/%3E%3Ctext x="50%25" y="50%25" font-size="14" fill="%2364748b" text-anchor="middle" dominant-baseline="middle"%3ENo Image%3C/text%3E%3C/svg%3E';
    
    // Reset all status badges
    document.querySelectorAll('.yap-card-status').forEach(badge => {
        badge.textContent = 'Not Set';
        badge.style.background = '#fee2e2';
        badge.style.color = '#dc2626';
    });

    // Update last update time
    document.getElementById('yapLastUpdate').textContent = isError ? 'Error loading' : 'Never';
}

// Remove YAP hero image
function removeYapHeroImage() {
    const yapId = document.getElementById('yapId').value;
    if (!yapId) {
        showNotification('Please save the content first before removing images', 'warning');
        return;
    }
    
    if (!confirm('Are you sure you want to remove the hero image? This will reset it to the default image.')) {
        return;
    }
    
    const formData = new FormData();
    formData.append('action', 'delete_hero_image');
    formData.append('id', yapId);
    
    fetch('handler/admin_yap_handler.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showNotification(data.message, 'success');
            // Reset image preview and input
            document.getElementById('yapHeroImage').value = '';
            document.getElementById('yapHeroImageStatus').textContent = 'No file selected';
            document.getElementById('yapHeroImagePreview').style.display = 'none';
            document.getElementById('deleteYapHeroImageBtn').style.display = 'none';
        } else {
            showNotification(data.message || 'Error removing hero image', 'error');
        }
    })
    .catch(error => {
        console.error('Error removing hero image:', error);
        showNotification('Error removing hero image', 'error');
    });
}

// Remove YAP resources background image
function removeYapResourcesImage() {
    const yapId = document.getElementById('yapId').value;
    if (!yapId) {
        showNotification('Please save the content first before removing images', 'warning');
        return;
    }
    
    if (!confirm('Are you sure you want to remove the resources background image? This will reset it to the default image.')) {
        return;
    }
    
    const formData = new FormData();
    formData.append('action', 'delete_resources_bg_image');
    formData.append('id', yapId);
    
    fetch('handler/admin_yap_handler.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showNotification(data.message, 'success');
            // Reset image preview and input
            document.getElementById('yapResourcesBackgroundImage').value = '';
            document.getElementById('yapResourcesImageStatus').textContent = 'No file selected';
            document.getElementById('yapResourcesImagePreview').style.display = 'none';
            document.getElementById('deleteYapResourcesImageBtn').style.display = 'none';
        } else {
            showNotification(data.message || 'Error removing resources image', 'error');
        }
    })
    .catch(error => {
        console.error('Error removing resources image:', error);
        showNotification('Error removing resources image', 'error');
    });
}

// Handle hero image file selection
function handleYapHeroImageSelect(input) {
    const file = input.files[0];
    const preview = document.getElementById('yapHeroImagePreview');
    const status = document.getElementById('yapHeroImageStatus');
    const deleteBtn = document.getElementById('deleteYapHeroImageBtn');
    const previewImg = preview.querySelector('img');
    
    if (file) {
        // Validate file type
        if (!file.type.startsWith('image/')) {
            showNotification('Please select a valid image file', 'error');
            input.value = '';
            return;
        }
        
        // Validate file size (max 5MB)
        if (file.size > 5 * 1024 * 1024) {
            showNotification('File size must be less than 5MB', 'error');
            input.value = '';
            return;
        }
        
        status.textContent = file.name;
        deleteBtn.style.display = 'inline-block';
        
        const reader = new FileReader();
        reader.onload = function(e) {
            previewImg.src = e.target.result;
            preview.style.display = 'block';
        };
        reader.readAsDataURL(file);
    } else {
        status.textContent = 'No file selected';
        deleteBtn.style.display = 'none';
        preview.style.display = 'none';
    }
}

// Handle resources image file selection  
function handleYapResourcesImageSelect(input) {
    const file = input.files[0];
    const preview = document.getElementById('yapResourcesImagePreview');
    const status = document.getElementById('yapResourcesImageStatus');
    const deleteBtn = document.getElementById('deleteYapResourcesImageBtn');
    const previewImg = preview.querySelector('img');
    
    if (file) {
        // Validate file type
        if (!file.type.startsWith('image/')) {
            showNotification('Please select a valid image file', 'error');
            input.value = '';
            return;
        }
        
        // Validate file size (max 5MB)
        if (file.size > 5 * 1024 * 1024) {
            showNotification('File size must be less than 5MB', 'error');
            input.value = '';
            return;
        }
        
        status.textContent = file.name;
        deleteBtn.style.display = 'inline-block';
        
        const reader = new FileReader();
        reader.onload = function(e) {
            previewImg.src = e.target.result;
            preview.style.display = 'block';
        };
        reader.readAsDataURL(file);
    } else {
        status.textContent = 'No file selected';
        deleteBtn.style.display = 'none';
        preview.style.display = 'none';
    }
}

// Clear hero image selection
function clearYapHeroImage() {
    const input = document.getElementById('yapHeroImage');
    const preview = document.getElementById('yapHeroImagePreview');
    const status = document.getElementById('yapHeroImageStatus');
    const deleteBtn = document.getElementById('deleteYapHeroImageBtn');
    
    input.value = '';
    status.textContent = 'No file selected';
    deleteBtn.style.display = 'none';
    preview.style.display = 'none';
}

// Clear resources image selection
function clearYapResourcesImage() {
    const input = document.getElementById('yapResourcesBackgroundImage');
    const preview = document.getElementById('yapResourcesImagePreview');
    const status = document.getElementById('yapResourcesImageStatus');
    const deleteBtn = document.getElementById('deleteYapResourcesImageBtn');
    
    input.value = '';
    status.textContent = 'No file selected';
    deleteBtn.style.display = 'none';
    preview.style.display = 'none';
}

// Rich Text Editor Functions for Description
function formatText(command) {
    document.execCommand(command, false, null);
    document.getElementById('yapDescriptionEditor').focus();
    syncEditorContent();
}

function createLink() {
    const url = prompt('Enter the URL:');
    if (url) {
        const selection = window.getSelection();
        if (selection.rangeCount > 0) {
            const range = selection.getRangeAt(0);
            const selectedText = range.toString();
            
            if (selectedText) {
                document.execCommand('createLink', false, url);
            } else {
                const linkText = prompt('Enter link text:');
                if (linkText) {
                    const link = document.createElement('a');
                    link.href = url;
                    link.textContent = linkText;
                    link.target = '_blank';
                    link.style.color = '#3b82f6';
                    link.style.textDecoration = 'underline';
                    range.insertNode(link);
                }
            }
        }
    }
    document.getElementById('yapDescriptionEditor').focus();
    syncEditorContent();
}

function removeLink() {
    document.execCommand('unlink', false, null);
    document.getElementById('yapDescriptionEditor').focus();
    syncEditorContent();
}

function changeTextColor(color) {
    document.execCommand('foreColor', false, color);
    document.getElementById('yapDescriptionEditor').focus();
    syncEditorContent();
}

function removeFormat() {
    document.execCommand('removeFormat', false, null);
    document.getElementById('yapDescriptionEditor').focus();
    syncEditorContent();
}

// Rich Text Editor Functions for Testimonial
function formatTestimonialText(command) {
    document.execCommand(command, false, null);
    document.getElementById('yapTestimonialEditor').focus();
    syncEditorContent();
}

function changeTestimonialTextColor(color) {
    document.execCommand('foreColor', false, color);
    document.getElementById('yapTestimonialEditor').focus();
    syncEditorContent();
}

function removeTestimonialFormat() {
    document.execCommand('removeFormat', false, null);
    document.getElementById('yapTestimonialEditor').focus();
    syncEditorContent();
}

// Initialize rich text editors with event listeners
function initializeRichTextEditors() {
    const descriptionEditor = document.getElementById('yapDescriptionEditor');
    if (descriptionEditor) {
        descriptionEditor.addEventListener('input', syncEditorContent);
        descriptionEditor.addEventListener('paste', function() {
            setTimeout(syncEditorContent, 10);
        });
        descriptionEditor.addEventListener('keyup', syncEditorContent);
    }
    
    const testimonialEditor = document.getElementById('yapTestimonialEditor');
    if (testimonialEditor) {
        testimonialEditor.addEventListener('input', syncEditorContent);
        testimonialEditor.addEventListener('paste', function() {
            setTimeout(syncEditorContent, 10);
        });
        testimonialEditor.addEventListener('keyup', syncEditorContent);
    }
}