<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Validation\Rule;
use Illuminate\View\View;
use App\Services\UserService;


class UserController extends Controller
{   
    protected UserService $service;

    public function __construct(UserService $service){
        $this->service = $service;
    }

    public function show(){
        $user = $this->service->show();
        return view('super_admin.index',compact('user'));
    }

    public function create(Request $request){
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'user_name' => ['required','string','max:255','unique:'.User::class],
            'phone'    => ['required','string','max:20','unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'role' => ['required']
        ]);

        $user = $this->service->create($data);

        return redirect()->route('user.manager')->with('success','Thanh cong');
    }

    public function update(Request $request,$id){
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users','email')->ignore($id)],
            'phone'    => ['required','string','max:20',Rule::unique('users','phone')->ignore($id)],
            'role' => ['required']
        ]);

        $user = $this->service->update($data,$id);

        return redirect()->route('user.manager')->with('success','thanh cong');
    }

    public function detail($id){
        $user = $this->service->detail($id);
        return view('super_admin.update',compact('user'));
    }

    public function delete($id){
        $user = $this->service->detail($id);
        $user->delete();
        return redirect()->route('user.manager')->with('success','Thanh cong');
    }
}
