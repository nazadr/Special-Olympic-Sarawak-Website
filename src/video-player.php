<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title id="page-title">Video Player | Special Olympics Sarawak</title>
    <link rel="shortcut icon" href="../assets/images/master_logo_front.png">
    <link rel="stylesheet" href="../css/global-style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <!-- For video player styling only -->
    <link rel="stylesheet" href="https://cdn.plyr.io/3.7.2/plyr.css" />

    <style>
        /* Plyr custom style */
        :root {
            --plyr-color-main: #e53935;
        }
        .plyr--video {
            width: 100%;
        }
        [id$="-speed"] {
            min-width: 140px;
        }
        @media (max-width: 768px) {
            .plyr--video .plyr__controls {
                opacity: 1;
                pointer-events: auto;
            }
            .plyr__menu__container {
                max-height: 140px;
            }
            [id$="-quality"], [id$="-speed"], [id$="-captions"] {
                max-height: 140px;
                overflow-y: auto;
                font-size: 0.85rem;
                min-width: 156px;
                max-width: 95vw;
            }
        }

        /* Local HTML Styles */
        .body {
            background-color: white;
            overflow-y: auto;
            min-height: 100vh;
        }
        .header-space {
            height: 70px;
            background: transparent;
        }
        .video-play-section {
            width: 100%;
            background: #2a2a2a;
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 400px;
            padding: 20px 0;
        }
        .video-container {
            width: 100%;
            max-width: 1065px;
            margin: 0 auto;
            display: flex;
            align-items: center;
            justify-content: center;
            background: black;
            position: relative;
        }
        .video-container:not(.vertical) {
            aspect-ratio: 16 / 9;
        }
        .video-container.vertical {
            max-width: 600px;
            max-height: 80vh;
            aspect-ratio: auto;
        }
        .video-container video {
            width: 100%;
            height: 100%;
            max-width: 100%;
            max-height: 100%;
            object-fit: contain;
            display: block;
            margin: 0 auto;
        }
        .video-container.vertical video {
            max-height: 80vh;
            width: auto;
            height: auto;
        }
        /* Fullscreen handling */
        .plyr--fullscreen.plyr--video,
        .plyr:-webkit-full-screen,
        .plyr:-moz-full-screen,
        .plyr:-ms-fullscreen {
            width: 100vw !important;
            height: 100vh !important;
            max-width: 100vw !important;
            max-height: 100vh !important;
        }
        .plyr--fullscreen.plyr--video .plyr__video-wrapper,
        .plyr:-webkit-full-screen .plyr__video-wrapper,
        .plyr:-moz-full-screen .plyr__video-wrapper,
        .plyr:-ms-fullscreen .plyr__video-wrapper {
            width: 100% !important;
            height: 100% !important;
        }
        .plyr--fullscreen.plyr--video video,
        .plyr:-webkit-full-screen video,
        .plyr:-moz-full-screen video,
        .plyr:-ms-fullscreen video {
            width: 100% !important;
            height: 100% !important;
            max-width: 100vw !important;
            max-height: 100vh !important;
            object-fit: cover !important;
        }
        /* Vertical video fullscreen - fill height and center */
        .video-container.vertical .plyr--fullscreen video,
        .video-container.vertical .plyr:-webkit-full-screen video,
        .video-container.vertical .plyr:-moz-full-screen video,
        .video-container.vertical .plyr:-ms-fullscreen video {
            width: auto !important;
            height: 100vh !important;
            max-width: none !important;
            max-height: 100vh !important;
            object-fit: contain !important;
            margin: 0 auto !important;
        }
        /* Ensure Plyr wrapper doesn't break centering */
        .video-container .plyr,
        .video-container .plyr__video-wrapper {
            width: 100%;
            height: 100%;
        }
        .video-description {
            width: 1200px;
            margin: 40px auto 80px auto;
        }
        .video-description h1 {
            color: #c4161c;
            font-size: 1rem;
            font-weight: 700;
            margin-bottom: 0;
            padding: 0 12px;
        }
        .video-description h2 {
            color: #333;
            font-size: 2.5rem;
            font-weight: 600;
            margin-top: 16px;
            padding: 0 12px;
        }
        .video-description p {
            color: #333;
            font-size: 1.1rem;
            padding: 0 12px;
        }
        .back-to-gallery {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: #e53935;
            color: white;
            padding: 12px 24px;
            border-radius: 6px;
            text-decoration: none;
            font-weight: 600;
            margin: 0 12px 20px 12px;
            transition: background 0.3s ease;
        }
        .back-to-gallery:hover {
            background: #c62828;
        }
        .loading-message {
            text-align: center;
            padding: 40px;
            color: #666;
        }
        .error-message {
            text-align: center;
            padding: 40px;
            color: #e53935;
        }
        @media (max-width: 768px) {
            .video-play-section {
                max-width: 100vw;
                padding: 0;
            }
            .video-container {
                aspect-ratio: 16 / 9;
                width: 100vw;
                min-width: 0;
            }
            .video-description {
                width: 100%;
                margin: 24px auto 40px auto;
            }
            .video-description h1 {
                font-size: 0.9rem;
            }
            .video-description h2 {
                font-size: 1.8rem;
            }
            .video-description p {
                font-size: 1rem;
            }
            .back-to-gallery {
                margin: 0 12px 16px 12px;
            }
        }
    </style>
