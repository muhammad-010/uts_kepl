<template>
  <div class="dashboard-wrapper">
    <Navbar />
    
    <div class="container-custom">
      <!-- Stats Cards -->
      <div class="stats-row">
        <StatsCard 
          icon="fas fa-users"
          :value="customerStore.pagination?.total || 0"
          label="Total Customers"
        />
        <StatsCard 
          icon="fas fa-box-open"
          :value="productStore.pagination?.total || 0"
          label="Total Products"
        />
        <StatsCard 
          icon="fas fa-warehouse"
          :value="productStore.totalStock"
          label="Total Stock"
        />
        <StatsCard 
          icon="fas fa-tags"
          :value="categoryStore.pagination?.total || 0"
          label="Total Categories"
        />
        <StatsCard 
          icon="fas fa-truck"
          :value="supplierStore.pagination?.total || 0"
          label="Total Suppliers"
        />
      </div>

      <!-- Customers Table -->
      <CustomerList />

      <!-- Products Table -->
      <ProductList />

      <!-- Categories Table -->
      <CategoryList />

      <!-- Suppliers Table -->
      <SupplierList />
    </div>
  </div>
</template>

<script setup>
import { onMounted } from 'vue';
import { useAuthStore } from '../stores/auth';
import { useCustomerStore } from '../stores/customer';
import { useProductStore } from '../stores/product';
import { useCategoryStore } from '../stores/category';
import { useSupplierStore } from '../stores/supplier';
import Navbar from '../components/Navbar.vue';
import StatsCard from '../components/StatsCard.vue';
import CustomerList from '../components/CustomerList.vue';
import ProductList from '../components/ProductList.vue';
import CategoryList from '../components/CategoryList.vue';
import SupplierList from '../components/SupplierList.vue';

const authStore = useAuthStore();
const customerStore = useCustomerStore();
const productStore = useProductStore();
const categoryStore = useCategoryStore();
const supplierStore = useSupplierStore();

onMounted(async () => {
  // Verify authentication
  await authStore.fetchProfile();
  
  // Load data
  await Promise.all([
    customerStore.fetchCustomers(),
    productStore.fetchProducts(),
    categoryStore.fetchCategories(),
    supplierStore.fetchSuppliers(),
  ]);
});
</script>

<style scoped>
.dashboard-wrapper {
  min-height: 100vh;
  background: linear-gradient(135deg, #0a1628 0%, #1a2332 25%, #0d1b2a 50%, #1b263b 75%, #0f1e2e 100%);
  font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
  position: relative;
  overflow-x: hidden;
}

.dashboard-wrapper::before {
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

.container-custom {
  position: relative;
  z-index: 1;
  padding: 2rem 1rem;
  max-width: 1400px;
  margin: 0 auto;
}

.stats-row {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
  gap: 1.5rem;
  margin-bottom: 2rem;
}

@media (max-width: 768px) {
  .stats-row {
    grid-template-columns: 1fr;
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
</style>
