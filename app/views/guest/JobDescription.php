<?php
// Fetch provinces directly in the view
function getProvinces() {
    try {
        // Direct database connection matching the api.php approach
        $db = new mysqli('localhost', 'root', '', 'jobhunter');
        
        if ($db->connect_error) {
            error_log("Database connection failed: " . $db->connect_error);
            return [];
        }
        
        $sql = "SELECT code, name FROM provinces ORDER BY name";
        $result = $db->query($sql);
        
        $provinces = [];
        if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $provinces[] = $row;
            }
        }
        
        $db->close();
        return $provinces;
    } catch (Exception $e) {
        error_log("Error in getProvinces: " . $e->getMessage());
        return [];
    }
}

$provinces = getProvinces();
?>

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

<div class="outside-description">
  <div class="description">
    <!-- JOB DESCRIPTION -->
    <div class="job-title">
      <h1><?= e($job['Postname'] ?? 'Job Title Not Available') ?></h1>
    </div>
    <div class="job-description">
      <div class="job-description-sub">
        <div class="applicants">
          <h3>Applicants: </h3>
          <p><?= e($job['Applicants_apply']) ?></p>
        </div>
        <div class="locations">
          <h3>Location: </h3>
          <p><?= e($job['Location'] ?? 'Not specified') ?></p>
        </div>
      </div>
      <div class="job-description-sub">
        <div class="level">
          <h3>Salary: </h3>
          <p><?= e($job['Salary'] ?? 'Not specified') ?></p>
        </div>
        <div class="due-date">
          <h3>Due date: </h3>
          <p><?= e(isset($job['Due']) && !empty($job['Due']) ? formatDate($job['Due']) : 'Not specified') ?></p>
        </div>
      </div>
      <div class="job-description-section-title">
        <h3>Description</h3>
      </div>
      <div class="job-description-section">
        <!--         
        <?php if (isset($job['File_description']) && !empty($job['File_description'])): ?>
          <div class="file-box">
            <div class="pdf-options">
              <a href="<?= e(UPLOAD_DESC . "/" . $job['File_description']) ?>" target="_blank">
                <i class="fas fa-file-pdf"></i> Download Job Description PDF
              </a>
              <button id="toggle-pdf-viewer" class="btn-view-pdf">
                <i class="fas fa-eye"></i> View PDF
              </button>
            </div>

            <div id="pdf-viewer-container" style="display: none; margin-top: 15px;">
              <div class="pdf-viewer-wrapper">
                <object data="<?= e(UPLOAD_DESC . "/" . $job['File_description']) ?>"
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
        <?php endif; ?> -->
        <!-- <div id="existing-file-list">
          <php
          $folderPath = realpath(dirname(__DIR__) . "/../../public/upload/descriptions/" . $job['ID']);
          if (is_dir($folderPath)) {
            $files = glob($folderPath . "/*");
            foreach ($files as $file) {
              $fileName = basename($file);
              echo "<div class='file-item existing' data-filename='" . htmlspecialchars($fileName, ENT_QUOTES) . "'>
                    <span>" . e($fileName) . "</span>
                    <button class='delete-btn'>Delete</button>
                    <input type='hidden' name='ExistingFiles[]' value='" . htmlspecialchars($fileName, ENT_QUOTES) . "'>
                  </div>";
            }
          }
          ?>
        </div> -->

        <div id="existing-file-list" style="display: flex; flex-direction: column; flex: 1; ">
  <?php
  $folderPath = realpath(dirname(__DIR__) . "/../../public/upload/descriptions/" . $job['ID']);
  $relativePath = UPLOAD_DESC ."/" . $job['ID']; // Public-facing relative URL path

  if (is_dir($folderPath)) {
    $files = glob($folderPath . "/*");
    foreach ($files as $file) {
      $fileName = basename($file);
      $fileUrl = htmlspecialchars($relativePath . "/" . $fileName, ENT_QUOTES);
      echo "<div class='file-item existing' style='padding: .5rem 0 .5rem 0;' data-filename='" . htmlspecialchars($fileName, ENT_QUOTES) . "'>
        <a href='" . $fileUrl . "' download target='_blank'>" . htmlspecialchars($fileName) . "</a>
        <input type='hidden' name='ExistingFiles[]' value='" . htmlspecialchars($fileName, ENT_QUOTES) . "'>
      </div>";
    }
  }
  ?>
