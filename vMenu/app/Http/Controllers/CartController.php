<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;
use App\Mail\OrderStatusMail;
use Illuminate\Support\Facades\Mail;
use App\Order;
use App\FoodOrders;
use App\Food;
use App\Guest;
use App\User;

class CartController extends Controller
{
    public function index() {
    	if (Cart::count() == 0) {
    		return redirect('/');
    	} else {
    		return view('cart');
    	}
    }

    public function deleteItem(Request $request) {
    	$id = $request->get('id');

    	Cart::remove($id);

    	if (Cart::count() == 0) {
    		return redirect('/');
    	} else {
    		return redirect('/see-cart');
    	}
    }

    public function checkout(Request $request) {
    	if (Auth::Check()) {
    		if (Auth::user()->isAdmin) {
    			$total = str_replace( ',', '', Cart::subtotal());

    			$order = Order::create([
					'guest_id' => null,
					'total' => floatval($total),
					'status' => 0
				]);

				foreach (Cart::content() as $item) {
					
		            FoodOrders::create([
		                'order_id' => $order->id,
		                'food_id' => $item->id,
		                'quantity' => $item->qty
		            ]);

		            $food = Food::find($item->id);

			        $food->increment('sold_amount');
		        }

		        Cart::destroy();

		        return redirect('/')->with('success', 'Your order has been registered');
    		} else {
    			Cart::destroy();
    			return redirect('/')->withErrors('What are you doing there?');
    		}
    	} else {
    		$rules = array(
				'email'	=> 'required|email'
			);

			$validator = Validator::make(Input::all(), $rules);

			if ($validator->fails()) {
				$messages = $validator->messages();

				return redirect('/see-cart')->withErrors($validator)->withInput();
			} else {
				$id = Guest::where('email', $request->post('email'))->first();

				if ($id == null) {
					Cart::destroy();
					return redirect('/')->withErrors('You are not a registered guest');
				} else {

					$total = str_replace( ',', '', Cart::subtotal());

					$order = Order::create([
						'guest_id' => $id->id,
						'total' => floatval($total),
						'status' => 0
					]);

					foreach (Cart::content() as $item) {
			            FoodOrders::create([
			                'order_id' => $order->id,
			                'food_id' => $item->id,
			                'quantity' => $item->qty
			            ]);

			            $food = Food::find($item->id);

			            $food->increment('sold_amount');
			        }

			        Cart::destroy();
			        $this->sendMailStatusUpdate($id->name, $order->id, "Pending", $id->email);
			        return redirect('/')->with('success', 'Your order has been registered');
				}
			}
    	}
    }

    protected function sendMailStatusUpdate($name, $number, $status, $email) {
        $obj = new \stdClass();
        $obj->sender = 'Marilyn García, CEO';
        $obj->receiver = $name;
        $obj->number = $number;
        $obj->status = $status;
 
        Mail::to($email)->send(new OrderStatusMail($obj));
    }  
}
