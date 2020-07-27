<?php
require_once "pdo.php";
session_start();

if (
    isset($_POST['make']) && isset($_POST['model'])
    && isset($_POST['year']) && isset($_POST['autos_id']) && isset($_POST['mileage'])
) {
    if (strlen($_POST["make"]) < 1 || strlen($_POST["model"]) < 1 || strlen($_POST["year"]) < 1 || strlen($_POST["mileage"]) < 1) {
        $_SESSION["editfail"] = "All fields are required";
        header("Location: edit.php?autos_id=" . $_POST["autos_id"]);
        return;
    } else {
        if (is_numeric($_POST["mileage"])) {
            if (is_numeric($_POST["year"])) {
                $stmt = $pdo->prepare("update autos set make=:mk, model=:md, year=:yr, mileage=:mi where autos_id=:id");
                $stmt->execute(
                    array(
                        ":mk" => $_POST["make"],
                        ":md" => $_POST["model"],
                        ":yr" => $_POST["year"],
                        ":mi" => $_POST["mileage"],
                        ":id" => $_POST["autos_id"]
                    )
                );

                $_SESSION["success"] = "Record edited";
                header("Location: index.php");
                return;
            } else {
                $_SESSION["editfail"] = "Year must be numeric";
                header("Location: edit.php?autos_id=" . $_POST["autos_id"]);
                return;
            }
        } else {
            $_SESSION["editfail"] = "Mileage must be numeric";
            header("Location: edit.php?autos_id=" . $_POST["autos_id"]);
            return;
        }
    }
}

$stmt = $pdo->prepare("SELECT * FROM autos where autos_id = :id");
$stmt->execute(array(":id" => $_GET['autos_id']));
$row = $stmt->fetch(PDO::FETCH_ASSOC);
if ($row === false) {
    $_SESSION['error'] = 'Bad value for autos_id';
    header('Location: index.php');
    return;
}

$m = htmlentities($row['make']);
$md = htmlentities($row['model']);
$y = htmlentities($row['year']);
$mi = htmlentities($row['mileage']);
$autos_id = $row['autos_id'];
?>

<head>
    <title>Dharmang Gajjar</title>
    <?php require_once "bootstrap.php"; ?>
</head>

<body>
    <div class="container">

        <h1>Editing Automobile</h1>
        <?php
        if (isset($_SESSION['editfail'])) {
            echo '<p style="color:red">' . $_SESSION['editfail'] . "</p>\n";
            unset($_SESSION['editfail']);
        }
        ?>
        <form method="post">
            <p>Make:
                <input type="text" name="make" value="<?= $m ?>"></p>
            <p>Model:
                <input type="text" name="model" value="<?= $md ?>"></p>
            <p>Year:
                <input type="text" name="year" value="<?= $y ?>"></p>
            <p>Mileage:
                <input type="text" name="mileage" value="<?= $mi ?>"></p>
            <input type="hidden" name="autos_id" value="<?= $autos_id ?>">
            <p><input type="submit" value="Save" />
                <a href="index.php">Cancel</a></p>
        </form>
    </div>
</body>