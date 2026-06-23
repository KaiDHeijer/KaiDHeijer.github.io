<?php
session_start();


$userId = $_SESSION['user_id'];

if(!isset($_SESSION['user_id']))
{
    header("Location: login.php");
    exit;
}

include 'db.php';


$name = $_POST['name'];
$description = $_POST['description'];
$cover_url = "";

if(isset($_FILES['cover']) && $_FILES['cover']['error'] == 0)
{
    $filename = time() . "_" . $_FILES['cover']['name'];

    move_uploaded_file(
        $_FILES['cover']['tmp_name'],
        "uploads/" . $filename
    );

    $cover_url = "uploads/" . $filename;
}

$user_id = 1;

$stmt = $pdo->prepare("
    INSERT INTO collections
    (user_id, name, description, cover_url)
    VALUES
    (?, ?, ?, ?)
");

$stmt->execute([
    $user_id,
    $name,
    $description,
    $cover_url
]);

header("Location: mijn-verzamelingen.php");
exit;