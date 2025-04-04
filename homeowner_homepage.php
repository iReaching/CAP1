<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login_homeowner.php");
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

// Fetch amenities from the database
$amenities = [];
$stmt = $conn->query("SELECT * FROM amenities");
if ($stmt && $stmt->num_rows > 0) {
    $amenities = $stmt->fetch_all(MYSQLI_ASSOC);
}

$sched_query = $conn->prepare("
  SELECT i.request_date, i.time_start, i.time_end, i.status, items.name AS item_name
  FROM item_schedule i
  JOIN items ON i.item_id = items.id
  WHERE i.homeowner_id = ?
  ORDER BY i.request_date DESC
");
$sched_query->bind_param("s", $_SESSION['user_id']);
$sched_query->execute();
$schedules = $sched_query->get_result();
?>





<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>VilMan - Homeowner</title>
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
      HOMEOWNER
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
      
      <!-- Facilities Carousel -->
      <div class="col-md-6 text-center px-5">
        <div class="border rounded p-3 bg-white shadow-sm">
          <div id="viewAmenitiesSection">
            <?php foreach ($amenities as $index => $amenity): ?>
              <div class="carousel-container amenity-item <?= $index === 0 ? 'active' : '' ?>" style="<?= $index !== 0 ? 'display: none;' : '' ?>">
                <img src="<?= htmlspecialchars($amenity['image']) ?>" class="img-fluid border rounded mb-3" alt="Facility" style="max-height: 300px; object-fit: cover;">
                <div class="form-control text-center fw-semibold mb-3"><?= htmlspecialchars($amenity['name']) ?></div>
                <div class="form-control text-start mb-3" style="height: 150px; overflow-y: auto;"><?= nl2br(htmlspecialchars($amenity['description'])) ?></div>
              </div>
            <?php endforeach; ?>
          </div>

          <!-- Dot Indicators with Prev/Next -->
          <div class="mt-3 d-flex justify-content-center align-items-center gap-2 dot-pagination">
            <button class="btn btn-sm btn-outline-secondary rounded-circle" id="prevBtn" aria-label="Previous">
              <i class="bi bi-chevron-left"></i>
            </button>

            <?php foreach ($amenities as $i => $dot): ?>
              <span class="dot <?= $i === 0 ? 'active-dot' : '' ?> mx-1"></span>
            <?php endforeach; ?>

            <button class="btn btn-sm btn-outline-secondary rounded-circle" id="nextBtn" aria-label="Next">
              <i class="bi bi-chevron-right"></i>
            </button>
          </div>
        </div>
      </div>





        <!-- Schedule Request Form -->
          <div class="col-md-6">
            <div class="bg-light border p-4 rounded shadow-sm">
              <h3 class="text-center fw-bold mb-4">Schedule Amenity</h3>

              <form id="scheduleForm" action="book_amenity.php" method="POST">
                
                <!-- Hidden homeowner_id -->
                <input type="hidden" name="homeowner_id" value="<?php echo htmlspecialchars($_SESSION['user_id']); ?>">

                <!-- Full Name -->
                <!-- Display Full Name (for display only) -->
                <div class="mb-3">
                  <label class="form-label fw-semibold">Full Name</label>
                  <input type="text" class="form-control" value="<?php echo htmlspecialchars($profile['full_name']); ?>" readonly>
                </div>

                <!-- House ID -->
                <div class="mb-3">
                  <label class="form-label fw-semibold">House ID</label>
                  <input type="text" name="house_id" class="form-control" required>
                </div>

                <!-- Date -->
                <div class="mb-3">
                  <label class="form-label fw-semibold">Date</label>
                  <input type="date" name="date" class="form-control" required>
                </div>

                <!-- Message -->
                <div class="mb-3">
                  <label class="form-label fw-semibold">Message / Purpose</label>
                  <textarea name="message" class="form-control" rows="2" required></textarea>
                </div>

                <!-- Amenity Type (dynamic from DB) -->
                <div class="mb-3">
                  <label class="form-label fw-semibold">Amenity Type</label>
                  <select name="amenity_id" class="form-select" required>
                    <option value="" disabled selected>Select Amenity</option>
                    <?php foreach ($amenities as $amenity): ?>
                      <option value="<?= htmlspecialchars($amenity['id']) ?>">
                        <?= htmlspecialchars($amenity['name']) ?>
                      </option>
                    <?php endforeach; ?>
                  </select>
                </div>

                <!-- Time Interval -->
                <div class="mb-3">
                  <label class="form-label fw-semibold">Time Interval</label>
                  <div class="input-group">
                    <input type="time" name="start_time" class="form-control" required>
                    <span class="input-group-text">to</span>
                    <input type="time" name="end_time" class="form-control" required>
                  </div>
                </div>

                <!-- Submit Button -->
                <div class="d-grid">
                  <button type="submit" class="btn btn-primary">Submit Request</button>
                </div>
              </form>
            </div>
          </div>

        </div>
      </div>

    </div>
  </div>
</section>























 <!-- items section -->
<div class="container-fluid">
  <div class="row">
    <!-- Sidebar -->
    <nav class="col-md-2 bg-light vh-100 d-flex flex-column align-items-start py-4 px-3 border-end">
      <div id="highlightBar" class="position-absolute start-0 top-0 bg-primary" style="width: 4px; height: 42px; transition: top 0.3s ease;"></div>
      <a href="#items-section" class="btn w-100 text-start mb-2 fw-bold active" id="tab-item">ITEM</a>
      <a href="#schedule-section" class="btn w-100 text-start mb-2 fw-bold" id="tab-schedule">SCHEDULE</a>
    </nav>

    <!-- Content Area -->
    <main class="col-md-10 py-4 px-5">
      <section class="mt-3" id="items-section">
        <div class="container-fluid">
          <h2 class="fw-bold mb-4">BORROW ITEM</h2>
          <div class="row">
            <!-- Left side: Paginated Item Display with JavaScript -->
              <div class="col-md-6">
                <div id="itemPaginationWrapper" class="border rounded p-3 bg-white shadow-sm">
                  <?php
                  $items_result = $conn->query("SELECT * FROM items");
                  $items = $items_result->fetch_all(MYSQLI_ASSOC);
                  foreach ($items as $index => $item): ?>
                    <div class="item-slide <?= $index === 0 ? '' : 'd-none' ?>">
                      <div class="card p-3 mb-3">
                        <img src="uploads/<?= htmlspecialchars($item['image']) ?>" class="img-fluid rounded mb-2" style="max-height: 250px; object-fit: contain;" alt="<?= htmlspecialchars($item['name']) ?>">
                        <div class="text-center fw-bold"><?= htmlspecialchars($item['name']) ?></div>
                        <p class="small text-muted"><?= htmlspecialchars($item['description']) ?></p>
                        <div class="d-flex justify-content-between">
                          <span>Available: <?= $item['available'] ?></span>
                          <span>Borrowed: <?= $item['borrowed'] ?></span>
                        </div>
                      </div>
                    </div>
                  <?php endforeach; ?>
                </div>

                <!-- Pagination -->
                  <div class="d-flex justify-content-center align-items-center mt-3 gap-3">
                    <button id="prevItemBtn" class="btn btn-outline-dark btn-sm rounded-circle">
                      <i class="bi bi-chevron-left"></i>
                    </button>

                    <div id="itemPaginationDots" class="d-flex gap-3"></div>

                    <button id="nextItemBtn" class="btn btn-outline-dark btn-sm rounded-circle">
                      <i class="bi bi-chevron-right"></i>
                    </button>
                  </div>

              </div>


            <!-- Right side: Borrowing Form -->
            <div class="col-md-6">
              <div class="card p-4 bg-light">
                <h5 class="text-center fw-bold mb-4">Borrowing Item</h5>
                <form action="schedule_item.php" method="POST">
                  <div class="mb-3">
                    <label class="form-label">Date</label>
                    <input type="date" class="form-control" name="request_date" required>
                  </div>
                  <div class="mb-3">
                    <label class="form-label">Message / Purpose</label>
                    <textarea class="form-control" name="message" rows="3"></textarea>
                  </div>
                  <div class="mb-3">
                    <label class="form-label">Item Name</label>
                    <select name="item_id" class="form-select" required>
                      <option value="">Select Item</option>
                      <?php $items_result = $conn->query("SELECT id, name FROM items");
                      while ($it = $items_result->fetch_assoc()): ?>
                        <option value="<?= $it['id'] ?>"><?= htmlspecialchars($it['name']) ?></option>
                      <?php endwhile; ?>
                    </select>
                  </div>
                  <div class="mb-3">
                    <label class="form-label">Time Interval</label>
                    <div class="d-flex gap-2">
                      <input type="time" class="form-control" name="time_start" required>
                      <span class="mt-2">to</span>
                      <input type="time" class="form-control" name="time_end" required>
                    </div>
                  </div>
                  <button class="btn btn-primary w-100">Submit Request</button>
                </form>
              </div>
            </div>
          </div>
        </div>
      </section>

      <!-- Schedule Section -->
      <section id="schedule-section" style="display: none;">
        <div class="container-fluid">
          <h4 class="text-center fw-bold bg-info text-white py-2">BORROWED</h4>
          <div class="border rounded p-3 bg-white">
            <table class="table table-bordered align-middle text-center">
              <thead class="table-light">
                <tr>
                  <th>Name</th>
                  <th>Item</th>
                  <th>Time Start</th>
                  <th>Time Returned</th>
                  <th>Date Start</th>
                  <th>Date Returned</th>
                </tr>
              </thead>
              <tbody>
                <?php if (!empty($schedules)): ?>
                  <?php foreach ($schedules as $sched): ?>
                    <tr>
                      <td><?= htmlspecialchars($_SESSION['user_id']) ?></td>
                      <td><?= htmlspecialchars($sched['item_name']) ?></td>
                      <td><?= htmlspecialchars($sched['request_date']) ?></td>
                      <td><?= htmlspecialchars($sched['time_start']) ?></td>
                      <td><?= htmlspecialchars($sched['time_end']) ?></td>
                      <td>
                        <?php
                          $status = $sched['status'];
                          $badgeClass = match ($status) {
                            'pending' => 'badge bg-warning text-dark',
                            'approved' => 'badge bg-success',
                            'rejected' => 'badge bg-danger',
                            default => 'badge bg-secondary'
                          };
                        ?>
                        <span class="<?= $badgeClass ?>"><?= ucfirst($status) ?></span>
                      </td>
                    </tr>
                  <?php endforeach; ?>
                <?php else: ?>
                  <tr>
                    <td colspan="6" class="text-muted text-center">No scheduled items.</td>
                  </tr>
                <?php endif; ?>
              </tbody>
            </table>
          </div>
        </div>
      </section>
    </main>
  </div>
</div>
















<!-- TOASTS SECTION (POP-UPS) -->
<!-- TOASTS SECTION (POP-UPS) -->
<!-- TOASTS SECTION (POP-UPS) -->
<!-- TOASTS SECTION (POP-UPS) -->
<!-- TOASTS SECTION (POP-UPS) -->
<!-- TOASTS SECTION (POP-UPS) -->
<!-- TOASTS SECTION (POP-UPS) -->
<!-- TOASTS SECTION (POP-UPS) -->
<!-- TOASTS SECTION (POP-UPS) -->
<!-- TOASTS SECTION (POP-UPS) -->
<!-- TOASTS SECTION (POP-UPS) -->
<!-- TOASTS SECTION (POP-UPS) -->
<!-- TOASTS SECTION (POP-UPS) -->
<!-- TOASTS SECTION (POP-UPS) -->
<!-- TOASTS SECTION (POP-UPS) -->
<!-- TOASTS SECTION (POP-UPS) -->



<!-- amenities, right side section, borrowing amenities) -->
<?php if (isset($_SESSION['update_success']) || isset($_SESSION['update_error'])): ?>
  <div class="position-fixed bottom-0 end-0 p-3" style="z-index: 9999;">
    <div id="toastMessage" class="toast align-items-center text-bg-<?php echo isset($_SESSION['update_success']) ? 'success' : 'danger'; ?> border-0 show" role="alert">
      <div class="d-flex">
        <div class="toast-body">
          <?php
            echo $_SESSION['update_success'] ?? $_SESSION['update_error'];
            unset($_SESSION['update_success'], $_SESSION['update_error']);
          ?>
        </div>
        <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
      </div>
    </div>
  </div>
