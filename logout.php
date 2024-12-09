<?php
session_start();
session_destroy(); // Ends the session
header("Location: index.php"); // Redirect to login page
exit();
?>