<?php
session_start();
require 'db.php';

$user_id = $_SESSION['user_id'];

$query = $db->prepare("SELECT * FROM users WHERE id = ?");
$query->execute([$user_id]);
$user = $query->fetch(PDO::FETCH_ASSOC);

if (isset($_POST['save'])) {
    $name = $_POST['name'];
    $headline = $_POST['headline'];
    $about = $_POST['about'];
    $skills = $_POST['skills'];
    $interests = $_POST['interests'];

    $query = $db->prepare("
        UPDATE users
        SET
            name = ?,
            headline = ?,
            about = ?,
            skills = ?,
            interests = ?
        WHERE id = ?
        ");

        $query->execute([
            $name,
            $headline,
            $about,
            $skills,
            $interests,
            $user_id
        ]);
        header("Location: profile.php");
        exit;
}

?>




<form method="POST">

    <div class="mb-3">
        <label class="form-label">Naam</label>
        <input type="text"
               class="form-control"
               name="name"
               value="<?= $user['name'] ?>"
               placeholder="Vul je naam in">
    </div>

    <div class="mb-3">
        <label class="form-label">Headline</label>
        <input type="text"
               class="form-control"
               name="headline"
               value="<?= $user['headline'] ?>"
               placeholder="Bijvoorbeeld: Software Developer">
    </div>

    <div class="mb-3">
        <label class="form-label">Bio</label>
        <textarea class="form-control"
                  name="about"
                  rows="4"
                  placeholder="Vertel iets over jezelf"><?= $user['about'] ?></textarea>
    </div>

    <div class="mb-3">
        <label class="form-label">Skills</label>
        <input type="text"
               class="form-control"
               name="skills"
               value="<?= $user['skills'] ?>"
               placeholder="Bijvoorbeeld: PHP, HTML, CSS">
    </div>

    <div class="mb-3">
        <label class="form-label">Interesses</label>
        <input type="text"
               class="form-control"
               name="interests"
               value="<?= $user['interests'] ?>"
               placeholder="Bijvoorbeeld: Fitness, Gamen">
    </div>

    <button type="submit" name="save" class="btn btn-primary">
        Profiel opslaan
    </button>

</form>