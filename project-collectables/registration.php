<?php

session_start();
require_once 'db.php';
global $db;
$fout = "";
$succes = "";


if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $naam = trim($_POST['name']);
    $email = trim($_POST['email']);
    $wachtwoord = $_POST['password'];
    $wachtwoord2 = $_POST['password2'];

    if (empty($naam)) {

        $fout = "Gebruikersnaam is verplicht.";

    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {

        $fout = "Ongeldig e-mailadres.";

    } elseif (strlen($wachtwoord) < 8) {

        $fout = "Wachtwoord moet minimaal 8 tekens bevatten.";

    } elseif ($wachtwoord !== $wachtwoord2) {

        $fout = "Wachtwoorden komen niet overeen.";

    } else {

        $stmt = $db->prepare("
            SELECT id
            FROM users
            WHERE email = ?
        ");

        $stmt->execute([$email]);

        if ($stmt->fetch()) {

            $fout = "Dit e-mailadres bestaat al.";

        } else {

            $hash = password_hash(
                    $wachtwoord,
                    PASSWORD_DEFAULT
            );

            $stmt = $db->prepare("
                INSERT INTO users
                (
                    name,
                    email,
                    password
                )
                VALUES
                (
                    ?,
                    ?,
                    ?
                )
            ");

            $stmt->execute([
                    $naam,
                    $email,
                    $hash
            ]);

            $succes = "Account succesvol aangemaakt!";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Registreren</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

</head>
<body class="bg-light">
<nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow-sm">
    <div class="container">

        <a class="navbar-brand" href="index.php">Collectables</a>

        <div class="ms-auto d-flex align-items-center">

            <?php if (isset($_SESSION['user_id'])): ?>

                <span class="text-white me-3">
                    👋 Hallo, <?= htmlspecialchars($_SESSION['user_name']) ?>
                </span>

                <a href="logout.php" class="btn btn-outline-light btn-sm">
                    Uitloggen
                </a>

            <?php else: ?>

                <a href="inlog.php" class="btn btn-outline-light btn-sm me-2">
                    Inloggen
                </a>

                <a href="registration.php" class="btn btn-warning btn-sm">
                    Registreren
                </a>

            <?php endif; ?>

        </div>

    </div>
</nav>


<div class="container py-5">

    <div class="row justify-content-center">

        <div class="col-lg-5">

            <div class="card shadow">

                <div class="card-body p-4">

                    <h2 class="text-center mb-2">
                        Account aanmaken
                    </h2>

                    <p class="text-center text-muted mb-4">
                        Maak een account aan om te beginnen met verzamelen
                    </p>

                    <?php if($fout): ?>
                        <div class="alert alert-danger">
                            <?= htmlspecialchars($fout) ?>
                        </div>
                    <?php endif; ?>

                    <?php if($succes): ?>
                        <div class="alert alert-success">
                            <?= htmlspecialchars($succes) ?>
                        </div>
                    <?php endif; ?>

                    <form method="POST">

                        <div class="mb-3">
                            <label class="form-label">
                                Gebruikersnaam
                            </label>

                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="bi bi-person"></i>
                                </span>

                                <input
                                        type="text"
                                        name="name"
                                        class="form-control"
                                        required
                                >
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">
                                E-mailadres
                            </label>

                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="bi bi-envelope"></i>
                                </span>

                                <input
                                        type="email"
                                        name="email"
                                        class="form-control"
                                        required
                                >
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">
                                Wachtwoord
                            </label>

                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="bi bi-lock"></i>
                                </span>

                                <input
                                        type="password"
                                        name="password"
                                        class="form-control"
                                        required
                                >
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">
                                Bevestig wachtwoord
                            </label>

                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="bi bi-lock"></i>
                                </span>

                                <input
                                        type="password"
                                        name="password2"
                                        class="form-control"
                                        required
                                >
                            </div>
                        </div>

                        <button
                                type="submit"
                                class="btn btn-primary w-100">

                            Registreren

                        </button>

                    </form>

                    <div class="text-center mt-3">
                        Heb je al een account?
                        <a href="inlog.php">
                            Inloggen
                        </a>
                    </div>

                </div>

            </div>

        </div>

    </div>

</div>

</body>
</html>