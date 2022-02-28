<?php

namespace App\Http\Controllers\MLM;
use DB;
use Helper;
use App\Http\Controllers\Controller;
use App\Models\MatchingBonus;
use App\Models\MLMWithDraw;
use App\Models\MLMLoyalityPoint;
use App\Models\User;
use App\Models\Order;
use App\Models\MLMRegister;
use App\Models\Ranking;
use App\Models\UseOfPv;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MLMWithDrawController extends Controller
{
      public function index()
    {
		$data['result']=User::select('total_pv_point','total_direct_dponsor','total_matching_bonus','leadership_bonus')
		          ->where('id',Auth::user()->id)
				  ->get();
		//echo '<pre>';print_r($result);die;
		//echo json_decode($data);
        return view('mlm.withdraw-form.index',$data);
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
            $withdraw_data = $request->validate([
			'bonus_type'              => 'required',
            'bank_name'               => 'required',
            'branch_name'             => 'required',
            'account_name'             => 'required',
            'amount'                  => 'required',
        ], [
		    'bonus_type.required'     => 'Please Enter Bonus Type',
            'bank_name.required'      => 'Please Enter Bank Name',
            'branch_name.required'    => 'Please Enter Branch Name',
            'account_name.required'   => 'Please Enter Account Number',
            'amount.required'         => 'Please Enter Amount',
        ]);
		 
		 //check for withdraw
		 
		 $withdrawamount=User::select('total_pv_point','total_direct_dponsor','total_matching_bonus','leadership_bonus')
		                       ->where('id',Auth::user()->id)
							   ->first();
			//echo '<pre>';print_r($withdrawamount);die;
			//echo '<pre>';print_r($withdraw_data);die;
			if($_POST['bonus_type'] == 1)
			{
			 if((float)$_POST['amount'] <= (float)$withdrawamount->total_direct_dponsor)
			{
               
				$withdraw_data['status'] = 1;
				$withdraw_data['user_id'] = Auth::user()->id;
				//echo '<pre>'; print_r($withdraw_data['amount']);die
				$data=MLMWithDraw::insert($withdraw_data);
				$result=User::where('id',Auth::user()->id)
				              ->update([
							  'total_direct_dponsor'  => DB::raw($withdrawamount->total_direct_dponsor - $_POST['amount'])
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
			if($_POST['bonus_type'] == 2)
			{
			 if((float)$_POST['amount'] <= (float)$withdrawamount->total_matching_bonus)
			{
               
				$withdraw_data['status'] = 1;
				$withdraw_data['user_id'] = Auth::user()->id;
				//echo '<pre>'; print_r($withdraw_data['amount']);die
				$data=MLMWithDraw::insert($withdraw_data);
				$result=User::where('id',Auth::user()->id)
				              ->update([
							  'total_matching_bonus'  => DB::raw($withdrawamount->total_matching_bonus - $_POST['amount'])
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
			if($_POST['bonus_type'] == 3)
			{
			 if((float)$_POST['amount'] <= (float)$withdrawamount->leadership_bonus)
			{
               
				$withdraw_data['status'] = 1;
				$withdraw_data['user_id'] = Auth::user()->id;
				//echo '<pre>'; print_r($withdraw_data['amount']);die
				$data=MLMWithDraw::insert($withdraw_data);
				$result=User::where('id',Auth::user()->id)
				              ->update([
							  'leadership_bonus'  => DB::raw($withdrawamount->leadership_bonus - $_POST['amount'])
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
			if($_POST['bonus_type'] == 4)
			{
			 if((float)$_POST['amount'] <= (float)$withdrawamount->leadership_bonus)
			{
               
				$withdraw_data['status'] = 1;
				$withdraw_data['user_id'] = Auth::user()->id;
				$data=MLMWithDraw::insert($withdraw_data);
				$result=User::where('id',Auth::user()->id)
				              ->update([
							  'leadership_bonus'  => DB::raw($withdrawamount->leadership_bonus - $_POST['amount'])
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
	}
			
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
}
