import { createStore } from 'vuex'
import axios from 'axios'

// Create a new store instance.
const productStore = createStore({
    state () {
        return {
            products: [],
            categories: []
        }
    },
    mutations: {
        setProducts(state, products) {
            state.products = products
        },
        setCategories(state, categories) {
            state.categories = categories
        },
    },
    actions: {
        async getProducts({ commit }) {
            try {
                const response = await axios.get(`/api/v1/products`)
                commit('setProducts', response.data)
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
        async createProduct({ dispatch }, product) {
            try {
                await axios.post(`/api/v1/products`, product)
                dispatch('getProducts')
            } catch (error) {
                throw error
            }
        }
    }
})

export default productStore
