<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Roles Selection | VilMan</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="./css/roles-bootstrap.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;700&display=swap" rel="stylesheet">
</head>
<body>

    <!-- Header -->
    <div class="header p-4 d-flex align-items-center">
        <img src="./images/vilman-logo.png" alt="VilMan Logo" class="logo">
        <h1 class="title">VilMan</h1>
    </div>

    <!-- Main Content -->
    <div class="container text-center">
        <h2 class="welcome">WELCOME | <span class="villagers">Villagers</span></h2>
        <p class="subtitle">Please pick the designated profile of yours</p>

        <!-- Role Selection Cards -->
        <div class="row justify-content-center">
            <div class="col-md-4">
                <div class="role-card">
                    <img src="./images/profile-user.png" class="profile-icon" alt="Visitor">
                    <p class="account-text">Already have an account?<br> Just click <a href="#" class="login-link">LOG IN</a></p>
                    <a href="login_visitor.php" class="btn btn-custom">Visitors</a>
                </div>
            </div>
            <div class="col-md-4">
                <div class="role-card">
                    <img src="./images/profile-user.png" class="profile-icon" alt="Home Owner">
                    <p class="account-text">Already have an account?<br> Just click <a href="#" class="login-link">LOG IN</a></p>
                    <a href="login_homeowner.php" class="btn btn-custom">Home Owners</a>
                </div>
            </div>
            <div class="col-md-4">
                <div class="role-card">
                    <img src="./images/profile-user.png" class="profile-icon" alt="Staff">
                    <p class="account-text">Already have an account?<br> Just click <a href="#" class="login-link">LOG IN</a></p>
                    <a href="login_staff.php" class="btn btn-custom">Staff</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
