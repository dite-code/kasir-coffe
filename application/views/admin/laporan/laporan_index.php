<?php
	defined('BASEPATH') OR exit('No direct script access allowed');
	$a = $this->session->userdata('is_login');
	echo $javasc;
	$caritanggal = date('Y-m-d');
	$bulan = date('m');
?>
<div class="box ">
	<div class="box-body">
		<center><h2>Laporan Harian</h2></center>
		<form method="get" action="<?= base_url(); ?>index.php/admin/laporan/laporan_html/cetak_lapharian.html">
			<table width="100%" border="0" align="center"  >
				<tr>
					<td width="170" style="padding-bottom:5px;padding-right:10px;text-align:right">Pilih Tanggal Laporan: </td>
					<td width="170" style="padding-bottom:5px;text-align:right">
						<input class="form-control tanggal"	type="date" name="tanggal" value="<?php echo $caritanggal;?>" >
					</td>
					<td style="padding-bottom:5px;padding-left:10px;text-align:left"><button class="btn btn-flat btn-success"><i class="fa fa-search"></i> Lihat</button></td>
				</tr>
			</table>
		</form>
		
	</div>
	<hr>
	<div class="box-body">
		<center><h2>Laporan Bulanan</h2></center>
		<form method="get" action="<?= base_url(); ?>index.php/admin/laporan/laporan_html/cetak_lapbulanan.html">
			<div class="form-row">
				<table width="100%" border="0" align="center"  >
					<tr>
						<td width="170" style="padding-bottom:5px;padding-right:10px;text-align:right">Pilih Bulan Laporan: </td>
						<td width="170" style="padding-bottom:5px;text-align:right">
							<select class="form-control custom-select mr-sm-2" name="bulan">
								<option >Choose...</option>
								<option <?php if($bulan==1){echo "selected";}?> value="1">Januari</option>
								<option <?php if($bulan==2){echo "selected";}?> value="2">Februari</option>
								<option <?php if($bulan==3){echo "selected";}?> value="3">Maret</option>
								<option <?php if($bulan==4){echo "selected";}?> value="4">April</option>
								<option <?php if($bulan==5){echo "selected";}?> value="5">Mei</option>
								<option <?php if($bulan==6){echo "selected";}?> value="6">Juni</option>
								<option <?php if($bulan==7){echo "selected";}?> value="7">Juli</option>
								<option <?php if($bulan==8){echo "selected";}?> value="8">Agustus</option>
								<option <?php if($bulan==9){echo "selected";}?> value="9">September</option>
								<option <?php if($bulan==10){echo "selected";}?> value="10">Oktober</option>
								<option <?php if($bulan==11){echo "selected";}?> value="11">November</option>
								<option <?php if($bulan==12){echo "selected";}?> value="12">Desember</option>
							</select>
						</td>
						<td width="70" style="padding-bottom:5px;text-align:right">
							<input class="form-control" name="tahun" value="<?php echo date('Y');?>" >
						</td>
						<td style="padding-bottom:5px;padding-left:10px;text-align:left"><button class="btn btn-flat btn-success"><i class="fa fa-search"></i> Lihat</button></td>
					</tr>
				</table>
			</div>
		</form>
		
	</div>
	<hr>
	<div class="box-body">
		<center><h2>Laporan Tahunan</h2></center>
		<form method="get" action="<?= base_url(); ?>index.php/admin/laporan/laporan_html/cetak_laptahunan.html">
			<div class="form-row">
				<table width="100%" border="0" align="center"  >
					<tr>
						<td width="170" style="padding-bottom:5px;padding-right:10px;text-align:right">Pilih Bulan Laporan: </td>
						<td width="70" style="padding-bottom:5px;text-align:right">
							<input class="form-control" name="tahun" value="<?php echo date('Y');?>" >
						</td>
						<td style="padding-bottom:5px;padding-left:10px;text-align:left"><button class="btn btn-flat btn-success"><i class="fa fa-search"></i> Lihat</button></td>
					</tr>
				</table>
			</div>
		</form>
	</div>
	
</div>