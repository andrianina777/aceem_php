<?php
  include '../../controller/paiements.php';
  require_once '../../layout/header.php'; 
  require_once '../../layout/sidebar.php';
  require_once '../../layout/navbar.php';
  
?>
  <div class="content">
    <div class="container-fluid">
      <div class="search-content">
        <div class="container">
          <div class="row">
            <div class="col-md-12">
              <a href="<?=$base_url?>/pages/eleves/create.php">
                <button class="btn btn-danger">Créer</button>
              </a>
            </div>
          </div>
          <div class="row form-group">
            <div class="col-md-1"></div>
            <div class="col-md-2">
              <label for="nom_search">Nom :</label>
            </div>
            <div class="col-md-5">
              <input type="text" id="nom_search" class="form-control">
            </div>
          </div>
          <div class="row form-group">
            <div class="col-md-1"></div>
            <div class="col-md-2">
              <label for="matricule_search">Matricule :</label>
            </div>
            <div class="col-md-5">
              <input type="text" id="matricule_search" class="form-control">
            </div>
          </div>
        </div>
      </div>
      <main>
        
      </main>
    </div>
  </div>
<?php require_once '../../layout/footer.php'; ?>