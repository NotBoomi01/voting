<?php include('../includes/navbar.php'); ?>

<?php
// Connect to database
$conn = new mysqli('localhost', 'root', '', 'online_voting');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Ensure default partylists exist
$conn->query("INSERT IGNORE INTO partylist (id, name, description, image) VALUES
    (1, 'Blue Partylist', 'Default description for Blue Partylist', ''),
    (2, 'Red Partylist', 'Default description for Red Partylist', '')");

// Handle form submission for editing partylists
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $description = $_POST['description'];

    // Handle image upload
    $image = null;
    if (!empty($_FILES['image']['name'])) {
        $imagePath = 'uploads/' . basename($_FILES['image']['name']);
        if (move_uploaded_file($_FILES['image']['tmp_name'], $imagePath)) {
            $image = $imagePath;
        }
    }

    // Update partylist
    $sql = "UPDATE partylist SET name = ?, description = ?, image = IFNULL(?, image) WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssi", $name, $description, $image, $id);
    $stmt->execute();

    echo "<script>alert('Partylist updated successfully!');</script>";
}

// Fetch partylists
$partylists = $conn->query("SELECT * FROM partylist");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Manage Partylists</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }
        .container {
            margin: 20px auto;
            width: 80%;
            background: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h2 {
            text-align: center;
        }
        .partylist {
            margin-bottom: 30px;
        }
        .partylist img {
            max-width: 100px;
            display: block;
            margin-top: 10px;
        }
        label {
            display: block;
            margin-top: 10px;
        }
        input, textarea, button {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        button {
            background-color: #007bff;
            color: #fff;
            border: none;
            cursor: pointer;
        }
        button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Manage Partylists</h2>
        <?php while ($partylist = $partylists->fetch_assoc()): ?>
            <div class="partylist">
                <form method="post" enctype="multipart/form-data">
                    <input type="hidden" name="id" value="<?php echo $partylist['id']; ?>">
                    <label for="name">Name:</label>
                    <input type="text" name="name" value="<?php echo htmlspecialchars($partylist['name']); ?>" required>

                    <label for="description">Description:</label>
                    <textarea name="description" required><?php echo htmlspecialchars($partylist['description']); ?></textarea>

                    <label for="image">Image:</label>
                    <input type="file" name="image">
                    <?php if (!empty($partylist['image'])): ?>
                        <img src="<?php echo htmlspecialchars($partylist['image']); ?>" alt="Partylist Image">
                    <?php endif; ?>

                    <button type="submit">Save</button>
                </form>
            </div>
        <?php endwhile; ?>
    </div>
</body>
</html>
