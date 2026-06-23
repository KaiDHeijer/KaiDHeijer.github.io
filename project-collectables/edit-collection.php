<?php

include 'db.php';

$id = $_GET['id'];

$stmt = $pdo->prepare("
    SELECT *
    FROM collections
    WHERE id = ?
");

$stmt->execute([$id]);

$collection = $stmt->fetch(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="nl">
<head>

    <meta charset="UTF-8">

    <title>Verzameling bewerken</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">

</head>
<body>

<div class="container mt-5">

    <div class="row justify-content-center">

        <div class="col-md-6">

            <div class="card">

                <div class="card-header">
                    <h3>Verzameling bewerken</h3>
                </div>

                <div class="card-body">

                    <form
                        action="update-collection.php"
                        method="POST">

                        <input
                            type="hidden"
                            name="id"
                            value="<?= $collection['id'] ?>">

                        <div class="mb-3">

                            <label class="form-label">
                                Naam
                            </label>

                            <input
                                type="text"
                                name="name"
                                class="form-control"
                                value="<?= $collection['name'] ?>">

                        </div>

                        <div class="mb-3">

                            <label class="form-label">
                                Beschrijving
                            </label>

                            <textarea
                                name="description"
                                class="form-control"><?= $collection['description'] ?></textarea>

                        </div>

                        <button
                            type="submit"
                            class="btn btn-primary">

                            Opslaan

                        </button>

                    </form>

                </div>

            </div>

        </div>

    </div>

</div>

</body>
</html>