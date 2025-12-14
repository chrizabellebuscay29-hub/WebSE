<!-- ================= MODALS ================= -->

<!-- ADD WORKER -->
<div id="worker-dialog" class="modal">
  <div class="modal-overlay" onclick="closeWorkerDialog()"></div>
  <div class="modal-content">
    <div class="modal-header">
      <h3>Add Worker</h3>
      <button class="modal-close" onclick="closeWorkerDialog()"><i class="fa-solid fa-xmark"></i></button>
    </div>
    <form method="POST" action="addworker.php" id="worker-form" class="modal-body" enctype="multipart/form-data">
      <label for="worker-name">Full Name:</label>
      <input id="worker-name" name="Fisherman" class="input" placeholder="Name" required />
      <label for="worker-picture">Insert Picture:</label>
      <input id="worker-picture" name="Picture" class="input" type="file" placeholder="Picture URL" accept="image/*"/>
      <label for="worker-permit">Permit Number:</label>
      <input id="worker-permit" name="Permitnumber" class="input" placeholder="Permit #" required />
      <label for="worker-similia">Amount of Similia:</label>
      <input id="worker-similia" name="AmountofSimilia" class="input" type="number" required />
      <label for="worker-age">Age:</label>
      <input id="worker-age" name="Age" class="input" type="number" required />
      <label for="worker-joined">Joined Date:</label>
      <input id="worker-joined" name="DateStarted" class="input" type="date" required />
      
      <button class="btn btn-primary" type="submit">Save Worker</button>
      <button type="button" class="btn btn-secondary" onclick="handleWorkerCancel()">Cancel</button>
    </form>
  </div>
</div>

