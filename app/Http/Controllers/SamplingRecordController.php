<?php

namespace App\Http\Controllers;

use DB;
use Illuminate\Http\Request;
use App\SamplingRecord;
use Validator;

class SamplingRecordController extends Controller
{
    //This is the controller index
    public function index( Request $request )
    {      
        // $todos = DB::table('sampling_records')->whereDate('sampling_date', '>=', '2020-01-01')->orderBy('id','desc')->get(); 
        // $user = $_SERVER['REMOTE_USER'];
        // var_dump($user);  // e.g. root or www-data 

        $todos = DB::table('sampling_records')->orderBy('id','desc')->first();  

        return view('SamplingRecord.SamplingRecord',[
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
        $query = SamplingRecord::query();
        
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
        $record = SamplingRecord::count();
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
        $query = SamplingRecord::query();
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
            $DownLoadValue = DB::table('sampling_records')->limit(10000)->orderBy($sidx, 'asc')->get();
             
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
            $updateData = SamplingRecord::find($uploadData["UploadData"]["id"]);
            if ($uploadData["UploadData"]["sampling_date"] ==''){$uploadData["UploadData"]["sampling_date"] = NULL;}
            if ($uploadData["UploadData"]["completion_date"] ==''){$uploadData["UploadData"]["completion_date"] = NULL;}
            
            if(!$updateData)
            {   
                $this-> CreateOperLogWithUpload( 'add', $uploadData["UploadData"], null);                          
                $this-> CreateRowData($uploadData["UploadData"]);
     
            }
            else
            {
                $this-> CreateOperLogWithUpload( 'edit', $uploadData["UploadData"], $updateData);
                $updateData->update($uploadData["UploadData"]);
            }    
            return response()->json([
                'success' => $uploadData["UploadData"]["id"],
            ]);
        }
    }

    //刪除方法
    public function destroy(Request $request)
    {   
        $Parameter = $request->all();

        $operlog["user"] =  $_SERVER['REMOTE_USER'];
        $operlog["action"] = "delete";
        $operlog["description"] = $Parameter["oper_log"];
        $this->CreateOperLog($operlog);
        
        SamplingRecord::find($Parameter["id"])->delete($Parameter["id"]);
        // return response()->json([
        //     'success' => 'Record deleted successfully!'
        // ]);
        //$UpdateValue = DB::table('sampling_records')->orderBy('id','desc')->get(); //回傳原本的資料
        return response()->json([
            //'success' =>  $UpdateValue
            'success' => 'OK'
            
        ]);        
    }

    //新增和修改
    public function AddandUpdate(Request $request)
    {      
        $AddParameter = $request->all();

        $operlog["user"] =  $_SERVER['REMOTE_USER'];
        $operlog["action"] = $AddParameter["oper"];
        $operlog["description"] = $AddParameter["oper_log"];
        $this->CreateOperLog($operlog);

        // var_dump($AddParameter);
        if ($AddParameter["sampling_date"] ==''){$AddParameter["sampling_date"] = NULL;}
        if ($AddParameter["completion_date"] ==''){$AddParameter["completion_date"] = NULL;}

        //dd($AddParameter["urgent"]);      
        if ($request->oper =='add')
        {
            $this->CreateRowData($AddParameter); 
            
            return response()->json([
                'success' => 'Record add successfully!'
            ]);
        }
        else
        {
            $updateData = SamplingRecord::find($request->id);
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
        $todo = SamplingRecord::create(
            [      
                'id'=> $RowData["id"],              
                'urgent'=> $RowData["urgent"],
                'sampling_date' => $RowData["sampling_date"],
                'product_name' => $RowData["product_name"],
                'level' => $RowData["level"],
                'bottle_number' => $RowData["bottle_number"],
                'batch_number' => $RowData["batch_number"],
                'sampler' => $RowData["sampler"],
                'sample_source' => $RowData["sample_source"],
                'analytical_item' => $RowData["analytical_item"],
                'analyst' => $RowData["analyst"],
                'completion_date' => $RowData["completion_date"],
                'determination' => $RowData["determination"],
                'remarks' => $RowData["remarks"],
                'MeO' => $RowData["MeO"],
                'Assay' => $RowData["Assay"],
                'HC' => $RowData["HC"],
                'Si' => $RowData["Si"],
                'Sn' => $RowData["Sn"],
                'Al' => $RowData["Al"],
                'I' => $RowData["I"],
                'Fe' => $RowData["Fe"],
                'Zn' => $RowData["Zn"],
                'Ag' => $RowData["Ag"],
                'As' => $RowData["As"],
                'Au' => $RowData["Au"],
                'B' => $RowData["B"],
                'Ba' => $RowData["Ba"],
                'Be' => $RowData["Be"],
                'Bi' => $RowData["Bi"],
                'Ca' => $RowData["Ca"],
                'Cd' => $RowData["Cd"],
                'Ce' => $RowData["Ce"],
                'Co' => $RowData["Co"],
                'Cr' => $RowData["Cr"],
                'Cs' => $RowData["Cs"],
                'Cu' => $RowData["Cu"],
                'Ga' => $RowData["Ga"],
                'Ge' => $RowData["Ge"],
                'Hg' => $RowData["Hg"],
                'In' => $RowData["In"],
                'K' => $RowData["K"],
                'La' => $RowData["La"],
                'Li' => $RowData["Li"],
                'Mg' => $RowData["Mg"],
                'Mn' => $RowData["Mn"],
                'Mo' => $RowData["Mo"],
                'Na' => $RowData["Na"],
                'Nb' => $RowData["Nb"],
                'Ni' => $RowData["Ni"],
                'P' => $RowData["P"],
                'Pb' => $RowData["Pb"],
                'Pd' => $RowData["Pd"],
                'Pt' => $RowData["Pt"],
                'Rb' => $RowData["Rb"],
                'Re' => $RowData["Re"],
                'Rh' => $RowData["Rh"],
                'Ru' => $RowData["Ru"],
                'S' => $RowData["S"],
                'Sb' => $RowData["Sb"],
                'Se' => $RowData["Se"],
                'Sr' => $RowData["Sr"],
                'Ta' => $RowData["Ta"],
                'Tb' => $RowData["Tb"],
                'Te' => $RowData["Te"],
                'Th' => $RowData["Th"],
                'Ti' => $RowData["Ti"],
                'Tl' => $RowData["Tl"],
                'U' => $RowData["U"],
                'V' => $RowData["V"],
                'W' => $RowData["W"],
                'Y' => $RowData["Y"],
                'Zr' => $RowData["Zr"],
                'F' => $RowData["F"],
                'Cl' => $RowData["Cl"],
                'Parameter_A' => $RowData["Parameter_A"],
                'Impurity_A' => $RowData["Impurity_A"],
                'Impurity_B' => $RowData["Impurity_B"],
                'Impurity_C' => $RowData["Impurity_C"],
                'Impurity_D' => $RowData["Impurity_D"],
                'Impurity_E' => $RowData["Impurity_E"],
                'Impurity_F' => $RowData["Impurity_F"],
                '1H_NMR' => $RowData["1H_NMR"],
                'Other_Metals' => $RowData["Other_Metals"],
                'Parameter_B' => $RowData["Parameter_B"],
                'Parameter_C' => $RowData["Parameter_C"],
                'Parameter_D' => $RowData["Parameter_D"],
                'Organic_impurity' => $RowData["Organic_impurity"],
                '2_2ppm' => $RowData["2_2ppm"],
                '3_8ppm' => $RowData["3_8ppm"],
                '4_0ppm' => $RowData["4_0ppm"],
                'Sum223840' => $RowData["Sum223840"],                  
            ]    
        );
    }

    //新增記錄到操作log table
    public function CreateOperLog($RowData)
    {
        $Result = DB::table('sampling_records_accounts')->
        where('User_Account', '=', $RowData["user"])->first();

        if ($Result != '')
        {
            $RowData["user"] = $RowData["user"] . '(' . $Result->User_Name .')';
        }
        $todo = DB::table("sampling_records_operlog")->insert(
            $RowData 
        );
    }

    //大量上傳時記錄到操作log table
    public function CreateOperLogWithUpload( $oper, $RowData, $updateData )
    {
        $change = 'false';
        $edit_statement = "";

        if ($oper == 'edit')
        {    
            foreach ($RowData as $key => $value )
            {      
                if ($key !== "更新時間" && $key !== "建立時間")
                { 
                    $value_before = ($updateData[$key] ==="")? 'Null' : $updateData[$key];
                    $value_after = ($RowData[$key] === "")? 'Null' : $RowData[$key];

                    if ($value_before != $value_after)
                    {
                        $edit_statement .= $this->Translate($key) . "：\"". $value_before. "\"" . " to ". "\"" .$value_after. "\"" .", "; 
                        $change = 'true';
                    }
                }  
            }

            $edit_statement = '[ ' . '編號' . '：' . $RowData["id"] . ' ] ' . $edit_statement;
            $edit_statement = substr( $edit_statement, 0, -2 );
        }
        else
        {
            $change = 'true';
            foreach ($RowData as $key => $value )
            {
                if ($key !== "更新時間" && $key !== "建立時間" && $key !== "id")
                {
                    if ($value !== '')
                    {
                        $edit_statement .= $this->Translate($key). "：". $value.", ";
                    }  
                }
            }
            $edit_statement = substr( $edit_statement, 0, -2 );       
        }
        
        if ($change == 'true')
        {
            $operlog["user"] =  $_SERVER['REMOTE_USER'];
            $operlog["action"] = $oper;
            $operlog["description"] = $edit_statement;
            $this->CreateOperLog($operlog);
        }
    }

    //檢查丟進來的檔案是否正確
    public function CheckColumn($RowData)
    {
        $Result = '';
        $dbCol = [
            'id',                
            'urgent',
            'sampling_date',
            'product_name',
            'level',
            'bottle_number',
            'batch_number',
            'sampler',
            'sample_source',
            'analytical_item',
            'analyst',
            'completion_date',
            'determination',
            'remarks',
            'MeO',
            'Assay',
            'HC',
            'Si',
            'Sn',
            'Al',
            'I',
            'Fe',
            'Zn',
            'Ag',
            'As',
            'Au',
            'B' ,
            'Ba',
            'Be',
            'Bi',
            'Ca',
            'Cd',
            'Ce',
            'Co',
            'Cr',
            'Cs',
            'Cu',
            'Ga',
            'Ge',
            'Hg',
            'In',
            'K' ,
            'La',
            'Li',
            'Mg',
            'Mn',
            'Mo',
            'Na',
            'Nb',
            'Ni',
            'P',
            'Pb',
            'Pd',
            'Pt',
            'Rb',
            'Re',
            'Rh',
            'Ru',
            'S',
            'Sb',
            'Se',
            'Sr',
            'Ta',
            'Tb',
            'Te',
            'Th',
            'Ti',
            'Tl',
            'U',
            'V',
            'W',
            'Y',
            'Zr',
            'F',
            'Cl',
            'Parameter_A',
            'Impurity_A',
            'Impurity_B',
            'Impurity_C',
            'Impurity_D',
            'Impurity_E',
            'Impurity_F',
            '1H_NMR',
            'Other_Metals',
            'Parameter_B',
            'Parameter_C',
            'Parameter_D',
            'Organic_impurity',
            '2_2ppm',
            '3_8ppm',
            '4_0ppm',
            'Sum223840',     
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
        // $todos = DB::table('sampling_records')->whereDate('sampling_date', '>=', '2020-01-01')->orderBy('id','desc')->get(); 
        // $user = $_SERVER['REMOTE_USER'];
        // var_dump($user);  // e.g. root or www-data 

        $todos = DB::table('sampling_records')->orderBy('id','desc')->first();  

        return view('SamplingRecord.SamplingRecordTest',[
            'todos' => $todos
        ]);
    }
    public function ComboboxItem(Request $request)
    {    
        //dd($request);    
        $product_name = DB::table('sampling_records')->select('product_name')->distinct()->get();
        $level = DB::table('sampling_records')->select('level')->distinct()->get();
        $sampler = DB::table('sampling_records')->select('sampler')->distinct()->get();
        $sample_source = DB::table('sampling_records')->select('sample_source')->distinct()->get();
        $analytical_item = DB::table('sampling_records')->select('analytical_item')->distinct()->get();
        $analyst = DB::table('sampling_records')->select('analyst')->distinct()->get();
        $determination = DB::table('sampling_records')->select('determination')->distinct()->get();
      
        return response()->json([
            //'success' => $todos,
            'product_name' => $product_name,
            'level' => $level,
            'sampler' => $sampler,
            'sample_source' => $sample_source,
            'analytical_item' => $analytical_item,
            'analyst' => $analyst,
            'determination' => $determination,
        ]);     
    }


    public function GetproductSPEC(Request $request)
    {    
        //dd($request);    
        $product_tmal = DB::table('product_spec_tmal')->get();
        $product_mo = DB::table('product_spec_mo')->get();
        $product_pdmat = DB::table('product_spec_pdmat')->get();
        $product_cctba = DB::table('product_spec_cctba')->get();
        $product_alexa = DB::table('product_spec_alexa')->get();
      
        return response()->json([
            //'success' => $todos,
            'product_tmal' => $product_tmal,
            'product_mo' => $product_mo,
            'product_pdmat' => $product_pdmat,
            'product_cctba' => $product_cctba,
            'product_alexa' => $product_alexa,
        ]);     
    }

    public function GetAuthority(Request $request)
    {    
        $User = $request->all();    
        $Result = DB::table('sampling_records_permissions')->
        leftJoin('sampling_records_accounts','sampling_records_permissions.Group_Name', 'sampling_records_accounts.Group_Name')->
        where('sampling_records_accounts.User_Account', '=', $User["User"])->get();
        return response()->json([
            'success' => $Result,        
        ]);     
    }
    public function GetUserName(Request $request)
    {    
        $User = $request->all();    
        $Result = DB::table('sampling_records_accounts')->
        where('User_Account', '=', $User["User"])->get();
        return response()->json([
            'success' => $Result,        
        ]);     
    }

    //從ID中獲取資料庫相對應的內容
    public function GetDataFromID( Request $request )
    {    
        $Data = $request->all();
        $DownLoadValue = [];
        $query = DB::table("sampling_records");
        foreach ($Data["postData"] as $i)
        {              
            $query = $query->orwhere('id', '=', $i); 
        }
        $DownLoadValue = $query->orderBy( 'id', 'asc')->get();    
        return response()->json([
            'success' => $DownLoadValue,        
        ]);     
    }

    
    //This is the controller show
    public function showOperLog( Request $request )
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
            case "/SamplingRecord/showOperLog":
                $table = 'sampling_records_operlog';
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

    public function Translate($col)
    {   
        $dbCol = [
            'id' => '編號',                
            'urgent' => '急件',
            'sampling_date' => '取樣日期',
            'product_name' => '品名',
            'level' => '等級',
            'bottle_number' => '瓶號',
            'batch_number' => '批號',
            'sampler' => '取樣者',
            'sample_source' => '樣品來源',
            'analytical_item' => '分析項目',
            'analyst' => '分析者',
            'completion_date' => '完成日',
            'determination' => '判定',
            'remarks' => '備註',
            'Parameter_A' => 'Parameter A',
            'Impurity_A' => 'Impurity A',
            'Impurity_B' => 'Impurity B',
            'Impurity_C' => 'Impurity C',
            'Impurity_D' => 'Impurity D',
            'Impurity_E' => 'Impurity E',
            'Impurity_F' => 'Impurity F',
            '1H_NMR' => '1H NMR',
            'Other_Metals' => 'Other Metals',
            'Parameter_B' => 'Parameter B',
            'Parameter_C' => 'Parameter C',
            'Parameter_D' => 'Parameter D',
            'Organic_impurity' => 'Organic impurity',
            '2_2ppm' => '[δ2.2ppm]',
            '3_8ppm' => '[δ3.8ppm]',
            '4_0ppm' => '[δ4.0ppm]',
            'Sum223840' => 'Sum[2.2+3.8+4.0]',              
        ];

        if (array_key_exists($col, $dbCol))
        {
            return $dbCol[$col];
        }   
        else
        {
            return $col;
        }   
    }
}
