<nav class="nav nav-pills nav-fill flex-column mt-2">
  <a class="nav-link <?php if (CurrentFileName() == "index.php") { echo "active";} ?>" href="/">
    <i class="fas fa-home"></i> 
    <span class="d-none d-sm-block">Home</span>
  </a>
  <a class="nav-link <?php if (CurrentFileName() == "admin.php") { echo "active";} ?>" href="/admin">
    <i class="fas fa-users-cog"></i> 
    <span class="d-none d-sm-block">Admin</span>
  </a>
  <a class="nav-link <?php if (CurrentFileName() == "faq.php") { echo "active";} ?>" href="/faq">
    <i class="fas fa-question"></i> 
    <span class="d-none d-sm-block">FAQ</span>
  </a>
  <a class="nav-link <?php if (CurrentFileName() == "privacy.php") { echo "active";} ?>" href="/privacy">
    <i class="fas fa-user-secret"></i> 
    <span class="d-none d-sm-block">Privacy</span>
  </a>
  <a class="nav-link" href="https://github.com/joevandebilt/SpotifyRadio">
    <i class="fab fa-github"></i> 
    <span class="d-none d-sm-block">Source Code</span>
  </a>
</nav>