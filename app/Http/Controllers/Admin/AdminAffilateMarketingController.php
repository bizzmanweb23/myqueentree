<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MLMRegister;
use App\Models\Ranking;
use App\Models\User;
use App\Models\MatchingBonus;
use App\Models\DirectSponser;
use Illuminate\Http\Request;

class AdminAffilateMarketingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {		
        return view('admin.affilatemarketing.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
		
        $data = MLMRegister::join('rankings','rankings.id','=','m_l_m_registers.ranking','left')
		                     ->select('m_l_m_registers.id','rankings.details','m_l_m_registers.user_id','m_l_m_registers.sponser_id','m_l_m_registers.member_id','m_l_m_registers.member_name','m_l_m_registers.email')
							 ->get();
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
	 public function view_affilate_details()
    {
       $result=MLMRegister::join('users','users.id','=','m_l_m_registers.user_id','left')
		                     ->select('m_l_m_registers.id','users.rank_id','m_l_m_registers.user_id','users.id','m_l_m_registers.sponser_id','m_l_m_registers.member_id','m_l_m_registers.member_name','m_l_m_registers.email','users.total_pv_point','users.total_direct_dponsor','users.total_matching_bonus','users.leadership_bonus')
							 ->Where('m_l_m_registers.id',$_GET['id'])
							 ->get();
	     //echo '<pre>';print_r($data);die
		 foreach($result as $data)
		 {
			 $arr[]=array(
			 'id'    =>$data->id,
			 'rank_id'=>$data->rank_id,
			 'sponser_id'=>$data->sponser_id,
			 'member_id'=>$data->member_id,
			 'member_name'=>$data->member_name,
			 'email'=>$data->email,
			 'total_pv_point'=>$data->total_pv_point,
			 'total_direct_dponsor'=>$data->total_direct_dponsor,
			 'total_matching_bonus'=>$data->total_matching_bonus,
			 'leadership_bonus'=>$data->leadership_bonus
			 );
		 }
		 //echo '<pre>';print_r($arr);die;
		 echo json_encode($data);
    }
	 
    public function get_affilate_details()
    {
       $result=MLMRegister::join('users','users.id','=','m_l_m_registers.user_id','left')
		                     ->select('m_l_m_registers.id','users.rank_id','m_l_m_registers.user_id','users.id','m_l_m_registers.sponser_id','m_l_m_registers.member_id','m_l_m_registers.member_name','m_l_m_registers.email','users.total_pv_point','users.total_direct_dponsor','users.total_matching_bonus','users.leadership_bonus')
							 ->Where('m_l_m_registers.id',$_GET['id'])
							 ->get();
	     //echo '<pre>';print_r($data);die
		 foreach($result as $data)
		 {
			 $arr[]=array(
			 'id'    =>$data->id,
			 'rank_id'=>$data->rank_id,
			 'sponser_id'=>$data->sponser_id,
			 'member_id'=>$data->member_id,
			 'member_name'=>$data->member_name,
			 'email'=>$data->email,
			 'total_pv_point'=>$data->total_pv_point,
			 'total_direct_dponsor'=>$data->total_direct_dponsor,
			 'total_matching_bonus'=>$data->total_matching_bonus,
			 'leadership_bonus'=>$data->leadership_bonus
			 );
		 }
		 //echo '<pre>';print_r($arr);die;
		 echo json_encode($data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
	 
	public function edit_affilate_details(Request $request)
	{
		$id= $request->id;
		$data = $request->validate([
            'rank_id'  => 'required',
            'sponserID'  => 'required',
            'memberID'  => 'required',
            'memberName'  => 'required',
            'emailAddress'      => 'required',
            'pv_points'      => 'required|numeric',
            'directBonus'      => 'required|numeric',
            'matchingBonus'      => 'required|numeric',
            'leadershipBonus'      => 'required|numeric',
        ]);
		$result=User::get();
		$arr=array(
		       'rank_id' =>$_POST['rank_id'],
			   'email'   =>$_POST['emailAddress'],
        'total_pv_point' =>$_POST['pv_points'],
  'total_direct_dponsor' =>$_POST['directBonus'],
  'total_matching_bonus' =>$_POST['matchingBonus'],
	  'leadership_bonus' =>$_POST['leadershipBonus']
	  );
        $data = User::where('id', $id)->update($arr);
        echo json_encode(['status' => 'success', 'message' => 'User Update Successfully']);
	}
	 
	 
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
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}