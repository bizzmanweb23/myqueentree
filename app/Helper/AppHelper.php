<?php
namespace App\Helper;
use Session;
use DB;
use App\Models\User;
use App\Models\Order;
use App\Models\MLMRegister;
use App\Models\MatchingBonus;
class AppHelper {

public static function getparentdetails($userId,$memberId){
	
		$data=User::select('users.left_id','users.right_id','users.unique_id','users.id','left.id as leftId','right.id as rightId')
					->join('users as left','left.unique_id','=','users.left_id','left')
					->join('users as right','right.unique_id','=','users.right_id','left')
		            ->where('users.id','=',$userId)			   
			        ->first();			  
			if(isset($data->left_id) && isset($data->right_id)){
				if($memberId == $data->left_id){

					//echo $data->rightId;
					//echo '<br>';
					//echo $data->leftId;
					
					$data=Order::select('orders.order_unique','orders.total_pv')
					->where('orders.user_id','=',$data->rightId)
					//->whereNull('in_house_status')
					->where('orders.self_pick_order_status','=','5')
					->where('orders.status_for_matching_bonus','=','0')
					->where('orders.status_for_old_order','=','1');
					//->orderBy('id','desc');					
					if($data->count() > 0){
						$data=$data->first();
						$type= 1;
					    $totalPv = $data->total_pv;
						$data = $data->order_unique;
					}else{
						$type= 0;
						$totalPv = 0;
					}			  
				}
				else if($memberId == $data->right_id){
					$data=Order::select('orders.order_unique','orders.total_pv')
					->where('orders.user_id','=',$data->leftId)
					//->whereNull('in_house_status')
					->where('orders.self_pick_order_status','=','5')
					->where('orders.status_for_matching_bonus','=','0')
					->where('orders.status_for_old_order','=','1');
					//->orderBy('id','desc');	

					if($data->count() > 0){
						$data=$data->first();
						$type= 2;
						$totalPv = $data->total_pv;
					}else{
						$type= 0;
						$totalPv = 0;
					}	
				}
			}else{
				$type = 3;
				$totalPv = 0;
			}			 
			return array($type,$totalPv);
	    
	}
	
	public static function getchildparentdetails($userID,$type,$point,$pvPointTotal){
		 if($userID < 1)
		 {
			return 1;
		 }else{
		
		$totalPv = 0;
		$parentDetails=MLMRegister::select('m_l_m_registers.placement_id','m_l_m_registers.sponser_id','m_l_m_registers.member_id','m_l_m_registers.member_name','m_l_m_registers.ranking')
					  ->where('m_l_m_registers.user_id','=',$userID)
					  ->first();
		$data=User::select('users.left_id','users.right_id','users.unique_id','users.id','left.id as leftId','right.id as rightId')
					->join('users as left','left.unique_id','=','users.left_id','left')
					->join('users as right','right.unique_id','=','users.right_id','left')
		            ->where('users.id','=',$parentDetails->placement_id)			   
			        ->first();
			  if(isset($data->left_id) && isset($data->right_id))
			  {
                if($type == $data->left_id)
				{
				  $data=Order::select('orders.order_unique','orders.total_pv')
				  ->where('orders.user_id','=',$data->rightId)
				  ->where('orders.self_pick_order_status','=','5')
					->where('orders.status_for_matching_bonus','=','0')
					->where('orders.status_for_old_order','=','1')
				  ->first();
				  $type= 1;
				  $totalPv = $data->total_pv;
				}
				else if($type == $data->right_id)
				{
				  $data=Order::select('orders.order_unique','orders.total_pv')
				  ->where('orders.user_id','=',$data->leftId)
				  ->where('orders.self_pick_order_status','=','5')
					->where('orders.status_for_matching_bonus','=','0')
					->where('orders.status_for_old_order','=','1')
				  ->first();
				  $type = 2;
				  $totalPv = $data->total_pv;
				}
			 }
                else
				{
				  $type = 3;
				  $totalPv = 0;
			    }
                if($totalPv == 0)
				{
				   $pvPoints=$pvPointTotal;
				}
                else
				{
					$pvPoints=$totalPv+$pvPointTotal;
				}	
				//echo '<pre>';print_r($data->order_unique);die;
				 if($parentDetails->ranking == 1){
				 $bonusper=6;
				 $bonus= ($totalPv*$bonusper)/100;  
			 }			  
			 if($parentDetails->ranking == 2){
				 $bonusper1= 8;
				 $bonus= ($totalPv*$bonusper1)/100;  
			 }
			 if($parentDetails->ranking == 3){
				 $bonusper2= 10;
				 $bonus= ($totalPv*$bonusper2)/100;  
			 }
			 if($parentDetails->ranking == 4){
				 $bonusper3= 12;
				 $bonus= ($totalPv*$bonusper3)/100;  
			 }
			  // echo $data->order_unique;die;
                 $bonusParent=array(
				 'sponser_id'=> $parentDetails->sponser_id,
				 'member_id'=> $parentDetails->member_id,
				 'user_id'=> $parentDetails->placement_id,
				 'point'=> $bonus,
				 //'order_id'=> $data->order_unique,
				 'created_at'=>DB::raw('CURRENT_TIMESTAMP'),
				 'updated_at'=>DB::raw('CURRENT_TIMESTAMP')		 
				 );                 
                 $storeMatchingBonus=MatchingBonus::insert($bonusParent);
				 //$updateBonusStatus=Order::where('order_unique', $data->order_unique)->update(['status_for_matching_bonus' => 1]);
				 $callAgain=self::getchildparentdetails($parentDetails->placement_id,$type,$point,$pvPoints);
              }
}
}
?>