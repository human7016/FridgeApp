<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Recipe;
use App\Models\Food;
use App\Models\Favorite;
use App\Models\Fridge;
use App\Models\Ingredient;

class RecipesController extends Controller
{
    public function index(Request $request) {
        $foods = array();
        $user = Auth::user();
        $type = $request['type'];
        switch($type){
        case "posted":
            $recipes = Recipe::where('user_id', $user->id)->get();
            $word = '投稿レシピ';
            return view('recipes/index', compact('recipes', 'word'));
            break;

        case "favorite":
            $favorites = Favorite::where('user_id',$user->id)->get();
            foreach($favorites as $favorite){
                $recipes[] = Recipe::where('id', $favorite->recipe_id)->first();
            }
            $word = 'お気に入りレシピ';
            return view('recipes/index', compact('recipes', 'word'));
            break;

        case "fridge":
            $user = Auth::user();
            $fridges = Fridge::where('user_id', $user->id)
                ->join('foods', 'fridges.food_id', '=', 'foods.id')
                ->select('foods.food')
                ->get();
            foreach(Recipe::all() as $pre_recipe){
                $count = 0;
                $ingredients = Ingredient::join('foods', 'food_recipe.food_id', '=', 'foods.id')
                    ->where("recipe_id", $pre_recipe->id)
                    ->get();
                foreach($ingredients as $ingredient){
                    foreach($fridges as $fridge){
                        if(strpos($ingredient->food, $fridge->food) !== false){
                            $count++;
                            if($count == $ingredients->count()){
                                $recipes[] = $pre_recipe;
                                break;
                            }
                        }
                    }
                } 
            }
            $word = "余った食材で作れるレシピが見つかりませんでした。";
            if(empty($recipes)){ return view('recipes/index', compact('word')); }
            $word = "余り物で作れるレシピ";
            return view('recipes/index', compact('recipes', 'word'));
            break;

        default :
            echo 'エラー';
            dd($type);
        }
    }

    public function search(Request $request) {
        $id_arr = array();
        $user = Auth::user();
        $food = Food::where('food', $request['word'])->first();
        // タイトルからLIKE検索して$recipeに追加
        $searches = Recipe::where('title', 'like', '%'.$request['word'].'%')->get();
        foreach($searches as $search){
            $recipes[] = $search;
            $id_arr[] = $search->id;
        }
        if(!empty($food)){
            // レシピの
            foreach(Recipe::all() as $recipe){
                // 食材が
                foreach($recipe->foods as $recipe_food){
                    // 検索ワードと食材IDが同じ時
                    if($food->id == $recipe_food->pivot->food_id){
                        // で、かつrecipesに入ってないならレシピ追加
                        if(!in_array($recipe->id, $id_arr)){
                            $recipes[] = $recipe;
                            $id_arr[] = $recipe->id;
                        }
                    }
                }
            }
        }
        // レシピから検索して$recipesに追加
        $searchs = Recipe::Where('recipe', 'like', '%'.$request['word'].'%')->get();
        foreach($searches as $search){
            if(!in_array($search->id, $id_arr)){
                $recipes[] = $recipe;
                $id_arr[] = $recipe->id;
            }
        }
        
        
        if(empty($recipes)){
            $word = '「'.$request['word']."」のレシピは見つかりませんでした。";
            return view('recipes/index', compact('word'));
        }
        $word = "「".$request['word']."」の検索結果";
        return view('recipes/index', compact('recipes', 'word'));
    }

    public function show(Request $request) {
        $user = Auth::user();
        $recipe = Recipe::where('id', $request->id)->first();
        // $recipe->foods()->get() == $recipe->foods;
        $foods = $recipe->foods;
        $favorite = Favorite::where('recipe_id', $request->id)
            ->where('user_id', $user->id)
            ->first();
        return view('recipes/show', compact('user', 'recipe', 'foods', 'favorite'));
    }
    
    public function get_create(){
        $user = Auth::user();
        if(empty($user)){
            return redirect('/');
        }
        return view('recipes/create', compact('user'));
    }

    public function post_create(Request $request){
        $user = Auth::user();
        if(empty($user)){
            return redirect('/');
        }
        return view('recipes/create', compact('request'));
    }

