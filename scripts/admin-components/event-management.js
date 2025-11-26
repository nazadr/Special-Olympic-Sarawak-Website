document.addEventListener('DOMContentLoaded', function() {
    const existingEventsContainer = document.getElementById('existingEvents');
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
    const deleteEventImageBtn = document.getElementById('deleteEventImageBtn');

    // Load Events
    function loadEvents() {
        fetch('handler/admin_event_handler.php?action=fetch')
            .then(response => response.json())
            .then(data => {
                existingEventsContainer.innerHTML = '';
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

                    // Edit button
                    document.querySelectorAll('#existingEvents .edit-btn').forEach(button => {
                        button.addEventListener('click', function() {
                            const eventId = this.getAttribute('data-id');
                            editEvent(eventId);
                        });
                    });

                    // Delete button
                    document.querySelectorAll('#existingEvents .delete-btn').forEach(button => {
                        button.addEventListener('click', function() {
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

    // Edit Event
    function editEvent(id) {
        fetch(`handler/admin_event_handler.php?action=fetch_single&id=${id}`)
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
                    currentEventImageInput.value = event.image_path || '';
                    if (event.image_path) {
                        eventImagePreview.src = event.image_path;
                        eventImagePreview.style.display = 'block';
                    } else {
                        eventImagePreview.style.display = 'none';
                    }
                    submitEventBtn.textContent = 'Update Event';
                    submitEventBtn.name = 'action';
                    submitEventBtn.value = 'edit';
                    cancelEditBtn.style.display = 'inline-block';
                    eventForm.scrollIntoView({ behavior: 'smooth' });
                } else {
                    alert('Error fetching event for edit: ' + data.message);
                }
            })
            .catch(error => console.error('Error:', error));
    }

    // Delete Event
    function deleteEvent(id) {
        fetch('handler/admin_event_handler.php', {
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
                loadEvents();
            } else {
                alert('Error deleting event: ' + data.message);
            }
        })
        .catch(error => console.error('Error:', error));
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
            fetch(this.action, {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('Event ' + (eventIdInput.value ? 'updated' : 'added') + ' successfully!');
                    eventForm.reset();
                    eventIdInput.value = '';
                    currentEventImageInput.value = '';
                    eventImagePreview.style.display = 'none';
                    submitEventBtn.textContent = 'Add Event';
                    submitEventBtn.name = '';
                    submitEventBtn.value = '';
                    cancelEditBtn.style.display = 'none';
                    loadEvents();
                } else {
                    alert('Error ' + (eventIdInput.value ? 'updating' : 'adding') + ' event: ' + data.message);
                }
            })
            .catch(error => console.error('Error:', error));
        });
    }

    // Cancel Edit button
    if (cancelEditBtn) {
        cancelEditBtn.addEventListener('click', function() {
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
                statusSpan.textContent = 'No file selected.';
                statusSpan.style.display = '';
                eventImagePreview.src = '';
                eventImagePreview.style.display = 'none';
                if (deleteEventImageBtn) deleteEventImageBtn.style.display = 'none';
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
            statusSpan.textContent = 'No file selected.';
            statusSpan.style.display = '';
            deleteEventImageBtn.style.display = 'none';
        });
    }

    // Initial load
    loadEvents();
});