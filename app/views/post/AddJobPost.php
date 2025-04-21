<div class="position-form-container container bg-light">
  <div class="pt-4 pb-4">
    <a href="javascript:history.back()" class="d-flex align-items-center text-decoration-none text-dark mb-4">
      <i class="bi bi-arrow-left me-2"></i>
      <span>Back</span>
    </a>


    <fieldset>
      <form>
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
          <input list="" type="text" name="Salary" id="salary" required>
        </div>

        <!-- File upload -->
        <div class="mt-4">
          <label class="form-label"><span class="position-form-required-star">*</span>Description</label>
          <div class="rounded p-4 text-center position-form-file-upload">
            <input name="File_description" type="file" accept=".txt,.pdf,.docx,.jpeg" class="position-form-input form-control"
              id="position-form-file-input">
            <i class="bi bi-upload fs-2 mb-2"></i>
            <p class="text-secondary mb-2">Choose a file or drag and drop it here</p>
            <p class="text-secondary mb-4">.txt, .pdf, .docx, .jpeg - Up to 50MB</p>
            <button type="button" class="position-form-browse-btn"
              onclick="document.getElementById('position-form-file-input').click()">Browse File</button>
          </div>
        </div>

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

<script>
  const fieldset = document.querySelector("fieldset");
  const deletebtn = document.querySelector("#delete-btn");
  const form = document.querySelector("form");
  // const id = form.dataset.id;
  const id = null;
  const title = null;
  if (deletebtn) {
    deletebtn.addEventListener('click', async () => {
      if (confirm("Are you sure you want to delete this post?")) {
        const url = `<?= API ?>jobpost?id=${id}`
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
      const url = `<?= API ?>jobpost?id=${id}`;
      // const data = await form2json(form);
      const data = new FormData(form);
      // console.log(data);
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