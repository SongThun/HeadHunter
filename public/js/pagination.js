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

let sort = "";
let filter = {};
let currentPage = 1;

function getLoader(LoadContentSuccess, LoadContentFail, DestGenerate) {
  attachCardView(DestGenerate);
  attachPagination();

  const sortSelect = document.querySelector(".sort-choices");
  const searchBar = document.querySelector(".search-box input");

  if (sortSelect) {
    sort = sortSelect.value;
    sortSelect.addEventListener("input", () => {
      sort = sortSelect.value;
      loadPost(sort, filter, 1);
    });
  }

  if (searchBar) {
    searchBar.addEventListener(
      "input",
      debounce(() => {
        filter.search = searchBar.value;
        loadPost(sort, filter, 1);
      }, 500)
    );
  }

  function updatePagination(current, total) {
    let html = "";
    if (total > 0) {
      html = `<li class="page-item ${current == 1 ? "disabled" : ""}">
            <button id="prev" class="page-link" tabindex="-1" aria-disabled="true">
              <i class="bi bi-arrow-left"></i> Previous
            </button>
          </li>
          <li> ${current} / ${total} </li>
          <li class="page-item ${current == total ? "disabled" : ""}">
            <button id="next" class="page-link">
              Next <i class="bi bi-arrow-right"></i>
            </button>
          </li>`;
    }
    currentPage = current;
    console.log(document.querySelector(".pagination"));
    document.querySelector(".pagination").innerHTML = html;
  }

  function attachPagination() {
    document.querySelector("#prev").addEventListener("click", () => {
      loadPost(sort, filter, current - 1);
    });
    document.querySelector("#next").addEventListener("click", () => {
      loadPost(sort, filter, current + 1);
    });
  }

  function attachCardView(DestGenerate) {
    const jobcards = document.querySelectorAll(".job-card");
    jobcards.forEach((card) => {
      const id = card.dataset.id;
      const name = card.dataset.name;
      card.addEventListener("click", () => {
        window.location.href = DestGenerate(id, name);
      });
    });
  }

  async function loadPost(sort, filter, page_num) {
    const response = await fetch(`${window.API}/jobposts`, {
      method: "POST",
      headers: {
        ContentType: "application/json",
      },
      body: JSON.stringify({
        sort,
        filter,
        page_num,
      }),
    });
    const res = await response.json();
    console.log(res);
    let html = "";
    if (res.data.length > 0) {
      html = res.data.reduce((acc, ele) => acc + LoadContentSuccess(ele), "");
    } else {
      html = LoadContentFail();
    }
    document.querySelector(".card-display").innerHTML = html;
    updatePagination(page_num, res.total);
    attachPagination();
    attachCardView(DestGenerate);
  }
  return loadPost();
}
