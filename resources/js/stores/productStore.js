import { createStore } from 'vuex'
import axios from 'axios'
import normalizeFilters from '@helpers/normalizeFilters'

// Create a new store instance.
const productStore = createStore({
    state () {
        return {
            products: [],
            categories: [],
            filters: {}
        }
    },
    mutations: {
        setProducts(state, products) {
            state.products = products
        },
        setCategories(state, categories) {
            state.categories = categories
        },
        setFilters(state, filters) {
            state.filters = {...state.filters, ...filters}
            console.log('state.filters', state.filters);
        },
        resetFilters(state) {
            state.filters = {}
        }
    },
    actions: {
        // async getProducts({ commit }, page) {
        //     try {
        //         const response = await axios.get(`/api/v1/products${page ? '?page=' + page : ''}`)
        //         commit('setProducts', response.data)
        //     } catch (error) {
        //         throw error
        //     }
        // },
        async getCategories({ commit }) {
            try {
                const response = await axios.get(`/api/v1/categories`)
                commit('setCategories', response.data)
            } catch (error) {
                throw error
            }
        },
        async createProduct({ dispatch }, product) {
            try {
                await axios.post(`/api/v1/products`, product)
                dispatch('getProducts')
            } catch (error) {
                throw error
            }
        },
        async getProducts({ commit, state }, filters) {
            try {
                let normalizedFilters = {}

                if (!Object.keys(filters).length) {
                    commit('resetFilters')
                } else {
                    normalizedFilters = normalizeFilters(filters, (filters) => {
                        typeof filters['category-id'] !== 'number' ? filters['category-id'] = '' : filters['category-id'];
                    })

                    commit('setFilters', normalizedFilters)
                    console.log('normalizedFilters', normalizedFilters);
                }

                console.log('filters', filters);
                const response = await axios.get(`/api/v1/products`, { params: state.filters })
                commit('setProducts', response.data)
                console.log(response.data);
                return Object.keys(normalizedFilters).length ? true : false
            } catch (error) {
                throw error
            }
        },
    }
})

export default productStore
