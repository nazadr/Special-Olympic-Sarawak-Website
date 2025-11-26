document.addEventListener('DOMContentLoaded', function() {
    const navItems = document.querySelectorAll('.nav-item');
    const contentSections = document.querySelectorAll('.content-section');
    const pageTitle = document.querySelector('.page-title');

    navItems.forEach(item => {
        item.addEventListener('click', function(e) {
            e.preventDefault();

            // Remove active class from all nav items
            navItems.forEach(nav => nav.classList.remove('active'));

            // Add active class to clicked item
            this.classList.add('active');

            // Get section ID
            const sectionId = this.getAttribute('data-section');

            // Update page title
            const sectionTitle = this.querySelector('span').textContent;
            if (pageTitle) pageTitle.textContent = sectionTitle;

            // Hide all content sections
            contentSections.forEach(section => section.classList.remove('active'));

            // Show selected section
            const targetSection = document.getElementById(sectionId);
            if (targetSection) targetSection.classList.add('active');

            // Optionally, trigger section-specific loading logic
            // Example:
            // if (sectionId === 'news' && typeof loadNewsArticles === 'function') loadNewsArticles();
            // if (sectionId === 'events' && typeof loadEvents === 'function') loadEvents();
            // if (sectionId === 'sponsorships' && typeof loadSponsorships === 'function') loadSponsorships();
            // if (sectionId === 'photos' && typeof loadPublishedPhotos === 'function') loadPublishedPhotos();
        });
    });

    // Initial load of content based on default active section
    const initialActiveSection = document.querySelector('.content-section.active');
    if (initialActiveSection) {
        const sectionId = initialActiveSection.id;
        // Optionally, trigger section-specific loading logic here as well
        // Example:
        // if (sectionId === 'news' && typeof loadNewsArticles === 'function') loadNewsArticles();
        // if (sectionId === 'events' && typeof loadEvents === 'function') loadEvents();
    }
});