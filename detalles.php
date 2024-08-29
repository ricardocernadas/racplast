<?php
require 'config/config.php';
require 'config/database.php';

$db = new Database();
$con = $db->conectar();

$id = isset($_GET['id']) ? $_GET['id'] : '';
$token = isset($_GET['token']) ? $_GET['token'] : '';

if($id == '' || $token == ''){
    echo "Error al procesar la petición";
    exit;
} else {
    $token_tmp = hash_hmac('sha1', $id, KEY_TOKEN);
    if($token == $token_tmp){
        $sql = $con->prepare("SELECT count(id_producto) FROM productos WHERE id_producto = ? AND activo = 1 LIMIT 1");
        $sql->execute([$id]);
        if($sql->fetchColumn() > 0){
            $sql = $con->prepare("SELECT nombre, descripcion, precio, descuento FROM productos WHERE id_producto = ?");
            $sql->execute([$id]);
            $row = $sql->fetch(PDO::FETCH_ASSOC);
            $nombre = $row['nombre'];
            $descripcion = $row['descripcion'];
            $precio = $row['precio'];
            $descuento = $row['descuento'];
            $precio_desc = $precio - ($precio * $descuento) / 100;
            $dir_images = 'img/productos/' . $id . '/';

            $rutaImg = $dir_images . 'principal.jpg';
            if(!file_exists($rutaImg)){
                $rutaImg = $dir_images . 'img/nophoto.jpg';
            }
            $imagenes = array();
            $dir = dir($dir_images);
            while(($archivo = $dir->read()) !== false){
                if($archivo != 'principal.jpg' && (strpos($archivo, 'jpg') || strpos($archivo, 'png'))){
                    $imagenes[] = $dir_images . $archivo;
                }
            }
            $dir->close();
        }
        $row = $sql->fetch(PDO::FETCH_ASSOC);
    }
}
?>

<!DOCTYPE html>
<html lang="es-ES">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalles</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <link rel="stylesheet" href="css/style.css">

</head>
<body>
<nav class="navbar navbar-expand-md bg-dark sticky-top border-bottom" data-bs-theme="dark">
  <div class="container">
    <a class="navbar-brand d-md-none" href="index.php">Aperture</a>
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
          <li class="nav-item">
            <a class="nav-link" href="#">
              <a href="#cart"><img src="img/carticon.png" alt="carrito" class="carrito"></a>
            </a>
          </li>
        </ul>
      </div>
    </div>
  </div>
</nav>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<main>
  <div class="container">  
    <div class="row">
      <div class="col-md-6">
        <div class="carousel-container">
          <div id="carouselImages" class="carousel slide">
            <div class="carousel-inner">
              <div class="carousel-item active">
                <img src="<?php echo $rutaImg; ?>" alt="Imagen principal">
              </div>
              <?php foreach($imagenes as $img) { ?>
                <div class="carousel-item">
                  <img src="<?php echo $img; ?>" alt="Imagen adicional">
                </div>
              <?php } ?>
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#carouselImages" data-bs-slide="prev">
              <span class="carousel-control-prev-icon" aria-hidden="true"></span>
              <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#carouselImages" data-bs-slide="next">
              <span class="carousel-control-next-icon" aria-hidden="true"></span>
              <span class="visually-hidden">Next</span>
            </button>
          </div>
        </div>
      </div>
      <div class="col-md-6">
        <h2><?php echo $nombre; ?></h2>
        <h3><?php echo MONEDA . number_format($precio, 2, '.', ''); ?></h3>
        <p class="lead"><?php echo $descripcion; ?></p>
        <div class="d-grid gap-2">
          <button class="btn btn-primary btn-lg" type="button">Comprar</button>
          <button class="btn btn-outline-primary btn-lg" type="button">Añadir al carrito</button>
        </div>
      </div>
    </div>
  </div>
</main>
</body>
</html>