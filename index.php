<?php include("connection.php"); ?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Fishing Operation Management</title>

  <!-- Fonts & Icons -->
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700;800&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />

  <!-- Existing local stylesheet (kept for overrides if present) -->
  <link rel="stylesheet" href="style.css">

  <!-- Select2 CSS -->
  <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

  <!-- jQuery + Select2 JS (kept as before) -->
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

  <style>
    /* ---------- Base ---------- */
    :root{
      --primary:#1f6feb;
      --accent:#2E549C;
      --muted:#6b7280;
      --card:#ffffff;
      --bg:#f4f8fb;
      --glass: rgba(255,255,255,0.6);
      --sea-1: #c7f0ff;
      --sea-2: #e6f7ff;
      --success: #14b8a6;
      --danger: #ef4444;
      --shadow: 0 8px 30px rgba(16,24,40,0.08);
      font-synthesis: none;
    }

    html,body{
      height:100%;
      margin:0;
      font-family: 'Inter', system-ui, -apple-system, "Segoe UI", Roboto, "Helvetica Neue", Arial;
      background-image: url ("fisherman-1559753_1280.jpg");
      color: #082E76;
      -webkit-font-smoothing:antialiased;
      -moz-osx-font-smoothing:grayscale;
      line-height:1.45;
    }

    /* subtle fish scale pattern (CSS-generated) */
    body::before{
      content:'';
      position:fixed;
      inset:0;
      background-image:
        radial-gradient(circle at 20% 20%, rgba(255,255,255,0.6) 0 2px, transparent 3px),
        radial-gradient(circle at 80% 80%, rgba(255,255,255,0.5) 0 1.5px, transparent 2.5px);
      opacity:0.18;
      pointer-events:none;
      z-index:0;
      mix-blend-mode:overlay;
    }

    .container{
      max-width:1180px;
      margin:0 auto;
      padding:22px;
      position:relative;
      z-index:2;
    }

    /* ---------- Header ---------- */
    .header{
      padding:18px 0;
      background: linear-gradient(90deg, rgba(47,116,233,0.12), rgba(46,84,156,0.06));
      border-radius: 12px;
      margin-bottom:14px;
      box-shadow: var(--shadow);
      backdrop-filter: blur(6px);
    }

    .header-bar{
      display:flex;
      align-items:center;
      justify-content:space-between;
      gap:12px;
    }

    .header-content{
      display:flex;
      align-items:center;
      gap:14px;
    }

    .header-icon{
      font-size:28px;
      color:var(--primary);
      background: linear-gradient(135deg,#eaf5ff, #e6f0ff);
      padding:10px;
      border-radius:10px;
      box-shadow: 0 6px 18px rgba(32,77,160,0.06), inset 0 -4px 12px rgba(255,255,255,0.5);
    }

    .header h1{
      margin:0;
      font-size:1.25rem;
      letter-spacing: -0.2px;
      color: #082E76;
      font-weight:700;
    }

    .header-subtitle{
      margin:0;
      font-size:0.875rem;
      color:var(--muted);
    }

    .header-actions .logout-btn{
      display:inline-flex;
      gap:8px;
      align-items:center;
      background:transparent;
      border:1px solid rgba(46,84,156,0.08);
      padding:9px 12px;
      border-radius:10px;
      color:var(--accent);
      font-weight:600;
      cursor:pointer;
      transition:all .18s ease;
      box-shadow: none;
    }
    .header-actions .logout-btn:hover{
      transform:translateY(-3px);
      box-shadow:0 8px 24px rgba(30,84,167,0.08);
      background: linear-gradient(180deg, rgba(47,116,233,0.06), rgba(46,84,156,0.02));
    }

    /* ---------- Nav Tabs ---------- */
    .nav{
      margin:16px 0 26px 0;
      padding:0;
    }

    .nav-tabs{
      display:flex;
      gap:10px;
      flex-wrap:wrap;
    }

    .nav-tab{
      border: none;
      background: transparent;
      color:var(--muted);
      padding:10px 14px;
      border-radius:12px;
      font-weight:600;
      cursor:pointer;
      display:inline-flex;
      gap:8px;
      align-items:center;
      transition: all .18s ease;
      border:1px solid transparent;
    }

   /* Default icon – visible */
.nav-tab .nav-icon{
  color: var(--primary);          /* strong base color */
  opacity: 1;                    /* no fading */
  transition: color 0.25s ease;
}

/* Hover state */
.nav-tab:hover{
  background: rgba(47,116,233,0.06);
  color: var(--accent);
  transform: translateY(-2px);
  box-shadow: 0 6px 18px rgba(30,84,167,0.05);
}

/* Icon on hover – high contrast */
.nav-tab:hover .nav-icon{
  color: var(--accent);          /* visible on hover bg */
}

/* Clicked / active tab */
.nav-tab:active .nav-icon,
.nav-tab.active .nav-icon{
  color: var(--accent);
}


    /* ---------- Main Layout ---------- */
    .main{
      padding-bottom:40px;
    }

    .page-header{
      display:flex;
      justify-content:space-between;
      align-items:center;
      gap:12px;
      margin-bottom:12px;
    }

    .page-header h2{
      margin:0;
      font-size:1.1rem;
      color:#082E76;
      font-weight:700;
    }

    .page-subtitle{
      margin:0;
      font-size:0.9rem;
      color:var(--muted);
    }

    .page-actions{
      display:flex;
      gap:8px;
      align-items:center;
    }

    .btn{
      border: none;
      border-radius:10px;
      padding:9px 14px;
      font-weight:700;
      cursor:pointer;
      display:inline-flex;
      gap:8px;
      align-items:center;
      justify-content:center;
    }

    .btn-primary{
      background: linear-gradient(90deg,var(--primary), var(--accent));
      color:white;
      box-shadow: 0 10px 26px rgba(46,84,156,0.12);
    }

    .btn-outline{
      background:transparent;
      border: 1px solid rgba(46,84,156,0.12);
      color:var(--accent);
    }

    .btn:hover{ transform: translateY(-3px); }

    /* ---------- Dashboard Cards ---------- */
    .stats-grid{
      display:grid;
      grid-template-columns: repeat(auto-fit, minmax(210px,1fr));
      gap:14px;
      margin-bottom:18px;
    }

    .card{
      background: linear-gradient(180deg, rgba(255,255,255,0.6), var(--card));
      border-radius:12px;
      padding:14px 16px;
      box-shadow: var(--shadow);
      border: 1px solid rgba(46,84,156,0.06);
      transition: transform .18s ease, box-shadow .18s ease;
      overflow:hidden;
    }

    .card:hover{
      transform: translateY(-6px);
      box-shadow: 0 18px 45px rgba(16,24,40,0.08);
    }

    .card-header-inline{
      display:flex;
      justify-content:space-between;
      align-items:center;
      gap:8px;
    }

    .card-title-sm{
      font-size:0.9rem;
      color:var(--muted);
      font-weight:700;
    }

    .card-body{
      display:flex;
      flex-direction:column;
      gap:6px;
      margin-top:10px;
    }

    .stat-value{
      font-size:1.35rem;
      font-weight:800;
      color:#082E76;
    }

    .stat-value-success{
      color:var(--success);
    }

    .stat-label{
      margin:0;
      font-size:0.85rem;
      color:var(--muted);
    }

    /* ---------- Workers Grid & Cards ---------- */
    .workers-grid{
      display:grid;
      grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
      gap:18px;
      margin-top:10px;
    }

   .worker-card {
    position:relative;
    background: linear-gradient(180deg, #ffffff, rgba(236,249,255,0.8));
    border-radius:12px;
    padding:14px 14px 18px 14px; /* Add bottom padding if wanted */
    text-align:left;
    transition: transform .18s ease, box-shadow .18s ease;
    border: 1px solid rgba(46,84,156,0.06);
    overflow:clip;
    /* ADD THIS LINE: */
    padding-top: 48px; /* Ensures the header buttons won't cover name/image */
}
.worker-card-header-left,
.worker-card-header-right {
    position:absolute;
    top:10px;
    z-index:5;
}
.worker-card-header-left { left:10px; }
.worker-card-header-right { right:10px; }

    .worker-card:hover{
      transform: translateY(-8px);
      box-shadow: 0 20px 50px rgba(16,24,40,0.08);
    }

   

    .worker-btn{
      background: rgba(255,255,255,0.9);
      border-radius:8px;
      border:1px solid rgba(46,84,156,0.06);
      padding:6px;
      display:inline-flex;
      align-items:center;
      justify-content:center;
      cursor:pointer;
    }

    .worker-image{
      width:100%;
      height:160px;
      object-fit:cover;
      border-radius:8px;
      display:block;
      margin-top:18px;
      box-shadow: 0 8px 24px rgba(46,84,156,0.06);
    }

    .worker-name{
      font-size:1rem;
      margin:10px 0 6px;
      color:var(--accent);
      font-weight:700;
    }

    .worker-info p{
      margin:4px 0;
      color:#15345a;
      font-size:0.88rem;
    }

    /* ---------- Tables ---------- */
    table{
      width:100%;
      border-collapse:separate;
      border-spacing:0;
      background:white;
      border-radius:10px;
      overflow:hidden;
      box-shadow: var(--shadow);
    }

    thead th{
      background: linear-gradient(90deg,var(--accent), var(--primary));
      color:white;
      font-weight:700;
      padding:12px;
      border:none;
      text-align:center;
      font-size:0.92rem;
    }

    tbody td{
      padding:10px 12px;
      color:#0f172a;
      border-bottom:1px solid rgba(15,23,42,0.04);
      text-align:center;
      font-size:0.92rem;
    }

    tbody tr:nth-child(even){ background: rgba(47,116,233,0.02); }

    tfoot td{
      padding:10px;
      background: #f8fbff;
      font-weight:700;
      color:var(--muted);
      text-align:center;
    }

    /* Inputs */
    .input{
      border-radius:10px;
      border:1px solid rgba(46,84,156,0.08);
      padding:9px 12px;
      background:white;
      font-size:0.95rem;
      color:#0f172a;
      box-shadow:inset 0 1px 0 rgba(255,255,255,0.6);
    }

    .form-group label{ font-weight:700; color:var(--accent); display:block; margin-bottom:6px; }

    /* Pagination area */
    #expense-pagination, #harvests-pagination, #transaction-pagination{
      margin-top:14px;
      display:flex;
      justify-content:center;
      gap:8px;
      align-items:center;
    }

    /* Receipts & modal adjustments remain unobtrusive */
    #receipt-modal .active, .modal.active { display:block !important; }

    /* Select2 integration tweaks (kept and improved) */
    .select2-container { width:100% !important; }
    .select2-container--default .select2-selection--single {
      height:44px !important;
      border:1px solid rgba(46,84,156,0.12) !important;
      border-radius:10px !important;
      padding:6px 10px !important;
      font-size:0.95rem !important;
      display:flex !important;
      align-items:center !important;
    }
    .select2-container--default .select2-selection--single .select2-selection__clear { right:42px; }
    .select2-dropdown { border-radius:8px; border:1px solid rgba(46,84,156,0.08) !important; }

    /* Responsive tweaks */
    @media (max-width:880px){
      .header h1 { font-size:1rem; }
      .stats-grid{ grid-template-columns: repeat(auto-fit,minmax(170px,1fr)); }
      .workers-grid{ grid-template-columns: repeat(auto-fill, minmax(180px,1fr)); }
    }
    @media (max-width:520px){
      .header-bar{ flex-direction:column; align-items:flex-start; gap:12px; }
      .page-header{ flex-direction:column; align-items:flex-start; gap:12px; }
      .nav-tabs{ overflow:auto; padding-bottom:6px; -webkit-overflow-scrolling:touch; }
      .nav-tab{ white-space:nowrap; }
    }

    /* Small utilities */
    .empty-state{ color:var(--muted); padding:12px; text-align:center; }
    .expense-search { display:inline-block; }

    /*for workers slider*/
.workers-slider-wrapper {
overflow: hidden;
position: relative;
padding: 0 50px;
}

.slider-btn {
  position: absolute;
  top: 50%;
  transform: translateY(-50%);
  z-index: 10;

  background: rgba(255, 255, 255, 0.9);
  border: none;
  border-radius: 50%;
  width: 42px;
  height: 42px;

  font-size: 20px;
  cursor: pointer;
  box-shadow: 0 4px 10px rgba(0, 0, 0, 0.15);
}

.slider-btn.prev {
  left: 5px;
}
.slider-btn.next {
  right: 5px;
}
.slider-btn:hover {
  background: #0066ff87;
  transform: translateY(-50%) scale(1.05);
}

.workers-slider {
  display: flex;
  gap: 16px;
  overflow-x: auto;
  scroll-behavior: smooth;
  scrollbar-width: none;
}

.workers-slider::-webkit-scrollbar {
  display: none;
}

#workers-list > * {
  flex: 0 0 calc((100% - 32px) / 3);
}

