<?php
// Include database configuration
require_once 'config.php';

// Initialize database
initializeDatabase();

// Start session
session_start();

// Check if form was submitted via POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // Sanitize and retrieve form data
    $studentId = htmlspecialchars($_POST['studentId']);
    $fullName = htmlspecialchars($_POST['fullName']);
    $email = htmlspecialchars($_POST['email']);
    $phone = htmlspecialchars($_POST['phone']);
    $major = htmlspecialchars($_POST['major']);
    $year = htmlspecialchars($_POST['year']);
    $gpa = htmlspecialchars($_POST['gpa']);
    
    // Server-side validation
    $errors = array();
    
    if (strlen($studentId) < 5) {
        $errors[] = "Student ID must be at least 5 characters";
    }
    
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Invalid email format";
    }
    
    if ($gpa < 0 || $gpa > 4) {
        $errors[] = "GPA must be between 0 and 4";
    }
    
    // If there are errors, show error page
    if (!empty($errors)) {
        echo "<!DOCTYPE html>
        <html lang='en'>
        <head>
            <meta charset='UTF-8'>
            <meta name='viewport' content='width=device-width, initial-scale=1.0'>
            <title>Error - LTUC</title>
            <link rel='stylesheet' href='style.css'>
        </head>
        <body>
            <div class='container'>
                <header>
                    <h1>Validation Error</h1>
                </header>
                <div class='result-container'>
                    <div class='result-card'>
                        <h3>Please correct the following errors:</h3>";
        
        foreach ($errors as $error) {
            echo "<p style='color: red; margin: 10px 0;'>• $error</p>";
        }
        
        echo "      </div>
                    <a href='index.html' class='back-btn'>Go Back</a>
                </div>
            </div>
        </body>
        </html>";
        exit;
    }
    
    // Connect to database
    $conn = getDBConnection();
    
    // Prepare and bind
    $stmt = $conn->prepare("INSERT INTO students (student_id, full_name, email, phone, major, year, gpa) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssssd", $studentId, $fullName, $email, $phone, $major, $year, $gpa);
    
    // Execute the statement
    if ($stmt->execute()) {
        $success = true;
        $message = "Student information saved successfully to database!";
    } else {
        $success = false;
        if ($stmt->errno == 1062) {
            $message = "Error: Student ID already exists in the database.";
        } else {
            $message = "Error saving to database: " . $stmt->error;
        }
    }
    
    $stmt->close();
    $conn->close();
    
    // Determine GPA status
    $gpaStatus = "";
    if ($gpa >= 3.5) {
        $gpaStatus = "Excellent";
    } elseif ($gpa >= 3.0) {
        $gpaStatus = "Very Good";
    } elseif ($gpa >= 2.5) {
        $gpaStatus = "Good";
    } elseif ($gpa >= 2.0) {
        $gpaStatus = "Pass";
    } else {
        $gpaStatus = "Needs Improvement";
    }
    
    // Generate submission timestamp
    $submissionTime = date('Y-m-d H:i:s');
    
} else {
    // If accessed directly without POST, redirect to form
    header("Location: index.html");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Information Submitted - LTUC</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <header>
            <h1>Luminus Technical University College</h1>
            <p>Student Information System</p>
        </header>

        <div class="result-container">
            <div class="result-card">
                <?php if ($success): ?>
                    <h3 style="color: #28a745;">✓ Registration Successful</h3>
                    <p style="color: #28a745; margin-bottom: 20px;"><?php echo $message; ?></p>
                <?php else: ?>
                    <h3 style="color: #dc3545;">✗ Registration Failed</h3>
                    <p style="color: #dc3545; margin-bottom: 20px;"><?php echo $message; ?></p>
                <?php endif; ?>
                
                <div class="info-row">
                    <span class="info-label">Student ID:</span>
                    <span class="info-value"><?php echo $studentId; ?></span>
                </div>
                
                <div class="info-row">
                    <span class="info-label">Full Name:</span>
                    <span class="info-value"><?php echo $fullName; ?></span>
                </div>
                
                <div class="info-row">
                    <span class="info-label">Email:</span>
                    <span class="info-value"><?php echo $email; ?></span>
                </div>
                
                <div class="info-row">
                    <span class="info-label">Phone:</span>
                    <span class="info-value"><?php echo $phone; ?></span>
                </div>
                
                <div class="info-row">
                    <span class="info-label">Major:</span>
                    <span class="info-value"><?php echo $major; ?></span>
                </div>
                
                <div class="info-row">
                    <span class="info-label">Academic Year:</span>
                    <span class="info-value"><?php echo $year; ?></span>
                </div>
                
                <div class="info-row">
                    <span class="info-label">GPA:</span>
                    <span class="info-value"><?php echo $gpa; ?> (<?php echo $gpaStatus; ?>)</span>
                </div>
                
                <div class="info-row">
                    <span class="info-label">Submission Time:</span>
                    <span class="info-value"><?php echo $submissionTime; ?></span>
                </div>
            </div>
            
            <a href="index.html" class="back-btn">Submit Another Student</a>
            <a href="view_students.php" class="back-btn" style="margin-left: 10px; background: #28a745;">View All Students</a>
        </div>

        <footer>
            <p>&copy; 2024 LTUC - All Rights Reserved</p>
        </footer>
    </div>
</body>
</html>