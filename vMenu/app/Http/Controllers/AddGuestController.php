<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;
use App\Mail\BookedRoomMail;
use Illuminate\Support\Facades\Mail;
use App\Guest;
use App\Room;

class AddGuestController extends Controller
{
    public function index() {
    	$rooms = Room::all();
    	$availableRooms = Room::where('isAvailable', true)->get();

    	if (Auth::Check()) {
    		if (count($rooms) == 0) {
    			return redirect('/guests')->withErrors('There are no rooms registered. Cannot register a guest without a room. Please register some rooms first.');
    		} else if (count($availableRooms) == 0) {
    			return redirect('/guests')->withErrors('There are no available rooms.');
    		} else {
    			if (Auth::user()->isAdmin || Auth::user()->isFront) {
    				return view('guests.add_guest', compact('availableRooms'));
    			} else if (Auth::user()->isCook) {
    				return redirect('/orders');
    			} 
    		}
    	} else {
    		return redirect('/');
    	}
    }

    public function addGuest(Request $request) {
    	$rules = array(
			'name'	=>'required',
			'surname'	=>'required',
			'rooms'	=>'required',
			'email'	=>'required|email|unique:guests',
			'stay'	=>'required|integer',
			'phone'	=>'required|integer|digits:10'
		);

		$validator = Validator::make(Input::all(), $rules);

		if ($validator->fails()) {
			$messages = $validator->messages();

			return redirect('/add-guest')->withErrors($validator)->withInput();
		} else {
			$guest = new Guest();
			
			$room_id = $request->post('rooms');
			$room = Room::find($room_id);

			$guest->name = $request->post('name');
	        $guest->surname = $request->post('surname');
	        $guest->room_number = $room->number;
	        $guest->email = $request->post('email');
	        $guest->phone = $request->post('phone');
	        $guest->stay_duration = $request->post('stay');
	        $guest->invoice_total = round($room->price * $request->post('stay'), 2);
	        $guest->isActive = true;

	        $room->isAvailable = false;
	        
	        $guest->save();
	        $room->save(); 
	        $this->sendMailBookedRoom($guest->name, $room->number, $guest->email, $room->price, $guest->stay_duration);      
	        return redirect('/guests')->with('success', 'The guest has been registered');
		}
    }

    protected function sendMailBookedRoom($name, $number, $email, $price, $stay) {
        $obj = new \stdClass();
        $obj->sender = 'Marilyn García, CEO';
        $obj->receiver = $name;
        $obj->number = $number;
        $obj->price = $price;
        $obj->stay = $stay;
 
        Mail::to($email)->send(new BookedRoomMail($obj));
    }
}
