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
        $name = explode('-', $_GET['id']);
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
        // $postname = isset($_GET['postid']) ? $_GET['postid'] : "";
        $id = $_GET['postid'];
        switch ($method) {
            case 'POST':
                // Format location data
                if (!empty($_POST['ProvinceCode']) && !empty($_POST['DistrictCode'])) {
                    // Connect to database
                    $db = new mysqli('localhost', 'root', '', 'jobhunter');
                    
                    if (!$db->connect_error) {
                        // Get district name
                        $sql = "SELECT name FROM districts WHERE code = ?";
                        $stmt = $db->prepare($sql);
                        $stmt->bind_param('s', $_POST['DistrictCode']);
                        $stmt->execute();
                        $result = $stmt->get_result();
                        $districtName = ($result->num_rows > 0) ? $result->fetch_assoc()['name'] : '';
                        
                        // Get province name
                        $sql = "SELECT name FROM provinces WHERE code = ?";
                        $stmt = $db->prepare($sql);
                        $stmt->bind_param('s', $_POST['ProvinceCode']);
                        $stmt->execute();
                        $result = $stmt->get_result();
                        $provinceName = ($result->num_rows > 0) ? $result->fetch_assoc()['name'] : '';
                        
                        if ($districtName && $provinceName) {
                            $_POST['Location'] = "$districtName, $provinceName";
                        }
                        
                        $db->close();
                    }
                }
                // $id = end($postname);
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
        
        // Check if we already have a formatted Location from the province/district dropdowns
        if (!isset($data['Location']) || empty($data['Location'])) {
            // For backward compatibility - if using old code that still submits District and City
            if (isset($data['District']) && isset($data['City'])) {
                $data["Location"] = $data["Address"] . ", " . $data["District"] . ", " . $data["City"];
            } else {
                // Default to just the address if no location components are present
                $data["Location"] = $data["Address"];
            }
        }
        
        // Handle file upload
        if (isset($_FILES["File_CV"]) && $_FILES["File_CV"]["error"] == 0) {
            $savePath = $id . "_" . basename($_FILES["File_CV"]["name"]);
            $data["File_CV"] = $savePath;
        }
        
        return $data;
    }
}
