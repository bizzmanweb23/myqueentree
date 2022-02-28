<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MLMLoyalityPoint extends Model
{
	
    use HasFactory;
	protected $table='loyality_points_wallet';
    protected $fillable = [
	    'user_id',
        'loyality_point',
        'status',
        'updated_at'
    ];
}