<?php
// CompanyDashboard.php
require_once __DIR__ . "/../app/controllers/AdminController.php";
require_once __DIR__ . "/../app/controllers/PostController.php";

$page = isset($_GET['page']) ? $_GET['page'] : 'home';
$controller = new AdminController();
$postController = new PostController();
?>

<!--  Header -->
<?php include __DIR__ . '/include/adminHeader.php' ?>

<!-- Main content -->
<?php
$valid_pages = ['home', 'jobposts', 'jobpost', 'applications'];
if (in_array($page, $valid_pages)) {
  switch ($page) {
    case 'jobposts':
      $controller->index('jobposts');
      break;
    case 'applications':
      $controller->index('applications');
      break;
    case 'jobpost':
      $postController->jobpost_index();
      break;
    default:
      $controller->index('dashboard');
      break;
  }
} else {
  echo "404 not found";
}
?>

<!-- Footer -->
<?php include __DIR__ . '/include/footer.php' ?>