<?php
session_start();
include '../utils/link.php';
$logged_user = $_SESSION['manager'];
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

if (isset($_POST['registerRoomClient'])) {
    $client_name = trim($_POST['fullName']);
    $client_email = trim($_POST['email']);
    $client_phone = trim($_POST['phone']);
    $client_ID = trim($_POST['ID']);
    $checkin_date = trim($_POST['checkin_date']);
    $checkout_date = trim($_POST['checkout_date']);
    $roomId = filter_var($_POST['roomId'], FILTER_VALIDATE_INT);
    $amount_paid = filter_var($_POST['amountPaid'], FILTER_VALIDATE_INT);

    if (empty($client_name) || empty($client_email) || empty($client_phone) || empty($client_ID) || empty($checkin_date) || empty($checkout_date) || !$roomId || !$amount_paid) {
        $error = 'Invalid client info';
    } else {
        // Insert with prepared statement 
        $stmt = $link->prepare("INSERT INTO rooms_clients(fullname, email, phone, id_number, checkin_date, checkout_date, room_id, amount_paid) VALUES(?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssssii", $client_name, $client_email, $client_phone, $client_ID, $checkin_date, $checkout_date, $roomId, $amount_paid);
        if (!$stmt->execute()) {
            $error = $stmt->error;
        } else {
            echo "<script>alert('Room Client was registered successfully!')</script>";
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
                            <a class="nav-link active text-white" id="cyberViewTab" data-bs-toggle="tab"
                                href="#gymView"><i class="fas fa-chart-bar"></i>Dashboard</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white" id="cyberViewTab" data-bs-toggle="tab" href="#roomsView"><i
                                    class="fas fa-eye"></i>View Rooms</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white" id="restaurentViewTab" data-bs-toggle="tab"
                                href="#roomClientsView"><i class="fas fa-eye"></i>View Room Clients</a>
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
                                        <th>Action</th>
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
                                            <td>
                                                <a href="deleteRoom.php?id=<?php echo $id; ?>"
                                                    class="btn btn-danger">Delete</a>
                                                <a href="updateRoom.php?id=<?php echo $id; ?>"
                                                    class="btn btn-secondary">Update</a>
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