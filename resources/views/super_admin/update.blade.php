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
    <title>Update user</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-SgOJa3DmI69IUzQ2PVdRZhwQ+dy64/BUtbMJw1MZ8t5HZApcHrRKUc4W0kG879m7" crossorigin="anonymous">
</head>
<body>
    <div class="container">
        <form action="{{ route('update.user',$user->id) }}" method="POST">
            @csrf

            <p>
                <label for="name" class="form-label">Name</label>
                <input type="text" class="form-control" id="name" name="name" value="{{ $user->name }}">
                @error('name')
                <div class="text-red-600">{{ $message }}</div>
                @enderror
            </p>
            <p>
                <label for="email" class="form-label">Email</label>
                <input type="text" class="form-control" id="email" name="email" value="{{ $user->email }}">
                @error('email')
                <div class="text-red-600">{{ $message }}</div>
                @enderror
            </p>
            <p>
                <label for="phone" class="form-label">Phone</label>
                <input type="text" class="form-control" id="phone" name="phone" value="{{ $user->phone }}">
                @error('phone')
                <div class="text-red-600">{{ $message }}</div>
                @enderror
            </p>
            <p>
                <label for="price" class="form-label">Role</label>
                <select name="role" id="role">
                    <option value="customer" {{ old('role',$user->role ?? '') === 'customer' ? 'selected' : '' }}>Customer</option>
                    <option value="admin" {{ old('role',$user->role ?? '') === 'admin' ? 'selected' : '' }}>Admin</option>
                    <option value="super_admin" {{ old('role',$user->role ?? '') === 'super_admin' ? 'selected' : '' }}>Super Admin</option>
                </select>
                @error('price')
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

