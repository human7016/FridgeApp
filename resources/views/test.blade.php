<form method="POST" action="/upload" enctype="multipart/form-data">
  @csrf
  <input type="file" name="image">
  <button>アップロード</button>
</form>

@foreach ($images as $image)
<!-- $image->path == storage/foods/ファイル名 -->
<img src="{{ asset($image->path) }}">
@endforeach