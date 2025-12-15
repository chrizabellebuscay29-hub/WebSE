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

<!-- Select2 CSS -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

<!-- jQuery + Select2 JS -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>


  <style>

/* Match size + style of your .input fields */
.select2-container {
  width: 100% !important;
}

.select2-container--default .select2-selection--single {
  height: 40px !important;
  border: 2px solid #4f7fe9 !important;
  border-radius: 6px !important;
  padding: 4px 8px !important;
  font-size: 0.875rem !important;
  display: flex !important;
  align-items: center !important;
}

.select2-container--default .select2-selection--single:focus,
.select2-container--default.select2-container--focus .select2-selection--single {
  outline: none !important;
  border-color: #4f7fe9 !important;
  box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1) !important;
}

.select2-container--default .select2-selection--single .select2-selection__arrow {
  height: 100% !important;
  right: 10px !important;
}

/* X (clear) button alignment */
.select2-container--default .select2-selection--single .select2-selection__clear {
  position: absolute;
  right: 32px;
  top: 50%;
  transform: translateY(-50%);
  font-size: 1.1rem;
  color: #515760;
  cursor: pointer;
  transition: color 0.2s ease;
  z-index: 10;
}
.select2-container--default .select2-selection--single .select2-selection__clear:hover {
  color: #e11522;
}

.select2-container--default .select2-selection--single .select2-selection__rendered {
  color: #0f172a !important;
  line-height: 32px !important;
  padding-right: 2rem !important;
}

.select2-dropdown {
  border: 2px solid #4f7fe9 !important;
  border-radius: 6px !important;
}


