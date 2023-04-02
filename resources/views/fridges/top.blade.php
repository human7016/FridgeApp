@extends('layouts.layout')

@section('content')
{{--トップページ--}}
@guest
<div class="container-fluid px-0 d-flex justify-content-center">
  <div class="col-11 mt-3">
    <div class="h1 text-center mt-3 bm-3" style="color:#0d6efd">
      食品ロスと戦うアプリ「FridgeApp」
    </div>
    <div class="text-wrap h4">
      <!-- ○気づいたら賞味期限がギリギリだった！<br>
      ○冷凍庫にいつ買ったか覚えてない食品が！<br>
      ○食材をどう料理すればいいかわからない！<br>
      </div>
      <div class="text-wrap h3">
      FridgeAppはあなたのお悩みをサポートします！
      </div> -->
      <div>
        <div class="h1 text-center border mt-5">
          賞味期限を伝える
        </div>
        <img class="img-fluid border" src="images/top.png">
        <div class="text-wrap">
          期限が近い食品が一目でわかります！<br>
          期限の近い食品を消費するレシピを提案します！<br>
        </div>
        <div class="container">
          <div class="d-flex justify-content-center">
            <a class="btn btn-success " href="register">アカウントを作成する</a>
          </div>
        </div>
      </div>
      <div class="container-fluid px-0">
        <div class="h1 text-center border mt-5">
          食材を管理する
        </div>
        <img class="img-fluid border" src="images/fridge.png">
        <div class="text-wrap">
          今ある食材を一覧で表示します！<br>
          賞味期限や個数までわかりやすく表示！<br>
        </div>
        <div class="container">
          <div class="d-flex justify-content-center">
            <a class="btn btn-success " href="register">アカウントを作成する</a>
          </div>
        </div>
      </div>
      <div>
        <div class="h1 text-center border mt-5">
          レシピを調べる
        </div>
        <img class="img-fluid border" src="images/index.png">
        <div class="text-wrap">
          余った食材からレシピを検索できます！<br>
          レシピ検索はコチラ↓<br>
        </div>
        <!-- 検索フォーム -->
        <form method="post" action="recipe_index">
          @csrf
          <div class="container input-group mt-3 mb-3">
            <input type="text" name="word" class="form-control" placeholder="レシピを検索してみる"
              aria-label="Recipient's username" aria-describedby="button-addon2" autocomplete="OFF">
            <button class="btn btn-outline-primary" type="submit" id="button-addon2">Search</button>
          </div>
        </form>
      </div>
      <div>
        <div class="h1 text-center border mt-5">
          買い物をサポートする
        </div>
        <img class="img-fluid border" src="images/memo.png">
        <div class="text-wrap">
          作りたいレシピを作るときはメモをご利用下さい<br>
          モチロン、食料品以外を登録も可能！<br>
        </div>
      </div>
      <div class="h1 text-center border mt-5">
        今すぐロスを減らそう！
      </div>
    </div>
  </div>
</div>
<!-- リンクボタン -->
<div class="container">
  <div class="d-flex justify-content-center">
    <a class="btn btn-success " href="register">アカウントを作成する</a>
  </div>
</div>
@endguest

@auth
<div class="text-center h1 mt-4 mb-2">賞味期限の近いもの</div>
<!-- 食材コンテナー -->
@foreach($fridges as $fridge)
<div class="food-container container" id="{{$fridge->id}}">
  <div class="row">
    <div class="col-4 border text-center h4 m-0 py-2" id="expiry{{$loop->index}}">{{$fridge->expiry}}</div>
    <div class="col-5 border text-center h4 m-0 py-2 food">{{$fridge->food}}</div>
    <div class="col-2 border text-center h4 m-0 py-2 stock">{{$fridge->stock}}</div>
    <div class="col-1 d-flex justify-content-center align-items-center border py-2">
      <i class="fa-solid fa-angles-down down"></i>
    </div>
  </div>
</div>
@endforeach
<div class="d-flex flex-row-reverse mt-3 pe-5">
  <a class="btn btn-primary btn-lg" href="fridge" type="bottun" id="button-addon2">食材一覧</a>
</div>

