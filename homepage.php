<?php
session_start();
$user_name = 'Rosca, A.'; // Example user name, replace with dynamic session data
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>VilMan - Administrator</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            background-color: #e9ecef;
        }
        .navbar {
            background-color: #007bff;
        }
        .welcome-container {
            text-align: center;
            padding: 50px;
        }
        .welcome-container h1 {
            color: #007bff;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark px-3">
        <a class="navbar-brand text-white" href="#"> <i class="fas fa-home"></i> VilMan</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item"><a class="nav-link text-white" href="#">Home</a></li>
                <li class="nav-item"><a class="nav-link text-white" href="#">Amenities</a></li>
                <li class="nav-item"><a class="nav-link text-white" href="#">Item</a></li>
                <li class="nav-item"><a class="nav-link text-white" href="#">Report</a></li>
                <li class="nav-item"><a class="nav-link text-white" href="#">Entry Log</a></li>
                <li class="nav-item"><a class="nav-link text-white" href="#">Home Owner</a></li>
            </ul>
        </div>
        <div class="d-flex align-items-center text-white">
            <i class="fas fa-user-circle me-2"></i>
            <span><?php echo $user_name; ?></span>
        </div>
    </nav>

    <div class="container welcome-container">
        <img src="your-image.png" alt="VilMan Logo" class="img-fluid" style="max-width: 200px;">
        <h2>Mabuhay!</h2>
        <h1>WELCOME to VilMan!</h1>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
