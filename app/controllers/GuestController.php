<?php
require_once __DIR__ . "/../models/Post.php";
require_once __DIR__ . "/../models/Application.php";
class GuestController
{
    private $post;
    private $app;
    public function __construct()
    {
        $this->post = new Post();
        $this->app = new Application();
    }
    public function index($page)
    {
        switch ($page) {
            case 'jobposts':
                $this->jobposts_init();
                break;
            case 'jobpost':
                $this->job_view();
                break;
            default:
                $this->home_init();
                break;
        }
    }
    private function job_view()
    {
<<<<<<< Updated upstream
        $name = explode('-', $_GET["id"]);
=======
        $name = explode('-', $_GET['id']);
>>>>>>> Stashed changes
        $id = end($name);
        $job = $this->post->getAPost($id);
        require_once __DIR__ . '/../views/guest/JobDescription.php';
    }
    private function home_init()
    {
        require_once __DIR__ . '/../views/guest/Home.php';
    }
    private function jobposts_init()
    {
        $page_num = 1;
        $record_per_page = 10;
        $sort = "CreatedDate DESC";
        $filter = [];
        $limit = 10;
        $offset = 0;
        $jobs = $this->post->getPostS($sort, $filter, $limit, $offset);
        $total_records = $this->post->getCount($filter);
        $total_pages = ceil($total_records / $record_per_page);
        require_once __DIR__ . "/../views/guest/JobPosts.php";
    }
    public function apply()
    {
        $method = $_SERVER['REQUEST_METHOD'];
        $id = $_GET['postid'];
        switch ($method) {
            case 'POST':
                $data = $this->prepare_data_applicant($id);
                $res = $this->app->apply($id, $data);
                break;
            default:
                $res = ["status" => "failure"];
        }
        header('ContentType: application/json');
        echo json_encode($res);
        exit();
    }
    private function prepare_data_applicant($id)
    {

        $data = $_POST;
        $data["Location"] = $_POST["Address"] . ", " . $_POST["District"] . ", " . $_POST["City"];
        $savePath = $id . "_" . basename($_FILES["File_CV"]["name"]);
        $data["File_CV"] = $savePath;
        return $data;
    }
}