.harvest-records table {
  width: 100%;
  border-collapse: collapse;
  margin-top: 20px;
}
.harvest-records th, .harvest-records td {
  border: 1px solid #ccc;
  padding: 8px;
  text-align: center;
}
.harvest-records th {
  background-color: #f2f2f2;
  font-weight: bold;
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
        <button class="nav-tab" data-tab="harvests"><i class="fa-solid fa-fish nav-icon"></i> Harvests</button>
        <button class="nav-tab" data-tab="transactions"><i class="fa-solid fa-handshake nav-icon"></i> Feeds Management</button>
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
        <div class="card">
          <div class="card-header-inline"><span class="card-title-sm">Harvest Value</span><i class="fa-solid fa-fish stat-icon"></i></div>
          <div class="card-body"><div class="stat-value" id="harvest-value">₱0.00</div><p class="stat-label">Total catch value</p></div>
        </div>
        <div class="card">
          <div class="card-header-inline"><span class="card-title-sm">Net Profit</span><i class="fa-solid fa-arrow-trend-up stat-icon stat-icon-success"></i></div>
          <div class="card-body"><div class="stat-value stat-value-success" id="net-profit">₱0.00</div><p class="stat-label">Income - Expenses</p></div>
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

<div class="page-actions">
  <button class="btn btn-outline" onclick="printAllExpenses()">
    <i class="fa-solid fa-print"></i> Print All
  </button>

  <button class="btn btn-primary" onclick="openExpenseDialog()">
    <i class="fa-solid fa-plus"></i> Add Expense
  </button>
</div>


      </div>
      <div id="expenses-list">
                   <!-- Search bar -->
<div style="margin-bottom: 15px;">
  <input type="text" id="expense-search" placeholder="Search Fisherman..." class="input" style="width: 300px; padding: 8px;">
  <button class="btn btn-primary" onclick="loadExpenses()">Search</button>
</div>

<div class="form-group" style="margin-top:10px;">
  <label style="font-weight:600; color:#082E76;">
    Total Expenses
  </label>
  <input
    type="text"
    id="expense-total"
    class="input"
    readonly
    value="₱0.00"
    style="
      background:#f8fafc;
      font-weight:600;
      color:#082E76;
    "
  >
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
      
      
      <td></td>
    </tr>
  </tfoot>
</table>

<div id="expense-pagination" style="text-align:center; margin-top:15px;"></div>


      </div>
    </div>

    <!-- Harvests -->
    <div id="harvests" class="tab-content">
      <div class="page-header">
        <div>
          <h2>Harvest Records</h2>
          <p class="page-subtitle">Calculate harvest profits</p>
        </div>
        <div class="page-actions">
  <button class="btn btn-outline" onclick="printAllHarvests()">
    <i class="fa-solid fa-print"></i> Print All
  </button>
  <button class="btn btn-primary" onclick="openHarvestDialog()">
    <i class="fa-solid fa-plus"></i> Add Harvest
  </button>
</div>
      </div>
      <div id="harvests-list">
        <!-- Search bar -->
<div style="margin-bottom: 15px;">
  <input type="text" id="harvest-search" placeholder="Search Fisherman..." class="input" style="width: 300px; padding: 8px;">
  <button class="btn btn-primary" onclick="loadHarvests()">Search</button>
</div>

<!-- Harvests Table -->
<table id="harvests-table" border="1" cellpadding="8" cellspacing="0" style="width:100%; background:white; border-collapse: collapse;">
  <thead style="background:#4f7fe9; color:white;">
    <tr>
      <th>Fisherman</th>
      <th>Kilo of Fish</th>
      <th>Price/Kilo</th>
      <th>Subtotal</th>
      <th>Similia</th>
      <th>Feeds</th>
      <th>Total Expenses</th>
      <th>Profit</th>
      <th>Divided Profit</th>
      <th>Date</th>
    </tr>
  </thead>
  <tbody></tbody>
  <tfoot>
    <tr style="background:#e9f0ff;">
      
     
    </tr>
  </tfoot>
</table>
<div id="harvests-pagination"></div>



      </div>
    </div>

    <!-- Transactions -->
    <div id="transactions" class="tab-content">
      <div class="page-header">
        <div>
          <h2>Feedstocks</h2>
          <p class="page-subtitle">Record feeds availability or stocks</p>
        </div>
        <div class="page-actions">
  <button class="btn btn-outline" onclick="printTransactions()">
    <i class="fa-solid fa-print"></i> Print All
  </button>
  <button class="btn btn-primary" onclick="openTransactionDialog()">
    <i class="fa-solid fa-plus"></i> Add Transaction
  </button>
</div>
      </div>
      
      <div id="transactions-list">
        <!-- Search Bar -->
<div style="margin-bottom: 15px;">
  <input type="text" id="transaction-search" placeholder="Search Feed Name..." class="input" style="width: 300px; padding: 8px;">
  <button class="btn btn-primary" onclick="loadTransactions()">Search</button>
</div>

<!-- Feedstocks Table -->
<table id="transactions-table" border="1" cellpadding="8" cellspacing="0" style="width:100%; background:white; border-collapse: collapse;">
  <thead style="background:#4f7fe9; color:white;">
    <tr>
      <th>Name of Feeds</th>
      <th>Price per Piece</th>
      <th>Quantity</th>
      <th>Total Amount</th>
      <th>Date</th>
    </tr>
  </thead>
  <tbody></tbody>
  <tfoot>
    <tr style="background:#e9f0ff;">
      
    </tr>
  </tfoot>
</table>
<div id="transaction-pagination"></div>

      </div>
    </div>
  </main>

  <!-- ============= MODALS ============= -->
  <?php include("modals.php"); ?>

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

    // Harvest Value
    document.getElementById("harvest-value").textContent = "₱" + parseFloat(data.total_harvests).toFixed(2);

    // Profit
    document.getElementById("net-profit").textContent = "₱" + parseFloat(data.net_profit).toFixed(2);

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
  const dialog = document.getElementById("worker-dialog");
  dialog.classList.add("active");

  // 🗓 Set today's date only if the field is empty
  const dateInput = document.getElementById("worker-joined");
  if (dateInput && !dateInput.value) {
    setCurrentDate("worker-joined");
  }
}

function closeWorkerDialog() {
  document.getElementById("worker-dialog").classList.remove("active");
}

function openExpenseDialog() {
  document.getElementById("expense-dialog").classList.add("active");
  setCurrentDate("expense-date"); // 🗓 sets current date
}

function closeExpenseDialog() {
  document.getElementById("expense-dialog").classList.remove("active");
}

function openHarvestDialog() {
  document.getElementById("harvest-dialog").classList.add("active");
  setCurrentDate("harvest-date"); // 🗓 sets current date
}

function closeHarvestDialog() {
  document.getElementById("harvest-dialog").classList.remove("active");
}

