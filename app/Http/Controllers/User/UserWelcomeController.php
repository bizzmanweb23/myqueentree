<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use App\Models\Contactus;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;

class UserWelcomeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('font.index');
    }

    public function search_product()
    {
        $users = Product::where('title', 'Like', '%' . request()->term . '%')->get();
        if ($users->count() > 0) {
            foreach ($users as $item) {
                $data[] = [
                    'label' => $item->title,
                    'id' => $item->id,
                ];
            }
        } else {
            $data[] = ['label' => 'Not Found', 'id' => 0];
        }
        echo json_encode($data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $lang = Config::get('app.locale');
        if ($lang == 'ch-s' || $lang == 'ch-t') {
            $banner     = Banner::select('Image_ch as image')
                ->get();
            $product    = Product::where('status', 1)
                ->leftJoin('wishlists', 'wishlists.product_id', '=', 'products.id')
                ->select('productimagec as image', 'title', 'saleprice', 'size', 'products.id', 'wishlists.product_id as active')
                ->orderBy('id', 'desc')
                ->get();
        } else {
            $banner     = Banner::select('Image_eng as image')
                ->get();
            $product    = Product::where('status', 1)
                ->leftJoin('wishlists', 'wishlists.product_id', '=', 'products.id')
                ->select('productimagee as image', 'title', 'saleprice', 'size', 'products.id', 'wishlists.product_id as active')
                ->orderBy('id', 'desc')
                ->get();
        }

        echo json_encode(['banner' => $banner, 'product' => $product]);
    }

    public function about_us()
    {
        return view('font.about-us');
    }

    public function contact_us()
    {
        return view('font.contact-us');
    }

    public function get_all_product()
    {
        $lang = Config::get('app.locale');
        if ($lang == 'ch-s' || $lang == 'ch-t') {
            $product    = Product::where('status', 1)
                ->leftJoin('wishlists', 'wishlists.product_id', '=', 'products.id')
                ->select('productimagec as image', 'title', 'saleprice', 'size', 'products.id', 'wishlists.id as active')
                ->orderBy('id', 'desc')
                ->get();
        } else {
            $product    = Product::where('status', 1)
                ->leftJoin('wishlists', 'wishlists.product_id', '=', 'products.id')
                ->select('productimagee as image', 'title', 'saleprice', 'size', 'products.id', 'wishlists.id as active')
                ->orderBy('id', 'desc')
                ->get();
        }

        echo json_encode($product);
    }

    public function view_product_list()
    {
        return view('font.product-list.index');
    }

    public function store_contact_us(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|unique:contactuses,email',
            'comment' => 'required'
        ]);

        Contactus::create($request->only(['email', 'name', 'comment']));

        echo json_encode(['status' => 'success', 'message' => 'Thank you for submitting your message we will come back to you']);
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