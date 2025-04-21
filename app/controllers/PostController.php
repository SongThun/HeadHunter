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
                $data = $_POST; //$this->prepare_data();
                if ($_SERVER['HTTP_X_HTTP_METHOD_OVERRIDE'] == 'PUT') {
                    $res = $this->model->edit($id,  $data);
                    if ($res['status'] == 'success') {
                        $this->save_files($id);
                    }
                } else {
                    $data['UserID'] = $_SESSION['userid'];
                    $res = $this->model->add($data);
                    if ($res['status'] == 'success') {
                        $this->save_files($res['id']);
                    }
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

    // private function save_files($id)
    // {
    //     $numFile = count($_FILES['File_description']['name']);
    //     $folderPath = realpath(dirname(__DIR__) . "/../public/upload/descriptions");

    //     $folderPath .= "/$id/";

    //     if (!is_dir($folderPath)) {
    //         mkdir($folderPath, 0775, true);
    //     } else {
    //         $existingFiles = glob($folderPath . "*");
    //         foreach ($existingFiles as $file) {
    //             if (is_file($file)) {
    //                 unlink($file);
    //             }
    //         }
    //     }

    //     for ($i = 0; $i < $numFile; $i++) {
    //         $tmpName = $_FILES['File_description']['tmp_name'][$i];
    //         $originalName = basename($_FILES['File_description']['name'][$i]);
    //         $safeName = preg_replace('/[^a-zA-Z0-9_\.-]/', '_', $originalName);
    //         $destination = $folderPath . $safeName;
    //         if (!move_uploaded_file($tmpName, $destination)) {
    //             echo "error upload files";
    //         }
    //     }

    //     // Handle newly uploaded files
    //     if (!empty($_FILES['File_description'])) {
    //         foreach ($_FILES['File_description']['name'] as $i => $name) {
    //             $tmpName = $_FILES['File_description']['tmp_name'][$i];
    //             $originalName = basename($_FILES['File_description']['name'][$i]);
    //             $safeName = preg_replace('/[^a-zA-Z0-9_\.-]/', '_', $originalName);
    //             $destination = $folderPath . $safeName;
    //             if (!move_uploaded_file($tmpName, $destination)) {
    //                 echo "error upload files";
    //             }
    //         }
    //     }

    //     // Handle existing files
    //     $existingFiles = glob($folderPath . "*");
    //     foreach ($existingFiles as $file) {
    //         if (in_array($file, $_POST['ExistingFiles'])) {
    //             unlink($file);
    //         }
    //     }
    // }
    private function save_files($id)
{
    $folderPath = realpath(dirname(__DIR__) . "/../public/upload/descriptions") . "/$id/";

    if (!is_dir($folderPath)) {
        mkdir($folderPath, 0775, true);
    }

    // 1. Parse which existing files should be kept
    $keepFiles = isset($_POST['ExistingFiles']) ? $_POST['ExistingFiles'] : [];

    // 2. Delete files NOT in $_POST['ExistingFiles']
    $existingFiles = glob($folderPath . "*");
    foreach ($existingFiles as $filePath) {
        $fileName = basename($filePath);
        if (!in_array($fileName, $keepFiles)) {
            unlink($filePath); // delete if not referenced
        }
    }

    // 3. Save new uploaded files
    if (!empty($_FILES['File_description']) && is_array($_FILES['File_description']['name'])) {
        $fileCount = count($_FILES['File_description']['name']);


        for ($i = 0; $i < $fileCount; $i++) {
            if (!is_uploaded_file($_FILES['File_description']['tmp_name'][$i])) {
                continue; // Skip non-uploaded items
            }
        
            $tmpName = $_FILES['File_description']['tmp_name'][$i];
            $originalName = basename($_FILES['File_description']['name'][$i]);
            $safeName = preg_replace('/[^a-zA-Z0-9_\.-]/', '_', $originalName);
            $destination = $folderPath . $safeName;
        
            if (!move_uploaded_file($tmpName, $destination)) {
                echo "Failed to upload file: " . $originalName;
            }
        }
        
    }
}

}
