<?php
session_start();
include ("conexion/database.php");

if(isset($_POST["correo"]) && isset($_POST["clave"]) ){
  //exit($_POST["correo"]."/".$_POST["clave"]);
  $correo = $_POST["correo"];
  $clave = $_POST["clave"];
  $sql = "Select * From usuario Where correo='$correo' and clave = '$clave' and estado='A'";
  //echo("<br />".$sql);
  //exit(0);
  $result = dbQuery($sql);
  $num_rows = mysqli_num_rows($result);
  if ($num_rows > 0 ) 
  { $row = mysqli_fetch_array($result, MYSQLI_BOTH);   
    $idusuario = $row["idusuario"];
    $_SESSION["IDUSUARIO"] = $idusuario; 
    $_SESSION["USUARIO"] = $row["nombre"]." ".$row["apellido"];	
    echo "<script language='JavaScript'>";
    echo "window.location.href='blank.php';";
    echo "</script>";

  }
  else
  { 	echo '<script language="JavaScript">';
      echo 'alert("La información registrada no es valida");';
      echo '</script>';
  }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Fitness.Center | Iniciar Sesión</title>

    

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="../Lab01/plugins/fontawesome-free/css/all.min.css">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="../Lab01/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="../Lab01/dist/css/adminlte.min.css">

  
  <style>
     body {
        background-image: url('../Lab01/imagen.jpg');
        background-size: cover;
        background-position: center;
     }

     
     .login-logo {
        color: #28a745;
        font-weight: bold;
        text-align: center;
     }

     .login-logo a {
        display: block;
        text-decoration: none;
     }

     .login-logo .linea1 {
        font-size: 4rem;  
        margin-bottom: 0; 
        color: #FFA500; 
     }

     .login-logo .linea2 {
        font-size: 3.5rem; 
        margin-top: -20px; 
        color: #FFA500; 
     }

     
     .login-box {
        background-color: rgba(17, 17, 17, 0.8); 
        color: white; 
        border-radius: 10px; 
        padding: 30px;
        margin: 0 auto;
        width: 500px; 
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%,-50%);
     }

    
     .login-card-body {
        background-color: rgba(255, 255, 255, 0.9); 
        border-radius: 10px;
        padding: 20px;
        color: #000;
        width: 300px;
        margin: 0 auto;
     }

     
     .btn-login {
        background-color: #FFA500;
        color: white;
     }

   
     .btn-facebook {
        background-color: #3b5998;
        color: white;
     }

     .btn-google {
        background-color: #dd1505;
        color: white;
     }

  </style>
</head>

<body class="hold-transition login-page">
<div class="login-box">

  <!-- título -->
  <div class="login-logo">
    <a href="../Lab01/index2.html">
      <span class="linea1">Fitness</span><br>
      <span class="linea2">Center</span>
    </a>
  </div>

  <div class="card">
    <div class="card-body login-card-body">
      <p class="login-box-msg">Regístrate o inicia sesión</p>

      <form action="login.php" method="post">

        <!--correo electrónico -->
        <div class="input-group mb-3">
          <input type="email" class="form-control" placeholder="Correo Electrónico" name="correo">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-envelope"></span>
            </div>
          </div>
        </div>

        <!--contraseña -->
        <div class="input-group mb-3">
          <input type="password" class="form-control" placeholder="Contraseña" name="clave">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>

        <!-- Botón de Iniciar Sesión -->
        <div class="row justify-content-center mt-2">
          <div class="col-6">
            <button type="submit" class="btn btn-login btn-block">Iniciar Sesión</button>
          </div>
        </div>

        <div>
          <br/>
        </div>

        <div class="row justify-content-center">
          <div class="col-8 text-center">
            <div class="icheck-primary d-inline">
              <input type="checkbox" id="remember">
              <label for="remember">
                Recordarme
              </label>
            </div>
          </div>
        </div>

      </form>

      <div class="social-auth-links text-center mb-3">
        <p>- O -</p>
        <a href="#" class="btn btn-facebook btn-block">
          <i class="fab fa-facebook mr-2"></i> Iniciar con Facebook
        </a>
        <a href="#" class="btn btn-google btn-block">
          <i class="fab fa-google-plus mr-2"></i> Iniciar con Google
        </a>
      </div>
      

      <p class="mb-1">
        <a href="forgot-password.html">Olvidé mi contraseña</a>
      </p>
      <p class="mb-0">
        <a href="register.html" class="text-center">Registrar nueva membresía</a>
      </p>
    </div>
    
  </div>
</div>


<!-- jQuery -->
<script src="../Lab01/plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="../Lab01/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="../Lab01/dist/js/adminlte.min.js"></script>
</body>
</html>
