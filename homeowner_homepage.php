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
        <div class="carousel-container border rounded p-3">
          <img src="./images/facility1.jpg" class="img-fluid border rounded mb-3" alt="Facility" style="max-height: 300px; object-fit: cover;">
          
          <div class="form-control text-center fw-semibold">Clubhouse</div>

          
          <div class="form-floating mb-3">
            <textarea class="form-control" id="facilityDesc" style="height: 230px;" readonly>A building or area used for social or recreational activities, serving as a central gathering place for residents</textarea>
            <label for="facilityDesc">Description</label>
          </div>

          <div class="d-flex justify-content-center gap-3">
          </div>

          <!-- Dot Indicators with Prev/Next -->
            <div class="mt-3 d-flex justify-content-center align-items-center gap-2">
            <!-- Prev Button -->
            <button class="btn btn-sm btn-outline-secondary rounded-circle" id="prevDot" aria-label="Previous">
                <i class="bi bi-chevron-left"></i>
            </button>

            <!-- Dots -->
            <div>
                <span class="dot mx-1"></span>
                <span class="dot mx-1"></span>
                <span class="dot mx-1"></span>
                <span class="dot mx-1 active-dot"></span>
                <span class="dot mx-1"></span>
                <span class="dot mx-1"></span>
                <span class="dot mx-1"></span>
            </div>

            <!-- Next Button -->
            <button class="btn btn-sm btn-outline-secondary rounded-circle" id="nextDot" aria-label="Next">
                <i class="bi bi-chevron-right"></i>
            </button>
            </div>
        </div>
    </div>

      <!-- Schedule Request Form -->
        <div class="col-md-6">
            <div class="bg-light border p-4 rounded shadow-sm">
                <h3 class="text-center fw-bold mb-4">Schedule Amenity</h3>

                <form id="scheduleForm">
                <div class="mb-3">
                    <label class="form-label fw-semibold">Full Name</label>
                    <input type="text" name="name" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">House ID</label>
                    <input type="text" name="house_id" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">Date</label>
                    <input type="date" name="date" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">Message / Purpose</label>
                    <textarea name="message" class="form-control" rows="2" required></textarea>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">Amenity Type</label>
                    <select name="type" class="form-select" required>
                    <option value="" disabled selected>Select Amenity</option>
                    <option value="Clubhouse">Clubhouse</option>
                    <option value="Basketball Court">Basketball Court</option>
                    <option value="Pool">Pool</option>
                    <!-- Add more options as needed -->
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">Time Interval</label>
                    <div class="input-group">
                    <input type="time" name="start_time" class="form-control" required>
                    <span class="input-group-text">to</span>
                    <input type="time" name="end_time" class="form-control" required>
                    </div>
                </div>

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
  <section class="mt-5" id="items-section">
  <div class="container-fluid">
  <div class="row">
  
  <!-- Single Item Card Start -->
  <div class="card mb-3 shadow-sm">
    <div class="card-body">
      <div class="row g-3 align-items-center">
        <!-- Item Name -->
        <div class="col-md-4">
          <label class="form-label fw-semibold">Name</label>
          <div class="input-group">
            <input type="text" class="form-control" value="Lawn Mower" readonly>
            <span class="input-group-text bg-light">
              <i class="bi bi-pencil-square"></i>
            </span>
          </div>
        </div>

        <!-- Image Info -->
        <div class="col-md-4">
          <label class="form-label fw-semibold">Image</label>
          <div class="input-group">
            <input type="text" class="form-control" value="lawnmower.jpg" readonly>
            <span class="input-group-text bg-light">
              <i class="bi bi-eye me-2"></i>
              <i class="bi bi-pencil-square"></i>
            </span>
          </div>
        </div>

        <!-- Quantity Info -->
        <div class="col-md-4">
          <label class="form-label fw-semibold">Item on-hand / Available / Borrowed</label>
          <div class="d-flex gap-2">
            <input type="text" class="form-control" placeholder="0" readonly>
            <input type="text" class="form-control" placeholder="0" readonly>
            <input type="text" class="form-control" placeholder="0" readonly>
          </div>
        </div>
      </div>
    </div>
  </div>
 

  <div class="card mb-3 shadow-sm">
    <div class="card-body">
      <div class="row g-3 align-items-center">
        <!-- Item Name -->
        <div class="col-md-4">
          <label class="form-label fw-semibold">Name</label>
          <div class="input-group">
            <input type="text" class="form-control" value="Lawn Mower" readonly>
            <span class="input-group-text bg-light">
              <i class="bi bi-pencil-square"></i>
            </span>
          </div>
        </div>

        <!-- Image Info -->
        <div class="col-md-4">
          <label class="form-label fw-semibold">Image</label>
          <div class="input-group">
            <input type="text" class="form-control" value="lawnmower.jpg" readonly>
            <span class="input-group-text bg-light">
              <i class="bi bi-eye me-2"></i>
              <i class="bi bi-pencil-square"></i>
            </span>
          </div>
        </div>

        <!-- Quantity Info -->
        <div class="col-md-4">
          <label class="form-label fw-semibold">Item on-hand / Available / Borrowed</label>
          <div class="d-flex gap-2">
            <input type="text" class="form-control" placeholder="0" readonly>
            <input type="text" class="form-control" placeholder="0" readonly>
            <input type="text" class="form-control" placeholder="0" readonly>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- Single Item Card End -->

  <!-- Repeat the card above for more items... -->

  <!-- Pagination -->
  <nav aria-label="Items pagination">
    <ul class="pagination justify-content-center">
      <li class="page-item disabled"><a class="page-link">«</a></li>
      <li class="page-item active"><a class="page-link">1</a></li>
      <li class="page-item"><a class="page-link">2</a></li>
      <li class="page-item"><a class="page-link">3</a></li>
      <li class="page-item disabled"><a class="page-link">...</a></li>
      <li class="page-item"><a class="page-link">15</a></li>
      <li class="page-item"><a class="page-link">»</a></li>
    </ul>
  </nav>
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


<!-- for amenities section -->
<script>
  document.getElementById("scheduleForm").addEventListener("submit", function(e) {
    e.preventDefault();
    const modal = new bootstrap.Modal(document.getElementById("scheduleSuccessModal"));
    modal.show();

    // Optional: Reset form
    this.reset();
  });
</script>



<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>