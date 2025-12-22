// song-bubble.js
// Floating SONG 2026 nav bubble for all main pages
// Usage: Call createSongBubble() after DOMContentLoaded

(function() {
    // Configurable options
    var bubbleConfig = {
        link: 'SONG 26.php',
        icon: "assets/icons/bintulu-stork.png", // Use relative path from main pages
        tooltip: 'SONG 2026 page',
        bubbleColor: '#d90429',
        iconColor: 'invert(1)', // white
        hoverBubbleColor: '#fff',
        hoverIconColor: 'invert(16%) sepia(99%) saturate(7490%) hue-rotate(-5deg) brightness(97%) contrast(119%)', // red
        size: 64,
        iconSize: 32,
        left: 32,
        zIndex: 100
    };

    // Detect if current page is in src/ folder
    var isSrcPage = window.location.pathname.match(/\/src\//);
    bubbleConfig.icon = isSrcPage ? '../assets/icons/bintulu-stork.png' : 'assets/icons/bintulu-stork.png';

    // Robust path detection for SONG 26.php (no src/ in link, only for logo if needed)
    var songPage = 'SONG 26.php';
    var songLink = '';
    var pathParts = window.location.pathname.split('/');
    // If already on SONG 26.php (anywhere), disable link
    if (pathParts[pathParts.length - 1] === songPage) {
        songLink = '#';
    } else if (window.location.pathname.endsWith('/' + songPage)) {
        songLink = '#';
    } else {
        // If on root, link to SONG 26.php; if in src/, link to ../src/SONG 26.php
        if (isSrcPage) {
            songLink = 'SONG 26.php';
        } else {
            songLink = 'src/SONG 26.php';
        }
    }
    bubbleConfig.link = songLink;

    function createSongBubble(config) {
        if (document.querySelector('.song26-nav-bubble')) return; // Prevent duplicate
        var bubble = document.createElement('a');
        bubble.className = 'song26-nav-bubble';
        bubble.href = config.link;
        bubble.setAttribute('aria-label', 'Go to SONG 26');
        bubble.style.position = 'fixed';
        bubble.style.top = '50%';
        bubble.style.left = config.left + 'px';
        bubble.style.transform = 'translateY(-50%)';
        bubble.style.zIndex = config.zIndex;
        bubble.style.width = config.size + 'px';
        bubble.style.height = config.size + 'px';
        bubble.style.background = config.bubbleColor;
        bubble.style.borderRadius = '50%';
        bubble.style.boxShadow = '0 4px 16px rgba(0,0,0,0.12)';
        bubble.style.display = 'flex';
        bubble.style.alignItems = 'center';
        bubble.style.justifyContent = 'center';
        bubble.style.transition = 'background 0.3s, box-shadow 0.3s';
        bubble.style.cursor = 'pointer';
        bubble.style.border = 'none';
        bubble.style.outline = 'none';
        bubble.style.animation = 'bubble-pop-in 0.6s cubic-bezier(.68,-0.55,.27,1.55)';

        // Icon
        var icon = document.createElement('img');
        icon.src = config.icon;
        icon.alt = 'SONG 26';
        icon.className = 'song26-bubble-icon';
        icon.style.width = config.iconSize + 'px';
        icon.style.height = config.iconSize + 'px';
        icon.style.filter = config.iconColor;
        icon.style.transition = 'filter 0.3s';
        bubble.appendChild(icon);

        // Tooltip
        var tooltip = document.createElement('span');
        tooltip.className = 'song26-bubble-tooltip';
        tooltip.textContent = config.tooltip;
        tooltip.style.position = 'absolute';
        tooltip.style.left = (config.size + 16) + 'px';
        tooltip.style.top = '50%';
        tooltip.style.transform = 'translateY(-50%) scale(0.95)';
        tooltip.style.background = config.bubbleColor;
        tooltip.style.color = '#fff';
        tooltip.style.padding = '8px 18px';
        tooltip.style.borderRadius = '24px';
        tooltip.style.fontSize = '1rem';
        tooltip.style.fontFamily = 'Inter, sans-serif';
        tooltip.style.whiteSpace = 'nowrap';
        tooltip.style.opacity = '0';
        tooltip.style.pointerEvents = 'none';
        tooltip.style.transition = 'opacity 0.25s, transform 0.25s, background 0.3s, color 0.3s';
        tooltip.style.boxShadow = '0 2px 8px rgba(0,0,0,0.10)';
        bubble.appendChild(tooltip);

        // Hover effect
        bubble.addEventListener('mouseenter', function() {
            bubble.style.background = config.hoverBubbleColor;
            bubble.style.boxShadow = '0 8px 24px rgba(217,4,41,0.18)';
            icon.style.filter = config.hoverIconColor;
            tooltip.style.opacity = '1';
            tooltip.style.transform = 'translateY(-50%) scale(1)';
            tooltip.style.background = config.hoverBubbleColor;
            tooltip.style.color = config.bubbleColor;
        });
        bubble.addEventListener('mouseleave', function() {
            bubble.style.background = config.bubbleColor;
            bubble.style.boxShadow = '0 4px 16px rgba(0,0,0,0.12)';
            icon.style.filter = config.iconColor;
            tooltip.style.opacity = '0';
            tooltip.style.transform = 'translateY(-50%) scale(0.95)';
            tooltip.style.background = config.bubbleColor;
            tooltip.style.color = '#fff';
        });

        // Keyframes for pop-in animation
        var style = document.createElement('style');
        style.textContent =
            '@keyframes bubble-pop-in {'+
            '0% { transform: scale(0.5) translateY(-50%); opacity: 0; }'+
            '60% { transform: scale(1.1) translateY(-50%); opacity: 1; }'+
            '100% { transform: scale(1) translateY(-50%); opacity: 1; }'+
            '}';
        document.head.appendChild(style);

        document.body.appendChild(bubble);
    }

    // Expose to global
    window.createSongBubble = function() {
        createSongBubble(bubbleConfig);
    };

    // Auto-init on DOMContentLoaded
    document.addEventListener('DOMContentLoaded', function() {
        window.createSongBubble();
    });
})();
