<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();

if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === false) {
    header("location: ./../index.php");
    exit;
}

require_once "./../login/config.php";

$sql = "SELECT email FROM users;";
$result = mysqli_query($link, $sql);

if (mysqli_num_rows($result) > 0) {
    $i = 0;

    while ($row = mysqli_fetch_assoc($result)) {
        $emails[$i] = $row["email"];
        echo $emails[$i] . "<br>";
        $i += 1;
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Message someone</title>
    <link rel="stylesheet" href="./../assets/styles/messanger.css">
</head>
<body>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <label for="email">Enter a E-Mail (only with @liam1581.de at the end, gmail or other doesnt work!)</label><br>
        <textarea id="email" name="email" class="non-resizable" placeholder="To: 'someone@liam1581.de'" cols="68" rows="1"></textarea><br>
        <textarea id="from" name="from" class="non-resizable" cols="68" rows="1" readonly>From: <?php echo $_SESSION["email"]; ?></textarea><br>
        <textarea id="text" name="text" cols="68" rows="15"></textarea><br>

        <button type="submit">Send</button>
    </form>
</body>
</html>