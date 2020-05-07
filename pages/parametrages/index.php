<?php
  include '../../controller/parametrages.php';
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
              <a href="<?=$base_url?>/pages/parametrages/create.php">
                <button class="btn btn-danger">Créer</button>
              </a>
            </div>
          </div>
          <div class="row form-group">
            <div class="col-md-1"></div>
            <div class="col-md-2">
              <label for="description">Description :</label>
            </div>
            <div class="col-md-5">
              <input type="text" id="description" class="form-control">
            </div>
          </div>
          <div class="row form-group">
            <div class="col-md-1"></div>
            <div class="col-md-2">
              <label for="table_search">Table :</label>
            </div>
            <div class="col-md-5">
              <select id="table_search" class="form-control">
                <option value="tout">Tout</option>
              </select>
            </div>
          </div>
        </div>
      </div>
      <main>
        
        <div class="card-body">
          <table id="liste_eleve" class="table table-bordered table-hover">
            <thead>
            <tr>
              <th>Table</th>
              <th>Sigle</th>
              <th>Valeur</th>
              <th>Description</th>
              <th>Ordre</th>
              <th>Action</th>
            </tr>
            </thead>
          </table>
        </div>
      </main>
    </div>
  </div>
<script>

  table = null;

  $(document).ready(function() {
    init_table();
  } );

  $('#liste_eleve tbody').on( 'click', 'button', function () {
        var data = table.row( $(this).parents('tr') ).data();
        alert( data[0] +"'s salary is: "+ data[ 5 ] );
  } );

  function init_table(url='<?= $base_url ?>/controller/parametrages.php?list=0') {
    table = $('#liste_eleve').DataTable( {
        "ajax": url,
        "columns": [
            { "data": "param_table" },
            { "data": "param_sigle" },
            { "data": "param_valeur" },
            { "data": "param_description" },
            { "data": "param_ordre" },
            {
              "data": function(data, type, full) {
                  let btn = `
                  <div class="flex content-space">
                    <a href="<?=$base_url?>/pages/parametrages/create.php?id=${data.param_id}"><i class="fa fa-edit"></i></a>
                    <a href="javascript:void(0)" onclick="delete_param(${data.param_id})"><i class="fa fa-trash text-danger"></i></a>
                  </div>
                  `;
                  return btn;
                }
            }
        ]
    } );
  }

  function delete_param(param_id) {
    Swal.fire({
      title: 'Êtes-vous sûre de le supprimer?',
      text: `L'action est irreversible.`,
      confirmButtonText: 'Supprimer',
      cancelButtonText: 'Annuler',
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
    }).then((result) => {
      if (result.value) {
        $.ajax({
          url: '<?=$base_url?>/controller/parametrages.php?delete='+ param_id,
          type: 'post',
          success: (r) => {
            if (r.status === 'success') {
              table.destroy();
              init_table()
              Swal.fire('Supprimer', 'Élement supprimer avec succès.', 'success')
            } else {
              Swal.fire('Erreur', `Une erreur s'est produit, veuillez réessayer!`, 'error');
            }
          },
          error: (error) => {
            console.log(error)
            Swal.fire('Erreur', `Une erreur s'est produit, veuillez réessayer!`, 'error');
          }
        })
      }
    })
  }
</script>
<?php require_once '../../layout/footer.php'; ?>