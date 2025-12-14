<?php
include("connection.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Fishing Operation Manager</title>
  <link rel="stylesheet" href="style.css">
  <style>

/* Make Select2 match your .input fields */
.select2-container {
  width: 100% !important; /* ensure full width */
}

.select2-container--default .select2-selection--single {
  height: 40px !important; /* match input height */
  border: 2px solid #4f7fe9 !important;
  border-radius: 6px !important;
  padding: 4px 8px !important;
  font-size: 0.875rem !important;
  font-family: inherit !important;
  display: flex !important;
  align-items: center !important;
}

.select2-container--default .select2-selection--single .select2-selection__arrow {
  height: 100% !important;
  right: 10px !important;
}

.select2-container--default .select2-selection--single .select2-selection__rendered {
  color: #0f172a !important;
  line-height: 32px !important;
}

.select2-dropdown {
  border: 2px solid #4f7fe9 !important;
  border-radius: 6px !important;
}

/* Hover and focus states to match .input focus */
.select2-container--default .select2-selection--single:focus,
.select2-container--default.select2-container--focus .select2-selection--single {
  outline: none !important;
  border-color: #4f7fe9 !important;
  box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1) !important;
}

/* Ensure Select2 clear (X) button is visible and properly positioned */
.select2-container--default .select2-selection--single .select2-selection__clear {
  position: absolute;
  right: 32px; /* keeps X inside but not overlapping the arrow */
  top: 50%;
  transform: translateY(-50%);
  font-size: 1.1rem;
  color: #515760;
  cursor: pointer;
  transition: color 0.2s ease;
  z-index: 10;
}

.select2-container--default .select2-selection--single .select2-selection__clear:hover {
  color: #e11522; /* red hover for better visibility */
}

/* Ensure space on the right so the X doesn't overlap text */
.select2-container--default .select2-selection--single .select2-selection__rendered {
  padding-right: 2rem !important;
}


.workers-grid {
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(180px, 1fr));
  gap: 15px;
  margin-top: 20px;
}

/* Worker Card Base */
.worker-card-header {
  position: absolute;
  top: 8px;
  right: 8px;
}

/* Add space between header icons and the rest of the card */
.worker-card {
  position: relative;
  background-color: rgb(194, 227, 249);
  border: 1px solid rgba(149, 171, 185, 1);
  border-radius: 8px;
  padding: 18px 12px 12px 12px; /* extra padding for top icons */
  text-align: left;
  transition: box-shadow 0.3s ease, transform 0.2s ease;
}

.worker-card:hover {
  transform: translateY(-3px);
  box-shadow: 0 6px 15px rgba(0, 102, 254, 0.25);
}
.worker-card-actions {
  display: flex;
  align-items: center;
  justify-content: flex-end;
  gap: 8px;
}

/* top-left (Edit button) */
.worker-card-header-left {
  position: absolute;
  top: 8px;
  left: 8px;
}

/* top-right (Delete button) */
.worker-card-header-right {
  position: absolute;
  top: 8px;
  right: 8px;
}

.worker-btn {
  background: none;
  border: none;
  cursor: pointer;
  font-size: 1.1rem;
  color: #4f7fe9;
  transition: color 0.2s ease, transform 0.15s ease;
  width: 28px;
  height: 28px;
  display: flex;
  align-items: center;
  justify-content: center;
}

.worker-btn:hover {
  transform: scale(1.15);
}

.edit-btn:hover {
  color: #2E549C;
}

.delete-btn:hover {
  color: #E11522;
}

/* image styling */
.worker-image {
  width: 100%;
  height: 180px;
  object-fit: cover;
  border-radius: 6px;
  margin-bottom: 10px;
  margin-top: 5px;
}

/* name above picture */
.worker-name {
  font-size: 1.05rem;
  color: #082E76;
  margin-top: 26px; /* ⬅ added top margin */
  margin-bottom: 6px;
}

.worker-card button {
  margin: 5px 2px;
  padding: 5px 10px;
  border: none;
  border-radius: 4px;
  cursor: pointer;
}

/* Hoverable effect for the dashboard stat "slabs" inside .stats-grid */
.stats-grid .card {
    cursor: pointer;
}
.worker.card .card:hover {
    transform: translateY(-6px);
    box-shadow: 0 12px 30px rgba(0, 102, 254, 0.574);
}
.worker.card .card:active {
    transform: translateY(-2px);
}

.expense-search{
  display: inline-block;
}


</style>

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />

  <!-- Select2 CSS -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

<!-- jQuery (required for Select2) -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- Select2 JS -->
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

</head>

