import { defineStore } from 'pinia';
import api from '../services/api';

export const useSupplierStore = defineStore('supplier', {
    state: () => ({
        suppliers: [],
        pagination: null,
        loading: false,
        searchQuery: '',
        filterStatus: '', // '' = all, 'active', 'inactive'
    }),

    getters: {
        activeCount: (state) => {
            return state.suppliers.filter(s => s.status === 'active').length;
        },
        inactiveCount: (state) => {
            return state.suppliers.filter(s => s.status === 'inactive').length;
        },
    },

    actions: {
        async fetchSuppliers(page = 1) {
            this.loading = true;
            try {
                let url = `/suppliers?page=${page}`;

                if (this.searchQuery) {
                    url += `&q=${encodeURIComponent(this.searchQuery)}`;
                }

                if (this.filterStatus) {
                    url += `&status=${this.filterStatus}`;
                }

                const response = await api.get(url);
                const data = response.data.data;
                this.suppliers = data.data || [];
                this.pagination = {
                    total: data.total,
                    currentPage: data.current_page,
                    lastPage: data.last_page,
                    perPage: data.per_page,
                };
            } catch (error) {
                console.error('Failed to fetch suppliers:', error);
            } finally {
                this.loading = false;
            }
        },

        async createSupplier(supplierData) {
            try {
                await api.post('/suppliers', supplierData);
                await this.fetchSuppliers();
                return { success: true };
            } catch (error) {
                return {
                    success: false,
                    message: error.response?.data?.message || 'Failed to create supplier',
                    errors: error.response?.data?.errors
                };
            }
        },

        async updateSupplier(id, supplierData) {
            try {
                await api.put(`/suppliers/${id}`, supplierData);
                await this.fetchSuppliers();
                return { success: true };
            } catch (error) {
                return {
                    success: false,
                    message: error.response?.data?.message || 'Failed to update supplier',
                    errors: error.response?.data?.errors
                };
            }
        },

        async deleteSupplier(id) {
            try {
                await api.delete(`/suppliers/${id}`);
                await this.fetchSuppliers();
                return { success: true };
            } catch (error) {
                return {
                    success: false,
                    message: error.response?.data?.message || 'Failed to delete supplier'
                };
            }
        },

        setSearch(query) {
            this.searchQuery = query;
            this.fetchSuppliers(1);
        },

        setFilter(status) {
            this.filterStatus = status;
            this.fetchSuppliers(1);
        },

        clearFilters() {
            this.searchQuery = '';
            this.filterStatus = '';
            this.fetchSuppliers(1);
        },
    },
});
