<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Landlord;
use App\Models\PmsImage;
use App\Models\PmsUnit;

class PmsProperty extends Model
{
    use HasFactory;
        protected $fillable = [
        'name',
        'landlord_id',
        'units_no',
        'commission'
    ];

    public function landlord()
    {
        return $this->belongsTo(Landlord::class,'landlord_id');
    }

    public function images(){
        return $this->hasMany(PmsImage::class, 'property_id');
    }

    public function units()
    {
        return $this->hasMany(PmsUnit::class);
    }
}
