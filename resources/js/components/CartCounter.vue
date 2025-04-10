<template>
    <span class="cart-count" @click="goToCart">{{ count }}</span>
</template>

<script>
export default {
    data() {
        return {
            count: 0
        }
    },
    methods: {
        updateCount() {
            const cart = JSON.parse(localStorage.getItem('cart')) || [];
            this.count = cart.reduce((sum, item) => sum + item.quantity, 0);
        },
        goToCart() {
            window.location.href = '/cart';
        }
    },
    mounted() {
        this.updateCount();
        window.addEventListener('storage', this.updateCount);
    },
    beforeUnmount() {
        window.removeEventListener('storage', this.updateCount);
    }
}
</script>

<style scoped>
.cart-count {
    margin-left: 5px;
    background: #e74c3c;
    color: white;
    border-radius: 50%;
    padding: 2px 6px;
    font-size: 12px;
    cursor: pointer;
}
</style>
