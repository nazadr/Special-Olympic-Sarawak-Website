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
            filter: '.edit-btn, .delete-btn, button, a, input, select, textarea',
            preventOnFilter: false,
            ghostClass: 'sortable-ghost',
            chosenClass: 'sortable-chosen',
            dragClass: 'sortable-drag',
            // Prevent drag from starting if clicking on buttons
            onChoose: function(evt) {
                const target = evt.originalEvent.target;
                const isButton = target.closest('.edit-btn, .delete-btn, button, a');
                if (isButton) {
                    return false; // Cancel the drag
                }
            },
            // Double-check on move
            onMove: function(evt) {
                const target = evt.related;
                if (target && target.closest('.edit-btn, .delete-btn, button, a')) {
                    return false;
                }
            },
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
            filter: '.edit-btn, .delete-btn, button, a, input, select, textarea',
            preventOnFilter: false,
            ghostClass: 'sortable-ghost',
            chosenClass: 'sortable-chosen',
            dragClass: 'sortable-drag',
            // Prevent drag from starting if clicking on buttons
            onChoose: function(evt) {
                const target = evt.originalEvent.target;
                const isButton = target.closest('.edit-btn, .delete-btn, button, a');
                if (isButton) {
                    return false; // Cancel the drag
                }
            },
            // Double-check on move
            onMove: function(evt) {
                const target = evt.related;
                if (target && target.closest('.edit-btn, .delete-btn, button, a')) {
                    return false;
                }
            },
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
    
    // Ensure all buttons are clickable after initialization
    setTimeout(() => {
        ensurePhotoButtonsClickable();
    }, 100);
}

// Ensure all buttons work correctly
function ensurePhotoButtonsClickable() {
    const allButtons = document.querySelectorAll('#publishedGalleryPhoto .edit-btn, #publishedGalleryPhoto .delete-btn, #publishedGalleryPhoto button:not([type="submit"]), #publishedGalleryPhoto a');
    
    allButtons.forEach(button => {
        // Force styles
        button.style.pointerEvents = 'auto';
        button.style.cursor = 'pointer';
        button.style.position = 'relative';
        button.style.zIndex = '9999';
        
        // Stop any drag attempt on button
        button.addEventListener('mousedown', function(e) {
            e.stopPropagation();
            e.stopImmediatePropagation();
        }, true);
        
        button.addEventListener('touchstart', function(e) {
            e.stopPropagation();
            e.stopImmediatePropagation();
        }, true);
        
        // Ensure click works
        button.addEventListener('click', function(e) {
            e.stopPropagation();
            console.log('Photo button clicked:', button);
        }, true);
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
window.ensurePhotoButtonsClickable = ensurePhotoButtonsClickable;
