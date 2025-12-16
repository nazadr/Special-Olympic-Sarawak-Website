// Photo Management functionality
console.log('Photo management script started loading...');

// Client-side image compression function
async function compressImages(files) {
    const compressedFiles = [];
    const maxWidth = 1920;
    const maxHeight = 1080;
    const quality = 0.8;
    const maxFileSize = 10 * 1024 * 1024; // 10MB per file
    
    for (let file of files) {
        try {
            // Skip if file is already small enough
            if (file.size <= maxFileSize) {
                compressedFiles.push(file);
                console.log(`File ${file.name} is already small enough (${(file.size/1024/1024).toFixed(1)}MB), keeping original`);
                continue;
            }
            
            console.log(`Compressing ${file.name} (${(file.size/1024/1024).toFixed(1)}MB)...`);
            
            const compressed = await new Promise((resolve, reject) => {
                const canvas = document.createElement('canvas');
                const ctx = canvas.getContext('2d');
                const img = new Image();
                
                img.onload = function() {
                    // Calculate new dimensions while maintaining aspect ratio
                    let { width, height } = img;
                    if (width > maxWidth || height > maxHeight) {
                        if (width > height) {
                            height = (height * maxWidth) / width;
                            width = maxWidth;
                        } else {
                            width = (width * maxHeight) / height;
                            height = maxHeight;
                        }
                    }
                    
                    canvas.width = width;
                    canvas.height = height;
                    
                    // Draw and compress
                    ctx.drawImage(img, 0, 0, width, height);
                    canvas.toBlob(resolve, 'image/jpeg', quality);
                };
                
                img.onerror = reject;
                img.src = URL.createObjectURL(file);
            });
            
            // Create new file with original name but compressed content
            const compressedFile = new File([compressed], file.name, {
                type: 'image/jpeg',
                lastModified: Date.now()
            });
            
            console.log(`Compressed ${file.name}: ${(file.size/1024/1024).toFixed(1)}MB → ${(compressedFile.size/1024/1024).toFixed(1)}MB`);
            compressedFiles.push(compressedFile);
            
        } catch (error) {
            console.error(`Error compressing ${file.name}:`, error);
            // If compression fails, use original file
            compressedFiles.push(file);
        }
    }
    
    return compressedFiles;
}

// Immediately define test function at global scope
window.testSortable = function() {
    console.log('=== TESTING SORTABLE ===');
    const container = document.getElementById('publishedGalleryPhoto');
    console.log('Container found:', !!container);
    console.log('SortableJS available:', typeof Sortable !== 'undefined');
    console.log('Container children:', container ? container.children.length : 0);
    
    if (container && typeof Sortable !== 'undefined') {
        try {
            const sortable = Sortable.create(container, {
                animation: 150,
                onStart: () => console.log('DRAG STARTED'),
                onEnd: () => console.log('DRAG ENDED')
            });
            console.log('Test sortable created successfully:', sortable);
        } catch (error) {
            console.error('Error creating sortable:', error);
        }
    }
};

console.log('testSortable function defined:', typeof window.testSortable);

