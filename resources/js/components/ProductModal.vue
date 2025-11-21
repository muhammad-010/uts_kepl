<template>
  <Modal 
    :show="show" 
    title="Product Form"
    icon="fas fa-box-edit"
    save-text="Save Product"
    @close="handleClose"
    @save="handleSave"
  >
    <div v-if="error" class="alert-error">
      <i class="fas fa-exclamation-circle"></i>
      {{ error }}
    </div>
    
    <div class="mb-3">
      <label class="form-label">Name</label>
      <input 
        class="form-control" 
        v-model="formData.name" 
        placeholder="Enter product name"
      >
    </div>
    <div class="mb-3">
      <label class="form-label">SKU</label>
      <input 
        class="form-control" 
        v-model="formData.sku" 
        placeholder="Enter SKU code"
      >
    </div>
    <div class="mb-3">
      <label class="form-label">Price</label>
      <input 
        class="form-control" 
        type="number"
        step="0.01"
        v-model="formData.price" 
        placeholder="Enter price"
      >
    </div>
    <div class="mb-3">
      <label class="form-label">Stock</label>
      <input 
        class="form-control" 
        type="number"
        v-model="formData.stock" 
        placeholder="Enter stock quantity"
      >
    </div>
  </Modal>
</template>

<script setup>
import { ref, watch } from 'vue';
import Modal from './Modal.vue';

const props = defineProps({
  show: {
    type: Boolean,
    required: true
  },
  product: {
    type: Object,
    default: null
  }
});

const emit = defineEmits(['close', 'save']);

const formData = ref({
  name: '',
  sku: '',
  price: '',
  stock: ''
});

const error = ref('');

watch(() => props.product, (newProduct) => {
  error.value = ''; // Clear error when modal opens
  if (newProduct) {
    formData.value = {
      name: newProduct.name || '',
      sku: newProduct.sku || '',
      price: newProduct.price || '',
      stock: newProduct.stock || ''
    };
  } else {
    formData.value = {
      name: '',
      sku: '',
      price: '',
      stock: ''
    };
  }
}, { immediate: true });

const handleSave = async () => {
  error.value = ''; // Clear previous errors
  
  // Client-side validation
  if (!formData.value.name.trim()) {
    error.value = 'Name is required';
    return;
  }
  if (!formData.value.sku.trim()) {
    error.value = 'SKU is required';
    return;
  }
  if (!formData.value.price || formData.value.price <= 0) {
    error.value = 'Price must be greater than 0';
    return;
  }
  if (!formData.value.stock || formData.value.stock < 0) {
    error.value = 'Stock must be 0 or greater';
    return;
  }
  
  const result = await emit('save', formData.value);
};

const handleClose = () => {
  error.value = ''; // Clear error when closing
  emit('close');
};
</script>

<style scoped>
.mb-3 {
  margin-bottom: 1rem;
}

.form-label {
  color: #cbd5e1;
  font-weight: 500;
  margin-bottom: 0.5rem;
  font-size: 0.9rem;
  display: block;
}

.form-control {
  background: rgba(15, 23, 42, 0.6);
  border: 1px solid rgba(59, 130, 246, 0.3);
  border-radius: 8px;
  color: #f8fafc;
  padding: 0.7rem;
  transition: all 0.3s ease;
  width: 100%;
}

.form-control:focus {
  background: rgba(15, 23, 42, 0.8);
  border-color: #3b82f6;
  box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
  outline: none;
  color: #f8fafc;
}

.form-control::placeholder {
  color: #64748b;
}

.alert-error {
  background: rgba(239, 68, 68, 0.15);
  color: #fca5a5;
  border-left: 4px solid #ef4444;
  padding: 0.75rem 1rem;
  border-radius: 8px;
  margin-bottom: 1rem;
  display: flex;
  align-items: center;
  gap: 0.5rem;
  font-size: 0.9rem;
  animation: slideDown 0.3s ease-out;
}

@keyframes slideDown {
  from {
    opacity: 0;
    transform: translateY(-10px);
  }
  to {
    opacity: 1;
    transform: translateY(0);
  }
}
</style>
