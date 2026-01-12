// ========================================
// GLOBAL FUNCTIONS - Must be outside DOMContentLoaded
// ========================================

// Click handler that DIRECTLY calls the function (bypassing onclick attribute issues)
document.addEventListener('click', function(e) {
    const target = e.target;
    const btn = target.closest('.collection-edit-btn');
    
    if (btn) {
        console.log('🔴 Edit button clicked - calling function directly');
        e.preventDefault();
        e.stopPropagation();
        
        // Get data from onclick attribute or data attributes
        const onclickAttr = btn.getAttribute('onclick');
        if (onclickAttr) {
            // Parse: editVideoCollection(1, 'Name', 'Desc')
            const match = onclickAttr.match(/editVideoCollection\((\d+),\s*'([^']*)',\s*'([^']*)'\)/);
            if (match) {
                const id = parseInt(match[1]);
                const name = match[2];
                const desc = match[3];
                console.log('  Parsed:', id, name, desc);
                editVideoCollection(id, name, desc);
                return;
            }
        }
        console.log('  Could not parse onclick, check data attributes');
    }
    
    // Handle delete collection button
    const deleteBtn = target.closest('.collection-delete-btn');
    if (deleteBtn) {
        console.log('🗑️ Delete button clicked - calling function directly');
        e.preventDefault();
        e.stopPropagation();
        
        const onclickAttr = deleteBtn.getAttribute('onclick');
        if (onclickAttr) {
            const match = onclickAttr.match(/deleteCollection\((\d+)\)/);
            if (match) {
                const id = parseInt(match[1]);
                deleteCollection(id);
                return;
            }
        }
    }
    
    // Handle delete video button
    const videoDeleteBtn = target.closest('.video-delete-btn');
    if (videoDeleteBtn) {
        console.log('🗑️ Video delete clicked - calling function directly');
        e.preventDefault();
        e.stopPropagation();
        
        const onclickAttr = videoDeleteBtn.getAttribute('onclick');
        if (onclickAttr) {
            const match = onclickAttr.match(/deleteVideo\((\d+)\)/);
            if (match) {
                const id = parseInt(match[1]);
                deleteVideo(id);
                return;
            }
        }
    }
    
    // Handle edit video button
    const videoEditBtn = target.closest('.video-edit-btn');
    if (videoEditBtn) {
        console.log('✏️ Video edit clicked - calling function directly');
        e.preventDefault();
        e.stopPropagation();
        
        const onclickAttr = videoEditBtn.getAttribute('onclick');
        if (onclickAttr) {
            const match = onclickAttr.match(/editVideo\((\d+),\s*'([^']*)',\s*'([^']*)'/);  
            if (match) {
                const id = parseInt(match[1]);
                const title = match[2].replace(/&#39;/g, "'").replace(/&quot;/g, '"');
                const desc = match[3].replace(/&#39;/g, "'").replace(/&quot;/g, '"');
                editVideo(id, title, desc);
                return;
            }
        }
    }
}, true); // Capture phase to run FIRST

// Edit Video Collection - Opens the edit modal
function editVideoCollection(collectionId, collectionName, collectionDesc) {
    console.log('🎯 editVideoCollection called:', collectionId, collectionName, collectionDesc);
    
    // Decode HTML entities
    const name = String(collectionName || '').replace(/&#39;/g, "'").replace(/&quot;/g, '"');
    const desc = String(collectionDesc || '').replace(/&#39;/g, "'").replace(/&quot;/g, '"');
    
    // Check if the admin panel has the full openEditCollectionModal function (with carousel logic)
    if (typeof window.openEditCollectionModal === 'function') {
        console.log('✅ Calling admin panel openEditCollectionModal with carousel support');
        window.openEditCollectionModal(collectionId, name, desc);
        return;
    }
    
    // Fallback to basic modal opening (if admin function not available)
    console.log('⚠️ Using fallback modal opening (no carousel)');
    const modal = document.getElementById('editVideoCollectionModal');
    console.log('Modal element found:', !!modal);
    
    if (modal) {
        // Populate form fields
        const idField = document.getElementById('editCollectionId');
        const nameField = document.getElementById('editCollectionName');
        const descField = document.getElementById('editCollectionDesc');
        
        if (idField) idField.value = collectionId;
        if (nameField) nameField.value = name;
        if (descField) descField.value = desc;
        
        // Show modal
        modal.classList.add('show');
        modal.style.display = 'flex';
        document.body.style.overflow = 'hidden';
        
        console.log('✅ Edit modal opened for collection:', collectionId);
    } else {
        console.error('❌ editVideoCollectionModal not found!');
        alert('Edit modal not found. Please refresh the page.');
    }
}

// Edit Individual Video - Opens edit video modal
function editVideo(videoId, videoTitle, videoDesc) {
    console.log('✏️ editVideo called:', videoId, videoTitle, videoDesc);
    
    const modal = document.getElementById('editVideoModal');
    console.log('Edit Video Modal found:', !!modal);
    
    if (modal) {
        // Populate form fields
        const idField = document.getElementById('editVideoId');
        const titleField = document.getElementById('editVideoTitle');
        const descField = document.getElementById('editVideoDesc');
        
        if (idField) idField.value = videoId;
        if (titleField) titleField.value = videoTitle;
        if (descField) descField.value = videoDesc;
        
        // Show modal
        modal.classList.add('show');
        modal.style.display = 'flex';
        document.body.style.overflow = 'hidden';
        
        console.log('✅ Edit video modal opened for video:', videoId);
    } else {
        console.error('❌ editVideoModal not found!');
        alert('Edit modal not found. Please refresh the page.');
    }
}

// Delete Collection
function deleteCollection(collectionId) {
    console.log('🗑️ deleteCollection called:', collectionId);
    if (!confirm('Delete this collection and all its videos? This cannot be undone.')) return;
    
    const fd = new FormData();
    fd.append('action', 'delete_collection');
    fd.append('id', collectionId);
    
    fetch('handler/admin_gallery_video_handler.php', { method: 'POST', body: fd })
        .then(r => r.json())
        .then(d => {
            if (d.success) {
                alert('Collection deleted successfully');
                if (typeof window.loadPublishedVideos === 'function') {
                    window.loadPublishedVideos();
                }
                if (typeof window.populateVideoCollections === 'function') {
                    window.populateVideoCollections();
                }
            } else {
                alert(d.message || 'Failed to delete collection');
            }
        })
        .catch(e => {
            console.error(e);
            alert('Error deleting collection');
        });
}

// Delete Video
function deleteVideo(videoId) {
    console.log('🗑️ deleteVideo called:', videoId);
    if (!confirm('Delete this video? This cannot be undone.')) return;
    
    const fd = new FormData();
    fd.append('action', 'delete_video');
    fd.append('id', videoId);
    
    fetch('handler/admin_gallery_video_handler.php', { method: 'POST', body: fd })
        .then(r => r.json())
        .then(d => {
            if (d.success) {
                alert('Video deleted successfully');
                if (typeof window.loadPublishedVideos === 'function') {
                    window.loadPublishedVideos();
                }
            } else {
                alert(d.message || 'Failed to delete video');
            }
        })
        .catch(e => {
            console.error(e);
            alert('Error deleting video');
        });
}

console.log('✅ Video global functions defined:', {
    editVideoCollection: typeof editVideoCollection,
    deleteCollection: typeof deleteCollection,
    deleteVideo: typeof deleteVideo
});

// ========================================
// DOM CONTENT LOADED - Internal functions
// ========================================
document.addEventListener('DOMContentLoaded', function () {
    // Elements
    const videoForm = document.getElementById('galleryVideo');
    const videoInput = document.getElementById('galleryVideo');
    const coverInput = document.getElementById('galleryVideoImage');
    const statusSpan = document.getElementById('galleryVideoStatus');
    const coverStatus = document.getElementById('galleryVideoImageStatus');
    const coverPreview = document.getElementById('galleryVideoImagePreview');
    const delVideoBtn = document.getElementById('deleteGalleryVideoBtn');
    const delCoverBtn = document.getElementById('deleteGalleryVideoImageBtn');
    const albumSelect = document.getElementById('galleryVideoAlbum');
    const publishedContainer = document.getElementById('publishedGalleryVideo');

    // Load collections for dropdown
    function populateVideoCollections() {
        fetch('handler/admin_gallery_video_handler.php?action=fetch_collections')
            .then(r => r.json())
            .then(d => {
                if (!d.success) return;
                albumSelect.innerHTML = '<option value="">Select Collection</option>';
                d.collections.forEach(col => {
                    const opt = document.createElement('option');
                    opt.value = col.name;
                    opt.textContent = col.name;
                    albumSelect.appendChild(opt);
                });
            });
    }

    // Load published video collections and videos
    function loadPublishedVideos() {
        console.log('🟢 loadPublishedVideos() called');
        if (!publishedContainer) return;
        publishedContainer.innerHTML = '<p style="text-align:center;color:#64748b;padding:24px 0;">Loading video collections...</p>';
        fetch('handler/admin_gallery_video_handler.php?action=fetch_collections')
            .then(r => r.json())
            .then(d => {
                if (!d.success || !d.collections.length) {
                    publishedContainer.innerHTML = '<p style="text-align:center;color:#64748b;padding:24px 0;">No video collections found.</p>';
                    return;
                }
                publishedContainer.innerHTML = '';
                const tasks = d.collections.map(col =>
                    fetch(`handler/admin_gallery_video_handler.php?action=fetch_items&collection_id=${col.id}`)
                        .then(r => r.json())
                        .then(items => {
                            const videos = (items.success && items.videos) ? items.videos : [];
                            const wrap = document.createElement('div');
                            wrap.className = 'gallery-admin-category';
                            wrap.dataset.collectionId = col.id;
                            
                            // Escape data for safe use
                            const escapedName = (col.name || '').replace(/'/g, "&#39;").replace(/"/g, "&quot;");
                            const escapedDesc = (col.description || '').replace(/'/g, "&#39;").replace(/"/g, "&quot;");
                            
                            wrap.innerHTML = `
                                <div class="video-collection" data-collection-id="${col.id}">
                                    <div class="collection-header">
                                        <div class="collection-info">
                                            <h3>${col.name}</h3>
                                            <p>${col.description || 'No description'}</p>
                                        </div>
                                        <div class="collection-actions">
                                            <button type="button" 
                                                class="edit-btn collection-edit-btn" 
                                                onclick="editVideoCollection(${col.id}, '${escapedName}', '${escapedDesc}')"
                                                title="Edit collection">
                                                <i class="fas fa-edit"></i> Edit Collection
                                            </button>
                                            <button type="button" 
                                                class="delete-btn collection-delete-btn" 
                                                onclick="deleteCollection(${col.id})"
                                                title="Delete collection">
                                                <i class="fas fa-trash"></i> Delete
                                            </button>
                                        </div>
                                    </div>
                                    <div class="video-items-grid" data-collection-id="${col.id}">
                                        ${videos.length > 0 ? videos.map(v => {
                                            // Smart path handling for cover image
                                            let coverSrc = v.cover_path || 'assets/videos/gallery_videos_upload/covers/default-video-thumb.svg';
                                            if (coverSrc && !coverSrc.startsWith('http') && !coverSrc.startsWith('../') && !coverSrc.startsWith('assets/')) {
                                                coverSrc = '../' + coverSrc;
                                            } else if (coverSrc && coverSrc.startsWith('assets/')) {
                                                coverSrc = '../' + coverSrc;
                                            }
                                            return `
                                            <div class="video-item" data-video-id="${v.id}">
                                                <div class="gallery-drag-handle" title="Drag to reorder">
                                                    <i class="fas fa-grip-vertical"></i>
                                                </div>
                                                <img src="${coverSrc}" alt="${v.title}" onerror="this.src='../assets/videos/gallery_videos_upload/covers/default-video-thumb.svg'">
                                                <div class="video-overlay">
                                                    <p class="video-title">${v.title}</p>
                                                    <div class="video-actions">
                                                        <button type="button" class="video-delete-btn" onclick="deleteVideo(${v.id})">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        `;}).join('') : '<p style="text-align:center;padding:20px;color:#94a3b8;">No videos in this collection. Click "Add Videos" to add some.</p>'}
                                    </div>
                                </div>`;
                            publishedContainer.appendChild(wrap);
                        })
                );
                Promise.all(tasks).then(() => {
                    // Initialize sortable after videos are loaded
                    if (typeof window.initializeVideoGallerySortable === 'function') {
                        window.initializeVideoGallerySortable();
                    }
                    console.log('✅ Video collections loaded with onclick handlers');
                });
            })
            .catch(e => {
                console.error(e);
                publishedContainer.innerHTML = '<p style="text-align:center;color:#ef4444;padding:24px 0;">Failed to load video collections.</p>';
            });
    }

    // Bind handlers for video modals, edit/delete collection, delete video
    function bindVideoAdminHandlers() {
        // This function is now mostly empty since we use onclick handlers
        // Keep it for backward compatibility
        console.log('✅ bindVideoAdminHandlers called - using inline onclick handlers');
    }

    // Delete collection modal logic (reuse from photo management if needed)
    function openCollectionDeleteModal(collectionId) {
        const modal = document.getElementById('gallery-modal-delete-album');
        const deleteBtn = document.getElementById('deleteGalleryAlbum');
        if (!modal || !deleteBtn) return;
        modal.style.display = 'flex';
        deleteBtn.disabled = true;
        let countdown = 5;
        const msgP = modal.querySelector('.gmac-desc p:nth-of-type(2)');
        const interval = setInterval(() => {
            countdown--;
            if (msgP) msgP.textContent = countdown > 0
                ? `The delete button will be available in ${countdown} second(s).`
                : 'The delete button is now available.';
            if (countdown <= 0) {
                deleteBtn.disabled = false;
                clearInterval(interval);
            }
        }, 1000);
        deleteBtn.onclick = () => {
            if (deleteBtn.disabled) return;
            if (!confirm('Delete this collection (all videos)?')) return;
            const fd = new FormData();
            fd.append('action', 'delete_collection');
            fd.append('id', collectionId);
            fetch('handler/admin_gallery_video_handler.php', { method: 'POST', body: fd })
                .then(r => r.json())
                .then(d => {
                    alert(d.message || (d.success ? 'Deleted' : 'Failed'));
                    if (d.success) {
                        modal.style.display = 'none';
                        loadPublishedVideos();
                        populateVideoCollections();
                    }
                });
        };
        document.getElementById('gallery-modal-album-close')?.addEventListener('click', () => {
            modal.style.display = 'none';
        }, { once: true });
        modal.addEventListener('click', e => {
            if (e.target === modal) modal.style.display = 'none';
        }, { once: true });
    }

    // Video upload form logic
    if (videoInput && delVideoBtn) {
        delVideoBtn.style.display = 'none';
        videoInput.addEventListener('change', () => {
            if (videoInput.files && videoInput.files[0]) {
                const f = videoInput.files[0];
                statusSpan.textContent = `${f.name} (${(f.size / 1048576).toFixed(2)} MB)`;
                delVideoBtn.style.display = 'inline-block';
            } else {
                statusSpan.textContent = 'No file selected';
                delVideoBtn.style.display = 'none';
            }
        });
        delVideoBtn.addEventListener('click', () => {
            videoInput.value = '';
            statusSpan.textContent = 'No file selected';
            delVideoBtn.style.display = 'none';
        });
    }

    if (coverInput && delCoverBtn) {
        delCoverBtn.style.display = 'none';
        coverInput.addEventListener('change', () => {
            if (coverInput.files && coverInput.files[0]) {
                const f = coverInput.files[0];
                coverStatus.textContent = f.name;
                const fr = new FileReader();
                fr.onload = e => {
                    const previewImg = coverPreview.querySelector('img');
                    if (previewImg) {
                        previewImg.src = e.target.result;
                        coverPreview.style.display = 'block';
                    }
                };
                fr.readAsDataURL(f);
                delCoverBtn.style.display = 'inline-block';
            } else {
                coverStatus.textContent = 'No file selected';
                const previewImg = coverPreview.querySelector('img');
                if (previewImg) previewImg.src = '';
                coverPreview.style.display = 'none';
                delCoverBtn.style.display = 'none';
            }
        });
        delCoverBtn.addEventListener('click', () => {
            coverInput.value = '';
            coverStatus.textContent = 'No file selected';
            const previewImg = coverPreview.querySelector('img');
            if (previewImg) previewImg.src = '';
            coverPreview.style.display = 'none';
            delCoverBtn.style.display = 'none';
        });
    }

    if (videoForm) {
        videoForm.addEventListener('submit', e => {
            e.preventDefault();
            if (!videoInput.files[0] || !coverInput.files[0]) {
                alert('Video and cover required');
                return;
            }
            const fd = new FormData(videoForm);
            fd.append('action', 'add_video');

            const xhr = new XMLHttpRequest();
            xhr.upload.onprogress = (ev) => {
                if (ev.lengthComputable) {
                    const pct = Math.round((ev.loaded / ev.total) * 100);
                    const loadedMB = (ev.loaded / 1048576).toFixed(2);
                    const totalMB = (ev.total / 1048576).toFixed(2);
                    statusSpan.textContent = `Uploading: ${loadedMB}/${totalMB} MB (${pct}%)`;
                }
            };
            xhr.onreadystatechange = () => {
                if (xhr.readyState === 4) {
                    try {
                        const d = JSON.parse(xhr.responseText);
                        alert(d.message || (d.success ? 'Video uploaded successfully!' : 'Upload failed'));
                        if (d.success) {
                            // Reset form and hide modal
                            videoForm.reset();
                            statusSpan.textContent = 'No file selected';
                            coverStatus.textContent = 'No file selected';
                            const previewImg = coverPreview.querySelector('img');
                            if (previewImg) previewImg.src = '';
                            coverPreview.style.display = 'none';
                            delVideoBtn.style.display = 'none';
                            delCoverBtn.style.display = 'none';
                            
                            // Close modal
                            if (typeof closeVideoModal === 'function') {
                                closeVideoModal();
                            }
                            
                            // Reload videos and collections
                            loadPublishedVideos();
                            populateVideoCollections();
                        }
                    } catch (e) { alert('Upload failed'); }
                }
            };
            xhr.open('POST', 'handler/admin_gallery_video_handler.php', true);
            xhr.send(fd);
        });
    }

    // Initial load
    populateVideoCollections();
    loadPublishedVideos();

    // Expose internal functions globally (for reloading data after operations)
    window.loadPublishedVideos = loadPublishedVideos;
    window.populateVideoCollections = populateVideoCollections;

    console.log('✅ Video Management DOMContentLoaded complete!');

    // Reload when Videos section is opened
    document.querySelectorAll('.nav-item').forEach(item => {
        item.addEventListener('click', function () {
            const sectionId = this.getAttribute('data-section');
            if (sectionId === 'videos') {
                loadPublishedVideos();
            }
        });
    });
});