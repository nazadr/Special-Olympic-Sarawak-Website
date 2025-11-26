// Navigation functionality
document.addEventListener('DOMContentLoaded', function () {
    const navItems = document.querySelectorAll('.nav-item');
    const contentSections = document.querySelectorAll('.content-section');
    const pageTitle = document.querySelector('.page-title');
    const existingNewsArticlesContainer = document.getElementById('existingNewsArticles');
    const existingEventsContainer = document.getElementById('existingEvents');

    // News Management Functions
    function loadNewsArticles() {
        fetch('admin_news_handler.php?action=fetch')
            .then(response => response.json())
            .then(news => {
                existingNewsArticlesContainer.innerHTML = ''; // Clear previous content
                if (news.length > 0) {
                    news.forEach(article => {
                        const newsItem = document.createElement('div');
                        newsItem.classList.add('news-item-admin');
                        newsItem.innerHTML = `
                                    <img src="${article.image_path}" alt="${article.headline}" class="news-item-admin-image">
                                    <div class="news-item-admin-content">
                                        <h4 class="news-item-admin-headline">${article.headline}</h4>
                                        <p class="news-item-admin-date">${article.news_date}</p>
                                        <p class="news-item-admin-desc">${article.description}</p>
                                    </div>
                                    <div class="news-item-admin-actions">
                                        <button class="edit-btn" data-id="${article.id}"><i class="fa-solid fa-pencil"></i></button>
                                        <button class="delete-btn" data-id="${article.id}"><i class="fa-solid fa-trash"></i></button>
                                    </div>
                                `;
                        existingNewsArticlesContainer.appendChild(newsItem);
                    });

                    // Attach event listeners for edit and delete buttons
                    document.querySelectorAll('#existingNewsArticles .edit-btn').forEach(button => {
                        button.addEventListener('click', function () {
                            const newsId = this.getAttribute('data-id');
                            // Implement edit functionality (e.g., populate form or open modal)
                            alert('Edit news item with ID: ' + newsId);
                            // For a full implementation, you'd fetch the news item data
                            // and populate the form for editing.
                        });
                    });

                    document.querySelectorAll('#existingNewsArticles .delete-btn').forEach(button => {
                        button.addEventListener('click', function () {
                            const newsId = this.getAttribute('data-id');
                            if (confirm('Are you sure you want to delete this news article?')) {
                                fetch('admin_news_handler.php', {
                                    method: 'POST',
                                    headers: {
                                        'Content-Type': 'application/x-www-form-urlencoded',
                                    },
                                    body: `action=delete&id=${newsId}`
                                })
                                    .then(response => response.json())
                                    .then(data => {
                                        if (data.success) {
                                            alert('News article deleted successfully!');
                                            loadNewsArticles(); // Reload the list
                                        } else {
                                            alert('Error deleting news article: ' + data.message);
                                        }
                                    })
                                    .catch(error => console.error('Error:', error));
                            }
                        });
                    });

                } else {
                    existingNewsArticlesContainer.innerHTML = '<p style="text-align: center; color: #64748b;">No news articles found.</p>';
                }
            })
            .catch(error => {
                console.error('Error loading news articles:', error);
                existingNewsArticlesContainer.innerHTML = '<p style="text-align: center; color: #ef4444;">Failed to load news articles.</p>';
            });
    }

    // Events Calendar Management Functions
    const eventForm = document.getElementById('eventForm');
    const eventIdInput = document.getElementById('eventId');
    const eventTitleInput = document.getElementById('eventTitle');
    const eventDescriptionInput = document.getElementById('eventDescription');
    const eventLocationInput = document.getElementById('eventLocation');
    const eventDateInput = document.getElementById('eventDate');
    const eventTimeInput = document.getElementById('eventTime');
    const eventTypeSelect = document.getElementById('eventType');
    const eventCitySelect = document.getElementById('eventCity');
    const eventImageInput = document.getElementById('eventImage');
    const eventImagePreview = document.getElementById('eventImagePreview');
    const currentEventImageInput = document.getElementById('currentEventImage');
    const submitEventBtn = document.getElementById('submitEventBtn');
    const cancelEditBtn = document.getElementById('cancelEditBtn');

    function loadEvents() {
        fetch('admin_event_handler.php?action=fetch')
            .then(response => response.json())
            .then(data => {
                existingEventsContainer.innerHTML = ''; // Clear previous content
                if (data.success && data.events.length > 0) {
                    data.events.forEach(event => {
                        const eventItem = document.createElement('div');
                        eventItem.classList.add('event-item-admin');
                        eventItem.innerHTML = `
                                    <img src="${event.image_path || 'https://via.placeholder.com/80'}" alt="${event.title}" class="event-item-admin-image">
                                    <div class="event-item-admin-content">
                                        <h4 class="event-item-admin-title">${event.title}</h4>
                                        <p class="event-item-admin-details">${event.event_date} at ${event.event_time} (${event.location})</p>
                                        <p class="event-item-admin-desc">${event.description}</p>
                                    </div>
                                    <div class="event-item-admin-actions">
                                        <button class="edit-btn" data-id="${event.id}"><i class="fa-solid fa-pencil"></i></button>
                                        <button class="delete-btn" data-id="${event.id}"><i class="fa-solid fa-trash"></i></button>
                                    </div>
                                `;
                        existingEventsContainer.appendChild(eventItem);
                    });

                    document.querySelectorAll('#existingEvents .edit-btn').forEach(button => {
                        button.addEventListener('click', function () {
                            const eventId = this.getAttribute('data-id');
                            editEvent(eventId);
                        });
                    });

                    document.querySelectorAll('#existingEvents .delete-btn').forEach(button => {
                        button.addEventListener('click', function () {
                            const eventId = this.getAttribute('data-id');
                            if (confirm('Are you sure you want to delete this event?')) {
                                deleteEvent(eventId);
                            }
                        });
                    });

                } else {
                    existingEventsContainer.innerHTML = '<p style="text-align: center; color: #64748b;">No events found.</p>';
                }
            })
            .catch(error => {
                console.error('Error loading events:', error);
                existingEventsContainer.innerHTML = '<p style="text-align: center; color: #ef4444;">Failed to load events.</p>';
            });
    }

    function editEvent(id) {
        fetch(`admin_event_handler.php?action=fetch_single&id=${id}`)
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    const event = data.event;
                    eventIdInput.value = event.id;
                    eventTitleInput.value = event.title;
                    eventDescriptionInput.value = event.description;
                    eventLocationInput.value = event.location;
                    eventCitySelect.value = event.city;
                    eventDateInput.value = event.event_date;
                    eventTimeInput.value = event.event_time;
                    eventTypeSelect.value = event.type;
                    currentEventImageInput.value = event.image_path; // Store current image path

                    if (event.image_path) {
                        eventImagePreview.src = event.image_path;
                        eventImagePreview.style.display = 'block';
                    } else {
                        eventImagePreview.style.display = 'none';
                    }

                    submitEventBtn.textContent = 'Update Event';
                    submitEventBtn.name = 'action'; // Set name for form submission
                    submitEventBtn.value = 'edit'; // Set value for form submission
                    cancelEditBtn.style.display = 'inline-block';
                    eventForm.scrollIntoView({ behavior: 'smooth' });
                } else {
                    alert('Error fetching event for edit: ' + data.message);
                }
            })
            .catch(error => console.error('Error:', error));
    }

    function deleteEvent(id) {
        fetch('admin_event_handler.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: `action=delete&id=${id}`
        })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('Event deleted successfully!');
                    loadEvents(); // Reload the list
                } else {
                    alert('Error deleting event: ' + data.message);
                }
            })
            .catch(error => console.error('Error:', error));
    }

    // Event form submission
    if (eventForm) {
        eventForm.addEventListener('submit', function (e) {
            e.preventDefault();
            const formData = new FormData(this);

            // Determine action based on whether eventId is set
            if (eventIdInput.value) {
                formData.append('action', 'edit');
            } else {
                formData.append('action', 'add');
            }

            fetch(this.action, {
                method: 'POST',
                body: formData
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert('Event ' + (eventIdInput.value ? 'updated' : 'added') + ' successfully!');
                        eventForm.reset(); // Clear the form
                        eventIdInput.value = ''; // Clear hidden ID
                        currentEventImageInput.value = ''; // Clear current image path
                        eventImagePreview.style.display = 'none'; // Hide preview
                        submitEventBtn.textContent = 'Add Event';
                        submitEventBtn.name = ''; // Reset name
                        submitEventBtn.value = ''; // Reset value
                        cancelEditBtn.style.display = 'none';
                        loadEvents(); // Reload the list
                    } else {
                        alert('Error ' + (eventIdInput.value ? 'updating' : 'adding') + ' event: ' + data.message);
                    }
                })
                .catch(error => console.error('Error:', error));
        });
    }

    // Cancel Edit button functionality
    if (cancelEditBtn) {
        cancelEditBtn.addEventListener('click', function () {
            eventForm.reset();
            eventIdInput.value = '';
            currentEventImageInput.value = '';
            eventImagePreview.style.display = 'none';
            submitEventBtn.textContent = 'Add Event';
            submitEventBtn.name = '';
            submitEventBtn.value = '';
            cancelEditBtn.style.display = 'none';
        });
    }

    // Image preview for event form
    const deleteEventImageBtn = document.getElementById('deleteEventImageBtn');
    if (eventImageInput) {
        eventImageInput.addEventListener('change', function () {
            const statusSpan = document.getElementById('eventImageStatus');
            if (this.files && this.files[0]) {
                statusSpan.textContent = this.files[0].name;
                statusSpan.style.display = '';
                const reader = new FileReader();
                reader.onload = function (e) {
                    eventImagePreview.src = e.target.result;
                    eventImagePreview.style.display = 'block';
                };
                reader.readAsDataURL(this.files[0]);
                // Display the Delete image button
                if (deleteEventImageBtn) deleteEventImageBtn.style.display = 'inline-block';
            } else {
                statusSpan.textContent = 'No file selected.';
                statusSpan.style.display = '';
                if (statusSpan) statusSpan.style.display = '';
                eventImagePreview.src = '';
                eventImagePreview.style.display = 'none';
                // Hide the Delete image button
                if (deleteEventImageBtn) deleteEventImageBtn.style.display = 'none';
            }
        });
    }
    if (deleteEventImageBtn) {
        // Hide the Delete image button by default
        deleteEventImageBtn.style.display = 'none';
        deleteEventImageBtn.addEventListener('click', function () {
            eventImageInput.value = '';
            eventImagePreview.src = '';
            eventImagePreview.style.display = 'none';
            const statusSpan = document.getElementById('eventImageStatus');
            statusSpan.textContent = 'No file selected.';
            statusSpan.style.display = '';
            deleteEventImageBtn.style.display = 'none';
        })
    }

    // News image preview and delete functionality
    const newsImageInput = document.getElementById('newsImage');
    const newsImagePreview = document.getElementById('newsImagePreview');
    const newsImageStatus = document.getElementById('newsImageStatus');
    const deleteNewsImageBtn = document.getElementById('deleteNewsImageBtn');

    if (newsImageInput) {
        newsImageInput.addEventListener('change', function () {
            if (this.files && this.files[0]) {
                newsImageStatus.textContent = this.files[0].name;
                newsImageStatus.style.display = '';
                const reader = new FileReader();
                reader.onload = function (e) {
                    newsImagePreview.src = e.target.result;
                    newsImagePreview.style.display = 'block';
                };
                reader.readAsDataURL(this.files[0]);
                // Show the Delete button
                if (deleteNewsImageBtn) deleteNewsImageBtn.style.display = 'inline-block';
            } else {
                newsImageStatus.textContent = 'No file selected.';
                newsImagePreview.src = '';
                newsImagePreview.style.display = 'none';
                if (deleteNewsImageBtn) deleteNewsImageBtn.style.display = 'none';
            }
        });
    }

    if (deleteNewsImageBtn) {
        // Hide the Delete button by default
        deleteNewsImageBtn.style.display = 'none';
        deleteNewsImageBtn.addEventListener('click', function () {
            newsImageInput.value = '';
            newsImagePreview.src = '';
            newsImagePreview.style.display = 'none';
            newsImageStatus.textContent = 'No file selected.';
            newsImageStatus.style.display = '';
            deleteNewsImageBtn.style.display = 'none';
        });
    }

    // General Navigation Logic
    navItems.forEach(item => {
        item.addEventListener('click', function (e) {
            e.preventDefault();

            // Remove active class from all nav items
            navItems.forEach(nav => nav.classList.remove('active'));

            // Add active class to clicked item
            this.classList.add('active');

            // Get section ID
            const sectionId = this.getAttribute('data-section');

            // Update page title
            const sectionTitle = this.querySelector('span').textContent;
            pageTitle.textContent = sectionTitle;

            // Hide all content sections
            contentSections.forEach(section => section.classList.remove('active'));

            // Show selected section
            document.getElementById(sectionId).classList.add('active');

            // If the news section is active, load news articles
            if (sectionId === 'news') {
                loadNewsArticles();
            }
            // If the events section is active, load events
            if (sectionId === 'events') {
                loadEvents(); // <--- THIS IS THE CRUCIAL ADDITION
            }
            // If the sponsorships section is active, load sponsorships
            if (sectionId === 'sponsorships') {
                loadSponsorships();
            }
        });
    });

    // Handle form submission for adding news (existing code)
    const addNewsForm = document.getElementById('addNewsForm');
    if (addNewsForm) {
        addNewsForm.addEventListener('submit', function (e) {
            e.preventDefault();
            const formData = new FormData(this);
            formData.append('action', 'add'); // Add action for the handler

            fetch(this.action, {
                method: 'POST',
                body: formData
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert('News article added successfully!');
                        addNewsForm.reset(); // Clear the form
                        loadNewsArticles(); // Reload the list
                    } else {
                        alert('Error adding news article: ' + data.message);
                    }
                })
                .catch(error => console.error('Error:', error));
        });
    }

    // Search functionality (placeholder)
    const searchInput = document.querySelector('.search-input');
    searchInput.addEventListener('input', function (e) {
        console.log('Searching for:', e.target.value);
        // Implement search functionality here
    });

    // Initial load of content based on default active section
    // Check which section is initially active and load its data
    const initialActiveSection = document.querySelector('.content-section.active');
    if (initialActiveSection) {
        const sectionId = initialActiveSection.id;
        if (sectionId === 'news') {
            loadNewsArticles();
        } else if (sectionId === 'events') {
            loadEvents(); // <--- Also call on initial load if events is default
        }
    }
});

