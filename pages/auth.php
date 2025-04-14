<?php
require_once __DIR__ . "/../app/controllers/AuthController.php";

$controller = new AuthController();
$controller->auth_handle($page);

require_once __DIR__ . "/include/footer.php";