<!-- おすすめレシピ -->
<div class="text-center h1 mt-5 pb-2">おすすめレシピ</div>
@for($i=0; $i<2; $i++) 
@php $recommend=$recommends[$i] @endphp 
<div class="container-fluid">
  <div class="d-flex p-0 position-relative">
    <div class="col-7 border">
      <img class="img-fluid" src={{$recommend->image}}>
    </div>
    <div class="col-5 text-wrap border text-12">
      <div>
        <div class="text-center h3">{{$recommend->title}}</div>
        <a href="recipe_show?id={{$recommend->id}}" class="stretched-link"></a>
      </div>
      @foreach($recommend->foods as $food)
      <div>
        {{$food->food}}:{{$food->pivot->amount}}
      </div>
      @endforeach
    </div>
  </div>
</div>
<div class="d-flex flex-row-reverse pe-5 mt-3 mb-5">
  <a href="recipe_show?id={{$recommend->id}}" type="button" class="btn btn-outline-secondary">作ってみる</a>
</div>
@endfor

 <script>
  $(function() {
    $.ajaxSetup({
      headers: {
        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
      }
    });

    // n日後の日付確認(https://algorithm.joho.info/programming/javascript/date-get-days-later-js/)
    // 日付フォーマット(https://qiita.com/toshimin/items/5f13c3b4c28825219231)
    function getDate(n) {
      let date = new Date();
      date.setDate(date.getDate() + n);
      let Y = date.getFullYear();
      let m = ('00' + (date.getMonth() + 1)).slice(-2);
      let d = ('00' + date.getDate()).slice(-2);
      return Y + "-" + m + "-" + d;
    }

    let msg = "";
    for (i = 0; i < {{$count}}; i++) {
      // 賞味期限2日以内は背景黄色
      if ($("#expiry" + i).text() <= getDate(2)) {
        $("#expiry" + i).parent().addClass("background-yellow");
      }
      // 賞味期限当日のものは赤文字
      if ($("#expiry" + i).text() <= getDate(0)) {
        msg += $("#expiry" + i).parent().find(".food").text() + "\n";
        $("#expiry" + i).addClass("color-red");
        $("#expiry" + i).parent().find(".food").addClass("color-red");
        $("#expiry" + i).parent().find(".food").addClass("color-red");
        if ($("#expiry" + i).text() == getDate(0)) {
          $("#expiry" + i).text("本日まで")
        }
      }
    }
    // アラート
    if ((msg) != "") {
      alert(msg + "賞味期限です。");
    }
    // Ajax
    $(".down").on("click", function() {
      let food_container = $(this).parent().parent().parent()
      let id = food_container.attr("id");
      if (food_container.find(`.stock`).text() == 1) {
        if (!confirm('削除してもよろしいですか')) {
          return false;
        } else {
          $(function() {
            $.ajax({
                type: "post",
                url: "delete_ajax",
                dataType: "json",
                data: {
                  id: id
                }
              })
              .done((res) => {
                $('#' + id).addClass('d-none');
              })
              .fail((error) => {
                console.log(error.statusText);
              });
          });
        }
      }
      $.ajax({
          type: "post",
          url: "minus",
          dataType: "json",
          timeout: 1000,
          data: {
            id: id
          }
        })
        .done((res) => {
          console.log(res);
          food_container.find(`.stock`).text((res));
        })
        .fail((error) => {
          console.log(error.statusText);
        });
    });

    // 長押しを検知する閾値
    var LONGPRESS = 1000;
    // 長押し実行タイマーのID 
    var timerId;

    $('.food-container').on("mousedown touchstart", function() {
      let id = $(this).attr('id');
      /// 長押し・ロングタップを検知する
      timerId = setTimeout(function() {
        /// 長押し時（Longpress）のコード
        console.log('longtap');
        if (!confirm('削除してもよろしいですか')) {
          return false;
        } else {
          $(function() {
            $.ajax({
                type: "post",
                url: "delete_ajax",
                dataType: "json",
                data: {
                  id: id
                }
              })
              .done((res) => {
                $('#' + id).addClass('d-none');
              })
              .fail((error) => {
                console.log(error.statusText);
              });
          });
        }
      }, LONGPRESS);
    }).on("mouseup mouseleave touchend", function() {
      clearTimeout(timerId);
    });

  });
</script>
@endauth

@endsection