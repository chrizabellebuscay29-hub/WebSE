<?php
include ("connection.php");

if (isset ($_GET['delete'])) {
    $id = $_GET['delete'];
    mysqli_query($conn, "DELETE FROM tbl_workersdata WHERE id=$id");
    header("Location: index.php");
    exit;
}

$search = "";
$whereClause = "";

if (isset ($_GET['search']) && !empty(trim($_GET['search']))){
    $search = trim($_GET['search']);
    $whereClause = "WHERE Fisherman LIKE '%$search%' OR Age LIKE '%$search%' OR AmountofSimilia LIKE '%$search%' OR Permitnumber LIKE '%$search%'";
}

$limit = 3;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$start_from = ($page - 1) * $limit;

$total_query = mysqli_query($conn, "SELECT COUNT(id) AS total FROM tbl_workersdata $whereClause");
$total_row = mysqli_fetch_assoc($total_query);
$total_records = $total_row['total'];
$total_pages = ceil($total_records / $limit);

$sql = "SELECT * FROM tbl_workersdata $whereClause ORDER BY id DESC LIMIT $start_from, $limit";
$result = mysqli_query($conn, $sql);


?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Fishing Operation Manager</title>

  <!-- Styles -->
  <style>

.modal form label {
  font-weight: bold;
}


.modal-header {
  padding: 12px 16px;
  border-bottom: 2px solid #4f7fe9;
  background-color:#313c54;
  display: flex;
  align-items: center;
  justify-content: space-between;
}



.modal-close {
  background: transparent;
  border: none;
  cursor: pointer;
  font-size: 1.05rem;
}

