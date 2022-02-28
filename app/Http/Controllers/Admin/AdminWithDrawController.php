<?php

namespace App\Http\Controllers\Admin;
use DB;
use App\Http\Controllers\Controller;
use App\Models\MLMRegister;
use App\Models\MLMWithDraw;
use App\Models\Ranking;
use App\Models\User;
use App\Models\MatchingBonus;
use App\Models\DirectSponser;
use App\Models\MLMLoyalityPoint;
use Illuminate\Http\Request;

class AdminWithDrawController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {		
        return view('admin.withdrawbonus.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
		
       $data = MLMWithDraw::all();		
        echo json_encode($data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    // Matching Bonus
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
         //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function approvewithdraw()
    {
		$result=MLMWithDraw::all();
		 //echo '<pre>'; print_r($result[0]->amount);die;
		 $amount =$result[0]->amount;
		 //echo $amount;die;
		 $data=MLMWithDraw::where('id',$_GET['id'])
	                      ->update([
	   'amount_users_will_receive' => DB::raw($result[0]->amount *(5/100)),
						  'status' => 2
						  ]);
		 $arr[]=array(
		 'user_id' => $_GET['id'],
  'loyality_point' => DB::raw($result[0]->amount *(10/100)),
          'status' => 1
		 );
		 $data=MLMLoyalityPoint::insert($arr);
		 return redirect('/admin/withdrawbonus');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
	 
	public function view_user_details()
	{
		$result=User::join('m_l_m_withdraw','m_l_m_withdraw.user_id','=','users.id')
		          ->select('m_l_m_withdraw.bonus_type','m_l_m_withdraw.amount','users.name','users.email','users.unique_id','users.total_direct_dponsor','users.total_matching_bonus','users.leadership_bonus')
				  ->where('m_l_m_withdraw.id',$_GET['id'])
				  ->get();
			foreach($result as $data)
		 {
			 $arr[]=array(
			 'name' =>$data->name,
			 'email'=>$data->email,
			 'unique_id'=>$data->unique_id,
			 'bonus_type'=>$data->bonus_type,
			 'amount'=>$data->amount,
			 'total_direct_dponsor'=>$data->total_direct_dponsor,
			 'total_matching_bonus'=>$data->total_matching_bonus,
			 'leadership_bonus'=>$data->leadership_bonus
			 );
		 }
		 //echo '<pre>';print_r($arr);die;
		 echo json_encode($data);				
	}
	
    public function destroy($id)
    {
        //
    }
}
