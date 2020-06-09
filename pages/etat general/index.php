<?php
  include '../../controller/etat.php';
  require_once '../../layout/header.php'; 
  require_once '../../layout/sidebar.php';
  require_once '../../layout/navbar.php';
?>
  <style type="text/css">
    #JodataTable tbody tr td:nth-child(4),
    #JodataTable tfoot tr td:nth-child(4) {
      color: red;
    }
    #JodataTable tfoot {
      background-color: #eee;
    }
  </style>
  <div class="content">
    <div class="container-fluid">
    <div class="search-content">
        <div class="container">
          <div class="row">
   			 <div class="col-sm-2">
   			 	<button class="btn btn-default" id="btn_search"><i class="fa fa-search"></i></button>
         		<button class="btn btn-default" id="btn_print"><i class="fa fa-print"></i></button>
       		</div>
       	</div>
       		<div class="row">
            <div class="col-sm-3"></div>
            <div class="col-sm-5">
              <div class="row form-group">
                <div class="col-sm-5">
                  <label for="type_recherche">Mois de : </label>
                </div>
                <div class="col-sm-7">
                  <select name="type_recherche" id="type_recherche" class="form-control form-control-sm">
                    <option value="janvier">Janvier</option>
                    <option value="fevrier">Février</option>
                    <option value="mars">Mars</option>
                    <option value="avril">Avril</option>
                    <option value="mai">Mai</option>
                    <option value="juin">Juin</option>
                    <option value="juillet">Juillet</option>
                    <option value="aout">Août</option>
                    <option value="septembre">Septembre</option>
                    <option value="octobre">Octobre</option>
                    <option value="novembre">Novembre</option>
                    <option value="decembre">Décembre</option>
                  </select>
                
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
                
                <th>Total</th>
                <th>Payer</th>
                <th>Reste</th>

                <th>Mois</th>

                <th>Action</th>
              </tr>
            </thead>
            <tfoot>
              <tr>
                <td></td>
                <td align="right" id="total_total"></td>
                <td align="right" id="total_payer"></td>
                <td align="right" id="total_reste"></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
              </tr>
            </tfoot>
          </table>
        </div>
      </main>

      <script>
  table = null;

  $(document).ready(function() {
    init_table();
  });



  $('#btn_print').click(() => {
    let type_recherche = $('#type_recherche').val();
    let type_paiement = $('#type_paiement').val();
    let filtrer_par = $('#filtrer_par').val();
    let date_du = $('#date_du').val();
    let date_au = $('#date_au').val();
    window.open(`<?= $base_url ?>/controller/paiements.php?pdf=0&type_recherche=${type_recherche}&type_paiement=${type_paiement}&filtrer_par=${filtrer_par}&date_du=${date_du}&date_au=${date_au}`)
  })

  $('#JoPaginate').change(() => {
    $('#JodataTable').DataTable().page.len($('#JoPaginate').val()).draw();
  })

  $('#search').on( 'keyup', function () {
    table.search( this.value ).draw();
    setTotal()
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

  function setTotal() {
    $('#total_total').html(`${get_total_by_child(2)}Ar`);
    $('#total_payer').html(`${get_total_by_child(3)}Ar`);
    $('#total_reste').html(`${get_total_by_child(4)}Ar`);
  }
  
  function date_formatter(value) {
    const date = new Date(value);
    const monthNames = ["Janvier", "Février", "Mars", "Avril", "Mai", "Juin", "Juillet", "Août", "Septembre", "Octobre", "Novembre", "Décembre"];
    if (!isNaN(date.getDate())) {
      return date.getDate() + " " + monthNames[date.getMonth()] + " " + date.getFullYear();
    }
  }

  function get_total_by_child(nbr_child) {
    let mt_tmp = 0;
    $("#JodataTable tbody tr").each(function() {
      let libelle = $(this).find("td:nth-child(" +nbr_child+ ")").html();
      if (libelle != undefined) {
        let mt = libelle.split(' Ar')[0];
        let nbMt = mt.split("&nbsp;").join('');
        nbMt = nbMt.split(` `).join('');
        mt_tmp += parseInt(nbMt);
      }
    });
    return format_montant(mt_tmp);
  }

  function format_montant(montant) {
    if (isNaN(montant)) {
      return '0';
    }
    let m = parseInt(montant).toLocaleString();
    return m.split(',').join(' ');
  }

  function init_table(url='<?= $base_url ?>/controller/paiements.php?list=0') {
    table = $('#JodataTable').DataTable( {
        "ajax": url,
        "columns": [
            { "data": (data, type, full) => {
							return data.paiement_date_depot !== null ? date_formatter(data.paiement_date_depot) : '-';
						} },
						{ "data": (data, type, full) => {
              return data.paiement_total !== null ? `${format_montant(data.paiement_total)} Ar` : '-';
						} },
						{ "data": (data, type, full) => {
							return data.paiement_montant !== null ? `${format_montant(data.paiement_montant)} Ar` : '-';
						} },
						{ "data": (data, type, full) => {
							let montant = format_montant(data.paiement_total - data.paiement_montant);
							return `${montant} Ar`;
						} },
						{ "data": (data, type, full) => {
							return data.type !== undefined ? `${data.type}` : '-';
						} },
						{ "data": (data, type, full) => {
							return data.mode !== undefined ? `${data.mode}` : '-';
						} },
						{ "data": (data, type, full) => {
							return data.paiement_num_tranche !== null ? `${data.paiement_num_tranche}` : '-';
						} },
						{ "data": (data, type, full) => {
							return data.paiement_mois !== null ? `${data.paiement_mois}` : '-';
						} },
            { "data": (data, type, full) => {
              return `${data.eleve_matricule}`;
            } },
            { "data": (data, type, full) => {
              return `${data.eleve_nom} ${data.eleve_prenom}`;
            } },
            { "data": (data, type, full) => {
							let html = ``;
              for (var i = 0; i < data.classe.length; i++) {
                let cl = data.classe[i];
                html += `${cl.classe} ${cl.categorie!=0?cl.categorie:''} ${cl.mention!=null?cl.mention:''} (${cl.session!=null?cl.session:'Aucun'})<br>`;
              }
              return html;
						} },
            {
              "data": (data, type, full) => {
                return data.paiement_id !== null ? `
                  <div class="flex content-space">
                    <a href="javascript:void(0)" onclick="onViewEleve(${data.paiement_id})">Aperçu</a>
                    <a href="javascript:void(0)" onclick="delete_paiement(${data.paiement_id})"><i class="fa fa-trash text-danger"></i></a>
                  </div>
                ` : '<div class="text-danger">Aucun aperçu</div>';
              }
            }
    		],
    		'columnDefs': [
    			{ "targets": 0, "className": "text-center" },
    			{ "targets": 1, "className": "text-right" },
    			{ "targets": 2, "className": "text-right" },
    			{ "targets": 3, "className": "text-right" },
    			{ "targets": 6, "className": "text-center", "width": "2%" },
    			{ "targets": 11, "className": "text-center", "width": "2%" },
        ],
         "initComplete": function (settings, json) {
            setTotal();
          }
      });
    init_page_info()
  }
  function onViewEleve(paiement_id) {
    $.ajax({
      url: `<?= $base_url ?>/controller/paiements.php`,
      type: 'get',
      data: { list: 0, paiement_id },
      success: (res) => {
        data = res.data[0];
        console.log(data); 
        let html = `
        <div class="container" align="left">
        <div class="row">
          <div class="col-sm-4">
            <img src="<?=$base_url?>/resources/eleves/${data.eleve_photo}" height="80px">
          </div>
          <div class="col-sm-8" align="right">
            <h4>${data.eleve_nom} ${data.eleve_prenom}</h4>
            <div><u>Numero matricule</u>: ${data.eleve_matricule}</div> 
            <h7><u>Adresse </u></h7>:${data.eleve_adresse}<br>
            <h7><u>Date de naissance</u></h7> : ${data.eleve_date_naissance} <hr>
          </div>
        </div>
          
          <div><u><i>Mode de paiement</u></i> :<b>${data.mode} </b></div>
          <div><u><i>status de paiement</u></i> :<b>${data.status}</b></div>
          <div><u><i>Type de paiement</u></i> :<b>${data.type}</b></div>
          <div><u><i>Reçu numéro</u></i> :<b>${data.paiement_numero_recu}</b></div>
          <div><u><i>Date Reçu</u></i> :<b> ${date_formatter(data.paiement_date_recu)}</b></div>
          <div><u><i>Date d'inscription</u></i> :<b>${date_formatter(data.eleve_date_inscription)}</b></div>
          <div><u><i>Observation</u><i> :${data.paiement_commentaire==null?'':data.paiement_commentaire}</div>

          <div><u><i>Montant payer</u></i>:<b> ${format_montant(data.paiement_montant)} Ar</b></div>
          
        </div>
        </div>
          
          <div><b><u>Montant payer</u></i>:</b> ${format_montant(data.paiement_montant)} Ar</div>
        </div>
        `;
        Swal.fire({
          html,
          showCloseButton: true,
          showCancelButton: false,
          showConfirmButton: false,
          padding: '2rem',
          width: '50%',
        })
      }
    })
    
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