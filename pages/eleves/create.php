<?php
  include '../../controller/eleves.php';
  require_once '../../layout/header.php'; 
  require_once '../../layout/sidebar.php';
  require_once '../../layout/navbar.php';
?>
<div class="content">
  <div class="container-fluid">
    <div class="container">
      <form method="post" enctype="multipart/form-data" id="form_eleve">
        <?= $data_eleve ? '
        <input type="text" name="id" value="'.$data_eleve->eleve_id.'" hidden="true">
        <input type="text" name="last_picture" value="'.$data_eleve->eleve_photo.'" hidden="true">
        ' :'' ?>
        <div class="row">
          <div class="col-md-2 flex content-space">
            <a href="javascript:void(0)" id="submit_eleve" class="btn btn-danger"><?= $data_eleve && !array_key_exists('error', $_SESSION) ? 'Modifier' :'Enregister'?></a>&nbsp;  <span>ou</span>&nbsp;  
            <a href="./">Annuler</a>
          </div>
        </div>
        <br>
        <main>
          <div class="row form-group">
            <div class="col-sm-1">
              <label for="photo">Photo</label>
            </div>
            <div class="col-sm-3">
              <div class="input-group">
                <input type="file" value="<?= $data_eleve ? $data_eleve->eleve_photo :'' ?>" class="form-control form-control-sm" id="photo" name="photo"><br>
              </div>
              <div class="text-danger" id="error_photo"></div>
            </div>
            <div class="col-sm-1">
              <label for="date_inscription">Date d'inscription<strong class="text-danger">*</strong></label>
            </div>
            <div class="col-sm-3">
              <div class="input-group">
                <div class="input-group-prepend">
                  <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                </div>
                <input type="date" name="date_inscription" value="<?= $data_eleve ? $data_eleve->eleve_date_inscription :'' ?>" class="form-control form-control-sm" id="date_inscription" data-inputmask-alias="datetime" data-inputmask-inputformat="dd/mm/yyyy" data-mask="" im-insert="false">
              </div>
              <div class="text-danger" id="error_date_inscription"></div>
            </div>
          </div>
          <div class="row form-group">
            <div class="col-sm-4">
              <div class="row">
                <div class="col-sm-3">
                  <label for="nom">Nom <strong class="text-danger">*</strong></label>
                </div>
                <div class="col-sm-9">
                  <input type="text" name="nom" value="<?= $data_eleve ? $data_eleve->eleve_nom :'' ?>" id="nom" class="form-control form-control-sm " placeholder="Nom">
                  <div class="text-danger" id="error_nom"></div>
                </div>
              </div>
            </div>
            <div class="col-sm-4">
              <div class="row">
                <div class="col-sm-3">
                  <label for="prenom">Prénom  <strong class="text-danger">*</strong></label>
                </div>
                <div class="col-sm-9">
                  <input type="text" name="prenom" value="<?= $data_eleve ? $data_eleve->eleve_prenom :'' ?>" id="prenom" class="form-control form-control-sm " placeholder="Prénom">
                  <div class="text-danger" id="error_prenom"></div>
                </div>
              </div>
            </div>
          </div>
          <div class="row form-group">
            <div class="col-sm-4">
              <div class="row">
                <div class="col-sm-3">
                  <label for="date_naissance">Date de naissance  <strong class="text-danger">*</strong></label>
                </div>
                <div class="col-sm-9">
                  <div class="input-group">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                    </div>
                    <input type="date" name="date_naissance" id="date_naissance" value="<?= $data_eleve ? $data_eleve->eleve_date_naissance :'' ?>" class="form-control form-control-sm" data-inputmask-alias="datetime" data-inputmask-inputformat="dd/mm/yyyy" data-mask="" im-insert="false">
                  </div>
                  <div class="text-danger" id="error_date_naissance"></div>
                </div>
              </div>
            </div>
            <div class="col-sm-4">
              <div class="row">
                <div class="col-sm-3">
                  <label for="adresse">Adresse  <strong class="text-danger">*</strong></label>
                </div>
                <div class="col-sm-9">
                  <input type="text" name="adresse" value="<?= $data_eleve ? $data_eleve->eleve_adresse :'' ?>" id="adresse" class="form-control form-control-sm " placeholder="Adresse">
                  <div class="text-danger" id="error_adresse"></div>
                </div>
              </div>
            </div>
          </div>
          <div class="row form-group">
            <div class="col-sm-1">
              <label for="matricule">Matricule  <strong class="text-danger">*</strong></label>
            </div>
            <div class="col-sm-3">
              <input type="text" name="matricule" value="<?= $data_eleve ? $data_eleve->eleve_matricule :'' ?>" id="matricule" class="form-control form-control-sm " placeholder="Matricule">
              <div class="text-danger" id="error_matricule"></div>
            </div>
            <div class="col-sm-1">
              <label for="numero">Numéro  <strong class="text-danger">*</strong></label>
            </div>
            <div class="col-sm-3">
              <input type="number" name="numero" value="<?= $data_eleve ? $data_eleve->eleve_numero :'' ?>" id="numero" class="form-control form-control-sm " placeholder="Numéro">
              <div class="text-danger" id="error_numero"></div>
            </div>
          </div>
          <div class="row form-group">
            <div class="col-sm-8">
              <label>Liste des classes:</label>
            </div>
          </div>

          <div class="row form-group">
            <div class="col-sm-8">
              <table class="table table-sm table-striped" id="table_classe">
                <thead>
                  <tr class="text-sm">
                    <th>Niveau</th>
                    <th>Catégorie</th>
                    <th>Mention</th>
                    <th>Session</th>
                    <th></th>
                  </tr>
                </thead>
                <tbody id="classe_liste">
                  <tr>
                    <td>
                      <select id="classe" class="form-control form-control-sm">
                        <?php foreach ($all_classe as $i => $classe):?>
                          <option value="<?=$classe['param_id']?>"><?=$classe['param_description']?></option>
                        <?php endforeach; ?>
                      </select>
                    </td>
                    <td>
                      <input type="number" min="0" id="categorie" class="form-control form-control-sm">
                    </td>
                    <td>
                      <select id="mention" class="form-control form-control-sm">
                        <option value="-1"></option>
                        <?php foreach ($all_mention as $i => $mention):?>
                          <option value="<?=$mention['param_id']?>"><?=$mention['param_description']?></option>
                        <?php endforeach; ?>
                      </select>
                    </td>
                    <td>
                      <select name="session" id="session" class="form-control form-control-sm">
                        <option value="-1"></option>
                        <?php foreach ($all_session as $i => $session):
                        ?>
                          <option value="<?=$session['param_id']?>"><?=$session['param_description']?></option>
                        <?php endforeach; ?>
                      </select>
                    </td>
                    <td class="d-flex">
                      <a href="javascript:void(0)" id="check_classe" class="fa fa-check text-success"></a>
                    </td>
                  </tr>
                  <?php if (sizeof($classe_list) != 0): ?>
                      <?php foreach ($classe_list as $i => $c): ?>
                      <tr id="classe_<?=$c['id']?>">
                        <td><?=$c['classe']?></td>
                        <td><?=$c['categorie']?></td>
                        <td><?=$c['mention']?></td>
                        <td><?=$c['session']?></td>
                        <td d-flex>
                          <a href="javascript:void(0)" data-id="<?=$c['id']?>" class="fa text-danger del_classe" onclick="del_classe($(this).attr('data-id'))">&#xf00d;</a>
                        </td>
                      </tr>
                      <?php endforeach;?>
                  <?php endif; ?>
                </tbody>
              </table>
            </div>
          </div>
        </main>
      </form>
    </div>
  </div>
