<?php
require_once __DIR__ . "/../db.php";
class User {
    private $db;
    public function __construct() {
        $this->db = Database::get_instance();
    }
    public function get_user($username) {
        $sql = "SELECT * FROM User_ WHERE Username = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();
        return $user;
    }
    public function getNoti($userid) {
        $stmt = $this->db->prepare("SELECT * FROM notification WHERE UserID = ? LIMIT 3");
        $stmt->bind_param("i",$userid);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function add_user($username, $password, $email, $company) {
        $passwordHash = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $this->db->prepare("INSERT INTO User_ (Username, Password, Email, CompanyName) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $username, $passwordHash, $email, $company);
        $stmt->execute();
        if ($stmt->affected_rows > 0) {
            return [
                "status" => "success",
                "msg" => "User registered successfully."
            ];
        } else {
            return [
                "status" => "fail",
                "msg" => "Failed to register user."
            ];
        }
    }
}
?>