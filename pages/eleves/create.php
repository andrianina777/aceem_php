<?php
  include '../../controller/eleves.php';
  require_once '../../layout/header.php'; 
  require_once '../../layout/sidebar.php';
  require_once '../../layout/navbar.php';
?>
<div class="content">
  <div class="container-fluid">
    <div class="container">
      <form method="post" enctype="multipart/form-data">
        <?= $data_eleve ? '<input type="text" name="id" value="'.$data_eleve->eleve_id.'" hidden="true">' :'' ?>
        <div class="row">
          <div class="col-md-2 flex content-space">
            <button type="submit" name="submit_eleve" class="btn btn-danger"><?= $data_eleve ? 'Modifier' :'Enregister'?></button>&nbsp;  <span>ou</span>&nbsp;  
            <a href="./">Annuler</a>
          </div>
        </div>
        <br>
        <main>
          <div class="row form-group">
            <div class="col-sm-4">
              <div class="row">
                <div class="col-sm-3">
                  <label for="nom">Nom:</label>
                </div>
                <div class="col-sm-9">
                  <input type="text" name="nom" value="<?= $data_eleve ? $data_eleve->eleve_nom :'' ?>" id="nom" class="form-control form-control-sm " placeholder="Nom">
                </div>
              </div>
            </div>
            <div class="col-sm-4">
              <div class="row">
                <div class="col-sm-3">
                  <label for="prenom">Prénom:</label>
                </div>
                <div class="col-sm-9">
                  <input type="text" name="prenom" value="<?= $data_eleve ? $data_eleve->eleve_prenom :'' ?>" id="prenom" class="form-control form-control-sm " placeholder="Prénom">
                </div>
              </div>
            </div>
            <div class="col-sm-4">
              <div class="row">
                <div class="col-sm-3">
                  <label for="photo">Photo:</label>
                </div>
                <div class="col-sm-9">
                  <div class="input-group">
                    <input type="file" value="<?= $data_eleve ? $data_eleve->eleve_photo :'' ?>" class="form-control form-control-sm" id="photo" name="photo"><br>
                  </div>
                  <div class="text-danger"></div>
                </div>
              </div>
            </div>
          </div>
          <div class="row form-group">
            <div class="col-sm-4">
              <div class="row">
                <div class="col-sm-3">
                  <label for="date_naissance">Date de naissance:</label>
                </div>
                <div class="col-sm-9">
                  <div class="input-group">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                    </div>
                    <input type="date" name="date_naissance" id="date_naissance" value="<?= $data_eleve ? $data_eleve->eleve_date_naissance :'' ?>" class="form-control form-control-sm" data-inputmask-alias="datetime" data-inputmask-inputformat="dd/mm/yyyy" data-mask="" im-insert="false">
                  </div>
                </div>
              </div>
            </div>
            <div class="col-sm-4">
              <div class="row">
                <div class="col-sm-3">
                  <label for="adresse">Adresse:</label>
                </div>
                <div class="col-sm-9">
                  <input type="text" name="adresse" value="<?= $data_eleve ? $data_eleve->eleve_adresse :'' ?>" id="adresse" class="form-control form-control-sm " placeholder="Adresse">
                </div>
              </div>
            </div>
            <div class="col-sm-4">
              <div class="row">
                <div class="col-sm-3">
                  <label for="matricule">Matricule:</label>
                </div>
                <div class="col-sm-3">
                  <input type="text" name="matricule" value="<?= $data_eleve ? $data_eleve->eleve_matricule :'' ?>" id="matricule" class="form-control form-control-sm " placeholder="Matricule">
                </div>
                <div class="col-sm-3">
                  <label for="numero">Numéro:</label>
                </div>
                <div class="col-sm-3">
                  <input type="number" name="numero" value="<?= $data_eleve ? $data_eleve->eleve_numero :'' ?>" id="numero" class="form-control form-control-sm " placeholder="Numéro">
                </div>
              </div>
            </div>
          </div>
          <div class="row form-group">
            <div class="col-sm-4">
              <div class="row">
                <div class="col-sm-3">
                  <label for="date_inscription">Date d'inscription:</label>
                </div>
                <div class="col-sm-9">
                  <div class="input-group">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                    </div>
                    <input type="date" name="date_inscription" value="<?= $data_eleve ? $data_eleve->eleve_date_inscription :'' ?>" class="form-control form-control-sm" id="date_inscription" data-inputmask-alias="datetime" data-inputmask-inputformat="dd/mm/yyyy" data-mask="" im-insert="false">
                  </div>
                </div>
              </div>
            </div>
            <div class="col-sm-4">
              <div class="row">
                <div class="col-sm-3">
                  <label for="classe">Classe:</label>
                </div>
                <div class="col-sm-3">
                  <select id="classe" name="classe" class="form-control form-control-sm">
                    <?php foreach ($all_classe as $i => $classe):
                      $selected = isset($data_eleve) && $data_eleve->eleve_classe_param_fk==$classe['param_id'] ? 'selected' :'';
                    ?>
                      <option value="<?=$classe['param_id']?>" <?=$selected?>><?=$classe['param_description']?></option>
                    <?php endforeach; ?>
                  </select>
                </div>
                <div class="col-sm-3">
                  <select name="classe_categorie" class="form-control form-control-sm">
                    <option value="-1">Aucun</option>
                    <?php foreach ($all_classe_cat as $i => $cat):
                      $selected = isset($data_eleve) && $data_eleve->eleve_classe_cat_param_fk==$cat['param_id'] ? 'selected' :'';
                    ?>
                      <option value="<?=$cat['param_id']?>" <?=$selected?>><?=$cat['param_description']?></option>
                    <?php endforeach; ?>
                  </select>
                </div>
                <div class="col-sm-3">
                  <select name="classe_mention" class="form-control form-control-sm">
                    <option value="-1">Aucun</option>
                    <?php foreach ($all_mention as $i => $mention):
                      $selected = isset($data_eleve) && $data_eleve->eleve_classe_mention_param_fk==$mention['param_id'] ? 'selected' :'';
                    ?>
                      <option value="<?=$mention['param_id']?>" <?=$selected?>><?=$mention['param_description']?></option>
                    <?php endforeach; ?>
                  </select>
                </div>
              </div>
            </div>
            <div class="col-sm-4">
              <div class="row">
                <div class="col-sm-3">
                  <label for="session">Session:</label>
                </div>
                <div class="col-sm-9">
                  <select name="session" id="session" class="form-control form-control-sm">
                    <?php foreach ($all_session as $i => $session):
                      $selected = isset($data_eleve) && $data_eleve->eleve_classe_session_param_fk==$session['param_id'] ? 'selected' :'';
                    ?>
                      <option value="<?=$session['param_id']?>" <?=$selected?>><?=$session['param_description']?></option>
                    <?php endforeach; ?>
                  </select>
                </div>
              </div>
            </div>
          </div>
