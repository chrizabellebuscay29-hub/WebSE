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

.worker-card {
  border: 1px solid #c3e4fa;
  border-radius: 8px;
  padding: 10px;
  text-align: left;
  background-color: #c3e4fa;
}

.worker-card button {
  margin: 5px 2px;
  padding: 5px 10px;
  border: none;
  border-radius: 4px;
  cursor: pointer;
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
        <button class="nav-tab" data-tab="transactions"><i class="fa-solid fa-handshake nav-icon"></i> Transactions</button>
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


        <button class="btn btn-primary" onclick="openExpenseDialog()"><i class="fa-solid fa-plus"></i> Add Expense</button>
      </div>
      <div id="expenses-list"></div>
    </div>

    <!-- Harvests -->
    <div id="harvests" class="tab-content">
      <div class="page-header">
        <div>
          <h2>Harvest Records</h2>
          <p class="page-subtitle">Calculate harvest profits</p>
        </div>
        <button class="btn btn-primary" onclick="openHarvestDialog()"><i class="fa-solid fa-plus"></i> Add Harvest</button>
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
      <td colspan="7" style="text-align:right; font-weight:bold;">Total Profit:</td>
      <td id="total-profit-sum" style="font-weight:bold;">₱0.00</td>
      <td colspan="2"></td>
    </tr>
  </tfoot>
</table>

      </div>
    </div>

    <!-- Transactions -->
    <div id="transactions" class="tab-content">
      <div class="page-header">
        <div>
          <h2>Feedstocks</h2>
          <p class="page-subtitle">Record feeds availability or stocks</p>
        </div>
        <button class="btn btn-primary" onclick="openTransactionDialog()"><i class="fa-solid fa-plus"></i> Add Transaction</button>
      </div>
      <div id="transactions-list"></div>
    </div>
  </main>

  <!-- ============= MODALS ============= -->
  <?php include("modals.php"); ?>

  <script>
  // Logout
  function confirmLogout() {
    if (confirm("Are you sure you want to log out?")) {
      window.location.href = 'login.html';
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

function openHarvestDialog() {
  document.getElementById("harvest-dialog").classList.add("active");
}
function closeHarvestDialog() {
  document.getElementById("harvest-dialog").classList.remove("active");
}

function openTransactionDialog() {
  document.getElementById("transaction-dialog").classList.add("active");
}
function closeTransactionDialog() {
  document.getElementById("transaction-dialog").classList.remove("active");
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
          <p><strong>Name:</strong> ${worker.Fisherman}</p>
          ${worker.Picture ? `<img src="${worker.Picture}" alt="${worker.Fisherman}" style="width:100%; border-radius:5px;">` : ''}
          <p><strong>Permit #:</strong> ${worker.Permitnumber}</p>
          <p><strong>Similia:</strong> ₱${worker.AmountofSimilia}</p>
          <p><strong>Age:</strong> ${worker.Age}</p>
          <p><strong>Date Started:</strong> ${worker.DateStarted}</p>
          
          <a class='btn btn-update' href='edit_workers.php?id=${worker.id}'>Update</a>

          <button onclick="deleteWorker(${worker.id})">Delete</button>
        `;
        container.appendChild(div);
      });
    });
}

// Save worker (add or edit)
function saveWorker() {
  const formData = new FormData(document.getElementById("worker-form"));
  fetch('workers_save.php', { method: 'POST', body: formData })
    .then(res => res.text())
    .then(() => {
      closeWorkerDialog();
      fetchWorkers();
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
