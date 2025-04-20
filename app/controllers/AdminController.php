<?php
require_once __DIR__ . "/../models/Post.php";
require_once __DIR__ . "/../models/Application.php";
class AdminController
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
                $this->jobpostpage();
                // require_once __DIR__ . "/../views/admin/AdminJobPost.php";
                break;
            case 'applications':
                $this->application_index();
                break;
            default:
                $this->dashboard();
                break;
        }
    }
    // VIEW HANDLER: Display view of Admin Dashboard
    private function dashboard() {
        // Get latest job posts instead of pending
        $latestPosts = $this->post->getPosts('CreatedDate DESC', [], 5, 0);
        
        // Get recent applications
        $recentApplications = $this->app->getApps('AppliedDate DESC', [], 5, 0);
        
        // Pass data to view
        $data = [
            'latestPosts' => $latestPosts,
            'recentApp' => $recentApplications
        ];
        
        // Render the dashboard view with data
        require_once __DIR__ . "/../views/admin/AdminDashboard.php";
    }

    // VIEW HANDLER: Display landing view for applications
    private function application_index() {
        // if query contains post ID and application ID -> display application 
        if (isset($_GET['post']) && isset($_GET['app'])) {
            // retrieve post detail
            $postname = explode('-', $_GET['post']);
            $postid = end($postname);
            $job = $this->post->getAPost($postid);
            
            // retrieve application detail
            $appname = explode('-', $_GET['app']);
            $appid = end($appname);
            $app = $this->app->getOneApp($appid);
            require_once __DIR__ . "/../views/admin/DescApplication.php";
        }
        // if query contains only post ID -> display list of applications
        else if (isset($_GET['post'])) {
            $postname = explode('-', $_GET['post']);
            $postid = end($postname);
            $filter = ['postid'=>$postid, 'status'=>'pending'];
            $apps = $this->app->getApps("AppliedDate DESC", $filter, 10, 0);
            $total = $this->app->getCount($filter);
            $page_num=1;
            $total_pages = ceil($total / 10);
            $counts = [];
            foreach (['accept', 'pending', 'reject'] as $status) {
                $counts[$status] = $this->app->getCount(["postid"=>$postid, "status"=>$status]);
            }
            $counts['all'] = $total;
            require_once __DIR__ . '/../views/admin/PostApplication.php';
        } 
        // default -> display approved job post
        else {
            $jobs = $this->post->getPosts("CreatedDate ASC",['status'=>'approved'],10,0);
            $page_num = 1;
            $total = $this->post->getCount(['status' => 'approved']);
            $total_pages = ceil($total / 10);
            require_once __DIR__ . "/../views/admin/AdminApplicationView.php";
        }
       
    }

    // VIEW HANDLER: Display landing view for job listings
    private function jobpostpage() {
        $record_per_page = 10;
        $search = isset($_GET['search']) ? $_GET['search'] : '';
        $page_num = 1;
        $sort_order = 'CreatedDate DESC';
        
        // Set default status to pending if none specified
        $status = $_GET['status'] ?? 'pending';
        $filter = [];
        
        if ($status !== 'all') {
            $filter['status'] = $status;
        }
        
        $total_records = $this->post->getCount(['status' => 'pending']);
        $total_pages = ceil($total_records / $record_per_page);
        $jobs = $this->post->getPosts($sort_order, $filter, $record_per_page, 0);
        // Initialize counts
        $statusCounts = [
            'all' => $this->post->getCount(['status' => '']),
            'approved' => $this->post->getCount(['status' => 'approved']),
            'pending' => $this->post->getCount(['status' => 'pending']),
            'disapproved' => $this->post->getCount(['status' => 'disapproved'])
        ];
        require_once __DIR__ . "/../views/admin/AdminJobPost.php";
    }

    // API HANDLER: handle admin post/application approval
    public function approve() {
        $adminid = $_SESSION['userid'];
        $data = json_decode(file_get_contents('php://input'), true);
        $data["AdminID"] = $adminid;
        
        $res = ['status'=> 'fail'];
        if (isset($_GET['appid'])) {
            $res = $this->app->approved($_GET['appid'], $data);
        }
        else if (isset($_GET['postid'])) { 
            $res = $this->post->approved($_GET['postid'], $data);
        }
        header("ContentType: application/json");
        echo json_encode($res);
        exit();
    }
    public function get_applications() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $data = json_decode(file_get_contents('php://input'), true);
            $sort = trim($data['sort']);
            $filter = $data['filter'];
            $page_num = $data['page_num'];
            $limit = 10;
            $offset = ($page_num - 1) * $limit;
            $jobs = $this->app->getApps($sort, $filter, $limit, $offset);
            $total = $this->app->getCount($filter);
            header('ContentType: application/json');
            echo json_encode(['status' => 'success', 'data' => $jobs, 'total' => ceil($total / 10)]);
            exit();
        }
    }
}
