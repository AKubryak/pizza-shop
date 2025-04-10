@extends('layouts.app')

@section('title', 'Меню')

@section('content')
    <h1>Наше меню</h1>

    <div class="filters">
        <select id="category-filter">
            <option value="">Все категории</option>
            @foreach ($categories as $category)
                <option value="{{ $category->id }}">{{ $category->name }}</option>
            @endforeach
        </select>
    </div>

    <div class="products-grid">
        @foreach ($products as $product)
            <div class="product-card" data-category="{{ $product->category_id }}">
                <img src="{{ $product->image ? asset('storage/' . $product->image) : asset('images/pizza-placeholder.jpg') }}"
                    alt="{{ $product->name }}">
                <h3>{{ $product->name }}</h3>
                <p>{{ $product->description }}</p>
                <p class="price">{{ $product->price }} ₽</p>
                <button class="add-to-cart" data-id="{{ $product->id }}">В корзину</button>
            </div>
        @endforeach
    </div>
@endsection

@section('scripts')
    <script>
        // Фильтрация по категориям
        document.getElementById('category-filter').addEventListener('change', function() {
            const categoryId = this.value;
            const products = document.querySelectorAll('.product-card');

            products.forEach(product => {
                if (!categoryId || product.getAttribute('data-category') === categoryId) {
                    product.style.display = 'block';
                } else {
                    product.style.display = 'none';
                }
            });
        });

        // Добавление в корзину
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
