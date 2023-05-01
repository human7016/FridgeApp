<?php
// ユーザに関するコントローラ
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
        if(empty($favorite)){
            $favo_recipes[] = null;
        }
        return view('users/user', compact('user', 'post_recipes', 'favo_recipes'));
    }

    public function get_favorite(Request $request){
        $favorites = Favorite::where('user_id', $request['user_id'])
        ->where('recipe_id', $request['recipe_id'])->exists();
        //ヘッダーを指定するすることによりjsonの動作を安定させる
        header('Content-type: application/json');
        return json_encode($favorites);
    }

    public function put_favorite(Request $request){
        $sql = array(
            'user_id' => $request['user_id'],
            'recipe_id' => $request['recipe_id'],
        );
        $favorite = Favorite::create($sql);

        //ヘッダーを指定するすることによりjsonの動作を安定させる
        header('Content-type: application/json');
        echo json_encode($favorite);
    }

    public function delete_favorite(Request $request){
        $favorite = Favorite::where('user_id', $request['user_id'])
            ->where('recipe_id', $request['recipe_id'])
            ->first();
        $favorite->delete();

        //ヘッダーを指定するすることによりjsonの動作を安定させる
        header('Content-type: application/json');
        echo json_encode($favorite);
    }
}