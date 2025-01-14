<template>
    <div class="create-product-container modal fade" data-bs-backdrop="static" id="newProductModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Agregar producto</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" @click="closeModal"></button>
                </div>
                <form @submit.prevent="createProduct">
                    <div class="modal-body">
                        <label for="product-name">Nombre del producto</label>
                        <input type="text" v-model="newProduct.name" class="form-control" id="product-name" placeholder="Nombre del producto" required>
                        <label for="product-category">Categoría</label>
                        <select class="form-select" v-model="newProduct.category_id" id="product-category" aria-label="Default select example" required>
                            <option selected>Selecciona una categoría</option>
                            <option v-for="(category, index) in categories" :key="category.id" :value="category.id">{{ category.name }}</option>
                        </select>
                        <label for="product-price">Precio</label>
                        <input type="number" v-model="newProduct.price" class="form-control" id="product-price" placeholder="Precio" required>
                        <label for="product-description">Descripción</label>
                        <textarea class="form-control" v-model="newProduct.description" id="product-description" rows="3" required></textarea>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" @click="closeModal">Cerrar</button>
                        <button type="submit" class="btn btn-primary" :disabled="toggleSendButton">Crear producto</button>
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
import { ElNotification } from 'element-plus'

const store = useStore();
const toggleSendButton = ref(false);
const alert = ref('alert')
const errorCode = ref(0)
let modalInstance = null;

const newProduct = ref({
    name: '',
    category_id: 'Selecciona una categoría',
    price: '',
    description: ''
});

defineProps({
    categories: Array
})

defineExpose({
    openModal
})

function resetNewProductValues() {
    newProduct.value.name = ''
    newProduct.value.category_id = 'Selecciona una categoría'
    newProduct.value.price = ''
    newProduct.value.description = ''
}

function closeModal() {
    if (modalInstance) {
        modalInstance.hide();
    }
    resetNewProductValues();
}

function openModal() {
    const modalElement = document.getElementById('newProductModal');
    modalInstance = new bootstrap.Modal(modalElement);
    modalInstance.show();
}

async function createProduct() {
    try {
        if (newProduct.value.category_id === 'Selecciona una categoría') {
            ElNotification({
                title: 'Falta categoría',
                message: 'Selecciona una categoría para el nuevo producto.',
                type: 'warning'
            })
            return
        }

        toggleSendButton.value = true;
        console.log(newProduct.value);
        await store.dispatch('createProduct', newProduct.value);

        ElNotification({
            title: 'Éxito',
            message: 'El producto fue creado exitosamente.',
            type: 'success'
        })

        closeModal();
        toggleSendButton.value = false;
    } catch (error) {
        console.error(error);

        ElNotification({
            title: 'Error',
            message: 'No se pudo crear el producto.',
            type: 'error'
        })
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
