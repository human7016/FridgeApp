@extends('layouts.layout')
<?php 
// dd($post_recipes);
?>
@section('content')
<div class="container-fluid">
  <div class="d-flex justify-content-center position-relative">
    <div class="h1 mt-4">{{$user->name}}さんのマイページ</div>
    <!-- ログアウト(https://www.kamome-susume.com/laratto-login/#index_id7) -->
    <form action=" {{ route('logout') }}" method="POST">
      @csrf
      <div class="align-self-cneter mt-4">
        <button class="align-self-cneter position-absolute end-0">ログアウト</button>
      </div>
    </form>
  </div>
</div>
<!-- お気に入りレシピ -->
<div class="container-fluid mt-1">
  <div class="d-flex justify-content-center position-relative">
    <div class="mt-4 h1">お気に入りレシピ</div>
    @if(!empty($favo_recipes[0]))
    <div class="align-self-cneter mt-4">
      <div class="d-flex flex-row-reverse">
        <a href="recipe_index?type=favorite" type="button"
          class="btn btn-outline-secondary position-absolute end-0">もっと見る</a>
      </div>
    </div>
    @else
</div>
    <div class="text-center mt-3 h3">お気に入りレシピはありません</div>
    <div>
    @endif
  </div>
</div>
@if(!empty($favo_recipes[0]))
<div class="container-fluid px-0">
  <div class="d-flex flex-row flex-wrap">
    @foreach($favo_recipes as $favorite)
    @if($loop->index==8) @break @endif
    <div class="col-3 position-relative pb-2 border">
      <div>
        @if(!empty($favorite->image))
        <img class="img-height-4" src="{{$favorite->image}}" alt="NO IMAGE">
      </div>
      @else
      <img class="img-height-4" src="/storage/NO IMAGE.jpeg" alt="NO IMAGE">
    </div>
    @endif
    <a href="recipe_show?id={{$favorite->id}}" class='stretched-link text12 fw-bold'>
      <div class="text-center">{{$favorite->title}}</div>
    </a>
  </div>
  @endforeach
</div>
@endif

<!-- 投稿レシピ -->
<div class="container-fluid mt-1">
  <div class="d-flex justify-content-center position-relative">
    <div class="mt-4 h1">投稿レシピ</div>
    @if(!empty($post_recipes[0]))
    <div class="align-self-cneter mt-4">
      <div class="d-flex flex-row-reverse">
        <a href="recipe_index?type=posted" type="button"
          class="btn btn-outline-secondary position-absolute end-0">もっと見る</a>
      </div>
    </div>
    @else
</div>
    <div class="text-center mt-3 h3">投稿レシピはありません</div>
</div>
    @endif
  </div>
</div>
<div class="container-fluid px-0">
  <div class="d-flex flex-row flex-wrap">
    @foreach($post_recipes as $recipe)
    @if($loop->index == 8) @break @endif
    <div class="col-3 position-relative pb-2 border" id="{{$recipe->id}}">
      <div>
        @if(!empty($recipe->image))
        <img class="img-height-4" src="{{$recipe->image}}" alt="NO IMAGE">
      </div>
      @else
      <img class="img-height-4" src="/storage/NO IMAGE.jpeg" alt="NO IMAGE">
    </div>
    @endif
    <a href="recipe_show?id={{$recipe->id}}" class='stretched-link text12 fw-bold'>
      <div class="text-center">{{$recipe->title}}</div>
    </a>
  </div>
  @endforeach
</div>
<div class="container-fluid">
  <div class="d-flex flex-row-reverse">
    <a type="button" class="btn btn-primary btn-lg mx-auto mt-5" href="recipe_create">レシピを投稿する</a>
  </div>
</div>


@endsection