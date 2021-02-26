<?php

namespace App\Http\Controllers;

use DB;
use Illuminate\Http\Request;
use Validator;

class BalanceAuthorityController extends Controller
{
    //This is the controller index
    public function index( Request $request )
    {      
        $todosAccounts = DB::connection('mysqlbalance')->table('container_balance_authority')->orderBy('id','desc')->first();
        
        return view('ContainerBalance.BalanceAuthority',[
            'todosAccounts' => $todosAccounts,
        ]);
    }

    //This is the controller show
    public function show( Request $request )
    {    
        $pageInf = $request->all();
        $pageNum = $pageInf["pageNum"];
        $limit = $pageInf["limit"];
        $sidx = ($pageInf["sidx"] == '')? 'id': $pageInf["sidx"];
        $order = ($pageInf["order"] == '')? 'desc': $pageInf["order"];
        
        $table = '';
        $searchGroupOp = ''; $filed = ''; $op = ''; $SearchData = '';
        $Record = '';
        
        switch ($_SERVER["REDIRECT_URL"])
        {
            case "/BalanceAuthority/show/Accounts":
                $table = 'container_balance_authority';
                break;
        }
        // var_dump($_SERVER["REDIRECT_URL"]);

        $query = DB::connection('mysqlbalance')->table($table);

        if ($pageInf["_search"] == 'true')
        {
            $tmp = get_object_vars(json_decode($pageInf["filters"])); //先把字串轉成obj,再轉成array形式運用
            //var_dump($tmp);
            foreach ($tmp["rules"] as $i)
            {
                $rules = get_object_vars($i);      
                $searchGroupOp = $tmp["groupOp"];
                $field = $rules["field"];
                $op = $rules["op"];
                $SearchData = $rules["data"];
                
                switch ($op){
                    case "eq":
                        $query = $query->where($field, $SearchData); 
                        break;
                    case "ne":
                        $query = $query->where($field, '!=' ,$SearchData); 
                        break;
                    case "bw":
                        $query = $query->where($field, 'like', '%'.$SearchData.'%'); 
                        break;
                    case "bn":
                        $query = $query->where($field, 'not like', '%'.$SearchData.'%'); 
                        break;
                    case "ew":
                        $query = $query->where($field, 'like', '%'.$SearchData.'%'); 
                        break;
                    case "en":
                        $query = $query->where($field, 'not like', '%'.$SearchData.'%');
                        break;
                    case "cn":
                        $query = $query->where($field, 'like', '%'.$SearchData.'%'); 
                        break;
                    case "nc":
                        $query = $query->where($field, 'not like', '%'.$SearchData.'%');
                        break;
                    case "nu":
                        $query = $query->whereNull($field);
                        break;
                    case "nn":
                        $query = $query->whereNotNull($field);
                        break;
                    case "in":
                        $query = $query->whereIn($field, $SearchData);
                        break;
                    case "ni":
                        $query = $query->whereNotIn($field, $SearchData);
                        break;
                    case "lt":
                        $query = $query->where($field,'<', $SearchData); 
                        break;
                    case "le":
                        $query = $query->where($field,'<=', $SearchData); 
                        break;
                    case "gt":
                        $query = $query->where($field,'>', $SearchData); 
                        break;
                    case "ge":
                        $query = $query->where($field,'>=', $SearchData); 
                        break;
                }
            }
        }
        
        $Record = $query->count();
        $todos = $query->get();
        $todos = $query->skip(($pageNum - 1) * $limit )->take($limit)->orderBy( $sidx, $order)->get();  
        //$todos = $query->offset(($pageNum - 1) * $limit )->limit($limit)->orderBy( $sidx, $order)->get();            
        $totalPage = ceil($Record / $limit) ;         
        
        return response()->json([
                'dataList'=> $todos,
                'currPage'=> $pageNum,  
                'totalCount'=> $Record,
                'totalPages'=> $totalPage,        
            ]);
    }

    //This is the controller Export
    public function Export(Request $request )
    {        
        $downloadReq = $request->all();

        $table = '';
        switch ($downloadReq["table"]){
            case 'dgAccounts':
                $table = 'container_balance_authority';
                break;
         
        }

        $_search = $downloadReq["postData"]["_search"];  
        $limit = $downloadReq["postData"]["limit"];
        $sidx = ($downloadReq["postData"]["sidx"] == '')? 'id': $downloadReq["postData"]["sidx"];
        $order = ($downloadReq["postData"]["order"] == '')? 'desc': $downloadReq["postData"]["order"];
        
        $searchGroupOp = ''; $filed = ''; $op = ''; $SearchData = '';
        $Record = '';
        $query = DB::connection('mysqlbalance')->table($table);
        $DownLoadValue = [];
        
        if ($_search == 'true')
        {
            $tmp = get_object_vars(json_decode($downloadReq["postData"]["filters"])); //先把字串轉成obj,再轉成array形式運用
            
            foreach ($tmp["rules"] as $i)
            {                
                $rules = get_object_vars($i);      
                $searchGroupOp = $tmp["groupOp"];
                $field = $rules["field"];
                $op = $rules["op"];
                $SearchData = $rules["data"];
                
                switch ($op){
                    case "eq":
                        $query = $query->where($field, $SearchData); 
                        break;
                    case "ne":
                        $query = $query->where($field, '!=' ,$SearchData); 
                        break;
                    case "bw":
                        $query = $query->where($field, 'like', '%'.$SearchData.'%'); 
                        break;
                    case "bn":
                        $query = $query->where($field, 'not like', '%'.$SearchData.'%'); 
                        break;
                    case "ew":
                        $query = $query->where($field, 'like', '%'.$SearchData.'%'); 
                        break;
                    case "en":
                        $query = $query->where($field, 'not like', '%'.$SearchData.'%');
                        break;
                    case "cn":
                        $query = $query->where($field, 'like', '%'.$SearchData.'%'); 
                        break;
                    case "nc":
                        $query = $query->where($field, 'not like', '%'.$SearchData.'%');
                        break;
                    case "nu":
                        $query = $query->whereNull($field);
                        break;
                    case "nn":
                        $query = $query->whereNotNull($field);
                        break;
                    case "in":
                        $query = $query->whereIn($field, $SearchData);
                        break;
                    case "ni":
                        $query = $query->whereNotIn($field, $SearchData);
                        break;
                    case "lt":
                        $query = $query->where($field,'<', $SearchData); 
                        break;
                    case "le":
                        $query = $query->where($field,'<=', $SearchData); 
                        break;
                    case "gt":
                        $query = $query->where($field,'>', $SearchData); 
                        break;
                    case "ge":
                        $query = $query->where($field,'>=', $SearchData); 
                        break;
                }
            }
            $Record = $query->count();
            //var_dump($Record);
            $DownLoadValue = $query->orderBy( $sidx, 'asc')->get();           
        } 
       
        else
        {     
            
            //dd($Record);
            $DownLoadValue = DB::connection('mysqlbalance')->table($table)->limit(10000)->orderBy($sidx, 'asc')->get();
             
        } 
        //dd($DownLoadValue);
        //$DownLoadValue = $query->orderBy( $sidx, $order)->get();
        //var_dump($DownLoadValue);

        return response()->json([
            //'success' =>  $UpdateValue
            'success' => $DownLoadValue,
            'sss' =>$Record
            
        ]); 
    }

