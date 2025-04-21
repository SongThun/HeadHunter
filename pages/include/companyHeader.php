<!-- COMPANY HEADER: used for User pages -->

<!-- <header style="height: 3rem;"> -->
<header style="height: 3rem;">
  <nav>
    <div class="navbar">
      <div class="logo">
        <h2>JOB</h2>
        <h2>PORTAL</h2>
      </div>
      
      <div class="info-desktop">
        <div class="dropdown">
          <button class="btn dropdown-toggle border-0" type="button" data-bs-toggle="dropdown" aria-expanded="false">
            <!-- Ảnh công ty, thay nếu cần -->
            <!-- <img class="avatar" src="<?= $avatarLink?>" alt="avatar" style="width: 10%; height: 10%; border-radius: 50%;"> -->
            <img class="avatar" src="<?= $avatarLink?>" alt="avatar" style="width: 10%; height: 10%; border-radius: 50%;">
            <i class="bi bi-chevron-down"></i>
          </button>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item text-centered" href="<?= API ?>/auth?action=logout">Log out</a></li>
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
          <li><a href="<?= API ?>/auth?action=logout">Log out</a></li>
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