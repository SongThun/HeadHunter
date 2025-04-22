<style>
  main{
  z-index: 1;
}
.outside-description{
  display: flex;
  flex-direction: column;
  flex-grow: 1;
  align-items: center;
  justify-content: center;
}
.description{
  width: 80%;
  height: 100%;
  margin: 1rem 10rem;
  justify-content: center;
}
.description .job-title{
  width: 100%;
  display: flex;
  justify-content: center;
  align-items: center;
  font-size: 2rem;
}

.description .job-description-sub{
  display: grid;
  grid-template-columns: repeat(2, 1fr);
  /* grid-template-columns: repeat(auto-fit, minmax(10rem, 1fr)); */
}
@media (max-width: 795px) {
  .description .job-description-sub{
    display: flex;
    flex-direction: column;
  }
}
.description .job-description-sub .applicants,
.description .job-description-sub .locations,
.description .job-description-sub .level,
.description .job-description-sub .due-date{
  display: flex;
  align-items: end;
  font-size: 1rem;
  gap: 1rem;
  text-align: center;
  padding: 1rem 0;
}


.description .job-description-sub .applicants p,
.description .job-description-sub .locations p,
.description .job-description-sub .level p,
.description .job-description-sub .due-date p {
  margin: 0 !important;
  font-size: 1.4rem;
  display: flex;
  align-items: end;
  align-self: end;
}

.description .job-description-sub h3,
.description .job-description-section-title > h3 {
  color: var(--deep-blue);
  margin: 0;
}
.description .job-description-sub p{
  font-size: 1.1rem;
}
.description .job-description-section-title{
  border-style: solid;
  border-width: 0 0 2px 0;
  border-color: var(--deep-blue);
  height: 2.5rem;
  margin-top: 1rem;
}
.job-description-section .file-box{
  border-style: solid;
  margin: 1.5rem 0 1rem 0;
  border-radius: 10px;
  min-height: 3.5rem;
  height: fit-content;
  width: 15rem;
  border-color: grey;
}

.form-description{
  display: flex;
  flex-direction: column;
  row-gap: 2rem;
  
}
.form-row{
  /* display: grid; */
  /* grid-template-columns: repeat(2, 1fr); */
  display: flex;
  justify-content: space-between;
}
.form-row-half,
.form-row-1{
  display: flex;
  flex-direction: column;
  row-gap: .5rem;
}



.form-row input,
.form-row-1 input{
  height: 2.5rem;
  width: 35rem;
  border-radius: 10px;
  border-width: 1px;
  border-color: var(--blue);
  outline: none;
  font-size: 1rem;
  padding: .3rem .8rem;
}
.form-row-1 input{
  width: 74rem;
}

.form-row-1 textarea{
  border-radius: 10px;
  border: 1px solid var(--blue);
  padding: .3rem .8rem;
  margin-bottom: 1rem;
  outline: none;
}

.form-btn{
  display: flex;
  justify-content: flex-end;
  height: 3rem;
  
}

 .form-btn button{
  margin-left: auto;
  width: 10rem;
  font-size: 1.3rem;
  background: var(--blue);
  color: white;
  outline: none;
  border: none;
  box-sizing: border-box;
  box-shadow: 1px 1px 1px rgba(.1,.1,.1,.1);
  border-radius: 10px;
  cursor: pointer;
}

.form-btn button:hover{
  scale: 1.1;
}
.form-row-1-file{
  display: flex;
  flex-direction: column;
}
.form-row-1-file input{
  /* border-style: dashed; */
  margin: .5rem 0;
}

/*** HTML STYLING  ***/
main {
  flex: 1;
  z-index: 1;
}

.alert {
  padding: 15px;
  margin-bottom: 20px;
  border-radius: 4px;
}

.alert-success {
  background-color: #d4edda;
  color: #155724;
  border: 1px solid #c3e6cb;
}

