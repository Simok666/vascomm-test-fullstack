<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class DashboardController extends Controller
{
   public function index()
   {
       if(Auth::user()->hasRole('user')){
        return view('welcome');
       }elseif(Auth::user()->hasRole('admin')){
        $data = User::select("*")
        ->from('users')
        ->join('role_user','user_id','=','users.id')
        ->where(['role_user.role_id' => 2 ])
        ->orderBy('created_at', 'DESC')
        ->get(); 
        $form = view('dashboard', ['data' => $data]);
        return $form;
   }
   }

   public function myprofile()
   {
    return view('myprofile');
   }
}
