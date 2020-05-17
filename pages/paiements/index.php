<?php
  include '../../controller/paiements.php';
  require_once '../../layout/header.php'; 
  require_once '../../layout/sidebar.php';
  require_once '../../layout/navbar.php';
  
?>
  <div class="content">
    <div class="container-fluid">
      <div class="search-content">
        <div class="container">
          <div class="row">
            <div class="col-sm-1">
              <a href="<?=$base_url?>/pages/paiements/create.php" class="btn btn-danger">Créer</a>
            </div>
            <div class="col-sm-2">
              <button class="btn btn-default" id="btn_search"><i class="fa fa-search"></i></button>
              <button class="btn btn-default" id="btn_print"><i class="fa fa-print"></i></button>
            </div>
            <div class="col-sm-5 form-group">
              <div class="row">
                <div class="col-sm-5">
                  <label for="description">Recherche :</label>
                </div>
                <div class="col-sm-7">
                  <input type="text" id="search" class="form-control form-control-sm">
                </div>
              </div>
            </div>
            <div class="col-sm-4">
              <div class="float-sm-right btn-pagination">
                <span class="page-start">0</span> - <span class="page-end">0</span> / <span class="page-total">0</span>&nbsp; 
                <a href="javascript:void(0)" class="fas fa-arrow-alt-circle-left" onclick="pagePrecedent()"></a>
                <a href="javascript:void(0)" class="fas fa-arrow-alt-circle-right" onclick="pageSuivant()"></a>
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-sm-3"></div>
            <div class="col-sm-5">
              <div class="row form-group">
                <div class="col-sm-5">
                  <label for="type_recherche">Type de recherche :</label>
                </div>
                <div class="col-sm-7">
                  <select name="type_recherche" id="type_recherche" class="form-control form-control-sm">
                    <option value="tout">Tout</option>
                    <option value="deperdition">Déperdition</option>
                    <option value="payer">Payer</option>
                  </select>
                </div>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-sm-3"></div>
            <div class="col-sm-5">
              <div class="row form-group">
                <div class="col-sm-5">
                  <label for="filtrer_par">Filtrer par :</label>
                </div>
                <div class="col-sm-7">
                  <select name="filtrer_par" id="filtrer_par" class="form-control form-control-sm">
                    <option value="tout">Tout</option>
                    <option value="deperdition">Classe</option>
                    <option value="payer">Session</option>
                  </select>
                </div>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-sm-3"></div>
            <div class="col-sm-5">
              <div class="row form-group">
                <div class="col-sm-5">
                  <label for="date_du">Date :</label>
                </div>
                <div class="col-sm-7">
                  <div class="row">
                    <div class="col-sm-6">
                      <input type="date" id="date_du" class="form-control form-control-sm">
                    </div>
                    <div class="col-sm-6">
                      <input type="date" id="date_au" class="form-control form-control-sm">
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
        
      <main class="row">
        <div class="col-sm-12">
          <table id="JodataTable" class="table table-hover">
            <thead>
              <tr>
                <th>Date de dépôt</th>
                <th>Total</th>
                <th>Payer</th>
                <th>Reste</th>
                <th>Type</th>
                <th>Mode</th>
                <th>Matricule</th>
                <th>Nom et prénom</th>
                <th>Classe</th>
                <th>Action</th>
              </tr>
            </thead>
          </table>
        </div>
      </main>
      <div class="clearfix"></div>
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

  $('#btn_search').click(() => {
    let type_recherche = $('#type_recherche').val();
    let filtrer_par = $('#filtrer_par').val();
    let date_du = $('#date_du').val();
    let date_au = $('#date_au').val();
    table.destroy();
    init_table(`<?= $base_url ?>/controller/paiements.php?list=0&type_recherche=${type_recherche}&filtrer_par=${filtrer_par}&date_du=${date_du}&date_au=${date_au}`)
  })

  $('#btn_print').click(() => {
    let type_recherche = $('#type_recherche').val();
    let filtrer_par = $('#filtrer_par').val();
    let date_du = $('#date_du').val();
    let date_au = $('#date_au').val();
    window.open(`<?= $base_url ?>/controller/paiements.php?pdf=0&type_recherche=${type_recherche}&filtrer_par=${filtrer_par}&date_du=${date_du}&date_au=${date_au}`)
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

  function init_table(url='<?= $base_url ?>/controller/paiements.php?list=0') {
    table = $('#JodataTable').DataTable( {
        "ajax": url,
        "columns": [
            { "data": (data, type, full) => {
							return date_formatter(data.paiement_date_depot);
						} },
						{ "data": (data, type, full) => {
							let m = parseInt(data.paiement_total).toLocaleString();
							let montant = m.split(',').join(' ');
							return `${montant} Ar &nbsp;  `;
						} },
						{ "data": (data, type, full) => {
							let m = parseInt(data.paiement_montant).toLocaleString();
							let montant = m.split(',').join(' ');
							return `${montant} Ar &nbsp;  `;
						} },
						{ "data": (data, type, full) => {
							let m = parseInt(data.paiement_total - data.paiement_montant).toLocaleString();
							let montant = m.split(',').join(' ');
							return `<span class="text-danger">${montant} Ar &nbsp;  </span>`;
						} },
						{ "data": (data, type, full) => {
							return `${data.type}`;
						} },
						{ "data": (data, type, full) => {
							return `${data.mode}`;
						} },
						{ "data": (data, type, full) => {
							return `${data.eleve_matricule}`;
						} },
            { "data": (data, type, full) => {
              return `${data.eleve_nom} ${data.eleve_prenom}`;
            } },
            { "data": (data, type, full) => {
							return `${data.classe} ${data.classe_cat!=null?data.classe_cat:''} ${data.mention!=null?data.mention:''}`;
						} },
            {
              "data": function(data, type, full) {
                  let btn = `
                  <div class="flex content-space">
                    <a href="<?=$base_url?>/pages/paiements/create.php?id=${data.paiement_id}"><i class="fa fa-edit"></i></a>
                    <a href="javascript:void(0)" onclick="delete_paiement(${data.paiement_id})"><i class="fa fa-trash text-danger"></i></a>
                  </div>
                  `;
                  return btn;
                }
            }
		],
		'columnDefs': [
			{ "targets": 0, "className": "text-center" },
			{ "targets": 1, "className": "text-right" },
			{ "targets": 2, "className": "text-right" },
			{ "targets": 3, "className": "text-right" },
			{ "targets": 6, "className": "text-center", "width": "5%" },
			{ "targets": 9, "className": "text-center", "width": "2%" },
		]
    } );
    init_page_info()
  }

  function delete_paiement(paiement_id) {
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
          url: '<?=$base_url?>/controller/paiements.php?delete='+ paiement_id,
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