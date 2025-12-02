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
        $feeds_res = mysqli_query($conn, "SELECT ID, NameofFeeds, Price FROM tbl_feeds");
        $feeds_array = [];
        while ($feed = mysqli_fetch_assoc($feeds_res)) {
          echo "<option value='{$feed['NameofFeeds']}' data-price='{$feed['Price']}'>{$feed['NameofFeeds']}</option>";
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
    echo "<option value='{$row['Fisherman']}' data-similia='{$row['AmountofSimilia']}'>{$row['Fisherman']}</option>";
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
  const kiloInput = document.getElementById("harvest-kilo");
  const priceInput = document.getElementById("harvest-price");
  const subtotalInput = document.getElementById("harvest-subtotal");
  const similiaInput = document.getElementById("harvest-similia");
  const feedsInput = document.getElementById("harvest-feeds");
  const expensesInput = document.getElementById("harvest-expenses");
  const profitInput = document.getElementById("harvest-profit");
  const divProfitInput = document.getElementById("harvest-divprofit");
  const workerSelect = document.getElementById("harvest-worker");

  function updateSubtotal() {
    const kilo = parseFloat(kiloInput.value) || 0;
    const price = parseFloat(priceInput.value) || 0;
    subtotalInput.value = (kilo * price).toFixed(2);
    updateCalculations();
  }

  function updateSimilia() {
    const selectedOption = workerSelect.options[workerSelect.selectedIndex];
    const similia = parseFloat(selectedOption.getAttribute("data-similia")) || 0;
    similiaInput.value = similia.toFixed(2);
    updateCalculations();
  }

  function updateCalculations() {
    const similia = parseFloat(similiaInput.value) || 0;
    const feeds = parseFloat(feedsInput.value) || 0;
    const subtotal = parseFloat(subtotalInput.value) || 0;

    const totalExpenses = similia + feeds;
    expensesInput.value = totalExpenses.toFixed(2);

    const profit = subtotal - totalExpenses;
    profitInput.value = profit.toFixed(2);

    const dividedProfit = profit / 2;
    divProfitInput.value = dividedProfit.toFixed(2);
  }

  // Event listeners
  kiloInput.addEventListener("input", updateSubtotal);
  priceInput.addEventListener("input", updateSubtotal);
  feedsInput.addEventListener("input", updateCalculations);
  workerSelect.addEventListener("change", updateSimilia);
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
    })
    .catch(err => {
      console.error("Error loading expenses:", err);
    });
}

// Auto-load all expenses when page first loads
document.addEventListener("DOMContentLoaded", loadExpenses);


function loadHarvests() {
  const searchValue = document.getElementById("harvest-search").value;
  fetch(`fetch_harvests.php?search=${encodeURIComponent(searchValue)}`)
    .then(res => res.json())
    .then(data => {
      const tableBody = document.querySelector("#harvests-table tbody");
      tableBody.innerHTML = "";
      let totalProfit = 0;

      if (data.length === 0) {
        tableBody.innerHTML = "<tr><td colspan='10' style='text-align:center;'>No harvest records found.</td></tr>";
      } else {
        data.forEach(h => {
          const row = document.createElement("tr");
          row.innerHTML = `
            <td>${h.Fisherman}</td>
            <td>${h.KiloofFish}</td>
            <td>₱${parseFloat(h.PricePerkilo).toFixed(2)}</td>
            <td>₱${parseFloat(h.Subtotal).toFixed(2)}</td>
            <td>₱${parseFloat(h.AmountofSimilia).toFixed(2)}</td>
            <td>₱${parseFloat(h.AmountofFeeds).toFixed(2)}</td>
            <td>₱${parseFloat(h.TotalExpense).toFixed(2)}</td>
            <td>₱${parseFloat(h.Profit).toFixed(2)}</td>
            <td>₱${parseFloat(h.Dividedprofit).toFixed(2)}</td>
            <td>${h.Date}</td>
          `;
          tableBody.appendChild(row);
          totalProfit += parseFloat(h.Profit);
        });
      }

      document.getElementById("total-profit-sum").textContent = "₱" + totalProfit.toFixed(2);
    })
    .catch(err => {
      console.error("Error loading harvests:", err);
    });
}

// Auto-load all harvests when page first loads
document.addEventListener("DOMContentLoaded", loadHarvests);




</script>
