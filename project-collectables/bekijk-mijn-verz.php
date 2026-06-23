<?php

include 'db.php';

$id = $_GET['id'] ?? 1;

// collectie + eigenaar
$stmt = $pdo->prepare("
    SELECT
        c.*,
        u.name AS username,
        u.avatar_url
    FROM collections c
    JOIN users u ON c.user_id = u.id
    WHERE c.id = ?
");

$stmt->execute([$id]);

$collection = $stmt->fetch(PDO::FETCH_ASSOC);

// items
$stmt = $pdo->prepare("
    SELECT *
    FROM items
    WHERE collection_id = ?
");

$stmt->execute([$id]);

$items = $stmt->fetchAll(PDO::FETCH_ASSOC);



?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $collection['name'] ?></title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<nav class="navbar navbar-expand-lg bg-white border-bottom">
    <div class="container">

        <a class="navbar-brand" href="#">
            COLLECTABLES
        </a>

        <div class="collapse navbar-collapse">

            <ul class="navbar-nav mx-auto">

                <li class="nav-item">
                    <a class="nav-link" href="index.php">
                        HOME
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link active border-purple" href="collectable-page.php">
                        VERZAMELINGEN
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="mijn-verzamelingen.php">
                        MIJN VERZAMELINGEN
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="profile.php">
                        PROFIEL
                    </a>
                </li>

            </ul>

            <form class="d-flex">
                <input
                    class="form-control"
                    placeholder="Zoeken naar verzamelingen, items...">
            </form>
<a href="profile.php">
    <img
        src="<?= !empty($collection['avatar_url'])
            ? $collection['avatar_url']
            : '07c4720d19a9e9edad9d0e939eca304a.jpg' ?>"
        class="rounded-circle ms-3"
        width="30"
        height="30"
        alt=""
    >
</a>

        </div>

    </div>
</nav>
<div class="container py-4">


    <div class="row mt-4">

        <!-- linkerkant -->
        <div class="col-lg-8">

            <div class="card mb-4">
                <div class="card-body">

                    <div class="row">

                        <div class="col-md-4">
                            <img
                                src="<?= $collection['cover_url'] ?>"
                                class="img-fluid rounded"
                                alt="">
                        </div>

                        <div class="col-md-8">

                            <h1><?= $collection['name'] ?></h1>

                            <p>
                                door
                                <strong><?= $collection['username'] ?></strong>
                            </p>

                            <p>
                                <?= $collection['description'] ?>
                            </p>

                            <div class="row text-center mt-4">

                                <div class="col">
                                    <h4><?= count($items) ?></h4>
                                    <small>Items</small>
                                </div>

                                <div class="col">
                                    <h4>15</h4>
                                    <small>Volgers</small>
                                </div>

                                <div class="col">
                                    <h4>2025</h4>
                                    <small>Bijgewerkt</small>
                                </div>

                            </div>

                        </div>

                    </div>

                </div>
            </div>

            <div class="card">

                <div class="card-header">
                    <h4 class="mb-0">Items</h4>
                </div>

                <div class="card-body">

                    <div class="row">

                        <?php foreach($items as $item): ?>

                        <div class="col-md-4 mb-4">

                            <div class="card h-100">

                                <img
                                    src="<?= $item['image_url'] ?>"
                                    class="card-img-top"
                                    alt="">

                                <div class="card-body">

                                    <h5>
                                        <?= $item['name'] ?>
                                    </h5>

                                    <p>
                                        <?= $item['description'] ?>
                                    </p>

                                    <span class="badge bg-primary">
                                        <?= $item['category'] ?>
                                    </span>

                                </div>

                            </div>

                        </div>

                        <?php endforeach; ?>

                    </div>

                </div>

            </div>

        </div>

        <!-- rechterkant -->
        <div class="col-lg-4">

            <div class="card">

                <div class="card-body">

                    <h5>Categorie</h5>

                    <p>
                        Trading Cards
                    </p>

                    <hr>

                    <h5>Beschrijving</h5>

                    <p>
                        <?= $collection['description'] ?>
                    </p>

                    <hr>

                    <h5>Eigenaar</h5>

                    <p>
                        <?= $collection['username'] ?>
                    </p>

                </div>

            </div>

        </div>

    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>