// Sponsorship image preview and delete functionality
const sponsorshipImageInput = document.getElementById('sponsorshipImage');
const sponsorshipImagePreview = document.getElementById('sponsorshipImagePreview');
const sponsorshipImageStatus = document.getElementById('sponsorshipImageStatus');
const deleteSponsorshipImageBtn = document.getElementById('deleteSponsorshipImageBtn');

if (sponsorshipImageInput) {
    sponsorshipImageInput.addEventListener('change', function () {
        if (this.files && this.files[0]) {
            sponsorshipImageStatus.textContent = this.files[0].name;
            sponsorshipImageStatus.style.display = '';
            const reader = new FileReader();
            reader.onload = function (e) {
                sponsorshipImagePreview.src = e.target.result;
                sponsorshipImagePreview.style.display = 'block';
            };
            reader.readAsDataURL(this.files[0]);
            // Show the Delete button
            if (deleteSponsorshipImageBtn) deleteSponsorshipImageBtn.style.display = 'inline-block';
        } else {
            sponsorshipImageStatus.textContent = 'No file selected.';
            sponsorshipImagePreview.src = '';
            sponsorshipImagePreview.style.display = 'none';
            if (deleteSponsorshipImageBtn) deleteSponsorshipImageBtn.style.display = 'none';
        }
    });
}

