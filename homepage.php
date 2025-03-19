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
        .facilities-container {
            margin: 30px auto;
            max-width: 900px;
        }
        .schedule-container {
            margin: 30px auto;
            max-width: 900px;
            background: #f8f0e3;
            padding: 20px;
            border-radius: 10px;
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
        <h2>Mabuhay!</h2>
        <h1>WELCOME to VilMan!</h1>
    </div>

    <div class="container facilities-container">
        <h2 class="text-center">FACILITIES</h2>
        <div class="card p-3">
            <img src="your-image.png" alt="Facility" class="card-img-top">
            <div class="card-body">
                <h5 class="card-title">Clubhouse</h5>
                <p class="card-text">A building or area used for social or recreational activities, serving as a central gathering place for residents.</p>
                <button class="btn btn-success">ADD</button>
                <button class="btn btn-danger">REMOVE</button>
            </div>
        </div>
    </div>

    <div class="container schedule-container">
        <h2 class="text-center">SCHEDULE</h2>
        <table class="table">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>House ID</th>
                    <th>Date</th>
                    <th>Message</th>
                    <th>Type</th>
                    <th>Time Interval</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php for ($i = 0; $i < 5; $i++): ?>
                <tr>
                    <td>John Doe</td>
                    <td>123</td>
                    <td>2025-03-20</td>
                    <td>Event</td>
                    <td>Clubhouse</td>
                    <td>10:00 - 12:00</td>
                    <td>
                        <button class="btn btn-success">Approve</button>
                        <button class="btn btn-danger">Reject</button>
                    </td>
                </tr>
                <?php endfor; ?>
            </tbody>
        </table>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
