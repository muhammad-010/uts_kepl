<template>
  <div class="card-custom">
    <div class="card-header-custom">
      <strong><i class="fas fa-users"></i> Customers</strong>
      <button class="btn-add" @click="showAddModal">
        <i class="fas fa-plus"></i> Add Customer
      </button>
    </div>
    <div class="card-body-custom">
      <div class="table-responsive">
        <table class="table-custom">
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
          <tbody>
            <tr v-for="customer in customerStore.customers" :key="customer.id">
              <td>{{ customer.id }}</td>
              <td>{{ customer.name }}</td>
              <td>{{ customer.email }}</td>
              <td>{{ customer.phone }}</td>
              <td>{{ customer.address || '' }}</td>
              <td>
                <button class="btn-edit" @click="editCustomer(customer)">Edit</button>
                <button class="btn-delete" @click="deleteCustomer(customer.id)">Del</button>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
    
    <CustomerModal 
      :show="showModal" 
      :customer="selectedCustomer"
      @close="closeModal"
      @save="saveCustomer"
    />
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import { useCustomerStore } from '../stores/customer';
import CustomerModal from './CustomerModal.vue';

const customerStore = useCustomerStore();
const showModal = ref(false);
const selectedCustomer = ref(null);

onMounted(() => {
  customerStore.fetchCustomers();
});

const showAddModal = () => {
  selectedCustomer.value = null;
  showModal.value = true;
};

const editCustomer = (customer) => {
  selectedCustomer.value = { ...customer };
  showModal.value = true;
};

const closeModal = () => {
  showModal.value = false;
  selectedCustomer.value = null;
};

const saveCustomer = async (customerData) => {
  let result;
  if (selectedCustomer.value?.id) {
    result = await customerStore.updateCustomer(selectedCustomer.value.id, customerData);
  } else {
    result = await customerStore.createCustomer(customerData);
  }
  
  // Only close modal if successful
  if (result.success) {
    closeModal();
  }
  // Error will be handled in the modal component
};

const deleteCustomer = async (id) => {
  if (confirm('Hapus customer ini?')) {
    await customerStore.deleteCustomer(id);
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
  .table-custom {
    font-size: 0.85rem;
  }
  
  .table-custom thead th,
  .table-custom tbody td {
    padding: 0.7rem 0.5rem;
  }
}
</style>
