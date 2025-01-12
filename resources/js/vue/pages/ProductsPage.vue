<template>
    <div class="main-container container">
        <h1 class="text-center">Nuestros productos</h1>
        <div class="products-container">
            <ProductCard v-for="(product, index) in products.data"
                :key="index"
                :productName="product.name"
                :productCategory="product.category_id"
                :productImage="product.image"
                :productPrice="product.price"
                :productDescription="product.description"
            />
        </div>
    </div>
</template>

<script setup>
import { onBeforeMount, computed, onMounted } from 'vue';
import { useStore } from 'vuex';
import ProductCard from '@components/products/ProductCard.vue';

const store = useStore();
const products = computed(() => store.state.products);

onBeforeMount(() => {
    store.dispatch('getProducts');
});

onMounted(() => {
    console.log(products.value);
})
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
</style>
