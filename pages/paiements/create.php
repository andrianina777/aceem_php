<?php
  include '../../controller/paiements.php';
  require_once '../../layout/header.php'; 
  require_once '../../layout/sidebar.php';
  require_once '../../layout/navbar.php';
?>
  <style type="text/css">
  main {
    margin-left: 50px; 
  }
</style>
<div class="content">
  <div class="container-fluid">
    <div class="container">
      <form method="post">
        <?= $data_param ? '<input type="text" name="id" value="'.$data_param->param_id.'" hidden="true">' :'' ?>
        <div class="row">
          <div class="col-md-2 flex content-space">
            <button type="submit" name="submit_param" class="btn btn-danger"><?= $data_param ? 'Modifier' :'Enregister'?></button>&nbsp;  <span>ou</span>&nbsp;  
            <a href="<?=$base_url?>/pages/parametrages">Annuler</a>
          </div>
        </div>
        <br>
        <main>
          <div class="row form-group">
            <div class="col-sm-6">
              <div class="row">
                <div class="col-sm-3">
                  <label ncnomfor="nc">NC : </label>
                </div>
                <div class="col-sm-9">
                  <input type="text" ncnomname="nc" value="<?= $data_param ? $data_param->param_table :'' ?>" id="nc" class="form-control form-control-perso" placeholder="NC">
                </div>
              </div>
            </div>
          </div>
          <div class="row form-group">
            <div class="col-sm-6">
              <div class="row">
                <div class="col-sm-3">
                  <label for="nom">Nom :</label>
                </div>
                <div class="col-sm-9">
                  <input type="text" name="nom" value="<?= $data_param ? $data_param->param_sigle :'' ?>" id="nom" class="form-control form-control-perso" placeholder="Nom">
                </div>
              </div>
            </div>
          </div>
          <div class="row form-group">
            <div class="col-sm-6">
              <div class="row">
                <div class="col-sm-3">
                  <label for="prenom">Prénom :</label>
                </div>
                <div class="col-sm-9">
                  <input type="text" name="prenom" value="<?= $data_param ? $data_param->param_valeur :'' ?>" id="prenom" class="form-control form-control-perso" placeholder="Prénom">
                </div>
              </div>
            </div>
          </div>
          <div class="row form-group">
            <div class="col-sm-6">
              <div class="row">
                <div class="col-sm-3">
                  <label for="description">Déscription : </label>
                </div>
                <div class="col-sm-9">
                  <textarea id="description" name="description" class="form-control"><?= $data_param ? $data_param->param_description :'' ?></textarea>
                </div>
              </div>
            </div>
          </div>
          <div class="row form-group">
            <div class="col-sm-6">
              <div class="row">
                <div class="col-sm-3">
                  <label for="ordre">Ordre : </label>
                </div>
                <div class="col-sm-9">
                  <input type="number" min="0" name="ordre" value="<?= $data_param ? $data_param->param_ordre :'' ?>" id="ordre" class="form-control form-control-perso" placeholder="Ordre">
                </div>
              </div>
            </div>
          </div>
        </main>
      </form>
    </div>
  </div>
</div>
<?php require_once '../../layout/footer.php'; ?>

<?php require_once '../../layout/footer.php'; ?>