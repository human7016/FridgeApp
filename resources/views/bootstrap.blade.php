<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <!-- ビューポート -->
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
  <link rel="stylesheet" type="text/css" href="css/bootstrap/layout.css">
  <!-- fontawesome使い方：https://fontawesome.com/icons/magnifying-glass -->
  <script src="https://kit.fontawesome.com/91f77763d8.js" crossorigin="anonymous"></script>
  <title></title>
</head>
<body>

<header>
  <!-- navberテンプレ:https://skillhub.jp/courses/230/lessons/1640 -->
  <!-- navberカスタム：https://skillhub.jp/courses/230/lessons/1641 -->
<nav class="navbar navbar-expand-lg navbar-light bg-info fixed-top">
  <div class="container-fluid">
    <a class="navbar-brand" href="#">Navbar</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="#">Home</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">Link</a>
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Dropdown
          </a>
          <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
            <li><a class="dropdown-item" href="#">Action</a></li>
            <li><a class="dropdown-item" href="#">Another action</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item" href="#">Something else here</a></li>
          </ul>
        </li>
        <li class="nav-item">
          <a class="nav-link disabled" href="#" tabindex="-1" aria-disabled="true">Disabled</a>
        </li>
      </ul>
      <form class="d-flex">
        <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
        <button class="btn btn-outline-success" type="submit">Search</button>
      </form>
    </div>
  </div>
</nav>
<div class="alert alert-primary alert-dismissible fade show" role="alert">
  <strong>Holy guacamole!</strong> You should check in on some of those fields below.
  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
<div class="img-hidden">
<!-- w-100:画像が小さくても画面幅に引き伸ばして表示:https://skillhub.jp/courses/230/lessons/1640 -->
<img src="images/bootstrap/a.jpg" class="img-fluid w-100">
</div>
</header>
<!-- margin, padding：https://skillhub.jp/courses/230/lessons/1646 -->
<div class="container mt-5">
  <div class="row">
    <div class="col-md-6 px-0">
      <img src="images/bootstrap/test.jpg" class="img-fluid">
    </div>
    <div class="col-md-6 px-0">
      <h1>sampletext</h1>
      <p>samplet extsampletextsam pletextsampletextsamplete xtsampl etextsa mpletextsamplet exts amplet extsamp lete xtsam p letext sampl ete xtsamp letextsample text sam plet extsampl etext sampletexts amplete xtsample textsa mplet extsam ple text
      </p>
    </div>
  </div>
</div>

<div class="container mt-5">
  <div class="row row-cols-1 row-cols-md-3 g-4">
    <div class="col">
      <div class="card h-100">
        <img src="images/bootstrap/b.jpg" class="card-img-top img-fluid" alt="...">
        <div class="card-body">
          <h5 class="card-title">Card title</h5>
          <p class="card-text">This is a wider card with supporting text below as a natural lead-in to additional content. This content is a little bit longer.</p>
        </div>
        <div class="card-footer text-end">
          <small class="text-muted">Last updated 3 mins ago</small>
        </div>
      </div>
    </div>
    <div class="col">
      <div class="card h-100">
        <img src="images/bootstrap/b.jpg" class="card-img-top" alt="...">
        <div class="card-body">
          <h5 class="card-title">Card title</h5>
          <p class="card-text">This card has supporting text below as a natural lead-in to additional content.</p>
        </div>
        <div class="card-footer text-end">
          <small class="text-muted">Last updated 3 mins ago</small>
        </div>
      </div>
    </div>
    <div class="col">
      <div class="card h-100">
        <img src="images/bootstrap/b.jpg" class="card-img-top" alt="...">
        <div class="card-body">
          <h5 class="card-title">Card title</h5>
          <p class="card-text">This is a wider card with supporting text below as a natural lead-in to additional content. This card has even longer content than the first to show that equal height action.</p>
        </div>
        <div class="card-footer text-end">
          <small class="text-muted">Last updated 3 mins ago</small>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="container mt-5">
  <div class="row">
    <div class="col-md-4 img-hidden">
      <img src="images/bootstrap/c.jpg" alt="img" class="img-fluid">
    </div>
    <div class="col-md-8">
      <h1>Sample Text</h1>
      <p>Sample TextSample TextSample TextSample TextSample TextSample TextSample TextSample TextSample TextSample TextSample TextSample TextSample TextSample TextSample TextSample TextSample TextSample TextSample TextSample TextSample TextSample TextSample TextSample TextSample TextSample TextSample Text</p>
    </div>
  </div>
</div>

<div class="container mt-5">
  <div class="row">
    <div class="col-md-4 img-hidden">
      <img src="images/bootstrap/d.jpg" alt="img" class="img-fluid">
    </div>
    <div class="col-md-4 img-hidden">
      <img src="images/bootstrap/d.jpg" alt="img" class="img-fluid">
    </div>
    <div class="col-md-4 img-hidden">
      <img src="images/bootstrap/d.jpg" alt="img" class="img-fluid">
    </div>
  </div>
</div>
<!-- fontawesome使い方：https://fontawesome.com/icons/magnifying-glass -->
<i class="fa-solid fa-house"></i>
<i class="fa-solid fa-magnifying-glass fa-2x"></i>
<i class="fa-solid fa-user fa-4x"></i>
<footer class="footer mt-5">© 2018 Bootstrap test</footer>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>
</html>