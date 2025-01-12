// import './bootstrap';
import 'bootstrap';
import 'bootstrap/scss/bootstrap.scss';
import { createApp } from 'vue';
import ProductsPage from '@pages/ProductsPage.vue';
import productStore from '@stores/productStore';
import App from './vue/App.vue';

const app = createApp(ProductsPage);
app.component('products-page', ProductsPage);
app.use(productStore);
app.mount('#app');
