<template>
  <Teleport to="body">
    <div class="modal-backdrop" v-if="show" @click.self="closeModal">
      <div class="modal-custom">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">
              <i :class="icon"></i> {{ title }}
            </h5>
            <button class="btn-close" @click="closeModal"></button>
          </div>
          <div class="modal-body">
            <slot></slot>
          </div>
          <div class="modal-footer">
            <button class="btn btn-secondary" @click="closeModal">Cancel</button>
            <button class="btn btn-primary" @click="$emit('save')">
              <i class="fas fa-save"></i> {{ saveText }}
            </button>
          </div>
        </div>
      </div>
    </div>
  </Teleport>
</template>

<script setup>
defineProps({
  show: {
    type: Boolean,
    required: true
  },
  title: {
    type: String,
    required: true
  },
  icon: {
    type: String,
    default: 'fas fa-edit'
  },
  saveText: {
    type: String,
    default: 'Save'
  }
});

const emit = defineEmits(['close', 'save']);

const closeModal = () => {
  emit('close');
};
</script>

<style scoped>
.modal-backdrop {
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background: rgba(0, 0, 0, 0.7);
  display: flex;
  align-items: center;
  justify-content: center;
  z-index: 2000;
  animation: fadeIn 0.3s ease-out;
}

@keyframes fadeIn {
  from { opacity: 0; }
  to { opacity: 1; }
}

.modal-custom {
  width: 90%;
  max-width: 500px;
  animation: slideUp 0.3s ease-out;
}

@keyframes slideUp {
  from {
    opacity: 0;
    transform: translateY(30px);
  }
  to {
    opacity: 1;
    transform: translateY(0);
  }
}

.modal-content {
  background: rgba(15, 23, 42, 0.95);
  backdrop-filter: blur(20px);
  border: 1px solid rgba(59, 130, 246, 0.3);
  border-radius: 16px;
  box-shadow: 0 25px 50px rgba(0, 0, 0, 0.5);
}

.modal-header {
  border-bottom: 1px solid rgba(59, 130, 246, 0.2);
  padding: 1.5rem;
  background: rgba(59, 130, 246, 0.1);
  border-radius: 16px 16px 0 0;
  display: flex;
  align-items: center;
  justify-content: space-between;
}

.modal-title {
  color: #f8fafc;
  font-weight: 600;
  font-size: 1.3rem;
  margin: 0;
  display: flex;
  align-items: center;
  gap: 0.5rem;
}

.modal-title i {
  color: #3b82f6;
}

.btn-close {
  background: transparent;
  border: none;
  color: #cbd5e1;
  font-size: 1.5rem;
  cursor: pointer;
  width: 30px;
  height: 30px;
  display: flex;
  align-items: center;
  justify-content: center;
  border-radius: 50%;
  transition: all 0.3s ease;
}

.btn-close::before {
  content: '×';
}

.btn-close:hover {
  background: rgba(255, 255, 255, 0.1);
  color: #f8fafc;
}

.modal-body {
  padding: 1.5rem;
}

.modal-footer {
  border-top: 1px solid rgba(59, 130, 246, 0.2);
  padding: 1.5rem;
  display: flex;
  justify-content: flex-end;
  gap: 1rem;
}

.btn {
  padding: 0.6rem 1.5rem;
  border-radius: 8px;
  font-weight: 500;
  border: none;
  cursor: pointer;
  transition: all 0.3s ease;
  display: flex;
  align-items: center;
  gap: 0.5rem;
}

.btn-secondary {
  background: rgba(71, 85, 105, 0.5);
  border: 1px solid rgba(71, 85, 105, 0.5);
  color: #cbd5e1;
}

.btn-secondary:hover {
  background: rgba(71, 85, 105, 0.7);
}

.btn-primary {
  background: linear-gradient(135deg, #3b82f6, #2563eb);
  color: white;
  box-shadow: 0 4px 12px rgba(59, 130, 246, 0.3);
}

.btn-primary:hover {
  transform: translateY(-2px);
  box-shadow: 0 6px 20px rgba(59, 130, 246, 0.4);
}
</style>
