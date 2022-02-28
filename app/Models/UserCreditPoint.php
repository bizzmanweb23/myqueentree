<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserCreditPoint extends Model
{
	
    use HasFactory;
	protected $table='redeem_credit_points';
    protected $fillable = [
	    'user_id',
		'credit_points',
		'status'
    ];
}