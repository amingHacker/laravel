<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Container_GdSp extends Model
{
    protected $table = 'container_gdsp';
    //This is Todo Model
    protected $fillable = [
        'id', 'Sampling_date','Equipment', 'StandardBottle', 'ProductName', 'LeftMonitor_A3', 'RightMonitor_A3', 'A3', 'LeftBody_A3', 'RightBody_A3',
        'Body', 'Operator', 'Remark'
        
    ];
}
