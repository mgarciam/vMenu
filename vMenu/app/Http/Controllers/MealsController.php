<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;
use App\Category;
use App\Food;

class MealsController extends Controller
{
    public function index() {
    	if (Auth::Check()) {
            if (Auth::user()->isAdmin) {
                $data = $this->listMeals();
                return view('meals.meals', compact('data'));
            } else if (Auth::user()->isCook) {
                return redirect('/orders');
            } else if (Auth::user()->isFront) {
                return redirect('/guests');
            }
    	} else {
    		return redirect('/');
    	}
    }

    public function editMeal(Request $request) {
        $id = $request->get('id');
        $data = Food::find($id);
        $category = Category::find($data->category_id);

        if ($category->isAvailable) {
            return view('meals.edit_meal', compact('data'));
        } else {
            return redirect('/meals')->withErrors('The category for this meal is not active. Please activate it first before editing a meal.');
        }  
    }

    public function updateMeal(Request $request) {
        $data = Food::find($request->post('id'));

        if ($request->hasFile('image')) {
            $rules = array(
                'name' => 'required|unique:categories,name,'.$data->id,
                'description' => 'required',
                'price' =>'required|numeric',
                'image' => 'required|image|mimes:jpeg,png,jpg|max:2048',
                'available' => 'required'
            );
        } else {
            $rules = array(
                'name' => 'required|unique:categories,name,'.$data->id,
                'description' => 'required',
                'price' =>'required|numeric',
                'available' => 'required'
            );
        }

        $validator = Validator::make(Input::all(), $rules);

        if ($validator->fails()) {
            $messages = $validator->messages();

            return redirect("/meals/edit-meal?id=$data->id")->withErrors($validator);
        } else {
            $data->name = $request->post('name');
            $data->description = $request->post('description');
            $data->price = $request->post('price');

            if ($request->hasFile('image')) {
                $imageName = time().'.'.$request->image->getClientOriginalExtension();
                $request->image->move(public_path('images'), $imageName);
                $data->image = $imageName;
            }

            if ($request->post('available') == 'yes') {
                $data->isActive = true;
            } else if ($request->post('available') == 'no') {
                $data->isActive = false;
            } 
            
            $data->save();
            
            return redirect('/meals')->with('success', 'The meal has been updated');
        }
    }

    public function deleteMeal(Request $request){
        $data = Food::find($request->post('id'));
        $category = Category::find($data->category_id);

        if ($data->isActive) {
            return redirect('/meals')->withErrors('An active meal cannot be deleted, please deactivate it first.');
        } else {
            $category->decrement('foods_number');
            $data->delete();
            return redirect('/meals')->with('success','The meal has been deleted');
        }
    }

    private function listMeals() {
    	$data = Food::all();

    	foreach ($data as $meal) {
    		$id = $meal->id;
            $cat = Food::find($id)->category_id;
    		$category = Category::find($cat);
            $meal->category = $category->name;
    		
    		if ($meal->isActive) {
    			$meal->available = "Yes";
    		} else {
    			$meal->available = "No";
    		}
    	}

        return $data;
    }
}
