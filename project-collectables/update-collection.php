<?php

include 'db.php';

$id = $_POST['id'];
$name = $_POST['name'];
$description = $_POST['description'];

$stmt = $pdo->prepare("
    UPDATE collections
    SET
        name = ?,
        description = ?
    WHERE id = ?
");

$stmt->execute([
    $name,
    $description,
    $id
]);

header("Location: mijn-verzamelingen.php");
exit;