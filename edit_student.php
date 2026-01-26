<?php
// Include database configuration
require_once 'config.php';

// Initialize database
initializeDatabase();

// Get student ID from URL
$student_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Connect to database
$conn = getDBConnection();

// Fetch student data
$stmt = $conn->prepare("SELECT * FROM students WHERE id = ?");
$stmt->bind_param("i", $student_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 0) {
    header("Location: view_students.php");
    exit;
}

$student = $result->fetch_assoc();
$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Student - LTUC</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <header>
            <h1>Luminus Technical University College</h1>
            <p>Edit Student Information</p>
        </header>

        <main>
            <form id="studentForm" action="update_student.php" method="POST">
                <h2>Edit Student Registration</h2>
                
                <input type="hidden" name="id" value="<?php echo $student['id']; ?>">
                
                <div class="form-group">
                    <label for="studentId">Student ID:</label>
                    <input type="text" id="studentId" name="studentId" value="<?php echo htmlspecialchars($student['student_id']); ?>" required readonly style="background-color: #f0f0f0;">
                    <small style="color: #666;">Student ID cannot be changed</small>
                </div>

                <div class="form-group">
                    <label for="fullName">Full Name:</label>
                    <input type="text" id="fullName" name="fullName" value="<?php echo htmlspecialchars($student['full_name']); ?>" required>
                </div>

                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($student['email']); ?>" required>
                </div>

                <div class="form-group">
                    <label for="phone">Phone Number:</label>
                    <input type="tel" id="phone" name="phone" value="<?php echo htmlspecialchars($student['phone']); ?>" required>
                </div>

                <div class="form-group">
                    <label for="major">Major:</label>
                    <select id="major" name="major" required>
                        <option value="">Select Major</option>
                        <option value="Computer Science" <?php if($student['major'] == 'Computer Science') echo 'selected'; ?>>Computer Science</option>
                        <option value="Software Engineering" <?php if($student['major'] == 'Software Engineering') echo 'selected'; ?>>Software Engineering</option>
                        <option value="Cloud Computing" <?php if($student['major'] == 'Cloud Computing') echo 'selected'; ?>>Cloud Computing</option>
                        <option value="Cyber Security" <?php if($student['major'] == 'Cyber Security') echo 'selected'; ?>>Cyber Security</option>
                        <option value="Data Science" <?php if($student['major'] == 'Data Science') echo 'selected'; ?>>Data Science</option>
                        <option value="Network Engineering" <?php if($student['major'] == 'Network Engineering') echo 'selected'; ?>>Network Engineering</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="year">Academic Year:</label>
                    <select id="year" name="year" required>
                        <option value="">Select Year</option>
                        <option value="First Year" <?php if($student['year'] == 'First Year') echo 'selected'; ?>>First Year</option>
                        <option value="Second Year" <?php if($student['year'] == 'Second Year') echo 'selected'; ?>>Second Year</option>
                        <option value="Third Year" <?php if($student['year'] == 'Third Year') echo 'selected'; ?>>Third Year</option>
                        <option value="Fourth Year" <?php if($student['year'] == 'Fourth Year') echo 'selected'; ?>>Fourth Year</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="gpa">GPA:</label>
                    <input type="number" id="gpa" name="gpa" min="0" max="4" step="0.01" value="<?php echo htmlspecialchars($student['gpa']); ?>" required>
                </div>

                <button type="submit" class="submit-btn">Update Information</button>
                <a href="view_students.php" class="back-btn" style="display: inline-block; text-align: center; margin-top: 10px;">Cancel</a>
            </form>
        </main>

        <footer>
            <p>&copy; 2026 LTUC - All Rights Reserved</p>
        </footer>
    </div>

    <script src="script.js"></script>
</body>
</html>