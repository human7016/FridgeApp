<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Recipe;
use App\Models\Favorite;

class UsersController extends Controller
{
    public function userpage()
    {
        // 認証済みユーザ取得(https://qiita.com/ucan-lab/items/a7441bff64ff1f173c10)
        $user = Auth::user();
        if(empty($user)){
            return redirect('/');
        }
        $post_recipes = Recipe::where('user_id', $user->id)
            ->orderBy('updated_at','desc')
            ->get();
        $favorites = Favorite::where('user_id', $user->id)
            ->orderBy('created_at','desc')
            ->get();
        foreach($favorites as $favorite){
            $favo_recipes[] = Recipe::where('id', $favorite->recipe_id)->first();
        }
        return view('users/user', compact('user', 'post_recipes', 'favo_recipes'));
    }

    public function put_favorite(Request $request){
        $user = Auth::user();
        $sql = array(
            'user_id' => $user->id,
            'recipe_id' => $request['recipe_id'],
        );
        $favorite = Favorite::create($sql);
        return $favorite;
    }

    public function delete_favorite(Request $request){
        $user = Auth::user();
        $favorite = Favorite::where('user_id', $user->id)
            ->where('recipe_id', $request['recipe_id'])
            ->first();
        $favorite->delete();
        return 'delete';
    }
}