if (deleteSponsorshipImageBtn) {
    // Hide the Delete button by default
    deleteSponsorshipImageBtn.style.display = 'none';
    deleteSponsorshipImageBtn.addEventListener('click', function () {
        sponsorshipImageInput.value = '';
        sponsorshipImagePreview.src = '';
        sponsorshipImagePreview.style.display = 'none';
        sponsorshipImageStatus.textContent = 'No file selected.';
        sponsorshipImageStatus.style.display = '';
        deleteSponsorshipImageBtn.style.display = 'none';
    });
}

// Sponsorship Management Functions
function loadSponsorships() {
    const sponsorshipsContainer = document.getElementById('currentSponsorship');
    sponsorshipsContainer.innerHTML = '<p style="text-align: center; color: #64748b;">Loading sponsorships...</p>';

    fetch('admin_sponsorship_handler.php?action=fetch')
        .then(response => response.json())
        .then(data => {
            sponsorshipsContainer.innerHTML = ''; // Clear previous content
            if (data.success && data.sponsorships.length > 0) {
                data.sponsorships.forEach(sponsor => {
                    const sponsorshipItem = document.createElement('div');
                    sponsorshipItem.classList.add('sponsorship-item-admin');
                    sponsorshipItem.innerHTML = `
                                <img src="${sponsor.image_path}" alt="${sponsor.type}" class="sponsorship-item-admin-image">
                                <div class="sponsorship-item-admin-content">
                                    <h4 class="sponsorship-item-admin-title">${sponsor.type}</h4>
                                </div>
                                <div class="news-item-admin-actions">
                                    <button class="edit-btn" data-id="${sponsor.id}"><i class="fa-solid fa-pencil"></i></button>
                                    <button class="delete-btn" data-id="${sponsor.id}"><i class="fa-solid fa-trash"></i></button>
                                </div>
                            `;
                    sponsorshipsContainer.appendChild(sponsorshipItem);
                });

                // Attach event listeners for edit and delete buttons
                document.querySelectorAll('#currentSponsorship .edit-btn').forEach(button => {
                    button.addEventListener('click', function () {
                        const sponsorshipId = this.getAttribute('data-id');
                        // Implement edit functionality here
                        alert('Edit sponsorship with ID: ' + sponsorshipId);
                    });
                });

                document.querySelectorAll('#currentSponsorship .delete-btn').forEach(button => {
                    button.addEventListener('click', function () {
                        const sponsorshipId = this.getAttribute('data-id');
                        if (confirm('Are you sure you want to delete this sponsorship?')) {
                            fetch('admin_sponsorship_handler.php', {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/x-www-form-urlencoded',
                                },
                                body: `action=delete&id=${sponsorshipId}`
                            })
                                .then(response => response.json())
                                .then(data => {
                                    if (data.success) {
                                        alert('Sponsorship deleted successfully!');
                                        loadSponsorships(); // Reload the list
                                    } else {
                                        alert('Error deleting sponsorship: ' + data.message);
                                    }
                                })
                                .catch(error => console.error('Error:', error));
                        }
                    });
                });

            } else {
                sponsorshipsContainer.innerHTML = '<p style="text-align: center; color: #64748b;">No sponsorships found.</p>';
            }
        })
        .catch(error => {
            console.error('Error loading sponsorships:', error);
            sponsorshipsContainer.innerHTML = '<p style="text-align: center; color: #ef4444;">Failed to load sponsorships.</p>';
        });
}

