<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SamplingRecord extends Model
{
    protected $table = 'sampling_records';
    //This is Todo Model
    protected $fillable = [
        'urgent', 'sampling_date','product_name', 'level', 'bottle_number', 'batch_number',
        'sampler', 'sample_source', 'analytical_item', 'analyst', 'completion_date', 'determination',
        'remarks', 'MeO', 'Assay', 'HC', 'Si', 'Sn', 'Al', 'I', 'Fe', 'Zn', 'Ag',
        'As', 'Au', 'B', 'Ba', 'Be', 'Bi', 'Ca', 'Cd', 'Ce', 'Co', 'Cr', 'Cs', 'Cu', 'Ga',
        'Ge', 'Hg', 'In', 'K', 'La', 'Li', 'Mg', 'Mn', 'Mo', 'Na', 'Nb', 'Ni', 'P',
        'Pb', 'Pd', 'Pt', 'Rb', 'Re', 'Rh', 'Ru', 'S', 'Sb', 'Se', 'Sr', 'Ta', 'Tb',
        'Te', 'Th', 'Ti', 'Tl', 'U', 'V', 'W', 'Y','Zr', 'F', 'Cl', 'Hf', 'H2O','Parameter_A',       
        'Impurity_A', 'Impurity_B', 'Impurity_C', 'Impurity_D', 'Impurity_E', 'Impurity_F',
        '1H_NMR', 'Other_Metals', 'Parameter_B', 'Parameter_C', 'Parameter_D', 'Organic_impurity',
        '0_0ppm', '2_2ppm', '3_8ppm', '4_0ppm', 'Sum223840', 'IR_A', 'DMAH', 'id', 'equipment_name', 'standard_solution',
        'sampling_kind', "Quattro_id", "IPA"
    ];
}
