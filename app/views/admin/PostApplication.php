<!-- DISPLAY APPLICATIONS FOR SPECIFIC JOB POST -->
 <style>
  body{
    display: flex;
  }
 </style>
<main style="flex: 1;">
  <div class="container-fluid">
    <div class="row">
      <!-- Sidebar -->
      <div class="col-md-2 col-lg-2 sidebar p-3">
        <!-- <button id="company-post-create" class="create-new-btn btn w-100 mb-3">Create new job</button> -->
        <div id="company-status-filter" class="list-group">
          <button value="all" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
            All <span class="sidebar-badge badge"><?= e($counts['all']) ?></span>
          </button>
          <button value="accept" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
            Accept <span class="sidebar-badge badge"><?= e($counts['accept']) ?></span>
          </button>
          <button value="pending" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
            Pending <span class="sidebar-badge badge"><?= e($counts['pending']) ?></span>
          </button>
          <button value="reject" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
            Reject <span class="sidebar-badge badge"><?= e($counts['reject']) ?></span>
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
          <div class="col">
            <div class="search-box">
              <i class="fa-solid fa-magnifying-glass"></i>
              <input type="text" class="form-control" placeholder="Search job posts">
            </div>
          </div>
          <div class="col-auto sort-section d-flex align-items-center">
            <!-- <i class="fa-solid fa-sliders me-2 sort-icon"></i> -->
            <select class="form-select sort-choices" name="sort">
              <option value="AppliedDate DESC" selected>Sort newest</option>
              <option value="AppliedDate ASC" oldest">Sort oldest</option>
            </select>
          </div>
        </div>

        <!-- Job posts grid -->
        <div id="company-job-display" class="container card-display" style="min-height: 80vh; height: 80vh;">
        </div>

        <!-- Pagination -->
        <div class="container-pagination"></div>

      </div>
    </div>
  </div>
</main>

<script src="<?= e(SCRIPT_PATH . "/pagination.js") ?>"></script>
<script src="<?= e(SCRIPT_PATH . "/utils.js") ?>"></script>
<script>
  // const createbtn 
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

<script>
  const loadSuccess = (app) => {
    return `
    <div class="col-12 job-card" data-id="${app.ID}" data-name="${app.Fullname}">
      <div class="d-flex justify-content-between">
        <h5>${escapeHTML(app.Fullname)}</h5>
        <span class="badge job-status-pending">${escapeHTML(app.Status)}</span>
      </div>
      <p class="mb-1">
        <i class="bi bi-calendar3"></i> ${formatDate(app.AppliedDate)}
        <i class="ml-4 bi bi-geo-alt"></i> ${escapeHTML(app.Location)}
      </p>
      <p class="mb-1">
        ${app.Cover.length > 50 ? app.Cover.substring(0, 50) + '...' : app.Cover}
      </p>
    </div>
  `;
  }
  const loadFail = () => {
    return `<div class="no-jobs-found">
            <h3>No applications found</h3>
          </div>`;
  }
  const destGen = (id, name) => {
    return window.location.href + slugify(name) + '-' + id;
  }
  const url = `${window.API}/application`;
  const loadPost = getLoader(loadSuccess,loadFail,destGen, url);
  state.filter.postid = "<?= e($postid) ?>";

  document.addEventListener('DOMContentLoaded', () => {
    loadPost(state.sort, state.filter, 1);
  })
</script>