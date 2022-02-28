<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LeaderShipBonus extends Model
{
    use HasFactory;
	protected $table='leadership_bonus';
    protected $fillable = [
        'sponser_id',
        'member_id',
        'member_name',
        'point',
        'order_id',
    ];
}