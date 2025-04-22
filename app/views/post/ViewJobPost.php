<main>
  <div class="container job-posting-container">
    <!-- Back Button -->
    <a href="javascript:history.back()" class="job-posting-back-btn">← Back</a>

    <!-- Company Info Section -->
    <?php if (isset($_SESSION['role']) && $_SESSION['role'] == 'admin'): ?>
      <div class="company-info mb-4">
        <img src="<?= empty($post['Avatar']) ? 'https://placehold.co/100x100' : e(UPLOAD_IMG . $post['Avatar']) ?>"
          alt="<?= e($post['Company']) ?>" class="company-logo">
        <h2 class="company-name"><?= e($post['Company']) ?></h2>
      </div>
    <?php endif; ?>

    <!-- Header Section -->
    <fieldset disabled>
      <form enctype="multipart/form-data" method="POST" class="job-posting-header" data-id="<?= e($post['ID']) ?>" data-title="<?= e($post['Postname']) ?>">
        <h1 class="header-post"><input name="Postname" type="text" value="<?= e($post['Postname']) ?>"></h1>
        <div class="job-posting-applicants">
          <label class="job-posting-label">Applicants:</label>
          <input name="Applicants_max" type="text" class="job-posting-value"
            value="<?= $post['Applicants_max'] ?>">
        </div>
        <div class="job-posting-row-double">
          <div class="job-posting-location">
            <label class="job-posting-label">Location:</label>
            <input name="Location" type="text" class="job-posting-value"
              value="<?= e($post['Location']) ?>">
          </div>
          <div class="job-posting-due-date">
            <label class="job-posting-label">Due date:</label>
            <input name="Due" type="date" class="job-posting-value"
              value="<?= date('Y-m-d', strtotime($post['Due'])) ?>">
          </div>
        </div>
        <div class="job-posting-row-double">
          <div class="job-posting-level">
            <label class="job-posting-label">Level:</label>
            <input name="Level" type="text" class="job-posting-value"
              value="<?= e($post['Level']) ?>">
          </div>
          <div class="job-posting-salary">
            <label class="job-posting-label">Salary:</label>
            <input name="Salary" type="number" class="job-posting-value"
              value="<?= e($post['Salary']) ?>">
          </div>
        </div>

        <div class="job-posting-description">
          <label class="job-posting-label">Description</label>
          <textarea name="Description" rows="5" cols="500"
            id="description"><?= e($post['Description']) ?></textarea>
        </div>

        <style>
          .file-item {
            display: flex;
            align-items: center;
            margin-top: 0.5rem;
            padding: 0.5rem;
            background: #f3f3f3;
            border: 1px solid #ccc;
            border-radius: 5px;
          }

          .file-item span {
            flex: 1;
            word-break: break-word;
          }

          .delete-btn {
            background: #e74c3c;
            color: white;
            border: none;
            padding: 0.3rem 0.6rem;
            border-radius: 4px;
            cursor: pointer;
            margin-left: 0.5rem;
          }

          .delete-btn:hover {
            background: #c0392b;
          }

          .dragover {
            outline: 2px dashed #007bff;
            background-color: #e0f0ff;
          }
        </style>

        <!-- Existing Files -->
        <h4 style="margin-top: 1rem;">Existing Files</h4>
        <!-- <div id="existing-file-list">
          <php
          $folderPath = realpath(dirname(__DIR__) . "/../../public/upload/descriptions/" . $post['ID']);
          if (is_dir($folderPath)) {
            $files = glob($folderPath . "/*");
            foreach ($files as $file) {
              $fileName = basename($file);
              echo "<div class='file-item existing' data-filename='" . htmlspecialchars($fileName, ENT_QUOTES) . "'>
              <span>" . htmlspecialchars($fileName) . "</span>
              <button class='delete-btn'>Delete</button>
              <input type='hidden' name='ExistingFiles[]' value='" . htmlspecialchars($fileName, ENT_QUOTES) . "'>
            </div>";
            }
          }
          ?>
        </div> -->

        <div id="existing-file-list" style="display: flex; flex-direction: column; flex: 1;">
  <?php
  $folderPath = realpath(dirname(__DIR__) . "/../../public/upload/descriptions/" . $post['ID']);
  $relativePath = UPLOAD_DESC ."/" . $post['ID']; // Public-facing relative URL path

  if (is_dir($folderPath)) {
    $files = glob($folderPath . "/*");
    foreach ($files as $file) {
      $fileName = basename($file);
      $fileUrl = htmlspecialchars($relativePath . "/" . $fileName, ENT_QUOTES);
      echo "<div class='file-item existing' style='padding: .5rem 0 .5rem 0;' data-filename='" . htmlspecialchars($fileName, ENT_QUOTES) . "'>
        <a href='" . $fileUrl . "' download target='_blank'>" . htmlspecialchars($fileName) . "</a>
        <button class='delete-btn'>Delete</button>
        <input type='hidden' name='ExistingFiles[]' value='" . htmlspecialchars($fileName, ENT_QUOTES) . "'>
      </div>";
    }
  }
  ?>
