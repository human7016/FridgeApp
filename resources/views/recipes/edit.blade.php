@extends('layouts.layout')

@section('content')
<!-- 画像アップロード(https://migisanblog.com/laravel-image-upload-view/) -->
<form method="post" action="recipe_update" enctype="multipart/form-data">
  <input type="hidden" name="id" value={{$recipe->id}}>
  <div class="text-center h4 mt-4">レシピ編集</div>
  @csrf
  <div class="container-fluid">
    <div class="row">
      <div class="col-12">
        <label for="formTitle" class="form-label mb-0">料理名</label>
        @if($errors->has('title'))<span class="error" style="color:red;">{{ $errors->first('title') }}</span> @endif
        <input class="form-control form-control-sm" type="text" name="title" value={{$recipe->title}}>
      </div>
    </div>

    <div class="row mt-3">
      <div class="col-12">
        <label for="formFileMultiple" class="form-label mb-0">料理画像</label>
        @if($errors->has('image'))<span class="error" style="color:red;">{{ $errors->first('image') }}</span> @endif
        <input class="form-control" type="file" name="image" id="imageFile" value="{{$image}}" multiple>
      </div>
    </div>

    <div class="row mt-3">
      <div class="col-8">材料  @if($errors->has('foods[0]'))<span class="error" style="color:red;">{{ $errors->first('foods[0]') }}</span> @endif</div>
      <div class="col-4">分量  @if($errors->has('amounts[0]'))<span class="error" style="color:red;">{{ $errors->first('amounts[0]') }}</span> @endif</div>
    </div>
    @foreach($foods as $food)
    <div class="row">
      <div class="col-8">
        <input class="form-control form-control-sm" type="text" name="foods[]" value={{$food->food}}>
      </div>
      <div class="col-4">
        <input class="form-control form-control-sm" type="text" name="amounts[]" value={{$food->pivot->amount}}>
      </div>
    </div>
    @endforeach
    @for($i=count($foods); $i<25; $i++)
    <div class="d-none" id=form-input{{$i}}>
      <div class="row">
        <div class="col-8">
          <input class="form-control form-control-sm" type="text" name="foods[]">
        </div>
        <div class="col-4">
          <input class="form-control form-control-sm" type="text" name="amounts[]">
        </div>
      </div>
      </div>
    @endfor

  <select class="form-select form-select-sm mt-1" id="foods-amounts">
    <option selected>食材の品数を変える</option>
    @for($i=count($foods); $i<25; $i++) <option value={{$i+1}}>{{$i+1}}</option>
      @endfor
  </select>

  <div class="mt-3">
    <label for="exampleFormControlTextarea1" class="form-label">レシピ</label>
    @if($errors->has('recipe'))<span class="error" style="color:red;">{{ $errors->first('recipe') }}</span> @endif
    <textarea class="form-control" name="recipe" id="exampleFormControlTextarea1"
      rows="10">{{$recipe->recipe}}</textarea>
  </div>
  </div>

  <div class="d-flex justify-content-center">
    <input type="submit" class="btn btn-success" value="編集する">
  </div>
</form>

<script>
$(function() {
  $("#foods-amounts").change(function() {
    // 食材の品数フォームの入力値読み込み
    let foodsAmounts = $("#foods-amounts").val();
    // 1度フォームを3個にリセット 
    for (i = {{count($foods)}}; i < 25; i++) {
      str = "#form-input" + i;
      $(str).addClass("d-none");
    }
    // 指定されたフォーム数になるまで増加
    for (i = {{count($foods)}}; i < foodsAmounts; i++) {
      str = "#form-input" + i;
      $(str).removeClass("d-none");
    }
  })
})
</script>
@endsection