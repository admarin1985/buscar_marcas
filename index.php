
<?php
session_start();
if ($_SESSION['login']!==true ) {
    header('Location: login.php');
}
    require 'Db.php';   
  
    $query = 'SELECT codigo, contrato, puesto, estructura.marca, fecha_hora FROM estructura inner join marcas on estructura.codigo = marcas.marca where 1';

    if (isset($_GET['fecha']) && $_GET['fecha'] != ''){
        $query .= ' and DATE(fecha_hora) = '.'"'.$_GET['fecha'].'"';
    }

    if (isset($_GET['hora']) && $_GET['hora'] != ''){
        $query .= ' and TIME(fecha_hora) like '.'"%'.$_GET['hora'].'%"';
    }
    
    if (isset($_GET['contrato']) && $_GET['contrato'] != ''){
        $query .= ' and contrato like "%'.$_GET['contrato'].'%"';
    }

    if (isset($_GET['puesto']) && $_GET['puesto'] != ''){
        $query .= ' and puesto like "%'.$_GET['puesto'].'%"';
    }

    if (isset($_GET['marca']) && $_GET['marca'] != ''){
        $query .= ' and marca like "%'.$_GET['marca'].'%"';
    }
       
    $db = new Db();
    $rows = $db -> select($query);
?>   
    
<html>
    <head>
    <title>Buscador de marcas</title>
    <link href="style.css" rel="stylesheet">
    <link rel="stylesheet" href="bootstrap/dist/css/bootstrap.min.css" > 
    <link rel="stylesheet" href="bootstrap-extension/css/bootstrap-extension.css" > 
    <!-- Optional theme -->
    <link rel="stylesheet" href="bootstrap/dist/css/bootstrap-theme.min.css" >
    <link rel="stylesheet" href="DataTables/media/css/dataTables.bootstrap.min.css" >

    <!-- Latest compiled and minified JavaScript -->
    <script src="jquery/dist/jquery.min.js"></script>
    <script src="bootstrap/dist/js/tether.min.js"></script>
    <script src="bootstrap/dist/js/bootstrap.min.js"></script>
    <script src="DataTables/media/js/jquery.dataTables.min.js"></script>
    <script src="DataTables/media/js/dataTables.bootstrap.min.js"></script>
    <script src="DataTables/media/js/i18n/es.js"></script>    
    
</head>
<body> 
<div class="buscador"> 
    <div class="float-lg-right">
        <a href='logout.php'> Salir <i class="fa fa-close">X</i></a>
    </div>    
    <div class="row">
            <div class="col-md-12">
                <div class="portlet light portlet-fit bordered">
                    <div class="portlet-body">
                        <div class="form-body">
                        <form action="index.php" method="GET">
                            <div class=row>
                                <div class="col-md-3">Fecha: <input type="date" id="fecha" class="form-control" name="fecha"/></div>
                                <div class="col-md-3">Hora: <input type="time" id="hora" class="form-control" name="hora"/></div>
                                <div class="col-md-6">Contrato: <input type="text" id="contrato" class="form-control" name="contrato"/></div>                                
                            </div>    
                            <div class=row> 
                                <div class="col-md-6">Puesto: <input type="text" id="puesto" class="form-control" name="puesto"/></div>
                                <div class="col-md-6">Marca: <input type="text" id="marca" class="form-control" name="marca"/></div> 
                            </div>
                            <br>
                            <div class="row">
                                <div class="col-md-2">
                                    <button type="submit" class="btn btn-primary">                                        
                                        Buscar
                                    </button>
                                </div>
                            </div>
                                
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>  
</div>
  
<h1>Marcas</h1>
	<table class="data-table" id="table-datatable">
		<caption class="title">Buscador de marcas</caption>
		<thead>
			<tr>
				<th>Código</th>
				<th>Contrato</th>
				<th>Puesto</th>
                <th>Marca</th>
                <th>Fecha</th>
			</tr>
		</thead>
		<tbody>
        <?php
        if($rows !== false){        
            foreach($rows as $row){
                echo '<tr>                        
                        <td>'.$row['codigo'].'</td>
                        <td>'.$row['contrato'].'</td>
                        <td>'.$row['puesto'].'</td>
                        <td>'.$row['marca'].'</td>
                        <td>'.$row['fecha_hora'].'</td>
                        
                    </tr>';
            }
        }?>
		</tbody>		
    </table>
    
    <!-- <script type="text/javascript">
        $(document).ready(function () {
            $('#table-datatable').DataTable();
        });
    </script> -->
</body>
</html>