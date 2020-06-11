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
                  <label for="search">Mois de : </label>
                </div>
                <div class="col-sm-7">
                  <select id="search" class="form-control form-control-sm">
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
          </tr>
        </thead>
        <tfoot>
          <tr>
            <td align="right" id="total_total"></td>
            <td align="right" id="total_payer"></td>
            <td align="right" id="total_reste"></td>
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

  $('#JoPaginate').change(() => {
    $('#JodataTable').DataTable().page.len($('#JoPaginate').val()).draw();
  })

  $('#search').on( 'change', function () {
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
              return data.paiement_total !== null ? `${format_montant(data.paiement_total)} Ar` : '-';
						} },
						{ "data": (data, type, full) => {
							return data.paiement_montant !== null ? `${format_montant(data.paiement_montant)} Ar` : '-';
						} },
						{ "data": (data, type, full) => {
							let montant = format_montant(data.paiement_total - data.paiement_montant);
							return `${montant} Ar`;
						} },
            { "data": "paiement_mois" }
    		],
       "initComplete": function (settings, json) {
          setTotal();
        }
      });
    init_page_info()
  }
</script>
<?php require_once '../../layout/footer.php'; ?>