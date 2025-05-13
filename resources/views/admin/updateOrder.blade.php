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
        <ul class="nav nav-tabs" id="orderTab" role="tablist">
            <li class="nav-item" role="presentation">
              <button class="nav-link active" id="tab-confirmation" data-bs-toggle="tab" data-bs-target="#pane-confirmation" type="button" role="tab" aria-controls="pane-confirmation" aria-selected="true">
                Chờ xác nhận
              </button>
            </li>
            <li class="nav-item" role="presentation">
              <button class="nav-link" id="tab-pending" data-bs-toggle="tab" data-bs-target="#pane-pending" type="button" role="tab" aria-controls="pane-pending" aria-selected="false">
                Chờ giao hàng
              </button>
            </li>
            <li class="nav-item" role="presentation">
              <button class="nav-link" id="tab-shipping" data-bs-toggle="tab" data-bs-target="#pane-shipping" type="button" role="tab" aria-controls="pane-shipping" aria-selected="false">
                Đang giao hàng
              </button>
            </li>
            <li class="nav-item" role="presentation">
              <button class="nav-link" id="tab-success" data-bs-toggle="tab" data-bs-target="#pane-success" type="button" role="tab" aria-controls="pane-success" aria-selected="false">
                Success
              </button>
            </li>
        </ul>
        <div class="tab-content mt-3" id="orderTabContent">
            <div class="tab-pane fade show active" id="pane-confirmation" role="tabpanel" aria-labelledby="tab-confirmation">
              <table class="table table-bordered">
                <thead>
                  <tr>
                    <th>ID</th>
                    <th>Ngày tạo</th>
                    <th>Tổng tiền</th>
                    <th>Người đặt</th>
                    <th>Trạng thái</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach($waitingOrder as $o)
                    <tr>
                      <td>{{ $o->id }}</td>
                      <td>{{ $o->created_at}}</td>
                      <td>{{ number_format($o->total) }}</td>
                      <td>{{ $o->user->name }}</td>
                      <td>{{ $o->status }}</td>
                      <td>
                        <a href="{{ route('update.status.page',$o->id) }}">Confirm</a>
                      </td>
                    </tr>
                  @endforeach
                </tbody>
              </table>
            </div>
            <div class="tab-pane fade show active" id="pane-pending" role="tabpanel" aria-labelledby="tab-confirmation">
                <table class="table table-bordered">
                  <thead>
                    <tr>
                      <th>ID</th>
                      <th>Ngày tạo</th>
                      <th>Tổng tiền</th>
                      <th>Người đặt</th>
                      <th>Trạng thái</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach($waitingShip as $o)
                      <tr>
                        <td>{{ $o->id }}</td>
                        <td>{{ $o->created_at}}</td>
                        <td>{{ number_format($o->total) }}</td>
                        <td>{{ $o->user->name }}</td>
                        <td>{{ $o->status }}</td>
                        <td>
                          <a href="{{ route('update.status.page',$o->id) }}">Confirm</a>
                        </td>
                      </tr>
                    @endforeach
                  </tbody>
                </table>
              </div>
              <div class="tab-pane fade show active" id="pane-shipping" role="tabpanel" aria-labelledby="tab-confirmation">
                <table class="table table-bordered">
                  <thead>
                    <tr>
                      <th>ID</th>
                      <th>Ngày tạo</th>
                      <th>Tổng tiền</th>
                      <th>Người đặt</th>
                      <th>Trạng thái</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach($shipping as $o)
                      <tr>
                        <td>{{ $o->id }}</td>
                        <td>{{ $o->created_at}}</td>
                        <td>{{ number_format($o->total) }}</td>
                        <td>{{ $o->user->name }}</td>
                        <td>{{ $o->status }}</td>
                        <td>
                          <a href="{{ route('update.status.page',$o->id) }}">Confirm</a>
                        </td>
                      </tr>
                    @endforeach
                  </tbody>
                </table>
              </div>
              <div class="tab-pane fade show active" id="pane-success" role="tabpanel" aria-labelledby="tab-confirmation">
                <table class="table table-bordered">
                  <thead>
                    <tr>
                      <th>ID</th>
                      <th>Ngày tạo</th>
                      <th>Tổng tiền</th>
                      <th>Người đặt</th>
                      <th>Trạng thái</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach($success as $o)
                      <tr>
                        <td>{{ $o->id }}</td>
                        <td>{{ $o->created_at}}</td>
                        <td>{{ number_format($o->total) }}</td>
                        <td>{{ $o->user->name }}</td>
                        <td>{{ $o->status }}</td>
                      </tr>
                    @endforeach
                  </tbody>
                </table>
              </div>
        </div>

</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js" integrity="sha384-k6d4wzSIapyDyv1kpU366/PK5hCdSbCRGRCMv+eplOQJWyd1fbcAu9OCUj5zNLiq" crossorigin="anonymous"></script>
</html>

</x-app-layout>