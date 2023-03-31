<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Fridge;
use App\Models\Food;
use App\Models\Recipe;
use App\Models\Ingredient;

class FridgesController extends Controller
{
    public function top(){
        $user = Auth::user();
        if(!empty($user)){
            $id_arr = array();
            
            // オススメレシピ
            // 冷蔵庫の食材全部取得
            $fridges = Fridge::where('user_id', $user->id)
                ->orderByRaw('expiry is null asc')
                ->orderBy('expiry','asc')
                ->get();
            foreach($fridges as $fridge){
                $ingredient = Ingredient::where('food_id', $fridge->food_id)->inRandomOrder()->first();
                if(!empty($ingredient)){
                    if(!in_array($ingredient->recipe_id, $id_arr)){
                        $id_arr[] = $ingredient->recipe_id;
                        $recipe = Recipe::find($ingredient->recipe_id);
                        $recommends[] = $recipe;
                    }
                }
            }
            // $today = date("Y-m-d");
            $week = date("Y-m-d", strtotime("+1 week"));
            // 賞味期限が1週間に迫っている食材
            $fridges = Fridge::where('user_id', $user->id)
            ->join('foods', 'fridges.food_id', '=', 'foods.id')
            ->select(
                'fridges.id', 
                'fridges.food_id',
                'fridges.user_id',
                'fridges.stock',
                'fridges.expiry',
                'foods.food',
            )
            ->where('expiry', '<=', $week)
            ->orderBy('expiry', 'asc')
            ->get();
            $count = $fridges->count();
            if(empty($recommends)){
                $recipes = Recipe::inRandomOrder()->get();
                foreach($recipes as $recipe){
                    $recommends[] = $recipe;
                }
            }
        } else {
            // ログインしてないユーザ
            $count = 0;
            $fridges = 0;
            $recommends = 0;
        }
        return view('fridges/top', compact('fridges', 'count', 'recommends'));
    }

    public function fridge(){
        $user = Auth::user();
        if(empty($user)){
            return redirect('/');
        }
        $fridges = Fridge::where('user_id', $user->id)
            ->join('foods', 'fridges.food_id', '=', 'foods.id')
            ->select(
                'fridges.id', 
                'fridges.food_id',
                'fridges.user_id',
                'fridges.stock',
                'fridges.expiry',
                'foods.food',
            )
            // nullを後ろに持ってくる(https://qiita.com/mitashun/items/a67bc664f7872c0d10d8)
            ->orderByRaw('expiry is null asc')
            ->orderBy('expiry', 'asc')
            ->get();
        $count = $fridges->count();
        return view('fridges.fridge', compact('user', 'fridges', 'count'));
    }

    public function minus(Request $request){
        $fridge = Fridge::find($request['id']);
        $fridge->stock--;
        $fridge->save();
        return $fridge->stock;
    }

    public function plus(Request $request){
        $fridge = Fridge::find($request['id']);
        $fridge->stock++;
        $fridge->save();
        return $fridge->stock;
    }

    public function delete(Request $request){
        $fridge = Fridge::find($request['id']);
        $fridge->delete();
        return redirect('/');
    }

    public function delete_ajax(Request $request){
        $fridge = Fridge::find($request['id']);
        $fridge->delete();
        return $request['id']; 
    }

    public function insert(Request $request){
        // バリデーション
        $validate = [
            'food' => 'required|max:20',
            'stock' => ['required','gte:1','lte:99'],
            'expiry' => ['nullable','date','after_or_equal:today']
        ];
        $msg = [
            'food.required' => '食材を入力して下さい',
            'food.max' => '食材名は20文字以内で入力してください',
            'stock.required' => '個数は入力必須です',
            'stock.gte' => '半角数字1~99で入力して下さい',
            'stock.lte' => '半角数字1~99で入力して下さい',
            'expiry.date' => 'カレンダーから入力して下さい',
            'expiry.after_or_equal' => '本日以降の日付を入力して下さい'
        ]; 
        // $request->validate():第一引数にバリデーションの条件、第二引数にエラーメッセージ
        $request->validate($validate, $msg);

        $stock = mb_convert_kana($request['stock'], "n");
        $user = Auth::user();
        $sql = array(
            'user_id' => $user->id,
            'stock' => $stock,
            'expiry' => $request['expiry'],
        );
        $food = Food::firstOrCreate([
            'food' => $request['food']
        ]);
        $sql['food_id'] = $food->id;
        Fridge::create($sql);
        return redirect('/fridge');
    }

    public function expiry(Request $request){
        $fridge = Fridge::find($request["id"]);
        $fridge->expiry = $request["expiry"];
        $fridge->save();
        $F = $fridge;
        return $F;
    }
}
