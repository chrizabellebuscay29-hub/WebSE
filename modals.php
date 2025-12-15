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
      
      <div class="modal-actions">
  <button class="btn btn-primary" type="submit">Save Worker</button>
  <button type="button" class="btn btn-secondary" onclick="closeWorkerDialog()">Cancel</button>
</div>
    </form>
  </div>
</div>

<style>
  .modal-actions {
  display: flex;
  justify-content: flex-end;
  gap: 10px;
  margin-top: 15px;
}

</style>

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

     <div class="modal-actions">
  <button class="btn btn-primary" type="submit">Save Expense</button>
  <button type="button" class="btn btn-secondary" onclick="handleExpenseCancel()">Cancel</button>
</div>
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
      <input id="harvest-kilo" name="KiloofFish" class="input" type="number" step="0.01"  oninput="formatNumberInput(this)" required />
      <label>Price per Kilo:</label>
      <input id="harvest-price" name="Priceperkilo" class="input" type="number" step="0.01"  oninput="formatNumberInput(this)" required />
      <label>Subtotal:</label>
      <input id="harvest-subtotal" name="Subtotal" class="input" type="number" step="0.01"  oninput="formatNumberInput(this)" required readonly />
      <label>Amount of Similia:</label>
      <input id="harvest-similia" name="AmountofSimilia" class="input" type="number" step="0.01"  oninput="formatNumberInput(this)" required readonly  />
      <label>Amount of Feeds:</label>
      <input id="harvest-feeds" name="AmountofFeeds" class="input" type="number" step="0.01"  oninput="formatNumberInput(this)" required />
      <label>Total Expenses:</label>
      <input id="harvest-expenses" name="TotalExpense" class="input" type="number" step="0.01"  oninput="formatNumberInput(this)" required readonly />
      <label>Profit Details:</label>
      <input id="harvest-profit" name="Profit" class="input" type="number" step="0.01"  oninput="formatNumberInput(this)" required readonly />
      <label>Divided Profit:</label>
      <input id="harvest-divprofit" name="Dividedprofit" class="input" type="number" step="0.01"  oninput="formatNumberInput(this)" required readonly />
      <label>Date:</label>
      <input id="harvest-date" name="Date" class="input" type="date" required />
     <div class="modal-actions">
  <button class="btn btn-primary" type="submit">Save Harvest</button>
  <button type="button" class="btn btn-secondary" onclick="handleHarvestCancel()">Cancel</button>
</div>
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
      <div class="modal-actions">
  <button class="btn btn-primary" type="submit">Save Transaction</button>
  <button type="button" class="btn btn-secondary" onclick="handleTransactionCancel()">Cancel</button>
</div>
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
const num = v => Number(v || 0);


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

//load expenses 
let currentExpensePage = 1; // Track current page globally

function loadExpenses(page = 1) {
  const searchValue = document.getElementById("expense-search").value;

  fetch(`fetch_expenses.php?search=${encodeURIComponent(searchValue)}&page=${page}`)
    .then(res => res.json())
    .then(data => {
      const tableBody = document.querySelector("#expenses-table tbody");
      tableBody.innerHTML = "";
      let total = 0;

      if (data.data.length === 0) {
        tableBody.innerHTML = "<tr><td colspan='6' style='text-align:center;'>No records found.</td></tr>";
      } else {
        data.data.forEach(exp => {
          const row = document.createElement("tr");
          row.innerHTML = `
            <td>${exp.Fisherman}</td>
            <td>${exp.TypeofFeeds}</td>
            <td>₱${parseFloat(exp.Price).toLocaleString('en-PH', { minimumFractionDigits: 2 })}</td>
            <td>${parseFloat(exp.Quantity).toLocaleString('en-PH', { minimumFractionDigits: 2 })}</td>
            <td>₱${parseFloat(exp.TotalAmount).toLocaleString('en-PH', { minimumFractionDigits: 2 })}</td>
            <td>${exp.TransactionDate}</td>
          `;
          tableBody.appendChild(row);
          total += parseFloat(exp.TotalAmount);
        });
      }

      

      // === Pagination Controls ===
      const pagination = document.getElementById("expense-pagination");
      pagination.innerHTML = "";
      pagination.style.display = "flex";
      pagination.style.justifyContent = "center";
      pagination.style.alignItems = "center";
      pagination.style.gap = "10px";
      pagination.style.marginTop = "15px";

      // ← Previous Button
      const prevBtn = document.createElement("button");
      prevBtn.innerHTML = "&#8592;";
      prevBtn.className = "btn btn-outline";
      prevBtn.disabled = (data.current_page <= 1);
      prevBtn.onclick = () => loadExpenses(data.current_page - 1);
      pagination.appendChild(prevBtn);

      // 🔢 Page Number Display (styled same as buttons)
      const pageInfo = document.createElement("button");
      pageInfo.textContent = `${data.current_page} / ${data.total_pages}`;
      pageInfo.className = "btn btn-outline";
      pageInfo.disabled = true;
      pageInfo.style.cursor = "default";
      pageInfo.style.opacity = "1"; // same full visibility
      pageInfo.style.backgroundColor = "rgba(255, 255, 255, 0.95)"; // brighter white
      pageInfo.style.color = "#082E76";
      pageInfo.style.fontWeight = "600";
      pageInfo.style.border = "1px solid #e2e8f0";
      pagination.appendChild(pageInfo);

      // → Next Button
      const nextBtn = document.createElement("button");
      nextBtn.innerHTML = "&#8594;";
      nextBtn.className = "btn btn-outline";
      nextBtn.disabled = (data.current_page >= data.total_pages);
      nextBtn.onclick = () => loadExpenses(data.current_page + 1);
      pagination.appendChild(nextBtn);

      currentExpensePage = data.current_page;
    })
    .catch(err => console.error("Error loading expenses:", err));
}

