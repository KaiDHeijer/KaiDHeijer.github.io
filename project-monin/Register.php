<?php
$name = '';
$email = '';
$errors = [];

if (isset($_POST['submit'])) {
$errors = [];
$name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
    $password = $_POST['password'];
    $confirm = $_POST['confirm'];

if (empty($name)){
$errors['name'] = "Name is required";}

if (empty($email)){
    $errors['email'] = "Email is required";
}
if (empty($errors)) {
    include 'db.php';
    global $db;
    $query = $db->prepare("INSERT INTO users (name, email, password) VALUES (:name, :email, :password)");
    $query->execute([
            ':name' => $name,
        ':email' => $email,
        ':password' => $password
    ]);
    header('Location: login.php');
    exit;
}

}
        ?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>LoginMonIn</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
</head>
<body class="bg-light">
<nav class="navbar bg-primary">
    <div class="container-fluid">
        <a class="navbar-brand text-white" href="#">
            <img src="img/images%20(3).png" alt="Logo" width="30" class="d-inline-block align-text-top">
            LinkedPro
        </a>
        <ul class="nav justify-content-end">
            <li class="nav-item">
                <a class="nav-link text-white" href="login.php"> <img src="img/logout-icon-linear-logo-mark-in-black-and-white-vector.jpg" width="30"> Login </a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-white" href="Register.php"> <img src="img/images%20(4).png" width="30"> Register</a>
            </li>

        </ul>
    </div>
</nav>
<div class="container pb-3 bg-white text-center mt-5 w-25 rounded-2">
   <div class="row">
       <div class="col">
           <img src="img/images%20(3).png" class="w-25">
       </div>
   </div>
    <div class="row">
        <div class="col">
            <h1> Join LinkedPro </h1>
        </div>
    </div>

    <div class="row">
        <div class="col">
            <p> Create your professional profile</p>
        </div>
    </div>
    <form method="post">
    <div class="row">
        <div class="col">
    <div class="form-floating mb-3">
        <input type="name" name="name" class="form-control" id="name" value="<?= $name ?>" placeholder="Full Name" required>
         <label for="name">Full Name</label>
        <p> <?= $errors['name'] ??'' ?> </p>
    </div>
        </div>
    </div>
    <div class="row">
        <div class="col">
    <div class="form-floating mb-3">
        <input type="email" name="email" class="form-control" id="email" value="<?= $email ?>" placeholder="name@example.com" required>
        <label for="email">Email address</label>
        <p> <?= $errors['email'] ?? '' ?> </p>
    </div>
        </div>
    </div>
    <div class="row">
        <div class="col">
    <div class="form-floating mb-3">
        <input type="password" name="password" class="form-control" id="password"  placeholder="Password" required>
        <label for="password">Password</label>
    </div>
        </div>
    </div>
    <div class="row">
        <div class="col">
    <div class="form-floating">
        <input type="password" name="confirm" class="form-control" id="floatingConfirm" placeholder="confirm" required>
        <label for="floatingConfirm"> Confirm password </label>
    </div>
        </div>
    </div>
    <div class="row">
        <div class="col">
    <div class="d-grid gap-2 col-6 mx-auto mt-3">
        <button name="submit" class="btn btn-primary" type="submit">Maak account aan</button>
    </div>
        </div>
    </form>
    <div class="row">
        <div class="col">
            <p> Heb je al een account? <a href="login.php">Sign in</a> </p>
    </div>

</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
</body>
</html>