<<<<<<< HEAD
        </div>

        <div class="col-sm-6">
          <div class="row">
            <div class="col-sm-3">
              <label for="classe">Catégorie classe :</label>
            </div>
            <div class="col-sm-9">
              <select class="form-control" id="type_classe" name="type_classe"> 
                    <option></option>
                    <option>AM</option>
                    <option>SS</option>
                    <option>TMS</option>
                    <option>SS+TMS</option>
                    <option>AM+SS</option>
                    <option>AM+TMS</option>
                    <option>AM+SS+TMS</option> 
                    <option>L1</option>
                    <option>L2</option>
                    <option>L3</option>
                    <option>M1</option>
                    <option>M2</option>   
              </select>
            </div>
          </div>
        </div>
            
          <div class="col-sm-6">
          <div class="row">
            <div class="col-sm-3">
              <label for="date_inscription">Date de naissance:</label>
            </div>
            <div class="col-sm-9">
              <input type="date" id="date_inscription" class="form-control form-control-perso" placeholder="date_inscription">
            </div>
          </div>
        </div>
               

       <div class="col-sm-6">
          <div class="row">
            <div class="col-sm-3">
              <label for="classe">Catégorie classe 2 :</label>
            </div>
            <div class="col-sm-9">
              <select class="form-control" id="type_classe" name="type_classe"> 
                    <option>1</option>
                    <option>2</option>
                    <option>3</option>
                    <option>4</option>
              </select>
            </div>
          </div>
        </div>

          <div class="col-sm-6">
          <div class="row">
            <div class="col-sm-3">
              <label for="date_inscription">Lieu de naissance:</label>
            </div>
            <div class="col-sm-9">
              <input type="text" id="date_inscription" class="form-control form-control-perso" placeholder="Lieu de naissance">
            </div>
          </div>
        </div>
   </div>
   </div>
=======
        </main>
      </form>
    </div>
>>>>>>> 1fed65e018506502eac504809bb195ef3a08d5b4
  </div>
</div>
<?php require_once '../../layout/footer.php'; ?>