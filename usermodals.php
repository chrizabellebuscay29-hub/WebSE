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



<!-- Cancel helpers -->
<script>
function handleWorkerCancel(){document.getElementById("worker-form").reset();closeWorkerDialog();}
function handleExpenseCancel(){document.getElementById("expense-form").reset();closeExpenseDialog();}


function closeWorkerDialog(){document.getElementById("worker-dialog").classList.remove("active");}
function closeExpenseDialog(){document.getElementById("expense-dialog").classList.remove("active");}




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

document.addEventListener("DOMContentLoaded", function() {
  // Initialize Select2 for dropdowns
  $('#expense-worker').select2({
    placeholder: "Select a Fisherman",
    allowClear: true,
    width: '100%'
  });

  $('#harvest-worker').select2({
    placeholder: "Select a Fisherman",
    allowClear: true,
    width: '100%'
  });
});



</script>
