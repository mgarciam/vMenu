<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Hash;
use App\Mail\RoleChangedMail;
use Illuminate\Support\Facades\Mail;
use App\User;

class AdminsController extends Controller
{
    public function index() {
    	if (Auth::Check()) {
            if (Auth::user()->isAdmin) {
                $data = $this->listUsers();
                return view('admins.admins', compact('data'));
            } else if (Auth::user()->isCook) {
                return redirect('/orders');
            } else if (Auth::user()->isFront) {
                return redirect('/guests');
            }
    	} else {
    		return redirect('/');
    	}
    	
    }

    public function editUser(Request $request) {
		$id = $request->get('id');
        $data = User::find($id);

    	if ($data->isAdmin) {
    		$data->role = "Admin";
    	} else if ($data->isCook) {
    		$data->role = "Cook";
    	} else if ($data->isFront) {
    		$data->role = "Front-desk";
    	}

        return view('admins.edit_user',compact('data'));
    }

    public function updateUser(Request $request) {
    	$data = User::find($request->post('id'));

    	$rules = array(
			'role' => 'required'
		);

		$validator = Validator::make(Input::all(), $rules);

		if ($validator->fails()) {
			$messages = $validator->messages();

			return redirect("/admins/edit-user?id=$data->id")->withErrors($validator);
		} else {
			if ($request->post('role') == 'admin') {
				$data->isAdmin = true;
				$data->isCook = false;
				$data->isFront = false;
			} else if ($request->post('role') == 'cook') {
				$data->isAdmin = false;
				$data->isCook = true;
				$data->isFront = false;
			} else if ($request->post('role') == 'front') {
				$data->isAdmin = false;
				$data->isCook = false;
				$data->isFront = true;
			}
	        
	        $data->save();
	        $this->sendMailRoleChanged($data->name, $request->post('role'), $data->email);
	        return redirect('/admins')->with('success', 'The user has been updated');
		}
    }

    public function deleteUser(Request $request){
        $users = User::all();
        $data = User::find($request->post('id'));

        if ($data->id == Auth::user()->id) {
            return redirect("/admins")->withErrors('You are not allowed to delete your own account');
        }

        if (count($users) == 1) {
            return redirect("/admins")->withErrors('At least one admin user must be left');
        } else {
            $data->delete();
            return redirect('/admins')->with('success','The user has been deleted');
        }
    }

    private function listUsers() {
        $data = User::all();

        foreach ($data as $user) {
        	if ($user->isAdmin) {
        		$user->role = 'Admin';
        	} else if ($user->isCook) {
        		$user->role = "Cook";
        	} else if ($user->isFront) {
        		$user->role = "Front-desk";
        	}
        }

        return $data;
    }

    protected function sendMailRoleChanged($name, $role, $email) {
        $obj = new \stdClass();
        $obj->sender = 'Marilyn García, CEO';
        $obj->receiver = $name;
        $obj->role = $role;
 
        Mail::to($email)->send(new RoleChangedMail($obj));
    }  
}
