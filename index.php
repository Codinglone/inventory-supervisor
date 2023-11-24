<?php
include './utils/link.php';
session_start();

if (isset($_POST['login'])) {
    $email = $_POST['email'];
    $pass = $_POST['password'];
    $user_sel = $link->query("SELECT * FROM users WHERE email='$email' AND password='$pass'");
    $user_row = mysqli_fetch_array($user_sel);
    if ($user_row['role'] == "accountant") {
        $_SESSION['accountant'] = $user_row['email'];
        header("location: ./accountant/index.php");
    } else if ($user_row['role'] == "manager") {
        header("location: ./manager/index.php");
    } else if ($user_row['role'] == "cyber") {
        $_SESSION['cyber'] = $user_row['email'];
        header("location: ./cyber/index.php");
    } else if ($user_row['role'] == "supermarket") {
        $_SESSION['supermarket'] = $user_row['email'];
        header("location: ./supermarket/index.php");
    } else if ($user_row['role'] == "sauna-massage") {
        header("location: ./sauna-massage/index.php");
    } else if ($user_row['role'] == "restaurent") {
        $_SESSION['restaurent'] = $user_row['email'];
        header("location: ./restaurent/index.php");
    } else if ($user_row['role'] == "reception") {
        $_SESSION['reception'] = $user_row['email'];
        header("location: ./reception/index.php");
    } else if ($user_row['role'] == "technician") {
        header("location: ./IT/index.php");
    } else {
        echo "<script>alert('Invalid credentials! Try again...')</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventory Supervisor</title>
    <link rel="stylesheet" href="./bootstrap-5.2.3-dist/css/bootstrap.min.css">
    <link rel="shortcut icon" href="./assets/logo.png" type="image/x-icon">
</head>

<body>
    <main class="container">
        <div class="row d-flex justify-content-center" style="margin:20vh 0;">
            <div class="col-lg-8 col-sm-12 col-md-12 p-4"
                style="box-shadow: rgba(100, 100, 111, 0.2) 0px 7px 29px 0px; background: white;">
                <div class="d-flex justify-content-center col-4" id="brand">
                    <img src="./assets/logo.png" class="img-fluid" alt="logo">
                </div>
                <div class="text-center text-primary">
                    <h1 class="d-1">Login</h1>
                </div>
                <form method="POST">
                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">Email address</label>
                        <input type="email" name="email" class="form-control" id="exampleInputEmail1" required
                            aria-describedby="emailHelp">
                    </div>
                    <div class="mb-3">
                        <label for="exampleInputPassword1" class="form-label">Password</label>
                        <input type="password" name="password" class="form-control" required id="exampleInputPassword1">
                    </div>
                    <button type="submit" name="login" class="btn btn-primary">Login</button>
                </form>
            </div>
        </div>
    </main>
</body>

</html>