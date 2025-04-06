<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Roles Selection | VilMan</title>
    <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

<!-- Custom CSS -->
<link rel="stylesheet" href="css/roles-bootstrap.css?v=1.01">

<!-- Google Fonts -->
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;700;900&display=swap" rel="stylesheet">
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

    <!-- Main Content -->
    <div class="container text-center">
        <h2 class="welcome">WELCOME | <span class="villagers">Villagers</span></h2>
        <p class="subtitle">Please pick the designated profile of yours</p>

        <!-- Role Selection Cards -->
        <div class="row justify-content-center">
            <div class="col-md-4">
                <div class="role-card my-4 mx-1">
                    <img src="./images/homeowner.png" class="profile-icon" alt="Visitor">
                    <p class="account-text">HOMEOWNERS</p>
                    <a href="login_homeowner.php" class="btn btn-custom">CLICK HERE</a>
                </div>
            </div>
            <div class="col-md-4 my-4 mx-1">
                <div class="role-card">
                    <img src="./images/staff.png" class="profile-icon" alt="Staff">
                    <p class="account-text">STAFF</p>
                    <a href="login_staff.php" class="btn btn-custom">CLICK HERE</a>
                </div>
            </div>
            <div class="col-md-4 my-4 mx-1">
              <div class="role-card">
                <img src="./images/guard.png" class="profile-icon" alt="Guard">
                <p class="account-text">GUARD</p>
                <a href="login_guard.php" class="btn btn-custom">CLICK HERE</a>
              </div>
            </div>
        </div>
    </div>






















    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
