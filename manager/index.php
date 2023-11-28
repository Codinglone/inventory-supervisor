<?php
session_start();
include '../utils/link.php';
$logged_user = $_SESSION['manager'];
if (is_null($logged_user)) {
    header("location: ../index.php");
}

if (isset($_POST['addOrganization'])) {

    // Validate inputs
    $organization_name = trim($_POST['organizationName']);

    if (empty($organization_name)) {
        $error = 'Invalid organization name';
    } else {
        // Insert with prepared statement 
        $stmt = $link->prepare("INSERT INTO gym_organizations(organization_name, date_registered) VALUES(?, NOW())");
        $date = date("Y-m-d");
        $stmt->bind_param("s", $organization_name);
        if (!$stmt->execute()) {
            $error = $stmt->error;
        } else {
            echo "<script>alert('Organization was registered!')</script>";
        }

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
                            <a class="nav-link active text-white" id="cyberViewTab" data-bs-toggle="tab"
                                href="#gymView"><i class="fas fa-chart-bar"></i>Dashboard</a>
                        </li>
                        <li class="nav-item">
              <a class="nav-link text-white" id="restaurantTab" data-bs-toggle="tab" href="#organization"><i
                  class="fas fa-building"></i> Add Gym Organization</a>
            </li>
                        <li class="nav-item">
                            <a class="nav-link text-white" id="cyberViewTab" data-bs-toggle="tab" href="#roomsView"><i
                                    class="fas fa-eye"></i>View All Rooms</a>
                        </li>
                        <li class="nav-item">
              <a class="nav-link text-white" id="restaurentViewTab" data-bs-toggle="tab" href="#restaurentView"><i
                  class="fas fa-eye"></i>View Resto Products</a>
            </li>
                        <li class="nav-item">
              <a class="nav-link text-white" id="cyberViewTab" data-bs-toggle="tab" href="#cyberView"><i
                  class="fas fa-eye"></i>View Cyber Products</a>
            </li>
            <li class="nav-item">
              <a class="nav-link text-white" id="supermarketViewTab" data-bs-toggle="tab" href="#supermarketView"><i
                  class="fas fa-eye"></i>View Supermarket</a>
            </li>
            <li class="nav-item">
                            <a class="nav-link text-white" id="cyberViewTab" data-bs-toggle="tab" href="#saunaView"><i
                                    class="fas fa-eye"></i>View Sauna & Massage</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white" id="cyberViewTab" data-bs-toggle="tab" href="#gymClientView"><i
                                    class="fas fa-eye"></i>View Gym Clients</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white" id="cyberViewTab" data-bs-toggle="tab" href="#gymOrganizationView"><i
                                    class="fas fa-eye"></i>All Gym Organizations</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white" id="cyberViewTab" data-bs-toggle="tab"
                                href="#roomClientsView"><i class="fas fa-eye"></i>View Room Clients</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white" id="restaurentViewTab" data-bs-toggle="tab"
                                href="#restaurentView"><i class="fas fa-eye"></i>Restaurent Transactions</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white" id="restaurentViewTab" data-bs-toggle="tab"
                                href="#cyberTransactions"><i class="fas fa-eye"></i>Cyber Transactions</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white" id="restaurentViewTab" data-bs-toggle="tab"
                                href="#supermarketTransactions"><i class="fas fa-eye"></i>All Supermarket Data</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white" id="restaurentViewTab" data-bs-toggle="tab"
                                href="#usersView"><i class="fas fa-eye"></i>View All Users</a>
                        </li>
                        <!-- Add more tabs as needed -->
                    </ul>
                </div>
            </nav>

            <main role="main" class="col-md-9 ml-sm-auto col-lg-12 px-md-2 d-flex justify-center">
                <div class="tab-content">

                    <div class="tab-pane active show" id="gymView">
                        <!-- Content for Restaurant Products tab -->
                        <h3 class="mb-4">Dashboard</h3>
                        <div class="p-3 d-flex justify-content-between" style="width: 1000px;">
                            <div class="bg-primary py-2"
                                style="width:22%;display: flex;flex-direction:column;border-radius: 6px;">
                                <span class="h4 text-white text-center">All Registered Clients</span>
                                <span class="h3 text-white text-center mt-4" style="font-weight:600;">100</span>
                            </div>
                            <div class="bg-success py-2"
                                style="width:22%;display: flex;flex-direction:column;border-radius: 6px;">
                                <span class="h4 text-white text-center">All Registered Gym Clients</span>
                                <span class="h3 text-white text-center mt-4" style="font-weight:600;">
                                <?php 
                                $query = "SELECT COUNT(*) as total_records FROM gym_clients";
                                $client_sel = $link->query($query);
                                $client_row = mysqli_fetch_array($client_sel);
                                ?>
                                <?php echo $client_row['total_records'];  ?>
                                </span>
                            </div>
                            <div class="py-2"
                                style="width:22%;display: flex;flex-direction:column;border-radius: 6px;background-color: teal;">
                                <span class="h4 text-white text-center">All Registered Room Clients</span>
                                <span class="h3 text-white text-center mt-4" style="font-weight:600;">
                                <?php 
                                $query = "SELECT COUNT(*) as total_records FROM rooms_clients";
                                $client_sel = $link->query($query);
                                $client_row = mysqli_fetch_array($client_sel);
                                ?>
                                <?php echo $client_row['total_records'];  ?>
                                </span>
                            </div>
                            <div class="bg-secondary py-2"
                                style="width:22%;display: flex;flex-direction:column;border-radius: 6px;">
                                <span class="h4 text-white text-center">All Registered Sauna Clients</span>
                                <span class="h3 text-white text-center mt-4" style="font-weight:600;">
                                <?php 
                                $query = "SELECT COUNT(*) as total_records FROM sauna_massage_clients";
                                $client_sel = $link->query($query);
                                $client_row = mysqli_fetch_array($client_sel);
                                ?>
                                <?php echo $client_row['total_records'];  ?>
                                </span>
                            </div>
                        </div>
                        <div class="p-3 d-flex justify-content-between" style="width: 1000px;">
                        <div class="bg-success py-2"
                                style="width:22%;display: flex;flex-direction:column;border-radius: 6px;">
                                <span class="h4 text-white text-center">All Restaurent Products</span>
                                <span class="h3 text-white text-center mt-4" style="font-weight:600;">
                                <?php 
                                $query = "SELECT COUNT(*) as total_records FROM restaurent_products";
                                $client_sel = $link->query($query);
                                $client_row = mysqli_fetch_array($client_sel);
                                ?>
                                <?php echo $client_row['total_records'];  ?>
                                </span>
                            </div>
                            <div class="bg-secondary py-2"
                                style="width:22%;display: flex;flex-direction:column;border-radius: 6px;">
                                <span class="h4 text-white text-center">All Supermarket Products</span>
                                <span class="h3 text-white text-center mt-4" style="font-weight:600;">
                                <?php 
                                $query = "SELECT COUNT(*) as total_records FROM supermarket_products";
                                $client_sel = $link->query($query);
                                $client_row = mysqli_fetch_array($client_sel);
                                ?>
                                <?php echo $client_row['total_records'];  ?>
                                </span>
                            </div>
                            <div class="bg-primary py-2"
                                style="width:22%;display: flex;flex-direction:column;border-radius: 6px;">
                                <span class="h4 text-white text-center">All Registered Rooms</span>
                                <span class="h3 text-white text-center mt-4" style="font-weight:600;">
                                <?php 
                                $query = "SELECT COUNT(*) as total_records FROM rooms";
                                $client_sel = $link->query($query);
                                $client_row = mysqli_fetch_array($client_sel);
                                ?>
                                <?php echo $client_row['total_records'];  ?>
                                </span>
                            </div>
                            
                            
                            <div class="py-2"
                                style="width:22%;display: flex;flex-direction:column;border-radius: 6px;background-color: teal;">
                                <span class="h4 text-white text-center">All Gym Organizations</span>
                                <span class="h3 text-white text-center mt-4" style="font-weight:600;">
                                <?php 
                                $query = "SELECT COUNT(*) as total_records FROM gym_organizations";
                                $client_sel = $link->query($query);
                                $client_row = mysqli_fetch_array($client_sel);
                                ?>
                                <?php echo $client_row['total_records'];  ?>
                                </span>
                            </div>
                            
                        </div>
                    </div>

                    <div class="tab-pane fade" id="saunaView">
                        <!-- Content for Restaurant Products tab -->
                        <h3 class="mb-4">View Sauna & Massage Clients</h3>
                        <div class="card p-3" style="width: 1000px;">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Fullname</th>
                                        <th>Email</th>
                                        <th>Phone</th>
                                        <th>Service Type</th>
                                        <th>Amount Paid</th>
                                        <th>Date Recorded</th>

                                    </tr>
                                </thead>

                                <tbody>
                                    <?php
                                    $count = 0;
                                    $sauna_sel = $link->query("SELECT * FROM sauna_massage_clients");
                                    while ($rows = mysqli_fetch_array($sauna_sel)) {
                                        $count += 1;
                                        $id = $rows['id'];
                                        ?>
                                        <tr>
                                            <td>
                                                <?php echo $count; ?>
                                            </td>
                                            <td>
                                                <?php echo $rows['fullname']; ?>
                                            </td>
                                            <td>
                                                <?php echo $rows['email']; ?>
                                            </td>
                                            <td>
                                                <?php echo $rows['phone']; ?>
                                            </td>
                                            <td>
                                                <?php echo $rows['service_type']; ?>
                                            </td>
                                            <td>
                                                <?php echo $rows['amount_paid']; ?>
                                            </td>
                                            <td>
                                                <?php echo $rows['dates']; ?>
                                            </td>
                                        </tr>
                                    <?php } ?>

                                </tbody>
                            </table>

                        </div>
                    </div>

                    <div class="tab-pane fade" id="cyberView">
            <!-- Content for Restaurant Products tab -->
            <h3 class="mb-4">View Cyber Products</h3>
            <div class="card p-3" style="width: 800px;">
              <table class="table table-bordered">
                <thead>
                  <tr>
                    <th>#</th>
                    <th>Product Name</th>
                    <th>Unit Price in RWF</th>
                    <th>Quantity</th>
                  </tr>
                </thead>

                <tbody>
                  <?php
                  $count = 0;
                  $cyber_sel = $link->query("SELECT * FROM cyber_products");
                  while ($rows = mysqli_fetch_array($cyber_sel)) {
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
                        <?php echo $rows['price_per_unit']; ?>
                      </td>
                      <td>
                        <?php echo $rows['quantity']; ?>
                      </td>
                    </tr>
                  <?php } ?>

                </tbody>
              </table>

            </div>
          </div>
          
          <div class="tab-pane fade" id="restaurentView">
                        <!-- Content for Restaurant Products tab -->
                        <h3 class="mb-4">View All Restaurent Transactions</h3>
                        <div class="card p-3" style="width: 800px;">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Product Name</th>
                                        <th>Unit Price in RWF</th>
                                        <th>Quantity</th>
                                        <th>Date sold</th>
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
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>

                        </div>
                    </div>
                    
          <div class="tab-pane fade" id="gymClientView">
                        <!-- Content for Restaurant Products tab -->
                        <h3 class="mb-4">View Gym Clients</h3>
                        <div class="card p-3" style="width: 800px;">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Fullname</th>
                                        <th>Membership Type</th>
                                        <th>Organization</th>
                                        <th>Amount Paid</th>
                                        <th>Date Recorded</th>

                                    </tr>
                                </thead>

                                <tbody>
                                    <?php
                                    $count = 0;
                                    $cyber_sel = $link->query("SELECT * FROM gym_clients");
                                    while ($rows = mysqli_fetch_array($cyber_sel)) {
                                        $count += 1;
                                        $id = $rows['id'];
                                        ?>
                                        <tr>
                                            <td>
                                                <?php echo $count; ?>
                                            </td>
                                            <td>
                                                <?php echo $rows['fullname']; ?>
                                            </td>
                                            <td>
                                                <?php echo $rows['membership_type']; ?>
                                            </td>
                                            <td>
                                                <?php echo $rows['organization']; ?>
                                            </td>
                                            <td>
                                                <?php echo $rows['amount_paid']; ?>
                                            </td>
                                            <td>
                                                <?php echo $rows['dates']; ?>
                                            </td>
                                        </tr>
                                    <?php } ?>

                                </tbody>
                            </table>

                        </div>
                    </div>

                    <div class="tab-pane fade" id="gymOrganizationView">
                        <!-- Content for Restaurant Products tab -->
                        <h3 class="mb-4">View Gym Organizations</h3>
                        <div class="card p-3" style="width: 800px;">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Organization Name</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    <?php
                                    $count = 0;
                                    $cyber_sel = $link->query("SELECT * FROM gym_organizations");
                                    while ($rows = mysqli_fetch_array($cyber_sel)) {
                                        $count += 1;
                                        $id = $rows['id'];
                                        ?>
                                        <tr>
                                            <td>
                                                <?php echo $count; ?>
                                            </td>
                                            <td>
                                                <?php echo $rows['organization_name']; ?>
                                            </td>
                                        </tr>
                                    <?php } ?>

                                </tbody>
                            </table>

                        </div>
                    </div>

                    <div class="tab-pane fade" id="roomClientsView">
                        <!-- Content for Restaurant Products tab -->
                        <h3 class="mb-4">View Room Clients</h3>
                        <div class="card p-3" style="width: 1000px;">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Fullname</th>
                                        <th>Phone</th>
                                        <th>Checkin Date</th>
                                        <th>Checkout Date</th>
                                        <th>Room Name</th>
                                        <th>Amount Paid</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    <?php
                                    $count = 0;
                                    $room_sel = $link->query("SELECT * FROM rooms_clients");
                                    while ($rows = mysqli_fetch_array($room_sel)) {
                                        $count += 1;
                                        $room_name_sel = $link->query("SELECT * FROM rooms WHERE id = '$rows[room_id]'");
                                        $room_row = mysqli_fetch_array($room_name_sel);
                                        ?>
                                        <tr>
                                            <td>
                                                <?php echo $count; ?>
                                            </td>
                                            <td>
                                                <?php echo $rows['fullname']; ?>
                                            </td>
                                            <td>
                                                <?php echo $rows['phone']; ?>
                                            </td>
                                            <td>
                                                <?php echo $rows['checkin_date']; ?>
                                            </td>
                                            <td>
                                                <?php echo $rows['checkout_date']; ?>
                                            </td>
                                            <td>
                                                <?php echo $room_row['room_name']; ?>
                                            </td>
                                            <td>
                                                <?php echo $rows['amount_paid']; ?>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>

                        </div>
                    </div>
                    
          <div class="tab-pane fade" id="supermarketView">
            <!-- Content for Restaurant Products tab -->
            <h3 class="mb-4">View Supermarket Products</h3>
            <div class="card p-3" style="width: 800px;">
              <table class="table table-bordered">
                <thead>
                  <tr>
                    <th>#</th>
                    <th>Product Name</th>
                    <th>Unit Price in RWF</th>
                    <th>Quantity</th>
                  </tr>
                </thead>

                <tbody>
                  <?php
                  $count = 0;
                  $supermarket_sel = $link->query("SELECT * FROM supermarket_products");
                  while ($rows = mysqli_fetch_array($supermarket_sel)) {
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
                        <?php echo $rows['unit_price']; ?>
                      </td>
                      <td>
                        <?php echo $rows['quantity']; ?>
                      </td>
                    </tr>
                  <?php } ?>

                </tbody>
              </table>
            </div>
          </div>

          <div class="tab-pane fade" id="organization">
            <h3 class="mb-4">Add Gym Organization</h3>
            <div class="card p-3" style="width: 800px;">
              <form method="POST">
                <div class="mb-3">
                  <label for="organizationName" class="form-label">Organization Name</label>
                  <input type="text" class="form-control" id="organizationName" name="organizationName"
                    required>
                </div>
                <button type="submit" name="addOrganization" class="btn btn-primary">Add Organization</button>
              </form>
            </div>
          </div>

          <div class="tab-pane fade" id="cyberTransactions">
                        <!-- Content for Restaurant Products tab -->
                        <h3 class="mb-4">View All Cyber Transactions</h3>
                        <div class="card p-3" style="width: 800px;">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Product Name</th>
                                        <th>Unit Price in RWF</th>
                                        <th>Quantity</th>
                                        <th>Date sold</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    <?php
                                    $count = 0;
                                    $restaurent_sel = $link->query("SELECT * FROM cyber_products_transactions");
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
                                                <?php echo $rows['price_per_unit']; ?>
                                            </td>
                                            <td>
                                                <?php echo $rows['quantity']; ?>
                                            </td>
                                            <td>
                                                <?php echo $rows['dates']; ?>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>

                        </div>
                    </div>

          <div class="tab-pane fade" id="restaurentView">
            <!-- Content for Restaurant Products tab -->
            <h3 class="mb-4">View Restaurent Products</h3>
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

          <div class="tab-pane fade" id="supermarketTransactions">
                        <!-- Content for Restaurant Products tab -->
                        <h3 class="mb-4">View All Supermarket Transactions</h3>
                        <div class="card p-3" style="width: 800px;">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Product Name</th>
                                        <th>Unit Price in RWF</th>
                                        <th>Quantity</th>
                                        <th>Date sold</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    <?php
                                    $count = 0;
                                    $restaurent_sel = $link->query("SELECT * FROM supermarket_products_transactions");
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
                                                <?php echo $rows['price_per_unit']; ?>
                                            </td>
                                            <td>
                                                <?php echo $rows['quantity']; ?>
                                            </td>
                                            <td>
                                                <?php echo $rows['dates']; ?>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>

                        </div>
                    </div>

                    <div class="tab-pane fade" id="usersView">
                        <!-- Content for Restaurant Products tab -->
                        <h3 class="mb-4">View All Users</h3>
                        <div class="card p-3" style="width: 800px;">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Fullname</th>
                                        <th>E-mail</th>
                                        <th>Password</th>
                                        <th>Role</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    <?php
                                    $count = 0;
                                    $users_sel = $link->query("SELECT * FROM users");
                                    while ($rows = mysqli_fetch_array($users_sel)) {
                                        $count += 1;
                                        $id = $rows['id'];
                                        ?>
                                        <tr>
                                            <td>
                                                <?php echo $count; ?>
                                            </td>
                                            <td>
                                                <?php echo $rows['fullname']; ?>
                                            </td>
                                            <td>
                                                <?php echo $rows['email']; ?>
                                            </td>
                                            <td>
                                                <?php echo $rows['password']; ?>
                                            </td>
                                            <td>
                                                <?php echo $rows['role']; ?>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>

                        </div>
                    </div>

                    <div class="tab-pane fade" id="roomsView">
                        <!-- Content for Restaurant Products tab -->
                        <h3 class="mb-4">View Rooms</h3>
                        <div class="card p-3" style="width: 800px;">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Room Name</th>
                                        <th>Room Price in RWF</th>
                                        <th>Room Status</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    <?php
                                    $count = 0;
                                    $room_sel = $link->query("SELECT * FROM rooms");
                                    while ($rows = mysqli_fetch_array($room_sel)) {
                                        $count += 1;
                                        $id = $rows['id'];
                                        ?>
                                        <tr>
                                            <td>
                                                <?php echo $count; ?>
                                            </td>
                                            <td>
                                                <?php echo $rows['room_name']; ?>
                                            </td>
                                            <td>
                                                <?php echo $rows['room_price']; ?>
                                            </td>
                                            <td>
                                                <?php echo $rows['room_status']; ?>
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