<?php
session_start();
require_once 'db.php';
global $db;

$fout = "";

if (isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $email = trim($_POST['email']);
    $password = $_POST['password'];

    $query = $db->prepare("SELECT * FROM users WHERE email = ?");
    $query->execute([$email]);
    $user = $query->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user['password'])) {

        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_name'] = $user['name'];
        $_SESSION['user_email'] = $user['email'];

        header("Location: index.php");
        exit;

    } else {
        $fout = "Email of wachtwoord is onjuist.";
    }
}
?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Inloggen</title>

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

                    <h2 class="text-center mb-2">Welkom terug</h2>
                    <p class="text-center text-muted mb-4">Log in op je account</p>

                    <?php if($fout): ?>
                        <div class="alert alert-danger">
                            <?= htmlspecialchars($fout) ?>
                        </div>
                    <?php endif; ?>

                    <form method="POST">

                        <div class="mb-3">
                            <label class="form-label">E-mailadres</label>
                            <input type="email" name="email" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Wachtwoord</label>
                            <input type="password" name="password" class="form-control" required>
                        </div>

                        <button class="btn btn-primary w-100" type="submit">
                            Inloggen
                        </button>

                    </form>

                </div>
            </div>

        </div>
    </div>

</div>

</body>
</html>