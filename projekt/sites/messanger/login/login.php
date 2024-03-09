<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
 
// Check if the user is already logged in, if yes then redirect him to welcome page
if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
    header("location: ./../index.php");
    exit;
}
     
// Include config file
//require_once "config.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['login'])) {
        require_once 'login-func.php';

        if (!empty($password_err)) {
            echo "Login: " . $password_err;
        }
        if (!empty($login_err)) {
            echo "Login: " . $login_err;
        } 
        if (!empty($username_err)) {
            echo "Login: " . $username_err;
        }
    } elseif (isset($_POST['register'])) {
        require_once 'register-func.php';

        echo $password_err;
        echo $confirm_password_err;
        echo $username_err;
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="./../assets/styles/login-modern.css">
    <title>Login</title>
</head>
<body>
    <div class="container" id="container">
        <div class="form-container sign-up">
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                <h1>Create Account</h1>
                <div class="social-icons">
                    <a href="#" class="icons"><i class="fa-brands fa-google-plus-g"></i></a>
                    <a href="#" class="icons"><i class="fa-brands fa-facebook"></i></a>
                    <a href="#" class="icons"><i class="fa-brands fa-github"></i></a>
                    <a href="#" class="icons"><i class="fa-brands fa-linkedin-in"></i></a>
                </div>
                <span>or use your email for registration</span>
		        <input type="text" name="username" placeholder="Username">
		        <input type="password" name="password" placeholder="Password">
                <input type="password" name="confirm_password" placeholder="Confirm Password">
		        <button type="submit" name="register">Sign Up</button>
            </form>
        </div>
        <div class="form-container sign-in">
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                <h1>Sign In</h1>
                <div class="social-icons">
                    <a href="#" class="icons"><i class="fa-brands fa-google-plus-g"></i></a>
                    <a href="#" class="icons"><i class="fa-brands fa-facebook"></i></a>
                    <a href="#" class="icons"><i class="fa-brands fa-github"></i></a>
                    <a href="#" class="icons"><i class="fa-brands fa-linkedin-in"></i></a>
                </div>
                <span>or use email & password</span>
                
		        <input type="text" name="username" placeholder="Username">
		        <input type="password" name="password" placeholder="Password">	 
                <a href="#">Forgot Password?</a>
                <button type="submit" name="login">Sign In</button>
            </form>
        </div>
        <div class="toggle-container">
            <div class="toggle">
                <div class="toggle-panel toggle-left">
                    <h1>Welcome Back!</h1>
                    <p>Enter your personal details to use all of site features</p>
                    <button class="hidden" id="login">Sign In</button>
                </div>
                <div class="toggle-panel toggle-right">
                    <h1>Hello, Friend!</h1>
                    <p>Register with your personal details to use all of site features</p>
                    <button class="hidden" id="register">Sign Up</button>
                </div>
            </div>
        </div>
    </div>

    <script src="./../assets/scripts/login-modern.js"></script>
</body>
</html>