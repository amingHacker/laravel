<?php

namespace App\Http\Controllers;

use DB;
use Illuminate\Http\Request;
use Validator;

class ContainerRecordController extends Controller
{
    //This is the controller index
    public function index( Request $request )
    {      
        $todosClean = DB::table('container_records_clean')->orderBy('id','desc')->first();
        $todosAssemblingtest = DB::table('container_records_assemblingtest')->orderBy('id','desc')->first();
        $todosOutbound = DB::table('container_records_outbound')->orderBy('id','desc')->first();
        $todosCPD = DB::table('container_records_cpd')->orderBy('id','desc')->first();
        $todosInbound = DB::table('container_records_inbound')->orderBy('id','desc')->first();
        $todosPumppurgetest = DB::table('container_records_pumppurgetest')->orderBy('id','desc')->first();
        $todosRGAtest = DB::table('container_records_rgatest')->orderBy('id','desc')->first();
        $todosHotn2 = DB::table('container_records_hotn2')->orderBy('id','desc')->first();

        return view('Container.ContainerRecord',[
            'todosClean' => $todosClean,
            'todosAssemblingtest' => $todosAssemblingtest,
            'todosOutbound' => $todosOutbound,
            'todosCPD' => $todosCPD,
            'todosInbound' => $todosInbound,
            'todosPumppurgetest'=> $todosPumppurgetest,
            'todosRGAtest'=> $todosRGAtest,
            'todosHotn2'=> $todosHotn2,
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
            case "/ContainerRecord/show/Clean":
                $table = 'container_records_clean';
                break;
            case "/ContainerRecord/show/Assemblingtest":
                $table = 'container_records_assemblingtest';
                break;
            case "/ContainerRecord/show/Outbound":
                $table = 'container_records_outbound';
                break;
            case "/ContainerRecord/show/CPD":
                $table = 'container_records_cpd';
                break;
            case "/ContainerRecord/show/Inbound":
                $table = 'container_records_inbound';
                break;
            case "/ContainerRecord/show/Pumppurgetest":
                $table = 'container_records_pumppurgetest';
                break;
            case "/ContainerRecord/show/RGAtest":
                $table = 'container_records_rgatest';
                break;
            case "/ContainerRecord/show/Hotn2":
                $table = 'container_records_hotn2';
                break;
        }
        // var_dump($_SERVER["REDIRECT_URL"]);

        $query = DB::table($table);

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
            case 'dgClean':
                $table = 'container_records_clean';
                break;
            case 'dgAssemblingtest':
                $table = 'container_records_assemblingtest';
                break;
            case 'dgOutbound':
                $table = 'container_records_outbound';
                break;
            case 'dgCPD':
                $table = 'container_records_cpd';
                break;
            case 'dgInbound':
                $table = 'container_records_inbound';
                break;
            case 'dgPumppurgetest':
                $table = 'container_records_pumppurgetest';
                break;
            case 'dgRGAtest':
                $table = 'container_records_rgatest';
                break;
            case 'dgHotn2':
                $table = 'container_records_hotn2';
                break;
        }

        $_search = $downloadReq["postData"]["_search"];  
        $limit = $downloadReq["postData"]["limit"];
        $sidx = ($downloadReq["postData"]["sidx"] == '')? 'id': $downloadReq["postData"]["sidx"];
        $order = ($downloadReq["postData"]["order"] == '')? 'desc': $downloadReq["postData"]["order"];
        
        $searchGroupOp = ''; $filed = ''; $op = ''; $SearchData = '';
        $Record = '';
        $query = DB::table($table);
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
            $DownLoadValue = $query->orderBy( $sidx, $order)->get();           
        } 
       
        else
        {     
            
            //dd($Record);
            $DownLoadValue = DB::table($table)->limit(10000)->orderBy($sidx,$order)->get();
             
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
            case 'dgClean':
                $table = 'container_records_clean';
                break;
            case 'dgAssemblingtest':
                $table = 'container_records_assemblingtest';
                break;
            case 'dgOutbound':
                $table = 'container_records_outbound';
                break;
            case 'dgCPD':
                $table = 'container_records_cpd';
                break;
            case 'dgInbound':
                $table = 'container_records_inbound';
                break;
            case 'dgPumppurgetest':
                $table = 'container_records_pumppurgetest';
                break;
            case 'dgRGAtest':
                $table = 'container_records_rgatest';
                break;
            case 'dgHotn2':
                $table = 'container_records_hotn2';
                break;
        } 
        $uploadData["UploadData"]["created_at"] = date('Y-m-d H:i:s');
        $uploadData["UploadData"]["updated_at"] = date('Y-m-d H:i:s');

