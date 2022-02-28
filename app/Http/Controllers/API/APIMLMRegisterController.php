<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\DirectSponsor;
use App\Models\User;
use App\Models\Branch;
use App\Models\Ranking;
use App\Models\MLMRegister;
use App\Models\Rating;
use Illuminate\Http\Request;

class APIMLMRegisterController extends Controller
{
	public function get_ranking_details(Request $request)
	{
		$ranking = Ranking::all();
        $branch = Branch::all();
		return response([
            $ranking,$branch
        ], 201);
	}
	
	public function search_user_details(Request $request)
    {
		$result=User::find($request->user()->id);
        $users = User::where('unique_id', 'Like', '%' . request()->term . '%')
            ->where('id', '!=',$result->id)
            ->where('is_mlm_member', 0)->get();
        if ($users->count() > 0) {
            foreach ($users as $item) {
                $data[] = [
                    'label' => $item->unique_id,
                    'id' => $item->id,
                    'name' => $item->name,
                    'email' => $item->email,
                    'unique_id' => $item->unique_id
                ];
            }
        } else {
            $data[] = ['label' => 'Not Found', 'id' => 0];
        }
           return response([
            $data
                ], 201);
    }
	
	public function check_user_status(Request $request)
    {
        $user = User::where('unique_id', request()->id)->first();
        if ($user) {
            $mlm_user = MLMRegister::where('member_id', $user->unique_id)->first();
            if ($mlm_user) {
                if ($mlm_user->status == 0) {
                    $data=(['status' => 'no', 'message' => 'Member Alrady Under Process']);
                } else {
                    $data=(['status' => 'no', 'message' => 'Member Alrady Register']);
                }
            } else {
                return response([
				$data
				], 201);
            }
        } else {
            request()->validate([
                'not_user' => 'required',
            ], [
                'not_user.required' => 'Invalid User Id'
            ]);
        }
    }
	
	public function get_placement_id(Request $request)
    {
		$result=User::find($request->user()->id);
		$data=MLMRegister::find($request->user()->id);
        $users = MLMRegister::where('sponser_id', $request->unique_id)
            ->orWhere('m_l_m_registers.placement_id', $request->id)->get();
        if ($users->count() > 0) {
            $data = MLMRegister::join('users', 'users.unique_id', '=', 'm_l_m_registers.member_id')
                ->select('users.*')
                ->where('sponser_id', $result->unique_id)
                ->where('m_l_m_registers.status', 1)
                ->orWhere('m_l_m_registers.placement_id', $result->id)
                ->get();
            $new = array();
            foreach ($data as $item) {
                if ($item->left_id == null || $item->right_id == null) {
                    if (array_search($item->id, array_column($new, 'id')) !== False) {
                    } else
                        $new[] = ['name' => $item->name, 'id' => $item->id, 'unique_id' => $item->unique_id];
                }

                $more_data = MLMRegister::join('users', 'users.unique_id', '=', 'm_l_m_registers.member_id')
                    ->select('users.*')
                    ->where('sponser_id', $item->unique_id)
                    ->where('m_l_m_registers.status', 1)
                    ->orWhere('m_l_m_registers.placement_id', $item->id)
                    ->get();
                foreach ($more_data as $value) {
                    if ($value->left_id == null || $value->right_id == null) {
                        if (array_search($value->id, array_column($new, 'id')) !== False) {
                        } else
                            $new[] = ['name' => $value->name, 'id' => $value->id, 'unique_id' => $value->unique_id];
                    }
                }
            }
            if ($result->left_id == null || $result->right_id == null) {
                $exit[] = ['name' => $result->name, 'id' => $result->id];
                $merge = array_merge($new, $exit);
            } else {
                $merge = $new;
            }
            return response(['status' => 'success', 'data' => $merge],201);
        } else {
            $data = array(
                'status' => 'no',
                'name' => $result->name,
                'id' => $result->id
            );
            return response([$data],201);
        }
    }
	
	public function get_pv_point(Request $request)
    {
		//echo 'hello';die;
		$result=User::find($request->user()->id);
        $user = User::where('unique_id', $result->unique_id)->first();
		//echo $user;die;
        $check_pv = Ranking::where('id', request()->pv_id)->first();
        if ($user && request()->pv_id != null) {
            if ($user->total_pv_point >= $check_pv->points) {
                $ranking = Ranking::all();
                $id = 0;
                foreach ($ranking as $item) {
                    if ($user->total_pv_point >= $item->points) {
                        $id = $item->id;
                    }
                }
                $data = ['status' => 'success', 'id' => $id];
            } else {
                $data = ['status' => 'faild', 'message' => 'You Not Able To Register Because Register User Does Not Have Sufficient PV Point'];
            }
            return response([$data],201);
        }
    }

}