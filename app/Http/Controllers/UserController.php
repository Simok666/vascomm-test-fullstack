<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
class UserController extends Controller
{

    public function update(Request $request , $id){
        $postall = $request->all(); 
        $inputclear = \Arr::except($request->all(), array('_token', '_method')); 
        $reqApporval = $request->input('is_approval');
        $getApproval = User::select('is_approval')->where('id', $id)->first(); 

        $cek = User::where([ 
            ['is_approval', '!=', $getApproval->is_approval],
            ['is_approval', '=', $reqApporval]
        ])->count();
        if($cek) {
            return response()->json([ 
                'status' => false,
                'info' => "sudah approval"
            ], 201);
            return false;
        }
       
        User::where('id', $id)->update($inputclear); 

        return response()->json([ 
            'status' => true,
            'info' => "Success"
        ], 201);
    }
}