document.addEventListener("DOMContentLoaded", function() {
  loadExpenses(); // loads page 1 on startup
  updateExpenseTotal();
refreshFeedsData()
});
// === Fetch total expenses for searched fisherman ===
function updateExpenseTotal() {
  const searchValue = document.getElementById("expense-search").value.trim();
  console.log("Searching total for:", searchValue); // 👈 DEBUG

  fetch(`fetch_expense_total.php?search=${encodeURIComponent(searchValue)}`)
    .then(res => res.json())
    .then(data => {
      console.log("Total response:", data); // 👈 DEBUG
      document.getElementById("expense-total").value =
        "₱" + Number(data.total).toLocaleString('en-PH', {
          minimumFractionDigits: 2
        });
    });
}



let currentHarvestPage = 1;

function loadHarvests(page = 1) {
  currentHarvestPage = page;

  const search = document.getElementById("harvest-search")?.value || "";

  fetch(`fetch_harvests.php?page=${page}&search=${encodeURIComponent(search)}`)
    .then(res => res.json())
    .then(result => {

      const tableBody = document.querySelector("#harvests-table tbody");
      tableBody.innerHTML = "";

      if (!result.data || result.data.length === 0) {
        tableBody.innerHTML =
          "<tr><td colspan='10' style='text-align:center;'>No records found.</td></tr>";
        return;
      }

      result.data.forEach(h => {
        const tr = document.createElement("tr");
        tr.innerHTML = `
          <td>${h.Fisherman}</td>
          <td>${Number(h.KiloofFish).toLocaleString()}</td>
          <td>₱${Number(h.Priceperkilo).toLocaleString('en-PH', { minimumFractionDigits: 2 })}</td>
          <td>₱${Number(h.Subtotal).toLocaleString('en-PH', { minimumFractionDigits: 2 })}</td>
          <td>₱${Number(h.AmountofFeeds).toLocaleString('en-PH', { minimumFractionDigits: 2 })}</td>
          <td>₱${Number(h.AmountofSimilia).toLocaleString('en-PH', { minimumFractionDigits: 2 })}</td>
          <td>₱${Number(h.TotalExpense).toLocaleString('en-PH', { minimumFractionDigits: 2 })}</td>
          <td>₱${Number(h.Profit).toLocaleString('en-PH', { minimumFractionDigits: 2 })}</td>
          <td>₱${Number(h.Dividedprofit).toLocaleString('en-PH', { minimumFractionDigits: 2 })}</td>
          <td>${h.Date}</td>
        `;
        tableBody.appendChild(tr);
      });

      // === Pagination Controls (SAME AS TRANSACTIONS) ===
      const pagination = document.getElementById("harvests-pagination");
      pagination.innerHTML = "";
      pagination.style.display = "flex";
      pagination.style.justifyContent = "center";
      pagination.style.alignItems = "center";
      pagination.style.gap = "10px";
      pagination.style.marginTop = "15px";

      // ← Previous
      const prevBtn = document.createElement("button");
      prevBtn.innerHTML = "&#8592;";
      prevBtn.className = "btn btn-outline";
      prevBtn.disabled = (result.current_page <= 1);
      prevBtn.onclick = () => loadHarvests(result.current_page - 1);
      pagination.appendChild(prevBtn);

      // Page number
      const pageInfo = document.createElement("button");
      pageInfo.textContent = `${result.current_page} / ${result.total_pages}`;
      pageInfo.className = "btn btn-outline";
      pageInfo.disabled = true;
      pageInfo.style.cursor = "default";
      pageInfo.style.opacity = "1";
      pageInfo.style.backgroundColor = "rgba(255, 255, 255, 0.95)";
      pageInfo.style.color = "#082E76";
      pageInfo.style.fontWeight = "600";
      pageInfo.style.border = "1px solid #e2e8f0";
      pagination.appendChild(pageInfo);

      // → Next
      const nextBtn = document.createElement("button");
      nextBtn.innerHTML = "&#8594;";
      nextBtn.className = "btn btn-outline";
      nextBtn.disabled = (result.current_page >= result.total_pages);
      nextBtn.onclick = () => loadHarvests(result.current_page + 1);
      pagination.appendChild(nextBtn);

    })
    .catch(err => console.error("Harvest load error:", err));
}

