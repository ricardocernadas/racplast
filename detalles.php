<?php
require 'config/config.php';
require 'config/database.php';

$db = new Database();
$con = $db->conectar();

$id = isset($_GET['id']) ? $_GET['id_producto'] : '';
$token = isset($_GET['token']) ?'';

if($id == '' || $token == ''){
    echo "Error al procesar la peticion";
    exit;
else{
    $token_tmp = hash_hmac('sha1', $id, KEY_TOKEN);
    if($token == $token_tmp){
        $sql = $con -> prepare ("SELECT * FROM productos WHERE id_producto = ?")  ;
        $sql->execute([$id]);
        $row = $sql->fetch(PDO::FETCH_ASSOC);
    }
}
}

$sql = $con -> prepare ("SELECT id_producto, nombre, precio FROM productos WHERE activo = 1")  ;

$sql->execute();
$resultado = $sql->fetchAll(PDO::FETCH_ASSOC);
?>




<!DOCTYPE html>
<html lang="es-ES">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
<nav class="navbar navbar-expand-md bg-dark sticky-top border-bottom" data-bs-theme="dark" style="">
  <div class="container">
    <a class="navbar-brand d-md-none" href="#">
      <svg class="bi" width="24" height="24"><use xlink:href="#aperture"></use></svg>
      Aperture
    </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvas" aria-controls="offcanvas" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvas" aria-labelledby="offcanvasLabel">
      <div class="offcanvas-header">
        <h5 class="offcanvas-title" id="offcanvasLabel">Aperture</h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
      </div>
      <div class="offcanvas-body">
        <ul class="navbar-nav flex-grow-1 justify-content-between">
          <li class="nav-item"><a class="nav-link" href="#">
            <svg class="bi" width="24" height="24"><use xlink:href="#aperture"></use></svg>
          </a></li>
          <li class="nav-item"><a class="nav-link" href="#">Tour</a></li>
          <li class="nav-item"><a class="nav-link" href="#">Product</a></li>
          <li class="nav-item"><a class="nav-link" href="#">Features</a></li>
          <li class="nav-item"><a class="nav-link" href="#">Enterprise</a></li>
          <li class="nav-item"><a class="nav-link" href="#">Support</a></li>
          <li class="nav-item"><a class="nav-link" href="#">Pricing</a></li>
          <li class="nav-item"><a class="nav-link" href="#">
            <a href="#cart"><img src="img/carticon.png" alt="carrito" class="carrito"></a>
          </a></li>
        </ul>
      </div>
    </div>
  </div>
</nav>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<main>
  <div class= container>  
    
  </div>
</main>
      </body>
</html>