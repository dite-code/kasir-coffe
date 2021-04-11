<?php
	//echo $order_meja->kode_order;
?>
<!doctype html>
<html lang="en">
	<head>
		<!-- Required meta tags -->
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		
		<!-- Bootstrap CSS -->
		<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
		<!-- Font Awesome -->
		<link rel="stylesheet" href="<?= base_url(); ?>assets/bower_components/font-awesome/css/font-awesome.min.css">
		
		<title>Pelayan</title>
	</head>
	<body>
		<nav class="navbar navbar-light bg-light sticky-top">
			<div class="container-fluid">
				<button class="btn btn-outline-warning" onclick="window.history.back()">Kembali</button>
				<form class="d-flex">
					
					<button class="btn btn-outline-success" type="submit">Simpan</button>
				</form>
			</div>
		</nav>
		<div id="keranjang">
			
		</div>
		<ul class="nav nav-tabs" id="myTab" role="tablist">
			<?php
				$i=0; foreach ($get_dataJenisMenu as $row_jns) { ?>
				<li class="nav-item" role="presentation">
					<button class="nav-link <?php if($i==0){echo " active ";}?>" id="<?= $row_jns->id; ?>-tab" data-bs-toggle="tab" data-bs-target="#id-<?= $row_jns->id; ?>" type="button" role="tab" aria-controls="id-<?= $row_jns->id; ?>" aria-selected="true"><?= $row_jns->nama_jenis_menu; ?></button>
				</li>
				
			<?php $i++;} ?>
		</ul>
		<div class="tab-content" id="myTabContent">
			<?php $i=0; foreach ($get_dataJenisMenu as $row_jns) { ?>
				<div class="tab-pane fade <?php if($i==0){echo " show active ";}?>" id="id-<?= $row_jns->id; ?>" role="tabpanel" aria-labelledby="<?= $row_jns->id; ?>-tab">
					<div class="row row-cols-1 row-cols-sm-3 m-3 g-4">
						<?php foreach ($get_dataMenuJoinFoto as $row) { 
							$ttl_harga = @($row->harga_menu - ($row->harga_menu * $row->diskon_menu / 100));
							if ($row_jns->id==$row->id_jenis_menu){
							?>
							
							<div class="col">
								<div class="card">
									<img src="<?= base_url(); ?>assets/img/menu/<?= $row->foto; ?>" class="card-img-top" alt="...">
									<div class="card-body">
										<h5 class="card-title"><?= $row->nama_menu; ?></h5>
									<p class="card-text"><?= number_format($ttl_harga, 0, ',', '.'); ?></li></p>
									<button type="button" class="btn btn-primary btn-lg col-12" onclick="simpanTrans('<?= $row->kode_menu; ?>','<?= $order_meja->kode_order; ?>','<?= $no_meja; ?>')">Tambah</button>
								</div>
							</div>
						</div>
						
						<?php }}?>
				</div>
			</div>
		<?php $i++;} ?>
	</div>
	
	
	<!-- Optional JavaScript; choose one of the two! -->
	
	<!-- Option 1: Bootstrap Bundle with Popper -->
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js" integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous"></script>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	<!-- Option 2: Separate Popper and Bootstrap JS -->
	<!--
		<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.1/dist/umd/popper.min.js" integrity="sha384-SR1sx49pcuLnqZUnnPwx6FCym0wLsk5JZuNx2bPPENzswTNFaQU1RDvt3wT4gWFG" crossorigin="anonymous"></script>
		<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.min.js" integrity="sha384-j0CNLUeiqtyaRmlzUHCPZ+Gy5fQu0dQ6eZ/xAww941Ai1SxSY+0EQqNXNE6DZiVc" crossorigin="anonymous"></script>
	-->
</body>
</html>	

<script>
	load_tbl_menu('<?= $order_meja->kode_order; ?>');
	
	function simpanTrans(kode_menu,kode_order,no_meja) {
        
		var posting = $.post('<?= base_url() ?>index.php/transaksi/Trans_order/insertMenuTrans', {
            kode_order: kode_order,
            kode_menu: kode_menu,
		    no_meja: no_meja
		});
        posting.done(function (data) {
			//alert(data);
			//            $("#tblKeranjang").load(data);
            load_tbl_menu(kode_order);
			//            window.location.reload();
		});
	}
	
	function load_tbl_menu(kode_order) {
        $('#keranjang').load('<?php echo base_url(); ?>index.php/home/ajax_pelayan/' + kode_order);
	}
	
	function editQty(qty, aksi, kode_order, kode_menu) {
        var posting = $.post('<?= base_url() ?>index.php/transaksi/Trans_order/updateQtyEdit', {
            kode_order: kode_order,
            kode_menu: kode_menu,
            aksi: aksi,
            qty: qty
		});
        posting.done(function (data) {
            if (data == 'true') {
                load_tbl_menu(kode_order);
				//                window.location.reload();
				} else {
                alert(data);
			}
		});
	}
	
	</script>				