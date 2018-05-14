<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;
use App\Room;
use App\Guest;

class RoomsController extends Controller
{
    public function index() {
    	if (Auth::Check()) {
            if (Auth::user()->isAdmin) {
                $data = $this->listRooms();
                return view('rooms.rooms', compact('data'));
            } else if (Auth::user()->isCook) {
                return redirect('/orders');
            } else if (Auth::user()->isFront) {
                return redirect('/guests');
            }
    	} else {
    		return redirect('/');
    	}
    }

    public function editRoom(Request $request) {
        $occupiedRooms = [];
        $activeGuests = Guest::where('isActive', true)->get();
		$id = $request->get('id');
        $data = Room::find($id);

        foreach ($activeGuests as $id => $active) {
            array_push($occupiedRooms, $active->room_number);
        }
        
        $occupied = in_array($data->number, $occupiedRooms);

        if ($occupied) {
            return redirect("/rooms")->withErrors('An occupied room cannot be edited. Wait until the guest checks out.');
        } else {
            return view('rooms.edit_room',compact('data'));
        }
    }

    public function updateRoom(Request $request) {
    	$data = Room::find($request->post('id'));

    	$rules = array(
			'number' => 'required|integer|unique:rooms,number,'.$data->id,
			'price' => 'required|numeric',
			'available' => 'required'
		);

		$validator = Validator::make(Input::all(), $rules);

		if ($validator->fails()) {
			$messages = $validator->messages();

			return redirect("/rooms/edit-room?id=$data->id")->withErrors($validator);
		} else {
			$data->number = $request->post('number');
	        $data->price = $request->post('price');
	        if ($request->post('available') == "yes") {
	        	$data->isAvailable = true;
	        } else if ($request->post('available') == "no"){
	        	$data->isAvailable = false;
	        }
	        
	        $data->save();
	        
	        return redirect('/rooms')->with('success', 'The room has been updated');
		}
    }

    public function deleteRoom(Request $request){
        $data = Room::find($request->post('id'));
        $occupiedRooms = [];
        $activeGuests = Guest::where('isActive', true)->get();

        foreach ($activeGuests as $id => $active) {
            array_push($occupiedRooms, $active->room_number);
        }
        
        $occupied = in_array($data->number, $occupiedRooms);

        if ($occupied) {
            return redirect("/rooms")->withErrors('An occupied room cannot be deleted. Wait until the guest checks out.');
        } else {
            $data->delete();
            return redirect('/rooms')->with('success','The room has been deleted');
        }

    }

    private function listRooms() {
        $data = Room::all();

        foreach ($data as $room) {
            if ($room->isAvailable) {
                $room->available = "Yes";
            } else {
                $room->available = "No";
            }
        }

        return $data;
    }
}
