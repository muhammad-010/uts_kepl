import { defineStore } from 'pinia';
import api from '../services/api';

export const useAuthStore = defineStore('auth', {
    state: () => ({
        user: null,
        token: localStorage.getItem('token') || null,
    }),

    getters: {
        isAuthenticated: (state) => !!state.token,
    },

    actions: {
        async login(credentials) {
            try {
                const response = await api.post('/login', credentials);
                const { access_token, user } = response.data.data;

                this.token = access_token;
                this.user = user;
                localStorage.setItem('token', access_token);

                return { success: true };
            } catch (error) {
                return {
                    success: false,
                    message: error.response?.data?.message || 'Login failed. Please try again.'
                };
            }
        },

        async fetchProfile() {
            try {
                const response = await api.get('/profile');
                this.user = response.data.data;
            } catch (error) {
                console.error('Failed to fetch profile:', error);
            }
        },

        async logout() {
            try {
                await api.post('/logout');
            } catch (error) {
                console.error('Logout error:', error);
            } finally {
                this.token = null;
                this.user = null;
                localStorage.removeItem('token');
            }
        },
    },
});