@media (max-width: 1023px) {
  #workers-list > * {
    flex: 0 0 calc((100% - 16px) / 2);
  }
}

@media (max-width: 767px) {
  #workers-list > * {
    flex: 0 0 100%;
  }
}
  </style>
</head>

<body>
  <!-- HEADER -->
  <header class="header">
    <div class="container">
      <div class="header-bar">
        <div class="header-content">
          <i class="fa-solid fa-ship header-icon"></i>
          <div>
            <h1>Fishing Operation Management</h1>
            <p class="header-subtitle">Record workers and track expenses, harvests & feeds.</p>
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

  <!-- 🔍 WORKER SEARCH (DITO TALAGA) -->
  <div style="margin-bottom: 15px;">
    <input
      type="text"
      id="worker-search"
      class="input"
      placeholder="Search worker..."
      style="width: 300px; padding: 8px;"
    />
  </div>

  <!-- ⬇️ Workers Slider -->
  <div class="workers-slider-wrapper">
    <button class="slider-btn prev">&#10094;</button>

    <div id="workers-list" class="workers-slider"></div>

    <button class="slider-btn next">&#10095;</button>
  </div>

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

        
 <div class="form-group" style="margin-top:10px;"> <label style="font-weight:600; color:#082E76;"> Total Expenses </label>
  <input
    type="text"
    id="expense-total"
    class="input"
    readonly
    value="₱0.00"
   
  >
  <button class="btn btn-primary" onclick="sendTotalToHarvest()" >
    Use in Harvest
  </button>
