<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Visitors Login | VilMan</title>
  <!-- Bootstrap CSS -->
  <link
    href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css"
    rel="stylesheet"
  />
  <link rel="stylesheet" href="./css/login_visitor.css" />
  <link
    href="https://fonts.googleapis.com/css2?family=Inter:wght@400;700&display=swap"
    rel="stylesheet"
  />
</head>
<body>

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
    document.addEventListener("DOMContentLoaded", function(){
       var loginModalEl = document.getElementById('loginSuccessModal');
       var loginModal = new bootstrap.Modal(loginModalEl);
       loginModal.show();
       loginModalEl.addEventListener('hidden.bs.modal', function () {
           window.location.href = 'dashboard.php';
       });
    });
  </script>
<?php unset($_SESSION["login_success"]); endif; ?>

<!-- popup for register successful-->
<?php if (isset($_SESSION["register_success"])): ?>
  <div class="modal fade" id="registerSuccessModal" tabindex="-1" aria-labelledby="registerSuccessModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
         <div class="modal-header">
           <h5 class="modal-title" id="registerSuccessModalLabel">Registration Successful</h5>
           <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
         </div>
         <div class="modal-body">
           <?php echo $_SESSION["register_success"]; ?>
         </div>
         <div class="modal-footer">
           <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
         </div>
      </div>
    </div>
  </div>
  <script>
    document.addEventListener("DOMContentLoaded", function(){
       var registerModalEl = document.getElementById('registerSuccessModal');
       var registerModal = new bootstrap.Modal(registerModalEl);
       registerModal.show();
       // Optionally, you can auto-redirect after registration success modal is closed
       // registerModalEl.addEventListener('hidden.bs.modal', function () {
       //     window.location.href = 'login_visitor.php';
       // });
    });
  </script>
<?php unset($_SESSION["register_success"]); endif; ?>

























<!-- main html code-->




<div class="container-fluid g-0">
    <div class="row g-0">
      <!-- Left Side -->
      <div class="col-lg-6 left-section d-flex flex-column align-items-center justify-content-center">
      
        <div class="branding position-absolute ms-0">
          
          <img src="./images/fingerheart.png" alt="Logo" class="logo-image">
          <div class="branding-text">
            <h1 class="ka mb-0">KA</h1>
            <h2 class="bayan">Bayan!</h2>
            <h2 class="musta">Musta</h2>
          </div>
        </div>
  <!-- Register Title -->
  <div class="register-title px-4 pt-4 pb-1">
    <h2 class="mb-0">Register</h2>
  </div>

  <!-- 📌 This div wraps the form with the pink background box -->
  <form action="register.php" method="POST">




  <div class="login-box p-4">
    <div class="text-center mb-3">
      <img src="./images/vilmanlogo.png" class="vilman-logo mb-2" alt="VilMan Logo" />
      <h3 class="vilman-text">REGISTER TO VilMan</h3>
    </div>

    <!-- User ID Field -->
    <div class="input-group mt-3">
      <span class="input-group-text">
        <img src="./images/profile.png" class="icon" alt="User" />
      </span>
      <input type="text" class="form-control" name="user_id" placeholder="ENTER User ID" required />
    </div>

    <!-- Email Field -->
    <div class="input-group mt-3">
      <span class="input-group-text">
        <img src="./images/email.png" class="icon" alt="Email" />
      </span>
      <input type="email" class="form-control" name="email" placeholder="ENTER Email" required />
    </div>

    <!-- Password Field -->
    <div class="input-group mt-3">
      <span class="input-group-text">
        <img src="./images/lock.png" class="icon" alt="Password" />
      </span>
      <input type="password" class="form-control" name="password" placeholder="ENTER Password" required />
    </div>

    <!-- Register Button -->
    <button type="submit" class="btn btn-custom w-100 mt-3">REGISTER</button>
    <div class="register-title px-2 pt-4 pb-0">
    <h5 class="mb-0" color="blue">Already Registered? Check Right side.</h2>
    </div>
  </div> <!-- End of register-box -->
  </form>
</div>


      <!-- Right Side -->

      <div class="col-lg-6 right-section d-flex flex-column">
        <!-- "Visitors" Title -->
        <div class="visitors-title">
        </div>

        <!-- Horizontal Line -->
        <div class="visitors-line mx-4 mb-4"></div>

        <!-- Login Form -->
        <div class="d-flex flex-column align-items-center justify-content-center flex-grow-1">
        <div class="visitors-title px-4 pt-4 pb-1">
        <h2 class="mb-0">Visitors</h2></div>
          <div class="login-box p-4">
          <?php if (isset($_SESSION["login_error"])): ?>
            <div class="alert alert-danger text-center">
              <?php echo $_SESSION["login_error"]; ?>
            </div>
            <?php unset($_SESSION["login_error"]); ?>
          <?php endif; ?>

            <div class="text-center mb-3">
              <img
                src="./images/vilmanlogo.png"
                class="vilman-logo mb-2"
                alt="VilMan Logo"
              />
              <h3 class="vilman-text">LOGIN TO VilMan</h3>
            </div>
            <form action="login.php" method="POST">
            <!-- User ID Field -->
            <div class="input-group mt-3">
              <span class="input-group-text">
                <img src="./images/profile.png" class="icon" alt="User" />
              </span>
              <input type="text" class="form-control" name="user_id" placeholder="ENTER User ID" required>
            </div>

            <!-- Password Field -->
            <div class="input-group mt-3">
              <span class="input-group-text">
                <img src="./images/lock.png" class="icon" alt="Password" />
              </span>
              <input type="password" class="form-control" name="password" placeholder="ENTER Password" required>
            </div>

            <!-- Remember Me & Forgot Password -->
            <div class="d-flex justify-content-between align-items-center mt-2">
              <div>
                <input type="checkbox" id="rememberMe">
                <label for="rememberMe">Remember Me</label>
              </div>
              <a href="#" class="forgot-password">Forgot Password?</a>
            </div>

            <!-- Login Button -->
            <button type="submit" class="btn btn-custom w-100 mt-3">LOGIN</button>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>














  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>









<!-- Register Modal -->
<div class="modal fade" id="registerModal" tabindex="-1" aria-labelledby="registerModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="registerModalLabel">Registration Successful</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        You have successfully registered! Please log in to continue.
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<!-- Login Modal -->
<div class="modal fade" id="loginModal" tabindex="-1" aria-labelledby="loginModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="loginModalLabel">Login Successful</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        You have successfully logged in! Redirecting to your dashboard...
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>













</html>

