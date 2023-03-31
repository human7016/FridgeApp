@extends('layouts.layout')
<?php // dd($fridges); ?>
@section('content')
@if($errors->has('food'))<div class="error" style="color:red;">{{ $errors->first('food') }}</div> @endif
@if($errors->has('stock'))<div class="error" style="color:red;">{{ $errors->first('stock') }}</div> @endif
@if($errors->has('expiry'))<div class="error" style="color:red;">{{ $errors->first('expiry') }}</div> @endif
<div class="container-fluid">
  <div class="d-flex justify-content-center position-relative">
    <div class="h1 mt-4 ">食材一覧</div>
    <div class="align-self-cneter mt-4">
      <button type="button" class="btn btn-outline-primary align-self-cneter position-absolute end-0" id="add-food">食材を追加</button>
    </div>
  </div>

  <!-- 食材追加フォーム表示 -->
  <div id="screen2" class="fixed-top d-none d-flex justify-content-center">
    <div class="position-absolute d-none" id="insert-form" > 
      <div class="d-flex flex-row-reverse">
        <i id="cancel-add" class="fa-solid fa-circle-xmark fa-2x mt-2 me-2"></i>
      </div>
      <div class="d-flex align-items-center justify-content-center">
        <form action="fridge_insert" method="post">
          @csrf
          <div class="container-fluid">
            <div class="h2 text-center">食材を追加</div>
          </div>
          <div><input class="text-center mt-3" type="text" name="food" placeholder="食材" value="{{ old('food') }}" autocomplete="OFF"></div>
          <div><input class="text-center mt-3" type="text" name="stock" placeholder="個数" value="{{ old('stock') }}" autocomplete="OFF"></div>
          <div><input class="text-center mt-3" type="text" name="expiry" placeholder="賞味期限" value="{{ old('expiry') }}" id="datepicker" autocomplete="OFF"></div>
          <div class="d-flex justify-content-center">
            <button class="mt-4 mb-4" type="submit">追加</button>
          </div>  
        </form>
      </div>
    </div>
  </div>

</div>
<!-- 自動折り返しクラス(flex-wrap) -->
<div class="d-flex flex-wrap mt-2">
  @foreach($fridges as $fridge)
  <div class="col-3 ps-0 pe-0 border food-container" id={{$fridge->id}}>
    <div class="food text-center small-font-size ms-0 me-0 mt-2" id="food{{$loop->index}}">{{$fridge->food}}</div>
    <div class="d-flex flex-row justify-content-around mt-2">
      <!-- マイナスボタン -->
      <i class="fa-solid fa-circle-minus minus-btn"></i>
        <div class="stock">{{$fridge->stock}}個</div>
      <!-- プラスボタン -->
      <i class="fa-solid fa-circle-plus plus-btn"></i>
    </div>
    @if(!empty($fridge->expiry))
    <div class="d-flex justify-content-center calendar mt-2 mb-2">
      <div class="col-3 d-flex justify-content-center">
        <i class="fa-solid fa-calendar-days align-self-center"></i>
      </div>
      <div class="text-center expiry" id="expiry{{$loop->index}}">{{$fridge->expiry}}</div>
      <input type="text" class="d-none datepicker input-sm m-auto text-center col-9" name="expiry[]" autocomplete="OFF" value={{$fridge->expiry}}>
    </div>
    @else
    <div class="d-flex justify-content-center calendar mt-2 mb-2">
      <div class="col-3 d-flex justify-content-center">
        <i class="fa-solid fa-calendar-days align-self-center"></i>
      </div>
      <div class="text-center expiry"></div>
      <input type="text" class="d-none datepicker input-sm m-auto text-center col-9" name="expiry" autocomplete="OFF">
    </div>
    @endif
  </div>
  @endforeach
</div>
<div class="d-flex justify-content-center">
  <a href="recipe_from_fridge?type=fridge" type="button" class="btn btn-primary btn-lg mt-5">余り物からレシピ検索</a>
</div>


