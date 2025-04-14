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
                <object data="<?= UPLOAD_DESC ?><?php echo htmlspecialchars($job['File_description']); ?>"
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

    <!-- APPLICATION FORM -->
    <fieldset>
      <form enctype="multipart/form-data">
        <div class="application-form">
          <div class="form-title">
            <h1 style="margin: 2rem 0; color: var(--blue);">Application form</h1>
          </div>

          <div class="form-description">
            <div class="form-row">
              <div class="form-row-half">
                <label for="full-name"><span style="color: red; margin-right: .2rem;">*</span>Full Name</label>
                <input type="text" name="Fullname" id="" required>
              </div>
              <div class="form-row-half">
                <label for="email-applicant"><span style="color: red; margin-right: .2rem;">*</span>Email</label>
                <input type="email" name="Email" id="" required>
              </div>
            </div>
            <div class="form-row">
              <div class="form-row-half">
                <label for="phone-num"><span style="color: red; margin-right: .2rem;">*</span>Phone Number</label>
                <input type="tel" name="Phone" id="" required>
              </div>
              <div class="form-row-half">
                <label for="address"><span style="color: red; margin-right: .2rem;">*</span>Address</label>
                <input type="text" name="Address" id="" required>
              </div>
            </div>
            <div class="form-row">
              <div class="form-row-half">
                <label for="district"><span style="color: red; margin-right: .2rem;">*</span>District</label>
                <input type="text" name="District" id="" required>
              </div>
              <div class="form-row-half">
                <label for="city"><span style="color: red; margin-right: .2rem;">*</span>City</label>
                <input type="text" name="City" id="" required>
              </div>
            </div>
            <div class="form-row-1">
              <label for="level"><span style="color: red; margin-right: .2rem;">*</span>Level</label>

              <input list="lists" type="text" name="Level" id="Level" required>
              <datalist id="lists">
                <option value="Intern">
                <option value="Junior">
                <option value="Middle">
                <option value="Senior">
                <option value="Lead">
              </datalist>
            </div>
            <div class="form-row-1">
              <div class="form-row-1-file">
                <label for="resume"><span style="color: red; margin-right: .2rem;">*</span>Resume</label>
                <input type="file" name="File_CV" id="file-applicant" required>
              </div>

              <div class="form-row-1">
                <label for="cover-letter"><span style="color: red; margin-right: .2rem;">*</span>Cover Letter</label>
                <textarea name="Cover" id="cover-letter" rows="10" cols="30" required></textarea>
              </div>
            </div>
          </div>
          <div class="form-btn">
            <button id="apply" type="submit">Apply Now</button>
          </div>
        </div>
      </form>
    </fieldset>
    <!-- END APPLICATION FORM -->
     
  </div>
</div>
</main>

<script>
  const fieldset = document.querySelector("fieldset")
  const form = document.querySelector("form");
  // const id = form.dataset.id;
  const id = <?= $_GET["id"] ?>;
  console.log(id);
  const applyBtn = document.querySelector("#apply")


  if (applyBtn) {
    applyBtn.addEventListener('click', async (e) => {
      e.preventDefault();
      const url = `<?= API ?>apply/${id}`;
      // const data = await form2json(form)
      // console.log(data)
      const response = await fetch(url, {
        method: 'POST',
        // body: JSON.stringify(data)
        // headers: { "X-HTTP-Method-Override": "PUT" },
        body: new FormData(form)
      });
      const res = await response.json();
      if (res.status == 'success') {
        window.location.href = '<?php $baseUrl ?>';
      }
    })
  }
  document.addEventListener("DOMContentLoaded", function() {
    let currentPage = window.location.pathname.split("/").pop().replace(/\.[^/.]+$/, "");
    console.log(currentPage);

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