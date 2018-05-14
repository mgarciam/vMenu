<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Hash;
use App\Mail\AccountCreatedMail;
use Illuminate\Support\Facades\Mail;
use App\User;

class AddUserController extends Controller
{
    public function index() {
    	if (Auth::Check()) {
    		if (Auth::user()->isAdmin) {
    			return view('admins.add_user');
    		} else if (Auth::user()->isCook) {
    			return redirect('/orders');
    		} else if (Auth::user()->isFront) {
    			return redirect('/guests');
    		}	
    	} else {
    		return redirect('/');
    	}
    }

    public function addUser(Request $request) {
    	$rules = array(
			'name'	=>'required',
			'surname'	=>'required',
			'email'	=>'required|email|unique:users',
			'password' => 'required|confirmed',
			'password_confirmation'	=>'required',
			'role' => 'required'
		);

		$validator = Validator::make(Input::all(), $rules);

		if ($validator->fails()) {
			$messages = $validator->messages();

			return redirect('/add-user')->withErrors($validator)->withInput();
		} else {
			$user = new User();

			$user->name = $request->post('name');
	        $user->surname = $request->post('surname');
	        $user->email = $request->post('email');
	        $user->password = bcrypt($request->post('password'));

			if ($request->post('role') == 'admin') {
				$user->isAdmin = true;
				$user->isCook = false;
				$user->isFront = false;
			} else if ($request->post('role') == 'cook') {
				$user->isAdmin = false;
				$user->isCook = true;
				$user->isFront = false;
			} else if ($request->post('role') == 'front') {
				$user->isAdmin = false;
				$user->isCook = false;
				$user->isFront = true;
			}
	        
	        $user->save(); 
	        $this->sendMailAccCreated($user->name, $request->post('role'), $user->email);      
	        return redirect('/admins')->with('success', 'A new user has been added');
		}
    }

    protected function sendMailAccCreated($name, $role, $email) {
        $obj = new \stdClass();
        $obj->sender = 'Marilyn García, CEO';
        $obj->receiver = $name;
        $obj->role = $role;
 
        Mail::to($email)->send(new AccountCreatedMail($obj));
    }
}