// Load collections + photos into the Published Photos section
function loadPublishedPhotos() {
    const container = document.getElementById('publishedGalleryPhoto');
    if (!container) return;

    container.innerHTML = '<p style="text-align: center; color: #64748b; padding: 24px 0;">Loading photo collections...</p>';

    fetch('./handler/admin_gallery_photo_handler.php?action=fetch_collections')
        .then(r => r.json())
        .then(d => {
            if (!d.success || !d.collections || d.collections.length === 0) {
                container.innerHTML = '<p style="text-align: center; color: #64748b; padding: 24px 0;">No photo collections found.</p>';
                return;
            }

            const tasks = d.collections.map(col => {
                return fetch(`../admin/handler/admin_gallery_photo_handler.php?action=fetch_items&collection_id=${col.id}`)
                    .then(r => r.json())
                    .then(items => {
                        const wrap = document.createElement('div');
                        wrap.className = 'gallery-admin-category';
                        wrap.dataset.collectionId = col.id;

                        const photos = (items.success && items.photos) ? items.photos : [];

                        wrap.innerHTML = `
                            <div class="gallery-admin-info" title="Drag to reorder gallery collections">
                                <div class="desc">
                                    <h3>${col.name}</h3>
                                    <p>${col.description || ''}</p>
                                </div>
                                <div class="gallery-admin-action">
                                    <button type="button" class="edit-btn" data-id="${col.id}"><i class="fa-solid fa-pencil"></i></button>
                                    <button type="button" class="delete-btn" data-id="${col.id}"><i class="fa-solid fa-trash"></i></button>
                                </div>
                            </div>
                            <div class="gallery-admin-grid">
                                ${photos.map(p => `
                                    <div class="gallery-admin-card photos" data-photo-id="${p.id}" data-src="${p.image_path ? (p.image_path.startsWith('../') ? p.image_path : '../' + p.image_path) : ''}" title="Drag to reorder photos">
                                        <img src="${p.image_path ? (p.image_path.startsWith('../') ? p.image_path : '../' + p.image_path) : 'https://via.placeholder.com/150'}" alt="Gallery Photo">
                                    </div>
                                `).join('')}
                            </div>
                        `;
                        return wrap;
                    });
            });

            Promise.all(tasks).then(results => {
                container.innerHTML = '';
                results.forEach(wrap => {
                    if (wrap) container.appendChild(wrap);
                });
                
                // Initialize sortable functionality after galleries are loaded
                setTimeout(() => {
                    initializeGallerySortable();
                    initializePhotoCardsSortable();
                }, 100);
            });
        })
        .catch(err => {
            console.error('Error loading published photos:', err);
            container.innerHTML = '<p style="text-align: center; color: #ef4444; padding: 24px 0;">Failed to load photo collections.</p>';
        });
}

/* ========== Delete Single Photo (No Confirmation) ========== */
function deletePhoto(photoId) {
    if (!photoId) {
        alert('Invalid photo ID.');
        return;
    }

    const fd = new FormData();
    fd.append('action', 'delete_photo');
    fd.append('id', photoId);

    fetch('./handler/admin_gallery_photo_handler.php', { method: 'POST', body: fd })
        .then(r => r.json())
        .then(d => {
            if (d.success) {
                alert('Photo deleted successfully!');
                // Remove card from DOM
                const card = document.querySelector(`.gallery-admin-card.photos[data-photo-id="${photoId}"]`);
                if (card) card.remove();
                // Close modal
                const photoModal = document.getElementById('galphoto-modal');
                if (photoModal) photoModal.style.display = 'none';
                // Reload published photos
                loadPublishedPhotos();
            } else {
                alert('Error deleting photo: ' + (d.message || 'Unknown error'));
            }
        })
        .catch(err => {
            console.error('Delete photo error:', err);
            alert('Failed to delete photo.');
        });
}

