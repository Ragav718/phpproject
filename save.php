<?php
// Database connection details
$servername = "localhost"; // Change if using a remote database
$username = "root";        // Your MySQL username
$password = "UserRoot!";            // Your MySQL password
$database = "mydatabase";  // Your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get and validate form data
$name = trim($_POST['name']);
$phone = trim($_POST['phone']);

// Validate name (only letters and spaces allowed)
if (!preg_match("/^[a-zA-Z\s]+$/", $name)) {
    die("Invalid name. Only letters and spaces are allowed.");
}

// Validate phone (only numbers allowed)
if (!preg_match("/^[0-9]+$/", $phone)) {
    die("Invalid phone number. Only numbers are allowed.");
}

// Use prepared statement to prevent SQL injection
$stmt = $conn->prepare("INSERT INTO users (name, phone) VALUES (?, ?)");
$stmt->bind_param("ss", $name, $phone);

if ($stmt->execute()) {
    echo "Record added successfully!";
} else {
    echo "Error: " . $stmt->error;
}

// Close statement and connection
$stmt->close();
$conn->close();
?>
