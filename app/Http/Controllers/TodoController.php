<?php

namespace App\Http\Controllers;

use DB;
use Illuminate\Http\Request;
use App\Todo;
use Validator;

class TodoController extends Controller
{
    //This is the controller index
    public function index()
    {
        # code...
        //取出
        //$todos = Todo::all();

        $todos = DB::table('todos')->orderBy('id','desc')->get();
        //dd($todos);
        //$todosSort = $todos->sortBy('id'); 
        //dd($todosSort); 
        //$todos = DB::select('select * from todos where title = "Peter"', [1]);
        //  dd($todos);

        // $collection = collect($todos);
        // $chunk = $collection->forpage(6,2);  //從哪裡拿多少資料
        // dd($chunk);


        return view('todo.index',[
            'todos' => $todos
        ]);
    }
    public function FileAdd(Request $request)
    {
        
        $validated = $request->validate([
            'start_at'=>'date_format:Y-m-d H:i:s',
            'title' => 'required|min:3',
            'item'=> 'required|min:0',       
        ]);

        # code...
        //Method 1
        // $todo = new Todo();
        // $todo->title = $request->title;
        // $todo->save();

        //Method 2
        /*
        *Method Two必須注意需在Todo Model裡先對欄位設定protected的值，否則會有錯誤
        */ 
        // $todo =  Todo::create([
        //     'title' => $request->title,
        // ]);

        //Method 3
        //$todo = Todo::create($request->all());
        $todo = Todo::create($validated);
        return response()->json([
            'success' => 'Record add successfully!',
          
        ]);
    }

    //此處應包含excel上傳時的新增與更新功能
    public function FileUpload( Request $request )
    {
        //dd($request ->all());
        $uploadData = $request->all();

        ///$aaa["UploadData"] as $key => $value  取得鍵值
        // foreach ($uploadData["UploadData"] as $key => $value ){
        //     var_dump($key);
        // }
        
        ///$aaa["UploadData"] as $value 取得value值
        // foreach ($uploadData["UploadData"] as $value ){
        //     var_dump($value);
        // }

        //var_dump($uploadData["UploadData"]["id"]);
        //var_dump($uploadData["UploadData"]);
        
        $updateData = Todo::find($uploadData["UploadData"]["id"]);
        
        if(!$updateData)
        {
            // $parameters = $uploadData["UploadData"];
            // $rules = [
            //     'start_at'=>'date_format:Y-m-d H:i:s',
            //     'title' => 'required|min:0',
            //     'item'=> 'required|min:0', 
            // ];
            // $messages = [
            //     'start_at.required' => '時間格式有誤',
            //     'title.required' => '請輸入名稱',
            //     'item'=> '請輸入物件',
            // ]; 

            // $validated = Validator::make($parameters, $rules, $messages);

            $todo = Todo::create(
                [                    
                    'title'=> $uploadData["UploadData"]["title"],
                    'start_at' => $uploadData["UploadData"]["start_at"],
                    //'start_at' => 'NULL',
                    'item' => $uploadData["UploadData"]["item"],
                    'end_at' => 'NULL'
                ]    
            );
            
        }
        else
        {
            $updateData->update($uploadData["UploadData"]);
        } 
        //  $updateData = Todo::find($request->id);
        //  if(!$updateData){return;}
         
        //  $updateData->update($request->all());
        
         return response()->json([
            'success' => $uploadData["UploadData"]["id"],
        ]);
    }

    // public function destroy(Request $request, Todo $todo)
    public function destroy($id)
    {
        # code...
        //dd($todo);
        //$todo->delete();
        //dd($todo);
        //return redirect('todo');
        
        Todo::find($id)->delete($id);
        return response()->json([
            'success' => 'Record deleted successfully!'
        ]);       
    }

    //新增和修改
    public function AddandUpdate(Request $request)
    {   
        //dd($request->all());    
        //新增在column的選項，方便使用者可以直接用下拉式選單選擇
        $updateItemSelect = DB::table('pdmat_kinds')->where('kind', $request->item)-> where('colName', 'item')->first(); 
        
        if ($updateItemSelect === null )
        {
            DB::table('pdmat_kinds')->insert(
                array('colName'=>'item',
                        'kind'=>$request->item, 
                        'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')
                    ));                         
        }

        
       
        if ($request->oper =='add')
        {
            //var_dump($request->all());
            $validated = $request->validate([
                'start_at'=>'date_format:Y-m-d H:i:s',
                'title' => 'required|min:0',
                'item'=> 'required|min:0',
                'urgent'=>'required|min:0',       
            ]);
            $todo = Todo::create($validated);
            return response()->json([
                'success' => 'Record add successfully!'
            ]);
        }
        else
        {
            $updateData = Todo::find($request->id);
            $updateData->update($request->all());
            return response()->json([
                'success' => 'Record update successfully!'
            ]);
      
        }
    }

    public function test()
    {
        return view('todo.test',[
            
        ]);  
    }
    public function ComboboxItem(Request $request)
    {    
        //dd($request);    
        //$todos = DB::table('pdmat_kinds')->orderBy('id','asc')->get();
        $todos = DB::table('todos')->select('item')->distinct()->get();

        return response()->json([
            'success' => $todos,
        ]);     
    }
}
