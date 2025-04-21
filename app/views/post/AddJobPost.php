<style>
  #unique {
    border: 1px dashed #999;
    display: flex;
    align-items: center;
    justify-content: center;
    min-height: 100px;
    width: 100%;
    border-radius: 10px;
    transition: .3s;
    cursor: pointer;

    white-space: pre-wrap;
    overflow-wrap: break-word;
    text-align: center;
    flex-wrap: wrap;
  }

  #unique:hover {
    color: #1DA1F2;
    border: 1px dashed #1DA1F2;
  }
</style>

<div class="position-form-container container bg-light">
  <div class="pt-4 pb-4">
    <a href="javascript:history.back()" class="d-flex align-items-center text-decoration-none text-dark mb-4">
      <i class="bi bi-arrow-left me-2"></i>
      <span>Back</span>
    </a>


    <fieldset>
      <form method="POST" enctype="multipart/form-data">
        <h1 class="text-center text-secondary mb-5"><input name="Postname" type="text" placeholder="Position Title"></h1>
        <div class="row g-4">
          <!-- location input -->
          <div class="col-md-6">
            <label class="form-label"><span class="position-form-required-star">*</span>Location</label>
            <div class="position-form-group input-group">
              <span class="position-form-icon-container input-group-text">
                <i class="bi bi-geo"></i>
              </span>

              <!-- Continue adding other provinces -->
              </select>
              <input type="text" name="Location" list="location-list" required>
              <datalist id="location-list">
                <option value="San Francisco, CA">
                <option value="Remove">
                <option value="Chicago">
                <option value="Boston, MA">
                <option value="Austin, TX">
                  <!-- Add remaining 58 provinces here -->
                <option value="New York, NY">
                <option value="Seattle, WA">
                <option value="Portland, OR">
                <option value="Denver, CO">
                <option value="Cambridge, MA">
                <option value="Jersey City, NJ">
              </datalist>
            </div>
          </div>

          <!-- due date input -->
          <div class="col-md-6">
            <label class="form-label"><span class="position-form-required-star">*</span>Due date</label>
            <div class="position-form-group input-group">
              <span class="position-form-icon-container input-group-text">
                <i class="bi bi-calendar3"></i>
              </span>
              <input name="Due" type="date" value="2025-03-01" class="position-form-input form-control" required>
            </div>
          </div>

        </div>

        <!-- level input -->
        <div class="mt-4">
          <label class="form-label">Level</label>
          <input list="lists" type="text" name="Level" id="Level" required>
          <datalist id="lists">
            <option value="Intern">
            <option value="Junior">
            <option value="Middle">
            <option value="Senior">
            <option value="Lead">
          </datalist>
        </div>

        <!-- salary input -->
        <div class="mt-4">
          <label class="form-label">Salary</label>
          <input list="" type="number" name="Salary" id="Salary" required min="0">
        </div>
        <div class="mt-4">
          <label class="form-label">Maximum number of applicants</label>
          <input list="" type="number" name="Applicants_max" id="Applicants_max" required min="1" step="1">
        </div>
        <!-- File upload -->
        <!-- <div class="mt-4">
          <label class="form-label"><span class="position-form-required-star">*</span>Description</label>
          <div class="rounded p-4 text-center position-form-file-upload">
            <input name="File_description[]" type="file" accept=".txt,.pdf,.docx,.jpeg" class="position-form-input form-control"
              id="position-form-file-input" multiple>
            <i class="bi bi-upload fs-2 mb-2"></i>
            <p class="text-secondary mb-2">Choose a file or drag and drop it here</p>
            <p class="text-secondary mb-4">.txt, .pdf, .docx, .jpeg - Up to 50MB</p>
            <button type="button" class="position-form-browse-btn"
              onclick="document.getElementById('position-form-file-input').click()">Browse File</button>
          </div>
          <div class="attachment"></div>
        </div> -->

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
            word-break: break-all;
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
        </style>

        <div class="mt-4">
          <label id="unique" for="File_description"><span style="color: red; margin-right: .2rem;">*</span>Resume</label>
          <input type="file" name="File_description[]" id="File_description" style="display: none;" multiple required>
        </div>

        <div id="file-list" style="margin-top: 1rem;"></div>

        <!-- Description -->
        <div class="mt-4">
          <textarea name="Description" class="position-form-input form-control" rows="5"
            placeholder="Or write something about this position: requirements, job description, ..."></textarea>
        </div>

        <!-- submit btn -->
        <div class="text-center mt-5">
          <button id="submit-btn" type="submit" class="position-form-submit-btn btn-primary">Submit for Review</button>
        </div>

      </form>
    </fieldset>


    <!-- CRUD btns -->
    <div class="flex" id="edit-btn-group" style="display: none;">
      <button id="delete-btn" class="btn job-posting-btn-custom job-posting-btn-delete">Delete post</button>
      <button id="edit-btn" class="btn job-posting-btn-custom job-posting-btn-edit">Edit post</button>
    </div>


  </div>
