import { createStore } from 'vuex'
import axios from 'axios'

// Create a new store instance.
const productStore = createStore({
    state () {
        return {
            products: []
        }
    },
    mutations: {
        setProducts(state, products) {
            state.products = products
        }
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
        }
    }
})

export default productStore
