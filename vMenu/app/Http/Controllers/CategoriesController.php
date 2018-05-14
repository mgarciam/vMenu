<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;
use App\Category;
use App\Food;

class CategoriesController extends Controller
{
    public function index() {
    	if (Auth::Check()) {
            if (Auth::user()->isAdmin) {
                $data = $this->listCategories();
                return view('categories.categories', compact('data'));
            } else if (Auth::user()->isCook) {
                return redirect('/orders');
            } else if (Auth::user()->isFront) {
                return redirect('/guests');
            }
    	} else {
    		return redirect('/');
    	}
    }

    public function editCategory(Request $request) {
		$id = $request->get('id');
        $data = Category::find($id);
        $foods = Food::all();

        if (count($foods) > 0) {
        	$meals = $data->foods;
        	foreach ($meals as $meal) {
        		if ($meal->isActive) {
        			$meal->available = "Yes";
        		} else {
        			$meal->available = "No";
        		}
        	}
        	return view('categories.edit_category', compact('data', 'meals'));
        } else {
        	return view('categories.edit_category', compact('data'));
        }
    }

    public function updateCategory(Request $request) {
    	$data = Category::find($request->post('id'));

    	if ($request->hasFile('image')) {
    		$rules = array(
				'name' => 'required|unique:categories,name,'.$data->id,
				'image' => 'required|image|mimes:jpeg,png,jpg|max:2048',
				'active' => 'required'
			);
    	} else {
    		$rules = array(
				'name' => 'required|unique:categories,name,'.$data->id,
				'active' => 'required'
			);
    	}

		$validator = Validator::make(Input::all(), $rules);

		if ($validator->fails()) {
			$messages = $validator->messages();

			return redirect("/categories/edit-category?id=$data->id")->withErrors($validator);
		} else {
			$data->name = $request->post('name');

			if ($request->hasFile('image')) {
				$imageName = time().'.'.$request->image->getClientOriginalExtension();
        		$request->image->move(public_path('images'), $imageName);
				$data->image = $imageName;
			}

			if ($request->post('active') == 'yes') {
				$data->isAvailable = true;
			} else if ($request->post('active') == 'no') {
				$data->isAvailable = false;
				$foods = Food::all();

				if (count($foods) > 0){
					$meals = $data->foods;
					foreach ($meals as $meal) {
						$meal->isActive = false;
						$meal->save();
					}
				}
			} 
	        
	        $data->save();
	        
	        return redirect('/categories')->with('success', 'The category has been updated');
		}
    }

    public function deleteCategory(Request $request){
        $data = Category::find($request->post('id'));

        if ($data->isAvailable) {
        	return redirect('/categories')->withErrors('An active category cannot be deleted, please deactivate it first.');
        } else {
        	$data->delete();
        	return redirect('/categories')->with('success','The category has been deleted');
        }
    }

    private function listCategories() {
    	$data = Category::all();

    	foreach ($data as $category) {
    		if ($category->isAvailable) {
    			$category->active = "Yes";
    		} else {
    			$category->active = "No";
    		}
    	}

        return $data;
    }
}
