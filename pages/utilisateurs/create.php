<?php
  include '../../controller/utilisateurs.php';
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
            <div class="col-sm-6">
              <div class="row">
                <div class="col-sm-3">
                  <label for="nom">Nom : </label>
                </div>
                <div class="col-sm-9">
                  <input type="text" name="nom" value="<?= $data_user ? $data_user->utilisateur_nom :'' ?>" id="nom" class="form-control form-control-perso" placeholder="Nom">
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
                  <input type="text" name="pseudo" value="<?= $data_user ? $data_user->utilisateur_pseudo :'' ?>" id="pseudo" class="form-control form-control-perso" placeholder="Pseudo">
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
                  <input type="email" name="email" value="<?= $data_user ? $data_user->utilisateur_email :'' ?>" id="email" class="form-control form-control-perso" placeholder="ex@email.com">
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
                  <select name="groupe" class="form-control">
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
                  <input type="password" name="password" id="password" class="form-control form-control-perso" placeholder="Mot de passe">
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