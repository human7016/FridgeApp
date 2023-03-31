@extends('layouts.layout')

@section('content')
<!-- フォーム -->
<!-- 画像アップロード(https://migisanblog.com/laravel-image-upload-view/) -->
<form method="post" action="recipe_confirm" enctype="multipart/form-data">
  <div class="text-center h4 mt-4">レシピ投稿</div>
  @csrf
  <div class="container-fluid">
    <div class="row">
      <div class="col-12">
        <label for="formTitle" class="form-label mb-0">料理名</label>
        @if($errors->has('title'))<span class="error" style="color:red;">{{ $errors->first('title') }}</span> @endif
        <input class="form-control form-control-sm" type="text" name="title" value="{{old('title')}}">
      </div>
    </div>

    <div class="row mt-3">
      <div class="col-12">
        <label for="formFileMultiple" class="form-label mb-0">料理画像</label>
        @if($errors->has('image'))<span class="error" style="color:red;">{{ $errors->first('image') }}</span> @endif
        <input class="form-control" type="file" name="image" id="formFileMultiple" multiple>
      </div>
    </div>

    <div class="row mt-3">
      <div class="col-7">材料  @if($errors->has('foods[0]'))<span class="error" style="color:red;">{{ $errors->first('foods[0]') }}</span> @endif</div>
      <div class="col-3">分量  @if($errors->has('amounts[0]'))<span class="error" style="color:red;">{{ $errors->first('amounts[0]') }}</span> @endif</div>
      <div class="col-2 d-flex flex-row-reverse">調味料</div>
    </div>
    @for($i=1;$i<=25;$i++) 
    @if($i<=3) 
    <div class="row">
      <div class="col-7">
        <input class="form-control form-control-sm" type="text" name="foods[]" value="{{old('foods[$i-1]')}}">
      </div>
      <div class="col-4">
        <input class="form-control form-control-sm" type="text" name="amounts[]" value="{{old('amounts[$i-1]')}}">
      </div>
      <div class="col-1 d-flex">
        <input class="align-self-center" type="checkbox" name="seasoning[]" value={{$i-1}}>
      </div>
    </div>
    @else
    <div class="d-none" id=form-input{{$i}}>
      <div class="row">
        <div class="col-7">
          <input class="form-control form-control-sm" type="text" name="foods[]" value="{{old('foods[$i-1]')}}">
        </div>
        <div class="col-4">
          <input class="form-control form-control-sm" type="text" name="amounts[]" value="{{old('amounts[$i-1]')}}">
        </div>
        <div class="col-1 d-flex">
          <input class="align-self-center" type="checkbox" name="seasoning[]" value={{$i-1}}>
        </div>
      </div>
    </div>
    @endif
    @endfor
    <select class="form-select form-select-sm mt-1" id="foods-amounts">
      <option selected>食材の品数を増やす</option>
      @for($i=4; $i<=25; $i++)
        <option value={{$i}}>{{$i}}</option>
      @endfor
    </select>

  <div class="mt-3">
    <label for="exampleFormControlTextarea1" class="form-label">レシピ</label>
    @if($errors->has('recipe'))<span class="error" style="color:red;">{{ $errors->first('recipe') }}</span> @endif
    <textarea class="form-control" name="recipe" id="exampleFormControlTextarea1" rows="10" value="{{old('recipe')}}">
(1)

(2)

(3)

(4)

    </textarea>
  </div>
  </div>

  <div class="d-flex justify-content-center">
    <input type="submit" class="btn btn-primary" value="投稿する">
  </div>
</form>

<script>
$(function() {
  $("#foods-amounts").change(function() {
    // 食材の品数フォームの入力値読み込み
    let foodsAmounts = $("#foods-amounts").val();
    console.log(foodsAmounts);
    // 1度フォームを3個にリセット 
    for(i=4; i<=25; i++){
      str = "#form-input" + i;
      $(str).addClass("d-none");
    }
    // 指定されたフォーム数になるまで増加
    for(i=4; i<=foodsAmounts; i++){
      str = "#form-input" + i;
      $(str).removeClass("d-none");
    }
  })
})
</script>
@endsection