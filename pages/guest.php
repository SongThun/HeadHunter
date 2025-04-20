<?php
require_once __DIR__ . "/../app/controllers/GuestController.php";
require_once __DIR__ . "/../app/controllers/PostController.php";

$page = isset($_GET['page']) ? $_GET['page'] : 'home';
$controller = new GuestController();
$postController = new PostController();

?>


<!-- <script>

document.addEventListener("DOMContentLoaded", function () {
const filterBtn = document.querySelector(".filter-box > button");
const filterBoxList = document.querySelector(".filter-box-list");
const filterValues = document.querySelectorAll(".filter-value");
const filterBox = document.querySelector(".filter-box");
// console.log(filterValues)

// filterBtn.addEventListener("click", (e) => {
//   console.log("hoho");
//   e.stopPropagation(); 
//   filterBoxList.style.display = 
//     filterBoxList.style.display === "block" ? "none" : "block";
// });

// document.addEventListener("click", function (e) {
//   if (!filterBox.contains(e.target)) {
//     filterBoxList.style.display = "none";
//   }
// });

if (filterBtn != null) {
  filterBtn.addEventListener("click", (e) => {
  e.stopPropagation();
  filterBoxList.classList.toggle("show");
});

document.addEventListener("click", function (e) {
  if (!filterBox.contains(e.target)) {
    filterBoxList.classList.remove("show");
  }
}); 

// filterValues.forEach(btn => {
//   btn.addEventListener("click", function () {
//     console.log("why");
//     this.classList.toggle("chosen");
//   });
// });
}


});

</script> -->

<!-- Header -->
<?php require __DIR__ . '/include/header.php' ?>

<!-- Main content -->
<?php
$valid_pages = ['home', 'jobposts', 'jobpost', 'contact', 'help'];
if (in_array($page, $valid_pages)) {
  switch ($page) {
    case 'jobposts':
      $controller->index('jobposts');
      break;
    case 'jobpost':
      $postController->jobpost_index();
      break;
    default:
      $controller->index("home");
      break;
  }
} else {
  echo "404 not found";
}
?>

<!-- Footer -->
<?php require __DIR__ . '/include/footer.php' ?>