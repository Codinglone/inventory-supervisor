<?php 
session_start();
include '../utils/link.php';
$logged_user = $_SESSION['accountant'];
if(is_null($logged_user)){
    header("location: ../index.php");
}

if(isset($_POST['addCyberProduct'])) {

    // Validate inputs
    $cyber_product_name = trim($_POST['productNameCyber']);
    $cyber_unit_price = filter_var($_POST['unitPriceCyber'], FILTER_VALIDATE_FLOAT);
    $cyber_quantity = filter_var($_POST['quantityCyber'], FILTER_VALIDATE_INT);
  
    if(empty($cyber_product_name) || !$cyber_unit_price || !$cyber_quantity) {
      $error = 'Invalid product data';
    } else {
  
      // Insert with prepared statement 
      $stmt = $link->prepare("INSERT INTO cyber_products(product_name, quantity, price_per_unit) VALUES(?, ?, ?)");
      
      $stmt->bind_param("sid", $cyber_product_name, $cyber_quantity, $cyber_unit_price);
      
      if(!$stmt->execute()) {
        $error = $stmt->error; 
      } else {
        echo "<script>alert('Product added successfully!')</script>";
      } 
    }
    
    // Check for errors
    if(isset($error)) {
      echo "Error adding product: " . $error;
    }
  
  }

  if(isset($_POST['addRestaurentProduct'])){
    $restaurent_product_name = trim($_POST['productNameRestaurant']);
    $restaurent_unit_price = filter_var($_POST['unitPriceRestaurant'], FILTER_VALIDATE_FLOAT);
    if(empty($restaurent_product_name) || !$restaurent_unit_price){
        $error = "Invalid product data";
    }
    else {
        $stmt = $link->prepare("INSERT INTO restaurent_products(product_name, price) VALUES(?, ?)");
        $stmt->bind_param("sd", $restaurent_product_name, $restaurent_unit_price);
        if(!$stmt->execute()){
            $error = $stmt->error;
        }
        else {
            echo "<script>alert('Product added successfully!')</script>";
        }
    }
    // Check for errors
    if(isset($error)) {
        echo "<script>alert('Error adding product. $error')</script>";
      }
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
    <span>Welcome, <strong><?php echo $logged_user; ?></strong></span>
      <a href="../logout.php" class="btn btn-danger">Logout</a>
    </div>
  </div>
</div>

<div class="container-fluid" style="margin-top:56px;">
  <div class="row">
    <nav class="col-md-2 d-none d-md-block sidebar" style="position: fixed; left:0;height:100vh;overflow:hidden;margin-top:14px;">
      <div class="sidebar-sticky">
        <ul class="nav flex-column">
          <li class="nav-item">
            <a class="nav-link active text-white" id="cyberTab" data-bs-toggle="tab" href="#cyberProducts"><i class="fas fa-laptop"></i> Cyber Products</a>
          </li>
          <li class="nav-item">
            <a class="nav-link text-white" id="restaurantTab" data-bs-toggle="tab" href="#restaurantProducts"><i class="fas fa-utensils"></i> Restaurant Products</a>
          </li>
          <!-- Add more tabs as needed -->
        </ul>
      </div>
    </nav>

    <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-md-4 d-flex justify-center">
      <div class="tab-content">
        <div class="tab-pane fade show active" id="cyberProducts">
          <!-- Content for Cyber Products tab -->
          <h3 class="mb-4">Cyber Products</h3>
          <div class="card p-3" style="width: 800px;">
            <form method="POST">
              <div class="mb-3">
                <label for="productNameCyber" class="form-label">Product Name</label>
                <input type="text" class="form-control" id="productNameCyber" name="productNameCyber" required>
              </div>
              <div class="mb-3">
                <label for="unitPriceCyber" class="form-label">Unit Price in RWF</label>
                <input type="number" class="form-control" id="unitPriceCyber" name="unitPriceCyber" required>
              </div>
              <div class="mb-3">
                <label for="quantityCyber" class="form-label">Quantity</label>
                <input type="number" class="form-control" id="quantityCyber" name="quantityCyber" required>
              </div>
              <button type="submit" name="addCyberProduct" class="btn btn-primary">Add Product</button>
            </form>
          </div>
        </div>

        <div class="tab-pane fade" id="restaurantProducts">
          <!-- Content for Restaurant Products tab -->
          <h3 class="mb-4">Restaurant Products</h3>
          <div class="card p-3" style="width: 800px;">
            <form method="POST">
              <div class="mb-3">
                <label for="productNameRestaurant" class="form-label">Product Name</label>
                <input type="text" class="form-control" id="productNameRestaurant" name="productNameRestaurant" required>
              </div>
              <div class="mb-3">
                <label for="unitPriceRestaurant" class="form-label">Unit Price in RWF</label>
                <input type="number" class="form-control" id="unitPriceRestaurant" name="unitPriceRestaurant" required>
              </div>
              <button type="submit" name="addRestaurentProduct" class="btn btn-primary">Add Product</button>
            </form>
          </div>
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