</div>
<style>
.form-group {
  position: relative; /* allow absolute positioning of button */
  display: flex;      /* align label and input horizontally */
  align-items: flex-start; /* align items at the top */
  gap: 8px;           /* space between label and input */
  margin-top: 10px;
}

#expense-total {
  width: 1142px;        /* keep original size */
  height: 34px;
  padding: 4px 6px;
  box-sizing: border-box;
}

.form-group button {
  position: absolute;
  top: 0;              /* align to top of container */
  right: 0;            /* right edge of container */
  height: 28px;
  padding: 4px 8px;
  font-size: 0.85rem;
}


</style>
<script>
function sendTotalToHarvest() {
  // Get the total expenses value
  const total = document.getElementById('expense-total').value;

  // Remove the currency symbol if needed, keeping only the number
  const numericTotal = total.replace(/₱|,/g, '').trim();

  // Set it to the Harvest modal input
  const harvestInput = document.getElementById("harvest-feeds");
  if(harvestInput){
    harvestInput.value = numericTotal; // or keep "₱" if you want
    // Optionally, open the harvest modal if not already open
    // openHarvestModal(); // if you have a function like this
   alert("Total expenses saved in Harvest field!"); // Show alert
  } else {
    alert("Harvest field not found!");
  }
}
</script>


        <!-- Expenses Table -->
        <table id="expenses-table" border="0" cellpadding="8" cellspacing="0" style="width:100%;">
          <thead>
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
            <tr>
              <td colspan="6"></td>
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
        <table id="harvests-table" border="0" cellpadding="8" cellspacing="0" style="width:100%;">
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
          <tbody></tbody>
          <tfoot>
            <tr></tr>
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
        <table id="transactions-table" border="0" cellpadding="8" cellspacing="0" style="width:100%;">
          <thead>
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
            <tr></tr>
          </tfoot>
        </table>
        <div id="transaction-pagination"></div>
      </div>
    </div>
  </main>

  <!-- ============= MODALS ============= -->
  <?php include("modals.php"); ?>

  <!-- =========================
       Existing scripts preserved (no functional changes).
       All original JS is retained below exactly as provided earlier.
       Only cosmetic/style changes were applied above.
       ========================= -->

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
  if (!confirm("Are you sure you want to delete this worker and all their records?")) return;

  fetch('workers_delete.php', {
    method: 'POST',
    body: new URLSearchParams({ id })
  })
  .then(response => response.text()) // optional but safer
  .then(() => {
    fetchWorkers();     // refresh worker list
    loadDashboard();    // refresh dashboard totals
  });
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

