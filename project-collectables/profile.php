<?php
session_start();
require_once 'db.php';
global $db;
if (!isset($_SESSION['user_id'])) {
    header('Location: inlog.php');
    exit;
}

$user_id = $_SESSION['user_id'];
$edit_mode = isset($_POST['edit_profile']);
$message = '';
$message_type = '';

// Fetch user data
$stmt = $db->prepare("SELECT id, name, email, bio FROM users WHERE id = ?");
$stmt->execute([$user_id]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

// Handle profile update
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_profile'])) {
    $name = trim($_POST['name'] ?? '');
    $bio = trim($_POST['bio'] ?? '');

    if (empty($name)) {
        $message = 'Naam mag niet leeg zijn.';
        $message_type = 'danger';
    } else {
        $stmt = $db->prepare("UPDATE users SET name = ?, bio = ? WHERE id = ?");
        if ($stmt->execute([$name, $bio, $user_id])) {
            $_SESSION['user_name'] = $name;
            $user['name'] = $name;
            $user['bio'] = $bio;
            $message = 'Profiel succesvol bijgewerkt!';
            $message_type = 'success';
        } else {
            $message = 'Er is een fout opgetreden bij het bijwerken.';
            $message_type = 'danger';
        }
    }
}


$stmt = $db->prepare("
    SELECT c.id, c.name, c.description, c.cover_url, COUNT(i.id) AS total_items
    FROM collections c
    LEFT JOIN items i ON i.collection_id = c.id
    WHERE c.user_id = ?
    GROUP BY c.id
    ORDER BY c.created_at DESC
");
$stmt->execute([$user_id]);
$collections = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Mijn Profiel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
</head>
<body class="bg-light">
<nav class="navbar navbar-expand-lg navbar-light bg-white border-bottom">
    <div class="container">
        <a class="navbar-brand" href="index.php">Collectables</a>
        <div class="ms-auto">
            <a href="logout.php" class="btn btn-outline-secondary btn-sm">Uitloggen</a>
        </div>
    </div>
</nav>

<div class="container py-5">
    <?php if (!empty($message)): ?>
        <div class="alert alert-<?= $message_type ?> alert-dismissible fade show" role="alert">
            <?= htmlspecialchars($message) ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <div class="row justify-content-center">
        <div class="col-lg-8">
            <!-- Profile Card -->
            <div class="card shadow-sm mb-4">
                <div class="card-body">
                    <?php if (!$edit_mode): ?>
                        <!-- View Mode -->
                        <div class="d-flex align-items-center gap-3 mb-4">
                            <div class="profile-icon" style="font-size: 3rem; width: 80px; height: 80px; display: flex; align-items: center; justify-content: center; background-color: #f0f0f0; border-radius: 8px;">
                                <i class="bi bi-person-fill"></i>
                            </div>
                            <div>
                                <h2 class="mb-1"><?= htmlspecialchars($user['name']) ?></h2>
                                <p class="text-muted mb-0"><?= htmlspecialchars($user['email']) ?></p>
                            </div>
                        </div>

                        <hr>

                        <h5>Bio</h5>
                        <p class="text-muted">
                            <?php if (!empty($user['bio'])): ?>
                                <?= nl2br(htmlspecialchars($user['bio'])) ?>
                            <?php else: ?>
                                <em>Geen bio ingesteld</em>
                            <?php endif; ?>
                        </p>

                        <form method="POST" class="mt-3">
                            <button type="submit" name="edit_profile" value="1" class="btn btn-primary btn-sm">
                                <i class="bi bi-pencil"></i> Profiel bewerken
                            </button>
                        </form>
                    <?php else: ?>
                        
                        <form method="POST">
                            <div class="mb-3">
                                <label for="name" class="form-label">Naam</label>
                                <input type="text" class="form-control" id="name" name="name" value="<?= htmlspecialchars($users['name']) ?>" required>
                            </div>

                            <div class="mb-3">
                                <label for="bio" class="form-label">Bio</label>
                                <textarea class="form-control" id="bio" name="bio" rows="4" placeholder="Vertel iets over jezelf..."><?= htmlspecialchars($user['bio'] ?? '') ?></textarea>
                                <small class="text-muted">Maximaal 500 karakters</small>
                            </div>

                            <div class="d-flex gap-2">
                                <button type="submit" name="update_profile" value="1" class="btn btn-success btn-sm">
                                    <i class="bi bi-check-lg"></i> Opslaan
                                </button>
                                <button type="button" class="btn btn-secondary btn-sm" onclick="location.reload()">
                                    <i class="bi bi-x-lg"></i> Annuleren
                                </button>
                            </div>
                        </form>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Collections Card -->
            <div class="card shadow-sm">
                <div class="card-header bg-white border-bottom">
                    <h5 class="mb-0">Mijn Collecties (<?= count($collections) ?>)</h5>
                </div>
                <div class="card-body">
                    <?php if (count($collections) > 0): ?>
                        <div class="row g-3">
                            <?php foreach ($collections as $collection): ?>
                                <div class="col-md-6">
                                    <div class="card h-100 border">
                                        <?php if (!empty($collection['cover_url'])): ?>
                                            <img src="<?= htmlspecialchars($collection['cover_url']) ?>" class="card-img-top" alt="<?= htmlspecialchars($collection['name']) ?>">
                                        <?php else: ?>
                                            <div class="card-img-top bg-secondary text-white d-flex align-items-center justify-content-center" style="height: 150px;">
                                                <i class="bi bi-collection" style="font-size: 2rem;"></i>
                                            </div>
                                        <?php endif; ?>
                                        <div class="card-body">
                                            <h6 class="card-title"><?= htmlspecialchars($collection['name']) ?></h6>
                                            <?php if (!empty($collection['description'])): ?>
                                                <p class="card-text small text-muted"><?= htmlspecialchars(substr($collection['description'], 0, 80)) ?>...</p>
                                            <?php endif; ?>
                                            <p class="card-text small"><strong><?= $collection['total_items'] ?></strong> items</p>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php else: ?>
                        <p class="text-muted text-center py-4">
                            Je hebt nog geen collecties. <a href="index.php">Maak er nu een!</a>
                        </p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
