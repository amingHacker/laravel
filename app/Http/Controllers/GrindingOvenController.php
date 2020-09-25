<?php

namespace App\Http\Controllers;

use DB;
use Illuminate\Http\Request;
use App\GrindingOven;
use Validator;

class GrindingOvenController extends Controller
{
    //This is the controller index
    public function index()
    {        
        $todos = DB::table('grindingovens')->orderBy('id','desc')->first();
    
        return view('PDMAT.GrindingOven',[
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
        $query = GrindingOven::query();
        
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
        $record = GrindingOven::count();
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
        $query = GrindingOven::query();
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
            $DownLoadValue = DB::table('grindingovens')->limit(10000)->orderBy($sidx,'asc')->get();
             
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

        $Result = $this->CheckColumn($uploadData["UploadData"]);

        if ($Result != '')
        {
            return response()->json([
                'message' => $Result,
            ]);          
        }

        else
        {
            $updateData = GrindingOven::find($uploadData["UploadData"]["id"]);
            if (array_key_exists("Filling_Date", $uploadData["UploadData"])) {
                if ($uploadData["UploadData"]["Filling_Date"] ==''){$uploadData["UploadData"]["Filling_Date"] = NULL;}
            }
            if ($uploadData["UploadData"]["Filling_Date"] ==''){$uploadData["UploadData"]["Filling_Date"] = NULL;}

            
            if(!$updateData)
            {                  
                $this->CreateRowData($uploadData["UploadData"]);            
            }
            else
            {
                $updateData->update($uploadData["UploadData"]);
            }

            return response()->json([
                'success' => $uploadData["UploadData"]["id"],
                'count' =>$uploadData["count"]
            ]);
        }
    }

    //刪除方法
    public function destroy($id)
    {    
        GrindingOven::find($id)->delete($id);
        // return response()->json([
        //     'success' => 'Record deleted successfully!'
        // ]);
        //$UpdateValue = DB::table('grindingovens')->orderBy('id','desc')->get(); //回傳原本的資料
        return response()->json([
            'success' =>  'OK'
            
        ]);              
    }

    //新增和修改
    public function AddandUpdate(Request $request)
    {     
        $AddParameter = $request->all();
        if ($AddParameter["Filling_Date"] ==''){$AddParameter["Filling_Date"] = NULL;}
           
        if ($request->oper =='add')
        {
            $this->CreateRowData($AddParameter); 
            
            return response()->json([
                'success' => 'Record add successfully!'
            ]);
        }
        else
        {
            $updateData = GrindingOven::find($request->id);
            $updateData->update($AddParameter);
            return response()->json([
                'success' => 'Record update successfully!'
            ]);
      
        }
    }

    //回填方法
    public function BackFill(Request $request)
    {   
        $Parameter = $request->all(); 
        $RowData = GrindingOven::find($Parameter["id"]);
        //var_dump($RowData["crude_batch"]);
        $_tmp = $RowData["sap_batch"];
        $updateItemSelect = DB::table('sampling_records')->where('batch_number', $_tmp)->get();//得到陣列 
        

        //update sap batch
        $updateAssay = ''; $updateMeO = '';

        foreach($updateItemSelect as $_tmp)
        {
            if($_tmp->Assay != '')
            {
                $updateAssay = $_tmp->Assay;
            }
            if($_tmp->MeO != '')
            {
                $updateMeO = $_tmp->MeO;
            }
            //var_dump($_tmp->Assay);
            //var_dump($_tmp->MeO);
        }
        //var_dump($updateAssay);
        //var_dump($updateMeO);
        //dd($updateItemSelect);

        //update bulk batch 的assay, meo
        $t1 = DB::table('sublimations')->where('bulk_batch', $RowData["1st_bulk_batch"])->where('judge', 'Pass')->first();//得到陣列
        $t2 = DB::table('sublimations')->where('bulk_batch', $RowData["2nd_bulk_batch"])->where('judge', 'Pass')->first();//得到陣列
        $t3 = DB::table('sublimations')->where('bulk_batch', $RowData["3rd_bulk_batch"])->where('judge', 'Pass')->first();//得到陣列

        $t1_bulk_actual_assay = ''; $t2_bulk_actual_assay = ''; $t3_bulk_actual_assay = '';
        $t1_bulk_actual_meo = ''; $t2_bulk_actual_meo = ''; $t3_bulk_actual_meo = '';

        //先清空
        $RowData->update(
            [
                'sap_batch_actual_assay' => '', 
                'sap_batch_actual_meo' =>  '',
                '1st_bulk_assay' => '',
                '1st_bulk_meo' => '',
                '2nd_bulk_assay' => '',
                '2nd_bulk_meo' => '',
                '3rd_bulk_assay' => '',
                '3rd_bulk_meo' => '',
            ]             
        );         
        
        //dd($updateItemSelect->{'2_2ppm'});
        if ($updateItemSelect != null )
        {
            $RowData->update(
                [
                    'sap_batch_actual_assay' => $updateAssay, 
                    'sap_batch_actual_meo' =>  $updateMeO,
                    //'updated_at' => date('Y-m-d H:i:s') 
                ]             
            );                 
        }
        if ($t1 != null)
        {
            $RowData->update(
                [
                    '1st_bulk_assay' => $t1->bulk_actual_assay,
                    '1st_bulk_meo' => $t1->bulk_actual_meo,
                ]             
            );
            $t1_bulk_actual_assay =  $t1->bulk_actual_assay;
            $t1_bulk_actual_meo =  $t1->bulk_actual_meo;            
        }
        if ($t2 != null)
        {
            $RowData->update(
                [
                    '2nd_bulk_assay' => $t2->bulk_actual_assay,
                    '2nd_bulk_meo' => $t2->bulk_actual_meo,
                ]             
            );
            $t2_bulk_actual_assay =  $t2->bulk_actual_assay;
            $t2_bulk_actual_meo =  $t2->bulk_actual_meo;            
        }
        if ($t3 != null)
        {
            $RowData->update(
                [
                    '3rd_bulk_assay' => $t3->bulk_actual_assay,
                    '3rd_bulk_meo' => $t3->bulk_actual_meo,
                ]             
            );
            $t3_bulk_actual_assay =  $t3->bulk_actual_assay;
            $t3_bulk_actual_meo =  $t3->bulk_actual_meo;            
        }

        //expect assay, expect meo 
        //$update_expect_assay
        //$update_expect_meo
        $update_expect_assay = ''; $update_expect_meo = '';
        $percent_1 = ''; $percent_2 = ''; $percent_3 = '';

        if ($RowData["1st_bulk_wt"] !='' && $RowData["PDMAT_g"] !=''){
            $percent_1 = (float)$RowData["1st_bulk_wt"] / (float)$RowData["PDMAT_g"];
        }
        if ($RowData["2nd_bulk_wt"] !='' && $RowData["PDMAT_g"] !=''){
            $percent_2 = (float)$RowData["2nd_bulk_wt"] / (float)$RowData["PDMAT_g"];
        }
        if ($RowData["3rd_bulk_wt"] !='' && $RowData["PDMAT_g"] !=''){
            $percent_3 = (float)$RowData["3rd_bulk_wt"] / (float)$RowData["PDMAT_g"];
        }

        $update_expect_assay = (float)$percent_1 * (float)$t1_bulk_actual_assay 
                                +(float)$percent_2 * (float)$t2_bulk_actual_assay 
                                +(float)$percent_3 * (float)$t3_bulk_actual_assay;
        $update_expect_meo =  (float)$percent_1 *  (float)trim($t1_bulk_actual_meo, '<') 
                                +(float)$percent_2 *  (float)trim($t2_bulk_actual_meo, '<')
                                +(float)$percent_3 *  (float)trim($t3_bulk_actual_meo, '<');
        $update_expect_assay = round($update_expect_assay, 2);
        $update_expect_meo = round($update_expect_meo, 2);     

        $RowData->update(
            [
                'expect_assay' => $update_expect_assay,
                'expect_meo' => $update_expect_meo,
            ]             
        );         


        // $UpdateValue = DB::table('grindingovens')->orderBy('id','desc')->get(); //回傳原本的資料
        return response()->json([
            'success' => $Parameter["count"]      
        ]);       
    }

    public function CreateRowData($RowData)
    {

        $todo = GrindingOven::create(
            [                    
                'Filling_Date'=> $RowData["Filling_Date"],
                'sap_batch' => $RowData["sap_batch"],
                'sap_batch_actual_assay' => $RowData["sap_batch_actual_assay"],
                'sap_batch_actual_meo' => $RowData["sap_batch_actual_meo"],
                'Op' => $RowData["Op"],
                'serial_number' => $RowData["serial_number"],
                'Main_bubbler_tank' => $RowData["Main_bubbler_tank"],
                '1st_bulk_batch' => $RowData["1st_bulk_batch"],
                '1st_bulk_wt' => $RowData["1st_bulk_wt"],
                '1st_tank_batch' => $RowData["1st_tank_batch"],                    
                '2nd_bulk_batch' => $RowData["2nd_bulk_batch"],
                '2nd_bulk_wt' => $RowData["2nd_bulk_wt"],
                '2nd_tank_batch' => $RowData["2nd_tank_batch"],
                '3rd_bulk_batch' => $RowData["3rd_bulk_batch"],
                '3rd_bulk_wt' => $RowData["3rd_bulk_wt"],
                '3rd_tank_batch' => $RowData["3rd_tank_batch"],
                '1st_bulk_assay' => $RowData["1st_bulk_assay"],
                '1st_bulk_meo' => $RowData["1st_bulk_meo"],
                '2nd_bulk_assay' => $RowData["2nd_bulk_assay"],
                '2nd_bulk_meo' => $RowData["2nd_bulk_meo"],
                '3rd_bulk_assay' => $RowData["3rd_bulk_assay"],
                '3rd_bulk_meo' => $RowData["3rd_bulk_meo"],
                'expect_assay' => $RowData["expect_assay"],
                'expect_meo' => $RowData["expect_meo"],
                'PDMAT_g' => $RowData["PDMAT_g"],
                's_75um' => $RowData["s_75um"],                  
                'grinding_time_h' => $RowData["grinding_time_h"],                
                'glove_box' => $RowData["glove_box"],
                'input_system_oxygen' => $RowData["input_system_oxygen"],
                'output_system_oxygen' => $RowData["output_system_oxygen"],
                'input_system_moisture' => $RowData["input_system_moisture"],
                'output_system_moisture' => $RowData["output_system_moisture"],
                'Q_Time' => $RowData["Q_Time"],
                'Oven' => $RowData["Oven"],
                'anneal_seat' => $RowData["anneal_seat"],
                '0_0_ppm' => $RowData["0_0_ppm"],                 
                'Remark' => $RowData["Remark"],
                'Material' => $RowData["Material"],
                'pressure_Drop_Via_bypass' => $RowData["pressure_Drop_Via_bypass"],
                'pressure_Drop_Via_body' => $RowData["pressure_Drop_Via_body"],                  
            ]    
        );
    }

    
    //檢查丟進來的檔案是否正確
    public function CheckColumn($RowData)
    {
        $Result = '';
        $dbCol = [
            'id',
            'Filling_Date',
            'sap_batch',
            'sap_batch_actual_assay',
            'sap_batch_actual_meo',
            'Op',
            'serial_number',
            'Main_bubbler_tank',
            '1st_bulk_batch',
            '1st_bulk_wt',
            '1st_tank_batch',                    
            '2nd_bulk_batch',
            '2nd_bulk_wt',
            '2nd_tank_batch',
            '3rd_bulk_batch',
            '3rd_bulk_wt',
            '3rd_tank_batch',
            '1st_bulk_assay',
            '1st_bulk_meo',
            '2nd_bulk_assay',
            '2nd_bulk_meo',
            '3rd_bulk_assay',
            '3rd_bulk_meo',
            'expect_assay',
            'expect_meo',
            'PDMAT_g',
            's_75um',                  
            'grinding_time_h',                
            'glove_box',
            'input_system_oxygen',
            'output_system_oxygen',
            'input_system_moisture',
            'output_system_moisture',
            'Q_Time',
            'Oven',
            'anneal_seat',
            '0_0_ppm',                 
            'Remark',
            'Material',
            'pressure_Drop_Via_bypass',
            'pressure_Drop_Via_body',          
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
        $Op = DB::table('grindingovens')->select('Op')->distinct()->get();
        $glove_box = DB::table('grindingovens')->select('glove_box')->distinct()->get();
        $Oven = DB::table('grindingovens')->select('Oven')->distinct()->get();
        $Material = DB::table('grindingovens')->select('Material')->distinct()->get();
    
        return response()->json([   
           'Op' => $Op,
           'glove_box' => $glove_box,
           'Oven' => $Oven,
           'Material' => $Material,
        ]);     
    }

    //從ID中獲取資料庫相對應的內容
    public function GetDataFromID( Request $request )
    {    
        $Data = $request->all();
        $DownLoadValue = [];
        $query = DB::table("grindingovens");
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
