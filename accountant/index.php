<?php 
session_start();
$logged_user = $_SESSION['accountant'];
if(is_null($logged_user)){
    header("location: ../index.php");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1><?php echo $logged_user; ?></h1>
    <a href="../logout.php">Logout</a>
</body>
</html>