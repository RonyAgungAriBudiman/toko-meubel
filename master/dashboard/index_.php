<div class="row">
	<div class="col-md-4">
		<!-- small box -->
          <div class="small-box bg-aqua" style="margin-bottom:0px">
            <div class="inner">
            	<?php 
              	$sql_rumah = "SELECT COUNT(Blok) AS JmlRumah  FROM ms_rumah
                            WHERE  Blok != '' AND No !='' ";
              	$data_rumah= $sqlLib->select($sql_rumah); ?>							
              <h3><?php echo number_format($data_rumah[0]["JmlRumah"])?></h3>

              <p><?php echo strtoupper("Rumah")?></p>
            </div>
            <div class="icon">
              <i class="fa fa-home"></i>
            </div>
          </div>
          <!-- Widget: user widget style 1 -->
          <div class="box box-widget widget-user-2">
            <div class="box-footer no-padding">
              <ul class="nav nav-stacked">
				<?php
				$sql2 = "SELECT DISTINCT Status FROM ms_rumah WHERE  Blok != '' AND No !='' AND Status Is Not Null	  ";
				$data2 = $sqlLib->select($sql2);
				foreach($data2 as $row2)
				{
					$sql_qty = "SELECT COUNT(Blok) as Jml FROM ms_rumah WHERE Status = '".$row2["Status"]."'";
					$data_qty = $sqlLib->select($sql_qty);
					?>
					<li>
						<a href="#">
							<?php echo $row2["Status"]?> <span class="pull-right badge bg-aqua"><?php echo number_format($data_qty[0]["Jml"])?></span>
						</a>
					</li>
				<?php }?>
              </ul>
            </div>
          </div>
          <!-- /.widget-user -->
	</div>

	<div class="col-md-4">
		<!-- small box -->
          <div class="small-box bg-green" style="margin-bottom:0px">
            <div class="inner">
            	<?php 
              	$sql_warga = "SELECT COUNT(SeqWarga) AS JmlWarga  FROM ms_warga
                            WHERE  Nama != '' ";
              	$data_warga= $sqlLib->select($sql_warga); ?>							
              <h3><?php echo number_format($data_warga[0]["JmlWarga"])?></h3>

              <p><?php echo strtoupper("Warga")?></p>
            </div>
            <div class="icon">
              <i class="fa fa-users"></i>
            </div>
          </div>
          <!-- Widget: user widget style 1 -->
          <div class="box box-widget widget-user-2">
            <div class="box-footer no-padding">
              <ul class="nav nav-stacked">
                <li>
                  <?php
                  $sql_kk = "SELECT COUNT(HubunganKeluarga) AS JmlKK FROM ms_warga WHERE  HubunganKeluarga = 'KEPALA KELUARGA'  ";
                  $data_kk = $sqlLib->select($sql_kk); ?>
                    <a href="#">Jumlah KK<span class="pull-right badge bg-green"><?php echo number_format($data_kk[0]["JmlKK"])?></span></a>
                </li>
        				<?php
        				$sql3 = "SELECT DISTINCT JenisKelamin FROM ms_warga WHERE  Nama != '' AND JenisKelamin !=''	  ";
        				$data3 = $sqlLib->select($sql3);
        				foreach($data3 as $row3)
        				{
        					$sql_jk = "SELECT COUNT(Blok) as Jml FROM ms_warga WHERE JenisKelamin = '".$row3["JenisKelamin"]."'";
        					$data_jk = $sqlLib->select($sql_jk);
        					?>
        					<li>
        						<a href="#">
        							<?php echo $row3["JenisKelamin"]?> <span class="pull-right badge bg-green"><?php echo number_format($data_jk[0]["Jml"])?></span>
        						</a>
        					</li>
        				<?php }?>
              </ul>
            </div>
          </div>
          <!-- /.widget-user -->
	</div>

	<div class="col-md-4 col-sm-6 col-xs-12">
        <div class="info-box bg-yellow">
            <?php 
				$sql_sa = "SELECT Nominal as SaldoAwal FROM ms_opname WHERE Tahun = '".date("Y")."' ";
				$data_sa= $sqlLib->select($sql_sa);

				$sql_ma = "SELECT SUM(Nominal) as Masuk FROM ms_masuk WHERE YEAR(Tanggal) = '".date("Y")."' ";
				$data_ma= $sqlLib->select($sql_ma);

				$sql_ke = "SELECT SUM(Nominal) as Keluar FROM ms_pengeluaran WHERE YEAR(Tanggal) = '".date("Y")."' ";
				$data_ke= $sqlLib->select($sql_ke);

				$kas = $data_sa[0]['SaldoAwal']+$data_ma[0]['Masuk']-$data_ke[0]['Keluar'];

              ?>
            <span class="info-box-icon"><i class="fa fa-money"></i></span>
            <div class="info-box-content">
              <span class="info-box-text">KAS RT</span>
              <span class="info-box-number" >
              <a href="index.php?m=<?php echo acakacak("encode","bendahara/laporankeuangan")?>&p=<?php echo acakacak("encode","laporankeuangan")?>">  
              <h2 style="font-weight: bold;  color: white;">Rp.&nbsp;&nbsp;<?php echo number_format($kas, 0, '.', '.') ?></h2></a></span>

              <div class="progress">
                <div class="progress-bar" style="width: 100%"></div>
              </div>
                  <span class="progress-description">
                    Tahun : <?php echo date("Y");?>
                  </span>
            </div> 
        </div>
        
  </div>
