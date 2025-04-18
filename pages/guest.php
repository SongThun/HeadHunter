<?php
// echo dirname(__DIR__, 1) . '/app/controllers/GuestController.php';
// require_once "app/controllers/GuestController.php";

require_once dirname(__DIR__) . "/app/controllers/GuestController.php";
require_once dirname(__DIR__) . "/app/controllers/PostController.php";

$page = isset($_GET['page']) ? $_GET['page'] : 'home';
$controller = new GuestController();

$postController = new PostController();

?>

<!-- Header -->
<?php require dirname(__DIR__) . '/pages/include/header.php' ?>

<!-- Main content -->
<?php
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
?>

<!-- Footer -->
<?php require dirname(__DIR__) . '/pages/include/footer.php' ?>
