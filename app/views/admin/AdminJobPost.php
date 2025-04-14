<div class="container-fluid">
  <div class="row">
    <!-- Sidebar -->
    <div class="col-md-2 col-lg-2 sidebar p-3 mt-3">
      <button id="admin-post-create" class="create-new-btn btn w-100 mb-3">Create new job</button>
      <div class="list-group">
        <a href="?status=all"
          class="list-group-item list-group-item-action d-flex justify-content-between align-items-center <?= ($_GET['status'] ?? '') === 'all' ? 'active' : '' ?>">
          All <span class="sidebar-badge badge"><?= $statusCounts['all'] ?></span>
        </a>
        <a href="?status=approved"
          class="list-group-item list-group-item-action d-flex justify-content-between align-items-center <?= ($_GET['status'] ?? '') === 'approved' ? 'active' : '' ?>">
          Approved <span class="sidebar-badge badge"><?= $statusCounts['approved'] ?></span>
        </a>
        <a href="?status=pending"
          class="list-group-item list-group-item-action d-flex justify-content-between align-items-center <?= empty($_GET['status']) || ($_GET['status'] ?? '') === 'pending' ? 'active' : '' ?>">
          Pending <span class="sidebar-badge badge"><?= $statusCounts['pending'] ?></span>
        </a>
        <a href="?status=disapproved"
          class="list-group-item list-group-item-action d-flex justify-content-between align-items-center <?= ($_GET['status'] ?? '') === 'disapproved' ? 'active' : '' ?>">
          Disapproved <span class="sidebar-badge badge"><?= $statusCounts['disapproved'] ?></span>
        </a>
      </div>
    </div>

    <!-- Main content -->
    <div class="col-md-9 col-lg-10 p-2">
      <div class="main-content">
        <div class="row mb-3 align-items-center">
          <div class="col">
            <div class="search-box">
              <i class="fa-solid fa-magnifying-glass"></i>
              <input type="text" class="form-control" placeholder="Search company">
            </div>
          </div>
          <div class="col-auto sort-section d-flex align-items-center">
            <i class="fa-solid fa-sliders me-2 sort-icon"></i>
            <select class="form-select sort-choices" name="sort" id="app-sort">
              <option value="CreatedDate ASC">Oldest</option>
              <option value="CreatedDate DESC" selected>Newest</option>
              <option value="Due ASC">Due soonest</option>
              <option value="Due DESC">Due latest</option>
            </select>
          </div>
        </div>

        <!-- Job posts grid -->
        <div class="container" id="company-job-display card-display">
          <?php if (empty($jobs)): ?>
            <div class="alert alert-info">No job posts found.</div>
          <?php else: ?>
            <?php foreach ($jobs as $job): ?>
              <div class="row job-card" onclick="viewJobPost(<?= htmlspecialchars($job['ID']) ?>)">
                <div class="col-2 d-flex flex-column align-items-center">
                  <img
                    src="<?= empty($job['Avatar']) ? 'https://placehold.co/100x100' : htmlspecialchars(UPLOAD_IMG . $job['Avatar']) ?>"
                    alt="<?= htmlspecialchars($job['Company']) ?>" class="company-logo mb-1">
                  <h6 class="text-center"><?= htmlspecialchars($job['Company']) ?></h6>
                </div>
                <div class="col-10">
                  <div class="d-flex justify-content-between">
                    <h5><?= htmlspecialchars($job['Postname']) ?></h5>
                    <span
                      class="badge job-status-<?= strtolower($job['Status']) ?>"><?= htmlspecialchars($job['Status']) ?></span>
                  </div>
                  <p class="mb-1">
                    <i class="bi bi-calendar3"></i> <?= date('d/m/Y', strtotime($job['CreatedDate'])) ?> -
                    <?= date('d/m/Y', strtotime($job['Due'])) ?>
                    <i class="ml-4 bi bi-geo-alt"></i> <?= htmlspecialchars($job['Location']) ?>
                  </p>
                  <p class="mb-1">
                    <i class="bi bi-hash"></i> <?= htmlspecialchars($job['Level']) ?>
                  </p>
                  <p class="mb-0">
                    <i class="bi bi-clock-history"></i> <?= htmlspecialchars($job['Experience'] ?? '2+ years') ?>
                  </p>
                </div>
              </div>
            <?php endforeach; ?>
          <?php endif; ?>
        </div>

        <!-- Pagination -->
        <nav aria-label="Page navigation">
          <ul class="pagination justify-content-center">
            <li class="page-item <?= $page_num == 1 ? 'disabled' : '' ?>">
              <button id="prev" class="page-link" tabindex="-1" aria-disabled="true">
                <i class="bi bi-arrow-left"></i> Previous
              </button>
            </li>
            <li><?= $page_num ?> / <?= $total_pages ?></li>
            <li class="page-item <?= $page_num == $total_pages ? 'disabled' : '' ?>">
              <button id="next" class="page-link">
                Next <i class="bi bi-arrow-right"></i>
              </button>
            </li>
          </ul>
        </nav>
        <!-- end paginatio-->

      </div>
    </div>
  </div>
</div>

<script>
  const createbtn = document.querySelector("#admin-post-create");
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

    // Kiểm tra xem nhấp chuột có nằm ngoài sidebar và nút toggler hay không
    if (!sidebar.contains(event.target) && !toggler.contains(event.target)) {
      sidebar.classList.remove('active');
    }
  });
</script>

<script>
  const loadSuccess = (job) => {
    return `
    <div class="col-2 d-flex flex-column align-items-center">
      <img src="${avatarUrl}" alt="${escapeHTML(job.Company)}" class="company-logo mb-1">
      <h6 class="text-center">${escapeHTML(job.Company)}</h6>
    </div>
    <div class="col-10">
      <div class="d-flex justify-content-between">
        <h5>${escapeHTML(job.Postname)}</h5>
        <span class="badge job-status-${escapeHTML(job.Status.toLowerCase())}">
          ${escapeHTML(job.Status)}
        </span>
      </div>
      <p class="mb-1">
        <i class="bi bi-calendar3"></i> ${formatDate(job.CreatedDate)} - ${formatDate(job.Due)}
        <i class="ml-4 bi bi-geo-alt"></i> ${escapeHTML(job.Location)}
      </p>
      <p class="mb-1">
        <i class="bi bi-hash"></i> ${escapeHTML(job.Level)}
      </p>
      <p class="mb-0">
        <i class="bi bi-clock-history"></i> ${escapeHTML(job.Experience || '2+ years')}
      </p>
    </div>`;
  }
  const loadFail = () => {
    return `<div class="alert alert-info">No job posts found.</div>`;
  }
  const destGen = (id, name) => {
    return window.location.href + slugify(name) + '-' + id;
  }
  const loadPost = getLoader(loadSuccess,loadFail,destGen);

</script>