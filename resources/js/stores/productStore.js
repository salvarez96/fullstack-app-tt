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
        // addNewProduct(state, product) {
        //     state.products.data.push(product)
        // }
    },
    actions: {
        getProducts({ commit }) {
            axios.get(`/api/v1/products`)
                .then(response => {
                    commit('setProducts', response.data)
                })
                .catch(error => {
                    console.error(error)
                })
        },
        getCategories({ commit }) {
            axios.get(`/api/v1/categories`)
                .then(response => {
                    commit('setCategories', response.data)
                })
                .catch(error => {
                    console.error(error)
                })
        },
        createProduct({ dispatch }, product) {
            axios.post(`/api/v1/products`, product)
                .then(() => {
                    dispatch('getProducts')
                })
                .catch(error => {
                    console.error(error)
                })
        }
    }
})

export default productStore
