<div class="outside-description">

  <div class="description">
    <!-- JOB DESCRIPTION -->
    <div class="job-title">
      <h1><?php echo htmlspecialchars($job['Postname'] ?? 'Job Title Not Available'); ?></h1>
    </div>
    <div class="job-description">
      <div class="job-description-sub">
        <div class="applicants">
          <h3>Applicants: </h3>
          <p><?php echo $job['Applicants_apply']; ?></p>
        </div>
        <div class="locations">
          <h3>Location: </h3>
          <p><?php echo htmlspecialchars($job['Location'] ?? 'Not specified'); ?></p>
        </div>
      </div>
      <div class="job-description-sub">
        <div class="level">
          <h3>Salary: </h3>
          <p><?php echo htmlspecialchars($job['Salary'] ?? 'Not specified'); ?></p>
        </div>
        <div class="due-date">
          <h3>Due date: </h3>
          <p><?php echo isset($job['Due']) && !empty($job['Due']) ? date('d/m/Y', strtotime($job['Due'])) : 'Not specified'; ?></p>
        </div>
      </div>
      <div class="job-description-section-title">
        <h3>Description</h3>
      </div>
      <div class="job-description-section">
        <?php if (isset($job['File_description']) && !empty($job['File_description'])): ?>
          <div class="file-box">
            <div class="pdf-options">
              <a href="<?= UPLOAD_DESC ?><?php echo htmlspecialchars($job['File_description']); ?>" target="_blank">
                <i class="fas fa-file-pdf"></i> Download Job Description PDF
              </a>
              <button id="toggle-pdf-viewer" class="btn-view-pdf">
                <i class="fas fa-eye"></i> View PDF
              </button>
            </div>

            <div id="pdf-viewer-container" style="display: none; margin-top: 15px;">
              <div class="pdf-viewer-wrapper">
                <object data="<?= UPLOAD_DESC?><?php echo htmlspecialchars($job['File_description']); ?>"
                  type="application/pdf"
                  width="100%"
                  height="600px">
                  <p>
                    Your browser doesn't support embedded PDFs.
                    <a href="<?= UPLOAD_DESC ?><?php echo htmlspecialchars($job['File_description']); ?>">Click here to download the PDF</a>.
                  </p>
                </object>
              </div>
            </div>
          </div>
        <?php endif; ?>

        <div class="job-details">
          <h3>Job Description: </h3>
          <p><?php echo nl2br(htmlspecialchars($job['Description'] ?? 'No description available')); ?></p>

          <h3>Number of Positions: </h3>
          <p><?php echo htmlspecialchars($job['Applicants_max'] ?? 'Not specified'); ?> candidate(s)</p>

          <h3>Posted Date: </h3>
          <p><?php echo isset($job['CreatedDate']) ? date('d/m/Y', strtotime($job['CreatedDate'])) : 'Not specified'; ?></p>

        </div>
      </div>
    </div>
    <!-- END JOB DESCRIPTION -->


    <!-- APPLICATION VIEW -->
    <fieldset disabled>
      <form enctype="multipart/form-data">
        <div class="application-form">
          <div class="form-title">
            <h1 style="margin: 2rem 0; color: var(--blue);">Application form</h1>
          </div>

          <div class="form-description">
            <div class="form-row">
              <div class="form-row-half">
                <label for="full-name"><span style="color: red; margin-right: .2rem;">*</span>Full Name</label>
                <input type="text" name="Fullname" id="" value="<?= $app['Fullname'] ?>" required>
              </div>
              <div class="form-row-half">
                <label for="email-applicant"><span style="color: red; margin-right: .2rem;">*</span>Email</label>
                <input type="email" name="Email" id="" value="<?= $app['Email'] ?>" required>
              </div>
            </div>
            <div class="form-row">
              <div class="form-row-half">
                <label for="phone-num"><span style="color: red; margin-right: .2rem;">*</span>Phone Number</label>
                <input type="tel" name="Phone" id="" value="<?= $app['Phone'] ?>" required>
              </div>
            </div>
            <div class="form-row">
              <div class="form-row-half">
                <label for="district"><span style="color: red; margin-right: .2rem;">*</span>Location</label>
                <input type="text" name="Location" id="" value="<?= $app['Location'] ?>" required>
              </div>
            </div>
            <div class="form-row-1">
              <label for="level"><span style="color: red; margin-right: .2rem;">*</span>Level</label>
              <input type="text" name="Level" id="" value="<?= $app['Level'] ?>" required>
            </div>
            <div class="form-row-1">
              <div class="form-row-1-file">
                <label for="resume"><span style="color: red; margin-right: .2rem;">*</span>Resume</label>
                <input type="file" name="File_CV" id="file-applicant">
              </div>
              <div class="job-posting-attachment-wrapper" style="width: 30rem;">
                <a href="<?= BASE_URL ?>upload/description/<?= $app['File_CV'] ?>" class="job-posting-attachment" download style="margin: 10rem !important;">
                  <span class="job-posting-icon"><i class="bi bi-file-earmark-pdf"></i></span>
                  <p class="job-posting-text"><?= htmlspecialchars($app['File_CV']) ?></p>
                </a>
              </div>
              <div class="form-row-1">
                <label for="cover-letter"><span style="color: red; margin-right: .2rem;">*</span>Cover Letter</label>
                <textarea name="cover" id="cover-letter" rows="10" cols="30" required><?= $app['Cover'] ?></textarea>
              </div>
            </div>
          </div>

        </div>
      </form>
    </fieldset>
    <!-- END APPLICATION VIEW -->

    <!-- OPTION[ADMIN]: APPROVAL FORM -->
    <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
      <fieldset data-value="<?= $app['Status'] ?>" id="admin-approval-form" <?= $app['Status'] == 'pending' ? "" : "disabled" ?>>
        <form action="">
          <?php if ($app['Status'] == 'pending'): ?>
            <textarea name="Reason" id="approval-reason" placeholder="Add comment..."></textarea>
          <?php else: ?>
            <textarea name="Reason" id="approval-reason" placeholder="Add comment..."><?= $app['Reason'] ?></textarea>
          <?php endif; ?>
          <span id="app-status"><?= $app['Status'] ?></span>
        </form>
      </fieldset>
      <button id="accept-btn" value="accept" class="btn job-posting-btn-custom job-posting-btn-approve">Accept</button>
      <button id="reject-btn" value="reject" class="btn job-posting-btn-custom job-posting-btn-disapprove">Reject</button>
      <button id="edit-btn" class="btn job-posting-btn-custom job-posting-btn-approve">Edit</button>
    <?php endif; ?>
    <!-- END APPROVAL FORM -->

  </div>
