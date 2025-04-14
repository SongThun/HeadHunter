<!-- LANDING PAGE OF ADMIN APPLICATIONS -->
<div class="container-fluid">
  <div class="row">
    <div class="col-12 p-2">
      <div class="main-content">
        <div class="row mb-3 align-items-center">
          <!-- search bar -->
          <div class="col">
            <div class="search-box">
              <i class="fa-solid fa-magnifying-glass"></i>
              <input type="text" class="form-control" placeholder="Search company">
            </div>
          </div>

          <!-- sort bar -->
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
        <div class="container card-display" id="company-job-display">
          <?php if (empty($jobs)): ?>
            <div class="no-jobs-found">
              <h3>No job posts found</h3>
              <p>Try adjusting your search criteria</p>
            </div>
          <?php else: ?>
            <?php foreach ($jobs as $job): ?>
              <div class="row job-card p-2" data-id="<?= htmlspecialchars($job['ID']) ?>"
                data-name="<?= htmlspecialchars($job['Postname']) ?>">
                <div class="col-2 d-flex flex-column align-items-center">
                  <img src="https://assets.datamation.com/uploads/2022/04/NVIDIA-logo-icon.png" alt="Company Logo"
                    class="company-logo mb-1">
                  <h6 class="text-center"><?= htmlspecialchars($job['Company']) ?></h6>
                </div>
                <div class="col-10">
                  <div class="d-flex justify-content-between">
                    <h5><?= htmlspecialchars($job['Postname']) ?></h5>
                    <span class="badge job-status-pending"><?= htmlspecialchars($job['Applicants_apply']) ?></span>
                  </div>
                  <p class="mb-1">
                    <i class="bi bi-calendar3"></i> <?= htmlspecialchars($job['CreatedDate']) ?> -
                    <?= htmlspecialchars($job['Due']) ?>
                    <i class="ml-4 bi bi-geo-alt"></i> <?= htmlspecialchars($job['Location']) ?>
                  </p>
                  <p class="mb-1">
                    <?= htmlspecialchars(substr($job['Description'], 0, min(strlen($job['Description']), 50))) . (strlen($job['Description']) > 50 ? '...' : '') ?>
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
        <!-- end pagination -->

      </div>
    </div>
  </div>
</div>

<script>
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
<script src="<?= SCRIPT_PATH ?>/pagination.js"></script>
<script>
  const loadSuccess = (job) => {
    return `<div class="row job-card" data-id="${job.ID}" data-name="${job.Postname}">
    <div class="col-2 d-flex flex-column align-items-center">
      <img src="https://assets.datamation.com/uploads/2022/04/NVIDIA-logo-icon.png" alt="Company Logo"
        class="company-logo mb-1">
      <h6 class="text-center">${job.Company}</h6>
    </div>
    <div class="col-10">
      <div class="d-flex justify-content-between">
        <h5>${job.Postname}</h5>
        <span class="badge job-status-pending">${job.Applicants_apply}</span>
      </div>
      <p class="mb-1">
        <i class="bi bi-calendar3"></i> ${job.CreatedDate} - ${job.Due}
        <i class="ml-4 bi bi-geo-alt"></i> ${job.Location}
      </p>
      <p class="mb-1">
        ${job.Description.length > 50 ? job.Description.substring(0, 50) + '...' : job.Description}
      </p>
    </div>
  </div>`
  }
  const loadFail = () => {
    return `<div class="no-jobs-found">
            <h3>No job posts found</h3>
            <p>Try adjusting your search criteria</p>
          </div>`;
  }
  const destGen = (id, name) => {
    return window.location.href + slugify(name) + '-' + id;
  }
  const loadPost = getLoader(loadSuccess,loadFail,destGen);

</script>