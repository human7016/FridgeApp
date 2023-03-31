<!DOCTYPE html>
<html>
<head>
<!-- 親コンポーネントはincludeから呼び出す -->
@include('layouts/head')
</head>

<body>
@include('layouts/header')
</header>

<!-- 子コンポーネントはyieldで紐付ける -->
@yield('content')

<!-- bootstrapのCDN -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>
</html>