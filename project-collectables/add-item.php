<?php

$collection_id = $_GET['collection_id'];

?>

<!DOCTYPE html>
<html lang="nl">
<head>

    <meta charset="UTF-8">

    <title>Item toevoegen</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">

</head>
<body>

<div class="container mt-5">

    <div class="row justify-content-center">

        <div class="col-md-6">

            <div class="card">

                <div class="card-header">
                    <h3>Nieuw Item</h3>
                </div>

                <div class="card-body">

                    <form
                        action="save-item.php"
                        method="POST"
                        enctype="multipart/form-data">

                        <input
                            type="hidden"
                            name="collection_id"
                            value="<?= $collection_id ?>">

                        <div class="mb-3">

                            <label class="form-label">
                                Naam
                            </label>

                            <input
                                type="text"
                                name="name"
                                class="form-control"
                                required>

                        </div>

                        <div class="mb-3">

                            <label class="form-label">
                                Beschrijving
                            </label>

                            <textarea
                                name="description"
                                class="form-control"></textarea>

                        </div>

                        <div class="mb-3">

                            <label class="form-label">
                                Categorie
                            </label>

                            <input
                                type="text"
                                name="category"
                                class="form-control">

                        </div>

                        <div class="mb-3">

                            <label class="form-label">
                                Afbeelding
                            </label>

                            <input
                                type="file"
                                name="image"
                                class="form-control">

                        </div>

                        <button
                            type="submit"
                            class="btn btn-primary">

                            Item toevoegen

                        </button>

                    </form>

                </div>

            </div>

        </div>

    </div>

</div>

</body>
</html>