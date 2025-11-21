<template>
  <div class="login-wrapper">
    <div class="login-card">
      <div class="logo-section">
        <div class="logo-icon">
          <i class="fas fa-box"></i>
        </div>
        <h1 class="login-title">Welcome Back</h1>
        <p class="login-subtitle">Sign in to UMKM Inventory System</p>
      </div>
      
      <div v-if="alert.show" :class="['alert-custom', alert.type, 'show']" role="alert">
        <i :class="alert.icon" style="margin-right: 0.5rem;"></i>
        {{ alert.message }}
      </div>
      
      <form @submit.prevent="handleLogin">
        <div class="form-group">
          <label class="form-label">Email Address</label>
          <div class="input-group-custom">
            <input 
              type="email" 
              class="form-control-custom" 
              v-model="credentials.email" 
              required 
              placeholder="Enter your email"
            >
            <i class="fas fa-envelope input-icon"></i>
          </div>
        </div>
        
        <div class="form-group">
          <label class="form-label">Password</label>
          <div class="input-group-custom">
            <input 
              type="password" 
              class="form-control-custom" 
              v-model="credentials.password" 
              required 
              placeholder="Enter your password"
            >
            <i class="fas fa-lock input-icon"></i>
          </div>
        </div>
        
        <button class="btn-login" type="submit" :disabled="loading">
          <i :class="loading ? 'fas fa-spinner fa-spin' : 'fas fa-sign-in-alt'" style="margin-right: 0.5rem;"></i>
          {{ loading ? 'Signing In...' : 'Sign In' }}
        </button>
      </form>
      
      <div class="footer-text">
        &copy; 2025 UMKM Inventory.<br>UTS_KEPL Muhammad Al Fayyadh_520499_PL5BB.
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue';
import { useRouter } from 'vue-router';
import { useAuthStore } from '../stores/auth';

const router = useRouter();
const authStore = useAuthStore();

const credentials = ref({
  email: 'admin@umkm.test',
  password: 'password123'
});

const loading = ref(false);
const alert = ref({
  show: false,
  type: '',
  icon: '',
  message: ''
});

const handleLogin = async () => {
  loading.value = true;
  alert.value.show = false;
  
  const result = await authStore.login(credentials.value);
  
  if (result.success) {
    alert.value = {
      show: true,
      type: 'alert-success',
      icon: 'fas fa-check-circle',
      message: 'Login successful! Redirecting...'
    };
    
    setTimeout(() => {
      router.push('/dashboard');
    }, 1000);
  } else {
    alert.value = {
      show: true,
      type: 'alert-danger',
      icon: 'fas fa-exclamation-circle',
      message: result.message
    };
    loading.value = false;
  }
};
</script>

<style scoped>
* {
  margin: 0;
  padding: 0;
  box-sizing: border-box;
}

