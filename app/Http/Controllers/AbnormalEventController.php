<?php

namespace App\Http\Controllers;

use DB;
use Illuminate\Http\Request;
// use App\ProductSPEC;
use Validator;

class AbnormalEventController extends Controller
{
    //This is the controller index
    public function index( Request $request )
    {      
        $sampling_records_abnormalevent = DB::table('sampling_records_abnormalevent')->orderBy('id','desc')->first();
      
        return view('SamplingRecord.AbnormalEvent',[
            'sampling_records_abnormalevent' => $sampling_records_abnormalevent,
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
            case "/AbnormalEvent/show/sampling_records_abnormalevent":
                $table = 'sampling_records_abnormalevent';
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
            case 'dgsampling_records_abnormalevent':
                $table = 'sampling_records_abnormalevent';
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
            $DownLoadValue = $query->orderBy( $sidx, 'asc')->get();           
        } 
       
        else
        {     
            
            //dd($Record);
            $DownLoadValue = DB::table($table)->limit(10000)->orderBy($sidx, 'asc')->get();
             
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
      
            case 'dgsampling_records_abnormalevent':
                $table = 'sampling_records_abnormalevent';
                break;
        } 
        $uploadData["UploadData"]["created_at"] = date('Y-m-d H:i:s');
        $uploadData["UploadData"]["updated_at"] = date('Y-m-d H:i:s');

        // $updateData = ProductSPEC::find($uploadData["UploadData"]["id"]);
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
            case 'dgsampling_records_abnormalevent':
                $table = 'sampling_records_abnormalevent';
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
            case 'dgsampling_records_abnormalevent':
                $table = 'sampling_records_abnormalevent';
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
            if($AddParameter["PD_Comment"] != '')
            {
                $AddParameter["Status"] = '已解決';
            }
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
            case "/AbnormalEvent/GetTable/sampling_records_abnormalevent":
                $table = 'sampling_records_abnormalevent';
                break;
        }
        
        $product_SPEC= DB::table($table)->get();
    
      
        return response()->json([
            'sampling_records_abnormalevent' => $sampling_records_abnormalevent,

        ]);  
    }

    public function GetComboboxItem(Request $request)
    {    
        //dd($request);    
        $Status = DB::table('sampling_records_abnormalevent')->select('Status')->distinct()->get();
        $QC_USER = DB::table('sampling_records_abnormalevent')->select('QC_USER')->distinct()->get();
        $PD_USER = DB::table('sampling_records_abnormalevent')->select('PD_USER')->distinct()->get();
        
      
        return response()->json([
            'Status' => $Status,
            'QC_USER' => $QC_USER,
            'PD_USER' => $PD_USER,
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
}
