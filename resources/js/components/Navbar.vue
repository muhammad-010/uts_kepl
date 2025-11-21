<template>
  <nav class="navbar-custom">
    <div class="container-fluid px-4 d-flex align-items-center justify-content-between">
      <a class="navbar-brand" href="#">
        <i class="fas fa-box"></i>
        UMKM Inventory
      </a>
      <button @click="handleLogout" class="btn-logout">
        <i class="fas fa-sign-out-alt"></i> Logout
      </button>
    </div>
  </nav>
</template>

<script setup>
import { useRouter } from 'vue-router';
import { useAuthStore } from '../stores/auth';

const router = useRouter();
const authStore = useAuthStore();

const handleLogout = async () => {
  await authStore.logout();
  router.push('/');
};
</script>

<style scoped>
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

.container-fluid {
  max-width: 100%;
  padding-left: 1rem;
  padding-right: 1rem;
}

.d-flex {
  display: flex;
}

.align-items-center {
  align-items: center;
}

.justify-content-between {
  justify-content: space-between;
}

.px-4 {
  padding-left: 1.5rem;
  padding-right: 1.5rem;
}

.navbar-brand {
  color: #f8fafc !important;
  font-weight: 700;
  font-size: 1.4rem;
  display: flex;
  align-items: center;
  gap: 0.5rem;
  text-decoration: none;
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
  cursor: pointer;
}

.btn-logout:hover {
  transform: translateY(-2px);
  box-shadow: 0 6px 20px rgba(239, 68, 68, 0.4);
}
</style>