// Album Edit Modal Logic
document.addEventListener('DOMContentLoaded', function () {
    // Get modal and close button
    const albumModal = document.getElementById('galphoto-modal-album');
    const albumModalClose = document.getElementById('galphoto-modal-album-close');

    // Listen for all edit buttons in the gallery-admin-action
    document.querySelectorAll('.gallery-admin-action .edit-btn').forEach(btn => {
        btn.addEventListener('click', function (e) {
            e.preventDefault();
            // Show the modal (use flex for centering)
            albumModal.style.display = 'flex';
        });
    });

    // Close modal on close icon click
    if (albumModalClose) {
        albumModalClose.addEventListener('click', function () {
            albumModal.style.display = 'none';
        });
    }

    // Optional: Close modal when clicking outside the modal content
    albumModal.addEventListener('click', function (e) {
        if (e.target === albumModal) {
            albumModal.style.display = 'none';
        }
    });
});

// Album Delete Modal Logic with 5s Countdown
document.addEventListener('DOMContentLoaded', function () {
    const deleteModal = document.getElementById('gallery-modal-delete-album');
    const deleteModalClose = document.getElementById('gallery-modal-album-close');
    const deleteBtn = document.getElementById('deleteGalleryAlbum');
    const gmacDesc = deleteModal.querySelector('.gmac-desc');
    let originalDeleteText = deleteBtn ? deleteBtn.textContent : 'Delete';
    let delayTimeout = null;
    let countdownInterval = null;

    document.querySelectorAll('.gallery-admin-action .delete-btn').forEach(btn => {
        btn.addEventListener('click', function (e) {
            e.preventDefault();
            deleteModal.style.display = 'flex';

            // Find the countdown <p> (assumes it's the second <p> in .gmac-desc)
            const countdownMsg = gmacDesc.querySelectorAll('p')[1];
            let countdown = 5;
            countdownMsg.textContent = `The delete button will be available in ${countdown} second(s).`;

            // Start 5s delay for delete button
            deleteBtn.disabled = true;
            deleteBtn.classList.add('disabled-delay');
            deleteBtn.textContent = originalDeleteText;

            // Live countdown
            countdownInterval = setInterval(() => {
                countdown--;
                if (countdown > 0) {
                    countdownMsg.textContent = `The delete button will be available in ${countdown} second(s).`;
                } else {
                    clearInterval(countdownInterval);
                    countdownMsg.textContent = "The delete button is now available.";
                }
            }, 1000);

            // Remove disabled state after 5s
            delayTimeout = setTimeout(() => {
                deleteBtn.disabled = false;
                deleteBtn.classList.remove('disabled-delay');
            }, 5000);
        });
    });

    function closeDeleteModal() {
        deleteModal.style.display = 'none';
        deleteBtn.disabled = false;
        deleteBtn.classList.remove('disabled-delay');
        deleteBtn.textContent = originalDeleteText;
        if (delayTimeout) clearTimeout(delayTimeout);
        if (countdownInterval) clearInterval(countdownInterval);
        // Reset message for next open
        const countdownMsg = gmacDesc.querySelectorAll('p')[1];
        countdownMsg.textContent = "The delete button will be available in 5 second(s).";
    }

    if (deleteModalClose) {
        deleteModalClose.addEventListener('click', closeDeleteModal);
    }

    deleteModal.addEventListener('click', function (e) {
        if (e.target === deleteModal) {
            closeDeleteModal();
        }
    });
});

