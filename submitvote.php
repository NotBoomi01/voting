<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Process votes
    $votes = [
        'President' => $_POST['candidate1'],
        'candidate2' => $_POST['candidate2'],
        'candidate3' => $_POST['candidate3'],
        'candidate4' => $_POST['candidate4']
    ];

    // Save $votes to the database...

    echo "Your vote has been submitted successfully!";
}
?>