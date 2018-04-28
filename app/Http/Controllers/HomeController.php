<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use App\User;
use Auth;
use Session;
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
    public function getProfile(){

        $orders = Auth::user()->orders;
        $orders->transform(function($order,$key){
            $order->order=unserialize($order->order);
            return $order;
        });
        return view('home',['orders'=>$orders]);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {	
        return view('home');
    }
   
}