<body>
  <!-- HEADER -->
  <header class="header">
    <div class="container">
      <div class="header-bar">
        <div class="header-content">
          <i class="fa-solid fa-ship header-icon"></i>
          <div>
            <h1>Fishing Operation Manager</h1>
            <p class="header-subtitle">Track expenses, harvests & transactions.</p>
          </div>
        </div>
        <div class="header-actions">
          <button id="logout-btn" class="btn btn-outline logout-btn" onclick="confirmLogout()">
            <i class="fa-solid fa-right-from-bracket"></i>
            <span class="logout-text">Logout</span>
          </button>
        </div>
      </div>
    </div>
  </header>

  <!-- NAVIGATION -->
  <nav class="nav">
    <div class="container">
      <div class="nav-tabs">
        <button class="nav-tab active" data-tab="dashboard"><i class="fa-solid fa-chart-line nav-icon"></i> Dashboard</button>
        <button class="nav-tab" data-tab="workers"><i class="fa-solid fa-user-group nav-icon"></i> Workers</button>
        <button class="nav-tab" data-tab="expenses"><i class="fa-solid fa-money-bill nav-icon"></i> Expenses</button>
       
      </div>
    </div>
  </nav>

  <!-- MAIN -->
  <main class="main container">

    <!-- Dashboard -->
    <div id="dashboard" class="tab-content active">
      <div class="stats-grid">
        <div class="card">
          <div class="card-header-inline"><span class="card-title-sm">Total Workers</span><i class="fa-solid fa-user-group stat-icon"></i></div>
          <div class="card-body"><div class="stat-value" id="total-workers">0</div><p class="stat-label">Active employees</p></div>
        </div>
        <div class="card">
          <div class="card-header-inline"><span class="card-title-sm">Total Expenses</span><i class="fa-solid fa-coins stat-icon"></i></div>
          <div class="card-body"><div class="stat-value" id="total-expenses">₱0.00</div><p class="stat-label">Worker expenses</p></div>
        </div>

      </div>
    </div>

    <!-- Workers -->
    <div id="workers" class="tab-content"> 
  <div class="page-header">
    <div>
      <h2>Workers Management</h2>
      <p class="page-subtitle">Manage your fishing crew members</p>
    </div>

    <button class="btn btn-primary" onclick="openWorkerDialog()">
      <i class="fa-solid fa-plus"></i> Add Worker
    </button>
  </div>

  <!-- Workers Grid -->
  <div id="workers-list" class="workers-grid"></div>
</div>




    <!-- Expenses -->
    <div id="expenses" class="tab-content">
      <div class="page-header">
        <div>
          <h2>Expenses Tracking</h2>
          <p class="page-subtitle">Track transaction expenses per worker</p>
        </div>

 

        <button class="btn btn-primary" onclick="openExpenseDialog()"><i class="fa-solid fa-plus"></i> Add Expense</button>
      </div>
      <div id="expenses-list">
                   <!-- Search bar -->
<div style="margin-bottom: 15px;">
  <input type="text" id="expense-search" placeholder="Search Fisherman..." class="input" style="width: 300px; padding: 8px;">
  <button class="btn btn-primary" onclick="loadExpenses()">Search</button>
</div>

        <!-- Expenses Table -->
<table id="expenses-table" border="1" cellpadding="8" cellspacing="0" style="width:100%; background:white; border-collapse: collapse;">
  <thead style="background:#4f7fe9; color:white;">
    <tr>
      <th>Fisherman</th>
      <th>Type of Feeds</th>
      <th>Price</th>
      <th>Quantity</th>
      <th>Total Amount</th>
      <th>Date</th>
    </tr>
  </thead>
  <tbody></tbody>
  <tfoot>
    <tr style="background:#e9f0ff;">
      <td colspan="4" style="text-align:right; font-weight:bold;">Total:</td>
      <td id="total-expenses-sum" style="font-weight:bold;">₱0.00</td>
      <td></td>
    </tr>
  </tfoot>
</table>

      </div>
    </div>

   
  </main>

  <!-- ============= MODALS ============= -->
  <?php include("usermodals.php"); ?>

  <script>
  // Logout
  function confirmLogout() {
    if (confirm("Are you sure you want to log out?")) {
      window.location.href = 'slider.html';
    }
  }

  // Tabs
  document.querySelectorAll(".nav-tab").forEach(tab => {
    tab.addEventListener("click", () => {
      const target = tab.dataset.tab;
      document.querySelectorAll(".tab-content").forEach(t => t.classList.remove("active"));
      document.getElementById(target).classList.add("active");
      document.querySelectorAll(".nav-tab").forEach(b => b.classList.remove("active"));
      tab.classList.add("active");
    });
  });

  // Fetch data from database (PHP)
  async function loadDashboardData() {
    const response = await fetch("load_data.php");
    const data = await response.json();

    // Workers
    document.getElementById("total-workers").textContent = data.total_workers;

    // Expenses
    document.getElementById("total-expenses").textContent = "₱" + parseFloat(data.total_expenses).toFixed(2);

    

    // Worker List
    const list = document.getElementById("workers-list");
    list.innerHTML = data.workers.map(w => `
      <div class="card">
        <div class="card-body">
          <strong>${w.Fisherman}</strong><br>
          Permit: ${w.Permitnumber}<br>
          Similia: ₱${w.AmountofSimilia}<br>
          Age: ${w.Age}
        </div>
      </div>
    `).join("") || `<p class="empty-state">No workers yet.</p>`;
  }

  document.addEventListener("DOMContentLoaded", loadDashboardData);

  // ===================== MODAL OPEN/CLOSE =====================