/* ========== Delegated UI Handlers ========== */
function setupPhotoDelegatedHandlers() {
    const publishedContainer = document.getElementById('publishedGalleryPhoto');
    if (!publishedContainer) return;

    const photoModal = document.getElementById('galphoto-modal');
    const photoModalClose = document.getElementById('galphoto-modal-close');
    const photoModalImage = document.getElementById('galphoto-modal-image');
    const photoModalFilename = document.getElementById('galphoto-modal-filename');

    let activePhotoId = null;

    // Delegated clicks inside Published Photos container
    publishedContainer.addEventListener('click', (e) => {
        // Open photo modal on card click
        const card = e.target.closest('.gallery-admin-card.photos');
        if (card && publishedContainer.contains(card)) {
            activePhotoId = card.dataset.photoId || null;
            const src = card.dataset.src || (card.querySelector('img')?.src || '');
            if (photoModal && photoModalImage && photoModalFilename) {
                photoModalImage.src = src;
                photoModalImage.alt = 'Image Preview';
                photoModalFilename.textContent = src.split('/').pop();
                photoModal.dataset.photoId = activePhotoId; // Store ID on modal
                photoModal.style.display = 'flex';
            }
            return;
        }

        // Open Edit Collection modal
        const editBtn = e.target.closest('.gallery-admin-action .edit-btn');
        if (editBtn && publishedContainer.contains(editBtn)) {
            const id = editBtn.getAttribute('data-id');
            if (id) openCollectionEditModal(id);
            return;
        }

        // Open Delete Collection modal
        const deleteBtn = e.target.closest('.gallery-admin-action .delete-btn');
        if (deleteBtn && publishedContainer.contains(deleteBtn)) {
            const id = deleteBtn.getAttribute('data-id');
            if (id) openCollectionDeleteModal(id);
            return;
        }
    });

    // Photo modal close
    if (photoModal && photoModalClose) {
        photoModalClose.onclick = () => photoModal.style.display = 'none';
        photoModal.onclick = (e) => { if (e.target === photoModal) photoModal.style.display = 'none'; };
    }

    // Photo modal -> delete single photo (NO CONFIRMATION) - USE DELEGATED EVENT
    if (photoModal) {
        photoModal.addEventListener('click', (e) => {
            // Check if the clicked element is the delete button
            if (e.target.id === 'deleteGalleryPhotoBtn' || e.target.closest('#deleteGalleryPhotoBtn')) {
                const photoId = photoModal.dataset.photoId || activePhotoId;
                if (!photoId) {
                    alert('Photo ID missing.');
                    return;
                }
                deletePhoto(photoId);
            }
        });
    }
}

/* ========== Edit Collection Modal ========== */
function openCollectionEditModal(collectionId) {
    const modal = document.getElementById('galphoto-modal-album');
    if (!modal) return;

    fetch('./handler/admin_gallery_photo_handler.php?action=fetch_collections')
        .then(r => r.json())
        .then(d => {
            if (!d.success) return;
            const col = d.collections.find(c => String(c.id) === String(collectionId));
            if (!col) return;

            const nameInput = modal.querySelector('#galleryPhotoAlbum');
            const descInput = modal.querySelector('#galleryPhotoAlbumDesc');
            if (nameInput) nameInput.value = col.name || '';
            if (descInput) descInput.value = col.description || '';

            modal.dataset.collectionId = String(collectionId);
            modal.style.display = 'flex';
        });
}

function setupEditCollectionModalHandlers() {
    const modal = document.getElementById('galphoto-modal-album');
    if (!modal) return;

    const cancelBtn = document.getElementById('galphoto-modal-album-close');
    const saveBtn = document.getElementById('saveGalleryPhotoAlbumEdit');

    if (cancelBtn) {
        cancelBtn.type = 'button';
        cancelBtn.addEventListener('click', () => {
            modal.style.display = 'none';
            modal.dataset.collectionId = '';
            const nameInput = modal.querySelector('#galleryPhotoAlbum');
            const descInput = modal.querySelector('#galleryPhotoAlbumDesc');
            if (nameInput) nameInput.value = '';
            if (descInput) descInput.value = '';
        });
    }

    if (saveBtn) {
        saveBtn.type = 'button';
        saveBtn.addEventListener('click', () => {
            const id = modal.dataset.collectionId;
            const nameInput = modal.querySelector('#galleryPhotoAlbum');
            const descInput = modal.querySelector('#galleryPhotoAlbumDesc');
            if (!id || !nameInput) return;

            const fd = new FormData();
            fd.append('action', 'update_collection');
            fd.append('id', id);
            fd.append('name', nameInput.value.trim());
            fd.append('description', (descInput?.value || '').trim());

            fetch('./handler/admin_gallery_photo_handler.php', { method: 'POST', body: fd })
                .then(r => r.json())
                .then(d => {
                    alert(d.message || (d.success ? 'Updated' : 'Failed'));
                    if (d.success) {
                        modal.style.display = 'none';
                        modal.dataset.collectionId = '';
                        loadPublishedPhotos();
                        populatePhotoCollections();
                    }
                });
        });
    }
}