</div>
        <div class="job-details">
          <h3>Job Description: </h3>
          <p><?= nl2br(e($job['Description'] ?? 'No description available')); ?></p>

          <h3>Number of Positions: </h3>
          <p><?= e($job['Applicants_max'] ?? 'Not specified'); ?> candidate(s)</p>

          <h3>Posted Date: </h3>
          <p><?= e(formatDate($job['CreatedDate'])) ?></p>

        </div>
      </div>
    </div>
    <!-- END JOB DESCRIPTION -->

    <!-- APPLICATION FORM -->
    <fieldset>
      <form method="POST" enctype="multipart/form-data" data-id="<?= e($job['ID']) ?>">
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
            <!-- Replace existing location input fields with these dropdown selects -->
            <div class="form-row">
              <div class="form-row-half">
                <label for="province-select"><span style="color: red; margin-right: .2rem;">*</span>City/Province</label>
                <select name="ProvinceCode" id="province-select" required onchange="loadDistricts(this.value)">
                  <option value="">Select City/Province</option>
                  <?php foreach ($provinces as $province): ?>
                    <option value="<?= htmlspecialchars($province['code']) ?>"><?= htmlspecialchars($province['name']) ?></option>
                  <?php endforeach; ?>
                </select>
              </div>
              <div class="form-row-half">
                <label for="district-select"><span style="color: red; margin-right: .2rem;">*</span>District</label>
                <select name="DistrictCode" id="district-select" required disabled>
                  <option value="">Select District First</option>
                </select>
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
                <label id="unique" for="file-applicant"><span style="color: red; margin-right: .2rem;">*</span>Resume</label>
                <input type="file" name="File_CV" id="file-applicant" style="display: none;" required>
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
        <!-- Hidden field to store the combined location string -->
        <input type="hidden" name="Location" id="location-combined">
      </form>
    </fieldset>
    <!-- END APPLICATION FORM -->

  </div>
</div>
</main>

<!-- HANDLE MULTIPLE FILE -->
<script>
  const input = document.getElementById("file-applicant");
  const label = document.getElementById("unique");

  function updateLabel(files) {
    if (files && files.length > 0) {
      const fileNames = Array.from(files).map(file => file.name);
      label.textContent = fileNames.join("\n");
    } else {
      label.textContent = "Upload Image";
    }
  }

  input.addEventListener("change", function() {
    updateLabel(this.files);
  });

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

    const droppedFiles = e.dataTransfer.files;
    input.files = droppedFiles; // assign to input
    updateLabel(droppedFiles);
  });
</script>

<script>
  const fieldset = document.querySelector("fieldset")
  const form = document.querySelector("form");
  const id = form.dataset.id;
  console.log(id);
  const applyBtn = document.querySelector("#apply")


  if (applyBtn) {
    applyBtn.addEventListener('click', async (e) => {
      e.preventDefault();
      const url = `${window.API}/apply/${id}`;
      const response = await fetch(url, {
        method: 'POST',
        body: new FormData(form)
      });
      const res = await response.json();
      if (res.status == 'success') {
        alert("You've successfully applied for this job")
        window.location.reload();
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
<script>
// Replace the existing loadDistricts function with this updated version

function loadDistricts(provinceCode) {
  const districtSelect = document.getElementById('district-select');
  
  // Clear existing options
  while (districtSelect.options.length > 1) {
    districtSelect.remove(1);
  }
  
  if (!provinceCode) {
    districtSelect.disabled = true;
    districtSelect.options[0].text = "Select District First";
    return;
  }
  
  // Show loading
  districtSelect.disabled = true;
  districtSelect.options[0].text = "Loading...";
  
  // Use direct endpoint instead of API router
  const apiUrl = `${window.BASE_URL}/public/getDistricts.php?province=${provinceCode}`;
  console.log("Fetching districts from:", apiUrl);
  
  fetch(apiUrl)
    .then(response => {
      if (!response.ok) {
        throw new Error(`HTTP error! Status: ${response.status}`);
      }
      return response.json();
    })
    .then(districts => {
      console.log("Districts loaded:", districts);
      
      // Reset placeholder
      districtSelect.options[0].text = "Select District";
      
      // Add new options
      if (Array.isArray(districts) && districts.length > 0) {
        districts.forEach(district => {
          const option = document.createElement('option');
          option.value = district.code;
          option.textContent = district.name;
          districtSelect.appendChild(option);
        });
        
        // Enable the select
        districtSelect.disabled = false;
      } else {
        console.log("No districts found for province:", provinceCode);
        districtSelect.options[0].text = "No districts available";
      }
    })
    .catch(error => {
      console.error("Error loading districts:", error);
      districtSelect.options[0].text = "Error loading districts";
    });
}

// Handle form submission to create the combined location string
document.addEventListener('DOMContentLoaded', function() {
  const form = document.querySelector('form[data-id]');
  if (form) {
    form.addEventListener('submit', function() {
      const provinceSelect = document.getElementById('province-select');
      const districtSelect = document.getElementById('district-select');
      const locationCombined = document.getElementById('location-combined');
      
      if (provinceSelect.selectedIndex > 0 && districtSelect.selectedIndex > 0) {
        const provinceName = provinceSelect.options[provinceSelect.selectedIndex].text;
        const districtName = districtSelect.options[districtSelect.selectedIndex].text;
        locationCombined.value = `${districtName}, ${provinceName}`;
      }
    });
  }
});
</script>