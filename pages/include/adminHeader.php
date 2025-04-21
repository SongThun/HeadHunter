<!-- ADMIN HEADER: used for Admin pages -->
<?php
$active_state = ['home' => "", 'jobposts' => "", 'applications' => ""];
$active_state[$page] = "active-list";
?>
<header>
  <style>

  </style>
  <nav>
    <div class="navbar">
      <div class="nav-container">
        <div class="logo">
          <h2>JOB</h2>
          <h2>PORTAL</h2>
        </div>
        <div class="list">
          <a href="<?= e(BASE_URL . '/home/') ?>">Home</a>
          <a href="<?= e(BASE_URL . '/jobposts/') ?>">Job Posts</a>
          <a href="<?= e(BASE_URL . '/applications/') ?>">Applications</a>
         
          <!-- <button data-href="<?= e(BASE_URL . '/home/') ?>" class="sub-list <?= $active_state['home'] ?>">Home</button>
          <button data-href="<?= e(BASE_URL . '/jobposts/') ?>" class="sub-list <?= $active_state['jobposts'] ?>">Job Post</button>
          <button data-href="<?= e(BASE_URL . '/applications/') ?>" class="sub-list <?= $active_state['applications'] ?>">Applications</button> -->
        </div>
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
          <li><button data-href="<?= e(BASE_URL . '/home/') ?>" class="sub-list <?= $active_state['home'] ?>">Home</button></li>
          <li><button data-href="<?= e(BASE_URL . '/jobposts/') ?>" class="sub-list <?= $active_state['jobposts'] ?>">Job Post</button></li>
          <li><button data-href="<?= e(BASE_URL . '/applications/') ?>" class="sub-list <?= $active_state['applications'] ?>">Applications</button></li>
          <li><button data-href="<?= e(API . "/auth?action=logout") ?>" class="nav-btn-sign-up">Log out</button></li>
        </ul>
      </div>
    </div>
  </nav>
</header>

<!-- Script handle responsive navbar -->
<script>
  const buttons = document.querySelectorAll('.list .sub-list, .mobile-menu button');
  buttons.forEach((btn) => {
    btn.addEventListener('click', () => {
      const dest = btn.dataset.href;
      if (dest) window.location.href = dest;
    });
  });

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