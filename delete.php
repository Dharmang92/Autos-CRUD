<?php
require_once "pdo.php";
session_start();

if (isset($_POST['delete']) && isset($_POST['autos_id'])) {
    $sql = "DELETE FROM autos WHERE autos_id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(array(':id' => $_POST['autos_id']));
    $_SESSION['success'] = 'Record deleted';
    header('Location: index.php');
    return;
}

if (!isset($_GET['autos_id'])) {
    $_SESSION['error'] = "Missing user_id";
    header('Location: index.php');
    return;
}

$stmt = $pdo->prepare("SELECT * FROM autos where autos_id = :id");
$stmt->execute(array(":id" => $_GET['autos_id']));
$row = $stmt->fetch(PDO::FETCH_ASSOC);
if ($row === false) {
    $_SESSION['error'] = 'Bad value for user_id';
    header('Location: index.php');
    return;
}
?>

<html>

<head>
    <title>Dharmang Gajjar</title>
    <?php require_once "bootstrap.php"; ?>
</head>

<body>
    <div class="container">
        Confirm: Deleting <?= htmlentities($row["make"]); ?>
        <br>
        <form method="post">
            <input type="hidden" name="autos_id" value="<?php echo $_GET["autos_id"]; ?>">
            <input type="submit" name="delete" value="Delete" />
            <a href="index.php">Cancel</a>
        </form>
    </div>
</body>

</html>