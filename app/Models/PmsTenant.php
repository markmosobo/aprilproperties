<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\PmsProperty;
use App\Models\PmsUnit;

class PmsTenant extends Model
{
    use HasFactory;

        protected $fillable = 
    [
        'first_name',
        'middle_name',
        'last_name',
        'id_number',
        'email_address',
        'phone_number',
        'pms_unit_id',
        'pms_property_id',
        'status',
        'vacated_at'
    ];

    public function unit()
    {
        return $this->belongsTo(PmsUnit::class,'pms_unit_id');
    }

    public function property(){
        return $this->belongsTo(PmsProperty::class, 'pms_property_id');
    }    
}
