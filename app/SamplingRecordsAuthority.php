<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SamplingRecordsAuthority extends Model
{
    protected $table = 'product_spec_tmal';
    // //This is Todo Model
    protected $fillable = [
        'id', 'ELEMENT', 'TMALEPU_EPU', 'TMALLO_LO', 'TMALOT_OT', 'TMAL4LED_4LED', 'TMALPG_PG',
        'TMALEG_EG', 'EMMA_TSMCCL', 'TMALforN5_TSMCCL', 'TMALTW_TW', 'TMALEP_EP', 'TMALUM_ProposedSpec'
    ];
}
