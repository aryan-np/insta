<?php
// Database configuration
$servername = "localhost";  // Replace with your database server
$username = "root";         // Replace with your database username
$password = "";             // Replace with your database password
$dbname = "your_database";  // Replace with your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Create the 'insta' table if it does not exist
$table_create_sql = "CREATE TABLE IF NOT EXISTS insta (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(255) NOT NULL,
    password VARCHAR(255) NOT NULL
)";

if ($conn->query($table_create_sql) === FALSE) {
    die("Error creating table: " . $conn->error);
}

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user = $_POST['username'];
    $pass = $_POST['password'];

    // Check if the user already exists
    $check_user_sql = "SELECT * FROM insta WHERE username = '$user'";

    $result = $conn->query($check_user_sql);

    if ($result->num_rows > 0) {
        // User exists, login them in
        $row = $result->fetch_assoc();
        if ($row['password'] == $pass) {
            echo "Login successful. Welcome, $user! <a href='dashboard.html'>Go to Dashboard</a>";
        } else {
            echo "Incorrect password. <a href='login.html'>Try again</a>";
        }
    } else {
        // User does not exist, insert the new user into the database
        $insert_user_sql = "INSERT INTO insta (username, password) VALUES ('$user', '$pass')";

        if ($conn->query($insert_user_sql) === TRUE) {
            echo "User created successfully. You can now <a href='login.html'>log in</a>";
        } else {
            echo "Error: " . $insert_user_sql . "<br>" . $conn->error;
        }
    }
}

// Close the connection
$conn->close();
?>
