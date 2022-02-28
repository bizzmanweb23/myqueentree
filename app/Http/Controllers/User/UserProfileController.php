<?php

namespace App\Http\Controllers\User;

use DB;
use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\PvPoint;
use App\Models\Rating;
use App\Models\UseCreditWallet;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

class UserProfileController extends Controller
{


    public function show_pending_payment()
    {
        $data = Order::where('user_id', Auth::user()->id)->where('payment_status', 0)->get();
        echo $data;
    }

    public function show_to_ship()
    {
        $data = Order::where('user_id', Auth::user()->id)->where('status_id', 4)->get();
        echo $data;
    }

    public function show_to_receive()
    {
        $data = Order::where('user_id', Auth::user()->id)->where('status_id', 5)->get();
        echo $data;
    }

    public function show_rate()
    {
        $data = Rating::join('products', 'products.id', '=', 'ratings.product_id')
            ->select('products.productimagee', 'ratings.*')
            ->where('ratings.user_id', Auth::user()->id)->get();

        echo $data;
    }


    public function show_collect()
    {
        $data = Order::leftJoin('branches', 'branches.id', '=', 'orders.in_house_status')
            ->where('orders.user_id', Auth::user()->id)
            ->where('orders.shipping_method', 'Self-Pickup')
            ->where('orders.status_id', '!=', 5)->get();
        echo $data;
    }

    public function payment_history()
    {
        $data = UseCreditWallet::join('orders', 'orders.id', '=', 'use_credit_wallets.order_id')
            ->where('use_credit_wallets.user_id', Auth::user()->id)->get();
        echo $data;
    }

    // public function show_completed()
    // {
    //     $data = Order::where('user_id', Auth::user()->id)->where('status_id', 5)->get();
    //     echo $data;
    // }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['result'] = User::select(DB::raw('total_direct_dponsor+total_matching_bonus+wallet+leadership_bonus as bonusSum'))
            ->where('id', Auth::user()->id)
            ->get();
        //echo '<pre>';print_r($data);die;
        return view('font.profile.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required',
            'email' => 'email|unique:users,email,' . Auth::user()->id,
            'phone' => 'required|numeric',
            'image' => 'nullable|image',
        ], [
            'name.required' => 'Please Enter Name',
            'email.required' => 'Please Enter Email',
            'phone.required' => 'Please Enter Phone Number',
        ]);

        if ($request->hasFile('image')) {
            File::delete(Auth::user()->image);
            $path = $request->image->storeAs('Profile/', Auth::user()->unique_id . date('d_m_y') . "." . $request->image->extension());
            $data['image'] = $path;
        }

        User::where('id', Auth::user()->id)->update($data);
        echo json_encode(['status' => 'success', 'message' => 'Profile Update Successfully']);
    }


    public function get_pv_point_history()
    {
        $data = PvPoint::join('orders', 'orders.id', '=', 'pv_points.order_id')
            ->select('orders.order_unique', 'pv_points.created_at as date', 'pv_points.point')
            ->where('pv_points.user_id', Auth::user()->id)->get();
        echo json_encode($data);
    }



    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
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