        $updateData = DB::table($table)->where("id", $uploadData["UploadData"]["id"]);
        $isExist = DB::table($table)->where("id", $uploadData["UploadData"]["id"])->first();

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
            case 'dgClean':
                $table = 'container_records_clean';
                break;
            case 'dgAssemblingtest':
                $table = 'container_records_assemblingtest';
                break;
            case 'dgOutbound':
                $table = 'container_records_outbound';
                break;
            case 'dgCPD':
                $table = 'container_records_cpd';
                break;
            case 'dgInbound':
                $table = 'container_records_inbound';
                break;
            case 'dgPumppurgetest':
                $table = 'container_records_pumppurgetest';
                break;
            case 'dgRGAtest':
                $table = 'container_records_rgatest';
                break;
            case 'dgHotn2':
                $table = 'container_records_hotn2';
                break;
        }
      
        $deleteData = DB::table($table)->delete($Parameter["id"]);
        $UpdateValue = DB::table($table)->orderBy('id','asc')->get(); //回傳原本的資料
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
            case 'dgClean':
                $table = 'container_records_clean';
                break;
            case 'dgAssemblingtest':
                $table = 'container_records_assemblingtest';
                break;
            case 'dgOutbound':
                $table = 'container_records_outbound';
                break;
            case 'dgCPD':
                $table = 'container_records_cpd';
                break;
            case 'dgInbound':
                $table = 'container_records_inbound';
                break;
            case 'dgPumppurgetest':
                $table = 'container_records_pumppurgetest';
                break;
            case 'dgRGAtest':
                $table = 'container_records_rgatest';
                break;
            case 'dgHotn2':
                $table = 'container_records_hotn2';
                break;
        }
        
        $AddParameter["created_at"] = date('Y-m-d H:i:s');
        $AddParameter["updated_at"] = date('Y-m-d H:i:s');
        //dd($AddParameter["urgent"]);      
        if ($request->oper =='add')
        {   unset($AddParameter["oper"]);
            unset($AddParameter["table"]);
            unset($AddParameter["caption"]);  
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
            unset($AddParameter["caption"]);
            $updateData = DB::table($table)->where('id', $request->id);
            $updateData->update($AddParameter);
            return response()->json([
                'success' => 'Record update successfully!'
            ]);
      
        }
    }

    //Get Table
    public function GetTable( Request $request )
    {    
        $table = '';
            
        switch ($_SERVER["REDIRECT_URL"])
        {
            case "/ContainerRecord/GetTable/Clean":
                $table = 'container_records_clean';
                break;
            case "/ContainerRecord/GetTable/Assemblingtest":
                $table = 'container_records_assemblingtest';
                break;
            case "/ContainerRecord/GetTable/Outbound":
                $table = 'container_records_outbound';
                break;
            case "/ContainerRecord/GetTable/CPD":
                $table = 'container_records_cpd';
                break;
            case "/ContainerRecord/GetTable/Inbound:
                $table = 'container_records_inbound";
                break;
            case "/ContainerRecord/GetTable/Pumppurgetest":
                $table = 'container_records_pumppurgetest';
                break;
            case "/ContainerRecord/GetTable/RGAtest":
                $table = 'container_records_rgatest';
                break;
            case "/ContainerRecord/GetTable/Hotn2":
                $table = 'container_records_hotn2';
                break;
        }
        
        $product_SPEC= DB::table($table)->get();
    
        return response()->json([
            'product_SPEC' => $product_SPEC,

        ]);  
    }


    //回填方法
    public function BackFill($id)
    {    
       
    }

    public function CreateRowData($RowData, $table)
    {
        $todo = DB::table($table)->insert(
            $RowData 
        );
    }

    public function test()
    {
        return view('todo.test',[
            
        ]);  
    }

    public function ComboboxItem(Request $request)
    {    
        //dd($request);    
        $container_model = DB::table('container_records_model')->select('container_model')->distinct()->get();
        $bottle_number = DB::table('container_records_model')->select('bottle_number')->distinct()->get();
        
        return response()->json([
            'container_model' => $container_model,
            'bottle_number' => $bottle_number,
        ]);     
    }

    //從ID中獲取資料庫相對應的內容
    public function GetDataFromID( Request $request )
    {  
        $table = '';
        switch ($_SERVER["REDIRECT_URL"])
        {
            case "/ContainerRecord/GetDataFromID/Clean":
                $table = 'container_records_clean';
                break;
            case "/ContainerRecord/GetDataFromID/Assemblingtest":
                $table = 'container_records_assemblingtest';
                break;
            case "/ContainerRecord/GetDataFromID/Outbound":
                $table = 'container_records_outbound';
                break;
            case "/ContainerRecord/GetDataFromID/CPD":
                $table = 'container_records_cpd';
                break;
            case "/ContainerRecord/GetDataFromID/Inbound":
                $table = 'container_records_inbound';
                break;
            case "/ContainerRecord/GetDataFromID/Pumppurgetest":
                $table = 'container_records_pumppurgetest';
                break;
            case "/ContainerRecord/GetDataFromID/RGAtest":
                $table = 'container_records_rgatest';
                break;
            case "/ContainerRecord/GetDataFromID/Hotn2":
                $table = 'container_records_hotn2';
                break;
        }
        
        $Data = $request->all();
        $DownLoadValue = [];
        $query = DB::table($table);
        foreach ($Data["postData"] as $i)
        {              
            $query = $query->orwhere('id', '=', $i); 
        }
        $DownLoadValue = $query->orderBy( 'id', 'asc')->get();    
        return response()->json([
            'success' => $DownLoadValue,        
        ]);     
    }
}
