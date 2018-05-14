<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;
use App\Food;
use App\Category;

class AddMealController extends Controller
{
    public function index() {
    	$categories = Category::all();
    	$activeCats = Category::where('isAvailable', true)->get();

    	if (Auth::Check()) {
    		if (count($categories) == 0) {
    			return redirect('/meals')->withErrors('There are no categories registered. Cannot register a meal without a category. Please register some categories first.');
    		} else if (count($activeCats) == 0) {
    			return redirect('/meals')->withErrors('There are no active categories.');
    		} else {
    			if (Auth::user()->isAdmin) {
    				return view('meals.add_meal', compact('activeCats'));
    			} else if (Auth::user()->isCook) {
    				return redirect('/orders');
    			} else if (Auth::user()->isFront) {
    				return redirect('/guests');
    			}
    		}
    	} else {
    		return redirect('/');
    	}
    }

    public function addMeal(Request $request) {
    	$rules = array(
			'name'	=> 'required|unique:foods',
			'description' => 'required',
			'price'	=>'required|numeric',
			'categories' =>'required',
			'image' => 'required|image|mimes:jpeg,png,jpg|max:2048'
		);

		$validator = Validator::make(Input::all(), $rules);

		if ($validator->fails()) {
			$messages = $validator->messages();

			return redirect('/add-meal')->withErrors($validator)->withInput();
		} else {
			$cat_id = $request->get('categories');
			$category = Category::find($cat_id);
			$meal = new Food();

			$imageName = time().'.'.$request->image->getClientOriginalExtension();
        	$request->image->move(public_path('images'), $imageName);

			$meal->name = $request->post('name');
			$meal->description = $request->post('description');
			$meal->price = round($request->post('price'), 2);
	        $meal->image = $imageName;
	        $meal->sold_amount = 0;
	        $meal->isActive = true;
	        $meal->category_id = $category->id;

	        $category->increment('foods_number');
	        
	        $meal->save();       
	        return redirect('/meals')->with('success', 'A new meal has been added');
		}
    }
}