// Edit each Photos Modal Logic
document.addEventListener('DOMContentLoaded', function () {
    // Get modal and close button
    const photoModal = document.getElementById('galphoto-modal');
    const photoModalClose = document.getElementById('galphoto-modal-close');
    const photoModalImage = document.getElementById('galphoto-modal-image');
    const photoModalTitle = document.getElementById('galphoto-modal-title');
    const photoModalFilename = document.getElementById('galphoto-modal-filename');

    // Listen for all photo cards (Photos only, not Videos)
    document.querySelectorAll('.gallery-admin-grid .gallery-admin-card.photos').forEach(card => {
        card.addEventListener('click', function () {
            // Get image and filename/title from the card
            const img = card.querySelector('img');
            if (img) {
                photoModalImage.src = img.src;
                photoModalImage.alt = img.alt || 'Image Preview';
                // You can customize how you get the title/filename
                photoModalTitle.textContent = 'File Name:';
                photoModalFilename.textContent = img.src.split('/').pop();
            }
            // Show the modal
            photoModal.style.display = 'flex';
        });
    });

    // Close modal on close icon click
    if (photoModalClose) {
        photoModalClose.addEventListener('click', function () {
            photoModal.style.display = 'none';
        });
    }

    // Optional: Close modal when clicking outside the modal content
    photoModal.addEventListener('click', function (e) {
        if (e.target === photoModal) {
            photoModal.style.display = 'none';
        }
    });
});

