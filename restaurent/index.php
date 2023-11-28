<?php
session_start();
include '../utils/link.php';
$logged_user = $_SESSION['restaurent'];
if (is_null($logged_user)) {
    header("location: ../index.php");
}

if (isset($_POST['sellProduct'])) {

    // Validate inputs
    $restaurent_product_name = trim($_POST['productNameRestaurent']);
    $restaurent_quantity = filter_var($_POST['quantityRestaurent'], FILTER_VALIDATE_INT);

    if (empty($restaurent_product_name) || !$restaurent_quantity) {
        $error = 'Invalid product data';
    } else {
        $stmt_product = $link->prepare("SELECT * FROM restaurent_products WHERE product_name = ?");
        $stmt_product->bind_param("s", $restaurent_product_name);
        $stmt_product->execute();
        $result_product = $stmt_product->get_result();
        $row = $result_product->fetch_assoc();
        // Insert with prepared statement 
        $stmt = $link->prepare("INSERT INTO restaurent_products_transactions(product_name, quantity, price,dates) VALUES(?, ?, ?, ?)");
        $date = date("Y-m-d");
        $stmt->bind_param("sids", $restaurent_product_name, $restaurent_quantity, $row['price'], $date);

        if (!$stmt->execute()) {
            $error = $stmt->error;
        } else {
            echo "<script>alert('Product sold successfully!')</script>";
        }
    }

    // Check for errors
    if (isset($error)) {
        echo "Error selling product: " . $error;
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
                            <a class="nav-link active text-white" id="cyberTab" data-bs-toggle="tab"
                                href="#cyberProducts"><i class="fas fa-exchange-alt"></i> Sell Products</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white" id="cyberViewTab" data-bs-toggle="tab" href="#cyberView"><i
                                    class="fas fa-eye"></i>View All Products</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white" id="restaurentViewTab" data-bs-toggle="tab"
                                href="#restaurentView"><i class="fas fa-eye"></i>View Sold Products</a>
                        </li>
                        <!-- Add more tabs as needed -->
                    </ul>
                </div>
            </nav>

            <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-md-4 d-flex justify-center">
                <div class="tab-content">
                    <div class="tab-pane fade show active" id="cyberProducts">
                        <!-- Content for Cyber Products tab -->
                        <h3 class="mb-4">Sell a Product</h3>
                        <div class="card p-3" style="width: 800px;">
                            <form method="POST">
                                <div class="mb-3">
                                    <label for="productNameRestaurent" class="form-label">Product Name</label>
                                    <select class="form-select" id="productNameRestaurent" name="productNameRestaurent"
                                        aria-label="Default select example">
                                        <option selected>Select Product</option>
                                        <?php
                                        $cyber_sel = $link->query("SELECT * FROM restaurent_products");
                                        while ($rows = mysqli_fetch_array($cyber_sel)) {
                                            $product_name = $rows['product_name'];
                                            ?>
                                            <option value="<?php echo $product_name; ?>">
                                                <?php echo $product_name; ?>
                                            </option>
                                        <?php } ?>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="quantityRestaurent" class="form-label">Quantity</label>
                                    <input type="number" class="form-control" id="quantityRestaurent"
                                        name="quantityRestaurent" required>
                                </div>
                                <button type="submit" name="sellProduct" class="btn btn-primary">Sell
                                    Product</button>
                            </form>
                        </div>
                    </div>


                    <div class="tab-pane fade" id="cyberView">
                        <!-- Content for Restaurant Products tab -->
                        <h3 class="mb-4">View All Products</h3>
                        <div class="card p-3" style="width: 800px;">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Product Name</th>
                                        <th>Unit Price in RWF</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    <?php
                                    $count = 0;
                                    $restaurent_sel = $link->query("SELECT * FROM restaurent_products");
                                    while ($rows = mysqli_fetch_array($restaurent_sel)) {
                                        $count += 1;
                                        $id = $rows['id'];
                                        ?>
                                        <tr>
                                            <td>
                                                <?php echo $count; ?>
                                            </td>
                                            <td>
                                                <?php echo $rows['product_name']; ?>
                                            </td>
                                            <td>
                                                <?php echo $rows['price']; ?>
                                            </td>
                                        </tr>
                                    <?php } ?>

                                </tbody>
                            </table>

                        </div>
                    </div>

                    <div class="tab-pane fade" id="restaurentView">
                        <!-- Content for Restaurant Products tab -->
                        <h3 class="mb-4">View Sold Products</h3>
                        <div class="card p-3" style="width: 800px;">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Product Name</th>
                                        <th>Unit Price in RWF</th>
                                        <th>Quantity</th>
                                        <th>Date sold</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    <?php
                                    $count = 0;
                                    $restaurent_sel = $link->query("SELECT * FROM restaurent_products_transactions");
                                    while ($rows = mysqli_fetch_array($restaurent_sel)) {
                                        $count += 1;
                                        $id = $rows['id'];
                                        ?>
                                        <tr>
                                            <td>
                                                <?php echo $count; ?>
                                            </td>
                                            <td>
                                                <?php echo $rows['product_name']; ?>
                                            </td>
                                            <td>
                                                <?php echo $rows['price']; ?>
                                            </td>
                                            <td>
                                                <?php echo $rows['quantity']; ?>
                                            </td>
                                            <td>
                                                <?php echo $rows['dates']; ?>
                                            </td>
                                            <td>
                    <form method="POST" action="generate_receipt.php" target="_blank">
                        <input type="hidden" name="transaction_id" value="<?php echo $id; ?>">
                        <button type="submit" class="btn btn-primary">Print Receipt</button>
                    </form>
                </td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>

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