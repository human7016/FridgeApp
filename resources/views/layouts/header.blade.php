<!-- navbar(https://getbootstrap.jp/docs/5.0/components/navbar/) -->
@guest
<nav class="navbar navbar-expand navbar-light" style="background-color: #d1eefc;">
  <!-- logo -->
  <div class="container-fluid mt-3">
    <div class="container-fluid w-75">
      <div class="container">
        <a class="navbar-brand" href="top">
          <img src="images/FridgeApp.png" width="120" height="" class="img-fluid" alt="">
        </a>
      </div>
    </div>
    <!-- nav-item -->
    <div class="flex-column w-100" id="navbarSupportedContent">
      <ul class="navbar-nav">
        <li class="nav-item">
          <!-- ログインにはlaravelBreezeを利用：https://php-junkie.net/framework/laravel/breeze/ -->
          <a class="nav-link active h4" aria-current="page" href="login">ログイン</a>
        </li>
        <li class="nav-item">
          <a class="nav-link active h4" aria-current="page" href="register">アカウント作成</a>
        </li>
      </ul>
    </div>
  </div>
</nav>
<!-- form -->
<form method="post" action="recipe_index">
  @csrf
  <div class="container-fluid pb-3 px-0" style="background-color: #d1eefc;">
    <div class="container input-group">
      <input type="text" name="word" class="form-control" placeholder="レシピを検索" aria-label="Recipient's username"
        aria-describedby="button-addon2">
      <button class="btn btn-outline-primary" type="bottun" id="button-addon2"
        style="background-color: white;">Search</button>
    </div>
  </div>
</form>
@endguest

<!-- navbar(https://getbootstrap.jp/docs/5.0/components/navbar/) -->
@auth
<!-- 通常状態 -->

<nav class="navbar navbar-expand navbar-light" style="background-color: #d1eefc;">
  <!-- logo -->
  <div class="container-fluid mt-3">
    <div class="container-fluid">
      <div class="container">
        <a class="navbar-brand" href="top">
          <img src="images/FridgeApp.png" width="140" height="" class="img-fluid" alt="">
        </a>
      </div>
    </div>
    <!-- nav-item -->
    <div class="flex-column" id="navbarSupportedContent">
      <ul class="navbar-nav">
        <li class="nav-item">
          <i id="memo_toggle" class="fa-regular fa-pen-to-square fa-3x me-4"></i>
        </li>
        <li class="nav-item" id="user-link">
          <i class="fa-regular fa-circle-user fa-3x me-4"></i>
        </li>
      </ul>
    </div>
  </div>
</nav>
<!-- 検索フォーム -->
<form method="post" action="recipe_index">
  @csrf
  <div class="container-fluid pb-3 px-0" style="background-color: #d1eefc;">
    <div class="container input-group">
      <input type="text" name="word" class="form-control" placeholder="レシピを検索" aria-label="Recipient's username"
        aria-describedby="button-addon2">
      <button class="btn btn-outline-primary" type="bottun" id="button-addon2"
        style="background-color: white;">Search</button>
    </div>
  </div>
</form>
<script>
$(function() {
  $("#user-link").on("click", function() {
    window.location.href = "user";
  });
});
</script>
@include('layouts.memo')
@endauth