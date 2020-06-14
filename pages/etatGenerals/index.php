<?php
  include '../../controller/etat.php';
  require_once '../../layout/header.php'; 
  require_once '../../layout/sidebar.php';
  require_once '../../layout/navbar.php';
?>
  <style type="text/css">
    #JodataTable tbody{
      height: 350px;
      overflow: scroll;
    }
  </style>
  <div class="content">
    <div class="container-fluid">
    <div class="search-content">
        <div class="container">
        <div class="row">
   			 <div class="col-sm-2">
         		<button class="btn btn-danger" id="btn_print"><i class="fa fa-print"></i> Imprimer</button>
       		</div>
       	</div>
     </div>
	</div>
</div>
</div>
	 <main class="container row">
    <div class="col-sm-12">
      <table id="JodataTable" class="table table-hover table-sm">
        <thead>
          <tr>
            <th></th>
            <?php foreach ($allMounth as $mounth): ?>
            <th><?=$mounth?></th>  
            <?php endforeach ?>
            <th>Total</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($data as $k => $v):
            $totalT = 0;
			      $totalR = 0;
          ?>
          <tr>
            <td><?=$k?></td>
            <?php for ($month=1; $month <= 12; $month++):
              $total = format_money($v[$month]['total']);
              $reste = format_money($v[$month]['reste']);
              $reste = $reste == 0 ? "0 Ar":"<div class='text-red'>- $reste</div>";
              if (is_numeric($v[$month]['total'])) {
                $totalT += $v[$month]['total'];
              }
              if (is_numeric($v[$month]['reste'])) {
                $totalR += $v[$month]['reste'];
              }
            ?>
            <td>
              <?=$total?><br>
              <?=$reste?>
            </td>
            <?php endfor;
              $totalR = $totalR == 0 ? "0 Ar":"<div class='text-red'>- " . format_money($totalR) . "</div>";
            ?>
            <td><?=format_money($totalT)?><br><?=$totalR?></td>
          </tr>
          <?php endforeach ?>
        </tbody>
      </table>
    </div>
  </main>
<script>
  $('#btn_print').click(() => {
    window.open(`<?=$base_url?>/controller/etat.php?pdf=0`);
  })
</script>
<?php require_once '../../layout/footer.php'; ?>