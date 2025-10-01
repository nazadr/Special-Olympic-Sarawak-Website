// No additional JS needed for basic animation, but you can add interactivity here if desired.
//drop up menu functionality
function attachDropupMenuListeners() {
  // Existing desktop dropup menu logic (no change needed for mobile hamburger)
  document.querySelectorAll('.nav-item').forEach(item => {
    const btn = item.querySelector('.nav-btn');
    const menu = item.querySelector('.dropup-menu');
    let timeout;
    function openMenu() {
      clearTimeout(timeout);
      item.classList.add('open');
    }
    function closeMenu() {
      timeout = setTimeout(() => {
        item.classList.remove('open');
      }, 250);
    }

    // Only attach mouseenter/mouseleave for desktop (or if you want hover on mobile too)
    // For mobile, dropdowns will typically open on click.
    if (btn && menu && window.innerWidth > 900) { // Apply only for desktop
      btn.addEventListener('mouseenter', openMenu);
      btn.addEventListener('mouseleave', closeMenu);
      menu.addEventListener('mouseenter', openMenu);
      menu.addEventListener('mouseleave', closeMenu);
    }
    // For mobile, you might want to toggle dropdowns on click of the parent link
    if (btn && menu && window.innerWidth <= 900) {
        btn.addEventListener('click', (e) => {
            e.preventDefault(); // Prevent default link behavior
            item.classList.toggle('open'); // Toggle the 'open' class for the dropup menu
        });
    }
  });
}

// Attach listeners on initial load (for static HTML)
attachDropupMenuListeners();
// --- Hamburger Menu Functionality ---
const hamburgerIcon = document.getElementById('hamburger-icon');
const navRightMenu = document.getElementById('nav-right-menu');
if (hamburgerIcon && navRightMenu) {
  hamburgerIcon.addEventListener('click', () => {
    hamburgerIcon.classList.toggle('open'); // Toggles the 'X' animation
    navRightMenu.classList.toggle('open');   // Toggles the slide-in menu
  });
}
// Close menu when a link is clicked (optional, but good for UX)
navRightMenu.querySelectorAll('a').forEach(link => {
  link.addEventListener('click', () => {
    // Check if the link is not a dropdown toggle (i.e., it's a final destination link)
    // This prevents the menu from closing when a dropdown is just being opened.
    if (!link.closest('.dropdown')) { // If it's not part of a dropdown parent
        hamburgerIcon.classList.remove('open');
        navRightMenu.classList.remove('open');
    }
  });
});

// Close menu if screen resized from mobile to desktop
window.addEventListener('resize', () => {
  if (window.innerWidth > 900) {
    hamburgerIcon.classList.remove('open');
    navRightMenu.classList.remove('open');
  }
});
// Chatbot toggle functionality (existing code)
const toggleBtn = document.querySelector('.chatbot-toggle');
const chatWindow = document.getElementById('chatbot-window');
const input = document.getElementById('chat-input');
const messages = document.getElementById('chat-messages');
// Toggle chatbot open/close
toggleBtn.addEventListener('click', (e) => {
  e.stopPropagation(); // Prevent closing immediately after open
  chatWindow.classList.toggle('open');
});
// Click outside to close
document.addEventListener('click', (e) => {
  const isClickInsideChatbot = chatWindow.contains(e.target) || toggleBtn.contains(e.target);
  const isClickInsideNav = navRightMenu.contains(e.target) || hamburgerIcon.contains(e.target); // Added for nav
  if (!isClickInsideChatbot && !isClickInsideNav) { // Check both
    chatWindow.classList.remove('open');
    // Also close the nav menu if clicked outside
    hamburgerIcon.classList.remove('open');
    navRightMenu.classList.remove('open');
  }
});

// Send message on Enter of chat bot (experimental)
input.addEventListener('keydown', function (e) {
  if (e.key === 'Enter') {
    const text = this.value.trim();
    if (!text) return;
    messages.innerHTML += `<p class="user-msg">${text}</p>`;
    this.value = '';
    setTimeout(() => {
      messages.innerHTML += `<p class="bot-msg">This is a sample response.</p>`;
      messages.scrollTop = messages.scrollHeight;
    }, 500);
  }
});

// fade-in and fade-out transitions for page navigation experimental
window.addEventListener('DOMContentLoaded', () => {
  document.body.classList.add('fade-in');
  const links = document.querySelectorAll('a');
  links.forEach(link => {
    if (link.hostname === location.hostname && !link.href.includes('#')) {
      link.addEventListener('click', function (e) {
        e.preventDefault();
        const href = this.getAttribute('href');
        document.body.classList.remove('fade-in');
        document.body.classList.add('fade-out');
        setTimeout(() => {
          window.location.href = href;
        }, 500);
      });
    }
  });
});