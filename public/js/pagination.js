// pagination utils
function debounce(func, delay) {
  let timer;
  return function (...args) {
    clearTimeout(timer);
    timer = setTimeout(() => {
      func.apply(this, args);
    }, delay);
  };
}

const state = {
  sort: "",
  filter: {},
  currentPage: 1,
};

function getLoader(LoadContentSuccess, LoadContentFail, DestGenerate, url=null) {
  
  const pagination = document.querySelector(".container-pagination");
  const searchBar = document.querySelector(".search-box input");
  const sortSelect = document.querySelector(".sort-choices");
  const statusFilter = document.querySelector(".status-filter");
  attachEvents();
  
  const fetchurl = url == null ? `${window.API}/jobposts` : url;
  async function loadPost(sort, filter, page_num) {
    try {
      const response = await fetch(fetchurl, {
        method: "POST",
        headers: {
          "Content-Type": "application/json",
        },
        body: JSON.stringify({
          sort,
          filter,
          page_num,
        }),
      });

      if (!response.ok) {
        console.error("Failed to fetch job posts:", response.status);
        return;
      }

      const res = await response.json();
      let html = "";
      if (res.data.length > 0) {
        html = res.data.reduce((acc, ele) => acc + LoadContentSuccess(ele), "");
      } else {
        html = LoadContentFail();
      }

      document.querySelector(".card-display").innerHTML = html;
      updatePagination(page_num, res.total);
      attachCardView();
      attachPagination(res.total);
    } catch (error) {
      console.error("Error loading job posts:", error);
    }
  }

  function attachEvents() {
    if (sortSelect) {
      state.sort = sortSelect.value;
      sortSelect.addEventListener("input", () => {
        state.sort = sortSelect.value;
        loadPost(state.sort, state.filter, 1);
      });
    }

    if (searchBar) {
      searchBar.addEventListener(
        "input",
        debounce(() => {
          state.filter.search = searchBar.value;
          loadPost(state.sort, state.filter, 1);
        }, 500)
      );
    }
    if (statusFilter) {
      statusBtn = statusFilter.querySelectorAll('button');
      statusBtn.forEach((btn) => {
        btn.addEventListener('click', () => {
          state.filter.status = btn.value == 'all' ? "" : btn.value;
          loadPost(state.sort, state.filter, 1);
        })
      })
    }

    attachPagination(5);
    attachCardView();
  }

  function updatePagination(current, total) {
    let html = "";
    if (total > 0) {
      

    if (total > 5) {
      // Previous Button
      html += `<a href="" class="page-links ${current === 1 ? "disabled-page" : ""}" id="prev">
        <i class='bx bx-left-arrow-alt'></i> Previous
      </a>`;
    
      // Always show first page
      html += `<a href="" class="page-links ${current === 1 ? "active-page" : ""}" id="page-first">1</a>`;
    
      // Case 1 & 2: current is 1 or 2
      if (current === 1 || current === 2) {
        html += `<a href="" class="page-links ${current === 2 ? "active-page" : ""}" id="page-2">${2}</a>`;
        html += `<a href="" class="page-links ${current === 3 ? "active-page" : ""}" id="page-3">${3}</a>`;
        html += `<a href="" class="page-links">...</a>`;
        html += `<a href="" class="page-links" id="page-last">${total} </a>`;
      }
    
      // Case 3: current is 3
      else if (current === 3) {
        html += `<a href="" class="page-links" id="page-2">${2}</a>`;
        html += `<a href="" class="page-links active-page" id="page-3">${3}</a>`;
        html += `<a href="" class="page-links" id="page-4">${4}</a>`;
        html += `<a href="" class="page-links">...</a>`;
        html += `<a href="" class="page-links" id="page-last">${total} </a>`;
      }
    
      // Middle pages: current between 4 and total-3
      else if (current > 3 && current < total - 2) {
        html += `<a href="" class="page-links">...</a>`;
        html += `<a href="" class="page-links" id="page-prev">${current - 1} </a>`;
        html += `<a href="" class="page-links active-page" id="page-current">${current} </a>`;
        html += `<a href="" class="page-links" id="page-next">${current + 1} </a>`;
        html += `<a href="" class="page-links">...</a>`;
        html += `<a href="" class="page-links" id="page-last">${total} </a>`;
      }
    
      // Case 4: current == total - 2
      else if (current === total - 2) {
        html += `<a href="" class="page-links">...</a>`;
        html += `<a href="" class="page-links" id="page-prev">${current - 1} </a>`;
        html += `<a href="" class="page-links active-page" id="page-current">${current} </a>`;
        html += `<a href="" class="page-links" id="page-last">${current + 1} </a>`;
      }
    
      // Case 5: current == total -1 or total
      else if (current >= total - 1) {
        html += `<a href="" class="page-links">...</a>`;
        html += `<a href="" class="page-links ${current === total - 1 ? "active-page" : ""}" id="page-prev-total">${total - 1}</a>`;
        html += `<a href="" class="page-links ${current === total ? "active-page" : ""}" id="page-last">${total}</a>`;
      }
    
      // Next Button
      html += `<a href="" class="page-links ${current === total ? "disabled-page" : ""}" id="next">
        Next <i class='bx bx-right-arrow-alt'></i>
      </a>`;
    }
      // case page >= 1 && <= 5
      else {
        html += `<a href="" style="gap: .3rem;" class="page-links ${current === 1 ? "disabled-page" : ""}" id="prev">
        <i class='bx bx-left-arrow-alt'></i>
        Previous
      </a>`;
      
        html += `<a href="" class="page-links ${current === 1 ? "active-page" : ""}" id="page-first">
        1
      </a>`;

        if (total === 5){
            html += `<a href="" class="page-links ${current === 2 ? "active-page" : ""}" id="page-2">
            2
          </a>`;
            
            html += `<a href="" class="page-links ${current === 3 ? "active-page" : ""}" id="page-3">
            3
          </a>`;

            html += `<a href="" class="page-links ${current === 4 ? "active-page" : ""}" id="page-4">
            4
          </a>`;

          html += `<a href="" class="page-links ${current === total ? "active-page" : ""}" id="page-last">
            ${total}
          </a>`;
        } else if (total === 4){
            html += `<a href="" class="page-links ${current === 2 ? "active-page" : ""}" id="page-2">
            2
          </a>`;
            
            html += `<a href="" class="page-links ${current === 3 ? "active-page" : ""}" id="page-3">
            3
          </a>`;

          html += `<a href="" class="page-links ${current === total ? "active-page" : ""}" id="page-last">
            ${total}
          </a>`;
        } else if (total === 3){
          html += `<a href="" class="page-links ${current === 2 ? "active-page" : ""}" id="page-2">
            2
          </a>`;

          html += `<a href="" class="page-links ${current === total ? "active-page" : ""}" id="page-last">
            ${total}
          </a>`;
        } else if (total === 2){
          html += `<a href="" class="page-links ${current === total ? "active-page" : ""}" id="page-last">
            ${total}
          </a>`;
        } 

        html += `<a href="" style="gap: .3rem;" class="page-links ${current === total ? "disabled-page" : ""}" id="next">
        Next
        <i class='bx bx-right-arrow-alt' ></i>
      </a>`;

      }
    }
    state.currentPage = current;
    pagination.innerHTML = html;
  }

  function attachPagination(total) {
    pagination.addEventListener("click", (e) => {
      if (e.target.closest("#prev")) {
        loadPost(state.sort, state.filter, state.currentPage - 1);
      }
      if (e.target.closest("#next")) {
        loadPost(state.sort, state.filter, state.currentPage + 1);
      }

      if (e.target.closest("#page-prev")) {
        loadPost(state.sort, state.filter, state.currentPage - 1);
      }
      if (e.target.closest("#page-prev-total")) {
        loadPost(state.sort, state.filter, total - 1);
      }
      if (e.target.closest("#page-next")) {
        loadPost(state.sort, state.filter, state.currentPage + 1);
      }

      if (e.target.closest("#page-2")) {
        loadPost(state.sort, state.filter, 2);
      }
      if (e.target.closest("#page-3")) {
        loadPost(state.sort, state.filter, 3);
      }

      if (e.target.closest("#page-4")) {
        loadPost(state.sort, state.filter, 4);
      }

      if (e.target.closest("#page-first")) {
        loadPost(state.sort, state.filter, 1);
      }
      if (e.target.closest("#page-last")) {
        loadPost(state.sort, state.filter, total);
      }
    });
  }

  function attachCardView() {
    const jobcards = document.querySelectorAll(".job-card");
    jobcards.forEach((card) => {
      const id = card.dataset.id;
      const name = card.dataset.name;
      card.addEventListener("click", () => {
        window.location.href = DestGenerate(id, name);
      });
    });
  }

  return loadPost;
}
