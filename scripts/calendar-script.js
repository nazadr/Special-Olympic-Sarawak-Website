// This is for event-calendar-test.php

document.addEventListener('DOMContentLoaded', function () {
    const calendarGrid = document.getElementById('calendar-grid');
    const currentMonthElement = document.getElementById('current-month');
    const prevMonthButton = document.getElementById('prev-month');
    const nextMonthButton = document.getElementById('next-month');
    const eventModal = document.getElementById('event-modal');
    const modalClose = document.getElementById('modal-close');
    const highlightedEventsContainer = document.getElementById('highlighted-events-container');

    let currentDate = new Date();
    let allEvents = []; // Store all fetched events

    // Placeholder events
    const placeholderEvents = [
        {
            id: 'ph1',
            title: 'Special Olympics Sibu Opening Ceremony',
            description: 'Grand opening ceremony for the Special Olympics in Sibu, featuring athletes, officials, and local dignitaries.',
            event_date: '2025-10-11',
            event_time: '09:00 AM',
            location: 'Sibu Stadium',
            type: 'ceremony',
            city: 'Sibu',
        },
        {
            id: 'ph2',
            title: 'Football Training',
            description: 'Regular football training session for athletes in Kuching.',
            event_date: '2025-11-28',
            event_time: '04:00 PM',
            location: 'Kuching Community Field',
            type: 'training',
            city: 'Kuching',
        }
    ];

    // Function to fetch events from the database
    async function fetchEvents() {
        try {
            const response = await fetch('../admin/admin_event_handler.php?action=fetch');
            const data = await response.json();
            if (data.success) {
                // Convert event_date strings to Date objects
                const fetched = data.events.map(event => ({
                    ...event,
                    date: new Date(event.event_date + 'T00:00:00') // Ensure date is parsed correctly
                }));
                allEvents = [...fetched, ...placeholderEvents.map(event => ({
                    ...event,
                    date: new Date(event.event_date + 'T00:00:00')
                }))]; // Combine fetched and placeholder events
                renderCalendar();
                renderHighlightedEvents();
            } else {
                console.error('Failed to fetch events:', data.message);
                allEvents = placeholderEvents.map(event => ({
                    ...event,
                    date: new Date(event.event_date + 'T00:00:00')
                })); // Use only placeholders if fetch fails
                renderCalendar();
                renderHighlightedEvents();
            }
        } catch (error) {
            console.error('Error fetching events:', error);
            allEvents = placeholderEvents.map(event => ({
                ...event,
                date: new Date(event.event_date + 'T00:00:00')
            })); // Use only placeholders if error
            renderCalendar();
            renderHighlightedEvents();
        }
    }

    function renderCalendar() {
        // Set the month and year title
        currentMonthElement.textContent =
            currentDate.toLocaleString('default', { month: 'long' }) + ' ' + currentDate.getFullYear();

        // Clear the calendar (except for headers)
        while (calendarGrid.children.length > 7) {
            calendarGrid.removeChild(calendarGrid.lastChild);
        }

        // Update day headers for mobile
        const dayHeaders = calendarGrid.querySelectorAll('.day-header');
        const dayAbbreviations = ['S', 'M', 'T', 'W', 'T', 'F', 'S'];
        const mediaQuery = window.matchMedia('(max-width: 768px)');

        dayHeaders.forEach((header, index) => {
            const desktopSpan = header.querySelector('.desktop-day-full');
            const mobileSpan = header.querySelector('.mobile-day-abbr');
            if (mediaQuery.matches) {
                desktopSpan.style.display = 'none';
                mobileSpan.style.display = 'inline';
            } else {
                desktopSpan.style.display = 'inline';
                mobileSpan.style.display = 'none';
            }
        });

        const firstDayOfMonth = new Date(currentDate.getFullYear(), currentDate.getMonth(), 1);
        const lastDayOfMonth = new Date(currentDate.getFullYear(), currentDate.getMonth() + 1, 0);

        // Add empty cells for days of previous month
        const firstDayOfWeek = firstDayOfMonth.getDay();
        for (let i = 0; i < firstDayOfWeek; i++) {
            const emptyDay = document.createElement('div');
            emptyDay.className = 'calendar-day empty-day';
            calendarGrid.appendChild(emptyDay);
        }

        // Add cells for current month
        const today = new Date();
        today.setHours(0, 0, 0, 0); // Normalize today's date for comparison

        for (let day = 1; day <= lastDayOfMonth.getDate(); day++) {
            const dayElement = document.createElement('div');
            const dayDate = new Date(currentDate.getFullYear(), currentDate.getMonth(), day);
            dayDate.setHours(0, 0, 0, 0); // Normalize current day's date for comparison

            dayElement.className = 'calendar-day';
            if (dayDate.getTime() === today.getTime()) {
                dayElement.classList.add('today');
            }

            const dayNumber = document.createElement('div');
            dayNumber.className = 'day-number';
            dayNumber.textContent = day;
            dayElement.appendChild(dayNumber);

            // Add events for this day
            allEvents.forEach(event => {
                if (event.date.getDate() === day &&
                    event.date.getMonth() === currentDate.getMonth() &&
                    event.date.getFullYear() === currentDate.getFullYear()) {
                    const eventElement = document.createElement('div');
                    eventElement.className = 'event ' + event.type;

                    let cityIconHtml = '';
                    if (!mediaQuery.matches) { // Desktop only city icon
                        const cityIcons = {
                            'Kuching': '../assets/icons/kuching-cat.png',
                            'Samarahan': '../assets/icons/samarahan-hornbill.png',
                            'Sibu': '../assets/icons/sibu-swan.png',
                            'Bintulu': '../assets/icons/bintulu-stork.png',
                            'Miri': '../assets/icons/miri-seahorse.png'
                        };
                        if (event.city && cityIcons[event.city]) {
                            cityIconHtml = `<img src="${cityIcons[event.city]}" alt="${event.city} icon" class="event-type-icon" style="background-color: white;">`;
                        }
                    }

                    let eventTypeMobileBg = '';
                    if (mediaQuery.matches) { // Mobile only event type background
                        eventTypeMobileBg = `<span class="event-type-mobile-bg" style="background-color: ${getEventColor(event.type)};">${event.type.charAt(0).toUpperCase() + event.type.slice(1)}</span>`;
                    } else { // Desktop event type icon
                        eventTypeMobileBg = `<div class="event-type-icon" style="background-color: ${getEventColor(event.type)};"></div>`;
                    }

                    eventElement.innerHTML = `
                                ${event.title}
                                ${cityIconHtml}
                                ${eventTypeMobileBg}
                                <div class="event-tooltip">
                                    <strong>${event.title}</strong><br>
                                    Date: ${event.date.toLocaleDateString('ms-MY')}<br>
                                    Time: ${event.event_time}<br>
                                    Location: ${event.location}
                                </div>
                            `;
                    eventElement.addEventListener('click', () => openEventModal(event));
                    dayElement.appendChild(eventElement);
                }
            });

            calendarGrid.appendChild(dayElement);
        }
    }

    function openEventModal(event) {
        document.getElementById('modal-title').textContent = event.title;
        document.getElementById('modal-description').textContent = event.description;
        const modalImage = document.getElementById('modal-image');
        modalImage.src = event.image_path || "https://storage.googleapis.com/workspace-0f70711f-8b4e-4d94-86f1-2a93ccde5887/image/af9758c7-3554-4b27-b555-9af3834ecb92.png";
        modalImage.alt = `${event.title}: ${event.description.substring(0, 100)}`;
        document.getElementById('modal-date').textContent = 'Date: ' + event.date.toLocaleDateString('ms-MY', {
            // weekday: 'long', year: 'numeric', month: 'long', day: 'numeric'
            day: '2-digit', month: '2-digit', year: 'numeric'
        });
        document.getElementById('modal-location').textContent = 'Location: ' + event.location;
        document.getElementById('modal-time').textContent = 'Time: ' + event.event_time;
        eventModal.style.display = 'flex';
    }

    prevMonthButton.addEventListener('click', function () {
        currentDate = new Date(currentDate.getFullYear(), currentDate.getMonth() - 1, 1);
        renderCalendar();
    });

    nextMonthButton.addEventListener('click', function () {
        currentDate = new Date(currentDate.getFullYear(), currentDate.getMonth() + 1, 1);
        renderCalendar();
    });

    modalClose.addEventListener('click', function () {
        eventModal.style.display = 'none';
    });

    window.addEventListener('click', function (event) {
        if (event.target === eventModal) {
            eventModal.style.display = 'none';
        }
    });

    // Function to check if the device is mobile
    function isMobile() {
        return window.matchMedia('(max-width: 768px)').matches;
    }

    function renderHighlightedEvents() {
        highlightedEventsContainer.innerHTML = ''; // Clear previous content
        const today = new Date();
        today.setHours(0, 0, 0, 0); // Normalize today's date

        // Filter for upcoming events (today or in the future)
        const upcomingEvents = allEvents.filter(event => event.date >= today)
            .sort((a, b) => a.date - b.date) // Sort by date
            .slice(0, 5); // Show top 5 upcoming events

        if (upcomingEvents.length > 0) {
            upcomingEvents.forEach(event => {
                const eventElement = document.createElement('div');
                eventElement.style.padding = '15px';
                eventElement.style.borderRadius = '5px';
                eventElement.style.backgroundColor = getEventColor(event.type);
                eventElement.style.color = 'white';
                eventElement.style.cursor = 'pointer';

                eventElement.innerHTML = `
                            <h3 style="margin-top: 0;">${event.title}</h3>
                            <p><strong>Date:</strong> ${event.date.toLocaleDateString('ms-MY')}</p>
                            <p><strong>Time:</strong> ${event.event_time}</p>
                            <p><strong>Location:</strong> ${event.location}</p>
                        `;

                eventElement.addEventListener('click', () => openEventModal(event));
                highlightedEventsContainer.appendChild(eventElement);
            });
        } else {
            highlightedEventsContainer.innerHTML = '<p style="text-align: center; color: #64748b;">No upcoming events.</p>';
        }
    }

    function getEventColor(type) {
        const colors = {
            'special': 'var(--special-red)',
            'training': '#4caf50',
            'fundraiser': '#9c27b0',
            'social': '#ff9800',
            'ceremony': '#607d8b',
            'meeting': '#795548'
        };
        return colors[type] || 'var(--special-accent)';
    }

    // Initial load of events
    fetchEvents();

    // Listen for screen size changes to update day headers
    window.matchMedia('(max-width: 768px)').addEventListener('change', renderCalendar);
});