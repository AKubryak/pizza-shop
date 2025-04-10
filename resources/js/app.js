import { createApp } from 'vue';
import Cart from './components/Cart.vue';
import CartCounter from './components/CartCounter.vue';

const app = createApp({});

app.component('Cart', Cart);
app.component('cart-counter', CartCounter);

app.mount('#app');
