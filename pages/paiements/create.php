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
<div class="content"> <!--Mbola tsy mandeha ilay boutton enregistrer sy annuler amty fa copie coller config io-->
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
                <div class="col-sm-3"></div>
                <div class="col-sm-9 d-flex">
                  <select name="paiement_par" id="paiement_par" class="form-control form-control-sm">
                    <?php foreach ($all_paiement_par as $i => $paiement_par):
                      $selected = isset($data_paiement) && $data_paiement->paiement_par_param_fk==$paiement_par['param_id'] ? 'selected' :'';
                    ?>
                      <option value="<?=$paiement_par['param_id']?>" <?=$selected?>><?=$paiement_par['param_description']?></option>
                    <?php endforeach; ?>
                  </select>
                  <input type="number" name="num_tranche" id="num_tranche" min="0" class="form-control form-control-sm" placeholder="numéro du tranche">
                </div>
              </div>
            </div>
          </div>
          <div class="row form-group">
            <div class="col-sm-6">
              <div class="row">
                <div class="col-sm-3">
                  <label for="nc">NC<strong class="text-danger">*</strong></label>
                </div>
                <div class="col-sm-9">
                  <input type="text" name="nc" id="nc" class="form-control form-control-sm" placeholder="NC">
                  <div class="text-danger" id="error_nc"></div>
                </div>
              </div>
            </div>
          </div>
          <div class="row form-group">
            <div class="col-sm-6">
              <div class="row">
                <div class="col-sm-3">
                  <label for="nc">Nom de l'élève<strong class="text-danger">*</strong></label>
                </div>
                <div class="col-sm-9">
                  <input name="nom_eleve" id="nom_eleve" list="all_eleves" class="form-control form-control-sm" placeholder="Nom et prénom">
                  <datalist id="all_eleves">
                    <?php foreach ($all_eleves as $i => $eleve): ?>
                      <option value="<?=$eleve['eleve_nom']?> <?=$eleve['eleve_prenom']?>">
                    <?php endforeach; ?>
                  </datalist>
                  <div class="text-danger" id="error_matricule"></div>
                </div>
              </div>
            </div>
          </div>
          <!--modif_ajout_num_reçu-->
          <div class="row form-group type_complet">
            <div class="col-sm-6">
              <div class="row">
                <div class="col-sm-3">
                  <label for="montant">Numéro reçu<strong class="text-danger">*</strong></label>
                </div>
                <div class="col-sm-9">
                  <input type="number" name="recu" value="<?= $data_paiement ? $data_paiement->paiement_recu :'' ?>" id="recu" class="form-control form-control-sm" placeholder="Numéro reçu">
                  <div class="text-danger" id="error_recu"></div>
                </div>
              </div>
            </div>
          </div>

          <div class="row form-group">
            <div class="col-sm-6">
              <div class="row">
                <div class="col-sm-3">
                  <label for="nc">Numéro reçu<strong class="text-danger">*</strong></label>
                </div>
                <div class="col-sm-9">
                  <div class="row">
                    <div class="col-sm-6">
                      <input name="numero_recu" id="numero_recu" type="number" min="0" class="form-control form-control-sm" placeholder="N° reçu">
                      <div class="text-danger" id="error_numero_recu"></div>
                    </div>
                    <div class="col-sm-4">
                      <label>Dernière numéro:</label>
                    </div>
                    <div class="col-sm-2"><?=$last_recu?></div>
                  </div>
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
    $('.type_partiel').hide();
    $('#num_tranche').hide();
    <?php if (isset($data_paiement)): ?>
      <?php if ($data_paiement->paiement_status_param_fk == $status_complet_id): ?>
        $('.type_complet').show();
        $('.type_partiel').hide();
      <?php else: ?>
        $('.type_complet').hide();
        $('.type_partiel').show();
      <?php endif; ?>
      <?php if ($data_paiement->paiement_par_param_fk == $paiement_tranche_id): ?>
        $('#num_tranche').show();
      <?php else: ?>
        $('#num_tranche').hide();
      <?php endif; ?>
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
  $('#paiement_par').change(() => {
    if ($('#paiement_par').val() == <?=$paiement_tranche_id?>) {
      $('#num_tranche').show('fast');
    } else {
      $('#num_tranche').hide('fast');
    }
  })
</script>
<?php require_once '../../layout/footer.php'; ?>