// Auto-load
document.addEventListener("DOMContentLoaded", () => loadHarvests());



let currentTransactionPage = 1;

function loadTransactions(page = 1) {
  const searchValue = document.getElementById("transaction-search").value;

  fetch(`fetch_transactions.php?search=${encodeURIComponent(searchValue)}&page=${page}`)
    .then(res => res.json())
    .then(data => {
      const tableBody = document.querySelector("#transactions-table tbody");
      tableBody.innerHTML = "";
      let total = 0;

      if (data.data.length === 0) {
        tableBody.innerHTML = "<tr><td colspan='5' style='text-align:center;'>No records found.</td></tr>";
      } else {
        data.data.forEach(row => {
          const tr = document.createElement("tr");
          const totalAmount = row.Quantity * row.Price;
          tr.innerHTML = `
            <td>${row.NameofFeeds}</td>
            <td>₱${parseFloat(row.Price).toLocaleString('en-PH', { minimumFractionDigits: 2 })}</td>
            <td>${parseFloat(row.Quantity).toLocaleString('en-PH', { minimumFractionDigits: 2 })}</td>
            <td>₱${parseFloat(totalAmount).toLocaleString('en-PH', { minimumFractionDigits: 2 })}</td>
            <td>${row.Date}</td>
          `;
          tableBody.appendChild(tr);
          total += totalAmount;
          
        });
        
      }
      

    

      // === Pagination Controls ===
      const pagination = document.getElementById("transaction-pagination");
      pagination.innerHTML = "";
      pagination.style.display = "flex";
      pagination.style.justifyContent = "center";
      pagination.style.alignItems = "center";
      pagination.style.gap = "10px";
      pagination.style.marginTop = "15px";

      // ← Previous
      const prevBtn = document.createElement("button");
      prevBtn.innerHTML = "&#8592;";
      prevBtn.className = "btn btn-outline";
      prevBtn.disabled = (data.current_page <= 1);
      prevBtn.onclick = () => loadTransactions(data.current_page - 1);
      pagination.appendChild(prevBtn);

      // Page number
      const pageInfo = document.createElement("button");
      pageInfo.textContent = `${data.current_page} / ${data.total_pages}`;
      pageInfo.className = "btn btn-outline";
      pageInfo.disabled = true;
      pageInfo.style.cursor = "default";
      pageInfo.style.opacity = "1";
      pageInfo.style.backgroundColor = "rgba(255, 255, 255, 0.95)";
      pageInfo.style.color = "#082E76";
      pageInfo.style.fontWeight = "600";
      pageInfo.style.border = "1px solid #e2e8f0";
      pagination.appendChild(pageInfo);

      // → Next
      const nextBtn = document.createElement("button");
      nextBtn.innerHTML = "&#8594;";
      nextBtn.className = "btn btn-outline";
      nextBtn.disabled = (data.current_page >= data.total_pages);
      nextBtn.onclick = () => loadTransactions(data.current_page + 1);
      pagination.appendChild(nextBtn);

      currentTransactionPage = data.current_page;
    })
    .catch(err => console.error("Error loading transactions:", err));
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



function formatNumberInput(input) {
  // remove commas
  let value = input.value.replace(/,/g, '');

  // allow empty
  if (value === '' || isNaN(value)) {
    input.value = '';
    return;
  }

  // format with commas
  input.value = Number(value).toLocaleString('en-PH');
}



</script>
<style>
  /* ================= MODAL BASE ================= */
.modal {
  display: none;
  position: fixed;
  inset: 0;
  z-index: 1000;
  font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
  transition: all 0.3s ease-in-out;
}

.modal.active {
  display: block;
}

/* ================= OVERLAY ================= */
.modal-overlay {
  position: fixed;
  inset: 0;
  background: rgba(0, 0, 0, 0.5);
  backdrop-filter: blur(4px);
  animation: fadeIn 0.25s ease-in-out;
}

/* ================= MODAL CONTENT ================= */
.modal-content {
  position: fixed;
  top: 50%;
  left: 50%;
  width: 90%;
  max-width: 600px;
  background: rgba(255, 255, 255, 0.85); /* subtle glass effect */
  backdrop-filter: blur(5px) saturate(120%); /* light blur */
  -webkit-backdrop-filter: blur(5px) saturate(120%);
  border: 1px solid rgba(200, 200, 200, 0.3); /* soft border */
  border-radius: 15px;
  box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15); /* softer shadow */
  transform: translate(-50%, -50%) scale(0.95);
  transition: all 0.3s ease-in-out;
  overflow: hidden;
}

