<?php
  include '../../controller/utilisateurs.php';
  require_once '../../layout/header.php'; 
  require_once '../../layout/sidebar.php';
  require_once '../../layout/navbar.php';
?>
<div class="content">
  <div class="container-fluid">
    <div class="container">
      <form method="post">
        <?= $data_user ? '<input type="text" name="id" value="'.$data_user->utilisateur_id.'" hidden="true">' :'' ?>
        <div class="row">
          <div class="col-md-2 flex content-space">
            <button type="submit" name="submit_user" class="btn btn-danger"><?= $data_user ? 'Modifier' :'Enregister'?></button>&nbsp;  <span>ou</span>&nbsp;  
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
                  <input type="text" name="nom" value="<?= $data_user ? $data_user->utilisateur_nom :'' ?>" id="nom" class="form-control form-control-sm " placeholder="Nom">
                </div>
              </div>
            </div>
            <div class="col-sm-4">
              <div class="row">
                <div class="col-sm-3">
                  <label for="prenom">Prénom:</label>
                </div>
                <div class="col-sm-9">
                  <input type="text" name="prenom" value="<?= $data_user ? $data_user->utilisateur_nom :'' ?>" id="prenom" class="form-control form-control-sm " placeholder="Prénom">
                </div>
              </div>
            </div>
            <div class="col-sm-4">
              <div class="row">
                <div class="col-sm-3">
                  <label for="date_naissance">Date de naissance:</label>
                </div>
                <div class="col-sm-9 input-group">
                    <div class="custom-file">
                      <input type="file" class="custom-file-input">
                      <label class="custom-file-label" for="customFile">Ajouter une image</label>
                    </div>
                  <!-- <div class="input-group">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                    </div>
                    <input type="date" class="form-control form-control-sm" data-inputmask-alias="datetime" data-inputmask-inputformat="dd/mm/yyyy" data-mask="" im-insert="false">
                  </div> -->
                </div>
              </div>
            </div>
          </div>
          <div class="row form-group">
            <div class="col-sm-6">
              <div class="row">
                <div class="col-sm-3">
                  <label for="pseudo">Pseudo : </label>
                </div>
                <div class="col-sm-9">
                  <input type="text" name="pseudo" value="<?= $data_user ? $data_user->utilisateur_pseudo :'' ?>" id="pseudo" class="form-control form-control-sm " placeholder="Pseudo">
                </div>
              </div>
            </div>
          </div>
          <div class="row form-group">
            <div class="col-sm-6">
              <div class="row">
                <div class="col-sm-3">
                  <label for="email">Email : </label>
                </div>
                <div class="col-sm-9">
                  <input type="email" name="email" value="<?= $data_user ? $data_user->utilisateur_email :'' ?>" id="email" class="form-control form-control-sm " placeholder="ex@email.com">
                </div>
              </div>
            </div>
          </div>
          <div class="row form-group">
            <div class="col-sm-6">
              <div class="row">
                <div class="col-sm-3">
                  <label for="email">Groupe : </label>
                </div>
                <div class="col-sm-9">
                  <select name="groupe" class="form-control form-control-sm">
                    <?php foreach($all_group as $key => $value): 
                      $selected = $data_user->utilisateur_groupe_fk==$value['groupe_id'] ? 'selected' :'';
                    ?>
                      <option value="<?=$value['groupe_id']?>" <?=$selected?>><?=$value['groupe_description']?></option>
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
                  <label for="password">Mot de passe : </label>
                </div>
                <div class="col-sm-9">
                  <input type="password" name="password" id="password" class="form-control form-control-sm " placeholder="Mot de passe">
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