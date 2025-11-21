import { defineStore } from 'pinia';
import api from '../services/api';

export const useProductStore = defineStore('product', {
    state: () => ({
        products: [],
        pagination: null,
        loading: false,
    }),

    getters: {
        totalStock: (state) => {
            return state.products.reduce((sum, product) => sum + (Number(product.stock) || 0), 0);
        },
    },

    actions: {
        async fetchProducts(page = 1) {
            this.loading = true;
            try {
                const response = await api.get(`/products?page=${page}`);
                const data = response.data.data;
                this.products = data.data || [];
                this.pagination = {
                    total: data.total,
                    currentPage: data.current_page,
                    lastPage: data.last_page,
                };
            } catch (error) {
                console.error('Failed to fetch products:', error);
            } finally {
                this.loading = false;
            }
        },

        async createProduct(productData) {
            try {
                await api.post('/products', productData);
                await this.fetchProducts();
                return { success: true };
            } catch (error) {
                return {
                    success: false,
                    message: error.response?.data?.message || 'Failed to create product',
                    errors: error.response?.data?.errors
                };
            }
        },

        async updateProduct(id, productData) {
            try {
                await api.put(`/products/${id}`, productData);
                await this.fetchProducts();
                return { success: true };
            } catch (error) {
                return {
                    success: false,
                    message: error.response?.data?.message || 'Failed to update product',
                    errors: error.response?.data?.errors
                };
            }
        },

        async deleteProduct(id) {
            try {
                await api.delete(`/products/${id}`);
                await this.fetchProducts();
                return { success: true };
            } catch (error) {
                return {
                    success: false,
                    message: error.response?.data?.message || 'Failed to delete product'
                };
            }
        },
    },
});
