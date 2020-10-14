<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Container_GdSp extends Model
{
    protected $table = 'container_gdsp';
    //This is Todo Model
    protected $fillable = [
        'id', 'Sampling_date','Equipment', 'StandardBottle', 'ProductName', 'LeftMonitor_A3', 'RightMonitor_A3', 'A3', 'LeftMonitor_Body', 'RightMonitor_Body',
        'Body', 'Operator', 'Remark', 'OriginalPipe', 'OriginalA3',	'OriginalBody', 'LeftMonitor_PipeCorrection', 'RightMonitor_PipeCorrection', 'PipeCorrection'	
        
    ];
}
