<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MLMRegister;
use App\Models\Ranking;
use App\Models\MatchingBonus;
use App\Models\DirectSponsor;
use Illuminate\Http\Request;

class AdminDirectSponserController extends Controller
{
	
 public function index()
 {
	 						  
	 return view ('admin.affilatemarketing.directbonus.index');
 }

 public function create()
    {		
	    $data = DirectSponsor::join('rankings','rankings.id','=','direct_sponsors.rank_id','left')
		                      ->select('rankings.details','direct_sponsors.sponsors_id','direct_sponsors.member_id','direct_sponsors.member_name','direct_sponsors.point')
							  ->get();
	     //echo '<pre>';print_r($data);die;
        echo json_encode($data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

}
?>