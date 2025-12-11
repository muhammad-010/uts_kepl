<template>
  <Modal 
    :show="show" 
    :title="supplier ? 'Edit Supplier' : 'Add Supplier'"
    icon="fas fa-truck"
    :save-text="loading ? 'Saving...' : 'Save'"
    @close="$emit('close')"
    @save="handleSubmit"
  >
    <div v-if="errorMessage" class="error-banner">
      <i class="fas fa-exclamation-circle"></i>
      {{ errorMessage }}
    </div>
    
    <form @submit.prevent="handleSubmit">
      <div class="form-row">
        <div class="form-group">
          <label for="name">Name <span class="required">*</span></label>
          <input 
            type="text" 
            id="name" 
            v-model="form.name" 
            :class="{ 'error': errors.name }"
            placeholder="Supplier name"
            maxlength="150"
          />
          <span class="error-text" v-if="errors.name">{{ errors.name[0] }}</span>
          <span class="hint">Min 3, max 150 characters</span>
        </div>

        <div class="form-group">
          <label for="email">Email <span class="required">*</span></label>
          <input 
            type="email" 
            id="email" 
            v-model="form.email" 
            :class="{ 'error': errors.email }"
            placeholder="supplier@example.com"
            maxlength="100"
          />
          <span class="error-text" v-if="errors.email">{{ errors.email[0] }}</span>
        </div>
      </div>

      <div class="form-row">
        <div class="form-group">
          <label for="phone">Phone <span class="required">*</span></label>
          <input 
            type="text" 
            id="phone" 
            v-model="form.phone" 
            :class="{ 'error': errors.phone }"
            placeholder="+62 xxx xxxx xxxx"
            maxlength="30"
          />
          <span class="error-text" v-if="errors.phone">{{ errors.phone[0] }}</span>
          <span class="hint">Min 8, max 30 characters</span>
        </div>

        <div class="form-group">
          <label for="company">Company</label>
          <input 
            type="text" 
            id="company" 
            v-model="form.company" 
            :class="{ 'error': errors.company }"
            placeholder="Company name (optional)"
            maxlength="150"
          />
          <span class="error-text" v-if="errors.company">{{ errors.company[0] }}</span>
        </div>
      </div>

      <div class="form-group">
        <label for="address">Address</label>
        <textarea 
          id="address" 
          v-model="form.address" 
          :class="{ 'error': errors.address }"
          placeholder="Full address (optional)"
          rows="3"
          maxlength="500"
        ></textarea>
        <span class="error-text" v-if="errors.address">{{ errors.address[0] }}</span>
        <span class="hint">Max 500 characters</span>
      </div>

      <div class="form-group">
        <label for="status">Status <span class="required">*</span></label>
        <select 
          id="status" 
          v-model="form.status" 
          :class="{ 'error': errors.status }"
        >
          <option value="active">Active</option>
          <option value="inactive">Inactive</option>
        </select>
        <span class="error-text" v-if="errors.status">{{ errors.status[0] }}</span>
      </div>
    </form>
  </Modal>
</template>

<script setup>
import { ref, watch, reactive } from 'vue';
import Modal from './Modal.vue';

const props = defineProps({
  show: Boolean,
  supplier: Object
});

const emit = defineEmits(['close', 'save']);

const form = reactive({
  name: '',
  email: '',
  phone: '',
  address: '',
  company: '',
  status: 'active',
});

const errors = ref({});
const errorMessage = ref('');
const loading = ref(false);

watch(() => props.show, (newVal) => {
  if (newVal) {
    errors.value = {};
    errorMessage.value = '';
    if (props.supplier) {
      form.name = props.supplier.name || '';
      form.email = props.supplier.email || '';
      form.phone = props.supplier.phone || '';
      form.address = props.supplier.address || '';
      form.company = props.supplier.company || '';
      form.status = props.supplier.status || 'active';
    } else {
      form.name = '';
      form.email = '';
      form.phone = '';
      form.address = '';
      form.company = '';
      form.status = 'active';
    }
  }
});

const validateForm = () => {
  const newErrors = {};
  
  if (!form.name || form.name.trim().length < 3) {
    newErrors.name = ['Name must be at least 3 characters'];
  }
  
  if (!form.email) {
    newErrors.email = ['Email is required'];
  } else if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(form.email)) {
    newErrors.email = ['Please enter a valid email'];
  }
  
  if (!form.phone || form.phone.trim().length < 8) {
    newErrors.phone = ['Phone must be at least 8 characters'];
  }
  
  if (!form.status) {
    newErrors.status = ['Status is required'];
  }
  
  errors.value = newErrors;
  return Object.keys(newErrors).length === 0;
};

const handleSubmit = async () => {
  if (!validateForm()) return;
  
  loading.value = true;
  errorMessage.value = '';
  
  const result = await emit('save', {
    name: form.name.trim(),
    email: form.email.trim().toLowerCase(),
    phone: form.phone.trim(),
    address: form.address?.trim() || null,
    company: form.company?.trim() || null,
    status: form.status,
  });
  
  loading.value = false;
  
  if (result && !result.success) {
    if (result.errors) {
      errors.value = result.errors;
    }
    errorMessage.value = result.message || 'An error occurred';
  }
};
</script>

<style scoped>
.form-row {
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 1rem;
}

@media (max-width: 600px) {
  .form-row {
    grid-template-columns: 1fr;
  }
}

.form-group {
  margin-bottom: 1.5rem;
}

.form-group label {
  display: block;
  color: #cbd5e1;
  margin-bottom: 0.5rem;
  font-weight: 500;
}

.required {
  color: #ef4444;
}

.form-group input[type="text"],
.form-group input[type="email"],
.form-group textarea,
.form-group select {
  width: 100%;
  padding: 0.75rem 1rem;
  background: rgba(15, 23, 42, 0.6);
  border: 1px solid rgba(59, 130, 246, 0.3);
  border-radius: 8px;
  color: #f8fafc;
  font-size: 1rem;
  transition: all 0.3s ease;
}

.form-group input:focus,
.form-group textarea:focus,
.form-group select:focus {
  outline: none;
  border-color: #3b82f6;
  box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.2);
}

.form-group input.error,
.form-group textarea.error,
.form-group select.error {
  border-color: #ef4444;
}

.error-text {
  display: block;
  color: #f87171;
  font-size: 0.85rem;
  margin-top: 0.3rem;
}

.hint {
  display: block;
  color: #64748b;
  font-size: 0.8rem;
  margin-top: 0.3rem;
}

.error-banner {
  background: rgba(239, 68, 68, 0.15);
  border: 1px solid rgba(239, 68, 68, 0.3);
  color: #f87171;
  padding: 0.75rem 1rem;
  border-radius: 8px;
  margin-bottom: 1rem;
  display: flex;
  align-items: center;
  gap: 0.5rem;
}
</style>
