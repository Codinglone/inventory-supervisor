<?php
session_start();
include '../utils/link.php';
$logged_user = $_SESSION['technician'];
if (is_null($logged_user)) {
  header("location: ../index.php");
}

if (isset($_POST['createUser'])) {

  // Validate inputs
  $fullname = trim($_POST['fullname']);
  $email = trim($_POST['email']);
  $password = trim($_POST['password']);
  $role = trim($_POST['role']);

  if (empty($fullname) || empty($email) || empty($password) || empty($role)) {
    $error = 'Invalid user data';
  } else {

    // Insert with prepared statement 
    $stmt = $link->prepare("INSERT INTO users(fullname, email, password, role) VALUES(?, ?, ?, ?)");

    $stmt->bind_param("ssss", $fullname, $email, $password, $role);

    if (!$stmt->execute()) {
      $error = $stmt->error;
    } else {
      echo "<script>alert('User added successfully!')</script>";
    }
  }

  // Check for errors
  if (isset($error)) {
    echo "Error adding product: " . $error;
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
              <a class="nav-link active text-white" id="cyberTab" data-bs-toggle="tab" href="#newUser"><i
                  class="fas fa-user"></i> Create New User</a>
            </li>
            <li class="nav-item">
              <a class="nav-link text-white" id="cyberViewTab" data-bs-toggle="tab" href="#usersView"><i
                  class="fas fa-eye"></i>View All Users</a>
            </li>
            <!-- Add more tabs as needed -->
          </ul>
        </div>
      </nav>

      <main role="main" class="col-md-9 ml-sm-auto col-lg-12 px-md-4 d-flex justify-center">
        <div class="tab-content">
          <div class="tab-pane fade show active" id="newUser">
            <h3 class="mb-4">Create a new user</h3>
            <div class="card p-3" style="width: 800px;">
              <form method="POST">
                <div class="mb-3">
                  <label for="fullname" class="form-label">User's Fullname</label>
                  <input type="text" class="form-control" id="fullname" name="fullname" required>
                </div>
                <div class="mb-3">
                  <label for="email" class="form-label">User's Email</label>
                  <input type="text" class="form-control" id="email" name="email" required>
                </div>
                <div class="mb-3">
                  <label for="password" class="form-label">User's Password</label>
                  <input type="number" class="form-control" id="password" name="password" required>
                </div>
                <div class="mb-3">
                                    <label for="role" class="form-label">User's Role</label>
                                    <select class="form-select" name="role" aria-label="Default select example"
                                        id="role">
                                        <option value="accountant" selected>accountant</option>
                                        <option value="manager">manager</option>
                                        <option value="supermarket">supermarket</option>
                                        <option value="sauna-massage">sauna-massage</option>
                                        <option value="cyber">cyber</option>
                                        <option value="restaurent">restaurent</option>
                                        <option value="reception">reception</option>
                                        <option value="technician">technician</option>
                                    </select>
                                </div>
                <button type="submit" name="createUser" class="btn btn-primary">Create User</button>
              </form>
            </div>
          </div>

          <div class="tab-pane fade" id="usersView">
            <!-- Content for Restaurant Products tab -->
            <h3 class="mb-4">View All Users</h3>
            <div class="card p-3" style="width: 900px;">
              <table class="table table-bordered">
                <thead>
                  <tr>
                    <th>#</th>
                    <th>Fullname</th>
                    <th>Email</th>
                    <th>Password</th>
                    <th>Role</th>
                    <th>Action</th>
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
                      <td>
                        <a href="deleteUser.php?id=<?php echo $id; ?>" class="btn btn-danger btn-sm">Delete</a>
                        <a href="updateUser.php?id=<?php echo $id; ?>" class="btn btn-secondary btn-sm">Update</a>
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