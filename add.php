<?php
session_start();
require_once "pdo.php";

if (!isset($_SESSION['name'])) {
    die("ACCESS DENIED");
}

if (isset($_POST["add"])) {
    if (strlen($_POST["make"]) < 1 || strlen($_POST["model"]) < 1 || strlen($_POST["year"]) < 1 || strlen($_POST["mileage"]) < 1) {
        $_SESSION["addfail"] = "All fields are required";
        header("Location: add.php");
        return;
    } else {
        if (is_numeric($_POST["mileage"])) {
            if (is_numeric($_POST["year"])) {
                $stmt = $pdo->prepare("insert into autos(make, model, year, mileage) values(:mk, :md, :yr, :mi)");
                $stmt->execute(
                    array(
                        ":mk" => $_POST["make"],
                        ":md" => $_POST["model"],
                        ":yr" => $_POST["year"],
                        ":mi" => $_POST["mileage"],
                    )
                );

                $_SESSION["success"] = "Record added";
                header("Location: index.php");
                return;
            } else {
                $_SESSION["addfail"] = "Year must be numeric";
                header("Location: add.php");
                return;
            }
        } else {
            $_SESSION["addfail"] = "Mileage must be numeric";
            header("Location: add.php");
            return;
        }
    }
}

if (isset($_POST["cancel"])) {
    header("Location: index.php");
    return;
}
?>

<html>

<head>
    <title>Dharmang Gajjar</title>

    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">

    <!-- Optional theme -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css" integrity="sha384-fLW2N01lMqjakBkx3l/M9EahuwpSfeNvV63J5ezn3uZzapT0u7EYsXMjQV+0En5r" crossorigin="anonymous">
</head>

<body>
    <div class="container">
        <h1>Tracking Automobiles for <?php echo htmlentities($_SESSION["name"]) ?> </h1>

        <?php
        if (isset($_SESSION["addfail"])) {
            echo ('<p style="color: red;">' . htmlentities($_SESSION["addfail"]) . "</p>\n");
            unset($_SESSION["addfail"]);
        }
        ?>

        <form method="post">
            <p>Make:
                <input type="text" name="make" size="40" /></p>
            <p>Model:
                <input type="text" name="model" size="40" /></p>
            <p>Year:
                <input type="text" name="year" size="10" /></p>
            <p>Mileage:
                <input type="text" name="mileage" size="10" /></p>
            <input type="submit" value="Add" name="add">
            <input type="submit" name="cancel" value="Cancel">
        </form>
    </div>
</body>

</html>