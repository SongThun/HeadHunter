<?php
// CompanyDashboard.php
require_once __DIR__ . "/../app/controllers/AdminController.php";
$page = isset($_GET['page']) ? $_GET['page'] : 'home';
$controller = new AdminController();
$postController = new PostController();
?>

<!--  Header -->
<?php include __DIR__ . '/include/adminHeader.php' ?>

<!-- Main content -->
<?php
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
?>

<!-- Footer -->
<?php include __DIR__ . '/include/footer.php' ?>