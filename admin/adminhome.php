<?php include ('../includes/navbarr.php'); ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Home</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css">
    <style>
        .card {
            margin: 10px;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="container mt-4">
        <h1 class="text-center">Welcome, Admin!</h1>
        <div class="row justify-content-center">
            <!-- User Card -->
            <div class="col-md-3">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">User</h5>
                        <p class="card-text">View registered voters</p>
                        <a href="voters.php" class="btn btn-primary">Go to User</a>
                    </div>
                </div>
            </div>

            <!-- Vote Results Card -->
            <div class="col-md-3">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Vote Results</h5>
                        <p class="card-text">View overall vote counts</p>
                        <a href="voteresult.php" class="btn btn-primary">View Results</a>
                    </div>
                </div>
            </div>

            <!-- Candidates Card -->
            <div class="col-md-3">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Candidates</h5>
                        <p class="card-text">View registered candidates</p>
                        <a href="candidates.php" class="btn btn-primary">View Candidates</a>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Partylist</h5>
                        <p class="card-text">View registered party-lists</p>
                        <a href="partylist.php" class="btn btn-primary">View Partylist</a>
                    </div>
                </div>
            </div>
        </div>
        </div>
    </div>

    

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
