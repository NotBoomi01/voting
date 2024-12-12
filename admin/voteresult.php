
<?php
// Connect to the database
$host = "localhost"; // Change this to your database host
$username = "root"; // Change this to your database username
$password = ""; // Change this to your database password
$database = "online_voting"; // Change this to your database name

$conn = new mysqli($host, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch all candidates grouped by partylist
$sql = "SELECT name, position, partylist, votes FROM candidates"; // Adjust table/column names as per your database schema
$result = $conn->query($sql);

// Separate candidates by partylist
$blueCandidates = [];
$redCandidates = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        if (strtolower($row["partylist"]) === "blue") {
            $blueCandidates[] = $row;
        } elseif (strtolower($row["partylist"]) === "red") {
            $redCandidates[] = $row;
        }
    }
}

$conn->close();
?>
<?php include ('../includes/navbar.php'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Voting Results</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            padding: 0;
        }

        h1 {
            text-align: center;
            margin-bottom: 20px;
        }

        .container {
            display: flex;
            justify-content: space-between;
            gap: 20px;
        }

        .party-column {
            flex: 1;
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 15px;
            background-color: #f9f9f9;
        }

        .party-column h2 {
            text-align: center;
            margin-bottom: 15px;
        }

        .candidate {
            border: 1px solid #ccc;
            border-radius: 5px;
            padding: 10px;
            margin-bottom: 10px;
            background-color: #fff;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .candidate h3 {
            margin: 0 0 5px;
            font-size: 16px;
        }

        .candidate p {
            margin: 3px 0;
        }
    </style>
</head>
<body>
    <h1>Voting Results</h1>
    <div class="container">
        <!-- Blue Party Column -->
        <div class="party-column">
            <h2>Blue Partylist</h2>
            <?php
            if (!empty($blueCandidates)) {
                foreach ($blueCandidates as $candidate) {
                    echo '<div class="candidate">';
                    echo '<h3>' . htmlspecialchars($candidate["name"]) . '</h3>';
                    echo '<p><strong>Position:</strong> ' . htmlspecialchars($candidate["position"]) . '</p>';
                    echo '<p><strong>Votes:</strong> ' . htmlspecialchars($candidate["votes"]) . '</p>';
                    echo '</div>';
                }
            } else {
                echo '<p>No candidates for Blue Partylist.</p>';
            }
            ?>
        </div>

        <!-- Red Party Column -->
        <div class="party-column">
            <h2>Red Partylist</h2>
            <?php
            if (!empty($redCandidates)) {
                foreach ($redCandidates as $candidate) {
                    echo '<div class="candidate">';
                    echo '<h3>' . htmlspecialchars($candidate["name"]) . '</h3>';
                    echo '<p><strong>Position:</strong> ' . htmlspecialchars($candidate["position"]) . '</p>';
                    echo '<p><strong>Votes:</strong> ' . htmlspecialchars($candidate["votes"]) . '</p>';
                    echo '</div>';
                }
            } else {
                echo '<p>No candidates for Red Partylist.</p>';
            }
            ?>
        </div>
    </div>
</body>
</html>