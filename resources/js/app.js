// import './bootstrap';
import 'bootstrap';
import 'bootstrap/scss/bootstrap.scss';
import { createApp } from 'vue';
import ProductsPage from '@pages/ProductsPage.vue';
import productStore from '@stores/productStore';
import App from './vue/App.vue';
import ElementPlus from 'element-plus'
import 'element-plus/dist/index.css'

const app = createApp(ProductsPage);
app.component('products-page', ProductsPage);
app.use(productStore);
app.use(ElementPlus);
app.mount('#app');
