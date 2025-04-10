<template>
    <div class="cart">
        <h2>Ваша корзина</h2>

        <div v-if="items.length === 0">
            <p>Корзина пуста</p>
        </div>

        <div v-else>
            <div class="cart-item" v-for="item in items" :key="item.id">
                <h3>{{ item.name }}</h3>
                <p>Цена: {{ item.price }} ₽</p>
                <p>Количество:
                    <button @click="decrement(item.id)">-</button>
                    {{ item.quantity }}
                    <button @click="increment(item.id)">+</button>
                </p>
                <p>Сумма: {{ item.price * item.quantity }} ₽</p>
                <button @click="remove(item.id)">Удалить</button>
            </div>

            <div class="cart-total">
                <h3>Итого: {{ total }} ₽</h3>
                <button @click="checkout">Оформить заказ</button>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            items: []
        }
    },
    computed: {
        total() {
            return this.items.reduce((sum, item) => sum + (item.price * item.quantity), 0);
        }
    },
    methods: {
        increment(id) {
            const item = this.items.find(i => i.id === id);
            if (item) item.quantity++;
            this.saveCart();
        },
        decrement(id) {
            const item = this.items.find(i => i.id === id);
            if (item && item.quantity > 1) {
                item.quantity--;
                this.saveCart();
            }
        },
        remove(id) {
            this.items = this.items.filter(i => i.id !== id);
            this.saveCart();
        },
        checkout() {
            alert('Заказ оформлен! Сумма: ' + this.total + ' ₽');
            this.items = [];
            this.saveCart();
        },
        saveCart() {
            localStorage.setItem('cart', JSON.stringify(this.items));
            window.dispatchEvent(new Event('storage'));
        },
        loadCart() {
            const cart = localStorage.getItem('cart');
            if (cart) {
                this.items = JSON.parse(cart);
            }
        },
    },
    mounted() {
        this.loadCart();
    }
}
</script>

<style scoped>
.cart-item {
    border: 1px solid #ddd;
    padding: 1rem;
    margin-bottom: 1rem;
    border-radius: 5px;
}

.cart-total {
    margin-top: 2rem;
    padding: 1rem;
    background: #f9f9f9;
    border-radius: 5px;
}

button {
    background: #e74c3c;
    color: white;
    border: none;
    padding: 0.3rem 0.6rem;
    border-radius: 3px;
    cursor: pointer;
    margin: 0 0.3rem;
}

button:hover {
    background: #c0392b;
}
</style>
