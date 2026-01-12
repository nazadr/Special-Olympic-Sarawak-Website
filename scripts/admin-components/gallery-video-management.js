// Initialize video gallery sortables
function initializeVideoGallerySortable() {
    console.log('✅ Initializing video gallery sortable (videos only, collections NOT sortable)...');
    
    // NO collection-level sorting - collections are NOT draggable
    // Only individual video items within collections are sortable
    
    // Individual video items sortable
    document.querySelectorAll('.video-items-grid').forEach(grid => {
        // Check if already initialized
        if (grid.sortableInstance) return;
        
        grid.sortableInstance = new Sortable(grid, {
            animation: 150,
            handle: '.gallery-drag-handle',
            draggable: '.video-item',
            filter: '.edit-btn, .delete-btn, button, a, input, select, textarea',
            preventOnFilter: true,
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
    
    console.log('✅ Video items sortable initialized for', document.querySelectorAll('.video-items-grid').length, 'collections');
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

// Call this after AJAX content load
window.initializeVideoGallerySortable = initializeVideoGallerySortable;
