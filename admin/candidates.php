<?php include('../includes/navbar.php'); ?>

<?php
// Database connection
$conn = new mysqli('localhost', 'root', '', 'voting');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch candidates from the database
$sql = "SELECT * FROM candidates";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Candidates List</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-4">
        <h2 class="text-center">Candidates List</h2>
        <a href="add_candidate.php" class="btn btn-primary mb-3">+ New</a>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Image</th>
                    <th>Partylist</th>
                    <th>Position</th>
                    <th>Platform</th>
                    <th>Tools</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($result->num_rows > 0): ?>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['Name']); ?></td>
                            <td>
                                <?php if (!empty($row['Image']) && file_exists("uploads/" . $row['Image'])): ?>
                                    <img src="uploads/<?php echo htmlspecialchars($row['Image']); ?>" alt="Photo" style="width: 100px; height: 100px;">
                                <?php else: ?>
                                    <span class="text-danger">Image not found</span>
                                <?php endif; ?>
                            </td>
                            <td><?php echo htmlspecialchars($row['Partylist']); ?></td>
                            <td><?php echo htmlspecialchars($row['Position']); ?></td>
                            <td><?php echo htmlspecialchars($row['PoliticalPlatform']); ?></td>
                            <td>
                                <a href="edit_candidate.php?id=<?php echo $row['id']; ?>" class="btn btn-success">Edit</a>
                                <a href="delete_candidate.php?id=<?php echo $row['id']; ?>" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this candidate?');">Delete</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="6" class="text-center">No candidates found.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</body>
</html>

<?php
$conn->close();
?>