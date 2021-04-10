<table class="table table-bordered">
	<thead>
		<tr>
			<th scope="col">#</th>
			<th scope="col">Menu</th>
			<th scope="col" width="180">Qty</th>
		</tr>
	</thead>
	<tbody>
		<?php
			$i=1;
			foreach ($order as $row) { ?>
			<tr>
				<th scope="row"><?= $i; ?></th>
				<td><?= $row->nama_menu ?></td>
				<td>
					<div class="input-group text-center">
						<input class="form-control" type="hidden" id="qty_<?= $row->kode_menu; ?>" value="<?= $row->qty; ?>">
						<button onclick="editQty($('#qty_<?= $row->kode_menu; ?>').val(), 'min', '<?= $row->kode_order; ?>', '<?= $row->kode_menu; ?>')" 
						class="btn btn-warning btn-xs btn-flat me-1" type="button">
						<i class="fa fa-minus"></i></button>
						
						<?= $row->qty . " " . $row->satuan; ?>
						<button onclick="editQty($('#qty_<?= $row->kode_menu; ?>').val(), 'plus', '<?= $row->kode_order; ?>', '<?= $row->kode_menu; ?>')" 
						type="button" class="btn btn-success btn-xs btn-flat ms-1">
						<i class="fa fa-plus"></i></button>
						
					</div>	
				</td>
			</tr>
			<?php
				$i++;
			}
		?>
	</tbody>
</table>