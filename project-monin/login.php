<?php
session_start();
$errors = [];
if (isset($_POST['submit'])){

    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $password = '';

    if (empty($email)){
        $errors['email'] = "Vul een post in";
    }

    if (empty($_POST['password'])){
        $errors['password'] = "Vul je wachtwoord in";
    } else{
        $password = $_POST['password'];
    }

    if (empty($errors)){
        include 'db.php';
        global $db;

        $query = $db->prepare("SELECT * FROM users WHERE email = '$email' AND password = '$password'");
        $query->execute();
        $user = $query->fetch(PDO::FETCH_ASSOC);
        if (empty($user)){
            $errors['login'] = "Je gegevens kloppen niet";
        }else{
            $_SESSION['user'] = $user;
            $_SESSION['user_id'] = $user['id'];

            header("Location: index.php");
            exit;
        }


    }

}

?>




<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bootstrap demo</title>
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
                  <a class="nav-link text-white" href="Login.php"> <img src="img/logout-icon-linear-logo-mark-in-black-and-white-vector.jpg" width="30"> Login </a>
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
              <h1> LinkedPro </h1>
          </div>
      </div>

      <div class="row">
          <div class="col">
              <p> Welcome back! </p>
          </div>
      </div>
      <form action="login.php" method="POST">
          <div class="row">
              <div class="col">
                  <div class="form-floating mb-3">
                      <input type="email" class="form-control" name="email" id="floatingInput" placeholder="name@example.com">
                      <?php if(isset($errors['email'])): ?>
                          <div class="text-danger">
                              <?= $errors['email']; ?>
                          </div>
                      <?php endif; ?>
                      <label for="floatingInput">Email address</label>
                  </div>
              </div>
          </div>
          <div class="row">
              <div class="col">
                  <div class="form-floating mb-3">
                      <input type="password" class="form-control" name="password" id="floatingPassword" placeholder="Password">
                      <?php if(isset($errors['password'])): ?>
                          <div class="text-danger">
                              <?= $errors['password']; ?>
                          </div>
                      <?php endif; ?>
                      <label for="floatingPassword">Password</label>
                  </div>
              </div>
          </div>
          <div class="d-grid gap-2 col-6 mx-auto mt-3">
              <button class="btn btn-primary" type="submit" name="submit" >Login</button>
              <?php if(isset($errors['login'])): ?>
                  <div class="text-danger mt-2">
                      <?= $errors['login']; ?>
                  </div>
              <?php endif; ?>
          </div>
      </form>
      <div class="row">
          <div class="col">
              <p> Heb je geen account? <a href="Register.php">Register</a> </p>
          </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
  </body>
</html>
