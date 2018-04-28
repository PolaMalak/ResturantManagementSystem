<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\MealOrder;
use App\Item;
use App\Menu;
use Session;
use App\OrdersData;
use Auth;
class ItemsController extends Controller
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
	public function getAddMeal(Request $request, $id){
        $item = Item::find($id);
        $oldOrder = Session::has('order') ? Session::get('order'): null;
        $order = new MealOrder($oldOrder);   
        $order->add($item,$item->id);
        Session::set('order', $order);
        return redirect()->route('itemIndex');
    }
    public function getOrder(){

        if(Session::has('item')){
            return view('Shopping-order');
        }
            $oldOrder = Session::get('order');
            $order = new MealOrder($oldOrder);
            return view('Shopping-order',['items'=>$order->items,'totalPrice'=>$order->totalPrice]);
    }
    public function getCheckout(){
        if(!Session::has('order')){
            return view('Shopping-order');
        }
        $oldOrder = Session::get('order');
        $order = new MealOrder($oldOrder);
        $total = $order->totalPrice;
        return view('checkout',['total'=>$total]); 

    }

    public function postCheckout(Request $request){
        if(!Session::has('order')){
            return redirect()->route('Shopping-order');
        }
        $oldOrder = Session::get('order');
        $order = new MealOrder($oldOrder);
        $orders = new OrdersData();
        $orders->order =serialize($order);
        $orders->address = $request->input('address');
        $orders->name = $request->input('name');

        Auth::user()->orders()->save($orders);
        Session::forget('order');
        return redirect()->route('itemIndex')->withSuccess('Items purchased succesfuly!');
    }
    public function getLogout(){
        Auth::logout();
        Session::flush();
        return Redirect::to('/');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
     	$items = Item::paginate(3);
     	
     	return view('Items.Items', compact('items'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
	    $menus = Menu::lists('title', 'id');
        return view('Items.Create', compact('menus'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
     	$input = $request->all();
     	
     	if(isset($input['image']))
     	{
	     	//upload $input['image']
	     	$input['image'] = $this->upload ($input['image']);
     	}
     	else
     	{
	     	$input['image'] = 'images/default.jpg';
     	}
     	
     	$input['user_id'] = \Auth::user()->id;
     	
     	$item = Item::create($input);
     	$menus = Menu::lists('title', 'id');
     	return view("Items.Edit", compact('item', 'menus'));
    }
    
    public function upload ($file)
    {
	    $extension = $file->getClientOriginalExtension();
	    $sha1 = sha1($file->getClientOriginalName());
		
		$filename = date('Y-m-d-h-i-s')."_".$sha1.".".$extension;
		$path = public_path('images/Items/');
    	$file->move($path, $filename);
    	
    	return 'images/Items/'.$filename;
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
        $item = Item::findOrFail($id); 
        $menus = Menu::lists('title', 'id');
     	return view("Items.Edit", compact('item', 'menus'));
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
        $input = $request->all();
     	
     	if(isset($input['image']))
	     	$input['image'] = $this->upload ($input['image']);
     	
     	Item::findOrFail($id)->update($input);
     	
     	return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Item::findOrFail($id)->delete();  
        
        return redirect()->back();     
    }
}
