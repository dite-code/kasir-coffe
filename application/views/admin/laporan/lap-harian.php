<?php
	defined('BASEPATH') OR exit('No direct script access allowed');
	$a = $this->session->userdata('is_login');
	$msg = $this->session->flashdata('msg');
	$tipe = $this->session->flashdata('tipe');
	$lambang = 'fa-check';
	$notify = 'Sukses!';
	echo $javasc;
	$nama_admin = $a['nama_admin'];
	$ttl_pemb = 0;
	foreach ($get_transOrderDetail as $row) {
		$sub_ttl = $row->harga_menu * $row->qty;
		$ttl_pemb += $sub_ttl;
	}
	$no_meja = $row_ord->no_meja;
	$tanggal = $row_ord->tanggal;
	$jam = $row_ord->jam;
	$diskon = $row_ord->diskon;
	$tunai = $row_ord->tunai;
	
	$mpdf = new \Mpdf\Mpdf([
	'mode' => 'utf-8',
	'format' => [210, 297],
	'orientation' => 'P',
	'margin_top' => 7,
	'margin_left' => 15,
	'margin_right' => 15
	]);
	
	
	//$mpdf->WriteHTML('<h1>Hello world!</h1>');
	//$mpdf->Bookmark('Start of the document');
	//$mpdf->WriteHTML('<div>Section 1 text</div>');
	
	// Buffer the following html with PHP so we can store it to a variable later
	ob_start();
	
	// This is where your script would normally output the HTML using echo or print
?>
<table width="100%" >
	<tr><td style="text-align:center" colspan="6"><h1><?= $row_pro->nama; ?></h1></td></tr>
	<tr><td style="text-align:center" colspan="6"><?= $row_pro->alamat; ?></td></tr>
	<tr><td style="text-align:center" colspan="6"><?= Tgl_indo::indo($tgl); ?></td></tr>
</table>
<br>
<table width="100%" border="1" style="border-collapse:collapse;">
	<tr>
		<th>No</th>
		<th>Kasir</th>
		<th>Kode Order</th>
		<th>No Meja</th>
		<th>Jam</th>
		<th>Pembayaran</th>
		<th>Pajak</th>
		<th>Total</th>
	</tr>
	<?php
		$no = 1;
        $ttl_pemb = 0;
		$ttl_ppn = 0;
        foreach ($laphar as $row) {
			$ppn=$row->ttl_pembayaran*$row->ppn/100;
            $ttl_pemb += $row->ttl_pembayaran;
			$ttl_ppn +=$ppn;
	?>
		<tr>
			<td align="center"><?= $no++; ?>.</td>
			<td style="padding-left:5px;"><?= $row->nama_admin; ?></td>
			<td style="padding-left:5px;"><?= $row->kode_order; ?></td>
			<td width="50" align="center"><?= $row->no_meja; ?></td>
			<td align="center"><?= $row->jam; ?></td>
			<td style="padding-right:5px;" align="right"><?= number_format($row->ttl_pembayaran, 0, ',', '.'); ?></td>
			<td style="padding-right:5px;" align="right"><?= number_format($ppn, 0, ',', '.'); ?></td>
			<td style="padding-right:5px;" align="right"><?= number_format($row->ttl_pembayaran+$ppn, 0, ',', '.'); ?></td>
		</tr>
		
		<?php 
		}
	?>
	<tr>
		<td style="padding-left:5px;" colspan="5">Jumlah ---------------------------------------------------------------</td>
		<td style="padding-right:5px;" align="right"><?= number_format($ttl_pemb, 0, ',', '.'); ?></td>
		<td style="padding-right:5px;" align="right"><?= number_format($ttl_ppn, 0, ',', '.'); ?></td>
		<td style="padding-right:5px;" align="right"><?= number_format($ttl_pemb+$ttl_ppn, 0, ',', '.'); ?></td>
	</tr>
</table>
<?php
	// Now collect the output buffer into a variable
	$html = ob_get_contents();
	ob_end_clean();
	
	// send the captured HTML from the output buffer to the mPDF class for processing
	$mpdf->WriteHTML($html);
	
	
	$mpdf->Output();
?>