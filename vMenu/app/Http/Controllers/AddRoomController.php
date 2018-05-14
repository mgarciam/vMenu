<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;
use App\Room;

class AddRoomController extends Controller
{
    public function index() {
    	if (Auth::Check()) {
    		if (Auth::user()->isAdmin) {
    			return view('rooms.add_rooms');
    		} else if (Auth::user()->isCook) {
    			return redirect('/orders');
    		} else if (Auth::user()->isFront) {
    			return redirect('/guests');
    		}
    	} else {
    		return redirect('/');
    	}
    }

    public function addRoom(Request $request) {
    	$rules = array(
			'number'	=>'required|integer|unique:rooms',
			'price'	=>'required|numeric'
		);

		$validator = Validator::make(Input::all(), $rules);

		if ($validator->fails()) {
			$messages = $validator->messages();

			return redirect('/add-room')->withErrors($validator)->withInput();
		} else {
			$room = new Room();

			$room->number = $request->post('number');
	        $room->price = round($request->post('price'), 2);
	        $room->isAvailable = true;
	        
	        $room->save();       
	        return redirect('/rooms')->with('success', 'A new room has been added');
		}
    }
}
