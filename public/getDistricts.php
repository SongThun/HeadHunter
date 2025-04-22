<?php
header('Content-Type: application/json');

// Get province code from request
$provinceCode = $_GET['province'] ?? '';

if (empty($provinceCode)) {
    echo json_encode([]);
    exit;
}

try {
    // Direct database connection
    $db = new mysqli('localhost', 'root', '', 'jobhunter');
    
    if ($db->connect_error) {
        throw new Exception("Database connection failed: " . $db->connect_error);
    }
    
    // Get districts for the province and sort alphabetically
    $sql = "SELECT code, name FROM districts WHERE province_code = ? ORDER BY name ASC";
    $stmt = $db->prepare($sql);
    $stmt->bind_param('s', $provinceCode);
    $stmt->execute();
    $result = $stmt->get_result();
    
    // Fetch districts
    $districts = [];
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $districts[] = $row;
        }
    }
    
    $stmt->close();
    $db->close();
    
    // Output districts as JSON
    echo json_encode($districts);
} catch (Exception $e) {
    error_log("Error fetching districts: " . $e->getMessage());
    echo json_encode([]);
}