<nav class="navbar navbar-expand-lg navbar-light bg-dark">
  <div class="container-fluid">
    <a class="navbar-brand text-primary" href="/">
      <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/1/19/Spotify_logo_without_text.svg/2048px-Spotify_logo_without_text.svg.png" width="30" height="30" class="d-inline-block align-top" alt="spotify logo">
      nKode / Spotify Radio
    </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon" style="filter: invert(69%) sepia(83%) saturate(5242%) hue-rotate(2deg) brightness(105%) contrast(103%);"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav">
        <li class="nav-item <?php if (CurrentFileName() == "index.php") { echo "active";} ?>">
          <a class="nav-link text-primary" href="/">Home</a>
        </li>
        <li class="nav-item <?php if (CurrentFileName() == "admin.php") { echo "active";} ?>">
          <a class="nav-link text-primary" href="/admin">Room Admin</a>
        </li>
        <li class="nav-item <?php if (CurrentFileName() == "faq.php") { echo "active";} ?>">
          <a class="nav-link text-primary" href="/faq">FAQ</a>
        </li>
        <li class="nav-item <?php if (CurrentFileName() == "privacy.php") { echo "active";} ?>">
          <a class="nav-link text-primary" href="/privacy">Privacy</a>
        </li>
        <li class="nav-item">
          <a class="nav-link text-primary" href="https://github.com/joevandebilt/SpotifyRadio" target="_blank">Source Code</a>
        </li>
      </ul>
    </div>
  </div>
</nav>