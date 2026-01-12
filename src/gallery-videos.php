<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Videos - Gallery | Special Olympics Sarawak</title>
    <link rel="shortcut icon" href="../assets/images/master_logo_front.png">
    <link rel="stylesheet" href="../css/global-style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <style>
        /* Local HTML Styles */
        .header-space {
            height: 70px;
            background: transparent;
        }
        
        .footer-space {
            height: 100px;
            background: transparent;
        }

        .body {
            background-color: #f9f9f9;
            overflow-y: auto;
            min-height: 100vh;
        }

        /* Video-specific styling */
        .cg-card.videos .cg-card-thumbnail {
            position: relative;
            cursor: pointer;
        }

        .video-play-overlay {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background: rgba(0, 0, 0, 0.7);
            color: white;
            border-radius: 50%;
            width: 60px;
            height: 60px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .cg-card.videos:hover .video-play-overlay {
            opacity: 1;
        }

        .cg-card.videos {
            transition: transform 0.2s ease;
        }

        .cg-card.videos:hover {
            transform: translateY(-5px);
        }
    </style>
</head>
<body>
    <script src="../scripts/components/header.js"></script>
    <script src="../scripts/components/socmed-bar.js"></script>
    <div class="header-space"></div>
    
    <section class="gallery-hero videos">
        <h1>Videos</h1>
        <p>Watch uplifting stories and exciting event highlights showcasing the spirit of Special Olympics Sarawak.</p>
    </section>
    
    <section class="category-gallery">
        <!-- Video Album/Collection will be added here via JS -->
    </section>

    <script>
        function getGalleryVisibleCount() {
            const w = window.innerWidth;
            // May not works due to transition slide (class name gallery-track)
            if (w <= 670) return 1;
            if (w <= 1000) return 2;
            if (w <= 1320) return 3;
            // Default cards visibility
            return 4;
        }

        function setupGallerySlider(gridEl, cardSelector, leftBtnSelector, rightBtnSelector, visibleCount) {
            if (!gridEl) return;
            
            const track = gridEl.querySelector('.gallery-track');
            if (!track) return;
            
            const cards = Array.from(track.querySelectorAll(cardSelector));
            let startIdx = 0;
            let currentVisible = visibleCount;

            function getCardWidth() {
                if (cards.length === 0) return 0;
                const cardStyle = window.getComputedStyle(cards[0]);
                const cardWidth = cards[0].offsetWidth;
                const gap = parseFloat(window.getComputedStyle(track).gap) || 24;
                return cardWidth + gap;
            }

            function render() {
                const slideDistance = startIdx * getCardWidth();
                track.style.transform = `translateX(-${slideDistance}px)`;
            }

            const leftBtn = gridEl.querySelector(leftBtnSelector);
            const rightBtn = gridEl.querySelector(rightBtnSelector);

            leftBtn?.addEventListener('click', () => {
                if (startIdx > 0) {
                    startIdx--;
                    render();
                }
            });

            rightBtn?.addEventListener('click', () => {
                if (startIdx < cards.length - currentVisible) {
                    startIdx++;
                    render();
                }
            });

            function adjustVisible() {
                const newCount = getGalleryVisibleCount();
                if (newCount !== currentVisible) {
                    currentVisible = newCount;
                    if (startIdx > cards.length - currentVisible) {
                        startIdx = Math.max(0, cards.length - currentVisible);
                    }
                    render();
                }
            }
            
            window.addEventListener('resize', () => {
                adjustVisible();
                render(); // Recalculate slide distance on resize
            }, { passive: true });

            render();
        }

        // Fetch video collections
        document.addEventListener('DOMContentLoaded', ()=>{
            const container = document.querySelector('.category-gallery');
            fetch('../admin/handler/admin_gallery_video_handler.php?action=fetch_collections')
                .then(r=>r.json())
                .then(d=>{
                    if (!d.success) return;
                    d.collections.forEach(col=>{
                        fetch(`../admin/handler/admin_gallery_video_handler.php?action=fetch_items&collection_id=${col.id}`)
                            .then(r=>r.json())
                            .then(items=>{
                                if (!items.success) return;
                                const wrap=document.createElement('div');
                                wrap.className='cg-container';
                                wrap.innerHTML = `
                                    <h2>${col.name}</h2>
                                    <p>${col.description || ''}</p>
                                    <div class="cg-grid">
                                        <button class="gallery-arrow left" aria-label="Previous"><i class="fa-solid fa-angle-left"></i></button>
                                        <button class="gallery-arrow right" aria-label="Next"><i class="fa-solid fa-angle-right"></i></button>
                                        <div class="gallery-track videos"></div>
                                    </div>`;
                                const track = wrap.querySelector('.gallery-track');
                                items.videos.forEach(v=>{
                                    // Smart path handling for cover image
                                    let coverSrc = v.cover_path || '../assets/videos/gallery_videos_upload/covers/default-video-thumb.svg';
                                    if (coverSrc && !coverSrc.startsWith('http') && !coverSrc.startsWith('../')) {
                                        coverSrc = '../' + coverSrc;
                                    }
                                    
                                    const card=document.createElement('div');
                                    card.className='cg-card videos';
                                    card.onclick = () => {
                                        // Open video in the dedicated player page
                                        window.location.href = `video-player.php?id=${v.id}`;
                                    };
                                    card.innerHTML = `
                                        <div class="cg-card-thumbnail">
                                            <img src="${coverSrc}" alt="${v.title}" onerror="this.src='../assets/videos/gallery_videos_upload/covers/default-video-thumb.svg'">
                                            <div class="video-play-overlay">
                                                <i class="fas fa-play"></i>
                                            </div>
                                        </div>
                                        <div class="cg-card-title"><p>${v.title}</p></div>`;
                                    track.appendChild(card);
                                });
                                container.appendChild(wrap);
                                
                                // Setup slider for this new collection
                                setupGallerySlider(
                                    wrap.querySelector('.cg-grid'),
                                    '.cg-card.videos',
                                    '.gallery-arrow.left',
                                    '.gallery-arrow.right',
                                    getGalleryVisibleCount()
                                );
                            });
                    });
                });
        });
    </script>
    
    <script src="../scripts/components/bottom-nav.js"></script>
    <script src="../scripts/components/site-footer.js"></script>
    <script src="../scripts/script.js"></script>
    <script src="../scripts/song-bubble.js"></script>
</body>
</html>