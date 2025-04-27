<?php
require_once __DIR__ . "/../db.php";

class Post
{
    private $db;
    public function __construct()
    {
        $this->db = Database::get_instance();
    }
    public function getPosts($sort, $filter, $limit, $offset)
    {
        $sql = "SELECT * FROM Post WHERE 1=1";
        $type = "";
        $param = []; 
        // var_dump($filter);
        if (!empty($filter)) {
            if (isset($filter['id'])) {
                $sql .= ' AND UserID = ?';
                $type .= 'i';
                $param[] = $filter['id'];
            }
            if (isset($filter['status']) && !empty($filter['status'])) {
                $sql .= ' AND Status = ?';
                $type .= 's';
                $param[] = $filter['status'];
            }
            if (isset($filter['search']) && !empty($filter['search'])) {
                $sql .= ' AND Postname LIKE ? OR Location LIKE ? OR Description LIKE ?';
                $type .= 'sss';
                $regex = "%" . $filter['search']. "%";
                $param = array_merge($param, [$regex,$regex,$regex]);
            }
            if (isset($filter['salary']) && !empty($filter['salary'])) {
                $salaryQueries = implode(' OR Salary ', $filter['salary']);
                $sql .= ' AND Salary ' . $salaryQueries;
            }
            if (isset($filter['location']) && !empty($filter['location'])) {
                $placeholders = implode(',', array_fill(0, count($filter['location']), '?'));
                $sql .= " AND Location IN ($placeholders)";
                $param = array_merge($param, $filter['location']);
                $type .= str_repeat("s", count($filter['location']));
            }
            if (isset($filter['level']) && !empty($filter['level'])) {
                $placeholders = implode(',', array_fill(0,count($filter['level']),'?'));
                $sql .= " AND Level IN ($placeholders)";
                $param = array_merge($param, $filter['level']);
                $type .= str_repeat('s', count($filter['level']));
            }
        }
        if (!empty($sort)) {
            $sql .= " ORDER BY $sort";
        }
        $sql .= ' LIMIT ? OFFSET ?';
        $type .= 'ii';
        $param = array_merge($param, [$limit, $offset]);
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param($type, ...$param);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }
    public function getCount($filter)
    {
        $sql = "SELECT COUNT(*) AS total FROM Post WHERE 1=1";
        $type = "";
        $param = [];

        if (!empty($filter)) {
            if (isset($filter['id'])) {
                $sql .= ' AND UserID = ?';
                $type .= 'i';
                $param[] = $filter['id'];
            }
            if (isset($filter['status']) && !empty($filter['status'])) {
                $sql .= ' AND Status = ?';
                $type .= 's';
                $param[] = $filter['status'];
            }
            if (isset($filter['search']) && !empty($filter['search'])) {
                $sql .= ' AND Postname LIKE ? OR Location LIKE ? OR Description LIKE ?';
                $type .= 'sss';
                $regex = "%" . $filter['search']. "%";
                $param = array_merge($param, [$regex,$regex,$regex]);
            }
            if (isset($filter['salary']) && !empty($filter['salary'])) {
                $salaryQueries = implode(' OR Salary ', $filter['salary']);
                $sql .= ' AND Salary ' . $salaryQueries;
            }
            if (isset($filter['location']) && !empty($filter['location'])) {
                $placeholders = implode(',', array_fill(0, count($filter['location']), '?'));
                $sql .= " AND Location IN ($placeholders)";
                $param = array_merge($param, $filter['location']);
                $type .= str_repeat("s", count($filter['location']));
            }
            if (isset($filter['level']) && !empty($filter['level'])) {
                $placeholders = implode(',', array_fill(0,count($filter['level']),'?'));
                $sql .= " AND Level IN ($placeholders)";
                $param = array_merge($param, $filter['level']);
                $type .= str_repeat('s', count($filter['level']));
            }
        }
        $stmt = $this->db->prepare($sql);
        if (!empty($param)) {
            $stmt->bind_param($type, ...$param);
        }
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc()['total'];
    }
    public function getAPost($postId) {
        $stmt = $this->db->prepare('SELECT p.*, u.Avatar FROM Post p JOIN User_ u ON p.UserID = u.ID WHERE p.ID=?');
        $stmt->bind_param('i',$postId);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }
    public function remove($id) {
        try {
            $stmt = $this->db->prepare('DELETE FROM post WHERE ID = ?');
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $result = $stmt->get_result();
            return ['status'=>'success'];
        } catch (Exception $e) {
            return ['status'=>"fail", "msg"=>$e->getMessage()];
        }
    }
    public function edit($id, $data) {
        // $sql = "UPDATE post SET Postname=?, Applicants_max=?, Location=?, Salary=?, Due=?, Level=?, Description=?, File_description=? WHERE ID=?";
        // $stmt = $this->db->prepare($sql);
        // $stmt->bind_param("sisdssssi", ...$data);
        // $stmt->execute();
        // $result = $stmt->get_result();
        // return $result;
        try {
            $sql = "UPDATE Post
            SET Postname = ?,
                Applicants_max = ?,
                Location = ?,
                Salary = ?,
                Due = ?,
                Level = ?,
                Description = ?,
                File_description = ?
                WHERE ID = ?";
            $stmt = $this->db->prepare($sql);
            $stmt->bind_param("sisdssssi", $data["Postname"], 
                                            $data["Applicants_max"], 
                                            $data["Location"], 
                                            $data["Due"], 
                                            $data["Due"], 
                                            $data["Level"], 
                                            $data["Description"], 
                                            $data["File_description"], $id);
            $stmt->execute();
            return ["status" => "success"];
        } catch (Exception $e){
            echo $e->getMessage();
            return ["status" => "failure" , "error" => $e->getMessage()];
        }
        
    }
    public function add($data) {
        try {
            $sql = "INSERT INTO Post (
                AdminID, 
                UserID, 
                Postname, 
                Company, 
                Applicants_max, 
                Location, 
                Salary, 
                Due, 
                Level, 
                Description, 
                File_description
            ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, '')";
            
            $stmt = $this->db->prepare($sql);
            $stmt->bind_param(
                "iissisdsss", 
                $data["AdminID"], 
                $data["UserID"], 
                $data["Postname"], 
                $data["Company"], 
                $data["Applicants_max"], 
                $data["Location"], 
                $data["Salary"], 
                $data["Due"], 
                $data["Level"], 
                $data["Description"]
            );
            
            $stmt->execute();
            $newId = $stmt->insert_id;
    
            return ["status" => "success", "id" => $newId];
        } catch (Exception $e) {
            echo $e->getMessage();
            return ["status" => "failure", "error" => $e->getMessage()];
        }
    }
    
    public function approved($id, $data) {
        try {
            $sql = "UPDATE Post
            SET Status = ?,
                AdminID = ?,
                Reason = ?
                WHERE ID = ?";
            $stmt = $this->db->prepare($sql);
            $stmt->bind_param("sisi", $data["Status"], $data["AdminID"], $data["Reason"], $id);
            $stmt->execute();
            return ["status" => "success"];
        } catch (Exception $e){
            echo $e->getMessage();
            return ["status" => "failure", "error" => $e->getMessage()];
        }
    }
}
