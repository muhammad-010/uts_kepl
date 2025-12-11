<template>
  <Modal 
    :show="show" 
    :title="category ? 'Edit Category' : 'Add Category'"
    icon="fas fa-tags"
    :save-text="loading ? 'Saving...' : 'Save'"
    @close="$emit('close')"
    @save="handleSubmit"
  >
    <div v-if="errorMessage" class="error-banner">
      <i class="fas fa-exclamation-circle"></i>
      {{ errorMessage }}
    </div>
    
    <form @submit.prevent="handleSubmit">
      <div class="form-group">
        <label for="name">Name <span class="required">*</span></label>
        <input 
          type="text" 
          id="name" 
          v-model="form.name" 
          :class="{ 'error': errors.name }"
          placeholder="Category name"
          maxlength="100"
        />
        <span class="error-text" v-if="errors.name">{{ errors.name[0] }}</span>
        <span class="hint">Min 2, max 100 characters</span>
      </div>

      <div class="form-group">
        <label for="code">Code <span class="required">*</span></label>
        <input 
          type="text" 
          id="code" 
          v-model="form.code" 
          :class="{ 'error': errors.code }"
          placeholder="e.g. ELEC-001"
          maxlength="20"
        />
        <span class="error-text" v-if="errors.code">{{ errors.code[0] }}</span>
        <span class="hint">Alphanumeric, underscore, dash only. Min 2, max 20 characters</span>
      </div>

      <div class="form-group">
        <label for="description">Description</label>
        <textarea 
          id="description" 
          v-model="form.description" 
          :class="{ 'error': errors.description }"
          placeholder="Optional description"
          rows="3"
          maxlength="500"
        ></textarea>
        <span class="error-text" v-if="errors.description">{{ errors.description[0] }}</span>
        <span class="hint">Max 500 characters</span>
      </div>

      <div class="form-group">
        <label class="checkbox-label">
          <input type="checkbox" v-model="form.is_active" />
          <span class="checkmark"></span>
          Active
        </label>
      </div>
    </form>
  </Modal>
</template>

<script setup>
import { ref, watch, reactive } from 'vue';
import Modal from './Modal.vue';

const props = defineProps({
  show: Boolean,
  category: Object
});

const emit = defineEmits(['close', 'save']);

const form = reactive({
  name: '',
  code: '',
  description: '',
  is_active: true,
});

const errors = ref({});
const errorMessage = ref('');
const loading = ref(false);

watch(() => props.show, (newVal) => {
  if (newVal) {
    errors.value = {};
    errorMessage.value = '';
    if (props.category) {
      form.name = props.category.name || '';
      form.code = props.category.code || '';
      form.description = props.category.description || '';
      form.is_active = props.category.is_active ?? true;
    } else {
      form.name = '';
      form.code = '';
      form.description = '';
      form.is_active = true;
    }
  }
});

const validateForm = () => {
  const newErrors = {};
  
  if (!form.name || form.name.trim().length < 2) {
    newErrors.name = ['Name must be at least 2 characters'];
  }
  
  if (!form.code || form.code.trim().length < 2) {
    newErrors.code = ['Code must be at least 2 characters'];
  } else if (!/^[A-Za-z0-9_-]+$/.test(form.code)) {
    newErrors.code = ['Code can only contain letters, numbers, underscore, and dash'];
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
    code: form.code.trim().toUpperCase(),
    description: form.description?.trim() || null,
    is_active: form.is_active,
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
.form-group textarea {
  width: 100%;
  padding: 0.75rem 1rem;
  background: rgba(15, 23, 42, 0.6);
  border: 1px solid rgba(59, 130, 246, 0.3);
  border-radius: 8px;
  color: #f8fafc;
  font-size: 1rem;
  transition: all 0.3s ease;
}

.form-group input[type="text"]:focus,
.form-group textarea:focus {
  outline: none;
  border-color: #3b82f6;
  box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.2);
}

.form-group input.error,
.form-group textarea.error {
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

.checkbox-label {
  display: flex;
  align-items: center;
  gap: 0.75rem;
  cursor: pointer;
  color: #cbd5e1;
}

.checkbox-label input[type="checkbox"] {
  width: 18px;
  height: 18px;
  accent-color: #3b82f6;
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
