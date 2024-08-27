<?php
require 'config/config.php';
require 'config/database.php';

$db = new Database();
$con = $db->conectar();
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
    <link rel="stylesheet"href="css/style.css">
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
    <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-3">
      <?php foreach ($resultado as $row) { ?>
        <div class="col">
          <div class="card shadow-sm">
            <?php 
            $id = $row['id_producto']; 
            $imagen = "img/productos/" . $id . "/IMG_7817.jpg";

            if (!file_exists($imagen)) {
                $imagen = "img/nophoto.jpg";
            }
            ?>
            <img src="<?php echo $imagen; ?>" alt="">
            <div class="card-body">
              <h5 class="card-title"><?php echo $row['nombre']; ?></h5>
              <p class="card-text">$<?php echo number_format($row['precio'], 2, ',', '.'); ?> </p>
              <div class="d-flex justify-content-between align-items-center">
                <div class="btn-group">
                  <a href="detalles.php?id=<?php echo $row['id_producto']; ?>&token=<?php echo hash_hmac('sha1', $row['id_producto'], KEY_TOKEN); ?>" class = "btn btn-primary">Detalles</a>
                  <a href="#" class = "btn btn-success">Agregar</a>
                </div>
                
              </div>
            </div>
          </div>
        </div>
        <?php } ?>
    </div>
  </div>
</main>
      </body>
</html>