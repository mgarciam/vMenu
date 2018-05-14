<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Hash;
use App\Mail\PasswordChangedMail;
use Illuminate\Support\Facades\Mail;
use App\User;

class SettingsController extends Controller
{
    public function index() {
    	if(Auth::Check()) {
    		$id = Auth::user()->id;
    		return view('settings.settings')->withId($id);
    	} else {
    		return redirect("/");
    	}
    }

    public function update(Request $request) {
    	$data = User::find($request->post('id'));
    	$currentPass = $data->password;

		$rules = array(
			'current-password'	=>'required',
			'password'	=>'required|confirmed',
			'password_confirmation'	=>'required'
		);

		$validator = Validator::make(Input::all(), $rules);

		if ($validator->fails()) {
			$messages = $validator->messages();

			return redirect("/settings")->withErrors($validator);
		} else if (Hash::check($request->post('current-password'), $currentPass)){
	        $data->password = bcrypt($request->post('password'));
	        $data->save();
	        $this->sendMail();
	        return redirect('/settings')->with('success','Your password has been updated');
		} else {
			return redirect("/settings")->withErrors('Current password is not correct');
		}
    }

    public function updateInfo(Request $request) {
    	if (Auth::Check()) {
    		$data = User::find($request->post('id'));

			$rules = array(
				'name'	=>'required',
				'surname'	=>'required',
				'email'	=>'required|email|unique:users,email,'.$data->id
			);

			$validator = Validator::make(Input::all(), $rules);

			if ($validator->fails()) {
				$messages = $validator->messages();

				return redirect("/settings")->withErrors($validator);
			} else{
		        $data->name = $request->post('name');
		        $data->surname = $request->post('surname');
		        $data->email = $request->post('email');
		        $data->save();
		        return redirect('/settings')->with('success','Your information has been updated');
			} 
    	} else {
    		return redirect("/");
    	}
    	
    }

    protected function sendMail() {
        $obj = new \stdClass();
        $obj->sender = 'Marilyn García, CEO';
        $obj->receiver = Auth::user()->name;
        $obj->account = Auth::user()->email;
 
        Mail::to(Auth::user()->email)->send(new PasswordChangedMail($obj));
    }
}
