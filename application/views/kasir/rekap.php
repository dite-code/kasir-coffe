<?php
	defined('BASEPATH') OR exit('No direct script access allowed');
	$a = $this->session->userdata('is_login');
	$msg = $this->session->flashdata('msg');
	$tipe = $this->session->flashdata('tipe');
	$lambang = 'fa-check';
	$notify = 'Sukses!';
	echo $javasc;
	
?>

<div class="box">
	<div class="box-body">
		
		
		<div class="row">
			<div class="col-md-12">
				<div class="table-responsive">
					<table class="tabel_3 table table-bordered table-hover" width="100%">
						<thead>
							<tr>
								<th class="text-center"  width="3%">No</th>
								<th class="text-center"  >Nama Kasir</th>
								<th class="text-center"  >Tanggal</th>
								<th class="text-center"  >Pendapatan</th>
								<th class="text-center"  >Pengeluaran</th>
								<th class="text-center"  >Total Bersih</th>
								<th class="text-center"  width="150"><i class="fa fa-cog"></i></th>
							</tr>
						</thead>
						<tbody>
							<?php
                                $no = 1;
                                $ttl_pemb_sub = 0;
                                $ttl_pemb_all = 0;
                                foreach ($get_rekap as $row) {
								if(($row->id_user == $a['id'])){
								if ($row->ttl_belanja==null){$row->ttl_belanja=0;}
								$total = $row->ttl_pembayaran-$row->ttl_belanja
								?>
								<tr>
									<td class="text-center"><?= $no++; ?></td>
									<td class=""><?= $row->nama_admin; ?></td>
									<td class="text-center"><?= Tgl_indo::indo($row->tanggal) ?></td>
									<td class="text-right"><span class="pull-left">Rp. </span><?= number_format($row->ttl_pembayaran, 2, ',', '.'); ?></td>
									<td class="text-right"><span class="pull-left">Rp. </span><?= number_format($row->ttl_belanja, 2, ',', '.'); ?></td>
									<td class="text-right"><span class="pull-left">Rp. </span><?= number_format($total, 2, ',', '.'); ?></td>
									<td class="text-center">
										<button class="btn btn-sm btn-success" data-toggle="modal" 
										data-target="#aksi_print"
										data-url="<?= base_url(); ?>index.php/admin/laporan/laporan_html/cetak_rekap.html?tanggal=<?= $row->tanggal; ?>&kasir=<?= $row->nama_admin; ?>&pendapatan=<?= $row->ttl_pembayaran; ?>&pengeluaran=<?= $row->ttl_belanja; ?>">
										<i class="fa fa-print"></i> Print</button>
										
									</td>
								</tr>
								<?php
								}}
							?>
						</tbody>
						
					</table>
					
				</div>
			</div>
		</div>
	</div>
</div>
<div class="modal fade" id="aksi_print" role="dialog" aria-labelledby="editlabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-gray-active">
                <button type="button" class="close" id="close-modal"  data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="editlabel"></h4>
			</div>
			<div class="modal-body">
				<iframe 
				src="../sample.pdf" id="myFrame" 
				frameborder="0" style="border:0;" 
                width="100%" height="500">
				</iframe>
			</div>
			<div class="modal-footer bg-gray-active">
				<div class="submit"></div>
			</div>
		</div>
	</div>
</div>

</section>

<script>
	
	
	setInterval(function(){
		var last = "<?= $lasttime;?>";
		var posting = $.post('<?= base_url() ?>index.php/home/ajax_cek_order', {
            last: last
		});
        posting.done(function (data) {
			if (data=="1"){
				$("#notif_order").html("Baranda <span class='badge badge-success'>"+data+" New</span>");
				//alert(last+'ada order baru');
				//window.location.reload(1);
			}
		});
	}, 5000);	
	
	$('#aksi_print').on('show.bs.modal', function (event) {
		var button = $(event.relatedTarget);
		var url = button.data('url');
		//alert(url);
		document.getElementById('myFrame').src = url;
		var objFra = document.getElementById('myFrame');
		//objFra.src = url;
		//objFra.contentWindow.focus();
		//objFra.contentWindow.print();
	});
	
	
	</script>								