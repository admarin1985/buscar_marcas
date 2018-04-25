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
        $query .= ' and TIME(fecha_hora) like '.'"'.$_GET['hora'].'%"';
    }
    
    if (isset($_GET['contrato']) && $_GET['contrato'] != ''){
        $query .= ' and contrato like "%'.$_GET['contrato'].'%"';
    }

    if (isset($_GET['puesto']) && $_GET['puesto'] != ''){
        $query .= ' and puesto like "%'.$_GET['puesto'].'%"';
    }

    if (isset($_GET['marca']) && $_GET['marca'] != ''){
        $query .= ' and estructura.marca like "%'.$_GET['marca'].'%"';
    }

    if (isset($_GET['submited']) && $_GET['submited'] != ''){
        $_SESSION['query'] = $query; 
    }
     
    if(isset($_SESSION['query']))
        $query = $_SESSION['query'];

    $db = new Db();
    $rows = $db -> select($query);

    //paginar resultados
    $config = parse_ini_file('./config.ini');
    $perpage = $config['results_perpage'];
    if(isset($_GET['page']) & !empty($_GET['page'])){
        $curpage = $_GET['page'];
    }else{
        $curpage = 1;
    }
    $start = ($curpage * $perpage) - $perpage;
    $totalres = $rows === false ? 0 : sizeof($rows);

    $endpage = ceil($totalres/$perpage);
    $startpage = 1;
    $nextpage = $curpage + 1;
    $previouspage = $curpage - 1;

    $paginatedQuery = $query . ' LIMIT '.$start.', '. $perpage;

    $rows = $db -> select($paginatedQuery);
?>

<html>
    <head>
    <title>Buscador de marcas</title>
    <link href="style.css" rel="stylesheet">
    <link rel="stylesheet" href="bootstrap/dist/css/bootstrap.min.css" > 
    <link rel="stylesheet" href="bootstrap-extension/css/bootstrap-extension.css" > 
    <!-- Optional theme -->
    <link rel="stylesheet" href="bootstrap/dist/css/bootstrap-theme.min.css" >
    <link rel="stylesheet" href="bootstrap-datepicker/css/bootstrap-datetimepicker.min.css" >

    <!-- Latest compiled and minified JavaScript -->
    <script src="jquery/dist/jquery.min.js"></script>
    <script src="bootstrap/dist/js/tether.min.js"></script>
    <script src="bootstrap/dist/js/bootstrap.min.js"></script>
    <script src="moment/min/moment.min.js"></script>
    <script src="moment/locale/es.js"></script>
    <script src="bootstrap-datepicker/js/bootstrap-datetimepicker.min.js"></script>

    
</head>

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
                                <div class="col-md-3">Fecha: <input type="text" id="fecha" class="form-control datepicker" name="fecha" placeholder="Fecha"/></div>
                                <div class="col-md-3">Hora: <input type="text" id="hora" class="form-control timepicker" name="hora" placeholder="Hora"/></div>
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
                                <input type="hidden" id="submited" name="submited" value="submited">
                            </div>                                
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>  
</div>
<body>   
<h1>Marcas</h1>
	<table class="data-table" id="table-datatable">
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
            <tr>
                <td colspan="5">
                    <nav>
                    <ul class="pagination">
                        <?php if($curpage != $startpage){ ?>
                            <li class="page-item">
                            <a class="page-link" href="?page=<?php echo $startpage ?>" tabindex="-1" aria-label="Previous">
                                <span aria-hidden="true">&laquo;</span>
                                <span class="sr-only">First</span>
                            </a>
                            </li>
                        <?php } ?>
                        <?php if($curpage >= 2){ ?>
                            <li class="page-item"><a class="page-link" href="?page=<?php echo $previouspage ?>"><?php echo $previouspage ?></a></li>
                        <?php } ?>
                        <li class="page-item active"><a class="page-link" href="?page=<?php echo $curpage ?>"><?php echo $curpage ?></a></li>
                        <?php if($curpage != $endpage){ ?>
                            <li class="page-item"><a class="page-link" href="?page=<?php echo $nextpage ?>"><?php echo $nextpage ?></a></li>
                        <?php } ?>
                        <?php if($curpage != $endpage){ ?>
                            <li class="page-item">
                            <a class="page-link" href="?page=<?php echo $endpage ?>" aria-label="Next">
                                <span aria-hidden="true">&raquo;</span>
                                <span class="sr-only">Last</span>
                            </a>
                            </li>
                        <?php } ?>
                    </ul>
                    </nav>
                </td>
            </tr>
            <tr>
                <td colspan="5">La consulta produjo <?php echo($totalres); ?> resultados</td>
            </tr>
        </tbody>
        <tfoot>
        
        </tfoot>		
    </table>        
    
    <script type="text/javascript">
        $('.datepicker').datetimepicker({
            'format': 'Y/M/D'
        });
        $('.timepicker').datetimepicker({
            'format': 'hh:mm'
        });
    </script>
</body>
</html>