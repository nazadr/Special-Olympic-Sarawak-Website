// No additional JS needed for basic animation, but you can add interactivity here if desired.

//drop up menu functionality

function attachDropupMenuListeners() {
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

    if (btn && menu) {
      btn.addEventListener('mouseenter', openMenu);
      btn.addEventListener('mouseleave', closeMenu);
      menu.addEventListener('mouseenter', openMenu);
      menu.addEventListener('mouseleave', closeMenu);
    }
  });
}

// Attach listeners on initial load (for static HTML)
attachDropupMenuListeners();

  // Chatbot toggle functionality

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
  if (!isClickInsideChatbot) {
    chatWindow.classList.remove('open');
  }
});

// Send message on Enter
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