function openTransactionDialog() {
  document.getElementById("transaction-dialog").classList.add("active");
  setCurrentDate("transaction-date"); // 🗓 sets current date
}

function closeTransactionDialog() {
  document.getElementById("transaction-dialog").classList.remove("active");
}

document.addEventListener("DOMContentLoaded", () => {
  fetchWorkers();

  // Form submission
  const wf = document.getElementById("worker-form");
  if (wf) {
    wf.addEventListener("submit", function(e) {
      e.preventDefault();
      saveWorker();
    });
  }
});

// Open modal (kept for compatibility)
function openWorkerDialog(editId = null, name = "") {
  const modal = document.getElementById("worker-dialog");
  if (!modal) return;
  modal.style.display = "block";
  const idInput = document.getElementById("worker-id");
  const nameInput = document.getElementById("worker-name");
  const title = document.getElementById("worker-modal-title");
  if (idInput) idInput.value = editId || "";
  if (nameInput) nameInput.value = name || "";
  if (title) title.innerText = editId ? "Edit Worker" : "Add Worker";
}

// Close modal
function closeWorkerDialog() {
  const modal = document.getElementById("worker-dialog");
  if (modal) modal.style.display = "none";
}

// ✅ Automatically set the worker date to today's date
document.addEventListener("DOMContentLoaded", function() {
  const workerDateInput = document.getElementById("worker-joined");
  if (workerDateInput) {
    const today = new Date();
    const yyyy = today.getFullYear();
    const mm = String(today.getMonth() + 1).padStart(2, '0');
    const dd = String(today.getDate()).padStart(2, '0');
    workerDateInput.value = `${yyyy}-${mm}-${dd}`;
  }
});

// ✅ When modal closes or cancel button clicked
function handleWorkerCancel() {
  const dialog = document.getElementById("worker-dialog");
  const form = document.getElementById("worker-form");
  if (dialog) dialog.classList.remove("active");
  if (form) form.reset();

  // reset the date again to today
  const workerDateInput = document.getElementById("worker-joined");
  if (workerDateInput) {
    const today = new Date();
    const yyyy = today.getFullYear();
    const mm = String(today.getMonth() + 1).padStart(2, '0');
    const dd = String(today.getDate()).padStart(2, '0');
    workerDateInput.value = `${yyyy}-${mm}-${dd}`;
  }
}


// Fetch workers from database
function fetchWorkers() {
  fetch('workers_fetch.php')
    .then(res => res.json())
    .then(data => {
      const container = document.getElementById("workers-list");
      if (!container) return;
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

      // =============================
      // Update dropdowns dynamically
      // =============================
      const expenseDropdown = document.getElementById("expense-worker");
      const harvestDropdown = document.getElementById("harvest-worker");

      if (expenseDropdown && harvestDropdown) {
        // Clear existing options
        expenseDropdown.innerHTML = '<option value="">-- Select Worker --</option>';
        harvestDropdown.innerHTML = '<option value="">-- Select Worker --</option>';

        // Add all fetched workers
        data.forEach(worker => {
          const option1 = document.createElement("option");
          option1.value = worker.Fisherman;
          option1.textContent = worker.Fisherman;
          option1.setAttribute("data-similia", worker.AmountofSimilia);

          const option2 = option1.cloneNode(true);

          expenseDropdown.appendChild(option1);
          harvestDropdown.appendChild(option2);
        });
      }
    })
    .catch(err => console.error("Error fetching workers:", err));
}

// Save worker (add or edit)
function saveWorker() {
  const form = document.getElementById("worker-form");
  if (!form) return;
  const formData = new FormData(form);
  fetch('workers_save.php', { method: 'POST', body: formData })
    .then(res => res.text())
    .then(() => {
      closeWorkerDialog();
      fetchWorkers(); // ✅ refresh worker list + dropdowns instantly
      if (typeof loadDashboard === 'function') loadDashboard(); // refresh dashboard if available
    }).catch(err => console.error("Error saving worker:", err));
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
  const feedSelect = $("#expense-category"); // now using jQuery
  const priceInput = document.getElementById("expense-price");
  const quantityInput = document.getElementById("expense-quantity");
  const totalInput = document.getElementById("expense-amount");

  // Initialize Select2
  if (feedSelect.length) {
    feedSelect.select2({
      placeholder: "-- Select Feed --",
      allowClear: true,
      width: "100%"
    });

    function calculateTotal() {
      const price = parseFloat(priceInput.value) || 0;
      const quantity = parseFloat(quantityInput.value) || 0;
      if (totalInput) totalInput.value = (price * quantity).toFixed(2);
    }

    // Use Select2's change event
    feedSelect.on("change", function() {
      const selectedOption = $(this).find(":selected");
      const feedPrice = parseFloat(selectedOption.data("price")) || 0;
      if (priceInput) priceInput.value = feedPrice.toFixed(2);
      calculateTotal();
    });

    $("#expense-quantity").on("input", calculateTotal);
  }
});


