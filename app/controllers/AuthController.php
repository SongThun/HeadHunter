<?php
require_once __DIR__ . "/../models/User.php";

class AuthController {
    private $model;
    public function __construct() {
        $this->model = new User();
    }
    public function auth_handle($action): void {
        switch ($action) {
            case 'signin':
                $this->signin_form();
                break;
            case 'signup':
                $this->signup_form();
                break;
            default:
                break;
        }
    }
    private function signin_form() {
        require_once __DIR__ . "/../views/login.php";
    }
    private function signup_form() {
        require_once __DIR__ . "/../views/register.php";
    }
    public function logout() {
        setcookie('remember_me', session_id(), time() - 60 * 60, '/');
        session_reset();
        session_destroy();
        header("Location: " . BASE_URL);  
        exit();
    }
    public function validate() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $data = json_decode(file_get_contents('php://input'), true);

        $username = trim($data["username"]);
        $password = trim($data["password"]);
        $user = $this->model->get_user($username);
        $res = [];
        
        if ($user != null && password_verify($password,$user['Password'])) {
            $_SESSION['userid'] = $user["ID"];
            $_SESSION['username'] = $user["Username"];
            $_SESSION['displayName'] = !empty($user["CompanyName"]) ? $user['CompanyName'] : $user['Username'];
            $_SESSION['avatar'] = null; // $user['Avatar'];
            $_SESSION['role'] = $user["Role"];
            setcookie('remember_me', session_id(), time() + (24 * 60 * 60), '/');
            $res = [
                "status" => "success"
            ];
        } else {
            $res = [
                "status" => "fail",
                "msg" => "Incorrect username or password."
            ];
        }
        header("Content-Type: application/json");
        echo json_encode($res);
        exit();
        }
    }
    public function register() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $data = json_decode(file_get_contents('php://input'), true);
            $username = trim($data["username"]);
            $password = trim($data["password"]);
            $email = trim($data["email"]);
            $companyName = trim($data["company"]);
            $res = $this->model->add_user($username, $password, $email, $companyName);
            if ($res['status'] == 'success') {
                $_SESSION['userid'] = $this->model->get_user($username)["ID"];
                $_SESSION['username'] = $username;
                $_SESSION['displayName'] = $companyName;
                $_SESSION['avatar'] = null; // $user['Avatar'];
                $_SESSION['role'] = 'user';
                setcookie('remember_me', session_id(), time() + (24 * 60 * 60), '/');
            } else {
                $res = [
                    "status" => "fail",
                    "msg" => $res['msg']
                ];
            }
            header("Content-Type: application/json");
            echo json_encode($res);
            exit();
        } 
    }
}
?>