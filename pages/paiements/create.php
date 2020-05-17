<?php
  require_once '../../controller/paiements.php';
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
        <?= $data_paiement ? '<input type="text" name="id" value="'.$data_paiement->paiement_id.'" hidden="true">' :'' ?>
        <div class="row">
          <div class="col-md-2 flex content-space">
            <button type="submit" name="submit_paiement" class="btn btn-danger"><?= $data_paiement ? 'Modifier' :'Enregister'?></button>&nbsp;  <span>ou</span>&nbsp;  
            <a href="<?=$base_url?>/pages/paiements">Annuler</a>
          </div>
        </div>
        <br>
        <main>
          <div class="row form-group">
            <div class="col-sm-6">
              <div class="row">
                <div class="col-sm-3">
                  <label for="nc">Matricule<strong class="text-danger">*</strong></label>
                </div>
                <div class="col-sm-9">
                  <input name="matricule" list="all_matricule" value="<?= $data_paiement ? $data_paiement->eleve_matricule :'' ?>" class="form-control form-control-sm" placeholder="Matricule">
                  <datalist id="all_matricule">
                    <?php foreach ($all_eleves as $i => $eleve): ?>
                      <option value="<?=$eleve['eleve_matricule']?>">
                    <?php endforeach; ?>
                  </datalist>
                  <div class="text-danger" id="error_matricule"></div>
                </div>
              </div>
            </div>
          </div>
          <div class="row form-group">
            <div class="col-sm-6">
              <div class="row">
                <div class="col-sm-3">
                  <label for="status_paiement">Statut du paiement</label>
                </div>
                <div class="col-sm-9">
                  <select name="status_paiement" id="status_paiement" class="form-control form-control-sm">
                    <?php foreach ($all_status as $i => $status):
                      $selected = isset($data_paiement) && $data_paiement->paiement_status_param_fk==$status['param_id'] ? 'selected' :'';
                    ?>
                      <option value="<?=$status['param_id']?>" <?=$selected?>><?=$status['param_description']?></option>
                    <?php endforeach; ?>
                  </select>
                </div>
              </div>
            </div>
          </div>
          <div class="row form-group type_complet">
            <div class="col-sm-6">
              <div class="row">
                <div class="col-sm-3">
                  <label for="montant">Montant<strong class="text-danger">*</strong></label>
                </div>
                <div class="col-sm-9">
                  <input type="number" name="montant" value="<?= $data_paiement ? $data_paiement->paiement_montant :'' ?>" id="montant" class="form-control form-control-sm" placeholder="Montant">
                  <div class="text-danger" id="error_montant"></div>
                </div>
              </div>
            </div>
          </div>
          <div class="row form-group type_partiel">
            <div class="col-sm-6">
              <div class="row">
                <div class="col-sm-3">
                  <label for="montant">Montant<strong class="text-danger">*</strong></label>
                </div>
                <div class="col-sm-9">
                  <div class="row">
                    <div class="col-sm-6">
                      <input type="number" name="montant_total" value="<?= $data_paiement ? $data_paiement->paiement_total :'' ?>" id="montant_total" class="form-control form-control-sm" placeholder="Total">
                      <div class="text-danger" id="error_montant_total"></div>
                    </div>
                    <div class="col-sm-6">
                      <input type="number" name="montant_payer" value="<?= $data_paiement ? $data_paiement->paiement_montant :'' ?>" id="montant_payer" class="form-control form-control-sm" placeholder="Payer">
                      <div class="text-danger" id="error_montant_payer"></div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="row form-group">
            <div class="col-sm-6">
              <div class="row">
                <div class="col-sm-3">
                  <label for="type_paiement">Type de paiement<strong class="text-danger">*</strong></label>
                </div>
                <div class="col-sm-9">
                  <select name="type_paiement" id="type_paiement" class="form-control form-control-sm">
                    <?php foreach ($all_types as $i => $type):
                      $selected = isset($data_paiement) && $data_paiement->paiement_type_paiement_param_fk==$type['param_id'] ? 'selected' :'';
                    ?>
                      <option value="<?=$type['param_id']?>" <?=$selected?>><?=$type['param_description']?></option>
                    <?php endforeach; ?>
                  </select>
                </div>
              </div>
            </div>
          </div>
          <div class="row form-group changement_classe">
            <div class="col-sm-6">
              <div class="row">
                <div class="col-sm-3">
                  <label for="classe">Classe<strong class="text-danger">*</strong></label>
                </div>
                <div class="col-sm-9">
                  <div class="row">
                    <div class="col-sm-4">
                      <select id="classe" name="classe" class="form-control form-control-sm">
                        <?php foreach ($all_classe as $i => $classe):
                          $selected = isset($data_paiement) && $data_paiement->eleve_classe_param_fk==$classe['param_id'] ? 'selected' :'';
                        ?>
                          <option value="<?=$classe['param_id']?>" <?=$selected?>><?=$classe['param_description']?></option>
                        <?php endforeach; ?>
                      </select>
                    </div>
                    <div class="col-sm-4">
                      <select name="classe_categorie" class="form-control form-control-sm">
                        <option value="-1">Aucun</option>
                        <?php foreach ($all_classe_cat as $i => $cat):
                          $selected = isset($data_paiement) && $data_paiement->eleve_classe_cat_param_fk==$cat['param_id'] ? 'selected' :'';
                        ?>
                          <option value="<?=$cat['param_id']?>" <?=$selected?>><?=$cat['param_description']?></option>
                        <?php endforeach; ?>
                      </select>
                    </div>
                    <div class="col-sm-4">
                      <select name="classe_mention" class="form-control form-control-sm">
                        <option value="-1">Aucun</option>
                        <?php foreach ($all_mention as $i => $mention):
                          $selected = isset($data_paiement) && $data_paiement->eleve_classe_mention_param_fk==$mention['param_id'] ? 'selected' :'';
                        ?>
                          <option value="<?=$mention['param_id']?>" <?=$selected?>><?=$mention['param_description']?></option>
                        <?php endforeach; ?>
                      </select>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="row form-group changement_classe">
            <div class="col-sm-6">
              <div class="row">
                <div class="col-sm-3">
                  <label for="session">Session<strong class="text-danger">*</strong></label>
                </div>
                <div class="col-sm-9">
                  <select name="session" id="session" class="form-control form-control-sm">
                    <?php foreach ($all_session as $i => $session):
                      $selected = isset($data_paiement) && $data_paiement->eleve_classe_session_param_fk==$session['param_id'] ? 'selected' :'';
                    ?>
                      <option value="<?=$session['param_id']?>" <?=$selected?>><?=$session['param_description']?></option>
                    <?php endforeach; ?>
                  </select>
                </div>
              </div>
            </div>
          </div>
          <div class="row form-group">
            <div class="col-sm-6">
              <div class="row">
                <div class="col-sm-3">
                  <label for="mode_paiement">Mode de paiement<strong class="text-danger">*</strong></label>
                </div>
                <div class="col-sm-9">
                  <select name="mode_paiement" id="mode_paiement" class="form-control form-control-sm">
                    <?php foreach ($all_modes as $i => $mode):
                      $selected = isset($data_paiement) && $data_paiement->paiement_mode_paiement_param_fk==$mode['param_id'] ? 'selected' :'';
                    ?>
                      <option value="<?=$mode['param_id']?>" <?=$selected?>><?=$mode['param_description']?></option>
                    <?php endforeach; ?>
                  </select>
                </div>
              </div>
            </div>
          </div>
          <div class="row form-group">
            <div class="col-sm-6">
              <div class="row">
                <div class="col-sm-3">
                  <label for="commentaire">Commentaire</label>
                </div>
                <div class="col-sm-9">
                  <textarea name="commentaire" id="commentaire" class="form-control"><?= $data_paiement ? $data_paiement->paiement_commentaire :'' ?></textarea>
                </div>
              </div>
            </div>
          </div>
        </main>
      </form>
    </div>
  </div>
