// Reusable HTML Element written in JavaScript.
// Default: Only for "position: fixed" without scroll limit
// Created on 8 Sep 2025

document.writeln(`
    <footer class="bottom-nav-legacy desktop-only">
  <ul>
    <li class="nav-item">
      <button class="nav-btn"><span>What We Do?</span></button>
      <div class="dropup-menu">
        <a href="../src/getting_started.html">Getting Started</a>
        <a href="../src/sport.html">Our Sports</a>
      </div>
    </li>
    <li class="nav-item">
      <button class="nav-btn"><span>Affiliate</span></button>
      <div class="dropup-menu">
        <a href="../src/loaffiliate_v1.html">Sarawak Chapters</a>
        <a href="../src/sponsorships.html">Sponsorships</a>
      </div>
    </li>
    <li class="nav-item">
      <button class="nav-btn"><span>Events</span></button>
      <div class="dropup-menu">
        <a href="#photos">Healthy Athletes Program (SOHAP)</a>
        <a href="#photos">Athletes Leadership Program (ALPs)</a>
        <a href="#photos">Young Athletes Program (YAP)</a>
        <a href="../src/state-games.html">State Games</a>
        <a href="../src/event_calendar.php">Events Calendar</a>
      </div>
    </li>
    <li class="nav-item">
      <button class="nav-btn"><span>Gallery</span></button>
      <div class="dropup-menu">
        <a href="#photos">Photos</a>
        <a href="#videos">Videos</a>
      </div>
    </li>
    <li class="nav-item">
      <button class="nav-btn"><span>Join Us</span></button>
      <div class="dropup-menu">
        <a href="../src/join_us.html">Join Us</a>
      </div>
    </li>
    <li class="nav-item">
      <button class="nav-btn"><span>Community</span></button>
      <div class="dropup-menu">
        <a href="#join">Program Partners</a>
        <a href="#details">Other Special Olympics</a>
      </div>
    </li>
  </ul>
</footer>
`)