function refreshFeedsData() {
  fetch("fetch_feeds.php")
    .then(res => res.json())
    .then(data => {
      const feedSelect = document.getElementById("expense-category");
      if (!feedSelect) return;
      feedSelect.innerHTML = '<option value="">-- Select Feed --</option>';

      data.forEach(feed => {
        if (parseFloat(feed.Quantity) > 0) { // just extra safety
          const option = document.createElement("option");
          option.value = feed.NameofFeeds;
          option.textContent = `${feed.NameofFeeds} (Stock: ${feed.Quantity})`;
          option.dataset.price = feed.Price;
          feedSelect.appendChild(option);
        }
      });
    })
    .catch(err => console.error("Error fetching feeds:", err));
}




  // ===== EXPENSE FORM =====
 document.addEventListener("DOMContentLoaded", function() {
  const expenseForm = document.getElementById("expense-form");
  if (!expenseForm) return;

  expenseForm.addEventListener("submit", function(e) {
    e.preventDefault();
    const formData = new FormData(expenseForm);

    fetch("addexpense.php", {
      method: "POST",
      body: formData
    })
    .then(res => res.json())
    .then(data => {
      if (data.success) {
        showReceipt(data.receiptData, "Expense Receipt");
        closeExpenseDialog();
        expenseForm.reset();

        if (typeof loadExpenses === 'function') loadExpenses(1);     // refresh expenses
        if (typeof loadTransactions === 'function') loadTransactions(1); // refresh transactions
        refreshFeedsData();                   // refresh stock source
        if (typeof loadDashboard === 'function') loadDashboard(); // update dashboard
      } else {
        alert("❌ " + data.message);
      }
    })
    .catch(err => {
      console.error("Fetch Error:", err);
      alert("Error: Could not connect to server.");
    });
  });
});


document.getElementById && document.getElementById("harvest-form") && document.getElementById("harvest-form").addEventListener("submit", function () {
  this.querySelectorAll("input[type='text']").forEach(input => {
    input.value = input.value.replace(/,/g, '');
  });
});


  // ===== HARVEST FORM =====
  document.addEventListener("DOMContentLoaded", function () {
  const harvestForm = document.getElementById("harvest-form");
  if (harvestForm) {
    harvestForm.addEventListener("submit", function (e) {
      e.preventDefault();

      const formData = new FormData(harvestForm);

      fetch("addharvest.php", { method: "POST", body: formData })
        .then(res => res.json())
        .then(data => {
          if (data.success) {
            closeHarvestDialog();
            showReceipt(data.data, "Harvest Receipt");
            if (typeof loadHarvests === 'function') loadHarvests();
            if (typeof loadDashboard === 'function') loadDashboard();
          } else {
            alert("❌ " + data.message);
          }
        })
        .catch(err => {
          console.error(err);
          alert("Error connecting to server.");
        });
    });
  }
});

document.addEventListener("DOMContentLoaded", function() {
  const transactionForm = document.getElementById("transaction-form");

  if (transactionForm) {
    transactionForm.addEventListener("submit", function(e) {
      e.preventDefault();

      const formData = new FormData(transactionForm);

      fetch("addtransaction.php", {
        method: "POST",
        body: formData
      })
      .then(res => res.json())
      .then(data => {
        if (data.success) {
          alert(data.message);
          transactionForm.reset();
          closeTransactionDialog();
          if (typeof loadTransactions === 'function') loadTransactions();   // refresh the table dynamically
          refreshFeedsData();   // refresh dropdown for expense section
          if (typeof loadDashboard === 'function') loadDashboard();
        } else {
          alert(data.message);
        }
      })
      .catch(err => {
        console.error(err);
        alert("Error saving feed record.");
      });
    });
  }
});


