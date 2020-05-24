<?php
  include '../../controller/dashboard.php';
  require_once '../../layout/header.php'; 
  require_once '../../layout/sidebar.php';
  require_once '../../layout/navbar.php';
?>
<div class="container">
	<div class="row">
	  <div class="col-lg-4 col-6">
	    <!-- small box -->
	    <div class="small-box bg-info">
	      <div class="inner">
	        <h3><?=$in_years?></h3>

	        <p>Payer</p>
	      </div>
	      <div class="icon">
	        <i class="ion ion-bag"></i>
	      </div>
	      <a href="#" class="small-box-footer">Cette année</a>
	    </div>
	  </div>
	  <!-- ./col -->
	  <div class="col-lg-4 col-6">
	    <!-- small box -->
	    <div class="small-box bg-success">
	      <div class="inner">
	        <h3><?=$in_mounth?></h3>

	        <p>Payer</p>
	      </div>
	      <div class="icon">
	        <i class="ion ion-stats-bars"></i>
	      </div>
	      <a href="#" class="small-box-footer">Ce mois</a>
	    </div>
	  </div>
	  <!-- ./col -->
	  <div class="col-lg-4 col-6">
	    <!-- small box -->
	    <div class="small-box bg-warning">
	      <div class="inner">
	        <h3><?=$in_day?></h3>

	        <p>Payer</p>
	      </div>
	      <div class="icon">
	        <i class="ion ion-person-add"></i>
	      </div>
	      <a href="#" class="small-box-footer">Aujourd'hui</i></a>
	    </div>
	  </div>
	  <!-- ./col -->
	</div>
	<div class="row">
		<div class="col-lg-4 col-6"></div>
	  	<div class="col-lg-4 col-6">
		    <!-- small box -->
		    <div class="small-box bg-danger">
		      <div class="inner">
		        <h3><?=$deperdition?></h3>

		        <p>Non payer</p>
		      </div>
		      <div class="icon">
		        <i class="ion ion-pie-graph"></i>
		      </div>
		      <a href="#" class="small-box-footer">Déperdition</a>
		    </div>
		 </div>
	  <!-- ./col -->
	  <div class="col-lg-4 col-6"></div>
	</div>
</div>
<?php require_once '../../layout/footer.php'; ?>