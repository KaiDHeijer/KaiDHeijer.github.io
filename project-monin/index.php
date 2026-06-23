<?php
session_start();
include "db.php";
global $db;
session_start();

if (isset($_GET['delete'])) {

$id = $_GET['delete'];

$query = $db->prepare("DELETE FROM posts WHERE id = ? AND user_id = ?");
$query ->execute([$id, $_SESSION['user_id']]);

header("location: index.php");
exit;
}
$query = $db->prepare("SELECT * FROM posts");
$query->execute();
$posts = $query->fetchAll(PDO::FETCH_ASSOC);
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Linkdin Project - Kai & Jesse</title>
</head>
<body>
<nav class="navbar navbar-dark bg-primary">
    <div class="container">
        <a class="navbar-brand fw-bold d-flex align-items-center" href="#">
            <img src="img/images (3).png" class="rounded me-2" alt="logo" width="30" height="30">
            LinkedPro
        </a>

        <div>
            <a class="text-decoration-none text-white-50 me-3" href="index.php">
                <img src="img/images%20(5).png" alt="logo" width="20" height="20" class="me-1">
                Home
            </a>

            <a class="text-decoration-none text-white-50 me-3" href="profile.php">
                <img src="img/images (4).png" alt="logo" width="20" height="20" class="me-1">
                Profile
            </a>

            <a class="text-decoration-none text-white-50" href="login.php">
                <img src="img/logout-icon-linear-logo-mark-in-black-and-white-vector.jpg" alt="logo" width="20" height="20" class="me-1">
                Logout
            </a>
        </div>
    </div>
</nav>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-6">
            <div class="card p-3">
                <form method="POST">
                    <input type="text" name="post" class="form-control" id="text" placeholder="What's on your mind?">
                    <div class="d-flex justify-content-end">
                        <input type="submit" name="submit" class="btn btn-primary m-1" value="Post">
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php
$errors = [];
if (isset($_POST['submit'])) {
    $post = filter_input(INPUT_POST, 'post', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

    if (empty($post)) {
        $errors['post'] = "Vul een post in";
    }

    if (empty($errors)) {
        $query = $db->prepare("INSERT INTO posts (content, user_id) VALUES (?, ?)");
        $query->execute([$post, $_SESSION['user_id']]);
        header("Location: index.php");
        exit;
    }
}
?>

<div class="row mt-5 justify-content-center">
    <div class="col-6">
        <h5 class="fs-4 text-left">Recent Posts</h5>
    </div>
</div>

<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-6">
            <?php 
            function timeAgo($datetime) {
                $time = time() - strtotime($datetime);

                if ($time < 60) {
                    return $time . "seconden geleden";
                } elseif ($time < 3600) {
                    return floor($time/60) . "Minuten geleden";
                } elseif ($time < 86400) {
                    return floor($time/3600) . "Uren geleden";
                } else {
                    return floor($time/86400) . "Dagen geleden";
                }

            }
            ?>
            <?php foreach ($posts as $post): ?>
                <div class="card p-3 mb-3 shadow-sm">
                    <div class="d-flex align-items-start mb-2">
                        <img
                                class="me-3 rounded-circle"
                                src="<?= !empty($post['avatar']) ? 'img/' . htmlspecialchars($post['avatar']) : 'img/default-avatar.png' ?>"
                                alt="Profielfoto"
                                width="55"
                                height="55"
                                style="object-fit: cover;"
                        >

                    <div class="d-flex align-items-center mb-2">
                        <a href="profile.php?id=<?= $post['user_id'] ?>">
                        <img src="img" width="50" class="me-2 rounded-circle">
                        </a>
                        
                        <a href="profile.php?id=<?= $post['user_id'] ?>" class="text-decoration-none text dark">
                            <strong>User <?= $post["user_id"] ?></strong>
                        </a>
                    </div>

                    <p><?= $post["content"] ?></p>

                    <small class="text-muted">
                        <?= timeAgo($post["created_at"])?>
                    </small>
                    <?php if ($_SESSION['user_id'] == $post['user_id']): ?>
                        <a href="index.php?delete=<?= $post['id'] ?>"class=btn btn-danger btn-sm">
                        Verwijderen
                    </a>
                    <?php endif; ?>

                </div>
            <?php endforeach; ?>

        </div>
    </div>
</div>

<div class="container text-center bg-primary mt-5 text-light">
    <div class="row align-items-center">
        <div class="col">
            <p>&copy; Gymratten (Kai & Jesse)</p>
        </div>
    </div>
</div>

</body>
</html>