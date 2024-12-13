<?php include('../includes/navbar.php'); ?>

<?php
// Connect to the database
$host = "localhost";
$username = "root";
$password = "";
$database = "online_voting";

$conn = new mysqli($host, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch all candidates grouped by partylist
$sql = "SELECT name, position, partylist, votes FROM candidates ORDER BY partylist, FIELD(position, 'president', 'vice president', 'muse', 'escort')";
$result = $conn->query($sql);

// Organize results by partylist
$candidates = ["Blue" => [], "Red" => []];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $candidates[$row['partylist']][] = $row;
    }
} else {
    $candidates = null;
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Voting Results</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        .partylist {
            margin-top: 20px;
            padding: 15px;
            border-radius: 5px;
        }
        .card {
            border: 1px solid #ddd;
        }
        .card-body {
            background-color: #f9f9f9;
        }
        .candidate {
            margin-bottom: 15px;
        }
        .logout-btn {
            position: absolute;
            top: 10px;
            right: 10px;
        }
        /* Define background colors for partylists */
        .Blue {
            background-color: #007bff; /* Blue color */
            color: black; /* Text color set to black */
        }
        .Red {
            background-color: #dc3545; /* Red color */
            color: black; /* Text color set to black */
        }
        .navbar {
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1 class="text-center mb-4">Voting Results</h1>
        <div class="row">
            <?php foreach ($candidates as $partylist => $partyCandidates): ?>
                <div class="col-md-6">
                    <h3 class="text-center"><?= htmlspecialchars($partylist) ?> Partylist</h3>
                    <div class="partylist <?= htmlspecialchars($partylist) ?>">
                        <div class="card">
                            <div class="card-body">
                                <?php if (!empty($partyCandidates)): ?>
                                    <?php foreach ($partyCandidates as $candidate): ?>
                                        <div class="candidate">
                                            <strong><?= htmlspecialchars($candidate['name']) ?></strong><br>
                                            <em>Position:</em> <?= htmlspecialchars($candidate['position']) ?><br>
                                            <em>Votes:</em> <?= htmlspecialchars($candidate['votes']) ?>
                                        </div>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <p>No candidates found for this partylist.</p>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
