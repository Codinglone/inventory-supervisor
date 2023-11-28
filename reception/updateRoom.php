<?php
session_start();
include '../utils/link.php';
$logged_user = $_SESSION['reception'];
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
                            <a class="nav-link text-white" id="cyberTab" data-bs-toggle="tab"
                                href="index.php"><i class="fas fa-dumbbell"></i>Add Gym Client</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white" id="cyberTab" data-bs-toggle="tab"
                                href="index.php"><i class="fas fa-bed"></i>Register Room</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white" id="cyberTab" data-bs-toggle="tab"
                                href="index.php"><i class="fas fa-bed"></i>Register Room Clients</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white" id="cyberViewTab" data-bs-toggle="tab" href="index.php"><i
                                    class="fas fa-eye"></i>View Gym Clients</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active text-white" id="cyberViewTab" data-bs-toggle="tab" href="index.php"><i
                                    class="fas fa-eye"></i>View Rooms</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white" id="restaurentViewTab" data-bs-toggle="tab"
                                href="index.php"><i class="fas fa-eye"></i>View Room Clients</a>
                        </li>
                        <!-- Add more tabs as needed -->
                    </ul>
                </div>
            </nav>

      <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-md-4 d-flex justify-center">
        <div class="tab-content">
          <div class="tab-pane fade active show" id="cyberView">
            <!-- Content for Cyber Products tab -->
            <h3 class="mb-4">Update Room</h3>
            <?php
            if (isset($_GET['id'])) {
              $id = $_GET['id'];
              $sql = "SELECT * FROM rooms WHERE id = '$id'";
              $result = $link->query($sql);
              $row = mysqli_fetch_array($result);

              if (isset($_POST['updateRoom'])) {
                $product_update = $link->query("UPDATE rooms SET room_name = '$_POST[roomName]', room_price = '$_POST[roomPrice]', room_status = '$_POST[roomStatus]' WHERE id = '$id'");
                if ($product_update) {
                  echo "<script>window.location.replace('index.php')</script>";
                } else {
                  echo "<script>alert('Failed to update product')</script>";
                }
              }

              ?>
              <div class="card p-3" style="width: 800px;">
                <form method="POST">
                  <div class="mb-3">
                    <label for="roomName" class="form-label">Room Name</label>
                    <input type="text" class="form-control" value="<?php echo $row['room_name'] ?>"
                      id="roomName" name="roomName" required>
                  </div>
                  <div class="mb-3">
                    <label for="roomPrice" class="form-label">Room Price in RWF</label>
                    <input type="number" class="form-control" value="<?php echo $row['room_price'] ?>"
                      id="roomPrice" name="roomPrice" required>
                  </div>
                  <div class="mb-3">
                    <label for="roomStatus" class="form-label">Room Status</label>
                    <select class="form-select" name="roomStatus" aria-label="Default select example"
                                        id="roomStatus">
                                        <option value="Available" selected>Available</option>
                                        <option value="Not-Available">Not-Available</option>
                                    </select>
                  </div>
                  <button type="submit" name="updateRoom" class="btn btn-primary">Update Room</button>
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