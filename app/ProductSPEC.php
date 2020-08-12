<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductSPEC extends Model
{
 
    public $table = 'product_spec_tmal';
    // //This is Todo Model
    protected $fillable = [
        'id', 'ELEMENT', 'TMALEPU_EPU', 'TMALLO_LO', 'TMALOT_OT', 'TMAL4LED_4LED', 'TMALPG_PG',
        'TMALEG_EG', 'EMMA_TSMCCL', 'TMALforN5_TSMCCL', 'TMALTW_TW', 'TMALEP_EP', 'TMALUM_ProposedSpec'
    ];

    //use BindsDynamically;
    
}

// trait BindsDynamically
// {
//     protected $connection = null;
//     protected $table = null;

//     public function bind(string $connection, string $table)
//     {
//        $this->setConnection($connection);
//        $this->setTable($table);
//     }

//     public function newInstance($attributes = [], $exists = false)
//     {
//        // Overridden in order to allow for late table binding.

//        $model = parent::newInstance($attributes, $exists);
//        $model->setTable($this->table);

//        return $model;
//     }

// }