    //此處應包含excel上傳時的新增與更新功能
    public function FileUpload( Request $request )
    {
    
        $uploadData = $request->all();

        $table = '';
        switch ($uploadData["table"]){
            case 'dgAccounts':
                $table = 'container_balance_authority';
                break;
        } 
        $uploadData["UploadData"]["created_at"] = date('Y-m-d H:i:s');
        $uploadData["UploadData"]["updated_at"] = date('Y-m-d H:i:s');

        // $updateData = ProductSPEC::find($uploadData["UploadData"]["id"]);
        $updateData = DB::connection('mysqlbalance')->table($table)->where("id", $uploadData["UploadData"]["id"]);
        $isExist = DB::connection('mysqlbalance')->table($table)->where("id", $uploadData["UploadData"]["id"])->first();

        if(!$isExist)
        {               
            $this->CreateRowData($uploadData["UploadData"], $table);      
        }
        else
        {
            unset($uploadData["UploadData"]["created_at"]);
            $updateData->update($uploadData["UploadData"]);
        } 
        
        return response()->json([
            'success' => $uploadData["UploadData"]["id"],
        ]);
    }

    //刪除方法
    public function destroy(Request $request)
    {   
        $Parameter = $request->all();
        // dd($Parameter);
        $table = '';
        switch ($Parameter["table"]){
            case 'dgAccounts':
                $table = 'container_balance_authority';
                break;
        }
      
        $deleteData = DB::connection('mysqlbalance')->table($table)->delete($Parameter["id"]);
        $UpdateValue = DB::connection('mysqlbalance')->table($table)->orderBy('id','asc')->get(); //回傳原本的資料
        return response()->json([
            //'success' =>  $UpdateValue
            'success' => 'OK'
            
        ]);        
    }

    //新增和修改
    public function AddandUpdate(Request $request)
    {      
        $AddParameter = $request->all();
        

        $table = '';
        switch ($AddParameter["table"]){
            case 'dgAccounts':
                $table = 'container_balance_authority';
                break;
        }
        
        $AddParameter["created_at"] = date('Y-m-d H:i:s');
        $AddParameter["updated_at"] = date('Y-m-d H:i:s');
        //dd($AddParameter["urgent"]);      
        if ($request->oper =='add')
        {   unset($AddParameter["oper"]);
            unset($AddParameter["table"]);  
            $this->CreateRowData($AddParameter, $table);             
            return response()->json([
                'success' => 'Record add successfully!'
            ]);
        }
        else
        {
            unset($AddParameter["oper"]);
            unset($AddParameter["table"]);
            unset($AddParameter["created_at"]);
            $updateData = DB::connection('mysqlbalance')->table($table)->where('id', $request->id);
            $updateData->update($AddParameter);
            return response()->json([
                'success' => 'Record update successfully!'
            ]);
      
        }
    }

     //獲得Authority Groups
     public function GetAuthorityGroup(Request $request)
     {    
        //dd($request);    
        $group_name = DB::connection('mysqlbalance')->table('container_balance_authority')->select('Group_Name')->distinct()->get();
        $Container_Group = DB::connection('mysqlbalance')->table('container_balance_authority')->select('Container_Group')->distinct()->get();
      
        return response()->json([
            'Group_Name' => $group_name,
            'Container_Group' => $Container_Group,
        ]);     
     }

    //回填方法
    public function BackFill($id)
    {    
       
    }

    public function CreateRowData($RowData, $table)
    {
        $todo = DB::connection('mysqlbalance')->table($table)->insert(
            $RowData 
        );
    }

    public function GetAuthority(Request $request)
    {    
        $User = $request->all();    
        $Result = DB::connection('mysqlbalance')->table('container_balance_authority')->
        where('container_balance_authority.User_Account', '=', $User["User"])->get();
        return response()->json([
            'success' => $Result,        
        ]);     
    }

    public function test()
    {
        return view('todo.test',[
            
        ]);  
    }
}
