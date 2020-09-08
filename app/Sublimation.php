<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sublimation extends Model
{
    protected $table = 'sublimations';
    //This is Todo Model
    protected $fillable = [
        'bulk_started', 'remark', '1st_crude_batch', '1st_crude_wt', '1st_tank_batch', '2nd_crude_batch',
        '2nd_crude_wt', '2nd_tank_batch', '3rd_crude_batch', '3rd_crude_wt', '3rd_tank_batch',
        'bulk_batch', 'bulk_actual_assay', 'bulk_actual_meo', 'judge',
        'Impurity_A', 'Impurity_B', 'Impurity_C', 'Impurity_D', 'Impurity_E', 'Impurity_F', 
        'glove_box', 'mantle', 'PLC_status',    
        'input_op', 'solid_input', 'output_op', 'bulk_output', 'bulk_yield', 'input_system_oxygen',
        'pre_system_Pump', 'pre_system_torr', 'output_system_oxygen', 'top_Mantle_end', 'top_Tapes_end',
        'top_Coolant_end', 'top_Turbo_end', 'top_Oxygen_end', 'main_Mantle_end', 'main_Tapes_end',
        'main_Coolant_end', 'main_Turbo_end', 'main_Oxygen_end'

    ];
}
