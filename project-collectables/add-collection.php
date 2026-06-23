<?php 
include 'db.php'; 
?>

<!DOCTYPE html>
<html>

<head>
    <title>Nieuwe verzameling</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>

    <div class="container mt-5">

        <h1>Nieuwe verzameling</h1>

        <form
    action="save-collection.php"
    method="POST"
    enctype="multipart/form-data">

    <div class="mb-3">

        <label class="form-label">
            Naam
        </label>

        <input
            type="text"
            name="name"
            class="form-control">

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
            Cover afbeelding
        </label>

        <input
            type="file"
            name="cover"
            class="form-control"
            accept="image/*">

    </div>

    <button
        type="submit"
        class="btn btn-primary">

        Opslaan

    </button>

</form>

    </div>

</body>

</html>