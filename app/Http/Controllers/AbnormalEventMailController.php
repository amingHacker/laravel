<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Mail\AbnormalEventMail;
use Illuminate\Support\Facades\Mail;

class AbnormalEventMailController extends Controller
{
    public function send(Request $request)
    {
        $Parameter = $request->all();
        // dd($Parameter);
        // 收件者務必使用 collect 指定二維陣列，每個項目務必包含 "name", "email"
        $to = collect([
            ['name' => 'Aming Huang', 'email' => 'aming.huang@merckgroup.com'],
            // ['name' => 'Mason Wang', 'email' => 'chia-hsien.wang@merckgroup.com'],
    
        ]);
 
        // 提供給模板的參數
        $params = [
            // 'say' => "SamplingRecordsID:".$Parameter["id"].", "."AbnormalEvent:".$Parameter["JudgeComment"]
            "id" => $Parameter["id"],
            "product_name" => $Parameter["product_name"],
            "level" => $Parameter["level"],
            "batch_number" => $Parameter["batch_number"],
            "equipment_name" => $Parameter["equipment_name"],
            "JudgeComment"=> $Parameter["JudgeComment"],
        ];
 
        // 若要直接檢視模板
        // echo (new Warning($data))->render();die;
 
        Mail::to($to)->send(new AbnormalEventMail($params));
    }
}
