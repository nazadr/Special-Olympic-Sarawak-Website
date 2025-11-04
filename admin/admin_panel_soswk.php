<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel | Special Olympics Sarawak</title>
    <!-- White color logo of SO represents an admin -->
    <link rel="shortcut icon" href="../assets/images/master-logo-front-white.png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="../css/admin_style.css" rel="stylesheet">
    
    
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: #f8fafc;
            color: #1e293b;
            overflow-x: hidden;
        }

        /* Sidebar Styles */
        .sidebar {
            width: 280px;
            height: 100vh;
            /* background: linear-gradient(180deg, #1e40af 0%, #3b82f6 100%); */
            background: linear-gradient(180deg, #b71c1c 0%, #e53935 100%);
            position: fixed;
            left: 0;
            top: 0;
            z-index: 1000;
            transition: all 0.3s ease;
            box-shadow: 4px 0 20px rgba(0, 0, 0, 0.1);
            overflow-y: auto;
            scrollbar-width: none; /* Firefox */
        }
        .sidebar::-webkit-scrollbar {
            display: none; /* Chrome, Safari, Edge */
        }

        .sidebar-header {
            padding: 24px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            text-align: center;
        }

        .sidebar-logo {
            color: white;
            font-size: 20px;
            font-weight: 700;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }

        .sidebar-logo i {
            font-size: 24px;
        }

        .sidebar-nav {
            padding: 20px 0;
        }

        .nav-section {
            margin-bottom: 24px;
        }

        .nav-section-title {
            color: rgba(255, 255, 255, 0.7);
            font-size: 12px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            padding: 0 24px 8px;
        }

        .nav-item {
            display: flex;
            align-items: center;
            padding: 12px 24px;
            color: rgba(255, 255, 255, 0.9);
            text-decoration: none;
            transition: all 0.3s ease;
            position: relative;
            cursor: pointer;
        }

        .nav-item:hover {
            background: rgba(255, 255, 255, 0.1);
            color: white;
        }

        .nav-item.active {
            background: rgba(255, 255, 255, 0.2);
            color: white;
            border-right: 3px solid #fbbf24;
        }

        .nav-item i, .nav-item img {
            width: 20px;
            margin-right: 12px;
            font-size: 16px;
        }

        .nav-item span {
            font-size: 14px;
            font-weight: 500;
        }

        /* Main Content Styles */
        .main-container {
            margin-left: 280px;
            min-height: 100vh;
            transition: all 0.3s ease;
        }

        /* Header Styles */
        .header {
            background: white;
            padding: 16px 32px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            display: flex;
            align-items: center;
            justify-content: space-between;
            position: sticky;
            top: 0;
            z-index: 100;
        }

        .header-left {
            display: flex;
            align-items: center;
            gap: 24px;
        }

        .page-title {
            font-size: 24px;
            font-weight: 700;
            color: #1e293b;
        }

        .header-right {
            display: flex;
            align-items: center;
            gap: 16px;
        }

        .search-box {
            position: relative;
        }

        .search-input {
            padding: 8px 16px 8px 40px;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            font-size: 14px;
            width: 300px;
            transition: all 0.3s ease;
        }

        .search-input:focus {
            outline: none;
            border-color: #3b82f6;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
        }

        .search-icon {
            position: absolute;
            left: 12px;
            top: 50%;
            transform: translateY(-50%);
            color: #64748b;
        }

        .notification-btn {
            position: relative;
            padding: 8px;
            border: none;
            background: none;
            cursor: pointer;
            color: #64748b;
            transition: color 0.3s ease;
        }

        .notification-btn:hover {
            color: #3b82f6;
        }

        .notification-badge {
            position: absolute;
            top: 0;
            right: 0;
            width: 8px;
            height: 8px;
            background: #ef4444;
            border-radius: 50%;
        }

        .user-profile {
            display: flex;
            align-items: center;
            gap: 12px;
            cursor: pointer;
            padding: 8px;
            border-radius: 8px;
            transition: background 0.3s ease;
        }

        .user-profile:hover {
            background: #f1f5f9;
        }

        .user-avatar {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            background: #3b82f6;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 600;
        }

        .user-info {
            display: flex;
            flex-direction: column;
        }

        .user-name {
            font-size: 14px;
            font-weight: 600;
            color: #1e293b;
        }

        .user-role {
            font-size: 12px;
            color: #64748b;
        }

        /* Content Area Styles */
        .content-area {
            padding: 32px;
            min-height: calc(100vh - 80px);
        }

        .content-section {
            display: none;
            animation: fadeIn 0.3s ease;
        }

        .content-section.active {
            display: block;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .section-header {
            margin-bottom: 24px;
        }

        .section-title {
            font-size: 28px;
            font-weight: 700;
            color: #1e293b;
            margin-bottom: 8px;
        }

        .section-subtitle {
            font-size: 16px;
            color: #64748b;
        }

        .content-placeholder {
            background: white;
            border-radius: 12px;
            padding: 48px;
            text-align: center;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
            margin-bottom: 24px;
        }

        .content-placeholder i, .content-placeholder img {
            font-size: 48px;
            color: #cbd5e1;
            margin-bottom: 16px;
        }

        .content-placeholder h3 {
            font-size: 20px;
            font-weight: 600;
            color: #475569;
            margin-bottom: 8px;
        }

        .content-placeholder p {
            color: #64748b;
            font-size: 14px;
        }

        .custom-browse-btn {
            display: inline-block !important;
            padding: 10px 20px;
            background-color: white;
            border: 2px solid #e53935;
            border-radius: 99px;
            font-weight: 600 !important;
            text-align: center;
            cursor: pointer;
            transition: all 0.3s ease;
            margin-right: 12px;
        }

        .custom-browse-btn:hover {
            background-color: #e53935;
            color: white;
        }

        .custom-delete-btn {
            font-family: 'Inter', sans-serif;
            display: inline-block;
            padding: 12px 22px;
            background-color: #c41926;
            color: white;
            border: 0px rgba(0, 0, 0, 0);
            border-radius: 99px;
            font-weight: 600;
            text-align: center;
            cursor: pointer;
            transition: all 0.3s ease;
            margin-right: 12px;
        }

        .custom-delete-btn:hover {
            background-color: #e94e1b;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .sidebar {
                width: 240px;
                transform: translateX(-100%);
            }

            .sidebar.active {
                transform: translateX(0);
            }

            .main-container {
                margin-left: 0;
            }

            .header {
                padding: 16px;
            }

            .search-input {
                width: 200px;
            }
        }

        /* Custom Scrollbar */
        ::-webkit-scrollbar {
            width: 6px;
        }

        ::-webkit-scrollbar-track {
            background: #f1f5f9;
        }

        ::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 3px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: #94a3b8;
        }

         /* News Management Specific Styles */
        .news-management-container,
        .event-management-container,
        .sponsorship-management-container {
            background: white;
            border-radius: 12px;
            padding: 32px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        }

        .news-form-group,
        .event-form-group,
        .sponsorship-form-group {
            margin-bottom: 20px;
            text-align: left;
        }

        .news-form-group label,
        .event-form-group label,
        .sponsorship-form-group label {
            display: block;
            font-size: 14px;
            font-weight: 600;
            color: #334155;
            margin-bottom: 8px;
        }

        .news-form-group input[type="text"],
        .news-form-group input[type="date"],
        .news-form-group textarea,
        .event-form-group input[type="text"],
        .event-form-group input[type="date"],
        .event-form-group input[type="time"],
        .event-form-group textarea,
        .event-form-group select,
        .sponsorship-form-group select {
            width: 100%;
            padding: 10px 12px;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            font-size: 14px;
            color: #1e293b;
            transition: border-color 0.3s ease, box-shadow 0.3s ease;
        }

        .news-form-group input[type="text"]:focus,
        .news-form-group input[type="date"]:focus,
        .news-form-group textarea:focus,
        .event-form-group input[type="text"]:focus,
        .event-form-group input[type="date"]:focus,
        .event-form-group input[type="time"]:focus,
        .event-form-group textarea:focus,
        .event-form-group select:focus {
            outline: none;
            border-color: #3b82f6;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
        }

        .news-form-group textarea, .event-form-group textarea {
            min-height: 120px;
            resize: vertical;
        }

        .news-form-group input[type="file"], .event-form-group input[type="file"] {
            padding: 8px 0;
        }

        .news-submit-btn,
        .event-submit-btn,
        .sponsorship-submit-btn {
            font-family: 'Inter', sans-serif;
            background-color: #3b82f6;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 99px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .news-submit-btn:hover,
        .event-submit-btn:hover,
        .sponsorship-submit-btn:hover {
            background-color: #2563eb;
        }

        .news-list-admin,
        .event-list-admin,
        .sponsorship-list-admin {
            margin-top: 40px;
            border-top: 1px solid #e2e8f0;
            padding-top: 30px;
        }

        .news-item-admin,
        .event-item-admin,
        .sponsorship-item-admin {
            display: flex;
            align-items: center;
            gap: 20px;
            padding: 15px 0;
            border-bottom: 1px solid #f1f5f9;
        }

        .news-item-admin:last-child,
        .event-item-admin:last-child,
        .sponsorship-item-admin:last-child {
            border-bottom: none;
        }

        .news-item-admin-image,
        .event-item-admin-image,
        .sponsorship-item-admin-image {
            width: 80px;
            height: 80px;
            border-radius: 8px;
            object-fit: cover;
            flex-shrink: 0;
        }

        .news-item-admin-content,
        .event-item-admin-content,
        .sponsorship-item-admin-content {
            flex-grow: 1;
            text-align: left;
        }

        .news-item-admin-headline,
        .event-item-admin-title,
        .sponsorship-item-admin-title {
            font-size: 16px;
            font-weight: 600;
            color: #1e293b;
            margin-bottom: 4px;
        }

        .news-item-admin-date, .event-item-admin-details {
            font-size: 12px;
            color: #64748b;
            margin-bottom: 8px;
        }

        .news-item-admin-desc, .event-item-admin-desc {
            font-size: 14px;
            color: #475569;
            line-height: 1.5;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .news-item-admin-actions, .event-item-admin-actions {
            flex-shrink: 0;
            display: flex;
            gap: 10px;
        }

        .news-item-admin-actions button, .event-item-admin-actions button {
            padding: 8px 12px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-size: 14px;
            transition: background-color 0.3s ease;
        }

        .news-item-admin-actions .edit-btn, .event-item-admin-actions .edit-btn {
            background-color: #f0efff;
            color: #605bff;
            border-radius: 99px;
            padding: 10px 20px;
        }

        .news-item-admin-actions .edit-btn:hover, .event-item-admin-actions .edit-btn:hover {
            background-color: #605bff;
            color: #f0efff
        }

        .news-item-admin-actions .delete-btn, .event-item-admin-actions .delete-btn {
            background-color: #f0efff;
            color: #ef4444;
            border: 2px solid #ef4444;
            border-radius: 99px;
            padding: 8px 18px;
        }

        .news-item-admin-actions .delete-btn:hover, .event-item-admin-actions .delete-btn:hover {
            background-color: #dc2626;
            color: #f0efff;
            border: 0;
            padding: 10px 20px;
        }
    </style>
</head>
<body>
    <!-- Sidebar -->
    <aside class="sidebar">
        <div class="sidebar-header">
            <div class="sidebar-logo">
                <img src="../assets/images/so-sarawak-footer-2.png" style="width: auto; height: 60px;">
                <!-- <i class="fas fa-medal"></i> -->
                <!-- <span>Special Olympics</span> -->
            </div>
        </div>
        
        <nav class="sidebar-nav">
            <!-- Main Navigation -->
            <div class="nav-section">
                <div class="nav-section-title">Main</div>
                <a href="#" class="nav-item active" data-section="dashboard">
                    <i class="fas fa-tachometer-alt"></i>
                    <span>Dashboard</span>
                </a>
                <a href="#" class="nav-item" data-section="analytics">
                    <i class="fas fa-chart-line"></i>
                    <span>Analytics</span>
                </a>
            </div>

            <!-- Managements -->
            <div class="nav-section">
                <div class="nav-section-title">Managements</div>
                <a href="#" class="nav-item" data-section="events">
                    <i class="fas fa-calendar-alt"></i>
                    <span>Events Calendar</span>
                </a>
                <a href="#" class="nav-item" data-section="sports">
                    <i class="fa-solid fa-futbol"></i>
                    <span>Sports</span>
                </a>
                <a href="#" class="nav-item" data-section="athletes">
                    <i class="fas fa-users"></i>
                    <span>Athletes</span>
                </a>
                <a href="#" class="nav-item" data-section="volunteers">
                    <i class="fas fa-hands-helping"></i>
                    <span>Volunteers</span>
                </a>
                <a href="#" class="nav-item" data-section="coaches">
                    <i class="fas fa-user-tie"></i>
                    <span>Coaches</span>
                </a>
            </div>

            <!-- Articles -->
            <div class="nav-section">
                <div class="nav-section-title">Articles and Programs</div>
                <a href="#" class="nav-item" data-section="state-games">
                    <i class="fas fa-newspaper"></i>
                    <span>State Games</span>
                </a>
                <a href="#" class="nav-item" data-section="news">
                    <i class="fas fa-newspaper"></i>
                    <span>News</span>
                </a>
                <a href="#" class="nav-item" data-section="alp">
                    <i class="fas fa-newspaper"></i>
                    <span>Athlete Leadership</span>
                </a>
                <a href="#" class="nav-item" data-section="sohap">
                    <i class="fas fa-newspaper"></i>
                    <span>Healthy Athletes</span>
                </a>
                <a href="#" class="nav-item" data-section="yap">
                    <i class="fas fa-newspaper"></i>
                    <span>Young Athletes</span>
                </a>
            </div>

            <!-- Media -->
            <div class="nav-section">
                <div class="nav-section-title">Media</div>
                <a href="#" class="nav-item" data-section="photos">
                    <i class="fas fa-images"></i>
                    <span>Photos</span>
                </a>
                <a href="#" class="nav-item" data-section="videos">
                    <i class="fa-solid fa-video"></i>
                    <span>Videos</span>
                </a>
                <a href="#" class="nav-item" data-section="documents">
                    <i class="fas fa-file-alt"></i>
                    <span>Documents</span>
                </a>
            </div>

            <!-- Affiliates -->
            <div class="nav-section">
                <div class="nav-section-title">Affiliates</div>
                <a href="#" class="nav-item" data-section="sarawak-chapters">
                    <img src="../assets/icons/samarahan-hornbill.png" style="width: 16px; height: 16px; margin: 0 14px 0 2px; filter: invert(1);">
                    <span>Sarawak Chapters</span>
                </a>
                <a href="#" class="nav-item" data-section="sponsorships">
                    <i class="fa-solid fa-hand-holding-heart"></i>
                    <span>Sponsorships</span>
                </a>
                <a href="#" class="nav-item" data-section="program-partners">
                    <i class="fa-solid fa-handshake"></i>
                    <span>Program Partners</span>
                </a>
                <a href="#" class="nav-item" data-section="other-special-olympics">
                    <i class="fa-solid fa-globe"></i>
                    <span>Other Special Olympics</span>
                </a>
            </div>

            <!-- Settings -->
            <div class="nav-section">
                <div class="nav-section-title">Settings</div>
                <a href="#" class="nav-item" data-section="settings">
                    <i class="fas fa-cog"></i>
                    <span>Settings</span>
                </a>
                <a href="#" class="nav-item" data-section="profile">
                    <i class="fas fa-user"></i>
                    <span>Profile</span>
                </a>
            </div>
        </nav>
    </aside>

    <!-- Main Container -->
    <div class="main-container">
        <!-- Header -->
        <header class="header">
            <div class="header-left">
                <h1 class="page-title">Dashboard</h1>
            </div>
            
            <div class="header-right">
                <div class="search-box">
                    <i class="fas fa-search search-icon"></i>
                    <input type="text" class="search-input" placeholder="Search...">
                </div>
                
                <button class="notification-btn">
                    <i class="fas fa-bell"></i>
                    <span class="notification-badge"></span>
                </button>
                
                <div class="user-profile">
                    <div class="user-avatar">A</div>
                    <div class="user-info">
                        <span class="user-name">Admin User</span>
                        <span class="user-role">Administrator</span>
                    </div>
                </div>
            </div>
        </header>

        <!-- Content Area -->
        <main class="content-area">


            <!-- Dashboard Section -->
            <div class="content-section active" id="dashboard">
                <div class="section-header">
                    <h2 class="section-title">Dashboard Overview</h2>
                    <p class="section-subtitle">Welcome to Special Olympics Admin Panel</p>
                </div>
                
                <div class="content-placeholder">
                    <i class="fas fa-tachometer-alt"></i>
                    <h3>Dashboard Content</h3>
                    <p>Add your dashboard widgets and statistics here</p>
                    <div>
                        <p>Use this space to display key metrics, charts, and quick links to other sections.</p>
                        <ul>
                            
                        </ul>

                    </div>

                </div>
            </div>

            <!-- Analytics Section -->
            <div class="content-section" id="analytics">
                <div class="section-header">
                    <h2 class="section-title">Analytics</h2>
                    <p class="section-subtitle">View detailed analytics and reports</p>
                </div>
                
                <div class="content-placeholder">
                    <i class="fas fa-chart-line"></i>
                    <h3>Analytics Content</h3>
                    <p>Add your charts, graphs, and analytics data here</p>
                </div>
            </div>

            <!-- Events Section -->
            <div class="content-section" id="events">
                <div class="section-header">
                    <h2 class="section-title">Events Calendar Management</h2>
                    <p class="section-subtitle">Create and manage events calendar</p>
                </div>
                
                <div class="event-management-container">
                    <h3>Add/Edit Event Calendar</h3>
                    <form id="eventForm" action="../admin/admin_event_handler.php" method="POST" enctype="multipart/form-data">
                        <input type="hidden" id="eventId" name="id">
                        <input type="hidden" id="currentEventImage" name="currentImage">
                        <div class="event-form-group">
                            <label for="eventImage">Upload Image:</label>
                            <!-- <input type="file" id="eventImage" name="eventImage" accept="image/*"> <!-- Change the code here -->
                            <!-- New style for Browse & Delete Image button -->
                            <label for="eventImage" class="custom-browse-btn">Browse</label>
                            <input type="file" id="eventImage" name="eventImage" accept="image/*" style="display: none;">
                            <button type="button" id="deleteEventImageBtn" class="custom-delete-btn">Delete</button>
                            <span style="font-size: 14px;" id="eventImageStatus">No file selected.</span>
                            <img id="eventImagePreview" src="" alt="Event Image Preview" style="max-width: 100px; max-height: 100px; margin-top: 10px; display: none;">
                        </div>
                        <div class="event-form-group">
                            <label for="eventTitle">Title:</label>
                            <input style="font-family: 'Inter', sans-serif;" type="text" id="eventTitle" name="eventTitle" placeholder="Enter event title" required>
                        </div>
                        <div class="event-form-group">
                            <label for="eventDescription">Description:</label>
                            <textarea style="font-family: 'Inter', sans-serif;" id="eventDescription" name="eventDescription" placeholder="Enter event description" required></textarea>
                        </div>
                        <div class="event-form-group">
                            <label for="eventLocation">Location:</label>
                            <input style="font-family: 'Inter', sans-serif;" type="text" id="eventLocation" name="eventLocation" placeholder="Enter event location" required>
                        </div>
                        <div class="event-form-group">
                            <label for="eventCity">City:</label>
                            <select style="font-family: 'Inter', sans-serif;" id="eventCity" name="eventCity" required>
                                <option value="">Select City</option>
                                <option value="Bintulu">Bintulu</option>
                                <option value="Kuching">Kuching</option>
                                <option value="Miri">Miri</option>
                                <option value="Samarahan">Samarahan</option>
                                <option value="Sibu">Sibu</option>
                            </select>
                        </div>
                        <div class="event-form-group">
                            <label for="eventDate">Date:</label>
                            <input style="font-family: 'Inter', sans-serif;" type="date" id="eventDate" name="eventDate" required>
                        </div>
                        <div class="event-form-group">
                            <label for="eventTime">Time:</label>
                            <input style="font-family: 'Inter', sans-serif;" type="text" id="eventTime" name="eventTime" placeholder="e.g., 10:00 AM - 12:00 PM" required>
                        </div>
                        <div class="event-form-group">
                            <label for="eventType">Type:</label>
                            <select style="font-family: 'Inter', sans-serif;" id="eventType" name="eventType" required>
                                <option value="">Select Event Type</option>
                                <option value="special">Special Event</option>
                                <option value="training">Training</option>
                                <option value="fundraiser">Fundraiser</option>
                                <option value="social">Social</option>
                                <option value="ceremony">Ceremony</option>
                                <option value="meeting">Meeting</option>
                            </select>
                        </div>
                        <button type="submit" class="event-submit-btn" id="submitEventBtn">Add Event</button>
                        <button type="button" class="event-submit-btn" id="cancelEditBtn" style="display:none; background-color: #6c757d;">Cancel Edit</button>
                    </form>

                    <div class="event-list-admin">
                        <h3>Existing Events</h3>
                        <div id="existingEvents">
                            <!-- Events will be loaded here via AJAX -->
                            <p style="text-align: center; color: #64748b;">Loading events...</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sports Section -->
            <div class="content-section" id="sports">
                <div class="section-header">
                    <h2 class="section-title">Sports Management</h2>
                    <p class="section-subtitle">Manage sports in the Our Sports page.</p>
                </div>
                
                <div class="content-placeholder">
                    <i class="fa-solid fa-futbol"></i>
                    <h3>Our Sports</h3>
                    <p>Add your sports management interface here</p>
                </div>
            </div>

            <!-- Athletes Section -->
            <div class="content-section" id="athletes">
                <div class="section-header">
                    <h2 class="section-title">Athletes Management</h2>
                    <p class="section-subtitle">Manage athlete registrations and profiles</p>
                </div>
                
                <div class="content-placeholder">
                    <i class="fas fa-users"></i>
                    <h3>Athletes Content</h3>
                    <p>Add your athlete management interface here</p>
                </div>
            </div>

            <!-- Volunteers Section -->
            <div class="content-section" id="volunteers">
                <div class="section-header">
                    <h2 class="section-title">Volunteers Management</h2>
                    <p class="section-subtitle">Manage volunteer applications and schedules</p>
                </div>
                
                <div class="content-placeholder">
                    <i class="fas fa-hands-helping"></i>
                    <h3>Volunteers Content</h3>
                    <p>Add your volunteer management interface here</p>
                </div>
            </div>

            <!-- Coaches Section -->
            <div class="content-section" id="coaches">
                <div class="section-header">
                    <h2 class="section-title">Coaches Management</h2>
                    <p class="section-subtitle">Manage coach profiles and certifications</p>
                </div>
                
                <div class="content-placeholder">
                    <i class="fas fa-user-tie"></i>
                    <h3>Coaches Content</h3>
                    <p>Add your coach management interface here</p>
                </div>
            </div>

            <!-- State Games -->
            <div class="content-section" id="state-games">
                <div class="section-header">
                    <h2 class="section-title">State Games — Special Olympics Major Events Management</h2>
                    <p>Manage event articles on the State Games page content.</p>
                </div>

                <div class="content-placeholder">
                    <i class="fas fa-newspaper"></i>
                    <h3>State Games Event</h3>
                    <p>This section should allows admin to add and manage Special Olympics Major Events articles</p>
                </div>
            </div>

            <!-- News Section -->
            <div class="content-section" id="news">
                <div class="section-header">
                    <h2 class="section-title">News Management</h2>
                    <p class="section-subtitle">Create and manage news articles</p>
                </div>
                
                <div class="news-management-container">
                    <h3>Add New News Article</h3>
                    <form id="addNewsForm" action="../admin/admin_news_handler.php" method="POST" enctype="multipart/form-data">
                        <div class="news-form-group">
                            <label for="newsImage">Upload Image:</label>
                            <label for="newsImage" class="custom-browse-btn">Browse</label>
                            <input type="file" id="newsImage" name="newsImage" accept="image/*" style="display: none;">
                            <button type="button" id="deleteNewsImageBtn" class="custom-delete-btn">Delete</button>
                            <span style="font-size: 14px;" id="newsImageStatus">No file selected.</span>
                            <img id="newsImagePreview" src="" alt="News Image Preview" style="max-width: 100px; max-height: 100px; margin-top: 10px; display: none;">
                        </div>
                        <div class="news-form-group">
                            <label for="newsHeadline">Headline:</label>
                            <input style="font-family: 'Inter', sans-serif;" type="text" id="newsHeadline" name="newsHeadline" placeholder="Enter news headline" required>
                        </div>
                        <div class="news-form-group">
                            <label for="newsDate">Date:</label>
                            <input style="font-family: 'Inter', sans-serif;" type="date" id="newsDate" name="newsDate" required>
                        </div>
                        <div class="news-form-group">
                            <label for="newsDescription">Description:</label>
                            <textarea style="font-family: 'Inter', sans-serif;" id="newsDescription" name="newsDescription" placeholder="Enter news description" required></textarea>
                        </div>
                        <button type="submit" class="news-submit-btn">Add News</button>
                    </form>

                    <div class="news-list-admin">
                        <h3>Existing News Articles</h3>
                        <div id="existingNewsArticles">
                            <!-- News articles will be loaded here via AJAX -->
                            <p style="text-align: center; color: #64748b;">Loading news articles...</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Athlete Leaderships -->
            <div class="content-section" id="alp">
                <div class="section-header">
                    <h2 class="section-title">Athlete Leaderships Management</h2>
                    <p class="section-subtitle">Manage Athlete Leaderships Program (ALP) overview articles, resources and the "learn more" page.</p>
                </div>
                
                <div class="content-placeholder">
                    <i class="fas fa-newspaper"></i>
                    <h3>Athlete Leaderships Program</h3>
                    <p>Add your Athlete Leaaderships management interface here</p>
                </div>
            </div>

            <!-- Healthy Athletes -->
            <div class="content-section" id="sohap">
                <div class="section-header">
                    <h2 class="section-title">Healthy Athletes Management</h2>
                    <p class="section-subtitle">Manage Healthy Athletes Program (SOHAP) overview articles, resources and the "learn more" page.</p>
                </div>
                
                <div class="content-placeholder">
                    <i class="fas fa-newspaper"></i>
                    <h3>Healthy Athletes Program</h3>
                    <p>Add your Healthy Athletes management interface here</p>
                </div>
            </div>

            <!-- Young Athletes -->
            <div class="content-section" id="yap">
                <div class="section-header">
                    <h2 class="section-title">Young Athletes Management</h2>
                    <p class="section-subtitle">Manage Young Athletes Program (YAP) overview articles, resources and the "learn more" page.</p>
                </div>
                
                <div class="content-placeholder">
                    <i class="fas fa-newspaper"></i>
                    <h3>Young Athletes Program</h3>
                    <p>Add your Young Athletes management interface here</p>
                </div>
            </div>

            <!-- Documents Section -->
            <div class="content-section" id="documents">
                <div class="section-header">
                    <h2 class="section-title">Documents Management</h2>
                    <p class="section-subtitle">Upload and manage documents</p>
                </div>
                
                <div class="content-placeholder">
                    <i class="fas fa-file-alt"></i>
                    <h3>Documents Content</h3>
                    <p>Add your documents management interface here</p>
                </div>
            </div>

            <!-- Gallery/Photos Section -->
            <div class="content-section" id="photos">
                <div class="section-header">
                    <h2 class="section-title">Photo Management</h2>
                    <p class="section-subtitle">Upload and manage images</p>
                </div>
                
                <div class="content-placeholder">
                    <i class="fas fa-images"></i>
                    <h3>Photo Content</h3>
                    <p>Add your photo management interface here</p>
                </div>
            </div>

            <!-- Gallery/Videos Section -->
            <div class="content-section" id="videos">
                <div class="section-header">
                    <h2 class="section-title">Video Management</h2>
                    <p class="section-subtitle">Upload and manage videos</p>
                </div>
                
                <div class="content-placeholder">
                    <i class="fa-solid fa-video"></i>
                    <h3>Video Content</h3>
                    <p>Add your video management interface here</p>
                </div>
            </div>

            <!-- Sarawak Chapters -->
            <div class="content-section" id="sarawak-chapters">
                <div class="section-header">
                    <h2 class="section-title">Sarawak Chapters Management</h2>
                    <p class="section-subtitle">Manage Sarawak pinpoint hover informations (Our Chapters Across Sarawak) such as chairman, vice chairman, secretary and treasurer.</p>
                </div>
                
                <div class="content-placeholder">
                    <i class="fas fa-users"></i>
                    <h3>Sarawak Chapters</h3>
                    <p>Add your Sarawak Chapters management interface here</p>
                </div>
            </div>

            <!-- Sponsorships -->
            <div class="content-section" id="sponsorships">
                <div class="section-header">
                    <h2 class="section-title">Sponsorships Management</h2>
                    <p class="section-subtitle">Manage Special Olympics Sarawak sponsorships by just simply add, edit and remove an images.<br>*This sponsorships management interface is under development</p>
                </div>

                <div class="sponsorship-management-container">
                    <h3>Add/Edit Sponsorship Logo Brand</h3>
                    <form id="sponsorshipForm" action="../admin/admin_sponsorship_handler.php" method="POST" enctype="multipart/form-data">
                        <input type="hidden" id="sponsorshipId" name="id">
                        <input type="hidden" id="currentSponsorshipImage" name="currentImage">
                        <div class="sponsorship-form-group">
                            <label for="sponsorshipImage">Upload Image:</label>
                            <label for="sponsorshipImage" class="custom-browse-btn">Browse</label>
                            <input type="file" id="sponsorshipImage" name="sponsorshipImage" accept="image/*" style="display: none;">
                            <button type="button" id="deleteSponsorshipImageBtn" class="custom-delete-btn">Delete</button>
                            <span style="font-size: 14px;" id="sponsorshipImageStatus">No file selected.</span>
                            <img id="sponsorshipImagePreview" src="" alt="Sponsorship Image Preview" style="max-width: 100px; max-height: 100px; margin-top: 10px; display: none;">
                        </div>
                        <div class="sponsorship-form-group">
                            <label for="sponsorshipChapter">Sponsorship Type:</label>
                            <select style="font-family: 'Inter', sans-serif;" id="sponsorshipChapter" name="sponsorshipChapter" required>
                                <option value="Special Olympics Sarawak">Special Olympics Sarawak</option>
                                <option value="Bintulu Chapter">Bintulu Chapter</option>
                                <option value="Kuching Chapter">Kuching Chapter</option>
                                <option value="Miri Chapter">Miri Chapter</option>
                                <option value="Samarahan Chapter">Samarahan Chapter</option>
                                <option value="Sibu Chapter">Sibu Chapter</option>
                            </select>
                        </div>
                        <button type="submit" class="sponsorship-submit-btn" id="submitSponsorshipBtn">Add Sponsorship</button>
                        <button type="button" class="sponsorship-submit-btn" id="cancelEditBtn" style="display: none; background-color: #6c757d;"> Cancel Edit</button>
                    </form>

                    <div class="sponsorship-list-admin">
                        <h3>Current Sponsorships</h3>
                        <div id="currentSponsorship">
                            <!-- Events will be loaded here via AJAX -->
                            <p style="text-align: center; color: #64748b;">Loading sponsorship...</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Program Partners -->
            <div class="content-section" id="program-partners">
                <div class="section-header">
                    <h2 class="section-title">Program Partners Management</h2>
                    <p class="section-subtitle">Manage Special Olympics Sarawak program partners.</p>
                </div>
                
                <div class="content-placeholder">
                    <i class="fa-solid fa-handshake"></i>
                    <h3>Program Partners</h3>
                    <p>Add your program pertners management interface here</p>
                </div>
            </div>

            <!-- Other Special Olympics -->
            <div class="content-section" id="other-special-olympics">
                <div class="section-header">
                    <h2 class="section-title">Other Special Olympics Management</h2>
                    <p class="section-subtitle">Manage other Special Olympics.</p>
                </div>
                
                <div class="content-placeholder">
                    <i class="fa-solid fa-globe"></i>
                    <h3>Other Special Olympics</h3>
                    <p>Add your other Special Olympics management interface here</p>
                </div>
            </div>

            <!-- Settings Section -->
            <div class="content-section" id="settings">
                <div class="section-header">
                    <h2 class="section-title">Settings</h2>
                    <p class="section-subtitle">Configure your admin panel settings</p>
                </div>
                
                <div class="content-placeholder">
                    <i class="fas fa-cog"></i>
                    <h3>Settings Content</h3>
                    <p>Add your settings interface </p>
                </div>
            </div>

            <!-- Profile Section -->
            <div class="content-section" id="profile">
                <div class="section-header">
                    <h2 class="section-title">Profile</h2>
                    <p class="section-subtitle">Manage your admin profile</p>
                </div>
                
                <div class="content-placeholder">
                    <i class="fas fa-user"></i>
                    <h3>Profile Content</h3>
                    <p>Add your profile management interface here</p>
                </div>
            </div>
        </main>
    </div>

<!-- JavaScript Admin Panel Functionality -->
    <script>
        // Navigation functionality
        document.addEventListener('DOMContentLoaded', function() {
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
                                button.addEventListener('click', function() {
                                    const newsId = this.getAttribute('data-id');
                                    // Implement edit functionality (e.g., populate form or open modal)
                                    alert('Edit news item with ID: ' + newsId);
                                    // For a full implementation, you'd fetch the news item data
                                    // and populate the form for editing.
                                });
                            });

                            document.querySelectorAll('#existingNewsArticles .delete-btn').forEach(button => {
                                button.addEventListener('click', function() {
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
                                button.addEventListener('click', function() {
                                    const eventId = this.getAttribute('data-id');
                                    editEvent(eventId);
                                });
                            });

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
                eventForm.addEventListener('submit', function(e) {
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
            const deleteEventImageBtn = document.getElementById('deleteEventImageBtn');
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
                deleteEventImageBtn.addEventListener('click', function() {
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
                newsImageInput.addEventListener('change', function() {
                    if (this.files && this.files[0]) {
                        newsImageStatus.textContent = this.files[0].name;
                        newsImageStatus.style.display = '';
                        const reader = new FileReader();
                        reader.onload = function(e) {
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
                deleteNewsImageBtn.addEventListener('click', function() {
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
                addNewsForm.addEventListener('submit', function(e) {
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
            searchInput.addEventListener('input', function(e) {
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
            sponsorshipImageInput.addEventListener('change', function() {
                if (this.files && this.files[0]) {
                    sponsorshipImageStatus.textContent = this.files[0].name;
                    sponsorshipImageStatus.style.display = '';
                    const reader = new FileReader();
                    reader.onload = function(e) {
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
            deleteSponsorshipImageBtn.addEventListener('click', function() {
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
                            button.addEventListener('click', function() {
                                const sponsorshipId = this.getAttribute('data-id');
                                // Implement edit functionality here
                                alert('Edit sponsorship with ID: ' + sponsorshipId);
                            });
                        });

                        document.querySelectorAll('#currentSponsorship .delete-btn').forEach(button => {
                            button.addEventListener('click', function() {
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

    </script>
</body>
</html>
