<template>
    <div class="product-card">
        <h3>{{ productName }}</h3>
        <h5>{{ productCategory }}</h5>
        <img class="product-image mb-2" :src="productImage" :alt="productName" />
        <h6>Precio: ${{ productPrice }}</h6>
        <p>{{ productDescription }}</p>
    </div>
</template>

<script setup>
    defineProps({
        productName: String,
        productCategory: String,
        productImage: String,
        productPrice: String,
        productDescription: String
    })
</script>

<style lang="scss">
    .product-card {
        max-width: 300px;
        margin: 0 auto;
        border: 1px solid black;
        border-radius: 20px;
        padding: 30px 20px;
    }

    .product-image {
        min-width: 258px;
        min-height: 193px;
        border-radius: 5px;
    }
</style>
