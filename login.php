<?php // Do not put any HTML above this line
session_start();

if (isset($_POST['cancel'])) {
    // Redirect the browser to game.php
    header("Location: index.php");
    return;
}

$salt = 'XyZzy12*_';
$stored_hash = '1a52e17fa899cf40fb04cfc42e6352f1';

if (isset($_POST['email']) && isset($_POST['pass'])) {
    if (strlen($_POST['email']) < 1 || strlen($_POST['pass']) < 1) {
        $_SESSION["failure"] = "User name and password are required";
        header("Location: login.php");
        return;
    }
    if (strpos($_POST["email"], "@") === false) {
        $_SESSION["failure"] = "Email must have an at-sign (@)";
        header("Location: login.php");
        return;
    } else {
        $check = hash('md5', $salt . $_POST['pass']);
        if ($check == $stored_hash) {
            error_log("Login success " . $_POST['email']);
            $_SESSION["name"] = $_POST['email'];
            header("Location: index.php");
            return;
        } else {
            $_SESSION["failure"] = "Incorrect password";
            error_log("Login fail " . $_POST['email'] . " $check");
            header("Location: login.php");
            return;
        }
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <?php require_once "bootstrap.php"; ?>
    <title>Dharmang Gajjar</title>
</head>

<body>
    <div class="container">
        <h1>Please Log In</h1>

        <?php
        if (isset($_SESSION["failure"])) {
            echo ('<p style="color: red;">' . htmlentities($_SESSION["failure"]) . "</p>\n");
            unset($_SESSION["failure"]);
        }
        ?>

        <form method="POST">
            <label for="nam">User Name</label>
            <input type="text" name="email" id="nam"><br />
            <label for="id_1723">Password</label>
            <input type="text" name="pass" id="id_1723"><br />
            <input type="submit" value="Log In">
            <a href="index.php">Cancel</a>
        </form>
        <p></p>
        <p>
            For a password hint, view source and find a password hint
            in the HTML comments.
        </p>
    </div>
</body>