<?php

namespace App\Http\Controllers;

use DB;
use Illuminate\Http\Request;
use App\Sublimation;
use Validator;

class SublimationController extends Controller
{
    //This is the controller index
    public function index()
    {        
        $todos = DB::table('sublimations')->orderBy('id','desc')->first();
    
        return view('PDMAT.Sublimation',[
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
         $query = Sublimation::query();
         
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
         $record = Sublimation::count();
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
        $query = Sublimation::query();
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
            $DownLoadValue = DB::table('sublimations')->limit(10000)->orderBy($sidx, 'asc')->get();
             
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
            $updateData = Sublimation::find($uploadData["UploadData"]["id"]);
            if ($uploadData["UploadData"]["bulk_started"] ==''){$uploadData["UploadData"]["bulk_started"] = NULL;}
        
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
            ]);
        }
    }

    //刪除方法
    public function destroy($id)
    {    
        Sublimation::find($id)->delete($id);
        // return response()->json([
        //     'success' => 'Record deleted successfully!'
        // ]);
        //$UpdateValue = DB::table('sublimations')->orderBy('id','desc')->get(); //回傳原本的資料
        return response()->json([
            'success' =>  'OK'
            
        ]);              
    }

    //新增和修改
    public function AddandUpdate(Request $request)
    {   
        $AddParameter = $request->all();
        if ($AddParameter["bulk_started"] ==''){$AddParameter["bulk_started"] = NULL;}
           
        if ($request->oper =='add')
        {
            $this->CreateRowData($AddParameter);  
            return response()->json([
                'success' => 'Record add successfully!'
            ]);
        }
        else
        {
            $updateData = Sublimation::find($request->id);
            $updateData->update($AddParameter);
            return response()->json([
                'success' => 'Record update successfully!'
            ]);
      
        }
    }

    //回填方法
    public function BackFill($id)
    {    
        $RowData = Sublimation::find($id);  
        //var_dump($RowData["crude_batch"]);
        $_tmp = $RowData["bulk_batch"];

       
        //分成檢查judge是否為Pass or Fail
        //judge為fail

        $updateItemSelect = DB::table('sampling_records')->where('batch_number', $_tmp)->get();//得到陣列 
        
        $updateAssay = ''; $updateMeO = '';
        $updateFailAssay = ''; $updateFailMeO = ''; 

        //先整理從Sampling Records紀錄的資料，再進一步判斷要如何更新資料
        foreach($updateItemSelect as $_tmp)
        {

            if ($_tmp->determination == 'Fail')
            {
                if ($_tmp->Assay != '')
                {
                    $updateFailAssay = $_tmp->Assay;
                }

                if($_tmp->MeO != '')
                {
                    $updateFailMeO = $_tmp->MeO;
                }

            }

            else if ( $_tmp->determination == 'Pass')
            {
                if($_tmp->Assay != '')
                {
                    $updateAssay = $_tmp->Assay;
                }
                if($_tmp->MeO != '')
                {
                    $updateMeO = $_tmp->MeO;
                }
            }
            else
            {


            }
        }
        //var_dump($updateItemSelect);      
        //dd($updateItemSelect->{'2_2ppm'});
        // var_dump($updateAssay);
        // var_dump($updateMeO);
        // var_dump($updateFailAssay);
        // var_dump($updateFailMeO);

        //從使用者的角度來思考
        $Assay_MeO = DB::table('sublimations')->
                    where('1st_crude_batch', $RowData["1st_crude_batch"])->where('1st_tank_batch', $RowData["1st_tank_batch"])->
                    where('2nd_crude_batch', $RowData["2nd_crude_batch"])->where('2nd_tank_batch', $RowData["2nd_tank_batch"])->
                    where('bulk_batch', $RowData["bulk_batch"])->
                    where('bulk_actual_assay', $updateAssay)->where('bulk_actual_meo', $updateMeO)->
                    get();
    
        $FailAssay_MeO = DB::table('sublimations')->
                    where('1st_crude_batch', $RowData["1st_crude_batch"])->where('1st_tank_batch', $RowData["1st_tank_batch"])->
                    where('2nd_crude_batch', $RowData["2nd_crude_batch"])->where('2nd_tank_batch', $RowData["2nd_tank_batch"])->
                    where('bulk_batch', $RowData["bulk_batch"])->
                    where('bulk_actual_assay', $updateFailAssay)->where('bulk_actual_meo', $updateMeO)->
                    get();
        
        $Assay_FailMeO = DB::table('sublimations')->
                    where('1st_crude_batch', $RowData["1st_crude_batch"])->where('1st_tank_batch', $RowData["1st_tank_batch"])->
                    where('2nd_crude_batch', $RowData["2nd_crude_batch"])->where('2nd_tank_batch', $RowData["2nd_tank_batch"])->
                    where('bulk_batch', $RowData["bulk_batch"])->
                    where('bulk_actual_assay', $updateAssay)->where('bulk_actual_meo', $updateFailMeO)->
                    get();
        
        $FailAssay_FailMeO = DB::table('sublimations')->
                    where('1st_crude_batch', $RowData["1st_crude_batch"])->where('1st_tank_batch', $RowData["1st_tank_batch"])->
                    where('2nd_crude_batch', $RowData["2nd_crude_batch"])->where('2nd_tank_batch', $RowData["2nd_tank_batch"])->
                    where('bulk_batch', $RowData["bulk_batch"])->
                    where('bulk_actual_assay', $updateFailAssay)->where('bulk_actual_meo', $updateFailMeO)->
                    get();
        
        // var_dump($Assay_MeO );
        // var_dump($FailAssay_MeO );
        // var_dump($Assay_FailMeO );
        // var_dump($FailAssay_FailMeO );
        
        
        //Condition 1: Assay != '', Meo != '', AssayFail == '', MeoFail != ''
        if ($updateAssay !='' && $updateMeO != '' && $updateFailAssay=='' && $updateFailMeO !='')
        {
            //Pass資料就是目前點擊的同一筆資料
            if($RowData["judge"] == 'Pass' )
            {
                //若SamplingRecord那邊的資料有變更, 此筆資料應該也要同動
                $RowData->update(
                    [
                        'bulk_actual_assay' => $updateAssay, 
                        'bulk_actual_meo' =>  $updateMeO,
                    ]             
                );

                if ($Assay_FailMeO->isEmpty() == true)
                {
                    //若是空的，先找是否有存在Fail:MeO的資料，若有則更新，若無則新增
                    $Assay_FailMeO = DB::table('sublimations')->
                    where('1st_crude_batch', $RowData["1st_crude_batch"])->where('1st_tank_batch', $RowData["1st_tank_batch"])->
                    where('2nd_crude_batch', $RowData["2nd_crude_batch"])->where('2nd_tank_batch', $RowData["2nd_tank_batch"])->
                    where('bulk_batch', $RowData["bulk_batch"])->
                    where('judge', 'Fail:MeO')->get();
                    //var_dump($Assay_FailMeO[0]->id);
                    if($Assay_FailMeO->isEmpty() == false)
                    {
                        $tmp = Sublimation::find($Assay_FailMeO[0]->id); 
                        $tmp ->update(
                            [
                                'bulk_actual_assay' =>$updateAssay,
                                'bulk_actual_meo' =>  $updateFailMeO,
                            ]
                        );
                    }

                    else
                    {
                        $RowData["bulk_actual_assay"] = $updateAssay;
                        $RowData["bulk_actual_meo"] = $updateFailMeO;
                        $RowData["judge"] = 'Fail:MeO';        
                        $this->CreateRowData($RowData);
                    }
                    
                }
            }
            //if($RowData["judge"] == 'Fail:MeO')
            if(strpos($RowData["judge"],'Fail') !== false)
            {
                 //若SamplingRecord那邊的資料有變更, 此筆資料應該也要同動
                 $RowData->update(
                    [
                        'bulk_actual_assay' => $updateAssay, 
                        'bulk_actual_meo' =>  $updateFailMeO,
                        'judge' => 'Fail:MeO', 
                    ]             
                );

                if ($Assay_MeO->isEmpty() == true)
                {
                    //若是空的，先找是否有存在Pass的資料，若有則更新，若無則新增
                    $Assay_MeO = DB::table('sublimations')->
                    where('1st_crude_batch', $RowData["1st_crude_batch"])->where('1st_tank_batch', $RowData["1st_tank_batch"])->
                    where('2nd_crude_batch', $RowData["2nd_crude_batch"])->where('2nd_tank_batch', $RowData["2nd_tank_batch"])->
                    where('bulk_batch', $RowData["bulk_batch"])->
                    where('judge', 'Pass')->get();
                    if($Assay_MeO->isEmpty() == false)
                    {
                        $tmp = Sublimation::find($Assay_MeO[0]->id); 
                        $tmp ->update(
                            [
                                'bulk_actual_assay' =>$updateAssay,
                                'bulk_actual_meo' =>  $updateMeO,
                            ]
                        );
                    }
                    else
                    {
                        $RowData["bulk_actual_assay"] = $updateAssay;
                        $RowData["bulk_actual_meo"] = $updateMeO;
                        $RowData["judge"] = 'Pass';        
                        $this->CreateRowData($RowData);
                    }              
                }
            }
            if($RowData["judge"] == '')
            {
                if($Assay_MeO->isEmpty() == true && $Assay_FailMeO->isEmpty() == true)
                {
                    $RowData->update(
                        [
                            'bulk_actual_assay' => $updateAssay, 
                            'bulk_actual_meo' =>  $updateMeO,
                            'judge' =>'Pass', 
                        ]             
                    );
                    
                    $RowData["bulk_actual_assay"] = $updateAssay;
                    $RowData["bulk_actual_meo"] = $updateFailMeO;
                    $RowData["judge"] = 'Fail:MeO';        
                    $this->CreateRowData($RowData);
                }
                if($Assay_MeO->isEmpty() == false && $Assay_FailMeO->isEmpty() == true)
                {
                    $RowData->update(
                        [
                            'bulk_actual_assay' => $updateAssay, 
                            'bulk_actual_meo' =>  $updateMeO,
                            'judge' =>'Fail:MeO', 
                        ]             
                    );
                }
                if($Assay_MeO->isEmpty() == true && $Assay_FailMeO->isEmpty() == false)
                {
                    $RowData->update(
                        [
                            'bulk_actual_assay' => $updateAssay, 
                            'bulk_actual_meo' =>  $updateMeO,
                            'judge' =>'Pass', 
                        ]             
                    );
                }
            }         
        }

        //Condition 2: Assay != '', Meo != '', AssayFail != '', MeoFail ==''
        if ($updateAssay !='' && $updateMeO != '' && $updateFailAssay !='' && $updateFailMeO =='')
        {
            //Pass資料就是目前點擊的同一筆資料
            if($RowData["judge"] == 'Pass' )
            {
                //若SamplingRecord那邊的資料有變更, 此筆資料應該也要同動
                $RowData->update(
                    [
                        'bulk_actual_assay' => $updateAssay, 
                        'bulk_actual_meo' =>  $updateMeO,
                    ]             
                );

                if ($FailAssay_MeO->isEmpty() == true)
                {
                    //若是空的，先找是否有存在Fail:Assay的資料，若有則更新，若無則新增
                    $FailAssay_MeO = DB::table('sublimations')->
                    where('1st_crude_batch', $RowData["1st_crude_batch"])->where('1st_tank_batch', $RowData["1st_tank_batch"])->
                    where('2nd_crude_batch', $RowData["2nd_crude_batch"])->where('2nd_tank_batch', $RowData["2nd_tank_batch"])->
                    where('bulk_batch', $RowData["bulk_batch"])->
                    where('judge', 'Fail:Assay')->get();
                    //var_dump($FailAssay_MeO[0]->id);
                    if($FailAssay_MeO->isEmpty() == false)
                    {
                        $tmp = Sublimation::find($FailAssay_MeO[0]->id); 
                        $tmp ->update(
                            [
                                'bulk_actual_assay' =>$updateFailAssay,
                                'bulk_actual_meo' =>  $updateMeO,
                            ]
                        );
                    }
                    else
                    {
                        $RowData["bulk_actual_assay"] = $updateFailAssay;
                        $RowData["bulk_actual_meo"] = $updateMeO;
                        $RowData["judge"] = 'Fail:Assay';        
                        $this->CreateRowData($RowData);
                    }
                }
            }
            //if($RowData["judge"] == 'Fail:Assay')
            if (strpos($RowData["judge"],'Fail') !== false)
            {
                //若SamplingRecord那邊的資料有變更, 此筆資料應該也要同動
                $RowData->update(
                    [
                        'bulk_actual_assay' => $updateFailAssay, 
                        'bulk_actual_meo' =>  $updateMeO,
                        'judge' =>'Fail:Assay',
                    ]             
                );

                if ($Assay_MeO->isEmpty() == true)
                {
                    //若是空的，先找是否有存在Pass的資料，若有則更新，若無則新增
                    $Assay_MeO = DB::table('sublimations')->
                    where('1st_crude_batch', $RowData["1st_crude_batch"])->where('1st_tank_batch', $RowData["1st_tank_batch"])->
                    where('2nd_crude_batch', $RowData["2nd_crude_batch"])->where('2nd_tank_batch', $RowData["2nd_tank_batch"])->
                    where('bulk_batch', $RowData["bulk_batch"])->
                    where('judge', 'Pass')->get();
                    if($Assay_MeO->isEmpty() == false)
                    {
                        $tmp = Sublimation::find($Assay_MeO[0]->id); 
                        $tmp ->update(
                            [
                                'bulk_actual_assay' =>$updateAssay,
                                'bulk_actual_meo' =>  $updateMeO,
                            ]
                        );
                    }
                    else
                    {
                        $RowData["bulk_actual_assay"] = $updateAssay;
                        $RowData["bulk_actual_meo"] = $updateMeO;
                        $RowData["judge"] = 'Pass';        
                        $this->CreateRowData($RowData);
                    }
                }
            }
            if($RowData["judge"] == '')
            {
                if($Assay_MeO->isEmpty() == true && $FailAssay_MeO->isEmpty() == true)
                {
                    $RowData->update(
                        [
                            'bulk_actual_assay' => $updateAssay, 
                            'bulk_actual_meo' =>  $updateMeO,
                            'judge' =>'Pass', 
                        ]             
                    );
                    
                    $RowData["bulk_actual_assay"] = $updateFailAssay;
                    $RowData["bulk_actual_meo"] = $updateMeO;
                    $RowData["judge"] = 'Fail:Assay';        
                    $this->CreateRowData($RowData);
                }
                if($Assay_MeO->isEmpty() == false && $FailAssay_MeO->isEmpty() == true)
                {
                    $RowData->update(
                        [
                            'bulk_actual_assay' => $updateFailAssay, 
                            'bulk_actual_meo' =>  $updateMeO,
                            'judge' =>'Fail:Assay', 
                        ]             
                    );
                }
                if($Assay_MeO->isEmpty() == true && $FailAssay_MeO->isEmpty() == false)
                {
                    $RowData->update(
                        [
                            'bulk_actual_assay' => $updateAssay, 
                            'bulk_actual_meo' =>  $updateMeO,
                            'judge' =>'Pass', 
                        ]             
                    );
                }
            }  
        }


        //Condition 3: Assay != '', Meo != '', AssayFail != '', MeoFail !='' 
        if ($updateAssay !='' && $updateMeO != '' && $updateFailAssay !='' && $updateFailMeO !='')
        {
            //Pass資料就是目前點擊的同一筆資料
            if($RowData["judge"] == 'Pass' )
            {
                //若SamplingRecord那邊的資料有變更, 此筆資料應該也要同動
                $RowData->update(
                    [
                        'bulk_actual_assay' => $updateAssay, 
                        'bulk_actual_meo' =>  $updateMeO,
                    ]             
                );
                if ($FailAssay_FailMeO->isEmpty() == true)
                {
                    //若是空的，先找是否有存在Fail:Assay, MeO的資料，若有則更新，若無則新增
                    $FailAssay_FailMeO = DB::table('sublimations')->
                    where('1st_crude_batch', $RowData["1st_crude_batch"])->where('1st_tank_batch', $RowData["1st_tank_batch"])->
                    where('2nd_crude_batch', $RowData["2nd_crude_batch"])->where('2nd_tank_batch', $RowData["2nd_tank_batch"])->
                    where('bulk_batch', $RowData["bulk_batch"])->
                    where('judge', 'Fail:Assay, MeO')->get();
                    if($FailAssay_FailMeO->isEmpty() == false)
                    {
                        $tmp = Sublimation::find($FailAssay_FailMeO[0]->id); 
                        $tmp ->update(
                            [
                                'bulk_actual_assay' =>$updateFailAssay,
                                'bulk_actual_meo' =>  $updateFailMeO,
                            ]
                        );
                    }
                    else
                    {
                        $RowData["bulk_actual_assay"] = $updateFailAssay;
                        $RowData["bulk_actual_meo"] = $updateFailMeO;
                        $RowData["judge"] = 'Fail:Assay, MeO';        
                        $this->CreateRowData($RowData);
                    }
                }
            }
            //if($RowData["judge"] == 'Fail:Assay, MeO')
            if (strpos($RowData["judge"],'Fail') !== false)
            {
                //若SamplingRecord那邊的資料有變更, 此筆資料應該也要同動
                $RowData->update(
                    [
                        'bulk_actual_assay' => $updateFailAssay, 
                        'bulk_actual_meo' =>  $updateFailMeO,
                        'judge' => 'Fail:Assay, MeO',
                    ]             
                );
                if ($Assay_MeO->isEmpty() == true)
                {
                    //若是空的，先找是否有存在Pass的資料，若有則更新，若無則新增
                    $Assay_MeO = DB::table('sublimations')->
                    where('1st_crude_batch', $RowData["1st_crude_batch"])->where('1st_tank_batch', $RowData["1st_tank_batch"])->
                    where('2nd_crude_batch', $RowData["2nd_crude_batch"])->where('2nd_tank_batch', $RowData["2nd_tank_batch"])->
                    where('bulk_batch', $RowData["bulk_batch"])->
                    where('judge', 'Pass')->get();
                    if($Assay_MeO->isEmpty() == false)
                    {
                        $tmp = Sublimation::find($Assay_MeO[0]->id); 
                        $tmp ->update(
                            [
                                'bulk_actual_assay' =>$updateAssay,
                                'bulk_actual_meo' =>  $updateMeO,
                            ]
                        );
                    }
                    else
                    {
                        $RowData["bulk_actual_assay"] = $updateAssay;
                        $RowData["bulk_actual_meo"] = $updateMeO;
                        $RowData["judge"] = 'Pass';        
                        $this->CreateRowData($RowData);
                    }
                }
            }
            if($RowData["judge"] == '')
            {
                if($Assay_MeO->isEmpty() == true && $FailAssay_FailMeO->isEmpty() == true)
                {
                    $RowData->update(
                        [
                            'bulk_actual_assay' => $updateAssay, 
                            'bulk_actual_meo' =>  $updateMeO,
                            'judge' =>'Pass', 
                        ]             
                    );
                    
                    $RowData["bulk_actual_assay"] = $updateFailAssay;
                    $RowData["bulk_actual_meo"] = $updateFailMeO;
                    $RowData["judge"] = 'Fail:Assay, MeO';        
                    $this->CreateRowData($RowData);
                }
                if($Assay_MeO->isEmpty() == false && $FailAssay_FailMeO->isEmpty() == true)
                {
                    $RowData->update(
                        [
                            'bulk_actual_assay' => $updateFailAssay, 
                            'bulk_actual_meo' =>  $updateFailMeO,
                            'judge' =>'Fail:Assay, MeO', 
                        ]             
                    );
                }
                if($Assay_MeO->isEmpty() == true && $FailAssay_FailMeO->isEmpty() == false)
                {
                    $RowData->update(
                        [
                            'bulk_actual_assay' => $updateAssay, 
                            'bulk_actual_meo' =>  $updateMeO,
                            'judge' =>'Pass', 
                        ]             
                    );
                }
            }  
        }
       
        //Condition 4: Assay == '', MeO == '', AssayFail != '', MeOFail !=''  or
        //             Assay !='', MeO != '', AssayFail == '', MeOFail=='' 
        if (
            ($updateAssay =='' && $updateMeO == '' && $updateFailAssay !='' && $updateFailMeO !='')||
            ($updateAssay !='' && $updateMeO != '' && $updateFailAssay =='' && $updateFailMeO =='')
            )
        {
            
            $_tmpAssay = ($updateAssay == '')? $updateFailAssay:$updateAssay;
            $_tmpMeO = ($updateMeO == '')? $updateFailMeO:$updateMeO;
            $_tmpjudge = ($updateAssay == '')?'Fail:Assay, MeO':'Pass';

            $RowData->update(
                    [
                        'bulk_actual_assay' => $_tmpAssay, 
                        'bulk_actual_meo' => $_tmpMeO,
                        'judge' =>$_tmpjudge,  
                    ]             
            );                            
        }

        //Condition 5: ($updateAssay !='' && $updateFailMeO!=''  && $updateFailAssay == '' && $updateMeO == '') or 
        //             ($updateFailAssay !='' && $updateMeO!=''&& $updateAssay =='' && $updateFailMeO =='') 
        if(
            ($updateAssay !='' && $updateFailMeO !='' && $updateFailAssay == '' && $updateMeO == '') || 
            ($updateFailAssay !='' && $updateMeO!='' && $updateAssay =='' && $updateFailMeO =='') 
        )
        {
            $_tmpAssay = ($updateAssay == '')? $updateFailAssay:$updateAssay;
            $_tmpMeO = ($updateMeO == '')? $updateFailMeO:$updateMeO;
            $_tmpjudge = ($updateFailMeO == '')?'Fail:Assay':'Fail:MeO';

            $RowData->update(
                    [
                        'bulk_actual_assay' => $_tmpAssay, 
                        'bulk_actual_meo' => $_tmpMeO,
                        'judge' =>$_tmpjudge,  
                    ]             
            );                            
        }

        //$UpdateValue = DB::table('sublimations')->orderBy('id','desc')->get(); //回傳原本的資料
        return response()->json([
            'success' =>  'OK'
            
        ]);       
    }

    public function CreateRowData($RowData)
    {
        $todo = Sublimation::create(
            [                    
                'bulk_started'=> $RowData["bulk_started"],
                'remark' => $RowData["remark"],
                '1st_crude_batch' => $RowData["1st_crude_batch"],
                '1st_crude_wt' => $RowData["1st_crude_wt"],
                '1st_tank_batch' => $RowData["1st_tank_batch"],
                '2nd_crude_batch' => $RowData["2nd_crude_batch"],
                '2nd_crude_wt' => $RowData["2nd_crude_wt"],
                '2nd_tank_batch' => $RowData["2nd_tank_batch"],
                '3rd_crude_batch' => $RowData["3rd_crude_batch"],
                '3rd_crude_wt' => $RowData["3rd_crude_wt"],
                '3rd_tank_batch' => $RowData["3rd_tank_batch"],
                'bulk_batch' => $RowData["bulk_batch"],
                'bulk_actual_assay' => $RowData["bulk_actual_assay"],
                'bulk_actual_meo' => $RowData["bulk_actual_meo"],
                'judge' => $RowData["judge"],
                'glove_box' => $RowData["glove_box"],
                'mantle' => $RowData["mantle"],                  
                'PLC_status' => $RowData["PLC_status"],                
                'input_op' => $RowData["input_op"],
                'solid_input' => $RowData["solid_input"],
                'output_op' => $RowData["output_op"],
                'bulk_output' => $RowData["bulk_output"],
                'bulk_yield' => $RowData["bulk_yield"],
                'input_system_oxygen' => $RowData["input_system_oxygen"],
                'pre_system_Pump' => $RowData["pre_system_Pump"],
                'pre_system_torr' => $RowData["pre_system_torr"],
                'output_system_oxygen' => $RowData["output_system_oxygen"],                 
                'top_Mantle_end' => $RowData["top_Mantle_end"],
                'top_Tapes_end' => $RowData["top_Tapes_end"],
                'top_Coolant_end' => $RowData["top_Coolant_end"],
                'top_Turbo_end' => $RowData["top_Turbo_end"],
                'top_Oxygen_end' => $RowData["top_Oxygen_end"],
                'main_Mantle_end' => $RowData["main_Mantle_end"],                  
                'main_Tapes_end' => $RowData["main_Tapes_end"],
                'main_Coolant_end' => $RowData["main_Coolant_end"],
                'main_Turbo_end' => $RowData["main_Turbo_end"],
                'main_Oxygen_end' => $RowData["main_Oxygen_end"],               
            ]    
        );
    }

     //檢查丟進來的檔案是否正確
     public function CheckColumn($RowData)
     {
         $Result = '';
         $dbCol = [
             'id',
             'bulk_started',
             'remark',
             '1st_crude_batch',
             '1st_crude_wt',
             '1st_tank_batch',
             '2nd_crude_batch',
             '2nd_crude_wt',
             '2nd_tank_batch',
             '3rd_crude_batch',
             '3rd_crude_wt',
             '3rd_tank_batch',
             'bulk_batch',
             'bulk_actual_assay',
             'bulk_actual_meo',
             'judge',
             'glove_box',
             'mantle',                  
             'PLC_status',                
             'input_op' ,
             'solid_input',
             'output_op',
             'bulk_output',
             'bulk_yield',
             'input_system_oxygen',
             'pre_system_Pump',
             'pre_system_torr',
             'output_system_oxygen',                 
             'top_Mantle_end',
             'top_Tapes_end',
             'top_Coolant_end',
             'top_Turbo_end',
             'top_Oxygen_end',
             'main_Mantle_end',                  
             'main_Tapes_end',
             'main_Coolant_end',
             'main_Turbo_end' ,
             'main_Oxygen_end',   
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
        $glove_box = DB::table('sublimations')->select('glove_box')->distinct()->get();
        $PLC_status = DB::table('sublimations')->select('PLC_status')->distinct()->get();
        $input_op = DB::table('sublimations')->select('input_op')->distinct()->get();
        $output_op = DB::table('sublimations')->select('output_op')->distinct()->get();
       
      
        return response()->json([
            'glove_box' => $glove_box,
            'PLC_status' => $PLC_status,
            'input_op' => $input_op,
            'output_op' => $output_op,
        ]);     
    }

    //從ID中獲取資料庫相對應的內容
    public function GetDataFromID( Request $request )
    {    
        $Data = $request->all();
        $DownLoadValue = [];
        $query = DB::table("sublimations");
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
