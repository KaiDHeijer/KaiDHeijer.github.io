<?php
session_start();

if(!isset($_SESSION['user_id']))
{
    header("Location: login.php");
    exit;
}

include 'db.php';

$stmt = $pdo->query("
    SELECT id, name
    FROM collections
    ORDER BY name
");

$collections = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="nl">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Verzameling verwijderen</title>

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css"
        rel="stylesheet">

</head>

<body class="bg-light">

<div class="container py-5">

    <div class="row justify-content-center">

        <div class="col-md-6">

            <div class="card shadow">

                <div class="card-header">

                    <h3 class="mb-0">
                        Verzameling verwijderen
                    </h3>

                </div>

                <div class="card-body">

                    <form
                        action="delete-collection.php"
                        method="POST">

                        <div class="mb-3">

                            <label class="form-label">
                                Kies een verzameling
                            </label>

                            <select
                                name="collection_id"
                                class="form-select"
                                required>

                                <option value="">
                                    Selecteer...
                                </option>

                                <?php foreach($collections as $collection): ?>

                                    <option value="<?= $collection['id'] ?>">

                                        <?= $collection['name'] ?>

                                    </option>

                                <?php endforeach; ?>

                            </select>

                        </div>

                        <div class="form-check mb-3">

                            <input
                                type="checkbox"
                                class="form-check-input"
                                required>

                            <label class="form-check-label">

                                Ik weet zeker dat ik deze verzameling wil verwijderen

                            </label>

                        </div>

                        <button
                            class="btn btn-danger">

                            Verwijderen

                        </button>

                        <a
                            href="mijn-verzamelingen.php"
                            class="btn btn-secondary">

                            Terug

                        </a>

                    </form>

                </div>

            </div>

        </div>

    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>