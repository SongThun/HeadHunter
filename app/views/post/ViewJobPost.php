<div class="container job-posting-container">
  <!-- Back Button -->
  <a href="javascript:history.back()" class="job-posting-back-btn">← Back</a>

  <!-- Company Info Section -->
  <?php if (isset($_SESSION['role']) && $_SESSION['role'] == 'admin'): ?>
    <div class="company-info mb-4">
      <img src="<?= empty($post['Avatar']) ? 'https://placehold.co/100x100' : htmlspecialchars(UPLOAD_IMG . $post['Avatar']) ?>"
        alt="<?= htmlspecialchars($post['Company']) ?>" class="company-logo">
      <h2 class="company-name"><?= htmlspecialchars($post['Company']) ?></h2>
    </div>
  <?php endif; ?>

  <!-- Header Section -->
  <fieldset disabled>
    <form class="job-posting-header" data-id="<?= $post['ID'] ?>" data-title="<?= $post['Postname'] ?>">
      <h1 class="mb-5"><input name="Postname" type="text" value="<?= htmlspecialchars($post['Postname']) ?>"></h1>
      <div class="job-posting-applicants mb-2">
        <label class="job-posting-label">Applicants:</label>
        <input name="Applicants_max" type="text" class="job-posting-value"
          value="<?= htmlspecialchars($post['Applicants_max']) ?>">
      </div>
      <div class="meta job-posting-meta">
        <span class="job-posting-location">
          <label class="job-posting-label">Location:</label>
          <input name="Location" type="text" class="job-posting-value"
            value="<?= htmlspecialchars($post['Location']) ?>">
        </span>
        <span class="job-posting-due-date">
          <label class="job-posting-label">Due date:</label>
          <input name="Due" type="date" class="job-posting-value"
            value="<?= date('Y-m-d', strtotime($post['Due'])) ?>">
        </span>
      </div>
      <div class="job-posting-level">
        <label class="job-posting-label">Level:</label>
        <input name="Level" type="text" class="job-posting-value"
          value="<?= htmlspecialchars($post['Level']) ?>">
      </div>
      <div class="job-posting-salary">
        <label class="job-posting-label">Salary:</label>
        <input name="Salary" type="number" class="job-posting-value"
          value="<?= htmlspecialchars($post['Salary']) ?>">
      </div>
      <div class="job-posting-description">
        <label class="job-posting-label">Description</label>
        <textarea name="Description" rows="5" cols="500"
          id="description"><?= htmlspecialchars($post['Description']) ?></textarea>
      </div>

      <!-- File Attachment Section -->
      <?php if (!empty($post['File_description'])): ?>
        <hr class="hr-custom job-posting-hr-custom">
        <div class="job-posting-attachment-wrapper">
          <a href="<?= BASE_URL ?>upload/description/<?= $post['File_description'] ?>"
            class="job-posting-attachment" download>
            <span class="job-posting-icon"><i class="bi bi-file-earmark-pdf"></i></span>
            <span class="job-posting-text"><?= htmlspecialchars($post['File_description']) ?></span>
          </a>
        </div>
      <?php endif; ?>
      <label for="File_description">Upload description file:</label>
      <div id="file-upload" class="job-posting-attachment">

        <input type="file" name="File_description">
      </div>
    </form>
  </fieldset>

  <!-- Action Buttons -->
  <div class="d-flex justify-content-center mt-4">
    <button id="delete-btn" class="btn job-posting-btn-custom job-posting-btn-delete">Delete post</button>
    <?php if ($post['Status'] != 'approved' || (isset($_SESSION['role']) && $_SESSION['role'] == 'admin')): ?>
      <button id="edit-btn" class="btn job-posting-btn-custom job-posting-btn-edit">Edit post</button>
      <button id="submit-btn" class="btn job-posting-btn-custom job-posting-btn-submit" style="display: none;">Submit
        for review</button>
    <?php endif; ?>
    <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
      <div id="comment">
        <fieldset data-value="<?= $post['Status'] ?>" id="admin-approval-form" <?= $post['Status'] == 'pending' ? "" : "disabled" ?>>
          <form action="">
            <?php if ($post['Status'] == 'pending'): ?>
              <textarea name="Reason" id="approval-reason" placeholder="Add comment..."></textarea>
            <?php else: ?>
              <textarea name="Reason" id="approval-reason"
                placeholder="Add comment..."><?= $post['Reason'] ?></textarea>
            <?php endif; ?>
            <span id="app-status"><?= $post['Status'] ?></span>
          </form>
        </fieldset>
        <button id="approve-btn" value="approved"
          class="btn job-posting-btn-custom job-posting-btn-approve">Approve</button>
        <button id="disapprove-btn" value="disapproved"
          class="btn job-posting-btn-custom job-posting-btn-disapprove">Disapprove</button>
        <button id="approve-edit-btn" class="btn job-posting-btn-custom job-posting-btn-approve">Edit</button>
      </div>
    <?php endif; ?>
  </div>
