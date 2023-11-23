<?php
session_start();
include '../utils/link.php';
$logged_user = $_SESSION['accountant'];
if (is_null($logged_user)) {
  header("location: ../index.php");
}


?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Stock MIS Dashboard</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
  <style>
    body {
      padding-top: 56px;
      padding-left: 250px;
      background-color: #f8f9fa;
    }

    .top-bar {
      background: linear-gradient(to right, #007bff, #0056b3);
      color: white;
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      padding: 10px;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    .sidebar {
      background: linear-gradient(to right, #007bff, #0056b3);
      color: white;
      position: fixed;
      top: 56px;
      left: 0;
      height: 100vh;
      width: 250px;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
      margin-bottom: 20px;
    }

    main {
      display: flex;
      justify-content: center;
    }

    .content {
      padding: 20px;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
      background-color: white;
    }

    /* Other color styles */
    .nav-link {
      color: white;
      transition: color 0.3s;
    }

    .nav-link:hover {
      color: white !important;
    }

    .nav-link.active {
      background-color: #0056b3;
      border-radius: 5px;
    }
  </style>
</head>

<body>

  <div class="top-bar" style="position: fixed;top:0;width:100%;z-index: 100;">
    <div class="container">
      <div class="d-flex justify-content-between align-items-center">
        <div class="bg-white px-2" style="border-radius: 10px;">
          <img src="../assets/logo.png" class="img-fluid" style="width: 100px;height:50px;" alt="">
        </div>
        <span>Welcome, <strong>
            <?php echo $logged_user; ?>
          </strong></span>
        <a href="../logout.php" class="btn btn-danger">Logout</a>
      </div>
    </div>
  </div>

  <div class="container-fluid" style="margin-top:56px;">
    <div class="row">
      <nav class="col-md-2 d-none d-md-block sidebar"
        style="position: fixed; left:0;height:100vh;overflow:hidden;margin-top:14px;">
        <div class="sidebar-sticky">
          <ul class="nav flex-column">
            <li class="nav-item">
              <a class="nav-link text-white" id="cyberTab" data-bs-toggle="tab" href="#cyberProducts"><i
                  class="fas fa-laptop"></i> Cyber Products</a>
            </li>
            <li class="nav-item">
              <a class="nav-link text-white" id="restaurantTab" data-bs-toggle="tab" href="#restaurantProducts"><i
                  class="fas fa-utensils"></i> Restaurant Products</a>
            </li>
            <li class="nav-item">
              <a class="nav-link text-white" id="supermarketTab" data-bs-toggle="tab" href="#supermarketProducts"><i
                  class="fas fa-cart-plus"></i> Supermarket Products</a>
            </li>
            <li class="nav-item">
              <a class="nav-link active text-white" id="cyberViewTab" data-bs-toggle="tab" href="#cyberView"><i
                  class="fas fa-eye"></i>View Cyber</a>
            </li>
            <li class="nav-item">
              <a class="nav-link text-white" id="restaurentViewTab" data-bs-toggle="tab" href="#restaurentView"><i
                  class="fas fa-eye"></i>View Restaurent</a>
            </li>
            <li class="nav-item">
              <a class="nav-link text-white" id="supermarketViewTab" data-bs-toggle="tab" href="#supermarketView"><i
                  class="fas fa-eye"></i>View Supermarket</a>
            </li>
            <!-- Add more tabs as needed -->
          </ul>
        </div>
      </nav>

      <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-md-4 d-flex justify-center">
        <div class="tab-content">
          <div class="tab-pane fade active show" id="cyberView">
            <!-- Content for Cyber Products tab -->
            <h3 class="mb-4">Update Cyber Product</h3>
            <?php 
            if(isset($_GET['id'])){
                $id = $_GET['id'];
                $sql = "SELECT * FROM cyber_products WHERE id = '$id'";
                $result = $link->query($sql);
                $row = mysqli_fetch_array($result);

                if(isset($_POST['updateCyberProduct'])){
                    $product_update = $link->query("UPDATE cyber_products SET product_name = '$_POST[productNameCyber]', price_per_unit = '$_POST[unitPriceCyber]', quantity = '$_POST[quantityCyber]' WHERE id = '$id'");
                    if($product_update){
                        echo "<script>window.location.replace('index.php')</script>";
                    }else{
                        echo "<script>alert('Failed to update product')</script>";
                }
            }
            
            ?>
            <div class="card p-3" style="width: 800px;">
              <form method="POST">
                <div class="mb-3">
                  <label for="productNameCyber" class="form-label">Product Name</label>
                  <input type="text" class="form-control" value="<?php echo $row['product_name'] ?>" id="productNameCyber" name="productNameCyber" required>
                </div>
                <div class="mb-3">
                  <label for="unitPriceCyber" class="form-label">Unit Price in RWF</label>
                  <input type="number" class="form-control"  value="<?php echo $row['price_per_unit'] ?>" id="unitPriceCyber" name="unitPriceCyber" required>
                </div>
                <div class="mb-3">
                  <label for="quantityCyber" class="form-label">Quantity</label>
                  <input type="number" class="form-control"value="<?php echo $row['quantity'] ?>" id="quantityCyber" name="quantityCyber" required>
                </div>
                <button type="submit" name="updateCyberProduct" class="btn btn-primary">Update Product</button>
              </form>
            </div>
            <?php } ?>
          </div>

          <!-- Add more tab panes as needed for additional functionality -->
        </div>
      </main>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>

</body>

</html>