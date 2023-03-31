<div>
  <!-- チェックボックス -->
  <div class="form-check">
    <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
    <label class="form-check-label" for="flexCheckDefault">
      {{$memo->food}}
    </label>
  </div>
</div>
<div>
  <!-- マイナスマーク -->
  <i class="fa-solid fa-square-caret-left"></i>
  {{$memo->purchase}}個
  <!-- プラスマーク -->
  <i class="fa-solid fa-square-caret-right"></i>
</div>