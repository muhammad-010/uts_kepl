<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Dashboard — UMKM Inventory</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body {
      min-height: 100vh;
      background: linear-gradient(135deg, #0a1628 0%, #1a2332 25%, #0d1b2a 50%, #1b263b 75%, #0f1e2e 100%);
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      position: relative;
      overflow-x: hidden;
    }

    body::before {
      content: '';
      position: absolute;
      width: 600px;
      height: 600px;
      background: radial-gradient(circle, rgba(59, 130, 246, 0.1) 0%, transparent 70%);
      top: -200px;
      right: -200px;
      border-radius: 50%;
      animation: float 8s ease-in-out infinite;
      z-index: 0;
    }

    @keyframes float {
      0%, 100% { transform: translateY(0px) rotate(0deg); }
      50% { transform: translateY(-30px) rotate(5deg); }
    }

    /* Navbar Styling */
    .navbar-custom {
      background: rgba(15, 23, 42, 0.95);
      backdrop-filter: blur(20px);
      border-bottom: 1px solid rgba(59, 130, 246, 0.2);
      box-shadow: 0 4px 20px rgba(0, 0, 0, 0.3);
      padding: 1rem 0;
      position: sticky;
      top: 0;
      z-index: 1000;
    }

    .navbar-brand {
      color: #f8fafc !important;
      font-weight: 700;
      font-size: 1.4rem;
      display: flex;
      align-items: center;
      gap: 0.5rem;
    }

    .navbar-brand i {
      color: #3b82f6;
      font-size: 1.6rem;
    }

    .btn-logout {
      background: linear-gradient(135deg, #ef4444, #dc2626);
      color: white;
      border: none;
      padding: 0.5rem 1.5rem;
      border-radius: 8px;
      font-weight: 500;
      transition: all 0.3s ease;
      box-shadow: 0 4px 12px rgba(239, 68, 68, 0.3);
    }

    .btn-logout:hover {
      transform: translateY(-2px);
      box-shadow: 0 6px 20px rgba(239, 68, 68, 0.4);
    }

    /* Container */
    .container-custom {
      position: relative;
      z-index: 1;
      padding: 2rem 1rem;
      max-width: 1400px;
      margin: 0 auto;
    }

    /* Stats Cards */
    .stats-row {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
      gap: 1.5rem;
      margin-bottom: 2rem;
    }

    .stat-card {
      background: rgba(15, 23, 42, 0.7);
      backdrop-filter: blur(20px);
      border: 1px solid rgba(59, 130, 246, 0.2);
      border-radius: 16px;
      padding: 1.5rem;
      box-shadow: 0 8px 32px rgba(0, 0, 0, 0.3);
      transition: all 0.3s ease;
      position: relative;
      overflow: hidden;
    }

    .stat-card::before {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      right: 0;
      height: 3px;
      background: linear-gradient(90deg, #3b82f6, #2563eb);
    }

    .stat-card:hover {
      transform: translateY(-5px);
      box-shadow: 0 12px 40px rgba(59, 130, 246, 0.2);
    }

    .stat-icon {
      width: 50px;
      height: 50px;
      background: linear-gradient(135deg, #3b82f6, #2563eb);
      border-radius: 12px;
      display: flex;
      align-items: center;
      justify-content: center;
      margin-bottom: 1rem;
      box-shadow: 0 4px 15px rgba(59, 130, 246, 0.3);
    }

    .stat-icon i {
      color: white;
      font-size: 1.5rem;
    }

    .stat-value {
      color: #f8fafc;
      font-size: 2rem;
      font-weight: 700;
      margin-bottom: 0.3rem;
    }

    .stat-label {
      color: #94a3b8;
      font-size: 0.9rem;
      font-weight: 500;
    }

    /* Card Styling */
    .card-custom {
      background: rgba(15, 23, 42, 0.7);
      backdrop-filter: blur(20px);
      border: 1px solid rgba(59, 130, 246, 0.2);
      border-radius: 16px;
      box-shadow: 0 8px 32px rgba(0, 0, 0, 0.3);
      margin-bottom: 2rem;
      overflow: hidden;
    }

    .card-header-custom {
      background: rgba(59, 130, 246, 0.1);
      border-bottom: 1px solid rgba(59, 130, 246, 0.2);
      padding: 1.25rem 1.5rem;
      display: flex;
      justify-content: space-between;
      align-items: center;
    }

    .card-header-custom strong {
      color: #f8fafc;
      font-size: 1.2rem;
      font-weight: 600;
      display: flex;
      align-items: center;
      gap: 0.5rem;
    }

    .card-header-custom strong i {
      color: #3b82f6;
    }

    .card-body-custom {
      padding: 1.5rem;
    }

    /* Button Styling */
    .btn-add {
      background: linear-gradient(135deg, #3b82f6, #2563eb);
      color: white;
      border: none;
      padding: 0.6rem 1.5rem;
      border-radius: 10px;
      font-weight: 500;
      transition: all 0.3s ease;
      box-shadow: 0 4px 12px rgba(59, 130, 246, 0.3);
      display: flex;
      align-items: center;
      gap: 0.5rem;
    }

    .btn-add:hover {
      transform: translateY(-2px);
      box-shadow: 0 6px 20px rgba(59, 130, 246, 0.4);
      color: white;
    }

    .btn-edit {
      background: linear-gradient(135deg, #10b981, #059669);
      color: white;
      border: none;
      padding: 0.4rem 0.8rem;
      border-radius: 6px;
      font-size: 0.85rem;
      transition: all 0.3s ease;
    }

    .btn-edit:hover {
      transform: translateY(-2px);
      box-shadow: 0 4px 12px rgba(16, 185, 129, 0.4);
    }

    .btn-delete {
      background: linear-gradient(135deg, #ef4444, #dc2626);
      color: white;
      border: none;
      padding: 0.4rem 0.8rem;
      border-radius: 6px;
      font-size: 0.85rem;
      transition: all 0.3s ease;
    }

    .btn-delete:hover {
      transform: translateY(-2px);
      box-shadow: 0 4px 12px rgba(239, 68, 68, 0.4);
    }

    /* Table Styling */
    .table-custom {
      width: 100%;
      color: #f8fafc;
      border-collapse: separate;
      border-spacing: 0;
    }

    .table-custom thead {
      background: rgba(59, 130, 246, 0.15);
    }

    .table-custom thead th {
      color: #cbd5e1;
      font-weight: 600;
      text-transform: uppercase;
      font-size: 0.8rem;
      letter-spacing: 0.5px;
      padding: 1rem;
      border-bottom: 2px solid rgba(59, 130, 246, 0.3);
    }

    .table-custom tbody tr {
      background: rgba(15, 23, 42, 0.4);
      transition: all 0.3s ease;
    }

    .table-custom tbody tr:hover {
      background: rgba(59, 130, 246, 0.1);
      transform: scale(1.01);
    }

    .table-custom tbody td {
      padding: 1rem;
      border-bottom: 1px solid rgba(59, 130, 246, 0.1);
      color: #cbd5e1;
    }

    .table-custom tbody tr:last-child td {
      border-bottom: none;
    }

    /* Modal Styling */
    .modal-custom .modal-content {
      background: rgba(15, 23, 42, 0.95);
      backdrop-filter: blur(20px);
      border: 1px solid rgba(59, 130, 246, 0.3);
      border-radius: 16px;
      box-shadow: 0 25px 50px rgba(0, 0, 0, 0.5);
    }

    .modal-custom .modal-header {
      border-bottom: 1px solid rgba(59, 130, 246, 0.2);
      padding: 1.5rem;
      background: rgba(59, 130, 246, 0.1);
    }

    .modal-custom .modal-title {
      color: #f8fafc;
      font-weight: 600;
      font-size: 1.3rem;
    }

    .modal-custom .btn-close {
      filter: invert(1);
      opacity: 0.8;
    }

    .modal-custom .modal-body {
      padding: 1.5rem;
    }

    .modal-custom .form-label {
      color: #cbd5e1;
      font-weight: 500;
      margin-bottom: 0.5rem;
      font-size: 0.9rem;
    }

    .modal-custom .form-control {
      background: rgba(15, 23, 42, 0.6);
      border: 1px solid rgba(59, 130, 246, 0.3);
      border-radius: 8px;
      color: #f8fafc;
      padding: 0.7rem;
      transition: all 0.3s ease;
    }

    .modal-custom .form-control:focus {
      background: rgba(15, 23, 42, 0.8);
      border-color: #3b82f6;
      box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
      color: #f8fafc;
    }

    .modal-custom .modal-footer {
      border-top: 1px solid rgba(59, 130, 246, 0.2);
      padding: 1.5rem;
    }

    .modal-custom .btn-secondary {
      background: rgba(71, 85, 105, 0.5);
      border: 1px solid rgba(71, 85, 105, 0.5);
      color: #cbd5e1;
    }

    .modal-custom .btn-secondary:hover {
      background: rgba(71, 85, 105, 0.7);
    }

    .modal-custom .btn-primary {
      background: linear-gradient(135deg, #3b82f6, #2563eb);
      border: none;
      box-shadow: 0 4px 12px rgba(59, 130, 246, 0.3);
    }

    .modal-custom .btn-primary:hover {
      transform: translateY(-2px);
      box-shadow: 0 6px 20px rgba(59, 130, 246, 0.4);
    }

    /* Responsive */
    @media (max-width: 768px) {
      .stats-row {
        grid-template-columns: 1fr;
      }
      
      .table-custom {
        font-size: 0.85rem;
      }
      
      .table-custom thead th,
      .table-custom tbody td {
        padding: 0.7rem 0.5rem;
      }
    }

    /* Scrollbar */
    ::-webkit-scrollbar {
      width: 10px;
      height: 10px;
    }

    ::-webkit-scrollbar-track {
      background: rgba(15, 23, 42, 0.5);
    }

    ::-webkit-scrollbar-thumb {
      background: rgba(59, 130, 246, 0.5);
      border-radius: 5px;
    }

    ::-webkit-scrollbar-thumb:hover {
      background: rgba(59, 130, 246, 0.7);
    }

    .table-responsive {
      border-radius: 12px;
      overflow: hidden;
    }
  </style>
</head>
<body>
<!-- Navbar -->
<nav class="navbar-custom">
  <div class="container-fluid px-4 d-flex align-items-center justify-content-between">
    <a class="navbar-brand" href="#">
      <i class="fas fa-box"></i>
      UMKM Inventory
    </a>
    <button id="btnLogout" class="btn-logout">
      <i class="fas fa-sign-out-alt"></i> Logout
    </button>
</div>
</nav>

<!-- Main Content -->
<div class="container-custom">
  <!-- Stats Cards -->
  <div class="stats-row">
    <div class="stat-card">
      <div class="stat-icon">
        <i class="fas fa-users"></i>
      </div>
      <div class="stat-value" id="totalCustomers">0</div>
      <div class="stat-label">Total Customers</div>
    </div>
    <div class="stat-card">
      <div class="stat-icon">
        <i class="fas fa-box-open"></i>
      </div>
      <div class="stat-value" id="totalProducts">0</div>
      <div class="stat-label">Total Products</div>
    </div>
    <div class="stat-card">
      <div class="stat-icon">
        <i class="fas fa-warehouse"></i>
      </div>
      <div class="stat-value" id="totalStock">0</div>
      <div class="stat-label">Total Stock</div>
    </div>
  </div>

  <!-- Customers Table -->
  <div class="card-custom">
    <div class="card-header-custom">
      <strong><i class="fas fa-users"></i> Customers</strong>
      <button class="btn-add" data-bs-toggle="modal" data-bs-target="#customerModal">
        <i class="fas fa-plus"></i> Add Customer
      </button>
    </div>
    <div class="card-body-custom">
      <div class="table-responsive">
        <table class="table-custom" id="customersTable">
          <thead>
            <tr>
              <th>ID</th>
              <th>Name</th>
              <th>Email</th>
              <th>Phone</th>
              <th>Address</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody></tbody>
        </table>
      </div>
    </div>
  </div>

  <!-- Products Table -->
  <div class="card-custom">
    <div class="card-header-custom">
      <strong><i class="fas fa-box-open"></i> Products</strong>
      <button class="btn-add" data-bs-toggle="modal" data-bs-target="#productModal">
        <i class="fas fa-plus"></i> Add Product
      </button>
    </div>
    <div class="card-body-custom">
      <div class="table-responsive">
        <table class="table-custom" id="productsTable">
          <thead>
            <tr>
              <th>ID</th>
              <th>Name</th>
              <th>SKU</th>
              <th>Price</th>
              <th>Stock</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody></tbody>
        </table>
      </div>
    </div>
  </div>
</div>

<!-- Customer Modal -->
<div class="modal fade modal-custom" id="customerModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title"><i class="fas fa-user-edit"></i> Customer Form</h5>
        <button class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <input type="hidden" id="customerId">
        <div class="mb-3">
          <label class="form-label">Name</label>
          <input class="form-control" id="customerName" placeholder="Enter customer name">
        </div>
        <div class="mb-3">
          <label class="form-label">Email</label>
          <input class="form-control" id="customerEmail" type="email" placeholder="Enter email address">
        </div>
        <div class="mb-3">
          <label class="form-label">Phone</label>
          <input class="form-control" id="customerPhone" placeholder="Enter phone number">
        </div>
        <div class="mb-3">
          <label class="form-label">Address</label>
          <input class="form-control" id="customerAddress" placeholder="Enter address">
        </div>
      </div>
      <div class="modal-footer">
        <button class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        <button class="btn btn-primary" id="saveCustomer">
          <i class="fas fa-save"></i> Save Customer
        </button>
      </div>
    </div>
  </div>
</div>

<!-- Product Modal -->
<div class="modal fade modal-custom" id="productModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title"><i class="fas fa-box-edit"></i> Product Form</h5>
        <button class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <input type="hidden" id="productId">
        <div class="mb-3">
          <label class="form-label">Name</label>
          <input class="form-control" id="productName" placeholder="Enter product name">
        </div>
        <div class="mb-3">
          <label class="form-label">SKU</label>
          <input class="form-control" id="productSku" placeholder="Enter SKU code">
        </div>
        <div class="mb-3">
          <label class="form-label">Price</label>
          <input class="form-control" id="productPrice" type="number" step="0.01" placeholder="Enter price">
        </div>
        <div class="mb-3">
          <label class="form-label">Stock</label>
          <input class="form-control" id="productStock" type="number" placeholder="Enter stock quantity">
        </div>
      </div>
      <div class="modal-footer">
        <button class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        <button class="btn btn-primary" id="saveProduct">
          <i class="fas fa-save"></i> Save Product
        </button>
      </div>
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
  // === Base URL mengikuti origin saat ini (jalan di Docker 8080 maupun artisan 8000) ===
  const API_BASE = `${window.location.origin.replace(/\/$/, '')}/api`;

  // === Ambil token dari localStorage ===
  const token = localStorage.getItem('token');
  if (!token) { window.location.href = '/login'; }

  // === Axios instance dengan header Authorization otomatis ===
  const api = axios.create({
    baseURL: API_BASE,
    headers: { Authorization: `Bearer ${token}` }
  });

  // Kalau 401: bersihkan token & kembali ke login
  api.interceptors.response.use(
    r => r,
    err => {
      if (err?.response?.status === 401) {
        localStorage.removeItem('token');
        alert('Sesi berakhir. Silakan login lagi.');
        window.location.href = '/login';
      }
      return Promise.reject(err);
    }
  );

  // === Logout ===
  document.getElementById('btnLogout').addEventListener('click', async () => {
    try { await api.post('/logout'); } catch (e) {}
    localStorage.removeItem('token');
    document.getElementById('totalCustomers').textContent = customers.length;
    window.location.href = '/login';
  });

  // === Load data ===
    async function loadCustomers(){
    const res = await api.get('/customers');
    const paged = res.data.data;      // objek paginator
    const rows  = paged.data || [];   // array item halaman ini

    // total seluruh customer (di DB), bukan cuma halaman ini
    document.getElementById('totalCustomers').textContent = paged.total ?? rows.length;

    const tbody = document.querySelector('#customersTable tbody');
    tbody.innerHTML = '';
    rows.forEach(c => {
        const tr = document.createElement('tr');
        tr.innerHTML = `
        <td>${c.id}</td>
        <td>${c.name}</td>
        <td>${c.email}</td>
        <td>${c.phone}</td>
        <td>${c.address || ''}</td>
        <td>
            <button class="btn btn-sm btn-warning me-1" onclick='editCustomer(${JSON.stringify(c).replaceAll("'", "&apos;")})'>Edit</button>
            <button class="btn btn-sm btn-danger" onclick="deleteCustomer(${c.id})">Del</button>
        </td>`;
        tbody.appendChild(tr);
    });
    }

    async function loadProducts(){
    const res = await api.get('/products');
    const paged = res.data.data;
    const rows  = paged.data || [];

    // total seluruh product (di DB)
    document.getElementById('totalProducts').textContent = paged.total ?? rows.length;

    const tbody = document.querySelector('#productsTable tbody');
    tbody.innerHTML = '';
    rows.forEach(p => {
        const tr = document.createElement('tr');
        tr.innerHTML = `
        <td>${p.id}</td>
        <td>${p.name}</td>
        <td>${p.sku}</td>
        <td>${p.price}</td>
        <td>${p.stock}</td>
        <td>
            <button class="btn btn-sm btn-warning me-1" onclick='editProduct(${JSON.stringify(p).replaceAll("'", "&apos;")})'>Edit</button>
            <button class="btn btn-sm btn-danger" onclick="deleteProduct(${p.id})">Del</button>
        </td>`;
        tbody.appendChild(tr);
    });

    // total stock DI HALAMAN INI saja:
    const totalStockPage = rows.reduce((sum, p) => sum + (Number(p.stock) || 0), 0);
    document.getElementById('totalStock').textContent = totalStockPage;
}

  // === Delete (pakai api instance + refresh yang benar) ===
  async function deleteCustomer(id) {
    if (!confirm('Hapus customer ini?')) return;
    await api.delete(`/customers/${id}`);
    await loadCustomers(); // sebelumnya salah: fetchCustomers()
  }

  async function deleteProduct(id) {
    if (!confirm('Hapus produk ini?')) return;
    await api.delete(`/products/${id}`);
    await loadProducts(); // sebelumnya salah: fetchProducts()
  }

  // === Edit modal helpers ===
  function editCustomer(c){
    document.getElementById('customerId').value = c.id;
    document.getElementById('customerName').value = c.name;
    document.getElementById('customerEmail').value = c.email;
    document.getElementById('customerPhone').value = c.phone;
    document.getElementById('customerAddress').value = c.address || '';
    new bootstrap.Modal(document.getElementById('customerModal')).show();
  }

  function editProduct(p){
    document.getElementById('productId').value = p.id;
    document.getElementById('productName').value = p.name;
    document.getElementById('productSku').value = p.sku;
    document.getElementById('productPrice').value = p.price;
    document.getElementById('productStock').value = p.stock;
    new bootstrap.Modal(document.getElementById('productModal')).show();
  }

  // === Create/Update ===
  document.getElementById('saveCustomer').addEventListener('click', async () => {
    const id = document.getElementById('customerId').value;
    const payload = {
      name: document.getElementById('customerName').value,
      email: document.getElementById('customerEmail').value,
      phone: document.getElementById('customerPhone').value,
      address: document.getElementById('customerAddress').value,
    };
    if (id) await api.put(`/customers/${id}`, payload);
    else await api.post('/customers', payload);
    bootstrap.Modal.getInstance(document.getElementById('customerModal')).hide();
    await loadCustomers();
  });

  document.getElementById('saveProduct').addEventListener('click', async () => {
    const id = document.getElementById('productId').value;
    const payload = {
      name: document.getElementById('productName').value,
      sku: document.getElementById('productSku').value,
      price: document.getElementById('productPrice').value,
      stock: document.getElementById('productStock').value,
    };
    if (id) await api.put(`/products/${id}`, payload);
    else await api.post('/products', payload);
    bootstrap.Modal.getInstance(document.getElementById('productModal')).hide();
    await loadProducts();
  });

  // === Init ===
  (async function init(){
    try { await api.get('/profile'); } catch(e){ return; }
    await loadCustomers();
    await loadProducts();
  })();
</script>