function openWorkerDialog() {
  document.getElementById("worker-dialog").classList.add("active");
}
function closeWorkerDialog() {
  document.getElementById("worker-dialog").classList.remove("active");
}

function openExpenseDialog() {
  document.getElementById("expense-dialog").classList.add("active");
}
function closeExpenseDialog() {
  document.getElementById("expense-dialog").classList.remove("active");
}


document.addEventListener("DOMContentLoaded", () => {
  fetchWorkers();

  // Form submission
  document.getElementById("worker-form").addEventListener("submit", function(e) {
    e.preventDefault();
    saveWorker();
  });
});

// Open modal
function openWorkerDialog(editId = null, name = "") {
  document.getElementById("worker-dialog").style.display = "block";
  document.getElementById("worker-id").value = editId || "";
  document.getElementById("worker-name").value = name || "";
  document.getElementById("worker-modal-title").innerText = editId ? "Edit Worker" : "Add Worker";
}

// Close modal
function closeWorkerDialog() {
  document.getElementById("worker-dialog").style.display = "none";
}

// Fetch workers from database
function fetchWorkers() {
  fetch('workers_fetch.php')
    .then(res => res.json())
    .then(data => {
      const container = document.getElementById("workers-list");
      container.innerHTML = "";
      data.forEach(worker => {
        const div = document.createElement("div");
        div.className = "worker-card";
       div.innerHTML = `
  <div class="worker-card-header-left">
    <button class="worker-btn edit-btn" title="Edit Worker" onclick="window.location='edit_workers.php?id=${worker.id}'">
      <i class="fa-solid fa-pen-to-square"></i>
    </button>
  </div>

  <div class="worker-card-header-right">
    <button class="worker-btn delete-btn" title="Delete Worker" onclick="deleteWorker(${worker.id})">
      <i class="fa-solid fa-trash"></i>
    </button>
  </div>

  <div class="worker-info">
    <p class="worker-name"><strong>${worker.Fisherman}</strong></p>
  </div>

  ${worker.Picture ? `<img src="${worker.Picture}" alt="${worker.Fisherman}" class="worker-image">` : ''}

  <div class="worker-info">
    <p><strong>Permit #:</strong> ${worker.Permitnumber}</p>
    <p><strong>Similia:</strong> ₱${worker.AmountofSimilia}</p>
    <p><strong>Age:</strong> ${worker.Age}</p>
    <p><strong>Date Started:</strong> ${worker.DateStarted}</p>
  </div>
`;

        container.appendChild(div);
      });
    });
}

// Refresh the Fisherman dropdown in Expense modal
function updateExpenseDropdown() {
  fetch('workers_fetch.php')
    .then(res => res.json())
    .then(data => {
      const select = document.getElementById("expense-worker");
      if (!select) return;

      // Clear old options
      select.innerHTML = "";

      // Rebuild the options
      data.forEach(worker => {
        const option = document.createElement("option");
        option.value = worker.Fisherman; // use name directly, not ID
        option.textContent = worker.Fisherman;
        select.appendChild(option);
      });
    })
    .catch(err => console.error("Error updating dropdown:", err));
}


// Save worker (add or edit)
function saveWorker() {
  const formData = new FormData(document.getElementById("worker-form"));
  fetch('workers_save.php', { method: 'POST', body: formData })
    .then(() => {
  closeWorkerDialog();
  fetchWorkers();
  updateExpenseDropdown(); // ✅ instantly refreshes dropdown
});
 
}


// Delete worker
function deleteWorker(id) {
  if (!confirm("Are you sure you want to delete this worker?")) return;
  fetch('workers_delete.php', {
    method: 'POST',
    body: new URLSearchParams({ id })
  }).then(() => fetchWorkers());
}

document.addEventListener("DOMContentLoaded", function() {
  const feedSelect = document.getElementById("expense-category");
  const priceInput = document.getElementById("expense-price");
  const quantityInput = document.getElementById("expense-quantity");
  const totalInput = document.getElementById("expense-amount");

  function calculateTotal() {
    const price = parseFloat(priceInput.value) || 0;
    const quantity = parseFloat(quantityInput.value) || 0;
    totalInput.value = (price * quantity).toFixed(2);
  }

  feedSelect.addEventListener("change", function() {
    const selectedOption = feedSelect.options[feedSelect.selectedIndex];
    const feedPrice = parseFloat(selectedOption.getAttribute("data-price")) || 0;
    priceInput.value = feedPrice.toFixed(2);
    calculateTotal();
  });

  quantityInput.addEventListener("input", calculateTotal);
});

  </script>
</body>
</html>