// Edit each Video Modal Logic
document.addEventListener('DOMContentLoaded', function () {
    // Get modal and close button
    const videoModal = document.getElementById('galvideo-modal');
    const videoModalClose = document.getElementById('galvideo-modal-close');
    const videoModalImage = document.getElementById('galvideo-modal-image');
    const videoTitleInput = document.getElementById('galleryVideoTitleEdit');
    const videoDescInput = document.getElementById('galleryVideoDescEdit');
    const videoAlbumSelect = document.getElementById('galleryVideoAlbumEdit');

    // Listen for all video cards (Videos only)
    document.querySelectorAll('.gallery-admin-grid .gallery-admin-card.videos').forEach(card => {
        card.addEventListener('click', function () {
            // Get image and title from the card
            const img = card.querySelector('img');
            const hoverTitle = card.querySelector('.gac-hover p');
            if (img) {
                videoModalImage.src = img.src;
                videoModalImage.alt = img.alt || 'Video Thumbnail';
            }
            if (hoverTitle) {
                videoTitleInput.value = hoverTitle.textContent.trim();
            } else {
                videoTitleInput.value = '';
            }
            // Optionally set description and album if you store them in data attributes
            // videoDescInput.value = card.dataset.desc || '';
            // videoAlbumSelect.value = card.dataset.album || '';

            // Show the modal
            videoModal.style.display = 'flex';
        });
    });

    // Close modal on close icon click
    if (videoModalClose) {
        videoModalClose.addEventListener('click', function () {
            videoModal.style.display = 'none';
        });
    }

    // Optional: Close modal when clicking outside the modal content
    videoModal.addEventListener('click', function (e) {
        if (e.target === videoModal) {
            videoModal.style.display = 'none';
        }
    });

    // Play and Change Video Cover logic
    document.querySelectorAll('.galvideo-form-group.cover').forEach(group => {
        const playBtn = group.querySelector('.gvmfg-options .play-btn');
        const changeBtn = group.querySelector('.gvmfg-options .change-btn');
        const videoCoverInput = document.getElementById('galleryVideoImage');
        const videoModalImage = group.querySelector('.galvideo-modal-image');

        // Play button: open video file path in new tab
        if (playBtn && videoModalImage) {
            playBtn.addEventListener('click', function (e) {
                e.preventDefault();
                // You may want to store the video file path in a data attribute on the image or elsewhere
                const videoPath = videoModalImage.getAttribute('data-video-path');
                if (videoPath) {
                    window.open(videoPath, '_blank');
                } else {
                    alert('Video file path not set.');
                }
            });
        }

        // Change Video Cover button: trigger file input
        if (changeBtn && videoCoverInput) {
            changeBtn.addEventListener('click', function (e) {
                e.preventDefault();
                videoCoverInput.click();
            });
        }
    });
});

