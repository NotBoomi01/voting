<?php

// Database credentials
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "online_voting";

// Create connection to MySQL database
$conn = new mysqli($servername, $username, $password, $dbname);

// Start session to track user
session_start();
if (!isset($_SESSION['user_id'])) {
    die("Access denied. Please log in.");
}

$user_id = $_SESSION['user_id'];
$candidates = [];

// Fetch candidates for the 'Vice President' position only
$sql = "SELECT * FROM candidates WHERE position = 'Vice President'";
$candidatesResult = $conn->query($sql);

if ($candidatesResult && $candidatesResult->num_rows > 0) {
  while ($row = $candidatesResult->fetch_assoc()) {
    $candidates[] = $row;
  }
}

// Check if the user has already voted for Vice President
$hasVoted = false;
$sql = "SELECT * FROM votes WHERE user_id = ? AND position = 'Vice President'";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows > 0) {
  $hasVoted = true;
}
$stmt->close();

// Handle vote submission
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['candidate']) && !$hasVoted) {
    $candidateName = $_POST['candidate'];

    // Record the vote
    $insertVoteSql = "INSERT INTO votes (user_id, candidate_id, position) VALUES (?, ?, 'Vice President')";
    $stmt = $conn->prepare($insertVoteSql);

    if ($stmt) {
        // Find the candidate's ID based on the name
        $candidateId = null;
        foreach ($candidates as $candidate) {
            if ($candidate['Name'] === $candidateName) {
                $candidateId = $candidate['id'];
                break;
            }
        }

        if ($candidateId) {
            $stmt->bind_param("ii", $user_id, $candidateId);
            $stmt->execute();

            // Update the candidate's votes count
            $updateSql = "UPDATE candidates SET votes = votes + 1 WHERE id = ?";
            $updateStmt = $conn->prepare($updateSql);
            $updateStmt->bind_param("i", $candidateId);
            $updateStmt->execute();
            $updateStmt->close();

            // Redirect to voting3.php after successful vote
            header("Location: voting3.php");
            exit();
        } else {
            echo "<script>alert('Error processing your vote. Please try again later.');</script>";
        }
        $stmt->close();
    }
} else if ($hasVoted) {
  echo "<script>alert('You have already voted. Thank you!');</script>";
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Voting Page - Vice President</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { margin: 0; background-color: #f4f4f4; font-family: Arial, sans-serif; }
        .main-content { display: flex; justify-content: center; align-items: center; flex-direction: column; min-height: calc(100vh - 56px); padding: 20px; }
        .container { width: 80%; text-align: center; margin-bottom: 30px; }
        .candidate-card { border: 1px solid #ddd; padding: 15px; text-align: center; margin-bottom: 20px; display: inline-block; width: 30%; margin-right: 2%; background-color: #fff; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); }
        .candidate-card img { width: 200px; height: 200px; object-fit: cover; margin-bottom: 10px; }
        .vote-options { text-align: center; margin-top: 20px; }
    </style>
</head>
<body>
    <!-- Navbar -->
    <?php include('includes/navbarr.php'); ?>

    <!-- Main Content -->
    <div class="main-content">
        <div class="container">
            <h3>Vice President Candidates</h3>
            <div class="candidate-row">
                <?php if (!empty($candidates)): ?>
                    <?php foreach ($candidates as $candidate): ?>
                        <div class="candidate-card">
                            <img src="uploads/<?php echo htmlspecialchars($candidate['Image']); ?>" alt="Candidate Image">
                            <h6><?php echo htmlspecialchars($candidate['Name']); ?></h6>
                            <p>Partylist: <?php echo htmlspecialchars($candidate['Partylist']); ?></p>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p>No candidates found for the Vice President position.</p>
                <?php endif; ?>
            </div>
        </div>

        <!-- Voting Form -->
        <div class="vote-options">
            <?php if (!$hasVoted): ?>
                <form id="votingForm" action="" method="POST" onsubmit="return validateForm()">
                    <h5>Select Your Vote</h5>
                    <?php foreach ($candidates as $candidate): ?>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="candidate" id="candidate-<?php echo $candidate['id']; ?>" value="<?php echo htmlspecialchars($candidate['Name']); ?>">
                            <label class="form-check-label" for="candidate-<?php echo $candidate['id']; ?>">
                                Vote for <?php echo htmlspecialchars($candidate['Name']); ?>
                            </label>
                        </div>
                    <?php endforeach; ?>
                    <button type="submit" class="btn btn-primary">Submit Vote</button>
                </form>
            <?php else: ?>
                <p>You have already voted. Thank you!</p>
            <?php endif; ?>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        function validateForm() {
            const radios = document.getElementsByName('candidate');
            let selected = false;
            for (const radio of radios) {
                if (radio.checked) {
                    selected = true;
                    break;
                }
            }
            if (!selected) {
                alert("Please select a candidate before proceeding.");
                return false;
            }
            return true;
        }
    </script>
</body>
</html>
