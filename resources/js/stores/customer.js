import { defineStore } from 'pinia';
import api from '../services/api';

export const useCustomerStore = defineStore('customer', {
    state: () => ({
        customers: [],
        pagination: null,
        loading: false,
    }),

    actions: {
        async fetchCustomers(page = 1) {
            this.loading = true;
            try {
                const response = await api.get(`/customers?page=${page}`);
                const data = response.data.data;
                this.customers = data.data || [];
                this.pagination = {
                    total: data.total,
                    currentPage: data.current_page,
                    lastPage: data.last_page,
                };
            } catch (error) {
                console.error('Failed to fetch customers:', error);
            } finally {
                this.loading = false;
            }
        },

        async createCustomer(customerData) {
            try {
                await api.post('/customers', customerData);
                await this.fetchCustomers();
                return { success: true };
            } catch (error) {
                return {
                    success: false,
                    message: error.response?.data?.message || 'Failed to create customer',
                    errors: error.response?.data?.errors
                };
            }
        },

        async updateCustomer(id, customerData) {
            try {
                await api.put(`/customers/${id}`, customerData);
                await this.fetchCustomers();
                return { success: true };
            } catch (error) {
                return {
                    success: false,
                    message: error.response?.data?.message || 'Failed to update customer',
                    errors: error.response?.data?.errors
                };
            }
        },

        async deleteCustomer(id) {
            try {
                await api.delete(`/customers/${id}`);
                await this.fetchCustomers();
                return { success: true };
            } catch (error) {
                return {
                    success: false,
                    message: error.response?.data?.message || 'Failed to delete customer'
                };
            }
        },
    },
});
