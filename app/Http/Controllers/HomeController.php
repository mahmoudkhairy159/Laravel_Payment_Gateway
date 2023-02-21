<?php

namespace App\Http\Controllers;

use App\Order;
use App\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     *    */
    public function index()
    {
        if (request('id') && request('resourcePath')) {
            $paymentStatus = $this->getPaymentStatus(request('resourcePath'));
            if (isset($paymentStatus['id'])) {
                Order::create([
                    'product_id' => 1,
                    'user_id' => Auth::id(),
                    'transaction_id' => $paymentStatus['id']
                ]);
                $products = Product::get();
                session()->flash('success', 'valid payment');
                return view('home')->with('products', $products);
            } else {
                $products = Product::get();
                session()->flash('success', 'invalid payment');
                return view('home')->with('products', $products);
            }
        }
        $products = Product::get();
        return view('home')->with('products', $products);
    }



    public function getPaymentStatus($responsePath)
    {

        $url = "https://eu-test.oppwa.com/";
        $url .= $responsePath;
        $url .= "?entityId=8a8294174b7ecb28014b9699220015ca";

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Authorization:Bearer OGE4Mjk0MTc0YjdlY2IyODAxNGI5Njk5MjIwMDE1Y2N8c3k2S0pzVDg='
        ));
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // this should be set to true in production
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $responseData = curl_exec($ch);
        if (curl_errno($ch)) {
            return curl_error($ch);
        }
        curl_close($ch);
        return json_decode($responseData, true);
    }
}
