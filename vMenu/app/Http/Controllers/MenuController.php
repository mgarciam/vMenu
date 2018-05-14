<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Gloudemans\Shoppingcart\Facades\Cart;
use App\Category;
use App\Food;

class MenuController extends Controller
{
    public function index() {
		$data = $this->listCategories();
		$meals = $this->listMeals();
		return view('welcome', compact('data', 'meals'));
    	
    }

    public function addToCart(Request $request) {
    	$id = (string)$request->post('id');
    	$qty = $request->post('qty');
    	$data = Food::find($request->post('id'));

        if ($qty > 0) {
            Cart::add($id, $data->name, $qty, $data->price);

            return redirect('/');
        } else {
            return redirect('/')->withErrors('At least one item must be added');
        }
    }

    private function listCategories() {
    	$data = Category::where('isAvailable', true)->get();

        return $data;
    }

    private function listMeals() {
    	$data = Food::where('isActive', true)->get();

    	foreach ($data as $meal) {
    		$category = $meal->category;
    		$meal->category = $category->name;
    	}

        return $data;
    }
}
