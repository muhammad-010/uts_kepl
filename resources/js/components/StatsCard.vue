<template>
  <div class="stat-card">
    <div class="stat-icon">
      <i :class="icon"></i>
    </div>
    <div class="stat-value">{{ value }}</div>
    <div class="stat-label">{{ label }}</div>
  </div>
</template>

<script setup>
defineProps({
  icon: {
    type: String,
    required: true
  },
  value: {
    type: [String, Number],
    required: true
  },
  label: {
    type: String,
    required: true
  }
});
</script>

<style scoped>
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
</style>
