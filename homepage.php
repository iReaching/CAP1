<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: l_admin.php");
    exit();
}
require 'db_connect.php';

$profile = [
  'full_name' => '',
  'contact_number' => '',
  'profile_pic' => './images/profile.png' // default fallback
];

if (isset($_SESSION['user_id'])) {
    $stmt = $conn->prepare("SELECT * FROM user_profiles WHERE user_id = ?");
    $stmt->bind_param("s", $_SESSION['user_id']);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($row = $result->fetch_assoc()) {
        $profile['full_name'] = $row['full_name'] ?? '';
        $profile['contact_number'] = $row['contact_number'] ?? '';
        $profile['profile_pic'] = $row['profile_pic'] ?: './images/profile.png';
    }
}

$stmt = $conn->query("SELECT * FROM amenities");
$amenities = $stmt->fetch_all(MYSQLI_ASSOC);
// Fetch all amenity requests to show in the admin SCHEDULE section
$schedule_stmt = $conn->query("SELECT * FROM amenity_schedule ORDER BY created_at DESC");
$schedule_requests = $schedule_stmt->fetch_all(MYSQLI_ASSOC);


// Fetch amenity schedule requests with amenity name
$schedule_stmt = $conn->query("
  SELECT s.*, a.name AS amenity_name
  FROM amenity_schedule s
  JOIN amenities a ON s.amenity_id = a.id
  ORDER BY s.request_date DESC
");
$schedule_requests = $schedule_stmt->fetch_all(MYSQLI_ASSOC);

// Fetch items from database
$sql = "SELECT * FROM items";
$result = $conn->query($sql);
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









<!-- User Session / Settings Icon -->
<div class="d-flex align-items-center">
  <button class="btn bg-light rounded-pill d-flex align-items-center px-3 py-1" data-bs-toggle="modal" data-bs-target="#accountSettingsModal">
    <img src="<?php echo $profile['profile_pic']; ?>" alt="User" width="25" height="25" class="me-2 rounded-circle">
    <span class="fw-semibold me-2"><?php echo $_SESSION['user_id']; ?></span>
    
  </button>
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
        <li class="nav-item"><a class="nav-link" href="#items-section">ITEM</a></li>
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
    <h2 class="text-center fw-bold mb-5">AMENITIES</h2>
    <div class="row">
      
    <div class="col-md-6 text-center px-5">
    <div class="border rounded p-3 bg-white shadow-sm">
      <!-- Toggle Buttons -->
      <div class="btn-group w-100 mb-4" role="group">
        <button class="btn btn-tab fw-bold active" id="tab-view">VIEW AMENITY</button>
        <button class="btn btn-tab fw-bold" id="tab-add">ADD AMENITY</button>
        <button class="btn btn-tab fw-bold" id="tab-edit">EDIT AMENITY</button>
      </div>
      <!-- View Amenities Section -->
        <div id="viewAmenitiesSection">
          <?php foreach ($amenities as $amenity): ?>
            <div class="carousel-container border rounded p-3 mb-4 amenity-item">
              <img src="<?php echo $amenity['image']; ?>" class="img-fluid border rounded mb-3" alt="Facility" style="max-height: 300px; object-fit: cover;">
              <div class="form-control text-center fw-semibold mb-3">
                <?php echo htmlspecialchars($amenity['name']); ?>
              </div>
              <div class="form-control text-start mb-3" style="height: 150px; overflow-y: auto;">
                <?php echo nl2br(htmlspecialchars($amenity['description'])); ?>
              </div>
            </div>
          <?php endforeach; ?>
        </div>
          <div class="d-flex justify-content-center align-items-center dot-pagination mt-3">
            <button id="prevBtn" class="btn btn-outline-secondary btn-sm me-2">
              <i class="bi bi-chevron-left"></i>
            </button>

            <span class="dot mx-1"></span>
            <span class="dot mx-1"></span>
            <span class="dot mx-1"></span>
            <span class="dot mx-1"></span>
            <span class="dot mx-1"></span>
            <span class="dot mx-1"></span>
            <span class="dot mx-1"></span>

            <button id="nextBtn" class="btn btn-outline-secondary btn-sm ms-2">
              <i class="bi bi-chevron-right"></i>
            </button>
          </div>



      <!-- Add Amenity Section (hidden by default) -->
      <div id="addAmenitySection" style="display: none;">
        <div class="border rounded p-3 mb-4 bg-white shadow-sm">
          <h4 class="text-center fw-bold mb-3">Add New Amenity</h4>
          <form action="add_amenity.php" method="POST" enctype="multipart/form-data">
            <div class="mb-3">
              <input type="text" name="name" class="form-control" placeholder="Amenity Name" required>
            </div>
            <div class="mb-3">
              <textarea name="description" class="form-control" placeholder="Amenity Description" rows="3" required></textarea>
            </div>
            <div class="mb-3">
              <input type="file" name="image" accept="image/*" class="form-control" required>
            </div>
            <div class="d-grid">
              <button type="submit" class="btn btn-success">Add Amenity</button>
            </div>
          </form>
        </div>
      </div>

      <div id="editAmenitySection" style="display: none;">
        <div class="border rounded p-3 mb-4 bg-white shadow-sm">
          <h4 class="text-center fw-bold mb-3">Edit Existing Amenity</h4>
          <form action="edit_amenity.php" method="POST" enctype="multipart/form-data">
            <div class="mb-3">
              <label class="form-label fw-semibold">Select Amenity</label>
              <select name="amenity_id" class="form-select" required>
                <option value="" disabled selected>Select an amenity</option>
                <?php foreach ($amenities as $amenity): ?>
                  <option value="<?php echo $amenity['id']; ?>">
                    <?php echo htmlspecialchars($amenity['name']); ?>
                  </option>
                <?php endforeach; ?>
              </select>
            </div>
            <div class="mb-3">
              <label class="form-label fw-semibold">New Name</label>
              <input type="text" name="new_name" class="form-control" placeholder="Leave blank to keep current name">
            </div>
            <div class="mb-3">
              <label class="form-label fw-semibold">New Description</label>
              <textarea name="new_description" class="form-control" placeholder="Leave blank to keep current description" rows="3"></textarea>
            </div>
            <div class="mb-3">
              <label class="form-label fw-semibold">New Image</label>
              <input type="file" name="new_image" accept="image/*" class="form-control">
              <small class="text-muted">Optional — only choose a file if you want to replace the current image.</small>
            </div>

            <div class="d-grid">
              <button type="submit" class="btn btn-warning">Update Amenity</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div> <!-- End of Left Column -->



    

    <!-- Schedule Requests Overview -->
      <div class="col-md-6">
        <div class="bg-light border p-4 rounded shadow-sm">
          <h3 class="text-center fw-bold mb-4">Amenity Requests</h3>

          <?php if (isset($_SESSION['message'])): ?>
            <div class="alert alert-info">
              <?= htmlspecialchars($_SESSION['message']); ?>
            </div>
            <?php unset($_SESSION['message']); ?>
          <?php endif; ?>

          <?php if (empty($schedule_requests)): ?>
            <p class="text-center text-muted">No amenity requests found.</p>
          <?php else: ?>
            <div class="table-responsive">
              <table class="table table-bordered text-center align-middle">
                <thead class="table-light">
                  <tr>
                    <th>User ID</th>
                    <th>House ID</th>
                    <th>Date</th>
                    <th>Amenity</th>
                    <th>Message</th>
                    <th>Time</th>
                    <th>Status</th>
                  </tr>
                </thead>
                <tbody>
                  <?php foreach ($schedule_requests as $req): ?>
                    <tr>
                      <td><?= htmlspecialchars($req['homeowner_id']) ?></td>
                      <td><?= htmlspecialchars($req['house_id']) ?></td>
                      <td><?= htmlspecialchars($req['request_date']) ?></td>
                      <td><?= htmlspecialchars($req['amenity_name']) ?></td>
                      <td><?= htmlspecialchars($req['message']) ?></td>
                      <td><?= htmlspecialchars($req['time_start']) ?> - <?= htmlspecialchars($req['time_end']) ?></td>
                      <td>
                        <?php if ($req['status'] === 'pending'): ?>
                          <form action="update_schedule_status.php" method="POST" class="d-inline">
                            <input type="hidden" name="id" value="<?= $req['id'] ?>">
                            <input type="hidden" name="action" value="approve">
                            <button type="submit" class="btn btn-success btn-sm mb-1">Approve</button>
                          </form>
                          <form action="update_schedule_status.php" method="POST" class="d-inline">
                            <input type="hidden" name="id" value="<?= $req['id'] ?>">
                            <input type="hidden" name="action" value="reject">
                            <button type="submit" class="btn btn-danger btn-sm">Reject</button>
                          </form>
                        <?php else: ?>
                          <span class="badge bg-<?= $req['status'] === 'approved' ? 'success' : 'danger' ?>">
                            <?= ucfirst($req['status']) ?>
                          </span>
                        <?php endif; ?>
                      </td>
                    </tr>
                  <?php endforeach; ?>
                </tbody>
              </table>
            </div>
          <?php endif; ?>
        </div>
      </div>

    </div> <!-- end of row -->

    </div>
  </div>
</section>























<!-- items section -->
<div class="container-fluid">
  <div class="row">
    <!-- Sidebar -->
    <nav class="col-md-2 bg-light vh-100 d-flex flex-column align-items-start py-4 px-3 border-end">
      <a href="#items-section" class="btn w-100 text-start mb-2 fw-bold active" id="tab-item">ITEM</a>
      <a href="#schedule-section" class="btn w-100 text-start mb-2 fw-bold" id="tab-schedule">SCHEDULE</a>
    </nav>

    <!-- Content Area -->
    <main class="col-md-10 py-4 px-5">
      <section class="mt-5" id="items-section">
        <div class="container-fluid">
          <div class="row">
            <!-- Item Tabs for View, Add, Edit -->
            <div class="col-md-12 mb-3">
              <div class="mb-4 border rounded overflow-hidden">
                <div class="d-flex">
                  <!-- Button for View Items -->
                  <button id="tab-view-items" class="tab-btn w-50 btn border-0 fw-bold py-3 bg-black text-white">VIEW ITEMS</button>
                  <!-- Button for Add Item -->
                  <button id="tab-add-item" class="tab-btn w-50 btn border-0 fw-bold py-3 bg-white text-dark">ADD ITEM</button>
                  <!-- Button for Edit Item -->
                  <button id="tab-edit-item" class="tab-btn w-50 btn border-0 fw-bold py-3 bg-white text-dark">EDIT ITEM</button>
                </div>

                <!-- Active tab indicator -->
                <div id="tabs-indicator" class="tabs-indicator"></div>
              </div>
            </div>

            <!-- Item Content Sections -->
            <div class="col-md-12">
              <!-- View Items Section -->
              <div id="view-items" class="tab-content active">
                <h4 class="text-center mb-4">View Items</h4>
                <?php if ($result->num_rows > 0): ?>
                  <?php while ($item = $result->fetch_assoc()): ?>
                    <div class="col-md-4 mb-3">
                      <div class="card shadow-sm">
                        <div class="card-body">
                          <h5 class="card-title"><?= htmlspecialchars($item['name']) ?></h5>
                          <img src="<?= htmlspecialchars($item['image']) ?>" class="img-fluid mb-3" alt="<?= htmlspecialchars($item['name']) ?>" />
                          <p class="card-text"><?= htmlspecialchars($item['description']) ?></p>
                          <p>Available: <?= htmlspecialchars($item['available']) ?></p>
                          <p>Borrowed: <?= htmlspecialchars($item['borrowed']) ?></p>
                        </div>
                      </div>
                    </div>
                  <?php endwhile; ?>
                <?php else: ?>
                  <p>No items found.</p>
                <?php endif; ?>
              </div>

              <!-- Add Item Section -->
              <div id="add-item" class="tab-content">
                <h4 class="text-center mb-4">Add New Item</h4>
                <form action="add_item.php" method="POST" enctype="multipart/form-data">
                  <div class="mb-3">
                    <label for="item-name" class="form-label">Item Name</label>
                    <input type="text" class="form-control" id="item-name" name="name" required>
                  </div>
                  <div class="mb-3">
                    <label for="item-description" class="form-label">Item Description</label>
                    <textarea class="form-control" id="item-description" name="description" rows="3" required></textarea>
                  </div>
                  <div class="mb-3">
                    <label for="item-available" class="form-label">Available Item</label>
                    <input type="number" class="form-control" id="item-available" name="available" required>
                  </div>
                  <div class="mb-3">
                    <label for="item-image" class="form-label">Item Image</label>
                    <input type="file" class="form-control" id="item-image" name="image" required>
                  </div>
                  <button type="submit" class="btn btn-success">Add Item</button>
                </form>
              </div>

              <!-- Edit Item Section -->
              <div id="edit-item" class="tab-content">
                <h4 class="text-center mb-4">Edit Existing Item</h4>
                <form action="edit_item.php" method="POST" enctype="multipart/form-data">
                  <div class="mb-3">
                    <label for="edit-item-select" class="form-label">Select Item</label>
                    <select name="item_id" class="form-select" id="edit-item-select" required>
                      <option value="" disabled selected>Select an item</option>
                      <?php foreach ($result as $item): ?>
                        <option value="<?php echo $item['id']; ?>"><?php echo htmlspecialchars($item['name']); ?></option>
                      <?php endforeach; ?>
                    </select>
                  </div>
                  <div class="mb-3">
                    <label for="edit-item-name" class="form-label">New Name</label>
                    <input type="text" name="name" class="form-control" id="edit-item-name" placeholder="Leave blank to keep current name">
                  </div>
                  <div class="mb-3">
                    <label for="edit-item-description" class="form-label">New Description</label>
                    <textarea name="description" class="form-control" id="edit-item-description" placeholder="Leave blank to keep current description" rows="3"></textarea>
                  </div>
                  <div class="mb-3">
                    <label for="edit-item-available" class="form-label">New Available Item</label>
                    <input type="number" name="available" class="form-control" id="edit-item-available" placeholder="Leave blank to keep current quantity">
                  </div>
                  <div class="mb-3">
                    <label for="edit-item-image" class="form-label">New Image</label>
                    <input type="file" name="image" class="form-control" id="edit-item-image">
                  </div>
                  <button type="submit" class="btn btn-warning">Update Item</button>
                </form>
              </div>
            </div>
          </div>
        </div>
      </section>

      <!-- SCHEDULE SECTION (hidden by default) -->
      <section id="schedule-section" style="display: none;">
        <!-- Schedule Tabs -->
        <div class="mb-4 border rounded overflow-hidden">
          <div class="d-flex">
            <button id="tab-ongoing" class="w-50 btn border-0 fw-bold py-3 bg-info text-white">ONGOING</button>
            <button id="tab-borrowed" class="w-50 btn border-0 fw-bold py-3 bg-white text-dark">BORROWED</button>
          </div>
        </div>

        <!-- Ongoing Table -->
        <div id="ongoing-table">
          <div class="table-responsive border rounded p-3">
            <table class="table table-bordered align-middle text-center">
              <thead class="table-light">
                <tr>
                  <th>Borrower's NAME</th>
                  <th>Borrowed Item</th>
                  <th>Time Start</th>
                  <th>Time Returned</th>
                  <th>Date Start</th>
                  <th>Date Returned</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td><input class="form-control" readonly></td>
                  <td><input class="form-control" readonly></td>
                  <td><input class="form-control" readonly></td>
                  <td><input class="form-control" readonly></td>
                  <td><input class="form-control" readonly></td>
                  <td><input class="form-control" readonly></td>
                </tr>
                <!-- Repeat <tr> as needed -->
              </tbody>
            </table>
          </div>
        </div>

        <!-- Borrowed Table (Initially Hidden) -->
        <div id="borrowed-table" style="display: none;">
          <div class="table-responsive border rounded p-3">
            <table class="table table-bordered align-middle text-center">
              <thead class="table-light">
                <tr>
                  <th>Borrower's NAME</th>
                  <th>Borrowed Item</th>
                  <th>Time Start</th>
                  <th>Time Returned</th>
                  <th>Date Start</th>
                  <th>Date Returned</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td><input class="form-control" readonly></td>
                  <td><input class="form-control" readonly></td>
                  <td><input class="form-control" readonly></td>
                  <td><input class="form-control" readonly></td>
                  <td><input class="form-control" readonly></td>
                  <td><input class="form-control" readonly></td>
                </tr>
                <!-- Repeat <tr> as needed -->
              </tbody>
            </table>
          </div>
        </div>
      </section>
    </main>
  </div>
</div>




















<!-- MODALS SECTION -->
<!-- MODALS SECTION -->
<!-- MODALS SECTION -->
<!-- MODALS SECTION -->
<!-- MODALS SECTION -->
<!-- MODALS SECTION -->
<!-- MODALS SECTION -->
<!-- MODALS SECTION -->
<!-- MODALS SECTION -->
<!-- MODALS SECTION -->
<!-- MODALS SECTION -->
<!-- MODALS SECTION -->
<!-- MODALS SECTION -->
<!-- MODALS SECTION -->
<!-- MODALS SECTION -->
<!-- MODALS SECTION -->
<!-- MODALS SECTION -->
<!-- MODALS SECTION -->
<!-- MODALS SECTION -->
<!-- MODALS SECTION -->
<!-- MODALS SECTION -->
<!-- MODALS SECTION -->
<!-- MODALS SECTION -->
<!-- MODALS SECTION -->
<!-- MODALS SECTION -->
<!-- MODALS SECTION -->
<!-- MODALS SECTION -->
<!-- MODALS SECTION -->
<!-- MODALS SECTION -->
<!-- MODALS SECTION -->
<!-- MODALS SECTION -->
<!-- MODALS SECTION -->
<!-- MODALS SECTION -->














<!-- Account Settings Modal -->
<div class="modal fade" id="accountSettingsModal" tabindex="-1" aria-labelledby="accountSettingsModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="accountSettingsModalLabel">Account Settings</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <!-- Profile Info -->
        <div class="row">
          <div class="col-md-4 text-center">
            <img src="<?php echo $profile['profile_pic']; ?>" alt="Profile" width="120" height="120" class="rounded-circle mb-3">
            <form action="update_profile.php" method="POST" enctype="multipart/form-data">
            <input type="file" name="profile_pic" accept="image/*" class="form-control mb-2" id="profilePicInput">
            <button type="submit" class="btn btn-sm btn-primary w-100" id="uploadBtn" disabled>Update Picture</button>
            </form>
            <form action="delete_profile_pic.php" method="POST">
              <input type="hidden" name="delete_pic" value="1">
              <button type="submit" class="btn btn-outline-danger btn-sm w-100 mt-2">Remove Picture</button>
            </form>

          </div>
          <div class="col-md-8">
           <form id="accountSettingsForm" action="update_profile.php" method="POST">
              <div class="mb-3">
                <label class="form-label fw-semibold">User ID</label>
                <input type="text" class="form-control" value="<?php echo $_SESSION['user_id']; ?>" disabled>
              </div>
              <div class="mb-3">
                <label class="form-label fw-semibold">Role</label>
                <input type="text" class="form-control" value="<?php echo ucfirst($_SESSION['role']); ?>" disabled>
              </div>
              <div class="mb-3 position-relative">
                <label class="form-label fw-semibold">Full Name</label>
                <input type="text" id="fullName" name="full_name" class="form-control pe-5"
                  value="<?php echo htmlspecialchars($profile['full_name']); ?>"
                  <?php echo !empty($profile['full_name']) ? 'readonly' : ''; ?> required>
                  <i class="bi bi-pencil-square position-absolute top-50 end-0 translate-middle-y me-3 text-secondary edit-icon"
                    role="button"
                    data-bs-toggle="tooltip"
                    data-bs-placement="left"
                    title="Click to edit Full Name"
                    data-target="fullName"></i>
              </div>
              <div class="mb-3 position-relative">
                <label class="form-label fw-semibold">Contact Number</label>
                <input type="text" id="contactNumber" name="contact_number" class="form-control pe-5"
                  value="<?php echo htmlspecialchars($profile['contact_number']); ?>"
                  <?php echo !empty($profile['contact_number']) ? 'readonly' : ''; ?> required>
                  <i class="bi bi-pencil-square position-absolute top-50 end-0 translate-middle-y me-3 text-secondary edit-icon"
                    role="button"
                    data-bs-toggle="tooltip"
                    data-bs-placement="left"
                    title="Click to edit Contact Number"
                    data-target="fullName"></i>
              </div>
              <button type="submit" class="btn btn-success w-100" id="saveChangesBtn" disabled>Save Changes</button>
            </form>
          </div>
        </div>
      </div>
      <div class="modal-footer d-flex justify-content-between">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <a href="logout.php" class="btn btn-danger">Logout</a>
      </div>
    </div>
  </div>
</div>















<!-- JAVASCRIPTS SECTION -->
<!-- JAVASCRIPTS SECTION -->
<!-- JAVASCRIPTS SECTION -->
<!-- JAVASCRIPTS SECTION -->
<!-- JAVASCRIPTS SECTION -->
<!-- JAVASCRIPTS SECTION -->
<!-- JAVASCRIPTS SECTION -->
<!-- JAVASCRIPTS SECTION -->
<!-- JAVASCRIPTS SECTION -->
<!-- JAVASCRIPTS SECTION -->
<!-- JAVASCRIPTS SECTION -->
<!-- JAVASCRIPTS SECTION -->
<!-- JAVASCRIPTS SECTION -->
<!-- JAVASCRIPTS SECTION -->
<!-- JAVASCRIPTS SECTION -->
<!-- JAVASCRIPTS SECTION -->
<!-- JAVASCRIPTS SECTION -->
<!-- JAVASCRIPTS SECTION -->
<!-- JAVASCRIPTS SECTION -->
<!-- JAVASCRIPTS SECTION -->
<!-- JAVASCRIPTS SECTION -->
<!-- JAVASCRIPTS SECTION -->
<!-- JAVASCRIPTS SECTION -->
<!-- JAVASCRIPTS SECTION -->
<!-- JAVASCRIPTS SECTION -->
<!-- JAVASCRIPTS SECTION -->
<!-- JAVASCRIPTS SECTION -->
<!-- JAVASCRIPTS SECTION -->
<!-- JAVASCRIPTS SECTION -->
<!-- JAVASCRIPTS SECTION -->
<!-- JAVASCRIPTS SECTION -->
<!-- JAVASCRIPTS SECTION -->
<!-- JAVASCRIPTS SECTION -->
<!-- JAVASCRIPTS SECTION -->
<!-- JAVASCRIPTS SECTION -->
<!-- JAVASCRIPTS SECTION -->
<!-- JAVASCRIPTS SECTION -->
<!-- JAVASCRIPTS SECTION -->
<!-- JAVASCRIPTS SECTION -->
<!-- JAVASCRIPTS SECTION -->
<!-- JAVASCRIPTS SECTION -->
<!-- JAVASCRIPTS SECTION -->
<!-- JAVASCRIPTS SECTION -->
<!-- JAVASCRIPTS SECTION -->








<!-- bottom right toast popup after successfully updating the profile or profile picture -->
<?php if (isset($_SESSION['update_success']) || isset($_SESSION['update_error'])): ?>
  <div class="position-fixed bottom-0 end-0 p-3" style="z-index: 9999;">
    <div id="toastMessage" class="toast align-items-center text-bg-<?php echo isset($_SESSION['update_success']) ? 'success' : 'danger'; ?> border-0 show" role="alert" aria-live="assertive" aria-atomic="true">
      <div class="d-flex">
        <div class="toast-body">
          <?php
          echo $_SESSION['update_success'] ?? $_SESSION['update_error'];
          unset($_SESSION['update_success']);
          unset($_SESSION['update_error']);
          ?>
        </div>
        <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
      </div>
    </div>
  </div>
<?php endif; ?>



<!-- checks if there's an uploaded photo or not-->
<script>
  document.addEventListener("DOMContentLoaded", function () {
    const picInput = document.getElementById('profilePicInput');
    const uploadBtn = document.getElementById('uploadBtn');

    if (picInput && uploadBtn) {
      picInput.addEventListener('change', function () {
        uploadBtn.disabled = !picInput.value; // Enable only if something is selected
      });
    }
  });
</script>


<!-- this script handles the full name and contact input being read-only after saving changes-->
<script>
  document.addEventListener("DOMContentLoaded", function () {
  const fullNameInput = document.getElementById("fullName");
  const contactInput = document.getElementById("contactNumber");
  const saveBtn = document.getElementById("saveChangesBtn");
  const form = document.getElementById("accountSettingsForm");

  if (!fullNameInput || !contactInput || !saveBtn || !form) return;

  const originalName = fullNameInput.value;
  const originalContact = contactInput.value;

  function checkForChanges() {
    const isReadOnly = fullNameInput.hasAttribute("readonly") && contactInput.hasAttribute("readonly");
    const hasChanged =
      fullNameInput.value !== originalName || contactInput.value !== originalContact;
    saveBtn.disabled = isReadOnly || !hasChanged;
  }

  fullNameInput.addEventListener("input", checkForChanges);
  contactInput.addEventListener("input", checkForChanges);

  // Disable save initially if inputs are readonly
  checkForChanges();

  // After form submit, lock the inputs
  form.addEventListener("submit", function (e) {
    fullNameInput.setAttribute("readonly", true);
    contactInput.setAttribute("readonly", true);
  });
});
</script>









<!-- edit button on the text boxes -->  
<script>
  document.addEventListener("DOMContentLoaded", function () {
    const saveBtn = document.getElementById("saveChangesBtn");
    const fullNameInput = document.getElementById("fullName");
    const contactInput = document.getElementById("contactNumber");

    const originalName = fullNameInput.value;
    const originalContact = contactInput.value;

    const editIcons = document.querySelectorAll('.edit-icon');

    function checkForChanges() {
      const hasChanged =
        fullNameInput.value !== originalName || contactInput.value !== originalContact;
      saveBtn.disabled = !hasChanged;
    }

    editIcons.forEach(icon => {
      icon.addEventListener('click', function () {
        const targetId = icon.getAttribute('data-target');
        const input = document.getElementById(targetId);
        if (input) {
          input.removeAttribute('readonly');
          input.focus();
        }
      });
    });

    fullNameInput.addEventListener("input", checkForChanges);
    contactInput.addEventListener("input", checkForChanges);

    document.getElementById("accountSettingsForm").addEventListener("submit", function () {
      fullNameInput.setAttribute("readonly", true);
      contactInput.setAttribute("readonly", true);
    });

    checkForChanges();
  });
</script>



<!-- items section for the sidebar -->
<script>
  document.addEventListener("DOMContentLoaded", function () {
    const itemTab = document.getElementById("tab-item");
    const scheduleTab = document.getElementById("tab-schedule");
    const itemSection = document.getElementById("items-section");
    const scheduleSection = document.getElementById("schedule-section");

    itemTab.addEventListener("click", function () {
      itemTab.classList.add("active");
      scheduleTab.classList.remove("active");
      itemSection.style.display = "block";
      scheduleSection.style.display = "none";
    });

    scheduleTab.addEventListener("click", function () {
      scheduleTab.classList.add("active");
      itemTab.classList.remove("active");
      scheduleSection.style.display = "block";
      itemSection.style.display = "none";
    });
  });
</script>









<!-- script for the tabs on schedule section on ITEMS section -->

<script>
  document.addEventListener("DOMContentLoaded", function () {
    const tabOngoing = document.getElementById("tab-ongoing");
    const tabBorrowed = document.getElementById("tab-borrowed");
    const ongoingTable = document.getElementById("ongoing-table");
    const borrowedTable = document.getElementById("borrowed-table");

    tabOngoing.addEventListener("click", function () {
      tabOngoing.classList.add("bg-info", "text-white");
      tabOngoing.classList.remove("bg-white", "text-dark");

      tabBorrowed.classList.add("bg-white", "text-dark");
      tabBorrowed.classList.remove("bg-info", "text-white");

      ongoingTable.style.display = "block";
      borrowedTable.style.display = "none";
    });

    tabBorrowed.addEventListener("click", function () {
      tabBorrowed.classList.add("bg-info", "text-white");
      tabBorrowed.classList.remove("bg-white", "text-dark");

      tabOngoing.classList.add("bg-white", "text-dark");
      tabOngoing.classList.remove("bg-info", "text-white");

      ongoingTable.style.display = "none";
      borrowedTable.style.display = "block";
    });
  });
</script>


<!-- script for the tabs in items section (VIEW/EDIT/ADD) -->

<!-- New JavaScript Code for Items Section -->
<script>
document.addEventListener("DOMContentLoaded", function () {
  // Get all the tab buttons
  const tabViewItems = document.getElementById("tab-view-items");
  const tabAddItem = document.getElementById("tab-add-item");
  const tabEditItem = document.getElementById("tab-edit-item");

  // Get all the item content sections
  const viewItemsSection = document.getElementById("view-items");
  const addItemSection = document.getElementById("add-item");
  const editItemSection = document.getElementById("edit-item");

  // Get the indicator div
  const indicator = document.getElementById("tabs-indicator");

  // Function to switch between sections and move the indicator
  function showSection(tab, section) {
    // Remove active class from all buttons and sections
    tabViewItems.classList.remove("bg-black", "text-white");
    tabAddItem.classList.remove("bg-white", "text-dark");
    tabEditItem.classList.remove("bg-white", "text-dark");

    // Reset the styles for all tabs
    tabViewItems.classList.add("bg-white", "text-dark");
    tabAddItem.classList.add("bg-white", "text-dark");
    tabEditItem.classList.add("bg-white", "text-dark");

    // Hide all sections
    viewItemsSection.classList.remove("active");
    addItemSection.classList.remove("active");
    editItemSection.classList.remove("active");

    // Set the clicked tab to active
    tab.classList.add("bg-black", "text-white");
    section.classList.add("active"); // Show the corresponding section

    // Move the indicator
    const tabRect = tab.getBoundingClientRect();
    indicator.style.width = `${tabRect.width}px`;
    indicator.style.left = `${tabRect.left - tab.offsetParent.getBoundingClientRect().left}px`;
  }

  // Add event listeners for each tab button
  tabViewItems.addEventListener("click", function () {
    showSection(tabViewItems, viewItemsSection);
  });

  tabAddItem.addEventListener("click", function () {
    showSection(tabAddItem, addItemSection);
  });

  tabEditItem.addEventListener("click", function () {
    showSection(tabEditItem, editItemSection);
  });

  // Default section to display on page load (View Items)
  showSection(tabViewItems, viewItemsSection);
});
</script>






<!-- amenities section -->
<script>
  document.addEventListener("DOMContentLoaded", function () {
    const viewTab = document.getElementById("tab-view");
    const addTab = document.getElementById("tab-add");
    const editTab = document.getElementById("tab-edit");

    const viewSection = document.getElementById("viewAmenitiesSection");
    const addSection = document.getElementById("addAmenitySection");
    const editSection = document.getElementById("editAmenitySection");

    function activateTab(tab, section) {
      // Reset active classes
      [viewTab, addTab, editTab].forEach(t => t.classList.remove("active"));
      tab.classList.add("active");

      // Hide all, show selected
      [viewSection, addSection, editSection].forEach(sec => sec.style.display = "none");
      section.style.display = "block";
    }

    viewTab.addEventListener("click", function (e) {
      e.preventDefault();
      activateTab(viewTab, viewSection);
    });

    addTab.addEventListener("click", function (e) {
      e.preventDefault();
      activateTab(addTab, addSection);
    });

    editTab.addEventListener("click", function (e) {
      e.preventDefault();
      activateTab(editTab, editSection);
    });
  });
</script>



<!-- script for paging in amenitiies -->
<script>
document.addEventListener("DOMContentLoaded", function () {
  const amenities = document.querySelectorAll("#viewAmenitiesSection .carousel-container");
  const dots = document.querySelectorAll(".dot-pagination .dot");
  const nextBtn = document.getElementById("nextBtn");
  const prevBtn = document.getElementById("prevBtn");

  let currentAmenityIndex = 0;
  let fakeDotIndex = 0; // Always loops 0-6 (7 dots)

  function updateCarousel() {
    // Show current amenity
    amenities.forEach((el, i) => {
      el.style.display = i === currentAmenityIndex ? "block" : "none";
    });

    // Highlight fake dot
    dots.forEach(dot => dot.classList.remove("active-dot"));
    dots[fakeDotIndex].classList.add("active-dot");
  }

  nextBtn.addEventListener("click", () => {
    currentAmenityIndex = (currentAmenityIndex + 1) % amenities.length;
    fakeDotIndex = (fakeDotIndex + 1) % dots.length;
    updateCarousel();
  });

  prevBtn.addEventListener("click", () => {
    currentAmenityIndex = (currentAmenityIndex - 1 + amenities.length) % amenities.length;
    fakeDotIndex = (fakeDotIndex - 1 + dots.length) % dots.length;
    updateCarousel();
  });

  updateCarousel(); // Initialize
});
</script>






<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>