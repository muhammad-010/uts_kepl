<template>
  <div class="card-custom">
    <div class="card-header-custom">
      <strong><i class="fas fa-truck"></i> Suppliers</strong>
      <button class="btn-add" @click="showAddModal">
        <i class="fas fa-plus"></i> Add Supplier
      </button>
    </div>
    <div class="card-body-custom">
      <!-- Search and Filter -->
      <div class="filter-bar">
        <div class="search-box">
          <i class="fas fa-search"></i>
          <input 
            type="text" 
            v-model="searchInput" 
            @input="debouncedSearch"
            placeholder="Search name, email, or company..."
          />
        </div>
        <div class="filter-group">
          <select v-model="filterValue" @change="onFilterChange">
            <option value="">All Status</option>
            <option value="active">Active</option>
            <option value="inactive">Inactive</option>
          </select>
        </div>
      </div>

      <div class="table-responsive">
        <table class="table-custom">
          <thead>
            <tr>
              <th>ID</th>
              <th>Name</th>
              <th>Email</th>
              <th>Phone</th>
              <th>Company</th>
              <th>Status</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="supplier in supplierStore.suppliers" :key="supplier.id">
              <td>{{ supplier.id }}</td>
              <td>{{ supplier.name }}</td>
              <td>{{ supplier.email }}</td>
              <td>{{ supplier.phone }}</td>
              <td>{{ supplier.company || '-' }}</td>
              <td>
                <span :class="['status-badge', supplier.status]">
                  {{ supplier.status === 'active' ? 'Active' : 'Inactive' }}
                </span>
              </td>
              <td>
                <button class="btn-edit" @click="editSupplier(supplier)">Edit</button>
                <button class="btn-delete" @click="deleteSupplier(supplier.id)">Del</button>
              </td>
            </tr>
            <tr v-if="supplierStore.suppliers.length === 0">
              <td colspan="7" class="text-center">No suppliers found</td>
            </tr>
          </tbody>
        </table>
      </div>

      <!-- Pagination -->
      <div class="pagination" v-if="supplierStore.pagination && supplierStore.pagination.lastPage > 1">
        <button 
          class="page-btn" 
          @click="goToPage(supplierStore.pagination.currentPage - 1)"
          :disabled="supplierStore.pagination.currentPage === 1"
        >
          <i class="fas fa-chevron-left"></i>
        </button>
        <span class="page-info">
          Page {{ supplierStore.pagination.currentPage }} of {{ supplierStore.pagination.lastPage }}
        </span>
        <button 
          class="page-btn" 
          @click="goToPage(supplierStore.pagination.currentPage + 1)"
          :disabled="supplierStore.pagination.currentPage === supplierStore.pagination.lastPage"
        >
          <i class="fas fa-chevron-right"></i>
        </button>
      </div>
    </div>
    
    <SupplierModal 
      :show="showModal" 
      :supplier="selectedSupplier"
      @close="closeModal"
      @save="saveSupplier"
    />
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import { useSupplierStore } from '../stores/supplier';
import SupplierModal from './SupplierModal.vue';

const supplierStore = useSupplierStore();
const showModal = ref(false);
const selectedSupplier = ref(null);
const searchInput = ref('');
const filterValue = ref('');

let searchTimeout = null;

onMounted(() => {
  supplierStore.fetchSuppliers();
});

const debouncedSearch = () => {
  if (searchTimeout) clearTimeout(searchTimeout);
  searchTimeout = setTimeout(() => {
    supplierStore.setSearch(searchInput.value);
  }, 300);
};

const onFilterChange = () => {
  supplierStore.setFilter(filterValue.value);
};

const goToPage = (page) => {
  supplierStore.fetchSuppliers(page);
};

const showAddModal = () => {
  selectedSupplier.value = null;
  showModal.value = true;
};

const editSupplier = (supplier) => {
  selectedSupplier.value = { ...supplier };
  showModal.value = true;
};

const closeModal = () => {
  showModal.value = false;
  selectedSupplier.value = null;
};

