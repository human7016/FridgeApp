@extends('layouts.layout')

@section('content')
<div class="container-fluid px-0">
  <img src="{{asset($image)}}" class="img-height-1" alt="NO IMAGE">
</div>
<div class="container-fluid">
  <div class="text-center">{{ $title }}</div>
  <ul class="list-group">
    @foreach($food_arr as $food)
    <li class="list-group-item">
      {{ $food }} : {{ $amount_arr[$loop->index] }}
    </li>
    @endforeach
  </ul>
  <div class="continer-fluid border">
    {!! nl2br(htmlspecialchars($recipe)) !!}
  </div>
  <form method='post' action='recipe_insert'>
    @csrf
    <input type="hidden" name="title" value="{{$title}}">
    <input type="hidden" name="image" value="{{$image}}">
    <input type="hidden" name="recipe" value="{{$recipe}}">
    <!-- ループ変数(https://eclair.blog/laravel-blade-loop/) -->
    @foreach($food_arr as $food)
    <input type="hidden" name="foods[]" value="{{$food}}">
    <input type="hidden" name="amounts[]" value="{{$amount_arr[$loop->index]}}">
    @endforeach 
    <div class="d-flex justify-content-evenly">
      <button type="submit" class="btn btn-success col-4">登録</button>
      <button formaction="recipe_create" class="btn btn-outline-secondary col-4">戻る</button>
    </div>
  </form>
</div>
@endsection