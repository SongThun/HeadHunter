<?php
// CompanyDashboard.php
require_once __DIR__ . "/../app/controllers/CompanyController.php";
require_once __DIR__ . "/../app/controllers/PostController.php";

$page = isset($_GET['page']) ? $_GET['page'] : 'home';
$controller = new CompanyController();
$postController = new PostController();
?>

<?php include __DIR__ . '/include/companyHeader.php' ?>

<?php
$valid_pages = ['home', 'jobpost'];
if (in_array($page, $valid_pages)) {
  switch ($page) {
    case 'jobpost':
      $postController->jobpost_index();
      break;
    default:
      $controller->index();
      break;
  }
} else {
  echo "404 not found";
}
?>

<!-- Footer -->
<?php include __DIR__ . '/include/footer.php' ?>