/* Optional: nicer scrollbars for WebKit browsers */
.modal-body::-webkit-scrollbar { width: 10px; }
.modal-body::-webkit-scrollbar-track { background: #f4f4f4; border-radius: 8px; }
.modal-body::-webkit-scrollbar-thumb { background: #cfcfcf; border-radius: 8px; }
.modal-body::-webkit-scrollbar-thumb:hover { background: #b7b7b7; }

/* Make inputs and buttons full width inside modal for nicer layout */
.modal-body .input,
.modal-body .select,
.modal-body .checkbox-group,
.modal-body .btn {
  width: 100%;
  margin-bottom: 10px;
}

/* Make modal form controls have a blue border by default */
.modal .input,
.modal .select,
.modal .textarea {
    border: 2px solid #4f7fe9;
    
}

.modal .input:focus,
.modal .select:focus,
.modal .textarea:focus {
    outline: none;
    border-color: #4f7fe9;
    box-shadow: 0 0 0 4px rgba(37,99,235,0.08);
}

@media (min-width: 700px) {
  .modal-content { width: 80%; }
}
/* Reset and Base Styles */
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

body {
    font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
    background-color: #f8fcf8;
    background-image: url(./bg/fisherman-1559753_1280.jpg);
    background-size: cover;
    background-attachment: fixed;
    background-position: center center;
    background-repeat: no-repeat;
    color: #0f172a;
    line-height: 1.5;
    min-height: 100vh;
}

h1 {
    font-size: 1.875rem;
    font-weight: 700;
    line-height: 2.25rem;
    
}

h2 {
    font-size: 1.5rem;
    font-weight: 600;
    line-height: 2rem;
}

h3 {
    font-size: 1.25rem;
    font-weight: 600;
    line-height: 1.75rem;
    color: white;
}

/* Container */
.container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 1rem;
}

/* Header */
.header {
    background-color: #0d54ef;
    color: white;
    padding: 1.5rem 0;
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
}

.header-content {
    display: flex;
    align-items: center;
    gap: 0.75rem;
}

/* Header layout: content + actions (logout) */
.header-bar {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 1rem;
}

.header-actions {
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.logout-btn {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.45rem 0.75rem;
    border-radius: 0.375rem;
    border: 1px solid #ffffff !important;
    background: white !important;
    color: #000000 !important;
    transition: all 0.2s;
}

.logout-btn:hover {
    background: #dddddd !important;
    border-color: #dddddd !important;
}

.logout-btn .logout-text { display: inline-block; }

@media (max-width: 640px) {
  .logout-btn .logout-text { display: none; }
}

.header-icon {
    width: 2rem;
    height: 2rem;
}

.header-subtitle {
    color: #bfdbfe;
    font-size: 0.875rem;
    margin-top: 0.25rem;
}

/* Navigation */
.nav {
    background-color: rgba(255, 255, 255, 0.414);
    border-bottom: 1px solid #e2e8f0;
    box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
    position: sticky;
    top: 0;
    z-index: 10;
}

.nav-tabs {
    display: flex;
    gap: 1rem;
    overflow-x: auto;
}

.nav-tab {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.75rem 1rem;
    border: none;
    border-bottom: 2px solid transparent;
    background: none;
    color: #677180;
    cursor: pointer;
    white-space: nowrap;
    transition: all 0.2s;
    font-size: 0.875rem;
    font-weight: 500;
}

.nav-tab:hover {
    color: #0d1831;
    border-bottom-color: #cbd5e1;
}

.nav-tab.active {
    color: #0049e8;
    border-bottom-color: #023ebd;
}

/* Individual tab background colors */
.nav-tab-dashboard {
    background-color: #dcebff;
}
.nav-tab-dashboard.active {
    background-color: #abccf5;
}

.nav-tab-workers {
    background-color: #dcebff;
}
.nav-tab-workers.active {
    background-color: #abccf5;
}

.nav-tab-expenses {
    background-color: #dcebff;
}
.nav-tab-expenses.active {
    background-color: #abccf5;
}

.nav-tab-harvests {
    background-color: #dcebff;
}
.nav-tab-harvests.active {
    background-color: #abccf5;
}

.nav-tab-transactions {
    background-color: #dcebff;
}
.nav-tab-transactions.active {
    background-color: #abccf5;
}

.nav-icon {
    width: 1rem;
    height: 1rem;
}

/* Main Content */
.main {
    padding: 2rem 1rem;
}

/* Tabs */
.tab-content {
    display: none;
}

.tab-content.active {
    display: block;
}

/* Card */
.card {
    background-color: rgb(194, 227, 249);
    border-radius: 0.5rem;
    border: 1px solid #73a7e96b;
    box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.814);
    transition: transform 0.3s ease, box-shadow 0.18s ease;
}

/* Hoverable effect for the dashboard stat "slabs" inside .stats-grid */
.stats-grid .card {
    cursor: pointer;
}
.stats-grid .card:hover {
    transform: translateY(-6px);
    box-shadow: 0 12px 30px rgba(0, 102, 254, 0.574);
}
.stats-grid .card:active {
    transform: translateY(-2px);
}

.card-header {
    padding: 1.5rem;
    border-bottom: 1px solid #e2e8f0;
}

.card-header-inline {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 1.5rem;
    padding-bottom: 0.5rem;
}

.card-title {
    font-size: 1.125rem;
    font-weight: 600;
}

.card-title-sm {
    font-size: 0.875rem;
    font-weight: 500;
}

.card-body {
    padding: 1.5rem;
}

.card-body-center {
    padding: 3rem 1.5rem;
    text-align: center;
}

/* Stats Grid */
.stats-grid {
    display: grid;
    grid-template-columns: repeat(1, 1fr);
    gap: 1rem;
    margin-bottom: 1.5rem;
}

@media (min-width: 768px) {
    .stats-grid {
        grid-template-columns: repeat(2, 1fr);
    }
}

@media (min-width: 1024px) {
    .stats-grid {
        grid-template-columns: repeat(4, 1fr);
    }
}

.stats-grid-2 {
    display: grid;
    grid-template-columns: repeat(1, 1fr);
    gap: 1rem;
}

@media (min-width: 768px) {
    .stats-grid-2 {
        grid-template-columns: repeat(2, 1fr);
    }
}

.stats-grid-3 {
    display: grid;
    grid-template-columns: repeat(1, 1fr);
    gap: 1rem;
}

@media (min-width: 768px) {
    .stats-grid-3 {
        grid-template-columns: repeat(3, 1fr);
    }
}

.stat-icon {
    width: 1rem;
    height: 1rem;
    color: #94a3b8;
}

.stat-icon-lg {
    width: 2rem;
    height: 2rem;
}

.stat-icon-primary {
    color: #2563eb;
}

.stat-icon-success {
    color: #16a34a;
}

.stat-icon-danger {
    color: #dc2626;
}

.stat-value {
    font-size: 1.5rem;
    line-height: 2rem;
    font-weight: 600;
}

.stat-value-lg {
    font-size: 1.875rem;
    line-height: 2.25rem;
    font-weight: 600;
}

.stat-value-success {
    color: #16a34a;
}

.stat-value-danger {
    color: #dc2626;
}

.stat-label {
    font-size: 0.75rem;
    color: #64748b;
    margin-top: 0.25rem;
}

.stat-row {
    display: flex;
    justify-content: space-between;
    align-items: center;
}

/* Dashboard Grid */
.dashboard-grid {
    display: grid;
    grid-template-columns: repeat(1, 1fr);
    gap: 1.5rem;
}

@media (min-width: 1024px) {
    .dashboard-grid {
        grid-template-columns: repeat(2, 1fr);
    }
}

/* Workers Grid */
.workers-grid {
    display: grid;
    grid-template-columns: repeat(1, 1fr);
    gap: 1rem;
}

@media (min-width: 768px) {
    .workers-grid {
        grid-template-columns: repeat(2, 1fr);
    }
}

@media (min-width: 1024px) {
    .workers-grid {
        grid-template-columns: repeat(3, 1fr);
    }
}

.worker-card-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.worker-actions {
    display: flex;
    gap: 0.25rem;
}

.worker-image {
    width: 100%;
    height: 8rem;
    border-radius: 0.375rem;
    overflow: hidden;
    background-color: #f1f5f9;
    margin-bottom: 0.75rem;
}

.worker-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.worker-info {
    display: flex;
    flex-direction: column;
    gap: 0.75rem;
}

.worker-field {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    font-size: 0.875rem;
}

.worker-field-label {
    color: #64748b;
}



/* Page Header */
.page-header {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    gap: 1rem;
    margin-bottom: 1.5rem;
    flex-wrap: wrap;
}

.page-subtitle {
    color: #64748b;
    font-size: 0.875rem;
    margin-top: 0.25rem;
}

/* Button */
.btn {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
    padding: 0.5rem 1rem;
    border-radius: 0.375rem;
    font-size: 0.875rem;
    font-weight: 500;
    cursor: pointer;
    transition: all 0.2s;
    border: 1px solid transparent;
    white-space: nowrap;
}

.btn:disabled {
    opacity: 0.5;
    pointer-events: none;
}

.btn-primary {
    background-color: #2563eb;
    color: white;
}

.btn-primary:hover {
    background-color: #1d4ed8;
}

.btn-outline {
    background-color: white;
    color: #0f172a;
    border-color: #e2e8f0;
}

.btn-outline:hover {
    background-color: #f8fafc;
}

.btn-sm {
    padding: 0.375rem 0.75rem;
    font-size: 0.875rem;
}

.btn-ghost {
    background: none;
    border: none;
    padding: 0.5rem;
}

.btn-ghost:hover {
    background-color: #f8fafc;
}

.btn-icon {
    width: 1rem;
    height: 1rem;
}

.flex-1 {
    flex: 1;
}

/* Modal */
.modal {
    display: none;
    position: fixed;
    inset: 0;
    z-index: 50;
}

.modal.active {
    display: block;
}

.modal-overlay {
    position: fixed;
    inset: 0;
    background-color: rgba(0, 0, 0, 0.5);
    animation: fadeIn 0.2s;
}


.modal-content {
  position: fixed;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
  background-color: white;
  width: calc(100% - 2rem);
  max-width: 32rem;
  border-radius: 0.5rem;
  border: 3px solid #4f7fe9;
  box-shadow: 0 10px 30px rgba(0, 0, 0, 0.985);
  display: flex;
  flex-direction: column;
  overflow: hidden; /* keep header/footer visible, body handles scrolling */
  max-height: 80vh; /* important: limit height so inner area can scroll */
  animation: zoomIn 0.2s;
}


.modal-content-scrollable {
    overflow-y: auto;
}

.modal-header {
    padding: 1.5rem;
    position: relative;
    background-color: #4f7fe9;
    color: #ffffff;
}

.modal-title {
    font-size: 1.125rem;
    font-weight: 600;
    margin-bottom: 0.5rem;
}

.modal-description {
    font-size: 0.875rem;
    color: #64748b;
}

.modal-close {
    position: absolute;
    top: 1rem;
    right: 1rem;
    background: none;
    border: none;
    cursor: pointer;
    padding: 0.5rem;
    border-radius: 0.25rem;
    color: #021836;
    transition: all 0.2s;
}

.modal-close:hover {
    background-color: #f8fafc;
    color: #0f172a;
}


.modal-body {
  padding: 0 1.5rem 1.5rem;
  overflow-y: auto; /* enable vertical scrolling inside modal */
  -webkit-overflow-scrolling: touch;
  gap: 1rem;
  flex-direction: column;
  display: flex;
}
.modal-footer {
    display: flex;
    gap: 0.5rem;
    margin-top: 1rem;
}

/* Form */
.form-group {
    display: flex;
    flex-direction: column;
    gap: 0.15rem;
    margin-bottom: 0.5rem;
}

.form-row {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 1rem;
}

.label {
    font-size: 0.875rem;
    font-weight:bold;
    margin-bottom: 0; 
}

.input,
.select,
.textarea {
    margin-top: 0;
  padding: 0.45rem 0.7rem;
  border: 2px solid #4f7fe9;
  transition: all 0.2s;
  font-family: inherit;
    border-radius: 0.375rem;
    font-size: 0.875rem;
    width: 100%;
}

.input:focus,
.select:focus,
.textarea:focus {
    outline: none;
  border-color: #4f7fe9;
  box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
}

.textarea {
    resize: vertical;
}

/* Checkbox */
.checkbox-group {
    border: 1px solid #e2e8f0;
    border-radius: 0.375rem;
    padding: 0.5rem; 
    max-height: 12rem;
    overflow-y: auto;
    display: flex;
    flex-direction: column;
      gap: 0.35rem;
}

.checkbox-item {
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.checkbox {
    width: 1rem;
    height: 1rem;
    cursor: pointer;
}

.checkbox-label {
    font-size: 0.875rem;
    cursor: pointer;
}

/* Badge */
.badge {
    display: inline-block;
    padding: 0.25rem 0.5rem;
    border-radius: 0.25rem;
    font-size: 0.75rem;
    font-weight: 500;
}

.badge-primary {
    background-color: #dbeafe;
    color: #1e40af;
}

.badge-success {
    background-color: #dcfce7;
    color: #166534;
}

.badge-danger {
    background-color: #fee2e2;
    color: #991b1b;
}

/* Expense Item */
.expense-item,
.harvest-item,
.transaction-item {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    gap: 1rem;
    padding: 1rem;
    border: 1px solid #e2e8f0;
    border-radius: 0.5rem;
    margin-bottom: 0.75rem;
    transition: background-color 0.2s;
}

.expense-item:hover,
.harvest-item:hover,
.transaction-item:hover {
    background-color: #f9fafb;
}

.expense-details,
.harvest-details,
.transaction-details {
    flex: 1;
}

.expense-meta,
.harvest-meta,
.transaction-meta {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    margin-bottom: 0.5rem;
    flex-wrap: wrap;
}

.expense-date,
.harvest-date,
.transaction-date {
    font-size: 0.875rem;
    color: #64748b;
}

.expense-text,
.harvest-text,
.transaction-text {
    font-size: 0.875rem;
    color: #64748b;
}

.expense-actions,
.harvest-actions {
    display: flex;
    align-items: center;
    gap: 1rem;
}

.expense-amount,
.harvest-amount {
    font-size: 1.125rem;
    font-weight: 500;
}

/* Transaction Specific */
.transaction-icon {
    padding: 0.5rem;
    border-radius: 9999px;
}

.transaction-icon-income {
    background-color: #dcfce7;
}

.transaction-icon-expense {
    background-color: #fee2e2;
}



.transaction-content {
    display: flex;
    gap: 0.75rem;
    flex: 1;
    align-items: flex-start;
}

.transaction-amount-income {
    font-size: 1.125rem;
    color: #16a34a;
}

.transaction-amount-expense {
    font-size: 1.125rem;
    color: #dc2626;
}

/* Filter */
.filter-row {
    display: flex;
    align-items: flex-end;
    gap: 1rem;
}

.filter-icon {
    width: 1rem;
    height: 1rem;
    color: #94a3b8;
    margin-bottom: 0.5rem;
}

.filter-total {
    text-align: right;
}

/* Tabs (Transaction Filter) */
.tabs {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 0.25rem;
    margin-bottom: 1rem;
}

.tab-button {
    padding: 0.75rem;
    border: none;
    background: none;
    cursor: pointer;
    border-bottom: 2px solid transparent;
    font-size: 0.875rem;
    font-weight: 500;
    color: #64748b;
    transition: all 0.2s;
}

.tab-button:hover {
    color: #0f172a;
}

.tab-button.active {
    color: #2563eb;
    border-bottom-color: #2563eb;
}

/* Empty State */
.empty-state {
    color: #64748b;
    font-size: 0.875rem;
}

.empty-state-sm {
    color: #94a3b8;
    font-size: 0.75rem;
}

/* Total Display */
.total-display {
    background-color: #eff6ff;
    padding: 0.75rem;
    border-radius: 0.375rem;
}

/* List Item */
.list-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding-bottom: 0.5rem;
    border-bottom: 1px solid #e2e8f0;
    margin-bottom: 0.75rem;
}

.list-item:last-child {
    margin-bottom: 0;
    border-bottom: none;
    padding-bottom: 0;
}

.list-item-title {
    font-size: 0.875rem;
}

.list-item-subtitle {
    font-size: 0.75rem;
    color: #64748b;
}

.list-item-value {
    font-size: 0.875rem;
}

/* Animations */
@keyframes fadeIn {
    from {
        opacity: 0;
    }
    to {
        opacity: 1;
    }
}

@keyframes zoomIn {
    from {
        opacity: 0;
        transform: translate(-50%, -50%) scale(0.95);
    }
    to {
        opacity: 1;
        transform: translate(-50%, -50%) scale(1);
    }
}

/* Responsive */
@media (max-width: 640px) {
    .page-header {
        flex-direction: column;
        align-items: stretch;
    }

    .filter-row {
        flex-direction: column;
        align-items: stretch;
    }

    .filter-total {
        text-align: left;
    }

    .expense-item,
    .harvest-item {
        flex-direction: column;
    }

    .expense-actions,
    .harvest-actions {
        width: 100%;
        justify-content: space-between;
    }
}

/* Utility Classes */
.text-sm {
    font-size: 0.875rem;
}

.text-xs {
    font-size: 0.75rem;
}

.text-muted {
    color: #64748b;
}

.mt-1 {
    margin-top: 0.25rem;
}

.mb-2 {
    margin-bottom: 0.5rem;
}

.gap-2 {
    gap: 0.5rem;
}

.flex {
    display: flex;
}

.items-center {
    align-items: center;
}

.justify-between {
    justify-content: space-between;
}


  </style>

  <!-- Font Awesome -->
  <link
    rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"
  />
</head>

<body>
  <!-- Header -->
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
            <span class="logout-text"> Logout</span>
          </button>
        </div>
      </div>
    </div>
  </header>

  <!-- Navigation -->
  <nav class="nav">
    <div class="container">
      <div class="nav-tabs">
        <button class="nav-tab nav-tab-dashboard active" data-tab="dashboard"><i class="fa-solid fa-chart-line nav-icon"></i> Dashboard</button>
        <button class="nav-tab nav-tab-workers" data-tab="workers"><i class="fa-solid fa-user-group nav-icon"></i> Workers</button>
        <button class="nav-tab nav-tab-expenses" data-tab="expenses"><i class="fa-solid fa-money-bill nav-icon"></i> Expenses</button>
        <button class="nav-tab nav-tab-harvests" data-tab="harvests"><i class="fa-solid fa-fish nav-icon"></i> Harvests</button>
        <button class="nav-tab nav-tab-transactions" data-tab="transactions"><i class="fa-solid fa-handshake nav-icon"></i> Transactions</button>
      </div>
    </div>
  </nav>

  <!-- Main -->
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
        <button class="btn btn-primary" onclick="openWorkerDialog()"><i class="fa-solid fa-plus"></i> Add Worker</button>
      </div>
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
      <div id="harvests-list"></div>
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

  <!-- ================= MODALS ================= -->
  <!-- Worker -->
  <div id="worker-dialog" class="modal">
    <div class="modal-overlay" onclick="closeWorkerDialog()"></div>
    <div class="modal-content">
      <div class="modal-header"><h3>Add Worker</h3><button class="modal-close" onclick="closeWorkerDialog()"><i class="fa-solid fa-xmark"></i></button></div>
      <form method="POST" action="addworker.php" id="worker-form" class="modal-body">
        <label for="name">Full Name:</label>
        <input id="worker-name" name="Fisherman" class="input" placeholder="Name" required />
        <label for="name">Permit Number:</label>
        <input id="worker-permit" name="Permitnumber" class="input" placeholder="Permit #" required />
        <label for="name">Amount of Similia:</label>
        <input id="worker-similia" name="AmountofSimilia" class="input" type="number"  required />
        <label for="name">Age:</label>
        <input id="worker-age" name="Age" class="input" type="number"  required />
        <label for="name">Joined Date:</label>
        <input id="worker-joined" name="DateStarted" class="input" type="date" required />
        <label for="name">Insert Picture:</label>
        <input id="worker-picture" name="Picture" class="input" placeholder="Picture URL" />
        <button class="btn btn-primary" type="submit">Save Worker</button>
      <button type="button" class="btn btn-secondary" onclick="handleWorkerCancel()">Cancel</button>

</form>
      
    </div>
  </div>

  <script>
    function handleWorkerCancel() {
  const form = document.getElementById("worker-form"); // make sure your form has id="worker-form"
  form.reset(); // clears all fields
  closeWorkerDialog(); // closes the modal/dialog
}

  </script>


  <!-- Expense -->
  <div id="expense-dialog" class="modal">
    <div class="modal-overlay" onclick="closeExpenseDialog()"></div>
    <div class="modal-content">
      <div class="modal-header"><h3>Add Expense</h3><button class="modal-close" onclick="closeExpenseDialog()"><i class="fa-solid fa-xmark"></i></button></div>
      <form id="expense-form" class="modal-body" onsubmit="handleExpenseSubmit(event)">
        <label for="name">Fisherman:</label>
        <select id="expense-worker" class="select" required></select>
        <label for="feeds">Type of Feeds:</label>
        <select id="expense-category" class="select"  required></select>
        <label for="price">Price:</label>
        <input id="expense-price" class="input" type="number" required />
        <label for="quantity">Quantity:</label>
        <input id="expense-quantity" class="input" type="number" required />
        <label for="total">Total Amount:</label>
        <input id="expense-amount" class="input" type="number" required />
        <label for="date">Date:</label>
        <input id="expense-date" class="input" type="date" required />
        <button class="btn btn-primary" type="submit">Save Transaction</button>
        <button type="button" class="btn btn-secondary" onclick="handleExpenseCancel()">Cancel</button>
</form>
      </form>
    </div>
  </div>
  <script>
    function handleExpenseCancel() {
  const form = document.getElementById("expense-form");
  form.reset();       // clears all input fields
  closeExpenseDialog(); // closes the expense dialog/modal
}

  </script>

  <!-- Harvest -->
  <div id="harvest-dialog" class="modal">
    <div class="modal-overlay" onclick="closeHarvestDialog()"></div>
    <div class="modal-content">
      <div class="modal-header"><h3>Add Computation</h3><button class="modal-close" onclick="closeHarvestDialog()"><i class="fa-solid fa-xmark"></i></button></div>
      <form id="harvest-form" class="modal-body" onsubmit="handleHarvestSubmit(event)">
        <label for="name">Full Name:</label>
        <select id="harvest-worker" class="select" placeholder="Fisherman" required></select>
        <label for="kilo">Kilo of Fish:</label>
        <input id="harvest-kilo" class="input" type="number" step="0.01" required />
        <label for="price">Price per Kilo:</label>
        <input id="harvest-price" class="input" type="number" step="0.01" required />
        <label for="subtotal">Subtotal:</label>
        <input id="harvest-subtotal" class="input" type="number" step="0.01" required />
        <label for="similia">Amount of Similia:</label>
        <input id="harvest-similia" class="input" type="number" step="0.01" required />
        <label for="feeds">Amount of Feeds:</label>
        <input id="harvest-feeds" class="input" type="number" step="0.01"  required />
        <label for="expenses">Total Expenses:</label>
        <input id="harvest-expenses" class="input" type="number" step="0.01" required />
        <label for="profit">Profit Details:</label>
        <input id="harvest-profit" class="input" type="number" step="0.01" required />
        <label for="divprofit">Divided Profit:</label>
        <input id="harvest-divprofit" class="input" type="number" step="0.01" required />
        <label for="date">Date:</label>
        <input id="harvest-date" class="input" type="date" required />
       
        <div id="harvest-workers" class="checkbox-group"></div>
        <button class="btn btn-primary" type="submit">Save Harvest</button>
        <button type="button" class="btn btn-secondary" onclick="handleHarvestCancel()">Cancel</button>
</form>
      </form>
    </div>
  </div>
  <script>
    function handleHarvestCancel() {
  const form = document.getElementById("harvest-form");
  form.reset();          // clears all fields
  closeHarvestDialog();  // closes the harvest modal/dialog
}

  </script>

  <!-- Transaction -->
  <div id="transaction-dialog" class="modal">
    <div class="modal-overlay" onclick="closeTransactionDialog()"></div>
    <div class="modal-content">
      <div class="modal-header"><h3>Add Feedstocks</h3><button class="modal-close" onclick="closeTransactionDialog()"><i class="fa-solid fa-xmark"></i></button></div>
      <form id="transaction-form" class="modal-body" onsubmit="handleTransactionSubmit(event)">
        <label for="feeds">Name of Feeds:</label>
        <input id="transaction-category" class="input"  required />
        <label for="price">Price/piece:</label>
        <input id="transaction-amount" class="input" type="number"  required />
<label for="quantity">Quantity:</label>
        <input id="transaction-amount" class="input" type="number"  required />
        <label for="date">Date:</label>
        <input id="transaction-date" class="input" type="date" required />
        <button class="btn btn-primary" type="submit">Save Transaction</button>
        <button type="button" class="btn btn-secondary" onclick="handleTransactionCancel()">Cancel</button>
</form>
      </form>
    </div>
  </div> 
  <script>
    function handleTransactionCancel() {
  const form = document.getElementById("transaction-form");
  form.reset();             // clears all input fields
  closeTransactionDialog(); // closes the transaction modal/dialog
}

  </script>
  

  <script>
let state = { workers: [], expenses: [], harvests: [], transactions: [] };

// Load & Save
function loadData() {
  const saved = localStorage.getItem("fishing-operation-storage");
  if (saved) state = JSON.parse(saved);
}
function saveData() {
  localStorage.setItem("fishing-operation-storage", JSON.stringify(state));
}

// Initialize
document.addEventListener("DOMContentLoaded", () => {
  loadData();
  initializeTabs();
  render();
  updateWorkerSelects();
});

// Logout with confirmation: clears session storage and redirects to login.html
function confirmLogout() {
  const ok = window.confirm('Are you sure you want to log out?');
  if (!ok) return;
  try {
    // optionally clear stored app data on logout
    localStorage.removeItem('fishing-operation-storage');
  } catch (e) {
    // ignore
  }
  window.location.href = 'login.html';
}

// Tabs
function initializeTabs() {
  document.querySelectorAll(".nav-tab").forEach(tab => {
    tab.addEventListener("click", () => {
      const target = tab.dataset.tab;
      document.querySelectorAll(".tab-content").forEach(t => t.classList.remove("active"));
      document.getElementById(target).classList.add("active");
      document.querySelectorAll(".nav-tab").forEach(b => b.classList.remove("active"));
      tab.classList.add("active");
    });
  });
}

// Rendering
function render() {
  document.getElementById("total-workers").textContent = state.workers.length;
  document.getElementById("workers-list").innerHTML =
    state.workers.map(w => `<div class="card"><div class="card-body"><strong>${w.name}</strong><br>Permit: ${w.permitNumber}<br>Similia: ₱${w.similiaAmount}<br>Age: ${w.age}</div></div>`).join("") || `<p class="empty-state">No workers yet.</p>`;
}

// Modals
function openWorkerDialog() { document.getElementById("worker-dialog").classList.add("active"); }
function closeWorkerDialog() { document.getElementById("worker-dialog").classList.remove("active"); }
function openExpenseDialog() { document.getElementById("expense-dialog").classList.add("active"); }
function closeExpenseDialog() { document.getElementById("expense-dialog").classList.remove("active"); }
function openHarvestDialog() { document.getElementById("harvest-dialog").classList.add("active"); }
function closeHarvestDialog() { document.getElementById("harvest-dialog").classList.remove("active"); }
function openTransactionDialog() { document.getElementById("transaction-dialog").classList.add("active"); }
function closeTransactionDialog() { document.getElementById("transaction-dialog").classList.remove("active"); }

// Forms
function handleWorkerSubmit(e) {
  e.preventDefault();
  const worker = {
    id: Date.now(),
    name: document.getElementById("worker-name").value,
    permitNumber: document.getElementById("worker-permit").value,
    similiaAmount: parseFloat(document.getElementById("worker-similia").value),
    age: parseInt(document.getElementById("worker-age").value),
    joinedDate: document.getElementById("worker-joined").value,
    picture: document.getElementById("worker-picture").value
  };
  state.workers.push(worker);
  saveData();
  closeWorkerDialog();
  render();
  updateWorkerSelects();
  e.target.reset();
}



function handleExpenseSubmit(e) {
  e.preventDefault();
  const exp = {
    id: Date.now(),
    workerId: document.getElementById("expense-worker").value,
    category: document.getElementById("expense-category").value,
    amount: parseFloat(document.getElementById("expense-amount").value),
    description: document.getElementById("expense-description").value,
    date: document.getElementById("expense-date").value
  };
  state.expenses.push(exp);
  saveData();
  closeExpenseDialog();
  e.target.reset();
}

function handleHarvestSubmit(e) {
  e.preventDefault();
  const qty = parseFloat(document.getElementById("harvest-quantity").value);
  const price = parseFloat(document.getElementById("harvest-price").value);
  const harvest = {
    id: Date.now(),
    date: document.getElementById("harvest-date").value,
    fishType: document.getElementById("harvest-fish").value,
    quantity: qty,
    unit: document.getElementById("harvest-unit").value,
    pricePerUnit: price,
    totalValue: qty * price
  };
  state.harvests.push(harvest);
  saveData();
  closeHarvestDialog();
  e.target.reset();
}

function handleTransactionSubmit(e) {
  e.preventDefault();
  const trans = {
    id: Date.now(),
    date: document.getElementById("transaction-date").value,
    type: document.getElementById("transaction-type").value,
    category: document.getElementById("transaction-category").value,
    amount: parseFloat(document.getElementById("transaction-amount").value),
    description: document.getElementById("transaction-description").value
  };
  state.transactions.push(trans);
  saveData();
  closeTransactionDialog();
  e.target.reset();
}

// Worker dropdowns for expenses
function updateWorkerSelects() {
  const select = document.getElementById("expense-worker");
  if (select) {
    select.innerHTML = state.workers.map(w => `<option value="${w.id}">${w.name}</option>`).join("");
  }
}


  </script>
</body>
</html>