<?php endif; ?>





































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





<!-- Success Modal for borrowing amenities -->
<div class="modal fade" id="scheduleSuccessModal" tabindex="-1" aria-labelledby="scheduleSuccessModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content border-success">
      <div class="modal-header bg-success text-white">
        <h5 class="modal-title" id="scheduleSuccessModalLabel">Request Submitted</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        Your amenity schedule request has been submitted. A staff member will review it shortly.
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-success" data-bs-dismiss="modal">Okay</button>
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




<!-- items section to animate the highlighting for the 2 sections -->
<script>
  document.addEventListener("DOMContentLoaded", function () {
    const itemTab = document.getElementById("tab-item");
    const scheduleTab = document.getElementById("tab-schedule");
    const itemSection = document.getElementById("items-section");
    const scheduleSection = document.getElementById("schedule-section");
    const highlightBar = document.getElementById("highlightBar");

    function moveHighlight(button) {
      const offset = button.offsetTop;
      highlightBar.style.top = offset + "px";
    }

    itemTab.addEventListener("click", function () {
      itemTab.classList.add("active");
      scheduleTab.classList.remove("active");
      itemSection.style.display = "block";
      scheduleSection.style.display = "none";
      moveHighlight(itemTab);
    });

    scheduleTab.addEventListener("click", function () {
      scheduleTab.classList.add("active");
      itemTab.classList.remove("active");
      scheduleSection.style.display = "block";
      itemSection.style.display = "none";
      moveHighlight(scheduleTab);
    });

    // Set default highlight position on page load
    moveHighlight(itemTab);
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




<script>
document.addEventListener("DOMContentLoaded", function () {
  const slides = document.querySelectorAll(".amenity-item");
  const dots = document.querySelectorAll(".dot-pagination .dot");
  const prevBtn = document.getElementById("prevBtn");
  const nextBtn = document.getElementById("nextBtn");

  let currentIndex = 0;

  function showSlide(index) {
    slides.forEach((slide, i) => {
      slide.style.display = (i === index) ? "block" : "none";
      dots[i].classList.toggle("active-dot", i === index);
    });
  }

  nextBtn.addEventListener("click", function () {
    currentIndex = (currentIndex + 1) % slides.length;
    showSlide(currentIndex);
  });

  prevBtn.addEventListener("click", function () {
    currentIndex = (currentIndex - 1 + slides.length) % slides.length;
    showSlide(currentIndex);
  });

  // Optional: Clicking dots
  dots.forEach((dot, i) => {
    dot.addEventListener("click", () => {
      currentIndex = i;
      showSlide(currentIndex);
    });
  });

  // Initialize
  showSlide(currentIndex);
});
</script>

<!-- item section pagination -->
<script>
  document.addEventListener("DOMContentLoaded", function () {
    const slides = document.querySelectorAll(".item-slide");
    const dotsContainer = document.getElementById("itemPaginationDots");
    const prevBtn = document.getElementById("prevItemBtn");
    const nextBtn = document.getElementById("nextItemBtn");
    let currentIndex = 0;

    function renderDots() {
  dotsContainer.innerHTML = '';
  slides.forEach((_, i) => {
    const dot = document.createElement('span');
    dot.className = 'dot rounded-circle';
    dot.style.width = '10px';
    dot.style.height = '10px';
    dot.style.display = 'inline-block';
    dot.style.cursor = 'pointer';
    dot.style.backgroundColor = i === currentIndex ? '#000' : '#ccc';
    dot.addEventListener('click', () => {
      currentIndex = i;
      showSlide(currentIndex);
    });
    dotsContainer.appendChild(dot);
  });
}


    function showSlide(index) {
      slides.forEach((slide, i) => {
        slide.classList.toggle('d-none', i !== index);
      });
      renderDots();
    }

    prevBtn.addEventListener("click", function () {
      currentIndex = (currentIndex - 1 + slides.length) % slides.length;
      showSlide(currentIndex);
    });

    nextBtn.addEventListener("click", function () {
      currentIndex = (currentIndex + 1) % slides.length;
      showSlide(currentIndex);
    });

    showSlide(currentIndex);
  });
</script>




<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>