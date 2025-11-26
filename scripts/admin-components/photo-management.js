// Photo Management functionality

// Load collections + photos into the Published Photos section
function loadPublishedPhotos() {
    const container = document.getElementById('publishedGalleryPhoto');
    if (!container) return;

    container.innerHTML = '<p style="text-align: center; color: #64748b; padding: 24px 0;">Loading photo collections...</p>';

    fetch('handler/admin_gallery_photo_handler.php?action=fetch_collections')
        .then(r => r.json())
        .then(d => {
            if (!d.success || !d.collections || d.collections.length === 0) {
                container.innerHTML = '<p style="text-align: center; color: #64748b; padding: 24px 0;">No photo collections found.</p>';
                return;
            }

            const tasks = d.collections.map(col => {
                return fetch(`handler/admin_gallery_photo_handler.php?action=fetch_items&collection_id=${col.id}`)
                    .then(r => r.json())
                    .then(items => {
                        const wrap = document.createElement('div');
                        wrap.className = 'gallery-admin-category';
                        wrap.dataset.collectionId = col.id;

                        const photos = (items.success && items.photos) ? items.photos : [];

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
                                ${photos.map(p => `
                                    <div class="gallery-admin-card photos" data-photo-id="${p.id}" data-src="${p.image_path}">
                                        <img src="${p.image_path}" alt="Gallery Photo">
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

    fetch('handler/admin_gallery_photo_handler.php', { method: 'POST', body: fd })
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

    fetch('handler/admin_gallery_photo_handler.php?action=fetch_collections')
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

            fetch('handler/admin_gallery_photo_handler.php', { method: 'POST', body: fd })
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

        fetch('handler/admin_gallery_photo_handler.php', { method: 'POST', body: fd })
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

    fetch('handler/admin_gallery_photo_handler.php?action=fetch_collections')
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
            if (imgInput.files && imgInput.files[0]) {
                statusSpan.textContent = imgInput.files[0].name;
                const fr = new FileReader();
                fr.onload = e => {
                    preview.src = e.target.result;
                    preview.style.display = 'block';
                };
                fr.readAsDataURL(imgInput.files[0]);
                delBtn.style.display = 'inline-block';
            } else {
                statusSpan.textContent = 'No file selected.';
                preview.src = '';
                preview.style.display = 'none';
                delBtn.style.display = 'none';
            }
        });
        delBtn.addEventListener('click', () => {
            imgInput.value = '';
            statusSpan.textContent = 'No file selected.';
            preview.src = '';
            preview.style.display = 'none';
            delBtn.style.display = 'none';
        });
    }

    if (form) {
        form.addEventListener('submit', e => {
            e.preventDefault();
            const fd = new FormData(form);
            fd.append('action', 'add_photo');

            fetch('handler/admin_gallery_photo_handler.php', { method: 'POST', body: fd })
                .then(r => r.json())
                .then(d => {
                    alert(d.message || (d.success ? 'Uploaded' : 'Failed'));
                    if (d.success) {
                        form.reset();
                        if (preview) preview.style.display = 'none';
                        if (statusSpan) statusSpan.textContent = 'No file selected.';
                        if (delBtn) delBtn.style.display = 'none';
                        loadPublishedPhotos();
                        populatePhotoCollections();
                    }
                });
        });
    }
}

/* ========== Bootstrapping ========== */
document.addEventListener('DOMContentLoaded', () => {
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