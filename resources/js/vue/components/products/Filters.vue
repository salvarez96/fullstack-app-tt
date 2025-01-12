<template>
    <div class="filters-container">
        <div class="category-filter">
            <label for="category-filter">Filtrar por categoría</label>
            <select class="form-select" id="category-filter" v-model="categoryFilter" aria-label="Default select example">
                <option selected>Selecciona una categoría</option>
                <option v-for="(category, index) in categories" :key="category.id" :value="category.id">{{ category.name }}</option>
            </select>
        </div>
        <div class="name-filter">
            <label for="name-filter">Buscar por nombre</label>
            <input type="text" class="form-control" id="name-filter" v-model="nameFilter" placeholder="nombre">
        </div>
        <div class="price-filter">
            <label for="min-price">Buscar por precio</label>
            <div class="price-form-container">
                de
                <input type="number" class="form-control price-form" id="min-price" v-model="minPrice" placeholder="min">
                a
                <input type="number" class="form-control price-form" id="max-price" v-model="maxPrice" placeholder="max">
            </div>
        </div>
    </div>
    <button type="button" class="btn btn-danger filters-cleaner" @click="cleanFilters">Limpiar filtros</button>
</template>

<script setup>
import { useStore } from 'vuex';
import { computed, onBeforeMount, ref } from 'vue';

const store = useStore();
const categories = computed(() => store.state.categories);

const categoryFilter = ref('Selecciona una categoría');
const nameFilter = ref('');
const minPrice = ref('');
const maxPrice = ref('');

onBeforeMount(() => {
    store.dispatch('getCategories');
});

function cleanFilters() {
    categoryFilter.value = 'Selecciona una categoría';
    nameFilter.value = '';
    minPrice.value = '';
    maxPrice.value = '';
}

</script>

<style lang="scss">
.filters-container {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
    gap: 20px;
    margin-top: 30px;

    label {
        margin-bottom: 10px;
    }
}

.price-form-container {
    display: flex;
    gap: 10px;
    align-items: center;

    .price-form {
        max-width: 100px;
    }
}

.filters-cleaner {
    margin: 0 auto;
    margin-top: 20px;
}
</style>
