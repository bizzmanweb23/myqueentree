<?php

namespace App\Http\Controllers\User;

use DB;
use App\Http\Controllers\Controller;
use App\Models\Wallet;
use App\Models\User;
use App\Models\UserCreditPoint;
use App\Models\MLMLoyalityPoint;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserWalletController extends Controller
{
    public function show_royalty_page()
    {
        return view('font.wallet.index');
    }


    public function get_qr_code_for_wallet()
    {
        request()->validate([
            'amount' => 'required|numeric'
        ], [
            'amount.required' => 'Please Enter Amount'
        ]);
        $postArray = array();
        $postArray['user_id'] = 'S111417';
        $postArray["user_password"] = md5('S111417' . '4ba2e90ba890799fb708e9f0bca9a648');
        $postArray['amount'] = request()->amount;
        $postArray['notify_url'] = 'd';
        $sign_string = md5($postArray['user_id'] . $postArray["user_password"] . $postArray['amount'] . $postArray['notify_url'] . '4ba2e90ba890799fb708e9f0bca9a648');
        $postArray["sign_string"] = $sign_string;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://mctpayment.com/dci/api_v2/get_fixed_amount_qrcode');
        curl_setopt($ch, CURLOPT_VERBOSE, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
        curl_setopt($ch, CURLOPT_TIMEOUT, 40);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postArray);
        $response = curl_exec($ch);
        echo $response;
    }


    public function store_wallet_payment(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric'
        ], [
            'amount.required' => 'Please Enter Amount'
        ]);

        if ($request->mct_pay == null && $request->pay_now == null) {
            $request->validate([
                'select_one' => 'required'
            ], [
                'select_one.required' => 'Please Select One Payment Option'
            ]);
        }
        $image = null;

        if ($request->mct_pay != null) {
            $payment_type = "MCT Pay";
        }
        if ($request->pay_now != null) {
            $request->validate([
                'payment_screen_shot' => 'required|image'
            ], [
                'payment_screen_shot.required' => 'Please Upload Payment Screenshot'
            ]);
            $payment_type = "Pay Now";
            $image = $request->payment_screen_shot->storeAs('wallet/paynow', time() . "_" . $request->amount . '.' . $request->payment_screen_shot->extension());
        }

        Wallet::create([
            'user_id' => Auth::user()->id,
            'amount' => $request->amount,
            'screen_shot' => $image,
            'payment_type' => $payment_type,
        ]);

        echo json_encode(['status' => 'success', 'message' => 'Payment Successfully']);
    }


    public function get_all_payment()
    {
        $data = Wallet::join('users', 'users.id', '=', 'wallets.user_id')
            ->select('users.name', 'wallets.*')
            ->where('wallets.user_id', Auth::user()->id)->get();
        echo json_encode($data);
    }

    public function show_wallet_page()
    {
        return view('font.wallet.wallet');
    }

    public function redeem_wallet_bonus(Request $request)
    {
        $withdraw_data = $request->validate([
            'credit_points'              => 'required',
        ], [
            'credit_points.required'     => 'Please Enter Credit Bonus',
        ]);
        $withdrawcredit = User::select('total_pv_point', 'wallet')
            ->where('id', Auth::user()->id)
            ->get();
        //echo '<pre>';print_r($withdrawcredit);die;
        if ($_POST['credit_points'] <= $withdrawcredit[0]->total_pv_point) {
            $withdraw_data['status'] = 1;
            $withdraw_data['user_id'] = Auth::user()->id;
            $data = UserCreditPoint::insert($withdraw_data);
            $result = User::where('id', Auth::user()->id)
                ->update([
                    'total_pv_point'  => DB::raw($withdrawcredit[0]->total_pv_point - $_POST['credit_points'])
                ]);
            $walletUpdate = User::where('id', Auth::user()->id)
                ->update([
                    'Wallet'  => DB::raw($withdrawcredit[0]->wallet + $_POST['credit_points'])
                ]);
            //echo '<pre>';print_r($data);die;
            echo json_encode(['status' => 'success', 'message' => 'WithDraw Request Succesfully Submitted']);
        } else {
            //die('else');
            echo json_encode(['status' => 'danger', 'message' => 'You Does Not Have Sufficient PV Point']);
        }
    }

    public function get_wallet_bonus()
    {
        $data = UserCreditPoint::join('users', 'users.id', '=', 'redeem_credit_points.user_id')
            ->select('users.name', 'redeem_credit_points.*')
            ->where('redeem_credit_points.user_id', Auth::user()->id)
            ->get();
        echo json_encode($data);
    }

    public function get_full_wallet_amount()
    {
        $result = User::select('total_pv_point')
            ->where('id', Auth::user()->id)
            ->get();
        foreach ($result as $data) {
            $arr[] = array(
                'total_pv_point' => $data->total_pv_point
            );
        }
        echo json_encode($data);
    }
}