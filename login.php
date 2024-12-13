<?php
// Start the session
session_start();

// Database credentials
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "online_voting";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Variables to store errors
$errorMessage = "";

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get input values
    $adminUsername = $_POST['username'];
    $adminPassword = $_POST['password'];

    // Sanitize input (basic sanitization, consider using prepared statements)
    $adminUsername = htmlspecialchars($adminUsername); 

    // Prepare statement to prevent SQL injection
    $sql = "SELECT id, password FROM voters WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $adminUsername);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $row = $result->fetch_assoc();
        $hashedPassword = $row['password'];

        // Verify password hash
        if (password_verify($adminPassword, $hashedPassword)) {
            // Authentication successful
            $_SESSION['voters_logged_in'] = true;
            $_SESSION['user_id'] = $row['id']; // Store user ID in session
            header("Location: voting1.php");
            exit();
        } else {
            $errorMessage = "Invalid password.";
        }
    } else {
        $errorMessage = "Invalid username.";
    }

    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <style>
        /* Ensure the HTML and body take full height */
        html, body {
            height: 100%;
            margin: 0;
            font-family: Arial, sans-serif;
            background-image: url('../images/Faculty-election-social.jpg'); 
            background-size: cover; 
            background-position: center center; 
            background-repeat: no-repeat;
        }

        /* Flexbox layout for footer placement */
        .page-wrapper {
            display: flex;
            flex-direction: column;
            min-height: 100%;
        }

        .main-content {
            flex-grow: 1;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }

        .registration-form {
            width: 100%;
            max-width: 400px;
            padding: 20px;
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .registration-form h2 {
            text-align: center;
            margin-bottom: 20px;
            color: #333;
        }

        .form-group {
            margin-bottom: 15px;
        }

        label {
            display: block;
            margin-bottom: 5px;
            color: #555;
        }

        input[type="text"], input[type="password"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }

        button {
            width: 100%;
            padding: 10px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
        }

        button:hover {
            background-color: #0056b3;
        }

        footer {
            background-color: #333;
            color: #fff;
            text-align: center;
            padding: 10px;
        }
    </style>
</head>
<body>
    <div class="page-wrapper">
        <!-- Include your navbar -->
        <?php include('includes/navvbar.php'); ?>

        <div class="main-content">
            <div class="registration-form">
                <h2>Login</h2>
                <?php if (!empty($errorMessage)): ?>
                    <div style="color:red; text-align:center;"><?php echo $errorMessage; ?></div>
                <?php endif; ?>
                <form action="" method="POST">
                    <!-- Username Field -->
                    <div class="form-group">
                        <label for="username">Username:</label>
                        <input type="text" id="username" name="username" placeholder="Enter username" required>
                    </div>

                    <!-- Password Field -->
                    <div class="form-group">
                        <label for="password">Password:</label>
                        <input type="password" id="password" name="password" placeholder="Enter your password" required>
                    </div>

                    <!-- Submit Button -->
                    <button type="submit">Login</button>
                </form>
                <p style="text-align:center;">Don't have an account? <a href="register.php">Register here</a></p>
            </div>
        </div>

        <footer>
            <p>&copy; 2024 Your Company. All rights reserved.</p>
        </footer>
    </div>
</body>
</html>
