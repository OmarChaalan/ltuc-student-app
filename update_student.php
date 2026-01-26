<?php
// Include database configuration
require_once 'config.php';

// Start session
session_start();

// Check if form was submitted via POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // Sanitize and retrieve form data
    $id = intval($_POST['id']);
    $studentId = htmlspecialchars($_POST['studentId']);
    $fullName = htmlspecialchars($_POST['fullName']);
    $email = htmlspecialchars($_POST['email']);
    $phone = htmlspecialchars($_POST['phone']);
    $major = htmlspecialchars($_POST['major']);
    $year = htmlspecialchars($_POST['year']);
    $gpa = htmlspecialchars($_POST['gpa']);
    
    // Server-side validation
    $errors = array();
    
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
                    <a href='edit_student.php?id=$id' class='back-btn'>Go Back</a>
                </div>
            </div>
        </body>
        </html>";
        exit;
    }
    
    // Connect to database
    $conn = getDBConnection();
    
    // Prepare and bind
    $stmt = $conn->prepare("UPDATE students SET full_name = ?, email = ?, phone = ?, major = ?, year = ?, gpa = ? WHERE id = ?");
    $stmt->bind_param("sssssdi", $fullName, $email, $phone, $major, $year, $gpa, $id);
    
    // Execute the statement
    if ($stmt->execute()) {
        $success = true;
        $message = "Student information updated successfully!";
    } else {
        $success = false;
        $message = "Error updating database: " . $stmt->error;
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
    // If accessed directly without POST, redirect
    header("Location: view_students.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Updated - LTUC</title>
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
                    <h3 style="color: #28a745;">✓ Update Successful</h3>
                    <p style="color: #28a745; margin-bottom: 20px;"><?php echo $message; ?></p>
                <?php else: ?>
                    <h3 style="color: #dc3545;">✗ Update Failed</h3>
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
                    <span class="info-label">Updated At:</span>
                    <span class="info-value"><?php echo $submissionTime; ?></span>
                </div>
            </div>
            
            <a href="view_students.php" class="back-btn" style="background: #28a745;">View All Students</a>
            <a href="index.html" class="back-btn" style="margin-left: 10px;">Add New Student</a>
        </div>

        <footer>
            <p>&copy; 2026 LTUC - All Rights Reserved</p>
        </footer>
    </div>
</body>
</html>