<!-- ADD EXPENSE -->
<div id="expense-dialog" class="modal">
  <div class="modal-overlay" onclick="closeExpenseDialog()"></div>
  <div class="modal-content">
    <div class="modal-header">
      <h3>Add Expense</h3>
      <button class="modal-close" onclick="closeExpenseDialog()"><i class="fa-solid fa-xmark"></i></button>
    </div>
    <form method="POST" action="addexpense.php" id="expense-form" class="modal-body">
      <label>Fisherman:</label>
      <select id="expense-worker" name="Fisherman" class="select" required>
        <?php
        include("connection.php");
        $res = mysqli_query($conn, "SELECT id, Fisherman FROM tbl_workersdata");
        while ($row = mysqli_fetch_assoc($res)) {
          echo "<option value='{$row['Fisherman']}'>{$row['Fisherman']}</option>";
        }
        ?>
      </select>

      <label>Type of Feeds:</label>
     <select id="expense-category" name="TypeofFeeds" class="input" required>
  <option value="">-- Select Feed --</option>
  <?php
  $feeds_res = mysqli_query($conn, "
    SELECT NameofFeeds, Price, Quantity
    FROM tbl_feeds
    WHERE Quantity > 0
    ORDER BY NameofFeeds ASC
  ");
  while ($feed = mysqli_fetch_assoc($feeds_res)) {
    echo "<option value='{$feed['NameofFeeds']}' data-price='{$feed['Price']}'>
            {$feed['NameofFeeds']} (Stock: {$feed['Quantity']})
          </option>";
  }
  ?>
</select>




      <label>Price:</label>
      <input id="expense-price" name="Price" class="input" type="number" min="0" step="0.01" required readonly />

      <label>Quantity:</label>
      <input id="expense-quantity" name="Quantity" class="input" type="number" min="0" step="0.01" required />

      <label>Total Amount:</label>
      <input id="expense-amount" name="TotalAmount" class="input" type="number" step="0.01" readonly />

      <label>Date:</label>
      <input id="expense-date" name="TransactionDate" class="input" type="date" required />

      <button class="btn btn-primary" type="submit">Save Expense</button>
      <button type="button" class="btn btn-secondary" onclick="handleExpenseCancel()">Cancel</button>
    </form>
  </div>
</div>

<!-- ADD HARVEST -->
<div id="harvest-dialog" class="modal">
  <div class="modal-overlay" onclick="closeHarvestDialog()"></div>
  <div class="modal-content">
    <div class="modal-header">
      <h3>Add Harvest</h3>
      <button class="modal-close" onclick="closeHarvestDialog()"><i class="fa-solid fa-xmark"></i></button>
    </div>
    <form method="POST" action="addharvest.php" id="harvest-form" class="modal-body">
      <label>Full Name:</label>
    <select id="harvest-worker" name="Fisherman" class="select" required>
  <?php
  $res = mysqli_query($conn, "SELECT Fisherman, AmountofSimilia FROM tbl_workersdata");
  while ($row = mysqli_fetch_assoc($res)) {
    echo "<option value='{$row['Fisherman']}' data-similia='{$row['AmountofSimilia']}'>
            {$row['Fisherman']}
          </option>";
  }
  ?>
</select>



      </select>
      <label>Kilo of Fish:</label>
      <input id="harvest-kilo" name="KiloofFish" class="input" type="number" step="0.01" required />
      <label>Price per Kilo:</label>
      <input id="harvest-price" name="Priceperkilo" class="input" type="number" step="0.01" required />
      <label>Subtotal:</label>
      <input id="harvest-subtotal" name="Subtotal" class="input" type="number" step="0.01" required readonly />
      <label>Amount of Similia:</label>
      <input id="harvest-similia" name="AmountofSimilia" class="input" type="number" step="0.01" required readonly  />
      <label>Amount of Feeds:</label>
      <input id="harvest-feeds" name="AmountofFeeds" class="input" type="number" step="0.01" required />
      <label>Total Expenses:</label>
      <input id="harvest-expenses" name="TotalExpense" class="input" type="number" step="0.01" required readonly />
      <label>Profit Details:</label>
      <input id="harvest-profit" name="Profit" class="input" type="number" step="0.01" required readonly />
      <label>Divided Profit:</label>
      <input id="harvest-divprofit" name="Dividedprofit" class="input" type="number" step="0.01" required readonly />
      <label>Date:</label>
      <input id="harvest-date" name="Date" class="input" type="date" required />
      <button class="btn btn-primary" type="submit">Save Harvest</button>
      <button type="button" class="btn btn-secondary" onclick="handleHarvestCancel()">Cancel</button>
    </form>
  </div>
</div>




<!-- ADD TRANSACTION -->
<div id="transaction-dialog" class="modal">
  <div class="modal-overlay" onclick="closeTransactionDialog()"></div>
  <div class="modal-content">
    <div class="modal-header">
      <h3>Add Feedstocks</h3>
      <button class="modal-close" onclick="closeTransactionDialog()"><i class="fa-solid fa-xmark"></i></button>
    </div>
    <form method="POST" action="addtransaction.php" id="transaction-form" class="modal-body">
      <label>Name of Feeds:</label>
      <input id="transaction-category" name="NameofFeeds" type="text" class="input" required />
      <label>Price per piece:</label>
      <input id="transaction-price" name="Price" class="input" type="number" required />
      <label>Quantity:</label>
      <input id="transaction-quantity" name="Quantity" class="input" type="number" required />
      <label>Date:</label>
      <input id="transaction-date" name="Date" class="input" type="date" required />
      <button class="btn btn-primary" type="submit">Save Transaction</button>
      <button type="button" class="btn btn-secondary" onclick="handleTransactionCancel()">Cancel</button>
    </form>
  </div>
</div>

<!-- RECEIPT PREVIEW MODAL -->
<div id="receipt-modal" class="modal">
  <div class="modal-overlay" onclick="closeReceiptModal()"></div>

  <div class="modal-content receipt-modal-content">
    <div class="modal-header receipt-header">
      <h3 id="receipt-title">Receipt</h3>
      <button class="modal-close" onclick="closeReceiptModal()">
        <i class="fa-solid fa-xmark"></i>
      </button>
    </div>

    <div class="modal-body receipt-body" id="receipt-content">
      <!-- Receipt details dynamically inserted here -->
    </div>

   <div class="modal-footer" style="display:flex; justify-content:flex-end; gap:10px; margin-top:15px; padding:10px 20px; border-top:1px solid #d0d7e3; background:#f9fbff; border-radius:0 0 8px 8px;">
  <button class="btn btn-primary" onclick="printReceipt()">🖨️ Print Receipt</button>
  <button class="btn btn-secondary" onclick="closeReceiptModal()">✖ Close</button>
</div>

  </div>
</div>




<!-- Cancel helpers -->
<script>
function handleWorkerCancel(){document.getElementById("worker-form").reset();closeWorkerDialog();}
function handleExpenseCancel(){document.getElementById("expense-form").reset();closeExpenseDialog();}
function handleHarvestCancel(){document.getElementById("harvest-form").reset();closeHarvestDialog();}
function handleTransactionCancel(){document.getElementById("transaction-form").reset();closeTransactionDialog();}

function closeWorkerDialog(){document.getElementById("worker-dialog").classList.remove("active");}
function closeExpenseDialog(){document.getElementById("expense-dialog").classList.remove("active");}
function closeHarvestDialog(){document.getElementById("harvest-dialog").classList.remove("active");}
function closeTransactionDialog(){document.getElementById("transaction-dialog").classList.remove("active");}


document.addEventListener("DOMContentLoaded", function() {
  const workerSelect = $("#harvest-worker");
  const similiaInput = document.getElementById("harvest-similia");
  const kiloInput = document.getElementById("harvest-kilo");
  const priceInput = document.getElementById("harvest-price");
  const subtotalInput = document.getElementById("harvest-subtotal");
  const feedsInput = document.getElementById("harvest-feeds");
  const expensesInput = document.getElementById("harvest-expenses");
  const profitInput = document.getElementById("harvest-profit");
  const divProfitInput = document.getElementById("harvest-divprofit");

  // Initialize Select2 for Harvest
  workerSelect.select2({
    placeholder: "-- Select Fisherman --",
    allowClear: true,
    width: "100%"
  });

  // Auto-fill similia when worker changes
  workerSelect.on("change", function() {
    const selectedOption = $(this).find(":selected");
    const similiaValue = parseFloat(selectedOption.data("similia")) || 0;
    similiaInput.value = similiaValue.toFixed(2);
    calculateTotals();
  });

  function calculateTotals() {
    const kilo = parseFloat(kiloInput.value) || 0;
    const price = parseFloat(priceInput.value) || 0;
    const feeds = parseFloat(feedsInput.value) || 0;
    const similia = parseFloat(similiaInput.value) || 0;

    const subtotal = kilo * price;
    const totalExpenses = feeds + similia;
    const profit = subtotal - totalExpenses;
    const divProfit = profit / 2;

    subtotalInput.value = subtotal.toFixed(2);
    expensesInput.value = totalExpenses.toFixed(2);
    profitInput.value = profit.toFixed(2);
    divProfitInput.value = divProfit.toFixed(2);
  }

  // Update totals when numeric inputs change
  $("#harvest-kilo, #harvest-price, #harvest-feeds").on("input", calculateTotals);
});


function loadExpenses() {
  const searchValue = document.getElementById("expense-search").value;
  fetch(`fetch_expenses.php?search=${encodeURIComponent(searchValue)}`)
    .then(res => res.json())
    .then(data => {
      const tableBody = document.querySelector("#expenses-table tbody");
      tableBody.innerHTML = "";
      let total = 0;

      if (data.length === 0) {
        tableBody.innerHTML = "<tr><td colspan='6' style='text-align:center;'>No records found.</td></tr>";
      } else {
        data.forEach(exp => {
          const row = document.createElement("tr");
          row.innerHTML = `
            <td>${exp.Fisherman}</td>
            <td>${exp.TypeofFeeds}</td>
            <td>₱${parseFloat(exp.Price).toFixed(2)}</td>
            <td>${exp.Quantity}</td>
            <td>₱${parseFloat(exp.TotalAmount).toFixed(2)}</td>
            <td>${exp.TransactionDate}</td>
          `;
          tableBody.appendChild(row);
          total += parseFloat(exp.TotalAmount);
        });
      }

      document.getElementById("total-expenses-sum").textContent = "₱" + total.toFixed(2);

      // 🪄 Save fisherman + total for Harvest autofill
const fisherman = document.getElementById("expense-search").value.trim();
if (fisherman !== "") {
  localStorage.setItem("latestFisherman", fisherman);
  localStorage.setItem("latestFeedsTotal", total.toFixed(2));
  console.log("Saved total feeds:", fisherman, total.toFixed(2));
}

    })
    .catch(err => {
      console.error("Error loading expenses:", err);
    });
}

// Auto-load all expenses when page first loads
document.addEventListener("DOMContentLoaded", loadExpenses);

function searchFisherman() {
  const fisherman = document.getElementById("expense-search").value.trim();
  if (fisherman === "") return alert("Please enter a fisherman name.");

  fetch(`get_total_feeds.php?fisherman=${encodeURIComponent(fisherman)}`)
    .then(res => res.json())
    .then(data => {
      if (data.success) {
        document.getElementById("fisherman-total").innerText = 
          `Total Feeds Amount for ${fisherman}: ₱${parseFloat(data.total).toFixed(2)}`;

        // 🪄 Save it in localStorage for the Harvest autofill later
        localStorage.setItem("latestFeedsTotal", data.total);
        localStorage.setItem("latestFisherman", fisherman);
      } else {
        alert("No records found for that fisherman.");
      }
    })
    .catch(err => console.error("Error fetching total feeds:", err));
}



function loadHarvests() {
  const searchValue = document.getElementById("harvest-search").value;
  fetch(`fetch_harvests.php?search=${encodeURIComponent(searchValue)}`)
    .then(res => res.json())
    .then(data => {
      const tableBody = document.querySelector("#harvests-table tbody");
      tableBody.innerHTML = "";
      let total = 0;

      if (data.length === 0) {
        tableBody.innerHTML = "<tr><td colspan='10' style='text-align:center;'>No records found.</td></tr>";
      } else {
        data.forEach(harvest => {
          const pricePerKilo = parseFloat(harvest.Priceperkilo) || 0;
          const kiloOfFish = parseFloat(harvest.KiloofFish) || 0;
          const subtotal = parseFloat(harvest.Subtotal) || (pricePerKilo * kiloOfFish);
          const totalExpense = parseFloat(harvest.TotalExpense) || 0;
          const profit = parseFloat(harvest.Profit) || (subtotal - totalExpense);
          const dividedProfit = parseFloat(harvest.Dividedprofit) || (profit / 2);

          const row = document.createElement("tr");
          row.innerHTML = `
            <td>${harvest.Fisherman}</td>
            <td>${kiloOfFish}</td>
            <td>₱${pricePerKilo.toFixed(2)}</td>
            <td>₱${subtotal.toFixed(2)}</td>
            <td>₱${parseFloat(harvest.AmountofSimilia || 0).toFixed(2)}</td>
            <td>₱${parseFloat(harvest.AmountofFeeds || 0).toFixed(2)}</td>
            <td>₱${totalExpense.toFixed(2)}</td>
            <td>₱${profit.toFixed(2)}</td>
            <td>₱${dividedProfit.toFixed(2)}</td>
            <td>${harvest.Date}</td>
          `;
          tableBody.appendChild(row);
          total += profit;
        });
      }

      document.getElementById("total-profit-sum").textContent = "₱" + total.toFixed(2);
    })
    .catch(err => {
      console.error("Error loading harvests:", err);
    });
}


// Auto-load all harvests when page first loads
document.addEventListener("DOMContentLoaded", loadHarvests);


function loadTransactions() {
  const searchValue = document.getElementById("transaction-search").value;
  fetch(`fetch_transactions.php?search=${encodeURIComponent(searchValue)}`)
    .then(res => res.json())
    .then(data => {
      const tableBody = document.querySelector("#transactions-table tbody");
      tableBody.innerHTML = "";
      let totalSum = 0;

      if (data.length === 0) {
        tableBody.innerHTML = "<tr><td colspan='5' style='text-align:center;'>No records found.</td></tr>";
      } else {
        data.forEach(tx => {
          const row = document.createElement("tr");
          const total = parseFloat(tx.Price) * parseFloat(tx.Quantity);
          row.innerHTML = `
            <td>${tx.NameofFeeds}</td>
            <td>₱${parseFloat(tx.Price).toFixed(2)}</td>
            <td>${tx.Quantity}</td>
            <td>₱${total.toFixed(2)}</td>
            <td>${tx.Date}</td>
          `;
          tableBody.appendChild(row);
          totalSum += total;
        });
      }

      document.getElementById("total-stock-sum").textContent = "₱" + totalSum.toFixed(2);
    })
    .catch(err => {
      console.error("Error loading transactions:", err);
    });
}

// Auto-load all feedstocks when page loads
document.addEventListener("DOMContentLoaded", loadTransactions);


$(document).ready(function() {
  // Initialize searchable + clearable dropdown for both modals
  $('#expense-worker, #harvest-worker').select2({
    placeholder: "Select a Fisherman",
    allowClear: true,
    width: '100%'
  });

  // Also make Type of Feeds searchable
  $('#expense-category').select2({
    placeholder: "Select Feed",
    allowClear: true,
    width: '100%'
  });
});


document.getElementById("expense-category").addEventListener("change", function() {
  const selected = this.options[this.selectedIndex];
  const stock = parseFloat(selected.getAttribute("data-stock")) || 0;
  const price = parseFloat(selected.getAttribute("data-price")) || 0;

  document.getElementById("expense-price").value = price.toFixed(2);

  if (stock <= 0) {
    alert("This feed is out of stock and cannot be selected!");
    this.value = "";
    document.getElementById("expense-price").value = "";
  }
});

document.getElementById("harvest-worker").addEventListener("change", function() {
  const selected = this.value;
  const savedFisherman = localStorage.getItem("latestFisherman");
  const savedTotal = localStorage.getItem("latestFeedsTotal");

  if (selected === savedFisherman && savedTotal) {
    document.getElementById("harvest-feeds").value = parseFloat(savedTotal).toFixed(2);
  }
});


document.addEventListener("DOMContentLoaded", function() {
  const harvestWorker = document.getElementById("harvest-worker");
  const harvestFeeds = document.getElementById("harvest-feeds");

  if (harvestWorker && harvestFeeds) {
    harvestWorker.addEventListener("change", function() {
      const selectedFisherman = this.value;
      const savedFisherman = localStorage.getItem("latestFisherman");
      const savedTotal = localStorage.getItem("latestFeedsTotal");

      console.log("Selected:", selectedFisherman);
      console.log("Saved:", savedFisherman, savedTotal);

      if (selectedFisherman === savedFisherman && savedTotal) {
        harvestFeeds.value = parseFloat(savedTotal).toFixed(2);
      }
    });
  }
});

document.addEventListener("DOMContentLoaded", function() {
  const harvestWorker = document.getElementById("harvest-worker");
  const harvestFeeds = document.getElementById("harvest-feeds");

  if (harvestWorker && harvestFeeds) {
    harvestWorker.addEventListener("change", function() {
      const selectedFisherman = this.value.trim();
      const savedFisherman = localStorage.getItem("latestFisherman");
      const savedTotal = localStorage.getItem("latestFeedsTotal");

      console.log("Selected:", selectedFisherman);
      console.log("Saved:", savedFisherman, savedTotal);

      if (selectedFisherman === savedFisherman && savedTotal) {
        harvestFeeds.value = parseFloat(savedTotal).toFixed(2);
      }
    });
  }
});


</script>