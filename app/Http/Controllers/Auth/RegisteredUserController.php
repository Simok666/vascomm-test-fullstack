<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            // 'profile_image' => 'required|image|mimes:jpg,png,jpeg,gif,svg',
            'password' => 'required|string|confirmed|min:8',
        ]);
       
        if($request->hasfile('profile_image')){
            $imageName = time().'.'.$request->file('profile_image')->getClientOriginalExtension();
            $request->file('profile_image')->move(public_path('imageRegisters'), $imageName);
        }
        
        Auth::login($user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'profile_image' => $imageName ?? NULL,
            'password' => Hash::make($request->password),
        ]));
        
        $user->attachRole($request->role_id); 
        
        event(new Registered($user));

        return redirect(RouteServiceProvider::HOME);
    }
}
