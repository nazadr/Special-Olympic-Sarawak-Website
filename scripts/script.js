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
if (navRightMenu) {
  navRightMenu.querySelectorAll('a').forEach(link => {
    link.addEventListener('click', () => {
      // Check if the link is not a dropdown toggle (i.e., it's a final destination link)
      // This prevents the menu from closing when a dropdown is just being opened.
      if (!link.closest('.dropdown')) { // If it's not part of a dropdown parent
        if (hamburgerIcon) hamburgerIcon.classList.remove('open');
        if (navRightMenu) navRightMenu.classList.remove('open');
      }
    });
  });
}

// Close menu if screen resized from mobile to desktop 
window.addEventListener('resize', () => {
  if (window.innerWidth > 1299) {
    hamburgerIcon.classList.remove('open');
    navRightMenu.classList.remove('open');
  }
});

// Mobile dropdown hamburger menu
const mobileDropdownParents = document.querySelectorAll('.mobile-dropdown-parent');
mobileDropdownParents.forEach(parentItem => {
  const dropdownToggleLink = parentItem.querySelector('a');
  const dropdownSubMenu = parentItem.querySelector('.mobile-dropdown-submenu');
  if (dropdownToggleLink && dropdownSubMenu) {
    dropdownToggleLink.addEventListener('click', (e) => {
      e.preventDefault(); // Prevent default link behavior
      parentItem.classList.toggle('open'); // Toggle the 'open' class on the parent li
    });
  }
});

// Chatbot toggle functionality (existing code)
const toggleBtn = document.querySelector('.chatbot-toggle');
const chatWindow = document.getElementById('chatbot-window');
const input = document.getElementById('chat-input');
const messages = document.getElementById('chat-messages');
// Toggle chatbot open/close
if (toggleBtn && chatWindow) {
  toggleBtn.addEventListener('click', (e) => {
    e.stopPropagation(); // Prevent closing immediately after open
    chatWindow.classList.toggle('open');
  });
}
// Click outside to close
document.addEventListener('click', (e) => {
  const isClickInsideChatbot = (chatWindow && chatWindow.contains(e.target)) || (toggleBtn && toggleBtn.contains(e.target));
  const isClickInsideNav = (navRightMenu && navRightMenu.contains(e.target)) || (hamburgerIcon && hamburgerIcon.contains(e.target)); // Added for nav
  if (!isClickInsideChatbot && !isClickInsideNav) { // Check both
    if (chatWindow) chatWindow.classList.remove('open');
    // Also close the nav menu if clicked outside
    if (hamburgerIcon) hamburgerIcon.classList.remove('open');
    if (navRightMenu) navRightMenu.classList.remove('open');
  }
});

// Send message on Enter of chat bot (experimental)
if (input && messages) {
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
}

// Footer Dropdown for Mobile Navigation (optional, not implemented yet)
const actionBtn = document.querySelector(".footer-navigation"); // actionBtn
const navGroup = document.querySelector(".nav-group"); // dropdown

if (actionBtn && navGroup) {
  actionBtn.addEventListener("click", (e) => {
    e.stopPropagation();
    navGroup.classList.toggle("hide");
  });

  window.addEventListener("click", () => {
    navGroup.classList.add("hide");
  });
}

/* Initial Search function implementation (not working yet) */
/* When the user clicks on the button, toggle between hiding and showing the dropdown content */
function myFunction() {
  document.getElementById("top-right-menu", "dropup-menu").classList.toggle("show");
}

function filterFunction() {
  const input = document.getElementById("search-input");
  if (!input) return;
  
  const filter = input.value.toUpperCase();
  const div = document.getElementById("myDropdown");
  if (!div) return;
  
  const a = div.getElementsByTagName("a");
  for (let i = 0; i < a.length; i++) {
    const txtValue = a[i].textContent || a[i].innerText;
    if (txtValue.toUpperCase().indexOf(filter) > -1) {
      a[i].style.display = "";
    } else {
      a[i].style.display = "none";
    }
  }
}

// ----- GETTING STARTED -----
// Simple JavaScript for the zoom animation (already implemented via CSS)
// Additional interactive elements can be added here if needed

// Smooth scrolling for anchor links
document.querySelectorAll('a[href^="#"]').forEach(anchor => {
  anchor.addEventListener('click', function (e) {
    e.preventDefault();
    const target = document.querySelector(this.getAttribute('href'));
    if (target) {
      target.scrollIntoView({
        behavior: 'smooth'
      });
    }
  });
});