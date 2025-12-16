// Modal Functions for Event and Sponsorship Management
console.log('Modal functions script loaded');

function openSponsorshipModal() {
    const modal = document.getElementById('sponsorshipModal');
    if (modal) {
        modal.style.display = 'flex';
        document.body.style.overflow = 'hidden';
        
        modal.onclick = function(e) {
            if (e.target === modal) {
                closeSponsorshipModal();
            }
        };
        console.log('Sponsorship modal opened');
    }
}

function closeSponsorshipModal() {
    const modal = document.getElementById('sponsorshipModal');
    if (modal) {
        modal.style.display = 'none';
        document.body.style.overflow = '';
        
        const form = document.getElementById('sponsorshipForm');
        if (form) form.reset();
        console.log('Sponsorship modal closed');
    }
}

function openEventModal() {
    const modal = document.getElementById('eventModal');
    if (modal) {
        modal.style.display = 'flex';
        document.body.style.overflow = 'hidden';
        
        modal.onclick = function(e) {
            if (e.target === modal) {
                closeEventModal();
            }
        };
        console.log('Event modal opened');
    }
}

function closeEventModal() {
    const modal = document.getElementById('eventModal');
    if (modal) {
        modal.style.display = 'none';
        document.body.style.overflow = '';
        
        const form = document.getElementById('eventForm');
        if (form) form.reset();
        console.log('Event modal closed');
    }
}

// Make functions globally available
window.openSponsorshipModal = openSponsorshipModal;
window.closeSponsorshipModal = closeSponsorshipModal;
window.openEventModal = openEventModal;
window.closeEventModal = closeEventModal;