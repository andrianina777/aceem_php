<?php
  include '../../controller/groupes.php';
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
        <?= $data_groupe ? '<input type="text" name="id" value="'.$data_groupe->groupe_id.'" hidden="true">' :'' ?>
        <div class="row">
          <div class="col-md-2 flex content-space">
            <button type="submit" name="submit_groupe" class="btn btn-danger"><?= $data_groupe ? 'Modifier' :'Enregister'?></button>&nbsp;  <span>ou</span>&nbsp;  
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
                  <input type="text" name="nom" value="<?= $data_groupe ? $data_groupe->groupe_nom :'' ?>" id="nom" class="form-control form-control-perso" placeholder="Nom">
                </div>
              </div>
            </div>
          </div>
          <div class="row form-group">
            <div class="col-sm-6">
              <div class="row">
                <div class="col-sm-3">
                  <label for="description">Description : </label>
                </div>
                <div class="col-sm-9">
                  <input type="text" name="description" value="<?= $data_groupe ? $data_groupe->groupe_description :'' ?>" id="description" class="form-control form-control-perso" placeholder="Pseudo">
                </div>
              </div>
            </div>
          </div>
        </main>
        <div class="row">
          <div class="col-sm-8">
            <div class="card" style="margin-left: 50px;">
              <div class="card-header">
                <h3 class="card-title">Menus</h3>
                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                    <i class="fas fa-minus"></i></button>
                </div>
              </div>
              <div class="card-body" style="margin-left: 25px;">
                <?php foreach ($all_menus as $key => $menu):
                  $checked = '';
                  foreach ($data_menus as $key => $dm) {
                    if ($dm['privilege_menu_fk'] == $menu['menu_id'] && $dm['privilege_is_active'] == 1) {
                      $checked = 'checked';
                      break;
                    } 
                  }
                ?>
                  <div class="form-group">
                    <div class="custom-control custom-switch custom-switch-off-default custom-switch-on-success">
                      <input type="checkbox" class="custom-control-input" name="menu_<?=$menu['menu_id']?>" id="menu_<?=$menu['menu_id']?>" <?=$checked?>>
                      <label class="custom-control-label" for="menu_<?=$menu['menu_id']?>"><?=$menu['menu_nom']?></label>
                    </div>
                  </div>
                <?php endforeach; ?>
              </div>
            </div>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>
<?php require_once '../../layout/footer.php'; ?>