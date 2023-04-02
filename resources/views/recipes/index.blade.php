@extends('layouts.layout')

@section('content')

@if(!isset($recipes))
<div class="text-center mt-4 h2">{{$word}}</div>

@else
<div class="text-center mt-4 h2">{{$word}}</div>
<!-- レシピコンテナ -->
@foreach($recipes as $recipe)
<div class="container-fluid">
  <div class="d-flex p-0 position-relative">
    <div class="col-6 border">
      <img class="img-fluid" src={{$recipe->image}}>
    </div>
    <div class="col-6 text-wrap border text-12">
      <div>
        <div class="text-center h3">{{$recipe->title}}</div>
        <a href="recipe_show?id={{$recipe->id}}" class="stretched-link"></a>
      </div>
      @foreach($recipe->foods as $food)
      <div>
        {{$food->food}}:{{$food->pivot->amount}}
      </div>
      @endforeach
    </div>
  </div>
</div>
@endforeach
@endif

@endsection