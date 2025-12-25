<?php
$aM = Arrays_months('th');
$cyc = date('Y');
if (@$_REQUEST['getY'] != '') {
  $cy = $_REQUEST['getY'];
} else {
  $cy = $cyc;
}
?>
<div class="row">
  <div class="col-xs-8">
    <div class="panel">
      <div class="panel-heading">
        <h3 class="panel-title">Counter Page View Chart</h3>
      </div>
      <div class="panel-body" style="min-height: 550px;">
        <div id="statsChart"></div>
      </div>
    </div>
  </div>
  <div class="col-xs-4">
    <div class="panel">
      <div class="panel-heading">
        <h3 class="panel-title">สถิติย้อนหลังในแต่ละเดือน ประจำปี <?php echo $cy; ?></h3>
      </div>
      <div class="panel-body">
        <div>
          <?php for ($iy = 2022; $iy <= $cyc; $iy++) { ?>
            <a href="index.php?getY=<?php echo $iy; ?>" class="btn btn-danger"><?php echo $iy; ?></a>
          <?php } ?>
        </div>
        <table class="table table-striped">
          <thead>
            <tr>
              <th scope="col">เดือน</th>
              <th scope="col">ระบบภายใน</th>
              <th scope="col">หน้าเว็บถูกเปิด</th>
            </tr>
          </thead>
          <tbody>
            <?php
            $interSum = 0;
            $intraSum = 0;

            foreach ($aM as $k => $v) {
              $aCounterInter = func_counter_get($k . '-' . $cy, 'web');
              $aCounterIntra = func_counter_get($k . '-' . $cy, 'admin');
              $inter = isset($aCounterInter['month'][0]) ? $aCounterInter['month'][0] : '<span style="color:#ddd;">0<span>';
              $intra = isset($aCounterIntra['month'][0]) ? $aCounterIntra['month'][0] : '<span style="color:#ddd;">0<span>';

              $interSum = (int)$interSum + (int)$inter;
              $intraSum = (int)$intraSum + (int)$intra;
            ?>
              <tr>
                <td><?php echo $v . ' ' . $cy; ?></td>
                <td><?php echo $intra; ?></td>
                <td><?php echo $inter; ?></td>
              </tr>
            <?php } ?>
            <tr>
              <td></td>
              <td><?php echo $intraSum; ?></td>
              <td><?php echo $interSum; ?></td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
<div class="row">
  <div class="col-xs-12">
    <div class="panel">
      <div class="panel-heading">
        <h3 class="panel-title">จำนวนการเปิดดูในแต่ละหน้า</h3>
      </div>
      <div class="panel-body">
        <table class="table table-striped">
          <thead>
            <tr>
              <th scope="col">Pages</th>
              <?php foreach ($aM as $k => $v) { ?><th scope="col"><?php echo $v; ?></th><?php } ?>
            </tr>
          </thead>
          <tbody>
            <?php
            $year = date('Y');
            $aPages = func_counter_page_get($year);
            foreach ($aPages as $LoopPageName => $vPages) {
            ?>
              <tr>
                <td><?php echo $LoopPageName; ?></td>
                <?php
                foreach ($aM as $k => $v) {
                  $k = $k + 0;
                  $n = @$vPages[$year][$k];
                  $n = ($n > 0) ? $n : '<span style="color:#ddd;">0<span>';
                ?>
                  <td><?php echo $n; ?></td>
                <?php } ?>
              </tr>
            <?php } ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>