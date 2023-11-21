<?php 
include './utils/link.php';
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
            <div class="col-lg-8 col-sm-12 col-md-12 p-4" style="box-shadow: rgba(100, 100, 111, 0.2) 0px 7px 29px 0px; background: white;">
                <div class="d-flex justify-content-center col-4" id="brand">
                    <img src="./assets/logo.png" class="img-fluid" alt="logo">
                </div>
                <div class="text-center">
                    <h1 class="d-1">Login</h1>
                </div>
                <form method="POST">
                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">Email address</label>
                        <input type="email" class="form-control" id="exampleInputEmail1" required aria-describedby="emailHelp">
                    </div>
  <div class="mb-3">
    <label for="exampleInputPassword1" class="form-label">Password</label>
    <input type="password" class="form-control" required id="exampleInputPassword1">
  </div>
  <button type="submit" class="btn btn-primary">Login</button>
</form>
    </div>
        </div>
    </main>
</body>
</html>