<template>
    <div class="create-product-container modal fade" data-bs-backdrop="static" id="newProductModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Agregar producto</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" @click="closeNewProductModal"></button>
                </div>
                <form @submit.prevent="createProduct">
                    <div class="modal-body">
                        <label for="product-name">Nombre del producto</label>
                        <input type="text" v-model="newProduct.name" class="form-control" id="product-name" placeholder="Nombre del producto" required>
                        <label for="product-category">Categoría</label>
                        <select class="form-select" v-model="newProduct.category" id="product-category" aria-label="Default select example" required>
                            <option selected>Selecciona una categoría</option>
                            <option v-for="(category, index) in categories" :key="category.id" :value="category.id">{{ category.name }}</option>
                        </select>
                        <label for="product-price">Precio</label>
                        <input type="number" v-model="newProduct.price" class="form-control" id="product-price" placeholder="Precio" required>
                        <label for="product-description">Descripción</label>
                        <textarea class="form-control" v-model="newProduct.description" id="product-description" rows="3" required></textarea>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                        <button type="submit" class="btn btn-primary">Crear producto</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>

<script setup>
import bootstrap from 'bootstrap/dist/js/bootstrap.bundle.min.js';
import { ref } from 'vue';
import { useStore } from 'vuex';

const store = useStore();

const newProduct = ref({
    name: '',
    category_id: '',
    price: '',
    description: ''
});

defineProps({
    categories: Array
})

defineExpose({
    openModal
})

function openModal() {
    const modalElement = document.getElementById('newProductModal');
    const modalInstance = new bootstrap.Modal(modalElement);
    modalInstance.show();
}

async function createProduct() {
    try {
        console.log(newProduct.value);
        await store.dispatch('createProduct', newProduct.value);

        newProduct.value.name = ''
        newProduct.value.category_id = ''
        newProduct.value.price = ''
        newProduct.value.description = ''
    } catch (error) {
        console.error(error);
    }
}

</script>

<style lang="scss">
    .create-product-container {
        label {
            margin: 10px 0;
        }
    }
</style>
