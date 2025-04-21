<!-- COMPANY HEADER: used for User pages -->

<header>
  <nav>
    <div class="navbar">
      <div class="logo">
        <h2>JOB</h2>
        <h2>PORTAL</h2>
      </div>
      
      <div class="info-desktop">
      <img src="<?= e($avatarLink) ?>" alt="Avatar" class="avatar">
      <a href="<?= e(API . "/auth?action=logout")?>">Log out</a>
      </div>

      <div class="avatar-toggle">
        <img src="<?= e($avatarLink) ?>" alt="Avatar" class="avatar">
        <button class="toggle-btn" aria-label="Toggle menu">
          <i class="bi bi-chevron-down"></i>
        </button>
      </div>

      <div class="mobile-menu">
        <ul>
          <li><a href="<?= e(API . "/auth?action=logout") ?>" >Log out</a></li>
        </ul>
      </div>
    </div>
  </nav>
</header>

<!-- Script handle responsive navbar -->
<script>
  const toggleBtn = document.querySelector('.toggle-btn');
  const mobileMenu = document.querySelector('.mobile-menu');
  toggleBtn.addEventListener('click', () => {
    mobileMenu.classList.toggle('show');
  });

  document.addEventListener('click', (e) => {
    if (!mobileMenu.contains(e.target) && !toggleBtn.contains(e.target)) {
      mobileMenu.classList.remove('show');
    }
  });
</script>