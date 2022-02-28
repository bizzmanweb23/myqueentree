<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MLMRegister;
use App\Models\Ranking;
use App\Models\MatchingBonus;
use App\Models\LeadershipBonus;
use App\Models\DirectSponser;
use Illuminate\Http\Request;

class AdminLeadershipBonusController extends Controller
{
	
 public function index()
 {
	 return view ('admin.affilatemarketing.leadership.index');
 }

 public function create()
    {		
	    $data = LeadershipBonus::get();
        echo json_encode($data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

}
?>