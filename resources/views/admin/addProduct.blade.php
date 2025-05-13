<x-app-layout>
    @auth
        @php
            $role = auth()->user()->role;
        @endphp
        @if ($role === 'admin')
            <x-slot name="header">
                <nav class="border-b border-gray-200 dark:border-gray-700 mb-4">
                    <ul class="flex space-x-8">
                        <li>
                            <a href="{{ route('product.manager') }}"
                               class="pb-2 {{ request()->routeIs('product.manager') ? 'border-b-2 border-indigo-600 text-indigo-600' : 'border-b-2 border-transparent hover:border-gray-300 dark:hover:border-gray-600' }}">
                                Product
                            </a>
                        </li>
                    </ul>
                </nav>
            </x-slot>
        @else
            <x-slot name="header">
                <nav class="border-b border-gray-200 dark:border-gray-700 mb-4">
                    <ul class="flex space-x-8">
                        <li>
                            <a href="{{ route('user.manager') }}"
                               class="pb-2 {{ request()->routeIs('user.manager') ? 'border-b-2 border-indigo-600 text-indigo-600' : 'border-b-2 border-transparent hover:border-gray-300 dark:hover:border-gray-600' }}">
                                User
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('product.manager') }}"
                               class="pb-2 {{ request()->routeIs('product.manager') ? 'border-b-2 border-indigo-600 text-indigo-600' : 'border-b-2 border-transparent hover:border-gray-300 dark:hover:border-gray-600' }}">
                                Product
                            </a>
                        </li>
                    </ul>
                </nav>
            </x-slot>
        @endif
    @endauth
    <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Add Product</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-SgOJa3DmI69IUzQ2PVdRZhwQ+dy64/BUtbMJw1MZ8t5HZApcHrRKUc4W0kG879m7" crossorigin="anonymous">
</head>
<body>
    <div class="container">
        <form action="{{ route('add.product') }}" method="POST">
            @csrf

            <p>
                <label for="code_product" class="form-label">Mã sản phẩm</label>
                <input type="text" class="form-control" id="code_product" name="code_product">
                @error('code_product')
                <div class="text-red-600">{{ $message }}</div>
                @enderror
            </p>
            <p>
                <label for="name" class="form-label">Name</label>
                <input type="text" class="form-control" id="name" name="name">
                @error('name')
                <div class="text-red-600">{{ $message }}</div>
                @enderror
            </p>
            <p>
                <label for="quantity" class="form-label">Quantity</label>
                <input type="text" class="form-control" id="quantity" name="quantity">
                @error('quantity')
                <div class="text-red-600">{{ $message }}</div>
                @enderror
            </p>
            <p>
                <label for="price" class="form-label">Price</label>
                <input type="text" class="form-control" id="price" name="price">
                @error('price')
                <div class="text-red-600">{{ $message }}</div>
                @enderror
            </p>
            <p>
                <label for="img" class="form-label">Img</label>
                <input type="file" class="form-control" id="img" name="img">
                @error('img')
                <div class="text-red-600">{{ $message }}</div>
                @enderror
            </p>
            <button type="submit" class="btn btn-warning rounded-pill">Save</button>
        </form>
    </div>
</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js" integrity="sha384-k6d4wzSIapyDyv1kpU366/PK5hCdSbCRGRCMv+eplOQJWyd1fbcAu9OCUj5zNLiq" crossorigin="anonymous"></script>
</html>
</x-app-layout>
