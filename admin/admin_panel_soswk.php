<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Wemaster | Special Olympics Sarawak</title>
    <!-- White color logo of SO represents an admin -->
    <link rel="shortcut icon" href="../assets/images/master-logo-front-white.png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../css/admin_style.css">

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
    </style>
</head>
<body>
    <!-- Sidebar -->
    <aside class="sidebar">
        <div class="sidebar-header">
            <div class="sidebar-logo">
                <img src="../assets/images/Remake/SO Sarawak (site footer) BG.png" style="width: auto; height: 60px;">
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
                <a href="#" class="nav-item" data-section="posters">
                    <i class="fa-solid fa-house"></i>
                    <span>Posters</span>
                </a>
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
                    <img src="../assets/icons/samarahan-hornbill.png"
                        style="width: 16px; height: 16px; margin: 0 14px 0 2px; filter: invert(1);">
                    <span>Sarawak Chapters</span>
                </a>
                <a href="#" class="nav-item" data-section="sponsorships">
                    <i class="fa-solid fa-hand-holding-heart"></i>
                    <span>Sponsorships</span>
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
                    <p class="section-subtitle">Welcome to Special Olympics Sarawak Admin Webmaster</p>
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

            <div class="content-section" id="posters">
                <div class="section-header">
                    <h2 class="section-title">Posters Management</h2>
                    <p class="section-subtitle">Create and manage the posters for the Index page. The recommended aspect
                        ratio for each poster is 4:5 portrait.<br>*This posters management interface is under
                        development</p>
                </div>

                <div class="management-container">
                    <h3>Add a Posters</h3>
                    <form id="posterForm" action="../admin/handler/admin_poster_handler.php" method="POST"
                        enctype="multipart/form-data">
                        <input type="hidden" id="posterId" name="id">
                        <input type="hidden" id="currentPosterImage" name="currentImage">
                        <div class="form-group">
                            <label for="posterImage">Upload Image:</label>
                            <label for="posterImage" class="custom-browse-btn">Browse</label>
                            <input type="file" id="posterImage" name="posterImage" accept="image/*"
                                style="display: none;">
                            <button type="button" id="deletePosterImageBtn" class="custom-delete-btn">Delete</button>
                            <span style="font-size: 14px;" id="posterImageStatus">No file selected.</span>
                            <img id="posterImagePreview" src="" alt="Poster Image Preview"
                                style="max-width: 100%; max-height: 100%; margin-top: 10px; display: none;">
                        </div>
                        <button type="submit" class="form-submit-btn" id="submitPosterBtn">Publish</button>

                        <div class="published-container">
                            <div class="published-title">
                                <h3>Published Posters</h3>
                            </div>
                            <!-- Fetch the published posters from the database -->
                            <!-- Below is just a hard-coded structure sample, not connected to the database -->
                            <div id="publishedPoster">
                                <div class="p-poster-container">
                                    <div class="card_4-5-portrait">
                                        <img src="" alt="Special Olympics National Games 2026">
                                    </div>
                                    <div class="card_4-5-portrait">
                                        <img src="" alt="Healthy Athletes Program Poster">
                                    </div>
                                    <div class="card_4-5-portrait">
                                        <img src="" alt="Poster Card 3">
                                    </div>
                                    <div class="card_4-5-portrait">
                                        <img src="" alt="Poster Card 4">
                                    </div>
                                    <div class="card_4-5-portrait">
                                        <img src="" alt="Poster Card 5">
                                    </div>
                                    <div class="card_4-5-portrait">
                                        <img src="" alt="Poster Card 6">
                                    </div>
                                    <div class="card_4-5-portrait">
                                        <img src="" alt="Poster Card 7">
                                    </div>
                                    <div class="card_4-5-portrait">
                                        <img src="" alt="Poster Card 8">
                                    </div>
                                    <div class="card_4-5-portrait">
                                        <img src="" alt="Poster Card 9">
                                    </div>
                                    <div class="card_4-5-portrait">
                                        <img src="" alt="Poster Card 10">
                                    </div>
                                    <div class="card_4-5-portrait">
                                        <img src="" alt="Poster Card 11">
                                    </div>
                                    <div class="card_4-5-portrait">
                                        <img src="" alt="Poster Card 12">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
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
                    <form id="eventForm" action="../admin/handler/admin_event_handler.php" method="POST"
                        enctype="multipart/form-data">
                        <input type="hidden" id="eventId" name="id">
                        <input type="hidden" id="currentEventImage" name="currentImage">
                        <div class="event-form-group">
                            <label for="eventImage">Upload Image:</label>
                            <!-- <input type="file" id="eventImage" name="eventImage" accept="image/*"> <!-- Change the code here -->
                            <!-- New style for Browse & Delete Image button -->
                            <label for="eventImage" class="custom-browse-btn">Browse</label>
                            <input type="file" id="eventImage" name="eventImage" accept="image/*"
                                style="display: none;">
                            <button type="button" id="deleteEventImageBtn" class="custom-delete-btn">Delete</button>
                            <span style="font-size: 14px;" id="eventImageStatus">No file selected.</span>
                            <img id="eventImagePreview" src="" alt="Event Image Preview"
                                style="max-width: 100px; max-height: 100px; margin-top: 10px; display: none;">
                        </div>
                        <div class="event-form-group">
                            <label for="eventTitle">Title:</label>
                            <input style="font-family: 'Inter', sans-serif;" type="text" id="eventTitle"
                                name="eventTitle" placeholder="Enter event title" required>
                        </div>
                        <div class="event-form-group">
                            <label for="eventDescription">Description:</label>
                            <textarea style="font-family: 'Inter', sans-serif;" id="eventDescription"
                                name="eventDescription" placeholder="Enter event description" required></textarea>
                        </div>
                        <div class="event-form-group">
                            <label for="eventLocation">Location:</label>
                            <input style="font-family: 'Inter', sans-serif;" type="text" id="eventLocation"
                                name="eventLocation" placeholder="Enter event location" required>
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
                            <input style="font-family: 'Inter', sans-serif;" type="date" id="eventDate" name="eventDate"
                                required>
                        </div>
                        <div class="event-form-group">
                            <label for="eventTime">Time:</label>
                            <input style="font-family: 'Inter', sans-serif;" type="text" id="eventTime" name="eventTime"
                                placeholder="e.g., 10:00 AM - 12:00 PM" required>
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
                        <button type="button" class="event-submit-btn" id="cancelEditBtn"
                            style="display:none; background-color: #6c757d;">Cancel Edit</button>
                    </form>

                    <div class="event-list-admin">
                        <h3>Existing Events</h3>
                        <div id="existingEvents">
                            <!-- Events will be loaded here via AJAX -->
                            <p style="text-align: center; color: #333;">Loading events...</p>
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
                    <form id="addNewsForm" action="../admin/handler/admin_news_handler.php" method="POST"
                        enctype="multipart/form-data">
                        <div class="news-form-group">
                            <label for="newsImage">Upload Image:</label>
                            <label for="newsImage" class="custom-browse-btn">Browse</label>
                            <input type="file" id="newsImage" name="newsImage" accept="image/*" style="display: none;">
                            <button type="button" id="deleteNewsImageBtn" class="custom-delete-btn">Delete</button>
                            <span style="font-size: 14px;" id="newsImageStatus">No file selected.</span>
                            <img id="newsImagePreview" src="" alt="News Image Preview"
                                style="max-width: 100px; max-height: 100px; margin-top: 10px; display: none;">
                        </div>
                        <div class="news-form-group">
                            <label for="newsHeadline">Headline:</label>
                            <input style="font-family: 'Inter', sans-serif;" type="text" id="newsHeadline"
                                name="newsHeadline" placeholder="Enter news headline" required>
                        </div>
                        <div class="news-form-group">
                            <label for="newsDate">Date:</label>
                            <input style="font-family: 'Inter', sans-serif;" type="date" id="newsDate" name="newsDate"
                                required>
                        </div>
                        <div class="news-form-group">
                            <label for="newsDescription">Description:</label>
                            <textarea style="font-family: 'Inter', sans-serif;" id="newsDescription"
                                name="newsDescription" placeholder="Enter news description" required></textarea>
                        </div>
                        <button type="submit" class="news-submit-btn">Add News</button>
                    </form>

                    <div class="news-list-admin">
                        <h3>Existing News Articles</h3>
                        <div id="existingNewsArticles">
                            <!-- News articles will be loaded here via AJAX -->
                            <p style="text-align: center; color: #333;">Loading news articles...</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Athlete Leaderships -->
            <div class="content-section" id="alp">
                <div class="section-header">
                    <h2 class="section-title">Athlete Leaderships Management</h2>
                    <p class="section-subtitle">Manage Athlete Leaderships Program (ALP) overview articles, resources
                        and the "learn more" page.</p>
                </div>

                <div class="content-placeholder">
                    <i class="fas fa-newspaper"></i>
                    <h3>Athlete Leaderships Program</h3>
                    <p>Add your Athlete Leaderships management interface here</p>
                </div>
            </div>

            <!-- Healthy Athletes -->
            <div class="content-section" id="sohap">
                <div class="section-header">
                    <h2 class="section-title">Healthy Athletes Management</h2>
                    <p class="section-subtitle">Manage Healthy Athletes Program (SOHAP) overview articles, resources and
                        the "learn more" page.</p>
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
                    <p class="section-subtitle">Manage Young Athletes Program (YAP) overview articles, resources and the
                        "learn more" page.</p>
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
                    <p class="section-subtitle">Upload and manage photos in the gallery.
                </div>

                <div class="galphoto-management-container">
                    <h3>Add Photo</h3>
                    <form id="galleryPhoto" action="../admin/handler/admin_gallery_photo_handler.php" method="POST"
                        enctype="multipart/form-data">
                        <input type="hidden" id="galleryPhotoId" name="id">
                        <input type="hidden" id="currentGalleryPhotoImage" name="currentImage">
                        <div class="galphoto-form-group">
                            <label for="galleryPhotoImage">Upload Image: <span
                                    style="color: #e53935;">*required</span></label>
                            <label for="galleryPhotoImage" class="custom-browse-btn">Browse</label>
                            <input type="file" id="galleryPhotoImage" name="galleryPhotoImage" accept="image/*"
                                style="display: none;">
                            <button type="button" id="deleteGalleryPhotoImageBtn"
                                class="custom-delete-btn">Delete</button>
                            <span style="font-size: 14px;" id="galleryPhotoImageStatus">No file selected.</span>
                            <img id="galleryPhotoImagePreview" src="" alt="Image Preview"
                                style="max-width: 100px; max-height: 100px; margin-top: 10px; display: none;">
                        </div>
                        <div class="galphoto-form-group">
                            <label for="galleryPhotoAlbum">Select Existing Collection: <span
                                    style="color: #e53935;">*required</span></label>
                            <select style="font-family: 'Inter', sans-serif;" id="galleryPhotoAlbum"
                                name="galleryPhotoAlbum">
                                <option value="">Fetching data...</option>
                            </select>
                        </div>
                        <div class="galphoto-form-group">
                            <!-- Adds an album / event / category for the admin's dropdown options, and to display to the end-user's interface -->
                            <label for="galleryPhotoNewAlbum">New Collection Name</label>
                            <input style="font-family: 'Inter', sans-serif;" type="text" id="galleryPhotoNewAlbum"
                                name="galleryPhotoNewAlbum" placeholder="Healthy Athletes Program">
                        </div>
                        <div class="galphoto-form-group">
                            <!-- Add a description for the end-user's interface -->
                            <label for="galleryPhotoNewAlbumDesc">New Collection Descriptions (recommended)</label>
                            <input style="font-family: 'Inter', sans-serif;" type="text" id="galleryPhotoNewAlbumDesc"
                                name="galleryPhotoNewAlbumDesc"
                                placeholder="The Healthy Athletes Program video category showcases content promoting health, fitness, and wellness initiatives for athletes with intellectual disabilities.">
                        </div>
                        <button type="submit" class="galphoto-submit-btn" id="submitGalleryPhotoBtn">Publish</button>
                    </form>

                    <div class="gallery-admin-container">
                        <div class="gallery-admin-title">
                            <h3>Published Photos</h3>
                        </div>
                        <!-- Fetch the published collections from the database -->
                        <!-- Below is just a hard-coded structure sample, not connected to the database -->
                        <div id="publishedGalleryPhoto">
                            <!-- <p style="text-align: center; color: #333;">Fetching videos from the database...</p> -->
                            <!-- Published videos will be loaded here via AJAX, such as -->
                        </div>
                    </div>
                </div>
            </div>

            <!-- Opens to display collection edit modal, save or discard the changes (Reusable for Photos and Videos) -->
            <div class="galphoto-modal-album" id="galphoto-modal-album" style="display: none;">
                <div class="galphoto-modal-album-content">
                    <div class="gpmac-desc">
                        <div class="gpmac-form-group">
                            <label>Collection Name</label>
                            <!-- Fetch collection name from the database -->
                            <input style="font-family: 'Inter', sans-serif;" type="text" id="galleryPhotoAlbum"
                                name="galleryPhotoAlbum">
                        </div>
                        <div class="gpmac-form-group">
                            <label>Descriptions</label>
                            <!-- Fetch descriptions from the database -->
                            <input style="font-family: 'Inter', sans-serif;" type="text" id="galleryPhotoAlbumDesc"
                                name="galleryPhotoAlbumDesc">
                        </div>
                    </div>
                    <div class="gpmac-options">
                        <button class="delete-btn" id="galphoto-modal-album-close">Cancel</button>
                        <button type="edit" class="edit-btn" id="saveGalleryPhotoAlbumEdit">Save</button>
                    </div>
                </div>
            </div>

            <!-- Opens a delete collection modal to prompt an admin for confirmation (Reusable for Photos and Videos) -->
            <div class="gallery-modal-album" id="gallery-modal-delete-album" style="display: none;">
                <div class="gallery-modal-album-content">
                    <div class="gmac-desc">
                        <h3>Delete Collection</h3>
                        <p>Deleting this collection will permanently remove all contents. This action cannot be undone.
                            Are you sure you want to continue?</p>
                        <p>The delete button will be available in 5 second(s).</p>
                    </div>
                    <div class="gmac-options">
                        <button class="cancel-btn" id="gallery-modal-album-close">Cancel</button>
                        <!-- 5 seconds delay before the delete button is clickable -->
                        <button class="delete-btn" id="deleteGalleryAlbum">Delete</button>
                    </div>
                </div>
            </div>

            <!-- Opens a modal to display an image, edit/delete an image (Specifically for Photos) -->
            <div class="galphoto-modal" id="galphoto-modal" style="display: none;">
                <div class="galphoto-modal-content">
                    <span class="modal-close" id="galphoto-modal-close"><i class="fa-solid fa-xmark"></i></span>
                    <img src="../assets/images/yap-lm/YAP PIP 16-9.png" alt="Image Preview" class="galphoto-modal-image"
                        id="galphoto-modal-image">
                    <h3 class="galphoto-modal-title" id="galphoto-modal-title">File Name:</h3>
                    <p class="galphoto-modal-filename" id="galphoto-modal-filename">This is the file name such as
                        photo.jpg</p>
                    <div class="galphoto-modal-options" style="margin-top: 20px;">
                        <button class="delete-btn" id="deleteGalleryPhotoBtn">Delete</button>
                    </div>
                </div>
            </div>

            <!-- Gallery/Videos Section -->
            <div class="content-section" id="videos">
                <div class="section-header">
                    <h2 class="section-title">Video Management</h2>
                    <p class="section-subtitle">Upload and manage videos in the gallery.<br><br>The recommended maximum
                        video resolution is <strong>1920×1080</strong>, with a <strong>video bitrate between 2–6
                            Mbps</strong> and an <strong>audio bitrate of 128 kbps (AAC)</strong> to help prevent
                        buffering issues. Since the admin webmaster does <strong>not support automatic video
                            compression</strong> like most streaming platforms, you’ll need to <strong>manually compress
                            your original video</strong> into the MP4 format before uploading.<br><br>*This video
                        management interface is under development.</p>
                </div>

                <div class="galvideo-management-container">
                    <h3>Add Video</h3>
                    <form id="galleryVideo" action="../admin/handler/admin_gallery_video_handler.php" method="POST"
                        enctype="multipart/form-data">
                        <input type="hidden" id="galleryVideoId" name="id">
                        <input type="hidden" id="currentGalleryVideoImage" name="currentImage">
                        <div class="galvideo-form-group">
                            <label for="galleryVideo">Upload Video: <span
                                    style="color: #e53935;">*required</span></label>
                            <label for="galleryVideo" class="custom-browse-btn">Browse</label>
                            <input type="file" id="galleryVideo" name="galleryVideo" accept="video/mp4"
                                style="display: none;">
                            <button type="button" id="deleteGalleryVideoBtn" class="custom-delete-btn">Delete</button>
                            <span style="font-size: 14px;" id="galleryVideoStatus">No file selected.</span>
                        </div>
                        <div class="galvideo-form-group">
                            <label for="galleryVideoImage">Video Cover: <span
                                    style="color: #e53935;">*required</span></label>
                            <label for="galleryVideoImage" class="custom-browse-btn">Browse</label>
                            <input type="file" id="galleryVideoImage" name="galleryVideoImage" accept="image/*"
                                style="display: none;">
                            <button type="button" id="deleteGalleryVideoImageBtn"
                                class="custom-delete-btn">Delete</button>
                            <span style="font-size: 14px;" id="galleryVideoImageStatus">No file selected.</span>
                            <img id="galleryVideoImagePreview" src="" alt="Video Thumbnail"
                                style="max-width: 100px; max-height: 100px; margin-top: 10px; display: none;">
                        </div>
                        <div class="galvideo-form-group">
                            <label for="galleryVideoTitle">Video Title: <span
                                    style="color: #e53935;">*required</span></label>
                            <input style="font-family: 'Inter', sans-serif;" type="text" id="galleryVideoTitle"
                                name="galleryVideoTitle" required>
                        </div>
                        <div class="galvideo-form-group">
                            <!-- Not displayed on the gallery but to be fetched to the video playback page -->
                            <label for="galleryVideoDesc">Descriptions:</label>
                            <textarea style="font-family: 'Inter', sans-serif;" id="galleryVideoDesc"
                                name="galleryVideoDesc"></textarea>
                        </div>
                        <div class="galvideo-form-group">
                            <label for="galleryVideoAlbum">Select Existing Collection: <span
                                    style="color: #e53935;">*required</span></label>
                            <select id="galleryVideoAlbum" name="galleryVideoAlbum" required>
                                <option value="">Fetching data...</option>
                            </select>
                        </div>
                        <div class="galvideo-form-group">
                            <!-- Adds an album / event / category for the admin's dropdown options, and to display to the end-user's interface -->
                            <label for="galleryVideoAddAlbum">New Collection Name</label>
                            <input style="font-family: 'Inter', sans-serif;" type="text" id="galleryVideoAddAlbum"
                                name="galleryVideoAddAlbum" placeholder="Healthy Athletes Program">
                        </div>
                        <div class="galvideo-form-group">
                            <!-- Add a description for the end-user's interface -->
                            <label for="galleryVideoAlbumDesc">Descriptions for the new Collection (recommended for
                                UX)</label>
                            <input style="font-family: 'Inter', sans-serif;" type="text" id="galleryVideoAlbumDesc"
                                name="galleryVideoAlbumDesc"
                                placeholder="The Healthy Athletes Program video category showcases content promoting health, fitness, and wellness initiatives for athletes with intellectual disabilities.">
                        </div>
                        <button type="submit" class="galvideo-submit-btn" id="submitGalleryVideoBtn">Publish</button>
                    </form>

                    <div class="gallery-admin-container">
                        <div class="gallery-admin-title">
                            <h3>Published Videos</h3>
                        </div>
                        <div id="publishedGalleryVideo">
                            <!-- <p style="text-align: center; color: #333;">Fetching videos from the database...</p> -->
                            <!-- Published videos will be loaded here via AJAX, such as -->
                        </div>
                    </div>
                </div>
            </div>

            <!-- Opens a modal to display an image, edit/delete an image (Specifically for Videos) -->
            <div class="galvideo-modal" id="galvideo-modal" style="display: none;">
                <div class="galvideo-modal-content">
                    <span class="modal-close" id="galvideo-modal-close"><i class="fa-solid fa-xmark"></i></span>
                    <div class="galvideo-form-group cover">
                        <!-- Hover on image to display browse -->
                        <img src="../assets/images/yap-lm/YAP PIP 16-9.png" alt="Video Thumbnail"
                            class="galvideo-modal-image" id="galvideo-modal-image">
                        <div class="gvmfg-options">
                            <button class="play-btn"><i class="fa-solid fa-play"
                                    style="margin-right: 12px;"></i>Play</button>
                            <button class="change-btn">Change Video Cover</button>
                        </div>
                    </div>
                    <div class="galvideo-form-group">
                        <label for="galleryVideoTitleEdit">Video Title: </label>
                        <input style="font-family: 'Inter', sans-serif;" type="text" id="galleryVideoTitleEdit"
                            name="galleryVideoTitleEdit" required>
                    </div>
                    <div class="galvideo-form-group">
                        <label for="galleryVideoDescEdit">Descriptions: </label>
                        <!-- Fetch video descriptions from the database to be display here and is editable -->
                        <textarea id="galleryVideoDescEdit" name="galleryVideoDescEdit"></textarea>
                    </div>
                    <div class="galvideo-form-group">
                        <label for="galleryVideoAlbumEdit">Collection: </label>
                        <select id="galleryVideoAlbumEdit" name="galleryVideoAlbumEdit">
                            <!-- Fetch from the existing collections dropdown options here -->
                        </select>
                    </div>
                    <div class="galvideo-modal-options" style="margin-top: 20px;">
                        <button class="delete-btn">Delete</button>
                        <button type="edit" class="save-edit-btn" id="saveGalleryVideoEdit">Save</button>
                    </div>
                </div>
            </div>

            <!-- Sarawak Chapters -->
            <div class="content-section" id="sarawak-chapters">
                <div class="section-header">
                    <h2 class="section-title">Sarawak Chapters Management</h2>
                    <p class="section-subtitle">Manage Sarawak pinpoint hover informations (Our Chapters Across Sarawak)
                        such as chairman, vice chairman, secretary and treasurer.</p>
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
                    <p class="section-subtitle">Manage Special Olympics Sarawak sponsorships by just simply add, edit
                        and remove an images.<br>*This sponsorships management interface is under development</p>
                </div>

                <div class="sponsorship-management-container">
                    <h3>Add/Edit Sponsorship Logo Brand</h3>
                    <form id="sponsorshipForm" action="../admin/handler/admin_sponsorship_handler.php" method="POST"
                        enctype="multipart/form-data">
                        <input type="hidden" id="sponsorshipId" name="id">
                        <input type="hidden" id="currentSponsorshipImage" name="currentImage">
                        <div class="sponsorship-form-group">
                            <label for="sponsorshipImage">Upload Image:</label>
                            <label for="sponsorshipImage" class="custom-browse-btn">Browse</label>
                            <input type="file" id="sponsorshipImage" name="sponsorshipImage" accept="image/*"
                                style="display: none;">
                            <button type="button" id="deleteSponsorshipImageBtn"
                                class="custom-delete-btn">Delete</button>
                            <span style="font-size: 14px;" id="sponsorshipImageStatus">No file selected.</span>
                            <img id="sponsorshipImagePreview" src="" alt="Sponsorship Image Preview"
                                style="max-width: 100px; max-height: 100px; margin-top: 10px; display: none;">
                        </div>
                        <div class="sponsorship-form-group">
                            <label for="sponsorshipChapter">Sponsorship Type:</label>
                            <select style="font-family: 'Inter', sans-serif;" id="sponsorshipChapter"
                                name="sponsorshipChapter" required>
                                <option value="Special Olympics Sarawak">Special Olympics Sarawak</option>
                                <option value="Bintulu Chapter">Bintulu Chapter</option>
                                <option value="Kuching Chapter">Kuching Chapter</option>
                                <option value="Miri Chapter">Miri Chapter</option>
                                <option value="Samarahan Chapter">Samarahan Chapter</option>
                                <option value="Sibu Chapter">Sibu Chapter</option>
                            </select>
                        </div>
                        <button type="submit" class="sponsorship-submit-btn" id="submitSponsorshipBtn">Add
                            Sponsorship</button>
                        <button type="button" class="sponsorship-submit-btn" id="cancelEditBtn"
                            style="display: none; background-color: #6c757d;"> Cancel Edit</button>
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

    <script src="../scripts/admin-components/navigation-functionality.js"></script>
    <script src="../scripts/admin-components/event-management.js"></script>
    <script src="../scripts/admin-components/news-management.js"></script>
    <script src="../scripts/admin-components/sponsorship-management.js"></script>
    <script src="../scripts/admin-components/photo-management.js"></script>
    <script src="../scripts/admin-components/video-management.js"></script>

    <!-- Fallback to the old script checkpoint if none of them works -->
    <!-- <script src="../scripts/admin-components/archive/admin-panel-soswk.js"></script> -->
</body>
</html>