// --- Print All Expenses ---
function printAllExpenses() {
  const searchValue = document.getElementById("expense-search") ? document.getElementById("expense-search").value : '';

  fetch(`print_expense.php?search=${encodeURIComponent(searchValue)}&all=1`)
    .then(res => res.json())
    .then(rows => {
      let tableHTML = `
        <table>
          <thead>
            <tr>
              <th>Fisherman</th>
              <th>Feeds</th>
              <th>Price</th>
              <th>Qty</th>
              <th>Total</th>
              <th>Date</th>
            </tr>
          </thead>
          <tbody>
      `;

      rows.forEach(e => {
        tableHTML += `
          <tr>
            <td>${e.Fisherman}</td>
            <td>${e.TypeofFeeds}</td>
            <td>₱${Number(e.Price).toLocaleString('en-PH', { minimumFractionDigits: 2 })}</td>
            <td>${Number(e.Quantity).toLocaleString()}</td>
            <td>₱${Number(e.TotalAmount).toLocaleString('en-PH', { minimumFractionDigits: 2 })}</td>
            <td>${e.TransactionDate || e.Date || ''}</td>
          </tr>
        `;
      });

      tableHTML += `</tbody></table>`;

      printWithStandardLayout("Expenses Report", tableHTML);
    })
    .catch(err => console.error("Error printing expenses:", err));
}


function printAllHarvests() {
  const searchValue = document.getElementById("harvest-search") ? document.getElementById("harvest-search").value : '';

  fetch(`print_harvests.php?search=${encodeURIComponent(searchValue)}&all=1`)
    .then(res => res.json())
    .then(rows => {
      let tableHTML = `
        <table>
          <thead>
            <tr>
              <th>Fisherman</th>
              <th>Kilo of Fish</th>
              <th>Price/Kilo</th>
              <th>Subtotal</th>
              <th>Similia</th>
              <th>Feeds</th>
              <th>Total Expenses</th>
              <th>Profit</th>
              <th>Divided Profit</th>
              <th>Date</th>
            </tr>
          </thead>
          <tbody>
      `;

      rows.forEach(h => {
        tableHTML += `
          <tr>
            <td>${h.Fisherman}</td>
            <td>${Number(h.KiloofFish).toLocaleString()}</td>
            <td>₱${Number(h.Priceperkilo).toLocaleString('en-PH')}</td>
            <td>₱${Number(h.Subtotal).toLocaleString('en-PH')}</td>
            <td>₱${Number(h.AmountofSimilia).toLocaleString('en-PH')}</td>
            <td>₱${Number(h.AmountofFeeds).toLocaleString('en-PH')}</td>
            <td>₱${Number(h.TotalExpense).toLocaleString('en-PH')}</td>
            <td>₱${Number(h.Profit).toLocaleString('en-PH')}</td>
            <td>₱${Number(h.Dividedprofit).toLocaleString('en-PH')}</td>
            <td>${h.Date}</td>
          </tr>
        `;
      });

      tableHTML += `</tbody></table>`;

      printWithStandardLayout("Harvest Report", tableHTML);
    })
    .catch(err => console.error("Error printing harvests:", err));
}




// --- Print All Feedstocks (Transactions) ---
function printTransactions() {
  const table = document.getElementById('transactions-table').outerHTML;
  const win = window.open('', '', 'width=900,height=700');
  win.document.write(`
    <html>
      <head>
        <title>All Feedstock Records</title>
        <style>
          body {
            font-family: "Segoe UI", Arial, sans-serif;
            background: #F3F9FF;
            color: #082E76;
            margin: 40px;
          }
          .report-container {
            background: white;
            border: 3px solid #2E549C;
            border-radius: 12px;
            padding: 25px 35px;
            box-shadow: 0 5px 25px rgba(0,0,0,0.15);
          }
          h2 {
            text-align: center;
            color: #082E76;
            margin-bottom: 20px;
            border-bottom: 2px solid #2E549C;
            padding-bottom: 8px;
          }
          table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
          }
          th, td {
            border: 1px solid #ccc;
            padding: 8px;
            text-align: center;
          }
          th {
            background-color: #2E549C;
            color: white;
          }
          tfoot td {
            background: #F3F9FF;
            font-weight: bold;
          }
          .footer {
            text-align: center;
            font-size: 0.85rem;
            color: #515760;
            margin-top: 25px;
          }
          @media print {
            .footer { display: none; }
            body { background: white; margin: 0; }
            .report-container { border: none; box-shadow: none; padding: 0; }
          }
        </style>
      </head>
      <body>
        <div class="report-container">
          <h2>All Feedstock Records</h2>
          ${table}
          <div class="footer">
            Printed on ${new Date().toLocaleString()} by Fishing Operation Manager
          </div>
        </div>
      </body>
    </html>
  `);
  win.document.close();
  win.print();
}


