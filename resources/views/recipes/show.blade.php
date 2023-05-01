@extends('layouts.layout')

@section('content')
<!-- 料理名 -->
<div class="container-fluid text-center h1 mt-4">
  {{$recipe->title}}
</div>
<!-- 画像 -->
<div class="container-fluid px-0">
  <image class="img-fluid img-height-1" src={{$recipe->image}}>
</div>

{{--お気に入りボタン--}}
@auth
<form>
<input type="hidden" id="favorite_off_user" value={{$user->id}}>
<input type="hidden" id="favorite_off_recipe" value={{$recipe->id}}>
<button type="button" id="pre-favorite" class="d-none btn btn-outline-primary position-absolute end-0 px-0"><i class="fa-regular fa-star"></i>お気に入り登録</button>
</form>
<form>
<input type="hidden" id="favorite_in_user" value={{$user->id}}>  
<input type="hidden" id="favorite_in_recipe" value={{$recipe->id}}>
<button type="button" id="delete-favorite" class="d-none btn btn-primary position-absolute end-0 px-0"><i class="fa-solid fa-star"></i>お気に入り解除</button>
</form>
@endauth

<!-- 材料 -->
<div class="container-fluid text-center h1 mt-4">材料</div>
<div class="container-fluid mb-4 h3">
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
<div class="container mb-4 h3">{!!nl2br(htmlspecialchars($recipe->recipe))!!}</div>

<!-- 編集、削除ボタン -->
@auth
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
@endauth

<script src="js/ajax_favoriteIO.js">

</script>
@endsection