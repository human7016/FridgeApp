@extends('layouts.layout')

@section('content')
<!-- 料理名 -->
<div class="container-fluid text-center h1 position-relative mt-4">
  {{$recipe->title}}
</div>
<!-- 画像 -->
<div class="container-fluid px-0">
  <image class="img-fluid img-height-1" src={{$recipe->image}}>
</div>



  @auth
  <button type="button" id="pre-favorite" class="btn btn-outline-primary position-absolute end-0 px-0"><i class="fa-regular fa-star"></i>お気に入り登録</button>
  <button type="button" id="delete-favorite" class="btn btn-primary position-absolute end-0 px-0"><i class="fa-solid fa-star"></i>お気に入り解除</button>
  @endauth


<!-- 食材 -->
<div class="container-fluid text-center h1 mt-4">材料</div>
<div class="container-fluid mb-4">
  @foreach($foods as $food)
  <div class="row">
    <div class="col-6">
      {{$food->food}} : {{$food->pivot->amount}}
    </div>
  </div>
  @endforeach
</div>

<!-- レシピ -->
<div class="container-fluid text-center h1">レシピ</div>
<div class="container mb-4">{!!nl2br(htmlspecialchars($recipe->recipe))!!}</div>

<!-- 編集、削除ボタン -->
@if($user->id == $recipe->user_id)
<div class="container-fluid">
  <div class="d-flex flex-row justify-content-evenly">
    <form class="col-6 d-flex justify-content-center" action="recipe_edit?id={{$recipe->id}}" method="post">
      @csrf
      <input type="hidden" name="id" value={{$recipe->id}}> 
      <button type="submit" class="btn btn-primary col-8">編集</button>
    </form>
    <form class="col-6 d-flex justify-content-center" action="recipe_delete" method="post">
      @csrf
      <input type="hidden" name="id" value={{$recipe->id}}>
      <button type="submit" class="btn btn-outline-secondary col-8">削除</button>
    </form>
  </div>
</div>
@endif

<script>
$(function(){
  // jquery上でlaravel変数を使う方法(https://qiita.com/ntm718/items/638a8f56d30d047ead0f)
  let favorite = @json($favorite);
  if(favorite == null){
    $('#delete-favorite').addClass("d-none");
  }else{
    $('#put-favorite').addClass('d-none');
  }

  $.ajaxSetup({
      headers: {
        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
      },
    });
  // Ajax非同期モデル操作(https://qiita.com/si-ma/items/6931ecc0b8562e96733e)
  $("#pre-favorite").on('click', function () {
    $.ajax({
      type: "post",
      url: "put_favorite",
      dataType: "html",
      data: {
        recipe_id: {{$recipe->id}},
      },
    })
    //通信が成功したとき
    .then((res) => {
      $("#pre-favorite").addClass("d-none");
      $("#delete-favorite").removeClass("d-none");
    })
    //通信が失敗したとき
    .fail((error) => {
      console.log(error.statusText);
    });
  });
});

$(function(){
  $("#delete-favorite").on('click', function () {
    $.ajax({
      type: "post",
      url: "delete_favorite",
      dataType: "html",
      data: {
        recipe_id: {{$recipe->id}},
      },
    })
    //通信が成功したとき
    .then((res) => {
      if((res) == "delete"){
        $("#delete-favorite").addClass("d-none");
        $("#pre-favorite").removeClass("d-none");
      }
    })
    //通信が失敗したとき
    .fail((error) => {
      console.log(error.statusText);
    });
  });
});
</script>
@endsection