</div>


        <!-- New Uploads -->
        <h4 style="margin-top: 1rem;">New Uploads</h4>
        <div id="new-file-list"></div>

        <!-- File input moved inside form but outside fieldset -->
        <div class="mt-4">
          <label id="unique" for="File_description"><span style="color: red; margin-right: .2rem;">*</span>Resume</label>
          <input type="file" name="File_description[]" id="File_description" style="display: none;" multiple>
        </div>
      </form>
    </fieldset>

    <!-- Action Buttons -->
    <div class="list-btn-of-job">
      <div class="company-btn-dlt-and-edit">
        <button id="delete-btn" class="btn job-posting-btn-custom job-posting-btn-delete">Delete post</button>
        <?php if ($post['Status'] != 'approved' || (isset($_SESSION['role']) && $_SESSION['role'] == 'admin')): ?>
          <button id="edit-btn" class="btn job-posting-btn-custom job-posting-btn-edit">Edit post</button>
          <button id="submit-btn" class="btn job-posting-btn-custom job-posting-btn-submit" style="display: none;">Submit
            for review</button>
        <?php endif; ?>
      </div>

      <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
        <div id="comment">
          <fieldset data-value="<?= $post['Status'] ?>" id="admin-approval-form" <?= $post['Status'] == 'pending' ? "" : "disabled" ?>>
            <form action="">
              <?php if ($post['Status'] == 'pending'): ?>
                <textarea name="Reason" id="approval-reason" placeholder="Add comment..."></textarea>
              <?php else: ?>
                <textarea name="Reason" id="approval-reason"
                  placeholder="Add comment..."><?= e($post['Reason']) ?></textarea>
              <?php endif; ?>
              <span id="app-status"><?= e($post['Status']) ?></span>
            </form>
          </fieldset>
          <div class="company-btn-dlt-and-edit">
            <button id="approve-btn" value="approved"
              class="btn job-posting-btn-custom job-posting-btn-approve" style="background: var(--blue)">Approve</button>
            <button id="disapprove-btn" value="disapproved"
              class="btn job-posting-btn-custom job-posting-btn-disapprove" style="background: var(--blue)">Disapprove</button>
            <button id="approve-edit-btn" class="btn job-posting-btn-custom job-posting-btn-approve" style="background: var(--blue)">Edit</button>
          </div>
        </div>
      <?php endif; ?>
    </div>
  </div>
</main>

