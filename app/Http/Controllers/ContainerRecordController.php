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
            $DownLoadValue = $query->orderBy( $sidx, 'asc')->get();           
        } 
       
        else
        {     
            
            //dd($Record);
            $DownLoadValue = DB::table($table)->limit(10000)->orderBy($sidx,'asc')->get();
             
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

        //從model裡面撈出鋼瓶的型號
        if ($uploadData["UploadData"]["bottle_number"] !='')
        {
            $tmp = DB::table("container_records_model")->select('container_model')
            ->where("bottle_number", $uploadData["UploadData"]["bottle_number"])->first();
            if ($tmp!=null)
            {
                $uploadData["UploadData"]["container_model"] = $tmp->container_model;
            }
            else
            {
                $uploadData["UploadData"]["container_model"] = '';
            }   
        }

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

        //從model裡面撈出鋼瓶的型號
        if ($AddParameter["bottle_number"] !='')
        {
            $tmp = DB::table("container_records_model")->select('container_model')
            ->where("bottle_number", $AddParameter["bottle_number"])->first(); 
            if ($tmp!=null)
            {
                $AddParameter["container_model"] = $tmp->container_model;
            }
            else
            {
                $AddParameter["container_model"] = '';
            }   
        }
        
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

    //從選定日期尋找製程是否完成更新資訊
    public function ContainerComplete(Request $request)
    {
        $Data = $request->all();
        //先找RGA日期為選擇日的鋼瓶資訊和工單
        $query = DB::table("container_records_rgatest");
                     
        $RGA = $query->whereDate('working_date', '=',  $Data["postData"])->get();  
        // var_dump($RGA);

        $Complete = [];

        if ($RGA != NULL){
            foreach ($RGA as $i){
                $tmp = [];
                $_assemblingtest = DB::table("container_records_assemblingtest")->where('work_id', '=', $i->work_id)->get();
                $_CPD = DB::table("container_records_cpd")->where('work_id', '=', $i->work_id)->get();
                $_inbound = DB::table("container_records_inbound")->where('work_id', '=', $i->work_id)->get();
                $_outbound = DB::table("container_records_outbound")->where('work_id', '=', $i->work_id)->get();

                $tmp["working_date"] = $i->working_date;
                $tmp["bottle_number"] = $i->bottle_number;
                $tmp["assemblingtest"] = ($_assemblingtest->all() == NULL)? "X":"O";
                $tmp["outbound"] = ($_outbound->all() == NULL)? "X":"O";
                $tmp["CPD"] = ($_CPD->all() == NULL)? "X":"O";
                $tmp["inbound"] = ($_inbound->all() == NULL)? "X":"O";
                $tmp["RGA"] = "O";
                $tmp["work_id"] = $i->work_id;
                array_push($Complete, $tmp);
            }
        }

        // dd($Complete);
        
        return response()->json([
            'success' => $Complete,        
        ]);     
        
    }

    //自動更新container records資訊
    public function AutoUpdate()
    {
        $connectionHost = 'mysql';   //mysql
        $connectionContainer = 'pgsql_container_remote';
        $this->assemblingtest($connectionHost, $connectionContainer);
        $this->Outbound($connectionHost, $connectionContainer);
        $this->Inbound($connectionHost, $connectionContainer);  
        $this->CPD($connectionHost, $connectionContainer);
        $this->rgatest($connectionHost, $connectionContainer);
    }

    //RGA測試
    public function rgatest($connectionHost, $connectionContainer)
    {
        //先從遠端主機找出最後一筆table_id
        $last_table_id = "0";
        $last_table= DB::connection($connectionHost)->table('container_records_rgatest')
        -> where('table_id', '!=', '') -> orderBy( 'id', 'desc')->first();

        //var_dump($last_table);

        if ($last_table != NULL){$last_table_id = $last_table->table_id;}
        //var_dump($last_table_id );

        $rgaStation = DB::connection($connectionContainer)->table('tb_rga')
        ->where('id', '>', $last_table_id)
        ->where('op_type', '=','4')
        //->whereDate('type_time', '=',  '2020/04/06')
        ->whereDate('type_time', '>=', '2020-03-01')
        ->orderBy( 'id', 'asc')->get();
        
        if( $rgaStation->all() !=NULL)
        {
            foreach($rgaStation as $object)
            {
                $key = (array)$object;
                //獲得鋼瓶型號
                $containerGetModel = DB::connection($connectionHost)->table('container_records_model')->
                where('bottle_number', $key["bubbler_id"])->first();
                $containerModel = ($containerGetModel!=NULL)? $containerGetModel->container_model: "";
            
                $insert = [
                    //"id" => $key["id"],
                    "working_date" => $key["type_time"],
                    "container_model" => $containerModel,
                    "bottle_number" => $key["bubbler_id"],
                    "vacuum_value" => $key["vacuum_value"],
                    "vacuum_equipment_limit" => '',
                    "spec" => '',
                    "H2O" => $key["h2o_value"],
                    "N2" => $key["n2_value"],
                    "O2" => $key["o2_value"],
                    "CO2" => $key["co2_value"],
                    "Acetone" => '',
                    "Pentane" => '',
                    "He" => '',
                    "spectro_equipment_limit" =>'',
                    "spectro_equipment_spec" =>'',
                    "work_id" => $key["work_id"],
                    "table_id"=> $key["id"],
                    "created_at" =>date('Y-m-d H:i:s'),
                    "updated_at" => date('Y-m-d H:i:s'),  
                ];


                $Result = DB::connection($connectionHost)->table('container_records_rgatest')->insert(
                    $insert
                );

                //var_dump($Result);
            }
        }
           
    }

    //壓降測漏
    public function CPD($connectionHost, $connectionContainer)
    {
        //先從遠端主機找出最後一筆table_id
        $last_table_id = "0";
        $last_table= DB::connection($connectionHost)->table('container_records_cpd')
        -> where('table_id', '!=', '') -> orderBy( 'id', 'desc')->first();

        //var_dump($last_table);

        if ($last_table != NULL){$last_table_id = $last_table->table_id;}
        //var_dump($last_table_id );

        $CPDStation = DB::connection($connectionContainer)->table('tb_pressure_difference')
        ->where('id', '>', $last_table_id)
        ->where('op_type', '=','4')
        ->where('output_time', '!=', '')
        //->whereDate('type_time', '=',  '2020/04/06')
        ->whereDate('type_time', '>=', '2020-03-01')
        ->orderBy( 'id', 'asc')->get();
        //var_dump($CPDStation);
        
        $CollectionCPD = [];
        $insertBypass = [];
        $insertBody = [];

        $_id = '';                //以pressure_difference_id表為主
        $_bubbler_id = '';        //瓶號
        $_work_id = '';           //工單
        $_input_time = '';        //輸出時間
        
        if ($CPDStation->all()!= NULL)
        {
            $Group = 1;
            $dictionaryCPD = [];
            
            //找出共幾組group  
            $start_id = [
                "id" => $CPDStation[0]->id,
                "bubbler_id" => $CPDStation[0]->bubbler_id,
                "work_id" => $CPDStation[0]->work_id,
                "input_time" => $CPDStation[0]->input_time,
            ];
            array_push($dictionaryCPD, $start_id);
        
            foreach( $CPDStation as $object )
            {
                $value = (array)$object;
                if($start_id["bubbler_id"] != $value["bubbler_id"])
                {
                    $start_id["id"] = $value["id"];
                    $start_id["bubbler_id"] = $value["bubbler_id"];
                    $start_id["work_id"] = $value["work_id"];
                    $start_id["input_time"] = $value["input_time"];
                    $Group ++;
                    array_push($dictionaryCPD, $start_id);
                }
            }

            //var_dump($dictionaryCPD);

            //將值依據組別放入
            for( $i = 0; $i < $Group ; $i++)
            {
                $_id = $dictionaryCPD[$i]["id"];
                $_bubbler_id = $dictionaryCPD[$i]["bubbler_id"];
                $_work_id = $dictionaryCPD[$i]["work_id"];
                $_input_time = $dictionaryCPD[$i]["input_time"];
                

                foreach( $CPDStation as $object )
                {
                    $value = (array)$object;
                    
                    if(
                        ($value["bubbler_id"] == $_bubbler_id) 
                        && ($value["input_time"] == $_input_time) 
                        && ($value["work_id"] == $_work_id) 
                    )
                    {
                        switch ($value["channels"])
                        {
                            case "0":
                                switch ($value["times"])
                                {
                                    case "0":
                                        $insertBypass["bypass_1"] = ($value["value_status"] == "S")? $value["value_diff"]:"";
                                        $insertBypass["bypass_fail"] = ($value["value_status"] == "F")? $value["value_diff"]:"";
                                        break;
                                    case "1":
                                        $insertBypass["bypass_2"] = ($value["value_status"] == "S")? $value["value_diff"]:"";
                                        break;

                                }
                                break;
                            case "1":
                                switch ($value["times"])
                                {
                                    case "0":
                                        $insertBody["body_1"] = ($value["value_status"] == "S")? $value["value_diff"]:"";
                                        $insertBody["body_fail"] = ($value["value_status"] == "F")? $value["value_diff"]:"";
                                        break;
                                    case "1":
                                        $insertBody["body_2"] = ($value["value_status"] == "S")? $value["value_diff"]:"";
                                        break;
                                }
                                break;
                        }      
                    }    
                }
                
                $CollectionCPD[$i] = [
                        "id" => $_id,
                        "bubbler_id" => $_bubbler_id,
                        "work_id" => $_work_id,
                        "insertBypass" =>  $insertBypass,
                        "insertBody" => $insertBody,
                        "input_time" => $_input_time,
                    ];
            } 
        }

        // var_dump($CollectionCPD);

        if($CollectionCPD!=NULL)
        {
            foreach($CollectionCPD as $key)
            {
                //獲得鋼瓶型號
                $containerGetModel = DB::connection($connectionHost)->table('container_records_model')->
                where('bottle_number', $key["bubbler_id"])->first();
                $containerModel = ($containerGetModel!=NULL)? $containerGetModel->container_model: "";
            
                $insert = [
                    //"id" => $key["id"],
                    "working_date" => $key["input_time"],
                    "container_model" => $containerModel,
                    "bottle_number" => $key["bubbler_id"],
                    "pipe_calibration" => '',
                    "calibration_fail" =>'',
                    "bypass_1" => $key["insertBypass"]["bypass_1"],
                    "bypass_2" => $key["insertBypass"]["bypass_2"],
                    "bypass_fail" => $key["insertBypass"]["bypass_fail"],
                    "body_1" => $key["insertBody"]["body_1"],
                    "body_2" => $key["insertBody"]["body_2"],
                    "body_fail" => $key["insertBody"]["body_fail"],
                    
                    "work_id" => $key["work_id"],
                    "table_id"=> $key["id"] + 7,
                    "created_at" =>date('Y-m-d H:i:s'),
                    "updated_at" => date('Y-m-d H:i:s'),  
                ];


                $Result = DB::connection($connectionHost)->table('container_records_cpd')->insert(
                    $insert
                );

                //var_dump($Result);
            }
        } 
    }
    
    //Inbound
    public function Inbound($connectionHost, $connectionContainer)
    {
        //先從遠端主機找出最後一筆table_id
        $last_table_id = "0";
        $last_table= DB::connection($connectionHost)->table('container_records_inbound')->
                    where('table_id', '!=', '')->orderBy( 'id', 'desc')->first();

        //var_dump($last_table);

        if ($last_table != NULL){$last_table_id = $last_table->table_id;}

        //先把inbound外漏找出
        $inboundOutStation = DB::connection($connectionContainer)->select(
            "select tb_leakage.id, tb_leakage.bubbler_id, tb_leakage.type_time, tb_leakage.work_id,
			tb_leakage_value.joint_id, tb_leakage_value.value, tb_leakage_value.status 
            from tb_leakage, tb_leakage_value
            where 
                tb_leakage.type_time = tb_leakage_value.input_time
            and tb_leakage.bound_mode = 2
            and tb_leakage.op_type = 4
            and tb_leakage.type_time > ('2020/03/01')
            and tb_leakage.id > ".$last_table_id.
            
            " order by tb_leakage.id"
        );//and CAST(tb_leakage.type_time as Date )= ('2020/04/06')
       
        //先把inbound內漏找出
        $inboundInStation = DB::connection($connectionContainer)->select(
            "select tb_leakage.id, tb_leakage.bubbler_id, tb_leakage.type_time, tb_leakage.work_id,
			tb_leakage_value.joint_id, tb_leakage_value.value, tb_leakage_value.status 
            from tb_leakage, tb_leakage_value
            where 
                tb_leakage.type_time = tb_leakage_value.input_time
            and tb_leakage.bound_mode = 3
            and tb_leakage.op_type = 4
            and tb_leakage.type_time > ('2020/03/01')
            and tb_leakage.id > ". $last_table_id.

            " order by tb_leakage.id"
        ); //and CAST(tb_leakage.type_time as Date )= ('2020/04/06')
        
        //var_dump($inboundInStation); 
  
        $_id = '';                //以leakage_id表為主
        $_bubbler_id = '';        //瓶號
        $_work_id = '';           //工單
        
        $CollectionOut = [];      //外漏的分組
        $CollectionIn = [];       //內漏的分組
        
        $insertInboundOut = [];   //分組後用來放外漏的值
        $insertInboundIn = [];    //分組後用來放內漏的值

        $CollectionInsert = [];   //真正要加入的資料
        
        //先將外漏分組
        if ($inboundOutStation!=NULL) 
        {
            $Group = 1;
            $dictionaryOut = [];
            
            //找出共幾組group  
            $start_id = [
                "id" => $inboundOutStation[0]->id,
                "bubbler_id" => $inboundOutStation[0]->bubbler_id,
                "work_id" => $inboundOutStation[0]->work_id,
            ];
            array_push($dictionaryOut, $start_id);
        
            foreach( $inboundOutStation as $object )
            {
                $value = (array)$object;
                if($start_id["id"] != $value["id"])
                {
                    $start_id["id"] = $value["id"];
                    $start_id["bubbler_id"] = $value["bubbler_id"];
                    $start_id["work_id"] = $value["work_id"];
                    $Group ++;
                    array_push($dictionaryOut, $start_id);
                }
            }


            //將值依據組別放入
            for( $i = 0; $i < $Group ; $i++)
            {
                $_id = $dictionaryOut[$i]["id"];
                $_bubbler_id = $dictionaryOut[$i]["bubbler_id"];
                $_work_id = $dictionaryOut[$i]["work_id"];
                $_isFail = 'false';
                $_date = '';
                

                foreach( $inboundOutStation as $object )
                {
                    $value = (array)$object;
                    
                    if($value["id"] == $_id)
                    {
                        if($value["status"] == 'F'){$_isFail = 'true';}
                        $_date = $value["type_time"];

                        switch ($value["joint_id"])
                        {
                            case "1":
                                $insertInboundOut["fill_port_fail"] = ($value["status"] == 'F') ?  $value["value"] : "";
                                $insertInboundOut["fill_port"] = ($value["status"] == 'F') ? "" :$value["value"];
                                break;
                            case "2":
                                $insertInboundOut["A1_fail"] = ($value["status"] == 'F') ?  $value["value"] : "";
                                $insertInboundOut["A1"] = ($value["status"] == 'F') ? "" :$value["value"];
                                break;
                            case "3":
                                $insertInboundOut["A2_fail"] = ($value["status"] == 'F') ?  $value["value"] : "";
                                $insertInboundOut["A2"] = ($value["status"] == 'F') ? "" :$value["value"];
                                break;
                            case "4":
                                $insertInboundOut["A3_fail"] = ($value["status"] == 'F') ?  $value["value"] : "";
                                $insertInboundOut["A3"] = ($value["status"] == 'F') ? "" :$value["value"];
                                break;
                            case "5":
                                $insertInboundOut["M1_fail"] = ($value["status"] == 'F') ?  $value["value"] : "";
                                $insertInboundOut["M1"] = ($value["status"] == 'F') ? "" :$value["value"];
                                break;
                            case "6":
                                $insertInboundOut["M2_fail"] = ($value["status"] == 'F') ?  $value["value"] : "";
                                $insertInboundOut["M2"] = ($value["status"] == 'F') ? "" :$value["value"];
                                break;
                            case "7":
                                $insertInboundOut["vcr_fail"] = ($value["status"] == 'F') ?  $value["value"] : "";
                                $insertInboundOut["vcr"] = ($value["status"] == 'F') ? "" :$value["value"];
                                break;
                        }      
                    }    
                }
                
                $CollectionOut[$i] = [
                        "id" => $_id,
                        "bubbler_id" => $_bubbler_id,
                        "work_id" => $_work_id,
                        "InsertInboundOut" =>  $insertInboundOut,
                        "isFail" => $_isFail,
                        "type_time" => $_date,
                    ];
            } 
        }
        
        // var_dump($CollectionOut);


        //先將內漏分組
        if ($inboundInStation!=NULL) 
        {
            $Group = 1;
            $dictionaryIn = [];
            
            //找出共幾組group  
            $start_id = [
                "id" => $inboundInStation[0]->id,
                "bubbler_id" => $inboundInStation[0]->bubbler_id,
                "work_id" => $inboundInStation[0]->work_id,
            ];
            array_push($dictionaryIn, $start_id);
        
            foreach( $inboundInStation as $object )
            {
                $value = (array)$object;
                if($start_id["id"] != $value["id"])
                {
                    $start_id["id"] = $value["id"];
                    $start_id["bubbler_id"] = $value["bubbler_id"];
                    $start_id["work_id"] = $value["work_id"];
                    $Group ++;
                    array_push($dictionaryIn, $start_id);
                }
            }


            //將值依據組別放入
            for( $i = 0; $i < $Group ; $i++)
            {
                $_id = $dictionaryIn[$i]["id"];
                $_bubbler_id = $dictionaryIn[$i]["bubbler_id"];
                $_work_id = $dictionaryIn[$i]["work_id"];
                $_isFail = 'false';
                $_date = '';
                

                foreach( $inboundInStation as $object )
                {
                    $value = (array)$object;
                    
                    if($value["id"] == $_id)
                    {
                        if($value["status"] == 'F'){$_isFail = 'true';}
                        $_date = $value["type_time"];

                        switch ($value["joint_id"])
                        {
                            case "2":
                                $insertInboundIn["A1_fail"] = ($value["status"] == 'F') ?  $value["value"] : "";
                                $insertInboundIn["A1"] = ($value["status"] == 'F') ? "" :$value["value"];
                                break;
                            case "3":
                                $insertInboundIn["A2_fail"] = ($value["status"] == 'F') ?  $value["value"] : "";
                                $insertInboundIn["A2"] = ($value["status"] == 'F') ? "" :$value["value"];
                                break;
                            case "4":
                                $insertInboundIn["A3_fail"] = ($value["status"] == 'F') ?  $value["value"] : "";
                                $insertInboundIn["A3"] = ($value["status"] == 'F') ? "" :$value["value"];
                                break;
                            case "5":
                                $insertInboundIn["M1_fail"] = ($value["status"] == 'F') ?  $value["value"] : "";
                                $insertInboundIn["M1"] = ($value["status"] == 'F') ? "" :$value["value"];
                                break;
                            case "6":
                                $insertInboundIn["M2_fail"] = ($value["status"] == 'F') ?  $value["value"] : "";
                                $insertInboundIn["M2"] = ($value["status"] == 'F') ? "" :$value["value"];
                                break;
                        }      
                    }    
                }
                
                $CollectionIn[$i] = [
                        "id" => $_id,
                        "bubbler_id" => $_bubbler_id,
                        "work_id" => $_work_id,
                        "InsertInboundIn" =>  $insertInboundIn,
                        "isFail" => $_isFail,
                        "type_time" => $_date,
                        "isUsed" => "N"
                    ];
            } 
        }

        // var_dump(count($CollectionOut));
        // var_dump(count($CollectionIn));

        //將CollectionOut和CollectionIn取兩層for迴圈，產生真正要加入的值
        //1.以CollectionOut為主要，向CollectionIn找尋bubbler_id相同的值，
        //2.CollectionOut若有Fail，則不需要找
        //3.找的方法必須依據type_time、bubbler_id、若找到則直接用這筆資料、並將此CollectionIn設為isUsed

        for($i = 0; $i < count($CollectionOut) ; $i++)
        {
            //若此筆資料中有fail，則整筆資料只需保留外漏fail資訊
            if($CollectionOut[$i]["isFail"] == 'true')
            {   //var_dump($i);
                $insertInboundIn["M1"] = '';
                $insertInboundIn["M2"] = '';
                $insertInboundIn["A1"] = '';
                $insertInboundIn["A2"] = '';
                $insertInboundIn["A3"] = '';
                $insertInboundIn["M1_fail"] = '';
                $insertInboundIn["M2_fail"] = '';
                $insertInboundIn["A1_fail"] = '';
                $insertInboundIn["A2_fail"] = '';
                $insertInboundIn["A3_fail"] = '';

                $CollectionOut[$i]["InsertInboundIn"] = $insertInboundIn;

                array_push( $CollectionInsert, $CollectionOut[$i] );             
            }
            else
            {
                $type_time = $CollectionOut[$i]["type_time"];
                $bubbler_id = $CollectionOut[$i]["bubbler_id"];
                $isFind = 'false';
                for($j = 0; $j < count($CollectionIn); $j++)
                {
                    //尚未被使用過
                    if($CollectionIn[$j]["isUsed"]!='Y')
                    {
                        //取日期相同、瓶號相同
                        if( 
                            date("Y/m/d", strtotime($CollectionIn[$j]["type_time"])) == date("Y/m/d",strtotime($type_time))
                            && ($CollectionIn[$j]["bubbler_id"] == $bubbler_id)
                        )
                        {
                            $CollectionOut[$i]["InsertInboundIn"] = $CollectionIn[$j]["InsertInboundIn"];
                            array_push( $CollectionInsert, $CollectionOut[$i] );
                            $CollectionIn[$j]["isUsed"] = 'Y';
                            $isFind = 'true';
                            break;
                        }
                    }
                }
                //沒有找到的情況，將這筆資料後面的值填空白
                //此筆資料不加入，因可能只有做完外漏，內漏還未做
                if($isFind == 'false')
                {
                    $insertInboundIn["M1"] = '';
                    $insertInboundIn["M2"] = '';
                    $insertInboundIn["A1"] = '';
                    $insertInboundIn["A2"] = '';
                    $insertInboundIn["A3"] = '';
                    $insertInboundIn["M1_fail"] = '';
                    $insertInboundIn["M2_fail"] = '';
                    $insertInboundIn["A1_fail"] = '';
                    $insertInboundIn["A2_fail"] = '';
                    $insertInboundIn["A3_fail"] = '';

                    $CollectionOut[$i]["InsertInboundIn"] = $insertInboundIn;
                    //array_push( $CollectionInsert, $CollectionOut[$i] );         
                }
            }
        }

        //var_dump($CollectionInsert);
        
        if(count($CollectionInsert)!= 0)
        {
            foreach($CollectionInsert as $key)
            {
                //獲得鋼瓶型號
                $containerGetModel = DB::connection($connectionHost)->table('container_records_model')->
                where('bottle_number', $key["bubbler_id"])->first();
                $containerModel = ($containerGetModel!=NULL)? $containerGetModel->container_model: "";
            
                $insert = [
                    //"id" => $key["id"],
                    "working_date" => $key["type_time"],
                    "container_model" => $containerModel,
                    "bottle_number" => $key["bubbler_id"],
                    "vcr" => $key["InsertInboundOut"]["vcr"],
                    "vcr_fail" => $key["InsertInboundOut"]["vcr_fail"],
                    "fill_port" => $key["InsertInboundOut"]["fill_port"],
                    "fill_port_fail" => $key["InsertInboundOut"]["fill_port_fail"],
                    "M1" => $key["InsertInboundOut"]["M1"],
                    "M2" => $key["InsertInboundOut"]["M2"],
                    "A1" => $key["InsertInboundOut"]["A1"],
                    "A2" => $key["InsertInboundOut"]["A2"],
                    "A3" => $key["InsertInboundOut"]["A3"],
                    "M1_fail" => $key["InsertInboundOut"]["M1_fail"],
                    "M2_fail" => $key["InsertInboundOut"]["M2_fail"],
                    "A1_fail" => $key["InsertInboundOut"]["A1_fail"],
                    "A2_fail" => $key["InsertInboundOut"]["A2_fail"],
                    "A3_fail" => $key["InsertInboundOut"]["A3_fail"],
                    
                    "M1_valve" => $key["InsertInboundIn"]["M1"],
                    "M2_valve" => $key["InsertInboundIn"]["M2"],
                    "A1_valve" => $key["InsertInboundIn"]["A1"],
                    "A2_valve" => $key["InsertInboundIn"]["A2"],
                    "A3_valve" => $key["InsertInboundIn"]["A3"],
                    "M1_valve_fail" => $key["InsertInboundIn"]["M1_fail"],
                    "M2_valve_fail" => $key["InsertInboundIn"]["M2_fail"],
                    "A1_valve_fail" => $key["InsertInboundIn"]["A1_fail"],
                    "A2_valve_fail" => $key["InsertInboundIn"]["A2_fail"],
                    "A3_valve_fail" => $key["InsertInboundIn"]["A3_fail"],
                    "IN_1" => "",
                    "IN_2" => "",
                    "OUT" => "",
                    "IN_1_fail" => "",
                    "IN_2_fail" => "",
                    "OUT_fail" => "",
                    "work_id" => $key["work_id"],
                    "table_id"=> $key["id"],
                    "created_at" =>date('Y-m-d H:i:s'),
                    "updated_at" => date('Y-m-d H:i:s'),  
                ];

                //var_dump($insert);

                $Result = DB::connection($connectionHost)->table('container_records_inbound')->insert(
                    $insert
                );
            }   
            //var_dump($Result);
        }   
        
    }

    //Outbound
    public function Outbound($connectionHost, $connectionContainer)
    {
        //先從遠端主機找出最後一筆table_id
        $last_table_id = "0";
        $last_table= DB::connection($connectionHost)->table('container_records_outbound')
                    ->where('table_id', '!=', '')->orderBy( 'id', 'desc')->first();

        //var_dump($last_table);

        if ($last_table != NULL){$last_table_id = $last_table->table_id;}
        //var_dump($last_table_id );

        $outboundStation = DB::connection($connectionContainer)->table('tb_leakage')->where('id', '>', $last_table_id)
                        ->where('bound_mode', '=', '1')->where('op_type', '=', '4')->orderBy( 'id', 'asc')
                        ->whereDate('type_time', '>=', '2020-03-01')
                        ->get();
        //var_dump($outboundStation);
        
        if($outboundStation->all()!= NULL)
        {
            foreach( $outboundStation as $object )
            {
                $key = (array)$object;
                
                //獲得leakage value
                $getLeakageValue = DB::connection($connectionContainer)->table('tb_leakage_value')->
                        where('bubbler_id', '=' ,$key["bubbler_id"])->where('input_time', '=', $key["type_time"])->get();
                //var_dump($getLeakageValue);

                $insertOutbound = [];
                foreach( $getLeakageValue as $tmp )
                {
                    $value = (array)$tmp;
                    switch ($value["joint_id"])
                    {
                        case "1":
                            $insertOutbound["FillPort_fail"] = ($value["status"] == 'F') ?  $value["value"] : "";
                            $insertOutbound["FillPort"] = ($value["status"] == 'F') ? "" :$value["value"];
                            break;
                        case "2":
                            $insertOutbound["A1_fail"] = ($value["status"] == 'F') ?  $value["value"] : "";
                            $insertOutbound["A1"] = ($value["status"] == 'F') ? "" :$value["value"];
                            break;
                        case "3":
                            $insertOutbound["A2_fail"] = ($value["status"] == 'F') ?  $value["value"] : "";
                            $insertOutbound["A2"] = ($value["status"] == 'F') ? "" :$value["value"];
                            break;
                        case "4":
                            $insertOutbound["A3_fail"] = ($value["status"] == 'F') ?  $value["value"] : "";
                            $insertOutbound["A3"] = ($value["status"] == 'F') ? "" :$value["value"];
                            break;
                        case "5":
                            $insertOutbound["M1_fail"] = ($value["status"] == 'F') ?  $value["value"] : "";
                            $insertOutbound["M1"] = ($value["status"] == 'F') ? "" :$value["value"];
                            break;
                        case "6":
                            $insertOutbound["M2_fail"] = ($value["status"] == 'F') ?  $value["value"] : "";
                            $insertOutbound["M2"] = ($value["status"] == 'F') ? "" :$value["value"];
                            break;
                        case "7":
                            $insertOutbound["VCR_fail"] = ($value["status"] == 'F') ?  $value["value"] : "";
                            $insertOutbound["VCR"] = ($value["status"] == 'F') ? "" :$value["value"];
                            break;
                    }
                    
                }

                //var_dump($insertOutbound);
                
                //獲得鋼瓶型號
                $containerGetModel = DB::connection($connectionHost)->table('container_records_model')->
                where('bottle_number', $key["bubbler_id"])->first();
                $containerModel = ($containerGetModel!=NULL)? $containerGetModel->container_model: "";
            
                $insert = [
                    //"id" => $key["id"],
                    "working_date" => $key["type_time"],
                    "container_model" => $containerModel,
                    "bottle_number" => $key["bubbler_id"],
                    "M1" => $insertOutbound["M1"],
                    "M2" => $insertOutbound["M2"],
                    "A1" => $insertOutbound["A1"],
                    "A2" => $insertOutbound["A2"],
                    "A3" => $insertOutbound["A3"],
                    "M1_fail" => $insertOutbound["M1_fail"],
                    "M2_fail" => $insertOutbound["M2_fail"],
                    "A1_fail" => $insertOutbound["A1_fail"],
                    "A2_fail" => $insertOutbound["A2_fail"],
                    "A3_fail" => $insertOutbound["A3_fail"],
                    "work_id" => $key["work_id"],
                    "table_id"=> $key["id"],
                    "created_at" =>date('Y-m-d H:i:s'),
                    "updated_at" => date('Y-m-d H:i:s'),
                    
                ];
                $Result = DB::connection($connectionHost)->table('container_records_outbound')->insert(
                    $insert
                );
                //var_dump($Result);
            }
        }
    }

    //組裝測試
    public function assemblingtest($connectionHost, $connectionContainer)
    {
        //先從遠端主機找出最後一筆table_id
        $last_table_id = "0";
        $last_table= DB::connection($connectionHost)->table('container_records_assemblingtest')
                -> where('table_id', '!=', '') -> orderBy( 'id', 'desc')->first();

        //var_dump($last_table);

        if ($last_table != NULL){$last_table_id = $last_table->table_id;}
        //var_dump($last_table_id );

        $ovenStation = DB::connection($connectionContainer)->table('tb_oven')->where('id', '>', $last_table_id)->orderBy( 'id', 'asc')->get();
        //var_dump($ovenStation);
        
        if($ovenStation->all()!= NULL)
        {
            foreach( $ovenStation as $object)
            {
                $key = (array)$object;
    
                $containerGetModel = DB::connection($connectionHost)->table('container_records_model')->
                        where('bottle_number', $key["bubbler_id"])->first();
                $containerModel = ($containerGetModel!=NULL)? $containerGetModel->container_model: "";
                if (trim($key["start_time"]) == "")
                {
                    $key["start_time"] = NULL;
                }
                if (trim($key["end_time"]) == "")
                {
                    $key["end_time"] = NULL;
                }

                $insert = [
                    //"id" => $key["id"],
                    "working_date" => $key["type_time"],
                    "container_model" => $containerModel,
                    "bottle_number" => $key["bubbler_id"],
                    "oven_temperature" => $key["temp_setpoint"],
                    "oven_time" => $key["time_period"],
                    "start_time" => $key["start_time"],
                    "end_time" => $key["end_time"],
                    "work_id" => $key["work_id"],
                    "table_id"=> $key["id"],
                    "created_at" =>date('Y-m-d H:i:s'),
                    "updated_at" => date('Y-m-d H:i:s'),
                    
                ];
                $Result = DB::connection($connectionHost)->table('container_records_assemblingtest')->insert(
                    $insert
                );
                // var_dump($Result);
            }
        }
        
    }

}
