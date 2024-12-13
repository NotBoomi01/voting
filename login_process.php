<?php
session_start();

$username = $_POST['username'];
$password = $_POST['password'];

// Database connection (replace with your actual connection details)
$conn = new mysqli('localhost', 'root', '', 'online_voting');

// Query to retrieve user information
$sql = "SELECT id FROM voters WHERE username = ? AND password = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", $username, $password);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $_SESSION['user_id'] = $row['id'];
    header("Location: voting1.php"); // Redirect to success page
    exit();
} else {
    echo "Access denied. Invalid username or password.";
}

$stmt->close();
$conn->close();
?>