<script>
  const input = document.getElementById("File_description");
  const label = document.getElementById("unique");
  const existingBox = document.getElementById("existing-file-list");
  const newBox = document.getElementById("new-file-list");

  let uploadedFiles = [];

  function autoRename(name) {
    const dot = name.lastIndexOf(".");
    if (dot === -1) return name + " (1)";
    const base = name.substring(0, dot);
    const ext = name.substring(dot);
    return `${base} (1)${ext}`;
  }

  function updateInputFiles() {
    const dataTransfer = new DataTransfer();
    uploadedFiles.forEach(file => dataTransfer.items.add(file));
    input.files = dataTransfer.files;
  }

  function addFileToList(file, isExisting = false) {
    const fileBox = document.createElement("div");
    fileBox.className = "file-item";
    fileBox.setAttribute("data-filename", file.name);

    const fileName = document.createElement("span");
    fileName.textContent = file.name;

    const deleteBtn = document.createElement("button");
    deleteBtn.className = "delete-btn";
    deleteBtn.textContent = "Delete";

    if (isExisting) {
      fileBox.classList.add("existing");

      deleteBtn.addEventListener("click", () => {
        fileBox.remove();
        const hidden = fileBox.querySelector("input[type='hidden']");
        if (hidden) hidden.remove();
      });

      const hidden = document.createElement("input");
      hidden.type = "hidden";
      hidden.name = "ExistingFiles[]";
      hidden.value = file.name;
      fileBox.appendChild(hidden);

      existingBox.appendChild(fileBox);
    } else {
      deleteBtn.addEventListener("click", () => {
        uploadedFiles = uploadedFiles.filter(f => f.name !== file.name);
        updateInputFiles();
        fileBox.remove();
      });

      newBox.appendChild(fileBox);
    }

    fileBox.appendChild(fileName);
    fileBox.appendChild(deleteBtn);
  }

  // Pre-bind delete logic for already rendered existing items
  document.querySelectorAll(".file-item.existing").forEach(item => {
    const btn = item.querySelector(".delete-btn");
    const hidden = item.querySelector("input[type='hidden']");
    btn.addEventListener("click", () => {
      item.remove();
      if (hidden) hidden.remove();
    });
  });

  input.addEventListener("change", function() {
    const selected = Array.from(this.files);
    const existingNames = Array.from(document.querySelectorAll(".file-item.existing"))
      .map(el => el.getAttribute("data-filename"));
    const newNames = uploadedFiles.map(f => f.name);

    selected.forEach(file => {
      const fileName = file.name;
      const isDuplicate = [...existingNames, ...newNames].includes(fileName);

      if (isDuplicate) {
        const newName = autoRename(fileName);
        const confirmOverwrite = confirm(`"${fileName}" already exists.\nClick OK to overwrite, Cancel to rename to "${newName}".`);

        if (confirmOverwrite) {
          uploadedFiles = uploadedFiles.filter(f => f.name !== fileName);
          uploadedFiles.push(file);
          addFileToList(file, false);
        } else {
          const renamed = new File([file], newName, {
            type: file.type
          });
          uploadedFiles.push(renamed);
          addFileToList(renamed, false);
        }
      } else {
        uploadedFiles.push(file);
        addFileToList(file, false);
      }
    });

    updateInputFiles();
    // input.value = ""; // reset input so same file can be re-selected
  });

  // Drag and drop functionality
  label.addEventListener("dragover", function(e) {
    e.preventDefault();
    label.classList.add("dragover");
  });

  label.addEventListener("dragleave", function() {
    label.classList.remove("dragover");
  });

  label.addEventListener("drop", function(e) {
    e.preventDefault();
    label.classList.remove("dragover");
    
    const droppedFiles = Array.from(e.dataTransfer.files);
    uploadedFiles.push(...droppedFiles);
    updateInputFiles();
    
    droppedFiles.forEach(file => {
      addFileToList(file, false);
    });
  });
</script>

<script>
  const fieldset = document.querySelector("fieldset");
  const deletebtn = document.querySelector("#delete-btn");
  const form = document.querySelector("form");
  const id = form.dataset.id;

  if (deletebtn) {
    deletebtn.addEventListener('click', async () => {
      if (confirm("Are you sure you want to delete this post?")) {
        const url = `${window.API}/jobpost?id=${id}`
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
  const comment = document.querySelector("#comment");

  if (editbtn) {
    editbtn.addEventListener("click", () => {
      fieldset.disabled = false;
      document.querySelector("#File_description").disabled = false;
      submitbtn.style.display = 'block';
      editbtn.style.display = 'none';
      if (comment) comment.style.display = 'none';
    })
  }
  if (submitbtn) {
    submitbtn.addEventListener("click", async () => {
      const url = `${window.API}/jobpost?id=${id}`;
      const formData = new FormData(form);

      // Log form data for debugging
      for (let [key, value] of formData.entries()) {
        if (value instanceof File) {
          console.log(`${key}: ${value.name} (size: ${value.size} bytes)`);
        } else {
          console.log(`${key}: ${value}`);
        }
      }
      
      const response = await fetch(url, {
        method: 'POST',
        headers: {
          "X-HTTP-Method-Override": "PUT"
        },
        body: formData
      });
      const res = await response.json();
      if (res.status == 'success') {
        fieldset.disabled = true;
        document.querySelector("#File_description").disabled = true;
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
    const status = approvalForm ? approvalForm.dataset.value : "";
    const statusResult = document.querySelector("#app-status");
    if (approvalForm) {
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
        const url = `${window.API}/approval?postid=<?= $post['ID'] ?>`;
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
        const reason = document.querySelector("#approval-reason").innerText;
        approvalFormSubmit(reason, 'disapproved')
      })
      acceptbtn.addEventListener('click', (e) => {
        e.preventDefault();
        const reason = document.querySelector("#approval-reason").innerText;
        approvalFormSubmit(reason, 'approved')
      })
    }
  })
</script>