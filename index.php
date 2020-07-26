<?php
session_start();
require_once "pdo.php";
?>

<!DOCTYPE html>
<html>

<head>
    <title>Dharmang Gajjar</title>
    <?php require_once "bootstrap.php"; ?>
    <link rel="stylesheet" href="style.css" />
</head>

<body>
    <div class="container">
        <h2>Welcome to the Automobiles Database</h2>

        <?php
        if (isset($_SESSION["success"])) {
            echo "<p style='color: green;'>" . htmlentities($_SESSION["success"]) . "</p>\n";
            unset($_SESSION["success"]);
        }
        if (isset($_SESSION["error"])) {
            echo "<p style='color: red;'>" . htmlentities($_SESSION["error"]) . "</p>\n";
            unset($_SESSION["error"]);
        }

        if (isset($_SESSION["name"])) {
            // Even if we display 4 fields and not autos_id we need to use in select query in order to user in $row["autos_id"].
            $stmt = $pdo->query("select autos_id, make, model, year, mileage from autos");
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($row === false) {
                echo "<p>No rows found</p>";
            } else {
                echo "<table border=1>";
                echo "<tr><td><b>Make</b></td><td><b>Model</b></td><td><b>Year</b></td><td><b>Mileage</b></td><td><b>Action</b></td></tr>";
                // had to print twice because of row pointer issue.
                echo "<tr>";
                echo "<td>" . $row["make"] . "</td>";
                echo "<td>" . htmlentities($row["model"]) . "</td>";
                echo "<td>" . htmlentities($row["year"]) . "</td>";
                echo "<td>" . htmlentities($row["mileage"]) . "</td><td>";
                echo '<a href="edit.php?autos_id=' . $row['autos_id'] . '">Edit</a> / ';
                echo '<a href="delete.php?autos_id=' . $row['autos_id'] . '">Delete</a>';
                echo "</td></tr>";
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    echo "<tr>";
                    echo "<td>" . $row["make"] . "</td>";
                    echo "<td>" . htmlentities($row["model"]) . "</td>";
                    echo "<td>" . htmlentities($row["year"]) . "</td>";
                    echo "<td>" . htmlentities($row["mileage"]) . "</td><td>";
                    echo "<form method='get'>";
                    echo '<a href="edit.php?autos_id=' . $row['autos_id'] . '">Edit</a> / ';
                    echo '<a href="delete.php?autos_id=' . $row['autos_id'] . '">Delete</a>';
                    echo "</form>";
                    echo "</td></tr>";
                }
                echo "</table>";
            }
            echo "<p></p>";
            echo "<p><a href='add.php'>Add New Entry</a></p>";
            echo "<p><a href='logout.php'>Logout</a></p>";
        } else {
            echo "<p><a href='login.php'>Please log in</a></p>";
            echo "<p>Attempt to <a href='add.php'>add data</a> without logging in.</p>";
        }
        ?>
    </div>
</body>