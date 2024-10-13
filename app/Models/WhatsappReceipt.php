<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\PmsStatement;
use App\Models\PmsTenant;

class WhatsappReceipt extends Model
{
    use HasFactory;

    protected $fillable = [
        'statement_id',
        'pms_tenant_id',
        'message'
    ];

    public function statement()
    {
        return $this->belongsTo(PmsStatement::class,'statement_id');
    }

    public function tenant()
    {
        return $this->belongsTo(PmsTenant::class,'pms_tenant_id');
    }
}
