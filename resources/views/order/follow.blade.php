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
            <input type="hidden" value="{{ $order->id }}" id="orderId">
               <div>
                    {{ $order->created_at }} - Đơn hàng của bạn đã được đặt đang :
               </div>
               <ul class="order-steps" id="order-steps">
                @foreach($step as $key => $item)
                  <li class="{{ $loop->last ? 'completed' : ($loop->index <= array_search($order->status, array_keys($step)) ? 'active' : '') }}">
                    <div class="step-label">{{ $item['label'] }} - {{ $item['date'] }}</div>
                  </li>
                @endforeach
              </ul>
        </div>
    </body> 
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js" integrity="sha384-k6d4wzSIapyDyv1kpU366/PK5hCdSbCRGRCMv+eplOQJWyd1fbcAu9OCUj5zNLiq" crossorigin="anonymous"></script>
    </html>
    </x-app-layout> 