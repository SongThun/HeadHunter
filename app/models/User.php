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

        // Validate before register
        try {
            $sql = "SELECT Username, Email, CompanyName FROM User_ WHERE Username = ? OR Email = ? OR CompanyName = ?";
            $stmt_validate = $this->db->prepare($sql);
            $stmt_validate->bind_param("sss", $username, $email, $company);
            $stmt_validate->execute();
            $stmt_validate->store_result();
            $result = ['status' => 'duplicate'];
            if ($stmt_validate->num_rows > 0){
                $exist_username = "";
                $exist_email = "";
                $exist_company = "";
                $stmt_validate->bind_result($exist_username, $exist_email, $exist_company);
                while ($stmt_validate->fetch()) {
                    if ($exist_username === $username) {
                        $result['exist_username'] = 1;
                    }
                    if ($exist_email === $email) {
                        $result['exist_email'] = 1;
                    }
                    if ($exist_company === $company) {
                        $result['exist_company'] = 1;
                    }
                }
                return $result;
            }
        } catch (Exception $e){
            return ['status' => 'duplicate', 'error' => 'can not validate register', 'msg' => $e->getMessage()];
        }


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