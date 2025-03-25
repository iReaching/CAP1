<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Admin Login | VilMan</title>
  <!-- Bootstrap 5 CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="css/login_homeowner.css?v=1.01">
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;700&display=swap" rel="stylesheet">
</head>
<body>
  <!-- Header Navbar -->
  <nav class="navbar navbar-expand-lg navbar-dark bg-topbar px-4 py-2">
    <div class="container-fluid">
      <div class="d-flex align-items-center">
        <img src="./images/vilmanlogo.png" alt="VilMan Logo" class="topbar-logo me-2">
        <a class="navbar-brand topbar-text mx-2" href="#">VilMan</a>
      </div>
    </div>
  </nav>

  <!-- Login Section -->
  <div class="container d-flex justify-content-center align-items-center min-vh-100">
    <div class="row shadow rounded-4 overflow-hidden" style="max-width: 900px; width: 100%;">
      <!-- Left Side -->
      <div class="col-md-6 bg-welcome text-white d-flex flex-column justify-content-center align-items-center p-4">
        <img src="./images/vilmanlogo.png" alt="VilMan Logo" class="mb-3" style="width: 120px;">
        <h3 class="fw-bold text-center">WELCOME<br><span class="text-decoration-underline">TO</span></h3>
        <h1 class="fw-bold text-center display-4 mt-2">VilMan</h1>
        <hr class="w-50 border-2 border-white">
      </div>
      <!-- Right Side -->
      <div class="col-md-6 bg-white p-4 d-flex flex-column justify-content-center">
        <h3 class="fw-bold text-center mb-4">ADMIN LOGIN</h3>

        <?php if (isset($_SESSION["login_error"])): ?>
        <div class="alert alert-danger text-center">
          <?php echo $_SESSION["login_error"]; ?>
        </div>
        <?php unset($_SESSION["login_error"]); endif; ?>

        <?php if (isset($_SESSION["login_success"])): ?>
        <div class="modal fade" id="loginSuccessModal" tabindex="-1" aria-labelledby="loginSuccessModalLabel" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="loginSuccessModalLabel">Login Successful</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">
                <?php echo $_SESSION["login_success"]; ?>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
              </div>
            </div>
          </div>
        </div>
        <script>
          document.addEventListener("DOMContentLoaded", function() {
            var loginModal = new bootstrap.Modal(document.getElementById("loginSuccessModal"));
            loginModal.show();
            document.getElementById("loginSuccessModal").addEventListener("hidden.bs.modal", function () {
              window.location.href = "homepage.php"; // You can customize this redirect
            });
          });
        </script>
        <?php unset($_SESSION["login_success"]); endif; ?>

        <form action="login_admin.php" method="POST">
          <div class="input-group mb-3">
            <span class="input-group-text bg-white border-end-0">
              <img src="./images/profile.png" class="icon" alt="User">
            </span>
            <input type="text" name="user_id" class="form-control border-start-0" placeholder="ENTER User ID" required>
          </div>
          <div class="input-group mb-3">
            <span class="input-group-text bg-white border-end-0">
              <img src="./images/lock.png" class="icon" alt="Password">
            </span>
            <input type="password" name="password" class="form-control border-start-0" placeholder="ENTER Password" required>
          </div>
          <div class="d-grid">
            <button type="submit" class="btn btn-success proceed-btn">Log In</button>
          </div>
        </form>

        <div class="text-center mt-3">
          <small>Don't have an admin account?<br><a href="r_admin.php" class="text-primary fw-bold">Register Here</a></small>
        </div>
      </div>
    </div>
  </div>

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
