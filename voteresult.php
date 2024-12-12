<?php
$conn = new mysqli('localhost', 'root', '', 'online_voting');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch vote results grouped by position and candidate
$sql = "SELECT candidates.Name, candidates.Position, COUNT(votes.id) AS vote_count
        FROM votes
        JOIN candidates ON votes.candidate_id = candidates.id
        GROUP BY votes.candidate_id, candidates.Position
        ORDER BY candidates.Position, vote_count DESC";

$result = $conn->query($sql);

if ($result->num_rows > 0): ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Vote Results</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    </head>
    <body>
        <div class="container mt-5">
            <h2 class="text-center">Vote Results</h2>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Position</th>
                        <th>Candidate Name</th>
                        <th>Votes</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['Position']); ?></td>
                            <td><?php echo htmlspecialchars($row['Name']); ?></td>
                            <td><?php echo htmlspecialchars($row['vote_count']); ?></td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </body>
    </html>
<?php else: ?>
    <p>No votes found.</p>
<?php endif;

$conn->close();
?>
