<template>
    <div class="filters-container">
        <form @submit.prevent="handleApplyFilters">
            <div class="category-filter">
                <label for="category-filter">Filtrar por categoría</label>
                <select class="form-select" id="category-filter" v-model="filters['category-id']" aria-label="Default select example">
                    <option selected>Selecciona una categoría</option>
                    <option v-for="(category, index) in categories" :key="category.id" :value="category.id">{{ category.name }}</option>
                </select>
            </div>
            <div class="name-filter">
                <label for="name-filter">Buscar por nombre</label>
                <input type="text" class="form-control" id="name-filter" v-model="filters['name']" placeholder="nombre">
            </div>
            <div class="price-filter">
                <label for="min-price">Buscar por precio</label>
                <div class="price-form-container">
                    de
                    <input type="number" class="form-control price-form" id="min-price" v-model="filters['min-price']" placeholder="min">
                    a
                    <input type="number" class="form-control price-form" id="max-price" v-model="filters['max-price']" placeholder="max">
                </div>
            </div>
            <div class="form-buttons-container">
                <button type="button" class="btn btn-danger form-buttons" @click="cleanFilters">Limpiar filtros</button>
                <button type="submit" class="btn btn-primary form-buttons">Agregar filtros</button>
            </div>
        </form>
    </div>
</template>

<script setup>
import { useStore } from 'vuex';
import { computed, onBeforeMount, ref } from 'vue';
import handleUrlPagination from '@helpers/handleUrlPagination'

const store = useStore();
const categories = computed(() => store.state.categories);
const isFilterApplied = ref(false);

const filters = ref({
    'category-id': 'Selecciona una categoría',
    'name': '',
    'min-price': '',
    'max-price': '',
    'page': 1
});

onBeforeMount(() => {
    store.dispatch('getCategories');
});

async function cleanFilters() {
    try {
        if (isFilterApplied.value) {
            await store.dispatch('getProducts', {});
            handleUrlPagination(1)
            isFilterApplied.value = false
        }

        filters.value['category-id'] = 'Selecciona una categoría';
        filters.value['name'] = '';
        filters.value['min-price'] = '';
        filters.value['max-price'] = '';
    } catch (error) {
        console.error(error);
    }
}

async function handleApplyFilters() {
    try {
        const response = await store.dispatch('getProducts', filters.value);
        handleUrlPagination(1)

        if (!filters.value['category-id']) {
            filters.value['category-id'] = 'Selecciona una categoría';
        }

        isFilterApplied.value = response;
        console.log(store.state.products);
    } catch (error) {
        console.error(error);
    }
}

</script>

<style lang="scss">
.filters-container {
    margin-top: 30px;

    form {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
        gap: 20px;

        label {
            margin-bottom: 10px;
        }
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

.form-buttons-container {
    justify-self: center;

    .form-buttons:nth-child(2) {
        margin-left: 20px;
    }
}
</style>
