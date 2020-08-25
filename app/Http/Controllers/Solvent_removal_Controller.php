<?php

namespace App\Http\Controllers;

use DB;
use Illuminate\Http\Request;
use App\Solvent_removal;
use Validator;

class Solvent_removal_Controller extends Controller
{
    //This is the controller index
    public function index()
    {    
        $todos = DB::table('solvent_removals')->orderBy('id','desc')->first();
        
        return view('PDMAT.Solvent_removal',[
             'todos' => $todos
        ]);
    }

    //This is the controller show
    public function show( Request $request )
    {      
        //var_dump($request->all());
        $pageInf = $request->all();
        $pageNum = $pageInf["pageNum"];
        $limit = $pageInf["limit"];
        $sidx = ($pageInf["sidx"] == '')? 'id': $pageInf["sidx"];
        $order = ($pageInf["order"] == '')? 'desc': $pageInf["order"];
        //var_dump($pageInf);
        $searchGroupOp = ''; $filed = ''; $op = ''; $SearchData = '';
        $Record = '';
        $query = Solvent_removal::query();
        
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
            $Record = $query->count();
        }
           
        $todos = $query->offset(($pageNum - 1) * $limit )->limit($limit)->orderBy( $sidx, $order)->get();
        $record = Solvent_removal::count();
        if ($Record != ''){$record = $Record;}
        $totalPage = ceil($record / $limit) ;         
    
