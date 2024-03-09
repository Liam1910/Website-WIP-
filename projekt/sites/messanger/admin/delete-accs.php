<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Initialize the session
session_start();
 
// Check if the user is already logged in, if yes then redirect him to welcome page
if (!$_SESSION["role"] == "admin") {
    header("location: ./../index.php");
    exit;
}
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: ./../index.php");
    exit;
}

require_once "./../login/config.php";

$sql = "SELECT id, username, roles FROM users;";
$result = mysqli_query($link, $sql);

if (mysqli_num_rows($result) > 0) {
    $i = 0;
    while ($row = mysqli_fetch_assoc($result)) {
        $msg[$i] = $row["username"];
        $role[$msg[$i]] = $row["roles"];
        $i += 1;
    }
} else {
    echo "0 results";
}

//require_once "./../login/config.php";

$wbd = "User will be deleted!<br>";
$d = "User deleted!<br>";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $selected = $_POST['userSelect'];
    if ($role[$selected] == "admin") {
        echo "User cant be deleted because: ERR_USER_ROLE_ADMIN";
    } else {
        echo $wbd;

        $sql = "DELETE FROM users WHERE username = ?";

        if ($stmt = mysqli_prepare($link, $sql)) {
            mysqli_stmt_bind_param($stmt, "s", $param_usrname);

            $param_usrname = $selected;

            if (mysqli_stmt_execute($stmt)) {
                echo $d;
                header("delete-accs.php");
            } else {
                echo "Oops! Something went wrong... Please try again later";
            }

            mysqli_stmt_close($stmt);
        }
    }

    mysqli_close($link);
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete Accounts</title>
</head>
<body>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <select name="userSelect">
            <?php
            $count = 0;

            foreach ($msg as $item) {
                if ($count >= $i) {
                    break;
                }

                echo '<option value="' . $msg[$count] . '">' . $msg[$count] . '</option>';

                $count++;
            }
            ?>
        </select>
        <br>
        <br>
        <button type="submit">Delete user!</button>
    </form>
    <a href="./../index.php" type="button">back</a>
</body>
</html>