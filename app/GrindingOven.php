<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GrindingOven extends Model
{
    protected $table = 'grindingovens';
    //This is Todo Model
    protected $fillable = [
        'Filling_Date', 'sap_batch', 'sap_batch_actual_assay', 'sap_batch_actual_meo', 'Op',
        'serial_number', 'Main_bubbler_tank', '1st_bulk_batch', '1st_bulk_wt', '1st_tank_batch',
        '2nd_bulk_batch', '2nd_bulk_wt', '2nd_tank_batch', '3rd_bulk_batch', '3rd_bulk_wt',
        '3rd_tank_batch', '1st_bulk_assay', '1st_bulk_meo', '2nd_bulk_assay', '2nd_bulk_meo',
        '3rd_bulk_assay', '3rd_bulk_meo', 'expect_assay', 'expect_meo', 'PDMAT_g', 's_75um',
        'grinding_time_h', 'glove_box', 'input_system_oxygen', 'output_system_oxygen',
        'input_system_moisture', 'output_system_moisture', 'Q_Time', 'Oven', 'anneal_seat',
        '0_0_ppm', 'Remark', 'Material', 'pressure_Drop_Via_bypass', 'pressure_Drop_Via_body' 
    ];
}