// SHOW RECEIPT MODAL
function showReceipt(data, title) {
  const content = document.getElementById('receipt-content');
  document.getElementById('receipt-title').innerText = title;
  
  // Build receipt HTML
  let html = `
    <div style="border:3px solid #2E549C; border-radius:10px; padding:20px;">
      <h3 style="text-align:center; color:#082E76;">Fishing Operation Manager</h3>
      <p style="text-align:center; font-size:14px; color:#515760;">Receipt Summary</p>
      <table style="width:100%; border-collapse:collapse; margin-top:15px;">
        ${Object.entries(data).map(([key, value]) => 
          `<tr>
             <td style="padding:6px; font-weight:bold; color:#2E549C;">${key.replace(/_/g, ' ')}</td>
             <td style="padding:6px; color:#082E76;">${value}</td>
           </tr>`
        ).join('')}
      </table>
      <p style="text-align:center; margin-top:10px; color:#515760;">
        Printed on ${new Date().toLocaleString()}
      </p>
    </div>
  `;

  content.innerHTML = html;
  document.getElementById('receipt-modal').classList.add('active');
}

// CLOSE RECEIPT MODAL
function closeReceiptModal() {
  document.getElementById('receipt-modal').classList.remove('active');
  clearAllForms();
}

function printReceipt() {
  const content = document.getElementById('receipt-content').innerHTML;
  const printWindow = window.open('', '', 'width=800,height=600');
  printWindow.document.write(`
    <html>
      <head><title>Receipt</title></head>
      <body style="font-family:Arial, sans-serif;">
        ${content}
      </body>
    </html>
  `);
  printWindow.document.close();
  printWindow.print();

  // Automatically close modal and clear forms after printing
  closeReceiptModal();
}

// Clear all modal forms after printing or closing
function clearAllForms() {
  const forms = document.querySelectorAll('.modal form');
  forms.forEach(form => form.reset());
}


// =========================
// AUTO-SET CURRENT DATE FUNCTION
// =========================
function setCurrentDate(inputId) {
  const today = new Date();
  const yyyy = today.getFullYear();
  const mm = String(today.getMonth() + 1).padStart(2, '0');
  const dd = String(today.getDate()).padStart(2, '0');
  const el = document.getElementById(inputId);
  if (el) el.value = `${yyyy}-${mm}-${dd}`;
}


function searchFisherman() {
  const fisherman = document.getElementById("expense-search").value.trim();
  if (fisherman === "") {
    alert("Please enter a fisherman name.");
    return;
  }

  fetch(`get_total_feeds.php?fisherman=${encodeURIComponent(fisherman)}`)
    .then(res => res.json())
    .then(data => {
      if (data.success) {
        const total = parseFloat(data.total) || 0;
        const el = document.getElementById("fisherman-total");
        if (el) {
          el.innerText = `Total Feeds Amount for ${fisherman}: ₱${total.toFixed(2)}`;
        }

        // 🪄 Save temporarily for Harvest autofill
        localStorage.setItem("latestFeedsTotal", total);
        localStorage.setItem("latestFisherman", fisherman);
        console.log("Saved:", fisherman, total);
      } else {
        alert("No records found for that fisherman.");
      }
    })
    .catch(err => {
      console.error("Error fetching total feeds:", err);
    });
}



  </script>
  <script>
    function printWithStandardLayout(title, tableHTML) {
  const win = window.open('', '', 'width=1100,height=700');

  win.document.write(`
    <html>
      <head>
        <title>${title}</title>
        <style>
          body {
            font-family: "Segoe UI", Arial, sans-serif;
            background: #F3F9FF;
            color: #082E76;
            margin: 40px;
          }

          .report-container {
            background: white;
            border: 3px solid #2E549C;
            border-radius: 12px;
            padding: 25px 35px;
            box-shadow: 0 5px 25px rgba(0,0,0,0.15);
          }

          h2 {
            text-align: center;
            color: #082E76;
            margin-bottom: 20px;
            border-bottom: 2px solid #2E549C;
            padding-bottom: 8px;
          }

          table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
          }

          th, td {
            border: 1px solid #ccc;
            padding: 8px;
            text-align: center;
          }

          th {
            background-color: #2E549C;
            color: white;
          }

          tfoot td {
            background: #F3F9FF;
            font-weight: bold;
          }

          .footer {
            text-align: center;
            font-size: 0.85rem;
            color: #515760;
            margin-top: 25px;
          }

          @media print {
            body {
              background: white;
              margin: 0;
            }
            .report-container {
              border: none;
              box-shadow: none;
              padding: 0;
            }
            .footer {
              display: none;
            }
          }
        </style>
      </head>

      <body>
        <div class="report-container">
          <h2>${title}</h2>
          ${tableHTML}
          <div class="footer">
            Printed on ${new Date().toLocaleString()} by Fishing Operation Manager
          </div>
        </div>
      </body>
    </html>
  `);

  win.document.close();
  win.print();
}

