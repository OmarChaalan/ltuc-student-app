<?php
// Include database configuration
require_once 'config.php';

// Get student ID from URL
$student_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($student_id == 0) {
    header("Location: view_students.php");
    exit;
}

// Connect to database
$conn = getDBConnection();

// First, get student info for display
$stmt = $conn->prepare("SELECT * FROM students WHERE id = ?");
$stmt->bind_param("i", $student_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 0) {
    $stmt->close();
    $conn->close();
    header("Location: view_students.php");
    exit;
}

$student = $result->fetch_assoc();
$stmt->close();

// Delete the student
$stmt = $conn->prepare("DELETE FROM students WHERE id = ?");
$stmt->bind_param("i", $student_id);

if ($stmt->execute()) {
    $success = true;
    $message = "Student record deleted successfully!";
} else {
    $success = false;
    $message = "Error deleting record: " . $stmt->error;
}

$stmt->close();
$conn->close();

$submissionTime = date('Y-m-d H:i:s');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Deleted - LTUC</title>
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
                    <h3 style="color: #dc3545;">✓ Student Deleted</h3>
                    <p style="color: #dc3545; margin-bottom: 20px;"><?php echo $message; ?></p>
                <?php else: ?>
                    <h3 style="color: #dc3545;">✗ Deletion Failed</h3>
                    <p style="color: #dc3545; margin-bottom: 20px;"><?php echo $message; ?></p>
                <?php endif; ?>
                
                <h4 style="color: #666; margin-top: 20px;">Deleted Student Information:</h4>
                
                <div class="info-row">
                    <span class="info-label">Student ID:</span>
                    <span class="info-value"><?php echo htmlspecialchars($student['student_id']); ?></span>
                </div>
                
                <div class="info-row">
                    <span class="info-label">Full Name:</span>
                    <span class="info-value"><?php echo htmlspecialchars($student['full_name']); ?></span>
                </div>
                
                <div class="info-row">
                    <span class="info-label">Email:</span>
                    <span class="info-value"><?php echo htmlspecialchars($student['email']); ?></span>
                </div>
                
                <div class="info-row">
                    <span class="info-label">Major:</span>
                    <span class="info-value"><?php echo htmlspecialchars($student['major']); ?></span>
                </div>
                
                <div class="info-row">
                    <span class="info-label">Deleted At:</span>
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