<?php
  require_once '../../controller/paiements.php';
  require_once '../../layout/header.php'; 
  require_once '../../layout/sidebar.php';
  require_once '../../layout/navbar.php';
?>
<style type="text/css">
  .resumer:nth-child(1) {
    text-align: left;
  }
</style>
<div class="content">
  <div class="container-fluid">
    <div class="container">
      <form method="post" id="form_paiement">
        <?= $data_paiement ? '<input type="text" name="id" value="'.$data_paiement->paiement_id.'" hidden="true">' :'' ?>
        <input type="hidden" name="submit_paiement" value="1" hidden="true">
        <div class="d-flex toolbtn">
          <div id="submit_paiement" class="btn btn-danger btn-sm"><?= $data_paiement ? 'Modifier' :'Enregistrer'?></div>&nbsp; <small>ou</small>&nbsp;
          <a href="<?=$base_url?>/pages/paiements">Annuler</a>
        </div>
        <br>
        <main>
          <div class="row">
            <div class="col-6">
              <div class="row form-group form-group-sm">
                <div class="offset-3 col-9 d-flex">
                  <select name="paiement_par" id="paiement_par" class="form-control form-control-sm">
                    <?php foreach ($all_paiement_par as $i => $paiement_par):
                      $selected = isset($data_paiement) && $data_paiement->paiement_par_param_fk==$paiement_par['param_id'] ? 'selected' :'';
                    ?>
                      <option value="<?=$paiement_par['param_id']?>" <?=$selected?>><?=$paiement_par['param_description']?></option>
                    <?php endforeach; ?>
                  </select>
                  <input type="number" name="num_tranche" id="num_tranche" min="0" class="form-control form-control-sm" placeholder="numéro du tranche">
                  <select name="mois" id="mois" class="form-control form-control-sm">
                    <?php foreach (getAllMounth() as $v): ?>
                      <option value="<?=$v?>"><?=$v?></option>
                    <?php endforeach; ?>
                  </select>
                </div>
              </div>
              <div class="row form-group form-group-sm">
                <div class="col-3">
                  <label for="nc">NC <strong class="text-danger">*</strong></label>
                </div>
                <div class="col-9">
                  <div class="d-flex">
                    <input name="nc" id="nc" class="form-control form-control-sm" placeholder="NC">
                    <a href="javascript:void(0)" class="btn btn-sm btn-default" id="checkEleve"><i class="fa fa-eye"></i></a>
                  </div>
                  <div class="text-danger" id="error_nom_eleve"></div>
                </div>
              </div>
              <div class="row form-group form-group-sm">
                <div class="col-3">
                  <label for="date_recu">Date du reçu<strong class="text-danger">*</strong></label>
                </div>
                <div class="col-9">
                  <input name="date_recu" id="date_recu" type="date" class="form-control form-control-sm">
                  <div class="text-danger" id="error_date_recu"></div>
                </div>
              </div>
              <div class="row form-group form-group-sm">
                <div class="col-3">
                  <label for="nc">Numéro reçu<strong class="text-danger">*</strong></label>
                </div>
                <div class="col-9">
                  <div class="row">
                    <div class="col-6">
                      <input name="numero_recu" id="numero_recu" type="text" class="form-control form-control-sm" placeholder="N° reçu">
                      <div class="text-danger" id="error_numero_recu"></div>
                    </div>
                    <div class="col-6"><input type="text" value="<?=$last_recu?>" class="form-control form-control-sm" disabled></div>
                  </div>
                </div>
              </div>
              <div class="row form-group form-group-sm">
                <div class="col-3">
                  <label for="status_paiement">Statut du paiement</label>
                </div>
                <div class="col-9">
                  <select name="status_paiement" id="status_paiement" class="form-control form-control-sm">
                    <?php foreach ($all_status as $i => $status):
                      $selected = isset($data_paiement) && $data_paiement->paiement_status_param_fk==$status['param_id'] ? 'selected' :'';
                    ?>
                      <option value="<?=$status['param_id']?>" <?=$selected?>><?=$status['param_description']?></option>
                    <?php endforeach; ?>
                  </select>
                </div>
              </div>
              <div class="row form-group form-group-sm type_complet">
                <div class="col-3">
                  <label for="montant">Montant<strong class="text-danger">*</strong></label>
                </div>
                <div class="col-9">
                  <input type="number" name="montant" value="<?= $data_paiement ? $data_paiement->paiement_montant :'' ?>" id="montant" class="form-control form-control-sm" placeholder="Montant">
                  <div class="text-danger" id="error_montant"></div>
                </div>
              </div>
              <div class="row form-group form-group-sm type_partiel">
                <div class="col-3">
                  <label for="montant">Montant<strong class="text-danger">*</strong></label>
                </div>
                <div class="col-9">
                  <div class="row">
                    <div class="col-6">
                      <input type="number" name="montant_total" value="<?= $data_paiement ? $data_paiement->paiement_total :'' ?>" id="montant_total" class="form-control form-control-sm" placeholder="Total">
                      <div class="text-danger" id="error_montant_total"></div>
                    </div>
                    <div class="col-6">
                      <input type="number" name="montant_payer" value="<?= $data_paiement ? $data_paiement->paiement_montant :'' ?>" id="montant_payer" class="form-control form-control-sm" placeholder="Payer">
                      <div class="text-danger" id="error_montant_payer"></div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="row form-group form-group-sm">
                <div class="col-3">
                  <label for="type_paiement">Type de paiement<strong class="text-danger">*</strong></label>
                </div>
                <div class="col-9 d-flex">
                  <select name="type_paiement" id="type_paiement" class="form-control form-control-sm">
                    <option value="SIMPLE">Simple</option>
                    <option value="DIVERS">Divers</option>
                  </select>
                  <select name="type_paiement_simple" id="type_paiement_simple" class="form-control form-control-sm">
                    <?php foreach ($all_types_simple as $i => $type):
                      $selected = isset($data_paiement) && $data_paiement->paiement_type_paiement_param_fk==$type['param_id'] ? 'selected' :'';
                    ?>
                      <option value="<?=$type['param_id']?>" <?=$selected?>><?=$type['param_description']?></option>
                    <?php endforeach; ?>
                  </select>
                  <select name="type_paiement_divers" id="type_paiement_divers" class="form-control form-control-sm hidden">
                    <?php foreach ($all_types_divers as $i => $type):
                      $selected = isset($data_paiement) && $data_paiement->paiement_type_paiement_param_fk==$type['param_id'] ? 'selected' :'';
                    ?>
                      <option value="<?=$type['param_id']?>" <?=$selected?>><?=$type['param_description']?></option>
                    <?php endforeach; ?>
                  </select>
                </div>
              </div>
              <div class="row form-group form-group-sm">
                <div class="col-3">
                  <label for="mode_paiement">Mode de paiement<strong class="text-danger">*</strong></label>
                </div>
                <div class="col-9">
                  <select name="mode_paiement" id="mode_paiement" class="form-control form-control-sm">
                    <?php foreach ($all_modes as $i => $mode):
                      $selected = isset($data_paiement) && $data_paiement->paiement_mode_paiement_param_fk==$mode['param_id'] ? 'selected' :'';
                    ?>
                      <option value="<?=$mode['param_id']?>" <?=$selected?>><?=$mode['param_description']?></option>
                    <?php endforeach; ?>
                  </select>
                </div>
              </div>
              <div class="row form-group form-group-sm">
                <div class="col-3">
                  <label for="commentaire">Observation : </label>
                </div>
                <div class="col-9">
                  <textarea name="commentaire" id="commentaire" class="form-control"><?= $data_paiement ? $data_paiement->paiement_commentaire :'' ?></textarea>
                </div>
              </div>
            </div>
            <div class="col-6 hidden" id="preview">
              <div class="row">
                <div class="col-4 pb-4" id="eleve_photo"></div>
                <div class="col-8 d-flex align-content-center align-items-center p-3">
                  <h5>
                    <span id="eleve_nom"></span>
                    <span id="eleve_prenom" class="pl-1"></span>
                    <span id="eleve_statut" class="pl-1"></span>
                  </h5>
                </div>
              </div>
              <div class="row">
                <div class="col-4 form-group form-group-sm"><label for="eleve_date_inscription">Date d'inscription:</label></div>
                <div class="col-8 form-group">
                  <input type="text" id="eleve_date_inscription" class="form-control form-control-sm" disabled>
                </div>
              </div>
              <div class="row form-group">
                <div class="col-4"><label for="eleve_date_limite">Date fin:</label></div>
                <div class="col-8">
                  <input type="text" id="eleve_date_limite" class="form-control form-control-sm" disabled>
                </div>
              </div>
              <div class="row form-group">
                <div class="col-4"><label for="eleve_matricule">Matricule:</label></div>
                <div class="col-8">
                  <input type="text" id="eleve_matricule" class="form-control form-control-sm" disabled>
                </div>
              </div>
              <div class="row form-group">
                <div class="col-4"><label for="eleve_numero">Numéro:</label></div>
                <div class="col-8">
                  <input type="text" id="eleve_numero" class="form-control form-control-sm" disabled>
                </div>
              </div>
              <div class="row form-group">
                <div class="col-4 text-danger"><label for="eleve_reste">Montant non payer:</label></div>
                <div class="col-8">
                  <input type="text" id="eleve_reste" class="form-control form-control-sm text-danger text-bold border-danger" disabled>
                </div>
              </div>
              <div class="row">
                <table id="JodataTable" class="table table-sm">
                  <thead>
                    <tr>
                      <th>Classe</th>
                      <th>Catégorie</th>
                      <th>Mention</th>
                      <th>Session</th>
                    </tr>
                  </thead>
                  <tbody id="eleve_classe"></tbody>
                </table>
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
  });
  $('#type_paiement').change((e) => {
    const v = e.target.value;
    if (v === 'SIMPLE') {
      $('#type_paiement_simple').show();
      $('#type_paiement_divers').hide();
    } else if (v === 'DIVERS') {
      $('#type_paiement_divers').show();
      $('#type_paiement_simple').hide();
    }
  });
  $('#checkEleve').click(() => {
    const nc = $('#nc').val();
    if (nc !== '') {
      $.ajax({
        url: `../../controller/eleves.php`,
        type: 'get',
        data: {nc, getOne: ''},
        success: (data) => {
          if (data !== null) {
            $('#eleve_nom').html(data.eleve_nom);
            $('#eleve_prenom').html(data.eleve_prenom);
            $('#eleve_date_inscription').val(date_formatter(data.eleve_date_inscription));
            $('#eleve_date_limite').val(date_formatter(data.eleve_date_limite));
            $('#eleve_matricule').val(data.eleve_matricule);
            $('#eleve_numero').val(data.eleve_numero);
            let statut = `<div class="text-success text-lg-center">(Actif)</div>`;
            const now = new Date();
            const date_limite = new Date(data.eleve_date_limite);
            if ( now.getTime() > date_limite.getTime()) {
              statut = `<div class="text-danger text-lg-center">(Ancien)</div>`;
            }
            $('#eleve_statut').html(statut);
            $('#eleve_reste').val(format_montant(data.reste) + ' Ar');
            $('#eleve_photo').html(`<img src="../../resources/eleves/${data.eleve_photo}" style="width: inherit; border-radius: 3px" alt="${data.eleve_nom}">`);
            let classe = '';
            data.classe.forEach((v) => {
              classe += `<tr><td>${v.classe}</td><td>${v.categorie === '0' ? '' : v.categorie}</td><td>${v.mention}</td><td>${v.session}</td></tr>`;
            });
            $('#eleve_classe').html(classe);
            $('#preview').show('slow');
          } else {
            Swal.fire({
              icon: 'warning',
              title: `Élèves non existant.`
            });
            $('#preview').hide('slow');
          }
        }
      })
    } else {
      Swal.fire({
        icon: 'warning',
        title: `Élèves non existant.`
      });
      $('#preview').hide('slow');
    }
  });
  $('#submit_paiement').click(() => {
    const paiement_par = $('#paiement_par option:selected').text();
    const status_paiement = $('#status_paiement option:selected').text();
    const type_paiement = $('#type_paiement option:selected').text();
    const mode_paiement = $('#mode_paiement option:selected').text();
    const num_tranche = $('#num_tranche').val() !== ''? 'n° '+ $('#num_tranche').val() :'';
    const commentaire = $('#commentaire').val();
    const montant = $('#montant').val();
    const nc = $('#nc').val();
    const date_recu = date_formatter($('#date_recu').val());
    const num_recu = $('#numero_recu').val();

    const html = `
      <div class="resumer">
        <div class="row" style="display:contents;text-align:center;font-weight:bold;">
          <div class="text-success">${paiement_par} ${num_tranche}</div>
        </div>
        <div class="row">
          <div class="col-6">Nc</div>
          <div class="col-6">${nc}</div>
        </div>
        <div class="row">
          <div class="col-6">Date du reçu</div>
          <div class="col-6">${date_recu?date_recu:'<div class="text-danger">Non renseigner</div>'}</div>
        </div>
        <div class="row">
          <div class="col-6">Numéro reçu</div>
          <div class="col-6">${num_recu}</div>
        </div>
        <div class="row">
          <div class="col-6">Statut du paiement</div>
          <div class="col-6">${status_paiement}</div>
        </div>
        <div class="row">
          <div class="col-6">Montant</div>
          <div class="col-6">${montant}</div>
        </div>
        <div class="row">
          <div class="col-6">Type de paiement</div>
          <div class="col-6">${type_paiement}</div>
        </div>
        <div class="row">
          <div class="col-6">Mode de paiement</div>
          <div class="col-6">${mode_paiement}</div>
        </div>
        <div class="row">
          <div class="col-6">Observation</div>
          <div class="col-6">${commentaire}</div>
        </div>
      </div>
    `;

    Swal.fire({
      title: 'Résumer',
      html,
      showCancelButton: true,
      cancelButtonText: 'Annuler',
      confirmButtonText: 'Enregistrer'
    }).then((r) => {
      if (r.value) {
        $('#form_paiement').submit()
      }
    })
  });
  $('#status_paiement').change(() => {
    if ($('#status_paiement').val() == <?=$status_complet_id?> || $('#status_paiement').val() == <?=$status_dpcomplet_id?>) {
      $('.type_complet').show('slow');
      $('.type_partiel').hide('slow');
    } else {
      $('.type_complet').hide('slow');
      $('.type_partiel').show('slow');
    }
  });
  $('#paiement_par').change(() => {
    if ($('#paiement_par').val() == <?=$paiement_tranche_id?>) {
      $('#mois').val('');
      $('#mois').hide();
      $('#num_tranche').slideDown();
    } else {
      $('#num_tranche').val('');
      $('#num_tranche').hide();
      $('#mois').slideDown();
    }
  });
  function date_formatter(value) {
    const date = new Date(value);
    const monthNames = ["Janvier", "Février", "Mars", "Avril", "Mai", "Juin", "Juillet", "Août", "Septembre", "Octobre", "Novembre", "Décembre"];
    if (!isNaN(date.getDate())) {
      return date.getDate() + " " + monthNames[date.getMonth()] + " " + date.getFullYear();
    }
  }
  function format_montant(montant) {
    if (isNaN(montant)) {
      return '0';
    }
    const m = parseInt(montant).toLocaleString().split(',').join(' ');
    return m;
  }
</script>
<?php require_once '../../layout/footer.php'; ?>
