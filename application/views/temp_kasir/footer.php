
<div class="modal fade" id="aksi_serah_trima" role="dialog" aria-labelledby="editlabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-gray-active">
				Serah Terima
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title"></h4>
			</div>
			<div class="modal-body">
				<div class="mb-3 row">
					<label for="inputsaldo" class="col-sm-5 col-form-label" style="color: #000">Jumlah Saldo</label>
					<div class="col-sm-7">
						<div class="input-group">
							<span class="input-group-addon bg-gray-active">Rp.</span>
							<input type="text" class="form-control text-right uang" id="inputsaldo" disabled value="<?= number_format($saldo, 0, ',', '.'); ?>">
							<span class="input-group-addon bg-gray-active">,00</span>
						</div>
					</div>
				</div>
				<div class="mb-3 row">
					<label for="inputpenarikan" class="col-sm-5 col-form-label" style="color: #000">Penarikan Saldo</label>
					<div class="col-sm-7">
						<div class="input-group">
							<span class="input-group-addon bg-gray-active">Rp.</span>
							<input type="text" class="form-control text-right uang" id="inputpenarikan" onkeyup="hitungsaldo()">
							<span class="input-group-addon bg-gray-active">,00</span>
						</div>
					</div>
				</div>
				
			</div>
			<div class="modal-footer bg-gray-active">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
				<button type="button" class="btn btn-primary" onclick="simpanserahterima()">Simpan</button>
			</div>
		</div>
	</div>
</div>

<div class="container">
    <div class="pull-right hidden-xs">
        <b>Version</b> 1.1
    </div>
    <strong>Copyright &copy; <?=date('Y');?> <span style="color: #0000ff"></span></strong>
</div>


<script>
	//document.getElementById("inputpenarikan").html = "Saldo : Rp. <?= number_format($sisasaldo, 0, ',', '.'); ?><span class='caret'>"
	//alert("<?= number_format($sisasaldo, 0, ',', '.'); ?>");
	//$("#saldo").html("Saldo : Rp. <?= number_format($sisasaldo, 0, ',', '.'); ?><span class='caret'>");
	
	function addCommas(nStr)
	{
		nStr += '';
		x = nStr.split(',');
		x1 = x[0];
		x2 = x.length > 1 ? '.' + x[1] : '';
		var rgx = /(\d+)(\d{3})/;
		while (rgx.test(x1)) {
			x1 = x1.replace(rgx, '$1' + '.' + '$2');
		}
		return x1 + x2;
	}
	
	function hitungsaldo(){
		//alert("ok");
		saldo = <?= $saldo ?>;
		penarikan = document.getElementById("inputpenarikan").value;
		penarikan = penarikan.replace(/[\D\s\._\-]+/g, "");
		//alert(penarikan);
		if (penarikan == ""){
			penarikan=0;
		}
		sisasaldo = saldo-penarikan;
		document.getElementById("inputsaldo").value = sisasaldo.toLocaleString("id-ID");		
		//penarikan = penarikan?parseInt(input, 10):0;
		//document.getElementById("inputpenarikan").value = addCommas(penarikan);
	}
	
	function simpanserahterima()
	{
		sisasaldo = document.getElementById("inputsaldo").value;
		sisasaldo = sisasaldo.replace(/[\D\s\._\-]+/g, "");
		penarikan = document.getElementById("inputpenarikan").value;
		penarikan = penarikan.replace(/[\D\s\._\-]+/g, "");
		//alert(penarikan);
		var posting = $.post('<?= base_url() ?>index.php/home/simpanserahterima', {
            penarikan: penarikan,
			sisasaldo: sisasaldo
		});
        posting.done(function (data) {
			if (data=="1"){
				$("#saldo").html("Saldo : Rp. "+sisasaldo.toLocaleString("id-ID")+"<span class='caret'>");
				//alert(last+'ada order baru');
				window.location.reload(1);
			}
			else{alert(data);}
		});
	}
</script>