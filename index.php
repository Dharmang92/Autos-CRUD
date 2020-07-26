<?php
session_start();
require_once "pdo.php";
?>

<!DOCTYPE html>
<html>

<head>
    <title>Dharmang Gajjar</title>
    <?php require_once "bootstrap.php"; ?>
</head>

<body>
    <div class="container">
        <h2>Welcome to the Automobiles Database</h2>

        <?php
        if (isset($_SESSION["name"])) {
            $stmt = $pdo->query("select make, model, year, mileage from autos");
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($row === false) {
                echo "<p>No rows found</p>";
            } else {
                echo "<table border=1>";
                echo "<tr><td><b>Make</b></td><td><b>Model</b></td><td><b>Year</b></td><td><b>Mileage</b></td><td><b>Action</b></td></tr>";
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    echo "<tr>";
                    echo "<td>" . htmlentities($row["make"]) . "</td>";
                    echo "<td>" . htmlentities($row["model"]) . "</td>";
                    echo "<td>" . htmlentities($row["year"]) . "</td>";
                    echo "<td>" . htmlentities($row["mileage"]) . "</td>";
                    echo "<td>" . "" . "</td>";
                    echo "</tr>";
                }
                echo "</table>";
            }

            echo "<p><a href='add.php'>Add New Entry</a></p>";
            echo "<p><a href='logout.php'>Logout</a></p>";
        } else {
            echo "<p><a href='login.php'>Please log in</a></p>";
            echo "<p>Attempt to <a href='add.php'>add data</a> without logging in.</p>";
        }
        ?>
    </div>
</body>