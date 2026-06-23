<?php

include 'db.php';

$userId = 1;

// collecties ophalen
$query = $pdo->prepare("
    SELECT c.*,
           COUNT(i.id) as item_count
    FROM collections c
    LEFT JOIN items i
        ON c.id = i.collection_id
    WHERE c.user_id = ?
    GROUP BY c.id
");

$query->execute([$userId]);

$collections = $query->fetchAll(PDO::FETCH_ASSOC);

// statistieken
$totalCollections = count($collections);

$totalItems = 0;

foreach ($collections as $collection) {
    $totalItems += $collection['item_count'];
}

?>

<!DOCTYPE html>
<html lang="nl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mijn Verzamelingen</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">

</head>

<body class="bg-light">

    <nav class="navbar navbar-expand-lg bg-white border-bottom">

        <div class="container">

            <a class="navbar-brand fw-bold" href="index.php">
                COLLECTABLES
            </a>

            <ul class="navbar-nav mx-auto">

                <li class="nav-item">
                    <a class="nav-link" href="index.php">
                        HOME
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="collectable-page.php">
                        VERZAMELINGEN
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link active" href="mijn-verzamelingen.php">
                        MIJN VERZAMELINGEN
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="#">
                        PROFIEL
                    </a>
                </li>

            </ul>

            <div class="d-flex align-items-center gap-3">

                <input type="text" class="form-control" placeholder="Zoek naar verzamelingen">

                <img src="07c4720d19a9e9edad9d0e939eca304a.jpg" class="rounded-circle cursor-pointer" width="40"
                    height="40" alt="">

            </div>

        </div>

    </nav>

    <div class="container py-5">

        <div class="row mb-4">

            <div class="col-md-8">

                <h1 class="fw-bold">
                    Mijn Verzamelingen
                </h1>

                <p class="text-muted">
                    Beheer en organiseer al jouw collecties op één plek.
                </p>

            </div>

            <div class="col-md-4 text-end">

                <a href="add-collection.php" class="btn btn-primary btn-lg">

                    + Nieuwe Verzameling

                </a>

            </div>

        </div>

        <div class="row">

            <div class="col-lg-9">

                <div class="card">

                    <div class="card-header bg-white">

                        <h5 class="mb-0">
                            Overzicht
                        </h5>

                    </div>

                    <div class="card-body">

                        <div class="row">

                            <?php foreach ($collections as $collection): ?>

                                <div class="col-md-6 col-lg-4 mb-4">

                                    <div class="card h-100 shadow-sm">

                                        <img src="<?= $collection['cover_url'] ?>" class="card-img-top"
                                            alt="Cover of collection">

                                        <div class="card-body">

                                            <h5>
                                                <?= $collection['name'] ?>
                                            </h5>

                                            <p class="text-muted small">

                                                <?= $collection['item_count'] ?>

                                                items

                                            </p>

                                            <p class="small text-muted">

                                                <?= $collection['description'] ?>

                                            </p>

                                        </div>

                                        <div class="card-footer bg-white border-0">

                                            <a href="collectable-page.php?id=<?= $collection['id'] ?>"
                                                class="btn btn-outline-primary w-100">

                                                Bekijken

                                            </a>

                                        </div>

                                    </div>

                                </div>

                            <?php endforeach; ?>

                            <!-- nieuwe collectie -->

                            <div class="col-md-6 col-lg-4 mb-4">

                                <div class="card h-100 border-primary">

                                    <div
                                        class="card-body d-flex flex-column justify-content-center align-items-center text-center">

                                        <h1>+</h1>

                                        <h5>
                                            Nieuwe verzameling
                                        </h5>

                                        <a href="add-collection.php" class="btn btn-primary btn-lg">

                                            <p class="text-muted"> Maak een nieuwe verzameling aan</p>

                                        </a>


                                    </div>

                                </div>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

            <div class="col-lg-3">

                <div class="card">

                    <div class="card-body">

                        <h5>
                            Statistieken
                        </h5>

                        <hr>

                        <p>
                            <strong>
                                <?= $totalCollections ?>
                            </strong>

                            Verzamelingen
                        </p>

                        <p>
                            <strong>
                                <?= $totalItems ?>
                            </strong>

                            Items
                        </p>

                        <hr>

                        <h5>
                            Snelle acties
                        </h5>

                        <div class="d-grid gap-2">

                            <a href="add-item.php?collection_id=<?= $collection['id'] ?>"
                                class="btn btn-outline-primary">

                                Item toevoegen

                            </a>

                            <a href="edit-collection.php?id=<?= $collection['id'] ?>" class="btn btn-outline-primary">

                                Verzameling bewerken

                            </a>

                            <a href="popup.php" class="btn btn-outline-danger">

                                Verzameling verwijderen

                            </a>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

    <footer class="bg-dark text-white mt-5 py-5">

        <div class="container">

            <div class="row">

                <div class="col-md-4">

                    <h5>COLLECTABLES</h5>

                    <p>
                        Dé plek voor verzamelaars om hun collecties te delen.
                    </p>

                </div>

                <div class="col-md-4">

                    <h5>Navigatie</h5>

                    <ul class="list-unstyled">
                        <li>Home</li>
                        <li>Verzamelingen</li>
                        <li>Mijn Verzamelingen</li>
                    </ul>

                </div>

                <div class="col-md-4">

                    <h5>Informatie</h5>

                    <ul class="list-unstyled">
                        <li>FAQ</li>
                        <li>Privacy</li>
                        <li>Contact</li>
                    </ul>

                </div>

            </div>

        </div>

    </footer>

</body>

</html>