<?php

namespace App\Http\Controllers;

use DB;
use Illuminate\Http\Request;
use Validator;
use PhpOffice\PhpWord\TemplateProcessor; // PhpWord

class InventoryInstockController extends Controller
{
    //This is the controller index
    public function index( Request $request )
    {      
        $todosInventoryInstock = DB::connection('mysqlinventory')->table('inventory_instock')->orderBy('Material','desc')->first();
        $todosInventoryShipment = DB::connection('mysqlinventory')->table('inventory_shipment')->orderBy('Delivery','desc')->first();
    
        return view('Inventory.InventoryInstock',[
            'todosInventoryInstock' => $todosInventoryInstock,
            'todosInventoryShipment' => $todosInventoryShipment,
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
            case "/InventoryInstock/show/InventoryInstock":
                $table = 'inventory_instock';
                break;
            case "/InventoryInstock/show/InventoryShipment":
                $table = 'inventory_shipment';
                break;
        }
        // var_dump($_SERVER["REDIRECT_URL"]);

        $queryTemp = DB::connection('mysqlinventory')->table($table);
        
        //處理UserFilter
        if($pageInf["UserFilter"]!="")
        {
            $_UserFilter = explode(",",$pageInf["UserFilter"]);
            foreach ($_UserFilter as $i)
            {
                if($i != "")
                {
                    $queryTemp = $queryTemp->orwhere("Material_Description",$i);
                }
            }
            
        }

        $query = DB::connection('mysqlinventory')->table(DB::connection('mysqlinventory')->raw('(' . $queryTemp->toSql() . ') as t'))->mergeBindings($queryTemp);
        
        if ($pageInf["_search"] == 'true')
        {
            $tmp = get_object_vars(json_decode($pageInf["filters"])); //先把字串轉成obj,再轉成array形式運用
            $query = $this->Recursive($tmp, $query);
          
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


    public function Recursive($tmp, $query)
    {
        $tmp = (array)$tmp;
        if (array_key_exists("groups", $tmp))
        {
            foreach( $tmp["groups"] as $j )
            {
                $j = (array)($j);
                
                
                if($j["groups"] != [])
                {

                    $this->Recursive($j, $query); 
                }
                else
                {
                    foreach ($j["rules"] as $i)
                    {
                        $rules = get_object_vars($i);      
                        $searchGroupOp = $j["groupOp"];
                        $field = $rules["field"];
                        $op = $rules["op"];
                        $SearchData = $rules["data"];
                        
                        switch ($op){
                            case "eq":
                                $query = $searchGroupOp == 'AND'? $query->where($field, $SearchData):$query->orwhere($field, $SearchData);
                                break;
                            case "ne":
                                $query = $searchGroupOp == 'AND'? $query->where($field, '!=', $SearchData):$query->orwhere($field, '!=', $SearchData);
                                break;
                            case "bw":
                                $query = $searchGroupOp == 'AND'? $query->where($field, 'like', '%'.$SearchData.'%'):$query->orwhere($field, 'like', '%'.$SearchData.'%');
                                break;
                            case "bn":
                                $query = $searchGroupOp == 'AND'? $query->where($field, 'not like', '%'.$SearchData.'%'):$query->orwhere($field, 'not like', '%'.$SearchData.'%');
                                break;
                            case "ew":
                                $query = $searchGroupOp == 'AND'? $query->where($field, 'like', '%'.$SearchData.'%'):$query->orwhere($field, 'like', '%'.$SearchData.'%');
                                break;
                            case "en":
                                $query = $searchGroupOp == 'AND'? $query->where($field, 'not like', '%'.$SearchData.'%'):$query->orwhere($field, 'not like', '%'.$SearchData.'%');
                                break;
                            case "cn":
                                $query = $searchGroupOp == 'AND'? $query->where($field, 'like', '%'.$SearchData.'%'):$query->orwhere($field, 'like', '%'.$SearchData.'%');
                                break;
                            case "nc":
                                $query = $searchGroupOp == 'AND'? $query->where($field, 'not like', '%'.$SearchData.'%'):$query->orwhere($field, 'not like', '%'.$SearchData.'%');
                                break;
                            case "nu":
                                $query = $searchGroupOp == 'AND'? $query->whereNull($field):$query->orwhereNull($field);
                                break;
                            case "nn":
                                $query = $searchGroupOp == 'AND'? $query->whereNotNull($field):$query->orwhereNotNull($field);
                                break;
                            case "in":
                                $query = $searchGroupOp == 'AND'? $query->whereIn($field, $SearchData):$query->orwhereIn($field, $SearchData);
                                break;
                            case "ni":
                                $query = $searchGroupOp == 'AND'? $query->whereNotIn($field, $SearchData):$query->orwhereNotIn($field, $SearchData);
                                break;
                            case "lt":
                                $query = $searchGroupOp == 'AND'? $query->where($field,'<', $SearchData):$query->orwhere($field,'<', $SearchData);
                                break;
                            case "le":
                                $query = $searchGroupOp == 'AND'? $query->where($field,'<=', $SearchData):$query->orwhere($field,'<=', $SearchData);
                                break;
                            case "gt":
                                $query = $searchGroupOp == 'AND'? $query->where($field,'>', $SearchData):$query->orwhere($field,'>', $SearchData);
                                break;
                            case "ge":
                                $query = $searchGroupOp == 'AND'? $query->where($field,'>=', $SearchData):$query->orwhere($field,'>=', $SearchData);
                                break;
                        }   
                    }
                }
            }
            // var_dump($query->toSql());

            $query = DB::connection('mysqlinventory')->table(DB::connection('mysqlinventory')->raw('(' . $query->toSql() . ') as t'))->mergeBindings($query);
            

            foreach ($tmp["rules"] as $i)
            {
                $rules = get_object_vars($i);      
                $searchGroupOp = $tmp["groupOp"];
                $field = $rules["field"];
                $op = $rules["op"];
                $SearchData = $rules["data"];
                
                switch ($op){
                    case "eq":
                        $query = $searchGroupOp == 'AND'? $query->where($field, $SearchData):$query->orwhere($field, $SearchData);
                        break;
                    case "ne":
                        $query = $searchGroupOp == 'AND'? $query->where($field, '!=', $SearchData):$query->orwhere($field, '!=', $SearchData);
                        break;
                    case "bw":
                        $query = $searchGroupOp == 'AND'? $query->where($field, 'like', '%'.$SearchData.'%'):$query->orwhere($field, 'like', '%'.$SearchData.'%');
                        break;
                    case "bn":
                        $query = $searchGroupOp == 'AND'? $query->where($field, 'not like', '%'.$SearchData.'%'):$query->orwhere($field, 'not like', '%'.$SearchData.'%');
                        break;
                    case "ew":
                        $query = $searchGroupOp == 'AND'? $query->where($field, 'like', '%'.$SearchData.'%'):$query->orwhere($field, 'like', '%'.$SearchData.'%');
                        break;
                    case "en":
                        $query = $searchGroupOp == 'AND'? $query->where($field, 'not like', '%'.$SearchData.'%'):$query->orwhere($field, 'not like', '%'.$SearchData.'%');
                        break;
                    case "cn":
                        $query = $searchGroupOp == 'AND'? $query->where($field, 'like', '%'.$SearchData.'%'):$query->orwhere($field, 'like', '%'.$SearchData.'%');
                        break;
                    case "nc":
                        $query = $searchGroupOp == 'AND'? $query->where($field, 'not like', '%'.$SearchData.'%'):$query->orwhere($field, 'not like', '%'.$SearchData.'%');
                        break;
                    case "nu":
                        $query = $searchGroupOp == 'AND'? $query->whereNull($field):$query->orwhereNull($field);
                        break;
                    case "nn":
                        $query = $searchGroupOp == 'AND'? $query->whereNotNull($field):$query->orwhereNotNull($field);
                        break;
                    case "in":
                        $query = $searchGroupOp == 'AND'? $query->whereIn($field, $SearchData):$query->orwhereIn($field, $SearchData);
                        break;
                    case "ni":
                        $query = $searchGroupOp == 'AND'? $query->whereNotIn($field, $SearchData):$query->orwhereNotIn($field, $SearchData);
                        break;
                    case "lt":
                        $query = $searchGroupOp == 'AND'? $query->where($field,'<', $SearchData):$query->orwhere($field,'<', $SearchData);
                        break;
                    case "le":
                        $query = $searchGroupOp == 'AND'? $query->where($field,'<=', $SearchData):$query->orwhere($field,'<=', $SearchData);
                        break;
                    case "gt":
                        $query = $searchGroupOp == 'AND'? $query->where($field,'>', $SearchData):$query->orwhere($field,'>', $SearchData);
                        break;
                    case "ge":
                        $query = $searchGroupOp == 'AND'? $query->where($field,'>=', $SearchData):$query->orwhere($field,'>=', $SearchData);
                        break;
                }   
            }

            $query = DB::connection('mysqlinventory')->table(DB::connection('mysqlinventory')->raw('(' . $query->toSql() . ') as t'))->mergeBindings($query);
        }
        else
        {

            foreach ($tmp["rules"] as $i)
            {
                $rules = get_object_vars($i);      
                $searchGroupOp = $tmp["groupOp"];
                $field = $rules["field"];
                $op = $rules["op"];
                $SearchData = $rules["data"];
                
                switch ($op){
                    case "eq":
                        $query = $searchGroupOp == 'AND'? $query->where($field, $SearchData):$query->orwhere($field, $SearchData);
                        break;
                    case "ne":
                        $query = $searchGroupOp == 'AND'? $query->where($field, '!=', $SearchData):$query->orwhere($field, '!=', $SearchData);
                        break;
                    case "bw":
                        $query = $searchGroupOp == 'AND'? $query->where($field, 'like', '%'.$SearchData.'%'):$query->orwhere($field, 'like', '%'.$SearchData.'%');
                        break;
                    case "bn":
                        $query = $searchGroupOp == 'AND'? $query->where($field, 'not like', '%'.$SearchData.'%'):$query->orwhere($field, 'not like', '%'.$SearchData.'%');
                        break;
                    case "ew":
                        $query = $searchGroupOp == 'AND'? $query->where($field, 'like', '%'.$SearchData.'%'):$query->orwhere($field, 'like', '%'.$SearchData.'%');
                        break;
                    case "en":
                        $query = $searchGroupOp == 'AND'? $query->where($field, 'not like', '%'.$SearchData.'%'):$query->orwhere($field, 'not like', '%'.$SearchData.'%');
                        break;
                    case "cn":
                        $query = $searchGroupOp == 'AND'? $query->where($field, 'like', '%'.$SearchData.'%'):$query->orwhere($field, 'like', '%'.$SearchData.'%');
                        break;
                    case "nc":
                        $query = $searchGroupOp == 'AND'? $query->where($field, 'not like', '%'.$SearchData.'%'):$query->orwhere($field, 'not like', '%'.$SearchData.'%');
                        break;
                    case "nu":
                        $query = $searchGroupOp == 'AND'? $query->whereNull($field):$query->orwhereNull($field);
                        break;
                    case "nn":
                        $query = $searchGroupOp == 'AND'? $query->whereNotNull($field):$query->orwhereNotNull($field);
                        break;
                    case "in":
                        $query = $searchGroupOp == 'AND'? $query->whereIn($field, $SearchData):$query->orwhereIn($field, $SearchData);
                        break;
                    case "ni":
                        $query = $searchGroupOp == 'AND'? $query->whereNotIn($field, $SearchData):$query->orwhereNotIn($field, $SearchData);
                        break;
                    case "lt":
                        $query = $searchGroupOp == 'AND'? $query->where($field,'<', $SearchData):$query->orwhere($field,'<', $SearchData);
                        break;
                    case "le":
                        $query = $searchGroupOp == 'AND'? $query->where($field,'<=', $SearchData):$query->orwhere($field,'<=', $SearchData);
                        break;
                    case "gt":
                        $query = $searchGroupOp == 'AND'? $query->where($field,'>', $SearchData):$query->orwhere($field,'>', $SearchData);
                        break;
                    case "ge":
                        $query = $searchGroupOp == 'AND'? $query->where($field,'>=', $SearchData):$query->orwhere($field,'>=', $SearchData);
                        break;
                }   
            }

            $query = DB::connection('mysqlinventory')->table(DB::connection('mysqlinventory')->raw('(' . $query->toSql() . ') as t'))->mergeBindings($query);
        
        }        
        
        return $query;
    }

    public function object_array($array) {  
        if(is_object($array)) {  
            $array = (array)$array;  
            } 
        if(is_array($array)) {  
        foreach($array as $key=>$value) {  
            $array[$key] = object_array($value);  
            }  
        }  
        return $array;  
    }
    

    //This is the controller Export
    public function Export(Request $request )
    {        
        $downloadReq = $request->all();

        $_search = $downloadReq["postData"]["_search"];  
        $limit = $downloadReq["postData"]["limit"];
        $sidx = ($downloadReq["postData"]["sidx"] == '')? 'id': $downloadReq["postData"]["sidx"];
        $order = ($downloadReq["postData"]["order"] == '')? 'desc': $downloadReq["postData"]["order"];

        $table = '';
        $searchGroupOp = ''; $filed = ''; $op = ''; $SearchData = '';
        $Record = '';
        
        switch ($downloadReq["table"]){
            case 'dgInventoryInstock':
                $table = 'inventory_instock';
                break;
            case 'dgInventoryShipment':
                $table = 'inventory_shipment';
                break;
        }

        $queryTemp = DB::connection('mysqlinventory')->table($table);
        $DownLoadValue = [];

        //處理UserFilter
        if($downloadReq["postData"]["UserFilter"]!="")
        {
            $_UserFilter = explode(",",$downloadReq["postData"]["UserFilter"]);
            foreach ($_UserFilter as $i)
            {
                if($i != "")
                {
                    $queryTemp = $queryTemp->orwhere("Material_Description",$i);
                }
            }
        }

        $query = DB::connection('mysqlinventory')->table(DB::connection('mysqlinventory')->raw('(' . $queryTemp->toSql() . ') as t'))->mergeBindings($queryTemp);
        
        if ($_search == 'true')
        {
            $tmp = get_object_vars(json_decode($downloadReq["postData"]["filters"])); //先把字串轉成obj,再轉成array形式運用
            
            $query = $this->Recursive($tmp, $query);

            $Record = $query->count();

            $DownLoadValue = $query->orderBy( $sidx, 'desc')->get();           
        } 
       
        else
        {     
            
            //dd($Record);
            //$DownLoadValue = DB::connection('mysqlinventory')->table($table)->limit(10000)->orderBy($sidx,'desc')->get();
            $DownLoadValue = $query->orderBy( $sidx, 'desc')->get();
             
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
            case 'dgInventoryInstock':
                $table = 'inventory_instock';
                break;
            case 'dgInventoryShipment':
                $table = 'inventory_shipment';
                break;
        }

        $uploadData["UploadData"]["created_at"] = date('Y-m-d H:i:s');
        $uploadData["UploadData"]["updated_at"] = date('Y-m-d H:i:s');

        $updateData = DB::connection('mysqlinventory')->table($table)->where("Material", $uploadData["UploadData"]["Material"]);
        $isExist = DB::connection('mysqlinventory')->table($table)->where("Material", $uploadData["UploadData"]["Material"])->first();

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
            'success' => $uploadData["UploadData"]["Material"],
        ]);
    }

    //刪除方法
    public function destroy(Request $request)
    {   
        $Parameter = $request->all();
        // dd($Parameter);
        $table = '';
        switch ($Parameter["table"]){
            case 'dgInventoryInstock':
                $table = 'inventory_instock';
                break;
            case 'dgInventoryShipment':
                $table = 'inventory_shipment';
                break;
        }
      
        $deleteData = DB::connection('mysqlinventory')->table($table)->delete($Parameter["Material"]);
        $UpdateValue = DB::connection('mysqlinventory')->table($table)->orderBy('Material','desc')->get(); //回傳原本的資料
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
            case 'dgInventoryInstock':
                $table = 'inventory_instock';
                break;
            case 'dgInventoryShipment':
                $table = 'inventory_shipment';
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
            $updateData = DB::connection('mysqlinventory')->table($table)->where('id', $request->id);
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
            case "/InventoryInstock/GetTable/InventoryInstock":
                $table = 'inventory_instock';
                break;
            case "/InventoryInstock/GetTable/InventoryShipment":
                $table = 'inventory_shipment';
                break;
            
        }
        
        $product_SPEC= DB::connection('mysqlinventory')->table($table)->get();
    
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
        $todo = DB::connection('mysqlinventory')->table($table)->insert(
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
        $Material_Description = DB::connection('mysqlinventory')->table('inventory_instock')->select('Material_Description')->distinct()->get();
        $Storage_Location = DB::connection('mysqlinventory')->table('inventory_instock')->select('Storage_Location')->distinct()->get();
        $Descr_of_Storage_Loc = DB::connection('mysqlinventory')->table('inventory_instock')->select('Descr_of_Storage_Loc')->distinct()->get();
        $Batch = DB::connection('mysqlinventory')->table('inventory_instock')->select('Batch')->distinct()->get();
    
        $Name_of_sold_to_party = DB::connection('mysqlinventory')->table('inventory_shipment')->select('Name_of_sold_to_party')->distinct()->get();
        $Name_of_the_ship_to_party = DB::connection('mysqlinventory')->table('inventory_shipment')->select('Name_of_the_ship_to_party')->distinct()->get();
        $Description = DB::connection('mysqlinventory')->table('inventory_shipment')->select('Description')->distinct()->get();
        $Sold_to_party = DB::connection('mysqlinventory')->table('inventory_shipment')->select('Sold_to_party')->distinct()->get();
        $Ship_to_party = DB::connection('mysqlinventory')->table('inventory_shipment')->select('Ship_to_party')->distinct()->get();
        $Ship_Batch = DB::connection('mysqlinventory')->table('inventory_shipment')->select('Ship_Batch')->distinct()->get();
        $Ship_Material = DB::connection('mysqlinventory')->table('inventory_shipment')->select('Ship_Material')->distinct()->get();
        $Item_category = DB::connection('mysqlinventory')->table('inventory_shipment')->select('Item_category')->distinct()->get();
        $Ship_Storage_Location = DB::connection('mysqlinventory')->table('inventory_shipment')->select('Ship_Storage_Location')->distinct()->get();

        return response()->json([
            'Material_Description' => $Material_Description,
            'Storage_Location' => $Storage_Location,
            'Descr_of_Storage_Loc' => $Descr_of_Storage_Loc,
            'Batch' => $Batch,
            'Name_of_sold_to_party' => $Name_of_sold_to_party,
            'Name_of_the_ship_to_party' => $Name_of_the_ship_to_party,
            'Description' => $Description,
            'Sold_to_party' => $Sold_to_party,
            'Ship_to_party' => $Ship_to_party,
            'Ship_Batch' => $Ship_Batch,
            'Ship_Material' => $Ship_Material,
            'Item_category' => $Item_category,
            'Ship_Storage_Location' => $Ship_Storage_Location,
            

        ]);     
    }

    //從ID中獲取資料庫相對應的內容
    public function GetDataFromID( Request $request )
    {  
        $table = '';
        switch ($_SERVER["REDIRECT_URL"])
        {
            case "/InventoryInstock/GetDataFromID/InventoryInstock":
                $table = 'inventory_instock';
                break;
            case "/InventoryInstock/GetDataFromID/InventoryShipment":
                $table = 'inventory_shipment';
                break;
        }
        
        $Data = $request->all();
        $DownLoadValue = [];
        $query = DB::connection('mysqlinventory')->table($table);
        foreach ($Data["postData"] as $i)
        {              
            $query = $query->orwhere('id', '=', $i); 
        }
        $DownLoadValue = $query->orderBy( 'id', 'asc')->get();    
        return response()->json([
            'success' => $DownLoadValue,        
        ]);     
    }


    //從ID中獲取資料庫相對應的內容
    public function Get_Condition( Request $request )
    {  
        $Data = $request->all();
        
        $table = '';
        $Condition = '';

        switch ($Data["table"]){
            case 'RawMaterial':
                $table = 'inventory_instock';
                $Condition = 'RawMaterial';

                break;
        }


        $Data = $request->all();
        $DownLoadValue = [];
        $query = DB::connection('mysqlinventory')->table($table)->select('Material_Description')->distinct()->get();
                  
        // $query = $query->where('id', '=', $i); 
       
        $DownLoadValue = $query;    
        return response()->json([
            'success' => $DownLoadValue,        
        ]);     
    }

    //從ID中獲取資料庫相對應的內容
    public function FilterSearch( Request $request )
    {  
        $Data = $request->all();
        
        $table = '';
        $Condition = '';

        switch ($Data["table"]){
            case 'RawMaterial':
                $table = 'inventory_instock';
                $Condition = 'RawMaterial';
                break;
        }

        $DownLoadValue = [];
        $query = DB::connection('mysqlinventory')->table($table);
        
        return response()->json([
            'success' => $DownLoadValue,        
        ]);     
    }

    //從我的最愛表格取出資料
    //This is the controller show
    public function MyFavorite( Request $request )
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
            case "/InventoryInstock/MyFavorite":
                $table = 'inventory_myfavorite';
                break;
        }
        // var_dump($_SERVER["REDIRECT_URL"]);

