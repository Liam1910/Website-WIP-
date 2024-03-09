<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once "config.php";

// Initialize the session
session_start();

$id = $_SESSION["id"];

$password_err = "";


if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if(empty(trim($_POST["password"]))){
        $password_err = "Please enter your password.";     
    } elseif ($_POST["password"] == $_SESSION["password"]) {
        $password_err = "";
    } else {
        $password_err = "Password did not match with your one!";
    }


    if (empty($password_err)) {
        $sql = "DELETE FROM users WHERE id = ?";

        if ($stmt = mysqli_prepare($link, $sql)) {
            mysqli_stmt_bind_param($stmt, "s", $param_id);

            $param_id = $id;

            if (mysqli_stmt_execute($stmt)) {
                mysqli_stmt_store_result($stmt);
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }
            mysqli_stmt_close($stmt);
            header("location: logout.php");
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body{ font: 14px sans-serif; }
        .wrapper{ width: 360px; padding: 20px; }
    </style>
    <title>Delete Account</title>
</head>
<body>
    <div class="wrapper">
        <h1>Delete Account</h1>
        <p>Please fill out this form to Delete your Account.</p>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group">
                <label>Enter Password</label>
                <input type="password" name="password" class="form-control <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>">
                <span class="invalid-feedback"><?php echo $password_err; ?></span>
            </div>    
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Delete Account">
                <a class="btn btn-link ml-2" href="index.php">Cancel</a>
            </div>
        </form>
    </div>
</body>
</html>
