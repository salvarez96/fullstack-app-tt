<template>
    <div class="main-container container">
        <h1 class="text-center">Nuestros productos</h1>
        <Filters />
        <CreateProduct ref="createProductForm" :categories="categories" />
        <div class="d-flex justify-content-end">
            <button type="button" class="btn btn-success new-product-form-button" @click="handleProductForm">+ Agregar producto</button>
        </div>
        <h6>Mostrando {{ products.meta?.to ?? 0 }} de {{ products.meta?.total ?? 0 }} productos</h6>
        <div class="products-container">
            <ProductCard v-for="(product) in products.data"
                :key="product.id"
                :productName="product.name"
                :productCategory="categories.find(category => category.id === product.category_id).name"
                :productImage="product.image"
                :productPrice="product.price"
                :productDescription="product.description"
            />
        </div>
        <Pagination
            :links="products.links"
            :meta="products.meta"
            storeAction="getProducts"
        />
    </div>
</template>

<script setup>
import { onBeforeMount, computed, ref } from 'vue';
import { useStore } from 'vuex';
import ProductCard from '@components/products/ProductCard.vue';
import Filters from '@components/products/Filters.vue';
import CreateProduct from '@components/products/CreateProduct.vue';
import Pagination from '@components/general/Pagination.vue'

const store = useStore();
const products = computed(() => store.state.products);
const categories = computed(() => store.state.categories);
const createProductForm = ref(null);

onBeforeMount(() => {
    store.dispatch('getCategories');
});

function handleProductForm() {
    createProductForm.value.openModal();
}

</script>

<style lang="scss">
    .main-container {
        max-width: 1100px;
        margin-top: 50px;
    }

    .products-container {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
        gap: 20px;
        margin-top: 50px;
    }

    .new-product-form-button {
        margin-top: 20px;
        margin-left: 10px;
    }
</style>
