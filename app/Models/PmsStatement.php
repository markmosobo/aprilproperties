<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\PmsProperty;
use App\Models\PmsTenant;

class PmsStatement extends Model
{
    use HasFactory;

        protected $fillable = 
    [
        'ref_no',
        'pms_property_id',
        'pms_tenant_id',
        'details',
        'total',
        'paid',
        'balance',
        'status',
        'payment_method',
        'mpesa_code',
    ];

    public function tenant()
    {
        return $this->belongsTo(PmsTenant::class,'pms_tenant_id');
    }

    public function property(){
        return $this->belongsTo(PmsProperty::class, 'pms_property_id');
    }

}
