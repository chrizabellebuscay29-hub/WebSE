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
