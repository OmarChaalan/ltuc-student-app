<?php
// Include database configuration
require_once 'config.php';

// Initialize database
initializeDatabase();

// Connect to database
$conn = getDBConnection();

// Fetch all students
$sql = "SELECT * FROM students ORDER BY created_at DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>All Students - LTUC</title>
    <link rel="stylesheet" href="style.css">
    <style>
        .students-table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }
        
        .students-table th,
        .students-table td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        
        .students-table th {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            font-weight: 600;
        }
        
        .students-table tr:hover {
            background-color: #f5f5f5;
        }
        
        .no-records {
            text-align: center;
            padding: 40px;
            color: #666;
        }
        
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }
        
        .stat-card {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 20px;
            border-radius: 10px;
            text-align: center;
        }
        
        .stat-number {
            font-size: 2em;
            font-weight: bold;
        }
        
        .stat-label {
            font-size: 0.9em;
            opacity: 0.9;
        }
        
        .action-buttons {
            display: flex;
            gap: 5px;
        }
        
        .btn-edit, .btn-delete {
            padding: 6px 12px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 14px;
            text-decoration: none;
            display: inline-block;
        }
        
        .btn-edit {
            background: #28a745;
            color: white;
        }
        
        .btn-edit:hover {
            background: #218838;
        }
        
        .btn-delete {
            background: #dc3545;
            color: white;
        }
        
        .btn-delete:hover {
            background: #c82333;
        }
    </style>
</head>
<body>
    <div class="container">
        <header>
            <h1>Luminus Technical University College</h1>
            <p>Registered Students Database</p>
        </header>

        <div class="result-container">
            <?php
            $totalStudents = $result->num_rows;
            
            // Calculate average GPA
            $avgGPA = 0;
            if ($totalStudents > 0) {
                $gpaResult = $conn->query("SELECT AVG(gpa) as avg_gpa FROM students");
                $gpaRow = $gpaResult->fetch_assoc();
                $avgGPA = round($gpaRow['avg_gpa'], 2);
            }
            ?>
            
            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-number"><?php echo $totalStudents; ?></div>
                    <div class="stat-label">Total Students</div>
                </div>
                <div class="stat-card">
                    <div class="stat-number"><?php echo $avgGPA; ?></div>
                    <div class="stat-label">Average GPA</div>
                </div>
            </div>
            
            <h2 style="color: #1e3c72; margin-bottom: 20px;">All Registered Students</h2>
            
            <?php if ($totalStudents > 0): ?>
                <div style="overflow-x: auto;">
                    <table class="students-table">
                        <thead>
                            <tr>
                                <th>Student ID</th>
                                <th>Full Name</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Major</th>
                                <th>Year</th>
                                <th>GPA</th>
                                <th>Registered</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while($row = $result->fetch_assoc()): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($row['student_id']); ?></td>
                                    <td><?php echo htmlspecialchars($row['full_name']); ?></td>
                                    <td><?php echo htmlspecialchars($row['email']); ?></td>
                                    <td><?php echo htmlspecialchars($row['phone']); ?></td>
                                    <td><?php echo htmlspecialchars($row['major']); ?></td>
                                    <td><?php echo htmlspecialchars($row['year']); ?></td>
                                    <td><?php echo htmlspecialchars($row['gpa']); ?></td>
                                    <td><?php echo date('Y-m-d H:i', strtotime($row['created_at'])); ?></td>
                                    <td>
                                        <div class="action-buttons">
                                            <a href="edit_student.php?id=<?php echo $row['id']; ?>" class="btn-edit">Edit</a>
                                            <a href="delete_student.php?id=<?php echo $row['id']; ?>" class="btn-delete" onclick="return confirm('Are you sure you want to delete this student?')">Delete</a>
                                        </div>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
            <?php else: ?>
                <div class="no-records">
                    <p>No students registered yet.</p>
                </div>
            <?php endif; ?>
            
            <a href="index.html" class="back-btn">Add New Student</a>
        </div>

        <footer>
            <p>&copy; 2026 LTUC - All Rights Reserved</p>
        </footer>
    </div>
</body>
</html>

<?php
$conn->close();
?>