/* ========== Delete Collection Modal ========== */
function openCollectionDeleteModal(collectionId) {
    const modal = document.getElementById('gallery-modal-delete-album');
    const cancelBtn = document.getElementById('gallery-modal-album-close');
    const deleteBtn = document.getElementById('deleteGalleryAlbum');
    if (!modal || !deleteBtn) return;

    modal.style.display = 'flex';
    deleteBtn.disabled = true;

    const msgP = modal.querySelector('.gmac-desc p:nth-of-type(2)');
    let countdown = 5;
    if (msgP) msgP.textContent = `The delete button will be available in ${countdown} second(s).`;

    const interval = setInterval(() => {
        countdown--;
        if (msgP) {
            msgP.textContent = countdown > 0
                ? `The delete button will be available in ${countdown} second(s).`
                : 'The delete button is now available.';
        }
        if (countdown <= 0) {
            deleteBtn.disabled = false;
            clearInterval(interval);
        }
    }, 1000);

    if (cancelBtn) {
        cancelBtn.type = 'button';
        const onCancel = () => {
            modal.style.display = 'none';
            clearInterval(interval);
            cancelBtn.removeEventListener('click', onCancel);
        };
        cancelBtn.addEventListener('click', onCancel);
    }

    const onDelete = () => {
        if (deleteBtn.disabled) return;
        if (!confirm('Delete this collection (all photos)?')) return;

        const fd = new FormData();
        fd.append('action', 'delete_collection');
        fd.append('id', collectionId);

        fetch('./handler/admin_gallery_photo_handler.php', { method: 'POST', body: fd })
            .then(r => r.json())
            .then(d => {
                alert(d.message || (d.success ? 'Deleted' : 'Failed'));
                if (d.success) {
                    modal.style.display = 'none';
                    loadPublishedPhotos();
                    populatePhotoCollections();
                }
            });
    };
    deleteBtn.onclick = onDelete;

    modal.addEventListener('click', function onBackdrop(e) {
        if (e.target === modal) {
            modal.style.display = 'none';
            clearInterval(interval);
            modal.removeEventListener('click', onBackdrop);
        }
    });
}

/* ========== Populate Select for Upload Form ========== */
function populatePhotoCollections() {
    const albumSelect = document.getElementById('galleryPhotoAlbum');
    if (!albumSelect) return;

    fetch('../admin/handler/admin_gallery_photo_handler.php?action=fetch_collections')
        .then(r => r.json())
        .then(d => {
            if (!d.success) {
                albumSelect.innerHTML = '<option value="">Error loading collections</option>';
                return;
            }
            albumSelect.innerHTML = '<option value="">Select Collection</option>';
            d.collections.forEach(col => {
                const opt = document.createElement('option');
                opt.value = col.name;
                opt.textContent = col.name;
                albumSelect.appendChild(opt);
            });
        })
        .catch(error => {
            console.error('Error fetching collections:', error);
            albumSelect.innerHTML = '<option value="">Error loading collections</option>';
        });
}

