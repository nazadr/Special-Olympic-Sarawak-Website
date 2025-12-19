// Initialize video gallery sortables
function initializeVideoGallerySortable() {
    console.log('Initializing video gallery sortable...');
    
    // Collection headers sortable
    const collectionsContainer = document.getElementById('publishedGalleryVideo');
    if (collectionsContainer) {
        new Sortable(collectionsContainer, {
            animation: 150,
            handle: '.collection-header-drag-handle',
            draggable: '.video-collection',
            ghostClass: 'sortable-ghost',
            chosenClass: 'sortable-chosen',
            dragClass: 'sortable-drag',
            onStart: function() {
                collectionsContainer.classList.add('dragging');
            },
            onEnd: function(evt) {
                collectionsContainer.classList.remove('dragging');
                saveVideoCollectionOrder();
            }
        });
    }
    
    // Individual video items sortable
    document.querySelectorAll('.video-items-grid').forEach(grid => {
        new Sortable(grid, {
            animation: 150,
            handle: '.gallery-drag-handle',
            draggable: '.video-item',
            ghostClass: 'sortable-ghost',
            chosenClass: 'sortable-chosen',
            dragClass: 'sortable-drag',
            onStart: function() {
                grid.classList.add('dragging');
            },
            onEnd: function(evt) {
                grid.classList.remove('dragging');
                const collectionId = grid.dataset.collectionId;
                saveVideoOrder(collectionId);
            }
        });
    });
}

function saveVideoCollectionOrder() {
    const collections = document.querySelectorAll('.video-collection');
    const order = Array.from(collections).map((col, index) => ({
        id: col.dataset.collectionId,
        order: index + 1
    }));
    
    fetch('handler/admin_gallery_video_handler.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ action: 'update_collection_order', order })
    });
}

function saveVideoOrder(collectionId) {
    const videos = document.querySelectorAll(`[data-collection-id="${collectionId}"] .video-item`);
    const order = Array.from(videos).map((video, index) => ({
        id: video.dataset.videoId,
        order: index + 1
    }));
    
    fetch('handler/admin_gallery_video_handler.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ action: 'update_video_order', collection_id: collectionId, order })
    });
}

window.initializeVideoGallerySortable = initializeVideoGallerySortable;
