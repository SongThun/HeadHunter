<!-- ADMIN HEADER: used for Admin pages -->

<?php
  $active_state = ['home' => "", 'jobposts' => "", 'applications' => ""];
  $active_state[$page] = "active-list";
  $avatar = isset($_SESSION['avatar']) ? $_SESSION['avatar'] : 'default_ava.jpg';
  $avatarLink = UPLOAD_IMG . $avatar;
?>

<header>
  <nav>
    <div class="navbar">
      <div class="nav-container">
        <div class="logo">
          <h2>JOB</h2>
          <h2>PORTAL</h2>
        </div>
        <div class="list">
          <button data-href="<?= BASE_URL . 'home/' ?>" class="sub-list <?=$active_state['home']?>">Home</button>
          <button data-href="<?= BASE_URL . 'jobposts/' ?>" class="sub-list <?=$active_state['jobposts']?>">Job Post</button>
          <button data-href="<?= BASE_URL . 'applications/' ?>" class="sub-list <?=$active_state['applications']?>">Applications</button>
        </div>
      </div>
      
      <div class="info-desktop">
        <div class="dropdown">
          <button class="btn dropdown-toggle border-0" type="button" data-bs-toggle="dropdown" aria-expanded="false">
            <!-- Avatar công ty -->
            <img class="avatar" src="<?= $avatarLink?>" alt="avatar">
            <i class="bi bi-chevron-down"></i>
          </button>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="<?= API ?>auth?action=logout">Log out</a></li>
          </ul>
        </div>
      </div>

      <div class="avatar-toggle">
        <img src="<?= $avatarLink?>" alt="Avatar" class="avatar">
        <button class="toggle-btn" aria-label="Toggle menu">
          <i class="bi bi-chevron-down"></i>
        </button>
      </div>

      <div class="mobile-menu">
        <ul>
          <li><button data-href="<?= BASE_URL . 'home/' ?>" class="sub-list <?=$active_state['home']?>">Home</button></li>
          <li><button data-href="<?= BASE_URL . 'jobposts/' ?>" class="sub-list <?=$active_state['jobposts']?>">Job Post</button></li>
          <li><button data-href="<?= BASE_URL . 'applications/' ?>" class="sub-list <?=$active_state['applications']?>">Applications</button></li>
          <li><button data-href="<?= API ?>auth?action=logout" class="nav-btn-sign-up">Log out</button></li>
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