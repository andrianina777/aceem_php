<?php
  include '../../controller/utilisateurs.php';
  require_once '../../layout/header.php'; 
  require_once '../../layout/sidebar.php';
  require_once '../../layout/navbar.php';
?>
  <div class="content">
    <div class="container-fluid">
        <div class="container">
          <div class="row">
            <div class="col-md-12">
              <button class="btn btn-danger">Enregister</button>
            </div>
          </div>
        </div>
    </div>
  </div>

<div class="container">
  <div class="row">
    <div class="col-lg-4">
      <form>
        <div class="form-group">
          <label>Email : </label>
          <input type="text" class="form-control">
        </div>
      </form>
    </div>

    <div class="col-lg-4">
      <form>
        <div class="form-group">
          <label>Mot de passe : </label>
          <input type="text" class="form-control">
        </div>
      </div>
      </form>
</div>
</div>
<?php require_once '../../layout/footer.php'; ?>