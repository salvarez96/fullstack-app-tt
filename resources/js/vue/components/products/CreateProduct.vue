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
                        <div class="alert alert-danger" ref="alert" role="alert">
                            Hubo un error al crear el nuevo producto, intenta de nuevo más tarde. Código de error: {{ errorCode }}
                        </div>
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

const store = useStore();
const toggleSendButton = ref(false);
const alert = ref('alert')
const errorCode = ref(0)
let modalInstance = null;

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

function resetNewProductValues() {
    newProduct.value.name = ''
    newProduct.value.category_id = ''
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
        toggleSendButton.value = true;
        console.log(newProduct.value);
        await store.dispatch('createProduct', newProduct.value);

        closeModal();
        toggleSendButton.value = false;
    } catch (error) {
        console.log('error:' , error);
        console.error(error);
        errorCode.value = error.response.status;
        alert.value.style.display = 'block';
        toggleSendButton.value = false;

        setTimeout(() => {
            errorCode.value = 0;
            alert.value.style.display = 'none';
        }, 5000);
    }
}

</script>

<style lang="scss">
    .create-product-container {
        label {
            margin: 10px 0;
        }
    }
    .alert {
        display: none;
        margin-top: 10px;
    }
</style>
