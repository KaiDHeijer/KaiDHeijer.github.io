<?php
session_start();

if(!isset($_SESSION['user_id']))
{
    header("Location: login.php");
    exit;
}

include 'db.php';

if(isset($_POST['collection_id']))
{
    $id = $_POST['collection_id'];

    $query = $pdo->prepare("
        DELETE FROM collections
        WHERE id = ?
    ");

    $query->execute([$id]);
}

header("Location: mijn-verzamelingen.php");
exit;