.alert-danger {
  background-color: #f8d7da;
  color: #721c24;
  border: 1px solid #f5c6cb;
}

.pdf-options {
  display: flex;
  align-items: stretch !important; /* Make children fill full height */
  padding: 0 0 0 1rem;
  flex-direction: row;
  height: 3rem; /* or any desired height */
}

.btn-view-pdf {
  background-color: var(--blue);
  color: white;
  border: none;
  height: 100% !important;
  height: 3.35rem !important;
  border-radius: 8px;
  border-bottom-left-radius: 0;
  border-top-left-radius: 0;
  width: 6rem;
  cursor: pointer;
  font-size: 14px;
  display: flex;
  align-items: center;
  gap: 5px;
}

.btn-view-pdf:hover {
  background-color: var(--deep-blue);
}

.pdf-viewer-wrapper {
  border: 1px solid #ddd;
  border-radius: 4px;
  overflow: hidden;
}

  #admin-approval-form{
    display: flex;
    align-items: center;
    justify-content: center;
  }

  #admin-approval-form textarea{
    align-self: center;
    resize: none;
    border-radius: 10px;
    border: 1px solid var(--blue);
    padding: .4rem .8rem;
    outline: none;
    width: 18rem;
    margin-bottom: 1rem;
    margin-top: 1rem;
  }

  .job-posting-attachment-wrapper a{
    /* height: 1rem; */
    width: 30rem !important;
    /* all: unset; */
    width: fit-content;
  }
  .job-posting-attachment{
    width: 20rem !important;
    width: 30rem !important;
  }

/*** END HTML STYLING ***/
@media (max-width: 1836px){
  .form-row input{
    width: 41rem;
  }
}
@media (max-width: 1718px){
  .form-row input{
    width: 38.5rem;
  }
}
@media (max-width: 1620px){
  .form-row input{
    width: 36rem;
  }
}
@media (min-width: 1516px){
  .form-row-1 input{
    width: 98%;
  }
}
@media (max-width: 1515px) {
  .form-row input,
  .form-row-1 input{
    height: 2.5rem;
    width: 35rem;
    border-radius: 10px;
    border-width: 1px;
    border-color: var(--deep-blue);
    outline: none;
    font-size: 1rem;
    padding: .3rem .8rem;
}
  .form-row-1 input{
    width: 74rem;
  }
}
@media (max-width: 1472px){
  .form-row input{
    width: 30rem;
  }
  .form-row-1 input{
    width: 97.5%;
  }
}
@media (max-width: 1283px){
  .form-row input{
    width: 25rem;
  }
  .form-row-1 input{
    width: 97.5%;
  }
}
@media (max-width: 1079px){
  .form-row input{
    width: 20rem;
  }
  .form-row-1 input{
    width: 97.5%;
  }
}
@media (max-width: 884px){
  .form-row{
    display: flex;
    flex-direction: column;
    row-gap: 1.7rem;
  }
  .form-row input{
    width: 97%;
  }
  .form-row-1 input{
    width: 97.5%;
  }
}
</style>

<style>
  .btn.job-posting-btn-custom{
    background: var(--blue);
  }
</style>

