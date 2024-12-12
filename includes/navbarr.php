<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

$host = "localhost"; // Usually 'localhost'
$dbusername = "root"; // Your MySQL username (default is 'root')
$dbpassword = ""; // Your MySQL password (default is empty for 'root' in local setups)
$dbname = "online_voting"; // Your database name, e.g. 'voting_system'

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $dbusername, $dbpassword);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Default display username as 'Guest'
    $displayUsername = 'Guest';

    // Check if user is logged in
    if (isset($_SESSION['user_id'])) {
        $stmt = $pdo->prepare("SELECT Username FROM voters WHERE id = :id");
        $stmt->bindParam(':id', $_SESSION['user_id'], PDO::PARAM_INT);
        $stmt->execute();

        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        // Update display username if user is found
        if ($user && isset($user['Username'])) {
            $displayUsername = htmlspecialchars($user['Username']); // Ensure the case matches your database schema
        }
    }
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Navbar</title>
    <style>
        .navbar a {
            color: white;
            text-decoration: none;
            margin: 0 10px;
            font-size: 16px;
        }
        .navbar a:hover {
            text-decoration: underline;
        }
        .navbar-text {
            color: white;
            font-size: 16px;
        }
    </style>
</head>
<body>
    <!-- Navbar section -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <span class="navbar-text">
                Welcome, <?php echo $displayUsername; ?>!
            </span>
            <a class="btn btn-danger ms-auto" href="/logout.php">Logout</a>
        </div>
    </nav>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>