</div>

<!-- HANDLE MULTIPLE FILE -->
<script>
  const input = document.getElementById("File_description");
  const label = document.getElementById("unique");
  const fileListDisplay = document.getElementById("file-list");

  let uploadedFiles = [];

  function renderFileList() {
    fileListDisplay.innerHTML = "";

    uploadedFiles.forEach((file, index) => {
      const fileBox = document.createElement("div");
      fileBox.className = "file-item";

      const fileName = document.createElement("span");
      fileName.textContent = file.name;

      const deleteBtn = document.createElement("button");
      deleteBtn.className = "delete-btn";
      deleteBtn.textContent = "Delete";
      deleteBtn.addEventListener("click", () => {
        uploadedFiles.splice(index, 1);
        updateInputFiles();
        renderFileList();
      });

      fileBox.appendChild(fileName);
      fileBox.appendChild(deleteBtn);
      fileListDisplay.appendChild(fileBox);
    });
  }

  function updateInputFiles() {
    const dataTransfer = new DataTransfer();
    uploadedFiles.forEach(file => dataTransfer.items.add(file));
    input.files = dataTransfer.files;
  }

  input.addEventListener("change", function() {
    for (const file of this.files) {
      uploadedFiles.push(file);
    }
    updateInputFiles();
    renderFileList();
  });

  // Drag-and-drop
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
    renderFileList();
  });
</script>


<script>
  const fieldset = document.querySelector("fieldset");
  const deletebtn = document.querySelector("#delete-btn");
  const form = document.querySelector("form");
  // const id = form.dataset.id;
  let id = null;
  let title = null;
  if (deletebtn) {
    deletebtn.addEventListener('click', async () => {
      if (confirm("Are you sure you want to delete this post?")) {
        const url = `${window.API}/jobpost?id=${id}`
        const response = await fetch(url, {
          method: 'DELETE'
        });
        const res = await response.json();
        if (res.status === 'success') {
          alert(`Delete post ${title}`)
          window.history.back();
        }
      }
    })
  }
  const btngroup = document.querySelector("#edit-btn-group");
  const editbtn = document.querySelector("#edit-btn");
  const submitbtn = document.querySelector("#submit-btn");
  // const fileUpload = document.querySelector("#file-upload");

  if (editbtn) {
    editbtn.addEventListener("click", () => {
      fieldset.disabled = false;
      submitbtn.style.display = 'block';
      btngroup.style.display = 'none';
    })
  }
  if (submitbtn) {
    submitbtn.addEventListener("click", async (e) => {
      e.preventDefault();
      const url = `${window.API}/jobpost?id=${id}`;
      const data = new FormData(form);
      const response = await fetch(url, {
        method: 'POST',
        headers: {
          "X-HTTP-Method-Override": "POST"
        },
        body: data
      });
      const res = await response.json();
      if (res.status == 'success') {
        // alert(`Post successful: ${data.get('Postname')}`);
        fieldset.disabled = true;
        btngroup.style.display = 'block';
        submitbtn.style.display = 'none';
        id = res.id
        title = data.get('Postname');
      }
    })
  }
</script>