document.addEventListener("DOMContentLoaded", function () {
  loadDashboard();
});

function loadDashboard() {
  fetch("fetch_dashboard.php")
    .then(res => res.json())
    .then(d => {
      // Workers
      const workersEl = document.getElementById("total-workers");
      if (workersEl) {
        workersEl.textContent = d.total_workers;
      }

      // Expenses
      const expensesEl = document.getElementById("total-expenses");
      if (expensesEl) {
        expensesEl.textContent =
          "₱" + Number(d.total_expenses).toLocaleString("en-PH", {
            minimumFractionDigits: 2
          });
      }

      // Harvest value
      const harvestEl = document.getElementById("harvest-value");
      if (harvestEl) {
        harvestEl.textContent =
          "₱" + Number(d.total_harvest).toLocaleString("en-PH", {
            minimumFractionDigits: 2
          });
      }

      // Net profit
      const profitEl = document.getElementById("net-profit");
      if (profitEl) {
        profitEl.textContent =
          "₱" + Number(d.net_profit).toLocaleString("en-PH", {
            minimumFractionDigits: 2
          });
      }
    })
    .catch(err => console.error("Dashboard load error:", err));
}


  </script>

  <!-- Integrated DB-wide expense-total-by-name script (inserted as requested) -->
<script>
(function() {
  function parseNumber(str) {
    if (str === null || str === undefined || str === '') return 0;
    const cleaned = String(str).replace(/[^0-9.-]+/g, '');
    const n = parseFloat(cleaned);
    return isNaN(n) ? 0 : n;
  }

  function formatPeso(n) {
    return '₱' + (Number(n) || 0).toLocaleString('en-PH', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
  }

  // Sum rows but only include rows whose Fisherman value matches (case-insensitive contains)
  function sumRowsFiltered(rows, name) {
    if (!Array.isArray(rows)) return 0;
    const needle = (name || '').toString().trim().toLowerCase();
    return rows.reduce((acc, e) => {
      const fisherman = (e.Fisherman || e.fisherman || '').toString().toLowerCase();
      if (!needle) {
        // no filter: include all rows
      } else {
        // include only if fisherman contains the search term
        if (!fisherman.includes(needle)) return acc;
      }
      const price = parseNumber(e.Price || e.price || 0);
      const qty = parseNumber(e.Quantity || e.quantity || 0);
      const totalAmount = parseNumber(e.TotalAmount || e.total_amount || e.Total || (price * qty));
      return acc + totalAmount;
    }, 0);
  }

  // Try direct total endpoint (recommended), else fetch all rows and filter client-side.
  async function fetchDatabaseTotalForName(name = '') {
    const encoded = encodeURIComponent(name || '');

    // 1) Preferred: endpoint that returns just the total for a fisherman (fast).
    // Try ?fisherman= first (common), then ?search=
    const totalEndpoints = [
      `print_expense_total.php?fisherman=${encoded}`,
      `print_expense_total.php?search=${encoded}`,
      `print_expense.php?search=${encoded}&all=1`
    ];

    // Try endpoints in order
    for (const url of totalEndpoints) {
      try {
        const resp = await fetch(url, { cache: 'no-cache' });
        if (!resp.ok) continue;
        const j = await resp.json();

        // If endpoint returns { total: number } use it directly
        if (j && typeof j === 'object' && ('total' in j || 'sum' in j)) {
          return parseNumber(j.total || j.sum);
        }

        // If returns an array of rows -> filter by name and sum
        if (Array.isArray(j)) {
          return sumRowsFiltered(j, name);
        }

        // If returns { rows: [...] } or { data: [...] } use that
        if (j && Array.isArray(j.rows)) return sumRowsFiltered(j.rows, name);
        if (j && Array.isArray(j.data)) return sumRowsFiltered(j.data, name);

        // Some print endpoints may return an object with metadata and .rows
        if (j && Array.isArray(j.result)) return sumRowsFiltered(j.result, name);
      } catch (err) {
        // try next strategy
        console.debug('fetchDatabaseTotalForName: try failed for', url, err);
      }
    }

    // If none of the above worked, fallback: sum visible table rows filtered by name
    const tbody = document.querySelector('#expenses-table tbody');
    if (tbody) {
      let sum = 0;
      const needle = (name || '').toString().trim().toLowerCase();
      Array.from(tbody.querySelectorAll('tr')).forEach(tr => {
        const tds = tr.querySelectorAll('td');
        if (tds.length < 5) return;
        const fisherman = (tds[0].textContent || '').toLowerCase();
        if (needle && !fisherman.includes(needle)) return;
        sum += parseNumber(tds[4].textContent || '');
      });
      return sum;
    }

    return 0;
  }

  // Update #expense-total input with DB-wide total for name
  async function updateTotalForName(name = '') {
    const total = await fetchDatabaseTotalForName(name);
    const el = document.getElementById('expense-total');
    if (el) el.value = formatPeso(total);
    return total;
  }

  // Preserve original functions if present
  const originalSearchFisherman = (typeof window.searchFisherman === 'function') ? window.searchFisherman : null;
  const originalLoadExpenses = (typeof window.loadExpenses === 'function') ? window.loadExpenses : null;

  // Override searchFisherman: call original, then compute DB total for the exact search string
  window.searchFisherman = function() {
    try {
      if (originalSearchFisherman) originalSearchFisherman();
    } catch (err) {
      console.warn('original searchFisherman error:', err);
    }
    const name = (document.getElementById('expense-search') || {}).value || '';
    // compute DB-wide total for this searched name (not paged)
    updateTotalForName(name);
  };

  // Override loadExpenses similarly: keep existing behavior then compute DB total for the search term
  window.loadExpenses = function(page = 1) {
    try {
      if (originalLoadExpenses) originalLoadExpenses(page);
    } catch (err) {
      console.warn('original loadExpenses error:', err);
    }
    const name = (document.getElementById('expense-search') || {}).value || '';
    updateTotalForName(name);
  };

  // Quick visible-table sum for immediate feedback (will be overwritten by DB total when ready)
  function attachTableObserver() {
    const tbody = document.querySelector('#expenses-table tbody');
    if (!tbody) return;
    const obs = new MutationObserver(() => {
      let sum = 0;
      const needle = (document.getElementById('expense-search') || {}).value.toString().trim().toLowerCase();
      Array.from(tbody.querySelectorAll('tr')).forEach(tr => {
        const tds = tr.querySelectorAll('td');
        if (tds.length < 5) return;
        const fisherman = (tds[0].textContent || '').toLowerCase();
        if (needle && !fisherman.includes(needle)) return;
        sum += parseNumber(tds[4].textContent || '');
      });
      const el = document.getElementById('expense-total');
      if (el) el.value = formatPeso(sum);
    });
    obs.observe(tbody, { childList: true, subtree: true, characterData: true });
  }

  // Init
  document.addEventListener('DOMContentLoaded', function() {
    attachTableObserver();
    // initial DB-wide total (no filter)
    updateTotalForName('');
  });

  // Expose helper if you want to call directly
  window.computeExpenseTotalForName = fetchDatabaseTotalForName;
  window.updateExpenseTotalForName = updateTotalForName;
})();
</script>

</body>
</html>