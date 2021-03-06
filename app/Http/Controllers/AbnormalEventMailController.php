<?php

namespace App\Http\Controllers;

use DB;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Mail\AbnormalEventMail;
use Illuminate\Support\Facades\Mail;

class AbnormalEventMailController extends Controller
{
    public function send(Request $request)
    {
        $Parameter = $request->all();
        $MailToMember = explode("," ,$Parameter["MailToMember"]);

        $MailArray = [];
        //dd($MailToMember);
        foreach ($MailToMember as $i)
        {
            if ($i != ''){
                $isExist = DB::table("sampling_records_accounts")->where("SPC_Group_Name", $i)->get();
                // var_dump($isExist);
                if ($isExist)
                {
                    foreach($isExist as $j)
                    {
                        $pushData["name"] = $j->User_Name;
                        $pushData["email"] = $j->User_Email;
                        array_push($MailArray , $pushData);
                    }
                }                        
            }
        }
        
        // dd($MailArray);
        // 收件者務必使用 collect 指定二維陣列，每個項目務必包含 "name", "email"
        $to = collect(
            // [    
            //      ['name' => 'Aming Huang', 'email' => 'aming.huang@merckgroup.com'],
            //      ['name' => 'Mason Wang', 'email' => 'chia-hsien.wang@merckgroup.com'],
            // ]
            $MailArray,
        );

        // dd($to);
 
        // 提供給模板的參數
        $params = [
            // 'say' => "SamplingRecordsID:".$Parameter["id"].", "."AbnormalEvent:".$Parameter["JudgeComment"]
            "id" => $Parameter["id"],
            "product_name" => $Parameter["product_name"],
            "level" => $Parameter["level"],
            "batch_number" => $Parameter["batch_number"],
            "equipment_name" => $Parameter["equipment_name"],
            "remarks" => $Parameter["remarks"],
            "JudgeComment"=> $Parameter["JudgeComment"],
        ];
 
        // 若要直接檢視模板
        // echo (new Warning($data))->render();die;
 
        Mail::to($to)->send(new AbnormalEventMail($params));

        return response()->json([
            'success' => "OK",
        ]);    
    }
}
