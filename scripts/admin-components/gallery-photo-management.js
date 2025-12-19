// The 
// Initialize photo gallery sortables after photos are loaded
function initializePhotoGallerySortable() {
    console.log('Initializing photo gallery sortable...');
    
    // Initialize collection headers sortable
    const collectionsContainer = document.getElementById('publishedGalleryPhoto');
    if (collectionsContainer) {
        new Sortable(collectionsContainer, {
            animation: 150,
            handle: '.collection-header-drag-handle',
            draggable: '.gallery-collection',
            ghostClass: 'sortable-ghost',
            chosenClass: 'sortable-chosen',
            dragClass: 'sortable-drag',
            onStart: function() {
                collectionsContainer.classList.add('dragging');
            },
            onEnd: function(evt) {
                collectionsContainer.classList.remove('dragging');
                saveCollectionOrder();
            }
        });
    }
    
    // Initialize individual photo items sortable within each collection
    document.querySelectorAll('.gallery-photos-grid').forEach(grid => {
        new Sortable(grid, {
            animation: 150,
            handle: '.gallery-drag-handle',
            draggable: '.gallery-item',
            ghostClass: 'sortable-ghost',
            chosenClass: 'sortable-chosen',
            dragClass: 'sortable-drag',
            onStart: function() {
                grid.classList.add('dragging');
            },
            onEnd: function(evt) {
                grid.classList.remove('dragging');
                const collectionId = grid.dataset.collectionId;
                savePhotoOrder(collectionId);
            }
        });
    });
}

function saveCollectionOrder() {
    const collections = document.querySelectorAll('.gallery-collection');
    const order = Array.from(collections).map((col, index) => ({
        id: col.dataset.collectionId,
        order: index + 1
    }));
    
    fetch('handler/admin_gallery_photo_handler.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ action: 'update_collection_order', order })
    });
}

function savePhotoOrder(collectionId) {
    const photos = document.querySelectorAll(`[data-collection-id="${collectionId}"] .gallery-item`);
    const order = Array.from(photos).map((photo, index) => ({
        id: photo.dataset.photoId,
        order: index + 1
    }));
    
    fetch('handler/admin_gallery_photo_handler.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ action: 'update_photo_order', collection_id: collectionId, order })
    });
}

// Call this after photos are loaded via AJAX
window.initializePhotoGallerySortable = initializePhotoGallerySortable;
