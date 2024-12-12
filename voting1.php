<?php
// Database credentials (Replace with your own credentials)
$servername = "localhost"; // Usually 'localhost'
$username = "root"; // Your MySQL username (default is 'root')
$password = ""; // Your MySQL password (default is empty for 'root' in local setups)
$dbname = "online_voting"; // Your database name, e.g. 'voting_system'

// Create connection to MySQL database
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch candidates for the 'President' position only
$sql = "SELECT * FROM candidates WHERE position = 'President'";
$candidatesResult = $conn->query($sql);

// Prepare an array to hold candidates data for the 'President' position
$candidates = [];
if ($candidatesResult->num_rows > 0) {
    // Fetch data for each candidate
    while ($row = $candidatesResult->fetch_assoc()) {
        $candidates[] = $row;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Voting Page - President</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            margin: 0;
            background-color: #f4f4f4;
            font-family: Arial, sans-serif;
        }
        .main-content {
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            min-height: calc(100vh - 56px); /* Adjust for navbar height */
            padding: 20px;
        }
        .container {
            width: 80%;
            text-align: center;
            margin-bottom: 30px;
        }
        .candidate-card {
            border: 1px solid #ddd;
            padding: 15px;
            text-align: center;
            margin-bottom: 20px;
            display: inline-block;
            width: 30%;
            margin-right: 2%;
            background-color: #fff;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .candidate-card img {
            width: 200px;
            height: 200px;
            object-fit: cover;
            margin-bottom: 10px;
        }
        .candidate-info {
            list-style: none;
            padding: 0;
        }
        .candidate-info li {
            margin: 5px 0;
        }
        .candidate-position {
            font-weight: bold;
            margin-top: 10px;
        }
        .candidate-name {
            cursor: pointer;
            color: black;
            font-weight: normal;
        }
        .candidate-row {
            display: flex;
            justify-content: center;
            flex-wrap: wrap;
            gap: 20px;
        }
        .candidate-card .form-check {
            margin-top: 10px;
        }
        .vote-options {
            text-align: center;
            margin-top: 20px;
        }
        .form-check {
            margin-bottom: 10px;
        }
        .pagination-buttons {
            text-align: center;
            margin-top: 30px;
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <?php include('includes/navbarr.php'); ?>

    <!-- Main Content -->
    <div class="main-content">
        <div class="container">
            <h3>President Candidates</h3>
            <div class="candidate-row">
                <?php if (count($candidates) > 0): ?>
                    <?php foreach ($candidates as $candidate): ?>
                        <div class="candidate-card">
                            <img src="uploads/<?php echo htmlspecialchars($candidate['Image']); ?>" alt="Candidate Image">
                            <h6 class="candidate-name" data-candidate-id="<?php echo $candidate['id']; ?>">
                                <?php echo htmlspecialchars($candidate['Name']); ?>
                            </h6>
                            <p class="candidate-position"><?php echo htmlspecialchars($candidate['Position']); ?></p>
                            <p>Partylist: <?php echo htmlspecialchars($candidate['Partylist']); ?></p>
                            <ul class="candidate-info">
                                <?php
                                $infoArray = explode(",", $candidate['PoliticalPlatform']);
                                foreach ($infoArray as $info):
                                ?>
                                    <li><?php echo htmlspecialchars(trim($info)); ?></li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p>No candidates found for the President position.</p>
                <?php endif; ?>
            </div>
        </div>

        <!-- Voting Form -->
        <div class="vote-options">
            <form id="votingForm" action="voting2.php" method="POST">
                <h5>Select Your Vote</h5>
                <?php foreach ($candidates as $candidate): ?>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="candidate" id="candidate-<?php echo $candidate['id']; ?>" value="<?php echo $candidate['Name']; ?>">
                        <label class="form-check-label" for="candidate-<?php echo $candidate['id']; ?>">
                            Vote for <?php echo htmlspecialchars($candidate['Name']); ?>
                        </label>
                    </div>
                <?php endforeach; ?>
                <button type="submit" class="btn btn-primary">Submit Vote</button>
            </form>
        </div>

        <!-- Navigation -->
        <div class="pagination-buttons">
            <a href="index.php?positionIndex=<?php echo min(count($positions) - 1, $positionIndex + 1); ?>" class="btn btn-primary btn-next">Next</a>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>