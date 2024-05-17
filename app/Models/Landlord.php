<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Landlord extends Model
{
    use HasFactory;
        protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'phone_no',
        'id_number',
        'address',
        'commission',
        'fixed_commission',
        'address',
        'nid'  
    ];
}
