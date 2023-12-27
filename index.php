<?php 
require('config.php');
$result = $connexion->query('SELECT COUNT(*) as total_contenedores FROM contenedores WHERE estado =1');
$row = $result->fetch_assoc();
$num_total_rows = $row['total_contenedores'];
?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Paginación de resultados con PHP Demo</title>
	<link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
	<script src="https://code.jquery.com/jquery-3.2.1.js"></script>
<style>
      .bd-placeholder-img {
        font-size: 1.125rem;
        text-anchor: middle;
        -webkit-user-select: none;
        -moz-user-select: none;
        user-select: none;
      }

      @media (min-width: 768px) {
        .bd-placeholder-img-lg {
          font-size: 3.5rem;
        }
      }

      .b-example-divider {
        width: 100%;
        height: 3rem;
        background-color: rgba(0, 0, 0, .1);
        border: solid rgba(0, 0, 0, .15);
        border-width: 1px 0;
        box-shadow: inset 0 .5em 1.5em rgba(0, 0, 0, .1), inset 0 .125em .5em rgba(0, 0, 0, .15);
      }

      .b-example-vr {
        flex-shrink: 0;
        width: 1.5rem;
        height: 100vh;
      }

      .bi {
        vertical-align: -.125em;
        fill: currentColor;
      }

      .nav-scroller {
        position: relative;
        z-index: 2;
        height: 2.75rem;
        overflow-y: hidden;
      }

      .nav-scroller .nav {
        display: flex;
        flex-wrap: nowrap;
        padding-bottom: 1rem;
        margin-top: -1px;
        overflow-x: auto;
        text-align: center;
        white-space: nowrap;
        -webkit-overflow-scrolling: touch;
      }

      .btn-bd-primary {
        --bd-violet-bg: #712cf9;
        --bd-violet-rgb: 112.520718, 44.062154, 249.437846;

        --bs-btn-font-weight: 600;
        --bs-btn-color: var(--bs-white);
        --bs-btn-bg: var(--bd-violet-bg);
        --bs-btn-border-color: var(--bd-violet-bg);
        --bs-btn-hover-color: var(--bs-white);
        --bs-btn-hover-bg: #6528e0;
        --bs-btn-hover-border-color: #6528e0;
        --bs-btn-focus-shadow-rgb: var(--bd-violet-rgb);
        --bs-btn-active-color: var(--bs-btn-hover-color);
        --bs-btn-active-bg: #5a23c8;
        --bs-btn-active-border-color: #5a23c8;
      }

      .bd-mode-toggle {
        z-index: 1500;
      }

      .bd-mode-toggle .dropdown-menu .active .bi {
        display: block !important;
      }
    </style>
</head>
<body>
	<header data-bs-theme="dark">
	  <div class="collapse text-bg-dark" id="navbarHeader">
		<div class="container">
		  <div class="row">
			<div class="col-sm-8 col-md-7 py-4">
			  <h4>About</h4>
			  <p class="text-body-secondary">Add some information about the album below, the author, or any other background context. Make it a few sentences long so folks can pick up some informative tidbits. Then, link them off to some social networking sites or contact information.</p>
			</div>
			<div class="col-sm-4 offset-md-1 py-4">
			  <h4>Contact</h4>
			  <ul class="list-unstyled">
				<li><a href="#" class="text-white">Follow on Twitter</a></li>
				<li><a href="#" class="text-white">Like on Facebook</a></li>
				<li><a href="#" class="text-white">Email me</a></li>
			  </ul>
			</div>
		  </div>
		</div>
	  </div>
	  <div class="navbar navbar-dark bg-dark shadow-sm">
		<div class="container">
		  <a href="#" class="navbar-brand d-flex align-items-center">
			<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" aria-hidden="true" class="me-2" viewBox="0 0 24 24"><path d="M23 19a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h4l2-3h6l2 3h4a2 2 0 0 1 2 2z"/><circle cx="12" cy="13" r="4"/></svg>
			<strong>Album</strong>
		  </a>
		  <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarHeader" aria-controls="navbarHeader" aria-expanded="false" aria-label="Toggle navigation">
			<span class="navbar-toggler-icon"></span>
		  </button>
		</div>
	  </div>
	</header>	