<main>
<div class="outside-description" style="background: white;">

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
          <div class="file-box" style="min-width: 20rem;">
            <div class="pdf-options" >
              <a href="<?= e(UPLOAD_DESC . "/" . $job['File_description']) ?>" target="_blank" >
                <i class="fas fa-file-pdf"></i> Download Job Description PDF
              </a>
              <button id="toggle-pdf-viewer" class="btn-view-pdf">
                <i class="fas fa-eye"></i> View PDF
              </button>
            </div>

            <div id="pdf-viewer-container" style="display: none; margin-top: 15px;">
              <div class="pdf-viewer-wrapper">
                <object data="<?= e(UPLOAD_DESC . "/" . $job['File_description']); ?>"
                  type="application/pdf"
                  width="100%"
                  height="600px">
                  <p>
                    Your browser doesn't support embedded PDFs.
                    <a href="<?= e(UPLOAD_DESC . "/" . $job['File_description']) ?>">Click here to download the PDF</a>.
                  </p>
                </object>
              </div>
            </div>
          </div>
        <?php endif; ?>

        <div class="job-details">
          <h3>Job Description: </h3>
          <p><?= nl2br(e($job['Description'] ?? 'No description available')) ?></p>

          <h3>Number of Positions: </h3>
          <p><?= e($job['Applicants_max'] ?? 'Not specified') ?> candidate(s)</p>

          <h3>Posted Date: </h3>
          <p><?= e(formatDate($job['CreatedDate'])) ?></p>

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
                <input type="text" name="Fullname" id="" value="<?= e($app['Fullname']) ?>" required>
              </div>
              <div class="form-row-half">
                <label for="email-applicant"><span style="color: red; margin-right: .2rem;">*</span>Email</label>
                <input type="email" name="Email" id="" value="<?= e($app['Email']) ?>" required>
              </div>
            </div>
            <div class="form-row">
              <div class="form-row-half">
                <label for="phone-num"><span style="color: red; margin-right: .2rem;">*</span>Phone Number</label>
                <input type="tel" name="Phone" id="" value="<?= e($app['Phone']) ?>" required>
              </div>
              <div class="form-row-half">
                <label for="district"><span style="color: red; margin-right: .2rem;">*</span>Location</label>
                <input type="text" name="Location" id="" value="<?= e($app['Location']) ?>" required>
              </div>
            </div>

            <div class="form-row-1">
              <label for="level"><span style="color: red; margin-right: .2rem;">*</span>Level</label>
              <input type="text" name="Level" id="" value="<?= e($app['Level']) ?>" required>
            </div>
            <div class="form-row-1">
              <div class="job-posting-attachment-wrapper">
                <a href="<?= e(UPLOAD_APP . "/" . $job['ID'] . "/" . $app['File_CV']) ?>" class="job-posting-attachment" download>
                  <span class="job-posting-icon"><i class="bi bi-file-earmark-pdf"></i></span>
                  <p class="job-posting-text"><?= e($app['File_CV']) ?></p>
                </a>
              </div>
            </div>
            <div class="form-row-1">
                <label for="cover-letter"><span style="color: red; margin-right: .2rem;">*</span>Cover Letter</label>
                <textarea name="cover" id="cover-letter" rows="10" cols="30" required><?= e($app['Cover']) ?></textarea>
            </div>
          </div>

        </div>
      </form>
    </fieldset>
    <!-- END APPLICATION VIEW -->

    <!-- OPTION[ADMIN]: APPROVAL FORM -->
    <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
      <fieldset data-value="<?= e($app['Status']) ?>" id="admin-approval-form" <?= $app['Status'] == 'pending' ? "" : "disabled" ?>>
        <form action="">
          <?php if ($app['Status'] == 'pending'): ?>
            <textarea name="Reason" id="approval-reason" placeholder="Add comment..."></textarea>
          <?php else: ?>
            <textarea name="Reason" id="approval-reason" placeholder="Add comment..."><?= e($app['Reason']) ?></textarea>
          <?php endif; ?>
          <span id="app-status"><?= e($app['Status']) ?></span>
        </form>
      </fieldset>
      <button id="accept-btn" value="accept" class="btn job-posting-btn-custom job-posting-btn-approve">Accept</button>
      <button id="reject-btn" value="reject" class="btn job-posting-btn-custom job-posting-btn-disapprove">Reject</button>
      <button id="edit-btn" class="btn job-posting-btn-custom job-posting-btn-approve">Edit</button>
    <?php endif; ?>
    <!-- END APPROVAL FORM -->

  </div>
</div>
</main>



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

<script src="<?= e(SCRIPT_PATH . "/adminApproval.js")?>></script>