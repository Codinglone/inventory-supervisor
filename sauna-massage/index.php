<?php
session_start();
include '../utils/link.php';
$logged_user = $_SESSION['sauna-massage'];
if (is_null($logged_user)) {
    header("location: ../index.php");
}

if (isset($_POST['registerClient'])) {

    // Validate inputs
    $client_name = trim($_POST['clientName']);
    $membership_type = trim($_POST['membershipType']);
    $organization_name = trim($_POST['organizationName']);
    $amount_paid = filter_var($_POST['amountPaid'], FILTER_VALIDATE_INT);

    if (empty($client_name) || empty($membership_type) || empty($organization_name) || !$amount_paid) {
        $error = 'Invalid product data';
    } else {
        // Insert with prepared statement 
        $stmt = $link->prepare("INSERT INTO gym_clients(fullname, membership_type, organization,dates, amount_paid) VALUES(?, ?, ?, ?, ?)");
        $date = date("Y-m-d");
        $stmt->bind_param("ssssi", $client_name, $membership_type, $organization_name, $date, $amount_paid);
        if (!$stmt->execute()) {
            $error = $stmt->error;
        } else {
            echo "<script>alert('Client was registered successfully!')</script>";
        }

    }
}
if (isset($_POST['registerRoom'])) {
    $room_name = trim($_POST['RoomName']);
    $room_price = filter_var($_POST['roomPrice'], FILTER_VALIDATE_INT);
    $room_status = trim($_POST['roomStatus']);

    if (empty($room_name) || !$room_price || empty($room_status)) {
        $error = 'Invalid product data';
    } else {
        // Insert with prepared statement 
        $stmt = $link->prepare("INSERT INTO rooms(room_name, room_price, room_status) VALUES(?, ?, ?)");
        $date = date("Y-m-d");
        $stmt->bind_param("sis", $room_name, $room_price, $room_status);
        if (!$stmt->execute()) {
            $error = $stmt->error;
        } else {
            echo "<script>alert('Room was registered successfully!')</script>";
        }
    }

    // Check for errors
    if (isset($error)) {
        echo "Error registering room: " . $error;
    }
}

if (isset($_POST['registerSaunaClient'])) {
    $client_name = trim($_POST['fullName']);
    $client_email = trim($_POST['email']);
    $client_phone = trim($_POST['phone']);
    $service_type = trim($_POST['serviceType']);
    $amount_paid = filter_var($_POST['amountPaid'], FILTER_VALIDATE_INT);

    if (empty($client_name) || empty($client_email) || empty($client_phone) || empty($service_type) || !$amount_paid) {
        $error = 'Invalid client info';
    } else {
        // Insert with prepared statement 
        $stmt = $link->prepare("INSERT INTO sauna_massage_clients(fullname, email, phone, service_type, amount_paid, dates) VALUES(?, ?, ?, ?, ?, NOW())");
        $stmt->bind_param("ssssi", $client_name, $client_email, $client_phone, $service_type, $amount_paid);
        if (!$stmt->execute()) {
            $error = $stmt->error;
        } else {
            echo "<script>alert('Sauna & Massage Client was registered!')</script>";
        }
    }

    // Check for errors
    if (isset($error)) {
        echo "Error registering room client: " . $error;
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
                                href="#registerSaunaClients"><i class="fas fa-hot-tub"></i>Sauna & Massage Client</a>
                        </li>
                        
                        <li class="nav-item">
                            <a class="nav-link text-white" id="cyberViewTab" data-bs-toggle="tab" href="#gymView"><i
                                    class="fas fa-eye"></i>View All Clients</a>
                        </li>
                        <!-- Add more tabs as needed -->
                    </ul>
                </div>
            </nav>

            <main role="main" class="col-md-9 ml-sm-auto col-lg-12 px-md-2 d-flex justify-center">
                <div class="tab-content">
                    <div class="tab-pane fade active show" id="registerSaunaClients">
                        <!-- Content for Cyber Products tab -->
                        <h3 class="mb-4">Register Sauna & Massage Clients</h3>
                        <div class="card p-3" style="width: 800px;">
                            <form method="POST">
                                <div class="mb-3">
                                    <label for="clientName" class="form-label">Client's Fullname</label>
                                    <input type="text" class="form-control" id="fullName" name="fullName" required>
                                </div>
                                <div class="mb-3">
                                    <label for="email" class="form-label">Client's Email</label>
                                    <input type="email" class="form-control" id="email" name="email" required>
                                </div>
                                <div class="mb-3">
                                    <label for="phone" class="form-label">Client's Phone</label>
                                    <input type="text" class="form-control" id="phone" name="phone" required>
                                </div>
                                <div class="mb-3">
                                    <label for="serviceType" class="form-label">Service Type</label>
                                    <select class="form-select" name="serviceType" id="serviceType"
                                        aria-label="Default select example">


                                        <option value="Sauna & Massage">
                                            Sauna & Massage
                                        </option>
                                        <option value="Sauna & Massage">
                                            Sauna
                                        </option>
                                        <option value="Sauna & Massage">
                                            Massage
                                        </option>

                                    </select>

                                </div>

                                <div class="mb-3">
                                    <label for="amountPaid" class="form-label">Amount Paid</label>
                                    <input type="number" class="form-control" value="0" id="amountPaid"
                                        name="amountPaid" required>
                                </div>
                                <button type="submit" name="registerSaunaClient" class="btn btn-primary">Register
                                    Client</button>
                            </form>
                        </div>
                    </div>

                    <div class="tab-pane fade" id="gymView">
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

                    <!-- Add more tab panes as needed for additional functionality -->
                </div>
            </main>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>

</body>

</html>