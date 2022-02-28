<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DirectSponsor;
use App\Models\MLMRegister;
use App\Models\User;
use App\Models\Wallet;
use Illuminate\Http\Request;

class AdminWalletController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Wallet::join('users', 'users.id', '=', 'wallets.user_id')
            ->select('wallets.*', 'users.name')
            ->orderBy('wallets.id', 'desc')
            ->get();
        echo  $data;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    }

    public function show_details()
    {
        $data = Wallet::join('users', 'users.id', '=', 'wallets.user_id')
            ->select('wallets.*', 'users.name', 'users.email', 'users.phone')
            ->where('wallets.id', request()->id)->first();
        echo  json_encode($data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:wallets,id',
        ]);

        Wallet::where('id', $request->id)->update([
            'status' => 1
        ]);

        $data = Wallet::where('id', $request->id)->first();
        $user = User::where('id', $data->user_id)->first();

        User::where('id', $data->user_id)->update([
            'wallet' => $user->wallet + $data->amount
        ]);

        if ($user->is_mlm_member == 1) {
            $this->get_direct_bonus($data->amount, $user);
        }

        echo json_encode(['status' => 'success', 'message' => 'Approve successfully']);
    }


    function get_direct_bonus($amount, $user)
    {
        $sponsors_id = MLMRegister::where('member_id', $user->unique_id)->first();
        if ($sponsors_id && !empty($sponsors_id->sponser_id)) {
            // add in DirectSponsor table
            $sponsors_user = User::where('unique_id', $sponsors_id->sponser_id)->first();

            if ($sponsors_user->rank_id == 1) {
                $per = 10;
                $direct_cal = ($per / 100) * $amount;
            } else if ($sponsors_user->rank_id == 2) {
                $per = 15;
                $direct_cal = ($per / 100) * $amount;
            } else if ($sponsors_user->rank_id == 3) {
                $per = 20;
                $direct_cal = ($per / 100) * $amount;
            } else {
                $per = 25;
                $direct_cal = ($per / 100) * $amount;
            }
            DirectSponsor::create([
                'sponsors_id'   => $sponsors_id->sponser_id,
                'member_id'     => $user->unique_id,
                'member_name'   => $user->name,
                'rank_id'       => $user->rank_id,
                'point'         => $direct_cal,
            ]);

            User::where('unique_id', $sponsors_id->sponser_id)->update([
                'total_direct_dponsor' => $sponsors_user->total_direct_dponsor + $direct_cal
            ]);
        }
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