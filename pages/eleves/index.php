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
            <div class="col-sm-1">
              <a href="<?=$base_url?>/pages/eleves/create.php" class="btn btn-danger">Créer</a>
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
                  <input type="text" id="search" class="form-control form-control-sm" placeholder="NC, matricule, nom, ...">
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
                    <option value="TOUT">Tout</option>
                    <option value="SANS_DOUBLON">Sans doublon</option>
                    <option value="AVEC_DOUBLON">Avec doublon</option>
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
                  <select id="filtrer_par" class="form-control form-control-sm">
                    <option value="TOUT">Tout</option>
                    <option value="CLASSE">Classe</option>
                    <option value="SESSION">Session</option>
                    <option value="MENTION">Mention</option>
                    <option value="NC">NC</option>
                  </select>
                </div>
              </div>
            </div>
          </div>
          <div class="row" id="nc_group">
            <div class="col-sm-3"></div>
            <div class="col-sm-5">
              <div class="row form-group">
                <div class="col-sm-5">
                  <label for="nc">NC :</label>
                </div>
                <div class="col-sm-7">
                  <input type="text" id="nc" class="form-control form-control-sm" placeholder="NC">
                </div>
              </div>
            </div>
          </div>
          <div class="row" id="classe_group">
            <div class="col-sm-3"></div>
            <div class="col-sm-5">
              <div class="row form-group">
                <div class="col-sm-5">
                  <label for="classe">Classe :</label>
                </div>
                <div class="col-sm-7">
                  <select id="classe" class="form-control form-control-sm">
                    <?php foreach ($all_classe as $i => $classe):?>
                      <option value="<?=$classe['param_id']?>"><?=$classe['param_description']?></option>
                    <?php endforeach; ?>
                  </select>
                </div>
              </div>
            </div>
          </div>
          <div class="row" id="mention_group">
            <div class="col-sm-3"></div>
            <div class="col-sm-5">
              <div class="row form-group">
                <div class="col-sm-5">
                  <label for="mention">Mention :</label>
                </div>
                <div class="col-sm-7">
                  <select id="mention" class="form-control form-control-sm">
                    <?php foreach ($all_mention as $i => $mention):?>
                      <option value="<?=$mention['param_id']?>"><?=$mention['param_description']?></option>
                    <?php endforeach; ?>
                  </select>
                </div>
              </div>
            </div>
          </div>
          <div class="row" id="session_group">
            <div class="col-sm-3"></div>
            <div class="col-sm-5">
              <div class="row form-group">
                <div class="col-sm-5">
                  <label for="session">Session :</label>
                </div>
                <div class="col-sm-7">
                  <select id="session" class="form-control form-control-sm">
                    <?php foreach ($all_session as $i => $session):?>
                      <option value="<?=$session['param_id']?>"><?=$session['param_description']?></option>
                    <?php endforeach; ?>
                  </select>
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
                <th>Photo</th>
                <th>NC</th>
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
    $('#classe_group').hide();
    $('#session_group').hide();
    $('#mention_group').hide();
    $('#nc_group').hide();
    init_table();
  });

  $('#type_recherche').change((e) => {
    let v = e.target.value;
    table.destroy();
    init_table(`<?= $base_url ?>/controller/eleves.php?list=0&type_recherche=${v}`)
  })

  $('#filtrer_par').change((e) => {
    let v = e.target.value;
    switch (v) {
      case 'CLASSE':
        $('#session_group').slideUp()
        $('#mention_group').slideUp()
        $('#nc_group').slideUp()
        $('#classe_group').slideDown('slow')
        break;
      case 'SESSION':
        $('#classe_group').slideUp()
        $('#mention_group').slideUp()
        $('#nc_group').slideUp()
        $('#session_group').slideDown('slow')
        break;
      case 'MENTION':
        $('#session_group').slideUp()
        $('#classe_group').slideUp()
        $('#nc_group').slideUp()
        $('#mention_group').slideDown('slow')
        break;
      case 'NC':
        $('#session_group').slideUp()
        $('#classe_group').slideUp()
        $('#mention_group').slideUp()
        $('#nc_group').slideDown('slow')
        break;
      case 'TOUT':
        $('#classe_group').slideUp();
        $('#session_group').slideUp();
        $('#mention_group').slideUp();
        $('#nc_group').slideUp()
        break;
    }
  })
  
  $('#btn_search').click(() => {
    let {v, p} = getSearchVal();
    table.destroy();
    init_table(`<?= $base_url ?>/controller/eleves.php?list=0&filtrer_par=${v}&param=${p}`)
  })
  
  $('#btn_print').click(() => {
    let {v, p} = getSearchVal();
    window.open(`<?= $base_url ?>/controller/eleves.php?pdf=0&filtrer_par=${v}&param=${p}`)
  })

  $('#JoPaginate').change(() => {
    $('#JodataTable').DataTable().page.len($('#JoPaginate').val()).draw();
  })

  $('#search').on( 'keyup', function () {
    table.search( this.value ).draw();
    init_page_info()
  });

  function getSearchVal() {
    let v = $('#filtrer_par').val();
    let p = -1;
    switch (v) {
      case 'CLASSE':
        p = $('#classe').val();
        break;
      case 'SESSION':
        p = $('#session').val();
        break;
      case 'MENTION':
        p = $('#mention').val();
        break;
      case 'NC':
        p = $('#nc').val(); 
        break;
    }
    return {v, p};
  }

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
            { "data": "eleve_nc" },
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