<?php

namespace App\Http\Controllers\MLM;
use DB;
use Helper;
use App\Http\Controllers\Controller;
use App\Models\MatchingBonus;
use App\Models\MLMWithDraw;
use App\Models\MLMLoyalityPoint;
use App\Models\RedeemLoyalityPoint;
use App\Models\User;
use App\Models\Order;
use App\Models\MLMRegister;
use App\Models\Ranking;
use App\Models\UseOfPv;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MLMLoyalityPointsContoller extends Controller
{
      public function index()
    {
		$data['result']=MLMLoyalityPoint::where('user_id',Auth::user()->id)->sum('loyality_point');
		//echo $data;die;
        return view('mlm.loyalitypoint-form.index',$data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
 
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $creditWallet_data = $request->validate([
			'credit_points'              => 'required',
        ], [
		    'credit_points.required'     => 'Please Enter Credit Bonus',
        ]);
	    $creditWallet=MLMLoyalityPoint::join('users','users.id','=','loyality_points_wallet.user_id','left')
		                                ->select('loyality_point','wallet')
		                                ->where('user_id',Auth::user()->id)
							            ->get();
						//echo '<pre>';print_r($withdrawcredit);die;
				if($_POST['credit_points'] <= $creditWallet[0]->loyality_point)
			{
                $creditWallet_data['status'] = 1;
				$creditWallet_data['user_id'] = Auth::user()->id;
				$creditWallet_data['redemption_date'] = date('Y-m-d');
				$data=RedeemLoyalityPoint::insert($creditWallet_data);
				$result=MLMLoyalityPoint::where('id',Auth::user()->id)
				              ->update([
							  'loyality_point'  => DB::raw($creditWallet[0]->loyality_point - $_POST['credit_points'])
							  ]);
				$walletUpdate=User::where('id',Auth::user()->id)
				              ->update([
							  'Wallet'  => DB::raw($creditWallet[0]->wallet + $_POST['credit_points'])
							  ]);
				 //echo '<pre>';print_r($data);die;
			    echo json_encode(['status' => 'success', 'message' => 'WithDraw Request Succesfully Submitted']);
			}
			else
			{
				//die('else');
			 echo json_encode(['status' => 'danger', 'message' => 'You Does Not Have Sufficient PV Point']);
			}	
	}
	
	public function get_loyalitypoint_history()
    {
        $data = MLMLoyalityPoint::join('users', 'users.id', '=', 'loyality_points_wallet.user_id')
            ->select('users.name', 'loyality_points_wallet.loyality_point','loyality_points_wallet.updated_at as date')
            ->where('loyality_points_wallet.user_id', Auth::user()->id)
			->get();
			//echo '<pre>'; print_r($data);die;
             echo json_encode($data);
    }
	
	public function redeem_loyality_bonus()
    {
        $data = RedeemLoyalityPoint::join('users', 'users.id', '=', 'withdraw_loyalitypoints_details.user_id')
            ->select('users.name', 'withdraw_loyalitypoints_details.*')
            ->where('withdraw_loyalitypoints_details.user_id', Auth::user()->id)->get();
			//echo '<pre>'; print_r($data);die;
             echo json_encode($data);
    }
	
	public function redeem_full_loyality_bonus()
	{
		$data=MLMLoyalityPoint::where('user_id',Auth::user()->id)
				  ->sum('loyality_point');
		//echo '<pre>';print_r($result);die;
		echo json_encode($data);
	}

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
}