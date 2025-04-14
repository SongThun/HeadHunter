const acceptbtn = document.querySelector("#accept-btn");
const rejectbtn = document.querySelector("#reject-btn");
const editbtn = document.querySelector("#edit-btn");
const approvalForm = document.querySelector("#admin-approval-form");
const status = approvalForm.dataset.value;
const statusResult = document.querySelector("#app-status");

function checkBtnDisplay(status) {
  if (status == "pending") {
    editbtn.style.display = "none";
    acceptbtn.style.display = "block";
    rejectbtn.style.display = "block";
    approvalForm.disabled = false;
    statusResult.style.display = "none";
  } else {
    editbtn.style.display = "block";
    acceptbtn.style.display = "none";
    rejectbtn.style.display = "none";
    approvalForm.disabled = true;
    statusResult.style.display = "block";
  }
}
checkBtnDisplay(status);
editbtn.addEventListener("click", () => {
  checkBtnDisplay("pending");
});
async function approvalFormSubmit(reason, status) {
  const url = `<?= API ?>approval?appid=<?= $app['ID'] ?>`;
  const response = await fetch(url, {
    method: "PUT",
    headers: {
      ContentType: "application/json",
    },
    body: JSON.stringify({
      Reason: reason,
      Status: status,
    }),
  });
  const res = await response.json();
  if (res.status == "success") {
    statusResult.innerText = status;
    checkBtnDisplay("done");
  }
}
rejectbtn.addEventListener("click", (e) => {
  e.preventDefault();
  console.log("reject");
  const reason = document.querySelector("#approval-reason").innerText;
  approvalFormSubmit(reason, "reject");
});
acceptbtn.addEventListener("click", (e) => {
  e.preventDefault();
  console.log("accept");
  const reason = document.querySelector("#approval-reason").innerText;
  approvalFormSubmit(reason, "accept");
});
