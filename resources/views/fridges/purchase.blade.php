@extends('layouts.layout')

@section('content')
{{--賞味期限入力ページ--}}
<div class="text-center h1 mt-3">賞味期限を入力</div>

<form action="memo_fridge" method="post">
@csrf

@foreach($purchases as $purchase)
<!-- 賞味期限入力フォーム --> 
<div class="container">
  <div class="row">
    <div class="col-5 h3">{{$purchase->food}}</div>
    <div class="col-5 me-1">
      <!-- datepicker(https://www.sejuku.net/blog/44165) -->
      <input type="text" class="datepicker" name="expiry[]" autocomplete="OFF">
      <input type="hidden" name="id[]" value="{{$purchase->id}}">
      <input type="hidden" name="food_id[]" value="{{$purchase->food_id}}">
      <input type="hidden" name="purchase[]" value="{{$purchase->purchase}}">
    </div>
  </div>
</div>
@endforeach

<div class="d-flex justify-content-center">
  <button type="submit" class="btn btn-outline-secondary text-center mt-3">食材一覧に追加</button>
</div>
</form>

<!-- datepickerのjQuery -->
<script>
  $('.datepicker').datepicker();
  $(".datepicker").datepicker("option", "dateFormat", 'yy-mm-dd' );
</script>
@endsection