</head>
<body>
    <!-- Navigation Bar (Loaded via JS) -->
    <script src="../scripts/components/header.js"></script>
    <!-- Social Media Bar (Loaded via JS) -->
    <script src="../scripts/components/socmed-bar.js"></script>
    <!-- Space for existing header -->
    <div class="header-space"></div>

    <div class="video-content">
        <div class="loading-message" id="loading">
            <i class="fas fa-spinner fa-spin"></i> Loading video...
        </div>
        
        <div class="error-message" id="error" style="display: none;">
            <i class="fas fa-exclamation-triangle"></i> Video not found or error loading video.
        </div>

        <div id="video-player-content" style="display: none;">
            <div class="video-play-section">
                <div class="video-container">
                    <video id="player" controls preload="metadata">
                        <!-- Video source will be loaded dynamically -->
                    </video>
                </div>
            </div>
            <div class="video-description">
                <a href="../src/gallery-videos.php" class="back-to-gallery">
                    <i class="fas fa-arrow-left"></i> Back to Gallery
                </a>
                <h1 id="video-category">SPECIAL OLYMPICS SARAWAK VIDEO GALLERY</h1>
                <h2 id="video-title">Video Title</h2>
                <p id="video-desc">Video description will be loaded here...</p>
            </div>
        </div>
    </div>

    <!-- Bottom Navigation -->
    <script src="../scripts/components/bottom-nav.js"></script>
    <!-- Site footer -->
    <script src="../scripts/components/site-footer.js"></script>
    <script src="../scripts/script.js"></script>
    
    <script src="//cdn.jsdelivr.net/npm/hls.js@1"></script>
    <script src="https://cdn.plyr.io/3.7.2/plyr.js"></script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const urlParams = new URLSearchParams(window.location.search);
            const videoId = urlParams.get('id');
            
            if (!videoId) {
                showError('No video ID provided');
                return;
            }
            
            // Fetch video data from the server
            fetch(`../admin/handler/admin_gallery_video_handler.php?action=get_video&id=${videoId}`)
                .then(response => response.json())
                .then(data => {
                    if (!data.success) {
                        showError('Video not found');
                        return;
                    }
                    
                    loadVideo(data.video);
                })
                .catch(error => {
                    console.error('Error fetching video:', error);
                    showError('Error loading video');
                });
            
            function loadVideo(video) {
                const videoElement = document.getElementById('player');
                const videoPlayerContent = document.getElementById('video-player-content');
                const loading = document.getElementById('loading');
                const videoContainer = document.querySelector('.video-container');
                
                // Update page title
                document.title = `${video.title} | Special Olympics Sarawak`;
                document.getElementById('page-title').textContent = `${video.title} | Special Olympics Sarawak`;
                
                // Update video information
                document.getElementById('video-title').textContent = video.title;
                document.getElementById('video-desc').textContent = video.description || 'No description available';
                document.getElementById('video-category').textContent = `SPECIAL OLYMPICS SARAWAK VIDEO GALLERY - ${video.collection_name || ''}`.toUpperCase();
                
                // Set video source
                videoElement.innerHTML = `<source src="${video.video_path}" type="video/mp4">`;
                
                // Detect video orientation once metadata is loaded
                videoElement.addEventListener('loadedmetadata', function() {
                    const aspectRatio = this.videoWidth / this.videoHeight;
                    console.log('Video dimensions:', this.videoWidth, 'x', this.videoHeight, 'Aspect ratio:', aspectRatio);
                    
                    // If height > width, it's vertical (portrait)
                    if (aspectRatio < 1) {
                        console.log('Vertical video detected');
                        videoContainer.classList.add('vertical');
                    } else {
                        console.log('Horizontal video detected');
                        videoContainer.classList.remove('vertical');
                    }
                });
                
                // Hide loading and show content
                loading.style.display = 'none';
                videoPlayerContent.style.display = 'block';
                
                // Initialize Plyr
                initializePlayer();
            }
            
            function showError(message) {
                const loading = document.getElementById('loading');
                const error = document.getElementById('error');
                
                loading.style.display = 'none';
                error.style.display = 'block';
                error.innerHTML = `<i class="fas fa-exclamation-triangle"></i> ${message}`;
            }
            
            function initializePlayer() {
                const video = document.getElementById('player');
                const videoContainer = document.querySelector('.video-container');
                
                const defaultOptions = {
                    controls: [
                        'play-large',
                        'play',
                        'progress',
                        'current-time',
                        'duration',
                        'mute',
                        'volume',
                        'captions',
                        'settings',
                        'pip',
                        'airplay',
                        'fullscreen',
                    ],
                    speed: {
                        selected: 1,
                        options: [0.5, 0.75, 1, 1.25, 1.5, 1.75, 2]
                    }
                };
                
                // Initialize Plyr
                const player = new Plyr(video, defaultOptions);
                
                // Handle fullscreen changes for vertical videos
                player.on('enterfullscreen', () => {
                    console.log('🖥️ Entering fullscreen...');
                    const videoElement = document.getElementById('player');
                    const aspectRatio = videoElement.videoWidth / videoElement.videoHeight;
                    
                    console.log('Fullscreen - Video dimensions:', videoElement.videoWidth, 'x', videoElement.videoHeight);
                    console.log('Aspect ratio:', aspectRatio, '- Is vertical:', aspectRatio < 1);
                    
                    // Apply styles directly for vertical videos
                    if (aspectRatio < 1) {
                        console.log('✅ Applying vertical fullscreen styles');
                        videoElement.style.width = 'auto';
                        videoElement.style.height = '100vh';
                        videoElement.style.maxWidth = 'none';
                        videoElement.style.maxHeight = '100vh';
                        videoElement.style.objectFit = 'contain';
                        videoElement.style.margin = '0 auto';
                    } else {
                        console.log('Applying horizontal fullscreen styles');
                        videoElement.style.width = '100%';
                        videoElement.style.height = '100%';
                        videoElement.style.objectFit = 'cover';
                    }
                });
                
                player.on('exitfullscreen', () => {
                    console.log('📤 Exited fullscreen - resetting styles');
                    const videoElement = document.getElementById('player');
                    videoElement.style.width = '';
                    videoElement.style.height = '';
                    videoElement.style.maxWidth = '';
                    videoElement.style.maxHeight = '';
                    videoElement.style.objectFit = '';
                    videoElement.style.margin = '';
                });
                
                // Auto-focus for better UX
                player.on('ready', () => {
                    video.focus();
                });
            }
        });
    </script>
</body>
</html>