document.addEventListener('DOMContentLoaded', function() {
    // Simple base path for admin directory - since this JS is loaded from admin panel
    const basePath = './';
    
    // Initialize event management elements
    
    const existingEventsContainer = document.getElementById('existingEvents');
    const eventForm = document.getElementById('eventForm');
    const eventIdInput = document.getElementById('eventId');
    
    // Update form action with correct path
    if (eventForm) {
        const correctAction = `${basePath}handler/admin_event_handler.php`;
        eventForm.action = correctAction;
    }
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
    const deleteEventImageBtn = document.getElementById('deleteEventImageBtn');

    // Function to ensure Events Calendar section stays active
    function ensureEventsSection() {
        // Hide all content sections
        const contentSections = document.querySelectorAll('.content-section');
        contentSections.forEach(section => section.classList.remove('active'));
        
        // Show Events Calendar section
        const eventsSection = document.getElementById('events');
        if (eventsSection) eventsSection.classList.add('active');
        
        // Update navigation
        const navItems = document.querySelectorAll('.nav-item');
        navItems.forEach(nav => nav.classList.remove('active'));
        const eventsNavItem = document.querySelector('.nav-item[data-section="events"]');
        if (eventsNavItem) eventsNavItem.classList.add('active');
        
        // Update page title
        const pageTitle = document.querySelector('.page-title');
        if (pageTitle) pageTitle.textContent = 'Events Calendar';
    }

    // Global variables for filtering and view
    let allEvents = [];
    let currentView = 'grid';

    // Load Events
    function loadEvents() {
        const timestamp = new Date().getTime();
        const url = `${basePath}handler/admin_event_handler.php?action=fetch&t=${timestamp}`;
        fetch(url)
            .then(response => {
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                return response.json();
            })
            .then(data => {
                if (data.success && data.events.length > 0) {
                    allEvents = data.events;
                    updateStatistics();
                    renderEvents(allEvents);
                } else {
                    allEvents = [];
                    updateStatistics();
                    showEmptyState();
                }
            })
            .catch(error => {
                existingEventsContainer.innerHTML = `
                    <div class="events-empty-state">
                        <i class="fas fa-exclamation-triangle"></i>
                        <h4>Failed to Load Events</h4>
                        <p>${error.message}</p>
                    </div>
                `;
            });
    }

    // Update Statistics
    function updateStatistics() {
        const totalCount = allEvents.length;
        const specialCount = allEvents.filter(e => e.type === 'special').length;
        const trainingCount = allEvents.filter(e => e.type === 'training').length;
        
        // Count upcoming events (events in the future)
        const today = new Date();
        today.setHours(0, 0, 0, 0);
        const upcomingCount = allEvents.filter(e => {
            const eventDate = new Date(e.event_date);
            return eventDate >= today;
        }).length;

        document.getElementById('totalEventsCount').textContent = totalCount;
        document.getElementById('specialEventsCount').textContent = specialCount;
        document.getElementById('trainingEventsCount').textContent = trainingCount;
        document.getElementById('upcomingEventsCount').textContent = upcomingCount;
    }

    // Render Events
    function renderEvents(events) {
        existingEventsContainer.innerHTML = '';
        document.getElementById('displayedEventsCount').textContent = events.length;
        
        if (events.length === 0) {
            showEmptyState();
            return;
        }

        // Apply view class
        existingEventsContainer.className = currentView === 'grid' ? 'events-grid' : 'events-list';

        events.forEach(event => {
            const eventCard = createEventCard(event);
            existingEventsContainer.appendChild(eventCard);
        });

        // Attach event listeners
        attachEventListeners();
    }

    // Create Event Card
    function createEventCard(event) {
        const card = document.createElement('div');
        const imageSrc = event.image_path ? 
            (event.image_path.startsWith('../') ? event.image_path : '../' + event.image_path) : 
            'https://via.placeholder.com/400x200?text=No+Image';

        if (currentView === 'grid') {
            card.classList.add('event-card');
            card.innerHTML = `
                <img src="${imageSrc}" alt="${event.title}" class="event-card-image">
                <div class="event-card-content">
                    <div class="event-card-header">
                        <h4 class="event-card-title">${event.title}</h4>
                        <span class="event-type-badge event-type-${event.type}">${event.type}</span>
                    </div>
                    <div class="event-card-meta">
                        <div class="event-meta-item">
                            <i class="fas fa-calendar"></i>
                            <span>${formatDate(event.event_date)}</span>
                        </div>
                        <div class="event-meta-item">
                            <i class="fas fa-clock"></i>
                            <span>${event.event_time}</span>
                        </div>
                        <div class="event-meta-item">
                            <i class="fas fa-map-marker-alt"></i>
                            <span>${event.location}, ${event.city}</span>
                        </div>
                    </div>
                    <p class="event-card-description">${event.description}</p>
                    <div class="event-card-actions">
                        <button class="event-action-btn edit" data-id="${event.id}">
                            <i class="fas fa-edit"></i> Edit
                        </button>
                        <button class="event-action-btn delete" data-id="${event.id}">
                            <i class="fas fa-trash"></i> Delete
                        </button>
                    </div>
                </div>
            `;
        } else {
            card.classList.add('event-item');
            card.innerHTML = `
                <img src="${imageSrc}" alt="${event.title}" class="event-item-image">
                <div class="event-item-content">
                    <div class="event-item-header">
                        <h4 class="event-item-title">${event.title}</h4>
                        <span class="event-type-badge event-type-${event.type}">${event.type}</span>
                    </div>
                    <div class="event-item-meta">
                        <div class="event-meta-item">
                            <i class="fas fa-calendar"></i>
                            <span>${formatDate(event.event_date)}</span>
                        </div>
                        <div class="event-meta-item">
                            <i class="fas fa-clock"></i>
                            <span>${event.event_time}</span>
                        </div>
                        <div class="event-meta-item">
                            <i class="fas fa-map-marker-alt"></i>
                            <span>${event.location}, ${event.city}</span>
                        </div>
                    </div>
                    <p class="event-item-description">${event.description}</p>
                    <div class="event-item-actions">
                        <button class="event-action-btn edit" data-id="${event.id}">
                            <i class="fas fa-edit"></i> Edit
                        </button>
                        <button class="event-action-btn delete" data-id="${event.id}">
                            <i class="fas fa-trash"></i> Delete
                        </button>
                    </div>
                </div>
            `;
        }

        return card;
    }

    // Format Date
    function formatDate(dateString) {
        const date = new Date(dateString);
        const options = { year: 'numeric', month: 'short', day: 'numeric' };
        return date.toLocaleDateString('en-US', options);
    }

    // Show Empty State
    function showEmptyState() {
        existingEventsContainer.className = 'events-grid';
        existingEventsContainer.innerHTML = `
            <div class="events-empty-state">
                <i class="fas fa-calendar-times"></i>
                <h4>No Events Found</h4>
                <p>Start by adding your first event using the button above</p>
            </div>
        `;
    }

    // Attach Event Listeners
    function attachEventListeners() {
        document.querySelectorAll('.event-action-btn.edit').forEach(button => {
            button.addEventListener('click', function() {
                const eventId = this.getAttribute('data-id');
                editEvent(eventId);
            });
        });

        document.querySelectorAll('.event-action-btn.delete').forEach(button => {
            button.addEventListener('click', function() {
                const eventId = this.getAttribute('data-id');
                if (confirm('Are you sure you want to delete this event?')) {
                    deleteEvent(eventId);
                }
            });
        });
    }

    // Filter and Search Events
    function filterEvents() {
        const typeFilter = document.getElementById('filterEventType').value;
        const cityFilter = document.getElementById('filterEventCity').value;
        const sortOrder = document.getElementById('sortEvents').value;
        const searchTerm = document.getElementById('searchEvents').value.toLowerCase();

        let filtered = [...allEvents];

        // Apply type filter
        if (typeFilter !== 'all') {
            filtered = filtered.filter(e => e.type === typeFilter);
        }

        // Apply city filter
        if (cityFilter !== 'all') {
            filtered = filtered.filter(e => e.city === cityFilter);
        }

        // Apply search
        if (searchTerm) {
            filtered = filtered.filter(e => 
                e.title.toLowerCase().includes(searchTerm) ||
                e.description.toLowerCase().includes(searchTerm) ||
                e.location.toLowerCase().includes(searchTerm)
            );
        }

        // Apply sorting
        filtered.sort((a, b) => {
            switch(sortOrder) {
                case 'date_desc':
                    return new Date(b.event_date) - new Date(a.event_date);
                case 'date_asc':
                    return new Date(a.event_date) - new Date(b.event_date);
                case 'title_asc':
                    return a.title.localeCompare(b.title);
                case 'title_desc':
                    return b.title.localeCompare(a.title);
                default:
                    return 0;
            }
        });

        renderEvents(filtered);
    }

    // View Toggle
    document.querySelectorAll('.view-toggle-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            document.querySelectorAll('.view-toggle-btn').forEach(b => b.classList.remove('active'));
            this.classList.add('active');
            currentView = this.getAttribute('data-view');
            renderEvents(allEvents);
        });
    });

    // Filter and Search Listeners
    document.getElementById('filterEventType')?.addEventListener('change', filterEvents);
    document.getElementById('filterEventCity')?.addEventListener('change', filterEvents);
    document.getElementById('sortEvents')?.addEventListener('change', filterEvents);
    document.getElementById('searchEvents')?.addEventListener('input', filterEvents);


    // Edit Event
    function editEvent(id) {
        const timestamp = new Date().getTime();
        const url = `${basePath}handler/admin_event_handler.php?action=fetch_single&id=${id}&t=${timestamp}`;
        fetch(url)
            .then(response => {
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                return response.json();
            })
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
                    currentEventImageInput.value = event.image_path || '';
                    
                    // Reset file input to allow new file selection
                    eventImageInput.value = '';
                    
                    // Handle image preview and status
                    const statusSpan = document.getElementById('eventImageStatus');
                    if (event.image_path) {
                        eventImagePreview.src = event.image_path.startsWith('../') ? event.image_path : '../' + event.image_path;
                        eventImagePreview.style.display = 'block';
                        statusSpan.textContent = 'Current image loaded. Select new image to change.';
                        if (deleteEventImageBtn) deleteEventImageBtn.style.display = 'inline-block';
                    } else {
                        eventImagePreview.style.display = 'none';
                        statusSpan.textContent = 'No image uploaded. Select image to add.';
                        if (deleteEventImageBtn) deleteEventImageBtn.style.display = 'none';
                    }
                    
                    submitEventBtn.textContent = 'Update Event';
                    submitEventBtn.name = 'action';
                    submitEventBtn.value = 'edit';
                    cancelEditBtn.style.display = 'inline-block';
                    
                    // Open the modal directly
                    openEventModal();
                }
            })
            .catch(error => {
                // Error handled silently
            });
    }

    // Delete Event
    function deleteEvent(id) {
        const url = `${basePath}handler/admin_event_handler.php`;
        fetch(url, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: `action=delete&id=${id}`
        })
        .then(response => {
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            return response.json();
        })
        .then(data => {
            if (data.success) {
                loadEvents();
            }
        })
        .catch(error => {
            // Error handled silently
        });
    }

    // Event Form Submission
    if (eventForm) {
        eventForm.addEventListener('submit', function(e) {
            e.preventDefault();

            
            const formData = new FormData(this);
            if (eventIdInput.value) {
                formData.append('action', 'edit');
            } else {
                formData.append('action', 'add');
            }
            

            
            const submitUrl = `${basePath}handler/admin_event_handler.php`;
            fetch(submitUrl, {
                method: 'POST',
                body: formData
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                return response.text(); // Get text first to debug
            })
            .then(text => {

                try {
                    return JSON.parse(text);
                } catch (e) {
                    throw new Error('Invalid JSON response from server');
                }
            })
            .then(data => {
                if (data.success) {
                    // Close the modal first
                    closeEventModal();
                    
                    // Reset form and UI state
                    eventForm.reset();
                    eventIdInput.value = '';
                    currentEventImageInput.value = '';
                    eventImagePreview.style.display = 'none';
                    
                    // Reset image status and delete button
                    const statusSpan = document.getElementById('eventImageStatus');
                    if (statusSpan) statusSpan.textContent = 'No file selected.';
                    if (deleteEventImageBtn) deleteEventImageBtn.style.display = 'none';
                    
                    // Reset form state to "Add" mode
                    submitEventBtn.textContent = 'Add Event';
                    submitEventBtn.name = '';
                    submitEventBtn.value = '';
                    cancelEditBtn.style.display = 'none';
                    
                    // Reload events list after a brief delay
                    setTimeout(() => {
                        loadEvents();
                    }, 100);
                }
            })
            .catch(error => {
                // Error handled silently
            });
        });
    }

    // Cancel Edit button
    if (cancelEditBtn) {
        cancelEditBtn.addEventListener('click', function() {
            eventForm.reset();
            eventIdInput.value = '';
            currentEventImageInput.value = '';
            eventImagePreview.style.display = 'none';
            
            // Reset image status and delete button
            const statusSpan = document.getElementById('eventImageStatus');
            statusSpan.textContent = 'No file selected.';
            if (deleteEventImageBtn) deleteEventImageBtn.style.display = 'none';
            
            submitEventBtn.textContent = 'Add Event';
            submitEventBtn.name = '';
            submitEventBtn.value = '';
            cancelEditBtn.style.display = 'none';
            
            // Close the modal
            closeEventModal();
        });
    }

    // Image preview for event form
    if (eventImageInput) {
        eventImageInput.addEventListener('change', function() {
            const statusSpan = document.getElementById('eventImageStatus');
            if (this.files && this.files[0]) {
                statusSpan.textContent = this.files[0].name;
                statusSpan.style.display = '';
                const reader = new FileReader();
                reader.onload = function(e) {
                    eventImagePreview.src = e.target.result;
                    eventImagePreview.style.display = 'block';
                };
                reader.readAsDataURL(this.files[0]);
                if (deleteEventImageBtn) deleteEventImageBtn.style.display = 'inline-block';
            } else {
                // Check if we're in edit mode and have a current image
                if (currentEventImageInput.value) {
                    statusSpan.textContent = 'Current image loaded. Select new image to change.';
                    eventImagePreview.src = currentEventImageInput.value;
                    eventImagePreview.style.display = 'block';
                    if (deleteEventImageBtn) deleteEventImageBtn.style.display = 'inline-block';
                } else {
                    statusSpan.textContent = 'No file selected.';
                    statusSpan.style.display = '';
                    eventImagePreview.src = '';
                    eventImagePreview.style.display = 'none';
                    if (deleteEventImageBtn) deleteEventImageBtn.style.display = 'none';
                }
            }
        });
    }

    // Delete event image button
    if (deleteEventImageBtn) {
        deleteEventImageBtn.style.display = 'none';
        deleteEventImageBtn.addEventListener('click', function() {
            eventImageInput.value = '';
            eventImagePreview.src = '';
            eventImagePreview.style.display = 'none';
            const statusSpan = document.getElementById('eventImageStatus');
            
            // If we're in edit mode, also clear the current image reference
            if (currentEventImageInput.value) {
                currentEventImageInput.value = '';
                statusSpan.textContent = 'Image removed. Select new image to add.';
            } else {
                statusSpan.textContent = 'No file selected.';
            }
            statusSpan.style.display = '';
            deleteEventImageBtn.style.display = 'none';
        });
    }

    // Custom browse button handler
    const browseBtn = document.querySelector('label[for="eventImage"].custom-browse-btn');
    if (browseBtn && eventImageInput) {
        browseBtn.addEventListener('click', function() {
            eventImageInput.click();
        });
    }

    // Initial load
    loadEvents();
});