</div>
<script>
  DATA_CLASSE = [];
  $(document).ready(() => {
    <?php if ($classe_data != ''): ?>
      DATA_CLASSE = JSON.parse('<?=$classe_data?>');
    <?php endif ?>
  })

  <?php
    if (array_key_exists('error', $_SESSION)) {
      $error = $_SESSION['error'];
      foreach ($error as $key => $value) {
        echo "$('#". $key ."').html(`". $value ."`);";
      }
    }
  ?>

  $('#check_classe').click(() => {
    let classe = $('#classe option:selected').text();
    let categorie = $('#categorie').val();
    let mention = $('#mention option:selected').text();
    let session = $('#session option:selected').text();
    let date = new Date();
    let id = date.getTime();
    let tmpVal = {
      id,
      classe_param_fk: $('#classe').val(),
      classe_categorie: $('#categorie').val(),
      classe_mention_param_fk: $('#mention').val(),
      classe_session_param_fk: $('#session').val()
    };
    DATA_CLASSE.push(tmpVal);
    let html = `
      <tr id="classe_${id}">
        <td>${classe}</td>
        <td>${categorie}</td>
        <td>${mention}</td>
        <td>${session}</td>
        <td d-flex>
          <a href="javascript:void(0)" class="fa text-danger" data-id="${id}" onclick="del_classe($(this).attr('data-id'))">&#xf00d;</a>
        </td>
      </tr>
    `;
    $('#classe_liste').append(html);
  })

  function del_classe(row) {
    let e = -1;
    DATA_CLASSE.forEach((el, i) => {
      if (el.id == row) {
        e = i;
      }
    })
    DATA_CLASSE.splice(e, 1);
    $(`#table_classe #classe_${row}`).remove();
    console.log(DATA_CLASSE);
  }

  $('#submit_eleve').click(() => {
    if (DATA_CLASSE.length == 0) {
      $("#table_classe").addClass('table-warning');
      setTimeout(() => {
        $("#table_classe").removeClass('table-warning');
      }, 4000)
      const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 4000,
        timerProgressBar: true,
        onOpen: (toast) => {
          toast.addEventListener('mouseenter', Swal.stopTimer)
          toast.addEventListener('mouseleave', Swal.resumeTimer)
        }
      })

      Toast.fire({
        icon: 'warning',
        title: 'Veuillez ajouter une classe'
      })
      return;
    }
    let classe = JSON.stringify(DATA_CLASSE);
    $('#form_eleve').submit(() => {
      let input = $("<input>")
                   .attr("type", "text")
                   .css('display', 'none')
                   .attr("name", "classe").val(classe);
      let input2 = $("<input>")
                   .attr("type", "hidden")
                   .css('display', 'none')
                   .attr("name", "submit_eleve").val('');
      $('#form_eleve').append($(input));
      $('#form_eleve').append($(input2));
    });
    $('#form_eleve').submit();
  })
</script>
<?php require_once '../../layout/footer.php'; ?>