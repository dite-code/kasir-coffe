<!doctype html>
<html lang="en">
	<head>
		<!-- Required meta tags -->
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		
		<!-- Bootstrap CSS -->
		<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
		
		<title>Pelayan</title>
	</head>
	<body>
		<div class="container">
			<h3 class="text-center">Pilih Meja <?php ?></h3>
			<div class="row m-3">
			<?php 
				$i=1;
				while ($i<=$meja){
				?>
					<div class="col-4 align-self-center">
						<a href="<?= base_url(); ?>index.php/home/meja?no_meja=<?= $i; ?>">
						<button type="button" class="btn <?php if(in_array($i,$mejaAktif)){echo " btn-secondary ";}else{echo " btn-primary ";}?> btn-lg col-12 p-3 m-2">Meja <?php echo $i;?></button>
						</a>
					</div>
				
				<?php 
				$i++;
				}
			?>
			</div>
		</div>
		
		
		
		<!-- Optional JavaScript; choose one of the two! -->
		
		<!-- Option 1: Bootstrap Bundle with Popper -->
		<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js" integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous"></script>
		
		<!-- Option 2: Separate Popper and Bootstrap JS -->
		<!--
		<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.1/dist/umd/popper.min.js" integrity="sha384-SR1sx49pcuLnqZUnnPwx6FCym0wLsk5JZuNx2bPPENzswTNFaQU1RDvt3wT4gWFG" crossorigin="anonymous"></script>
				<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.min.js" integrity="sha384-j0CNLUeiqtyaRmlzUHCPZ+Gy5fQu0dQ6eZ/xAww941Ai1SxSY+0EQqNXNE6DZiVc" crossorigin="anonymous"></script>
			-->
	</body>
</html>