// Photo Modal Test Functions
console.log('Photo modal test script loaded');

function openPhotoModal() {
    console.log('Opening photo modal...');
    const modal = document.getElementById('photoModal');
    console.log('Modal element found:', modal);
    if (modal) {
        modal.style.display = 'flex';
        document.body.style.overflow = 'hidden';
        
        modal.onclick = function(e) {
            if (e.target === modal) {
                closePhotoModal();
            }
        };
        console.log('Photo modal opened successfully');
    } else {
        console.error('Photo modal element not found!');
    }
}

function closePhotoModal() {
    console.log('Closing photo modal...');
    const modal = document.getElementById('photoModal');
    if (modal) {
        modal.style.display = 'none';
        document.body.style.overflow = '';
        
        const form = document.getElementById('galleryPhoto');
        if (form) form.reset();
        
        console.log('Photo modal closed successfully');
    }
}

// Make functions globally available
window.openPhotoModal = openPhotoModal;
window.closePhotoModal = closePhotoModal;

console.log('Photo modal functions defined globally');