/* ========== Upload Form Enhancements ========== */
function setupPhotoUploadForm() {
    const form = document.getElementById('galleryPhoto');
    const imgInput = document.getElementById('galleryPhotoImage');
    const preview = document.getElementById('galleryPhotoImagePreview');
    const statusSpan = document.getElementById('galleryPhotoImageStatus');
    const delBtn = document.getElementById('deleteGalleryPhotoImageBtn');

    if (imgInput && delBtn && statusSpan && preview) {
        delBtn.style.display = 'none';
        imgInput.addEventListener('change', () => {
            if (imgInput.files && imgInput.files.length > 0) {
                const files = Array.from(imgInput.files);
                const totalSize = files.reduce((sum, file) => sum + file.size, 0);
                const totalSizeMB = (totalSize / (1024 * 1024)).toFixed(1);
                
                if (files.length === 1) {
                    // Single file - show preview and details
                    const file = files[0];
                    const fileSize = (file.size / (1024 * 1024)).toFixed(1);
                    statusSpan.innerHTML = `${file.name} (${fileSize} MB)<br><small style="color: #666;">⚡ Will be compressed and optimized automatically</small>`;
                    
                    if (file.size > 10 * 1024 * 1024) { // 10MB
                        statusSpan.innerHTML += `<br><small style="color: #ff6b7f;">⚠️ Large file - compression will significantly reduce size</small>`;
                    }
                    
                    const fr = new FileReader();
                    fr.onload = e => {
                        preview.src = e.target.result;
                        preview.style.display = 'block';
                    };
                    fr.readAsDataURL(file);
                } else {
                    // Multiple files - show count and total size
                    statusSpan.innerHTML = `${files.length} images selected (${totalSizeMB} MB total)<br><small style="color: #666;">⚡ All images will be compressed and optimized automatically</small>`;
                    
                    if (totalSize > 50 * 1024 * 1024) { // 50MB total
                        statusSpan.innerHTML += `<br><small style="color: #ff6b7f;">⚠️ Large batch - compression will significantly reduce total size</small>`;
                    }
                    
                    // Show preview of first image
                    const fr = new FileReader();
                    fr.onload = e => {
                        preview.src = e.target.result;
                        preview.style.display = 'block';
                    };
                    fr.readAsDataURL(files[0]);
                }
                
                delBtn.style.display = 'inline-block';
            } else {
                statusSpan.textContent = 'No files selected.';
                preview.src = '';
                preview.style.display = 'none';
                delBtn.style.display = 'none';
            }
        });
        delBtn.addEventListener('click', () => {
            imgInput.value = '';
            statusSpan.textContent = 'No files selected.';
            preview.src = '';
            preview.style.display = 'none';
            delBtn.style.display = 'none';
        });
    }

    if (form) {
        form.addEventListener('submit', async e => {
            e.preventDefault();
            
            // Show upload progress
            const submitBtn = form.querySelector('button[type="submit"]');
            const originalText = submitBtn.textContent;
            submitBtn.disabled = true;
            submitBtn.textContent = 'Compressing images...';
            
            try {
                const fd = new FormData(form);
                fd.append('action', 'add_photo');
                
                // Compress images before upload if they exist
                const fileInput = form.querySelector('input[name="galleryPhotoImage[]"]');
                if (fileInput && fileInput.files.length > 0) {
                    submitBtn.textContent = 'Compressing images...';
                    const compressedFiles = await compressImages(fileInput.files);
                    
                    // Replace original files with compressed ones
                    fd.delete('galleryPhotoImage[]');
                    for (let i = 0; i < compressedFiles.length; i++) {
                        fd.append('galleryPhotoImage[]', compressedFiles[i]);
                    }
                    submitBtn.textContent = 'Uploading compressed images...';
                }

            fetch('./handler/admin_gallery_photo_handler.php', { method: 'POST', body: fd })
                .then(r => {
                    if (!r.ok) {
                        throw new Error(`HTTP ${r.status}: ${r.statusText}`);
                    }
                    return r.text();
                })
                .then(text => {
                    // Debug log raw response
                    console.log('Raw response:', text);
                    try {
                        const d = JSON.parse(text);
                        
                        // Show detailed message for multiple uploads
                        if (d.uploaded_count && d.total_files) {
                            let alertMsg = `Uploaded ${d.uploaded_count} of ${d.total_files} images`;
                            if (d.message) alertMsg += `\n\nDetails: ${d.message}`;
                            alert(alertMsg);
                        } else {
                            alert(d.message || (d.success ? 'Upload completed' : 'Upload failed'));
                        }
                        
                        if (d.success) {
                            form.reset();
                            statusSpan.textContent = 'No files selected.';
                            preview.src = '';
                            preview.style.display = 'none';
                            delBtn.style.display = 'none';
                            loadPublishedPhotos();
                            populatePhotoCollections();
                        }
                    } catch (e) {
                        console.error('JSON parse error:', e);
                        console.error('Response text:', text);
                        throw new Error('Invalid response from server: ' + text.substring(0, 200));
                    }
                })
                .catch(error => {
                    console.error('Upload error:', error);
                    alert('Upload failed: ' + error.message);
                })
                .finally(() => {
                    // Reset button state
                    submitBtn.disabled = false;
                    submitBtn.textContent = originalText;
                });
            } catch (error) {
                console.error('Async upload error:', error);
                alert('Upload failed: ' + error.message);
                // Reset button state
                submitBtn.disabled = false;
                submitBtn.textContent = originalText;
            }
        });
    }
}