const saveSupplier = async (supplierData) => {
  let result;
  if (selectedSupplier.value?.id) {
    result = await supplierStore.updateSupplier(selectedSupplier.value.id, supplierData);
  } else {
    result = await supplierStore.createSupplier(supplierData);
  }
  
  if (result.success) {
    closeModal();
  }
  return result;
};

const deleteSupplier = async (id) => {
  if (confirm('Hapus supplier ini?')) {
    await supplierStore.deleteSupplier(id);
  }
};
</script>

<style scoped>
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

.filter-bar {
  display: flex;
  gap: 1rem;
  margin-bottom: 1.5rem;
  flex-wrap: wrap;
}

.search-box {
  position: relative;
  flex: 1;
  min-width: 200px;
}

.search-box i {
  position: absolute;
  left: 12px;
  top: 50%;
  transform: translateY(-50%);
  color: #64748b;
}

.search-box input {
  width: 100%;
  padding: 0.75rem 1rem 0.75rem 2.5rem;
  background: rgba(15, 23, 42, 0.6);
  border: 1px solid rgba(59, 130, 246, 0.3);
  border-radius: 8px;
  color: #f8fafc;
  font-size: 0.95rem;
}

.search-box input:focus {
  outline: none;
  border-color: #3b82f6;
  box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.2);
}

.filter-group select {
  padding: 0.75rem 1rem;
  background: rgba(15, 23, 42, 0.6);
  border: 1px solid rgba(59, 130, 246, 0.3);
  border-radius: 8px;
  color: #f8fafc;
  font-size: 0.95rem;
  min-width: 150px;
}

.filter-group select:focus {
  outline: none;
  border-color: #3b82f6;
}

.table-responsive {
  border-radius: 12px;
  overflow: hidden;
  overflow-x: auto;
}

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

.status-badge {
  padding: 0.3rem 0.8rem;
  border-radius: 20px;
  font-size: 0.8rem;
  font-weight: 500;
}

.status-badge.active {
  background: rgba(16, 185, 129, 0.2);
  color: #34d399;
}

.status-badge.inactive {
  background: rgba(239, 68, 68, 0.2);
  color: #f87171;
}

.pagination {
  display: flex;
  justify-content: center;
  align-items: center;
  gap: 1rem;
  margin-top: 1.5rem;
  padding-top: 1rem;
  border-top: 1px solid rgba(59, 130, 246, 0.2);
}

.page-btn {
  background: rgba(59, 130, 246, 0.2);
  border: 1px solid rgba(59, 130, 246, 0.3);
  color: #93c5fd;
  padding: 0.5rem 1rem;
  border-radius: 8px;
  cursor: pointer;
  transition: all 0.3s ease;
}

.page-btn:hover:not(:disabled) {
  background: rgba(59, 130, 246, 0.4);
}

.page-btn:disabled {
  opacity: 0.5;
  cursor: not-allowed;
}

.page-info {
  color: #94a3b8;
  font-size: 0.9rem;
}

.text-center {
  text-align: center;
  color: #64748b;
  padding: 2rem !important;
}

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
  cursor: pointer;
}

.btn-add:hover {
  transform: translateY(-2px);
  box-shadow: 0 6px 20px rgba(59, 130, 246, 0.4);
}

.btn-edit {
  background: linear-gradient(135deg, #10b981, #059669);
  color: white;
  border: none;
  padding: 0.4rem 0.8rem;
  border-radius: 6px;
  font-size: 0.85rem;
  transition: all 0.3s ease;
  cursor: pointer;
  margin-right: 0.5rem;
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
  cursor: pointer;
}

.btn-delete:hover {
  transform: translateY(-2px);
  box-shadow: 0 4px 12px rgba(239, 68, 68, 0.4);
}

@media (max-width: 768px) {
  .filter-bar {
    flex-direction: column;
  }
  
  .table-custom {
    font-size: 0.85rem;
  }
  
  .table-custom thead th,
  .table-custom tbody td {
    padding: 0.7rem 0.5rem;
  }
}
</style>
