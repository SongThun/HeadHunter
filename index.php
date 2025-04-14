<?php
include __DIR__ . "/config.php";
require_once __DIR__ . "/app/controllers/AuthController.php";

session_start();

$role = isset($_SESSION['role']) ? $_SESSION['role'] : 'guest';
$page = isset($_GET['page']) ? $_GET['page'] : 'home';

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Bootstrap dependencies -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <!-- todo: cái j dài dẫy ... -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

    <!-- Font dependencies -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Carrois+Gothic&family=Neonderthaw&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet">
    <script src="https://kit.fontawesome.com/fdab99180b.js" crossorigin="anonymous"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

    <!-- CSS styling -->
        <link rel="stylesheet" href="<?= STYLE_PATH ?>/index.css">

    <?php if ($role == 'admin'): ?>
        <link rel="stylesheet" href="<?= STYLE_PATH ?>/admin.css">
    <?php elseif ($role == 'user'): ?>
        <link rel="stylesheet" href="<?= STYLE_PATH ?>/user.css">
    <?php else: ?>
        <link rel="stylesheet" href="<?= STYLE_PATH ?>/guest.css">
    <?php endif; ?>

    <script>
        window.BASE_URL = "<?= BASE_URL; ?>";
        window.API = "<?= API ?>";
    </script>
    <script src="<?= SCRIPT_PATH ?>/utils.js"></script>
    <title>Job Portal</title>

</head>

<body>
    <?php
    // All types of user use the same authentication pages
    if (in_array($page, ['signin', 'signup', 'logout'])) {
        require_once __DIR__ . "/pages/auth.php";
        exit();
    }

    // Page on user's role, determine the landing page
    switch ($role) {
        case 'admin':
            require __DIR__ . '/pages/admin.php';
            break;
        case 'user':
            require __DIR__ . '/pages/company.php';
            break;
        case 'guest':
            require __DIR__ . '/pages/guest.php';
            break;
    }
    ?>
</body>

</html>