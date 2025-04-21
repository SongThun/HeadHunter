<?php include __DIR__ . "/../../utils.php" ?>
<style>
  .container-pagination a{
    text-decoration: none;
  }
  .container-pagination > button {
  border: none !important;
  background: none ;
}
</style>
<div>
  <div class="container-search" style="background: var(--off-white);margin-top: 0;height: 6rem;">
    <!-- search bar -->
    <div class="search-box">
      <!-- <form action=""> -->
        <i class="fa-solid fa-magnifying-glass"></i>
        <input type="text" name="search" placeholder="Search anything here...">
      <!-- </form> -->
    </div>

    <div class="right-box">

      <!-- filter box -->
      <div class="filter-box" style="z-index:9999;">
        <button><i class="fa-solid fa-sliders"></i></button>
        <div class="filter-box-list" style="display: none;">
          <div class="filter-box-list-sub">
            <div id="filter-location" class="filter-list-value location">
              <div class="filter-title">Location: </div>
              <button value="San Francisco, CA" class="filter-value">San Francisco, CA</button>
              <button value="Remote" class="filter-value">Remote</button>
              <button value="Chicago, IL" class="filter-value">Chicago, IL</button>
              <button value="Boston, MA" class="filter-value">Boston, MA</button>
            </div>
          </div>

          <div class="filter-box-list-sub">
            <div id="filter-level" class="filter-list-value level">
              <div class="filter-title">Level: </div>
              <button value="Intern" class="filter-value">Intern</button>
              <button value="Fresher" class="filter-value">Fresher</button>
              <button value="Junior" class="filter-value">Junior</button>
              <button value="Middle" class="filter-value">Middle</button>
              <button value="Senior" class="filter-value">Senior</button>
            </div>
          </div>

          <div class="filter-box-list-sub">
            <div id="filter-salary" class="filter-list-value salary">
              <div class="filter-title">Salary: </div>
              <button value="< 10000" class="filter-value"> 10.000</button>
              <button value="BETWEEN 10000 AND 20000" class="filter-value">10.000 - 20.000</button>
              <button value="BETWEEN 20000 AND 30000" class="filter-value">20.000 - 30.000</button>
              <button value="> 30000" class="filter-value">30.000</button>
            </div>
          </div>

        </div>
      </div>
      <!-- end filter box -->

      <!-- sort box -->
      <div class="sort-by-box">
        <label for="sort">Sort by:</label>
        <select class="sort-choices" name="sort">
          <option value="CreatedDate DESC" selected>Newest</option>
          <option value="CreatedDate ASC">Oldest</option>
          <option value="Salary DESC">Highest Salary</option>
        </select>
      </div>
      <!-- end sort box -->
    </div>
  </div>

  <!-- job listings -->
  <div class="container-list-job card-display" style="z-index:1;">
    
  </div>
  <!-- end job listings -->

  <!-- navigation  -->
  <div class="container-pagination"></div>
  <!-- end navigation -->
  
</div>

<script src="<?= SCRIPT_PATH ?>/pagination.js"></script>
<script src="<?= SCRIPT_PATH ?>/utils.js"></script>
<script>
  const filterBox = document.querySelector(".filter-box");
  const filterBtn = document.querySelector(".filter-box button");
  const filterBoxList = document.querySelector(".filter-box-list");

  filterBtn.addEventListener("click", (e) => {
    e.stopPropagation();
    // filterBoxList.classList.toggle("show");
    filterBoxList.style.display = filterBoxList.style.display == 'none' ? 'block' : 'none';
  });

  document.addEventListener("click", function(e) {
    if (!filterBoxList.contains(e.target)) {
      if (filterBoxList.classList.contains("show"))
        // filterBoxList.classList.remove("show");
        filterBoxList.style.display = 'none';
    }
  });
</script>

<script>
  const loadSuccess = (job) => {
    return `
    <div class="container-job-card"">
      <div class="container-job-card-left">
        <div class="containter-job-title">
          <h2>${escapeHTML(job.Postname)}</h2>
        </div>
        <div class="container-job-description">
          <div class="calender">
            <i class="fa-regular fa-calendar-check"></i>
            ${formatDate(job.CreatedDate)} - ${formatDate(job.Due)}
          </div>
          <div class="location">
            <i class="fa-regular fa-map"></i>
            ${escapeHTML(job.Location)}
          </div>
        </div>
      </div>
      <div class="container-job-card-right">
        <div>
          <a href="${destGen(job.ID,job.Postname)}">
            <button class="apply-now">Apply now</button>
          </a>
        </div>
      </div>
    </div>
  `;
  }

  const loadFail = () => {
    return `<div class="no-jobs-found" style="z-index: 1;">
        <h3>No job listings found</h3>
        <p>Try adjusting your search criteria</p>
      </div>`
  }

  const destGen = (id, name) => {
    return window.BASE_URL + '/jobpost/view/' + `${slugify(name)}-${id}`;   
  }
  
  const loadPostGuest = getLoader(loadSuccess, loadFail, destGen);

  const locationFilter = document.querySelector("#filter-location")
    const locationBtns = locationFilter.querySelectorAll('button');
    locationBtns.forEach((btn) => {
  
      btn.addEventListener('click', () => {
        btn.classList.toggle('chosen');
        state.filter.location = Array.from(locationFilter.querySelectorAll('.chosen')).map(btn => btn.value);
        // console.log("locationssssss: ", state.filter.location);
        debounce(loadPostGuest, 500)(state.sort, state.filter, 1);
      })
    })
  
    const levelFilter = document.querySelector("#filter-level");
    const levelBtns = levelFilter.querySelectorAll('button');
    levelBtns.forEach((btn) => {
      btn.addEventListener('click', () => {
        btn.classList.toggle('chosen');
        state.filter.level = Array.from(levelFilter.querySelectorAll('.chosen')).map(btn => btn.value);
        debounce(loadPostGuest, 500)(state.sort, state.filter, 1);
      })
    })
  
    const salaryFilter = document.querySelector("#filter-salary")
    const salaryBtns = salaryFilter.querySelectorAll('button')
    salaryBtns.forEach((btn) => {
      btn.addEventListener('click', () => {
        btn.classList.toggle('chosen');
        state.filter.salary = Array.from(salaryFilter.querySelectorAll('.chosen')).map(btn => btn.value);
        debounce(loadPostGuest, 500)(state.sort, state.filter, 1);
      });
    })
    document.addEventListener('DOMContentLoaded', () => {
      loadPostGuest(state.sort, state.filter, 1);
    })
</script>