<main>	
  <section class="py-3 text-center container">
    <div class="row py-lg-5">
      <div class="col-lg-7 col-md-9 mx-auto">
        <h1 class="fw-light">Sistema de control y monitoreo en vivo</h1>
      </div>
    </div>
  </section>
<div class="album py-5 bg-body-tertiary">
	<div class="container">
	<?php
	if ($num_total_rows > 0) {
		$page = false;

		//examino la pagina a mostrar y el inicio del registro a mostrar
		if (isset($_GET["page"])) {
			$page = $_GET["page"];
		}

		if (!$page) {
			$start = 0;
			$page = 1;
		} else {
			$start = ($page - 1) * NUM_ITEMS_BY_PAGE;
		}
		//calculo el total de paginas
		$total_pages = ceil($num_total_rows / NUM_ITEMS_BY_PAGE);

		//pongo el n�mero de registros total, el tama�o de p�gina y la p�gina que se muestra
		/*echo '<h3>Numero de articulos: '.$num_total_rows.'</h3>';
		echo '<h3>En cada pagina se muestra '.NUM_ITEMS_BY_PAGE.' articulos ordenados por fecha en formato descendente.</h3>';
		echo '<h3>Mostrando la pagina '.$page.' de ' .$total_pages.' paginas.</h3>';*/

		$result = $connexion->query(
			'SELECT * FROM contenedores WHERE estado =1 
		ORDER BY nombre_contenedor DESC LIMIT '.$start.', '.NUM_ITEMS_BY_PAGE
		);
		echo '<div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-3">';
		if ($result->num_rows > 0) {
			while ($row = $result->fetch_assoc()) {
				echo '<div class="col">';
					echo '<div class="card  shadow-sm">';			
						echo '<div class="card-body">';
							echo '<h5 class="card-title">ID: '.utf8_encode($row['nombre_contenedor']).'</h5>';
								echo '<div class="d-flex justify-content-between align-items-center">';
									echo '<div class="btn-group justify-content-between align-items-center">';
										echo '<button type="button" class="btn btn-sm btn-outline-primary">Grafica</button>';
										echo '<button type="button" class="btn btn-sm btn-outline-secondary">Datos</button>';
										echo '<button type="button" class="btn btn-sm btn-outline-success">Email</button>';
										echo '<button type="button" class="btn btn-sm btn-outline-danger">Report</button>';
									echo  '</div>';
								echo '</div>';
						echo '</div>';
						echo '<div class="card-body">';
							echo '<div class="table-responsive">';
								echo '<table class="table table-bordered border-success">';
									echo '<thead>';
										echo '<tr>';
											echo '<th scope="col">Parametros</th>';
											echo '<th scope="col">Set</th>';
											echo '<th scope="col">Actual</th>';
										echo '</tr>';
									echo '</thead>';
									echo '<tbody>';
										echo '<tr>';
											echo '<th scope="row">Temperatura</th>';
											echo '<td>';
												echo '<div class="input-group mb-2">';
													echo '<input type="text" class="form-control" aria-label="temperatura" size="20" value="'.$row['set_point'].'">';	
													echo '<span class="input-group-text">C°</span>';
												echo '</div>';
											echo '</td>';
											echo '<td>';
												echo '<div class="input-group mb-2">';
													echo '<span class="input-group-text">S : '.$row['temp_supply_1'].' C°</span>';
												echo '</div>';
										  echo '</td>';										  
										echo '</tr>';
										echo '<tr>';
											echo '<th scope="row">Humedad</th>';
											echo '<td>';
												echo '<div class="input-group mb-2">';
													echo '<input type="text" class="form-control" aria-label="temperatura" size="20" value="'.$row['humidity_set_point'].'">';
													echo '<span class="input-group-text">%</span>';
												echo '</div>';
											echo '</td>';
											echo '<td>';
												echo '<div class="input-group mb-2">';
													echo '<span class="input-group-text">R : '.$row['return_air'].' %</span>';
												echo '</div>';
											echo '</td>';
										echo '</tr>';
										echo '<tr>';
										  echo '<th scope="row">CO2</th>';
										  echo '<td>';
											echo '<div class="input-group mb-2">';
												echo '<input type="text" class="form-control" aria-label="temperatura" size="20" value="'.$row['set_point_co2'].'">';
												echo '<span class="input-group-text">%</span>';
											echo '</div>';
										  echo '</td>';
										  echo '<td>';
											echo '<div class="input-group mb-2">';
												echo '<span class="input-group-text">'.$row['co2_reading'].' %</span>';
											echo '</div>';
										  echo '</td>';
										echo '</tr>';
										echo '<tr>';
											echo '<th scope="row">C2 H2</th>';
											echo '<td>';
												echo '<div class="input-group mb-2">';
													echo '<input type="text" class="form-control" aria-label="temperatura" size="20" value="'.$row['sp_ethyleno'].'">';
													echo '<span class="input-group-text">ppm</span>';
												echo '</div>';
											echo '</td>';
											echo '<td>';
												echo '<div class="input-group mb-2">';
													echo '<span class="input-group-text">'.$row['ethylene'].'  ppm</span>';
												echo '</div>';
											echo ' </td>';
										echo '</tr>';
										echo '<tr>';
											echo '<th scope="row">Horas de Inyeccion</th>';
											echo '<td>';
												echo '<div class="input-group mb-2">';
													echo '<input type="text" class="form-control" aria-label="temperatura" size="20">';
													echo '<span class="input-group-text">Horas</span>';
												echo '</div>';
										  echo '</td>';
										  echo '<td>';
											echo '<div class="input-group mb-2">';
												echo '<input type="text" class="form-control" aria-label="temperatura" size="20">';
												echo '<span class="input-group-text">Horas</span>';
											echo '</div>';
										  echo '</td>';
										echo '</tr>';
									echo '</tbody>';
								echo '</table>';
							echo '</div>';
						echo '</div>';	
					echo '</div>';
				echo '</div>';		
				
					}
			
		}
		echo '</div>';	
		//echo '<div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-3">';
			echo '<nav aria-label="Page navigation example">';
				echo '<ul id="pagination-demo" class="pagination justify-content-end">';
				if ($total_pages > 1) {
					if ($page != 1) {
						echo '<li class="page-item"><a class="page-link" href="index.php?page='.($page-1).'"><span aria-hidden="true">&laquo;</span></a></li>';
					}

					for ($i=1;$i<=$total_pages;$i++) {
						if ($page == $i) {
							echo '<li class="page-item active"><a class="page-link" href="#">'.$page.'</a></li>';
						} else {
							echo '<li class="page-item"><a class="page-link" href="index.php?page='.$i.'">'.$i.'</a></li>';
						}
					}

					if ($page != $total_pages) {
						echo '<li class="page-item"><a class="page-link" href="index.php?page='.($page+1).'"><span aria-hidden="true">&raquo;</span></a></li>';
					}
				}
				echo '</ul>';
			echo '</nav>';
		//echo '</div>';
	}
	?>		     
	</div>
</div>
</main>
<footer class="text-body-secondary py-5">
  <div class="container">
    <p class="float-end mb-1">
      <a href="#">Back to top</a>
    </p>
    <p class="mb-1">Album example is &copy; Bootstrap, but please download and customize it for yourself!</p>
    <p class="mb-0">New to Bootstrap? <a href="/">Visit the homepage</a> or read our <a href="../getting-started/introduction/">getting started guide</a>.</p>
  </div>
</footer>

</body>
</html>