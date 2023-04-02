<?php
// 食材に関するコントローラー
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Food;

class FoodsController extends Controller
{
    public function index() {
        $foods = Food::all();
        return view('test/food', compact('foods'));
    }
}
