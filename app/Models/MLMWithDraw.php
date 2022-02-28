<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MLMWithDraw extends Model
{
	
    use HasFactory;
	protected $table='m_l_m_withdraw';
    protected $fillable = [
	    'user_id',
        'bank_name',
        'branch_name',
        'account_name',
		'amount',
		'status',
		'updated_at'
    ];
}