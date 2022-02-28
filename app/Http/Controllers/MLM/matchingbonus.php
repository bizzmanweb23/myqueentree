
	public function commissionbonus()
	{
		//echo 'sdfrg';die;
	 	   $result=Order::join('m_l_m_registers as mlm','mlm.user_id','=','orders.user_id','left')
		         ->select('mlm.member_id','mlm.member_name','mlm.sponser_id','orders.order_unique','mlm.user_id')
		         ->where('orders.id','=','30')
				 ->where('orders.status_for_matching_bonus','=','0')
				 ->first();
				/*echo '<pre>';
				 print_r($result);
				 die;*/
		   $data=Order::select('orders.user_id','orders.total_pv')
		         ->where('orders.id','=','30')
				 ->where('orders.status_for_matching_bonus','=','0')
				 ->first();
				/*echo '<pre>';
				 print_r($data);
				 die;*/
		   $getParentDetails=MLMRegister::select('placement_id','ranking')
					         ->where('m_l_m_registers.user_id','=',$result->user_id)
					         ->first();
							/*echo '<pre>';
				            print_r($getParentDetails);
				            die;*/
            $getParentSponserDetails=MLMRegister::select('sponser_id')
					         ->where('m_l_m_registers.user_id','=',$getParentDetails->placement_id)
					         ->first();	
             //echo $getParentSponserDetails;die;
            $getSponserDetails=MLMRegister::select('sponser_id','ranking','user_id')
			                   ->where('m_l_m_registers.member_id',$getParentSponserDetails->sponser_id)
							   ->first();
                             //echo '<pre>'; print_r($getSponserDetails);die;
	        $placementID=$getParentDetails->placement_id;
            //echo $result->member_id;die;			
	        $checkOrders = Helper::getparentdetails($placementID,$result->member_id);
	        if($checkOrders[0] == 1)
			{
		         if($checkOrders[1] < $data->total_pv)
				 {
			       $pvPoint[$data['user_id']] = $checkOrders[1];
		         }
				 else
				 {
			       $pvPoint[$data['user_id']] = $data->total_pv;
		         }		
	        } 
	        else if($checkOrders[0] == 2)
			{
		       if($checkOrders[1] < $data->total_pv)
			   {
			     $pvPoint = $checkOrders[1];
		       }
			     else
				 {
			       $pvPoint= $data->total_pv;
		          }		
	        }
			$pvPointTotal[$data['user_id']] = $data->total_pv + $checkOrders[1];
			//echo $pvPointTotal[$data['user_id']];die;
			 if($getParentDetails->ranking == 1){
				 $commissionBonus= $pvPoint*(6/100);  
			 }
			 if($getParentDetails->ranking == 2){
				 $commissionBonus= $pvPoint*(8/100);  
			 }
			 if($getParentDetails->ranking == 3){
				 $commissionBonus= $pvPoint*(10/100);  
			 }
			 if($getParentDetails->ranking == 4){
				 $commissionBonus= $pvPoint*(12/100);  
			 }
			   $bonusArray=array(
				 'sponser_id'=> $result->sponser_id,
				 'member_id'=> $result->member_id,
				 'user_id'=> $placementID,
				 'point'=> $commissionBonus,
				 'created_at'=>DB::raw('CURRENT_TIMESTAMP'),
				 'updated_at'=>DB::raw('CURRENT_TIMESTAMP')
				);
			  $storeMatchingBonus=MatchingBonus::insert($bonusArray);
			 if($getSponserDetails->ranking == 1){
				 $sponserCommissionBonus= $commissionBonus*(6/100);  
			 }
			 if($getSponserDetails->ranking == 2){
				 $sponserCommissionBonus= $commissionBonus*(8/100);  
			 }
			 if($getSponserDetails->ranking == 3){
				 $sponserCommissionBonus= $commissionBonus*(10/100);  
			 }
			 if($getSponserDetails->ranking == 4){
				 $sponserCommissionBonus= $commissionBonus*(12/100);  
			 }
			     $sponserBonusArray=array(
				 'sponser_id'=> $getSponserDetails->sponser_id,
				 'member_id'=> $getParentSponserDetails->sponser_id,
				 'user_id'=> $getSponserDetails->user_id,
				 'point'=> $sponserCommissionBonus,
				 'created_at'=>DB::raw('CURRENT_TIMESTAMP'),
				 'updated_at'=>DB::raw('CURRENT_TIMESTAMP')
				);
				//echo '<pre>'; print_r($sponserBonusArray);die;
				$storeMatchingBonus=MatchingBonus::insert($sponserBonusArray);
			  $parentBonusStatus=Order::where('order_unique', $result->order_unique)->update(['status_for_matching_bonus' => 1]);
			  $parentdetail = Helper::getchildparentdetails($placementID,$checkOrders[0],$data->placement_id_type,$pvPointTotal,$getParentDetails->ranking);
			  	 
	}
	
	public function leadershipbonus(){
	  $result=Order::join('m_l_m_registers as MLM','MLM.user_id','=','orders.user_id','left')
	             ->select('MLM.member_id','MLM.member_name','MLM.sponser_id','orders.order_unique','mlm.user_id')
		         ->where('orders.id','=','30')
				 ->where('orders.status_of_leadership_bonus','=','0')
				 ->first();
	//echo '<pre>'; print_r($result);die;
	   $data=Order::select('orders.user_id','orders.total_pv')
		         ->where('orders.id','=','30')
				 ->where('orders.status_of_leadership_bonus','=','0')
				 ->first();
		$order_pv= $data->total_pv;
		//echo $order_pv;die;
		//echo '<pre>'; print_r($data);die;
		$getReferalDetails=MLMRegister::select('sponser_id','ranking')
					                 ->where('m_l_m_registers.user_id','=',$result->user_id)
					                 ->first();
		//echo '<pre>'; print_r($getReferalDetails);die;
		$referalDetails=User::select('left_id','right_id','id','rank_id','name')
		            ->where('users.unique_id','=',$getReferalDetails->sponser_id)			   
			        ->first();	
		  //echo '<pre>'; print_r($referalDetails);die;
		            if(isset($referalDetails->left_id)&& isset($referalDetails->right_id))
					{
				      if($referalDetails->rank_id == 1)
				      {
				        $leadershipBonus= 0;  
			          }
			          if($referalDetails->rank_id == 2)
				      {
				        $leadershipBonus= $order_pv*(2/100);  
			          }
			          if($referalDetails->rank_id == 3)
				      {
				        $leadershipBonus= $order_pv*(5/100);  
			          }
			          if($referalDetails->rank_id == 4)
				      {
				        $leadershipBonus= $order_pv*(10/100);  
			          }
					}
		$leadershipBonusArray=array(
				 'sponser_id'=> $getReferalDetails->sponser_id,
				 'member_name'=> $referalDetails->name,
				 'member_id'=> $result->member_id,
				 'order_id'=> $result->order_unique,
				 'point'=> $leadershipBonus,
				 'created_at'=>DB::raw('CURRENT_TIMESTAMP'),
				 'updated_at'=>DB::raw('CURRENT_TIMESTAMP')
				);
		$storeLeaderShipBonus=LeaderShipBonus::insert($leadershipBonusArray);
		$LeaderBonusStatus=Order::where('order_unique', $result->order_unique)->update(['status_of_leadership_bonus' => 1]);
		$updateLeadershipPoints=User::where('unique_id',$getReferalDetails->sponser_id)
		                            ->update(['leadership_bonus' => $leadershipBonus]);
	}
	