<?php

// Initialize the session
session_start();
$loggedin;

if (isset($_GET['loggedin']) == 'false') {
    $loggedin = false;
} elseif(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: index.php?loggedin=false");
    exit;
} elseif(isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] == true) {
    $loggedin = true;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/styles/index.css">
    <title>Welcome</title>
</head>
<body>
    <h1>Hello <?php echo $_SESSION["username"]; ?></h1>
    <?php
        if (!empty($_SESSION["email"])) {
            echo '<h4>(your email is: ' . $_SESSION["email"] . ')</h4>';
        }
    ?>
    <br>
    <br>
    <?php
    if ($loggedin == false) {
        echo "<a href='login/login.php'>Login?</a>";
    } elseif ($loggedin == true) {
        echo "<a href='login/logout.php'>Logout</a><br>";
        echo "<a href='login/reset-password.php'>Reset Password</a><br>";
        echo "<a href='login/delete-acc.php'>Delete Account</a><br>";
        echo "<a href='messanger/messanger.php'>Message someone</a><br>";
        echo "<a href='messanger/inbox.php'>Inbox</a><br><br>";
    }

    if ($_SESSION["role"] == "admin") {
        echo "<h2>Admin Only:</h2>";
        echo "<a href='admin/delete-accs.php'>Delete Accounts</a><br>";
        echo "<a href='admin/give-role.php'>Give Role</a>";
    }
    ?>


    <script src="assets/scripts/index.js"></script>
</body>
</html>
