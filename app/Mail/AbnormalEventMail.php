<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class AbnormalEventMail extends Mailable
{
    use Queueable, SerializesModels;
 
    public $params;
 
    // 讓外部可以將參數指定進來
    public function __construct($params)
    {
        $this->params = $params;
    }
 
    public function build()
    {
        // 透過 with 把參數指定給 view
        return $this->subject("[SamplingRecords]異常事件通報")
            ->view('Email.AbnormalEventMailView')
            ->with([
                'params' => $this->params,
            ]);
    }
}