/* ========== Sortable Gallery Categories ========== */
window.initializeGallerySortable = function initializeGallerySortable() {
    const container = document.getElementById('publishedGalleryPhoto');
    if (!container) {
        console.error('Container publishedGalleryPhoto not found');
        return;
    }

    // Check if SortableJS is available
    if (typeof Sortable === 'undefined') {
        console.warn('SortableJS library not loaded. Gallery reordering will not be available.');
        return;
    }

    console.log('Initializing gallery sortable for container:', container);
    console.log('Gallery children count:', container.children.length);

    // Initialize sortable for the gallery categories
    try {
        const sortable = Sortable.create(container, {
            animation: 150,
            ghostClass: 'gallery-sortable-ghost',
            chosenClass: 'gallery-sortable-chosen',
            dragClass: 'gallery-sortable-drag',
            // Temporarily remove handle to test if it works without restriction
            // handle: '.gallery-admin-info', 
            onStart: function(evt) {
                console.log('Gallery drag started:', evt);
            },
            onMove: function(evt) {
                console.log('Gallery drag moving:', evt);
            },
            onEnd: function(evt) {
                console.log('Gallery drag ended:', evt);
                // Get the new order of collection IDs
                const newOrder = Array.from(container.children).map((item, index) => ({
                    collection_id: item.dataset.collectionId,
                    sort_order: index + 1
                }));
                
                console.log('New gallery order:', newOrder);
                // Save the new order to the backend
                saveGalleryOrder(newOrder);
            }
        });
        
        console.log('Gallery sortable created successfully:', sortable);
    } catch (error) {
        console.error('Failed to create gallery sortable:', error);
    }
    
    console.log('Gallery sortable initialized:', sortable);
}

console.log('initializeGallerySortable function defined:', typeof window.initializeGallerySortable);

function saveGalleryOrder(orderData) {
    const formData = new FormData();
    formData.append('action', 'update_gallery_order');
    formData.append('order_data', JSON.stringify(orderData));

    fetch('./handler/admin_gallery_photo_handler.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            console.log('Gallery order updated successfully');
            // Optional: Show success notification
            showNotification('Gallery order updated successfully', 'success');
        } else {
            console.error('Failed to update gallery order:', data.message);
            showNotification('Failed to update gallery order: ' + (data.message || 'Unknown error'), 'error');
            // Reload the galleries to restore original order
            loadPublishedPhotos();
        }
    })
    .catch(error => {
        console.error('Error updating gallery order:', error);
        showNotification('Error updating gallery order', 'error');
        // Reload the galleries to restore original order
        loadPublishedPhotos();
    });
}

function showNotification(message, type = 'info') {
    // Create or update notification element
    let notification = document.getElementById('gallery-notification');
    if (!notification) {
        notification = document.createElement('div');
        notification.id = 'gallery-notification';
        notification.style.cssText = `
            position: fixed;
            top: 20px;
            right: 20px;
            padding: 12px 20px;
            border-radius: 6px;
            color: white;
            font-weight: 500;
            z-index: 10000;
            font-family: 'Inter', sans-serif;
            font-size: 14px;
            max-width: 300px;
            opacity: 0;
            transform: translateX(100%);
            transition: all 0.3s ease;
        `;
        document.body.appendChild(notification);
    }

    // Set background color based on type
    const colors = {
        success: '#10b981',
        error: '#ef4444',
        info: '#3b82f6'
    };
    notification.style.backgroundColor = colors[type] || colors.info;
    notification.textContent = message;

    // Show notification
    setTimeout(() => {
        notification.style.opacity = '1';
        notification.style.transform = 'translateX(0)';
    }, 10);

    // Hide notification after 3 seconds
    setTimeout(() => {
        notification.style.opacity = '0';
        notification.style.transform = 'translateX(100%)';
    }, 3000);
}

