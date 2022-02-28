<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\DirectSponsor;
use App\Models\LeaderShipBonus;
use App\Models\User;
use App\Models\Rating;
use Illuminate\Http\Request;

class APILeaderShipBonusController extends Controller
{
	public function leadership_bonus_list(Request $request)
	{
		$result=User::find($request->user()->id);
		$data = LeaderShipBonus::where('sponser_id', $result->unique_id)->paginate(10);
		$data1=$data->sum('point');
		return response([
            $data,
			'total of leadership bonus' => $data1
        ], 201);
	}
}