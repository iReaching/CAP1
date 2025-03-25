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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="css/homepage.css?v=1.0.1">

</head>
<body>
<!-- ADMINISTRATOR Header -->
<nav class="navbar navbar-expand-lg navbar-dark bg-highbar">
  <div class="container-fluid d-flex justify-content-between align-items-center">

    <!-- Left: Logo + Text -->
    <div class="d-flex align-items-center">
      <img src="./images/vilmanlogo.png" alt="VilMan Logo" class="topbar-logo me-2">
      <a href="#"><span class="topbar-text text-white fw-bold">VilMan</span></a>
    </div>

    <!-- Center: ADMINISTRATOR -->
    <div class="text-white fw-bold fs-3 text-center flex-grow-1 position-absolute start-50 translate-middle-x">
      ADMINISTRATOR
    </div>

    <!-- Right: User Session -->
    <div class="d-flex align-items-center">
      <div class="bg-light rounded-pill d-flex align-items-center px-3 py-1">
        <img src="./images/profile.png" alt="User" width="25" height="25" class="me-2 rounded-circle">
        <span class="fw-semibold">Rosca, A.</span>
      </div>
    </div>

  </div>
</nav>


<!-- Navigation Bar -->
<nav class="navbar navbar-expand-lg navbar-dark bg-topbar">
  <div class="container-fluid px-4">

    <!-- Navigation Links -->
    <div class="collapse navbar-collapse justify-content-center">
      <ul class="navbar-nav mb-2 mb-lg-0">
        <li class="nav-item"><a class="nav-link" href="#home">HOME</a></li>
        <li class="nav-item"><a class="nav-link" href="#amenities">AMENITIES</a></li>
        <li class="nav-item"><a class="nav-link" href="#item">ITEM</a></li>
        <li class="nav-item"><a class="nav-link" href="#report">REPORT</a></li>
        <li class="nav-item"><a class="nav-link" href="#entrylog">ENTRY LOG</a></li>
        <li class="nav-item"><a class="nav-link" href="#account">ACCOUNT</a></li>
      </ul>
    </div>

    
  </div>
</nav>



<!-- HOME SECTION -->
<section id="home" class="bg-home-section py-5">
  <div class="container-fluid">
    <div class="row align-items-center px-5">
      <!-- Logo -->
      <div class="col-md-5 text-center">
        <img src="./images/vilmanlogo.png" alt="VilMan Logo" class="img-fluid welcome-logo">
      </div>

      <!-- Text -->
      <div class="col-md-7">
        <h2 class="fw-bold mabuhay-heading">Mabuhay!</h2>
        <hr class="welcome-hr">
        <h1 class="fw-bold welcome-heading">WELCOME<br>to VilMan!</span></h1>
      </div>
    </div>
  </div>
</section>
























<!-- AMENITIES SECTION -->
<section id="amenities" class="bg-light py-5">
  <div class="container-fluid">
    <h2 class="text-center fw-bold mb-5">FACILITIES</h2>
    <div class="row">
      
      <!-- Facilities Carousel -->
      <div class="col-md-6 text-center px-5">
        <div class="carousel-container border rounded p-3">
          <img src="./images/facility1.jpg" class="img-fluid border rounded mb-3" alt="Facility" style="max-height: 300px; object-fit: cover;">
          
          <!-- Facility Controls -->
          <div class="input-group mb-3">
          <input type="text" class="form-control w-50 text-center" placeholder="Enter Amenity Name (e.g. Clubhouse)" />
            <button class="btn btn-success ms-2">Change Images</button>
          </div>
          
          <div class="form-floating mb-3">
            <textarea class="form-control" id="facilityDesc" style="height: 100px;" readonly>A building or area used for social or recreational activities, serving as a central gathering place for residents</textarea>
            <label for="facilityDesc">Description</label>
          </div>

          <div class="d-flex justify-content-center gap-3">
            <button class="btn btn-success px-4">ADD</button>
            <button class="btn btn-danger px-4">REMOVE</button>
          </div>

          <!-- Dot indicators -->
          <div class="mt-3">
            <span class="dot mx-1"></span>
            <span class="dot mx-1"></span>
            <span class="dot mx-1"></span>
            <span class="dot mx-1 active-dot"></span>
            <span class="dot mx-1"></span>
            <span class="dot mx-1"></span>
            <span class="dot mx-1"></span>
          </div>
        </div>
      </div>

      <!-- Schedule Table -->
      <div class="col-md-6">
        <div class="bg-light border p-3 rounded shadow-sm">
          <h3 class="text-center fw-bold mb-4">SCHEDULE</h3>
          <table class="table table-bordered text-center align-middle">
            <thead class="table-light">
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
                  <button class="btn btn-success btn-sm">Approve</button>
                  <button class="btn btn-danger btn-sm">Reject</button>
                </td>
              </tr>
              <?php endfor; ?>
            </tbody>
          </table>

          <!-- Pagination -->
          <div class="d-flex justify-content-center mt-3">
            <nav>
              <ul class="pagination mb-0">
                <li class="page-item"><a class="page-link" href="#"><i class="bi bi-chevron-double-left"></i></a></li>
                <li class="page-item active"><a class="page-link" href="#">1</a></li>
                <li class="page-item"><a class="page-link" href="#">2</a></li>
                <li class="page-item"><a class="page-link" href="#">3</a></li>
                <li class="page-item"><a class="page-link" href="#">4</a></li>
                <li class="page-item"><a class="page-link" href="#">5</a></li>
                <li class="page-item"><a class="page-link" href="#">...</a></li>
                <li class="page-item"><a class="page-link" href="#">29</a></li>
                <li class="page-item"><a class="page-link" href="#"><i class="bi bi-chevron-double-right"></i></a></li>
              </ul>
            </nav>
          </div>
        </div>
      </div>

    </div>
  </div>
</section>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>