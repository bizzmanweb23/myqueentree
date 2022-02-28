<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\MatchingBonus;
use App\Models\User;
use App\Models\Rating;
use Illuminate\Http\Request;

class APIMatchingBonusController extends Controller
{
	public function matching_bonus_list(Request $request)
	{
		$result=User::find($request->user()->id);
		$data = MatchingBonus::where('user_id', $result->id)->paginate(10);
		$total= $data->sum('point');
		return response([
            $data,
			'total of matching bonus' => $total
        ], 201);
	}
}