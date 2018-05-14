<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;
use App\Mail\FarewellEMail;
use Illuminate\Support\Facades\Mail;
use App\Guest;
use App\Room;
use App\Order;

class GuestsController extends Controller
{
    public function index() {
    	if (Auth::Check()) {
            if (Auth::user()->isAdmin || Auth::user()->isFront) {
                $data = $this->listGuests();
                return view('guests.guests', compact('data'));
            } else {
                return redirect('/orders');
            }
    	} else {
    		return redirect('/');
    	}
    }

    public function editGuest(Request $request) {
        $id = $request->get('id');
        $data = Guest::find($id);
        $orders = Order::all();

        if (count($orders) > 0) {
            $ord = $data->orders;

            foreach ($ord as $o) {
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
            return view('guests.edit_guest',compact('data', 'ord'));
        } else {
            return view('guests.edit_guest',compact('data'));
        }
    }

    public function updateGuest(Request $request) {
        $data = Guest::find($request->post('id'));

        $rules = array(
            'name'  =>'required',
            'surname' =>'required',
            'email' =>'required|email|unique:guests,email,'.$data->id,
            'phone' =>'required|integer|digits:10'
        );

        $validator = Validator::make(Input::all(), $rules);

        if ($validator->fails()) {
            $messages = $validator->messages();

            return redirect("/guests/edit-guest?id=$data->id")->withErrors($validator);
        } else {
            $data->name = $request->post('name');
            $data->surname = $request->post('surname');
            $data->email = $request->post('email');
            $data->phone = $request->post('phone');

            $data->save();
            
            return redirect('/guests')->with('success', 'The guest has been updated');
        }
    }

    public function deleteGuest(Request $request){
        $data = Guest::find($request->post('id'));
        $detected = $this->searchRoom($data->room_number);
        $room = Room::find($detected->id);
        $room->isAvailable = true;

        $room->save();
        $data->delete();
        $this->sendMailFarewell($data->name, $data->invoice_total, $data->email);
        return redirect('/guests')->with('success','The guest has been deleted');
        
    }

    private function searchRoom($number) {
        $rooms = Room::where('isAvailable', false)->get();
        $detected = null;

        foreach ($rooms as $room) {
            if ($room->number == $number) {
                $detected = $room;
                break;
            }
        }

        return $detected;
    }

    private function listGuests() {
        $data = Guest::all();

        foreach ($data as $guest) {
        	if ($guest->isActive) {
        		$guest->active = 'Yes';
        	} else {
        		$guest->active = 'No';
        		$guest->invoice_total = 0.00;
        	}

        	if ($guest->invoice_total == null) {
        		$guest->invoice_total = 0.00;
        	}
        }

        return $data;
    }

    protected function sendMailFarewell($name, $invoice, $email) {
        $obj = new \stdClass();
        $obj->sender = 'Marilyn García, CEO';
        $obj->receiver = $name;
        $obj->invoice = $invoice;
 
        Mail::to($email)->send(new FarewellEMail($obj));
    }
}
