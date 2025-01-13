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
        <nav class="navigation-container" aria-label="Page navigation example">
            <ul class="pagination">
                <li class="page-item">
                    <button class="page-link" @click="handlePagination('previous')" aria-label="Previous">
                        <span aria-hidden="true">&laquo;</span>
                    </button>
                </li>
                <li class="page-item" v-for="link in products.meta?.links" :key="link.label">
                    <button class="page-link" v-if="Number(link.label)" @click="handlePagination(link.label)">{{ link.label }}</button>
                </li>
                <li class="page-item">
                    <button class="page-link" @click="handlePagination('next')" aria-label="Next">
                        <span aria-hidden="true">&raquo;</span>
                    </button>
                </li>
            </ul>
        </nav>
    </div>
</template>

<script setup>
import { onBeforeMount, computed, onMounted, ref, onUnmounted } from 'vue';
import { useStore } from 'vuex';
import ProductCard from '@components/products/ProductCard.vue';
import Filters from '@components/products/Filters.vue';
import CreateProduct from '@components/products/CreateProduct.vue';
import handleUrlPagination from '@helpers/handleUrlPagination'

const store = useStore();
const products = computed(() => store.state.products);
const categories = computed(() => store.state.categories);
const createProductForm = ref(null);
const currentPage = ref(1)

onBeforeMount(() => {
    store.dispatch('getCategories');

    setCurrentPage();
    console.log(currentPage);
    store.dispatch('getProducts', {'page': currentPage.value});
});

function handleProductForm() {
    createProductForm.value.openModal();
}

function setCurrentPage() {
    currentPage.value = location.search.match(/(?:page=)\d+/) ? location.search.match(/(?:page=)\d+/)[0].split('=')[1] : 1
}

function handlePagination(pageToGo, isPopState = false) {
    // calculate previous and next page depending on the product's available navigation links
    if (pageToGo === 'previous' && products.value.links?.prev) {
        pageToGo = products.value.meta.current_page - 1
    } else if (pageToGo === 'next' && products.value.links?.next) {
        pageToGo = products.value.meta.current_page + 1
    }

    // if the navigation is done through the pagination buttons, push the new page
    // to the browser's history as a param and then load the products for that page
    if (Number(pageToGo) && !isPopState) {
        console.log(products.value.links);
        console.log(pageToGo);

        handleUrlPagination(pageToGo)

        store.dispatch('getProducts', {'page': pageToGo});
    }

    // if navigation is done through the browser's back and forward buttons,
    // set the current page to the one in the URL and then load the products for that page
    if (isPopState) {
        setCurrentPage();
        console.log(currentPage.value, isPopState);
        store.dispatch('getProducts', {'page': currentPage.value});
    }
}

onMounted(() => {
    // if user navigates through the browser's back and forward buttons, handle the pagination
    window.addEventListener('popstate', () => handlePagination(1, true))
})

onUnmounted(() => {
    window.removeEventListener('popstate', () => handlePagination(1, true))
});

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

    .navigation-container {
        margin: 50px 0;
        display: flex;
        justify-content: center;
    }
</style>
