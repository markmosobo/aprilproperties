<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\PmsProperty;
use App\Models\PmsTenant;
use App\Models\PmsUnit;

class PmsStatement extends Model
{
    use HasFactory;

        protected $fillable = 
    [
        'ref_no',
        'pms_property_id',
        'pms_tenant_id',
        'pms_unit_id',
        'unit_number',
        'details',
        'total',
        'paid',
        'balance',
        'water_bill',
        'electricity_bill',
        'status',
        'payment_method',
        'mpesa_code',
        'sms_status',
        'rent_month',
        'paid_at'
    ];

    public function tenant()
    {
        return $this->belongsTo(PmsTenant::class,'pms_tenant_id');
    }

    public function property(){
        return $this->belongsTo(PmsProperty::class, 'pms_property_id');
    }

    public function unit()
    {
        return $this->belongsTo(PmsUnit::class,'pms_unit_id');
    }

}