    public function confirm(Request $request){
        // バリデーション
        $validate = [
            'title' => 'required',
            'recipe' => 'required',
            'image' => 'nullable|file',
        ];
        
        $msg = [
            'title.required' => '入力して下さい',
            'recipe.required' => '入力して下さい',
            'image.file' => 'ファイル形式で選択して下さい',
        ]; 
        // $request->validate():第一引数にバリデーションの条件、第二引数にエラーメッセージ
        $request->validate($validate, $msg);

        $user = Auth::user();
        if(empty($user)){
            return redirect('/');
        }
        $title = $request['title'];
        $recipe = ($request['recipe']);

        // 食材food_arrと分量amount_arr
        foreach($request['foods'] as $food){ $foods[] = $food; }
        foreach($request['amounts'] as $amount){ $amounts[] = $amount; }
        for($i = 0; $i < 25; $i++){
            if(empty($foods[$i])||empty($amounts[$i])){
                continue;
            }
            $food_arr[] = $foods[$i];
            $amount_arr[] = $amounts[$i];
        }

        // 画像保存(一時保存)
        if(!empty($request->file('image'))){
        $dir = 'foods';
        $file_name = $request->file('image')->getClientOriginalName();
        $request->file('image')->storeAs('public/' . $dir, $file_name);
        $image = 'storage/' . $dir . '/' . $file_name;
        }else{
        $image = 'storage/NO_IMAGE.jpeg';
        }

        return view('recipes.confirm', compact('user','title', 'recipe', 'image' ,'food_arr', 'amount_arr'));
    }

    public function insert(Request $request){
        $user = Auth::user();
        $sql = array(
            'title' => $request['title'],
            'user_id' => $user->id,
            'image' => $request['image'],
            'recipe' => $request['recipe']
        );
        $recipe = Recipe::create($sql);
        foreach($request['foods'] as $food){ $foods[] = $food; }
        foreach($request['amounts'] as $amount){ $amounts[] = $amount; }
        // foodsテーブルにない食材が呼ばれた時にレコードを生成(firstOrCreate:https://readouble.com/laravel/8.x/ja/eloquent.html)
        for($i=0; $i<count($foods); $i++){
            if(empty($foods[$i])){
                break;
            }
            $param = Food::firstOrCreate([
                'food' => $foods[$i]
            ]);
            // $recipe->foods()->sync(array( id => ['amount' => $amounts[0]] ))の形になるように$paramsにキーとハッシュを渡す
            $params[$param->id] = ['amount' => $amounts[$i]];
        }
        // 中間テーブル(https://beyondjapan.com/blog/2022/01/laravel-sync/)
        $recipe->foods()->sync($params);
        return redirect('user');
    }

    public function edit(Request $request){
        $user = Auth::user();
        if(empty($user)){
            return redirect('/');
        }

        $recipe = Recipe::where('id', $request->id)->first();
        $foods = $recipe->foods;
        // imageを文字列置換(ファイル選択フォームの初期値変更、bootstrapだと無理なのかも)
        if($recipe->image == "storage/NO IMAGE.jpeg"){
            $image = str_replace("storage/NO IMAGE", "", $recipe->image);
        } else {
            $image = str_replace('storage/foods/', '', $recipe->image);
        }
        return view('recipes/edit', compact('user', 'recipe', 'foods', 'image'));
    }

    public function update(Request $request){
        // バリデーション
        $validate = [
            'title' => 'required',
            'recipe' => 'required',
            'image' => 'nullable|file',
        ];
        
        $msg = [
            'title.required' => '入力して下さい',
            'recipe.required' => '入力して下さい',
            'image.file' => 'ファイル形式で選択して下さい',
        ]; 
        // $request->validate():第一引数にバリデーションの条件、第二引数にエラーメッセージ
        $request->validate($validate, $msg);
        $user = Auth::user();
        $recipe = Recipe::find($request['id']);
        $recipe->title = $request['title'];
        $recipe->recipe = $request['recipe'];

        // 画像ファイル保存
        if(!empty($request->file('image'))){
            $dir = 'foods';
            $file_name = $request->file('image')->getClientOriginalName();
            $request->file('image')->storeAs('public/' . $dir, $file_name);
            $image = 'storage/' . $dir . '/' . $file_name;
        }else{
            $image = 'storage/NO_IMAGE.jpeg';
        }
        $recipe->image = $image;
        $recipe->save();

        // レシピ-食材テーブル保存
        foreach($request['foods'] as $food){ $foods[] = $food; }
        foreach($request['amounts'] as $amount){ $amounts[] = $amount; }
        // foodsテーブルにない食材が呼ばれた時にレコードを生成(firstOrCreate:https://readouble.com/laravel/8.x/ja/eloquent.html)
        for($i=0; $i<count($foods); $i++){
            if(empty($foods[$i])){ break; }
            $param = Food::firstOrCreate([
                'food' => $foods[$i]
            ]);
            $params[$param->id] = ['amount' => $amounts[$i]];
        }
        // sync関数なので上書きされる
        $recipe->foods()->sync($params);
        return redirect('recipe_show?id='.$request['id']);
    }

    public function delete(Request $request){
        Recipe::find($request['id'])->delete();
        return redirect('user');
    }
}
