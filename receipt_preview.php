<?php
include("connection.php");

if (!isset($_GET['table']) || !isset($_GET['id'])) {
  die("Missing parameters.");
}

$table = $_GET['table'];
$id = intval($_GET['id']);
$allowed = ['tbl_transactions', 'tbl_profit'];
if (!in_array($table, $allowed)) die("Invalid request.");

$result = mysqli_query($conn, "SELECT * FROM $table WHERE id = $id");
if (!$result || mysqli_num_rows($result) === 0) die("Record not found.");

$data = mysqli_fetch_assoc($result);
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Receipt Preview</title>
<style>
  body {
  font-family: "Segoe UI", Arial, sans-serif;
  background: rgba(0,0,0,0.2);
  display: flex;
  align-items: center;
  justify-content: center;
  height: 100vh;
  margin: 0;
  transition: background 0.3s ease;
}

.receipt-container {
  background: white;
  border: 3px solid #2E549C;
  border-radius: 12px;
  max-width: 500px;
  width: 90%;
  padding: 25px 35px 35px; /* <-- make sure this padding is generous */
  box-shadow: 0 5px 25px rgba(0,0,0,0.15);
  opacity: 0;
  transition: opacity 0.3s ease;
  display: flex;
  flex-direction: column;
  gap: 20px; /* adds space between header, table, footer */
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
  margin-bottom: 20px;
}

td {
  padding: 8px 4px;
  border-bottom: 1px solid #E6E9EE;
}

td:first-child {
  font-weight: bold;
  width: 45%;
  color: #2E549C;
}

/* FIXED BUTTON AREA */
.receipt-footer {
  display: flex;
  justify-content: flex-end; /* buttons aligned to the right */
  gap: 12px; /* space between buttons */
  padding: 15px 0 0; /* space above buttons */
}


/* Buttons */
.btn-print,
.btn-close {
  min-width: 130px;
  font-size: 0.95rem;
  font-weight: 600;
  border: none;
  padding: 10px 16px;
  border-radius: 8px;
  cursor: pointer;
  transition: all 0.25s ease;
}

.btn-print {
  background-color: #082E76;
  color: #fff;
}

.btn-print:hover {
  background-color: #2E549C;
  transform: translateY(-2px);
}

.btn-close {
  background-color: #E11522;
  color: #fff;
}

.btn-close:hover {
  background-color: #ff4b5a;
  transform: translateY(-2px);
}

/* Hide footer and buttons during print */
@media print {
  .receipt-footer, .footer {
    display: none;
  }
  body {
    background: white;
  }
  .receipt-container {
    box-shadow: none;
    border: none;
    padding: 0;
  }
}

</style>
</head>
<body>
  <div class="receipt-container">
    <h2>
      <?= ($table === 'tbl_transactions') ? 'Expense Receipt' : 'Harvest Receipt' ?>
    </h2>

    <table>
      <?php foreach ($data as $key => $val): ?>
        <?php if (!in_array($key, ['id'])): ?>
        <tr>
          <td><?= htmlspecialchars(ucwords(str_replace("_", " ", $key))) ?></td>
          <td>
  <?= is_numeric($val) ? '₱' . number_format($val, 2) : htmlspecialchars($val) ?>
</td>

        </tr>
        <?php endif; ?>
      <?php endforeach; ?>
    </table>

    <!-- Buttons (INSIDE the container, centered) -->
    <div class="receipt-footer">
      <button class="btn-print" onclick="window.print()">🖨 Print Receipt</button>
      <button class="btn-close" onclick="window.close()">✖ Close</button>
    </div>

    <!-- Footer -->
    <div class="footer">
      Printed on <?= date("F d, Y h:i A") ?> by Fishing Operation Manager
    </div>
  </div>

  <script>
    // Automatically show the receipt popup with print prompt
    setTimeout(() => {
      document.querySelector(".receipt-container").style.opacity = "1";
    }, 100);
  </script>
</body>

</html>
