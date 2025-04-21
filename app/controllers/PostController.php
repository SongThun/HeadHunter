<?php
require_once __DIR__ . "/../models/Post.php";
class PostController
{
    private $model;
    public function __construct()
    {
        $this->model = new Post();
    }
    public function jobpost_index()
    {
        $action = $_GET['action'];
        switch ($action) {
            case 'add':
                $this->add_form();
                break;
            case 'view':
                $this->view_form();
                break;
        }
    }
    private function add_form()
    {
        require_once __DIR__ . '/../views/post/AddJobPost.php';
    }
    private function view_form()
    {
        $id = $_SESSION['userid'] ?? null;
        $postname = explode('-', $_GET['id']);
        $postid = end($postname);
        // echo($postid);
        // var_dump($postname);
        $post = $this->model->getAPost($postid);
        require_once __DIR__ . '/../views/post/ViewJobPost.php';
    }
    public function get()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $data = json_decode(file_get_contents('php://input'), true);
            $sort = trim($data['sort']);
            $filter = $data['filter'];
            $page_num = $data['page_num'];
            $limit = 10;
            $offset = ($page_num - 1) * $limit;
            $jobs = $this->model->getPosts($sort, $filter, $limit, $offset);
            $total = $this->model->getCount($filter);
            header('ContentType: application/json');
            echo json_encode(['status' => 'success', 'data' => $jobs, 'total' => ceil($total / 10)]);
            exit();
        }
    }

    // public function MultiFilterGet() {
    //     if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    //         $data = json_decode(file_get_contents('php://input'), true);
    //         $sort = trim($data['sort']);
    //         $filter = $data['filter'];
    //         $page_num = $data['page_num'];
    //         $limit = 10;
    //         $offset = ($page_num - 1) * $limit;
    //         $jobs = $this->model->getPosts($sort, $filter, $limit, $offset);
    //         $total = $this->model->getCount($filter);
    //         header('ContentType: application/json');
    //         echo json_encode(['status' => 'success', 'data'=>$jobs, 'total'=>$total]);
    //         exit();
    //     }
    // }

    

    public function post_handle()
    {
        $method = $_SERVER['REQUEST_METHOD'];
        $id = $_GET['id'];
        switch ($method) {
            case 'DELETE':
                $res = $this->model->remove((string)$id);
                break;
            case 'POST':
                $data = $this->prepare_data();
                if ($_SERVER['HTTP_X_HTTP_METHOD_OVERRIDE'] == 'PUT') {
                    $res = $this->model->edit($id,  $data);
                } else {
                    $data['UserID'] = $_SESSION['userid'];
                    $res = $this->model->add($data);
                }
                break;
            default:
                $res = ["status" => "fail"];
        }
        header('ContentType: application/json');
        echo json_encode($res);
        exit();
    }
    private function prepare_data()
    {
        // $data = json_decode(file_get_contents('php://input'), true);
        $data = $_POST;
        $savePath = $_SESSION["userid"] . "_" . basename($_FILES["File_description"]["name"]);
        $data["File_description"] = $savePath;
        return $data;
    }
    
}
