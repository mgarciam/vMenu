<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;
use App\Category;

class AddCategoryController extends Controller
{
    public function index() {
    	if (Auth::Check()) {
    		if (Auth::user()->isAdmin) {
    			return view('categories.add_category');
    		} else if (Auth::user()->isCook) {
    			return redirect('/orders');
    		} else if (Auth::user()->isFront) {
    			return redirect('/guests');
    		}
    	} else {
    		return redirect('/');
    	}
    }

    public function addCategory(Request $request) {
    	$rules = array(
			'name'	=>'required|unique:categories',
			'image' => 'required|image|mimes:jpeg,png,jpg|max:2048'
		);

		$validator = Validator::make(Input::all(), $rules);

		if ($validator->fails()) {
			$messages = $validator->messages();

			return redirect('/add-category')->withErrors($validator)->withInput();
		} else {
			$category = new Category();

			$imageName = time().'.'.$request->image->getClientOriginalExtension();
        	$request->image->move(public_path('images'), $imageName);

			$category->name = $request->post('name');
	        $category->image = $imageName;
	        $category->foods_number = 0;
	        $category->isAvailable = true;
	        
	        $category->save();       
	        return redirect('/categories')->with('success', 'A new category has been added');
		}
    }
}
