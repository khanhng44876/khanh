<x-app-layout>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Customer</title>
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
        <div class="position-relative w-50">
            <input type="text" id="product-search" class="form-control" placeholder="Tìm theo mã hoặc tên" autocomplete="off">
            <ul id="suggest" class="list-group position-absolute w-100" style="z-index:1000; display:none;">

            </ul>
        </div>
        <div>
            <form id="fillter" action="{{ route('product.sort') }}" method="get">
                @csrf
                <select
                name="sort"
                id="sort-select"
                class="form-select w-auto"
                >
                    <option value="">-- Sắp xếp giá --</option>
                    <option type="submit" value="desc" {{ request('sort')=='desc' ? 'selected' : '' }}>
                    Giá: cao → thấp
                    </option>
                    <option type="submit" value="asc" {{ request('sort')=='asc' ? 'selected' : '' }}>
                    Giá: thấp → cao
                    </option>
                </select>
                <button type="submit" class="d-none">Áp dụng</button>
            </form>
        </div>
        <div class="row mt-4">
          @foreach ($listProduct as $p)
            <div class="col-6 col-md-3 mb-4">
              <div class="card h-100">
                <img src="{{ asset('images/'.$p->img) }}" class="card-img-top" alt="{{ $p->name }}">
                <div class="card-body d-flex flex-column">
                  <h5 class="card-title">{{ $p->name }}</h5>
                  <p class="card-text text-danger">{{ number_format($p->price,0,',','.') }} ₫</p>
                  <a href="/detail/{{ $p->id }}" class="btn btn-primary mt-auto">Detail</a>
                </div>
              </div>
            </div>
          @endforeach
        </div>
        <!-- Pagination links -->
        <div class="d-flex justify-content-center">
            {{ $listProduct->appends(request()->query())->links() }}
        </div>
      </div>
</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js" integrity="sha384-k6d4wzSIapyDyv1kpU366/PK5hCdSbCRGRCMv+eplOQJWyd1fbcAu9OCUj5zNLiq" crossorigin="anonymous"></script>
<script>
    document.getElementById('sort-select').addEventListener('change',function(){
        document.getElementById('fillter').submit();
    });
    document.addEventListener('DOMContentLoaded',function(){
        const input = document.getElementById('product-search');
        const list = document.getElementById('suggest');
        let timer;

        async function sendSuggest(term){
            const res = await fetch(`{{ url('/product-search') }}?term=${encodeURIComponent(term)}`);
            if(!res.ok) return [];
            return await res.json();

        }

        function showSuggest(items){
            if(items.length === 0){
                list.style.display = 'none';
                return;
            }
            list.innerHTML = items.map(item =>
            `<li class="list-group-item list-group-item-action" data-id="${item.id}">
                ${item.label}
            </li>`
            ).join('');
            list.style.display = 'block';
        }

        list.addEventListener('click',e=>{
            const li = e.target.closest('li');
            if(!li){
                return;
            }
            input.value = li.textContent.trim();
            list.style.display = 'none';
            window.location.href = `/detail/${li.dataset.id}`;
         })

        input.addEventListener('input',function(){
            const term = this.value.trim();
            clearTimeout(timer);
            if (term === '') {
                list.style.display = 'none';
                return;
            }
            timer = setTimeout(async () => {
            const suggestions = await sendSuggest(term);
            showSuggest(suggestions);
            }, 300);
        })
        document.addEventListener('click', e => {
            if (!input.contains(e.target) && !list.contains(e.target)) {
            list.style.display = 'none';
            }
        });
    })
</script>
</html>
</x-app-layout>