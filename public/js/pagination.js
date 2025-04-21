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

function getLoader(
  LoadContentSuccess,
  LoadContentFail,
  DestGenerate,
  url = null
) {
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
      attachPagination();
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
      statusBtn = statusFilter.querySelectorAll("button");
      statusBtn.forEach((btn) => {
        btn.addEventListener("click", () => {
          state.filter.status = btn.value == "all" ? "" : btn.value;
          loadPost(state.sort, state.filter, 1);
        });
      });
    }

    attachPagination(5);
    attachCardView();
  }

  function updatePagination(current, total) {
    if (total === 0) {
      display.innerHTML = "";
      pagination.innerHTML = "";
      return 0;
    }

    const delta = 1;
    const range = [];

    if (current >= 1) range.push(1);
    if (current - delta > 2) range.push("...");
    for (let i = current - delta; i <= current + delta; ++i) {
      if (i > 1 && i < total) range.push(i);
    }
    if (current + delta < total - 1) range.push("...");
    if (current <= total && total !== 1) range.push(total);

    let html = "";
    if (total > 1 && current > 1)
      html += `<button id="prev" class="page-links" ><i class='bx bx-chevron-left'></i></button>`;
    else
      html += `<button disabled id="prev" class="page-links disabled-page" ><i class='bx bx-chevron-left'></i></button>`;

    range.forEach((page) => {
      if (page === "...") {
        html += `<button disabled>...</button>`;
      } else if (page === current) {
        html += `<button class="page-links active-page" data-page="${page}">${page}</button>`;
      } else {
        html += `<button class="page-links" data-page="${page}">${page}</button>`;
      }
    });

    if (total > 1 && current < total)
      html += `<button id="next" class="page-links"><i class='bx bx-chevron-right'></i></button>`;
    else
      html += `<button disabled id="next" class="page-links disabled-page" ><i class='bx bx-chevron-right'></i></button>`;
    
      pagination.innerHTML = html;
    state.currentPage = current;
  }

  function attachPagination() {
    const prevbtn = document.querySelector(".container-pagination #prev");
    const nextbtn = document.querySelector(".container-pagination #next");

    if (prevbtn)
      prevbtn.addEventListener("click", () =>
        loadPost(state.sort, state.filter, state.currentPage-1)
      );
    if (nextbtn)
      nextbtn.addEventListener("click", () =>
        loadPost(state.sort, state.filter, state.currentPage+1)
      );

    const pageBtns = document.querySelectorAll(".container-pagination button[data-page]");
    pageBtns.forEach((btn) => {
        const page = btn.dataset.page;
        if (page) {
          btn.addEventListener("click", () => {
            loadPost(state.sort, state.filter, parseInt(page), );
          });
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