</div>

<script>
  const fieldset = document.querySelector("fieldset")
  const form = document.querySelector("form");
  const id = form.dataset.id;

  document.addEventListener("DOMContentLoaded", function() {
    let currentPage = window.location.pathname.split("/").pop().replace(/\.[^/.]+$/, "");
    let button = document.querySelectorAll(".list .sub-list");

    button.forEach(button => {
      let btnPage = button.getAttribute("data-links");
      console.log(btnPage);
      if (btnPage && (btnPage.includes(currentPage) || currentPage.includes("jobdescription"))) {

        button.classList.add("active-list"); // Add active class
      } else {
        button.classList.remove("active-list"); // Ensure others don't have it
      }
      button.addEventListener("click", () => {
        window.location.href = btnPage;
      });
    });
  });
</script>

<script>
  // Existing script remains as is

  // Add PDF viewer toggle functionality
  document.addEventListener("DOMContentLoaded", function() {
    const togglePdfBtn = document.getElementById('toggle-pdf-viewer');
    const pdfContainer = document.getElementById('pdf-viewer-container');

    if (togglePdfBtn) {
      togglePdfBtn.addEventListener('click', function() {
        if (pdfContainer.style.display === 'none') {
          pdfContainer.style.display = 'block';
          togglePdfBtn.innerHTML = '<i class="fas fa-eye-slash"></i> Hide PDF';
        } else {
          pdfContainer.style.display = 'none';
          togglePdfBtn.innerHTML = '<i class="fas fa-eye"></i> View PDF';
        }
      });
    }
  });
</script>

<script src="<?= SCRIPT_PATH ?>/adminApproval.js"></script>