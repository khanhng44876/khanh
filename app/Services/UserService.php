<?php

namespace App\Services;

use App\Models\User;

class UserService
{
    public function create(array $data):User{
        return User::create($data);
    }

    public function update(array $data,$id):User{
        $user = User::findOrFail($id);
        $user->name = $data['name'];
        $user->email = $data['email'];
        $user->phone = $data['phone'];
        $user->role = $data['role'];
        $user->save();
        return $user;
    }

    public function show(){
        return User::orderBy('created_at','desc')->paginate(5);
    }

    public function detail($id){
        return User::findOrFail($id);
    }
}