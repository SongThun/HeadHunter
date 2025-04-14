<?php
// CompanyDashboard.php
require_once "app/controllers/CompanyController.php";
$page = isset($_GET['page']) ? $_GET['page'] : 'home';
$controller = new CompanyController();
$postController = new PostController();
?>

<?php include __DIR__ . '/include/companyHeader.php' ?>

<?php
switch ($page) {
  case 'jobpost':
    $postController->jobpost_index();
    break;
  default:
    $controller->index();
    break;
}
?>

<!-- Footer -->
<?php include __DIR__ . '/include/footer.php' ?>