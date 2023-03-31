<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Auth;
use App\Models\Food;
use App\Models\Memo;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
        view()->composer('*', function($view)
        {
            $user = Auth::user();
            if(!empty($user)){
                $memos = Memo::where('user_id', $user->id)
                ->join('foods', 'memos.food_id', '=', 'foods.id')
                ->select(
                    'memos.id',
                    'memos.food_id',
                    'memos.purchase',
                    'memos.on_check',
                    'foods.food',
                )
                ->get();
                $memo_count = $memos->count();
                // ビュー全体（*.blade.php）にデータ共有(https://minory.org/laravel-view-share.html)
            
            $view->with("memos", $memos)->with("memo_count", $memo_count);
            }                         
        });
    }
}
