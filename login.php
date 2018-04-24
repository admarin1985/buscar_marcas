<html>
<head>
  <title>Inicio de sesión</title>
  <link rel="stylesheet" href="bootstrap/dist/css/bootstrap.min.css" >
 
  <!-- Optional theme -->
  <link rel="stylesheet" href="bootstrap/dist/css/bootstrap-theme.min.css" >
 
  <link rel="stylesheet" href="login.css" >
 
  <!-- Latest compiled and minified JavaScript -->
  <script src="bootstrap/dist/js/bootstrap.min.js"></script>
</head>
<form class="form-signin" method="POST" action="trylog.php">
        <h2 class="form-signin-heading">Inicie sesión</h2>
        <div class="input-group">
	  <span class="input-group-addon" id="basic-addon1">@</span>
	  <input type="text" name="username" class="form-control" placeholder="Usuario" required>
	</div>
        <label for="inputPassword" class="sr-only">Password</label>
        <input type="password" name="password" id="inputPassword" class="form-control" placeholder="Contraseña" required>
        <button class="btn btn-lg btn-primary btn-block" type="submit">Iniciar sesión</button>
      </form>
</form>
</html>