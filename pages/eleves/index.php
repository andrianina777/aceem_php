<?php
  require_once '../../controller/eleves.php';
  require_once '../../layout/header.php'; 
  require_once '../../layout/sidebar.php';
  require_once '../../layout/navbar.php';
  
?>
  <div class="content">
    <div class="container-fluid">
      <div class="search-content">
        <div class="container">
          <div class="row">
            <div class="col-md-12">
              <a href="<?=$base_url?>/pages/eleves/create.php">
                <button class="btn btn-danger">Créer</button>
              </a>
            </div>
          </div>
          <div class="row form-group">
            <div class="col-md-1"></div>
            <div class="col-md-2">
              <label for="nom_search">Nom :</label>
            </div>
            <div class="col-md-5">
              <input type="text" id="nom_search" class="form-control">
            </div>
          </div>
          <div class="row form-group">
            <div class="col-md-1"></div>
            <div class="col-md-2">
              <label for="matricule_search">Matricule :</label>
            </div>
            <div class="col-md-5">
              <input type="text" id="matricule_search" class="form-control">
            </div>
          </div>
        </div>
      </div>
      <main>
        
        <div class="card-body">
          <table id="liste_eleve" class="table table-bordered table-hover">
            <thead>
            <tr>
              <th>Name</th>
                <th>Position</th>
                <th>Office</th>
                <th>Extn.</th>
                <th>Start date</th>
                <th>Salary</th>
            </tr>
            </thead>
          </table>
        </div>
      </main>
    </div>
  </div>
<script>
  console.log($('#liste_eleve'));
  $(document).ready(function() {
    $('#liste_eleve').DataTable( {
        "ajax": "https://s3-us-west-2.amazonaws.com/s.cdpn.io/730692/json.txt",
        "columns": [
            { "data": "name" },
            { "data": "position" },
            { "data": "office" },
            { "data": "extn" },
            { "data": "start_date" },
            { "data": "salary" }
        ]
    } );
  } );
</script>
<?php require_once '../../layout/footer.php'; ?>