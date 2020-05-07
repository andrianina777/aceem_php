<?php
  include '../../controller/parametrages.php';
  require_once '../../layout/header.php'; 
  require_once '../../layout/sidebar.php';
  require_once '../../layout/navbar.php';
?>
<div class="content">
  <div class="container-fluid">
    <div class="container">
      <div class="row">
        <div class="col-md-2 flex content-space">
          <button class="btn btn-danger">Enregister</button><span>ou</span> 
          <a href="<?=$base_url?>/pages/parametrages"> Annuler</a>
        </div>
      </div>
      <br>
      <div class="row form-group">
        <div class="col-sm-6">
          <div class="row">
            <div class="col-sm-3">
              <label for="nom">Nom : </label>
            </div>
            <div class="col-sm-9">
              <input type="text" id="nom" name="nom" class="form-control form-control-perso" placeholder="Nom">
            </div>
          </div>
        </div>

        <div class="col-sm-6">
          <div class="row">
            <div class="col-sm-3">
              <label for="prenom">Prénom : </label>
            </div>
            <div class="col-sm-9">
              <input type="text" id="prenom" class="form-control form-control-perso" placeholder="Prénom">
            </div>
          </div>
        </div>
      </div>

      <div class="row form-group">
        <div class="col-sm-6">
          <div class="row">
            <div class="col-sm-3">
              <label for="matricule">Numéro Matriculle : </label>
            </div>
            <div class="col-sm-9">
              <input type="text" id="matricule" class="form-control form-control-perso" placeholder="Numéro Matriculle">
            </div>
          </div>
        </div>
        <div class="col-sm-6">
          <div class="row">
            <div class="col-sm-3">
              <label for="contact">Contact : </label>
            </div>
            <div class="col-sm-9">
              <input type="text" id="contact" class="form-control form-control-perso" placeholder="Contact">
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<?php require_once '../../layout/footer.php'; ?>