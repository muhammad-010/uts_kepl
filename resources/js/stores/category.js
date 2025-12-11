import { defineStore } from 'pinia';
import api from '../services/api';

export const useCategoryStore = defineStore('category', {
    state: () => ({
        categories: [],
        pagination: null,
        loading: false,
        searchQuery: '',
        filterActive: null, // null = all, true = active, false = inactive
    }),

    getters: {
        activeCount: (state) => {
            return state.categories.filter(c => c.is_active).length;
        },
        inactiveCount: (state) => {
            return state.categories.filter(c => !c.is_active).length;
        },
    },

    actions: {
        async fetchCategories(page = 1) {
            this.loading = true;
            try {
                let url = `/categories?page=${page}`;

                if (this.searchQuery) {
                    url += `&q=${encodeURIComponent(this.searchQuery)}`;
                }

                if (this.filterActive !== null) {
                    url += `&is_active=${this.filterActive}`;
                }

                const response = await api.get(url);
                const data = response.data.data;
                this.categories = data.data || [];
                this.pagination = {
                    total: data.total,
                    currentPage: data.current_page,
                    lastPage: data.last_page,
                    perPage: data.per_page,
                };
            } catch (error) {
                console.error('Failed to fetch categories:', error);
            } finally {
                this.loading = false;
            }
        },

        async createCategory(categoryData) {
            try {
                await api.post('/categories', categoryData);
                await this.fetchCategories();
                return { success: true };
            } catch (error) {
                return {
                    success: false,
                    message: error.response?.data?.message || 'Failed to create category',
                    errors: error.response?.data?.errors
                };
            }
        },

        async updateCategory(id, categoryData) {
            try {
                await api.put(`/categories/${id}`, categoryData);
                await this.fetchCategories();
                return { success: true };
            } catch (error) {
                return {
                    success: false,
                    message: error.response?.data?.message || 'Failed to update category',
                    errors: error.response?.data?.errors
                };
            }
        },

        async deleteCategory(id) {
            try {
                await api.delete(`/categories/${id}`);
                await this.fetchCategories();
                return { success: true };
            } catch (error) {
                return {
                    success: false,
                    message: error.response?.data?.message || 'Failed to delete category'
                };
            }
        },

        setSearch(query) {
            this.searchQuery = query;
            this.fetchCategories(1);
        },

        setFilter(isActive) {
            this.filterActive = isActive;
            this.fetchCategories(1);
        },

        clearFilters() {
            this.searchQuery = '';
            this.filterActive = null;
            this.fetchCategories(1);
        },
    },
});
