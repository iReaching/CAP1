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
<div class="container-fluid g-0">
    <div class="row g-0">
      <!-- Left Side -->
      <div class="col-lg-5 left-section d-flex flex-column justify-content-center align-items-start">
        <div class="branding position-relative ms-4">
          <img src="./images/heart-logo.png" alt="Logo" class="logo-image">
          <div class="branding-text">
            <h1 class="ka mb-0">KA</h1>
            <h2 class="bayan">Bayan!</h2>
            <h2 class="musta">Musta</h2>
          </div>
        </div>
      </div>

      <!-- Right Side -->
      <div class="col-lg-7 right-section d-flex flex-column">
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
            <div class="text-center mb-3">
              <img
                src="./images/vilman-logo.png"
                class="vilman-logo mb-2"
                alt="VilMan Logo"
              />
              <h3 class="vilman-text">VilMan</h3>
            </div>

            <!-- User ID Field -->
            <div class="input-group mt-3">
              <span class="input-group-text">
                <img
                  src="./images/profile.png"
                  class="icon"
                  alt="User"
                />
              </span>
              <input
                type="text"
                class="form-control"
                placeholder="ENTER User ID"
              />
            </div>

            <!-- Password Field -->
            <div class="input-group mt-3">
              <span class="input-group-text">
                <img
                  src="./images/lock.png"
                  class="icon"
                  alt="Password"
                />
              </span>
              <input
                type="password"
                class="form-control"
                placeholder="ENTER Password"
              />
            </div>

            <!-- Remember Me & Forgot Password -->
            <div class="d-flex justify-content-between align-items-center mt-2">
              <div>
                <input type="checkbox" id="rememberMe" />
                <label for="rememberMe">Remember Me</label>
              </div>
              <a href="#" class="forgot-password">Forgot Password?</a>
            </div>

            <!-- Login Button -->
            <button class="btn btn-custom w-100 mt-3">LOGIN</button>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
