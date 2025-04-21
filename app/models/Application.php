<?php
require_once __DIR__ . "/../db.php";
class Application
{
    private $db;
    public function __construct()
    {
        $this->db = Database::get_instance();
    }
    public function getApps($sort, $filter, $limit, $offset)
    {
        $sql = "SELECT * FROM Applicant WHERE 1=1";
        $type = "";
        $param = [];

        if (!empty($filter)) {
            if (isset($filter['postid']) && !empty($filter['postid'])) {
                $sql .= ' AND PostID = ?';
                $type .= 'i';
                $param[] = $filter['postid'];
            }
            if (isset($filter['status']) && !empty($filter['status'])) {
                $sql .= ' AND Status = ?';
                $type .= 's';
                $param[] = $filter['status'];
            }
            if (isset($filter['search']) && !empty($filter['search'])) {
                $sql .= ' AND Fullname LIKE ? OR Location LIKE ? OR Cover LIKE ?';
                $type .= 'sss';
                $regex = '%' . $filter['search'] . '%';
                $param = array_merge($param, [$regex, $regex, $regex]);
            }
        }
        if (!empty($sort)) {
            $sql .= " ORDER BY $sort";
        }
        $sql .= " LIMIT ? OFFSET ? ";
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
        $sql = "SELECT COUNT(*) as total FROM Applicant WHERE 1=1";
        $type = "";
        $param = [];

        if (!empty($filter)) {
            if (isset($filter['postid']) && !empty($filter['postid'])) {
                $sql .= ' AND PostID = ?';
                $type .= 'i';
                $param[] = $filter['postid'];
            }
            if (isset($filter['status']) && !empty($filter['status'])) {
                $sql .= ' AND Status = ?';
                $type .= 's';
                $param[] = $filter['status'];
            }
            if (isset($filter['search']) && !empty($filter['search'])) {
                $sql .= ' AND Fullname LIKE ? OR Location LIKE ? OR Cover LIKE ?';
                $type .= 'sss';
                $regex = '%' . $filter['search'] . '%';
                $param = array_merge($param, [$regex, $regex, $regex]);
            }
        }

        $stmt = $this->db->prepare($sql);
        $stmt->bind_param($type, ...$param);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc()['total'];
    }
    public function getOneApp($appid)
    {
        $stmt = $this->db->prepare("SELECT * FROM Applicant WHERE ID = ?");
        $stmt->bind_param("i", $appid);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }
    public function apply($id, $data)
{
    $this->db->begin_transaction(); // Start transaction

    try {
        // Step 1: Insert data with a placeholder filename
        $sql = "INSERT INTO Applicant (Fullname, Email, Phone, PostID, Location, Level, Cover, File_CV)
                VALUES (?, ?, ?, ?, ?, ?, ?, '')";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param(
            "sssisss",
            $data["Fullname"],
            $data["Email"],
            $data["Phone"],
            $id,
            $data["Location"],
            $data["Level"],
            $data["Cover"]
        );
        $stmt->execute();

        $appID = $this->db->insert_id;

        $uploadDir = realpath(dirname(__DIR__) . "/../public/upload/applications/") . "/$id/";
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0775, true);
        }

        $fileTmp = $_FILES["File_CV"]["tmp_name"];
        $fileExt = pathinfo($_FILES["File_CV"]["name"], PATHINFO_EXTENSION);
        $filename = $appID . "-" . $data['Fullname'] . "." . $fileExt;
        $newPath = $uploadDir . $filename;

        if (!move_uploaded_file($fileTmp, $newPath)) {
            $this->db->rollback();
            return ["status" => "failure", "error" => "Cannot upload file"];
        }

        $updateSQL = "UPDATE Applicant SET File_CV = ? WHERE ID = ?";
        $updateStmt = $this->db->prepare($updateSQL);
        $updateStmt->bind_param("si", $filename, $appID);
        $updateStmt->execute();

        $this->db->commit(); 
        return ["status" => "success"];
    } catch (Exception $e) {
        $this->db->rollback(); 
        return ["status" => "failure", "error" => $e->getMessage()];
    }
}

    public function approved($id, $data)
    {
        try {
            $sql = "UPDATE Applicant
            SET Status = ?,
                AdminID = ?,
                Reason = ?
                WHERE ID = ?";
            $stmt = $this->db->prepare($sql);
            $stmt->bind_param("sisi", $data["Status"], $data["AdminID"], $data["Reason"], $id);
            $stmt->execute();
            return ["status" => "success"];
        } catch (Exception $e) {
            echo $e->getMessage();
            return ["status" => "fail", "error" => $e->getMessage()];
        }
    }
    public function getRecentApps($limit)
    {
        $sql = "SELECT 
                    p.ID,
                    p.Postname,
                    p.Company,
                    p.Location,
                    p.Due,
                    MAX(a.AppliedDate) AS MostRecentApplication,
                    COUNT(CASE WHEN a.Status = 'pending' THEN 1 END) AS PendingApplications
                FROM 
                    Post p
                JOIN 
                    Applicant a ON p.ID = a.PostID
                GROUP BY 
                    p.ID
                ORDER BY 
                    MostRecentApplication DESC
                LIMIT ?;
                ";

        $stmt = $this->db->prepare($sql);
        $stmt->bind_param('i', $limit);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }
}
