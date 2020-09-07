<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Solvent_removal extends Model
{
    protected $table = 'solvent_removals';
    //This is Todo Model
    protected $fillable = [
        'solid_Started', 'tank_batch', 'Crude_assay', 'Crude_2_2ppm', 'Crude_3_8ppm', 'Crude_4_0ppm', 'Crude_223840', 
        'crude_batch','Line', 'sol_expect_wt', 'end_Temp', 'solvent_Input', 'solid_output', 'cycle_Time',
        'solid_yield', 'output_system_oxygen', 'glove_box', 'output_time_spent', 'solid_consumed_1',
        'solid_consumed_2', 'solid_consumed_3', 'solid_consumed_4', 'solid_consumed_5'
    ];
}
