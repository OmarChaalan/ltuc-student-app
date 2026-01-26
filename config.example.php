<?php
// Database configuration - TEMPLATE FILE
define('DB_HOST', 'your-rds-endpoint.region.rds.amazonaws.com');
define('DB_USER', 'admin');
define('DB_PASS', 'your-password-here');
define('DB_NAME', 'ltuc_students');

// Create connection
function getDBConnection() {
    $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    
    return $conn;
}

// Create students table if it doesn't exist
function initializeDatabase() {
    $conn = getDBConnection();
    
    $sql = "CREATE TABLE IF NOT EXISTS students (
        id INT AUTO_INCREMENT PRIMARY KEY,
        student_id VARCHAR(50) NOT NULL UNIQUE,
        full_name VARCHAR(100) NOT NULL,
        email VARCHAR(100) NOT NULL,
        phone VARCHAR(20) NOT NULL,
        major VARCHAR(100) NOT NULL,
        year VARCHAR(50) NOT NULL,
        gpa DECIMAL(3,2) NOT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )";
    
    if ($conn->query($sql) === TRUE) {
        $conn->close();
        return true;
    } else {
        $conn->close();
        return false;
    }
}
?>