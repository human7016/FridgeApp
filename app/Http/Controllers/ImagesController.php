<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Image;

class ImagesController extends Controller
{
    public function index(Request $request){
        $images = Image::get();
        return view('test', compact('images'));
    }
    public function upload(Request $request)
    {
        // 画像アップロード:https://reffect.co.jp/laravel/how_to_upload_file_in_laravel
        // https://migisanblog.com/laravel-image-upload-view/#:~:text=%E7%94%BB%E5%83%8F%E3%83%95%E3%82%A1%E3%82%A4%E3%83%AB%E3%82%92%E4%BF%9D%E5%AD%98%E3%81%99%E3%82%8B,%E3%83%A1%E3%82%BD%E3%83%83%E3%83%89%E3%82%92%E4%BD%BF%E7%94%A8%E3%81%97%E3%81%BE%E3%81%99%E3%80%82&text=store%E3%83%A1%E3%82%BD%E3%83%83%E3%83%89%E3%81%AE%E5%BC%95%E6%95%B0%E3%81%A7%E3%81%AF,%E5%90%8D%E3%81%A7%E4%BF%9D%E5%AD%98%E3%81%95%E3%82%8C%E3%81%BE%E3%81%99%E3%80%82
        // /strageディレクトリ配下に保存される


        // dd($request->file('image'));
        // $request->file('image')->store('images/test');

        // ディレクトリ名
        $dir = 'foods';

        // アップロードされたファイル名を取得
        $file_name = $request->file('image')->getClientOriginalName();

        // 取得したファイル名で保存
        $request->file('image')->storeAs('public/' . $dir, $file_name);

        // ファイル情報をDBに保存
        $image = new Image();
        $image->name = $file_name;
        $image->path = 'storage/' . $dir . '/' . $file_name;
        $image->save();

        return redirect('img');
    }
}
