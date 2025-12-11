<template>
  <div class="card-custom">
    <div class="card-header-custom">
      <strong><i class="fas fa-tags"></i> Categories</strong>
      <button class="btn-add" @click="showAddModal">
        <i class="fas fa-plus"></i> Add Category
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
            placeholder="Search name or code..."
          />
        </div>
        <div class="filter-group">
          <select v-model="filterValue" @change="onFilterChange">
            <option :value="null">All Status</option>
            <option :value="true">Active</option>
            <option :value="false">Inactive</option>
          </select>
        </div>
      </div>

      <div class="table-responsive">
        <table class="table-custom">
          <thead>
            <tr>
              <th>ID</th>
              <th>Name</th>
              <th>Code</th>
              <th>Status</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="category in categoryStore.categories" :key="category.id">
              <td>{{ category.id }}</td>
              <td>{{ category.name }}</td>
              <td><code>{{ category.code }}</code></td>
              <td>
                <span :class="['status-badge', category.is_active ? 'active' : 'inactive']">
                  {{ category.is_active ? 'Active' : 'Inactive' }}
                </span>
              </td>
              <td>
                <button class="btn-edit" @click="editCategory(category)">Edit</button>
                <button class="btn-delete" @click="deleteCategory(category.id)">Del</button>
              </td>
            </tr>
            <tr v-if="categoryStore.categories.length === 0">
              <td colspan="5" class="text-center">No categories found</td>
            </tr>
          </tbody>
        </table>
      </div>

      <!-- Pagination -->
      <div class="pagination" v-if="categoryStore.pagination && categoryStore.pagination.lastPage > 1">
        <button 
          class="page-btn" 
          @click="goToPage(categoryStore.pagination.currentPage - 1)"
          :disabled="categoryStore.pagination.currentPage === 1"
        >
          <i class="fas fa-chevron-left"></i>
        </button>
        <span class="page-info">
          Page {{ categoryStore.pagination.currentPage }} of {{ categoryStore.pagination.lastPage }}
        </span>
        <button 
          class="page-btn" 
          @click="goToPage(categoryStore.pagination.currentPage + 1)"
          :disabled="categoryStore.pagination.currentPage === categoryStore.pagination.lastPage"
        >
          <i class="fas fa-chevron-right"></i>
        </button>
      </div>
    </div>
    
    <CategoryModal 
      :show="showModal" 
      :category="selectedCategory"
      @close="closeModal"
      @save="saveCategory"
    />
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import { useCategoryStore } from '../stores/category';
import CategoryModal from './CategoryModal.vue';

const categoryStore = useCategoryStore();
const showModal = ref(false);
const selectedCategory = ref(null);
const searchInput = ref('');
const filterValue = ref(null);

let searchTimeout = null;

onMounted(() => {
  categoryStore.fetchCategories();
});

const debouncedSearch = () => {
  if (searchTimeout) clearTimeout(searchTimeout);
  searchTimeout = setTimeout(() => {
    categoryStore.setSearch(searchInput.value);
  }, 300);
};

const onFilterChange = () => {
  categoryStore.setFilter(filterValue.value);
};

const goToPage = (page) => {
  categoryStore.fetchCategories(page);
};

const showAddModal = () => {
  selectedCategory.value = null;
  showModal.value = true;
};

const editCategory = (category) => {
  selectedCategory.value = { ...category };
  showModal.value = true;
};

const closeModal = () => {
  showModal.value = false;
  selectedCategory.value = null;
};

const saveCategory = async (categoryData) => {
  let result;
  if (selectedCategory.value?.id) {
    result = await categoryStore.updateCategory(selectedCategory.value.id, categoryData);
  } else {
    result = await categoryStore.createCategory(categoryData);
  }
  
  if (result.success) {
    closeModal();
  }
  return result;
};

const deleteCategory = async (id) => {
  if (confirm('Hapus kategori ini?')) {
    await categoryStore.deleteCategory(id);
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

.table-custom code {
  background: rgba(59, 130, 246, 0.2);
  padding: 0.2rem 0.5rem;
  border-radius: 4px;
  font-family: monospace;
  color: #93c5fd;
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
