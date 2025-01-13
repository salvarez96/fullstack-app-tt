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
        },
        resetFilters(state) {
            state.filters = {}
        }
    },
    actions: {
        async getProducts({ commit, state }, newFilters) {
            try {
                if (!Object.keys(newFilters).length) {
                    commit('resetFilters')
                } else {
                    const normalizedFilters = normalizeFilters(newFilters, (filters) => {
                        typeof filters['category-id'] !== 'number' ? delete filters['category-id'] : filters['category-id'];
                    })

                    commit('setFilters', normalizedFilters)
                }

                const response = await axios.get(`/api/v1/products`, { params: state.filters })
                commit('setProducts', response.data)
                return Object.keys(state.filters).length ? true : false
            } catch (error) {
                throw error
            }
        },
        async getCategories({ commit }) {
            try {
                const response = await axios.get(`/api/v1/categories`)
                commit('setCategories', response.data)
            } catch (error) {
                throw error
            }
        },
        async createProduct({ dispatch, state }, product) {
            try {
                await axios.post(`/api/v1/products`, product)
                dispatch('getProducts', state.filters)
            } catch (error) {
                throw error
            }
        },
    }
})

export default productStore
