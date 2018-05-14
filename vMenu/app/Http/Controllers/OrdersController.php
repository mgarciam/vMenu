<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;
use App\Mail\OrderStatusMail;
use Illuminate\Support\Facades\Mail;
use App\Guest;
use App\Order;
use App\Food;
use App\FoodOrders;

class OrdersController extends Controller
{
    public function index() {
    	if (Auth::Check()) {
            if (Auth::user()->isAdmin || Auth::user()->isCook) {
                $data = $this->listOrders();
                return view('orders.orders', compact('data'));
            } else if (Auth::user()->isFront) {
                return redirect('/guests');
            }
    	} else {
    		return redirect('/');
    	}
    }

    public function editOrder(Request $request) {
		$id = $request->get('id');
        $data = Order::find($id);
        $guest = $data->guest;
        $goodMeals = [];

        $meals = FoodOrders::where('order_id', $data->id)->paginate(10);
        
        foreach ($meals as $meal) {
        	$meal = Food::find($meal->food_id);
        	array_push($goodMeals, $meal);
        }

        if ($data->status == 0) {
            $data->stat = "Pending";
        } else if ($data->status == 1) {
            $data->stat = "In process";
        } else if ($data->status == 2) {
            $data->stat = "Sent";
        } else if ($data->status == 3) {
            $data->stat = "Delivered";
        }

        if ($data->status == 3) {
        	return redirect("/orders")->withErrors('A delivered order cannot be updated');
        } else {
        	return view('orders.edit_order', compact('data', 'guest', 'goodMeals'));
        }
    }

    public function updateOrder(Request $request) {
    	$data = Order::find($request->post('id'));

		$rules = array(
			'status' => 'required'
		);
    	
		$validator = Validator::make(Input::all(), $rules);

		if ($validator->fails()) {
			$messages = $validator->messages();

			return redirect("/orders/edit-order?id=$data->id")->withErrors($validator);
		} else {
			if ($request->post('status') == 0) {
				$data->status = 0;
                
			} else if ($request->post('status') == 1) {
				$data->status = 1;
                
			} else if ($request->post('status') == 2) {
				$data->status = 2;
               
			} else if ($request->post('status') == 3) {
				$data->status = 3;
                
			}

			if ($data->guest_id) {
                $guest = Guest::find($data->guest_id);

                if ($request->post('status') == 0) {
                    $status = "Pending";
                } else if ($request->post('status') == 1) {
                    $status = "In process";
                } else if ($request->post('status') == 2) {
                    $status = "Sent";
                } else if ($request->post('status') == 3) {
                    $status = "Delivered";
                }

				if ($request->post('status') == 3) {
					$guest->invoice_total = $guest->invoice_total + $data->total;
					$guest->save();
				}

                $this->sendMailStatusUpdate($guest->name, $data->id, $status, $guest->email);
			}

	        $data->save();
	        
	        return redirect('/orders')->with('success', 'The order has been updated');
		}
    }

    public function deleteOrder(Request $request){
        $data = Order::find($request->post('id'));

        if ($data->status < 3) {
        	return redirect("/orders")->withErrors('An order that is not delivered cannot be deleted');
        } else {
        	return redirect('/orders')->with('success', 'The order has been deleted');
        }
    }

    private function listOrders() {
        $data = Order::all();

        if (count($data) > 0) {
        	foreach ($data as $o) {
        		$guest = Guest::find($o->guest_id);
        		if ($guest == null) {
        			$o->name = "Admin";
        			$o->surname = "Admin";
        		} else {
        			$o->name = $guest->name;
        			$o->surname = $guest->surname;
        		}

                if ($o->status == 0) {
                    $o->stat = "Pending";
                } else if ($o->status == 1) {
                    $o->stat = "In process";
                } else if ($o->status == 2) {
                    $o->stat = "Sent";
                } else if ($o->status == 3) {
                    $o->stat = "Delivered";
                }
            }
        }

        return $data;
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
