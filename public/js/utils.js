// UTILITIES FUNCTION
function slugify(str) {
  return str
    .toLowerCase()
    .trim()
    .replace(/[^a-z0-9\s-]/g, "")
    .replace(/[\s-]+/g, "-")
    .replace(/^-+|-+$/g, "");
}

function escapeHTML(str) {
  if (typeof str !== "string") return "";
  return str
    .replace(/&/g, "&amp;")
    .replace(/</g, "&lt;")
    .replace(/>/g, "&gt;")
    .replace(/"/g, "&quot;")
    .replace(/'/g, "&#039;");
}

function formatDate(dateString) {
  const date = new Date(dateString);
  const day = String(date.getDate()).padStart(2, '0');     // '01' to '31'
  const month = String(date.getMonth() + 1).padStart(2, '0'); // '01' to '12'
  const year = date.getFullYear();
  return `${day}/${month}/${year}`;
}

function form2json(element) {
  const formData = new FormData(element);
  const obj = {};
  const promises = [];

  formData.forEach((value, key) => {
    if (value instanceof File) {
      const promise = new Promise((resolve) => {
        const reader = new FileReader();
        reader.onloadend = function () {
          obj[key] = reader.result;
          resolve();
        };
        reader.readAsDataURL(value);
      });
      promises.push(promise);
    } else {
      obj[key] = value;
    }
  });

  return Promise.all(promises).then(() => obj);
}
