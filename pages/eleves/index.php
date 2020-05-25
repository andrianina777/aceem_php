<?php
  include '../../controller/eleves.php';
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
          <div class="row form-group">
            <div class="col-md-1"></div>
            <div class="col-md-2">
              <label for="description">Type de recherche :</label>
            </div>
            <div class="col-md-5">
              <select id="type_recherche" class="form-control form-control-sm">
                <option value="TOUT">Tout</option>
                <option value="SANS_DOUBLON">Sans doublon</option>
                <option value="AVEC_DOUBLON">Avec doublon</option>
              </select>
            </div>
          </div>
        </div>
      </div>
        
      <main class="row">
        <div class="col-sm-12">
          <table id="JodataTable" class="table table-hover">
            <thead>
              <tr>
                <th>Photo</th>
                <th>Matricule</th>
                <th>Nom et prénom</th>
                <th>Classe</th>
                <th>Session</th>
                <th>Date d'incription</th>
                <th>Action</th>
              </tr>
            </thead>
          </table>
        </div>
      </main>
      <div class="clearfix"></div>
      <select class="form-control form-control-sm col-sm-2" id="JoPaginate">
        <option value="10" selected>10/pages</option>
        <option value="20">20/pages</option>
        <option value="50">50/pages</option>
      </select>
    </div>
  </div>
<script>

  table = null;

  $(document).ready(function() {
    init_table();
  } );

  $('#type_recherche').change((e) => {
    let v = e.target.value;
    table.destroy();
    init_table(`<?= $base_url ?>/controller/eleves.php?list=0&type_recherche=${v}`)
    
  })

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

  function date_formatter(value) {
    const date = new Date(value);
    const monthNames = ["Janvier", "Février", "Mars", "Avril", "Mai", "Juin", "Juillet", "Août", "Septembre", "Octobre", "Novembre", "Décembre"];
    if (!isNaN(date.getDate())) {
      return date.getDate() + " " + monthNames[date.getMonth()] + " " + date.getFullYear();
    }
  }

  function init_table(url='<?= $base_url ?>/controller/eleves.php?list=0') {
    table = $('#JodataTable').DataTable( {
        "ajax": url,
        "columns": [
            { "data": (data, type, full) => {
              if (data.eleve_photo == '-') {
                return `<div align="center"><i class="fa fa-user fa-2x" aria-hidden="true"></i></div>`;
              } else {
                return `<img src="<?=$base_url?>/resources/eleves/${data.eleve_photo}" height="80px">`;
              }
            } },
            { "data": "eleve_matricule" },
            { "data": (data, type, full) => {
              return `${data.eleve_nom} ${data.eleve_prenom}`;
            } },
            { "data": (data, type, full) => {
              let html = ``;
              for (var i = 0; i < data.classe.length; i++) {
                let cl = data.classe[i];
                html += `${cl.classe} ${cl.categorie!=0?cl.categorie:''} ${cl.mention!=null?cl.mention:''}<br>`;
              }
              return html;
            } },
            { "data": (data, type, full) => {
              let html = ``;
              for (var i = 0; i < data.classe.length; i++) {
                let cl = data.classe[i];
                html += `${cl.session}<br>`;
              }
              return html;
            } },
            { "data": (data, type, full) => {
              return date_formatter(data.eleve_date_inscription);
            } },
            {
              "data": function(data, type, full) {
                  let btn = `
                  <div class="flex content-space">
                    <a href="<?=$base_url?>/pages/eleves/create.php?id=${data.eleve_id}"><i class="fa fa-edit"></i></a>
                    <a href="javascript:void(0)" onclick="delete_eleve(${data.eleve_id},'${data.eleve_nom}', '${data.eleve_photo}')"><i class="fa fa-trash text-danger"></i></a>
                  </div>
                  `;
                  return btn;
                }
            }
        ],
        'columnDefs': [
          { "targets": 5, "className": "text-center", "width": "10%" },
          { "targets": 6, "className": "text-center", "width": "2%" },
        ]
    } );
    init_page_info()
  }

  function delete_eleve(eleve_id, eleve_nom, eleve_photo) {
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
          url: '<?=$base_url?>/controller/eleves.php?delete='+ eleve_id,
          type: 'get',
          data: {eleve_nom, eleve_photo},
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