</div>
<script>
  <?php
    if (array_key_exists('error', $_SESSION)) {
      $error = $_SESSION['error'];
      foreach ($error as $key => $value) {
        echo "$('#". $key ."').html(`". $value ."`);";
      }
    }
  ?>

  $(document).ready(() => {
    $('.changement_classe').hide();
    $('.type_partiel').hide();
    <?php if (isset($data_paiement)): ?>
      <?php if ($data_paiement->paiement_status_param_fk == $status_complet_id): ?>
        $('.type_complet').show();
        $('.type_partiel').hide();
      <?php else: ?>
        $('.type_complet').hide();
        $('.type_partiel').show();
      <?php endif; ?>
    <?php endif; ?>
    <?php if (isset($data_paiement) && $data_paiement->paiement_type_paiement_param_fk == $changement_classe_id): ?>
      $('.changement_classe').show();
    <?php endif; ?>
  })


  $('#status_paiement').change(() => {
    if ($('#status_paiement').val() == <?=$status_complet_id?>) {
      $('.type_complet').show('slow');
      $('.type_partiel').hide('slow');
    } else {
      $('.type_complet').hide('slow');
      $('.type_partiel').show('slow');
    }
  })

  $('#type_paiement').change(() => {
    if ($('#type_paiement').val() == <?=$changement_classe_id?>) {
      $('.changement_classe').show('slow');
    } else {
      $('.changement_classe').hide('slow');
    }
  })
</script>
<?php require_once '../../layout/footer.php'; ?>