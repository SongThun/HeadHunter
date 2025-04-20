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

function getLoader(LoadContentSuccess, LoadContentFail, DestGenerate) {
  const state = {
    sort: "",
    filter: {},
    currentPage: 1,
  };

  const $pagination = document.querySelector(".pagination");
  const $searchBar = document.querySelector(".search-box input");
  const $sortSelect = document.querySelector(".sort-choices");

  attachEvents();

  async function loadPost(sort, filter, page_num) {
    try {
      const response = await fetch(`${window.API}/jobposts`, {
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
    } catch (error) {
      console.error("Error loading job posts:", error);
    }
  }

  function attachEvents() {
    if ($sortSelect) {
      state.sort = $sortSelect.value;
      $sortSelect.addEventListener("input", () => {
        state.sort = $sortSelect.value;
        loadPost(state.sort, state.filter, 1);
      });
    }

    if ($searchBar) {
      $searchBar.addEventListener(
        "input",
        debounce(() => {
          state.filter.search = $searchBar.value;
          loadPost(state.sort, state.filter, 1);
        }, 500)
      );
    }

    attachPaginationOnce();
  }

  function updatePagination(current, total) {
    let html = "";
    if (total > 0) {
      html = `<li class="page-item ${current === 1 ? "disabled" : ""}">
                <button id="prev" class="page-link">
                  <i class="bi bi-arrow-left"></i> Previous
                </button>
              </li>
              <li> ${current} / ${total} </li>
              <li class="page-item ${current === total ? "disabled" : ""}">
                <button id="next" class="page-link">
                  Next <i class="bi bi-arrow-right"></i>
                </button>
              </li>`;
    }
    state.currentPage = current;
    $pagination.innerHTML = html;
  }

  function attachPaginationOnce() {
    $pagination.addEventListener("click", (e) => {
      if (e.target.closest("#prev")) {
        loadPost(state.sort, state.filter, state.currentPage - 1);
      }
      if (e.target.closest("#next")) {
        loadPost(state.sort, state.filter, state.currentPage + 1);
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
