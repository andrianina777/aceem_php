<?php
  include '../../controller/utilisateurs.php';
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
              <a href="<?=$base_url?>/pages/utilisateurs/create.php">
                <button class="btn btn-danger">Créer</button>
              </a>
              <div class="float-sm-right btn-pagination">
                <span class="page-start">0</span> - <span class="page-end">0</span> / <span class="page-total">0</span>&nbsp; 
                <a href="javascript:void(0)" class="fas fa-arrow-alt-circle-left" onclick="pagePrecedent()"></a>
                <a href="javascript:void(0)" class="fas fa-arrow-alt-circle-right" onclick="pageSuivant()"></a>
              </div>
            </div>
          </div>
          <div class="row form-group">
            <div class="col-md-1"></div>
            <div class="col-md-2">
              <label for="description">Recherche :</label>
            </div>
            <div class="col-md-5">
              <input type="text" id="search" class="form-control form-control-sm">
            </div>
          </div>
        </div>
      </div>
        
       <main class="row">
        <div class="col-sm-12">
          <table id="JodataTable" class="table table-hover">
            <thead>
              <tr>
                <th>Nom</th>
                <th>Pseudo</th>
                <th>Email</th>
                <th>Action</th>
              </tr>
            </thead>
          </table>
        </div>
      </main>

      <select class="form-control form-control-sm col-sm-2" id="JoPaginate">
        <option value="10" selected>10 affichés</option>
        <option value="20">20 affichés</option>
        <option value="50">50 affichés</option>
      </select>
    </div>
  </div>
<script>

  table = null;

  $(document).ready(function() {
    init_table();
  } );

  $('#JoPaginate').change(() => {
    $('#JodataTable').DataTable().page.len($('#JoPaginate').val()).draw();
  })

  $('#search').on( 'keyup', function () {
    table.search( this.value ).draw();
    init_page_info()
  } );

  function init_page_info() {
    table.on('draw', () => {
      let tInfo = table.page.info();
      $('.page-start').html(tInfo.start + 1) 
      $('.page-end').html(tInfo.end) 
      $('.page-total').html(tInfo.recordsDisplay) 
      $('body .odd .dataTables_empty').html('Aucun résultat trouvé')
    })
  }

  function init_table(url='<?= $base_url ?>/controller/utilisateurs.php?list=0') {
    table = $('#JodataTable').DataTable( {
        "ajax": url,
        "columns": [
            { "data": "utilisateur_nom" },
            { "data": "utilisateur_pseudo" },
            { "data": "utilisateur_email" },
            {
              "data": function(data, type, full) {
                  let btn = `
                  <div class="flex content-space">
                    <a href="<?=$base_url?>/pages/utilisateurs/create.php?id=${data.utilisateur_id}"><i class="fa fa-edit"></i></a>
                    <a href="javascript:void(0)" onclick="delete_param(${data.utilisateur_id}, '${data.utilisateur_pseudo}')"><i class="fa fa-trash text-danger"></i></a>
                  </div>
                  `;
                  return btn;
                }
            }
        ],
        'columnDefs': [
          { "targets": 3, "className": "text-center", "width": "2%" },
        ]
    } );
    init_page_info()
  }

  function delete_param(user_id, utilisateur_pseudo) {
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
          url: '<?=$base_url?>/controller/utilisateurs.php?delete='+ user_id,
          type: 'get',
          data: {utilisateur_pseudo},
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