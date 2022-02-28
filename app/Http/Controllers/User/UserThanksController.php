<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Branch;
use App\Models\MCTPay;
use App\Models\OfflinePay;
use App\Models\Order;
use App\Models\OrderStatus;
use App\Models\SelfPick;
use App\Models\Shipping;
use App\Models\User;
use App\Notifications\OrderCreate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\URL;

class UserThanksController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        echo json_encode(['status' => 'success', 'url' => URL::signedRoute('users.thank.show', request()->id)]);
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $check = SelfPick::where('order_id', $id)->first();
        $order_data = Order::find($id);
        if ($check) {
            $order_summary = [
                'order_no' => $order_data->order_unique,
                'order_date' => $order_data->created_at,
                'name'  => Auth::user()->name,
                'order_status' => 'Processing',
                'email' => Auth::user()->email,
                'total_order_amount' => $order_data->total,
                'shipping_address' => $check->country . ', ' . $check->state . ', ' . $check->zip,
                'shipping' => $order_data->shipping_method,
                'payment_method' => $order_data->payment_method,
                'sub_total' => $order_data->order_sum,
                'shipping_charge'   => $order_data->shipping_charge,
                'coupon_discount'   => $order_data->how_may_discount . " " . $order_data->discount_type,
                'total_amount' => $order_data->total
            ];
        } else {
            if ($order_data->is_bill_same_ship == 1) {
                $ship_address = Order::join('billings', 'billings.id', '=', 'orders.billing_id')
                    ->where('orders.id', $id)->first();
            } else {
                $ship_address = Order::join('shippings', 'shippings.id', '=', 'orders.shipping_id')
                    ->where('orders.id', $id)->first();
            }


            $order_summary = [
                'order_no' => $order_data->order_unique,
                'order_date' => $order_data->created_at,
                'name'  => $ship_address->first_name . ' ' . $ship_address->lastname,
                'order_status' => 'Processing',
                'email' => Auth::user()->email,
                'total_order_amount' => $order_data->total,
                'shipping_address' => $ship_address->address . ", " . $ship_address->country . ', ' . $ship_address->state . ', ' . $ship_address->zip,
                'shipping' => $order_data->shipping_method,
                'payment_method' => $order_data->payment_method,
                'sub_total' => $order_data->order_sum,
                'shipping_charge'   => $order_data->shipping_charge,
                'coupon_discount'   => $order_data->how_may_discount . " " . $order_data->discount_type,
                'total_amount' => $order_data->total
            ];
        }

        $lang = Config::get('app.locale');

        $order_details = Order::join('order_items', 'order_items.order_id', '=', 'orders.id')
            ->join('products', 'products.id', '=', 'order_items.product_id')
            ->select(
                'products.title',
                'products.productimagee as image',
                'order_items.quentity as qun',
                'orders.shipping_method',
                'products.saleprice'
            )
            ->where('orders.id', $id)->get();

        $this->send_email_to_user($id);

        return view('font.thank.index')->with(['order_summary' => $order_summary, 'order_details' => $order_details]);
        // print_r($order_details);
    }

    function send_email_to_user($id)
    {
        $check = SelfPick::where('order_id', $id)->first();
        $order_data = Order::find($id);
        if ($order_data) {
            $user = User::find($order_data->user_id);
            if ($check) {
                $order_summary = [
                    'order_id' => $order_data->id,
                    'order_no' => $order_data->order_unique,
                    'order_date' => $order_data->created_at,
                    'name'  => $user->name,
                    'email' => $user->email,
                    'phone' => $user->phone,
                    'total_order_amount' => $order_data->total,
                    'shipping_address' => $check->country . ', ' . $check->state . ', ' . $check->zip,
                    'billing_address' => $check->country . ', ' . $check->state . ', ' . $check->zip,
                    'shipping_method' => $order_data->shipping_method,
                    'payment_method' => $order_data->payment_method,
                    'sub_total' => $order_data->order_sum,
                    'shipping_charge'   => $order_data->shipping_charge,
                    'coupon_discount'   => $order_data->how_may_discount . " " . $order_data->discount_type,
                    'total_amount' => $order_data->total,
                    'in_house_status' => $order_data->in_house_status,
                    'status_id' => $order_data->status_id,
                    'payment_status' => $order_data->payment_status,
                    'self_pick_order_status' => $order_data->self_pick_order_status
                ];
            } else {
                if ($order_data->is_bill_same_ship == 1) {
                    $ship_address = Order::join('billings', 'billings.id', '=', 'orders.billing_id')
                        ->select('billings.first_name as firstname', 'billings.address', 'billings.country', 'billings.state', 'billings.zip')
                        ->where('orders.id', $id)->first();
                    $billing_address = Order::join('billings', 'billings.id', '=', 'orders.billing_id')
                        ->select('billings.first_name as firstname', 'billings.address', 'billings.country', 'billings.state', 'billings.zip')
                        ->where('orders.id', $id)->first();
                } else {
                    $ship_address = Order::join('shippings', 'shippings.id', '=', 'orders.shipping_id')
                        ->select('shippings.first_name as firstname', 'shippings.address', 'shippings.country', 'shippings.state', 'shippings.zip')
                        ->where('orders.id', $id)->first();
                    $billing_address = Order::join('billings', 'billings.id', '=', 'orders.billing_id')
                        ->select('billings.first_name as firstname', 'billings.address', 'billings.country', 'billings.state', 'billings.zip')
                        ->where('orders.id', $id)->first();
                }


                $order_summary = [
                    'order_id' => $order_data->id,
                    'order_no' => $order_data->order_unique,
                    'order_date' => $order_data->created_at,
                    'name'  => $ship_address->firstname . ' ' . $ship_address->lastname,
                    'email' => $user->email,
                    'phone' => $user->phone,
                    'total_order_amount' => $order_data->total,
                    'shipping_address' => $ship_address->address . ", " . $ship_address->country . ', ' . $ship_address->state . ', ' . $ship_address->zip,
                    'billing_address' => $billing_address->address . ', ' . $billing_address->country . ', ' . $billing_address->state . ', ' . $billing_address->zip,
                    'shipping_method' => $order_data->shipping_method,
                    'payment_method' => $order_data->payment_method,
                    'sub_total' => $order_data->order_sum,
                    'shipping_charge'   => $order_data->shipping_charge,
                    'coupon_discount'   => $order_data->how_may_discount . " " . $order_data->discount_type,
                    'total_amount' => $order_data->total,
                    'in_house_status' => $order_data->in_house_status,
                    'status_id' => $order_data->status_id,
                    'payment_status' => $order_data->payment_status,
                    'self_pick_order_status' => $order_data->self_pick_order_status
                ];
            }

            $order_details = Order::join('order_items', 'order_items.order_id', '=', 'orders.id')
                ->join('products', 'products.id', '=', 'order_items.product_id')
                ->select(
                    'products.title',
                    'products.productimagee as image',
                    'order_items.quentity as qun',
                    'orders.shipping_method',
                    'products.saleprice',
                    'products.size'
                )
                ->where('orders.id', $id)->get();

            Notification::send(Auth::user(), new OrderCreate($order_summary, $order_details));
            // return view('mail.order_create', compact('order_summary', 'order_details'));
        }
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