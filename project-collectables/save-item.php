<?php
session_start();

if(!isset($_SESSION['user_id']))
{
    header("Location: login.php");
    exit;
}

include 'db.php';

$collection_id = $_POST['collection_id'];
$name = $_POST['name'];
$description = $_POST['description'];
$category = $_POST['category'];

$image_url = "";

if(isset($_FILES['image']) && $_FILES['image']['error'] == 0)
{
    $filename = time() . "_" . $_FILES['image']['name'];

    move_uploaded_file(
        $_FILES['image']['tmp_name'],
        "uploads/" . $filename
    );

    $image_url = "uploads/" . $filename;
}

$stmt = $pdo->prepare("
    INSERT INTO items
    (
        collection_id,
        name,
        description,
        category,
        image_url
    )
    VALUES
    (
        ?,
        ?,
        ?,
        ?,
        ?
    )
");

$stmt->execute([
    $collection_id,
    $name,
    $description,
    $category,
    $image_url
]);

header("Location: collectable-page.php?id=" . $collection_id);
exit;