.modal.active .modal-content {
  transform: translate(-50%, -50%) scale(1);
}


/* ================= MODAL HEADER ================= */
.modal-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 15px 20px;
  background: linear-gradient(135deg, #1e3c72, #2a5298);
  color: #fff;
  font-weight: 600;
  font-size: 1.2rem;
  border-bottom: 1px solid rgba(255, 255, 255, 0.2);
}

.modal-header h3 {
  margin: 0;
}

.modal-close {
  background: rgba(255, 255, 255, 0.15);
  border: none;
  color: #fff;
  padding: 6px 10px;
  border-radius: 50%;
  cursor: pointer;
  transition: all 0.2s ease;
}

.modal-close:hover {
  background: rgba(255, 255, 255, 0.35);
  transform: scale(1.1);
}

/* ================= MODAL BODY ================= */
.modal-body {
  padding: 20px 25px;
  display: flex;
  flex-direction: column;
  gap: 12px;
}

.modal-body label {
  font-weight: 600;
  font-size: 0.95rem;
  color: #082E76;
}

.modal-body input,
.modal-body select {
  padding: 10px 12px;
  border: 1px solid rgba(0, 46, 118, 0.2);
  border-radius: 8px;
  outline: none;
  font-size: 0.95rem;
  background: rgba(255, 255, 255, 0.25);
  color: #082E76;
  transition: all 0.2s ease;
}

.modal-body input:focus,
.modal-body select:focus {
  border-color: #1e90ff;
  box-shadow: 0 0 6px rgba(30, 144, 255, 0.4);
}

/* ================= MODAL ACTIONS ================= */
.modal-actions {
  display: flex;
  justify-content: flex-end;
  gap: 12px;
  margin-top: 15px;
}

.btn {
  padding: 10px 18px;
  font-weight: 600;
  border-radius: 8px;
  border: none;
  cursor: pointer;
  transition: all 0.25s ease;
  font-size: 0.95rem;
}

.btn-primary {
  background: linear-gradient(90deg,var(--primary), var(--accent));
  color: #fff;
  box-shadow: 0 4px 15px rgba(30, 144, 255, 0.3);
}

.btn-primary:hover {
  transform: translateY(-2px);
  box-shadow: 0 6px 20px rgba(30, 144, 255, 0.45);
}

.btn-secondary {
  background: rgba(255, 255, 255, 0.25);
  color: #082E76;
  border: 1px solid rgba(8, 46, 118, 0.4);
}

.btn-secondary:hover {
  background: rgba(255, 255, 255, 0.45);
}

/* ================= RECEIPT MODAL ================= */
.receipt-modal-content {
  max-width: 500px;
  background: linear-gradient(135deg, rgba(30, 60, 72, 0.9), rgba(42, 82, 152, 0.9));
  color: #fff;
}

.receipt-header {
  background: rgba(255, 255, 255, 0.15);
  color: #fff;
}

.receipt-body {
  background: rgba(255, 255, 255, 0.1);
  padding: 15px 20px;
  max-height: 400px;
  overflow-y: auto;
  border-radius: 0 0 15px 15px;
}

/* ================= ANIMATION ================= */
@keyframes fadeIn {
  from { opacity: 0; }
  to { opacity: 1; }
}

/* ================= SCROLLBAR FOR RECEIPT ================= */
.receipt-body::-webkit-scrollbar {
  width: 8px;
}

.receipt-body::-webkit-scrollbar-track {
  background: rgba(255, 255, 255, 0.05);
  border-radius: 4px;
}

.receipt-body::-webkit-scrollbar-thumb {
  background: rgba(255, 255, 255, 0.2);
  border-radius: 4px;
}

</style>