// Photo Management functionality
function loadPublishedPhotos() {
    const container = document.getElementById('publishedGalleryPhoto');
    if (!container) return;

    container.innerHTML = '<p style="text-align: center; color: #64748b; padding: 24px 0;">Loading photo collections...</p>';

    fetch('admin_gallery_photo_handler.php?action=fetch_collections')
        .then(r => r.json())
        .then(d => {
            if (!d.success || !d.collections || d.collections.length === 0) {
                container.innerHTML = '<p style="text-align: center; color: #64748b; padding: 24px 0;">No photo collections found.</p>';
                return;
            }

            const tasks = d.collections.map(col => {
                return fetch(`admin_gallery_photo_handler.php?action=fetch_items&collection_id=${col.id}`)
                    .then(r => r.json())
                    .then(items => {
                        if (!items.success || !items.photos || items.photos.length === 0) {
                            return null;
                        }

                        const wrap = document.createElement('div');
                        wrap.className = 'gallery-admin-category';
                        wrap.innerHTML = `
                            <div class="gallery-admin-info">
                                <div class="desc">
                                    <h3>${col.name}</h3>
                                    <p>${col.description || ''}</p>
                                </div>
                                <div class="gallery-admin-action">
                                    <button type="button" class="edit-btn"><i class="fa-solid fa-pencil"></i></button>
                                    <button type="button" class="delete-btn"><i class="fa-solid fa-trash"></i></button>
                                </div>
                            </div>
                            <div class="gallery-admin-grid">
                                ${items.photos.map(p => `
                                    <div class="gallery-admin-card photos">
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

                // Rebind photo modal & album edit/delete buttons
                bindPhotoAdminCardHandlers();
            });
        })
        .catch(err => {
            console.error('Error loading published photos:', err);
            container.innerHTML = '<p style="text-align: center; color: #ef4444; padding: 24px 0;">Failed to load photo collections.</p>';
        });
}

// Rebind handlers for cards and gallery-admin-action buttons
function bindPhotoAdminCardHandlers() {
    const photoModal = document.getElementById('galphoto-modal');
    const photoModalClose = document.getElementById('galphoto-modal-close');
    const photoModalImage = document.getElementById('galphoto-modal-image');
    const photoModalTitle = document.getElementById('galphoto-modal-title');
    const photoModalFilename = document.getElementById('galphoto-modal-filename');

    // card click -> open view modal
    document.querySelectorAll('.gallery-admin-grid .gallery-admin-card.photos').forEach(card => {
        card.onclick = function () {
            const img = this.querySelector('img');
            if (!img) return;
            photoModalImage.src = img.src;
            photoModalImage.alt = img.alt || 'Image Preview';
            photoModalTitle.textContent = 'File Name:';
            photoModalFilename.textContent = img.src.split('/').pop();
            photoModal.style.display = 'flex';
        };
    });

    if (photoModal && photoModalClose) {
        photoModalClose.onclick = () => photoModal.style.display = 'none';
        photoModal.onclick = e => { if (e.target === photoModal) photoModal.style.display = 'none'; };
    }

    // album edit/delete buttons will open your existing modals (you already have global listeners)
}

// Call once on DOM ready so admin sees data immediately
document.addEventListener('DOMContentLoaded', () => {
    loadPublishedPhotos();
});

// Also reload when Photos section is opened
document.addEventListener('DOMContentLoaded', () => {
    const navItems = document.querySelectorAll('.nav-item');
    navItems.forEach(item => {
        item.addEventListener('click', function () {
            const sectionId = this.getAttribute('data-section');
            if (sectionId === 'photos') {
                loadPublishedPhotos();
            }
        });
    });
});

// After successful photo upload, refresh list
// (augment your existing photo form submit handler)
document.addEventListener('DOMContentLoaded', () => {
    const form = document.getElementById('galleryPhoto');
    const preview = document.getElementById('galleryPhotoImagePreview');
    const statusSpan = document.getElementById('galleryPhotoImageStatus');
    const delBtn = document.getElementById('deleteGalleryPhotoImageBtn');

    if (imgInput) {
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
                preview.src = ''; preview.style.display = 'none';
                delBtn.style.display = 'none';
            }
        });
        delBtn.addEventListener('click', () => {
            imgInput.value = '';
            statusSpan.textContent = 'No file selected.';
            preview.src = ''; preview.style.display = 'none';
            delBtn.style.display = 'none';
        });
    }

    if (!form) return;

    form.addEventListener('submit', e => {
        e.preventDefault();
        const fd = new FormData(form);
        fd.append('action', 'add_photo');

        fetch('admin_gallery_photo_handler.php', {
            method: 'POST',
            body: fd
        })
            .then(r => r.json())
            .then(d => {
                alert(d.message || (d.success ? 'Uploaded' : 'Failed'));
                if (d.success) {
                    form.reset();
                    if (preview) preview.style.display = 'none';
                    if (statusSpan) statusSpan.textContent = 'No file selected.';
                    if (delBtn) delBtn.style.display = 'none';
                    loadPublishedPhotos(); // refresh list
                }
            });
    }, { once: false }); // keep existing behaviour
});