.login-wrapper {
  min-height: 100vh;
  background: linear-gradient(135deg, #0a1628 0%, #1a2332 25%, #0d1b2a 50%, #1b263b 75%, #0f1e2e 100%);
  font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
  position: relative;
  overflow-x: hidden;
  display: flex;
  align-items: center;
  justify-content: center;
  padding: 2rem 1rem;
}

.login-wrapper::before {
  content: '';
  position: absolute;
  width: 500px;
  height: 500px;
  background: radial-gradient(circle, rgba(59, 130, 246, 0.15) 0%, transparent 70%);
  top: -150px;
  right: -150px;
  border-radius: 50%;
  animation: float 6s ease-in-out infinite;
}

.login-wrapper::after {
  content: '';
  position: absolute;
  width: 400px;
  height: 400px;
  background: radial-gradient(circle, rgba(37, 99, 235, 0.1) 0%, transparent 70%);
  bottom: -100px;
  left: -100px;
  border-radius: 50%;
  animation: float 8s ease-in-out infinite reverse;
}

@keyframes float {
  0%, 100% { transform: translateY(0px); }
  50% { transform: translateY(-20px); }
}

.login-card {
  background: rgba(15, 23, 42, 0.7);
  backdrop-filter: blur(20px);
  border: 1px solid rgba(59, 130, 246, 0.2);
  border-radius: 24px;
  padding: 3rem;
  box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5),
              0 0 50px rgba(59, 130, 246, 0.1),
              inset 0 1px 1px rgba(255, 255, 255, 0.05);
  max-width: 450px;
  width: 100%;
  animation: slideUp 0.6s ease-out;
  position: relative;
  z-index: 1;
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

.login-card::before {
  content: '';
  position: absolute;
  top: 0;
  left: 0;
  right: 0;
  height: 4px;
  background: linear-gradient(90deg, #3b82f6, #2563eb, #1d4ed8);
  border-radius: 24px 24px 0 0;
}

.logo-section {
  text-align: center;
  margin-bottom: 2.5rem;
}

.logo-icon {
  width: 70px;
  height: 70px;
  background: linear-gradient(135deg, #3b82f6, #2563eb);
  border-radius: 20px;
  display: inline-flex;
  align-items: center;
  justify-content: center;
  margin-bottom: 1.5rem;
  box-shadow: 0 10px 30px rgba(59, 130, 246, 0.3);
  animation: pulse 2s ease-in-out infinite;
}

@keyframes pulse {
  0%, 100% { transform: scale(1); }
  50% { transform: scale(1.05); }
}

.logo-icon i {
  font-size: 2rem;
  color: white;
}

.login-title {
  color: #f8fafc;
  font-size: 2rem;
  font-weight: 700;
  margin-bottom: 0.5rem;
  letter-spacing: -0.5px;
}

.login-subtitle {
  color: #94a3b8;
  font-size: 0.95rem;
}

.form-group {
  margin-bottom: 1.5rem;
  position: relative;
}

.form-label {
  color: #cbd5e1;
  font-size: 0.9rem;
  font-weight: 500;
  margin-bottom: 0.5rem;
  display: block;
}

.input-group-custom {
  position: relative;
}

.input-icon {
  position: absolute;
  left: 1rem;
  top: 50%;
  transform: translateY(-50%);
  color: #64748b;
  font-size: 1.1rem;
  z-index: 2;
  transition: color 0.3s ease;
}

.form-control-custom {
  width: 100%;
  padding: 0.9rem 1rem 0.9rem 3rem;
  background: rgba(15, 23, 42, 0.6);
  border: 1px solid rgba(59, 130, 246, 0.2);
  border-radius: 12px;
  color: #f8fafc;
  font-size: 0.95rem;
  transition: all 0.3s ease;
}

.form-control-custom:focus {
  outline: none;
  border-color: #3b82f6;
  background: rgba(15, 23, 42, 0.8);
  box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.1);
}

.form-control-custom:focus ~ .input-icon {
  color: #3b82f6;
}

.form-control-custom::placeholder {
  color: #475569;
}

.btn-login {
  width: 100%;
  padding: 1rem;
  background: linear-gradient(135deg, #3b82f6, #2563eb);
  border: none;
  border-radius: 12px;
  color: white;
  font-size: 1rem;
  font-weight: 600;
  cursor: pointer;
  transition: all 0.3s ease;
  box-shadow: 0 4px 15px rgba(59, 130, 246, 0.3);
  position: relative;
  overflow: hidden;
}

.btn-login::before {
  content: '';
  position: absolute;
  top: 0;
  left: -100%;
  width: 100%;
  height: 100%;
  background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
  transition: left 0.5s ease;
}

.btn-login:hover:not(:disabled) {
  transform: translateY(-2px);
  box-shadow: 0 8px 25px rgba(59, 130, 246, 0.4);
}

.btn-login:hover:not(:disabled)::before {
  left: 100%;
}

.btn-login:active {
  transform: translateY(0);
}

.btn-login:disabled {
  opacity: 0.7;
  cursor: not-allowed;
}

.alert-custom {
  padding: 1rem;
  border-radius: 12px;
  margin-bottom: 1.5rem;
  border: none;
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

.alert-danger {
  background: rgba(239, 68, 68, 0.15);
  color: #fca5a5;
  border-left: 4px solid #ef4444;
}

.alert-success {
  background: rgba(34, 197, 94, 0.15);
  color: #86efac;
  border-left: 4px solid #22c55e;
}

.footer-text {
  text-align: center;
  margin-top: 2rem;
  color: #64748b;
  font-size: 0.85rem;
}

@media (max-width: 576px) {
  .login-card {
    padding: 2rem 1.5rem;
  }
  
  .login-title {
    font-size: 1.6rem;
  }
}
</style>
