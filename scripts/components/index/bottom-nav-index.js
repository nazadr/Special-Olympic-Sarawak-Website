// Reusable HTML Element written in JavaScript.
// Compatible with index page only.

document.writeln(`
    <footer class="bottom-nav-legacy desktop-only">
  <ul>
    <li class="nav-item">
      <button class="nav-btn"><span>What We Do?</span></button>
      <div class="dropup-menu">
        <a href="src/getting_started.php">Getting Started</a>
        <a href="src/alp.php">Athlete Leadership Program (ALP)</a>
        <a href="src/yap.php">Young Athletes Program (YAP)</a>
      </div>
    </li>
    <li class="nav-item">
      <button class="nav-btn"><span>Core Program</span></button>
      <div class="dropup-menu">
        <a href="src/sohap.php">Healthy Athletes Program (HAP)</a>
      </div>
    </li>
    <li class="nav-item">
      <button class="nav-btn"><span>Sports</span></button>
      <div class="dropup-menu">
        <a href="src/sport.php">Our Sports</a>
      </div>
    </li>
    <li class="nav-item">
      <button class="nav-btn"><span>Events</span></button>
      <div class="dropup-menu">
        <a href="src/state-games.php">State Games</a>
        <a href="src/event_calendar.php">Events Calendar</a>
      </div>
    </li>
    <li class="nav-item">
      <button class="nav-btn"><span>Affiliate</span></button>
      <div class="dropup-menu">
        <a href="src/sarawak-chapters.php">Sarawak Chapters</a>
        <a href="src/sponsorships.php">Sponsorships</a>
        <a href="src/other-so.php">Other Special Olympics</a>
      </div>
    </li>
    <li class="nav-item">
      <button class="nav-btn"><span>Gallery</span></button>
      <div class="dropup-menu">
        <a href="src/gallery-photos.php">Photos</a>
        <a href="src/gallery-videos.php">Videos</a>
      </div>
    </li>
    <li class="nav-item">
      <button class="nav-btn"><span>Join Us</span></button>
      <div class="dropup-menu">
        <a href="src/join_us.php">Join Us</a>
      </div>
    </li>
  </ul>
</footer>
`)