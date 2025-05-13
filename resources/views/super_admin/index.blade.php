<x-app-layout>
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
    <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>User Manager</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-SgOJa3DmI69IUzQ2PVdRZhwQ+dy64/BUtbMJw1MZ8t5HZApcHrRKUc4W0kG879m7" crossorigin="anonymous">
</head>
<body>
    <div class="container">
        <a href="{{ route('user.add.page') }}" class="btn btn-warning rounded-pill mt-4 mb-4">
            +Thêm mới
        </a>
        <table class="table table-bordered">
            <thead>
              <tr>
                <th>Id</th>
                <th>Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>UserName</th>
                <th>Role</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
                @foreach ($user as $u)
                    <tr>
                        <td>{{ $u->id }}</td>
                        <td>{{ $u->name }}</td>
                        <td>{{ $u->email }}</td>
                        <td>{{ $u->phone }}</td>
                        <td>{{ $u->user_name }}</td>
                        <td>{{ $u->role }}</td>
                        <td>
                            <a href="/super_admin/update-page/{{ $u->id }}" type="button" class="btn btn-warning">Sửa</a>
                            <a href="/super_admin/delete/{{ $u->id }}" type="button" class="btn btn-danger">Xóa</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
          </table>
          <div class="d-flex justify-content-center">
                {{ $user->appends(request()->query())->links() }}
          </div>
    </div>
</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js" integrity="sha384-k6d4wzSIapyDyv1kpU366/PK5hCdSbCRGRCMv+eplOQJWyd1fbcAu9OCUj5zNLiq" crossorigin="anonymous"></script>
</html>

</x-app-layout>
