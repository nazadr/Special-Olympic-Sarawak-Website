<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Photos - Gallery | Special Olympics Sarawak</title>
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
    </style>
</head>
<body>
    <script src="../scripts/components/header.js"></script>
    <script src="../scripts/components/socmed-bar.js"></script>
    <div class="header-space"></div>
    
    <section class="gallery-hero photos">
        <h1>Photos</h1>
        <p>Explore memorable moments and inspiring highlights from Special Olympics Sarawak through our photo gallery.</p>
    </section>
    
    <section class="category-gallery">
        <!-- Photo Album/Collection will be added here via JS -->
        
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

        setupGallerySlider(
            document.querySelector('.lg-grid'),
            '.lp-card',
            '.gallery-arrow.left',
            '.gallery-arrow.right',
            getGalleryVisibleCount()
        );

        // Fetch photo collections
        document.addEventListener('DOMContentLoaded', ()=>{
            const photoForm = document.getElementById('galleryPhoto');

            if (photoForm) {
                photoForm.addEventListener('submit', function (e) {
                    e.preventDefault();
                    const fd = new FormData(photoForm);
                    fd.append('action', 'add_photo'); // IMPORTANT

                    fetch('../admin/handler/admin_gallery_photo_handler.php', {
                        method: 'POST',
                        body: fd
                    })
                    .then(r => r.json())
                    .then(d => {
                        // Upload completed
                    });
                });
            };
            
            const container = document.querySelector('.category-gallery');
            fetch('../admin/handler/admin_gallery_photo_handler.php?action=fetch_collections')
                .then(r=>r.json())
                .then(d=>{
                    if (!d.success || !d.collections) {
                        container.innerHTML = '<div style="text-align: center; padding: 40px; color: #666;"><p>No photo collections available at the moment.</p></div>';
                        return;
                    }
                    
                    if (d.collections.length === 0) {
                        container.innerHTML = '<div style="text-align: center; padding: 40px; color: #666;"><p>No photo collections found.</p></div>';
                        return;
                    }
                    
                    // Process collections sequentially to maintain order
                    const processCollections = async () => {
                        for (const col of d.collections) {
                            try {
                                const itemsResponse = await fetch(`../admin/handler/admin_gallery_photo_handler.php?action=fetch_items&collection_id=${col.id}`);
                                const items = await itemsResponse.json();
                                
                                if (!items.success || !items.photos || items.photos.length === 0) continue;
                                
                                const wrap = document.createElement('div');
                                wrap.className = 'cg-container';
                                wrap.innerHTML = `
                                    <h2>${col.name}</h2>
                                    <p>${col.description || ''}</p>
                                    <div class="cg-grid">
                                        <button class="gallery-arrow left" aria-label="Previous"><i class="fa-solid fa-angle-left"></i></button>
                                        <button class="gallery-arrow right" aria-label="Next"><i class="fa-solid fa-angle-right"></i></button>
                                        <div class="gallery-track photos"></div>
                                    </div>`;
                                
                                const track = wrap.querySelector('.gallery-track');
                                // Photos are already ordered by sort_order in the handler
                                items.photos.forEach(p => {
                                    const card = document.createElement('div');
                                    card.className = 'cg-card';
                                    card.innerHTML = `<a href="${p.image_path}"><img src="${p.image_path}" alt=""></a>`;
                                    track.appendChild(card);
                                });
                                
                                container.appendChild(wrap);
                                
                                // Setup gallery slider for this newly added grid
                                setupGallerySlider(
                                    wrap.querySelector('.cg-grid'),
                                    '.cg-card',
                                    '.gallery-arrow.left',
                                    '.gallery-arrow.right',
                                    getGalleryVisibleCount()
                                );
                            } catch (error) {
                                // Error processing collection
                            }
                        }
                    };
                    
                    processCollections();
                })
                .catch(error => {
                    // Error fetching collections
                    container.innerHTML = '<div style="text-align: center; padding: 40px; color: #e74c3c;"><p>Failed to load gallery collections. Please try again later.</p></div>';
                });
        });
    </script>

    <script src="../scripts/components/bottom-nav.js"></script>
    <script src="../scripts/components/site-footer.js"></script>
    <script src="../scripts/script.js"></script>
    <script src="../scripts/song-bubble.js"></script>
</body>
</html>