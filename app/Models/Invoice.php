<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\PmsProperty;
use App\Models\PmsTenant;
use App\Models\PmsUnit;
use App\Models\PmsStatement;

class Invoice extends Model
{
    use HasFactory;

        protected $fillable = 
    [
        'statement_id',
        'ref_no',
        'pms_property_id',
        'pms_tenant_id',
        'pms_unit_id',
        'details',
        'total',
        'water_bill',
        'status',
    ];

    public function statement()
    {
        return $this->belongsTo(PmsStatement::class,'statement_id');
    }

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
