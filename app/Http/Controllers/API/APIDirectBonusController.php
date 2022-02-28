<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\DirectSponsor;
use App\Models\User;
use App\Models\Rating;
use Illuminate\Http\Request;

class APIDirectBonusController extends Controller
{
	public function direct_bonus_list(Request $request)
	{
		$result=User::find($request->user()->id);
		$data = DirectSponsor::where('sponsors_id', $result->unique_id)->paginate(10);
		$total=$data->sum('point');
		return response([
            $data,
			'total of direct bonus' => $total
        ], 201);
	}
}