        $query = DB::connection('mysqlinventory')->table($table);

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

    //在我的最愛表格新增和修改
    public function MyFavoriteAddandUpdate(Request $request)
    {      
        $AddParameter = $request->all();
    
        $table = '';
        switch ($AddParameter["table"]){
            case 'viewLog':
                $table = 'inventory_myfavorite';
                break;
        }
        
        $AddParameter["created_at"] = date('Y-m-d H:i:s');
        $AddParameter["updated_at"] = date('Y-m-d H:i:s');
        //dd($AddParameter["urgent"]);      
        if ($request->oper =='add')
        {   
            unset($AddParameter["oper"]);
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
            $updateData = DB::connection('mysqlinventory')->table($table)->where('id', $request->id);
            $updateData->update($AddParameter);
            return response()->json([
                'success' => 'Record update successfully!'
            ]);
    
        }
    }

    //列印Word格式
    public function ExportWord(Request $request)
    {   
        $Data = $request->all();
        $Include = explode(",",$Data["Include"]);
        $Sum = explode(",",$Data["Sum"]);
        
        
        //php 產生word檔
        $phpWord = new \PhpOffice\PhpWord\PhpWord();

        // Adding an empty Section to the document...
        $section = $phpWord->addSection();

        $section->addText("日報表");

        $table = $section->addTable(array('borderColor' => '000000', 'borderSize' => 6, 'cellMargin' => 50));
        $table->addRow();
        $table->addCell(2000)->addText("");
        $table->addCell(2000)->addText("庫存");
        
        for ( $i = 0 ; $i < count($Include) ; $i++ ) 
        {
            $table->addRow();
            $table->addCell(2000)->addText($Include[$i]);
            $table->addCell(2000)->addText($Sum[$i]);
        }

        // Saving the document as OOXML file...
        $objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'Word2007');

        header("Content-Disposition: attachment; filename=日報表.docx");
        $objWriter->save("php://output");
        
        // 一定要有 exit()
        exit();
        
    }
}
