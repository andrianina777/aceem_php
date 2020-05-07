<?php
  include '../../controller/eleves.php';
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
  <div class="row form-group">
    <div class="col-sm-6">
          <label for="nom">Nom</label>
          <input type="text" id="nom" name="nom" class="form-control" placeholder="Nom">
   </div>
  </div>

   <div class="col-sm-6">
      <form>
        <div class="form-group">
          <label>Prénom</label>
          <input type="text" class="form-control" placeholder="Prénom">
        </div>
      </div>
      </form>
  </div>


<div class="row">
<div class="col-sm-6">
      <form>
        <div class="form-group">
          <label>Numéro Matriculle</label>
          <input type="text" class="form-control" placeholder="Numéro Matriculle">
        </div>
      </form>
    </div>

    <div class="col-sm-6">
      <form>
        <div class="form-group">
          <label>Contact</label>
          <input type="text" class="form-control" placeholder="Contact">
        </div>
      </div>
      </form>

</div>
</div>

<?php require_once '../../layout/footer.php'; ?>