// Video Management functionality
document.addEventListener('DOMContentLoaded', () => {
    const form = document.getElementById('galleryVideo');
    const videoInput = document.getElementById('galleryVideo');
    const coverInput = document.getElementById('galleryVideoImage');
    const statusSpan = document.getElementById('galleryVideoStatus');
    const coverStatus = document.getElementById('galleryVideoImageStatus');
    const coverPreview = document.getElementById('galleryVideoImagePreview');
    const delVideoBtn = document.getElementById('deleteGalleryVideoBtn');
    const delCoverBtn = document.getElementById('deleteGalleryVideoImageBtn');
    const albumSelect = document.getElementById('galleryVideoAlbum');

    function loadCollections() {
        fetch('admin_gallery_video_handler.php?action=fetch_collections')
            .then(r => r.json())
            .then(d => {
                if (!d.success) return;
                albumSelect.innerHTML = '<option value="">Select Collection</option>';
                d.collections.forEach(c => {
                    const op = document.createElement('option');
                    op.value = c.name; op.textContent = c.name;
                    albumSelect.appendChild(op);
                });
            });
    }
    loadCollections();

    delVideoBtn.style.display = 'none';
    delCoverBtn.style.display = 'none';

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
            coverPreview.src = ''; coverPreview.style.display = 'none';
            delCoverBtn.style.display = 'none';
        }
    });

    delCoverBtn.addEventListener('click', () => {
        coverInput.value = '';
        coverStatus.textContent = 'No file selected.';
        coverPreview.src = ''; coverPreview.style.display = 'none';
        delCoverBtn.style.display = 'none';
    });

    if (form) {
        form.addEventListener('submit', e => {
            e.preventDefault();
            if (!videoInput.files[0] || !coverInput.files[0]) {
                alert('Video and cover required'); return;
            }
            const fd = new FormData(form);
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
                            form.reset();
                            coverPreview.style.display = 'none';
                            coverStatus.textContent = 'No file selected.';
                            delVideoBtn.style.display = 'none';
                            delCoverBtn.style.display = 'none';
                        }
                    } catch (e) { alert('Upload failed'); }
                }
            };
            xhr.open('POST', 'admin_gallery_video_handler.php', true);
            xhr.send(fd);
        });
    }
});

// Fetch photo collections
function populatePhotoCollections() {
    const select = document.getElementById('galleryPhotoAlbum');
    if (!select) return;

    fetch('../admin/admin_gallery_photo_handler.php?action=fetch_collections')
        .then(r => r.json())
        .then(d => {
            if (!d.success) {
                console.error(d.message);
                return;
            }
            select.innerHTML = '<option value="">Select Collection</option>';
            d.collections.forEach(col => {
                const opt = document.createElement('option');
                opt.value = col.name;   // name is what handler expects
                opt.textContent = col.name;
                select.appendChild(opt);
            });
        });
}

document.addEventListener('DOMContentLoaded', populatePhotoCollections);

// Fetch video collections
function populateVideoCollections() {
    fetch('../admin/admin_gallery_handler.php?action=fetch_video_collections')
        .then(res => res.json())
        .then(collections => {
            const select = document.getElementById('galleryVideoAlbum');
            if (select) {
                select.innerHTML = '<option value="">Select Collection</option>';
                collections.forEach(col => {
                    const option = document.createElement('option');
                    option.value = col.name;
                    option.textContent = col.name;
                    select.appendChild(option);
                });
            }
        });
}

// Initial load
populatePhotoCollections();
populateVideoCollections();