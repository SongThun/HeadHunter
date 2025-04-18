<?php
// require_once __DIR__ . "/../models/Post.php";
// require_once __DIR__ . "/../models/User.php";
require_once dirname(__DIR__) . "/../app/models/Post.php";
require_once dirname(__DIR__) . "/../app/models/User.php";
class CompanyController
{
    private $post;
    private $user;
    public function __construct()
    {
        $this->post = new Post();
        $this->user = new User();
    }
    public function index()
    {
        $id = $_SESSION['userid'];
        $jobs = $this->post->getPosts("CreatedDate DESC", ["id" => $id], 10, 0);
        $page_num = 1;
        $total = $this->post->getCount(["id" => $id]);
        $total_pages = ceil($total / 10);
        $maxLength = 50;
        $notis = $this->user->getNoti($id);
        foreach (['approved', 'pending', 'disapproved'] as $status) {
            $counts[$status] = $this->post->getCount(["id" => $id, "status" => $status]);
        }
        $counts['all'] = $total;
        require_once __DIR__ . "/../views/company/CompanyDashboard.php";
    }
}
