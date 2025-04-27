<?php
    require_once __DIR__ . "/config.php";
    require_once __DIR__ . "/app/controllers/AuthController.php";
    require_once __DIR__ . "/app/controllers/PostController.php";
    require_once __DIR__ . "/app/controllers/AdminController.php";
    require_once __DIR__ . "/app/controllers/GuestController.php";
    session_start();

    $page = isset($_GET['page']) ? $_GET['page'] : 'home';
    $role = isset($_SESSION['role']) ? $_SESSION['role'] : 'guest';

    // based on request determine the controller that handle the request
    switch ($page) {
        // func: user login, logout, register
        case 'auth':
            $controller = new AuthController();
            $action = $_GET['action'];
            switch ($action) {
                case 'validate':
                    $controller->validate();
                    break;
                case 'register':
                    $controller->register();
                    break;
                case 'logout':
                    $controller->logout();
                default:
                    break;
            }
            break;
        // func: get job listings 
        case 'jobposts':
            $controller = new PostController();
            $controller->get();
            break;
        // func: handle crud for specific job post
        case 'jobpost':
            $controller = new PostController();
            $controller->post_handle();
            break;
        // func: handle application submit
        case 'application':
            $controller = new AdminController();
            $controller->get_applications();
        case 'apply' :
            $controller = new GuestController();
            $controller->apply();
            break;
        // func: handle admin functionalities
        case 'approval':
            $controller = new AdminController();
            $controller->approve();
        default:
            break;
    }
?>