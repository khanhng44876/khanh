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
    <title>Order Manager</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-SgOJa3DmI69IUzQ2PVdRZhwQ+dy64/BUtbMJw1MZ8t5HZApcHrRKUc4W0kG879m7" crossorigin="anonymous">
</head>
<body>
    <div class="container">
        <input type="hidden" value="{{ $order->id }}" name="orderId" id="orderId">
        <div>
            <form action="{{ route('update.status',$order->id) }}" method="POST">
                @csrf
                
                <button type="submit" class="btn btn-warning rounded-pill">Xác nhận</button>
            </form> 
        </div>
        <div class="row">
            <h1>HD{{ $order->id }}</h1> <span>Ngày tạo: {{ $order->created_at }}</span>
            <strong>Tổng tiền hàng: <span>{{ number_format($order->total) }}</span></strong>
            <ul class="list-group mt-3">
              @foreach ($order->detail as $item)
                <li class="list-group-item p-0 border-0">
                  <a href="{{ route('product.detail', $item->product->id) }}" 
                     class="d-flex align-items-center text-decoration-none text-dark py-2 px-3"
                     style="transition: background .2s;">
                    <img src="{{ asset('images/'.$item->product->img) }}" 
                         alt="{{ $item->product->name }}"
                         class="me-3 rounded" 
                         style="width: 80px; height: 80px; object-fit: cover;">
        
                    <div class="flex-fill">
                      <h6 class="mb-1">{{ $item->product->name }}</h6>
                      <div class="small text-muted">
                        Đơn giá: {{ number_format($item->product->price) }}₫ &nbsp;|&nbsp;
                        Số lượng: {{ $item->quantity }}
                      </div>
                    </div>
        
                    <div class="fw-bold text-danger">
                      {{ number_format($item->total) }}₫
                    </div>
                  </a>
                </li>
              @endforeach
            </ul>
          </div>
          <div>
            Trạng thái đơn : <strong>{{ $order->status }}</strong>
        </div>
    </div>
    
</body>
<x-slot name="scripts">
    {{-- Đưa orderId lên window --}}
    <script>
        window.orderId = document.getElementById('orderId').value;
    </script>

    {{-- Nạp bundle JS (bootstrap.js + echo.js) --}}
    @vite(['resources/js/app.js'])
</x-slot> 
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js" integrity="sha384-k6d4wzSIapyDyv1kpU366/PK5hCdSbCRGRCMv+eplOQJWyd1fbcAu9OCUj5zNLiq" crossorigin="anonymous"></script>
</html>

</x-app-layout>