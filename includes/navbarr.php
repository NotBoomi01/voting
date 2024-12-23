<?php
// Ensure session is only started if not already active
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}


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

        if ($stmt->execute()) {
            $user = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($user) {
                $displayUsername = htmlspecialchars($user['Username']);
            } else {
                echo "No user found with this ID.<br>"; // Debugging output
            }
        } else {
            echo "Query execution failed.<br>"; // Debugging output
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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
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
