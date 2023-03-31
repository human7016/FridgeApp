<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Memo;
use App\Models\Food;
use App\Models\Fridge;

class MemosController extends Controller
{
    public function insert(Request $request){
        $user = Auth::user();
        $item = Food::firstOrCreate([
            'food' => $request['item']
        ]);
        $sql = array(
            'user_id' => $user->id,
            'food_id' => $item->id,
        );
        $memo = Memo::create($sql);
        $memo = Memo::where('user_id', $user->id)
            ->join('foods', 'memos.food_id', '=', 'foods.id')
            ->select(
                'memos.id',
                'memos.purchase',
                'memos.on_check',
                'foods.food',
            )
            ->latest('id')
            ->first();
        return $memo;
    }

    public function delete(Request $request){
        $memo = Memo::find($request['id']);
        $memo->delete();
        return $request['id'];
    }

    public function subtraction(Request $request){
        $memo = Memo::find($request['id']);
        $memo->purchase--;
        $memo->save();
        return $memo->purchase;
    }

    public function addition(Request $request){
        $memo = Memo::find($request['id']);
        $memo->purchase++;
        $memo->save();
        return $memo->purchase;
    }

    public function checked(Request $request){
        $memo = Memo::find($request['id']);
        $memo->on_check ? $memo->on_check = false : $memo->on_check = true;
        $memo->save();
        return $memo->on_check;
    }

    public function purchase(Request $request){
        $user = Auth::user();
        $purchases = Memo::where('on_check', true)
            ->join('foods', 'memos.food_id', '=', 'foods.id')
            ->select(
                'memos.id',
                'memos.food_id',
                'memos.purchase',
                'foods.food',
            )
            ->get();
        return view('fridges.purchase', compact('purchases'));
    }

    public function fridge(Request $request){
        $user = Auth::user();
        $count = count($request['expiry']);
        for($i=0; $i<$count; $i++){
            $sql = array(
                'expiry' => $request['expiry'][$i],
                'food_id' => $request['food_id'][$i],
                'stock' => $request['purchase'][$i],
                'user_id' => $user->id
            );
            Fridge::create($sql);
            Memo::find($request['id'][$i])->delete();
        }

        return redirect('fridge');
    }

    public function to_fridge(Request $request){
        $user = Auth::user();
        $memos = Memo::where('on_check', true)->get();
        foreach($memos as $memo){
            $sql =  array(
                'food_id' => $memo->food_id,
                'stock' => $memo->purchase,
                'user_id' => $user->id
            );
            Fridge::create($sql);
            $memo->delete();
        }
        return redirect('fridge');
    }
}
