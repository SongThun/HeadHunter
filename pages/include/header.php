<header>
  <nav>
    <div class="navbar container-fluid">
      <div class="logo">
        <div><a href="<?= e(BASE_URL . '/home/') ?>" data-scroll="#home" class="scroll-link">
            <h2 style="margin: 0; max-width: fit-content;cursor: pointer;">JOB</h2>
          </a></div>
        <div><a href="<?= e(BASE_URL . '/home/') ?>" data-scroll="#home" class="scroll-link">
            <h2 style="margin: 0; max-width: fit-content;cursor: pointer;">PORTAL</h2>
          </a></div>
      </div>
      <div class="list">
        <button data-href="<?= e(BASE_URL . '/home/') ?>" data-scroll="#home" class="sub-list <?= $active_state['home'] ?>">Home</button>
        <button data-href="<?= e(BASE_URL . '/jobposts/') ?>" class="sub-list <?= $active_state['jobposts'] ?>">Job Listing</button>
        <button data-href="<?= e(BASE_URL . '/help/') ?>" data-scroll="#help" class="sub-list <?= $active_state['help'] ?>">Help</button>
        <button data-href="<?= e(BASE_URL . '/contact/') ?>" data-scroll="#contact" class="sub-list <?= $active_state['contact'] ?>">Contact</button>
      </div>
      <div class="sign-up-in">
        <?php if ($role == 'guest'): ?>
          <button data-href="<?= e(BASE_URL . '/signin/') ?>" class="nav-btn-sign-in">Sign in</button>
          <button data-href="<?= e(BASE_URL . '/signup/') ?>" class="nav-btn-sign-up">Sign up</button>
        <?php else: ?>
          <button data-href="<?= e(API . '/auth?action=logout') ?>" class="nav-btn-sign-up">Logout</button>
        <?php endif; ?>
      </div>
      <!-- Mobile toggle -->
      <div class="avatar-toggle">
        <button class="toggle-btn" aria-label="Toggle menu">
          <i class="bi bi-chevron-down"></i>
        </button>
      </div>
    </div>
    <!-- Mobile menu -->
    <div class="mobile-menu">
      <ul>
        <li><button data-href="<?= e(BASE_URL . '/home/') ?>" data-scroll="#home" class="sub-list <?= $active_state['home'] ?>">Home</button></li>
        <li><button data-href="<?= e(BASE_URL . '/jobposts/') ?>" class="sub-list <?= $active_state['jobposts'] ?>">Job Listing</button></li>
        <li><button data-href="<?= e(BASE_URL . '/help/') ?>" data-scroll="#help" class="sub-list <?= $active_state['help'] ?>">Help</button></li>
        <li><button data-href="<?= e(BASE_URL . '/contact/') ?>" data-scroll="#contact" class="sub-list <?= $active_state['contact'] ?>">Contact</button></li>
        <?php if ($role == 'guest'): ?>
          <li><button data-href="<?= e(BASE_URL . '/signin/') ?>" class="nav-btn-sign-in">Sign in</button></li>
          <li><button data-href="<?= e(BASE_URL . '/signup/') ?>" class="nav-btn-sign-up">Sign up</button></li>
        <?php else: ?>
          <li><button data-href="<?= e(API . '/auth?action=logout') ?>" class="nav-btn-sign-up">Logout</button></li>
        <?php endif; ?>
      </ul>
    </div>
  </nav>
</header>

<script>
  const buttons = document.querySelectorAll('.list .sub-list, .sign-up-in button, .mobile-menu button, .scroll-link');
  buttons.forEach((btn) => {
    btn.addEventListener('click', (e) => {
      e.preventDefault();
      const dest = btn.dataset.href;
      const scrollTarget = btn.dataset.scroll;

      // Kiểm tra nếu đang ở trang home (guest.php?page=home hoặc mặc định)
      const isHomePage = window.location.search.includes('page=home') || window.location.search === '';
      if (scrollTarget && isHomePage) {
        const element = document.querySelector(scrollTarget);
        if (element) {
          window.scrollTo({
            top: element.offsetTop - 60, // Trừ 60px để tránh header sticky
            behavior: 'smooth'
          });
          // Đóng menu mobile nếu đang mở
          const mobileMenu = document.querySelector('.mobile-menu');
          mobileMenu.classList.remove('show');
        }
      } else if (dest) {
        // Chuyển hướng nếu không ở trang home hoặc không có scrollTarget
        window.location.href = dest;
      }
    });
  });

  // Xử lý toggle menu mobile
  const toggleBtn = document.querySelector('.toggle-btn');
  const mobileMenu = document.querySelector('.mobile-menu');
  toggleBtn.addEventListener('click', () => {
    mobileMenu.classList.toggle('show');
  });

  // Đóng menu khi click ra ngoài
  document.addEventListener('click', (e) => {
    if (!mobileMenu.contains(e.target) && !toggleBtn.contains(e.target)) {
      mobileMenu.classList.remove('show');
    }
  });
</script>