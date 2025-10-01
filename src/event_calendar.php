<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Events Calendar | Special Olympics Sarawak</title>
    <link rel="shortcut icon" href="../assets/images/master_logo_front.png">
    <link rel="stylesheet" href="../css/global-style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">


    <style>
        :root {
            --special-red: #e51f3a;
            --special-light-red: #ff6b7f;
            --special-dark-red: #c0102a;
            --special-white: #ffffff;
            --special-gray: #f5f5f5;
            --special-dark: #333333;
            --special-accent: #0091d1;
            /* Event Type */
            --event-special: #e51f3a;
            --event-training: #4caf50;
            --event-fundraiser: #9c27b0;
            --event-social: #ff9800;
            --event-ceremony: #607d8b;
            --event-meeting: #795548;
            --event-day-text: #ffffff;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 20px 0;
            background-color: var(--special-gray);
            color: var(--special-dark);
            overflow-y: auto;
        }

        .calendar-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 15px;
        }

        .calendar-title {
            text-align: center;
            color: var(--special-red);
            margin-bottom: 30px;
            font-weight: 700;
            font-size: 2.5rem;
        }

        .month-nav {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            background-color: var(--special-white);
            padding: 15px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }

        .month-title {
            font-size: 1.8rem;
            font-weight: 600;
            color: var(--special-red);
            margin: 0;
        }

        .nav-button {
            background-color: var(--special-red);
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .nav-button:hover {
            background-color: var(--special-dark-red);
        }

        .calendar-grid {
            display: grid;
            grid-template-columns: repeat(7, 1fr);
            gap: 10px;
            margin-bottom: 30px;
        }

        .day-header {
            font-weight: 700;
            text-align: center;
            padding: 10px;
            color: var(--special-red);
            background-color: var(--special-white);
            border-radius: 5px;
        }

        .calendar-day {
            background-color: var(--special-white);
            color: var(--special-red);
            border-radius: 5px;
            min-height: 100px;
            padding: 10px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
            position: relative;
            display: flex;
            flex-direction: column;
            gap: 5px;
        }

        .day-number {
            font-weight: 600;
            margin-bottom: 5px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        /* Container for the city icon */
        .day-number-img {
            display: flex;
            align-items: center; /* Center the image vertically inside the container */
            justify-content: center; /* Center the image horizontally inside the container */
            width: 24px; /* Container width */
            height: 24px; /* Container height */
            border-radius: 50%; /* Make the container circular */
            overflow: hidden; /* Ensure the image doesn't overflow the container */
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
            margin: 0 auto 0 12px; /* Margin next to the day number text */
            background-color: white; /* Optional: background color for the container */
        }

        /* Image inside the container */
        .day-number-img img {
            width: 80%;
            height: 80%;
        }

        .event {
            background-color: var(--special-accent);
            color: white;
            padding: 5px;
            border-radius: 4px;
            margin-bottom: 5px;
            font-size: 0.85rem;
            cursor: pointer;
            transition: all 0.3s ease;
            position: relative;
        }
        
        .event-tooltip {
            visibility: hidden;
            width: 200px;
            background-color: var(--special-dark);
            color: var(--special-white);
            text-align: center;
            border-radius: 6px;
            padding: 8px;
            position: absolute;
            z-index: 1;
            bottom: 125%;
            left: 50%;
            transform: translateX(-50%);
            opacity: 0;
            transition: opacity 0.3s;
        }
        
        .event:hover .event-tooltip {
            visibility: visible;
            opacity: 1;
        }

        .event:hover {
            background-color: #0077b3;
        }

        /* Event Type Legend */
        .event.special {
            background-color: var(--special-red);
            font-weight: 600;
        }

        .event.training {
            background-color: #4caf50;
            font-weight: 600;
        }

        .event.fundraiser {
            background-color: #9c27b0;
            font-weight: 600;
        }
        .event.social {
            background-color: #ff9800;
            font-weight: 600;
        }
        .event.meeting {
            background-color: #795548;
            font-weight: 600;
        }

        /* Remove background color from ceremony event (from previous update) */
        .event.ceremony {
            /* background-color: #607d8b; */
            background-color: transparent;
            color: inherit;
            font-weight: 600;
        }

        /* Add a new class for calendar-day backgrounds by event type */
        .calendar-day.bg-special {
            background-color: var(--special-red);
            color: white;
        }
        .calendar-day.bg-training {
            background-color: #4caf50;
            color: white;
        }
        .calendar-day.bg-fundraiser {
            background-color: #9c27b0;
            color: white;
        }
        .calendar-day.bg-social {
            background-color: #ff9800;
            color: white;
        }
        .calendar-day.bg-ceremony {
            /* Since ceremony event background is transparent, 
            you can choose a subtle background or keep transparent */
            background-color: rgba(96, 125, 139, 1); /* light transparent blue-grey */
            color: white;
        }
        .calendar-day.bg-meeting {
            background-color: #795548;
            color: white;
        }
        /* END */

        .empty-day {
            background-color: #f9f9f9;
        }

        .today {
            border: 2px solid var(--special-red);
        }

        .event-modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0,0,0,0.7);
            z-index: 1000;
            justify-content: center;
            align-items: center;
        }

        .modal-content {
            background-color: white;
            padding: 30px;
            border-radius: 8px;
            max-width: 500px;
            width: 90%;
            box-shadow: 0 5px 20px rgba(0,0,0,0.2);
            position: relative;
        }

        .modal-close {
            position: absolute;
            top: 16px;
            right: 28px;
            font-size: 2rem;
            cursor: pointer;
            color: var(--special-red);
        }

        .modal-image {
            width: 100%;
            height: 200px;
            object-fit: cover;
            border-radius: 5px;
            margin: 40px 0 15px 0;
        }

        .modal-title {
            color: var(--special-red);
            margin-top: 0;
            margin-bottom: 15px;
        }

        .modal-description {
            margin-bottom: 20px;
            line-height: 1.6;
        }

        .modal-details {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .detail-item {
            display: flex;
            align-items: center;
        }

        .detail-icon {
            margin-right: 10px;
            color: var(--special-red);
        }

        /* City Legend Icon Styling */
        .city-icon {
            width: 20px;
            height: 20px;
            margin-right: 12px;
            border-radius: 50%; /* To make it circular */
            object-fit: cover; /* Ensure image covers the area */
        }

        /* Event icon for desktop */
        .event-type-icon {
            width: 15px;
            height: 15px;
            border-radius: 50%;
            display: inline-block;
            margin-left: 5px;
            vertical-align: middle;
        }

        /* Icon image inside the container */
        .day-number-img .city-icon-in-day-number {
            width: 16px; /* Image width: 16px as requested */
            height: 16px; /* Image height: 16px as requested */
            border-radius: 50%; /* Keep circular shape */
            object-fit: cover; /* Ensure image fills the 16x16 area without distortion */
            /* No margin on the image itself—container handles positioning */
        }

        /* Mobile-specific styles */
        @media (max-width: 768px) {
            .calendar-grid {
                grid-template-columns: repeat(7, 1fr); /* Keep 7 columns for days */
                font-size: 0.8rem;
            }
            
            .month-title {
                font-size: 1.4rem;
            }

            .calendar-title {
                font-size: 2rem;
            }

            .day-header {
                font-size: 0.7rem; /* Smaller font for day headers */
                padding: 5px;
            }

            .calendar-day {
                min-height: 50px; /* Smaller height for mobile days */
                padding: 5px;
            }

            .day-number {
                font-size: 1.2rem;
                margin: auto;
                text-align: center;
            }

            .event {
                display: none;
            }

            /* Hide full day names and show simplified ones */
            .day-header span:not(.mobile-day-abbr) {
                display: none;
            }
            .mobile-day-abbr {
                display: inline;
            }

            /* Event type background for mobile */
            .event-type-mobile-bg {
                display: none;
            }
            .event-type-icon {
                display: none; /* Hide desktop event type icon on mobile */
            }
            /* Ensure city icon in day number is hidden on mobile */
            .day-number .city-icon-in-day-number {
                display: none;
            }
        }

        @media (max-width: 480px) {
            .calendar-grid {
                grid-template-columns: repeat(7, 1fr); /* Still 7 columns, but narrower */
            }

            .month-nav {
                flex-direction: column;
                gap: 15px;
            }
            .nav-button {
                width: 100%;
                padding: 10px 0;
            }
            .month-title {
                font-size: 1.2rem;
            }
            .calendar-title {
                font-size: 1.8rem;
            }
        }
    </style>
</head>
<body>

    <!-- Navigation Bar -->
    <script src="../scripts/components/header.js"></script>

    <!-- Social Media Bar (Loaded via JS) -->
    <script src="../scripts/components/socmed-bar.js"></script>

    <!-- Space for your existing header -->
    <div style="height: 80px;"></div>
    
    <div class="calendar-container">
        <h1 class="calendar-title">Special Olympics Events Calendar</h1>
        
        <div class="month-nav">
            <button class="nav-button" id="prev-month">Previous</button>
            <h2 class="month-title" id="current-month">Month Year</h2>
            <button class="nav-button" id="next-month">Next</button>
        </div>
        
        <div class="calendar-grid" id="calendar-grid">
            <!-- Days of week headers -->
            <div class="day-header"><span class="desktop-day-full">Sunday</span><span class="mobile-day-abbr" style="display:none;">S</span></div>
            <div class="day-header"><span class="desktop-day-full">Monday</span><span class="mobile-day-abbr" style="display:none;">M</span></div>
            <div class="day-header"><span class="desktop-day-full">Tuesday</span><span class="mobile-day-abbr" style="display:none;">T</span></div>
            <div class="day-header"><span class="desktop-day-full">Wednesday</span><span class="mobile-day-abbr" style="display:none;">W</span></div>
            <div class="day-header"><span class="desktop-day-full">Thursday</span><span class="mobile-day-abbr" style="display:none;">T</span></div>
            <div class="day-header"><span class="desktop-day-full">Friday</span><span class="mobile-day-abbr" style="display:none;">F</span></div>
            <div class="day-header"><span class="desktop-day-full">Saturday</span><span class="mobile-day-abbr" style="display:none;">S</span></div>
            
            <!-- Calendar days will be inserted here by JavaScript -->
        </div>

        <div class="event-legend" style="margin: 30px auto; max-width: 800px; background: white; padding: 25px; border-radius: 12px; box-shadow: 0 3px 10px rgba(0,0,0,0.1);">
            <h2 style="color: var(--special-red); text-align: center; margin-top: 0; margin-bottom: 20px; font-size: 1.8rem;">Event Type Legend</h2>
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 15px; justify-items: center;">
                <div style="display: flex; align-items: center; width: 100%; max-width: 200px; padding: 10px; background: #f9f9f9; border-radius: 6px;">
                    <div style="width: 20px; height: 20px; background: var(--special-red); border-radius: 50%; margin-right: 12px;"></div>
                    <span style="font-weight: 600;">Special Event</span>
                </div>
                <div style="display: flex; align-items: center; width: 100%; max-width: 200px; padding: 10px; background: #f9f9f9; border-radius: 6px;">
                    <div style="width: 20px; height: 20px; background: #4caf50; border-radius: 50%; margin-right: 12px;"></div>
                    <span style="font-weight: 600;">Training</span>
                </div>
                <div style="display: flex; align-items: center; width: 100%; max-width: 200px; padding: 10px; background: #f9f9f9; border-radius: 6px;">
                    <div style="width: 20px; height: 20px; background: #9c27b0; border-radius: 50%; margin-right: 12px;"></div>
                    <span style="font-weight: 600;">Fundraiser</span>
                </div>
                <div style="display: flex; align-items: center; width: 100%; max-width: 200px; padding: 10px; background: #f9f9f9; border-radius: 6px;">
                    <div style="width: 20px; height: 20px; background: #ff9800; border-radius: 50%; margin-right: 12px;"></div>
                    <span style="font-weight: 600;">Social</span>
                </div>
                <div style="display: flex; align-items: center; width: 100%; max-width: 200px; padding: 10px; background: #f9f9f9; border-radius: 6px;">
                    <div style="width: 20px; height: 20px; background: #607d8b; border-radius: 50%; margin-right: 12px;"></div>
                    <span style="font-weight: 600;">Ceremony</span>
                </div>
                <div style="display: flex; align-items: center; width: 100%; max-width: 200px; padding: 10px; background: #f9f9f9; border-radius: 6px;">
                    <div style="width: 20px; height: 20px; background: #795548; border-radius: 50%; margin-right: 12px;"></div>
                    <span style="font-weight: 600;">Meeting</span>
                </div>
            </div>
            <h2 style="color: var(--special-red); text-align: center; margin-top: 20px; margin-bottom: 20px; font-size: 1.8rem;">City Legend</h2>
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 15px; justify-items: center;">
                <div style="display: flex; align-items: center; width: 100%; max-width: 200px; padding: 10px; background: #f9f9f9; border-radius: 6px;">
                    <img src="../assets/icons/kuching-cat.png" alt="Kuching Cat Icon" class="city-icon">
                    <span style="font-weight: 600;">Kuching</span>
                </div>
                <div style="display: flex; align-items: center; width: 100%; max-width: 200px; padding: 10px; background: #f9f9f9; border-radius: 6px;">
                    <img src="../assets/icons/samarahan-hornbill.png" alt="Samarahan Hornbill icon" class="city-icon">
                    <span style="font-weight: 600;">Samarahan</span>
                </div>
                <div style="display: flex; align-items: center; width: 100%; max-width: 200px; padding: 10px; background: #f9f9f9; border-radius: 6px;">
                    <img src="../assets/icons/sibu-swan.png" alt="Sibu Swan Icon" class="city-icon">
                    <span style="font-weight: 600;">Sibu</span>
                </div>
                <div style="display: flex; align-items: center; width: 100%; max-width: 200px; padding: 10px; background: #f9f9f9; border-radius: 6px;">
                    <img src="../assets/icons/bintulu-stork.png" alt="Bintulu Stork Icon" class="city-icon">
                    <span style="font-weight: 600;">Bintulu</span>
                </div>
                <div style="display: flex; align-items: center; width: 100%; max-width: 200px; padding: 10px; background: #f9f9f9; border-radius: 6px;">
                    <img src="../assets/icons/miri-seahorse.png" alt="Miri Seahorse Icon" class="city-icon">
                    <span style="font-weight: 600;">Miri</span>
                </div>
            </div>
        </div>

        <div class="upcoming-events" style="margin-top: 40px; margin-bottom: 80px; background: white; padding: 20px; border-radius: 8px;">
            <h2 style="color: var(--special-red); margin-bottom: 20px; border-bottom: 2px solid var(--special-red); padding-bottom: 10px;">Upcoming Events</h2>
            <div id="highlighted-events-container" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); gap: 20px;">
                <!-- Highlighted events will be inserted here by JavaScript -->
            </div>
        </div>
    </div>
    
    <div class="event-modal" id="event-modal">
        <div class="modal-content">
            <span class="modal-close" id="modal-close"><i class="fa-solid fa-xmark"></i></span>
            <img src="https://storage.googleapis.com/workspace-0f70711f-8b4e-4d94-86f1-2a93ccde5887/image/fda553f6-b090-496c-9670-08e7fcc0bd24.png" alt="Group of Special Olympics athletes smiling and celebrating after a competition" class="modal-image" id="modal-image">
            <h3 class="modal-title" id="modal-title">Event Title</h3>
            <p class="modal-description" id="modal-description">Event description will appear here with all the details about the competition, venue, and participants.</p>
            <div class="modal-details">
                <div class="detail-item">
                    <span class="detail-icon"><i style="color: black; margin: 0 1px 0 1px;" class="fa-solid fa-calendar"></i></span>
                    <span id="modal-date">Date: Loading...</span>
                </div>
                <div class="detail-item">
                    <span class="detail-icon"><i style="color: black; margin: 0 2px 0 2px;" class="fa-solid fa-location-dot"></i></span>
                    <span id="modal-location">Location: Loading...</span>
                </div>
                <div class="detail-item">
                    <span class="detail-icon"><i style="color: black;" class="fa-solid fa-clock"></i></span>
                    <span id="modal-time">Time: Loading...</span>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Event Calendar Script -->
    <!-- <script src="../scripts/calendar-script.js"></script> -->

    <!-- Testing script for future calendar functionality -->
    <script>
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
                    image: 'https://www.theborneopost.com/newsimages/2025/05/kch-030525-dd-fatimah-702x336.jpg',
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
                    image: 'https://files.elfsightcdn.com/eafe4a4d-3436-495d-b748-5bdce62d911d/1116d1f4-7d86-4173-9c6e-d168403fbe05/Soccer.png',
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

                    // --- START MODIFICATION ---
                    // Find events for this specific day
                    const eventsOnThisDay = allEvents.filter(event =>
                        event.date.getDate() === day &&
                        event.date.getMonth() === currentDate.getMonth() &&
                        event.date.getFullYear() === currentDate.getFullYear()
                    );

                    if (eventsOnThisDay.length > 0) {
                        // Get the first event's type
                        const firstEventType = eventsOnThisDay[0].type;
                        // Add background class to calendar-day
                        dayElement.classList.add('bg-' + firstEventType);
                    }

                    // Add city icon to day number if there's an event with a city
                    if (eventsOnThisDay.length > 0 && !mediaQuery.matches) { // Only add city icon on desktop
                        const firstEventWithCity = eventsOnThisDay.find(event => event.city);
                        if (firstEventWithCity) {
                            const cityIcons = {
                                'Kuching': '../assets/icons/kuching-cat.png',
                                'Samarahan': '../assets/icons/samarahan-hornbill.png',
                                'Sibu': '../assets/icons/sibu-swan.png',
                                'Bintulu': '../assets/icons/bintulu-stork.png',
                                'Miri': '../assets/icons/miri-seahorse.png'
                            };
                            if (firstEventWithCity.city && cityIcons[firstEventWithCity.city]) {
                                // Create container for the icon
                                const dayNumberImgContainer = document.createElement('span');
                                dayNumberImgContainer.classList.add('day-number-img');

                                // Create the icon image
                                const cityIconImg = document.createElement('img');
                                cityIconImg.src = cityIcons[firstEventWithCity.city];
                                cityIconImg.alt = `${firstEventWithCity.city} icon`;
                                cityIconImg.classList.add('city-icon-in-day-number'); // Keep for additional styling if needed

                                // Append image to container
                                dayNumberImgContainer.appendChild(cityIconImg);

                                // Append container to day number
                                dayNumber.appendChild(dayNumberImgContainer);
                            }
                        }
                    }
                    // --- END MODIFICATION ---

                    dayElement.appendChild(dayNumber);

                    // Add events for this day
                    eventsOnThisDay.forEach(event => { // Use the filtered events
                        const eventElement = document.createElement('div');
                        eventElement.className = 'event ' + event.type;

                        let eventTypeMobileBg = '';
                        if (mediaQuery.matches) { // Mobile only event type background
                            eventTypeMobileBg = `<span class="event-type-mobile-bg" style="background-color: ${getEventColor(event.type)};">${event.type.charAt(0).toUpperCase() + event.type.slice(1)}</span>`;
                        }

                        // Hover in the calendar
                        eventElement.innerHTML = `
                                    ${event.title}
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
                    });

                    calendarGrid.appendChild(dayElement);
                }
            }

            // When a user clicks on an event in the calendar, open the modal with details
            function openEventModal(event) {
                document.getElementById('modal-title').textContent = event.title;
                document.getElementById('modal-description').textContent = event.description;
                const modalImage = document.getElementById('modal-image');
                //              Custom image || Placeholder image if none provided
                modalImage.src = event.image || "../assets/images/SOS_modalimage-default.png";
                modalImage.alt = `${event.title}: ${event.description.substring(0, 100)}`;
                document.getElementById('modal-date').textContent = 'Date: ' + event.date.toLocaleDateString('ms-MY', {
                    // weekday: 'long', year: 'numeric', month: 'long', day: 'numeric'
                    day: '2-digit', month: '2-digit', year: 'numeric'
                });
                document.getElementById('modal-location').textContent = 'Location: ' + event.location + ', ' + event.city;
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

            // Function to check if the device is mobile (not directly used here, but kept for context)
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
                                    <p>${event.description.length > 100 ? event.description.substring(0, 250) + '' : event.description}</p>
                                    <p><strong>Date:</strong> ${event.date.toLocaleDateString('ms-MY')}</p>
                                    <p><strong>Time:</strong> ${event.event_time}</p>
                                    <p><strong>Location:</strong> ${event.location}, ${event.city}</p>
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
    </script>

    <!-- Bottom Navigation -->
    <script src="../scripts/components/bottom-nav.js"></script>

    <!-- Site footer -->
    <script src="../scripts/components/site-footer.js"></script>

    <!-- Section Divider -->
    <div class="section-divider"></div>
    <script src="../scripts/script-prerelease.js"></script>
</body>
</html>