<?php
$roles_possible = ["norm", "admin", "team", "IT"];

    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    session_start();

    //if (!$_SESSION["role"] == "admin") {
    //    header("location: ./../index.php");
    //    exit;
    //}
    if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
        header("location: ./../index.php");
        exit;
    }

    require_once "./../login/config.php";

    $sql = "SELECT id, username, roles FROM users";
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

    $wbc = "User role will be changed!<br>";
    $c = "User role changed!<br>";

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $selectedUser = $_POST["userSelect"];
        $selectedRole = $_POST["roleSelect"];
        
        echo $wbc;

        $sql = "UPDATE users SET roles = ? WHERE username = ?";

        if ($stmt = mysqli_prepare($link, $sql)) {
            mysqli_stmt_bind_param($stmt, "ss", $param_role, $param_username);

            $param_username = $selectedUser;
            $param_role = $selectedRole;

            if (mysqli_stmt_execute($stmt)) {
                echo $c;
                header("give-role.php");
            } else {
                echo "Oops! Something went wrong... Plese try again later!";
            }

            mysqli_stmt_close($stmt);
        }
        
        mysqli_close($link);
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Give Roles</title>
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
        <select name="roleSelect">
            <?php
                $count = 0;

                foreach ($roles_possible as $item) {
                    echo '<option value="' . $roles_possible[$count] . '">' . $roles_possible[$count] . '</option>';
                    $count += 1;
                }
            ?>
        </select>
        <br><br>
        <button type="submit">Give Role!</button>
    </form>
    <a href="./../index.php">back</a>
</body>
</html>