        return response()->json([
                'dataList'=> $todos,
                'currPage'=> $pageNum,  
                'totalCount'=> $record,
                'totalPages'=> $totalPage,        
            ]);
    }

    //This is the controller Export
    public function Export(Request $request )
    {        
        $downloadReq = $request->all();
        $_search = $downloadReq["postData"]["_search"];  
        $limit = $downloadReq["postData"]["limit"];
        $sidx = ($downloadReq["postData"]["sidx"] == '')? 'id': $downloadReq["postData"]["sidx"];
        $order = ($downloadReq["postData"]["order"] == '')? 'desc': $downloadReq["postData"]["order"];
        
        $searchGroupOp = ''; $filed = ''; $op = ''; $SearchData = '';
        $Record = '';
        $query = Solvent_removal::query();
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
            $DownLoadValue = DB::table('solvent_removals')->limit(10000)->orderBy($sidx, 'asc')->get();
             
        } 
        //dd($DownLoadValue);
        //$DownLoadValue = $query->orderBy( $sidx, $order)->get();
        //var_dump($DownLoadValue);

        return response()->json([
            //'success' =>  $UpdateValue
            'success' => $DownLoadValue,
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

        $Result = $this->CheckColumn($uploadData["UploadData"]);

        if ($Result != '')
        {
            return response()->json([
                'message' => $Result,
            ]);          
        }
        else
        { 
            $updateData = Solvent_removal::find($uploadData["UploadData"]["id"]);
            
            if (array_key_exists("solid_Started", $uploadData["UploadData"])) {
                if ($uploadData["UploadData"]["solid_Started"] ==''){$uploadData["UploadData"]["solid_Started"] = NULL;}
            }
           
            if(!$updateData)
            {
                $this->CreateRowData($uploadData["UploadData"]);
            }
            else
            {
                //以下的欄位不能由upload資料修改，可能會蓋掉原本的欄位
                $uploadData["UploadData"]["Crude_assay"] = $updateData["Crude_assay"];
                $uploadData["UploadData"]["Crude_2_2ppm"] = $updateData["Crude_2_2ppm"];
                $updateData->update($uploadData["UploadData"]);
            }
            return response()->json([
                'success' => $uploadData["UploadData"]["id"],
            ]);    
        }     
    }

    //刪除方法
    public function destroy($id)
    {    
        Solvent_removal::find($id)->delete($id);
        // return response()->json([
        //     'success' => 'Record deleted successfully!'
        // ]);
        //$UpdateValue = DB::table('solvent_removals')->orderBy('id','desc')->get(); //回傳原本的資料
        return response()->json([
            'success' =>  'OK'
            
        ]);              
    }

    //新增和修改
    public function AddandUpdate(Request $request)
    {       
        $AddParameter = $request->all();
        if ($AddParameter["solid_Started"] ==''){$AddParameter["solid_Started"] = NULL;}
           
        if ($request->oper =='add')
        {
            $this->CreateRowData($AddParameter);
            return response()->json([
                'success' => 'Record update successfully!'
            ]);
        }
        else
        {
            $updateData = Solvent_removal::find($request->id);
            $updateData->update($AddParameter);
            return response()->json([
                'success' => 'Record update successfully!'
            ]);
      
        }
    }

    //回填方法
    public function BackFill($id)
    {    
        $RowData = Solvent_removal::find($id);
        //var_dump($RowData["crude_batch"]);
        $_tmp = $RowData["crude_batch"];
        $updateItemSelect = DB::table('sampling_records')->where('batch_number', $_tmp)->first();//得到陣列 
        
        //dd($updateItemSelect->{'2_2ppm'});
        if ($updateItemSelect != null )
        {
            $RowData->update(
                [
                    'Crude_assay' => $updateItemSelect->Assay, 
                    'Crude_2_2ppm' => $updateItemSelect->{'2_2ppm'}, 
                    'updated_at' => date('Y-m-d H:i:s') 
                ]             
            );                 
        }

        //$UpdateValue = DB::table('solvent_removals')->orderBy('id','desc')->get(); //回傳原本的資料
        return response()->json([
            'success' =>  'OK'
            
        ]);       
    }

    public function CreateRowData($RowData)
    {    
        $todo = Solvent_removal::create(
            [                    
                'solid_Started'=> $RowData["solid_Started"],
                'tank_batch' => $RowData["tank_batch"],
                'Crude_assay' => $RowData["Crude_assay"],
                'Crude_2_2ppm' => $RowData["Crude_2_2ppm"],
                'crude_batch' => $RowData["crude_batch"],
                'Line' => $RowData["Line"],
                'sol_expect_wt' => $RowData["sol_expect_wt"],
                'end_Temp' => $RowData["end_Temp"],
                'solvent_Input' => $RowData["solvent_Input"],
                'solid_output' => $RowData["solid_output"],
                'cycle_Time' => $RowData["cycle_Time"],                
                'solid_yield' => $RowData["solid_yield"],
                'output_system_oxygen' => $RowData["output_system_oxygen"],
                'glove_box' => $RowData["glove_box"],
                'output_time_spent' => $RowData["output_time_spent"],
                'solid_consumed_1' => $RowData["solid_consumed_1"],
                'solid_consumed_2' => $RowData["solid_consumed_2"],
                'solid_consumed_3' => $RowData["solid_consumed_3"],
                'solid_consumed_4' => $RowData["solid_consumed_4"],
                'solid_consumed_5' => $RowData["solid_consumed_5"],             
            ]    
        );  
    }

    //檢查丟進來的檔案是否正確
    public function CheckColumn($RowData)
    {
        $Result = '';
        $dbCol = [
            'id',
            'solid_Started',
            'tank_batch' ,
            'Crude_assay',
            'Crude_2_2ppm',
            'crude_batch',
            'Line',
            'sol_expect_wt',
            'end_Temp',
            'solvent_Input',
            'solid_output',
            'cycle_Time',                
            'solid_yield',
            'output_system_oxygen',
            'glove_box',
            'output_time_spent',
            'solid_consumed_1',
            'solid_consumed_2',
            'solid_consumed_3',
            'solid_consumed_4',
            'solid_consumed_5',
            '建立時間',
            '更新時間'            
        ];

        foreach ($RowData as $i => $value)
        {
            if (!in_array($i, $dbCol))
            {
                $Result .= (string)$i . ',';
            }
        }
        
        return $Result;
    }

    public function test()
    {
        return view('todo.test',[
            
        ]);  
    }
    public function ComboboxItem(Request $request)
    {    
        //dd($request);    
        $Line = DB::table('solvent_removals')->select('Line')->distinct()->get();
        $glove_box = DB::table('solvent_removals')->select('glove_box')->distinct()->get();
       
      
        return response()->json([
            //'success' => $todos,
            'Line' => $Line,
            'glove_box' => $glove_box,
        ]);     
    }

    //從ID中獲取資料庫相對應的內容
    public function GetDataFromID( Request $request )
    {    
        $Data = $request->all();
        $DownLoadValue = [];
        $query = DB::table("solvent_removals");
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
