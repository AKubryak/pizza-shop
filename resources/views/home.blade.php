@extends('layouts.app')

@section('title', 'Главная')

@section('content')
    <section class="hero">
        <h1>Лучшая пицца в городе</h1>
        <p>Быстрая доставка и только свежие ингредиенты</p>
    </section>

    <section class="popular-products">
        <h2>Популярные пиццы</h2>
        <div class="products-grid">
            @foreach ($popularProducts as $product)
                <div class="product-card">
                    <img src="{{ $product->image ? asset('storage/' . $product->image) : asset('images/pizza-placeholder.jpg') }}"
                        alt="{{ $product->name }}">
                    <h3>{{ $product->name }}</h3>
                    <p>{{ $product->description }}</p>
                    <p class="price">{{ $product->price }} ₽</p>
                    <button class="add-to-cart" data-id="{{ $product->id }}">В корзину</button>
                </div>
            @endforeach
        </div>
    </section>
@endsection

@section('scripts')
    <script>
        document.querySelectorAll('.add-to-cart').forEach(button => {
            button.addEventListener('click', function() {
                const productId = this.getAttribute('data-id');
                const productName = this.parentNode.querySelector('h3').textContent;
                const productPrice = parseFloat(this.parentNode.querySelector('.price').textContent);

                let cart = JSON.parse(localStorage.getItem('cart')) || [];
                const existingItem = cart.find(item => item.id === productId);

                if (existingItem) {
                    existingItem.quantity += 1;
                } else {
                    cart.push({
                        id: productId,
                        name: productName,
                        price: productPrice,
                        quantity: 1
                    });
                }

                localStorage.setItem('cart', JSON.stringify(cart));
                window.dispatchEvent(new Event('storage'));

                // Уведомление
                const notification = document.createElement('div');
                notification.textContent = 'Товар добавлен в корзину!';
                notification.style.position = 'fixed';
                notification.style.bottom = '20px';
                notification.style.right = '20px';
                notification.style.backgroundColor = '#4CAF50';
                notification.style.color = 'white';
                notification.style.padding = '10px';
                notification.style.borderRadius = '5px';
                document.body.appendChild(notification);

                setTimeout(() => {
                    notification.remove();
                }, 2000);
            });
        });
    </script>
@endsection
