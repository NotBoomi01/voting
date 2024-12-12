<?php
// Database credentials
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "online_voting";

// Create connection to MySQL database
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch candidates for the 'Vice President' position only
$sql = "SELECT * FROM candidates WHERE position = 'Vice President'";
$candidatesResult = $conn->query($sql);

// Prepare an array to hold candidates data for the 'Vice President' position
$candidates = [];
if ($candidatesResult->num_rows > 0) {
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
    <title>Voting Page - Vice President</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { margin: 0; background-color: #f4f4f4; font-family: Arial, sans-serif; }
        .main-content { display: flex; justify-content: center; align-items: center; flex-direction: column; min-height: calc(100vh - 56px); padding: 20px; }
        .container { width: 80%; text-align: center; margin-bottom: 30px; }
        .candidate-card { border: 1px solid #ddd; padding: 15px; text-align: center; margin-bottom: 20px; display: inline-block; width: 30%; margin-right: 2%; background-color: #fff; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); }
        .candidate-card img { width: 200px; height: 200px; object-fit: cover; margin-bottom: 10px; }
        .vote-options { text-align: center; margin-top: 20px; }
        .pagination-buttons { text-align: center; margin-top: 30px; }
        
        /* Centering radio buttons */
        .form-check {
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 10px;
            text-align: left;
        }

        .form-check-input {
            margin-right: 10px;
        }

        /* Centering the voting options */
        .vote-options form {
            display: flex;
            flex-direction: column;
            align-items: center; /* Center items horizontally */
            justify-content: center; /* Center items vertically */
        }

        .candidate-info {
            list-style-type: none;
            padding-left: 0;
        }
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
                <?php if (count($candidates) > 0): ?>
                    <?php foreach ($candidates as $candidate): ?>
                        <div class="candidate-card">
                            <img src="uploads/<?php echo htmlspecialchars($candidate['Image']); ?>" alt="Candidate Image">
                            <h6><?php echo htmlspecialchars($candidate['Name']); ?></h6>
                            <p>Partylist: <?php echo htmlspecialchars($candidate['Partylist']); ?></p>
                            <p><strong>Political Platform:</strong></p>
                            <ul class="candidate-info">
                                <?php
                                // Displaying each candidate's political platform
                                $platformArray = explode(",", $candidate['PoliticalPlatform']);
                                foreach ($platformArray as $platform):
                                ?>
                                    <li><?php echo htmlspecialchars(trim($platform)); ?></li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p>No candidates found for the Vice President position.</p>
                <?php endif; ?>
            </div>

            <!-- Voting Form -->
            <div class="vote-options">
                <form id="votingForm" action="voting3.php" method="POST" onsubmit="return validateForm()">
                    <h5>Select Your Vote</h5>
                    <?php foreach ($candidates as $candidate): ?>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="candidate" id="candidate-<?php echo $candidate['id']; ?>" value="<?php echo $candidate['Name']; ?>">
                            <label class="form-check-label" for="<?php echo 'candidate-' . $candidate['id']; ?>">Vote for <?php echo htmlspecialchars($candidate['Name']); ?></label>
                        </div>
                    <?php endforeach; ?>
                    <button type="submit" class="btn btn-primary">Submit Vote</button>
                </form>
            </div>

            <!-- Navigation -->
            <div class="pagination-buttons">
                <!-- Add navigation buttons if necessary -->
            </div>

        </div>

<script src='https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js'></script>

<script>
// Validate the voting form to ensure a candidate is selected
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
        return false; // Prevent form submission if no candidate is selected
    }

    return true; // Allow form submission if a candidate is selected
}
</script>

</body>
</html>