</div>  

<div class="row">
	<div class="col-md-12" style="margin-top:10px">

    <?php
    $dataHasil = "";
    for($i=1; $i<=5; $i++) //1.bayi balita, 2.anak2 3.remaja 4.dewasa 5.lansia
    {
      
      $sql_hasil = "SELECT COUNT(Nama) AS Jml 
                    FROM ms_warga WHERE Nama !='' ";
      if($i=="1") $sql_hasil .= " AND (DATEDIFF( CURDATE(), TanggalLahir ) / 365)<5 ";  
      else if($i=="2") $sql_hasil .= " AND (DATEDIFF( CURDATE(), TanggalLahir ) / 365)>5 AND (DATEDIFF( CURDATE(), TanggalLahir ) / 365)<10 ";  
      else if($i=="3") $sql_hasil .= " AND (DATEDIFF( CURDATE(), TanggalLahir ) / 365)>10 AND (DATEDIFF( CURDATE(), TanggalLahir ) / 365)<19 "; 
      else if($i=="4") $sql_hasil .= " AND (DATEDIFF( CURDATE(), TanggalLahir ) / 365)>19 AND (DATEDIFF( CURDATE(), TanggalLahir ) / 365)<60 ";  
      else if($i=="5") $sql_hasil .= " AND (DATEDIFF( CURDATE(), TanggalLahir ) / 365)>60 "; 
      $data_hasil = $sqlLib->select($sql_hasil);


      if($i=="1")  { $title ="Balita ( 0 < 5 tahun)"; }
      else if($i=="2") {  $title ="Anak-anak ( 5 < 10 tahun)"; }
      else if($i=="3") { $title ="Remaja ( 10 < 19 tahun)"; }
      else if($i=="4") { $title ="Dewasa ( 19 < 60 tahun)"; }
      else if($i=="5") { $title ="Lansia ( >60 tahun)"; }
      
      $label = $title;
      $dataHasil .= "{ label: '" . $label . "', y: " . $data_hasil[0]["Jml"] . " },";


    }
    ?>


    <script>
      window.onload = function() {

        var chart = new CanvasJS.Chart("chartContainer", {
          animationEnabled: true,
          theme: "light",
          title: {
            text: "Data Warga RT 02 Berdasarkan Usia",
            fontFamily: "tahoma",
            fontSize: 20,
          },
          legend: {
            cursor: "pointer",
            verticalAlign: "bottom",
            horizontalAlign: "center",
            itemclick: toggleDataSeries
          },
          axisX: {
            labelFontSize: 12
          },
          data: [{
            type: "column",
            indexLabelFontSize: 14,
            name: "",
            indexLabel: "{y}",
            yValueFormatString: "#,###",
            showInLegend: true,
            dataPoints: [
              <?php echo $dataHasil ?>
            ]
          }]
        });
        chart.render();

        function toggleDataSeries(e) {
          if (typeof(e.dataSeries.visible) === "undefined" || e.dataSeries.visible) {
            e.dataSeries.visible = false;
          } else {
            e.dataSeries.visible = true;
          }
          chart.render();
        }

      }
    </script>

    
    <div style="padding:10px; background-color:#FFF">
      <div id="chartContainer" style="height: 470px; width: 100%"></div>
    </div>
    <div style="background-color:#FFF; position:absolute; margin-top:-30px; height:30px; width:100px;"></div>
    <script src="js/canvasjs.min.js"></script>

  </div>

</div>

