<?php
namespace App;

class MealOrder
{
	public $items = null;
	public $quantity =0;
	public $totalPrice =0;
	public function __construct($oldOrder){
	if($oldOrder){
		$this->items =$oldOrder->items;
		$this->quantity =$oldOrder->quantity;
		$this->totalPrice =$oldOrder->totalPrice;
		}

	}
	public function add($item,$id){
	
		$storedItem =  ['qty' => 0,'price' => $item->price,'item' => $item];
		if($this->items){

			if(array_key_exists($id, $this->items)){
				$storedItem = $this->items[$id];
			}
		}
		$storedItem['qty']++;
		$storedItem['price'] = $item->price * $storedItem['qty'];
		$this->items[$id] =$storedItem;
		$this->quantity++;
		$this->totalPrice += $item->price;
	}

}





