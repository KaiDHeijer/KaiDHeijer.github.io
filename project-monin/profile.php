<?php
session_start();
require 'db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

if (isset($_GET['id'])) {
    $user_id = $_GET['id'];
} else {
    $user_id = $_SESSION['user_id'];
}


$query = $db->prepare("SELECT * FROM users WHERE id = ?");
$query->execute([$user_id]);
$users = $query->fetch(PDO::FETCH_ASSOC);
$postQuery = $db->prepare("SELECT * FROM posts WHERE user_id = ?");
$postQuery->execute([$user_id]);
$post = $postQuery->fetchAll(PDO::FETCH_ASSOC);
?>


<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LinkedPro</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>


<nav class="navbar navbar-dark bg-primary">
    <div class="container">
        <a class="navbar-brand fw-bold d-flex align-items-center" href="#">
            <img src="img/images (3).png" width="30" class="me-2">
            LinkedPro
        </a>

        <div>
            <a class="text-white-50 me-3 text-decoration-none" href="index.php">
                <img src="img/images (5).png" width="30" class="me-2">
                Home
            </a>

            <a class="text-white me-3 text-decoration-none" href="profile.php">
                <img src="img/images (4).png" width="30" class="me-2">
                Profile
            </a>

            <a class="text-white-50 text-decoration-none" href="login.php">
                <img src="img/logout-icon-linear-logo-mark-in-black-and-white-vector.jpg" width="30" class="me-2">
                Logout
            </a>
        </div>
    </div>
</nav>


<div class="container mt-5">
    <div class="rounded-3 border border-black">


        <div class="bg-primary position-relative py-5 rounded-top">
        <img src="<?php echo $users['avatar']; ?>"
                 class="rounded-circle border border-5 border-white position-absolute top-100 start-0 translate-middle ms-4"
                 width="110">
        </div>


        <div class="px-3 pt-5 pb-3">

            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <h4 class="mb-0"> <?php echo $users['name'] ?? '' ?></h4>
                    <small class="text-muted"> <?php echo $users['headline'] ?? ''; ?></small>
                </div>

                <a href="edit_profile.php"> <button class="btn btn-outline-primary btn-sm">
                    Edit Profile
                    </button> </a>
            </div>

            <hr>

            <h6>About</h6>
            <p><?php echo $users['about'] ?? ''; ?></p>

        </div>
    </div>
</div>


<div class="container mt-4">
    <div class="rounded-3 border border-black">

        <div class="px-3 py-2">
            <h6 class="mb-0">🛠️ Skills</h6>
        </div>

        <hr class="mt-0">

        <div class="d-flex gap-2 flex-wrap p-2">
            <span class="badge bg-light text-primary rounded-pill px-3 py-2"><?php echo $users['skills'] ?></span>
        </div>

    </div>
</div>


<div class="container mt-4 mb-5">
    <div class="rounded-3 border border-black">

        <div class="px-3 py-2">
            <h6 class="mb-0">🔍 Interests</h6>
        </div>

        <hr class="mt-0">

        <div class="d-flex gap-2 flex-wrap p-2">
            <span class="badge bg-light text-primary rounded-pill px-3 py-2"><?php echo $users['interests'] ?></span>

        </div>

    </div>
</div>
<div class="container mt-4 mb-5">
    <h4> Berichten</h4>

    <?php foreach ($post as $post): ?>
        <div class="card p-3 mb-3">

        <p><?= $post['content']; ?></p>

        <small class="text-muted">
            <?= $post['created_at']; ?>
        </small>

        </div>
    <?php endforeach; ?>
    </div>

</body>
</html>