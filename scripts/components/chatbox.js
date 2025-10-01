// No priority. Optional feature.
// Reusable HTML Element written in JavaScript
// Created on 8 Sep 2025

document.writeln(`
    <div class="chatbot-container">
  <button class="chatbot-toggle">💬</button>
  <div class="chatbot-window" id="chatbot-window">
    <div class="chatbot-header">Chat Assistant</div>
    <div class="chatbot-messages" id="chat-messages">
      <p class="bot-msg">Hi there! How can I help you?</p>
    </div>
    <input type="text" id="chat-input" class="chatbot-input" placeholder="Type your message...">
  </div>
</div>
`)