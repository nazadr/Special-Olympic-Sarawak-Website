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
                            wrap.innerHTML = `
                                <div class="gallery-admin-info">
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
                                    ${videos.map(v => `
                                      <div class="gallery-admin-card videos" data-video-id="${v.id}" data-src="${v.video_path}" data-cover="${v.cover_path}" data-title="${v.title}" data-desc="${v.description || ''}" data-album="${col.name}">
                                         <img src="${v.cover_path}" alt="Video Thumbnail">
                                         <div class="gac-hover"><p>${v.title}</p></div>
                                      </div>`).join('')}
                                </div>`;
                            publishedContainer.appendChild(wrap);
                        })
                );
                Promise.all(tasks).then(() => bindVideoAdminHandlers());
            })
            .catch(e => {
                console.error(e);
                publishedContainer.innerHTML = '<p style="text-align:center;color:#ef4444;padding:24px 0;">Failed to load video collections.</p>';
            });
    }

    // Bind handlers for video modals, edit/delete collection, delete video
    function bindVideoAdminHandlers() {
        const videoModal = document.getElementById('galvideo-modal');
        const videoModalClose = document.getElementById('galvideo-modal-close');
        const videoModalImage = document.getElementById('galvideo-modal-image');
        const videoTitleInput = document.getElementById('galleryVideoTitleEdit');
        const videoDescInput = document.getElementById('galleryVideoDescEdit');
        const videoAlbumSelect = document.getElementById('galleryVideoAlbumEdit');
        const videoDeleteBtn = videoModal.querySelector('.delete-btn');
        const videoSaveBtn = document.getElementById('saveGalleryVideoEdit');
        let activeVideoId = null;

        // Video card click -> open modal
        document.querySelectorAll('.gallery-admin-card.videos').forEach(card => {
            card.onclick = () => {
                activeVideoId = card.dataset.videoId;
                videoModalImage.src = card.dataset.cover;
                videoModalImage.alt = card.dataset.title || 'Video Thumbnail';
                videoTitleInput.value = card.dataset.title || '';
                videoDescInput.value = card.dataset.desc || '';
                // Populate album select (if needed)
                if (videoAlbumSelect) {
                    for (let i = 0; i < videoAlbumSelect.options.length; i++) {
                        if (videoAlbumSelect.options[i].value === card.dataset.album) {
                            videoAlbumSelect.selectedIndex = i;
                            break;
                        }
                    }
                }
                videoModal.style.display = 'flex';
            };
        });

        // Delete single video
        if (videoDeleteBtn) {
            videoDeleteBtn.onclick = () => {
                if (!activeVideoId) return;
                if (!confirm('Delete this video?')) return;
                const fd = new FormData();
                fd.append('action', 'delete_video');
                fd.append('id', activeVideoId);
                fetch('handler/admin_gallery_video_handler.php', { method: 'POST', body: fd })
                    .then(r => r.json())
                    .then(d => {
                        alert(d.message || (d.success ? 'Deleted' : 'Failed'));
                        if (d.success) {
                            videoModal.style.display = 'none';
                            loadPublishedVideos();
                        }
                    });
            };
        }

        // Save edit video
        if (videoSaveBtn) {
            videoSaveBtn.onclick = () => {
                if (!activeVideoId) return;
                const fd = new FormData();
                fd.append('action', 'update_video');
                fd.append('id', activeVideoId);
                fd.append('title', videoTitleInput.value.trim());
                fd.append('description', videoDescInput.value.trim());
                fd.append('album', videoAlbumSelect.value);
                fetch('handler/admin_gallery_video_handler.php', { method: 'POST', body: fd })
                    .then(r => r.json())
                    .then(d => {
                        alert(d.message || (d.success ? 'Updated' : 'Failed'));
                        if (d.success) {
                            videoModal.style.display = 'none';
                            loadPublishedVideos();
                        }
                    });
            };
        }

        // Close modal
        if (videoModalClose) videoModalClose.onclick = () => videoModal.style.display = 'none';
        if (videoModal) videoModal.onclick = e => { if (e.target === videoModal) videoModal.style.display = 'none'; };

        // Edit collection button
        document.querySelectorAll('.edit-collection-btn').forEach(btn => {
            btn.onclick = () => {
                const id = btn.dataset.id;
                openCollectionEditModal(id);
            };
        });

        // Delete collection button
        document.querySelectorAll('.delete-collection-btn').forEach(btn => {
            btn.onclick = () => {
                const id = btn.dataset.id;
                openCollectionDeleteModal(id);
            };
        });
    }

    // Edit collection modal logic (reuse from photo management if needed)
    function openCollectionEditModal(collectionId) {
        const modal = document.getElementById('galphoto-modal-album');
        if (!modal) return;
        fetch('handler/admin_gallery_video_handler.php?action=fetch_collections')
            .then(r => r.json())
            .then(d => {
                if (!d.success) return;
                const col = d.collections.find(c => c.id == collectionId);
                if (!col) return;
                const nameInput = modal.querySelector('input#galleryPhotoAlbum');
                const descInput = modal.querySelector('input#galleryPhotoAlbumDesc');
                if (nameInput) nameInput.value = col.name;
                if (descInput) descInput.value = col.description || '';
                modal.dataset.collectionId = collectionId;
                modal.style.display = 'flex';
            });
    }
    document.getElementById('galphoto-modal-album-close')?.addEventListener('click', () => {
        const modal = document.getElementById('galphoto-modal-album');
        if (modal) modal.style.display = 'none';
    });
    document.getElementById('saveGalleryPhotoAlbumEdit')?.addEventListener('click', () => {
        const modal = document.getElementById('galphoto-modal-album');
        if (!modal) return;
        const id = modal.dataset.collectionId;
        const nameInput = modal.querySelector('input#galleryPhotoAlbum');
        const descInput = modal.querySelector('input#galleryPhotoAlbumDesc');
        if (!id || !nameInput) return;
        const fd = new FormData();
        fd.append('action', 'update_collection');
        fd.append('id', id);
        fd.append('name', nameInput.value.trim());
        fd.append('description', descInput.value.trim());
        fetch('handler/admin_gallery_video_handler.php', { method: 'POST', body: fd })
            .then(r => r.json())
            .then(d => {
                alert(d.message || (d.success ? 'Updated' : 'Failed'));
                if (d.success) {
                    modal.style.display = 'none';
                    loadPublishedVideos();
                    populateVideoCollections();
                }
            });
    });

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
                statusSpan.textContent = `Ready: ${f.name} (${(f.size / 1048576).toFixed(2)} MB)`;
                delVideoBtn.style.display = 'inline-block';
            } else {
                statusSpan.textContent = 'No file selected.';
                delVideoBtn.style.display = 'none';
            }
        });
        delVideoBtn.addEventListener('click', () => {
            videoInput.value = '';
            statusSpan.textContent = 'No file selected.';
            delVideoBtn.style.display = 'none';
        });
    }

    if (coverInput && delCoverBtn) {
        delCoverBtn.style.display = 'none';
        coverInput.addEventListener('change', () => {
            if (coverInput.files && coverInput.files[0]) {
                coverStatus.textContent = coverInput.files[0].name;
                const fr = new FileReader();
                fr.onload = e => {
                    coverPreview.src = e.target.result;
                    coverPreview.style.display = 'block';
                };
                fr.readAsDataURL(coverInput.files[0]);
                delCoverBtn.style.display = 'inline-block';
            } else {
                coverStatus.textContent = 'No file selected.';
                coverPreview.src = '';
                coverPreview.style.display = 'none';
                delCoverBtn.style.display = 'none';
            }
        });
        delCoverBtn.addEventListener('click', () => {
            coverInput.value = '';
            coverStatus.textContent = 'No file selected.';
            coverPreview.src = '';
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
                        alert(d.message || (d.success ? 'Uploaded' : 'Failed'));
                        if (d.success) {
                            statusSpan.textContent = videoInput.files[0].name;
                            videoForm.reset();
                            coverPreview.style.display = 'none';
                            coverStatus.textContent = 'No file selected.';
                            delVideoBtn.style.display = 'none';
                            delCoverBtn.style.display = 'none';
                            loadPublishedVideos();
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