<?php 
require_once __DIR__ . "/app/db.php";
$conn = Database::get_instance();

function getpw($pw)
{
    return password_hash($pw, PASSWORD_DEFAULT);
}

$users = [
    ['techrecruiter1', 'hashed_password_123', 'recruiter1@techco.com', 'TechCo Solutions', 'openai.png', 5, 28, 'user'],
    ['hrmanager_abc', 'secure_pass_456', 'hr@abccorp.com', 'ABC Corporation', 'openai.png', 4, 15, 'user'],
    ['talentscout', 'talent_pwd_789', 'scout@talentfinders.com', 'Talent Finders Inc.', 'facebook.jpg', 3, 12, 'user'],
    ['devhiring', 'dev_hire_101', 'hiring@devworks.com', 'DevWorks', 'facebook.jpg', 6, 32, 'user'],
    ['admin_sarah', 'admin_s_pwd', 'sarah@jobhunter.com', null, 'eastagile.png', 0, 0, 'admin'],
    ['admin_john', 'admin_j_pwd', 'john@jobhunter.com', null, 'openai.png', 0, 0, 'admin'],
    ['financerecruiter', 'finance_pwd', 'recruit@financeplus.com', 'Finance Plus', 'eastagile.png', 4, 18, 'user'],
    ['globalhires', 'global_pwd', 'hiring@globaltech.com', 'Global Technologies', 'facebook.jpg', 3, 9, 'user'],
    ['innovatestaff', 'inno_pwd_123', 'staff@innovatech.com', 'InnovaTech', 'openai.png', 2, 7, 'user'],
    ['cloudrecruit', 'cloud_pwd_456', 'jobs@cloudservices.net', 'Cloud Services Network', 'facebook.jpg', 3, 14, 'user'],
];

foreach ($users as $user) {
    $stmt = $conn->prepare("INSERT INTO User_ (Username, Password, Email, CompanyName, Avatar, NumPost, NumApplicant, Role) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->execute([
        $user[0],
        getpw($user[1]),
        $user[2],
        $user[3],
        $user[4],
        $user[5],
        $user[6],
        $user[7]
    ]);
}

echo "Success user add";