</div>

<script>
  const fieldset = document.querySelector("fieldset");
  const deletebtn = document.querySelector("#delete-btn");
  const form = document.querySelector("form");
  const id = form.dataset.id;

  if (deletebtn) {
    deletebtn.addEventListener('click', async () => {
      if (confirm("Are you sure you want to delete this post?")) {
        const url = `<?= API ?>jobpost?id=${id}`
        const response = await fetch(url, {
          method: 'DELETE'
        });
        const res = await response.json();
        if (res.status === 'success') {
          alert(`Delete post ${form.dataset.title}`)
          window.history.back();
        }
      }
    })
  }
  const editbtn = document.querySelector("#edit-btn");
  const submitbtn = document.querySelector("#submit-btn");
  const fileUpload = document.querySelector("#file-upload");
  const comment = document.querySelector("#comment");

  if (editbtn) {
    editbtn.addEventListener("click", () => {
      fieldset.disabled = false;
      submitbtn.style.display = 'block';
      editbtn.style.display = 'none';
      if (comment) comment.style.display = 'none';
    })
  }
  if (submitbtn) {
    submitbtn.addEventListener("click", async () => {
      const url = `<?= API ?>jobpost?id=${id}`;
      // const data = await form2json(form);
      const response = await fetch(url, {
        method: 'POST',
        headers: {
          "X-HTTP-Method-Override": "PUT"
        },
        body: new FormData(form)
      });
      const res = await response.json();
      if (res.status == 'success') {
        fieldset.disabled = true;
        editbtn.style.display = 'block';
        submitbtn.style.display = 'none';
        if (comment) comment.style.display = 'flex';
      }
    })
  }
</script>

<script>
  document.addEventListener("DOMContentLoaded", function() {
    const acceptbtn = document.querySelector("#approve-btn");
    const rejectbtn = document.querySelector("#disapprove-btn");
    const editbtn = document.querySelector("#approve-edit-btn");
    const approvalForm = document.querySelector("#admin-approval-form");
    const status = approvalForm.dataset.value;
    const statusResult = document.querySelector("#app-status");

    function checkBtnDisplay(status) {
      if (status == 'pending') {
        editbtn.style.display = 'none';
        acceptbtn.style.display = 'block';
        rejectbtn.style.display = 'block';
        approvalForm.disabled = false;
        statusResult.style.display = 'none';
      } else {
        editbtn.style.display = 'block';
        acceptbtn.style.display = 'none';
        rejectbtn.style.display = 'none';
        approvalForm.disabled = true;
        statusResult.style.display = 'block';
      }
    }
    checkBtnDisplay(status);
    editbtn.addEventListener('click', () => {
      checkBtnDisplay('pending');
    })
    async function approvalFormSubmit(reason, status) {
      const url = `<?= API ?>approval?postid=<?= $post['ID'] ?>`;
      const response = await fetch(url, {
        method: 'PUT',
        headers: {
          'ContentType': 'application/json'
        },
        body: JSON.stringify({
          "Reason": reason,
          "Status": status
        })
      });
      const res = await response.json();
      if (res.status == 'success') {
        statusResult.innerText = status;
        checkBtnDisplay('done')
      }
    }
    rejectbtn.addEventListener('click', (e) => {
      e.preventDefault();
      console.log("disapproved");
      const reason = document.querySelector("#approval-reason").innerText;
      approvalFormSubmit(reason, 'disapproved')
    })
    acceptbtn.addEventListener('click', (e) => {
      e.preventDefault();
      console.log("approved");
      const reason = document.querySelector("#approval-reason").innerText;
      approvalFormSubmit(reason, 'approved')
    })
  })
</script>