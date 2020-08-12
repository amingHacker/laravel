<?php

namespace App\Http\Controllers;

use DB;
use Illuminate\Http\Request;
use Validator;

class ShowAll extends Controller
{
    public function ShowAll($system)
    {
        $todos = DB::table($system)->orderBy('id','asc')->get();
        
        return view('ShowAll.Test',[
             'todos' => $todos
        ]);

    }


    public function test()
    {
        return view('todo.test',[
            
        ]);  
    }
    public function ComboboxItem(Request $request)
    {    
        //dd($request);    
        $todos = DB::table('pdmat_kinds')->orderBy('id','asc')->get();
      
        return response()->json([
            'success' => $todos,
        ]);     
    }


}
