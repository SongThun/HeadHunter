<?php
// require_once __DIR__ . "/../db.php";
require_once dirname(__DIR__) . "/../app/db.php";
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
        try {
            if (move_uploaded_file($_FILES["File_CV"]["tmp_name"], $data["File_CV"])) {
                // echo "upload success";
            } else {
                return ["status" => "failure", "error" => "Can not upload file"];
            }

            $sql = "INSERT INTO Applicant(Fullname, Email, Phone, PostID, Location, Level, Cover,File_CV) VALUES(
                                        ?, ? , ? , ? , ? , ? , ?, ?
            )";
            $stmt = $this->db->prepare($sql);
            $stmt->bind_param("sssissss", $data["Fullname"], $data["Email"], $data["Phone"], $id, $data["Location"], $data["Level"], $data["Cover"], $data['File_CV']);
            $stmt->execute();
            return ["status" => "success"];
        } catch (Exception $e) {
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
