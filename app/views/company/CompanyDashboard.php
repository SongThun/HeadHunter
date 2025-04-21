<div class="container-fluid">
  <div class="row">
    <!-- Sidebar -->
    <div class="col-md-2 col-lg-2 sidebar p-3">
      <button id="company-post-create" class="create-new-btn btn w-100 mb-3">Create new job</button>
      <div class="list-group status-filter">
        <button value="all"
          class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
          All <span class="sidebar-badge badge"><?= $counts['all'] ?></span>
        </button>
        <button value="approved"
          class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
          Approved <span class="sidebar-badge badge"><?= $counts['approved'] ?></span>
        </button>
        <button value="pending"
          class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
          Pending <span class="sidebar-badge badge"><?= $counts['pending'] ?></span>
        </button>
        <button value="disapproved"
          class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
          Disapproved <span class="sidebar-badge badge"><?= $counts['disapproved'] ?></span>
        </button>
      </div>
    </div>

    <!-- Main content -->
    <div class="col-md-7 col-lg-7 p-3 main-content">
      <div class="row mb-3 align-items-center">
        <div class="col-auto d-lg-none">
          <button class="navbar-toggler" type="button" onclick="toggleSidebar()">
            <i class="bi bi-list-nested"></i>
          </button>
        </div>

        <!-- search bar -->
        <div class="col">
          <div class="search-box">
            <i class="fa-solid fa-magnifying-glass"></i>
            <input type="text" class="form-control" placeholder="Search job posts">
          </div>
        </div>

        <!-- sort bar -->
        <div class="col-auto sort-section d-flex align-items-center">
          <!-- <i class="fa-solid fa-sliders me-2 sort-icon"></i> -->
          <select id="company-sort" class="form-select sort-choices" name="sort">
            <option value="CreatedDate DESC" selected>Sort newest</option>
            <option value="CreatedDate ASC" oldest">Sort oldest</option>
          </select>
        </div>

      </div>

      <!-- Job posts grid -->
      <div id="company-job-display" class="container card-display">
        
      </div>

      <!-- Pagination -->
      <div class="container-pagination"></div>

    </div>

    <!-- Right section -->
    <div class="col-md-3 col-lg-3 p-3">
      <!-- Company information -->
      <div class="company-info mb-4 d-flex flex-column align-items-center">
        <img src="https://images.icon-icons.com/167/PNG/512/nvidia_23133.png" alt="Company Logo" class="mb-2"
          style="width: 120px; height: 120px;">
        <h4><?= $_SESSION['displayName'] ?></h4>
        <div class="company-info_notification d-flex flex-column align-items-center">
          <!-- <p>10 jobs post last week</p>
          <p>150 approved applicants last week</p> -->
        </div>

      </div>
      <!-- Notifications -->
      <div class="notifications">
        <h4 class="mb-4">Notification</h4>
        <?php foreach ($notis as $noti): ?>
          <div data-id="<?= $noti['PostID'] ?>" class="notification-item d-flex justify-content-between">
            <span><?= $noti['Description'] ?></span>
            <span><?= $noti['Type'] ?></span>
          </div>
        <?php endforeach; ?>
      </div>

    </div>
  </div>
</div>

<script>
  const createbtn = document.querySelector("#company-post-create");
  createbtn.addEventListener('click', () => {
    window.location.href = `${window.BASE_URL}/jobpost/add/`;
  })

  function toggleSidebar() {
    const sidebar = document.querySelector('.sidebar');
    sidebar.classList.toggle('active');
  }
  // Đóng sidebar khi nhấp ra ngoài
  document.addEventListener('click', function(event) {
    const sidebar = document.querySelector('.sidebar');
    const toggler = document.querySelector('.navbar-toggler');
    if (!sidebar.contains(event.target) && !toggler.contains(event.target)) {
      sidebar.classList.remove('active');
    }
  });
</script>

<script src="<?= SCRIPT_PATH ?>/pagination.js"></script>
<script src="<?= SCRIPT_PATH ?>/utils.js"></script>
<script>
  const loadSuccess = (job) => {
    return `<div class="row job-card" data-id="${job.ID}" data-name="${escapeHTML(job.Postname)}">
          <div class="col-12">
            <div class="d-flex justify-content-between">
              <h5>${escapeHTML(job.Postname)}</h5>
              <span class="badge job-status-${escapeHTML(job.Status)}">${escapeHTML(job.Status)}</span>
            </div>
            <p class="mb-1">
              <i class="bi bi-calendar3"></i> ${formatDate(job.CreatedDate)} - ${formatDate(job.Due)}
              <i class="ml-4 bi bi-geo-alt"></i> ${escapeHTML(job.Location)}
            </p>
            <p class="mb-1">
              ${escapeHTML(job.Description)}
            </p>
          </div>
        </div>
      `;
  }
  const loadFail = () => {
    return `<div class="no-jobs-found">
              <h3>No job posts found</h3>
              <p>Try adjusting your search criteria</p>
            </div>`;
  }

  const destGen = (id, name) => {
    return window.BASE_URL + '/jobpost/view/' + `${slugify(name)}-${id}`
  }
  
  state.filter.id = "<?= $_SESSION['userid'] ?>";

  const loadPost = getLoader(loadSuccess, loadFail, destGen);

  document.addEventListener('DOMContentLoaded', () => {
    loadPost(state.sort, state.filter, 1);
  })
</script>