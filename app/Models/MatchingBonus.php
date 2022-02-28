<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MatchingBonus extends Model
{
    use HasFactory;
	protected $table='matching_bonuses';
    protected $fillable = [
        'sponser_id',
        'member_id',
        'point',
		'order_id',
		'user_id',
    ];
}