// Keep correct tab active after redirect (e.g., ?tab=workers)
document.addEventListener("DOMContentLoaded", () => {
  const params = new URLSearchParams(window.location.search);
  const tab = params.get("tab");
  if (tab) {
    document.querySelectorAll(".tab-content").forEach(t => t.classList.remove("active"));
    document.querySelectorAll(".nav-tab").forEach(b => b.classList.remove("active"));
    document.getElementById(tab)?.classList.add("active");
    document.querySelector(`.nav-tab[data-tab="${tab}"]`)?.classList.add("active");
  }
});



</script>
<script>
  //slider sa workers
  const slider = document.querySelector(".workers-slider");
  const nextBtn = document.querySelector(".slider-btn.next");
  const prevBtn = document.querySelector(".slider-btn.prev");

  function getVisibleCount() {
    const w = window.innerWidth;
    if (w <= 767) return 1;
    if (w <= 1023) return 2;
    return 3;
  }

  function scrollPage(direction) {
    const card = slider.querySelector(":scope > *");
    if (!card) return;

    const gap = 16;
    const visible = getVisibleCount();
    const amount = (card.offsetWidth + gap) * visible;

    slider.scrollBy({
      left: direction * amount,
      behavior: "smooth"
    });
  }

  nextBtn.onclick = () => scrollPage(1);
  prevBtn.onclick = () => scrollPage(-1);


  //search sa workers
  const workerSearch = document.getElementById("worker-search");

  workerSearch.addEventListener("input", function () {
    const query = this.value.toLowerCase();
    const workers = document.querySelectorAll("#workers-list > *");

    workers.forEach(worker => {
      const text = worker.innerText.toLowerCase();
      worker.style.display = text.includes(query) ? "" : "none";
    });

    // reset scroll after search
    slider.scrollTo({ left: 0 });
  });
</script>

</body>
</html>