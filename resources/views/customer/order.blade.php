<x-app-layout>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Follow Order</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-SgOJa3DmI69IUzQ2PVdRZhwQ+dy64/BUtbMJw1MZ8t5HZApcHrRKUc4W0kG879m7" crossorigin="anonymous">
        <link rel="preconnect" href="https://fonts.bunny.net">
            <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />
    
    </head>
    <body class="bg-[#FDFDFC] dark:bg-[#0a0a0a] text-[#1b1b18] flex p-6 lg:p-8 items-center lg:justify-center min-h-screen flex-col">
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
            <h1>Đơn hàng của bạn</h1>
            <hr>
              @foreach ($orders as $o)
                <div class="row">
                  <h1>HD{{ $o->id }}</h1> <span>Ngày tạo: {{ $o->created_at }}</span>
                  <strong>Tổng tiền hàng: <span>{{ number_format($o->total) }}</span></strong>
                  <ul class="list-group mt-3">
                    @foreach ($o->detail as $item)
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
                <hr>
              @endforeach
            </div>
            <!-- Pagination links -->
            <div class="d-flex justify-content-center">
                {{ $orders->appends(request()->query())->links() }}
            </div>
          </div>
    </body>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js" integrity="sha384-k6d4wzSIapyDyv1kpU366/PK5hCdSbCRGRCMv+eplOQJWyd1fbcAu9OCUj5zNLiq" crossorigin="anonymous"></script>
    </html>
    </x-app-layout>