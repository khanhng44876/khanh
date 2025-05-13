<x-app-layout>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Cart</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-SgOJa3DmI69IUzQ2PVdRZhwQ+dy64/BUtbMJw1MZ8t5HZApcHrRKUc4W0kG879m7" crossorigin="anonymous">
    </head>
    <body>
        <header class="w-full lg:max-w-4xl max-w-[335px] text-sm mb-6 not-has-[nav]:hidden">
            @guest
            <nav class="flex items-center justify-end gap-4">
                <a
                    href="{{ route('home.page') }}"
                    class="inline-block px-5 py-1.5 dark:text-[#EDEDEC] border-[#19140035] hover:border-[#1915014a] border text-[#1b1b18] dark:border-[#3E3E3A] dark:hover:border-[#62605b] rounded-sm text-sm leading-normal"
                >
                    Home
                </a>
                <a
                    href="{{ route('login') }}"
                    class="inline-block px-5 py-1.5 dark:text-[#EDEDEC] text-[#1b1b18] border border-transparent hover:border-[#19140035] dark:hover:border-[#3E3E3A] rounded-sm text-sm leading-normal"
                >
                    Log in
                </a>
    
                <a
                    href="{{ route('register') }}"
                    class="inline-block px-5 py-1.5 dark:text-[#EDEDEC] border-[#19140035] hover:border-[#1915014a] border text-[#1b1b18] dark:border-[#3E3E3A] dark:hover:border-[#62605b] rounded-sm text-sm leading-normal">
                    Register
                </a>
            </nav>
            @else
                <nav class="flex items-center justify-end gap-4">
                        <x-slot name="header">
                            <nav class="border-b border-gray-200 dark:border-gray-700 mb-4">
                                <ul class="flex space-x-8">
                                    <li>
                                        <a href="{{ route('home.page') }}"
                                        class=" 'border-b-2 border-indigo-600 text-indigo-600' : 'border-b-2 border-transparent hover:border-gray-300 dark:hover:border-gray-600' }}">
                                            Home
                                        </a>
                                    </li>
                                </ul>
                            </nav>
                        </x-slot>
                </nav>
            @endguest
    </header>
        <div class="container">
            <h2>Giỏ hàng của bạn</h2>
    @if(session('cart') && count(session('cart')) > 0)
        <table class="table">
            <thead>
                <tr><th>Ảnh</th><th>Sản phẩm</th><th>Giá</th><th>Số lượng</th><th>Thành tiền</th><th>Thao tác</th></tr>
            </thead>
            <tbody>
                @foreach(session('cart') as $id => $item)
                <tr>
                    <td>
                        <img src="{{ asset('images/'.$item['img']); }}" alt="" style="max-width:150px; height:auto;">
                    </td>
                    <td>{{ $item['name'] }}</td>
                    <td>{{ number_format($item['price']) }}</td>
                    <td>{{ $item['quantity'] }}</td>
                    <td>{{ number_format($item['total']) }}</td>
                    <td>
                        <form action="{{ route('cart.delete', $id) }}" method="POST">
                            @csrf
                            <button class="btn btn-danger btn-sm">Xóa</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p>Giỏ hàng trống.</p>
    @endif
    <hr>
        </div>
            @auth
                @if (session('cart') && count(session('cart')) > 0)
                @php
                    $total = 0;
                    $cart = session()->get('cart',[]);
                    foreach ($cart as $item) {
                        $total += $item['total'];
                    }
                @endphp
                    <form action="{{ route('cart.purchase') }}" method="POST">
                        @csrf
                        <span class="text-danger">Tổng tiền hàng : {{ number_format($total) }}</span> <br>
                        <input type="hidden" id="total" name="total" value="{{ $total }}">
                        <button type="submit" class="btn btn-warning rounded-pill">Thanh toán</button>
                    </form>
                @endif
            @endauth
        </div>
    </body>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js" integrity="sha384-k6d4wzSIapyDyv1kpU366/PK5hCdSbCRGRCMv+eplOQJWyd1fbcAu9OCUj5zNLiq" crossorigin="anonymous"></script>
    </html>
    </x-app-layout>