<script>
$(function(){
  $.ajaxSetup({
    headers: {
      "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
    },
  });

  // datepicker
  $("#datepicker").datepicker();
  $("#datepicker").datepicker("option", "dateFormat", 'yy-mm-dd' );
  $(".datepicker").datepicker();
  $(".datepicker").datepicker("option", "dateFormat", 'yy-mm-dd' );

  $(".calendar").on("click", function(){
    $(this).find(".d-none").removeClass("d-none");
    $(this).find(".expiry").text("");
    $(this).find(".datepicker").focus();
  });
// 賞味期限を編集
  $(".datepicker").change(function(){
    console.log('change');
    let food_container = $(this).parent().parent();
    let id = food_container.attr('id');
    let expiry = $(this).val();
    $.ajax({
      type: "post",
      url: "update_expiry",
      dataType: "json",
      data: {
        id: id,
        expiry: expiry
      }
    })
    .done((res)=>{
      // 賞味期限上書き
      food_container.find(".expiry").text(expiry);
      // 賞味期限2日以内は背景黄色
      if (food_container.find(".expiry").text() <= getDate(2)) {
        food_container.addClass("background-yellow");
      } else {
        food_container.removeClass("background-yellow")
      }
      // 賞味期限当日より前のものは赤文字に
      if (food_container.find(".expiry").text() <= getDate(0)) {
        food_container.find(".food").addClass("color-red");
        food_container.find(".expiry").addClass("color-red");
      } else {
        food_container.find(".food").removeClass("color-red");
        food_container.find(".expiry").removeClass("color-red");
      }
      // 賞味期限当日のものはテキストを本日に
      if (food_container.find(".expiry").text() == getDate(0)) {
        food_container.find(".expiry").text("本日まで");
      }
      $(this).addClass("d-none");
      window.location.reload();
    })
    .fail((error)=>{
      console.log(error);
    });
  })

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
      $("#expiry" + i).parent().parent().addClass("background-yellow");
    }
    // 賞味期限当日より前のものは赤文字に
    if ($("#expiry" + i).text() <= getDate(0)) {
      $("#food" + i).addClass("color-red");
      $("#expiry" + i).addClass("color-red");
    }
    // 賞味期限当日のものはテキストを本日に
    if ($("#expiry" + i).text() == getDate(0)) {
      $("#expiry" + i).text("本日まで");
    }
  }

  // 食材追加フォーム
  $("#add-food").on("click", function(){
    $("#insert-form, #screen2").removeClass("d-none");
  })
  $("#cancel-add").on("click", function(){
    $("#insert-form, #screen2").addClass("d-none");
  })

  // Ajaxマイナス
  $(".minus-btn").on("click", function(){
    let food_container = $(this).parent().parent();
    let id = food_container.attr('id');
    if(food_container.find(`.stock`).text() == "1個"){
      console.log("flg");
      if(!confirm('削除してもよろしいですか')){
        return false;
      }else{
        $(function(){
          $.ajax({
            type: "post",
            url: "delete_ajax",
            dataType: "json",
            data: {
              id: id
            }
          })
          .done((res)=>{
            $('#'+id).addClass('d-none');
          })
          .fail((error)=>{
            console.log(error.statusText);
          });
        });
      }
    }
    if($(this).parent().find(".stock").text() == '0個'){
      return false;
    }
    $.ajax({
      type: "post",
      url: "minus",
      dataType: "json",
      data: { 
        id: id 
      }
    })
    .done((res)=>{
      let str = (res) + '個';
      // テキスト上書き:text()
      $(this).parent().find(".stock").text(str);
    })
    .fail((error)=>{
      console.log(error.statusText);
    });
  });
  // プラスボタン
  $(".plus-btn").on("click", function(){
    let id = $(this).parent().parent().attr('id');
    $.ajax({
      type: "post",
      url: "plus",
      dataType: "json",
      data: { 
        id: id 
      }
    })
    .done((res)=>{
      let str = (res) + '個';
      $(this).parent().find(".stock").text(str);
    })
    .fail((error)=>{
      console.log(error.statusText);
    });
  });

  

// ロングタップ判定(https://pisuke-code.com/jquery-way-to-detect-longpress/)
// 長押しを検知する閾値
var LONGPRESS = 1000;
// 長押し実行タイマーのID
var timerId;
 
$('.food-container').on("mousedown touchstart",function(){
  let id = $(this).attr('id');
  /// 長押し・ロングタップを検知する
  timerId = setTimeout(function(){
    /// 長押し時（Longpress）のコード
    console.log('longtap');
    if(!confirm('削除してもよろしいですか')){
        return false;
    }else{
      $(function(){
          $.ajax({
            type: "post",
            url: "delete_ajax",
            dataType: "json",
            data: {
              id: id
            }
          })
          .done((res)=>{
            $('#'+id).addClass('d-none');
          })
          .fail((error)=>{
            console.log(error.statusText);
          });
        });
    }
  }, LONGPRESS);
}).on("mouseup mouseleave touchend",function(){
  clearTimeout(timerId);
});
});




</script>
@endsection