/* ========== Sortable Photo Cards ========== */
window.initializePhotoCardsSortable = function initializePhotoCardsSortable() {
    const galleryGrids = document.querySelectorAll('.gallery-admin-grid');
    console.log('Found gallery grids for photo sorting:', galleryGrids.length);
    
    galleryGrids.forEach((grid, index) => {
        const categoryContainer = grid.closest('.gallery-admin-category');
        if (!categoryContainer) {
            console.warn(`Grid ${index}: No category container found`);
            return;
        }
        
        const collectionId = categoryContainer.dataset.collectionId;
        if (!collectionId) {
            console.warn(`Grid ${index}: No collection ID found`);
            return;
        }

        // Check if SortableJS is available
        if (typeof Sortable === 'undefined') {
            console.warn('SortableJS library not loaded. Photo card reordering will not be available.');
            return;
        }

        console.log(`Initializing photo cards sortable for collection ${collectionId}`);

        // Initialize sortable for photo cards in this grid
        try {
            const sortable = Sortable.create(grid, {
                animation: 150,
                ghostClass: 'photo-card-sortable-ghost',
                chosenClass: 'photo-card-sortable-chosen',
                dragClass: 'photo-card-sortable-drag',
                onStart: function(evt) {
                    console.log(`Photo drag started in collection ${collectionId}:`, evt);
                },
                onMove: function(evt) {
                    console.log(`Photo drag moving in collection ${collectionId}:`, evt);
                },
                onEnd: function(evt) {
                    console.log(`Photo drag ended in collection ${collectionId}:`, evt);
                    // Get the new order of photo IDs
                    const newOrder = Array.from(grid.children).map((card, index) => ({
                        photo_id: card.dataset.photoId,
                        sort_order: index + 1
                    }));
                    
                    console.log('New photo order:', newOrder);
                    // Save the new order to the backend
                    savePhotoOrder(collectionId, newOrder);
                }
            });
            
            console.log(`Photo sortable created successfully for collection ${collectionId}:`, sortable);
        } catch (error) {
            console.error(`Failed to create photo sortable for collection ${collectionId}:`, error);
        }
        
        console.log(`Photo sortable initialized for collection ${collectionId}:`, sortable);
    });
}

console.log('initializePhotoCardsSortable function defined:', typeof window.initializePhotoCardsSortable);

function savePhotoOrder(collectionId, orderData) {
    const formData = new FormData();
    formData.append('action', 'update_photo_order');
    formData.append('collection_id', collectionId);
    formData.append('order_data', JSON.stringify(orderData));

    fetch('./handler/admin_gallery_photo_handler.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            console.log('Photo order updated successfully');
            showNotification('Photo order updated successfully', 'success');
        } else {
            console.error('Failed to update photo order:', data.message);
            showNotification('Failed to update photo order: ' + (data.message || 'Unknown error'), 'error');
            // Reload the galleries to restore original order
            loadPublishedPhotos();
        }
    })
    .catch(error => {
        console.error('Error updating photo order:', error);
        showNotification('Error updating photo order', 'error');
        // Reload the galleries to restore original order
        loadPublishedPhotos();
    });
}

/* ========== Test Sortable Function (moved to top) ========== */
// testSortable function is now defined at the top of this file

/* ========== Bootstrapping ========== */
document.addEventListener('DOMContentLoaded', () => {
    console.log('Photo management script loaded');
    console.log('SortableJS available:', typeof Sortable !== 'undefined');
    
    // Initialize photo management components
    populatePhotoCollections();
    loadPublishedPhotos();
    setupPhotoDelegatedHandlers();
    setupEditCollectionModalHandlers();
    setupPhotoUploadForm();

    document.querySelectorAll('.nav-item').forEach(item => {
        item.addEventListener('click', function () {
            const sectionId = this.getAttribute('data-section');
            if (sectionId === 'photos') {
                loadPublishedPhotos();
            }
        });
    });
});

// Final confirmation that script loaded completely
console.log('Photo management script loaded completely. Functions available:', {
    testSortable: typeof window.testSortable,
    initializeGallerySortable: typeof window.initializeGallerySortable,
    initializePhotoCardsSortable: typeof window.initializePhotoCardsSortable
});
