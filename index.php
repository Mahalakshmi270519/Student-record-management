<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Student Record System</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            background-color: #f0f0f0;
            padding: 20px;
        }
        .container {
            max-width: 800px;
            background-color: #fff;
            padding: 20px;
            margin: 20px auto;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        table, th, td {
            border: 1px solid #ccc;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        .delete-btn {
            background-color: #dc3545;
            color: #fff;
            border: none;
            padding: 5px 10px;
            border-radius: 4px;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Student Record System</h2>
        
        <!-- Form to add a new student -->
        <h3>Add New Student</h3>
        <form action="index.php" method="post">
            <label for="name">Name:</label><br>
            <input type="text" id="name" name="name" required><br><br>
            <label for="email">Email:</label><br>
            <input type="email" id="email" name="email" required><br><br>
            <label for="phone">Phone:</label><br>
            <input type="text" id="phone" name="phone"><br><br>
            <label for="dob">Date of Birth:</label><br>
            <input type="date" id="dob" name="dob"><br><br>
            <input type="submit" value="Add Student">
        </form>

        <!-- Display existing students -->
        <h3>Existing Students</h3>
        <table>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Date of Birth</th>
                <th>Actions</th>
            </tr>
            <?php
            // Database connection
            $host = 'localhost';  // Database host
            $user = 'root';       // Database username
            $password = '';       // Database password
            $dbname = 'student_records'; // Database name

            $conn = new mysqli($host, $user, $password, $dbname);

            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            // Handle form submission
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                $name = $_POST['name'];
                $email = $_POST['email'];
                $phone = $_POST['phone'];
                $dob = $_POST['dob'];

                $sql = "INSERT INTO students (name, email, phone, dob) VALUES ('$name', '$email', '$phone', '$dob')";

                if ($conn->query($sql) === TRUE) {
                    echo "<p>Student added successfully!</p>";
                } else {
                    echo "Error: " . $sql . "<br>" . $conn->error;
                }
            }

            // Display existing students
            $sql = "SELECT * FROM students ORDER BY created_at DESC";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($row['name']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['email']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['phone']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['dob']) . "</td>";
                    echo '<td><form action="delete.php" method="post">
                              <input type="hidden" name="student_id" value="' . $row['id'] . '">
                              <button type="submit" class="delete-btn">Delete</button>
                          </form></td>';
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='5'>No students found</td></tr>";
            }

            $conn->close();
            ?>
        </table>
    </div>
</body>
</html>
