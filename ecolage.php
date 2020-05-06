<?php
  //include 'controller/paiement.php';
  require_once 'layout/header.php'; 
  require_once 'layout/sidebar.php';
  require_once 'layout/navbar.php';
//misy erreur navbar?>
  <div class="content">
    <div class="container-fluid">
    	<div class="search-content">
    		<div class="container">
    			<div class="row">
    				<div class="col-md-12">
    					<button class="btn btn-danger">Recherche</button>
    				</div>
    			</div>
                    <div class="row form-group">
                    <div class="col-md-1"></div>
                    <div class="col-md-2">
                        <label for="NC_search">Recherche par NC</label>
                    </div>

                    <div class="col-md-5">
                        <input type="text" id="NC_search" class="form-control">
                    </div>
                </div>
            </div>
        </div>

    	</div>
        <div class="row form-group">
                    <div class="col-md-1"></div>
                    <div class="col-md-2">
                        <label for="date_search">Recherche par Date :</label>
                    </div>
                    <div class="col-md-5">
                        <input type="Date" id="date_search" class="form-control">
                    </div>
                </div>
            </div>
        </div>

    	<main>
    		
    	</main>
    </div>
  </div>
<?php require_once 'layout/footer.php'; ?>
